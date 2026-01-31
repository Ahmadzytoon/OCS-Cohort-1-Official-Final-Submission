<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Primary curator admin
        User::updateOrCreate(
            ['email' => 'admin@chic.co'],
            [
                'name' => 'Admin Curator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'style_persona' => 'luxury'
            ]
        );

        $this->command->info('Admin user created: admin@chic.co / password');
    }
}
