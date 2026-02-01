<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Photographer;

class PhotographerPublicController extends Controller
{
    public function show(User $photographer)
    {
        // لازم يكون Photographer + Approved
        abort_unless(
            ($photographer->account_type ?? null) === 'photographer' &&
            (($photographer->status ?? 'pending') === 'approved'),
            404
        );

        // ✅ هاد هو الـ profile الحقيقي (من جدول photographers)
        $profile = Photographer::where('user_id', $photographer->id)->first();

        // ✅ Portfolio (حسب relation اللي عندك على User)
        $portfolio = $photographer->portfolioItems()
            ->latest()
            ->take(24)
            ->get();

        return view('main.photographer-profile', compact('photographer', 'profile', 'portfolio'));
    }
}
