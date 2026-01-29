<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Trip;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $agencies = Agency::where('is_active', true)->get();
        $featuredTrips = Trip::with(['bus.agency', 'route'])
            ->where('travel_date', '>=', now()->format('Y-m-d'))
            ->where('is_available_online', true)
            ->orderBy('travel_date')
            ->take(6)
            ->get();

        return view('home', compact('agencies', 'featuredTrips'));
    }
}
