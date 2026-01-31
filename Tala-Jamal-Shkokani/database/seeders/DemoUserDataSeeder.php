<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserPaymentMethod;

class DemoUserDataSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'admin')->first() ?? User::first();

        if ($user) {
            // Demo Address
            UserAddress::updateOrCreate(
                ['user_id' => $user->id, 'street_address' => 'Luxury Villas 10'],
                [
                    'type' => 'home',
                    'area' => 'Dabouq',
                    'phone' => '0799999999',
                    'is_default' => true,
                ]
            );

            UserAddress::updateOrCreate(
                ['user_id' => $user->id, 'street_address' => 'Business Center Tower'],
                [
                    'type' => 'work',
                    'area' => 'Abdoun',
                    'phone' => '0798888888',
                    'is_default' => false,
                ]
            );

            // Demo Payment
            UserPaymentMethod::updateOrCreate(
                ['user_id' => $user->id, 'last_four' => '4242'],
                [
                    'type' => 'card',
                    'provider' => 'Visa',
                    'expiry' => '12/28',
                    'is_default' => true,
                ]
            );
        }
    }
}
