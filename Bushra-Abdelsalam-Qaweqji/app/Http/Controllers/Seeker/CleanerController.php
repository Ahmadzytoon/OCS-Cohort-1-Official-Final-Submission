<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Models\ProviderProfile;
use App\Models\Review;
use App\Models\User;

class CleanerController extends Controller
{
    public function index()
    {
        return view('seeker.pages.providers-list');
    }

    public function show(int $providerUserId)
    {
        $provider = ProviderProfile::query()
            ->where('user_id', $providerUserId)
            ->whereHas('user', function ($u) {
                $u->where('role', User::ROLE_PROVIDER)
                ->where('status', User::STATUS_ACTIVE);
            })
            ->with([
                'user:id,name',
                'services' => function ($q) {
                    $q->with([
                        'category:id,code,name',
                        'optionPricings.serviceOption:id,name',
                    ]);
                },
                'availabilitySlots' => function ($q) {
                    $q->where('is_booked', false)
                    ->orderBy('start_time');
                },
            ])
            ->firstOrFail();

        $reviews = Review::query()
            ->whereHas('booking', function ($q) use ($providerUserId) {
                $q->where('provider_user_id', $providerUserId);
            })
            ->whereNotNull('comment')
            ->with('booking.customer:id,name')
            ->orderByDesc('created_at')
            ->get();

        return view('seeker.pages.provider-details', compact('provider', 'reviews'));
    }

}
