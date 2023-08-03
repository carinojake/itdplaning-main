@if ($task['task_id'] !== null)
<x-slot:toolbar>
    <form class="taskRefund-form" action="{{ route('project.task.taskRefund', ['project' => $project->hashid, 'task' => $task->hashid]) }}" method="POST" style="display:inline">
        @method('POST') {{-- Use POST method to submit the form --}}
        @csrf
        <button class="btn btn-warning text-white btn-delete"><i class="cil-money"></i></button>
    </form>

    <form class="taskRefund-form" action="{{ route('project.task.taskRefundbudget_1', ['project' => $project->hashid, 'task' => $task->hashid]) }}" method="POST" style="display:inline">
        @method('POST') {{-- Use POST method to submit the form --}}
        @csrf
        <button class="btn btn-rad text-white btn-delete"><i class="cil-money"></i></button>
    </form>

</x-slot:toolbar>
@isset($contract)
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
                    <div class="col-3 fw-semibold">{{ __('เลขที่ สัญญา') }}</div>
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

            <table class="table table-bordered table-striped  mt-3">
                <thead>

                    <th>เอกสารแนบ</th>

                    <th>File</th>

                </thead>
                <tbody>
                    @if(count($files_contract) > 0)
                        @foreach($files_contract as $file)
                            <tr>
                                <td>{{ $file->name }}</td>

                                <td><a href="{{ asset('storage/uploads/contracts/' . $file->contract_id . '/'  . $file->name) }}">{{ $file->name }}</a></td>


                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">No Table Data</td>
                        </tr>
                    @endif
                </tbody>
            </table>




        </div>

        @if ($results->count() > 0)
            <table class="table mt-3">

                <thead>
                    <tr>
                        <th>งวด</th>
                        <th>วันที่เบิกจ่าย</th>
                        <th>ใบเลขการเบิกจ่าย</th>
                        <th>ใช้จ่าย</th>
                        <th class="text-end"> คำสั่ง</th>
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
                            <td>{{ $result->taskcon_pp }}</td>
                            <td>{{ number_format($result->taskcon_pay) }}</td>

                               <td class="text-end">

                                <a href="{{ route('contract.task.show',  ['contract' => Hashids::encode($result->contract_id), 'taskcon' => Hashids::encode($result->taskcon_id)])}}"
                                    class="btn-sm btn btn-primary text-white"><i
                                        class="cil-folder-open ">ข้อมูล </i></a>
                                <a href="{{ route('contract.task.edit',  ['contract' => Hashids::encode($result->contract_id), 'taskcon' => Hashids::encode($result->taskcon_id)]) }}"
                                    class="btn-sm btn btn-warning text-white"> <i class="cil-cog"> เบิกจ่าย</i>
                                </a>
                                <form
                                    action="{{ route('contract.task.destroy',  ['contract' => Hashids::encode($result->contract_id), 'taskcon' => Hashids::encode($result->taskcon_id)]) }}"
                                    method="POST" style="display:inline">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-danger text-white"><i
                                            class="cil-trash"></i></button>
                                </form>
                            </td>

                            @foreach ($taskcons as $taskcon)
                            <td class="text-end">
                                <a href="{{ route('contract.task.show', ['contract' => $contract->hashid, 'taskcon' => $taskcon->hashid]) }}"
                                    class="btn-sm btn btn-primary text-white"><i class="cil-folder-open ">ข้อมูล </i></a>

                                <a href="{{ route('contract.task.edit', ['contract' => $contract->hashid, 'taskcon' => $taskcon->hashid]) }}"
                                    class="btn-sm btn btn-warning text-white"> <i class="cil-cog"> เบิกจ่าย</i>
                                </a>

                                <form class="delete-form"  action="{{ route('contract.task.destroy', ['contract' => $contract->hashid, 'taskcon' => $taskcon->hashid]) }}"
                                    method="POST" style="display:inline">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-danger text-white btn-delete"><i class="cil-trash"></i></button>
                                </form>
                            </td>
                        @endforeach

                            <!-- Changed from contract_description to contract_year  -->

                            <!-- Add other data rows as needed -->

                        </tr>
                    @endforeach

                </tbody>
            @endisset
        </table>
    @endif
@endif
