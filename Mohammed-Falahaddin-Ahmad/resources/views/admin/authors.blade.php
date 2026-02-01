@extends('layouts.admin')
@section('title', 'Author Management')
@section('page-title', 'Author Management')

@section('content')
<div class="table-container">
    <div class="table-header">
        <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i> Author Management</h5>
        <a href="{{ route('admin.authors.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add Author
        </a>
    </div>
    
    <div style="padding: 0 2rem;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Author Name</th>
                    <th>Bio</th>
                    <th>Books Count</th>
                    <th>Added</th>
                    <th class="text-nowrap">Actions</th> <!-- Prevent wrapping -->
                </tr>
            </thead>
            <tbody>
                @forelse($authors as $author)
                <tr>
                    <td>{{ $author->id }}</td>
                    <td>{{ $author->name }}</td>
                    <td style="max-width: 200px;" class="text-truncate">{{ $author->biography ?? 'N/A' }}</td>
                    <td>{{ $author->books_count }}</td>
                    <td>{{ $author->created_at->format('Y-m-d') }}</td>
                    <td class="text-nowrap">
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.authors.show', $author->id) }}" class="btn btn-sm btn-info action-btn">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            
                            <!-- SweetAlert Delete Button -->
                            <button type="button" 
                                    class="btn btn-sm btn-danger action-btn delete-author-btn" 
                                    data-author-id="{{ $author->id }}"
                                    data-author-name="{{ $author->name }}"
                                    data-books-count="{{ $author->books_count }}"
                                    data-delete-url="{{ route('admin.authors.destroy', $author->id) }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No authors found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>




    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Category pagination">
            <ul class="pagination pagination-sm">
                {{-- Previous --}}
                @if ($authors->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">« Previous</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $authors->previousPageUrl() }}" rel="prev">« Previous</a>
                    </li>
                @endif

                {{-- Next --}}
                @if ($authors->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $authors->nextPageUrl() }}" rel="next">Next »</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">Next »</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>



@endsection


@push('scripts')
<script src="{{ asset('assets/admin/js/authors.js') }}"></script>
@endpush