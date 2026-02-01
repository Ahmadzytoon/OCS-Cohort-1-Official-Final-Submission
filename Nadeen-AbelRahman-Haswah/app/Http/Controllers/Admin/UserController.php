<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $users = User::with(['company', 'department'])
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('role', 'like', "%{$q}%")
                        ->orWhere('position', 'like', "%{$q}%")
                        ->orWhere('phone', 'like', "%{$q}%")
                        ->orWhereHas('company', function ($companyQuery) use ($q) {
                            $companyQuery->where('workspace_name', 'like', "%{$q}%");
                        });
                });
            })
            ->latest()
            ->paginate(4)
            ->withQueryString();

        return view('admin.users', compact('users', 'q'));
    }

    public function create()
    {
        $companies = Company::orderBy('workspace_name')->get();
        return view('admin.addUser', compact('companies'));
    }

    // حفظ المستخدم
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => ['required', 'in:company_owner,department_manager,employee'],
            'company_id' => ['required', 'exists:companies,id'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'position' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['status'] = 'active';

        $validated['joined_at'] = now();

        // last_login_at تترك null بالبداية (تتحدّث لاحقًا عند تسجيل الدخول)
        $validated['last_login_at'] = null;

        User::create($validated);

        if (!empty($validated['department_id'])) {
            $isValid = \App\Models\Department::where('id', $validated['department_id'])
                ->where('company_id', $validated['company_id'])
                ->exists();

            if (!$isValid) {
                return back()->withErrors(['department_id' => 'Selected department does not belong to the selected company.'])
                    ->withInput();
            }
        }


        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }


    public function departmentsByCompany(Company $company)
    {
        // رجّعي الأقسام النشطة فقط (إذا بتحبي) + مرتبة
        $departments = Department::where('company_id', $company->id)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($departments);
    }
    // عرض مستخدم واحد
    public function show(User $user)
    {
        $user->load(['company', 'department']);

        // لاحقًا: رح نعبيها لما نعمل knowledge tables
        $knowledgeItems = collect();

        return view('admin.showUser', compact('user', 'knowledgeItems'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }
}
