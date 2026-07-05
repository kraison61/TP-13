<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreQuoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $budgets = collect(config('vouchers.tiers'))->pluck('budget')->all();
        $amounts = collect(config('vouchers.tiers'))->pluck('amount')->all();

        return [
            'reference' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^[0-9\-\s]{9,20}$/'],
            'service' => ['required', 'string', 'max:255'],
            'budget' => ['required', 'string', Rule::in($budgets)],
            'requested_discount' => ['required', 'integer', 'in:'.implode(',', $amounts)],
            'detail' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $budget = $this->input('budget');
            $discount = (int) $this->input('requested_discount');

            $expected = collect(config('vouchers.tiers'))
                ->firstWhere('budget', $budget)['amount'] ?? null;

            if ($expected !== null && $expected !== $discount) {
                $validator->errors()->add(
                    'requested_discount',
                    'ส่วนลดที่เลือกไม่ตรงกับช่วงงบประมาณ กรุณาเลือกงบประมาณใหม่อีกครั้ง'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'name.required' => 'กรุณากรอกชื่อ–นามสกุล',
            'phone.required' => 'กรุณากรอกเบอร์โทรศัพท์',
            'phone.regex' => 'รูปแบบเบอร์โทรศัพท์ไม่ถูกต้อง',
            'service.required' => 'กรุณาเลือกประเภทงาน',
            'budget.required' => 'กรุณาเลือกงบประมาณ',
            'budget.in' => 'ช่วงงบประมาณไม่ถูกต้อง',
            'requested_discount.required' => 'ไม่พบข้อมูลส่วนลด กรุณาเลือกงบประมาณอีกครั้ง',
        ];
    }
}
