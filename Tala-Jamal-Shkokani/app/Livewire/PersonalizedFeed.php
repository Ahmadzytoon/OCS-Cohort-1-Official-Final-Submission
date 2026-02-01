<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('My Edit • Wonderland')]
class PersonalizedFeed extends Component
{
    use WithPagination;

    public $aesthetic;
    public $mood = 'discover'; // discover, indulge, explore
    public $view = 'feed'; // feed, lookbook, atelier

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->view = request('view', 'feed');
        $this->aesthetic = request('aesthetic');

        if (!$this->aesthetic) {
            if (auth()->check()) {
                $this->aesthetic = auth()->user()->primary_aesthetic ?? auth()->user()->style_persona ?? Session::get('user_aesthetic', 'mix');
            } else {
                $this->aesthetic = Session::get('user_aesthetic', 'mix');
            }
        } else {
            // Save it to session for future visits
            Session::put('user_aesthetic', $this->aesthetic);
        }
    }

    public function addToCart($productId)
    {
        try {
            $cartService = new \App\Services\CartService();
            $cartService->add($productId);

            $this->dispatch('cart-updated');
            $this->dispatch('open-cart');

            \Log::info('PersonalizedFeed Quick Add: Success', ['productId' => $productId]);
        } catch (\Exception $e) {
            \Log::error('PersonalizedFeed Quick Add Error: ' . $e->getMessage());
            $this->dispatch('swal:error', ['title' => 'Error', 'text' => 'Could not update your bag.']);
        }
    }

    public function setMood($mood)
    {
        $this->mood = $mood;
        $this->resetPage();
    }

    public function setView($view)
    {
        $this->view = $view;
        $this->resetPage();
    }

    public function render()
    {
        $recommendationService = new \App\Services\StyleRecommendationService();
        $query = $recommendationService->getPersonalizedQuery();

        // Aesthetic override if manually selected (optional)
        if ($this->aesthetic && $this->aesthetic !== 'mix' && $this->aesthetic !== 'all') {
            $query->where('aesthetic', $this->aesthetic);
        }

        // Apply mood filters dynamically
        if ($this->mood === 'indulge') {
            // Indulge: High tier priority
            $query->orderByRaw("CASE WHEN price_tier = 'luxury' THEN 0 ELSE 1 END")
                ->orderBy('price', 'desc');
        } elseif ($this->mood === 'explore') {
            // Explore: Shuffle the predictable algorithm for discovery
            // Using reorder() is critical to clear both order clauses and their bindings
            $query->reorder()->inRandomOrder();
        }

        $products = $query->paginate(12);

        return view('livewire.personalized-feed', [
            'products' => $products
        ]);
    }
}
