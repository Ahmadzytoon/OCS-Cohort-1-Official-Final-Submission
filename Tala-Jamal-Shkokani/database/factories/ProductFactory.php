<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $aesthetics = ['soft', 'alt', 'luxury', 'mix'];

        $images = [
            'soft' => [
                'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=600&auto=format&fit=crop', // Pink silk
                'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?q=80&w=600&auto=format&fit=crop', // White dress
                'https://images.unsplash.com/photo-1469334031218-e382a71b716b?q=80&w=600&auto=format&fit=crop', // Soft floral
            ],
            'alt' => [
                'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=600&auto=format&fit=crop', // Boots
                'https://images.unsplash.com/photo-1583209814683-c023dd293cc6?q=80&w=600&auto=format&fit=crop', // Black dress
                'https://images.unsplash.com/photo-1605763560940-2726359eb31c?q=80&w=600&auto=format&fit=crop', // Leather jacket
            ],
            'luxury' => [
                'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?q=80&w=600&auto=format&fit=crop', // Gold watch
                'https://images.unsplash.com/photo-1566150905458-1bf1fc113f0d?q=80&w=600&auto=format&fit=crop', // Handbag
                'https://images.unsplash.com/photo-1445205170230-053b83016050?q=80&w=600&auto=format&fit=crop', // Fur coat
            ],
            'mix' => [
                'https://images.unsplash.com/photo-1520986606214-8b456906c813?q=80&w=600&auto=format&fit=crop', // Scarf
                'https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=600&auto=format&fit=crop', // Statement piece
            ]
        ];

        $aesthetic = fake()->randomElement($aesthetics);
        $image = fake()->randomElement($images[$aesthetic] ?? $images['mix']);

        return [
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'price' => fake()->numberBetween(20, 500),
            'stock' => fake()->numberBetween(0, 100),
            'category_id' => fake()->numberBetween(1, 4), // Assuming categories 1-4 exist from seeder
            'aesthetic' => $aesthetic,
            'image' => $image,
            'price_tier' => fake()->randomElement(['luxury', 'aspirational', 'accessible', 'treat']),
            'colors' => fake()->randomElements(['#000000', '#F5F5DC', '#FFFFFF', '#808080', '#A52A2A', '#000080', '#2E8B57'], fake()->numberBetween(2, 4)),
            'sizes' => fake()->randomElements(['XS', 'S', 'M', 'L', 'XL', 'XXL'], fake()->numberBetween(3, 5)),
            'is_featured' => fake()->boolean(20),
            'status' => 'active',
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
