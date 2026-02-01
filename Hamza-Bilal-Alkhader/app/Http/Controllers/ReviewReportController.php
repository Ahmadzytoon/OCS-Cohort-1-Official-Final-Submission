<?php

namespace App\Http\Controllers;
use App\Models\Review;
use App\Models\ReviewReport;
use Illuminate\Http\Request;

class ReviewReportController extends Controller
{
    public function store(Request $request,Review $review)
    {
        $already = ReviewReport::where('review_id', $review->id)
            ->where('user_id', $request->user()->id)
            ->exists();

        if ($already) {
            return back()->with('error', 'You already reported this review.');
        }

        ReviewReport::create([
            'review_id' => $review->id,
            'user_id'   => $request->user()->id,
        ]);

        return back()->with('success', 'Report submitted. Thank you!');
    }
}
