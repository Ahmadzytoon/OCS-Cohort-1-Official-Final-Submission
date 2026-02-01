<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:0'],
            'billing_cycle' => ['required', 'in:monthly,yearly,trial,lifetime'],
            'trial_days' => ['nullable', 'integer', 'min:1', 'max:365'],

            'max_users' => ['required', 'integer', 'min:0'],
            'max_departments' => ['required', 'integer', 'min:0'],
            'max_knowledge_cards' => ['required', 'integer', 'min:0'],
            'ai_requests_limit' => ['required', 'integer', 'min:0'],

            'is_active' => ['nullable'], // checkbox
            'sort_order' => ['nullable', 'integer', 'min:0'],

            // features inputs: features[]
            'features' => ['nullable', 'array'],
            'features.*' => ['nullable', 'string', 'max:255'],
        ];
    }
}
