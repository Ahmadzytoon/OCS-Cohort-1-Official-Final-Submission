@extends('admin.layout.master')

@section('title', 'Dashboard')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

        <div>
            <button class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
            </button>
        </div>
    </div>

    <!-- Stat Cards Row (4 Cards) -->
    <div class="row">

        <!-- Total Customers -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Customers
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalCustomers) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Providers -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Service Providers
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalProviders) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Bookings -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Bookings
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalBookings) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Transactions -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Payments / Transactions
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalPayments) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-credit-card fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <!-- Customers Status -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Customers Status</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-gray-700">Active Customers</span>
                        <span class="font-weight-bold text-success">{{ number_format($activeCustomers) }}</span>
                    </div>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $customerActivePct }}%"></div>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-gray-700">Inactive Customers</span>
                        <span class="font-weight-bold text-secondary">{{ number_format($inactiveCustomers) }}</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $customerInactivePct }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Providers Status -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Providers Status</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-gray-700">Active Providers</span>
                        <span class="font-weight-bold text-success">{{ number_format($activeProviders) }}</span>
                    </div>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $providerActivePct }}%"></div>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-gray-700">Inactive Providers</span>
                        <span class="font-weight-bold text-secondary">{{ number_format($inactiveProviders) }}</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $providerInactivePct }}%"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Charts Row -->
    <div class="row">

    </div>

    <!-- Recent Activity (2 Tables) -->
    <div class="row">

        <!-- Latest Bookings -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Latest Bookings</h6>
                    <a href="{{ route('admin.bookings') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Provider</th>
                                    <th>Service</th>
                                    <th>Date & Time</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($latestBookings as $booking)
                                    @php
                                        $paymentStatus = $booking->payment?->payment_status ?? 'unpaid';
                                    @endphp
                                    <tr>
                                        <td>{{ $booking->customer?->name ?? 'N/A' }}</td>
                                        <td>{{ $booking->provider?->name ?? 'N/A' }}</td>
                                        <td>
                                            @if ($booking->category)
                                                <span class="badge badge-primary">{{ $booking->category->code }}</span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $booking->slot?->start_time ?? $booking->created_at?->format('Y-m-d H:i') }}
                                        </td>
                                        <td>
                                            @php
                                                $bookingBadge = match ($booking->status) {
                                                    'completed' => 'success',
                                                    'accepted' => 'info',
                                                    'rejected' => 'danger',
                                                    default => 'warning',
                                                };
                                            @endphp
                                            <span class="badge badge-{{ $bookingBadge }}">{{ ucfirst($booking->status) }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $paymentBadge = match ($paymentStatus) {
                                                    'paid' => 'success',
                                                    'failed' => 'danger',
                                                    'pending' => 'warning',
                                                    default => 'secondary',
                                                };
                                            @endphp
                                            <span class="badge badge-{{ $paymentBadge }}">{{ ucfirst($paymentStatus) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No bookings yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Payments -->
        <div class="col-lg-5 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Latest Payments</h6>
                    <a href="{{ route('admin.payments') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>TX</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($latestPayments as $payment)
                                    @php
                                        $paymentBadge = match ($payment->payment_status) {
                                            'paid' => 'success',
                                            'failed' => 'danger',
                                            default => 'warning',
                                        };
                                        $amount = $payment->booking?->total_cost ?? 0;
                                    @endphp
                                    <tr>
                                        <td>#TX-{{ $payment->id }}</td>
                                        <td>${{ number_format($amount, 2) }}</td>
                                        <td><span class="badge badge-{{ $paymentBadge }}">{{ ucfirst($payment->payment_status) }}</span></td>
                                        <td>{{ $payment->created_at?->format('Y-m-d') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No payments yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection

@section('script')
    <!-- Page level plugins -->
    <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts (SB Admin 2 default demos) -->
    <script src="{{ asset('admin/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('admin/js/demo/chart-pie-demo.js') }}"></script>

@endsection
