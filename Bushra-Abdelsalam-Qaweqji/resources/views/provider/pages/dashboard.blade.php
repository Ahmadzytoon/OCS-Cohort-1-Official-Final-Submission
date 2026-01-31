@extends('provider.layouts.app')
@section('title', 'Cleanova | Provider Dashboard')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Earnings
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format((float) $totalEarnings, 2) }} JOD
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Completed Jobs
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($completedCount) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Average Rating
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format((float) $avgRating, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-star fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Upcoming Bookings
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ isset($upcomingBookings) ? $upcomingBookings->count() : 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Upcoming Bookings</h6>
                    <a href="{{ route('provider.bookings') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Service</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $bookingStatus = [
                                        'completed' => 'success',
                                        'accepted' => 'info',
                                        'rejected' => 'danger',
                                        'pending' => 'warning',
                                    ];
                                @endphp
                                @forelse ($upcomingBookings as $booking)
                                    <tr>
                                        <td>{{ $booking->customer?->name ?? '-' }}</td>
                                        <td>{{ $booking->category?->name ?? ($booking->category?->code ?? '-') }}</td>
                                        <td>
                                            {{ $booking->slot ? \Carbon\Carbon::parse($booking->slot->start_time)->format('H:i') : '-' }}
                                            -
                                            {{ $booking->slot ? \Carbon\Carbon::parse($booking->slot->end_time)->format('H:i') : '-' }}
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $bookingStatus[$booking->status] ?? 'secondary' }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No upcoming bookings.</td>
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
