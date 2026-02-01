<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Essential Ready-To-Wear', 'slug' => 'tops'],
            ['name' => 'The Evening Archive', 'slug' => 'dresses'],
            ['name' => 'Haute Accessories', 'slug' => 'accessories'],
            ['name' => 'Signature Outerwear', 'slug' => 'outerwear'],
            ['name' => 'Boutique Footwear', 'slug' => 'footwear'],
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::updateOrCreate(['slug' => $cat['slug']], ['name' => $cat['name']]);
        }
    }
}
