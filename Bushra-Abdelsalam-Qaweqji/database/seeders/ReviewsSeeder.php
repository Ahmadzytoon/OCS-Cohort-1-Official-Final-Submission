<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\ProviderProfile;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ReviewsSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Review::query()->delete();
        Schema::enableForeignKeyConstraints();

        $completed = Booking::query()->where('status', 'completed')->get();

        foreach ($completed as $b) {
            $rating = random_int(4, 5); // keep realistic (good providers)
            Review::create([
                'booking_id' => $b->id,
                'rating' => $rating,
                'comment' => (random_int(1, 3) === 1) ? 'Very professional and on time. Great results.' : null,
            ]);
        }

        // Recompute provider ratings based on reviews
        $providers = ProviderProfile::query()->get();
        foreach ($providers as $p) {
            $ratings = Review::query()
                ->whereHas('booking', fn ($q) => $q->where('provider_user_id', $p->user_id))
                ->pluck('rating');

            $count = $ratings->count();
            $avg = $count ? round($ratings->average(), 2) : 0.00;

            $p->update([
                'avg_rating' => $avg,
                'rating_count' => $count,
            ]);
        }
    }
}
