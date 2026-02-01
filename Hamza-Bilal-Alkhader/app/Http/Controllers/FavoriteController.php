<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\TeacherProfile;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    // صفحة favorites للطالب
    public function index(Request $request)
    {
        $studentId = $request->user()->id;

        $favorites = Favorite::query()
            ->where('student_id', $studentId)
            ->with([
                'teacherProfile' => function ($q) {
                    $q->with(['subject', 'branch'])
                      ->withCount('reviews')
                      ->withAvg('reviews', 'rating');
                }
            ])
            ->latest()
            ->paginate(6);

        return view('student.favorites', compact('favorites'));
    }

    // Toggle add/remove
    public function toggle(Request $request, TeacherProfile $teacherProfile)
    {
        // ما نسمح إلا للـ approved
        if ($teacherProfile->status !== 'approved') {
            abort(404);
        }

        $studentId = $request->user()->id;

        $fav = Favorite::where('student_id', $studentId)
            ->where('teacher_profile_id', $teacherProfile->id)
            ->first();

        if ($fav) {
            $fav->delete();
        } else {
            Favorite::create([
                'student_id' => $studentId,
                'teacher_profile_id' => $teacherProfile->id,
            ]);
        }

        return back();
    }

    // حذف من صفحة favorites
    public function destroy(Request $request,Favorite $favorite)
    {
        if ($favorite->student_id !== $request->user()->id) {
            abort(403);
        }

        $favorite->delete();

        return back();
    }
}
