<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            CustomerProfilesSeeder::class,
            ProviderProfilesSeeder::class,
            ServiceCatalogSeeder::class,
            ProviderServicesSeeder::class,
            AvailabilitySlotsSeeder::class,
            BookingsSeeder::class,
            PaymentsSeeder::class,
            ReviewsSeeder::class,
        ]);
    }
}
