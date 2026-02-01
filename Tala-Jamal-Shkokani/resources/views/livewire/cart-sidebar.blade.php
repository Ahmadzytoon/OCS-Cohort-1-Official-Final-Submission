<div class="offcanvas offcanvas-end" tabindex="-1" id="cartSidebar" aria-labelledby="cartSidebarLabel" wire:ignore.self>
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title font-heading fw-bold ls-1" id="cartSidebarLabel">YOUR BAG</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column h-100">
        @if(count($cart) > 0)
            <div class="flex-grow-1 overflow-auto pe-2">
                <div class="d-flex flex-column gap-4">
                    @foreach($cart as $item)
                        <div class="d-flex gap-3 align-items-start border-bottom pb-4">
                            <div class="position-relative">
                                <a href="{{ route('shop.show', $item['id']) }}">
                                    <img src="{{ $item['image'] ?? 'https://via.placeholder.com/60' }}" alt="{{ $item['name'] }}"
                                        class="rounded-4 shadow-sm object-fit-cover" style="width: 80px; height: 100px;">
                                </a>
                                @if($item['out_of_stock'])
                                    <span class="position-absolute top-0 start-0 badge bg-danger m-1" style="font-size: 0.6rem;">Sold Out</span>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h6 class="mb-1 font-heading fw-bold text-uppercase text-truncate" style="max-width: 140px;">
                                        <a href="{{ route('shop.show', $item['id']) }}" class="text-decoration-none text-dark">{{ $item['name'] }}</a>
                                    </h6>
                                    <button class="btn btn-link text-muted extra-small p-0 text-decoration-none text-uppercase ls-1 hover-text-dark"
                                        wire:click="removeFromCart({{ $item['item_id'] }})">Remove</button>
                                </div>
                                
                                <p class="mb-2 text-dark small">{{ number_format((float) $item['price'], 0) }} JOD</p>
                                
                                <div class="d-flex gap-2 mb-3">
                                    @if(isset($item['size']) && $item['size'])
                                        <span class="badge bg-light text-dark border fw-normal" style="font-size: 0.65rem;">
                                            {{ $item['size'] }}
                                        </span>
                                    @endif
                                    @if(isset($item['color']) && $item['color'])
                                        <div class="rounded-circle border"
                                            style="width: 14px; height: 14px; background-color: {{ $item['color'] }};"
                                            title="Color: {{ $item['color'] }}"></div>
                                    @endif
                                </div>

                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-center border rounded-pill px-2 py-1" style="width: fit-content; max-width: 120px;">
                                        <button class="btn btn-link text-dark p-0 px-2 text-decoration-none quantity-btn-sidebar" wire:click="decrement({{ $item['item_id'] }})">-</button>
                                        <span class="px-2 fw-bold" style="font-size: 0.9rem; min-width: 25px; text-align: center;">{{ $item['quantity'] }}</span>
                                        <button class="btn btn-link text-dark p-0 px-2 text-decoration-none quantity-btn-sidebar" wire:click="increment({{ $item['item_id'] }})" @if($item['out_of_stock']) disabled @endif>+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if(count($recommendations) > 0)
                <div class="mt-5 pt-2">
                    <p class="small text-uppercase fw-bold ls-2 mb-3 text-muted">Complete The Look</p>
                    <div class="row g-3">
                        @foreach($recommendations as $rec)
                            <div class="col-4">
                                <a href="{{ route('shop.show', $rec->id) }}" class="text-decoration-none group">
                                    <div class="position-relative mb-2 overflow-hidden rounded-3">
                                        <img src="{{ $rec->image ?? ($rec->images->first()?->url ?? asset('images/placeholder.jpg')) }}"
                                            class="w-100 shadow-sm transition-premium group-hover-scale" style="height: 120px; object-fit: cover;">
                                    </div>
                                    <p class="extra-small text-dark text-truncate mb-0 fw-bold">{{ $rec->name }}</p>
                                    <p class="extra-small text-muted mb-0">
                                        @if($rec->hasDiscount())
                                            <span class="text-dark">{{ number_format($rec->discounted_price, 0) }} JOD</span>
                                        @else
                                            {{ number_format($rec->price, 0) }} JOD
                                        @endif
                                    </p>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <div class="mt-auto pt-4 bg-white border-top">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-uppercase small fw-bold">Subtotal</span>
                    <span class="fw-bold font-heading">{{ number_format((float) $total, 0) }} JOD</span>
                </div>
                <p class="text-muted extra-small mb-4">Shipping & taxes calculated at checkout.</p>
                <div class="d-grid">
                    <button wire:click="checkout" class="btn btn-primary-custom py-3 rounded-pill text-uppercase ls-1 fw-bold">
                        Proceed to Checkout
                    </button>
                </div>
            </div>
        @else
            <div class="h-100 d-flex flex-column align-items-center justify-content-center text-center">
                <div class="mb-4 p-4 rounded-circle bg-light text-muted">
                    <i class="fa-solid fa-bag-shopping fa-2x"></i>
                </div>
                <h5 class="font-heading fw-bold mb-2">Your Bag is Empty</h5>
                <p class="text-muted small mb-4 px-4">Looks like you haven't found your perfect match yet.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-outline-dark rounded-pill px-4 py-2 text-uppercase ls-1 extra-small fw-bold">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>

    <style>
        .quantity-btn-sidebar {
            opacity: 1 !important;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.2s ease;
        }

        .quantity-btn-sidebar:hover {
            transform: scale(1.2);
            color: #000 !important;
        }

        .quantity-btn-sidebar:disabled {
            opacity: 0.5 !important;
            cursor: not-allowed;
        }
    </style>
</div>