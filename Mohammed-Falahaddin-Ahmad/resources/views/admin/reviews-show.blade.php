@extends('layouts.admin')
@section('title', 'Review Details')
@section('page-title', 'Review Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-search me-2 text-primary"></i> Review #{{ $review->id }}</h5>
                    <div class="status-badge">
                        <span class="badge {{ $review->is_approved ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $review->is_approved ? 'Approved' : 'Pending Approval' }}
                        </span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase fw-bold">Reviewer</label>
                            <p class="fs-5 mb-0">{{ $review->user->name ?? $review->customer_name }}</p>
                            <span class="text-muted small">{{ $review->user->email ?? $review->customer_email }}</span>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <label class="text-muted small text-uppercase fw-bold">Date Submitted</label>
                            <p class="mb-0">{{ $review->created_at->format('M d, Y - H:i') }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Book Reviewed</label>
                        <div class="d-flex align-items-center mt-2">
                            @if($review->book->cover_image)
                                <img src="{{ asset('uploads/books/' . $review->book->cover_image) }}" alt="cover" class="rounded me-3" style="width: 50px; height: 75px; object-fit: cover;">
                            @endif
                            <div>
                                <h6 class="mb-0">{{ $review->book->title }}</h6>
                                <span class="text-muted small">ISBN: {{ $review->book->isbn }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Rating</label>
                        <div class="star-rating fs-4 mt-2">
                            {!! $review->rating_stars !!}
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Comment</label>
                        <div class="bg-light p-3 rounded mt-2">
                            <p class="mb-0" style="white-space: pre-wrap;">{{ $review->comment }}</p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
