@extends('layouts.admin')
@section('title', 'Edit Book')
@section('page-title', 'Edit Book')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit Book</h5>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Basic Info -->
            <div class="mb-3">
                <label for="title" class="form-label">Title *</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $book->title) }}" required>
            </div>

            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN *</label>
                <input type="text" class="form-control" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="author_id" class="form-label">Author *</label>
                    <select class="form-select" id="author_id" name="author_id" required>
                        <option value="">Select Author</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ old('author_id', $book->author_id) == $author->id ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="category_id" class="form-label">Category *</label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Pricing & Stock -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Price *</label>
                    <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" value="{{ old('price', $book->price) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="stock_quantity" class="form-label">Stock Quantity *</label>
                    <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" min="0" value="{{ old('stock_quantity', $book->stock_quantity) }}" required>
                </div>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label for="status" class="form-label">Status *</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Active" {{ old('status', $book->status) == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ old('status', $book->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <!-- Cover Image -->
            <div class="mb-3">
                <label for="cover_image" class="form-label">Cover Image</label>
                <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*">
                @if($book->cover_image)
                    <div class="mt-2">
                        <img src="{{ asset('uploads/books/' . $book->cover_image) }}" alt="Current Cover" style="width:100px; height:auto; border-radius:5px;">
                        <br>
                        <small>Current cover image</small>
                    </div>
                @endif
            </div>

            <!-- Descriptions -->
            <div class="mb-3">
                <label for="description" class="form-label">Short Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Brief description shown in listings">{{ old('description', $book->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="long_description" class="form-label">Long Description</label>
                <textarea class="form-control" id="long_description" name="long_description" rows="5" placeholder="Detailed description shown on product page">{{ old('long_description', $book->long_description) }}</textarea>
            </div>

            <!-- Book Details -->
            <h6 class="mt-4 mb-3">Book Details</h6>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="language" class="form-label">Language</label>
                    <input type="text" class="form-control" id="language" name="language" value="{{ old('language', $book->language) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="format" class="form-label">Format</label>
                    <select class="form-select" id="format" name="format">
                        <option value="Hardcover" {{ old('format', $book->format) == 'Hardcover' ? 'selected' : '' }}>Hardcover</option>
                        <option value="Paperback" {{ old('format', $book->format) == 'Paperback' ? 'selected' : '' }}>Paperback</option>
                        <option value="eBook" {{ old('format', $book->format) == 'eBook' ? 'selected' : '' }}>eBook</option>
                        <option value="Audiobook" {{ old('format', $book->format) == 'Audiobook' ? 'selected' : '' }}>Audiobook</option>
                        <option value="Other" {{ old('format', $book->format) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="pages" class="form-label">Number of Pages</label>
                    <input type="number" class="form-control" id="pages" name="pages" min="1" value="{{ old('pages', $book->pages) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="country" class="form-label">Country of Publication</label>
                    <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $book->country) }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="publish_date" class="form-label">Publish Date</label>
                    <input type="date" class="form-control" id="publish_date" name="publish_date" value="{{ old('publish_date', $book->publish_date?->format('Y-m-d')) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="publish_year" class="form-label">Publish Year</label>
                    <input type="number" class="form-control" id="publish_year" name="publish_year" min="1000" max="{{ date('Y') }}" value="{{ old('publish_year', $book->publish_year) }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="dimensions" class="form-label">Dimensions (e.g., 6 x 9 in)</label>
                    <input type="text" class="form-control" id="dimensions" name="dimensions" placeholder="e.g., 15 x 23 cm" value="{{ old('dimensions', $book->dimensions) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="weight" class="form-label">Weight (kg)</label>
                    <input type="number" class="form-control" id="weight" name="weight" step="0.01" min="0" placeholder="e.g., 0.5" value="{{ old('weight', $book->weight) }}">
                </div>
            </div>

            <div class="mb-3">
                <label for="tags" class="form-label">Tags (comma-separated)</label>
                <input type="text" class="form-control" id="tags" name="tags" placeholder="e.g., Fiction, Bestseller, Adventure" value="{{ old('tags', $book->tags) }}">
            </div>

            <!-- Submit Buttons -->
            <button type="submit" class="btn btn-primary">Update Book</button>
            <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection