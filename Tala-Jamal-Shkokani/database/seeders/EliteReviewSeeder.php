<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class EliteReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }

        $reviews = [
            'soft' => [
                'rating' => 5,
                'comments' => [
                    "The way this piece drapes is pure poetry. The silk is substantial yet ethereal.",
                    "An absolute dream for my soft-femme archive. The color is exactly as pictured.",
                    "Exquisite craftsmanship. It feels like wearing a cloud of luxury.",
                    "Perfectly encapsulates my aesthetic. The detail work is breathtaking."
                ]
            ],
            'luxury' => [
                'rating' => 5,
                'comments' => [
                    "Architectural perfection. This is silent luxury at its most profound.",
                    "The cut is razor-sharp. A cornerstone for any minimalist collection.",
                    "Investing in this archive was the best decision. The quality is generational.",
                    "Seamless construction and elite materials. Worth every JOD."
                ]
            ],
            'alt' => [
                'rating' => 5,
                'comments' => [
                    "Structured, rebellious, and undeniably chic. The silver hardware is heavy and premium.",
                    "Exactly the edge I was looking for. The fit is empowering.",
                    "Unrivaled quality in the alt-archive space. A statement piece that turns heads.",
                    "The material is incredibly durable. A true lifetime acquisition."
                ]
            ],
            'mix' => [
                'rating' => 5,
                'comments' => [
                    "A daring blend of textures. This is what modern curation should look like.",
                    "Eclectic yet refined. It bridges the gap between eras perfectly.",
                    "Breathtaking patterns and masterful execution. A unique archive gem.",
                    "The versatility of this piece is unmatched. It shifts with my mood effortlessly."
                ]
            ]
        ];

        // Seed 2-3 reviews for each product to make it look active
        foreach ($products as $product) {
            $aesthetic = $product->aesthetic ?? 'luxury';
            $reviewData = $reviews[$aesthetic] ?? $reviews['luxury'];

            // Try to find a user that matches this aesthetic for a more "intended" feel
            $matchingUser = $users->where('primary_aesthetic', $aesthetic)->first();

            // 70% chance to have 1-2 reviews
            if (rand(1, 100) <= 70) {
                $numReviews = rand(1, 2);
                for ($i = 0; $i < $numReviews; $i++) {
                    // Use the matching user for the first review, then random for others
                    $user = ($i === 0 && $matchingUser) ? $matchingUser : $users->random();

                    Review::updateOrCreate(
                        ['user_id' => $user->id, 'product_id' => $product->id],
                        [
                            'rating' => rand(4, 5),
                            'comment' => $reviewData['comments'][array_rand($reviewData['comments'])],
                            'is_approved' => true,
                            'created_at' => now()->subDays(rand(1, 30))
                        ]
                    );
                }
            }
        }
    }
}
