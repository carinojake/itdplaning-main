<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateTaskPay implements Rule
{
    protected $costs;

    public function __construct($costs)
    {
        $this->costs = $costs;
    }

    public function passes($attribute, $value)
    {
         // Remove any commas from the values
    $task_cost_it_operating = str_replace(',', '', $this->costs['task_cost_it_operating']);
    $task_cost_it_investment = str_replace(',', '', $this->costs['task_cost_it_investment']);
    $task_cost_gov_utility = str_replace(',', '', $this->costs['task_cost_gov_utility']);

    // Convert the values to float
    $task_cost_it_operating = floatval($task_cost_it_operating);
    $task_cost_it_investment = floatval($task_cost_it_investment);
    $task_cost_gov_utility = floatval($task_cost_gov_utility);

    $totalCost = $task_cost_it_operating + $task_cost_it_investment + $task_cost_gov_utility;

    // Allow task_pay to be filled only if the total cost is greater than 0
    return $totalCost > 0 || $value === null;
    }

    public function message()
    {
        return 'ค่าใช้จ่าย ต้องมากกว่า 0 บาท หรือ ไม่กรอกเลย';
    }
}
