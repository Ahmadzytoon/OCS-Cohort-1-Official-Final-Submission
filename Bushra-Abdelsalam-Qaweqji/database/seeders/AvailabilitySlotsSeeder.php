<?php

namespace Database\Seeders;

use App\Models\AvailabilitySlot;
use App\Models\ProviderProfile;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AvailabilitySlotsSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        AvailabilitySlot::query()->delete();
        Schema::enableForeignKeyConstraints();

        $categories = ServiceCategory::query()->where('is_active', true)->get();
        $providers = ProviderProfile::query()->get();

        $timeBlocks = [
            ['09:00:00', '12:00:00'],
            ['12:30:00', '15:30:00'],
            ['16:00:00', '19:00:00'],
        ];

        foreach ($providers as $p) {
            foreach ($categories as $cat) {
                foreach ($timeBlocks as $block) {
                    AvailabilitySlot::create([
                        'provider_user_id' => $p->user_id,
                        'service_category_id' => $cat->id,
                        'start_time' => $block[0],
                        'end_time' => $block[1],
                        'is_booked' => false,
                    ]);
                }
            }
        }
    }
}
