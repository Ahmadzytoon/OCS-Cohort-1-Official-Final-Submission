<?php

namespace App\Http\Controllers\Knowledge;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\KnowledgeEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KnowledgeBrowseController extends Controller
{
    // 4 endpoints (واحد لكل صفحة) بس كلهم بيرجعوا لنفس index
    public function onboarding(Request $request)
    {
        return $this->index($request, 'onboarding');
    }
    public function mistakes(Request $request)
    {
        return $this->index($request, 'mistakes');
    }
    public function operational(Request $request)
    {
        return $this->index($request, 'operational');
    }
    public function critical(Request $request)
    {
        return $this->index($request, 'critical');
    }

    private function index(Request $request, string $type)
    {
        $user = Auth::user();

        abort_unless($user->company_id, 403);

        // 1) نحدد القسم اللي الموظف/المدير إله
        $managedDepartment = null;

        // افتراض: عندك user.department_id للموظف
        // إذا ما عندك، لازم تخزنيها (أو pivot) عشان نعرف قسمه
        $employeeDepartmentId = $user->department_id ?? null;

        // لو department_manager: نجيب القسم اللي هو مديره (مثل ما عملتي بالـ approvals)
        if ($user->role === 'department_manager') {
            $managedDepartment = Department::query()
                ->where('company_id', $user->company_id)
                ->where('manager_id', $user->id)
                ->first();

            abort_unless($managedDepartment, 403);
        }

        // 2) query أساسي: الشركة + النوع + approved فقط (عرض رسمي)
        $query = KnowledgeEntry::query()
            ->with([
                'author:id,name',
                'department:id,name',
                'tags:id,name',
            ])
            ->where('company_id', $user->company_id)
            ->where('type', $type)
            ->where('status', 'approved'); // عرض رسمي

        // 3) صلاحيات العرض حسب الدور
        // company_owner: يشوف كل الأقسام داخل الشركة
        // department_manager: يشوف بس قسمه
        // employee: يشوف بس قسمه
        if ($user->role === 'department_manager') {
            $query->where('department_id', $managedDepartment->id);
        } elseif ($user->role !== 'company_owner') {
            // employee أو أي role ثانية
            abort_unless($employeeDepartmentId, 403);
            $query->where('department_id', $employeeDepartmentId);
        }

        // 4) Search (q) شامل
        // نبحث في: title, summary, content + author name + department name + tags
        if ($request->filled('q')) {
            $q = trim($request->q);

            $query->where(function ($qq) use ($q) {
                $qq->where('title', 'like', "%{$q}%")
                    ->orWhere('summary', 'like', "%{$q}%")
                    ->orWhere('content', 'like', "%{$q}%")
                    ->orWhereHas('author', fn($a) => $a->where('name', 'like', "%{$q}%"))
                    ->orWhereHas('department', fn($d) => $d->where('name', 'like', "%{$q}%"))
                    ->orWhereHas('tags', fn($t) => $t->where('name', 'like', "%{$q}%"));
            });
        }

        // 5) Pagination + الحفاظ على query string
        $entries = $query->latest('approved_at')->paginate(12)->withQueryString();

        // 6) إحصائيات بسيطة للصفحة (اختياري)
        $totalCount = (clone $query)->toBase()->getCountForPagination();

        // 7) اختيار الـ view حسب النوع
        $viewMap = [
            'onboarding'  => 'site.innerPages.companyOwner.onboardingKnowledge',
            'mistakes'    => 'site.innerPages.companyOwner.MistakesAndLessonsLearned',
            'operational' => 'site.innerPages.companyOwner.OperationalKnowledge',
            'critical'    => 'site.innerPages.companyOwner.CriticalAndStrategicKnowledge',
        ];

        abort_unless(isset($viewMap[$type]), 404);

        return view($viewMap[$type], [
            'entries' => $entries,
            'type' => $type,
            'q' => $request->q,
            'totalCount' => $totalCount,
        ]);
    }
    public function criticalDetails(KnowledgeEntry $entry)
    {
        $user = Auth::user();
        abort_unless($user->company_id && $entry->company_id === $user->company_id, 403);

        // لازم تكون approved (عرض رسمي)
        abort_unless($entry->status === 'approved', 403);

        // scope حسب الدور (owner كل شيء، manager قسمه، employee قسمه)
        if ($user->role === 'department_manager') {
            $managedDepartment = Department::query()
                ->where('company_id', $user->company_id)
                ->where('manager_id', $user->id)
                ->first();

            abort_unless($managedDepartment, 403);
            abort_unless($entry->department_id === $managedDepartment->id, 403);
        } elseif ($user->role !== 'company_owner') {
            abort_unless($user->department_id, 403);
            abort_unless($entry->department_id === $user->department_id, 403);
        }

        $entry->load(['author', 'department', 'tags', 'attachments']);

        $html = view('site.innerPages.companyOwner.partials.critical_details_modal_body', [
            'entry' => $entry,
        ])->render();

        return response()->json(['ok' => true, 'html' => $html]);
    }



    public function mistakesDetails(KnowledgeEntry $entry)
    {
        $user = Auth::user();

        // ✅ لازم يكون نفس الشركة + approved + type mistakes
        abort_unless($entry->company_id === $user->company_id, 403);
        abort_unless($entry->status === 'approved', 403);
        abort_unless($entry->type === 'mistakes', 403);

        // ✅ Scoping حسب الدور:
        // employee يشوف بس قسمه
        // department_manager يشوف بس قسمه اللي مديره
        // company_owner يشوف الكل
        if ($user->role === 'employee') {
            abort_unless($entry->department_id === $user->department_id, 403);
        }

        if ($user->role === 'department_manager') {
            // إذا عندك department_manager مربوط بجدول departments.manager_id مثل ما سويتي قبل:
            $managedDepartmentId = \App\Models\Department::where('company_id', $user->company_id)
                ->where('manager_id', $user->id)
                ->value('id');

            abort_unless($managedDepartmentId, 403);
            abort_unless($entry->department_id === $managedDepartmentId, 403);
        }

        $entry->load(['author:id,name', 'department:id,name', 'attachments', 'tags']);

        $attachments = $entry->attachments->map(function ($att) {
            return [
                'type' => $att->type,
                'original_name' => $att->original_name,
                'url' => $att->path ? Storage::disk('public')->url($att->path) : null,
            ];
        });

        $html = view('site.innerPages.companyOwner.partials.mistake_details_modal_body', [
            'entry' => $entry,
            'attachments' => $attachments,
        ])->render();

        return response()->json([
            'ok' => true,
            'html' => $html,
        ]);
    }
}
