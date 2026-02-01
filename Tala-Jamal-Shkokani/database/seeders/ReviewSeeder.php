<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Product;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }

        $comments = [
            5 => [
                "Absolutely stunning piece! The quality is unmatched.",
                "Better than I expected. Fits perfectly into my aesthetic.",
                "A true luxury experience. Highly recommend.",
                "Obsessed with this! Will definitely buy more.",
                "The details are exquisite. Worth every penny."
            ],
            4 => [
                "Really beautiful, just took a bit long to ship.",
                "Great quality, slightly different color than photos but still nice.",
                "Love the design, fits well.",
                "Very chic and modern.",
                "Good value for the price."
            ],
            3 => [
                "It's okay, but I expected a bit more for the price.",
                "Nice, but the sizing runs small.",
                "Average quality, nothing special.",
                "Decent, but took forever to arrive.",
                "Looks good from afar, but details are lacking."
            ]
        ];

        // Create 30 reviews
        for ($i = 0; $i < 30; $i++) {
            $rating = rand(3, 5); // Mostly positive reviews
            $commentList = $comments[$rating];

            Review::create([
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'rating' => $rating,
                'comment' => $commentList[array_rand($commentList)],
                'is_approved' => rand(0, 1) // Random approval status
            ]);
        }
    }
}
