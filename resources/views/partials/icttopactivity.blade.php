@php
    $totalBudgetItOperating = 0;
    foreach ($project->main_task as $task) {
        if ($task->task_budget_it_operating && $task->task_status == 1 && $task->task_refund_pa_status == 1 && $task->task_refund_budget_type == 1) {
            $totalBudgetItOperating += $task->task_budget_it_operating;
        }
    }
@endphp

<p>
กิจกรรม ที่คืนงบประมาณ
<br>
@foreach ($project->main_task as $index => $task)
    {{-- Check for tasks with refund budget type 1 --}}
    @if ($task->task_budget_it_operating && $task->task_budget_type == 0 && $task->task_refund_pa_status == 3)
        - {{ $task->task_name }}: {{ number_format($task->task_refund_pa_budget, 2) }} บาท<br>
    @endif
@endforeach

<p>
    กิจกรรม ใช้งบประมาณ ที่คืนงบประมาณ
    <br>
@foreach ($project->main_task as $index => $task)
    {{-- Check for tasks with refund budget type 4 --}}
    @if ($task->task_budget_it_operating && $task->task_status == 1 && $task->task_refund_pa_status == 1 && $task->task_refund_budget_type == 1)
        - {{ $task->task_name }}: {{ number_format($task->task_budget_it_operating, 2) }} บาท<br>
    @endif
@endforeach

<p>
    {{ 'รวม'}}: {{ number_format($totalBudgetItOperating, 2) }} บาท<br>
</p>
