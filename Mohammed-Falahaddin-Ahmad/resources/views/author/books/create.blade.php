@extends('layouts.admin')
@section('title', 'Add New Book')
@section('page-title', 'Add New Book')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="table-container">
            <div class="table-header border-bottom pb-3 mb-4">
                <h5><i class="fas fa-plus-circle me-2"></i> Book Information</h5>
                <a href="{{ route('author.books') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>

            <form action="{{ route('author.books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">Book Title</label>
                            <input type="text" name="title" class="form-control" required placeholder="Enter book title">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="5" required placeholder="Enter book description"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price ($)</label>
                            <input type="number" name="price" step="0.01" class="form-control" required placeholder="0.00">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stock Quantity</label>
                            <input type="number" name="stock_quantity" class="form-control" required placeholder="0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cover Image</label>
                            <input type="file" name="cover_image" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="fas fa-save me-1"></i> Publish Book
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
