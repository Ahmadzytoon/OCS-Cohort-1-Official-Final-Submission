<div class="animate-fade-in">
    <!-- Header & Statistics -->
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 mb-1" style="font-family: var(--font-heading); font-weight: 700;">Order Management</h1>
                <p class="text-muted small mb-0">Live control room for client acquisitions.</p>
            </div>
            <div class="d-flex gap-2">
                <div class="bg-white px-3 py-2 rounded-4 shadow-sm border text-center cursor-pointer {{ $statusFilter === '' ? 'border-dark' : '' }}" wire:click="$set('statusFilter', '')">
                    <div class="extra-small text-muted fw-bold text-uppercase ls-1">Total</div>
                    <div class="h5 mb-0 fw-bold">{{ $counts['all'] }}</div>
                </div>
                <div class="bg-white px-3 py-2 rounded-4 shadow-sm border text-center cursor-pointer {{ $statusFilter === 'pending' ? 'border-warning' : '' }}" wire:click="$set('statusFilter', 'pending')">
                    <div class="extra-small text-muted fw-bold text-uppercase ls-1 text-warning">Pending</div>
                    <div class="h5 mb-0 fw-bold text-warning">{{ $counts['pending'] }}</div>
                </div>
                <div class="bg-white px-3 py-2 rounded-4 shadow-sm border text-center cursor-pointer {{ $statusFilter === 'processing' ? 'border-primary' : '' }}" wire:click="$set('statusFilter', 'processing')">
                    <div class="extra-small text-muted fw-bold text-uppercase ls-1 text-primary">Active</div>
                    <div class="h5 mb-0 fw-bold text-primary">{{ $counts['processing'] }}</div>
                </div>
                <div class="bg-white px-3 py-2 rounded-4 shadow-sm border text-center cursor-pointer {{ $statusFilter === 'delivered' ? 'border-success' : '' }}" wire:click="$set('statusFilter', 'delivered')">
                    <div class="extra-small text-muted fw-bold text-uppercase ls-1 text-success">Finished</div>
                    <div class="h5 mb-0 fw-bold text-success">{{ $counts['delivered'] }}</div>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <div class="position-relative">
                            <input type="text" class="form-control border-0 bg-light rounded-3 ps-5 shadow-sm" placeholder="Search by #Order or Customer..." wire:model.live.debounce.300ms="search">
                            <i class="fa fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select wire:model.live="dateFilter" class="form-select border-0 bg-light rounded-3 shadow-sm">
                            <option value="all">Any Date</option>
                            <option value="today">Today</option>
                            <option value="week">Last 7 Days</option>
                            <option value="month">Last Month</option>
                            <option value="year">Last Year</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <input type="number" wire:model.live="minAmount" class="form-control border-0 bg-light rounded-3 shadow-sm" placeholder="Min JOD">
                            <input type="number" wire:model.live="maxAmount" class="form-control border-0 bg-light rounded-3 shadow-sm" placeholder="Max JOD">
                        </div>
                    </div>
                    <div class="col-md-3 text-end">
                        <button wire:click="resetFilters" class="btn btn-light rounded-3 px-3 shadow-sm border-0">
                            <i class="fa fa-undo-alt me-2 text-muted"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bulk Actions -->
        @if(count($selectedRows) > 0)
            <div class="d-flex align-items-center gap-3 animate-fade-in bg-white p-2 rounded-pill shadow border px-4 mb-4">
                <span class="small fw-bold text-primary">{{ count($selectedRows) }} selected</span>
                <div class="vr"></div>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-dark border-0 rounded-pill dropdown-toggle" data-bs-toggle="dropdown">
                        Bulk Action
                    </button>
                    <ul class="dropdown-menu shadow border-0 rounded-4">
                        <li><a class="dropdown-item small py-2" href="#" wire:click.prevent="bulkUpdateStatus('processing')">Accept & Process</a></li>
                        <li><a class="dropdown-item small py-2" href="#" wire:click.prevent="bulkUpdateStatus('shipped')">Mark as Sent</a></li>
                        <li><a class="dropdown-item small py-2" href="#" wire:click.prevent="bulkUpdateStatus('delivered')">Mark as Delivered</a></li>
                        <li><hr class="dropdown-divider opacity-50"></li>
                        <li><a class="dropdown-item small py-2 text-danger" href="#" wire:click.prevent="bulkDelete">Delete Selected</a></li>
                    </ul>
                </div>
            </div>
        @endif
    </div>

    <!-- Orders Table -->
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr class="bg-light bg-opacity-50 align-top">
                            <th class="ps-4 py-3 border-0" style="width: 40px;">
                                <div class="form-check">
                                    <input class="form-check-input shadow-none cursor-pointer" type="checkbox" wire:model.live="selectAll">
                                </div>
                            </th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1 cursor-pointer" wire:click="sortBy('order_number')">
                                Order # @if($sortField === 'order_number') <i class="fa fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-primary"></i> @else <i class="fa fa-sort opacity-25"></i> @endif
                            </th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1 cursor-pointer" wire:click="sortBy('user_id')">
                                Customer @if($sortField === 'user_id') <i class="fa fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-primary"></i> @else <i class="fa fa-sort opacity-25"></i> @endif
                            </th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1 text-center">Items</th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1 cursor-pointer" wire:click="sortBy('total_amount')">
                                Total @if($sortField === 'total_amount') <i class="fa fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-primary"></i> @else <i class="fa fa-sort opacity-25"></i> @endif
                            </th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1 text-center cursor-pointer" wire:click="sortBy('status')">
                                Status @if($sortField === 'status') <i class="fa fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-primary"></i> @else <i class="fa fa-sort opacity-25"></i> @endif
                            </th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1 text-end cursor-pointer" wire:click="sortBy('created_at')">
                                Date @if($sortField === 'created_at') <i class="fa fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-primary"></i> @else <i class="fa fa-sort opacity-25"></i> @endif
                            </th>
                            <th class="pe-4 py-3 border-0 text-end text-uppercase extra-small text-muted fw-bold ls-1">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($orders as $order)
                            <tr wire:key="order-row-{{ $order->id }}" class="border-top" style="border-color: rgba(0,0,0,0.02) !important;">
                                <td class="ps-4">
                                    <div class="form-check">
                                        <input class="form-check-input shadow-none cursor-pointer" type="checkbox" value="{{ $order->id }}" wire:model.live="selectedRows">
                                    </div>
                                </td>
                                <td><span class="fw-bold text-dark">#{{ $order->order_number }}</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-soft-blush rounded-circle d-flex align-items-center justify-content-center me-2 text-dark fw-bold"
                                            style="width: 32px; height: 32px; font-size: 0.7rem;">
                                            {{ substr($order->user->name ?? 'G', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-medium text-dark small">{{ $order->user->name ?? 'Guest' }}</div>
                                            <div class="text-muted extra-small" style="font-size: 0.65rem;">{{ $order->user->email ?? 'no-email' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="small">{{ $order->items_count ?? $order->items()->count() }} items</td>
                                <td class="fw-bold text-dark small">{{ number_format($order->total_amount, 0) }} JOD</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm rounded-pill px-3 extra-small border-0
                                            @if($order->status === 'delivered') bg-success-subtle text-success
                                            @elseif($order->status === 'cancelled') bg-danger-subtle text-danger
                                            @elseif($order->status === 'shipped') bg-info-subtle text-info
                                            @else bg-warning-subtle text-warning @endif"
                                            type="button" data-bs-toggle="dropdown">
                                            @if($order->status === 'pending') Acceptance Needed @elseif($order->status === 'shipped') Sent @else {{ ucfirst($order->status) }} @endif
                                        </button>
                                        <ul class="dropdown-menu border-0 shadow-sm rounded-4">
                                            <li><a class="dropdown-item small py-2" href="#" wire:click.prevent="updateStatus({{ $order->id }}, 'pending')">Pending Acceptance</a></li>
                                            <li><a class="dropdown-item small py-2" href="#" wire:click.prevent="updateStatus({{ $order->id }}, 'processing')">Accept & Process</a></li>
                                            <li><a class="dropdown-item small py-2" href="#" wire:click.prevent="updateStatus({{ $order->id }}, 'shipped')">Mark as Sent</a></li>
                                            <li><a class="dropdown-item small py-2" href="#" wire:click.prevent="updateStatus({{ $order->id }}, 'delivered')">Delivered</a></li>
                                            <li><hr class="dropdown-divider opacity-50"></li>
                                            <li><a class="dropdown-item small py-2 text-danger" href="#" wire:click.prevent="updateStatus({{ $order->id }}, 'cancelled')">Cancel Order</a></li>
                                        </ul>
                                    </div>
                                </td>
                                <td class="text-muted small">{{ $order->created_at->format('M d, H:i') }}</td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button wire:click="viewDetails({{ $order->id }})" class="btn btn-sm btn-light rounded-pill px-3 py-2 extra-small fw-bold border shadow-sm">
                                            Track
                                        </button>
                                        <button wire:click="deleteOrder({{ $order->id }})" wire:confirm="Soft-delete this luxury acquisition?" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-2 extra-small border-0">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fa fa-box-open fa-3x mb-3 opacity-25 text-primary"></i>
                                    <p class="mb-0 fw-bold">No orders match your selected filters.</p>
                                    <button wire:click="resetFilters" class="btn btn-link text-primary btn-sm mt-2">Clear all filters</button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($orders->count() > 0)
            <div class="card-footer bg-white py-4 border-0 d-flex justify-content-center">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

    <!-- Tracking Sidebar -->
    @if($showDetails && $selectedOrder)
        <div class="position-fixed inset-0 bg-dark bg-opacity-50 blur-bg" style="z-index: 1060;" wire:click="$set('showDetails', false)"></div>
        <div class="bg-white position-fixed top-0 end-0 h-100 shadow-lg animate-slide-in" style="width: 500px; z-index: 1070; border-left: 1px solid rgba(0,0,0,0.05);">
            <div class="h-100 d-flex flex-column">
                <div class="p-4 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
                    <h5 class="mb-0 fw-bold" style="font-family: 'Playfair Display';">Logistics for #{{ $selectedOrder->order_number }}</h5>
                    <button class="btn-close" wire:click="$set('showDetails', false)"></button>
                </div>
                
                <div class="flex-grow-1 overflow-auto p-4">
                    <!-- Tracking Timeline -->
                    <div class="mb-5">
                        <label class="extra-small text-muted text-uppercase fw-bold ls-1 mb-4 d-block">Tracking Journey</label>
                        <div class="tracking-timeline">
                            @php 
                                $stages = [
                                    'pending' => ['label' => 'Discovery Placed', 'icon' => 'fa-clock', 'desc' => 'Waiting for admin acceptance'],
                                    'processing' => ['label' => 'Hand-picked', 'icon' => 'fa-check', 'desc' => 'Order is being prepared'],
                                    'shipped' => ['label' => 'Departure (Sent)', 'icon' => 'fa-truck', 'desc' => 'On the way to client'],
                                    'delivered' => ['label' => 'Acquired', 'icon' => 'fa-home', 'desc' => 'Successfully delivered']
                                ];
                                $currentStatus = $selectedOrder->status;
                                $statusOrder = ['pending', 'processing', 'shipped', 'delivered'];
                                $currentIndex = array_search($currentStatus, $statusOrder);
                            @endphp

                            @foreach($statusOrder as $index => $status)
                                <div wire:click="updateStatus({{ $selectedOrder->id }}, '{{ $status }}')"
                                    class="timeline-item cursor-pointer {{ $index <= $currentIndex ? 'active' : '' }}">
                                    <div class="timeline-icon"><i class="fa {{ $stages[$status]['icon'] }}"></i></div>
                                    <div class="timeline-content">
                                        <div class="fw-bold small">{{ $stages[$status]['label'] }}</div>
                                        <div class="text-muted extra-small">{{ $stages[$status]['desc'] }}</div>
                                        @if($index === 0)
                                            <div class="text-muted extra-small opacity-50">{{ $selectedOrder->created_at->format('M d, Y - H:i') }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card border-0 bg-light rounded-4 mb-4 shadow-sm">
                        <div class="card-body p-4">
                            <label class="extra-small text-muted text-uppercase fw-bold ls-1 mb-3 d-block">Client Profile</label>
                            <h6 class="fw-bold mb-2">{{ $selectedOrder->user->name ?? 'Guest Client' }}</h6>
                            <p class="small text-muted mb-2"><i class="fa fa-envelope me-2 opacity-50"></i>{{ $selectedOrder->user->email ?? 'N/A' }}</p>
                            <p class="small text-muted mb-0"><i class="fa fa-map-marker-alt me-2 opacity-50"></i>{{ $selectedOrder->shipping_address ?? 'Jordan, Amman' }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="extra-small text-muted text-uppercase fw-bold ls-1 mb-3 d-block">Discovery Curations</label>
                        @foreach($selectedOrder->items as $item)
                            <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom border-light">
                                <div class="bg-white rounded-3 p-1 shadow-sm" style="width: 50px; height: 60px;">
                                    <img src="{{ $item->product->image ?? 'https://via.placeholder.com/60' }}" class="rounded-2 object-fit-cover w-100 h-100">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="small mb-0 fw-bold text-dark">{{ $item->product->name }}</h6>
                                    <p class="extra-small text-muted mb-0">Qty: {{ $item->quantity }} • JOD {{ number_format($item->price, 0) }}</p>
                                    @if($item->size || $item->color)
                                        <div class="d-flex gap-2 mt-1">
                                            @if($item->size)
                                                <span class="badge bg-light text-muted border extra-small">{{ $item->size }}</span>
                                            @endif
                                            @if($item->color)
                                                <div class="rounded-circle border" style="width: 12px; height: 12px; background-color: {{ $item->color }};" title="Color"></div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="fw-bold small text-dark">JOD {{ number_format($item->price * $item->quantity, 0) }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="p-4 bg-dark text-white rounded-bottom-0" style="border-top-left-radius: 30px; border-top-right-radius: 30px; box-shadow: 0 -10px 30px rgba(0,0,0,0.1);">
                    <div class="d-flex justify-content-between align-items-center mb-0">
                        <span class="small opacity-50 text-uppercase ls-1 fw-bold">Investment Total</span>
                        <span class="h3 mb-0 fw-bold">JOD {{ number_format($selectedOrder->total_amount, 0) }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
        .extra-small { font-size: 0.65rem; }
        .ls-1 { letter-spacing: 1.5px; }
        .cursor-pointer { cursor: pointer; }
        .bg-soft-blush { background: rgba(246, 166, 178, 0.15); }
        .bg-success-subtle { background: rgba(25, 135, 84, 0.1); color: #198754 !important; }
        .bg-danger-subtle { background: rgba(220, 53, 69, 0.1); color: #dc3545 !important; }
        .bg-info-subtle { background: rgba(13, 202, 240, 0.1); color: #0dcaf0 !important; }
        .bg-warning-subtle { background: rgba(255, 193, 7, 0.1); color: #f59e0b !important; }

        .tracking-timeline { position: relative; padding-left: 45px; }
        .tracking-timeline::before { content: ''; position: absolute; left: 14px; top: 10px; bottom: 10px; width: 2px; background: #eee; }
        
        .timeline-item { position: relative; margin-bottom: 35px; opacity: 0.3; transition: all 0.4s ease; transform: scale(0.95); transform-origin: left; }
        .timeline-item.active { opacity: 1; transform: scale(1); }
        
        .timeline-icon {
            position: absolute; left: -45px; width: 32px; height: 32px; 
            background: white; border: 2px solid #eee; border-radius: 50%; 
            display: flex; align-items: center; justify-content: center; font-size: 10px; z-index: 10;
        }
        
        .timeline-item.active .timeline-icon { border-color: #F6A6B2; background: #F6A6B2; color: white; box-shadow: 0 0 15px rgba(246,166,178,0.5); }
        .timeline-item.cursor-pointer:hover { transform: translateX(10px) scale(1.02); opacity: 1; }
        .timeline-item.cursor-pointer:hover .timeline-icon { background: #f6a6b2 !important; border-color: #f6a6b2 !important; color: white !important; box-shadow: 0 0 20px rgba(246,166,178,0.7) !important; }

        @keyframes slideIn { from { transform: translateX(100%); } to { transform: translateX(0); } }
        .animate-slide-in { animation: slideIn 0.6s cubic-bezier(0.23, 1, 0.32, 1); }
        
        .form-check-input:checked { background-color: #F6A6B2; border-color: #F6A6B2; }
        .blur-bg { backdrop-filter: blur(5px); }
        .text-primary { color: #F6A6B2 !important; }
        .btn-primary { background-color: #F6A6B2; border-color: #F6A6B2; }
    </style>
</div>