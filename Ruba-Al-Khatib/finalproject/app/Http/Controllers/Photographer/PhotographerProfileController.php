<?php

namespace App\Http\Controllers\Photographer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Photographer;
use App\Models\PhotographerPortfolio;

class PhotographerProfileController extends Controller
{
    /**
     * Display photographer profile along with portfolio items
     */

    public function index()
    {


        $user = Auth::user();

        $profile = Photographer::where('user_id', $user->id)->firstOrFail();

        $items = PhotographerPortfolio::where('photographer_id', $profile->id)
            ->latest()
            ->get();
      
        return view('photographer.profile.index', compact('user', 'profile', 'items'));
    }


    /**
     * Show profile page
     */
    public function show()
{
    $user = Auth::user();

    $profile = Photographer::where('user_id', $user->id)->firstOrFail();

    $items = PhotographerPortfolio::where('photographer_id', $profile->id)
        ->latest()
        ->get();

    return view('photographer.profile.index', compact('user', 'profile', 'items'));
}


    /**
     * Show edit profile page
     */
    public function edit()
    {
        $user = Auth::user();
        $profile = Photographer::where('user_id', $user->id)->firstOrFail();

        return view('photographer.profile.edit', compact('user', 'profile'));
    }

    /**
     * Update profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = Photographer::where('user_id', $user->id)->firstOrFail();

        $data = $request->validate([
            'bio' => 'required|string',
            'years_of_experience' => 'required|integer|min:0',
            'photography_types' => 'required|array',
            'starting_price' => 'required|numeric|min:0',
            'city' => 'required|string',
            'instagram_url' => 'nullable|string',
            'website_url' => 'nullable|string',
            'behance_url' => 'nullable|string',
        ]);

        $profile->update($data);

        return redirect()
            ->route('photographer.profile.show')
            ->with('success', 'Profile updated successfully');
    }
}
