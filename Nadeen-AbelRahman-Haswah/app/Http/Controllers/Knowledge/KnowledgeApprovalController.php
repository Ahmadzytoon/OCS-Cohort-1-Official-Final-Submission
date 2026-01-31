<?php

namespace App\Http\Controllers\Knowledge;

use Illuminate\Support\Carbon;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\KnowledgeEntry;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KnowledgeApprovalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        abort_unless(in_array($user->role, ['company_owner', 'department_manager']), 403);
        abort_unless($user->company_id, 403);

        // --- Base query: pending only, within same company ---
        $query = KnowledgeEntry::query()
            ->with(['author:id,name,email,avatar', 'department:id,name', 'attachments:id,knowledge_entry_id,type,path,original_name'])
            ->where('company_id', $user->company_id)
            ->where('status', 'pending');

        // --- Role scoping ---
        $managedDepartment = null;

        if ($user->role === 'department_manager') {
            // القسم اللي هو مديره (من جدول departments.manager_id)
            $managedDepartment = Department::query()
                ->where('company_id', $user->company_id)
                ->where('manager_id', $user->id)
                ->first();

            abort_unless($managedDepartment, 403); // إذا ما في قسم مربوط فيه كمدير

            $query->where('department_id', $managedDepartment->id);
        }

        // --- Filters ---
        // type filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // author filter by name (search)
        if ($request->filled('author')) {
            $author = trim($request->author);
            $query->whereHas('author', function ($q) use ($author) {
                $q->where('name', 'like', "%{$author}%");
            });
        }

        // department filter only for company_owner
        if ($user->role === 'company_owner' && $request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        $entries = $query->latest('submitted_at')->paginate(10)->withQueryString();

        // dropdown data
        $departments = [];
        if ($user->role === 'company_owner') {
            $departments = Department::query()
                ->where('company_id', $user->company_id)
                ->where('is_active', 1)
                ->orderBy('name')
                ->get(['id', 'name']);
        }

        $baseStatsQuery = KnowledgeEntry::query()
            ->where('company_id', $user->company_id);

        if ($user->role === 'department_manager') {
            // نفس منطق قسم المدير
            $managedDepartment = $managedDepartment ?? Department::query()
                ->where('company_id', $user->company_id)
                ->where('manager_id', $user->id)
                ->first();

            abort_unless($managedDepartment, 403);

            $baseStatsQuery->where('department_id', $managedDepartment->id);
        }

        $pendingCount = (clone $baseStatsQuery)->where('status', 'pending')->count();

        $approvedThisMonth = (clone $baseStatsQuery)
            ->where('status', 'approved')
            ->whereBetween('approved_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();

        $rejectedThisMonth = (clone $baseStatsQuery)
            ->where('status', 'rejected')
            ->whereBetween('rejected_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();


        return view('site.innerPages.companyOwner.approvals', compact(
            'entries',
            'departments',
            'managedDepartment',
            'pendingCount',
            'approvedThisMonth',
            'rejectedThisMonth'
        ));
    }

    public function details(KnowledgeEntry $entry)
    {
        $user = Auth::user();
        $this->authorizeEntryForReview($user, $entry);

        $entry->load(['author', 'department', 'attachments', 'tags']);

        // تجهيز روابط الملفات
        $attachments = $entry->attachments->map(function ($att) {
            $url = null;
            if ($att->path) {
                $url = Storage::disk('public')->url($att->path);
            }
            return [
                'id' => $att->id,
                'type' => $att->type,
                'original_name' => $att->original_name,
                'url' => $url,
            ];
        });

        // نرجّع HTML جاهز للمودال
        $html = view('site.innerPages.companyOwner.partials.approval_details_modal_body', [
            'entry' => $entry,
            'attachments' => $attachments
        ])->render();

        return response()->json([
            'ok' => true,
            'html' => $html,
        ]);
    }

    public function approve(Request $request, KnowledgeEntry $entry)
    {
        $user = Auth::user();
        $this->authorizeEntryForReview($user, $entry);

        $data = $request->validate([
            'comment' => ['nullable', 'string', 'max:5000'],
        ]);

        $entry->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $user->id,
            'approval_comment' => $data['comment'] ?? null,

            // تنظيف رفض سابق إذا موجود
            'rejected_at' => null,
            'rejected_by' => null,
            'rejection_reason' => null,
            'rejection_comment' => null,
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'Knowledge card approved successfully.',
        ]);
    }

    public function reject(Request $request, KnowledgeEntry $entry)
    {
        $user = Auth::user();
        $this->authorizeEntryForReview($user, $entry);

        $data = $request->validate([
            'comment' => ['required', 'string', 'max:5000'],
        ]);

        $entry->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'rejected_by' => $user->id,

            // نخليها "مختصرة" في rejection_reason (191) اختياري
            'rejection_reason' => mb_substr($data['comment'], 0, 191),
            'rejection_comment' => $data['comment'],

            // تنظيف approve سابق إذا موجود
            'approved_at' => null,
            'approved_by' => null,
            'approval_comment' => null,
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'Knowledge card rejected successfully.',
        ]);
    }

    public function bulkApprove(Request $request)
    {
        $user = Auth::user();
        abort_unless(in_array($user->role, ['company_owner', 'department_manager']), 403);

        $data = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
        ]);

        $entries = KnowledgeEntry::query()
            ->whereIn('id', $data['ids'])
            ->where('company_id', $user->company_id)
            ->where('status', 'pending');

        // لو department_manager: لازم بس قسمه
        if ($user->role === 'department_manager') {
            $managedDepartment = Department::query()
                ->where('company_id', $user->company_id)
                ->where('manager_id', $user->id)
                ->first();

            abort_unless($managedDepartment, 403);
            $entries->where('department_id', $managedDepartment->id);
        }

        $entries->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $user->id,
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'Selected knowledge cards approved successfully.',
        ]);
    }

    private function authorizeEntryForReview($user, KnowledgeEntry $entry): void
    {
        abort_unless($entry->company_id === $user->company_id, 403);
        abort_unless($entry->status === 'pending', 403);

        if ($user->role === 'department_manager') {
            $managedDepartment = Department::query()
                ->where('company_id', $user->company_id)
                ->where('manager_id', $user->id)
                ->first();

            abort_unless($managedDepartment, 403);
            abort_unless($entry->department_id === $managedDepartment->id, 403);
        }
    }
}
