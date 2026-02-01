@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card primary position-relative h-100 d-flex flex-column justify-content-center">
            <div class="stat-title">Total Users</div>
            <div class="stat-value" id="totalUsers">{{ number_format($totalUsers) }}</div>
            <div class="text-muted small">&nbsp;</div> <!-- Placeholder for height consistency -->
            <i class="fas fa-users stat-icon"></i>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card success position-relative h-100 d-flex flex-column justify-content-center">
            <div class="stat-title">Total Books</div>
            <div class="stat-value" id="totalBooks">{{ number_format($totalBooks) }}</div>
            <div class="text-muted small">Authors: <span id="totalAuthors">{{ number_format($totalAuthors) }}</span></div>
            <i class="fas fa-book stat-icon"></i>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card info position-relative h-100 d-flex flex-column justify-content-center">
            <div class="stat-title">Total Orders</div>
            <div class="stat-value" id="totalOrders">{{ number_format($totalOrders) }}</div>
            <div class="text-muted small">Completed: <span id="completedOrders">{{ number_format($completedOrders) }}</span></div>
            <i class="fas fa-shopping-cart stat-icon"></i>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card warning position-relative h-100 d-flex flex-column justify-content-center">
            <div class="stat-title">Total Revenue</div>
            <div class="stat-value">${{ number_format($totalRevenue, 2) }}</div>
            <div class="text-muted small">Active Coupons: <span>{{ number_format($activeCoupons) }}</span></div>
            <i class="fas fa-dollar-sign stat-icon"></i>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card danger position-relative h-100 d-flex flex-column justify-content-center">
            <div class="stat-title">Pending Orders</div>
            <div class="stat-value" id="pendingOrders">{{ number_format($pendingOrders) }}</div>
            <div class="text-muted small">Canceled: <span id="canceledOrders">{{ number_format($canceledOrders) }}</span></div>
            <i class="fas fa-clock stat-icon"></i>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card warning position-relative h-100 d-flex flex-column justify-content-center">
            <div class="stat-title">Low Stock Books</div>
            <div class="stat-value" id="lowStock">{{ number_format($lowStockBooks) }}</div>
            <div class="text-muted small">Out of stock: <span id="outOfStock">{{ number_format($outOfStock) }}</span></div>
            <i class="fas fa-exclamation-triangle stat-icon"></i>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card success position-relative h-100 d-flex flex-column justify-content-center">
            <div class="stat-title">Active Categories</div>
            <div class="stat-value" id="activeCategories">{{ number_format($activeCategories) }}</div>
            <div class="text-muted small">Total: {{ number_format($activeCategories) }}</div>
            <i class="fas fa-list stat-icon"></i>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card info position-relative h-100 d-flex flex-column justify-content-center">
            <div class="stat-title">Coupons Used</div>
            <div class="stat-value" id="couponsUsed">{{ number_format($usedCoupons) }}</div>
            <div class="text-muted small">Active: {{ number_format($activeCoupons) }}</div>
            <i class="fas fa-ticket-alt stat-icon"></i>
        </div>
    </div>
</div>

<!-- Charts remain as placeholders for now -->
<div class="row g-3 mb-4">
    <div class="col-xl-8">
        <div class="chart-container">
            <div class="chart-header">
                <h5><i class="fas fa-chart-line me-2"></i> Sales Analytics</h5>
                <select class="form-select form-select-sm" style="width: auto;" id="salesPeriod">
                    <option value="7">Last 7 Days</option>
                    <option value="30" selected>Last 30 Days</option>
                    <option value="90">Last 3 Months</option>
                </select>
            </div>
            <canvas id="salesChart"></canvas>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="chart-container">
            <div class="chart-header">
                <h5><i class="fas fa-chart-pie me-2"></i> Order Status</h5>
            </div>
            <canvas id="orderStatusChart"></canvas>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-6">
        <div class="chart-container">
            <div class="chart-header">
                <h5><i class="fas fa-chart-bar me-2"></i> Top Selling Books</h5>
            </div>
            <canvas id="topBooksChart"></canvas>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="chart-container">
            <div class="chart-header">
                <h5><i class="fas fa-chart-bar me-2"></i> Top Categories</h5>
            </div>
            <canvas id="topCategoriesChart"></canvas>
        </div>
    </div>
</div>

{{-- Hidden Data for Charts --}}
<div id="chartData" 
    data-sales='@json($salesData)' 
    data-order-status='@json($orderStatusData)'
    data-top-books='@json($topBooks)'
    data-top-categories='@json($topCategories)'
    data-daily-orders='@json($dailyOrdersData)'
    style="display: none;">
</div>
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/admin-dashboard.css') }}">
@endpush
@endsection

@push('scripts')
<script src="{{ asset('assets/admin/js/admin.js') }}"></script>
@endpush