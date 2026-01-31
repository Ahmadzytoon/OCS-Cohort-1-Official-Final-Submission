<?php

namespace Database\Seeders;

use App\Models\ProviderOptionPricing;
use App\Models\ProviderProfile;
use App\Models\ProviderService;
use App\Models\ServiceCategory;
use App\Models\ServiceOption;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ProviderServicesSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        ProviderOptionPricing::query()->delete();
        ProviderService::query()->delete();
        Schema::enableForeignKeyConstraints();

        $categories = ServiceCategory::query()->where('is_active', true)->get()->keyBy('code');
        $home = $categories['HOME_CLEAN'];
        $car  = $categories['CAR_CLEAN'];

        $providers = ProviderProfile::query()->get(); // provider_profiles exist now

        foreach ($providers as $p) {
            $homeService = ProviderService::create([
                'provider_user_id' => $p->user_id,
                'service_category_id' => $home->id,
                'hourly_rate' => random_int(12, 20),
            ]);

            $carService = ProviderService::create([
                'provider_user_id' => $p->user_id,
                'service_category_id' => $car->id,
                'hourly_rate' => random_int(10, 18),
            ]);

            // Add-on option pricing per provider_service
            $homeAddOns = ServiceOption::query()
                ->where('service_category_id', $home->id)
                ->where('pricing_type', 'add-on')
                ->get();

            foreach ($homeAddOns as $opt) {
                ProviderOptionPricing::create([
                    'provider_service_id' => $homeService->id,
                    'service_option_id' => $opt->id,
                    'price' => random_int(3, 10),
                ]);
            }

            $carAddOns = ServiceOption::query()
                ->where('service_category_id', $car->id)
                ->where('pricing_type', 'add-on')
                ->get();

            foreach ($carAddOns as $opt) {
                ProviderOptionPricing::create([
                    'provider_service_id' => $carService->id,
                    'service_option_id' => $opt->id,
                    'price' => random_int(2, 8),
                ]);
            }
        }
    }
}
