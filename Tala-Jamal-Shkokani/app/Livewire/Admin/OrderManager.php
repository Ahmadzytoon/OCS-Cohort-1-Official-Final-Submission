<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use Livewire\WithPagination;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
#[Title('Operations Control')]
class OrderManager extends Component
{
    use WithPagination;

    #[Url(as: 'search')]
    public $search = '';

    #[Url(as: 'status')]
    public $statusFilter = '';

    #[Url(as: 'date')]
    public $dateFilter = 'all'; // all, today, week, month, year

    public $minAmount = '';
    public $maxAmount = '';

    public $selectedOrder = null;
    public $showDetails = false;

    // Sorting properties
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // Bulk selection
    public $selectAll = false;
    public $selectedRows = [];

    protected $paginationTheme = 'bootstrap';

    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedStatusFilter()
    {
        $this->resetPage();
    }
    public function updatedDateFilter()
    {
        $this->resetPage();
    }
    public function updatedMinAmount()
    {
        $this->resetPage();
    }
    public function updatedMaxAmount()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter', 'dateFilter', 'minAmount', 'maxAmount']);
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedRows = Order::pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedRows = [];
        }
    }

    public function bulkUpdateStatus($status)
    {
        if (empty($this->selectedRows))
            return;
        Order::whereIn('id', $this->selectedRows)->update(['status' => $status]);
        $this->selectedRows = [];
        $this->selectAll = false;
        $this->dispatch('swal:success', ['title' => 'Bulk Update', 'text' => 'Orders updated successfully.', 'icon' => 'success']);
    }

    public function bulkDelete()
    {
        if (empty($this->selectedRows))
            return;
        Order::whereIn('id', $this->selectedRows)->delete();
        $this->selectedRows = [];
        $this->selectAll = false;
        $this->dispatch('swal:success', ['title' => 'Bulk Delete', 'text' => 'Orders moved to trash.', 'icon' => 'success']);
    }

    public function updateStatus($orderId, $status)
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status' => $status]);
        if ($this->selectedOrder && $this->selectedOrder->id == $orderId) {
            $this->selectedOrder = $order->fresh(['user', 'items.product']);
        }
        $this->dispatch('swal:success', ['title' => 'Status Updated', 'text' => 'Order updated.', 'icon' => 'success']);
    }

    public function viewDetails($orderId)
    {
        $this->selectedOrder = Order::with(['user', 'items.product'])->findOrFail($orderId);
        $this->showDetails = true;
    }

    public function deleteOrder($orderId)
    {
        Order::findOrFail($orderId)->delete();
        $this->dispatch('swal:success', ['title' => 'Deleted', 'text' => 'Order removed.', 'icon' => 'success']);
    }

    public function render()
    {
        $query = Order::with('user');

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('order_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($uq) {
                        $uq->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Filters
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        // Date Filter
        if ($this->dateFilter !== 'all') {
            $query->where('created_at', '>=', match ($this->dateFilter) {
                'today' => Carbon::today(),
                'week' => Carbon::now()->subDays(7),
                'month' => Carbon::now()->subMonth(),
                'year' => Carbon::now()->subYear(),
            });
        }

        // Amount Filter
        if ($this->minAmount)
            $query->where('total_amount', '>=', $this->minAmount);
        if ($this->maxAmount)
            $query->where('total_amount', '<=', $this->maxAmount);

        $orders = $query->orderBy($this->sortField, $this->sortDirection)->paginate(10);

        $counts = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
        ];

        return view('livewire.admin.order-manager', [
            'orders' => $orders,
            'counts' => $counts
        ]);
    }
}
