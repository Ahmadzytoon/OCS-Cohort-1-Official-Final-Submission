<?php

namespace App\Http\Controllers;

use App\Models\Plan;

class PricingController extends Controller
{
    public function index()
    {
        $plans = Plan::where('is_active', true)
            ->orderBy('sort')
            ->get()
            ->groupBy('for'); // customer / photographer / studio

        return view('main.pricing', compact('plans'));
    }
}
