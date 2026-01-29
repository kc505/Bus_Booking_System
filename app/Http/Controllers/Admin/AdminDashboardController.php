<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Agency;
use App\Models\Route;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_bookings' => Booking::count(),
            'today_bookings' => Booking::whereDate('travel_date', today())->count(),
            'total_revenue' => Booking::where('payment_status', 'paid')->sum('total_amount') ?? 0,
            'total_agencies' => Agency::count(),
            'total_routes' => Route::where('is_active', true)->count(),
            'total_users' => User::where('role', '!=', 'admin')->count(),
        ];

        $recentBookings = Booking::with(['user', 'agency', 'route'])
            ->latest()
            ->take(10)
            ->get();

        $todayBookings = Booking::whereDate('travel_date', today())
            ->with(['agency', 'route'])
            ->orderBy('departure_time')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'todayBookings'));
    }
}
