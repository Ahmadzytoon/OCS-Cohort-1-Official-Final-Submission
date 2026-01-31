<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class UpdateProductColorsAndStockSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $colors = ['#000000', '#F5F5DC', '#FFFFFF', '#808080', '#A52A2A', '#000080', '#2E8B57', '#C0C0C0', '#FFD700'];

        foreach ($products as $product) {
            $updates = [];

            // Add colors if missing or empty
            if (empty($product->colors)) {
                $updates['colors'] = fake()->randomElements($colors, fake()->numberBetween(2, 4));
            }

            // Randomly mark some as sold out (stock = 0)
            // Let's say ~20% chance
            if (fake()->boolean(20)) {
                $updates['stock'] = 0;
            }

            if (!empty($updates)) {
                $product->update($updates);
            }
        }
    }
}
