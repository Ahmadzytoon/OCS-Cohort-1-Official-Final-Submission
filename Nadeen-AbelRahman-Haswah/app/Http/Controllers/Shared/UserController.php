<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $companyId = Auth::user()->company_id;

        // Inputs from filters/search
        $q            = trim((string) $request->get('q'));
        $departmentId = $request->get('department_id'); // nullable
        $role         = $request->get('role');          // nullable
        $status       = $request->get('status');        // nullable

        // For selects (departments list)
        $departments = Department::where('company_id', $companyId)
            ->where('is_active', 1)
            ->orderBy('name')
            ->get(['id', 'name']);

        // Users query
        $usersQuery = User::with(['department'])
            ->where('company_id', $companyId)
            // بحث
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('position', 'like', "%{$q}%")
                        ->orWhere('phone', 'like', "%{$q}%")
                        ->orWhereHas('department', function ($dq) use ($q) {
                            $dq->where('name', 'like', "%{$q}%");
                        });
                });
            })
            // فلتر قسم
            ->when($departmentId, fn($query) => $query->where('department_id', $departmentId))
            // فلتر دور
            ->when($role, fn($query) => $query->where('role', $role))
            // فلتر حالة
            ->when($status, fn($query) => $query->where('status', $status))
            ->latest();

        // Pagination
        $users = $usersQuery->paginate(10)->withQueryString();

        // Stats (من نفس الشركة)
        $stats = [
            'total'     => User::where('company_id', $companyId)->count(),
            'active'    => User::where('company_id', $companyId)->where('status', 'active')->count(),
            'pending'   => User::where('company_id', $companyId)->where('status', 'pending')->count(),
            'inactive'  => User::where('company_id', $companyId)->where('status', 'inactive')->count(),
        ];

        return view('site.innerPages.companyOwner.employee', compact(
            'users',
            'departments',
            'stats',
            'q',
            'departmentId',
            'role',
            'status'
        ));
    }

    public function store(Request $request)
    {
        $companyId = Auth::user()->company_id;

        $validated = $request->validate([
            'email' => ['required', 'email', 'max:191', 'unique:users,email'],
            'name'  => ['required', 'string', 'max:191'],
            'phone' => ['nullable', 'string', 'max:191'],
            'position' => ['nullable', 'string', 'max:191'],

            // department_id لازم يكون من نفس شركة الـ owner
            'department_id' => [
                'nullable',
                Rule::exists('departments', 'id')->where(fn($q) => $q->where('company_id', $companyId)),
            ],

            // حسب DB enum: company_owner, department_manager, employee
            // company owner غالبًا ما يضيف Company Owner ثاني، فخليها فقط للموظفين والمدراء:
            'role' => ['required', Rule::in(['department_manager', 'employee'])],

            // حسب DB enum: active, inactive, pending
            'status' => ['required', Rule::in(['active', 'inactive', 'pending'])],

            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        User::create([
            'company_id'     => $companyId,
            'department_id'  => $validated['department_id'] ?? null,
            'name'           => $validated['name'],
            'email'          => $validated['email'],
            'phone'          => $validated['phone'] ?? null,
            'position'       => $validated['position'] ?? null,
            'role'           => $validated['role'],
            'status'         => $validated['status'],
            'joined_at'      => now(),
            'last_login_at'  => null,
            'password'       => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('shared.employee.index')
            ->with('success', 'Employee added successfully!');
    }
}
