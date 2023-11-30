@php
    $totalBudgetItOperating = 0;
    $totalrefundpabudget = 0;

    foreach ($project->main_task as $task) {
        if ($task->task_budget_it_operating && $task->task_status == 1 && $task->task_refund_pa_status == 1 && $task->task_refund_budget_type == 1) {
            $totalBudgetItOperating += $task->task_budget_it_operating;
        }
        elseif ($task->task_budget_it_operating && $task->task_status == 2 && $task->task_refund_pa_status == 3 && $task->task_refund_budget_type == 1) {
            # code...
            $totalBudgetItOperating += $task->task_budget_it_operating;
        }
        elseif ($task->task_budget_it_operating && $task->task_status == 1 && $task->task_parent_sub == 3 && $task->task_refund_budget_type == 1) {
            # code...
            $totalBudgetItOperating += $task->task_budget_it_operating;
        }

    }

    foreach ($project->main_task as $task) {
    if ($task->task_budget_it_operating && $task->task_budget_type == 0 && $task->task_refund_pa_status == 3){
            $totalrefundpabudget += $task->task_refund_pa_budget;
        }




    }



@endphp

<p>
กิจกรรม ที่คืนงบประมาณ
<br>
@foreach ($project->main_task as $index => $task)
    {{-- Check for tasks with refund budget type 1 --}}
    @if ($task->task_budget_it_operating && $task->task_budget_type == 0 && $task->task_refund_pa_status == 3 )
        - {{ $task->task_name }}: {{ number_format($task->task_refund_pa_budget, 2) }} บาท<br>
    @endif
@endforeach
<p>
    {{ 'รวม'}}: {{ number_format($totalrefundpabudget, 2) }} บาท<br>
</p>
<p>
 กิจกรรม ใช้งบประมาณ ที่คืนงบประมาณ
    <br>
@foreach ($project->main_task as $index => $task)
    {{-- Check for tasks with refund budget type 4 --}}

    @if ($task->task_budget_it_operating   && $task->task_status == 1 && $task->task_refund_pa_status == 1 && $task->task_refund_budget_type == 1)
    - {{ $task->task_name }}: {{ number_format($task->task_budget_it_operating, 2) }} บาท<br>

    @elseif ($task->task_budget_it_operating && $task->task_budget_type == 0 && $task->task_refund_pa_status == 3 && $task->task_refund_budget_type == 1)
    - {{ $task->task_name }}: {{ number_format($task->task_budget_it_operating, 2) }} บาท<br>

        @endif



    @endforeach

<p>
    {{ 'รวม'}}: {{ number_format($totalBudgetItOperating, 2) }} บาท<br>
</p>
