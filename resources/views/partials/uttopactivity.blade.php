@php
    $totalBudgetItutility = 0;
    $totalrefundpabudget = 0;

    foreach ($project->main_task as $task) {
        if ($task->task_budget_gov_utility && $task->task_status == 1 && $task->task_refund_pa_status == 1 && $task->task_refund_budget_type == 1) {
            $totalBudgetItutility += $task->task_budget_gov_utility;
        }
        elseif ($task->task_budget_gov_utility && $task->task_status == 2 && $task->task_refund_pa_status == 3 && $task->task_refund_budget_type == 1) {
            # code...
            $totalBudgetItutility += $task->task_budget_gov_utility;
        }


    }

    foreach ($project->main_task as $task) {
    if ($task->task_budget_gov_utility && $task->task_budget_type == 0 && $task->task_refund_pa_status == 3){
            $totalrefundpabudget += $task->task_refund_pa_budget;
        }




    }



@endphp

<p>
กิจกรรม ที่คืนงบประมาณ
<br>
@foreach ($project->main_task as $index => $task)
    {{-- Check for tasks with refund budget type 1 --}}
    @if ($task->task_budget_gov_utility && $task->task_budget_type == 0 && $task->task_refund_pa_status == 3 )
        - {{ $task->task_name }}: {{ number_format($task->task_refund_pa_budget, 2) }} บาท<br>
    @endif
@endforeach
<p>
    {{ 'รวม'}}: {{ number_format($totalrefundpabudget, 2) }} บาท<br>
</p>
<p>
    @if($totalBudgetItutility)
 กิจกรรม ใช้งบประมาณ ที่คืนงบประมาณ
    <br>
@foreach ($project->main_task as $index => $task)
    {{-- Check for tasks with refund budget type 4 --}}

    @if ($task->task_budget_gov_utility   && $task->task_status == 1 && $task->task_refund_pa_status == 1 && $task->task_refund_budget_type == 1)
    - {{ $task->task_name }}: {{ number_format($task->task_budget_gov_utility, 2) }} บาท<br>

    @elseif ($task->task_budget_gov_utility && $task->task_budget_type == 0 && $task->task_refund_pa_status == 3 && $task->task_refund_budget_type == 1)
    - {{ $task->task_name }}: {{ number_format($task->task_budget_gov_utility, 2) }} บาท<br>

        @endif



    @endforeach

<p>
    {{ 'รวม'}}: {{ number_format($totalBudgetItutility, 2) }} บาท<br>
</p>

@endif
{{--
                                            @foreach ($project->main_task as $index => $task)
                            @if ($task->task_budget_gov_utility > 0 && $task->task_budget_type == 0 && $task->task_refund_budget_type == 1)
                                            <P>-
                                            {{ $task->task_name }}
                                            {{ number_format($task->task_refund_pa_budget, 2) }} บาท
                                            @endif
                                            @endforeach --}}

