@extends('admin.layout.master')

@section('title', 'Bookings Management')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/booking.css') }}">
@endsection

@section('content')

<div class="container-fluid main-content">

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Bookings Management</h1>
            <p class="text-muted mb-0">View all photography bookings (Admin: Read-only)</p>
        </div>

        <!-- ✅ Admin read-only -->
        <div class="page-actions">
            <span class="badge bg-secondary">Read-only</span>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Stats Cards -->
    <div class="stats-cards">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($totalCount ?? 0) }}</h3>
                <p>Total Bookings</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon confirmed">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($approvedCount ?? 0) }}</h3>
                <p>Approved</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon pending">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($pendingCount ?? 0) }}</h3>
                <p>Pending</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon cancelled">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($cancelledCount ?? 0) }}</h3>
                <p>Cancelled</p>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="main-card">

        <!-- Card Header with Filters -->
        <div class="card-header">
            <h3 class="card-title">All Bookings</h3>

            <div class="card-tools">
                <form method="GET" action="{{ route('admin.bookings') }}" class="filters" style="display:flex;gap:10px;align-items:center;">
                    <input type="hidden" name="tab" value="{{ request('tab', $tab ?? 'all') }}">

                    <div class="filter-group">
                        <i class="fas fa-search"></i>
                        <input type="text" name="q" class="filter-input" placeholder="Search bookings..."
                            value="{{ request('q') }}">
                    </div>

                    <select class="filter-select" name="status">
                        <option value="">All Statuses</option>
                        @foreach(['pending','approved','rejected','cancelled','completed'] as $st)
                        <option value="{{ $st }}" @selected(request('status')===$st)>{{ ucfirst($st) }}</option>
                        @endforeach
                    </select>

                    <select class="filter-select" name="sort">
                        <option value="newest" @selected(request('sort','newest')==='newest' )>Sort by: Newest</option>
                        <option value="oldest" @selected(request('sort')==='oldest' )>Sort by: Oldest</option>
                        <option value="amount_high" @selected(request('sort')==='amount_high' )>Sort by: Amount High-Low</option>
                        <option value="amount_low" @selected(request('sort')==='amount_low' )>Sort by: Amount Low-High</option>
                    </select>

                    <button class="btn btn-outline-secondary" type="submit">Apply</button>
                </form>
            </div>
        </div>

        <!-- Tabs (GET links) -->
        @php
        $currentTab = request('tab', $tab ?? 'all');
        $tabs = [
        'all' => 'All',
        'upcoming' => 'Upcoming',
        'today' => 'Today',
        'pending' => 'Pending',
        'completed' => 'Completed',
        ];
        @endphp

        <div class="booking-tabs">
            @foreach($tabs as $key => $label)
            <a
                class="tab-btn {{ $currentTab === $key ? 'active' : '' }}"
                href="{{ route('admin.bookings', array_merge(request()->query(), ['tab' => $key])) }}"
                style="text-decoration:none;">
                {{ $label }}
                <span class="tab-count">{{ $tabCounts[$key] ?? 0 }}</span>
            </a>
            @endforeach
        </div>

        <!-- List View -->
        <div class="table-container" id="list-view">
            <table class="bookings-table">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Customer</th>
                        <th>Provider</th>
                        <th>Service Type</th>
                        <th>Date & Time</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($bookings as $b)
                    @php
                    $st = strtolower($b->status ?? 'pending');
                    $badgeClass = match($st){
                    'approved' => 'status-confirmed',
                    'confirmed' => 'status-confirmed',
                    'pending' => 'status-pending',
                    'cancelled' => 'status-cancelled',
                    'completed' => 'status-confirmed',
                    'rejected' => 'status-cancelled',
                    default => 'status-pending',
                    };

                    // provider label
                    $providerLabel = ucfirst($b->provider_type ?? 'provider') . ' #' . ($b->provider_id ?? '-');
                    @endphp

                    <tr>
                        <td>
                            <div class="booking-info">
                                <div class="booking-icon" style="background: rgba(74, 144, 226, 0.1); color: #4a90e2;">
                                    <i class="fas fa-camera"></i>
                                </div>
                                <div class="booking-details">
                                    <h6>#BK-{{ $b->id }}</h6>
                                    <p>{{ $b->service_type ?? '-' }}</p>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="user-info">
                                <img src="{{ asset('/img/Userprofile.png') }}" alt="Customer" class="user-avatar">
                                <span class="user-name">{{ $b->customer?->full_name ?? '-' }}</span>
                            </div>
                        </td>

                        <td>
                            <div class="user-info">
                                <img src="{{ asset('/img/Userprofile.png') }}" alt="Provider" class="user-avatar">
                                <span class="user-name">{{ $providerLabel }}</span>
                            </div>
                        </td>

                        <td>{{ $b->service_type ?? '-' }}</td>

                        <td>
                            <div class="booking-details">
                                <h6>
                                    {{ $b->date ? \Carbon\Carbon::parse($b->date)->format('M d, Y') : '-' }}
                                </h6>
                                <p>
                                    {{ $b->time_from ?? '-' }} - {{ $b->time_to ?? '-' }}
                                </p>
                            </div>
                        </td>

                        <td class="booking-amount">
                            {{ $b->amount !== null ? number_format($b->amount, 2) : '-' }}
                        </td>

                        <td>
                            <span class="status-badge {{ $badgeClass }}">{{ ucfirst($st) }}</span>
                        </td>

                        <!-- ✅ Admin actions: View only -->
                        <td>
                            <div class="action-buttons">
                                <a class="btn-action view" href="{{ route('admin.bookings.show', $b->id) }}">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-muted" style="padding:20px;">
                            No bookings found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            <div class="pagination-info">
                Showing {{ $bookings->firstItem() ?? 0 }} to {{ $bookings->lastItem() ?? 0 }}
                of {{ $bookings->total() ?? 0 }} bookings
            </div>

            <div class="pagination">
                {{ $bookings->links() }}
            </div>
        </div>

    </div>
</div>

@endsection

@section('script')
<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('wrapper')?.classList.toggle('toggled');
    });
</script>
@endsection