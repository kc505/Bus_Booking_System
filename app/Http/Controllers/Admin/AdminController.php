<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\Bus;
use App\Models\Route;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Display the trip creation form
    public function createTrip()
    {
        $buses = Bus::with('agency')->get();
        $routes = Route::with(['departureCity', 'destinationCity'])->get();

        return view('admin.trips.create', compact('buses', 'routes'));
    }

    // Store a new trip
    public function storeTrip(Request $request)
    {
        $validated = $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'route_id' => 'required|exists:routes,id',
            'travel_date' => 'required|date|after_or_equal:today', // FIXED: Changed from departure_date
            'departure_time' => 'required|in:07:00,19:00',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:scheduled,delayed,cancelled,completed',
        ]);

        // Get the route to calculate estimated arrival
        $route = Route::findOrFail($validated['route_id']);

        // Create departure_datetime by combining date and time
        $departureDateTime = Carbon::parse($validated['travel_date'] . ' ' . $validated['departure_time']);

        // Calculate estimated arrival (add duration in hours)
        $durationHours = (float) str_replace(' hours', '', $route->duration);
        $estimatedArrival = $departureDateTime->copy()->addHours($durationHours);

        // Create the trip
        $trip = Trip::create([
            'bus_id' => $validated['bus_id'],
            'route_id' => $validated['route_id'],
            'travel_date' => $validated['travel_date'],
            'departure_time' => $validated['departure_time'],
            'departure_datetime' => $departureDateTime,
            'estimated_arrival_datetime' => $estimatedArrival,
            'price' => $validated['price'],
            'status' => $validated['status'],
            'is_available_online' => true,
        ]);

        return redirect()
            ->route('admin.trips.index')
            ->with('success', 'Trip scheduled successfully!');
    }

    // Display all trips
    public function manageTrips()
    {
        $trips = Trip::with(['bus.agency', 'route.departureCity', 'route.destinationCity'])
            ->orderBy('travel_date', 'desc')
            ->orderBy('departure_time', 'desc')
            ->paginate(15);

        return view('admin.trips.index', compact('trips'));
    }

    // Show edit form
    public function editTrip($id)
    {
        $trip = Trip::findOrFail($id);
        $buses = Bus::with('agency')->get();
        $routes = Route::with(['departureCity', 'destinationCity'])->get();

        return view('admin.trips.edit', compact('trip', 'buses', 'routes'));
    }

    // Update trip
    public function updateTrip(Request $request, $id)
    {
        $trip = Trip::findOrFail($id);

        $validated = $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'route_id' => 'required|exists:routes,id',
            'travel_date' => 'required|date',
            'departure_time' => 'required|in:07:00,19:00',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:scheduled,delayed,cancelled,completed',
        ]);

        // Recalculate departure_datetime and estimated_arrival
        $route = Route::findOrFail($validated['route_id']);
        $departureDateTime = Carbon::parse($validated['travel_date'] . ' ' . $validated['departure_time']);
        $durationHours = (float) str_replace(' hours', '', $route->duration);
        $estimatedArrival = $departureDateTime->copy()->addHours($durationHours);

        $trip->update([
            'bus_id' => $validated['bus_id'],
            'route_id' => $validated['route_id'],
            'travel_date' => $validated['travel_date'],
            'departure_time' => $validated['departure_time'],
            'departure_datetime' => $departureDateTime,
            'estimated_arrival_datetime' => $estimatedArrival,
            'price' => $validated['price'],
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.trips.index')
            ->with('success', 'Trip updated successfully!');
    }

    // Delete trip
    public function deleteTrip($id)
    {
        $trip = Trip::findOrFail($id);

        // Check if there are any bookings for this trip
        if ($trip->bookings()->count() > 0) {
            return back()->with('error', 'Cannot delete trip with existing bookings!');
        }

        $trip->delete();

        return redirect()
            ->route('admin.trips.index')
            ->with('success', 'Trip deleted successfully!');
    }

    // View all bookings
    public function allBookings()
    {
        $bookings = Booking::with(['user', 'trip.route', 'trip.bus.agency'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }

    // View specific booking details
    public function viewBooking($id)
    {
        $booking = Booking::with(['user', 'trip.route', 'trip.bus', 'tickets'])
            ->findOrFail($id);

        return view('admin.bookings.show', compact('booking'));
    }


    public function manageUsers()
{
    $users = User::withCount('bookings')
        ->orderBy('created_at', 'desc')
        ->paginate(20);

    $stats = [
        'total_users' => User::count(),
        'active_users' => User::count(), // Add email_verified_at check if needed
        'admin_users' => User::where('is_admin', true)->count(),
        'new_users' => User::whereMonth('created_at', now()->month)->count(),
    ];

    return view('admin.users.index', compact('users', 'stats'));
}

public function settings()
{
    return view('admin.settings.index');
}

    // Process refund
    public function processRefund(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status !== 'confirmed') {
            return back()->with('error', 'Only confirmed bookings can be refunded!');
        }

        DB::beginTransaction();
        try {
            // Update booking status
            $booking->update([
                'status' => 'refunded',
                'refund_amount' => $booking->total_amount,
                'refund_date' => now(),
            ]);

            // Release the seats
            $booking->tickets()->update([
                'status' => 'cancelled'
            ]);

            DB::commit();

            return back()->with('success', 'Refund processed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to process refund: ' . $e->getMessage());
        }
    }
}
