<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AvailabilitySlot;
use App\Models\ProviderOptionPricing;
use App\Models\ProviderProfile;
use App\Models\ProviderService;
use App\Models\ServiceCategory;
use App\Models\ServiceOption;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProviderOnboardingController extends Controller
{
    public function show()
    {
        $categories = ServiceCategory::with(['options' => function ($q) {
            $q->where('is_active', true)->orderBy('name');
        }])
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('auth.provider-onboarding', compact('categories'));
    }

    public function step1(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone'    => ['nullable', 'string', 'max:10'],
            'zip_code' => ['required', 'string', 'max:10'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $request->session()->put('provider_onboarding.step1', [
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'] ?? null,
            'zip_code' => $validated['zip_code'],
            'password' => $validated['password'],
        ]);

        return response()->json(['ok' => true]);
    }

    public function step2(Request $request)
    {
        $validated = $request->validate([
            'bio' => ['nullable', 'string', 'max:1000'],

            // services[category_id] = hourly_rate
            'services'   => ['required', 'array', 'min:1'],
            'services.*' => ['required', 'numeric', 'min:0'],

            // option_prices[option_id] = price
            'option_prices'   => ['nullable', 'array'],
            'option_prices.*' => ['nullable', 'numeric', 'min:0'],
        ]);

        $request->session()->put('provider_onboarding.step2', [
            'bio'           => $validated['bio'] ?? null,
            'services'      => $validated['services'],
            'option_prices' => $validated['option_prices'] ?? [],
        ]);

        return response()->json(['ok' => true]);
    }

    public function complete(Request $request)
    {
        $step1 = $request->session()->get('provider_onboarding.step1');
        $step2 = $request->session()->get('provider_onboarding.step2');

        if (!$step1 || !$step2) {
            return response()->json([
                'ok' => false,
                'message' => 'Missing registration data. Please restart.'
            ], 422);
        }

        $validated = $request->validate([
            'slots' => ['required', 'array', 'min:1'],
            'slots.*.service_category_id' => ['required', 'integer'],
            'slots.*.start_time' => ['required', 'date_format:H:i'],
            'slots.*.end_time' => ['required', 'date_format:H:i'],
        ]);


        //  end > start
        foreach ($validated['slots'] as $i => $slot) {
            if (strtotime($slot['end_time']) <= strtotime($slot['start_time'])) {
                return response()->json([
                'message' => 'End time must be after start time'
                ], 422);
            }
        }


        $user = DB::transaction(function () use ($step1, $step2, $validated) {

            // 1) Create user
            $user = User::create([
                'name'     => $step1['name'],
                'email'    => $step1['email'],
                'phone'    => $step1['phone'],
                'password' => Hash::make($step1['password']),
                'role'     => User::ROLE_PROVIDER,
                'status'   => 'active',
            ]);

            // 2) Create provider profile (zip_code NOT NULL عندك)
            ProviderProfile::create([
                'user_id'   => $user->id,
                'zip_code'  => $step1['zip_code'],
                'bio'       => $step2['bio'],
                'avg_rating' => 0,
                'rating_count' => 0,
            ]);

            // 3) Provider Services
            $categoryToProviderServiceId = [];

            foreach ($step2['services'] as $categoryId => $hourlyRate) {
                $ps = ProviderService::create([
                    'provider_user_id' => $user->id,
                    'service_category_id' => (int)$categoryId,
                    'hourly_rate' => $hourlyRate,
                    'is_active' => true,
                ]);

                $categoryToProviderServiceId[(int)$categoryId] = $ps->id;
            }

            // 4) Option pricings (only if its category selected)
            $optionPrices = $step2['option_prices'] ?? [];

            foreach ($optionPrices as $optionId => $price) {
                if ($price === null || $price === '') continue;

                $opt = ServiceOption::select('id', 'service_category_id')
                    ->where('id', (int)$optionId)
                    ->first();

                if (!$opt) continue;

                $catId = (int)$opt->service_category_id;

                if (!isset($categoryToProviderServiceId[$catId])) {
                    continue;
                }

                ProviderOptionPricing::create([
                    'provider_service_id' => $categoryToProviderServiceId[$catId],
                    'service_option_id' => (int)$optionId,
                    'price' => $price,
                ]);
            }


            foreach ($validated['slots'] as $slot) {
                $catId = (int)$slot['service_category_id'];

                // only allow slots for selected categories
                if (!isset($categoryToProviderServiceId[$catId])) {
                    continue;
                }

                AvailabilitySlot::create([
                    'provider_user_id' => $user->id,
                    'service_category_id' => $catId,
                    'start_time' => $slot['start_time'],
                    'end_time' => $slot['end_time'],
                    'is_booked' => false,
                ]);
            }

            return $user;
        });

        event(new Registered($user));
        Auth::login($user);

        $request->session()->forget('provider_onboarding.step1');
        $request->session()->forget('provider_onboarding.step2');

        return response()->json([
            'ok' => true,
            'redirect' => route('provider.dashboard'),
        ]);
    }
}
