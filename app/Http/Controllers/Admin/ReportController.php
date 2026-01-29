<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Agency;
use App\Models\Route;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'total_revenue' => Booking::where('payment_status', 'paid')->sum('total_amount'),
            'total_bookings' => Booking::count(),
            'monthly_revenue' => Booking::where('payment_status', 'paid')
                ->whereMonth('created_at', now()->month)
                ->sum('total_amount'),
            'monthly_bookings' => Booking::whereMonth('created_at', now()->month)->count(),
        ];

        return view('admin.reports.index', compact('stats'));
    }

    public function revenue()
    {
        // Revenue report logic
        return view('admin.reports.revenue');
    }

    public function bookings()
    {
        // Bookings report logic
        return view('admin.reports.bookings');
    }

    public function agencies()
    {
        // Agencies report logic
        return view('admin.reports.agencies');
    }
}
