<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class RecentOrders extends Component
{
    public function reorder($orderId)
    {
        $order = Order::with('items')->find($orderId);
        if (!$order)
            return;

        $cart = Session::get('cart', []);

        foreach ($order->items as $item) {
            $cartKey = $item->product_id . ($item->size ? '-' . $item->size : '') . ($item->color ? '-' . str_replace('#', '', $item->color) : '');

            if (isset($cart[$cartKey])) {
                $cart[$cartKey]['quantity'] += $item->quantity;
            } else {
                $cart[$cartKey] = [
                    'id' => $item->product_id,
                    'name' => $item->product->name,
                    'price' => $item->price,
                    'image' => $item->product->images->first()?->url ?? asset('images/placeholder.jpg'),
                    'aesthetic' => $item->product->aesthetic,
                    'size' => $item->size,
                    'color' => $item->color,
                    'quantity' => $item->quantity,
                ];
            }
        }

        Session::put('cart', $cart);
        $this->dispatch('cart-updated');

        $this->dispatch('swal:success', [
            'title' => 'Bag Updated!',
            'text' => 'We\'ve added items from your previous order to your bag.',
            'icon' => 'success'
        ]);
    }

    public function render()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.product.images')
            ->orderBy('created_at', 'desc')
            ->limit(2)
            ->get();

        return view('livewire.user.recent-orders', [
            'orders' => $orders
        ]);
    }
}
