<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MasterAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Clear potential conflicts
        DB::table('users')->where('email', 'admin@chic.co')->delete();

        User::updateOrCreate(
            ['email' => 'admin@chic.co'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin'),
                'role' => 'admin',
                'style_persona' => 'luxury'
            ]
        );

        $this->command->info('MASTER ADMIN CREATED: admin@chic.co / admin');
    }
}
