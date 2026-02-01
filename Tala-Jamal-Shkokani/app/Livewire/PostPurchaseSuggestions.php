<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Order;

class PostPurchaseSuggestions extends Component
{
    public $order;
    public $suggestions = [];

    public function mount(Order $order)
    {
        $this->order = $order;
        $this->loadSuggestions();
    }

    public function loadSuggestions()
    {
        $purchasedCategoryIds = $this->order->items->pluck('product.category_id')->filter()->unique();
        $purchasedAesthetics = $this->order->items->pluck('product.aesthetic')->filter()->unique();
        $purchasedProductIds = $this->order->items->pluck('product_id')->unique();

        // Suggest items with same aesthetic but different categories, or high discover score
        $this->suggestions = Product::query()
            ->whereNotIn('id', $purchasedProductIds)
            ->where(function ($query) use ($purchasedAesthetics) {
                if ($purchasedAesthetics->count() > 0) {
                    $query->whereIn('aesthetic', $purchasedAesthetics);
                }
            })
            ->orderBy('discover_score', 'desc')
            ->limit(4)
            ->get();
    }

    public function render()
    {
        return view('livewire.post-purchase-suggestions');
    }
}
