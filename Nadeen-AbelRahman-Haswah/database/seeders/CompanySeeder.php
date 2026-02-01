<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            ['workspace_name' => 'Orange', 'industry' => 'Technology'],
            ['workspace_name' => 'Acme Corporation', 'industry' => 'Manufacturing'],
            ['workspace_name' => 'Tech Solutions Ltd', 'industry' => 'IT Services'],
        ];

        foreach ($companies as $c) {
            Company::firstOrCreate(
                ['workspace_name' => $c['workspace_name']],
                [
                    'slug' => Str::slug($c['workspace_name']),
                    'industry' => $c['industry'] ?? null,
                ]
            );
        }
    }
}
