<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@buscam.cm',
            // 'phone' => '+237 600 000 001',
            'password' => Hash::make('SuperAdmin@123'),
            'is_admin' => 1,
            'role' => 'super_admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
    }
}
