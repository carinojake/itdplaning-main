
<h6>
<div class=text-black-underline>งบกลาง ICT  : <b class=text-blue-ganll  >

    @if(isset($budget['tasks_increased_amount_null']) && $budget['tasks_increased_amount_null'] > 1)
    {{ number_format($budget['totalBudgetItOperating'] - $budget['total_task_refund_budget_ItOperating'] - $budget['tasks_increased_amount_null'], 2) }}
@else
    {{ number_format($budget['totalBudgetItOperating'] - $budget['total_task_refund_budget_ItOperating'], 2) }}
@endif


</b> บาท</div>
</h6>
<!-- Rest of your code -->
<div>
กิจกรรม ที่คืนงบประมาณ
</div>
@foreach ($project->main_task as $index => $task)
    {{-- Check for tasks with refund budget type 1 --}}
    @if ($task->task_budget_it_operating > 1 && $task->task_budget_type == 0 && $task->task_refund_pa_status == 3 )
        - {{ $task->task_name }}: {{ number_format($task->task_refund_pa_budget, 2) }} บาท<br>
    @endif
@endforeach

     {{ 'รวม'}}:  <b class=text-blue-ganll  >{{ number_format($budget['total_refund_pa_budget_it_operating'], 2) }}</b>  บาท<br>

    {{-- {{ 'รวม'}}: {{ number_format($budget['total_refund_pa_budget_it_operating'], 2) }} บาท --}}



@if($totalBudgetItOperating)

<div>
 กิจกรรม ใช้งบประมาณ ที่คืนงบประมาณ
</div>

@foreach ($project->main_task as $index => $task)
    {{-- Check for tasks with refund budget type 4 --}}

    @if ($task->task_budget_it_operating   && $task->task_status == 1 && $task->task_refund_pa_status == 1 && $task->task_refund_budget_type == 1)
    - {{ $task->task_name }}: {{ number_format(($task->task_budget_it_operating-$task->tasks_increased_amount)-$task->task_refund_budget, 2) }} บาท <br>
    @elseif ($task->task_budget_it_operating && $task->task_budget_type == 0 && $task->task_refund_pa_status == 3 && $task->task_refund_budget_type == 1)
    - {{ $task->task_name }}: {{ number_format($task->task_budget_it_operating, 2) }} บาท <br>

        @endif



    @endforeach


    {{ 'รวม'}}:  <b class=text-red-crimson>
        @if(isset($budget['tasks_increased_amount_null']) && $budget['tasks_increased_amount_null'] > 1){
            {{ number_format($budget['totalBudgetItOperating']-$budget['total_task_refund_budget_ItOperating']- $budget['tasks_increased_amount_null'] , 2) }}
        }
        @else{
            {{ number_format($budget['totalBudgetItOperating']-$budget['total_task_refund_budget_ItOperating'], 2) }}
        }

    </b> บาท
    @endif
{{--         {{ number_format($budget['totalBudgetItOperating']-$budget['total_task_refund_budget_ItOperating']- $budget['tasks_increased_amount_null'] , 2) }}
 --}}



@endif
<p>
