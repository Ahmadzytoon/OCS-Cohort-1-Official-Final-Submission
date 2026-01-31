<?php

namespace App\Http\Controllers\Shared;

use App\Models\AccessRequest;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Http\Request;

class AccessRequestController extends Controller
{
   public function create(Request $request)
{
    $companies = Company::where('is_active', 1)->orderBy('workspace_name')->get();

    $departmentsByCompany = Department::where('is_active', 1)
        ->orderBy('name')
        ->get(['id','name','company_id'])
        ->groupBy('company_id');

    return view('site.loging.access-request', compact('companies', 'departmentsByCompany'));
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'email', 'max:191'],
            'phone' => ['nullable', 'string', 'max:191'],
            'company_id' => ['required', 'exists:companies,id'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'message' => ['nullable', 'string'],
            'requested_role' => ['required', 'in:employee,department_manager'],
        ]);

        // تأكد القسم تابع للشركة
        if (!empty($validated['department_id'])) {
            $ok = Department::where('id', $validated['department_id'])
                ->where('company_id', $validated['company_id'])
                ->exists();

            if (!$ok) {
                return back()->withErrors(['department_id' => 'Department does not belong to selected company'])->withInput();
            }
        }

        // منع pending مكرر
        $existsPending = AccessRequest::where('company_id', $validated['company_id'])
            ->where('email', $validated['email'])
            ->where('status', 'pending')
            ->exists();

        if ($existsPending) {
            return back()->withErrors(['email' => 'You already have a pending request for this company.'])->withInput();
        }

        AccessRequest::create([
            ...$validated,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your access request has been submitted!');
    }
}
