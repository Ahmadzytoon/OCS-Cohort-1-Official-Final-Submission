@extends('layouts.admin')
@section('title', 'Edit Author')
@section('page-title', 'Edit Author')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit Author</h5>
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

        <form action="{{ route('admin.authors.update', $author->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="name" class="form-label">Author Name *</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $author->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="biography" class="form-label">Biography</label>
                <textarea class="form-control" id="biography" name="biography" rows="4">{{ old('biography', $author->biography) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Author</button>
            <a href="{{ route('admin.authors.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection