<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Wipe standard tables to ensure a clean luxury archive
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        DB::table('user_addresses')->truncate();
        DB::table('user_payment_methods')->truncate();
        DB::table('user_profiles')->truncate();
        DB::table('categories')->truncate();
        DB::table('products')->truncate();
        DB::table('images')->truncate();
        DB::table('product_variants')->truncate();
        DB::table('orders')->truncate();
        DB::table('order_items')->truncate();
        DB::table('cart_items')->truncate();
        DB::table('wishlists')->truncate();
        DB::table('reviews')->truncate();
        DB::table('user_behaviors')->truncate();
        DB::table('user_engagements')->truncate();
        DB::table('style_quiz_results')->truncate();
        Schema::enableForeignKeyConstraints();

        // 2. Call specialized seeders in dependency order
        $seeders = [
            CategorySeeder::class,
            LuxuryProductSeeder::class,
            UserSeeder::class,
            OrderSeeder::class,
            EliteReviewSeeder::class,
            AttributeSeeder::class,
            PersonaEngagementSeeder::class,
        ];

        foreach ($seeders as $seeder) {
            try {
                $this->call($seeder);
            } catch (\Exception $e) {
                $this->command->error("Error in $seeder: " . $e->getMessage());
                // Throw to stop if necessary, or just continue to see all errors
            }
        }

        $this->command->info('Full Luxury Archive Seeded: Categories, Products, Users, Orders, and Elite Reviews are now live!');
    }
}
