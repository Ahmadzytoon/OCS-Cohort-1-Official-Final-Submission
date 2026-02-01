<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'address'])->orderBy('created_at', 'desc');
        
        // Filter by status
        $query->when($request->filled('status'), function($q) use ($request) {
            $q->where('order_status', $request->status);
        });
        
        // Filter by date range
        $query->when($request->filled('from_date'), function($q) use ($request) {
            $q->whereDate('created_at', '>=', $request->from_date);
        });
        
        $query->when($request->filled('to_date'), function($q) use ($request) {
            $q->whereDate('created_at', '<=', $request->to_date);
        });

        // Search by Order ID or Customer Name
        $query->when($request->filled('search'), function($q) use ($request) {
            $searchTerm = $request->search;
            $q->where(function($sq) use ($searchTerm) {
                $sq->where('id', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function($qu) use ($searchTerm) {
                      $qu->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        });
        
        $orders = $query->simplePaginate(5);
        
        return view('admin.orders', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'address', 'orderItems.book.author', 'orderItems.book.category']);
        return view('admin.orders-show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:pending,delivered,cancelled',
        ]);

        $order->update(['order_status' => $request->order_status]);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order status updated successfully!');
    }
}