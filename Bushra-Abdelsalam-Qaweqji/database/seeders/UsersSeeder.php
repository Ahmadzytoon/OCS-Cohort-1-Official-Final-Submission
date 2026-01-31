<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::query()->delete();
        Schema::enableForeignKeyConstraints();

        // Admin
        User::create([
            'role' => User::ROLE_ADMIN,
            'name' => 'Cleanova Admin',
            'email' => 'admin@cleanova.test',
            'password' => 'Password123!',
            'phone' => '0791234567',
            'status' => User::STATUS_ACTIVE,
        ]);
        // Customer
        User::create([
            'role' => User::ROLE_CUSTOMER,
            'name' => "Bushra Qaweqji",
            'email' => "bushra@cleanova.test",
            'password' => 'Password123!',
            'phone' => '07' . str_pad((string)random_int(10000000, 99999999), 8, '0', STR_PAD_LEFT),
            'status' => User::STATUS_ACTIVE,
            ]);
            
        // Providers
        $providers = [ "Liam Carter", "Olivia Martinez", "Noah Johnson", "Emma Williams", "Ethan Brown", "Sophia Anderson", "James Wilson", "Ava Thompson", "Benjamin Harris", "Mia Clark", "Lucas Rodriguez", "Isabella Lewis", "Henry Walker", "Charlotte Hall", "Alexander Young", "Amelia King", "Daniel Scott", "Harper Green", "Matthew Adams", "Ella Baker"];
        for ($i = 0; $i <= 19; $i++) {
            User::create([
                'role' => User::ROLE_PROVIDER,
                'name' => $providers[$i],
                'email' => "provider{$i}@cleanova.test",
                'password' => 'Password123!',
                'phone' => '07' . str_pad((string)random_int(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'status' => User::STATUS_ACTIVE,
            ]);
        }
    }
}
