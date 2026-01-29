<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Agency;
use App\Models\Seat;
use Illuminate\Database\Seeder;

class BusSeeder extends Seeder
{
    public function run(): void
    {
        $agencies = Agency::all();

        foreach ($agencies as $agency) {
            // Create 1 bus per agency for testing
            $bus = Bus::updateOrCreate(
                ['plate_number' => 'BUS-' . $agency->id . '-CAM'],
                [
                    'agency_id' => $agency->id,
                    'brand' => 'Mercedes-Benz',
                    'capacity' => 70,
                ]
            );

            // Create 70 seats
            for ($i = 1; $i <= 70; $i++) {
                Seat::updateOrCreate(
                    ['bus_id' => $bus->id, 'seat_number' => $i],
                    [
                        'is_available_online' => ($i <= 32),
                        'side' => ($i % 2 == 0) ? 'right' : 'left',
                        'class' => 'standard',
                    ]
                );
            }
        }
    }
}
