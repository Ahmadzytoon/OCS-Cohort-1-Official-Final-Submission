<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Image;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        $imagesByAesthetic = [
            'soft' => [
                'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1469334031218-e382a71b716b?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1596783074918-c84cb06531ca?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1591369822096-ffd140ec948f?q=80&w=600&auto=format&fit=crop',
            ],
            'alt' => [
                'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1583209814683-c023dd293cc6?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1605763560940-2726359eb31c?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1509319117443-cda9a3e1e1f1?q=80&w=600&auto=format&fit=crop',
            ],
            'luxury' => [
                'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1566150905458-1bf1fc113f0d?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1445205170230-053b83016050?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1584917865442-de89df76afd3?q=80&w=600&auto=format&fit=crop',
            ],
            'mix' => [
                'https://images.unsplash.com/photo-1520986606214-8b456906c813?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?q=80&w=600&auto=format&fit=crop',
            ]
        ];

        foreach ($products as $product) {
            $aesthetic = $product->aesthetic ?? 'mix';
            $availableImages = $imagesByAesthetic[$aesthetic] ?? $imagesByAesthetic['mix'];

            // Each product gets 2-4 images
            $imageCount = rand(2, 4);
            $selectedImages = collect($availableImages)->random(min($imageCount, count($availableImages)));

            foreach ($selectedImages as $index => $imageUrl) {
                Image::create([
                    'url' => $imageUrl,
                    'imageable_id' => $product->id,
                    'imageable_type' => Product::class,
                    'alt_text' => $product->name . ' - Image ' . ($index + 1),
                    'is_primary' => $index === 0, // First image is primary
                    'sort_order' => $index,
                ]);
            }
        }
    }
}
