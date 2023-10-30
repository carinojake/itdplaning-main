<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BudgetGreaterThanCostInvestment implements Rule
{
    protected $cost;

    public function __construct($cost)
    {
        $this->cost = $cost;
    }

    public function passes($attribute, $value)
    {
        return $value >= $this->cost;
    }

    public function message()
    {
        return 'วงเงินที่ขออนุมัติ งบดำเนินงาน ต้องมากกว่าหรือเท่ากับ รอการเบิก งบดำเนินงาน.';
    }
}
