<?php

namespace Database\Seeders;

use App\Models\CustomerProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CustomerProfilesSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        CustomerProfile::query()->delete();
        Schema::enableForeignKeyConstraints();

        $customers = User::query()->where('role', User::ROLE_CUSTOMER)->get();

        foreach ($customers as $u) {
            CustomerProfile::create([
                'user_id' => $u->id,
                'zip_code' => (string)random_int(10000, 99999),
            ]);
        }
    }
}
