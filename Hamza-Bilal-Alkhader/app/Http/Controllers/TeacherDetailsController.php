<?php

namespace App\Http\Controllers;
use App\Models\TeacherProfile;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Models\Favorite;
use App\Models\ReviewReport;

class TeacherDetailsController extends Controller
{
    public function show(TeacherProfile $teacherProfile, Request $request)
    {
        // للـ Guest/Student: ما نعرض إلا approved
        if ($teacherProfile->status !== 'approved') {
            abort(404);
        }

        // تحميل العلاقات + احصائيات التقييم
        $teacherProfile->load(['subject', 'branch', 'user']);
        $teacherProfile->loadCount('reviews');
        $teacherProfile->loadAvg('reviews', 'rating');

        // آخر التقييمات (مع اسم الطالب)
        $reviews = $teacherProfile->reviews()
            ->with(['serviceRequest.student'])
            ->latest()
            ->take(10)
            ->get();

 $reportedReviewIds = collect();
if ($request->user()) {
    $reportedReviewIds = ReviewReport::where('user_id', $request->user()->id)
        ->whereIn('review_id', $reviews->pluck('id'))
        ->pluck('review_id'); // Collection فيها IDs
}



          $reviewableRequest = null;

if ($request->user() && $request->user()->role === 'student') {
    $reviewableRequest = ServiceRequest::query()
        ->where('student_id', $request->user()->id)
        ->where('teacher_profile_id', $teacherProfile->id)
        ->where('status', 'completed')
        ->whereDoesntHave('review')
        ->latest()
        ->first();
}

$isFavorited = false;

if ($request->user() && $request->user()->role === 'student') {
    $isFavorited = Favorite::where('student_id', $request->user()->id)
        ->where('teacher_profile_id', $teacherProfile->id)
        ->exists();
}

  
        return view('student.teacher-details', [
            'teacher' => $teacherProfile,
            'reviews' => $reviews,
            'reviewableRequest' => $reviewableRequest,
            'isFavorited' => $isFavorited,
            'reportedReviewIds' => $reportedReviewIds,

        ]);
    }
}
