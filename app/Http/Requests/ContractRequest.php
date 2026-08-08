<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

abstract class ContractRequest extends FormRequest
{
    protected const BUDGET_FIELDS = [
        'contract_mm_budget',
        'contract_pr_budget',
        'contract_pa_budget',
        'contract_po_budget',
        'contract_er_budget',
        'contract_cn_budget',
        'contract_oe_budget',
        'contract_ba_budget',
        'contract_bd_budget',
        'contract_refund_pa_budget',
        'contract_peryear_pa_budget',
        'contract_pay',
    ];

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $normalized = [
            'contract_name' => $this->normalizeText($this->input('contract_name')),
            'contract_number' => $this->normalizeText($this->input('contract_number')),
        ];

        foreach (self::BUDGET_FIELDS as $field) {
            $normalized[$field] = $this->normalizeBudget($this->input($field));
        }

        $this->merge($normalized);
    }

    /**
     * @return array<string, mixed>
     */
    protected function contractRules(?int $ignoredContractId = null): array
    {
        $uniqueContractNumber = Rule::unique('contracts', 'contract_number')
            ->where(function ($query) {
                return $query
                    ->where('contract_fiscal_year', $this->input('contract_fiscal_year'))
                    ->whereNull('deleted_at');
            });

        if ($ignoredContractId !== null) {
            $uniqueContractNumber->ignore($ignoredContractId, 'contract_id');
        }

        $rules = [
            'contract_name' => ['required', 'string', 'max:255'],
            'contract_number' => ['required', 'string', 'max:50', $uniqueContractNumber],
            'contract_fiscal_year' => ['required', 'integer'],
            'contract_start_date' => ['required', 'date_format:d/m/Y'],
            'contract_end_date' => ['required', 'date_format:d/m/Y', 'after_or_equal:contract_start_date'],
            'contract_mm_budget' => ['required', 'numeric', 'min:0', 'max:999999999.99'],
        ];

        foreach (array_diff(self::BUDGET_FIELDS, ['contract_mm_budget']) as $field) {
            $rules[$field] = ['nullable', 'numeric', 'min:0', 'max:999999999.99'];
        }

        return $rules;
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        $messages = [
            'contract_name.required' => 'กรุณาระบุชื่อสัญญา',
            'contract_number.required' => 'กรุณาระบุเลขที่สัญญา',
            'contract_number.unique' => 'เลขที่สัญญานี้มีอยู่แล้วในปีงบประมาณเดียวกัน',
            'contract_fiscal_year.required' => 'กรุณาระบุปีงบประมาณ',
            'contract_fiscal_year.integer' => 'ปีงบประมาณต้องเป็นตัวเลข',
            'contract_start_date.required' => 'กรุณาระบุวันที่เริ่มต้น',
            'contract_start_date.date_format' => 'วันที่เริ่มต้นต้องอยู่ในรูปแบบ วัน/เดือน/ปี',
            'contract_end_date.required' => 'กรุณาระบุวันที่สิ้นสุด',
            'contract_end_date.date_format' => 'วันที่สิ้นสุดต้องอยู่ในรูปแบบ วัน/เดือน/ปี',
            'contract_end_date.after_or_equal' => 'วันที่สิ้นสุดต้องไม่น้อยกว่าวันที่เริ่มต้น',
            'contract_mm_budget.required' => 'กรุณาระบุวงเงิน MM',
        ];

        foreach (self::BUDGET_FIELDS as $field) {
            $messages[$field.'.numeric'] = 'จำนวนเงินต้องเป็นตัวเลข';
            $messages[$field.'.min'] = 'จำนวนเงินต้องไม่น้อยกว่า 0';
            $messages[$field.'.max'] = 'จำนวนเงินเกินขนาดที่ระบบรองรับ';
        }

        return $messages;
    }

    private function normalizeText($value)
    {
        return is_string($value) ? trim($value) : $value;
    }

    private function normalizeBudget($value)
    {
        if (! is_string($value)) {
            return $value;
        }

        $normalized = str_replace([',', ' '], '', trim($value));

        return $normalized === '' ? null : $normalized;
    }
}
