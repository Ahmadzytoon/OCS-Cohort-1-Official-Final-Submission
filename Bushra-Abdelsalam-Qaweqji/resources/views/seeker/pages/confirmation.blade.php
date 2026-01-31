@extends('seeker.layouts.app')
@section('title', 'Cleanova | Booking Confirmed')

@section('content')
    <section class="cc-section pt-4">
        <div class="container">
            <div class="card cc-shell-card">
                <div class="card-body p-4 text-center">
                    <h3 class="fw-bold mb-2">Booking Created</h3>
                    <p class="text-muted">Your booking is now pending. We will notify you when the provider confirms.</p>

                    <div class="d-flex justify-content-center gap-2 mt-3">
                        <a href="{{ route('seeker.bookings.index') }}" class="btn btn-primary cc-btn-primary">
                            View My Bookings
                        </a>
                        <a href="{{ route('seeker.dashboard') }}" class="btn btn-outline-primary cc-btn-outline">
                            Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

