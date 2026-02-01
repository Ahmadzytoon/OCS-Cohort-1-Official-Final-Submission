<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePlanRequest;
use App\Models\Plan;
use App\Services\PlanService;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::with('features')->orderBy('sort_order')->latest()->get();
        return view('admin.plans', compact('plans'));
    }

    public function create()
    {
        return view('admin.addPlan');
    }

    public function store(StorePlanRequest $request, PlanService $service)
    {
        try {
            $service->create($request->validated());
        } catch (\Exception $e) {
            return back()->withErrors(['trial_days' => $e->getMessage()])->withInput();
        }

        return redirect()->route('admin.plans.index')->with('success', 'Plan created successfully!');
    }
    public function destroy(Plan $plan, PlanService $service)
    {
        $service->delete($plan);

        return redirect()
            ->route('admin.plans.index')
            ->with('success', 'Plan deleted successfully!');
    }
    public function edit(Plan $plan)
    {
        $plan->load('features');

        $features = $plan->features->pluck('feature')->toArray();
        return view('admin.editPlan', compact('plan', 'features'));
    }

    public function update(StorePlanRequest $request, Plan $plan, PlanService $service)
    {
        try {
            $service->update($plan, $request->validated());
        } catch (\Exception $e) {
            return back()->withErrors(['trial_days' => $e->getMessage()])->withInput();
        }

        return redirect()->route('admin.plans.index')->with('success', 'Plan updated successfully!');
    }
}
