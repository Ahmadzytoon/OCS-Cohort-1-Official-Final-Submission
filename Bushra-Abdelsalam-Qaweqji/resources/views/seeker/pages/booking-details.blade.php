@extends('seeker.layouts.app')
@section('title', 'Cleanova | Booking Details')

@section('content')
    <section class="cc-section pt-4">
        <div class="container">
            <div class="mb-3">
                <a href="{{ route('seeker.bookings.index') }}" class="cc-back-link">&larr; Back to bookings</a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
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
                            <div class="text-muted small">Payment: {{ $paid ? 'Paid' : 'Unpaid' }}</div>
                        </div>
                        @if ($booking->status === 'accepted' && !$paid)
                            <a href="{{ route('seeker.bookings.pay.form', $booking) }}" class="btn btn-success">
                                Pay Now
                            </a>
                        @endif
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="fw-semibold">Provider</div>
                            <div class="text-muted">{{ $booking->provider?->name ?? '-' }}</div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="fw-semibold">Service</div>
                            <div class="text-muted">{{ $booking->category?->name ?? $booking->category?->code ?? '-' }}</div>
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

                </div>
            </div>

            <div class="card cc-shell-card mt-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Review</h5>

                    @if ($booking->review)
                        <div class="mb-2">
                            <div class="fw-semibold">Your Rating</div>
                            <div class="text-muted">{{ $booking->review->rating }} / 5</div>
                        </div>
                        @if ($booking->review->comment)
                            <div>
                                <div class="fw-semibold">Comment</div>
                                <div class="text-muted">{{ $booking->review->comment }}</div>
                            </div>
                        @endif
                    @elseif ($booking->status === 'completed')
                        <form method="POST" action="{{ route('seeker.bookings.review', $booking) }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Rating</label>
                                <select name="rating" class="form-select" required>
                                    <option value="">Select rating</option>
                                    @for ($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Comment (optional)</label>
                                <textarea name="comment" class="form-control" rows="3" maxlength="1000"></textarea>
                            </div>
                            <button class="btn btn-primary cc-book-btn" type="submit">Submit Review</button>
                        </form>
                    @else
                        <div class="text-muted">You can review this booking after it is completed.</div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

