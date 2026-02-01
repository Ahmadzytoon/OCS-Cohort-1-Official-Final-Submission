<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Photographer;
use App\Models\Studio;
use App\Models\Booking;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index(Request $request)
{
    // ✅ سنة الشارت (افتراضي السنة الحالية)
    $year = (int) ($request->get('year', now()->year));

    // ✅ قراءة الفلاتر من الـ URL (الفورم)
    $q = $request->get('q');
    $role = $request->get('role', 'all');       // customer / photographer / studio / all
    $status = $request->get('status', 'all');   // approved / pending / rejected / all

    // ✅ Stats
    $totalUsers = User::where('account_type', '!=', 'admin')->count();
    $totalPhotographers = Photographer::count();

    // مؤقتاً (لما تعمل جدول bookings بنربطه)
    $totalBookings = 0;

    $pendingApprovals = User::whereIn('account_type', ['photographer', 'studio'])
        ->where('status', 'pending')
        ->count();

    $recentActivityDelta = User::where('created_at', '>=', now()->subDays(7))->count();

    $usersThisMonth = User::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();
    $usersPrevMonth = User::whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])->count();
    $usersGrowthPct = $usersPrevMonth > 0
        ? round((($usersThisMonth - $usersPrevMonth) / $usersPrevMonth) * 100, 1)
        : null;

    // ✅ Chart placeholders
    $labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    $chartData = array_fill(0, 12, 0);


    // ✅ Recent Activity data
    $recentUsers = User::latest()->take(4)->get(['id','full_name','created_at']);
    $recentPending = User::whereIn('account_type', ['photographer','studio'])
        ->where('status','pending')
        ->latest()
        ->take(4)
        ->get(['id','full_name','created_at']);

    // ✅ Manage Users (مع الفلاتر)
    $manageUsersQuery = User::query()->where('account_type', '!=', 'admin');

    if ($q) {
        $manageUsersQuery->where(function ($w) use ($q) {
            $w->where('full_name', 'like', "%{$q}%")
              ->orWhere('email', 'like', "%{$q}%");
        });
    }

    if ($role !== 'all') {
        $manageUsersQuery->where('account_type', $role);
    }

    if ($status !== 'all') {
        $manageUsersQuery->where('status', $status);
    }

    $manageUsers = $manageUsersQuery->latest()->take(6)->get();

    // ✅ Pending Photographer Approvals
    $pendingPhotographers = User::where('account_type', 'photographer')
        ->where('status','pending')
        ->latest()
        ->take(6)
        ->get();

    return view('admin.dashboard', compact(
        'year',
        'totalUsers','totalPhotographers','totalBookings','pendingApprovals',
        'recentActivityDelta','usersGrowthPct',
        'labels','chartData',
        'manageUsers','pendingPhotographers',
        'recentUsers','recentPending'
    ));
}


}
