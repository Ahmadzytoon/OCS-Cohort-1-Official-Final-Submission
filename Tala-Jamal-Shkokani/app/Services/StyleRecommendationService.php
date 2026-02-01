<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class StyleRecommendationService
{
    /**
     * Get a personalized query builder based on the user's total interactive footprint.
     */
    public function getPersonalizedQuery()
    {
        $stats = $this->analyzeStyleContext();
        $aesthetic = $stats['aesthetic'];
        $priceTier = $stats['price_tier'];

        $query = Product::where('status', 'active')->where('stock', '>', 0);

        // Score based on aesthetic match (Primary importance)
        if ($aesthetic !== 'mix') {
            $query->orderByRaw("CASE WHEN aesthetic = ? THEN 0 ELSE 1 END", [$aesthetic]);
        }

        // Tier refinement
        if ($priceTier === 'luxury') {
            $query->orderByRaw("CASE WHEN price_tier = 'luxury' THEN 0 ELSE 1 END");
        }

        // Always mix in some high discovery score items
        $query->orderBy('discover_score', 'desc');

        return $query;
    }

    /**
     * Get tailored recommendations based on a user's style context.
     */
    public function getRecommendations(Collection $currentItems = null, $limit = 4): Collection
    {
        $query = $this->getPersonalizedQuery();

        if ($currentItems) {
            $query->whereNotIn('id', $currentItems->pluck('id')->toArray());
        }

        return $query->limit($limit)->get();
    }

    /**
     * Deep analysis of the current selection and historical behavior to build a style profile.
     */
    private function analyzeStyleContext(Collection $items = null): array
    {
        $user = auth()->user();

        // 1. Initial State from User/Quiz
        $aesthetic = $user->primary_aesthetic ?? 'mix';
        $priceTier = 'mid';

        // 2. Quiz Refinement
        if ($user && $quiz = \App\Models\StyleQuizResult::where('user_id', $user->id)->first()) {
            $aesthetic = $quiz->dominant_aesthetic ?? $aesthetic;
            if (isset($quiz->preferences['budget']) && $quiz->preferences['budget'] === 'Premium') {
                $priceTier = 'luxury';
            }
        }

        // 3. Behavioral Refinement (Browsing History)
        if ($user) {
            $recentViews = \App\Models\UserBehavior::where('user_id', $user->id)
                ->where('action', 'view')
                ->latest()
                ->limit(10)
                ->with('product')
                ->get();

            if ($recentViews->count() > 0) {
                $vAesthetics = $recentViews->pluck('product.aesthetic')->filter();
                if ($vAesthetics->count() > 0) {
                    $aesthetic = $vAesthetics->countBy()->sortDesc()->keys()->first();
                }
            }
        }

        // 4. Cart Refinement (High Intent)
        if ($user) {
            $cartItems = \App\Models\CartItem::where('user_id', $user->id)->with('product')->get();
            if ($cartItems->count() > 0) {
                $cAesthetics = $cartItems->pluck('product.aesthetic')->filter();
                if ($cAesthetics->count() > 0) {
                    $aesthetic = $cAesthetics->countBy()->sortDesc()->keys()->first();
                }
            }
        }

        // 5. Fallback to Session for Guest
        if (!$user && session()->has('recently_viewed')) {
            $recentIds = session()->get('recently_viewed', []);
            $recentProducts = Product::whereIn('id', $recentIds)->get();
            if ($recentProducts->count() > 0) {
                $aesthetic = $recentProducts->pluck('aesthetic')->countBy()->sortDesc()->keys()->first() ?? 'mix';
            }
        }

        return [
            'aesthetic' => $aesthetic ?? 'mix',
            'price_tier' => $priceTier,
            'occasions' => [] // Could be expanded further
        ];
    }
}
