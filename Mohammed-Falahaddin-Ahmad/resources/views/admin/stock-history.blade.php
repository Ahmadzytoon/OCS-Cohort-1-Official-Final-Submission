@extends('layouts.admin')

@section('title', 'Stock History')
@section('page-title', 'Stock History')

@section('content')
<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-history me-2"></i>
            {{ $book->title }}
        </h5>
        <a href="{{ route('admin.stock.index') }}" class="btn btn-secondary">
            Back to Stock
        </a>
    </div>

    <div class="card-body">

        <div class="mb-3">
            <strong>Current Stock:</strong>
            <span class="badge {{ $book->stock_status_badge_class }}">
                {{ $book->stock_quantity }}
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Change</th>
                        <th>Previous</th>
                        <th>New</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>

                @forelse($adjustments as $adjustment)
                    <tr>
                        <td>{{ $adjustment->created_at->format('Y-m-d H:i') }}</td>
                        <td class="{{ $adjustment->quantity_change > 0 ? 'text-success' : 'text-danger' }}">
                            {{ $adjustment->quantity_change > 0 ? '+' : '' }}{{ $adjustment->quantity_change }}
                        </td>
                        <td>{{ $adjustment->previous_stock }}</td>
                        <td>{{ $adjustment->new_stock }}</td>
                        <td>{{ $adjustment->reason ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No stock adjustments found</td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $adjustments->links() }}
        </div>

    </div>
</div>
@endsection
