

@if ($task['task_parent'] == null)
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
                        {{ number_format($task->task_budget_it_operating,2) }}
                    @endif
                </div>
                <div class="row">
                    @if ($task->task_budget_it_investment > 0)
                        <div class="col-6 fw-semibold">{{ __('งบดำเนินงาน') }}</div>
                        {{ number_format($task->task_budget_it_investment,2) }}
                    @endif
                </div>
                <div class="row">
                    @if ($task->task_budget_gov_utility > 0)
                        <div class="col-6 fw-semibold">{{ __('ค่าสาธารณูปโภค') }}</div>
                        {{ number_format($task->task_budget_gov_utility,2) }}
                    @endif
                </div>
            </div>
            <div class="col-sm">
                <div class="row">
                    @if ($task->task_budget_it_operating > 0)
                        <div class="col-6 fw-semibold">{{ __('คงเหลือ งบกลาง ICT') }}</div>
                        {{ number_format(floatval($task->task_budget_it_operating - $task_sub_sums['operating']['task_mm_budget'] + $task_sub_refund_pa_budget['operating']['task_refund_pa_budget']), 2) }}
                    @endif
                </div>
                <div class="row">
                    @if ($task->task_budget_it_investment > 0)
                        <div class="col-6 fw-semibold">{{ __('คงเหลือ งบดำเนินงาน') }}</div>
                        {{ number_format(floatval($task->task_budget_it_investment - $task_sub_sums['investment']['task_mm_budget'] + $task_sub_refund_pa_budget['investment']['task_refund_pa_budget']), 2) }}
                    @endif
                </div>
                <div class="row">
                    @if ($task->task_budget_gov_utility > 0)
                        <div class="col-6 fw-semibold">{{ __('คงเหลือ งบสาธารณูปโภค') }}</div>
                        <div class="col-6">
                            {{ number_format(floatval($task->task_budget_gov_utility - $task_sub_sums['utility']['task_mm_budget'] + $task_sub_refund_pa_budget['utility']['task_refund_pa_budget']), 2) }}
                        </div>
                    @endif
                </div>
            </div>


                <div class="row mt-3">
                    <div class="col-12">
                        <h5>{{ __('รายละเอียดงาน/โครงการ') }}</h5>
                    </div>
                    {{ $task->task_description }}
                </div>
        </div>

  @if ($task->subtask->count() > 0)
        <table class="table mt-3">
            <tbody>
                <tr>
                    <th width="50">ลำดับ</th>
                    <th>กิจกรรม</th>
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
                    $relatedData = collect($cteQuery->get())->firstWhere('root', $subtask->task_id);
                @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $subtask->task_name }}{!! $task->task_status == 2 ? '<span class="badge bg-info">ดำเนินการแล้วเสร็จ</span>' : '' !!}</td>
                            <td>
                                <span class="badge bg-primary">{{ \Helper::date4(date('Y-m-d H:i:s', $subtask->task_start_date)) }}</span>
                                <span class="badge bg-primary">{{ \Helper::date4(date('Y-m-d H:i:s', $subtask->task_end_date)) }}</span>
                            </td>

                            <td>{{ number_format($subtask->task_budget_it_operating+$subtask->task_budget_it_investment+$subtask->task_budget_gov_utility,2) }}   </td>
                            <td></td>
                            <td>
                                @if($relatedData->totalLeastCost > 1)
                                {{ number_format($relatedData->totalLeastCost, 2) }}
                            @else
                                {{ number_format($subtask->task_cost_it_operating + $subtask->task_cost_it_investment + $subtask->task_cost_gov_utility, 2) }}
                            @endif
                            </td>
                            <td>
                                @if($relatedData->totalLeastconPay >1)

                                {{ number_format($relatedData->totalLeastconPay, 2) }}
                                @elseif($subtask->task_parent_sub_cost > 1)
                                    {{ number_format($subtask->task_parent_sub_pay, 2) }}

                                @elseif($subtask->task_pay > 1)
                                    {{ number_format($subtask->task_pay, 2) }}

                                @endif
                            </td>

                            <td>
                                <a href="{{ route('project.task.show', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}"
                                    class="btn btn-primary btn-sm" ><i class="cil-folder-open"></i></a>
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
                            <td colspan="5">
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
@endif




@if ($task['task_parent'] == 9999 )
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
                            <form class="delete-form"  action="{{ route('contract.task.destroy', ['contract' => $contract->hashid, 'taskcon' => $result->hashid]) }}" method="POST" style="display:inline">
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




