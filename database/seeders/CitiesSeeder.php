<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'Yaoundé', 'region' => 'Centre', 'is_active' => true],
            ['name' => 'Douala', 'region' => 'Littoral', 'is_active' => true],
            ['name' => 'Bafoussam', 'region' => 'Ouest', 'is_active' => true],
            ['name' => 'Bamenda', 'region' => 'Nord-Ouest', 'is_active' => true],
            ['name' => 'Garoua', 'region' => 'Nord', 'is_active' => true],
            ['name' => 'Maroua', 'region' => 'Extrême-Nord', 'is_active' => true],
            ['name' => 'Ngaoundéré', 'region' => 'Adamaoua', 'is_active' => true],
            ['name' => 'Bertoua', 'region' => 'Est', 'is_active' => true],
            ['name' => 'Buea', 'region' => 'Sud-Ouest', 'is_active' => true],
            ['name' => 'Limbé', 'region' => 'Sud-Ouest', 'is_active' => true],
            ['name' => 'Kribi', 'region' => 'Sud', 'is_active' => true],
            ['name' => 'Ebolowa', 'region' => 'Sud', 'is_active' => true],
        ];

        foreach ($cities as $city) {
            City::updateOrCreate(
                ['name' => $city['name']], // Check by name
                $city // Update or create with these values
            );
        }

        $this->command->info('Cities seeded successfully!');
    }
}
