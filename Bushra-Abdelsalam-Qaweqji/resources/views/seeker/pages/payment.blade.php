@extends('seeker.layouts.app')
@section('title', 'Cleanova | Payment')

@section('content')
    <section class="cc-section pt-4">
        <div class="container">
            <div class="mb-3">
                <a href="{{ route('seeker.bookings.show', $booking) }}" class="cc-back-link">&larr; Back to booking</a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    Please fix the highlighted payment fields.
                </div>
            @endif

            <div class="row g-4 align-items-start">
                <div class="col-12 col-lg-8">
                    <div class="card cc-shell-card mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="fw-bold mb-1">Pay with PayPal</h4>
                                    <div class="text-muted small">
                                        You will be redirected to PayPal to complete the payment.
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="text-muted small">Total</div>
                                    <div class="fw-bold fs-5">{{ number_format((float) $booking->total_cost, 2) }} JOD</div>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('seeker.paypal.create') }}">
                                @csrf
                                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                <input type="hidden" name="amount" value="{{ number_format((float) $booking->total_cost, 2, '.', '') }}">

                                <div class="d-grid d-sm-flex justify-content-sm-end gap-2">
                                    <a href="{{ route('seeker.bookings.show', $booking) }}" class="btn btn-outline-secondary">
                                        Cancel
                                    </a>
                                    <button class="btn btn-primary" type="submit">
                                        Pay with PayPal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

                <div class="col-12 col-lg-4">
                    <div class="card cc-shell-card">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Booking Summary</h5>
                            <div class="mb-2">
                                <div class="text-muted small">Provider</div>
                                <div class="fw-semibold">{{ $booking->provider?->name ?? '-' }}</div>
                            </div>
                            <div class="mb-2">
                                <div class="text-muted small">Service</div>
                                <div class="fw-semibold">{{ $booking->category?->name ?? $booking->category?->code ?? '-' }}</div>
                            </div>
                            <div class="mb-2">
                                <div class="text-muted small">Hours</div>
                                <div class="fw-semibold">{{ number_format((float) $booking->hours, 2) }}</div>
                            </div>
                            <hr class="cc-hr">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Total</span>
                                <strong>{{ number_format((float) $booking->total_cost, 2) }} JOD</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
