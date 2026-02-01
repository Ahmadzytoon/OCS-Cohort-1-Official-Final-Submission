<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        // بعض الحالات (خاصة Facebook) تحتاج stateless لو صار مشكلة state
        // جرّب بدونها أولاً، وإذا طلع لك InvalidStateException استخدم stateless()
        $socialUser = Socialite::driver($provider)->user();

        $email = $socialUser->getEmail();

        // لو المزود ما رجّع ايميل (ممكن يصير بفيسبوك إذا صلاحيات ناقصة)
        if (!$email) {
            return redirect()->route('login')->withErrors([
                'email' => 'لم يتم استلام البريد الإلكتروني من '.$provider,
            ]);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'User',
                'email' => $email,
                // نضيف باسورد عشوائي (مش رح يحتاجه طالما بيسجل OAuth)
                'password' => bcrypt(Str::random(32)),
            ]);
        }

        Auth::login($user, true);

        return redirect()->intended('/'); // غيّره حسب مشروعك
    }
}
