@extends('layouts.admin')
@section('title', 'Reviews Management')
@section('page-title', 'Reviews Management')

@section('content')
<div class="table-container">
    <div class="table-header">
        <h5 class="mb-0"><i class="fas fa-star me-2"></i> Reviews Management</h5>
    </div>
    
    <div style="padding: 0 2rem;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Filters -->
        <form method="GET" action="{{ route('admin.reviews.index') }}" class="row mb-4 g-3">
            <div class="col-md-3">
                <select class="form-select" name="rating">
                    <option value="">All Ratings</option>
                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Reviewer</th>
                    <th>Book</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr>
                    <td>{{ $review->user->name ?? 'Anonymous' }}</td>
                    <td>{{ $review->book->title ?? 'N/A' }}</td>
                    <td>{!! $review->rating_stars !!}</td>
                    <td>{{ Str::limit($review->comment, 50) }}</td>
                    <td>{{ $review->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-sm btn-info text-white me-2">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this review?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No reviews found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $reviews->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto-dismiss success alert after 3 seconds
document.addEventListener('DOMContentLoaded', function() {
    const successAlert = document.getElementById('success-alert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.classList.remove('show');
            successAlert.classList.add('fade');
            setTimeout(() => successAlert.remove(), 150);
        }, 3000);
    }
});
</script>
@endpush