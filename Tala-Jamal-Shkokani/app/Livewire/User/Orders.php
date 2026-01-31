<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('My Wardrobe')]
class Orders extends Component
{
    public $selectedOrderId;

    public function showReceipt($orderId)
    {
        $this->selectedOrderId = $orderId;
        $this->dispatch('open-receipt-drawer');
    }

    public function render()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        $selectedOrder = $this->selectedOrderId ? Order::with(['items.product', 'user'])->find($this->selectedOrderId) : null;

        return view('livewire.user.orders', [
            'orders' => $orders,
            'selectedOrder' => $selectedOrder
        ]);
    }
}
