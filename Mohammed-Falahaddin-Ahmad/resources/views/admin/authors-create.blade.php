@extends('layouts.admin')
@section('title', 'Add New Author')
@section('page-title', 'Add New Author')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Add New Author</h5>
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

        <form action="{{ route('admin.authors.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="name" class="form-label">Author Name *</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="biography" class="form-label">Biography</label>
                <textarea class="form-control" id="biography" name="biography" rows="4">{{ old('biography') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save Author</button>
            <a href="{{ route('admin.authors.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection