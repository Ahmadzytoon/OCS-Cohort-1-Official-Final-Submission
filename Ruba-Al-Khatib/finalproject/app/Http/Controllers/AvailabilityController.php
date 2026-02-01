<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Studio;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    private int $slotMinutes = 60;

    public function check(Request $request)
    {
        $data = $request->validate([
            'provider_type' => 'required|in:photographer,studio',
            'provider_id'   => 'required|integer',
            'date'          => 'required|date',
        ]);

        $date = Carbon::parse($data['date'])->startOfDay();

        $booked = Booking::query()
            ->where('provider_type', $data['provider_type'])
            ->where('provider_id', $data['provider_id'])
            ->whereDate('booking_date', $date->toDateString())
            ->whereIn('status', ['pending','approved'])
            ->pluck('booking_time')
            ->map(fn($t) => substr($t, 0, 5))
            ->toArray();

        [$start, $end] = $this->getWorkingWindow($data['provider_type'], $data['provider_id'], $date) ?? [null, null];

        if (!$start || !$end || $start->gte($end)) {
            return response()->json(['available' => []]);
        }

        $available = [];
        $cursor = $start->copy();

        while ($cursor->lt($end)) {
            $time = $cursor->format('H:i');
            if (!in_array($time, $booked)) {
                $available[] = $time;
            }
            $cursor->addMinutes($this->slotMinutes);
        }

        return response()->json([
            'date' => $date->toDateString(),
            'slot_minutes' => $this->slotMinutes,
            'available' => $available,
        ]);
    }

    private function getWorkingWindow(string $type, int $id, Carbon $date): ?array
    {
        if ($type === 'photographer') {
            return [
                $date->copy()->setTime(8, 0),
                $date->copy()->setTime(22, 0),
            ];
        }

        $studio = Studio::findOrFail($id);
        $wh = $studio->working_hours;

        $map = [1=>'monday',2=>'tuesday',3=>'wednesday',4=>'thursday',5=>'friday',6=>'saturday',0=>'sunday'];
        $key = $map[$date->dayOfWeek];

        $day = $wh[$key] ?? null;
        if (!$day || ($day['closed'] ?? true) === true) return null;

        $open  = $day['open'] ?? null;
        $close = $day['close'] ?? null;
        if (!$open || !$close) return null;

        $start = $date->copy()->setTimeFromTimeString($open);
        $end   = $date->copy()->setTimeFromTimeString($close);

        // إذا close أقل من open اعتبريه غلط إدخال → نرجع null
        if ($end->lte($start)) return null;

        return [$start, $end];
    }
}
