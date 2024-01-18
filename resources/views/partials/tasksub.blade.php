

@if ($task['task_parent_sub'] === 2)

<x-slot:toolbar>
    @if($task->task_status == 1)
    @if($task_sub_refund_total_count == $task_sub_refund_count )
    <form class="taskRefund-form" action="{{ route('project.task.taskRefund_prarent_3', ['project' => $project->hashid, 'task' => $task->hashid]) }}" method="POST" style="display:inline">
        @method('POST') {{-- Use POST method to submit the form --}}
        @csrf
        <button class="btn btn-primary text-dark btn-taskRefund"><i class="cil-money"></i></button>
    </form>
    @endif

    <a href="{{ route('project.task.editsub', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
        class="btn btn-warning text-dark"> <i class="cil-cog"></i>{{-- แก้ไขedit {{ Helper::projectsType($project->project_type) }} --}}
    </a>
    @if ($task->task_budget_it_operating > 0)
    <a href="{{ route('project.task.createsub', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
        class="btn btn-success text-white">เพิ่ม สัญญา</a>

    <a href="{{ route('project.task.createsubnop', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
        class="btn btn-dark text-white">เพิ่มรายการที่ใช้จ่าย </a>
@elseif ($task->task_budget_it_investment > 0)
    <a href="{{ route('project.task.createsub', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
        class="btn btn-success text-white">เพิ่ม สัญญา</a>

    <a href="{{ route('project.task.createsubnop', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
        class="btn btn-dark text-white">เพิ่มรายการที่ใช้จ่าย </a>
@elseif ($task->task_budget_gov_utility > 0)
    <a href="{{ route('project.task.createsub', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
        class="btn btn-success text-white">เพิ่ม สัญญา</a>

    <a href="{{ route('project.task.createsubnop', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
        class="btn btn-dark text-white">เพิ่มรายการที่ใช้จ่าย</a>
@endif
@endif
<a href="{{ route('project.view', ['project' => $project->hashid]) }}"
    class="btn btn-secondary">กลับ</a>
</x-slot:toolbar>
<span class="<?= $task->task_refund_pa_status == 2 ? 'text-blue' : '' ?>">

<h2>{{ $task->task_name }}   @if(auth()->user()->isAdmin()) [{{   $task_rs_get['rs'] }}]  @endif</h2>
</span>
<div class="container">
    <div class="row mt-5">
        <div class="col-sm">
            <div class="row">
                <div class="col-6 fw-semibold">{{ __('ปีงบประมาณ') }}</div>
                {{ $project->project_fiscal_year }}
            </div>
        </div>
        <div class="col-sm">

            <div class="row">
                @if ($task->task_budget_it_operating > 0)
                    <div class="col-6 fw-semibold">{{ __('งบกลาง ICT') }}</div>
                    {{ number_format(floatval($task->task_budget_it_operating), 2) }} บาท
                @endif
            </div>
            <div class="row">
                @if ($task->task_budget_it_investment > 0)
                    <div class="col-6 fw-semibold">{{ __('งบดำเนินงาน') }}</div>
                    {{ number_format(floatval($task->task_budget_it_investment), 2) }} บาท
                @endif
            </div>
            <div class="row">
                @if ($task->task_budget_gov_utility > 0)
                    <div class="col-6 fw-semibold">{{ __('ค่าสาธารณูปโภค') }}</div>
                    {{ number_format(floatval($task->task_budget_gov_utility), 2) }} บาท
                @endif
            </div>
        </div>
        <div class="col-sm">
            <div class="row">
                @if ($task->task_budget_it_operating > 0)
                    <div class="col-6 fw-semibold">{{ __('คงเหลือ งบกลาง ICT') }}</div>
                    {{ number_format(floatval($task->task_budget_it_operating - $task_sub_sums['operating']['task_mm_budget'] + $task_sub_refund_pa_budget['operating']['task_refund_pa_budget']), 2) }} บาท
                @endif
            </div>
            <div class="row">
                @if ($task->task_budget_it_investment > 0)
                    <div class="col-6 fw-semibold">{{ __('คงเหลือ งบดำเนินงาน') }}</div>
                    {{ number_format(floatval($task->task_budget_it_investment - $task_sub_sums['investment']['task_mm_budget'] + $task_sub_refund_pa_budget['investment']['task_refund_pa_budget']), 2) }} บาท
                @endif
            </div>
            <div class="row">
                @if ($task->task_budget_gov_utility > 0)
                    <div class="col-6 fw-semibold">{{ __('คงเหลือ งบสาธารณูปโภค') }}</div>
                    <div class="col-6">
                        {{ number_format(floatval($task->task_budget_gov_utility - $task_sub_sums['utility']['task_mm_budget'] + $task_sub_refund_pa_budget['utility']['task_refund_pa_budget']), 2) }} บาท

                    </div>
                @endif
            </div>
        </div>


            <div class="row mt-3">
                <div class="col-12 fw-semibold">
                    <div>{{ __('รายละเอียดงาน/โครงการ') }}</div>
                </div>
                {{ $task->task_description }}
            </div>
    </div>



