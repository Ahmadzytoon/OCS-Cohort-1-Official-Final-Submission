<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\Layout;
use App\Services\StyleRecommendationService;

#[Layout('layouts.app')]
class ProductDetail extends Component
{
    public $product;
    public $recommendations;

    public function mount($id)
    {
        $this->product = Product::with(['category', 'images'])->findOrFail($id);

        // Track Recently Viewed
        $recentlyViewed = session()->get('recently_viewed', []);

        if (($key = array_search($id, $recentlyViewed)) !== false) {
            unset($recentlyViewed[$key]);
        }

        array_unshift($recentlyViewed, $id);
        $recentlyViewed = array_slice($recentlyViewed, 0, 5);
        session()->put('recently_viewed', $recentlyViewed);

        // Persistent Tracking for Authenticated Users
        if (auth()->check()) {
            \App\Models\UserBehavior::create([
                'user_id' => auth()->id(),
                'product_id' => $id,
                'action' => 'view'
            ]);
        }

        // Century Analytics
        try {
            $century = new \App\Services\CenturyService();
            $century->trackProductView($this->product);
        } catch (\Exception $e) {
        }

        // Get recommendations via Style Service
        $styleService = new StyleRecommendationService();
        $this->recommendations = $styleService->getRecommendations(collect([$this->product]), 4);

        // Initialize selected color
        if ($this->product->colors && count($this->product->colors) > 0) {
            $this->selectedColor = $this->product->colors[0];
        }

        // Initialize selected size if specified in metadata, otherwise default to M if it exists in options
        if ($this->product->sizes && count($this->product->sizes) > 0) {
            $this->selectedSize = in_array('M', $this->product->sizes) ? 'M' : $this->product->sizes[0];
        } else {
            $this->selectedSize = 'M';
        }

        // Debug logging
        \Log::info('ProductDetail Recommendations Debug', [
            'product_id' => $id,
            'product_name' => $this->product->name,
            'product_aesthetic' => $this->product->aesthetic,
            'recommendations_count' => $this->recommendations->count(),
            'recommendations_ids' => $this->recommendations->pluck('id')->toArray(),
        ]);
    }

    public $selectedSize;
    public $selectedColor;

    public function addToCart()
    {
        $this->validate([
            'selectedSize' => 'required|string',
            'selectedColor' => 'nullable|string',
        ]);

        try {
            $variant = $this->product->variants()
                ->where('color', $this->selectedColor)
                ->where('size', $this->selectedSize)
                ->first();

            $maxStock = $variant ? $variant->stock : 0;

            if ($maxStock <= 0) {
                $this->dispatch('swal:error', [
                    'title' => 'Unavailable',
                    'text' => 'This specific combination is currently out of stock.',
                    'icon' => 'warning'
                ]);
                return;
            }

            $cartService = new \App\Services\CartService();
            $cartService->add($this->product->id, 1, $this->selectedSize, $this->selectedColor);

            $this->dispatch('cart-updated');
            $this->dispatch('open-cart');
        } catch (\Exception $e) {
            \Log::error('ProductDetail AddToCart Error: ' . $e->getMessage());
            $this->dispatch('swal:error', ['title' => 'Error', 'text' => 'Could not update your bag.']);
        }
    }

    public function getStockForVariant($color = null, $size = null)
    {
        $color = $color ?? $this->selectedColor;
        $size = $size ?? $this->selectedSize;

        if ($color && $size) {
            $variant = $this->product->variants
                ->where('color', $color)
                ->where('size', $size)
                ->first();
            return $variant ? (int) $variant->stock : 0;
        }
        return 0;
    }

    public function isColorAvailable($color)
    {
        return $this->product->variants
            ->where('color', $color)
            ->where('stock', '>', 0)
            ->count() > 0;
    }

    public function isSizeAvailable($size)
    {
        return $this->product->variants
            ->where('color', $this->selectedColor)
            ->where('size', $size)
            ->where('stock', '>', 0)
            ->count() > 0;
    }

    public function getAvailableSizesProperty()
    {
        if (!$this->selectedColor)
            return $this->product->sizes ?? [];

        return $this->product->variants
            ->where('color', $this->selectedColor)
            ->where('stock', '>', 0)
            ->pluck('size')
            ->unique()
            ->values()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.product-detail')
            ->title($this->product->name . ' - Chic & Co.');
    }
}
