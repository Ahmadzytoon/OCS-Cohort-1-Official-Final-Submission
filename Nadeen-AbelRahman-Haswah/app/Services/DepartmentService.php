<?php

namespace App\Services;

use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DepartmentService
{
    public function createDepartment(array $data): Department
    {
        return DB::transaction(function () use ($data) {
            $department = Department::create([
                'company_id'   => $data['company_id'],
                'name'         => $data['name'],
                'slug'         => Str::slug($data['name']),
                'icon'         => $data['icon'] ?? 'fa-briefcase',
                'description'  => $data['description'] ?? null,
                'manager_id'   => $data['manager_id'] ?? null,
                'is_active'    => true,
            ]);

            if (!empty($data['manager_id'])) {
                $this->assignManager($department, $data['manager_id']);
            }

            return $department;
        });
    }

    public function updateDepartment(Department $department, array $data): Department
    {
        return DB::transaction(function () use ($department, $data) {

            // 1) تحديث بيانات القسم
            $department->update([
                'company_id'  => $data['company_id'],
                'name'        => $data['name'],
                'slug'        => Str::slug($data['name']),
                'icon'        => $data['icon'] ?? $department->icon ?? 'fa-briefcase',
                'description' => $data['description'] ?? null,
                'manager_id'  => $data['manager_id'] ?? null,
            ]);

            // 2) تحديث المدير (اختياري)
            // إذا ما تم اختيار مدير => نخلي manager_id = null (وبس)
            if (!empty($data['manager_id'])) {
                $this->assignManager($department, $data['manager_id']);
            } else {
                $department->update(['manager_id' => null]);
            }

            return $department;
        });
    }

    private function assignManager(Department $department, int $managerId): void
    {
        // لازم المدير يكون من نفس الشركة
        $manager = User::where('id', $managerId)
            ->where('company_id', $department->company_id)
            ->first();

        if ($manager) {
            $manager->update([
                'department_id' => $department->id,
                'role' => 'department_manager',
                'status' => 'active',
            ]);

            $department->update(['manager_id' => $manager->id]);
        }
    }
}
