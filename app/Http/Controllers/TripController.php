<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Trip;
use App\Models\Seat;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\CampayService;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketBooked;

class TripController extends Controller
{
    public function index() {
        return view('welcome');
    }

    public function search(Request $request) {
        $query = Trip::query();

        if ($request->filled('date')) {
            $query->whereDate('travel_date', $request->date);
        }
        if ($request->filled('origin') && $request->filled('destination')) {
            $query->whereHas('route', function($q) use ($request) {
                $q->where('origin', $request->origin)->where('destination', $request->destination);
            });
        }
        // Logic to check capacity
        $query->whereRaw('
            (SELECT capacity FROM buses WHERE buses.id = trips.bus_id) >
            (
                SELECT COUNT(*) FROM tickets
                JOIN bookings ON tickets.booking_id = bookings.id
                WHERE bookings.trip_id = trips.id
                AND bookings.status IN ("confirmed", "pending")
            )
        ');

        $trips = $query->with(['bus.agency', 'route'])->get();
        return view('welcome', compact('trips'));
    }

    public function book($id) {
        $trip = Trip::with(['bus.agency', 'route'])->findOrFail($id);
        $takenSeats = Ticket::whereHas('booking', function($query) use ($id) {
            $query->where('trip_id', $id)->whereIn('status', ['confirmed', 'pending']);
        })->with('seat')->get()->pluck('seat.seat_number')->toArray();

        return view('booking.page', compact('trip', 'takenSeats'));
    }

    public function store(Request $request) {
        $request->validate(['trip_id' => 'required', 'seat_number' => 'required']);

        $trip = Trip::findOrFail($request->trip_id);
        $seat = Seat::where('bus_id', $trip->bus_id)->where('seat_number', $request->seat_number)->first();

        $isTaken = Ticket::whereHas('booking', function($q) use ($trip) {
            $q->where('trip_id', $trip->id)->whereIn('status', ['confirmed', 'pending']);
        })->where('seat_id', $seat->id)->exists();

        if ($isTaken) return back()->with('error', 'Seat taken.');

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'trip_id' => $trip->id,
            'passenger_count' => 1,
            'total_amount' => $trip->price,
            'status' => 'confirmed',
            'payment_status' => 'pending',
        ]);

        Ticket::create([
            'booking_id' => $booking->id,
            'seat_id' => $seat->id,
            'ticket_number' => strtoupper(Str::random(10)),
            'status' => 'active',
            'passenger_name' => auth()->user()->name,
            'passenger_phone' => '600000000',
        ]);

        return redirect()->route('bookings.payment', $booking->id);
    }

    public function payment($id) {
        $booking = Booking::with(['trip.bus.agency', 'trip.route', 'tickets.seat'])->findOrFail($id);
        return view('booking.payment', compact('booking'));
    }

    // --- PAYMENT LOGIC USING SERVICE ---
    public function processPayment(Request $request, $id) {
        $request->validate(['phone_number' => 'required|digits:9']);
        $booking = Booking::findOrFail($id);

        $campay = new CampayService();

        // 1. Send Request
        // IMPORTANT: Use "10" or "50" FCFA for demo testing
        $result = $campay->collectRequest(
            "10",
            $request->phone_number,
            'Booking Ref: ' . $booking->booking_reference
        );

        if ($result['success']) {
            return view('booking.waiting', [
                'booking' => $booking,
                'reference' => $result['reference']
            ]);
        }

        return back()->with('error', 'Payment initialization failed.');
    }

    // --- POLLING STATUS ---
    public function pollPaymentStatus($bookingId, $reference) {
        $booking = Booking::findOrFail($bookingId);

        if ($booking->payment_status === 'paid') {
            return response()->json(['status' => 'SUCCESSFUL']);
        }

        $campay = new CampayService();
        $statusData = $campay->checkTransactionStatus($reference);

        if ($statusData && isset($statusData['status']) && $statusData['status'] === 'SUCCESSFUL') {
            $booking->update(['payment_status' => 'paid']);
            Mail::to(auth()->user()->email)->send(new TicketBooked($booking->tickets->first()));
            return response()->json(['status' => 'SUCCESSFUL']);
        }

        if ($statusData && isset($statusData['status']) && $statusData['status'] === 'FAILED') {
            return response()->json(['status' => 'FAILED']);
        }

        return response()->json(['status' => 'PENDING']);
    }

    // --- MANUAL CHECK BUTTON ---
    public function checkPaymentStatus(Request $request, $reference) {
        $booking = Booking::findOrFail($request->booking_id);
        $campay = new CampayService();
        $statusData = $campay->checkTransactionStatus($reference);

        if ($statusData && isset($statusData['status']) && $statusData['status'] === 'SUCCESSFUL') {
            $booking->update(['payment_status' => 'paid']);
            Mail::to(auth()->user()->email)->send(new TicketBooked($booking->tickets->first()));
            return redirect()->route('bookings.success', $booking->id);
        }


        return back()->with('error', 'Payment not confirmed yet.');
    }

    public function success($id) {
        $booking = Booking::with(['trip.route', 'tickets.seat'])->findOrFail($id);
        if ($booking->user_id !== auth()->id()) abort(403);
        return view('booking.success', compact('booking'));
    }


    public function failure($id) {
        $booking = Booking::with(['trip.route', 'tickets.seat'])->findOrFail($id);
        if ($booking->user_id !== auth()->id()) abort(403);
        return view('booking.failure', compact('booking'));
    }
}
