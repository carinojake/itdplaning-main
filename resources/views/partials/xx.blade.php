@if ($task->subtask->count() > 0)
@if ($task['task_parent'] == null)
<h2>{{ $task->task_name }}</h2>
<div class="container">
    <div class="row mt-5">
        <div class="col-sm">
            <div class="row">
                <div class="col-6">{{ __('ปีงบประมาณ') }}</div>
                {{ $project->project_fiscal_year }}
            </div>
        </div>
        <div class="col-sm">
            <div class="row">
                @if($task->task_budget_it_operating > 0)
                <div class="col-6">{{ __('งบกลาง ICT') }}</div>
                {{ number_format($task->task_budget_it_operating) }}
                @endif
            </div>
            <div class="row">
                @if($task->task_budget_it_investment  > 0)
                <div class="col-6">{{ __('งบดำเนินงาน') }}</div>
                {{ number_format($task->task_budget_it_investment) }}
                @endif
            </div>
            <div class="row">
                @if($task->task_budget_gov_utility  > 0)
                <div class="col-6">{{ __('ค่าสาธารณูปโภค') }}</div>
                {{ number_format($task->task_budget_gov_utility) }}
                @endif
            </div>
        </div>
             <div class="col-sm">
            <div class="row">
                @if($task->task_budget_it_operating  > 0)
                <div class="col-6">{{ __('คงเหลือ งบกลาง ICT') }}</div>
        {{ number_format(floatval($task->task_budget_it_operating-$task_sub_sums['operating']['task_budget']+$task_sub_sums['operating']['task_refund_pa_budget']), 2) }}
                @endif
            </div>
            <div class="row">
                @if($task->task_budget_it_investment > 0)
                <div class="col-6">{{ __('คงเหลือ งบดำเนินงาน') }}</div>
            {{--     {{ number_format(floatval($is_refund_mm_pr), 2) }} --}}
                @endif
            </div>
            <div class="row">
                @if($task->task_budget_gov_utility > 0)
                <div class="col-6">{{ __('คงเหลือ งบสาธารณูปโภค') }}</div>
             {{--    {{ number_format(floatval($ut_refund_mm_pr), 2) }} --}}
            </div>
            @endif
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12" ><h5>{{ __('รายละเอียดงาน/โครงการ') }}</h5></div>
        {{ $task->task_description }}
    </div>
