<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
/* ======================
   PHOTOGRAPHERS
====================== */
[
    'for' => 'photographer',
    'code' => 'free',
    'name' => 'Free',
    'price_jod' => 0,
    'sort' => 10,
    'features' => [
        'portfolio_upload' => true,
        'accept_booking' => false,         // ❗ Free ما بقبل
        'portfolio_limit' => 6,
        'monthly_requests_limit' => 2,
        'chat' => false,
        'featured' => false,
        'analytics' => false,
    ],
],
[
    'for' => 'photographer',
    'code' => 'pro',
    'name' => 'Pro',
    'price_jod' => 12,
    'sort' => 20,
    'features' => [
        'portfolio_upload' => true,
        'accept_booking' => true,          // ✅ Pro بقبل
        'portfolio_limit' => null,
        'monthly_requests_limit' => null,
        'chat' => true,
        'featured' => false,
        'analytics' => false,
    ],
],
[
    'for' => 'photographer',
    'code' => 'premium',
    'name' => 'Premium',
    'price_jod' => 25,
    'sort' => 30,
    'features' => [
        'portfolio_upload' => true,
        'accept_booking' => true,          // ✅ Premium بقبل
        'portfolio_limit' => null,
        'monthly_requests_limit' => null,
        'chat' => true,
        'featured' => true,
        'analytics' => true,
    ],
],

/* ======================
   STUDIOS
====================== */
[
    'for' => 'studio',
    'code' => 'starter',
    'name' => 'Starter',
    'price_jod' => 20,
    'sort' => 10,
    'features' => [
        'portfolio_upload' => true,        // إذا عندك صور للستديو
        'accept_booking' => true,          // عادة الستديو لازم يقدر يقبل
        'team_members' => 2,
        'multi_calendar' => false,
        'analytics' => false,
        'featured' => false,
    ],
],
[
    'for' => 'studio',
    'code' => 'pro',
    'name' => 'Studio Pro',
    'price_jod' => 45,
    'sort' => 20,
    'features' => [
        'portfolio_upload' => true,
        'accept_booking' => true,
        'team_members' => 8,
        'multi_calendar' => true,
        'analytics' => false,
        'featured' => false,
    ],
],
[
    'for' => 'studio',
    'code' => 'premium',
    'name' => 'Studio Premium',
    'price_jod' => 80,
    'sort' => 30,
    'features' => [
        'portfolio_upload' => true,
        'accept_booking' => true,
        'team_members' => 20,
        'multi_calendar' => true,
        'analytics' => true,
        'featured' => true,
    ],
],

        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(
                ['for' => $plan['for'], 'code' => $plan['code']],
                $plan
            );
        }
    }
}
