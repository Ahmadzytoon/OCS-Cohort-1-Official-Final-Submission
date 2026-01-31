<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Models\CustomerProfile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $profile = $user->customerProfile;

        $nameParts = preg_split('/\s+/', trim($user->name ?? ''));
        $firstName = $nameParts[0] ?? '';
        $lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : '';

        return view('seeker.pages.profile', compact('user', 'profile', 'firstName', 'lastName'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $profile = $user->customerProfile;

        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['nullable', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address_line' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'zip_code' => ['nullable', 'string', 'max:10'],
            'unit' => ['nullable', 'string', 'max:50'],
            'preferred_language' => ['nullable', 'in:en,ar'],
            'notifications' => ['nullable', 'in:email_sms,email,sms'],
            'default_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $fullName = trim($data['first_name'] . ' ' . ($data['last_name'] ?? ''));

        $user->update([
            'name' => $fullName,
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
        ]);

        CustomerProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'zip_code' => $data['zip_code'] ?? ($profile?->zip_code ?? ''),
                'address_line' => $data['address_line'] ?? null,
                'city' => $data['city'] ?? null,
                'unit' => $data['unit'] ?? null,
                'preferred_language' => $data['preferred_language'] ?? null,
                'notifications' => $data['notifications'] ?? null,
                'default_notes' => $data['default_notes'] ?? null,
            ]
        );

        return back()->with('success', 'Profile updated.');
    }
}
