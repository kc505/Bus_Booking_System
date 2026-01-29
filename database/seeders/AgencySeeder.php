<?php

namespace Database\Seeders;

use App\Models\Agency;
use Illuminate\Database\Seeder;

class AgencySeeder extends Seeder
{
    public function run(): void
    {
        $agencies = [
            ['id' => 1, 'name' => 'Musango', 'email' => 'info@musango.cm', 'phone' => '+237 670000000', 'is_active' => true],
            ['id' => 2, 'name' => 'Nso Boys', 'email' => 'contact@nsoboys.com', 'phone' => '+237 678454573', 'is_active' => true],
            ['id' => 3, 'name' => 'Park Lane', 'email' => 'admin@parklane.com', 'phone' => '+237 654312452', 'is_active' => true],
        ];

        foreach ($agencies as $agency) {
            Agency::updateOrCreate(['id' => $agency['id']], $agency);
        }
    }
}
