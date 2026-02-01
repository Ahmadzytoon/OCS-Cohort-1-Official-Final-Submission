<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminTeacherController extends Controller
{
    public function index()
    {
        $teachers = User::where('role', 'teacher')
            ->latest()
            ->get();

        return view('admin.teachers', compact('teachers'));
    }

    public function destroy(User $teacher)
    {
      
        if ($teacher->role !== 'teacher') {
            return back()->with('error', 'Invalid user.');
        }

        $teacher->delete();
        return back()->with('success', 'Teacher deleted successfully.');
    }
}
