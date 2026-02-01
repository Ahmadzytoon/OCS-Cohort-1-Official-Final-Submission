<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PhotographerApprovalController extends Controller
{
    public function index(Request $request)
    {
        $tab  = $request->get('tab', 'pending'); // pending|approved|rejected
        $q    = $request->get('q');
        $sort = $request->get('sort', 'newest');

        $totalApplications = User::where('account_type', 'photographer')->count();
        $approvedCount     = User::where('account_type', 'photographer')->where('status', 'approved')->count();
        $pendingCount      = User::where('account_type', 'photographer')->where('status', 'pending')->count();
        $rejectedCount     = User::where('account_type', 'photographer')->where('status', 'rejected')->count();

        // ✅ أهم شي: eager loading
        $query = User::where('account_type', 'photographer')
            ->with('photographerProfile');

        // ✅ فلترة حسب التبويب
        if (in_array($tab, ['pending', 'approved', 'rejected'], true)) {
            $query->where('status', $tab);
        }

        // ✅ بحث
        if ($q) {
            $query->where(function ($w) use ($q) {
                $w->where('full_name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        // ✅ ترتيب
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'name_az') {
            $query->orderBy('full_name', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $applications = $query->paginate(10)->withQueryString();

        return view('admin.photographers', compact(
            'tab',
            'q',
            'sort',
            'applications',
            'totalApplications',
            'approvedCount',
            'pendingCount',
            'rejectedCount'
        ));
    }

    public function show(User $user)
    {
        abort_unless($user->account_type === 'photographer', 404);

        $photographer = $user->photographerProfile;
        abort_if(!$photographer, 404);

        $portfolio = $photographer->portfolio()
            ->latest('uploaded_at')
            ->get();

        return view('admin.photographers_show', compact('user', 'photographer', 'portfolio'));
    }

    public function approve(User $user)
    {
        abort_unless($user->account_type === 'photographer', 404);

        $user->forceFill([
            'status' => 'approved',
            'approved_at' => now(),
        ])->save();


        return redirect()
            ->route('admin.photographers.show', $user->id)
            ->with('success', 'Photographer approved.');
    }

    public function reject(User $user)
    {
        abort_unless($user->account_type === 'photographer', 404);

        $user->forceFill([
            'status' => 'rejected',
            'approved_at' => null,
        ])->save();


        return redirect()
            ->route('admin.photographers.show', $user->id)
            ->with('success', 'Photographer rejected.');
    }
}
