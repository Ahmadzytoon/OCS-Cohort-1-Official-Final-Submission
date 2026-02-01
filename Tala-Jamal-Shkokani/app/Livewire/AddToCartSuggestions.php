<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\On;
use App\Services\CartService;
use App\Services\StyleRecommendationService;

class AddToCartSuggestions extends Component
{
    public $show = false;
    public $productId;
    public $suggestions = [];

    #[On('cart-updated')]
    public function handleCartUpdated($productId = null)
    {
        if (is_array($productId) && isset($productId['productId'])) {
            $productId = $productId['productId'];
        }

        if ($productId) {
            $this->productId = $productId;
            $this->loadSuggestions();
            $this->show = true;
        }
    }

    public function loadSuggestions()
    {
        $product = Product::find($this->productId);
        $service = new StyleRecommendationService();
        $context = $product ? collect([$product]) : null;
        $this->suggestions = $service->getRecommendations($context, 3);
    }

    public function addToCart($id)
    {
        try {
            $cartService = new CartService();
            $cartService->add($id, 1);

            $this->dispatch('cart-updated');

            $this->dispatch('swal:success', [
                'title' => 'Added to Selection',
                'text' => 'This piece has been curated into your bag.',
                'icon' => 'success',
                'timer' => 2000,
                'showConfirmButton' => false
            ]);
        } catch (\Throwable $e) {
            \Log::error('Suggestions AddToCart Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.add-to-cart-suggestions');
    }
}
