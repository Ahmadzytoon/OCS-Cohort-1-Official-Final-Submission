@if(auth()->user()->account_type === 'photographer' && !auth()->user()->hasActiveSubscription())
  <div style="margin:12px 0; padding:14px; border:1px solid rgba(239,68,68,.35); background:rgba(239,68,68,.08); border-radius:12px;">
    <strong>Subscription Required:</strong>
    You need an active plan to upload portfolio photos and manage bookings.
    <a href="{{ route('pricing') }}" style="margin-left:10px; font-weight:700;">View Plans</a>
  </div>
@endif


@extends('photographer.layout')

@section('title', 'Photographer Dashboard')

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div>
        <h1 class="page-title">
            Welcome back, {{ auth()->user()->full_name }}
        </h1>
        <p class="page-subtitle">
            Here's what's happening with your photography business today.
        </p>
    </div>

    <a href="{{ route('photographer.bookings.index') }}" class="btn btn-primary"> 
        <i class="fas fa-plus"></i> View Bookings
    </a>
</div>

{{-- STATS --}}
<div class="stats-grid mb-5">

    <div class="card stat-card">
        <div class="stat-icon bookings">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div>
            <div class="stat-value">{{ $stats['upcoming'] ?? 0 }}</div>
            <div class="stat-label">Upcoming Bookings</div>
        </div>
    </div>

    <div class="card stat-card">
        <div class="stat-icon earnings">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div>
            <div class="stat-value">${{ $stats['earnings'] ?? 0 }}</div>
            <div class="stat-label">Monthly Earnings</div>
        </div>
    </div>

    <div class="card stat-card">
        <div class="stat-icon rating">
            <i class="fas fa-star"></i>
        </div>
        <div>
            <div class="stat-value">{{ $stats['rating'] ?? '—' }}</div>
            <div class="stat-label">Average Rating</div>
        </div>
    </div>

    <div class="card stat-card">
        <div class="stat-icon pending">
            <i class="fas fa-clock"></i>
        </div>
        <div>
            <div class="stat-value">{{ $stats['pending'] ?? 0 }}</div>
            <div class="stat-label">Pending Requests</div>
        </div>
    </div>

</div>

{{-- RECENT BOOKINGS --}}
<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Recent Bookings</h3>
        <a href="{{ route('photographer.bookings.index') }}" class="btn btn-outline btn-sm"> 
            View All
        </a>
    </div>

    @if($recentBookings->isEmpty())
        <p class="mb-0">No bookings yet.</p>
    @else
        <table class="bookings-table">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Service</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentBookings as $booking)
                    <tr>
                        <td>{{ $booking->user->full_name }}</td>
                        <td>{{ $booking->date }}</td>
                        <td>{{ $booking->service }}</td>
                        <td>${{ $booking->price }}</td>
                        <td>
                            <span class="status-badge status-{{ $booking->status }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
