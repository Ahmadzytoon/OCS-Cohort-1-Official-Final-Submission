@extends('layouts.admin')
@section('title', 'Category Management')
@section('page-title', 'Category Management')

@section('content')
<div class="table-container">
    <div class="table-header">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i> Category Management</h5>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add Category
        </a>
    </div>
    
    <div style="padding: 0 2rem;">


    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Books Count</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>
                        @if($category->parent_id)
                            <span class="text-muted ms-3">└─</span> {{ $category->name }}
                            <small class="text-muted">({{ $category->parent->name }})</small>
                        @else
                            <strong>{{ $category->name }}</strong>
                        @endif
                    </td>
                    <td>{{ $category->books_count }}</td>
                  
                    <td>{{ $category->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-warning action-btn">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        <button type="button" 
                                class="btn btn-sm btn-danger action-btn delete-category-btn" 
                                data-category-id="{{ $category->id }}"
                                data-category-name="{{ $category->name }}"
                                data-books-count="{{ $category->books_count }}"
                                data-delete-url="{{ route('admin.categories.destroy', $category->id) }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No categories found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Category pagination">
            <ul class="pagination pagination-sm">
                {{-- Previous --}}
                @if ($categories->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">« Previous</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $categories->previousPageUrl() }}" rel="prev">« Previous</a>
                    </li>
                @endif

                {{-- Next --}}
                @if ($categories->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $categories->nextPageUrl() }}" rel="next">Next »</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">Next »</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>

</div>
@endsection









@push('scripts')
<script src="{{ asset('assets/admin/js/categories.js') }}"></script>
@endpush