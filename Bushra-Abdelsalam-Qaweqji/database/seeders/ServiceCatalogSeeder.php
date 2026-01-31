<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use App\Models\ServiceOption;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ServiceCatalogSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        ServiceOption::query()->delete();
        ServiceCategory::query()->delete();
        Schema::enableForeignKeyConstraints();

        $home = ServiceCategory::create([
            'code' => 'HOME_CLEAN',
            'name' => 'Home Cleaning',
            'is_active' => true,
        ]);

        $car = ServiceCategory::create([
            'code' => 'CAR_CLEAN',
            'name' => 'Car Cleaning',
            'is_active' => true,
        ]);

        // Home options
        $homeOptions = [
            ['name' => 'Basic Supplies Included', 'pricing_type' => 'included'],
            ['name' => 'Deep Cleaning', 'pricing_type' => 'add-on'],
            ['name' => 'Inside Fridge', 'pricing_type' => 'add-on'],
            ['name' => 'Inside Oven', 'pricing_type' => 'add-on'],
            ['name' => 'Windows (Interior)', 'pricing_type' => 'add-on'],
        ];

        foreach ($homeOptions as $o) {
            ServiceOption::create([
                'service_category_id' => $home->id,
                'name' => $o['name'],
                'pricing_type' => $o['pricing_type'],
                'is_active' => true,
            ]);
        }

        // Car options
        $carOptions = [
            ['name' => 'Vacuum Included', 'pricing_type' => 'included'],
            ['name' => 'Interior Detailing', 'pricing_type' => 'add-on'],
            ['name' => 'Leather Conditioning', 'pricing_type' => 'add-on'],
            ['name' => 'Trunk Cleaning', 'pricing_type' => 'add-on'],
        ];

        foreach ($carOptions as $o) {
            ServiceOption::create([
                'service_category_id' => $car->id,
                'name' => $o['name'],
                'pricing_type' => $o['pricing_type'],
                'is_active' => true,
            ]);
        }
    }
}
