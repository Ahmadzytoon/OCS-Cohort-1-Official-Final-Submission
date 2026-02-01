@extends('layouts.user')

@section('content')

<!-- Cursor follower -->
<div class="cursor-follower"></div>

<!-- Breadcrumb Section Start -->
<div class="breadcrumb-wrapper bg-cover section-padding"
    style="background-image: url({{ asset('assets/user/images/hero/breadcrumb-bg.jpg') }});">
    <div class="container">
        <div class="page-heading">
            <h1>Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h1>
            <div class="page-header">
                <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".3s">
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li><i class="fa-solid fa-chevron-right"></i></li>
                    <li><a href="{{ route('user.orders') }}">My Orders</a></li>
                    <li><i class="fa-solid fa-chevron-right"></i></li>
                    <li>Order Details</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Order Details Section Start -->
<section class="order-details-section section-padding">
    <div class="container">
        <div class="row g-5">
            <!-- Left: Order Items -->
            <div class="col-lg-8">
                <div class="order-card shadow-sm mb-4">
                    <div class="card-header-premium">
                        <h4 class="mb-0"><i class="fas fa-shopping-basket me-2"></i> Your Ordered Books</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table order-table mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4">Product</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th class="pe-4 text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="book-mini-thumb">
                                                        <img src="{{ $item->book->cover_image ? asset('uploads/books/' . $item->book->cover_image) : asset('assets/user/images/book/placeholder.png') }}" 
                                                             alt="{{ $item->book->title }}">
                                                    </div>
                                                    <div class="book-info ms-3">
                                                        <h6 class="mb-0">{{ $item->book->title }}</h6>
                                                        <small class="text-muted">{{ optional($item->book->author)->name ?? 'Author' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle fw-semibold">${{ number_format($item->price, 2) }}</td>
                                            <td class="align-middle">{{ $item->quantity }}</td>
                                            <td class="align-middle pe-4 text-end fw-bold text-dark">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer-premium text-end p-4">
                        <div class="total-row d-flex justify-content-end align-items-center">
                            <span class="text-muted me-3">Total Amount</span>
                            <h3 class="total-amount mb-0">${{ number_format($order->total_amount ?? 0, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Order Status Card -->
                <div class="order-summary-card shadow-sm mb-4">
                    <div class="card-header-premium">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Order Status</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="status-timeline">
                            <div class="status-item d-flex justify-content-between mb-3">
                                <span class="text-muted">Order ID:</span>
                                <span class="fw-bold">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="status-item d-flex justify-content-between mb-3">
                                <span class="text-muted">Date:</span>
                                <span class="fw-bold">{{ $order->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="status-item d-flex justify-content-between mb-3">
                                <span class="text-muted">Status:</span>
                                <span class="badge badge-premium bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'processing' ? 'warning' : 'info') }}">
                                    {{ strtoupper($order->status ?? 'pending') }}
                                </span>
                            </div>
                            <hr class="my-3">
                            <div class="status-item d-flex justify-content-between mb-2">
                                <span class="text-muted">Payment:</span>
                                <span class="fw-bold">{{ $order->payment->payment_method ?? 'N/A' }}</span>
                            </div>
                            <div class="status-item d-flex justify-content-between">
                                <span class="text-muted">Payment status:</span>
                                <span class="text-{{ $order->payment && $order->payment->status === 'completed' ? 'success' : 'danger' }} fw-bold">
                                    {{ strtoupper($order->payment->status ?? 'pending') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Card -->
                @if($order->shippingAddress)
                <div class="order-summary-card shadow-sm p-4">
                    <h5 class="mb-4"><i class="fas fa-shipping-fast me-2 text-pink"></i> Shipping To</h5>
                    <div class="address-details">
                        <h6 class="fw-bold mb-2">{{ $order->shippingAddress->full_name }}</h6>
                        <p class="mb-1 text-muted"><i class="fas fa-map-marker-alt me-2"></i> {{ $order->shippingAddress->address_line1 }}</p>
                        @if($order->shippingAddress->address_line2)
                            <p class="mb-1 text-muted ms-4">{{ $order->shippingAddress->address_line2 }}</p>
                        @endif
                        <p class="mb-1 text-muted ms-4">{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }} {{ $order->shippingAddress->postal_code }}</p>
                        <p class="mb-3 text-muted ms-4">{{ $order->shippingAddress->country }}</p>
                        <p class="mb-0"><i class="fas fa-phone me-2 text-pink"></i> <strong>{{ $order->shippingAddress->phone }}</strong></p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/user/css/order-show.css') }}">
@endpush

@endsection