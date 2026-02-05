<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Agency;
use App\Models\Booking;
use App\Models\Dispute;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_passengers' => User::where('role', 'passenger')->count(),
            'agency_admins' => User::where('role', 'admin')->count(),
            'checkin_staff' => User::where('role', 'staff')->count(),
            'total_agencies' => Agency::count(),
            'active_agencies' => Agency::where('status', 'active')->count(),
            'suspended_agencies' => Agency::where('status', 'suspended')->count(),
            'total_bookings' => Booking::count(),
            'total_revenue' => Booking::where('payment_status', 'paid')->sum('total_amount'),
            'pending_disputes' => Dispute::where('status', 'pending')->count(),
            'total_disputes' => Dispute::count(),
        ];

        $recentDisputes = Dispute::with(['user', 'agency'])
            ->latest()
            ->take(5)
            ->get();

        $recentAgencies = Agency::latest()->take(5)->get();

        return view('superadmin.dashboard', compact('stats', 'recentDisputes', 'recentAgencies'));
    }
    public function reports()
{
    // For now — minimal placeholder (expand later with real stats)
    $stats = [
        'total_bookings' => \App\Models\Booking::count(),
        'total_revenue'  => \App\Models\Booking::where('payment_status', 'paid')->sum('total_amount'),
        'total_disputes' => \App\Models\Dispute::count(),
    ];

    return view('superadmin.reports.index', compact('stats'));
}
}
