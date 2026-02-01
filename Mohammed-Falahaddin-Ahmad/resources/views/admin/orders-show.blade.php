@extends('layouts.admin')
@section('title', 'Order Details: ' . $order->order_id)
@section('page-title', 'Order Details')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Order Details - {{ $order->order_id }}</h5>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back to Orders</a>
    </div>
    <div class="card-body">
        <!-- Order Summary -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h6>Customer Information</h6>
                <p><strong>Name:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $order->user->phone ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6">
                <h6>Shipping Address</h6>
                <p>{{ $order->address->street ?? 'N/A' }}</p>
                <p>{{ $order->address->city ?? 'N/A' }}, {{ $order->address->state ?? 'N/A' }} {{ $order->address->zip_code ?? 'N/A' }}</p>
                <p><strong>Country:</strong> {{ $order->address->country ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- Order Status -->
        <div class="row mb-4">
            <div class="col-md-12">
                <h6>Order Status</h6>
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <select name="order_status" class="form-select d-inline w-auto" onchange="this.form.submit()">
                        <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </form>
                <span class="badge {{ $order->status_badge_class }} ms-2">{{ $order->status_label }}</span>
            </div>
        </div>

        <!-- Order Items -->
        <div class="row mb-4">
            <div class="col-md-12">
                <h6>Order Items</h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Book</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->book->title ?? 'N/A' }}</td>
                            <td>{{ $item->book->author->name ?? 'N/A' }}</td>
                            <td>{{ $item->book->category->name ?? 'N/A' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price_at_time, 2) }}</td>
                            <td>${{ number_format($item->price_at_time * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-end">Total Amount:</th>
                            <th>${{ number_format($order->total_amount, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Order Actions -->
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary" onclick="window.print()"><i class="fas fa-print me-2"></i>Print Invoice</button>
                @if($order->order_status == 'pending')
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="order_status" value="delivered">
                        <button type="submit" class="btn btn-success" onclick="return confirm('Mark this order as delivered?')">
                            <i class="fas fa-check me-2"></i>Mark as Delivered
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection