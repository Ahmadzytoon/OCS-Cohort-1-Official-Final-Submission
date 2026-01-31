@extends('seeker.layouts.app')
@section('title', 'Cleanova | My Bookings')

@section('content')
    <section class="cc-section pt-4">
        <div class="container">
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-3">
                <div>
                    <h2 class="fw-bold mb-1">My Bookings</h2>
                    <div class="text-muted">All your bookings in one place</div>
                </div>
                <a href="{{ route('seeker.providers-list') }}" class="btn btn-outline-primary cc-btn-outline">
                    Book a new cleaner
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <div class="card cc-shell-card">
                <div class="card-body p-3 p-md-4">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="cc-table-head">
                                <tr>
                                    <th>Provider</th>
                                    <th>Service</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bookings as $booking)
                                    @php
                                        $paid = $booking->payment && $booking->payment->payment_status === 'paid';
                                    @endphp
                                    <tr>
                                        <td class="fw-semibold">{{ $booking->provider?->name ?? '-' }}</td>
                                        <td class="text-muted">
                                            {{ $booking->category?->name ?? $booking->category?->code ?? '-' }}
                                        </td>
                                        <td class="text-muted">
                                            {{ $booking->slot ? \Carbon\Carbon::parse($booking->slot->start_time)->format('H:i') : '-' }}
                                            -
                                            {{ $booking->slot ? \Carbon\Carbon::parse($booking->slot->end_time)->format('H:i') : '-' }}
                                        </td>
                                        <td>{{ $statusMap[$booking->status] ?? ucfirst($booking->status) }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('seeker.bookings.show', $booking) }}"
                                                class="btn btn-sm btn-primary cc-btn-primary">
                                                View
                                            </a>
                                            @if ($booking->status === 'accepted' && !$paid)
                                                <a href="{{ route('seeker.bookings.pay.form', $booking) }}"
                                                    class="btn btn-sm cc-pay-btn">
                                                    Pay
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted p-4">
                                            You have no bookings yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
