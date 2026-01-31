<?php

namespace App\Services;

use App\Models\Plan;
use Illuminate\Support\Facades\DB;


class PlanService
{
    public function create(array $data): Plan
    {
        return DB::transaction(function () use ($data) {

            if (($data['billing_cycle'] ?? null) === 'trial' && empty($data['trial_days'])) {
                // أسهل حل للمبتدئة: نرمي Exception
                throw new \Exception('Trial days is required when billing cycle is trial.');
            }

            $plan = Plan::create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'price' => $data['price'],
                'billing_cycle' => $data['billing_cycle'],
                'trial_days' => $data['billing_cycle'] === 'trial' ? ($data['trial_days'] ?? null) : null,

                'max_users' => $data['max_users'],
                'max_departments' => $data['max_departments'],
                'max_knowledge_cards' => $data['max_knowledge_cards'],
                'ai_requests_limit' => $data['ai_requests_limit'],

                'is_active' => !empty($data['is_active']),
                'sort_order' => $data['sort_order'] ?? 0,
            ]);

            // Features
            $features = collect($data['features'] ?? [])
                ->map(fn($f) => trim($f))
                ->filter()
                ->values();

            foreach ($features as $i => $feature) {
                $plan->features()->create([
                    'feature' => $feature,
                    'sort_order' => $i,
                ]);
            }

            return $plan;
        });
    }

    public function delete(Plan $plan): void
    {
        DB::transaction(function () use ($plan) {

            // إذا عندك relation اسمها features:
            // (سواء جدول features منفصل أو pivot)
            if (method_exists($plan, 'features')) {
                $plan->features()->delete(); // أو ->detach() إذا pivot
            }

            $plan->delete(); // soft delete إذا الموديل فيه SoftDeletes
        });
    }
    public function update(Plan $plan, array $data): Plan
    {
        return DB::transaction(function () use ($plan, $data) {
            if (($data['billing_cycle'] ?? null) === 'trial' && empty($data['trial_days'])) {
                throw new \Exception('Trial days is required when billing cycle is trial.');
            }

            $trialDays = (($data['billing_cycle'] ?? null) === 'trial')
                ? ($data['trial_days'] ?? null)
                : null;

            $plan->update([
                'name' => $data['name'],
                'price' => $data['price'],
                'billing_cycle' => $data['billing_cycle'],
                'trial_days' => $trialDays,


                'max_users' => $data['max_users'] ?? 0,
                'max_departments' => $data['max_departments'] ?? 0,
                'max_knowledge_cards' => $data['max_knowledge_cards'] ?? 0,
                'ai_requests_limit' => $data['ai_requests_limit'] ?? 0,

                'is_active' => isset($data['is_active']) ? (int) $data['is_active'] : 1,
                'sort_order' => $data['sort_order'] ?? ($plan->sort_order ?? 0),
            ]);


            $features = collect($data['features'] ?? [])
                ->map(fn($x) => trim((string)$x))
                ->filter()
                ->values();

            if (method_exists($plan, 'features')) {
                $plan->features()->delete();

                // قبل الإضافة احذف القديم
                // $plan->features()->delete();

                foreach ($features as $i => $feature) {
                    $plan->features()->create([
                        'feature' => $feature,
                        'sort_order' => $i,
                    ]);
                }
            }

            return $plan;
        });
    }
}
