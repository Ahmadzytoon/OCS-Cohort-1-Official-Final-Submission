<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StudioApprovalController extends Controller
{
    public function index(Request $request)
    {
        $tab  = $request->get('tab', 'pending');
        $q    = $request->get('q');
        $sort = $request->get('sort', 'newest');

        $totalApplications = User::where('account_type', 'studio')->count();
        $approvedCount     = User::where('account_type', 'studio')->where('status', 'approved')->count();
        $pendingCount      = User::where('account_type', 'studio')->where('status', 'pending')->count();
        $rejectedCount     = User::where('account_type', 'studio')->where('status', 'rejected')->count();

        $query = User::where('account_type', 'studio')
            ->with('studioProfile');

        if (in_array($tab, ['pending', 'approved', 'rejected'], true)) {
            $query->where('status', $tab);
        }

        if ($q) {
            $query->where(function ($w) use ($q) {
                $w->where('full_name', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%");
            });
        }

        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'name_az') {
            $query->orderBy('full_name', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $applications = $query->paginate(10)->withQueryString();

        return view('admin.studios', compact(
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
        abort_unless($user->account_type === 'studio', 404);

        $studio = $user->studioProfile;
        abort_if(!$studio, 404);

        $portfolio = $studio->portfolio()
            ->latest('uploaded_at')   // إذا عندك uploaded_at
            ->get();

        return view('admin.studios_show', compact('user', 'studio', 'portfolio'));
    }

    public function approve(User $user)
    {
        abort_unless($user->account_type === 'studio', 404);

        $user->forceFill([
            'status' => 'approved',
            'approved_at' => now(),
        ])->save();


        return redirect()->route('admin.studios.show', $user->id)
            ->with('success', 'Studio approved.');
    }

    public function reject(User $user)
    {
        abort_unless($user->account_type === 'studio', 404);

        $user->forceFill([
            'status' => 'rejected',
            'approved_at' => null,
        ])->save();

        return redirect()->route('admin.studios.show', $user->id)
            ->with('success', 'Studio rejected.');
    }
}
