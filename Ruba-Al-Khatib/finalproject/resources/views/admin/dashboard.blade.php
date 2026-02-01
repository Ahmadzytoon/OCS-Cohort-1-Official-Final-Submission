{{-- blade-formatter-disable --}}
@extends('admin.layout.master')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid p-4 main-content">
    <h4 class="mb-4">Photography Marketplace Admin Dashboard</h4>

    <!-- Stats Cards -->
    <div class="stats-row mb-4">
        <div class="stat-card-col">
            <div class="card stat-card active-stat">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="stat-icon"><i class="fas fa-users"></i> Total Users</div>
                    </div>

                    <h2 class="mb-1">{{ number_format($totalUsers) }}</h2>

                    <div class="text-success small">
                        @if(!is_null($usersGrowthPct))
                        <i class="fas fa-arrow-up"></i>
                        <span class="text-successs">{{ $usersGrowthPct }}%</span>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card-col">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-icon text-muted mb-2"><i class="fas fa-camera"></i>
                        <span class="stat-text">Total Photographers</span>
                    </div>
                    <h2 class="mb-1">{{ number_format($totalPhotographers) }}</h2>
                </div>
            </div>
        </div>

        <div class="stat-card-col">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-icon text-muted mb-2"><i class="fas fa-calendar-check"></i>
                        <span class="stat-text"> Total Bookings</span>
                    </div>
                    <h2 class="mb-1">{{ number_format($totalBookings) }}</h2>
                </div>
            </div>
        </div>

        <div class="stat-card-col">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-icon text-muted mb-2"><i class="fas fa-clock"></i>
                        <span class="stat-text">Pending Approvals</span>
                    </div>
                    <h2 class="mb-1">{{ number_format($pendingApprovals) }}</h2>
                </div>
            </div>
        </div>

        <div class="stat-card-col">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-icon text-muted mb-2"><i class="fas fa-chart-line"></i>
                        <span class="stat-text"> Recent Activity</span>
                    </div>
                    <h2 class="mb-1 text-brown">
                        {{ $recentActivityDelta >= 0 ? '+' : '' }}{{ $recentActivityDelta }}
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Bookings Overview -->
        <div class="col-lg-8 col-md-12 mb-4">
            <div class="card h-100 main-card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h6 class="m-0 fw-bold">Bookings Overview</h6>
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-sm bg-light border-0">
                            <option>By Month</option>
                        </select>

                        <select class="form-select form-select-sm bg-light border-0"
                            onchange="location.href = `{{ route('admin.dashboard') }}?year=${this.value}`;">
                            @for($y = now()->year - 3; $y <= now()->year + 1; $y++)
                                <option value="{{ $y }}" @selected($y==$year)>{{ $y }}</option>
                                @endfor
                        </select>

                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="bookingsChart"></canvas>

                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card h-100 recent-activity-card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h6 class="m-0 fw-bold">Recent Activity</h6>
                    <a href="#" class="text-decoration-none small text-muted">View All Activity</a>
                </div>

                <div class="card-body p-0">
                    <div class="list-group list-group-flush">

                        {{-- مثال بسيط: آخر Users --}}
                        @foreach($recentUsers as $u)
                        <div class="list-group-item border-0 px-3 py-3">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('/img/Userprofile.png') }}" class="rounded-circle recent-activity-img me-3" alt="User">
                                <div class="flex-grow-1">
                                    <div class="small fw-bold">{{ $u->full_name }} registered.</div>
                                    <div class="extra-small text-muted">
                                        {{ $u->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-outline-secondary recent-activity-btn">View</button>
                            </div>
                        </div>
                        @endforeach

                        {{-- Pending photographers --}}
                        @foreach($recentPending as $p)
                        <div class="list-group-item border-0 px-3 py-3">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('/img/Userprofile.png') }}" class="rounded-circle recent-activity-img me-3" alt="User">
                                <div class="flex-grow-1">
                                    <div class="small fw-bold">{{ $p->full_name ?? 'Photographer' }} pending approval.</div>
                                    <div class="extra-small text-muted">{{ $p->created_at->diffForHumans() }}</div>
                                </div>
                                <button class="btn btn-sm btn-brown text-white recent-activity-btn">Approve</button>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>

                <div class="card-footer bg-white border-0 d-flex justify-content-between py-3">
                    <a href="#" class="text-decoration-none small text-muted">View All Users ></a>
                    <a href="#" class="text-decoration-none small text-muted">View All Activity ></a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Manage Users -->
        <div class="col-lg-7 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 manage-users-header">
                    <h6 class="m-0 fw-bold">Manage Users</h6>

                    <form class="d-flex gap-2 align-items-center manage-users-filters" method="GET" action="{{ route('admin.dashboard') }}">
                        <input type="hidden" name="year" value="{{ $year }}">

                        <div class="search-box-sm">
                            <i class="fas fa-search text-muted"></i>
                            <input type="text" name="q" value="{{ request('q') }}"
                                class="form-control form-control-sm border-0 bg-light" placeholder="Search...">
                        </div>

                        <select name="role" class="form-select form-select-sm bg-light border-0 filter-select">
                            <option value="all">All Roles</option>
                            <option value="customer" @selected(request('role')=='customer' )>Customer</option>
                            <option value="photographer" @selected(request('role')=='photographer' )>Photographer</option>
                            <option value="studio" @selected(request('role')=='studio' )>Studio</option>
                        </select>

                        <select name="status" class="form-select form-select-sm bg-light border-0 filter-select">
                            <option value="all" @selected(request('status','all')=='all' )>All Statuses</option>
                            <option value="approved" @selected(request('status')=='approved' )>Approved</option>
                            <option value="pending" @selected(request('status')=='pending' )>Pending</option>
                            <option value="rejected" @selected(request('status')=='rejected' )>Rejected</option>
                            <option value="completed" @selected(request('status')=='completed' )>Completed</option>
                            <option value="canceled" @selected(request('status')=='canceled' )>Canceled</option>
                        </select>

                        <button class="btn btn-sm btn-light border">Apply</button>
                        <i class="fas fa-ellipsis-h text-muted ms-2 d-none d-sm-block"></i>
                    </form>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 px-4">Name</th>
                                    <th class="border-0">Role</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($manageUsers as $u)
                                <tr>
                                    <td class="px-4">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('/img/Userprofile.png') }}" class="rounded-circle table-user-img me-2" alt="User">
                                            <span class="small fw-bold">{{ $u->full_name }}</span>
                                        </div>
                                    </td>

                                    <td class="small">{{ ucfirst($u->account_type) }}</td>


                                    <td>
                                        @php

                                        $st = $u->status ?? 'pending';

                                        $dot = match($st) {
                                        'approved' => 'bg-success',
                                        'pending' => 'bg-warning',
                                        'rejected' => 'bg-danger',
                                        'completed'=> 'bg-success',
                                        'canceled' => 'bg-secondary',
                                        default => 'bg-secondary',
                                        };
                                        @endphp
                                        <span class="status-dot {{ $dot }}"></span>
                                        <span class="small">{{ ucfirst($st) }}</span>


                                    </td>

                                    <td class="text-center">
                                        <button class="btn btn-sm btn-light border table-action-btn">View</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No users found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-white border-0 d-flex justify-content-between py-3">
                    <a href="#" class="text-decoration-none small text-muted">View All Users ></a>
                    <a href="#" class="text-decoration-none small text-muted">View All Activity ></a>
                </div>
            </div>
        </div>

        <!-- Pending Photographer Approvals -->
        <div class="col-lg-5 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h6 class="m-0 fw-bold">Pending Photographer Approvals</h6>
                    <i class="fas fa-ellipsis-h text-muted d-none d-sm-block"></i>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 px-4">Name</th>
                                    <th class="border-0">Email</th>
                                    <th class="border-0 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingPhotographers as $p)
                                <tr>
                                    <td class="px-4">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('/img/Userprofile.png') }}" class="rounded-circle table-user-img me-2" alt="User">
                                            <span class="small fw-bold">{{ $p->full_name ?? $p->name ?? 'Photographer' }}</span>
                                        </div>
                                    </td>
                                    <td class="extra-small text-muted">{{ $p->email ?? '—' }}</td>
                                    <td class="text-center">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <button class="btn btn-xs btn-brown-outline">Approve</button>
                                            <button class="btn btn-xs btn-danger-light">Block</button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">No pending approvals.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-white border-0 d-flex justify-content-between py-3">
                    <a href="#" class="text-decoration-none small text-muted">View All Users ></a>
                    <a href="#" class="text-decoration-none small text-muted">View All Pending Approvals</a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = {!! json_encode($labels) !!};
    const chartData = {!! json_encode($chartData) !!};

    const ctx = document.getElementById('bookingsChart').getContext('2d');
    const bookingsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Bookings',
                data: chartData,
                borderColor: '#4a90e2',
                backgroundColor: 'rgba(74, 144, 226, 0.05)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#4a90e2',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e5e7eb',
                        drawBorder: false,
                        borderDash: [3, 3]
                    },
                    ticks: {
                        color: '#6b7280',
                        padding: 10
                    }
                },
                x: {
                    grid: {
                        color: '#e5e7eb',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#6b7280',
                        padding: 10
                    }
                }
            }
        }
    });

    document.getElementById('sidebarToggle')?.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('wrapper')?.classList.toggle('toggled');
    });
</script>
@endsection