<?php

namespace App\Http\Controllers;

use App\Models\TeacherProfile;
use App\Models\Subject;
use App\Models\Branch;
use Illuminate\Http\Request;

class TeacherListController extends Controller
{
    public function index(Request $request)
    {
        // base query: approved teachers only + relations + rating stats
        $query = TeacherProfile::query()
            ->where('status', 'approved')
            ->with(['subject', 'branch'])
            ->withCount('reviews')                 // reviews_count
            ->withAvg('reviews', 'rating');        // reviews_avg_rating

        // search by name
        if ($request->filled('q')) {
            $query->where('display_name', 'like', '%' . $request->q . '%');
        }

        // filter by subject
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        // filter by branch
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        // sorting: featured first, then higher rating, then newest
        $teachers = $query
            ->orderByDesc('is_featured')
            ->orderByRaw('COALESCE(reviews_avg_rating, 0) DESC')
            ->latest()
            ->paginate(6)
            ->withQueryString();

        // filters data
        $subjects = Subject::orderBy('name')->get();
        $branches = Branch::orderBy('name')->get();

        return view('student.teachers', compact('teachers', 'subjects', 'branches'));
    }
}
