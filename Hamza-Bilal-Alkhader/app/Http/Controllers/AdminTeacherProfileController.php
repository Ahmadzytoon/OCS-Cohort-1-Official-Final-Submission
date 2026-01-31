<?php

namespace App\Http\Controllers;

use App\Models\TeacherProfile;

class AdminTeacherProfileController extends Controller
{
    public function index()
    {
        $profiles = TeacherProfile::with(['user', 'subject', 'branch'])
            ->latest()
            ->get();

        return view('admin.teacher-profiles', compact('profiles'));
    }

    public function show(TeacherProfile $profile)
    {
        $profile->load(['user', 'subject', 'branch']);
        return view('admin.teacher-profile-show', compact('profile'));
    }

    public function approve(TeacherProfile $profile)
    {
        $profile->update(['status' => 'approved']);
        return back()->with('success', 'Profile approved.');
    }

    public function reject(TeacherProfile $profile)
    {
        $profile->update(['status' => 'rejected']);
        return back()->with('success', 'Profile rejected.');
    }

    public function toggleFeatured(TeacherProfile $profile)
    {
        $profile->update(['is_featured' => !$profile->is_featured]);
        return back()->with('success', 'Paid status updated.');
    }
}
