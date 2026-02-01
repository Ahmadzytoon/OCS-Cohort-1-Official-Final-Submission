    @extends('layouts.user')
    @section('content')
    <div class="container py-5">
        <div class="section-title text-center mb-5">
            <h2>My Orders</h2>
            <p>Track your recent purchases</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>{{ $order->items->count() }} item(s)</td>
                                <td class="fw-bold">${{ number_format($order->total_amount ?? 0, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'processing' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($order->status ?? 'pending') }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('user.order.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-box-open fa-3x text-muted"></i>
                </div>
                <h4>No orders yet</h4>
                <p class="text-muted mb-4">Start shopping to see your orders here</p>
                <a href="{{ route('user.shop') }}" class="theme-btn">
                    <i class="fas fa-book-reader me-1"></i> Browse Books
                </a>
            </div>
        @endif
    </div>
    @endsection

    @push('styles')
    <link rel="stylesheet" href="{{ asset('assets/user/css/orders.css') }}">
    @endpush