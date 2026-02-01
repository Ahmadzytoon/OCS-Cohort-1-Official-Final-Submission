@extends('layouts.admin')
@section('title', 'Author Dashboard')
@section('page-title', 'Author Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="stat-card primary position-relative">
            <div class="stat-title">My Total Books</div>
            <div class="stat-value">{{ number_format($totalBooks) }}</div>
            <i class="fas fa-book stat-icon"></i>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="stat-card success position-relative">
            <div class="stat-title">Total Sales (Units)</div>
            <div class="stat-value">{{ number_format($totalSales) }}</div>
            <i class="fas fa-shopping-bag stat-icon"></i>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="stat-card info position-relative">
            <div class="stat-title">Total Earnings</div>
            <div class="stat-value">${{ number_format($totalEarnings, 2) }}</div>
            <i class="fas fa-wallet stat-icon"></i>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-xl-12">
        <div class="table-container">
            <div class="table-header">
                <h5><i class="fas fa-history me-2"></i> Recent Earnings</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Book</th>
                            <th>Amount</th>
                            <th>Commission (10%)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentEarnings as $earning)
                        <tr>
                            <td>{{ $earning->created_at->format('M d, Y') }}</td>
                            <td>{{ $earning->orderItem->book->title }}</td>
                            <td class="text-success font-weight-bold">${{ number_format($earning->amount, 2) }}</td>
                            <td class="text-muted">${{ number_format($earning->platform_commission, 2) }}</td>
                            <td><span class="status-badge badge-active">Paid to Balance</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No earnings yet. Keep publishing!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
