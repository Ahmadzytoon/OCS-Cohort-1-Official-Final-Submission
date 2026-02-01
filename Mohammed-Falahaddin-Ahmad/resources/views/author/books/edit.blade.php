@extends('layouts.admin')
@section('title', 'Edit Book')
@section('page-title', 'Edit Book')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="table-container">
            <div class="table-header border-bottom pb-3 mb-4">
                <h5><i class="fas fa-edit me-2"></i> Edit Book: {{ $book->title }}</h5>
                <a href="{{ route('author.books') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>

            <form action="{{ route('author.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">Book Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $book->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="5" required>{{ $book->description }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $book->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price ($)</label>
                            <input type="number" name="price" step="0.01" class="form-control" value="{{ $book->price }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stock Quantity</label>
                            <input type="number" name="stock_quantity" class="form-control" value="{{ $book->stock_quantity }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cover Image</label>
                            <input type="file" name="cover_image" class="form-control" accept="image/*">
                            @if($book->cover_image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Current Cover" style="width: 100px; height: 140px; object-fit: cover; border-radius: 4px;">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="fas fa-save me-1"></i> Update Book
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
