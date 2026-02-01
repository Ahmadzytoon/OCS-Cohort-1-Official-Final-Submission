@extends('layouts.admin')
@section('title', 'My Books')
@section('page-title', 'My Books')

@section('content')
<div class="table-container">
    <div class="table-header">
        <h5><i class="fas fa-book me-2"></i> Manage My Books</h5>
        <a href="{{ route('author.books.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Add New Book
        </a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Cover</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Sales</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                <tr>
                    <td>
                        <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('assets/img/default-book.png') }}" 
                             alt="Cover" style="width: 40px; height: 60px; object-fit: cover; border-radius: 4px;">
                    </td>
                    <td class="font-weight-bold">{{ $book->title }}</td>
                    <td>{{ $book->category->name }}</td>
                    <td>${{ number_format($book->price, 2) }}</td>
                    <td>
                        @if($book->stock_quantity <= 5)
                            <span class="text-danger font-weight-bold">{{ $book->stock_quantity }}</span>
                        @else
                            {{ $book->stock_quantity }}
                        @endif
                    </td>
                    <td>{{ $book->sales_count }}</td>
                    <td>
                        <span class="status-badge {{ $book->status === 'Active' ? 'badge-active' : 'badge-inactive' }}">
                            {{ $book->status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('author.books.edit', $book->id) }}" class="btn btn-sm btn-info text-white">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-muted">You haven't added any books yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $books->links() }}
    </div>
</div>
@endsection
