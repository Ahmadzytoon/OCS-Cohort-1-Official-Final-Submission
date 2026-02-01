<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDepartmentRequest;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use App\Services\DepartmentService;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UpdateDepartmentRequest;

class DepartmentController extends Controller
{

    public function index(Request $request)
    {
        $search = trim($request->get('search'));

        $departments = Department::with(['manager', 'company'])
            ->withCount('users')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('manager', function ($mq) use ($search) {
                        $mq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('company', function ($cq) use ($search) {
                        $cq->where('workspace_name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]); // عشان يضل البحث مع pagination

        return view('admin.departments', compact('departments', 'search'));
    }
    public function create()
    {
        $companies = Company::orderBy('workspace_name')->get();

        $users = User::select('id', 'name', 'company_id', 'role')->orderBy('name')->get();

        return view('admin.addDepartment', compact('companies', 'users'));
    }

    public function store(StoreDepartmentRequest $request, DepartmentService $service)
    {
        $department = $service->createDepartment($request->validated());

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Department created successfully!');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Department deleted successfully!');
    }

    public function show(Department $department)
    {
        $department->load(['company', 'manager', 'users']);

        $availableUsers = User::where('company_id', $department->company_id)
            ->whereNull('department_id')
            ->where('role', 'employee')
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'role']);

        return view('admin.showDepartment', compact('department', 'availableUsers'));
    }
    public function edit(Department $department)
    {
        $department->load(['company', 'manager']);

        $companies = Company::orderBy('workspace_name')->get();

        // الموظفين/المدراء من نفس شركة القسم عشان السيلكت
        $companyUsers = User::where('company_id', $department->company_id)
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'role']);

        return view('admin.editDepartment', compact('department', 'companies', 'companyUsers'));
    }

    public function update(UpdateDepartmentRequest $request, Department $department, DepartmentService $service)
    {
        $service->updateDepartment($department, $request->validated());

        return redirect()
            ->route('admin.departments.show', $department->id)
            ->with('success', 'Department updated successfully!');
    }

    public function addEmployees(Request $request, Department $department)
    {
        $validated = $request->validate([
            'employee_ids' => ['required', 'array', 'min:1'],
            'employee_ids.*' => ['integer', 'exists:users,id'],
        ]);

        // تأكيد: الموظفين لازم يكونوا من نفس الشركة
        User::whereIn('id', $validated['employee_ids'])
            ->where('company_id', $department->company_id)
            ->update(['department_id' => $department->id]);

        return redirect()
            ->route('admin.departments.show', $department->id)
            ->with('success', 'Employees added successfully!');
    }
}
