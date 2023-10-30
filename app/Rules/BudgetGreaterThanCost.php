<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BudgetGreaterThanCost implements Rule
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
        return 'วงเงินที่ขออนุมัติ งบกลาง ICT ต้องมากกว่าหรือเท่ากับ รอการเบิก งบกลาง ICT.';
    }
}
