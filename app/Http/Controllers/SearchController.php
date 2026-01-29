<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Route;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SearchController extends Controller
{
    public function index()
    {
        $cities = Route::select('origin', 'destination')
            ->distinct()
            ->get()
            ->flatMap(function ($route) {
                return [$route->origin, $route->destination];
            })
            ->unique()
            ->sort()
            ->values();

        return view('search', compact('cities'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'origin' => 'required|string',
            'destination' => 'required|string',
            'travel_date' => 'required|date|after_or_equal:today',
        ]);

        $trips = Trip::with(['bus.agency', 'route'])
            ->whereHas('route', function($query) use ($request) {
                $query->where('origin', 'like', '%' . $request->origin . '%')
                      ->where('destination', 'like', '%' . $request->destination . '%');
            })
            ->where('travel_date', $request->travel_date)
            ->where('is_available_online', true)
            ->where('status', 'scheduled')
            ->orderBy('departure_time')
            ->get();

        return view('search-results', compact('trips', 'request'));
    }
}
