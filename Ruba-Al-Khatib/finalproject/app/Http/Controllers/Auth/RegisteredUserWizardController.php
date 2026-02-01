<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Photographer;
use App\Models\PhotographerPortfolio;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\StudioPortfolio;

class RegisteredUserWizardController extends Controller
{
    private const SESSION_KEY = 'signup.step1';

    /* =========================
     * STEP 1
     * ========================= */

    public function createStep1()
    {
        return view('auth.signup.step1');
    }

    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'fullName'     => ['required', 'string', 'min:2', 'max:255'],
            'email'        => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'     => ['required', 'string', 'min:8'],
            'confirmPassword' => ['required', 'same:password'],
            'accountType'  => ['required', Rule::in(['customer', 'photographer', 'studio'])],
            'terms'        => ['accepted'],
        ]);

        // خزّني بالسيشن (لـ photographer/studio فقط)
        session([
            self::SESSION_KEY => [
                'full_name'    => $validated['fullName'],
                'email'        => $validated['email'],
                'password'     => $validated['password'],
                'account_type' => $validated['accountType'],
            ]
        ]);

        // ✅ إذا customer: احفظي مباشرة واطلعيه على الصفحة العامة
        if ($validated['accountType'] === 'customer') {
            User::create([
                'full_name'    => $validated['fullName'],
                'email'        => $validated['email'],
                'password'     => Hash::make($validated['password']),
                'account_type' => 'customer',
                // إذا عندك status:
                // 'status' => 'approved',
            ]);

            session()->forget(self::SESSION_KEY);

            return redirect('/')->with('success', 'Account created successfully!');
        }

        // ✅ إذا photographer/studio: روحي على Step2
        return match ($validated['accountType']) {
            'photographer' => redirect()->route('signup.photographer'),
            'studio'       => redirect()->route('signup.studio'),
        };
    }

    private function ensureStep1()
    {
        if (!session()->has(self::SESSION_KEY)) {
            return redirect()->route('signup.step1');
        }
        return null;
    }

    /* =========================
     * STEP 2 - CUSTOMER
     * ========================= */

    public function createUserStep2()
    {
        if ($r = $this->ensureStep1()) return $r;
        return view('auth.signup.user');
    }

    public function storeUserStep2(Request $request)
    {
        if ($r = $this->ensureStep1()) return $r;
        $step1 = session(self::SESSION_KEY);

        DB::transaction(function () use ($step1) {
            User::create([
                'full_name'    => $step1['full_name'],
                'email'        => $step1['email'],
                'password'     => Hash::make($step1['password']),
                'account_type' => 'customer',
                'status'       => 'approved',        // ✅ customer مباشرة
                'approved_at'  => now(),
            ]);
        });

        session()->forget(self::SESSION_KEY);

        return redirect('/login')->with('success', 'Account created successfully. You can log in now!');
    }

    /* =========================
     * STEP 2 - PHOTOGRAPHER
     * ========================= */

    public function createPhotographerStep2()
    {
        if ($r = $this->ensureStep1()) return $r;
        return view('auth.signup.photographer');
    }

    public function storePhotographerStep2(Request $request)
    {
        if ($r = $this->ensureStep1()) return $r;
        $step1 = session(self::SESSION_KEY);

        // photography_types should be array (photography_types[])
        $types = $request->input('photography_types');
        if (!is_array($types)) $types = [];

        // portfolio_paths comes as JSON string from hidden input
        $paths = $request->input('portfolio_paths');
        if (is_string($paths)) $paths = json_decode($paths, true);
        if (!is_array($paths)) $paths = [];

        $request->merge([
            'photography_types' => $types,
            'portfolio_paths'   => $paths,
        ]);
        $profilePath = $request->input('profile_image_path'); // string or null

$request->merge([
    'profile_image_path' => $profilePath,
]);


        $validated = $request->validate([
            'bio' => ['required', 'string', 'min:50'],
            'years_of_experience' => ['required', 'integer', 'min:0'],
            'photography_types' => ['required', 'array', 'min:1'],
            'starting_price' => ['required', 'numeric', 'min:0'],
            'city' => ['required', 'string', 'max:120'],
            'instagram_url' => ['nullable', 'url'],
            'website_url' => ['nullable', 'url'],
            'behance_url' => ['nullable', 'url'],

            'portfolio_paths'   => ['required', 'array', 'min:6', 'max:12'],
            'portfolio_paths.*' => ['string'],
            'profile_image_path' => ['nullable', 'string', 'max:255'],

        ]);

        DB::transaction(function () use ($step1, $validated) {

            $user = User::create([
                'full_name'    => $step1['full_name'],
                'email'        => $step1['email'],
                'password'     => Hash::make($step1['password']),
                'account_type' => 'photographer',
                'status'       => 'pending',
                'approved_at'  => null,
                
            ]);

            $photographer = Photographer::create([
                'user_id'             => $user->id,
                'bio'                 => $validated['bio'],
                'years_of_experience' => (int) $validated['years_of_experience'],
                'photography_types'   => $validated['photography_types'],
                'starting_price'      => $validated['starting_price'],
                'city'                => $validated['city'],
                'instagram_url'       => $validated['instagram_url'] ?? null,
                'website_url'         => $validated['website_url'] ?? null,
                'behance_url'         => $validated['behance_url'] ?? null,

                 'profile_image_path'  => $validated['profile_image_path'] ?? null, // ✅
            ]);

            foreach ($validated['portfolio_paths'] as $p) {
                if (!str_starts_with($p, 'photographers/portfolio/')) continue;

                PhotographerPortfolio::create([
                    'photographer_id' => $photographer->id,
                    'image_path'      => $p,
                ]);
            }
        });

        session()->forget(self::SESSION_KEY);

        return redirect()->route('account.pending')
            ->with('success', 'Your photographer account was created and is pending admin approval.');
    }


    /* =========================
     * STEP 2 - STUDIO
     * ========================= */

    public function createStudioStep2()
    {
        if ($r = $this->ensureStep1()) return $r;
        return view('auth.signup.studio');
    }


    public function storeStudioStep2(Request $request)
    {
        if ($r = $this->ensureStep1()) return $r;
        $step1 = session(self::SESSION_KEY);

        // decode JSON strings
        $equipment = $request->input('equipment_tags');
        $hours = $request->input('working_hours');

        if (is_string($equipment)) $equipment = json_decode($equipment, true);
        if (!is_array($equipment)) $equipment = [];

        if (is_string($hours)) $hours = json_decode($hours, true);
        if (!is_array($hours)) $hours = [];

        // services checkboxes are array already (services[])
        $services = $request->input('services');
        if (!is_array($services)) $services = [];

        // portfolio paths JSON
        $paths = $request->input('portfolio_paths');
        if (is_string($paths)) $paths = json_decode($paths, true);
        if (!is_array($paths)) $paths = [];

        $request->merge([
            'equipment_tags' => $equipment,
            'working_hours' => $hours,
            'services' => $services,
            'portfolio_paths' => $paths,
        ]);

        $validated = $request->validate([
            'studio_name'   => ['required', 'string', 'max:255'],
            'description'   => ['required', 'string', 'min:20'],
            'phone_number'  => ['required', 'string', 'max:50'],
            'address'       => ['required', 'string', 'max:255'],

            'team_size'     => ['required', 'string', 'max:10'],
            'services'      => ['required', 'array', 'min:1'],

            'equipment_tags' => ['nullable', 'array'],
            'working_hours' => ['nullable', 'array'],

            'portfolio_paths'   => ['required', 'array', 'min:6', 'max:15'],
            'portfolio_paths.*' => ['string'],
        ]);

        DB::transaction(function () use ($step1, $validated) {

            $user = User::create([
                'full_name'    => $step1['full_name'],
                'email'        => $step1['email'],
                'password'     => Hash::make($step1['password']),
                'account_type' => 'studio',
                'status'       => 'pending',
                'approved_at'  => null,
            ]);

            $studio = Studio::create([
                'user_id'        => $user->id,
                'studio_name'    => $validated['studio_name'],
                'description'    => $validated['description'],
                'phone_number'   => $validated['phone_number'],
                'address'        => $validated['address'],
                'working_hours'  => $validated['working_hours'] ?? null,
                'services'       => $validated['services'] ?? null,
                'equipment_tags' => $validated['equipment_tags'] ?? null,
                'team_size'      => $validated['team_size'],
                // location_lat/location_lng إذا عندك input
                'location_lat'   => $validated['location_lat'] ?? null,
                'location_lng'   => $validated['location_lng'] ?? null,
            ]);

            // حفظ صور البورتفوليو
            foreach ($validated['portfolio_paths'] as $p) {
                // حماية: لازم تكون داخل studios/portfolio
                if (!str_starts_with($p, 'studios/portfolio/')) continue;

                StudioPortfolio::create([
                    'studio_id'  => $studio->id,
                    'image_path' => $p,
                ]);
            }
        });

        session()->forget(self::SESSION_KEY);

        return redirect()->route('account.pending')
            ->with('success', 'Your studio account was created and is pending admin approval.');
    }
}
