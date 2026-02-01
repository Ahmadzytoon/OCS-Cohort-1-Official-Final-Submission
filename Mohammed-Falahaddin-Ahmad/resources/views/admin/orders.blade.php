@extends('layouts.admin')
@section('title', 'Order Management')
@section('page-title', 'Order Management')

@section('content')
<div class="table-container">
    <div class="table-header">
        <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i> Order Management</h5>
    </div>
    
    <div style="padding: 0 2rem;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Filters -->
        <form method="GET" action="{{ route('admin.orders.index') }}" class="row mb-4 g-3">
            <div class="col-md-3">
                <select class="form-select" name="status">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control" name="from_date" value="{{ request('from_date') }}" placeholder="From Date">
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}" placeholder="To Date">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Order ID or Customer">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary me-1">Filter</button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->order_id }}</td>
                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                    <td>{{ $order->orderItems->count() }}</td>
                    <td>${{ number_format($order->total_amount, 2) }}</td>
                    <td><span class="badge {{ $order->status_badge_class }}">{{ $order->status_label }}</span></td>
                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info action-btn">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if($order->order_status == 'pending')
                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="order_status" value="delivered">
                                <button type="submit" class="btn btn-sm btn-success action-btn" 
                                        onclick="return confirm('Mark this order as delivered?')">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                        @endif
                        <button class="btn btn-sm btn-primary action-btn" onclick="window.print()">
                            <i class="fas fa-print"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No orders found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $orders->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto-dismiss success alert after 3 seconds
document.addEventListener('DOMContentLoaded', function() {
    const successAlert = document.getElementById('success-alert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.classList.remove('show');
            successAlert.classList.add('fade');
            setTimeout(() => successAlert.remove(), 150);
        }, 3000);
    }
});
</script>
@endpush