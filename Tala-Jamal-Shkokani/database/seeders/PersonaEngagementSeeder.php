<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\UserBehavior;
use App\Models\UserEngagement;
use App\Models\StyleQuizResult;
use App\Models\CartItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PersonaEngagementSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::whereIn('email', ['soft@chic.co', 'alt@chic.co', 'mix@chic.co'])->get();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }

        foreach ($users as $user) {
            $aesthetic = $user->primary_aesthetic;

            // 1. Style Quiz Results (Foundation for personalization)
            StyleQuizResult::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'dominant_aesthetic' => $aesthetic,
                    'style_archetype' => $user->style_persona,
                    'preferences' => [
                        'colors' => $aesthetic === 'soft' ? ['pink', 'white'] : ($aesthetic === 'alt' ? ['black', 'purple'] : ['gold', 'black']),
                        'fit' => 'Relaxed',
                        'budget' => 'Premium'
                    ]
                ]
            );

            // 2. Behavioral History (Simulate browsing the website)
            // Seed 10-15 "view" actions primarily on their aesthetic
            $targetedProducts = $products->where('aesthetic', $aesthetic);
            $otherProducts = $products->where('aesthetic', '!=', $aesthetic);

            // View 8 random products from their aesthetic
            foreach ($targetedProducts->random(min(8, $targetedProducts->count())) as $p) {
                UserBehavior::create([
                    'user_id' => $user->id,
                    'product_id' => $p->id,
                    'action' => 'view',
                    'metadata' => ['duration' => rand(10, 60), 'source' => 'feed'],
                    'created_at' => now()->subDays(rand(1, 10))
                ]);
            }

            // View 4 random products from other aesthetics (realistic browsing)
            foreach ($otherProducts->random(min(4, $otherProducts->count())) as $p) {
                UserBehavior::create([
                    'user_id' => $user->id,
                    'product_id' => $p->id,
                    'action' => 'view',
                    'metadata' => ['duration' => rand(5, 20), 'source' => 'discover'],
                    'created_at' => now()->subDays(rand(1, 5))
                ]);
            }

            // 3. Engagement Signals (More intense actions)
            // Add a product to cart that matches their aesthetic
            $cartProduct = $targetedProducts->random();
            CartItem::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'product_id' => $cartProduct->id
                ],
                [
                    'quantity' => 1,
                    'color' => $cartProduct->colors[0] ?? '#000000',
                    'size' => $cartProduct->sizes[0] ?? 'M',
                    'session_id' => Str::random(40)
                ]
            );

            // Engagement Record for "Review Click"
            UserEngagement::create([
                'user_id' => $user->id,
                'type' => 'review_view',
                'engageable_type' => Product::class,
                'engageable_id' => $targetedProducts->random()->id,
                'data' => ['source' => 'product_page']
            ]);
        }
    }
}
