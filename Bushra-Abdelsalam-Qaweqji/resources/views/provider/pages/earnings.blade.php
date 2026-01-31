@extends('provider.layouts.app')
@section('title', 'Cleanova | Earnings')

@section('content')
    <div class="container-fluid">
        <div class="cc-page-head mb-3">
            <h2 class="fw-bold mb-1">Earnings</h2>
            <p class="text-muted mb-0">Track your income and completed jobs.</p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-12 col-md-6">
                <div class="card cc-stat-card h-100">
                    <div class="card-body">
                        <div class="cc-stat-value mt-3">{{ number_format((float) $totalEarnings, 2) }} JOD</div>
                        <div class="text-muted">Total Earnings</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="card cc-stat-card h-100">
                    <div class="card-body">
                        <div class="cc-stat-value mt-3">{{ $completedCount }}</div>
                        <div class="text-muted">Completed Jobs</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card cc-shell-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Earnings history</h5>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="cc-table-head">
                            <tr>
                                <th>Customer</th>
                                <th>Service</th>
                                <th>Hours</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($completedBookings as $booking)
                                <tr>
                                    <td class="fw-semibold">{{ $booking->customer?->name ?? '-' }}</td>
                                    <td class="text-muted">{{ $booking->category?->name ?? $booking->category?->code ?? '-' }}</td>
                                    <td class="text-muted">{{ number_format((float) $booking->hours, 2) }}</td>
                                    <td class="text-end fw-bold">{{ number_format((float) $booking->total_cost, 2) }} JOD</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted p-4">No completed bookings yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection

