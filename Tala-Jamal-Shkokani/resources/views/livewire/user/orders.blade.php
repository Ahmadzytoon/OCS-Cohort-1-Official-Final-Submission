<div class="container py-5 animate-fade-up">
    <div class="mb-5">
        <span class="text-muted extra-small text-uppercase ls-1">Order History</span>
        <h1 class="display-5 font-heading fw-bold">Your Archive</h1>
    </div>

    @if($orders->count() > 0)
        <div class="row g-4">
            @foreach($orders as $order)
                <div class="col-12" x-data="{ expanded: false }">
                    <div class="card card-premium overflow-hidden" :class="expanded ? 'shadow-lg' : ''">
                        <div class="card-body p-0">
                            <div class="row g-0 cursor-pointer" @click="expanded = !expanded">
                                <!-- Order Summary Info -->
                                <div class="col-md-4 p-4 bg-light border-end d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <span class="text-muted extra-small text-uppercase ls-1 d-block">Order Number</span>
                                                <h6 class="fw-bold mb-0">#{{ $order->order_number }}</h6>
                                            </div>
                                            <span class="badge rounded-pill px-3 py-2 status-{{ $order->status }}">
                                                {{ strtoupper($order->status) }}
                                            </span>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <span class="text-muted extra-small text-uppercase ls-1 d-block">Purchased On</span>
                                            <p class="mb-0 small fw-medium">{{ $order->created_at->format('M d, Y') }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <span class="text-muted extra-small text-uppercase ls-1 d-block">Payment Method</span>
                                            <p class="mb-0 small fw-medium text-capitalize">
                                                {{ $order->payment_method === 'card' ? 'Visa •••• 4242' : 'Cash on Delivery' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="pt-4 border-top">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold text-uppercase small ls-1">Total Amount</span>
                                            <span class="h4 mb-0 fw-bold">{{ number_format($order->total_amount, 0) }} JOD</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Items List (Condensed View) -->
                                <div class="col-md-8 p-4 position-relative">
                                    <h6 class="text-uppercase small ls-1 fw-bold mb-4">Items ({{ $order->items->count() }})</h6>
                                    <div class="d-flex flex-column gap-3">
                                        @foreach($order->items as $item)
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="{{ $item->product->image ?? 'https://via.placeholder.com/60' }}" 
                                                         class="rounded-3 object-fit-cover shadow-sm" 
                                                         style="width: 50px; height: 65px;"
                                                         alt="{{ $item->product->name }}">
                                                    <div>
                                                        <p class="mb-0 fw-bold small text-uppercase">{{ $item->product->name }}</p>
                                                        <div class="d-flex gap-2 align-items-center">
                                                            @if($item->size)
                                                                <span class="extra-small text-muted">Size: {{ $item->size }}</span>
                                                            @endif
                                                            @if($item->color)
                                                                <div class="rounded-circle border" style="width: 10px; height: 10px; background-color: {{ $item->color }};"></div>
                                                            @endif
                                                            <span class="extra-small text-muted">× {{ $item->quantity }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <span class="small fw-bold d-block">{{ number_format($item->price, 0) }} JOD</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-4 pt-4 border-top d-flex gap-2 justify-content-end align-items-center">
                                        <button class="btn btn-premium-outline btn-sm py-2 px-3" @click.stop="expanded = !expanded">
                                            <i class="fa-solid" :class="expanded ? 'fa-chevron-up' : 'fa-list-ul'"></i> 
                                            <span x-text="expanded ? 'Hide Details' : 'View Items'"></span>
                                        </button>
                                        <button class="btn btn-premium-outline btn-sm py-2 px-3" wire:click="showReceipt({{ $order->id }})" @click.stop>
                                            <i class="fa-solid fa-file-invoice me-1"></i> Receipt
                                        </button>
                                        <a href="{{ route('checkout.success', $order->id) }}" class="btn btn-premium btn-sm py-2 px-4 shadow-none" @click.stop>
                                            Track
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Drawn Down Details -->
                            <div x-show="expanded" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 class="p-4 bg-white border-top border-light"
                                 x-cloak>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="p-4 rounded-4 bg-light h-100">
                                            <h6 class="text-uppercase small ls-1 fw-bold mb-3"><i class="fa-solid fa-truck-fast me-2"></i> Shipping Bag</h6>
                                            <p class="mb-1 small fw-bold">Address:</p>
                                            <p class="text-muted small mb-3">{{ $order->shipping_address }}</p>
                                            
                                            <p class="mb-1 small fw-bold">Tracking Number:</p>
                                            <p class="text-muted small mb-0 font-monospace">{{ $order->tracking_number ?? 'Assigning...' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-4 rounded-4 bg-light h-100">
                                            <h6 class="text-uppercase small ls-1 fw-bold mb-3"><i class="fa-solid fa-clock me-2"></i> Est. Delivery</h6>
                                            <p class="text-muted small mb-0">Our courier curated for {{ $order->shipping_address }} will typically arrive within 24-48 hours.</p>
                                            <div class="mt-3">
                                                <span class="badge bg-dark rounded-pill px-3 py-2" style="font-size: 0.7rem;">Expected: {{ $order->created_at->addDays(2)->format('M d') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Receipt Drawer (Offcanvas) -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="receiptDrawer" aria-labelledby="receiptDrawerLabel" style="width: 450px;">
            <div class="offcanvas-header border-bottom py-3">
                <h5 class="offcanvas-title font-heading fw-bold ls-1" id="receiptDrawerLabel">OFFICIAL RECEIPT</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-0">
                @if($selectedOrder)
                    <div class="p-5 receipt-content" id="printableReceipt">
                        <div class="text-center mb-5">
                            <h2 class="mb-1 font-heading ls-2 fw-bold" style="font-family: 'Playfair Display', serif;">CHIC & CO.</h2>
                            <p class="extra-small text-muted text-uppercase mb-4">Luxury Curation • Amman, Jordan</p>
                            <div class="receipt-divider my-4"></div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-6">
                                <span class="text-muted extra-small text-uppercase ls-1">Receipt No.</span>
                                <p class="small fw-bold">{{ $selectedOrder->order_number }}</p>
                            </div>
                            <div class="col-6 text-end">
                                <span class="text-muted extra-small text-uppercase ls-1">Date</span>
                                <p class="small fw-bold">{{ $selectedOrder->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        <div class="mb-4 pb-4 border-bottom border-dashed">
                            <span class="text-muted extra-small text-uppercase ls-1 mb-3 d-block">Purchased Elements</span>
                            @foreach($selectedOrder->items as $item)
                                <div class="d-flex justify-content-between mb-3">
                                    <div style="max-width: 250px;">
                                        <p class="mb-0 small fw-bold text-uppercase">{{ $item->product->name }}</p>
                                        <div class="d-flex align-items-center gap-2">
                                            <p class="extra-small text-muted mb-0">Qty: {{ $item->quantity }}</p>
                                            @if($item->size) <span class="extra-small text-muted">| Size: {{ $item->size }}</span> @endif
                                            @if($item->color) 
                                                <span class="extra-small text-muted">| Color: </span>
                                                <div class="rounded-circle border" style="width: 8px; height: 8px; background-color: {{ $item->color }};"></div>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="small fw-bold">{{ number_format($item->price * $item->quantity, 0) }} JOD</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="mb-5">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small text-muted">Subtotal</span>
                                <span class="small">{{ number_format($selectedOrder->total_amount, 0) }} JOD</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small text-muted">Concierge Shipping</span>
                                <span class="small text-success">Complimentary</span>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <span class="fw-bold text-uppercase ls-1">Total Amount</span>
                                <span class="h4 mb-0 fw-bold">{{ number_format($selectedOrder->total_amount, 0) }} JOD</span>
                            </div>
                        </div>

                        <div class="p-4 rounded-4 bg-light mb-5">
                            <div class="mb-3">
                                <span class="text-muted extra-small text-uppercase ls-1">Payment Descriptor</span>
                                <p class="small mb-0 fw-bold text-capitalize">{{ $selectedOrder->payment_method }} Experience</p>
                            </div>
                            <div>
                                <span class="text-muted extra-small text-uppercase ls-1">Billed To</span>
                                <p class="small mb-0 fw-bold text-uppercase">{{ $selectedOrder->user->name ?? 'Luxury Guest' }}</p>
                            </div>
                        </div>

                        <div class="text-center pt-4 opacity-50">
                            <p class="extra-small mb-1">Thank you for choosing Chic & Co.</p>
                            <p class="extra-small">Your aesthetic journey continues at chic-co.luxury</p>
                        </div>
                    </div>
                    
                    <div class="p-4 border-top bg-white sticky-bottom">
                        <button class="btn btn-dark w-100 py-3 rounded-pill text-uppercase ls-1 fw-bold" onclick="window.print()">
                            <i class="fa-solid fa-print me-2"></i> Print Archive Copy
                        </button>
                    </div>
                @else
                    <div class="h-100 d-flex flex-column align-items-center justify-content-center opacity-50">
                        <i class="fa-solid fa-spinner fa-spin fa-2x mb-3"></i>
                        <p class="extra-small text-uppercase ls-1">Curating Your Receipt...</p>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="py-5 text-center bg-light rounded-5 border-dashed">
            <div class="mb-4">
                <i class="fa-thin fa-scroll fa-4x text-muted opacity-50"></i>
            </div>
            <h4 class="fw-bold mb-3">No Orders Yet</h4>
            <p class="text-muted mb-4">You haven't archived any luxury pieces yet. Start your journey in the shop.</p>
            <a href="{{ route('shop.index') }}" class="btn btn-dark rounded-pill px-5 py-3 text-uppercase ls-1 fw-bold">Discover Collections</a>
        </div>
    @endif

    <script>
        document.addEventListener('livewire:initialized', () => {
            const receiptModal = new bootstrap.Offcanvas(document.getElementById('receiptDrawer'));
            
            Livewire.on('open-receipt-drawer', () => {
                receiptModal.show();
            });
        });
    </script>

    <style>
        .order-receipt-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .order-receipt-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important;
        }
        .extra-small {
            font-size: 0.7rem;
        }
        .ls-2 { letter-spacing: 2px; }
        .status-pending { background: #fff3cd; color: #856404; font-size: 0.65rem; }
        .status-confirmed { background: #d1ecf1; color: #0c5460; font-size: 0.65rem; }
        .status-shipped { background: #d4edda; color: #155724; font-size: 0.65rem; }
        .status-delivered { background: #000; color: #fff; font-size: 0.65rem; }
        
        .border-dashed {
            border-bottom-style: dashed !important;
        }
        .receipt-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #eee, transparent);
        }
        .border-dashed {
            border-bottom: 2px dashed #eee;
        }
        
        @media print {
            body * { visibility: hidden; }
            #printableReceipt, #printableReceipt * { visibility: visible; }
            #printableReceipt { position: absolute; left: 0; top: 0; width: 100%; }
        }
    </style>
</div>
