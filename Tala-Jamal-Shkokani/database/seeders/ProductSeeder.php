<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $tops = Category::where('slug', 'tops')->first();
        if (!$tops) {
            $tops = Category::create(['name' => 'Tops', 'slug' => 'tops']);
        }

        // Manual product
        $p1 = Product::firstOrCreate(
            ['slug' => 'classic-silk-blouse'],
            [
                'name' => 'Classic Silk Blouse',
                'sku' => 'TS-001',
                'price' => 85.00,
                'description' => 'A timeless silk blouse for any occasion.',
                'category_id' => $tops->id,
                'stock' => 100,
                'status' => 'active',
                'is_featured' => true,
                'aesthetic' => 'soft',
                'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=600&auto=format&fit=crop'
            ]
        );

        // Factory products
        Product::factory()->count(50)->create();
    }
}
