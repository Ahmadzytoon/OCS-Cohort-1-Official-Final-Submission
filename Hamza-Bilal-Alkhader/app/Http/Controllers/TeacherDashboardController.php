<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Subject;
use App\Models\TeacherProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestStatusChanged;


class TeacherDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $profile = $user->teacherProfile;

        $subjects = Subject::orderBy('name')->get();
        $branches = Branch::orderBy('name')->get();

        $requests = $profile
            ? $profile->serviceRequests()->with('student')->latest()->get()
            : collect();

        return view('teacher.dashboard', compact('profile', 'subjects', 'branches', 'requests'));
    }

    public function saveProfile(Request $request)
    {
        $user = $request->user();
        $profile = $user->teacherProfile; 

        $data = $request->validate([
            'display_name' => ['required', 'string', 'max:255'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'branch_id' => ['required', 'exists:branches,id'],
            'experience_years' => ['required', 'integer', 'min:0', 'max:60'],
            'phone' => ['required', 'string', 'max:30'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        // رفع/تحديث الصورة
        if ($request->hasFile('image')) {
            if ($profile && $profile->image_path) {
                Storage::disk('public')->delete($profile->image_path);
            }
            $data['image_path'] = $request->file('image')->store('teachers', 'public');
        }

        // create أول مرة
        if (!$profile) {
            $data['user_id'] = $user->id;
            $data['status'] = 'pending';
            $data['is_featured'] = false;

            TeacherProfile::create($data);

            return back()->with('success', 'Profile submitted for review.');
        }

        // update
        $profile->update($data);
        return back()->with('success', 'Profile updated successfully.');
    }

    public function deleteProfile(Request $request)
    {
        $profile = $request->user()->teacherProfile;

        if (!$profile) {
            return back()->with('error', 'No profile found');
        }

        if ($profile->image_path) {
            Storage::disk('public')->delete($profile->image_path);
        }

        $profile->delete();

        return back()->with('success', 'Profile deleted successfully.');
    }
    

    public function acceptRequest(Request $request, ServiceRequest $serviceRequest)
{
    $profile = $request->user()->teacherProfile;

    if (!$profile || $serviceRequest->teacher_profile_id !== $profile->id) {
        abort(403);
    }

    if ($serviceRequest->status !== 'pending') {
        return back()->with('error', 'Only pending requests can be accepted.');
    }

    $serviceRequest->update(['status' => 'accepted']);

// إرسال إيميل للطالب
Mail::to($serviceRequest->student->email)
    ->send(new RequestStatusChanged($serviceRequest));

    return back()->with('success', 'Request accepted successfully.');
}

public function rejectRequest(Request $request, ServiceRequest $serviceRequest)
{
    $profile = $request->user()->teacherProfile;

    if (!$profile || $serviceRequest->teacher_profile_id !== $profile->id) {
        abort(403);
    }

    if (!in_array($serviceRequest->status, ['pending', 'accepted'])) {
        return back()->with('error', 'Only pending/accepted requests can be rejected.');
    }

    $serviceRequest->update(['status' => 'rejected']);

    // إرسال إيميل للطالب
Mail::to($serviceRequest->student->email)
    ->send(new RequestStatusChanged($serviceRequest));

    return back()->with('success', 'Request rejected successfully.');
}

public function completeRequest(Request $request, ServiceRequest $serviceRequest)
{
    $profile = $request->user()->teacherProfile;

    if (!$profile || $serviceRequest->teacher_profile_id !== $profile->id) {
        abort(403);
    }

    if ($serviceRequest->status !== 'accepted') {
        return back()->with('error', 'Only accepted requests can be completed.');
    }

    $serviceRequest->update(['status' => 'completed']);

    // إرسال إيميل للطالب
Mail::to($serviceRequest->student->email)
    ->send(new RequestStatusChanged($serviceRequest));
    
    return back()->with('success', 'Request marked as completed.');
}


}
