<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    
    public function index()
    {
        $orders = Auth::user()->orders()
            ->with(['items.book'])
            ->latest()
            ->paginate(10);
        
        return view('user.orders', compact('orders'));
    }

    public function show($id)
    {
        $order = Auth::user()->orders()
            ->with(['items.book', 'shippingAddress', 'payment'])
            ->findOrFail($id);
        
        return view('user.order-show', compact('order'));
    }
}