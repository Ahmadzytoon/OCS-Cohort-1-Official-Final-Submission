@extends('seeker.layouts.app')
@section('title', 'Cleanova | Dashboard')

@section('content')
    <section class="cc-section pt-4">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-3">
                <div>
                    <h2 class="fw-bold mb-1">Welcome back</h2>
                    <div class="text-muted">Quick look at your recent bookings</div>
                </div>
                <a href="{{ route('seeker.providers-list') }}" class="btn btn-outline-primary cc-btn-outline">
                    Book a new cleaner
                </a>
            </div>

            <div class="row g-4">
                <div class="col-12 col-lg-8">
                    <div class="card cc-shell-card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="cc-table-head">
                                        <tr>
                                            <th>Provider</th>
                                            <th>Service</th>
                                            <th>Time</th>
                                            <th>Status</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $statusMap = [
                                                'pending' => 'Pending',
                                                'accepted' => 'Confirmed',
                                                'rejected' => 'Cancelled',
                                                'completed' => 'Completed',
                                            ];
                                        @endphp

                                        @forelse ($bookings as $booking)
                                            <tr>
                                                <td class="fw-semibold">{{ $booking->provider?->name ?? '-' }}</td>
                                                <td class="text-muted">{{ $booking->category?->name ?? $booking->category?->code ?? '-' }}</td>
                                                <td class="text-muted">
                                                    {{ $booking->slot ? \Carbon\Carbon::parse($booking->slot->start_time)->format('H:i') : '-' }}
                                                    -
                                                    {{ $booking->slot ? \Carbon\Carbon::parse($booking->slot->end_time)->format('H:i') : '-' }}
                                                </td>
                                                <td>{{ $statusMap[$booking->status] ?? ucfirst($booking->status) }}</td>
                                                <td class="text-end">
                                                    <a href="{{ route('seeker.bookings.show', $booking) }}"
                                                        class="btn btn-sm btn-primary cc-btn-primary">View</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted p-4">
                                                    No bookings yet. Start by finding a cleaner.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="card cc-shell-card">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Quick Actions</h5>
                            <div class="d-grid gap-2">
                                <a href="{{ route('seeker.providers-list') }}" class="btn btn-primary cc-book-btn">
                                    Find Cleaners
                                </a>
                                <a href="{{ route('seeker.bookings.index') }}" class="btn btn-outline-primary cc-btn-outline">
                                    View All Bookings
                                </a>
                            </div>
                            <div class="text-muted small mt-3">
                                Tip: This is your seeker home page.
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

