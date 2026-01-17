<?php
// database/seeders/AdminUserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '1234567890',
            'address' => 'Admin Address',
            'is_approved' => true,
            'email_verified_at' => now(),
        ]);

        // Create a sample seller
        User::create([
            'name' => 'Seller User',
            'email' => 'seller@example.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'phone' => '1234567891',
            'address' => 'Seller Address',
            'is_approved' => true,
            'email_verified_at' => now(),
        ]);

        // Create a sample customer
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '1234567892',
            'address' => 'Customer Address',
            'is_approved' => true,
            'email_verified_at' => now(),
        ]);
    }
}