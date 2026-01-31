<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attribute;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        $size = Attribute::create(['name' => 'Size']);
        $size->values()->createMany([
            ['value' => 'Small'],
            ['value' => 'Medium'],
            ['value' => 'Large'],
            ['value' => 'XL'],
        ]);

        $color = Attribute::create(['name' => 'Color']);
        $color->values()->createMany([
            ['value' => 'Black'],
            ['value' => 'White'],
            ['value' => 'Beige'],
            ['value' => 'Pink'],
        ]);
    }
}
