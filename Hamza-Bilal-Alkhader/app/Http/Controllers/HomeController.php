<?php

namespace App\Http\Controllers;

use App\Models\TeacherProfile;

class HomeController extends Controller
{
    public function index()
    {
        $topTeachers = TeacherProfile::query()
            ->where('status', 'approved')
            ->with(['subject', 'branch'])          
            ->withCount('reviews')                
            ->withAvg('reviews', 'rating')         
            ->orderByRaw('COALESCE(reviews_avg_rating, 0) DESC')
            ->orderByDesc('reviews_count')       
            ->latest()
            ->take(6)
            ->get();

        return view('student.home', compact('topTeachers'));
    }
}
