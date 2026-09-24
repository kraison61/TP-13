<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePhoneClickRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => ['required', 'string', 'max:32'],
            'page_url' => ['nullable', 'string', 'max:500'],
            'placement' => ['nullable', 'string', 'max:64'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $phone = preg_replace('/[^\d+]/', '', (string) $this->input('phone')) ?? '';

        $this->merge([
            'phone' => $phone,
            'page_url' => $this->filled('page_url')
                ? mb_substr((string) $this->input('page_url'), 0, 500)
                : null,
            'placement' => $this->filled('placement')
                ? mb_substr((string) $this->input('placement'), 0, 64)
                : null,
        ]);
    }
}
