<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::updateOrCreate(
            ['email' => 'admin@bookstore.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Regular User
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        // Subscription Plans
        Plan::updateOrCreate(
            ['name' => 'Monthly Starter'],
            [
                'description' => 'Perfect for new authors.',
                'price' => 19.99,
                'duration_type' => 'month',
                'book_limit' => 5,
                'is_active' => true,
            ]
        );

        Plan::updateOrCreate(
            ['name' => 'Yearly Professional'],
            [
                'description' => 'Our most popular plan for established authors.',
                'price' => 199.99,
                'duration_type' => 'year',
                'book_limit' => -1,
                'is_active' => true,
            ]
        );
    }
}
