<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $query = Coupon::orderBy('created_at', 'desc');
        
        // Filter by status
        $query->when($request->filled('status'), function($q) use ($request) {
            $q->where('is_active', '=', $request->status === 'active' ? 1 : 0);
        });
        
        // Filter by expiration
        $query->when($request->filled('expiration'), function($q) use ($request) {
            switch ($request->expiration) {
                case 'expired':
                    $q->whereNotNull('expires_at')->where('expires_at', '<', now());
                    break;
                case 'active':
                    $q->where(function ($sub) {
                        $sub->whereNull('expires_at')
                            ->orWhere('expires_at', '>=', now());
                    });
                    break;
            }
        });
        
        $coupons = $query->simplePaginate(5);
        
        return view('admin.coupons', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
            'is_active' => 'required|boolean',
        ]);

        // Handle empty expiration date properly
        $expiresAt = $request->expires_at ? Carbon::parse($request->expires_at) : null;

        Coupon::create([
            'code' => strtoupper(trim($request->code)),
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order_amount' => $request->min_order_amount,
            'usage_limit' => $request->usage_limit,
            'used_count' => 0,
            'expires_at' => $expiresAt,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully!');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons-edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code,' . $coupon->id,
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
            'is_active' => 'required|boolean',
        ]);

        // Handle empty expiration date properly
        $expiresAt = $request->expires_at ? Carbon::parse($request->expires_at) : null;

        $coupon->update([
            'code' => strtoupper(trim($request->code)),
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order_amount' => $request->min_order_amount,
            'usage_limit' => $request->usage_limit,
            'used_count' => $coupon->used_count, // Preserve existing usage count
            'expires_at' => $expiresAt,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated successfully!');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully!');
    }

    public function toggleStatus(Coupon $coupon)
    {
        $coupon->update(['is_active' => !$coupon->is_active]);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon status updated successfully!');
    }
}