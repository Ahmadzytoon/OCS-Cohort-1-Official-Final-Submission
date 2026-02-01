<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserPaymentMethod;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin Curator
        $admin = User::updateOrCreate(
            ['email' => 'admin@chic.co'],
            [
                'name' => 'The Master Curator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'style_persona' => 'Luxury Clean',
                'primary_aesthetic' => 'luxury',
            ]
        );

        // 2. Test User 1: Soft Femme 🌸
        $user1 = User::updateOrCreate(
            ['email' => 'soft@chic.co'],
            [
                'name' => 'Sofia Rose',
                'password' => Hash::make('password'),
                'role' => 'user',
                'style_persona' => 'Soft Femme',
                'primary_aesthetic' => 'soft',
                'loyalty_tier' => 'Gold',
            ]
        );

        $this->seedUserRelations($user1, 'Soft');

        // 3. Test User 2: Alt Girly 🖤
        $user2 = User::updateOrCreate(
            ['email' => 'alt@chic.co'],
            [
                'name' => 'Luna Vesper',
                'password' => Hash::make('password'),
                'role' => 'user',
                'style_persona' => 'Alt Girly',
                'primary_aesthetic' => 'alt',
                'loyalty_tier' => 'Silver',
            ]
        );

        $this->seedUserRelations($user2, 'Alt');

        // 4. Test User 3: Modern Mix 🎭
        $user3 = User::updateOrCreate(
            ['email' => 'mix@chic.co'],
            [
                'name' => 'Alex Echo',
                'password' => Hash::make('password'),
                'role' => 'user',
                'style_persona' => 'Modern Mix',
                'primary_aesthetic' => 'mix',
                'loyalty_tier' => 'Platinum',
            ]
        );

        $this->seedUserRelations($user3, 'Mix');
    }

    private function seedUserRelations($user, $prefix)
    {
        // Address
        UserAddress::create([
            'user_id' => $user->id,
            'type' => 'Home',
            'area' => 'Abdoun',
            'street_address' => 'Luxury Lane 404',
            'building_no' => 'Gemini Tower',
            'apartment_no' => 'Suite ' . rand(100, 999),
            'phone' => '+962 79 ' . rand(1000000, 9999999),
            'is_default' => true,
        ]);

        UserAddress::create([
            'user_id' => $user->id,
            'type' => 'Work',
            'area' => 'Dabouq',
            'street_address' => 'Business Bay 101',
            'building_no' => 'The Archive',
            'apartment_no' => 'Office ' . rand(1, 50),
            'phone' => '+962 79 ' . rand(1000000, 9999999),
            'is_default' => false,
        ]);

        // Payment Method
        UserPaymentMethod::create([
            'user_id' => $user->id,
            'type' => 'Credit Card',
            'provider' => 'Visa',
            'last_four' => rand(1000, 9999),
            'expiry' => '12/28',
            'token' => Str::random(32),
            'is_default' => true,
        ]);

        UserPaymentMethod::create([
            'user_id' => $user->id,
            'type' => 'Apple Pay',
            'provider' => 'Apple',
            'last_four' => rand(1000, 9999),
            'expiry' => '01/30',
            'token' => Str::random(32),
            'is_default' => false,
        ]);

        // Wishlist
        $wishlistProducts = \App\Models\Product::inRandomOrder()->limit(3)->get();
        foreach ($wishlistProducts as $wp) {
            \App\Models\Wishlist::updateOrCreate([
                'user_id' => $user->id,
                'product_id' => $wp->id
            ]);
        }

        // Loyalty Points
        \App\Models\LoyaltyPoint::create([
            'user_id' => $user->id,
            'points' => rand(100, 1000),
            'reason' => 'Welcome to the Archive',
            'expires_at' => now()->addYear()
        ]);

        // Profile information is now primarily handled on the User model itself
        // or through specific related tables like UserAddress.
    }
}
