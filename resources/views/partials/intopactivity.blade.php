<h6>
    <p  class=text-investment  >งบดำเนินงาน : {{ number_format($budget['total_refund_pa_budget_it_investment']-$budget['totalBudgetItInvestment'], 2) }} บาท<br>
    </h6>
    <!-- Rest of your code -->




<p>
    กิจกรรม ที่คืนงบประมาณ
    <br>
    @foreach ($project->main_task as $index => $task)
        {{-- Check for tasks with refund budget type 1 --}}
        @if ($task->task_budget_it_investment && $task->task_budget_type == 0 && $task->task_refund_pa_status == 3 )
            - {{ $task->task_name }}: {{ number_format($task->task_refund_pa_budget, 2) }} บาท<br>
        @endif
    @endforeach
    <p class=text-blue>
        {{ 'รวม'}}: {{ number_format($budget['total_refund_pa_budget_it_investment'], 2) }}  บาท<br>
    </p>
    <p>

    @if( $budget['totalBudgetItInvestment'])
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

        <p class=text-success>
        {{ 'รวม'}}: {{ number_format($budget['totalBudgetItInvestment'], 2) }} บาท<br>

    </p>
@endif

