<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\ProviderProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $profile = ProviderProfile::query()
            ->where('user_id', $user->id)
            ->first();

        return view('provider.pages.profile', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'zip_code' => ['nullable', 'string', 'max:10'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'profile_image' => ['nullable', 'image', 'max:2048'],
        ]);

        $user->update([
            'name' => $data['name'],
            'phone' => $data['phone'] ?? null,
        ]);

        $profile = ProviderProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'zip_code' => $data['zip_code'] ?? null,
                'bio' => $data['bio'] ?? null,
            ]
        );

        if ($request->hasFile('profile_image')) {
            if ($profile->profile_image) {
                $oldPath = str_contains($profile->profile_image, '/')
                    ? $profile->profile_image
                    : 'provider-avatars/'.$profile->profile_image;
                Storage::disk('public')->delete($oldPath);
            }

            $file = $request->file('profile_image');
            $filename = $file->hashName();
            $file->storeAs('provider-avatars', $filename, 'public');
            $profile->update(['profile_image' => $filename]);
        }

        return back()->with('success', 'Profile updated.');
    }
}
