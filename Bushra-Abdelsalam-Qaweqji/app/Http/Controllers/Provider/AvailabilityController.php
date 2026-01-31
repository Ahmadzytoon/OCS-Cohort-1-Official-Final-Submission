<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\AvailabilitySlot;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index()
    {
        $providerId = auth()->id();

        $categories = ServiceCategory::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $slots = AvailabilitySlot::query()
            ->where('provider_user_id', $providerId)
            ->with('category:id,code,name')
            ->orderBy('start_time')
            ->get();

        return view('provider.pages.availability', compact('slots', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_category_id' => ['required', 'integer', 'exists:service_categories,id'],
            'start_time' => ['required'],
            'end_time' => ['required'],
        ]);

        if (strtotime($data['end_time']) <= strtotime($data['start_time'])) {
            return back()->withErrors(['end_time' => 'End time must be after start time.'])->withInput();
        }

        AvailabilitySlot::create([
            'provider_user_id' => auth()->id(),
            'service_category_id' => $data['service_category_id'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'is_booked' => false,
        ]);

        return back()->with('success', 'Slot added.');
    }

    public function destroy(AvailabilitySlot $slot)
    {
        if ($slot->provider_user_id !== auth()->id()) {
            abort(403);
        }

        $slot->delete();

        return back()->with('success', 'Slot removed.');
    }
}
