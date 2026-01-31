<?php

namespace App\Http\Controllers;

use App\Models\Review;

class AdminReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with([
                'serviceRequest.student',
                'serviceRequest.teacherProfile',
            ])
            ->latest()
            ->get();

        return view('admin.reviews', compact('reviews'));
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted successfully.');
    }

    public function reported()
{
    $reviews = Review::query()
        ->whereHas('reports') // فقط الريفيو اللي عليها تقارير
        ->withCount('reports') // reports_count
        ->with([
            'serviceRequest.student',
            'serviceRequest.teacherProfile',
        ])
        ->latest()
        ->get();

    return view('admin.reported-reviews', compact('reviews'));
}

}
