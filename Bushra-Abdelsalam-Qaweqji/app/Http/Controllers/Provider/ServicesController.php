<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\ProviderService;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServicesController extends Controller
{
    public function index()
    {
        $providerId = auth()->id();

        $categories = ServiceCategory::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $providerServices = ProviderService::query()
            ->where('provider_user_id', $providerId)
            ->with(['category:id,code,name', 'optionPricings.serviceOption:id,name,pricing_type,service_category_id'])
            ->get()
            ->keyBy('service_category_id');

        $optionsByCategory = \App\Models\ServiceOption::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get()
            ->groupBy('service_category_id');

        return view('provider.pages.services', compact('categories', 'providerServices', 'optionsByCategory'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_category_id' => ['required', 'integer', 'exists:service_categories,id'],
            'hourly_rate' => ['required', 'numeric', 'min:1'],
        ]);

        ProviderService::create([
            'provider_user_id' => auth()->id(),
            'service_category_id' => $data['service_category_id'],
            'hourly_rate' => $data['hourly_rate'],
        ]);

        return back()->with('success', 'Service added.');
    }

    public function update(Request $request, ProviderService $providerService)
    {
        if ($providerService->provider_user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'hourly_rate' => ['required', 'numeric', 'min:1'],
        ]);

        $providerService->update([
            'hourly_rate' => $data['hourly_rate'],
        ]);

        return back()->with('success', 'Service updated.');
    }

    public function updateOptions(Request $request, ProviderService $providerService)
    {
        if ($providerService->provider_user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'options' => ['array'],
            'options.*.service_option_id' => [
                'required',
                'integer',
                Rule::exists('service_options', 'id')
                    ->where('service_category_id', $providerService->service_category_id),
            ],
            'options.*.price' => ['required', 'numeric', 'min:0'],
        ]);

        $options = $data['options'] ?? [];

        foreach ($options as $opt) {
            \App\Models\ProviderOptionPricing::updateOrCreate(
                [
                    'provider_service_id' => $providerService->id,
                    'service_option_id' => $opt['service_option_id'],
                ],
                [
                    'price' => $opt['price'],
                ]
            );
        }

        return back()->with('success', 'Options updated.');
    }

    public function destroy(ProviderService $providerService)
    {
        if ($providerService->provider_user_id !== auth()->id()) {
            abort(403);
        }

        $providerService->delete();

        return back()->with('success', 'Service deleted.');
    }
}
