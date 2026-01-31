<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure Admin User
        $this->call(AdminUserSeeder::class);

        // 2. Ensure Categories
        $this->call(CategorySeeder::class);

        // 3. Create Products (Simulating the logic from ProductSeeder but scaling it up)
        // We'll just call ProductSeeder since we updated it to create 50 products
        $this->call(ProductSeeder::class);

        // 4. Attach Images to Products
        $this->call(ImageSeeder::class);

        // 5. Create Sample Orders
        $this->call(OrderSeeder::class);
    }
}
