<div>
    @forelse($orders as $order)
        <div class="card card-custom border-0 shadow-sm mb-4 overflow-hidden animate-fade-in">
            <div class="row g-0">
                <div class="col-md-3">
                    <img src="{{ $order->items->first()->product->image ?? 'https://via.placeholder.com/400' }}"
                        class="h-100 w-100 object-fit-cover" alt="Item">
                </div>
                <div class="col-md-9">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="mb-1 fw-bold text-uppercase" style="font-size: 1rem;">Order
                                    #{{ $order->order_number }}</h5>
                                <p class="text-muted small mb-0">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                            <span class="badge rounded-pill px-3 py-2 status-{{ $order->status }}"
                                style="font-size: 0.65rem;">
                                {{ strtoupper($order->status) }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <ul class="list-unstyled small mb-0">
                                @foreach($order->items as $item)
                                    <li class="text-muted">• {{ $item->product->name }} (@if($item->size){{ $item->size }}@endif
                                        @if($item->color)<span class="d-inline-block rounded-circle border ms-1"
                                        style="width: 8px; height: 8px; background-color: {{ $item->color }};"></span>@endif)
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="d-flex justify-content-between align-items-end pt-3 border-top">
                            <div>
                                <span class="text-muted extra-small d-block text-uppercase ls-1"
                                    style="font-size: 0.6rem;">Total Paid</span>
                                <span class="fw-bold fs-5">{{ number_format($order->total_amount, 0) }} JOD</span>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-dark px-3 rounded-pill"
                                    onclick="triggerReviewModal('{{ $order->items->first()->product->name }}')">
                                    <i class="fa-regular fa-star me-1"></i> Review
                                </button>
                                <button class="btn btn-sm btn-dark px-3 rounded-pill"
                                    wire:click="reorder({{ $order->id }})">
                                    <i class="fa-solid fa-rotate-right me-1"></i> Order Again
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5 bg-light rounded-4">
            <p class="text-muted mb-0">No recent discoveries yet.</p>
        </div>
    @endforelse

    <style>
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-confirmed {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-shipped {
            background: #d4edda;
            color: #155724;
        }

        .status-delivered {
            background: #000;
            color: #fff;
        }
    </style>
</div>