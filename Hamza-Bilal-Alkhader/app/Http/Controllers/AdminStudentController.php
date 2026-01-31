<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class AdminStudentController extends Controller
{
    //
     public function index()
    {
        $students = User::where('role', 'student')
            ->latest()
            ->get();

        return view('admin.students', compact('students'));
    }

    public function destroy(User $student)
    {
       
        if ($student->role !== 'student') {
            return back()->with('error', 'You can only delete student accounts.');
        }

        $student->delete();

        return back()->with('success', 'Student deleted successfully.');
    }
}
