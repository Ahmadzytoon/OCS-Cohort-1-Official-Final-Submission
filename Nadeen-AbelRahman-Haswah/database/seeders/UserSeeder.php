<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::with('departments')->get();

        if ($companies->isEmpty()) {
            $this->command->warn('Companies table is empty. Run CompanySeeder first.');
            return;
        }

        foreach ($companies as $company) {

            // 1) Company Owner
            $owner = User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '', $company->workspace_name)) . '@owner.com'],
                [
                    'name' => $company->workspace_name . ' Owner',
                    'password' => Hash::make('password123'),
                    'role' => 'company_owner',
                    'status' => 'active',
                    'company_id' => $company->id,
                    'department_id' => null,
                    'position' => 'Company Owner',
                    'phone' => '0790000000',
                    'joined_at' => now(),
                    'last_login_at' => null,
                ]
            );

            // 2) لكل قسم: Department Manager + Employees
            foreach ($company->departments as $department) {

                // Manager
                $managerEmail = strtolower($company->workspace_name) . '.' . strtolower($department->name) . '.manager@company.com';
                $managerEmail = str_replace(' ', '', $managerEmail);

                $manager = User::firstOrCreate(
                    ['email' => $managerEmail],
                    [
                        'name' => $department->name . ' Manager (' . $company->workspace_name . ')',
                        'password' => Hash::make('password123'),
                        'role' => 'department_manager',
                        'status' => 'active',
                        'company_id' => $company->id,
                        'department_id' => $department->id,
                        'position' => 'Department Manager',
                        'phone' => '0791111111',
                        'joined_at' => now(),
                        'last_login_at' => null,
                    ]
                );

                // اربط manager_id داخل department
                $department->update(['manager_id' => $manager->id]);

                // Employees (مثلاً 5 موظفين لكل قسم)
                for ($i = 1; $i <= 5; $i++) {
                    $email = strtolower($company->workspace_name) . '.' . strtolower($department->name) . ".emp{$i}@company.com";
                    $email = str_replace(' ', '', $email);

                    User::firstOrCreate(
                        ['email' => $email],
                        [
                            'name' => $department->name . " Employee {$i} (" . $company->workspace_name . ")",
                            'password' => Hash::make('password123'),
                            'role' => 'employee',
                            'status' => 'active',
                            'company_id' => $company->id,
                            'department_id' => $department->id,
                            'position' => 'Employee',
                            'phone' => '0792222222',
                            'joined_at' => now(),
                            'last_login_at' => null,
                        ]
                    );
                }
            }
        }

        $this->command->info('Users seeded successfully (owners, managers, employees). Password: password123');
    }
}
