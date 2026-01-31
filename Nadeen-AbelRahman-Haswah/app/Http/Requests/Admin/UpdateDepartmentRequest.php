<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_id' => ['required', 'exists:companies,id'],
            'name' => [
                'required',
                'string',
                'max:255',
                // اسم القسم ما يتكرر داخل نفس الشركة (استثناء القسم الحالي)
                Rule::unique('departments', 'name')
                    ->where(fn($q) => $q->where('company_id', $this->company_id))
                    ->ignore($this->route('department')->id),
            ],
            'description' => ['nullable', 'string'],
            'manager_id' => ['nullable', 'exists:users,id'],
            'icon' => ['nullable', 'string', 'max:100'],
        ];
    }
}
