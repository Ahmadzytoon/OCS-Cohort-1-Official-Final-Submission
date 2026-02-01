<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\User;

class LandingController extends Controller
{
   

public function index()
{
    $featuredPhotographers = User::query()
        ->where('account_type', 'photographer')
        ->where('status', 'approved')
        ->with(['portfolioItems' => function ($q) {
            $q->latest()->limit(1); // آخر صورة (cover)
        }])
        ->latest()
        ->take(8)
        ->get();

    return view('main.index', compact('featuredPhotographers'));
}


    public function photographers()
    {
        $featuredPhotographers = User::query()
            ->where('account_type', 'photographer')
            ->where('status', 'approved')
            ->with(['portfolioItems' => function ($q) {
                $q->latest()->limit(1);
            }])
            ->latest()
            ->paginate(12);

        return view('main.photographers', compact('featuredPhotographers'));
    }
}
