<?php

namespace Database\Seeders;

use App\Models\AvailabilitySlot;
use App\Models\Booking;
use App\Models\BookingOption;
use App\Models\ProviderService;
use App\Models\ServiceOption;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BookingsSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        BookingOption::query()->delete();
        Booking::query()->delete();
        Schema::enableForeignKeyConstraints();

        $customers = User::query()->where('role', User::ROLE_CUSTOMER)->get();
        $slots = AvailabilitySlot::query()->where('is_booked', false)->get();

        // Create 10 bookings max (or less if not enough slots)
        $target = min(10, $slots->count(), $customers->count());

        for ($i = 0; $i < $target; $i++) {
            $customer = $customers[$i];
            $slot = $slots[$i];

            // Provider service for this slot/category
            $providerService = ProviderService::query()
                ->where('provider_user_id', $slot->provider_user_id)
                ->where('service_category_id', $slot->service_category_id)
                ->firstOrFail();

            $hours = 3.00; // fits the 3-hour blocks you seeded
            $hourlyRate = (float)$providerService->hourly_rate;
            $baseCost = round($hours * $hourlyRate, 2);

            $booking = Booking::create([
                'customer_user_id' => $customer->id,
                'provider_user_id' => $slot->provider_user_id,
                'service_category_id' => $slot->service_category_id,
                'availability_slot_id' => $slot->id,

                'hours' => $hours,
                'service_address' => 'Apartment ' . random_int(1, 40) . ', Building ' . random_int(1, 12),
                'zip_code' => (string)random_int(10000, 99999),
                'customer_note' => (random_int(1, 3) === 1) ? 'Please focus on bathrooms and floors.' : null,

                'hourly_rate' => $hourlyRate,
                'base_cost' => $baseCost,
                'options_cost' => 0,
                'total_cost' => $baseCost,

                'status' => ['pending','accepted','completed'][random_int(0,2)],
                'rejection_reason' => null,
            ]);

            // Attach 0–2 add-ons (if exist)
            $addOns = ServiceOption::query()
                ->where('service_category_id', $slot->service_category_id)
                ->where('pricing_type', 'add-on')
                ->inRandomOrder()
                ->limit(random_int(0, 2))
                ->get();

            $optionsCost = 0;

            foreach ($addOns as $opt) {
                // Provider-specific price (fallback to a reasonable default)
                $providerPrice = $providerService->optionPricings()
                    ->where('service_option_id', $opt->id)
                    ->value('price');

                $price = $providerPrice !== null ? (float)$providerPrice : (float)random_int(3, 8);

                BookingOption::create([
                    'booking_id' => $booking->id,
                    'service_option_id' => $opt->id,
                    'option_name' => $opt->name,
                    'option_price' => $price,
                ]);

                $optionsCost += $price;
            }

            $booking->update([
                'options_cost' => round($optionsCost, 2),
                'total_cost' => round($baseCost + $optionsCost, 2),
            ]);

            // Mark slot booked
            $slot->update(['is_booked' => true]);
        }
    }
}
