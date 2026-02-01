<?php

namespace App\Http\Controllers\CompanyOwner;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompanyProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        assert($user instanceof \App\Models\User);

        // dd(get_class($user));
        // dd(Auth::check(), Auth::user());
        // dd(
        //     Auth::check(),
        //     Auth::user(),
        //     Auth::user() ? get_class(Auth::user()) : null
        // );



        $company = $user->company()
            ->with(['owner', 'currentSubscription.plan'])
            ->firstOrFail();

        // Quick stats
        $totalEmployees = User::where('company_id', $company->id)->count();
        $departmentsCount = $company->departments()->count();
        $knowledgeCardsCount = $company->knowledgeEntries()->count();

        // Subscription + Payment (آخر دفعة)
        $subscription = $company->currentSubscription; // ممكن تكون null
        $latestPayment = null;

        if ($subscription) {
            $latestPayment = Payment::where('subscription_id', $subscription->id)
                ->where('company_id', $company->id)
                ->latest('paid_at')
                ->first();
        }

        return view('site.innerPages.companyOwner.companyProfile', compact(
            'company',
            'subscription',
            'latestPayment',
            'totalEmployees',
            'departmentsCount',
            'knowledgeCardsCount'
        ));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        assert($user instanceof \App\Models\User);



        $company = $user->company()->firstOrFail();

        $validated = $request->validate([
            'workspace_name' => ['required', 'string', 'max:191', 'unique:companies,workspace_name,' . $company->id],
            'company_size' => ['nullable', 'in:1-10,11-50,51-200,200+'],
            'industry' => ['nullable', 'in:it-software,accounting,marketing,hr,manufacturing,other'],
            'other_industry' => ['nullable', 'string', 'max:191'],

            'admin_name' => ['required', 'string', 'max:191'],
            'admin_email' => ['required', 'email', 'max:191', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        if (($validated['industry'] ?? null) !== 'other') {
            $validated['other_industry'] = null;
        }

        DB::transaction(function () use ($company, $user, $validated) {
            $company->update([
                'workspace_name' => $validated['workspace_name'],
                'company_size' => $validated['company_size'] ?? null,
                'industry' => $validated['industry'] ?? null,
                'other_industry' => $validated['other_industry'] ?? null,
            ]);

            $user->update([
                'name' => $validated['admin_name'],
                'email' => $validated['admin_email'],
            ]);

            if (!empty($validated['password'])) {
                $user->update([
                    'password' => Hash::make($validated['password']),
                ]);
            }
        });

        return back()->with('success', 'Profile updated successfully.');
    }
}