<table class="table mt-3">
    <tbody>
        <tr>
            <th width="50">ลำดับ</th>
            <th>กิจกรรม</th>
            <th>สถานะ</th>
            <th>วันที่</th>
            <th>งบ</th>
            <th></th>
            <th>ที่ค่าใช้จ่าย</th>
            <th>เบิก</th>
            <th width="200">ข้อมูล</th>
        </tr>
        @if ($task->subtask->count() > 0)
            @foreach ($task->subtask as $index => $subtask)



@php
$relatedData = collect($cteQuery)->firstWhere('root', $subtask->task_id);
$resultthItem = collect($resultth)->firstWhere('taskid', $subtask->task_id);
@endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>

                        @foreach ($subtask->contract as $contract)
                        <a href="{{ route('contract.show', ['contract' => $contract->hashid]) }}" class="btn btn-primary text-white badge">
                            สญ.ที่ {{ $contract->contract_number }}
                        </a>

                    @endforeach
                    <span class="<?= $subtask->task_refund_pa_status == 2 ? 'text-blue' : '' ?>">
                        {{ $subtask?->task_name }}
                    </span>


                    </td>
                    <td>

                        <span class="badge {{ $subtask->task_status == 2 ? 'bg-success' : '' }}">
                            {{ $subtask->task_status == 2 ? 'ดำเนินการแล้วเสร็จ' : '' }}
                        </span>
                   {{--      @if(isset($subtask) && $subtask->task_refund_pa_status == 2)
                            <span class="badge bg-success">ดำเนินการแล้วเสร็จคืนเงิน pa</span>
                        @else
                            <span class="badge bg-info">ไม่คืนเงิน pa</span>
                        @endif --}}
                    </td>
                    <td>
                        <span class="badge bg-primary">{{ \Helper::date4(date('Y-m-d H:i:s', $subtask->task_start_date)) }}</span>
                        <span class="badge bg-primary">{{ \Helper::date4(date('Y-m-d H:i:s', $subtask->task_end_date)) }}</span>
                    </td>

                    <td>{{ number_format($subtask->task_budget_it_operating+$subtask->task_budget_it_investment+$subtask->task_budget_gov_utility,2) }}  บาท </td>
                    <td></td>
                    <td>
                        <span style="color: red;">
                        {{ number_format($subtask->task_cost_it_operating+$subtask->task_cost_it_investment+$subtask->task_cost_gov_utility,2) }}    </span>บาท

                    </td>
                    <td>

                    @if ($subtask->task_pay > 1)
                    <span class="text-warning">
                        {{ number_format($subtask?->task_pay,2) }} </span>บาท
                        @else
                        <span class="text-warning">
                  {{ number_format($resultthItem?->total_pay_con,2) }}    </span>บาท
                        @endif




                    </td>
                    <td>



                        @foreach ($subtask->contract as $contract)
                        <a href="{{ route('contract.show', ['contract' => $contract->hashid]) }}" class="btn btn-success btn-sm"><i class="cil-description"></i></a>
                    @endforeach

                    @if ($subtask->contract->count() < 1)
                        <a href="{{ route('project.task.show', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}" class="btn btn-primary btn-sm"><i class="cil-folder-open"></i></a>
                    @endif

                    @if($subtask->task_status == 1 ||$subtask->task_refund_pa_status == 1)
                        <a href="{{ route('project.task.editsub', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}"
                            class="btn btn-warning btn-sm" ><i class="cil-cog"></i></a>

                 @endif


                @if($subtask->task_status == 2)
                 <form class="delete-form"
                 action="{{ route('project.task.destroy', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}"
                 method="POST" style="display:inline">
                 @method('DELETE')
                 @csrf
                 <button class="btn btn-danger text-white btn-delete"><i class="cil-trash"></i></button>
             </form>
                @endif

                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="12">
                        @foreach ($subtask->subtaskparent as $subtask_sub)
                            <div>- {{ $subtask_sub->task_name }}</div>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@endif



