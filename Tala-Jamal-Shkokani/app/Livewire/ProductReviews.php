<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ProductReviews extends Component
{
    public $productId;
    public $rating = 5;
    public $comment = '';
    public $showForm = false;
    public $canReview = false;

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|min:5',
    ];

    public function mount($productId)
    {
        $this->productId = $productId;

        if (Auth::check()) {
            $this->canReview = Auth::user()->orders()
                ->where('status', 'delivered')
                ->whereHas('items', function ($query) {
                    $query->where('product_id', $this->productId);
                })->exists();
        }
    }

    public function submitReview()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate();

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $this->productId,
            'rating' => $this->rating,
            'comment' => $this->comment,
        ]);

        $this->reset(['comment', 'rating', 'showForm']);

        $this->dispatch('swal:success', [
            'title' => 'Review Submitted',
            'text' => 'Thank you for sharing your experience.',
            'icon' => 'success'
        ]);
    }

    public function render()
    {
        $product = Product::with('reviews.user')->findOrFail($this->productId);
        $reviews = $product->reviews()->latest()->get();
        $averageRating = $reviews->avg('rating') ?: 0;

        return view('livewire.product-reviews', [
            'reviews' => $reviews,
            'averageRating' => $averageRating
        ]);
    }
}
