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
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // Member
        User::firstOrCreate(
            ['email' => 'member@example.com'],
            [
                'name' => 'Zayn Malik',
                'password' => Hash::make('password'),
                'role' => 'member',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // Curator
        User::firstOrCreate(
            ['email' => 'curator@example.com'],
            [
                'name' => 'John Curator',
                'password' => Hash::make('password'),
                'role' => 'curator',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
    }
}