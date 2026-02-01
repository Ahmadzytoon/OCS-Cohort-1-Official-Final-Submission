@extends('layouts.admin')
@section('title', 'Subscription Plans')
@section('page-title', 'Subscription Plans')

@section('content')
<div class="table-container">
    <div class="table-header">
        <h5 class="mb-0"><i class="fas fa-layer-group me-2"></i> Subscription Plans</h5>
        <a href="{{ route('admin.plans.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Create Plan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Book Limit</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($plans as $plan)
                <tr>
                    <td>{{ $plan->name }}</td>
                    <td>${{ number_format($plan->price, 2) }}</td>
                    <td>Per {{ ucfirst($plan->duration_type) }}</td>
                    <td>{{ $plan->book_limit < 0 ? 'Unlimited' : $plan->book_limit }}</td>
                    <td>
                        <span class="badge {{ $plan->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $plan->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.plans.edit', $plan) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.plans.update', $plan) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="name" value="{{ $plan->name }}">
                                <input type="hidden" name="price" value="{{ $plan->price }}">
                                <input type="hidden" name="duration_type" value="{{ $plan->duration_type }}">
                                <input type="hidden" name="book_limit" value="{{ $plan->book_limit }}">
                                @if($plan->is_active)
                                    <button type="submit" class="btn btn-sm btn-danger" name="toggle_status" value="0">
                                        <i class="fas fa-times-circle"></i> Deactivate
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-sm btn-success" name="is_active" value="1">
                                        <i class="fas fa-check-circle"></i> Activate
                                    </button>
                                @endif
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
