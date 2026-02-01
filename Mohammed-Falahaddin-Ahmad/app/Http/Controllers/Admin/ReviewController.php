<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['user', 'book'])->orderBy('created_at', 'desc');
        
        // Filter by approval status
        $query->when($request->filled('approval_status'), function($q) use ($request) {
            $q->where('is_approved', '=', $request->approval_status === 'approved' ? 1 : 0);
        });
        
        // Filter by rating
        $query->when($request->filled('rating'), function($q) use ($request) {
            $q->where('rating', $request->rating);
        });
        
        $reviews = $query->simplePaginate(5);
        
        return view('admin.reviews', compact('reviews'));
    }

    public function show(Review $review)
    {
        return view('admin.reviews-show', compact('review'));
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully!');
    }
}