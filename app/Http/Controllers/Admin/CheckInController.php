<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    /**
     * Display check-in management page
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        // 1. Define the missing variables from the request (with defaults)
        $travelDate = $request->get('travel_date', today()->toDateString());
        $departureTime = $request->get('departure_time');

        // 2. Build the main query
        $query = Booking::whereDate('travel_date', $travelDate);

        // Filter by Agency if the user is assigned to one (e.g., Musango)
        if ($user->agency_id) {
            $query->where('agency_id', $user->agency_id);
        }

        if ($departureTime) {
            $query->where('departure_time', $departureTime);
        }

        $bookings = $query->latest()->paginate(10);

        // 3. Stats logic - must also respect the Agency filter
        $statsQuery = Booking::whereDate('travel_date', $travelDate);
        if ($user->agency_id) {
            $statsQuery->where('agency_id', $user->agency_id);
        }

        $stats = [
            'total_today' => (clone $statsQuery)->count(),
            'checked_in'  => (clone $statsQuery)->where('status', 'checked_in')->count(),
            'pending'     => (clone $statsQuery)->where('status', 'confirmed')->count(),
            'no_show'     => (clone $statsQuery)->where('status', 'no_show')->count(),
        ];

        // Now all variables in compact() are defined
        return view('admin.checkin', compact('bookings', 'stats', 'travelDate', 'departureTime'));
    }

    /**
     * Search for a booking
     */
    public function search(Request $request)
    {
        $booking = Booking::where('booking_number', $request->number)
            ->with(['agency', 'route.departureCity', 'route.destinationCity', 'user'])
            ->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found'
            ], 404);
        }

        // Add city names
        $booking->departure_city = $booking->route->departureCity->name ?? 'N/A';
        $booking->destination_city = $booking->route->destinationCity->name ?? 'N/A';
        $booking->seats = json_decode($booking->seats, true);

        return response()->json([
            'success' => true,
            'booking' => $booking
        ]);
    }

    /**
     * Check in a passenger
     */
    public function checkIn(Booking $booking)
    {
        // Validate booking can be checked in
        if ($booking->status === 'checked_in') {
            return response()->json([
                'success' => false,
                'message' => 'Passenger already checked in'
            ], 400);
        }

        if ($booking->status !== 'confirmed') {
            return response()->json([
                'success' => false,
                'message' => 'Only confirmed bookings can be checked in'
            ], 400);
        }

        // Check if it's the right day
        if ($booking->travel_date !== today()->toDateString()) {
            return response()->json([
                'success' => false,
                'message' => 'This booking is not for today'
            ], 400);
        }

        // Update booking status
        $booking->update([
            'status' => 'checked_in',
            'checked_in_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-in successful!',
            'booking' => [
                'id' => $booking->id,
                'booking_number' => $booking->booking_number,
                'passenger_name' => $booking->passenger_name,
                'seats' => json_decode($booking->seats, true),
                'status' => 'checked_in'
            ]
        ], 200);
    }

    /**
     * Mark booking as no show
     */
    public function markNoShow(Booking $booking)
    {
        // Validate booking
        if ($booking->status === 'no_show') {
            return response()->json([
                'success' => false,
                'message' => 'Already marked as no show'
            ], 400);
        }

        if ($booking->status !== 'confirmed') {
            return response()->json([
                'success' => false,
                'message' => 'Only confirmed bookings can be marked as no show'
            ], 400);
        }

        // Update booking
        $booking->update([
            'status' => 'no_show',
            'no_show_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Marked as No Show',
            'booking' => [
                'id' => $booking->id,
                'booking_number' => $booking->booking_number,
                'status' => 'no_show'
            ]
        ], 200);
    }

    /**
     * Show booking details
     */
    public function show(Booking $booking)
    {
        $booking->load(['agency', 'route.departureCity', 'route.destinationCity', 'user']);
        $booking->departure_city = $booking->route->departureCity->name ?? 'N/A';
        $booking->destination_city = $booking->route->destinationCity->name ?? 'N/A';
        $booking->seats = json_decode($booking->seats, true);

        return view('admin.booking-details', compact('booking'));
    }
}
