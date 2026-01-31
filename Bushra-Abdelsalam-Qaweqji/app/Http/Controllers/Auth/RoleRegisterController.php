<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CustomerProfile;
use App\Models\ProviderProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RoleRegisterController extends Controller
{
    public function createSeeker()
    {
        return view('auth.register-seeker');
    }

    public function storeSeeker(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:10'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'zip_code' => ['required','string', 'max:10'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_CUSTOMER,
        ]);

        CustomerProfile::create([
            'user_id' => $user->id,
            'zip_code' => $request->zip_code,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('seeker.providers-list');
    }

    public function createProvider()
    {
        return view('auth.register-provider');
    }

    public function storeProvider(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:10'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'zip_code' => ['required','string', 'max:10'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_PROVIDER,
            'status' => 'active',
        ]);

        ProviderProfile::create([
            'user_id' => $user->id,
            'zip_code' => $request->zip_code,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('provider.dashboard');
    }
}
