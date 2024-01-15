<h6>
    <div class=text-black-underline>งบสาธาณูปโภค : <b class=text-blue-ganll  >{{ number_format($budget['total_refund_pa_budget_gov_utility']-$budget['totalBudgetGovUtility'], 2) }}</b> บาท</div>
</h6>
<div {{--  class=text-blue-ganll  --}} >
กิจกรรม ที่คืนงบประมาณ
</div>
@foreach ($project->main_task as $index => $task)
    {{-- Check for tasks with refund budget type 1 --}}
    @if ($task->task_budget_gov_utility && $task->task_budget_type == 0 && $task->task_refund_pa_status == 3 )
        - {{ $task->task_name }}: {{ number_format($task->task_refund_pa_budget, 2) }} บาท<br>
    @endif
@endforeach

<div >
    <b>  {{ 'รวม'}}:</b>  <b class=text-blue-ganll  >{{ number_format($budget['total_refund_pa_budget_gov_utility'], 2) }}</b>  บาท<br>
</div>
{{-- <p class=text-blue>
    {{ 'รวม'}}: {{ number_format($budget['total_refund_pa_budget_gov_utility'], 2) }} บาท<br>
</p> --}}
<p>
    @if($budget['totalBudgetGovUtility'])
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
    {{ 'รวม'}}:  <b class=text-red-crimson> {{ number_format($budget['totalBudgetGovUtility'], 2) }}  </b>บาท



@endif
{{--
                                            @foreach ($project->main_task as $index => $task)
                            @if ($task->task_budget_gov_utility > 0 && $task->task_budget_type == 0 && $task->task_refund_budget_type == 1)
                                            <P>-
                                            {{ $task->task_name }}
                                            {{ number_format($task->task_refund_pa_budget, 2) }} บาท
                                            @endif
                                            @endforeach --}}

