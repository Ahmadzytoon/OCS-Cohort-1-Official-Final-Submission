<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TeacherProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1) Counters
        $studentsCount = User::where('role', 'student')->count();
        $teachersCount = User::where('role', 'teacher')->count();
        $pendingProfilesCount = TeacherProfile::where('status', 'pending')->count();

        // 2) Chart: 
        $start = now()->startOfMonth()->subMonths(5); 
        $end   = now()->endOfMonth();

        // جلب العدد من قاعدة البيانات grouped by year-month
        $rows = User::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as total")
            ->whereIn('role', ['student', 'teacher'])
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('ym')
            ->orderBy('ym')
            ->get();

        // تجهيز labels + data بشكل ثابت حتى لو شهر ما فيه بيانات
        $months = [];
        $monthlyNewUsers = [];

        $cursor = $start->copy();
        while ($cursor <= $end) {
            $key = $cursor->format('Y-m');         // 2026-01
            $label = $cursor->format('M Y');       // Jan 2026

            $months[] = $label;

            $found = $rows->firstWhere('ym', $key);
            $monthlyNewUsers[] = $found ? (int)$found->total : 0;

            $cursor->addMonth();
        }

        return view('admin.dashboard', compact(
            'studentsCount',
            'teachersCount',
            'pendingProfilesCount',
            'months',
            'monthlyNewUsers'
        ));
    }
}
