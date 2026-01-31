<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Wishlist as WishlistModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('My Wishlist')]
class Wishlist extends Component
{
    public function removeFromWishlist($id)
    {
        WishlistModel::where('id', $id)->where('user_id', Auth::id())->delete();
        $this->dispatch('swal:success', [
            'title' => 'Removed',
            'text' => 'Item removed from your curated wishlist.',
            'icon' => 'success'
        ]);
    }

    public function render()
    {
        $wishlistItems = Auth::user()->wishlist()->with('product')->get();

        return view('livewire.user.wishlist', [
            'wishlistItems' => $wishlistItems
        ]);
    }
}
