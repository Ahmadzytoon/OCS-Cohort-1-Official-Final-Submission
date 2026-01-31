<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCompanyRequest;
use App\Models\Company;
use App\Services\CompanyCreationService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $companies = Company::with('users')
            ->when($q, function ($query) use ($q) {
                $query->where('workspace_name', 'like', "%{$q}%")
                    ->orWhere('industry', 'like', "%{$q}%")
                    ->orWhere('company_size', 'like', "%{$q}%");
            })
            ->latest()
            ->paginate(2)
            ->withQueryString();

        return view('admin.companies', compact('companies', 'q'));
    }

    public function create()
    {
        return view('admin.addCompany');
    }

    public function store(StoreCompanyRequest $request, CompanyCreationService $service)
    {
        $service->createCompanyWithOwner($request->validated());

        return redirect()
            ->route('admin.companies.index')
            ->with('success', 'Company created successfully!');
    }
    public function show(Company $company)
    {
        $company->load('users');

        $owner = $company->users->where('role', 'company_owner')->first();

        $employees = $company->users
            ->whereIn('role', ['department_manager', 'employee'])
            ->values();

        return view('admin.showCompany', compact('company', 'owner', 'employees'));
    }

    public function edit(Company $company)
    {
        $owner = User::where('company_id', $company->id)
            ->where('role', 'company_owner')
            ->first();

        return view('admin.editCompany', compact('company', 'owner'));
    }




    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            // Company fields (حسب الفورم)
            'workspace_name' => ['required', 'string', 'max:255', 'unique:companies,workspace_name,' . $company->id],
            'company_size' => ['nullable', 'in:1-10,11-50,51-200,200+'],
            'industry' => ['nullable', 'in:it-software,accounting,marketing,hr,manufacturing,other'],
            'other_industry' => ['nullable', 'string', 'max:255'],

            // Owner fields
            'owner_name' => ['required', 'string', 'max:255'],
            'owner_email' => ['required', 'email', 'max:255', 'unique:users,email,' . $company->id . ',company_id'], // مهم: لا يتكرر داخل نفس الشركة
            'owner_phone' => ['nullable', 'string', 'max:50'],

            'password' => ['nullable', 'string', 'min:8', 'confirmed'],


        ]);

        if (($validated['industry'] ?? null) !== 'other') {
            $validated['other_industry'] = null;
        }

        DB::transaction(function () use ($company, $validated) {

            // 1) Update company
            $company->update([
                'workspace_name' => $validated['workspace_name'],
                'company_size' => $validated['company_size'] ?? null,
                'industry' => $validated['industry'] ?? null,
                'other_industry' => $validated['other_industry'] ?? null,
                // 'is_active' => $isActive,
            ]);

            // 2) Update owner user (company_owner)
            $owner = User::where('company_id', $company->id)
                ->where('role', 'company_owner')
                ->first();

            if ($owner) {
                $ownerData = [
                    'name' => $validated['owner_name'],
                    'email' => $validated['owner_email'],
                    'phone' => $validated['owner_phone'] ?? null,
                ];

                // Update password only if provided
                if (!empty($validated['password'])) {
                    $ownerData['password'] = Hash::make($validated['password']);
                }

                $owner->update($ownerData);
            }
        });

        return redirect()
            ->route('admin.companies.index')
            ->with('success', 'Company updated successfully!');
    }


    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()
            ->route('admin.companies.index')
            ->with('success', 'Company deleted successfully!');
    }
}
