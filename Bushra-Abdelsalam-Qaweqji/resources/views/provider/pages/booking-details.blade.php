@extends('provider.layouts.app')
@section('title', 'Cleanova | Booking Details')

@section('content')
    <section class="cc-section pt-4">
        <div class="container">
            <div class="mb-3">
                <a href="{{ route('provider.bookings') }}" class="cc-back-link">&larr; Back to bookings</a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->has('status'))
                <div class="alert alert-danger">{{ $errors->first('status') }}</div>
            @endif

            @php
                $statusMap = [
                    'pending' => 'Pending',
                    'accepted' => 'Confirmed',
                    'rejected' => 'Cancelled',
                    'completed' => 'Completed',
                ];
                $statusLabel = $statusMap[$booking->status] ?? ucfirst($booking->status);
                $paid = $booking->payment && $booking->payment->payment_status === 'paid';
            @endphp

            <div class="card cc-shell-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h4 class="fw-bold mb-1">Booking #{{ $booking->id }}</h4>
                            <div class="text-muted small">Status: {{ $statusLabel }}</div>
                            <div class="text-muted small">
                                Payment:
                                <span class="{{ $paid ? 'text-success fw-semibold' : 'text-danger fw-bolder' }}">
                                    {{ $paid ? 'Paid' : 'Unpaid' }}
                                </span>
                            </div>
                        </div>
                        <div class="text-end">
                            @if ($booking->status === 'pending')
                                <div class="d-flex gap-2 justify-content-end">
                                    <form method="POST" action="{{ route('provider.bookings.accept', $booking) }}">
                                        @csrf
                                        <button class="btn btn-sm btn-success" type="submit"
                                            style="margin-right: 5px;">Accept</button>
                                    </form>
                                    <form method="POST" action="{{ route('provider.bookings.reject', $booking) }}">
                                        @csrf
                                        <button class="btn btn-sm btn-danger" type="submit">Decline</button>
                                    </form>
                                </div>
                            @elseif ($booking->status === 'accepted')
                                <form method="POST" action="{{ route('provider.bookings.complete', $booking) }}"
                                    class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-primary cc-btn-outline" type="submit"
                                        @disabled(!$paid)>
                                        Mark Completed
                                    </button>
                                </form>
                                @if (!$paid)
                                    <div class="text-danger small mt-1">Payment must be completed first.</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="fw-semibold">Customer</div>
                            <div class="text-muted">{{ $booking->customer?->name ?? '-' }}</div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="fw-semibold">Service</div>
                            <div class="text-muted">{{ $booking->category?->name ?? ($booking->category?->code ?? '-') }}
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="fw-semibold">Time Slot</div>
                            <div class="text-muted">
                                {{ $booking->slot ? \Carbon\Carbon::parse($booking->slot->start_time)->format('H:i') : '-' }}
                                -
                                {{ $booking->slot ? \Carbon\Carbon::parse($booking->slot->end_time)->format('H:i') : '-' }}
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="fw-semibold">Hours</div>
                            <div class="text-muted">{{ number_format((float) $booking->hours, 2) }}</div>
                        </div>

                        <div class="col-12">
                            <div class="fw-semibold">Address</div>
                            <div class="text-muted">{{ $booking->service_address }} ({{ $booking->zip_code }})</div>
                        </div>

                        @if ($booking->customer_note)
                            <div class="col-12">
                                <div class="fw-semibold">Notes</div>
                                <div class="text-muted">{{ $booking->customer_note }}</div>
                            </div>
                        @endif
                    </div>

                    <hr class="cc-hr">

                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <div class="fw-semibold">Hourly Rate</div>
                            <div class="text-muted">{{ number_format((float) $booking->hourly_rate, 2) }} JOD</div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="fw-semibold">Base Cost</div>
                            <div class="text-muted">{{ number_format((float) $booking->base_cost, 2) }} JOD</div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="fw-semibold">Total</div>
                            <div class="text-muted">{{ number_format((float) $booking->total_cost, 2) }} JOD</div>
                        </div>
                    </div>
                    <div class="text-end">
                        @if (!in_array($booking->status, ['pending', 'accepted'], true))
                            <span class="text-muted small">No actions</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
