<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDepartmentRequest extends FormRequest
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
                Rule::unique('departments', 'name')->where(
                    fn($q) =>
                    $q->where('company_id', $this->company_id)->whereNull('deleted_at')
                ),
            ],

            'icon' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],

            // لازم يكون manager من نفس الشركة
            'manager_id' => ['nullable', 'exists:users,id'],

            // employees[] لازم يكونوا users موجودين
            'employees' => ['nullable', 'array'],
            'employees.*' => ['integer', 'exists:users,id'],
        ];
    }
}
