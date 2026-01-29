<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\City;
use App\Models\Route as BusRoute;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; // ADDED: Import Log facade

class RouteController extends Controller
{
    /**
     * Show route selection page
     */
    public function select(Agency $agency)
    {
        // Get all cities for the dropdowns
        $cities = City::orderBy('name')->get();

        // Debug: Log cities count (FIXED: Using proper Log facade)
        Log::info('Cities loaded for agency ' . $agency->id . ': ' . $cities->count());

        // If no cities found, log warning
        if ($cities->isEmpty()) {
            Log::warning('No cities found in database!');
        }

        // Get popular routes for this agency
        $popularRoutes = \App\Models\Route::where('agency_id', $agency->id)
            ->where('is_active', true)
            ->with(['departureCity', 'destinationCity'])
            ->limit(6)
            ->get()
            ->map(function ($route) {
                return [
                    'id' => $route->id,
                    'departure_city_id' => $route->departureCity?->id ?? $route->departure_city_id,
                    'destination_city_id' => $route->destinationCity?->id ?? $route->destination_city_id,
                    'departure_city' => $route->departureCity?->name ?? $route->origin ?? 'Unknown',
                    'destination_city' => $route->destinationCity?->name ?? $route->destination ?? 'Unknown',
                    'duration' => $route->estimated_duration_minutes . ' mins',
                    'price' => $route->base_price,
                ];
            });

        // Calculate available booking dates (next 7 days, unlocked on Saturday 7:05pm)
        $availableDates = $this->getAvailableBookingDates();

        return view('routes.select', compact('agency', 'cities', 'popularRoutes', 'availableDates'));
    }

    /**
     * Get available booking dates based on schedule unlock logic
     * New week unlocks every Saturday at 7:05 PM
     */
    private function getAvailableBookingDates()
    {
        $dates = [];
        $now = now();

        // Check if we're past Saturday 7:05 PM
        $currentSaturday = $now->copy()->startOfWeek()->addDays(5)->setTime(19, 5, 0); // This Saturday at 7:05 PM

        // If today is Sunday OR (Saturday after 7:05 PM)
        if ($now->isSunday() || ($now->isSaturday() && $now->greaterThanOrEqualTo($currentSaturday))) {
            // Show next week (starting from next Sunday)
            $startDate = $now->copy()->next('Sunday');
            $endDate = $startDate->copy()->addDays(6); // Until next Saturday
        } else {
            // Show current week (from today until this Saturday)
            $startDate = $now->copy();
            $endDate = $now->copy()->endOfWeek()->subDay(); // This Saturday
        }

        // Generate dates
        $currentDate = $startDate->copy();
        while ($currentDate->lessThanOrEqualTo($endDate)) {
            $dates[] = [
                'value' => $currentDate->format('Y-m-d'),
                'label' => $currentDate->format('D, M j, Y'),
                'is_weekend' => in_array($currentDate->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY]),
                'is_past' => false,
                'is_today' => $currentDate->isToday(),
                'day_name' => $currentDate->format('l'),
            ];
            $currentDate->addDay();
        }

        return $dates;
    }
    /**
     * Get route information via AJAX
     */
    public function getRouteInfo(Request $request)
    {
        try {
            Log::info('Route info request received:', $request->all());

            $departure = $request->input('departure');
            $destination = $request->input('destination');
            $agency = $request->input('agency');

            if (!$departure || !$destination || !$agency) {
                return response()->json(['success' => false, 'message' => 'Missing required parameters'], 400);
            }

           $departureCity = City::find($departure);
            $destinationCity = City::find($destination);

            if (!$departureCity || !$destinationCity) {
                return response()->json(['success' => false, 'message' => 'Invalid cities selected'], 404);
            }

            Log::info('Searching for route between:', [
                'departure' => $departureCity->name,
                'destination' => $destinationCity->name,
                'agency' => $agency
            ]);

            // FIXED: Proper query with agency filter maintained
            $route = BusRoute::where('agency_id', $agency)
                ->where('is_active', true)
                ->where(function ($query) use ($departureCity, $destinationCity) {
                    $query->where(function ($q) use ($departureCity, $destinationCity) {
                        $q->where('origin', $departureCity->name)
                            ->where('destination', $destinationCity->name);
                    })
                        ->orWhere(function ($q) use ($departureCity, $destinationCity) {
                            $q->where('origin', $destinationCity->name)
                                ->where('destination', $departureCity->name);
                        });
                })
                ->first();

            if (!$route) {
                Log::warning('No route found for the selected cities and agency');
                return response()->json([
                    'success' => false,
                    'message' => 'No active route found between ' . $departureCity->name . ' and ' . $destinationCity->name . ' for this agency.'
                ], 404);
            }

            Log::info('Route found', ['id' => $route->id, 'origin' => $route->origin, 'destination' => $route->destination]);

            return response()->json([
                'success' => true,
                'route_id' => $route->id,
                'duration' => $route->estimated_duration_minutes . ' minutes',
                'price' => number_format($route->base_price),
                'raw_price' => $route->base_price
            ]);
        } catch (\Exception $e) {
            Log::error('Route info error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
}
