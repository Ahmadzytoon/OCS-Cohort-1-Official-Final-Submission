@extends('layouts.admin')
@section('title', 'Book Details: ' . $book->title)
@section('page-title', 'Book Details')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Book Details</h5>
        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Back to Books</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 text-center">
                @if($book->cover_image)
                    <img src="{{ asset('uploads/books/' . $book->cover_image) }}" alt="Cover" style="max-width: 100%; height: auto; border-radius: 5px;">
                @else
                    <div style="width: 200px; height: 300px; background: #ddd; border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-book fa-3x text-muted"></i>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <div class="mb-3">
                    <strong>Title:</strong> {{ $book->title }}
                </div>
                <div class="mb-3">
                    <strong>ISBN:</strong> {{ $book->isbn }}
                </div>
                <div class="mb-3">
                    <strong>Author:</strong> {{ $book->author->name ?? 'N/A' }}
                </div>
                <div class="mb-3">
                    <strong>Category:</strong> {{ $book->category->name ?? 'N/A' }}
                </div>
                <div class="mb-3">
                    <strong>Price:</strong> ${{ number_format($book->price, 2) }}
                </div>
                <div class="mb-3">
                    <strong>Stock Quantity:</strong> {{ $book->stock_quantity }}
                </div>
                <div class="mb-3">
                    <strong>Status:</strong> 
                    <span class="status-badge {{ $book->status == 'Active' ? 'badge-active' : 'badge-inactive' }}">
                        {{ $book->status }}
                    </span>
                </div>
                @if($book->description)
                    <div class="mb-3">
                        <strong>Description:</strong>
                        <p>{{ $book->description }}</p>
                    </div>
                @endif
                <div class="mt-4">
                    <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i> Edit Book
                    </a>
                    <button type="button" class="btn btn-danger delete-book-btn" 
                            data-book-id="{{ $book->id }}"
                            data-book-title="{{ $book->title }}"
                            data-delete-url="{{ route('admin.books.destroy', $book->id) }}">
                        <i class="fas fa-trash me-2"></i> Delete Book
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/books-show.js') }}"></script>
@endpush