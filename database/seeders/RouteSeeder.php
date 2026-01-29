<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Route;
use App\Models\Agency;
use App\Models\City;

class RouteSeeder extends Seeder
{
    public function run(): void
    {
        $yaounde = City::where('name', 'Yaoundé')->first();
        $douala = City::where('name', 'Douala')->first();

        $agencies = Agency::all();

        foreach ($agencies as $agency) {
            // Yaoundé to Douala
            Route::updateOrCreate(
                ['agency_id' => $agency->id, 'departure_city_id' => $yaounde->id, 'destination_city_id' => $douala->id],
                [
                    'origin' => 'Yaoundé',
                    'destination' => 'Douala',
                    'estimated_duration_minutes' => 240,
                    'base_price' => 7000,
                    'distance_km' => 250,
                    'is_active' => true,
                ]
            );
            // Douala to Yaoundé
            Route::updateOrCreate(
                ['agency_id' => $agency->id, 'departure_city_id' => $douala->id, 'destination_city_id' => $yaounde->id],
                [
                    'origin' => 'Douala',
                    'destination' => 'Yaoundé',
                    'estimated_duration_minutes' => 240,
                    'base_price' => 7000,
                    'distance_km' => 250,
                    'is_active' => true,
                ]
            );
        }
    }
}
