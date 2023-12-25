
<h6>
<p  class=text-ict  >งบกลาง ICT  : {{ number_format($budget['total_refund_pa_budget_it_operating']-$budget['totalBudgetItOperating'], 2) }} บาท<br>
</h6>
<!-- Rest of your code -->





<p>
กิจกรรม ที่คืนงบประมาณ
<br>
</p>
@foreach ($project->main_task as $index => $task)
    {{-- Check for tasks with refund budget type 1 --}}
    @if ($task->task_budget_it_operating > 1 && $task->task_budget_type == 0 && $task->task_refund_pa_status == 3 )
        - {{ $task->task_name }}: {{ number_format($task->task_refund_pa_budget, 2) }} บาท<br>
    @endif
@endforeach
<br>
<h6>
<p class=text-blue>
    {{ 'รวม'}}: {{ number_format($budget['total_refund_pa_budget_it_operating'], 2) }} บาท<br>
</p></h6>
@if($totalBudgetItOperating)

<p>
 กิจกรรม ใช้งบประมาณ ที่คืนงบประมาณ
</p>

@foreach ($project->main_task as $index => $task)
    {{-- Check for tasks with refund budget type 4 --}}

    @if ($task->task_budget_it_operating   && $task->task_status == 1 && $task->task_refund_pa_status == 1 && $task->task_refund_budget_type == 1)
    - {{ $task->task_name }}: {{ number_format($task->task_budget_it_operating-$task->task_refund_budget, 2) }} บาท<br>

    @elseif ($task->task_budget_it_operating && $task->task_budget_type == 0 && $task->task_refund_pa_status == 3 && $task->task_refund_budget_type == 1)
    -2 {{ $task->task_name }}: {{ number_format($task->task_budget_it_operating-$task->task_refund_budget, 2) }} บาท<br>

        @endif



    @endforeach
    <br>
    <h6>
    <p class=text-success>
    {{ 'รวม'}}: {{ number_format($budget['totalBudgetItOperating'], 2) }} บาท<br>
</p>
@endif
