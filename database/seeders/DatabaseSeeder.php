<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Core Data (Cities, then Agencies, then Routes/Buses)
        $this->call([
            CitiesSeeder::class,
            AgencySeeder::class, // Musango is ID 1
            RouteSeeder::class,
            BusSeeder::class,
        ]);

        // 2. MUSANGO ADMIN (Only has access to Musango data)
        User::updateOrCreate(
            ['email' => 'admin@musango.cm'],
            [
                'name' => 'Musango Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'agency_id' => 1, // Linked to Musango
            ]
        );

        // 3. MUSANGO CONDUCTOR / STAFF (For Check-in Management)
        User::updateOrCreate(
            ['email' => 'staff@musango.cm'],
            [
                'name' => 'Musango Conductor',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'agency_id' => 1, // Linked to Musango
            ]
        );

        // 4. REGULAR PASSENGER (Can see all agencies, not linked to any)
        User::updateOrCreate(
            ['email' => 'passenger@gmail.com'],
            [
                'name' => 'Regular Passenger',
                'password' => Hash::make('password'),
                'role' => 'passenger',
                'agency_id' => null,
            ]
        );

        // 5. Finalize Trips
        $this->call([
            TripSeeder::class,
        ]);
    }
}
