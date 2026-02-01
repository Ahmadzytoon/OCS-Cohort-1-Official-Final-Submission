<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
#[Title('Curator Dashboard')]
class Dashboard extends Component
{
    public $stats = [];
    public $salesTrend = [];
    public $styleDistribution = [];
    public $customerOfTheMonth = null;
    public $bestSeller = null;
    public $recentPurchases = [];

    public function mount()
    {
        $this->loadStats();
        $this->loadTrends();
        $this->loadStyles();
        $this->loadInsights();
    }

    public function loadStats()
    {
        $this->stats = [
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'active_orders' => Order::whereIn('status', ['pending', 'processing', 'shipped'])->count(),
            'avg_order_value' => Order::avg('total_amount') ?? 0,
            'conversion_rate' => $this->calculateConversionRate(),
            'revenue_change' => 12,
            'orders_change' => 5,
        ];
    }

    private function calculateConversionRate()
    {
        $totalUsers = User::count();
        if ($totalUsers === 0)
            return 0;
        $orderCount = Order::count();
        return round(($orderCount / $totalUsers) * 100, 1);
    }

    public function loadTrends()
    {
        $trends = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $this->salesTrend = [
            'labels' => $trends->pluck('date')->map(fn($d) => Carbon::parse($d)->format('D'))->toArray(),
            'data' => $trends->pluck('total')->toArray(),
        ];

        if (empty($this->salesTrend['data'])) {
            $this->salesTrend = [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'data' => [0, 0, 0, 0, 0, 0, 0]
            ];
        }
    }

    public function loadStyles()
    {
        $styles = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.aesthetic', DB::raw('SUM(order_items.quantity) as total'))
            ->groupBy('products.aesthetic')
            ->get();

        $this->styleDistribution = [
            'labels' => $styles->pluck('aesthetic')->map(fn($s) => ucfirst($s))->toArray(),
            'data' => $styles->pluck('total')->toArray(),
        ];

        if (empty($this->styleDistribution['data'])) {
            $this->styleDistribution = [
                'labels' => ['Soft', 'Alt', 'Luxury', 'Mix'],
                'data' => [1, 1, 1, 1]
            ];
        }
    }



    public function loadInsights()
    {
        // Customer of the Month (Highest spender this month)
        // Two-step approach to avoid strict group by issues
        $topSpenderStats = Order::select('user_id', DB::raw('SUM(total_amount) as monthly_spend'))
            ->where('payment_status', 'paid')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('user_id')
            ->orderByDesc('monthly_spend')
            ->first();

        if ($topSpenderStats) {
            $this->customerOfTheMonth = User::find($topSpenderStats->user_id);
            if ($this->customerOfTheMonth) {
                $this->customerOfTheMonth->monthly_spend = $topSpenderStats->monthly_spend;
            }
        }

        // Best Seller (Most quantity sold last 30 days)
        $bestSellerStats = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'paid')
            ->where('orders.created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->first();

        if ($bestSellerStats) {
            $this->bestSeller = Product::find($bestSellerStats->product_id);
            if ($this->bestSeller) {
                $this->bestSeller->total_sold = $bestSellerStats->total_sold;
            }
        }

        // Recent Purchases
        $this->recentPurchases = Order::with('user')
            ->where('payment_status', 'paid')
            ->latest()
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
