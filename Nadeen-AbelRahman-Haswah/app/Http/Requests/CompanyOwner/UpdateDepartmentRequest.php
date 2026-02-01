<?php
namespace App\Http\Requests\CompanyOwner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class UpdateDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = Auth::user();
        assert($user instanceof \App\Models\User);

        $departmentId = $this->route('department')->id;

        return [
            'name' => [
                'required','string','max:255',
                Rule::unique('departments', 'name')
                    ->where(fn($q) => $q->where('company_id', $user->company_id))
                    ->ignore($departmentId),
            ],
            'icon' => ['nullable','string','max:100'],
            'description' => ['nullable','string'],
            'manager_id' => ['nullable','integer','exists:users,id'],
        ];
    }
}
