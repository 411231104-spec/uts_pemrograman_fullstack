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
            'name'     => 'Anza Admin',
            'email'    => 'anza@test.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // Member
        User::create([
            'name'     => 'Fiony Member',
            'email'    => 'fiony@test.com',
            'password' => Hash::make('member123'),
            'role'     => 'member',
        ]);
    }
}
