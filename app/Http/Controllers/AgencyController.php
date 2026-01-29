<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    public function index(Request $request)
    {
        $agencies = Agency::query()
            // Real route statistics (thanks to the new agency_id column)
            ->withCount('routes as routes_count')
            ->withMin('routes', 'base_price') // creates $agency->routes_min_price

            // Search by agency name
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            })

            // Filter by departure city (string match on origin column)
            ->when($request->filled('departure_city'), function ($q) use ($request) {
                $q->whereHas('routes', function ($r) use ($request) {
                    $r->where('origin', 'like', "%{$request->departure_city}%");
                });
            })

            // Filter by destination city (string match on destination column)
            ->when($request->filled('destination_city'), function ($q) use ($request) {
                $q->whereHas('routes', function ($r) use ($request) {
                    $r->where('destination', 'like', "%{$request->destination_city}%");
                });
            })

            // Order & pagination (Laravel does everything for you)
            ->latest()
            ->paginate(9)
            ->withQueryString(); // keeps ?search=…&departure_city=… in URL

        // Make min_price more readable (instead of routes_min_price)
        foreach ($agencies as $agency) {
            $agency->min_price = $agency->routes_min_price ?? 0;
        }

        return view('agencies.index', compact('agencies'));
    }

    public function show(Agency $agency)
    {
        // Now we can really eager-load the agency's routes
        $agency->load([
            'routes' => fn($q) => $q->where('is_active', true),
            'routes.departurecity',
            'routes.destinationcity'
        ]);

        return view('agencies.show', compact('agency'));
    }
}
