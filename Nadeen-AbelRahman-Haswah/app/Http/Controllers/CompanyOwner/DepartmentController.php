<?php

namespace App\Http\Controllers\CompanyOwner;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyOwner\StoreDepartmentRequest;
use App\Http\Requests\CompanyOwner\UpdateDepartmentRequest;
use App\Models\Department;
use App\Models\User;
use App\Services\DepartmentService;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function index()
{
    $companyId = Auth::user()->company_id;

    $departments = Department::with(['manager'])
        ->withCount('users')
        ->where('company_id', $companyId)
        ->latest()
        ->get();

    // ✅ إضافة: عدد كروت المعرفة لكل قسم (بدون ما نعدل الـ query الأساسي)
    $knowledgeCounts = \App\Models\KnowledgeEntry::where('company_id', $companyId)
        ->selectRaw('department_id, COUNT(*) as cnt')
        ->groupBy('department_id')
        ->pluck('cnt', 'department_id'); // [department_id => count]

    // ✅ إضافة: نحقن knowledge_count داخل كل Department object
    foreach ($departments as $dept) {
        $dept->knowledge_count = (int) ($knowledgeCounts[$dept->id] ?? 0);
    }

    // ✅ إضافة: maxCards لحساب completion %
    $maxCards = max(1, (int) $departments->max('knowledge_count'));

    // المدراء المحتملين: من نفس الشركة (ممكن employees فقط)
    $managers = User::where('company_id', $companyId)
        ->whereIn('role', ['employee','department_manager'])
        ->orderBy('name')
        ->get(['id','name','email','role']);

    // stats أعلى الصفحة
    $totalDepartments = $departments->count();
    $totalMembers = User::where('company_id', $companyId)->count();
    $departmentManagersCount = User::where('company_id', $companyId)->where('role','department_manager')->count();

    // Knowledge cards (لو عندك relation company->knowledgeEntries)
    $knowledgeCardsCount = \App\Models\KnowledgeEntry::where('company_id', $companyId)->count();

    return view('site.innerPages.companyOwner.departments', compact(
        'departments',
        'managers',
        'totalDepartments',
        'totalMembers',
        'knowledgeCardsCount',
        'departmentManagersCount',
        'maxCards' // ✅ إضافة
    ));
}

    public function store(StoreDepartmentRequest $request, DepartmentService $service)
    {
        $data = $request->validated();
        $data['company_id'] = Auth::user()->company_id; // أهم سطر

        $service->createDepartment($data);

        return back()->with('success', 'Department created successfully!');
    }

    public function update(UpdateDepartmentRequest $request, Department $department, DepartmentService $service)
    {
        $companyId = Auth::user()->company_id;

        abort_unless($department->company_id == $companyId, 403);

        $data = $request->validated();
        $data['company_id'] = $companyId; // تثبيت الشركة

        $service->updateDepartment($department, $data);

        return back()->with('success', 'Department updated successfully!');
    }

    public function destroy(Department $department)
    {
        $companyId = Auth::user()->company_id;
        abort_unless($department->company_id == $companyId, 403);

        $department->delete();

        return back()->with('success', 'Department deleted successfully!');
    }

    // View Details modal (صفحة/JSON)
    public function show(Department $department)
    {
        $companyId = Auth::user()->company_id;
        abort_unless($department->company_id == $companyId, 403);

        $department->load(['manager']);
        $membersCount = $department->users()->count();

        // رجع JSON عشان تفتحي modal بسهولة بـ JS
        return response()->json([
            'id' => $department->id,
            'name' => $department->name,
            'icon' => $department->icon,
            'description' => $department->description,
            'manager' => $department->manager ? [
                'name' => $department->manager->name,
                'email' => $department->manager->email,
            ] : null,
            'members_count' => $membersCount,
            'created_at' => optional($department->created_at)->format('Y-m-d'),
        ]);
    }

public function members(Department $department)
{
    $user = Auth::user();

    // تأكيد إن القسم تابع لشركة الـ owner
    if ($department->company_id !== $user->company_id) {
        abort(403);
    }

    $department->load(['users:id,name,email,role,avatar,department_id']);

    return response()->json([
        'department' => [
            'id' => $department->id,
            'name' => $department->name,
        ],
        'members' => $department->users->map(function ($u) {
            return [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'role' => $u->role,
                'avatar' => $u->avatar, // عندك accessor يرجّع asset جاهز ✅
            ];
        }),
    ]);
}

}