</div>
<table class="table mt-3">
    <table class="table mt-3">
        <tbody>
            <tr>
                <th width="50">ลำดับ</th>
                <th>กิจกรรม</th>
                <th>วันที่</th>
                <th>ที่สัญญา</th>
                <th width="200"> ดูสัญญา</th>
            </tr>
            @if ($task->subtask->count() > 0)
                @foreach ($task->subtask as $index => $subtask)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $subtask->task_name }}</td>
                        <td>
                            <span class="badge bg-primary">{{ \Helper::date4(date('Y-m-d H:i:s', $subtask->task_start_date)) }}</span>
                            <span class="badge bg-primary">{{ \Helper::date4(date('Y-m-d H:i:s', $subtask->task_end_date)) }}</span>
                        </td>
                        <td>
                            @if ($subtask->contract->count() > 0)
                                @foreach ($subtask->contract as $contract)
                                    <button type="button" class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $contract->hashid }}">

                                        @if (($contract->contract_type == 4))
                                        {{ \Helper::contractType($contract->contract_type) }}"_"{{  strtolower($contract->contract_number)  }}
                                        @else
                                           สญ.ที่ {{  strtolower($contract->contract_number)  }}
                                        @endif
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal{{ $contract->hashid }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">สัญญา {{ $contract->contract_number }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('project.task.show', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}" class="btn btn-primary btn-sm" target="_blank"><i class="cil-folder-open">ข้อมูล</i></a>
                            <a href="{{ route('project.task.editsub', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}" class="btn btn-warning btn-sm" target="_blank"><i class="cil-cog"></i></a>
                            <form action="{{ route('project.task.destroy', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}" method="POST" style="display:inline">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger btn-sm"><i class="cil-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endif
@if ($task['task_parent'] )
<h5>มีสัญญา</h5>
<div class="container">
    <div class="row">
        <div class="col-sm">
            <div class="row">
                <div class="col-3 fw-semibold">{{ __('สถานะสัญญา') }}</div>
                <div class="col-9">
                    <?php
                    echo isset($contract) && $contract->contract_status == 2 ? '<span style="color:red;">ดำเนินการแล้วเสร็จ</span>' : '<span style="color:green;">อยู่ในระหว่างดำเนินการ</span>';
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-3 fw-semibold">{{ __('เลขที่สัญญา') }}</div>
                <div class="col-9">{{ $contract->contract_number }} </div>
            </div>
            <div class="row">
                <div class="col-3 fw-semibold">{{ __('คู่ค้า') }}</div>
                <div class="col-9">{{ $contract->contract_juristic_id }}</div>
            </div>
            <div class="row">
                <div class="col-3 fw-semibold">{{ __('เลขที่สั่งซื้อ') }}</div>
                <div class="col-9">{{ $contract->contract_order_no }}</div>
            </div>

           {{--  <div class="row">
                <div class="col-3">{{ __('วิธีการได้มา') }}</div>
                <div class="col-9">
                    {{ \Helper::contractAcquisition($contract->contract_acquisition) }}</div>
            </div> --}}
            <div class="row">
                <div class="col-3 fw-semibold">{{ __('วันที่เริ่มสัญญา') }}</div>
                <div class="col-9">
                    {{ Helper::Date4(date('Y-m-d H:i:s', $contract->contract_start_date)) }}</div>
            </div>

            <div class="row">
                <div class="col-3 fw-semibold">{{ __('วันที่สิ้นสุดสัญญา') }}</div>
                <div class="col-9">
                    {{ Helper::Date4(date('Y-m-d H:i:s', $contract->contract_end_date)) }}</div>
            </div>
            <div class="row">
                <div class="col-3 fw-semibold">{{ __('จำนวนเดือน') }}</div>
                <div class="col-3">
                    {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse($contract->contract_end_date)) }}
                    เดือน</div>
                <div class="col-3 fw-semibold">{{ __('จำนวนวัน') }}</div>
                <div class="col-3">
                    {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInDays(\Carbon\Carbon::parse($contract->contract_end_date)) }}
                    วัน</div>
            </div>
            <div class="row">
                <div class="col-3 fw-semibold">{{ __('ดำเนินการมาแล้ว') }}</div>
                <div class="col-3">
                    {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse()) }}
                    เดือน</div>
                <div class="col-3 fw-semibold">{{ __('ดำเนินการมาแล้ว') }}</div>
                <div class="col-3">
                    {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInDays(\Carbon\Carbon::parse()) }}
                    วัน</div>
            </div>

            <div class="row">
                <div class="col-3 fw-semibold">{{ __('เตือน เหลือเวลา') }}</div>
                <div class="col-9">

                    {{ \Carbon\Carbon::parse($contract->contract_end_date)->diffInMonths(
                        \Carbon\Carbon::parse($contract->contract_start_date),
                    ) - \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse()) }}
                    เดือน; </div>
            </div>



        </div>
        <div class="col-sm">
            <div class="row">
                <div class="col-6 fw-semibold">{{ __('บันทึกข้อความ') }}</div>
                <div class="col-6">{{ $contract->contract_projectplan }}</div>
            </div>
            <div class="row">
                <div class="col-6 fw-semibold">{{ __('เลขที่ PR') }}</div>
                <div class="col-6">{{ $contract->contract_pr }}</div>
            </div>
            <div class="row">
                <div class="col-6 fw-semibold">{{ __('จำนวนเงิน PR') }}</div>
                <div class="col-6">{{ number_format($contract->contract_pr_budget) }}</div>
            </div>
            <div class="row">
                <div class="col-6 fw-semibold">{{ __('เลขที่ PA') }}</div>
                <div class="col-6">{{ $contract->contract_pa }}</div>
            </div>
            <div class="row">
                <div class="col-6 fw-semibold">{{ __('จำนวนเงิน PA') }}</div>
                <div class="col-6">{{ number_format($contract->contract_pa_budget) }}</div>
            </div>
            <div class="row">
                <div class="col-6 fw-semibold">{{ __('จำนวนคงเหลือหลังเงิน PA') }}</div>
                <div class="col-6">
                    {{ number_format($contract->contract_pr_budget - $contract->contract_pa_budget) }}
                </div>
            </div>

            <div class="row">
                <div class="col-6 fw-semibold">{{ __('จำนวนเงินคงต่อปี PA') }}</div>
                <div class="col-6">{{ number_format($contract->contract_peryear_pa_budget) }}</div>
            </div>

            <!--<div class="row">
<div class="col-6">{{ __('refund_pa_status') }}</div>
<div class="col-6">{{ $contract->contract_refund_pa_status }}</div>
</div>-->
            <div class="row">
                <div class="col-6 fw-semibold">{{ __('เจ้าหน้าที่ผู้รับผิดชอบ') }}</div>
                <div class="col-6">{{ $contract->contract_owner }}</div>
            </div>
        </div>
    </div>

    @if ($results->count() > 0)

        <table class="table">

            <thead>
                <tr>
                    <th>งวด</th>
                    <th>วันที่เบิกจ่าย</th>
                    <th>สถานะการเบิกจ่าย</th>
                    <th>ใช้จ่าย</th>
                    <th class="text-end" > คำสั่ง</th>
                    <!-- Changed from Contract Description to Contract Year -->
                    <!-- Add other columns as needed -->
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $result)
                    <tr>

                        <td>{{ $result->taskcon_name }}</td>
                        <td>{{ Helper::Date4(date('Y-m-d H:i:s', strtotime($result->taskcon_pay_date))) }}
                        </td>
                        <td>{{ $result->disbursement_taskcons_status }}</td>
                        <td>{{ number_format($result->taskcon_pay) }}</td>
                        <td class="text-end">
                            <a href="{{ route('contract.task.show', ['contract' => $contract->hashid, 'taskcon' => $result->hashid]) }}" class="btn-sm btn btn-primary text-white"><i class="cil-folder-open"> ข้อมูล</i></a>


                            <a href="{{ route('contract.task.edit', ['contract' => $contract->hashid, 'taskcon' => $result->hashid]) }}" class="btn-sm btn btn-warning text-white"><i class="cil-cog">เพิ่มค่าใช้จ่าย</i></a>
                            <form action="{{ route('contract.task.destroy', ['contract' => $contract->hashid, 'taskcon' => $result->hashid]) }}" method="POST" style="display:inline">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger text-white"><i class="cil-trash"></i></button>
                            </form>

                        </td>
                        <!-- Changed from contract_description to contract_year  -->

                        <!-- Add other data rows as needed -->

                    </tr>
                @endforeach

            </tbody>

        </table>
    @endif
@endif
@endif
