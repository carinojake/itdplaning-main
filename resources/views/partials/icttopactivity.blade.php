@foreach ($project->main_task as $index => $task)
    {{-- Check for tasks with refund budget type 1 --}}
    @if ($task->task_budget_it_operating && $task->task_budget_type == 0 && $task->task_refund_budget_type == 1)
        - {{ $task->task_name }}: {{ number_format($task->task_refund_pa_budget, 2) }} บาท<br>
    @endif
@endforeach


@foreach ($project->main_task as $index => $task)
    {{-- Check for tasks with refund budget type 4 --}}
    @if ($task->task_budget_it_operating && $task->task_budget_type == 0 && $task->task_refund_budget_type == 4)
        - {{ $task->task_name }}: {{ number_format($task->task_refund_pa_budget, 2) }} บาท<br>
    @endif
@endforeach
