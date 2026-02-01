<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\TeacherProfile;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    // صفحة My Requests
    public function index(Request $request)
    {
        $studentId = $request->user()->id;

        $requests = ServiceRequest::query()
            ->where('student_id', $studentId)
            ->with(['review','teacherProfile.subject', 'teacherProfile.branch'])
            ->latest()
            ->paginate(6);

        return view('student.requests', compact('requests'));
    }

    // إنشاء طلب جديد
    public function store(Request $request, TeacherProfile $teacherProfile)
    {
        // فقط للمدرسين approved
        if ($teacherProfile->status !== 'approved') {
            abort(404);
        }

        $studentId = $request->user()->id;

        // منع طلبات مكررة نشطة لنفس المدرس (pending أو accepted)
        $alreadyActive = ServiceRequest::where('student_id', $studentId)
            ->where('teacher_profile_id', $teacherProfile->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->exists();

        if ($alreadyActive) {
            return back()->with('error', 'You already have an active request with this teacher.');
        }

        ServiceRequest::create([
            'student_id' => $studentId,
            'teacher_profile_id' => $teacherProfile->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Request sent successfully.');
    }
}

