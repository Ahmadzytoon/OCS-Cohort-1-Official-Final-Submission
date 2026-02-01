<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        if ($companies->isEmpty()) {
            $this->command->warn('Companies table is empty. Run CompanySeeder first.');
            return;
        }

        $templateDepartments = [
            ['name' => 'IT', 'icon' => 'fa-laptop-code', 'description' => 'Tech & systems'],
            ['name' => 'HR', 'icon' => 'fa-users', 'description' => 'People & hiring'],
            ['name' => 'Finance', 'icon' => 'fa-coins', 'description' => 'Budget & accounting'],
        ];

        foreach ($companies as $company) {
            foreach ($templateDepartments as $d) {
                Department::firstOrCreate(
                    [
                        'company_id' => $company->id,
                        'name' => $d['name'],
                    ],
                    [
                        'slug' => Str::slug($d['name']),
                        'icon' => $d['icon'],
                        'description' => $d['description'],
                        'is_active' => true,
                        'manager_id' => null,
                    ]
                );
            }
        }
    }
}
