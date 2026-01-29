<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

    // 1. If user is Staff (Conductor), send to Check-in
    if ($user->role === 'staff') {
        return redirect()->route('admin.checkin');
    }

    // 2. If user is Admin, send to Admin Dashboard
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }



        // Regular user dashboard code...
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
            ->with(['agency', 'route.departureCity', 'route.destinationCity'])
            ->orderBy('travel_date')
            ->get()
            ->map(function ($booking) {
                $booking->departure_city = $booking->route->departureCity->name ?? 'N/A';
                $booking->destination_city = $booking->route->destinationCity->name ?? 'N/A';
                return $booking;
            });

        $pastBookings = Booking::where('user_id', auth()->id())
            ->where('travel_date', '<', now()->toDateString())
            ->with(['agency', 'route.departureCity', 'route.destinationCity'])
            ->orderBy('travel_date', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($booking) {
                $booking->departure_city = $booking->route->departureCity->name ?? 'N/A';
                $booking->destination_city = $booking->route->destinationCity->name ?? 'N/A';
                return $booking;
            });

        $cancelledBookings = Booking::where('user_id', auth()->id())
            ->where('status', 'cancelled')
            ->with(['agency', 'route.departureCity', 'route.destinationCity'])
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($booking) {
                $booking->departure_city = $booking->route->departureCity->name ?? 'N/A';
                $booking->destination_city = $booking->route->destinationCity->name ?? 'N/A';
                return $booking;
            });

        return view('dashboard', compact(
            'stats',
            'upcomingBookings',
            'pastBookings',
            'cancelledBookings'
        ));
    }
}
