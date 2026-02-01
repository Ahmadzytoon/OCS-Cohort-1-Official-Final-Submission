<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnterSessionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (Auth::check()) {
            // User is logged in: Check if they have a style persona (aesthetic)
            if (Auth::user()->style_persona) {
                // If they have a persona, take them to the customized shopping experience (My Edit / Personalized Feed)
                // Assuming 'personalized.feed' or similar route exists. If not, filtered shop.
                return redirect()->route('shop.index', ['aesthetic' => Auth::user()->style_persona]);
            } else {
                // Logged in but no persona (maybe skipped quiz): Take to Quiz
                return redirect()->route('sparkle.quiz');
            }
        } else {
            // Not logged in: Redirect to login with 'intended' destination set to Quiz -> Shop
            // We can chain this by setting the intended URL manually or handling it in the Login logic.
            // For now, simpler flow: Login -> (Login Controller should redirect to Quiz if not taken, or Dashboard/Shop)

            // However, the prompt specifically says: Login -> Quiz -> Customized Experience.
            // Best way: Send them to Login, and ensure Login redirects to Quiz.
            // We can force this by setting intended url to the quiz.

            session()->put('url.intended', route('sparkle.quiz'));
            return redirect()->route('login', ['context' => 'quiz']);
        }
    }
}
