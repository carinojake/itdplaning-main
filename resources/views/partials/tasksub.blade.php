

@if ($task['task_parent_sub'] === 2)

<x-slot:toolbar>
    {{-- <form class="taskRefund-form" action="{{ route('project.task.taskRefund', ['project' => $project->hashid, 'task' => $task->hashid]) }}" method="POST" style="display:inline">
        @method('POST')
        @csrf
        <button class="btn btn-warning text-white btn-taskRefund-sub"><i class="cil-money">taskRefund</i></button>
    </form> --}}
    <form class="taskRefund-form" action="{{ route('project.task.taskRefund_prarent_3', ['project' => $project->hashid, 'task' => $task->hashid]) }}" method="POST" style="display:inline">
        @method('POST') {{-- Use POST method to submit the form --}}
        @csrf
        <button class="btn btn-primary text-dark btn-taskRefund"><i class="cil-money">taskRefund_prarent_3</i></button>
    </form>

    {{-- <form class="taskRefund-form" action="{{ route('project.task.taskRefund', ['project' => $project->hashid, 'task' => $task->hashid]) }}" method="POST" style="display:inline">
        @method('POST')
        @csrf
        <button class="btn btn-warning text-white btn-taskRefund-sub">1.1<i class="cil-money"></i></button>
    </form>

    <form class="taskRefund-form" action="{{ route('project.task.taskRefundbudget_sub_st', ['project' => $project->hashid, 'task' => $task->hashid]) }}" method="POST" style="display:inline">
        @method('POST')
        @csrf
        <button class="btn btn-Light text-dark btn-taskRefund-sub"><i class="cil-money">taskRefundbudget_sub_st</i></button>
    </form>
    <form class="taskRefund-form" action="{{ route('project.task.taskRefundbudget_str', ['project' => $project->hashid, 'task' => $task->hashid]) }}" method="POST" style="display:inline">
        @method('POST')
        @csrf
        <button class="btn btn-info text-dark btn-taskRefund-sub"><i class="cil-money">taskRefundbudget_str</i></button>
    </form>


    <form class="taskRefund-form" action="{{ route('project.task.taskRefundbudget_sub', ['project' => $project->hashid, 'task' => $task->hashid]) }}" method="POST" style="display:inline">
        @method('POST')
        @csrf
        <button class="btn btn-dark text-dark btn-taskRefund-sub"><i class="cil-money">taskRefundbudget_sub</i></button>
    </form> --}}





{{--     <form class="taskRefund-form" action="{{ route('project.task.taskRefundbudget_sub', ['project' => $project->hashid, 'task' => $task->hashid]) }}" method="POST" style="display:inline">
        @method('POST')
        @csrf
        <button class="btn btn-danger text-white btn-delete"><i class="cil-money">taskRefundbudget_sub</i></button>
    </form> --}}
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
<a href="{{ route('project.view', ['project' => $project->hashid]) }}"
    class="btn btn-secondary">กลับ</a>
</x-slot:toolbar>

<h2>{{ $task->task_name }}</h2>
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
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>

                        @foreach ($subtask->contract as $contract)
                        <a href="{{ route('contract.show', ['contract' => $contract->hashid]) }}" class="btn btn-primary text-white badge">
                            สญ.ที่ {{ $contract->contract_number }}
                        </a>

                    @endforeach
                        {{ $subtask->task_name }}



                    </td>
                    <td>

                        <span class="badge {{ $subtask->task_status == 2 ? 'bg-success' : 'bg-warning' }}">
                            {{ $subtask->task_status == 2 ? 'ดำเนินการแล้วเสร็จ' : 'อยู่ในระหว่างดำเนินการ' }}
                        </span>
                        @if(isset($subtask) && $subtask->task_refund_pa_status == 2)
                            <span class="badge bg-success">ดำเนินการแล้วเสร็จคืนเงิน pa</span>
                        @else
                            <span class="badge bg-info">ไม่คืนเงิน pa</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-primary">{{ \Helper::date4(date('Y-m-d H:i:s', $subtask->task_start_date)) }}</span>
                        <span class="badge bg-primary">{{ \Helper::date4(date('Y-m-d H:i:s', $subtask->task_end_date)) }}</span>
                    </td>

                    <td>{{ number_format($subtask->task_budget_it_operating+$subtask->task_budget_it_investment+$subtask->task_budget_gov_utility,2) }}  บาท </td>
                    <td></td>
                    <td>
                        {{ number_format($subtask->task_cost_it_operating+$subtask->task_cost_it_investment+$subtask->task_cost_gov_utility,2) }} บาท
                       {{--  @if ($subtask->contract->count() > 0)
                            @foreach ($subtask->contract as $contract)
                                <button type="button" class="badge btn btn-success text-white"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModal{{ $contract->hashid }}">

                                    @if ($contract->contract_type == 4)
                                        {{ \Helper::contractType($contract->contract_type) }}"_"{{ strtolower($contract->contract_number) }}
                                    @else
                                        สญ.ที่ {{ strtolower($contract->contract_number) }}
                                    @endif
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal{{ $contract->hashid }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">สัญญา {{ $contract->contract_number }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <!-- ... (เนื้อหาในส่วนนี้เหมือนเดิม) ... -->
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif --}}
                    </td>
                    <td>  {{ number_format($subtask->task_pay,2) }} บาท
                    </td>
                    <td>



                        @foreach ($subtask->contract as $contract)
                        <a href="{{ route('contract.show', ['contract' => $contract->hashid]) }}" class="btn btn-success btn-sm"><i class="cil-description"></i></a>
                    @endforeach

                    @if ($subtask->contract->count() < 1)
                        <a href="{{ route('project.task.show', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}" class="btn btn-primary btn-sm"><i class="cil-folder-open"></i></a>
                        @endif

                        <a href="{{ route('project.task.editsub', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}"
                            class="btn btn-warning btn-sm" ><i class="cil-cog"></i></a>
                        <form class="delete-form"
                            action="{{ route('project.task.destroy', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}"
                            method="POST" style="display:inline">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger text-white btn-delete"><i class="cil-trash"></i></button>
                        </form>
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



