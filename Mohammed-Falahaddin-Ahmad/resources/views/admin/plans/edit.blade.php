@extends('layouts.admin')
@section('title', 'Edit Subscription Plan')
@section('page-title', 'Edit Subscription Plan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="chart-container">
            <h5 class="mb-4"><i class="fas fa-edit me-2"></i> Edit Plan: {{ $plan->name }}</h5>
            <form action="{{ route('admin.plans.update', $plan) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Plan Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $plan->name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ $plan->description }}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Price ($)</label>
                        <input type="number" step="0.01" name="price" class="form-control" value="{{ $plan->price }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Duration</label>
                        <select name="duration_type" class="form-select" required>
                            <option value="month" {{ $plan->duration_type == 'month' ? 'selected' : '' }}>Monthly</option>
                            <option value="year" {{ $plan->duration_type == 'year' ? 'selected' : '' }}>Yearly</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Book Limit (-1 for unlimited)</label>
                    <input type="number" name="book_limit" class="form-control" value="{{ $plan->book_limit }}" required>
                </div>
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $plan->is_active ? 'checked' : '' }} id="isActive">
                        <label class="form-check-label" for="isActive">Active</label>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Plan</button>
                    <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
