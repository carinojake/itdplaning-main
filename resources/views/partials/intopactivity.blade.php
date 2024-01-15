<h6>
    <div  class=text-black-underline>งบดำเนินงาน :  <b class=text-blue-ganll  >{{ number_format($budget['total_refund_pa_budget_it_investment']-$budget['totalBudgetItInvestment'], 2) }} </b>บาท
    </div>
</h6>
    <!-- Rest of your code -->
    <div {{--  class=text-blue-ganll  --}} >
    กิจกรรม ที่คืนงบประมาณ
    </div>

    @foreach ($project->main_task as $index => $task)
        {{-- Check for tasks with refund budget type 1 --}}
        @if ($task->task_budget_it_investment && $task->task_budget_type == 0 && $task->task_refund_pa_status == 3 )
            - {{ $task->task_name }}: {{ number_format($task->task_refund_pa_budget, 2) }} บาท<br>
        @endif
    @endforeach
    <div >
        <b>  {{ 'รวม'}}:</b>  <b class=text-blue-ganll  >{{ number_format($budget['total_refund_pa_budget_it_investment'], 2) }}</b>  บาท<br>
    </div>

    @if( $budget['totalBudgetItInvestment'])
    <div {{-- class=taxt-green-ganll --}}>
        กิจกรรม ใช้งบประมาณ ที่คืนงบประมาณ
    </div>

    @foreach ($project->main_task as $index => $task)
        {{-- Check for tasks with refund budget type 4 --}}

        @if ($task->task_budget_it_investment   && $task->task_status == 1 && $task->task_refund_pa_status == 1 && $task->task_refund_budget_type == 1)
        - {{ $task->task_name }}: {{ number_format($task->task_budget_it_investment, 2) }} บาท<br>

        @elseif ($task->task_budget_it_investment && $task->task_budget_type == 0 && $task->task_refund_pa_status == 3 && $task->task_refund_budget_type == 1)
        - {{ $task->task_name }}: {{ number_format($task->task_budget_it_investment, 2) }} บาท<br>

            @endif



        @endforeach

        <div >
            {{ 'รวม'}}:  <b class=text-red-crimson> {{ number_format($budget['totalBudgetItInvestment'], 2) }}  </b>บาท
{{--             <b>  {{ 'รวม'}}:</b> <b class=taxt-green-ganll>{{ number_format($budget['totalBudgetItInvestment'], 2) }}</b> บาท</div>
 --}}@endif

<p>
