<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin Smart-Hub',
            'email'    => 'admin@smarthub.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);

        // Member 1
        User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@smarthub.com',
            'password' => Hash::make('password123'),
            'role'     => 'member',
        ]);

        // Member 2
        User::create([
            'name'     => 'Siti Rahayu',
            'email'    => 'siti@smarthub.com',
            'password' => Hash::make('password123'),
            'role'     => 'member',
        ]);
    }
}
