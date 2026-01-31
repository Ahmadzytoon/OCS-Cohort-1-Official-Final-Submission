<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProviderProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisteredProviderController extends Controller
{
    public function create()
    {
        return view('auth.register.provider');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = DB::transaction(function () use ($validated) {

            $user = User::create([
                'role'     => User::ROLE_PROVIDER,
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'phone'    => $validated['phone'] ?? null,
                'status'   => User::STATUS_ACTIVE,
                'password' => Hash::make($validated['password']),
            ]);

            ProviderProfile::create([
                'user_id' => $user->id,
            ]);

            return $user;
        });

        auth()->login($user);

        return redirect()->route('provider.dashboard');
    }
}
