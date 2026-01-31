t<div class="container py-5 animate-fade-in" style="min-height: 70vh;">
    <div class="text-center mb-5">
        <span class="text-muted small text-uppercase ls-1">Your Selection</span>
        <h1 class="display-5 font-heading fw-bold" style="font-family: 'Playfair Display', serif;">Shopping Bag</h1>
    </div>

    @if(count($cart) > 0)
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="bg-light">
                                    <tr class="text-uppercase small ls-1">
                                        <th class="ps-4 py-3 border-0">Product</th>
                                        <th class="py-3 border-0">Price</th>
                                        <th class="py-3 border-0 text-center">Quantity</th>
                                        <th class="pe-4 py-3 border-0 text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $cartKey => $item)
                                        <tr class="border-bottom">
                                            <td class="ps-4 py-4">
                                                <div class="d-flex align-items-center">
                                                    <a href="{{ route('shop.show', ['id' => $item['id']]) }}">
                                                        <img src="{{ $item['image'] ?? 'https://via.placeholder.com/80' }}"
                                                            alt="{{ $item['name'] }}" class="rounded-3 shadow-sm me-3"
                                                            style="width: 80px; height: 100px; object-fit: cover;">
                                                    </a>
                                                    <div>
                                                        <h6 class="mb-1 fw-bold text-uppercase" style="font-size: 0.9rem;">
                                                            {{ $item['name'] }}
                                                        </h6>
                                                        @if(isset($item['out_of_stock']) && $item['out_of_stock'])
                                                            <div class="text-danger small fw-bold mb-2">
                                                                <i class="fa-solid fa-circle-exclamation me-1"></i> Currently Sold
                                                                Out
                                                            </div>
                                                        @elseif(isset($item['stock_capped']) && $item['stock_capped'])
                                                            <div class="text-warning small fw-bold mb-2">
                                                                <i class="fa-solid fa-triangle-exclamation me-1"></i> Quantities
                                                                adjusted to available stock
                                                            </div>
                                                        @endif
                                                        @if((isset($item['size']) && $item['size']) || (isset($item['color']) && $item['color']))
                                                            <div class="d-flex gap-2 align-items-center mb-2">
                                                                @if(isset($item['size']) && $item['size'])
                                                                    <span class="badge bg-light text-dark border px-2 py-1"
                                                                        style="font-size: 0.65rem;">SIZE: {{ $item['size'] }}</span>
                                                                @endif
                                                                @if(isset($item['color']) && $item['color'])
                                                                    <div class="rounded-circle border"
                                                                        style="width: 14px; height: 14px; background-color: {{ $item['color'] }};"
                                                                        title="Color: {{ $item['color'] }}"></div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        <button wire:click="removeFromCart('{{ $cartKey }}')"
                                                            class="btn btn-link text-danger p-0 text-decoration-none small">
                                                            <i class="fa-regular fa-trash-can me-1"></i> Remove
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 fw-medium">
                                                @if(isset($item['has_discount']) && $item['has_discount'])
                                                    <div class="d-flex flex-column">
                                                        <span class="text-dark">{{ number_format((float) $item['price'], 0) }} JOD</span>
                                                        <span class="text-muted text-decoration-line-through extra-small">{{ number_format((float) $item['original_price'], 0) }} JOD</span>
                                                    </div>
                                                @else
                                                    {{ number_format((float) $item['price'], 0) }} JOD
                                                @endif
                                            </td>
                                            <td class="py-4">
                                                <div class="d-flex align-items-center border rounded-pill px-2 py-1 mx-auto"
                                                    style="width: fit-content; max-width: 120px;">
                                                    <button class="btn btn-link text-dark p-0 px-2 text-decoration-none quantity-btn"
                                                        wire:click="decrement('{{ $cartKey }}')">-</button>
                                                    <span class="px-2 fw-bold"
                                                        style="font-size: 0.9rem; min-width: 25px; text-align: center;">{{ $item['quantity'] }}</span>
                                                    <button class="btn btn-link text-dark p-0 px-2 text-decoration-none quantity-btn"
                                                        wire:click="increment('{{ $cartKey }}')">+</button>
                                                </div>
                                            </td>
                                            <td class="pe-4 py-4 text-end fw-bold">
                                                {{ number_format((float) $item['price'] * $item['quantity'], 0) }} JOD
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('shop.index') }}" class="text-dark text-decoration-none small fw-bold">
                        <i class="fa-solid fa-arrow-left me-2"></i> Continue Shopping
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 bg-white sticky-top" style="top: 100px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4 text-uppercase ls-1" style="font-size: 1rem;">Order Summary</h5>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold">{{ number_format((float) $total, 0) }} JOD</span>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted">Shipping</span>
                            <span class="text-success small fw-medium">Free (Amman)</span>
                        </div>

                        <div class="border-top pt-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold fs-5">Estimated Total</span>
                                <span class="fw-bold fs-4 text-dark">{{ number_format($total, 0) }} JOD</span>
                            </div>
                            <p class="text-muted extra-small" style="font-size: 0.7rem;">Taxes and international shipping
                                calculated at checkout.</p>
                        </div>

                        @php
                            $hasOutOfStock = collect($cart)->contains('out_of_stock', true);
                        @endphp

                        <div class="d-grid gap-3">
                            @if($hasOutOfStock)
                                <button class="btn btn-secondary py-3 rounded-pill text-uppercase ls-1 fw-bold disabled"
                                    disabled>
                                    Review Selection to Proceed
                                </button>
                                <p class="text-danger extra-small text-center opacity-75">Some items in your bag are currently
                                    unavailable.</p>
                            @else
                                <button wire:click="checkout"
                                    class="btn btn-dark py-3 rounded-pill text-uppercase ls-1 fw-bold">Proceed to
                                    Checkout</button>
                            @endif
                        </div>

                        <div class="mt-4 pt-4 border-top text-center">
                            <div class="d-flex justify-content-center gap-3 opacity-50">
                                <i class="fa-brands fa-cc-visa fa-2x"></i>
                                <i class="fa-brands fa-cc-mastercard fa-2x"></i>
                                <i class="fa-brands fa-cc-apple-pay fa-2x"></i>
                            </div>
                            <p class="text-muted small mt-3 mb-0">
                                <i class="fa-solid fa-lock me-1"></i> SSL 128-bit Secure Checkout
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-5 py-5">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center"
                        style="width: 100px; height: 100px;">
                        <i class="fa-solid fa-bag-shopping fa-3x text-muted opacity-50"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-3">Your Bag is Empty</h3>
                <p class="text-muted mb-5 mx-auto" style="max-width: 400px;">Discover the latest curation of luxury pieces
                    tailored for your unique persona.</p>
                <a href="{{ route('shop.index') }}"
                    class="btn btn-dark rounded-pill px-5 py-3 text-uppercase ls-1 fw-bold">Explore the Shop</a>
            </div>
        </div>
    @endif
    <style>
        .extra-small {
            font-size: 0.75rem;
        }

        .sticky-top {
            z-index: 10;
        }

        table th {
            font-weight: 600;
            color: #666;
        }

        .quantity-btn {
            opacity: 1 !important;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.2s ease;
        }

        .quantity-btn:hover {
            transform: scale(1.2);
            color: #000 !important;
        }
    </style>
</div>