<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWorkspaceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'workspace_name' => ['required', 'string', 'max:255', 'unique:companies,workspace_name'],

            'company_size' => ['nullable', Rule::in(['1-10','11-50','51-200','200+'])],
            'industry' => ['nullable', Rule::in(['it-software','accounting','marketing','hr','manufacturing','other'])],
            'other_industry' => ['nullable', 'string', 'max:255'],

            'owner_name' => ['required', 'string', 'max:255'],
            'owner_email' => ['required', 'email', 'max:255', 'unique:users,email'],

            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('other_industry', ['required'], function ($input) {
            return ($input->industry ?? null) === 'other';
        });
    }
}
