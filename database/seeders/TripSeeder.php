<?php

namespace Database\Seeders;

use App\Models\Trip;
use App\Models\Bus;
use App\Models\Route;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TripSeeder extends Seeder
{
    public function run(): void
    {
        $buses = Bus::all();
        $routes = Route::all();
        $times = ['07:00:00', '19:00:00'];
        $startDate = Carbon::today();

        foreach ($routes as $route) {
            // Find a bus belonging to this route's agency
            $bus = Bus::where('agency_id', $route->agency_id)->first();

            if ($bus) {
                for ($i = 0; $i < 14; $i++) {
                    $date = $startDate->copy()->addDays($i);
                    foreach ($times as $time) {
                        Trip::updateOrCreate(
                            [
                                'bus_id' => $bus->id,
                                'route_id' => $route->id,
                                'travel_date' => $date->format('Y-m-d'),
                                'departure_time' => $time
                            ],
                            [
                                'price' => $route->base_price,
                                'status' => 'scheduled',
                                'is_available_online' => true,
                            ]
                        );
                    }
                }
            }
        }
    }
}
