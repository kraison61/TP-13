<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreVoucherCopyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reference' => ['required', 'string', 'max:50'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $sessionReference = session('quote_reference');

            if (! is_string($sessionReference) || $sessionReference === '') {
                $validator->errors()->add('reference', 'ไม่พบรหัส E-Voucher ในเซสชัน');

                return;
            }

            if ($this->input('reference') !== $sessionReference) {
                $validator->errors()->add('reference', 'รหัส E-Voucher ไม่ถูกต้อง');
            }
        });
    }
}
