@extends('layouts.admin')
@section('title', 'Coupons & Discounts')
@section('page-title', 'Coupons & Discounts')

@section('content')
<div class="table-container">
    <div class="table-header">
        <h5 class="mb-0"><i class="fas fa-tags me-2"></i> Coupons & Discounts</h5>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add Coupon
        </a>
    </div>
    
    <div style="padding: 0 2rem;">
        <!-- Filters -->
        <form method="GET" action="{{ route('admin.coupons.index') }}" class="row mb-4 g-3">
            <div class="col-md-3">
                <select class="form-select" name="status">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" name="expiration">
                    <option value="">All Expiration</option>
                    <option value="active" {{ request('expiration') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="expired" {{ request('expiration') == 'expired' ? 'selected' : '' }}>Expired</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Value</th>
                    <th>Min Order</th>
                    <th>Usage Limit</th>
                    <th>Used</th>
                    <th>Expires</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coupons as $coupon)
                <tr>
                    <td><code>{{ $coupon->code }}</code></td>
                    <td>{{ ucfirst($coupon->discount_type) }}</td>
                    <td>{{ $coupon->discount_type === 'percentage' ? $coupon->discount_value . '%' : '$' . number_format($coupon->discount_value, 2) }}</td>
                    <td>{{ $coupon->min_order_amount ? '$' . number_format($coupon->min_order_amount, 2) : 'N/A' }}</td>
                    <td>{{ $coupon->usage_limit ?? 'Unlimited' }}</td>
                    <td>{{ $coupon->used_count }}</td>
                    <td>{{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : 'Never' }}</td>
                    <td><span class="badge {{ $coupon->status_badge_class }}">{{ $coupon->status_label }}</span></td>
                    <td>
                        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-sm btn-warning action-btn">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger action-btn delete-coupon-btn" data-coupon-code="{{ $coupon->code }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">No coupons found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $coupons->links() }}
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('assets/js/coupons.js') }}"></script>
@endpush