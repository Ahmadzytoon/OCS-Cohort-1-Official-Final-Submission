<?php
namespace App\Http\Requests\CompanyOwner;
use Illuminate\Support\Facades\Auth;


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
        $user = Auth::user();
        assert($user instanceof \App\Models\User);

        return [
            'name' => [
                'required','string','max:255',
                Rule::unique('departments', 'name')
                    ->where(fn($q) => $q->where('company_id', $user->company_id)->whereNull('deleted_at')),
            ],
            'icon' => ['nullable','string','max:100'],
            'description' => ['nullable','string'],
            'manager_id' => ['nullable','integer','exists:users,id'],
        ];
    }
}
