<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class StudentReviewController extends Controller
{
    public function store(Request $request, ServiceRequest $serviceRequest)
    {
        $studentId = $request->user()->id;

        // لازم الريكويست يكون للطالب نفسه
        if ($serviceRequest->student_id !== $studentId) {
            abort(403);
        }

        // لازم يكون Completed
        if ($serviceRequest->status !== 'completed') {
            return back()->with('error', 'You can review only after the request is completed.');
        }

        // ممنوع أكثر من review لنفس request
        if ($serviceRequest->review()->exists()) {
            return back()->with('error', 'You already reviewed this completed request.');
        }

        $data = $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:2000'],
        ]);

        Review::create([
            'service_request_id' => $serviceRequest->id,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
        ]);

        return back()->with('success', 'Review submitted successfully.');
    }

 

    public function destroy(Request $request, Review $review)
    {
          $studentId = $request->user()->id;

          if (!$review->serviceRequest || $review->serviceRequest->student_id !==$studentId) {
            abort(403);
        }

        $review->delete();

        return back()->with('success', 'Review deleted successfully.');
    }
}
