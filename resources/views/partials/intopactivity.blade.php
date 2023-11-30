@php
    $totalBudgetItinvestment = 0;
    $totalrefundpabudgetin = 0;

    foreach ($project->main_task as $task) {
        if ($task->task_budget_it_investment && $task->task_status == 1 && $task->task_refund_pa_status == 1 && $task->task_refund_budget_type == 1) {
            $totalBudgetItinvestment += $task->task_budget_it_investment;
        }
        elseif ($task->task_budget_it_investment && $task->task_status == 2 && $task->task_refund_pa_status == 3 && $task->task_refund_budget_type == 1) {
            # code...
            $totalBudgetItinvestment += $task->task_budget_it_investment;
        }


    }

    foreach ($project->main_task as $task) {
    if ($task->task_budget_it_investment && $task->task_budget_type == 0 && $task->task_refund_pa_status == 3){
            $totalrefundpabudgetin += $task->task_refund_pa_budget;
        }




    }



@endphp

<p>
    กิจกรรม ที่คืนงบประมาณ
    <br>
    @foreach ($project->main_task as $index => $task)
        {{-- Check for tasks with refund budget type 1 --}}
        @if ($task->task_budget_it_investment && $task->task_budget_type == 0 && $task->task_refund_pa_status == 3 )
            - {{ $task->task_name }}: {{ number_format($task->task_refund_pa_budget, 2) }} บาท<br>
        @endif
    @endforeach
    <p>
        {{ 'รวม'}}: {{ number_format($totalrefundpabudgetin, 2) }} บาท<br>
    </p>
    <p>
        กิจกรรม ใช้งบประมาณ ที่คืนงบประมาณ
        <br>
    @foreach ($project->main_task as $index => $task)
        {{-- Check for tasks with refund budget type 4 --}}

        @if ($task->task_budget_it_investment   && $task->task_status == 1 && $task->task_refund_pa_status == 1 && $task->task_refund_budget_type == 1)
        - {{ $task->task_name }}: {{ number_format($task->task_budget_it_investment, 2) }} บาท<br>

        @elseif ($task->task_budget_it_investment && $task->task_budget_type == 0 && $task->task_refund_pa_status == 3 && $task->task_refund_budget_type == 1)
        - {{ $task->task_name }}: {{ number_format($task->task_budget_it_investment, 2) }} บาท<br>

            @endif



        @endforeach

    <p>
        {{ 'รวม'}}: {{ number_format($totalBudgetItinvestment, 2) }} บาท<br>
    </p>


