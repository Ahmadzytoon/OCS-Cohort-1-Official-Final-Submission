<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Plan;
class HomeController extends Controller
{
  

public function index()
{
    $plans = Plan::where('is_active', true)
        ->orderBy('sort')
        ->get()
        ->groupBy('for'); // customer / photographer / studio

    return view('main.index', compact('plans'));
}

    public function guest()
    {
        // آخر مصورين approved
        $featuredPhotographers = User::query()
            ->where('account_type', 'photographer')
            ->where('status', 'approved')
            ->latest()
            ->take(6)
            ->get();

        // آخر ستوديوهات approved
        $featuredStudios = User::query()
            ->where('account_type', 'studio')
            ->where('status', 'approved')
            ->latest()
            ->take(6)
            ->get();

        return view('main.index', compact('featuredPhotographers', 'featuredStudios'));
    }
}
