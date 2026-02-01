@extends('layouts.admin')
@section('title', 'Edit Coupon')
@section('page-title', 'Edit Coupon')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit Coupon</h5>
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

        <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="code" class="form-label">Coupon Code *</label>
                <input type="text" class="form-control" id="code" name="code" value="{{ old('code', $coupon->code) }}" required>
                <small class="form-text text-muted">Use uppercase letters and numbers only</small>
            </div>

            <div class="mb-3">
                <label for="discount_type" class="form-label">Discount Type *</label>
                <select class="form-select" id="discount_type" name="discount_type" required>
                    <option value="">Select Discount Type</option>
                    <option value="percentage" {{ old('discount_type', $coupon->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage</option>
                    <option value="fixed" {{ old('discount_type', $coupon->discount_type) == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="discount_value" class="form-label">Discount Value *</label>
                <input type="number" class="form-control" id="discount_value" name="discount_value" step="0.01" value="{{ old('discount_value', $coupon->discount_value) }}" required>
                <small class="form-text text-muted">For percentage: 20 = 20%, For fixed: 10 = $10</small>
            </div>

            <div class="mb-3">
                <label for="min_order_amount" class="form-label">Minimum Order Amount</label>
                <input type="number" class="form-control" id="min_order_amount" name="min_order_amount" step="0.01" value="{{ old('min_order_amount', $coupon->min_order_amount) }}">
                <small class="form-text text-muted">Leave blank for no minimum</small>
            </div>

            <div class="mb-3">
                <label for="usage_limit" class="form-label">Usage Limit</label>
                <input type="number" class="form-control" id="usage_limit" name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}">
                <small class="form-text text-muted">Leave blank for unlimited uses</small>
            </div>

            <div class="mb-3">
                <label for="expires_at" class="form-label">Expiration Date</label>
                <input type="datetime-local" class="form-control" id="expires_at" name="expires_at" 
                       value="{{ old('expires_at', $coupon->expires_at ? $coupon->expires_at->format('Y-m-d\TH:i') : '') }}">
                <small class="form-text text-muted">Leave blank for never expiring</small>
            </div>

            <div class="mb-3">
                <label for="is_active" class="form-label">Status *</label>
                <select class="form-select" id="is_active" name="is_active" required>
                    <option value="1" {{ old('is_active', $coupon->is_active) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active', $coupon->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Coupon</button>
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection