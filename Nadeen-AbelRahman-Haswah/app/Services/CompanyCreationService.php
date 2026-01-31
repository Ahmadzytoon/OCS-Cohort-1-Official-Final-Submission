<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompanyCreationService
{
    public function createCompanyWithOwner(array $data): Company
    {
        return DB::transaction(function () use ($data) {

            // 1) Create company
            $workspaceName = $data['workspace_name'] ?? ($data['company_name'] ?? $data['owner_name']);
            // fallback بسيط
            $slug = $this->uniqueSlug($workspaceName);

            $company = Company::create([
                'workspace_name' => $workspaceName, // إذا بدك workspace_name من فورم منفصل لاحقًا بنعدله
                'slug' => $slug,
                'company_size' => $data['company_size'] ?? null,
                'industry' => $data['industry'] ?? null,
                'other_industry' => $data['other_industry'] ?? null,
                'is_active' => true,
                'activated_at' => now(),
            ]);

            // 2) Create owner user
            User::create([
                'company_id' => $company->id,
                'department_id' => null,
                'name' => $data['owner_name'],
                'email' => $data['owner_email'],
                'phone' => $data['owner_phone'] ?? null,
                'password' => Hash::make($data['password']),
                'role' => 'company_owner',
                'status' => 'active',
                'joined_at' => now(),
            ]);

            return $company;
        });
    }

    private function uniqueSlug(string $base): string
    {
        $slug = Str::slug($base);
        $original = $slug;
        $i = 1;

        while (Company::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $i;
            $i++;
        }

        return $slug;
    }
}
