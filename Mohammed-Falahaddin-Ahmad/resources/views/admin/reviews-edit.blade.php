@extends('layouts.admin')
@section('title', 'Edit Review')
@section('page-title', 'Edit Review')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-edit me-2 text-warning"></i> Edit Review #{{ $review->id }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Reviewer</label>
                                <input type="text" class="form-control bg-light" value="{{ $review->user->name ?? $review->customer_name }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Book</label>
                                <input type="text" class="form-control bg-light" value="{{ $review->book->title }}" readonly>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="rating" class="form-label fw-bold">Rating*</label>
                            <select name="rating" id="rating" class="form-select @error('rating') is-invalid @enderror" required>
                                <option value="5" {{ old('rating', $review->rating) == 5 ? 'selected' : '' }}>5 Stars</option>
                                <option value="4" {{ old('rating', $review->rating) == 4 ? 'selected' : '' }}>4 Stars</option>
                                <option value="3" {{ old('rating', $review->rating) == 3 ? 'selected' : '' }}>3 Stars</option>
                                <option value="2" {{ old('rating', $review->rating) == 2 ? 'selected' : '' }}>2 Stars</option>
                                <option value="1" {{ old('rating', $review->rating) == 1 ? 'selected' : '' }}>1 Star</option>
                            </select>
                            @error('rating')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="comment" class="form-label fw-bold">Comment*</label>
                            <textarea name="comment" id="comment" rows="6" class="form-control @error('comment') is-invalid @enderror" required>{{ old('comment', $review->comment) }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Approval Status</label>
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_approved" value="0">
                                <input class="form-check-input" type="checkbox" name="is_approved" id="is_approved" value="1" {{ old('is_approved', $review->is_approved) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_approved">Approved</label>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Update Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
