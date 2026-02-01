@extends('layouts.admin')
@section('title', 'Author Details: ' . $author->name)
@section('page-title', 'Author Details')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Author Details</h5>
        <a href="{{ route('admin.authors.index') }}" class="btn btn-secondary">Back to Authors</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <strong>Author Name:</strong> {{ $author->name }}
                </div>

                @if($author->biography)
                    <div class="mb-3">
                        <strong>Biography:</strong>
                        <p>{{ $author->biography }}</p>
                    </div>
                @endif

                <div class="mb-3">
                    <strong>Books Count:</strong> 
                    {{ $author->books->count() ?? 0 }} {{-- Use collection count --}}
                </div>

                <div class="mb-3">
                    <strong>Added:</strong> {{ $author->created_at->format('Y-m-d') }}
                </div>

                @if($author->books->count() > 0)
                    <div class="mt-4">
                        <h6>Books by {{ $author->name }}:</h6>
                        <ul class="list-group">
                            @foreach($author->books as $book)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $book->title }}
                                    <span class="badge bg-primary rounded-pill">{{ $book->created_at->format('Y') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="mt-4">
                        <p>No books found for this author.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('scripts')
    <script src="{{ asset('assets/js/admin-author-show.js') }}"></script>
@endsection
