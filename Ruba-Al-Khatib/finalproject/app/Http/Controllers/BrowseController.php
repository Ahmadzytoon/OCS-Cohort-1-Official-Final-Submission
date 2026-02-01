<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrowseController extends Controller
{
    public function photographers(Request $request)
    {
        $q        = $request->string('q')->toString();        // search by name/city/type
        $city     = $request->string('city')->toString();
        $type     = $request->string('type')->toString();     // photography_types
        $minPrice = $request->input('min_price'); // string/nullable
        $maxPrice = $request->input('max_price');

        $sort     = $request->string('sort')->toString();     // popular/rating/price_low/price_high

        $query = User::query()
            ->where('account_type', 'photographer')
            ->where('status', 'approved')
            ->with([
                'photographerProfile' => function ($q) {
                    $q->select([
                        'id',
                        'user_id',
                        'city',
                        'starting_price',
                        'photography_types',
                        'profile_image_path',
                        'avatar'
                    ]);
                },
            ]);

        // search
        if ($q) {
            $query->where(function ($qq) use ($q) {
                $qq->where('full_name', 'like', "%{$q}%")
                    ->orWhereHas('photographerProfile', function ($p) use ($q) {
                        $p->where('city', 'like', "%{$q}%")
                            ->orWhere('photography_types', 'like', "%{$q}%");
                    });
            });
        }

        // filters
        if ($city) {
            $query->whereHas('photographerProfile', function ($p) use ($city) {
                $p->whereRaw('LOWER(city) = ?', [strtolower($city)]);
            });
        }


        if ($type) {
            $query->whereHas('photographerProfile', fn($p) => $p->where('photography_types', 'like', "%{$type}%"));
        }

        if ($request->filled('min_price')) {
            $query->whereHas('photographerProfile', fn($p) => $p->where('starting_price', '>=', (int)$minPrice));
        }

        if ($request->filled('max_price')) {
            $query->whereHas('photographerProfile', fn($p) => $p->where('starting_price', '<=', (int)$maxPrice));
        }


        // sorting (مؤقتاً السعر فقط لأن rating/popularity مش موجودين بجدولك)
        if ($sort === 'price_low') {
            $query->orderBy(
                \App\Models\Photographer::select('starting_price')
                    ->whereColumn('photographers.user_id', 'users.id'),
                'asc'
            );
        } elseif ($sort === 'price_high') {
            $query->orderBy(
                \App\Models\Photographer::select('starting_price')
                    ->whereColumn('photographers.user_id', 'users.id'),
                'desc'
            );
        } else {
            $query->latest('users.id'); // default
        }
     /*   dd(
    DB::query()->fromSub($query->select('users.id'), 't')->count(),
    $query->toSql(),
    $query->getBindings()
);*/


        $photographers = $query->paginate(12)->withQueryString();

        // صور preview (3 صور لكل مصور)
        // نجمع photographer_ids
        $photographerIds = $photographers->getCollection()
            ->pluck('photographerProfile.id')
            ->filter()
            ->values();

        $previews = \App\Models\PhotographerPortfolio::query()
            ->whereIn('photographer_id', $photographerIds)
            ->latest('id')
            ->get()
            ->groupBy('photographer_id')
            ->map(fn($items) => $items->take(3));

        // cities dropdown
        $cities = \App\Models\Photographer::query()
            ->whereNotNull('city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        return view('main.photographers', compact('photographers', 'previews', 'cities'));
    }
}
