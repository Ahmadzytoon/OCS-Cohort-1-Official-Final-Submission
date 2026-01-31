<?php

namespace App\Http\Controllers\Shared;
use App\Http\Controllers\Controller;
use App\Models\AccessRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RequestsStatusController extends Controller
{
    public function index()
    {
        $companyId = Auth::user()->company_id;

        $pendingRequests = AccessRequest::with(['company','department'])
            ->where('company_id', $companyId)
            ->where('status', 'pending')
            ->latest()
            ->paginate(5);

        // stats
        $pendingCount = AccessRequest::where('company_id', $companyId)
            ->where('status','pending')
            ->count();

        $approvedThisMonth = AccessRequest::where('company_id', $companyId)
            ->where('status','approved')
            ->whereMonth('processed_at', now()->month)
            ->whereYear('processed_at', now()->year)
            ->count();

        $rejectedThisMonth = AccessRequest::where('company_id', $companyId)
            ->where('status','rejected')
            ->whereMonth('processed_at', now()->month)
            ->whereYear('processed_at', now()->year)
            ->count();

        // departments list for approve modal (اختياري إذا بدك تعيين/تعديل القسم)
        $departments = Department::where('company_id', $companyId)->where('is_active',1)->orderBy('name')->get();

        return view('site.innerPages.companyOwner.accessRequests', compact(
            'pendingRequests',
            'pendingCount',
            'approvedThisMonth',
            'rejectedThisMonth',
            'departments'
        ));
    }

    public function approve(Request $request, AccessRequest $accessRequest)
    {
        $companyId = Auth::user()->company_id;

        abort_if($accessRequest->company_id != $companyId, 403);
        abort_if($accessRequest->status !== 'pending', 403);

        $validated = $request->validate([
            'approved_role' => ['required','in:employee,department_manager'],
            'department_id' => ['nullable','exists:departments,id'],
            'position' => ['nullable','string','max:191'],
            'password' => ['required','min:8','confirmed'],
            'welcome_message' => ['nullable','string'],
        ]);

        // إذا owner اختار قسم، لازم يكون بنفس الشركة
        if (!empty($validated['department_id'])) {
            $ok = Department::where('id', $validated['department_id'])
                ->where('company_id', $companyId)->exists();
            if (!$ok) {
                return back()->withErrors(['department_id' => 'Invalid department.'])->withInput();
            }
        }

        // create user
        $user = User::create([
            'name' => $accessRequest->name,
            'email' => $accessRequest->email,
            'phone' => $accessRequest->phone,
            'company_id' => $companyId,
            'department_id' => $validated['department_id'] ?? $accessRequest->department_id,
            'position' => $validated['position'] ?? null,
            'role' => $validated['approved_role'],
            'status' => 'active',
            'joined_at' => now(),
            'password' => Hash::make($validated['password']),
        ]);

        // update request
        $accessRequest->update([
            'status' => 'approved',
            'approved_role' => $validated['approved_role'],
            'position' => $validated['position'] ?? null,
            'processed_by' => Auth::id(),
            'processed_at' => now(),
        ]);

        // send email (دعينا نعمله لاحقًا بميلابِل)
        // Mail::to($user->email)->send(new InviteEmployeeMail($user, $validated['password'], $validated['welcome_message'] ?? null));

        return redirect()->route('shared.accessRequests.index')
            ->with('success', 'Request approved and employee account created!');
    }

    public function reject(Request $request, AccessRequest $accessRequest)
    {
        $companyId = Auth::user()->company_id;

        abort_if($accessRequest->company_id != $companyId, 403);
        abort_if($accessRequest->status !== 'pending', 403);

        $validated = $request->validate([
            'rejection_reason' => ['required','in:not_hiring,no_position,qualifications,other'],
            'rejection_message' => ['nullable','string'],
        ]);

        $accessRequest->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'rejection_message' => $validated['rejection_message'] ?? null,
            'processed_by' => Auth::id(),
            'processed_at' => now(),
        ]);

        // ممكن تبعتي إيميل اعتذار (اختياري)
        // Mail::to($accessRequest->email)->send(new RejectAccessRequestMail(...));

        return redirect()->route('shared.accessRequests.index')
            ->with('success', 'Request rejected successfully!');
    }
}

