<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Category;
use App\Models\Book; 
use App\Models\Coupon;
use App\Models\Author; // 👈 Add this import
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalAuthors = Author::count();
        $totalBooks = Book::count();
        $totalOrders = Order::count();
        $completedOrders = Order::where('order_status', 'delivered')->count();

        $totalRevenue = Order::whereHas('payments', function ($query) {
            $query->where('payment_status', 'succeeded'); 
        })->sum('total_amount');

        $pendingOrders = Order::where('order_status', 'pending')->count();
        $canceledOrders = Order::where('order_status', 'cancelled')->count();
        $lowStockBooks = Book::whereBetween('stock_quantity', [1, 10])->count();
        $outOfStock = Book::where('stock_quantity', 0)->count();
        $activeCategories = Category::count();

        // Coupon Statistics
        $activeCoupons = Coupon::where('is_active', true)
                             ->where(function($query) {
                                 $query->whereNull('expires_at')
                                       ->orWhere('expires_at', '>', now());
                             })
                             ->count();

        $usedCoupons = Coupon::where('used_count', '>', 0)->count();

        // Chart Data: Sales Analytics (Last 30 days)
        // Chart Data: Sales Analytics (Last 30 days)
        $salesData = Order::whereHas('payments', function ($query) {
                $query->where('payment_status', 'succeeded');
            })
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('total', 'date');

        // Chart Data: Order Status Distribution
        $orderStatusData = Order::selectRaw('order_status, COUNT(*) as count')
            ->groupBy('order_status')
            ->pluck('count', 'order_status');

        // Chart Data: Top Selling Books
        $topBooks = Book::orderBy('sales_count', 'desc')->take(5)->pluck('sales_count', 'title');

        // Chart Data: Top Categories
        $topCategories = Category::withCount('books')->orderBy('books_count', 'desc')->take(5)->pluck('books_count', 'name');

        // Chart Data: Daily Orders (Last 7 days)
        $dailyOrdersData = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('count', 'date');

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalBooks',
            'totalOrders',
            'completedOrders',
            'totalRevenue',
            'pendingOrders',
            'canceledOrders', // Restored 'canceledOrders'
            'lowStockBooks',
            'outOfStock',
            'activeCategories',
            'activeCoupons',
            'usedCoupons',
            'totalAuthors',
            'salesData',
            'orderStatusData',
            'topBooks',
            'topCategories',
            'dailyOrdersData'
        ));
    }
}