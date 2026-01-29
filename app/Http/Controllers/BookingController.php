<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Booking;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class BookingController extends Controller
{
    /**
     * Show seat selection page
     */
    public function selectSeats(Request $request)
    {
        $request->validate([
            'agency_id' => 'required|exists:agencies,id',
            'departure_city' => 'required|exists:cities,id',
            'destination_city' => 'required|exists:cities,id',
            'travel_date' => 'required|date|after_or_equal:today',
            'departure_time' => 'required|in:07:00,19:00',
            'route_id' => 'required|exists:routes,id', // ADDED: route_id validation
        ]);

        // Get the route and price
        $route = Route::where('id', $request->route_id) // FIXED: Use route_id from request
            ->where('agency_id', $request->agency_id)
            ->with(['agency', 'departureCity', 'destinationCity'])
            ->firstOrFail();

        // Get booked seats for this specific trip
        $bookedSeats = Booking::where('route_id', $route->id)
            ->where('travel_date', $request->travel_date)
            ->where('departure_time', $request->departure_time)
            ->whereIn('status', ['confirmed', 'checked_in'])
            ->get()
            ->flatMap(function ($booking) {
                // Safely handle decoding
                $decoded = is_array($booking->seats) ? $booking->seats : json_decode($booking->seats, true);
                return $decoded ?: [];
            })
            ->unique()
            ->values()
            ->toArray();

        // Prepare booking data for the view
        $bookingData = [
            'agency_id' => $route->agency_id,
            'agency_name' => $route->agency->name,
            'route_id' => $route->id,
            'departure_city' => $route->departureCity->name,
            'destination_city' => $route->destinationCity->name,
            'travel_date' => $request->travel_date,
            'departure_time' => $request->departure_time,
            'price' => $route->base_price, // FIXED: Changed from $route->price to $route->base_price
        ];

        // \Log::info('Booking data for seat selection:', $bookingData); // Debug log

        return view('seats.select', compact('bookedSeats', 'bookingData')); // FIXED: Correct view path
    }

    /**
     * Show payment confirmation page
     */
    public function confirm(Request $request)
{
    if ($request->isMethod('get')) {
        return redirect()->route('home')->with('error', 'Session expired.');
    }

    $request->validate([
        'seats' => 'required',
        'total_amount' => 'required|numeric',
        'route_id' => 'required|exists:routes,id',
    ]);

    $bookingData = $request->all();
    $route = Route::with(['departureCity', 'destinationCity', 'agency'])->findOrFail($request->route_id);

    $bookingData['agency_name'] = $route->agency->name;
    // Use the actual names from the database
    $bookingData['departure_city'] = $route->departureCity->name;
    $bookingData['destination_city'] = $route->destinationCity->name;
    $bookingData['subtotal'] = (float)$request->total_amount - 500;

    return view('booking.confirm', compact('bookingData'));
}

    /**
     * Process payment and create booking
     */
    /**
 * Process payment and create booking
 */
/**
 * Process payment and create booking
 */
public function processPayment(Request $request)
{
    try {
        $request->validate([
            'booking_data' => 'required',
            'passenger_name' => 'required|string',
            'passenger_phone' => 'required|string',
            'passenger_email' => 'required|email',
            'payment_method' => 'required',
            'terms' => 'required|accepted',
        ]);

        $bookingData = json_decode($request->booking_data, true);
        $route = Route::findOrFail($bookingData['route_id']);

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'agency_id' => $bookingData['agency_id'],
            'route_id' => $bookingData['route_id'],
            'booking_number' => 'BK' . strtoupper(Str::random(8)),
            'passenger_name' => $request->passenger_name,
            'passenger_phone' => $request->passenger_phone,
            'passenger_email' => $request->passenger_email,
            'origin' => $bookingData['departure_city'],
            'destination' => $bookingData['destination_city'],
            'travel_date' => $bookingData['travel_date'],
            'departure_time' => $bookingData['departure_time'],
            'seats' => is_array($bookingData['seats']) ? json_encode($bookingData['seats']) : $bookingData['seats'],
            'total_amount' => $bookingData['total_amount'],
            'payment_method' => $request->payment_method,
            'payment_status' => 'paid',
            'status' => 'confirmed',
        ]);

        // Redirect to ticket with success message
        return redirect()->route('bookings.ticket', $booking->id)
            ->with('success', 'Seat booked successfully! Your ticket is ready.');

    } catch (\Exception $e) {
        Log::error('Payment failed: ' . $e->getMessage());
        // Explicitly redirect to confirm so you don't land on Home
        return redirect()->route('seats.select', $request->all())
            ->with('error', 'Booking failed: ' . $e->getMessage());
    }
}
    /**
     * Mock payment gateway processing
     */
    private function processPaymentGateway(Request $request, Booking $booking)
    {
        return true; // Simulate success
    }

    /**
     * Show user's bookings
     */
    public function index()
    {
        $stats = [
            'total_bookings' => Booking::where('user_id', auth()->id())->count(),
            'upcoming_trips' => Booking::where('user_id', auth()->id())
                ->where('travel_date', '>=', now()->toDateString())
                ->whereIn('status', ['confirmed', 'checked_in'])
                ->count(),
            'completed_trips' => Booking::where('user_id', auth()->id())
                ->where('travel_date', '<', now()->toDateString())
                ->where('status', 'completed')
                ->count(),
            'total_spent' => Booking::where('user_id', auth()->id())
                ->where('payment_status', 'paid')
                ->sum('total_amount'),
        ];

        $upcomingBookings = Booking::where('user_id', auth()->id())
            ->where('travel_date', '>=', now()->toDateString())
            ->whereIn('status', ['confirmed', 'checked_in'])
            ->with('agency')
            ->orderBy('travel_date')
            ->get();

        $pastBookings = Booking::where('user_id', auth()->id())
            ->where('travel_date', '<', now()->toDateString())
            ->with('agency')
            ->orderBy('travel_date', 'desc')
            ->get();

        $cancelledBookings = Booking::where('user_id', auth()->id())
            ->where('status', 'cancelled')
            ->with('agency')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('dashboard', compact('stats', 'upcomingBookings', 'pastBookings', 'cancelledBookings'));
    }

    /**
     * Show digital ticket
     */
    public function showTicket(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('bookings.ticket', compact('booking'));
    }

    /**
     * Download ticket as PDF
     */
    public function downloadPDF(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return back()->with('info', 'PDF download will be implemented soon');
    }

    /**
     * Cancel booking
     */
    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $travelDateTime = \Carbon\Carbon::parse($booking->travel_date . ' ' . $booking->departure_time);
        $hoursUntilTravel = now()->diffInHours($travelDateTime, false);

        if ($hoursUntilTravel < 0) {
            return response()->json(['success' => false, 'message' => 'Cannot cancel booking after departure time']);
        }

        $refundPercentage = ($hoursUntilTravel >= 24) ? 90 : (($hoursUntilTravel >= 12) ? 50 : 0);
        $refundAmount = ($booking->total_amount * $refundPercentage) / 100;

        $booking->update([
            'status' => 'cancelled',
            'refund_amount' => $refundAmount,
            'refund_status' => 'pending',
            'cancelled_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking cancelled successfully.',
            'refund_amount' => $refundAmount
        ]);
    }

    /**
     * Get seat availability via AJAX
     */
    public function getSeatAvailability(Request $request)
    {
        $bookedSeats = Booking::where('route_id', $request->route_id)
            ->where('travel_date', $request->travel_date)
            ->where('departure_time', $request->departure_time)
            ->whereIn('status', ['confirmed', 'checked_in'])
            ->get()
            ->flatMap(function ($booking) {
                $decoded = is_array($booking->seats) ? $booking->seats : json_decode($booking->seats, true);
                return $decoded ?: [];
            })
            ->unique()
            ->values()
            ->toArray();

        return response()->json(['success' => true, 'booked_seats' => $bookedSeats]);
    }
}
