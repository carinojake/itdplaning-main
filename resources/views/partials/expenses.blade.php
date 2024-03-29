<ul>

    <table class="table">
        <thead>
            <tr>

                 <th width="50">ลำดับ</th>
                {{--  <th>ประเภท</th> --}}
                <th >รายการ</th>
                <th>วันที่</th>
                <th>ประเภทงบ-วงเงิน</th>
                <th width="200"> คำสั่ง</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($project->main_task_sub as $index => $task)
        {{--     {{ var_dump($task->hashid) }} --}}
                <tr>
                    <td>{{ $index + 1 }}</td>

                    <td>
                        <div>
                            <span style="color: green;">{{ isset($task->taskcon_mm) ? $task->taskcon_mm . ' - ' : '' }}</span> {{ $task->task_name }} {!! $task->task_status == 2 ? '<span class="badge bg-info">ดำเนินการแล้วเสร็จ</span>' : '' !!}
                        </div>
                        @if ($task->contract->count() > 0)
                            <div class="mt-2">
                                <h6>สัญญา</h6>
                                @foreach ($task->contract as $contract)
                                    <a href="{{ route('contract.show', ['contract' => $contract->hashid]) }}"><span class="badge bg-warning">{{ $contract->contract_number }}</span></a>
                                @endforeach
                            </div>
                        @endif
                        @if ($task->subtask->count() > 0)
                            <div class="mt-2">
                                <h6>กิจกรรมย่อย</h6>
                                <ul>
                                    @foreach ($task->subtask as $subtask)
                                        <li>
                                            {{ $subtask->task_name }}

                                            @if ($subtask->contract->count() > 0)



                                                @foreach ($subtask->contract as $contract)




                                                       <!-- Button trigger modal -->
                                                       @if (($contract->task_type == 2))
                                                       <button


                                                       type="button"
                                                       class="badge btn btn-primary text-white "
                                                data-coreui-toggle="modal"
                                                data-coreui-target="#exampleModal{{ $contract->hashid }}">



                                                 {{ \Helper::contractType($contract->contract_type) }}"_"{{  strtolower($contract->contract_number)  }}



                                                 @else

                                                    สญ.ที่ {{  strtolower($contract->contract_number)  }}
                                                 @endif
                                            </button>

                                            @if (($contract->task_type == 1 ))
                                            <button
                                                       type="button"
                                                       class="badge btn btn-success text-white "
                                                data-coreui-toggle="modal"
                                                data-coreui-target="#exampleModal{{ $contract->hashid }}">
                                                    สญ.ที่ {{  strtolower($contract->contract_number)  }}
                                                    @endif
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade"
                                                id="exampleModal{{ $contract->hashid }}"
                                                tabindex="-1"
                                                aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="exampleModalLabel">
                                                                สัญญา
                                                                {{ $contract->contract_number }}
                                                            </h5>
                                                            <button type="button"
                                                                class="btn-close"
                                                                data-coreui-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                            <div class="modal-body">


                                                            {{--  --}}
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-sm">
                                                                        <div
                                                                            class="row">
                                                                            <div
                                                                                class="col-3">
                                                                                {{ __('สถานะสัญญา') }}
                                                                            </div>
                                                                            <div
                                                                                class="col-9">
                                                                                <?php
                                                                                echo isset($contract) && $contract->contract_status == 2 ? '<span style="color:red;">ดำเนินการแล้วเสร็จ</span>' : '<span style="color:green;">อยู่ในระหว่างดำเนินการ</span>';
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="row">
                                                                            <div
                                                                                class="col-3">
                                                                                {{ __('เลขที่ สัญญา') }}
                                                                            </div>
                                                                            <div
                                                                                class="col-9">
                                                                                {{ $contract->contract_number }}
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="row">
                                                                            <div
                                                                                class="col-3">
                                                                                {{ __('เลขที่ คู่ค้า') }}
                                                                            </div>
                                                                            <div
                                                                                class="col-9">
                                                                                {{ $contract->contract_juristic_id }}
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="row">
                                                                            <div
                                                                                class="col-3">
                                                                                {{ __('เลขที่สั่งซื้อ') }}
                                                                            </div>
                                                                            <div
                                                                                class="col-9">
                                                                                {{ $contract->contract_order_no }}
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="row">
                                                                            <div
                                                                                class="col-3">
                                                                                {{ __('ประเภท') }}
                                                                            </div>
                                                                            <div
                                                                                class="col-9">
                                                                                {{ \Helper::contractType($contract->contract_type) }}
                                                                            </div>
                                                                        </div>
                                                                        {{-- <div class="row">
<div class="col-3">{{ __('วิธีการได้มา') }}</div>
<div class="col-9">
{{ \Helper::contractAcquisition($contract->contract_acquisition) }}
</div>
</div> --}}
                                                                        <div
                                                                            class="row">
                                                                            <div
                                                                                class="col-3">
                                                                                {{ __('วันที่เริ่มสัญญา') }}
                                                                            </div>
                                                                            <div
                                                                                class="col-9">
                                                                                {{ Helper::Date4(date('Y-m-d H:i:s', $contract->contract_start_date)) }}
                                                                            </div>
                                                                        </div>

                                                                        <div
                                                                            class="row">
                                                                            <div
                                                                                class="col-3">
                                                                                {{ __('วันที่สิ้นสุดสัญญา') }}
                                                                            </div>
                                                                            <div
                                                                                class="col-9">
                                                                                {{ Helper::Date4(date('Y-m-d H:i:s', $contract->contract_end_date)) }}
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="row">
                                                                            <div
                                                                                class="col-3">
                                                                                {{ __('จำนวนเดือน') }}
                                                                            </div>
                                                                            <div
                                                                                class="col-3">
                                                                                {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse($contract->contract_end_date)) }}
                                                                                เดือน</div>
                                                                            <div
                                                                                class="col-3">
                                                                                {{ __('จำนวนวัน') }}
                                                                            </div>
                                                                            <div
                                                                                class="col-3">
                                                                                {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInDays(\Carbon\Carbon::parse($contract->contract_end_date)) }}
                                                                                วัน</div>
                                                                        </div>
                                                                        <div
                                                                            class="row">
                                                                            <div
                                                                                class="col-3">
                                                                                {{ __('ดำเนินการมาแล้ว') }}
                                                                            </div>
                                                                            <div
                                                                                class="col-3">
                                                                                {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse()) }}
                                                                                เดือน</div>
                                                                            <div
                                                                                class="col-3">
                                                                                {{ __('ดำเนินการมาแล้ว') }}
                                                                            </div>
                                                                            <div
                                                                                class="col-3">
                                                                                {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInDays(\Carbon\Carbon::parse()) }}
                                                                                วัน</div>
                                                                        </div>

                                                                        {{--   <div class="row">
<div class="col-3">{{ __('เตือน เหลือเวลา') }}</div>
<div class="col-9">
<?php
echo isset($duration_p) && $duration_p < 3 ? '<span style="color:red;">' . $duration_p . '</span>' : '<span style="color:rgb(5, 255, 5);">' . $duration_p . '</span>';
?> เดือน


</div>
</div> --}}


                                                                    </div>
                                                                    <div class="col-sm">
                                                                        <div
                                                                            class="row">
                                                                            <div
                                                                                class="col-6">
                                                                                {{ __('หมายเหตุ') }}
                                                                            </div>
                                                                            <div
                                                                                class="col-6">
                                                                                {{ $contract->contract_projectplan }}
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="row">
                                                                            <div
                                                                                class="col-6">
                                                                                {{ __('เลขที่ MM') }}
                                                                            </div>
                                                                            <div
                                                                                class="col-6">
                                                                                {{ $contract->contract_mm }}
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="row">
                                                                            <div
                                                                                class="col-6">
                                                                                {{ __('จำนวนเงิน MM') }}
                                                                            </div>
                                                                            <div
                                                                                class="col-6">
                                                                                {{ $contract->contract_mm_bodget }}
                                                                            </div>
                                                                        </div>

                                                                        <div
                                                                            class="row">
                                                                            <div
                                                                                class="col-6">
                                                                                {{ __('เลขที่ PR') }}
                                                                            </div>
                                                                            <div
                                                                                class="col-6">
                                                                                {{ $contract->contract_pr }}
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="row">
                                                                            <div
                                                                                class="col-6">
                                                                                {{ __('จำนวนเงิน PR') }}
                                                                            </div>
                                                                            <div
                                                                                class="col-6">
                                                                                {{ number_format($contract->contract_pr_budget) }}
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="row">
                                                                            <div
                                                                                class="col-6">
                                                                                {{ __('เลขที่ PA') }}
                                                                            </div>
                                                                            <div
                                                                                class="col-6">
                                                                                {{ $contract->contract_pa }}
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="row">
                                                                            <div
                                                                                class="col-6">
                                                                                {{ __('จำนวนเงิน PA') }}
                                                                            </div>
                                                                            <div
                                                                                class="col-6">
                                                                                {{ number_format($contract->contract_pa_budget) }}
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="row">
                                                                            <div
                                                                                class="col-6">
                                                                                {{ __('จำนวนคงเหลือหลังเงิน PA') }}
                                                                            </div>
                                                                            <div
                                                                                class="col-6">
                                                                                {{ number_format($contract->contract_pr_budget - $contract->contract_pa_budget) }}
                                                                            </div>
                                                                        </div>

                                                                        <div
                                                                            class="row">
                                                                            <div
                                                                                class="col-6">
                                                                                {{ __('จำนวนเงิน ที่ใช้จ่ายต่อปี') }}
                                                                            </div>
                                                                            <div
                                                                                class="col-6">
                                                                                {{ number_format($contract->contract_peryear_pa_budget) }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{--  --}}
                                                        </div>
                                                        <div class="modal-footer">

                                                            <div>
                                                                <a href="{{ route('project.task.show', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}" class="btn btn-primary btn-sm"><i class="cil-folder-open"></i></a>
                                                                <a href="{{ route('project.task.editsub', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}" class="btn btn-warning btn-sm"><i class="cil-cog"></i></a>
                                                                <form action="{{ route('project.task.destroy', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}" method="POST" style="display:inline">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button class="btn btn-danger btn-sm"><i class="cil-trash"></i></button>
                                                                </form>
                                                            </div>



                                                            <button type="button"
                                                                class="btn btn-secondary"
                                                                data-coreui-dismiss="modal">Close</button>







                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif





                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </td>


                    <td>
                        <span class="badge bg-primary">{{ \Helper::date4(date('Y-m-d H:i:s', $task->task_start_date)) }}</span>
                        <span class="badge bg-primary">{{ \Helper::date4(date('Y-m-d H:i:s', $task->task_end_date)) }}</span>
                    </td>
                    <td>
                        <div class="row">
                            @if ($task->task_budget_it_operating > 0)
                                <div class="col-6 ">{{ __('งบกลาง ICT') }}</div>
                               {{--  {{ number_format($task->task_budget_it_operating) }} บาท --}}
                            @endif
                        </div>
                        <div class="row">
                            @if ($task->task_budget_it_investment > 0)
                                <div class="col-6">{{ __('งบดำเนินงาน') }}</div>
                               {{--  {{ number_format($task->task_budget_it_investment) }} บาท --}}
                            @endif
                        </div>
                        <div class="row">
                            @if ($task->task_budget_gov_utility > 0)
                                <div class="col-6">{{ __('ค่าสาธารณูปโภค') }}</div>
                            {{--     {{ number_format($task->task_budget_gov_utility) }} บาท --}}
                            @endif
                        </div>
                    </td>

                       <td class="text-end">
                         <a href="{{ route('project.task.show', ['project' => $project->hashid, 'task' => $task->hashid]) }}" class="btn btn-primary text-white"><i class="cil-folder-open"></i></a>
                       <a href="{{ route('project.task.editsubno', ['project' => $project->hashid, 'task' => $task->hashid]) }}" class="btn btn-warning text-white"><i class="cil-cog"></i></a>

                        @if ($task->task_parent == 0)

                        <form class="delete-form" action="{{ route('project.task.destroy', ['project' => $project->hashid, 'task' => $task->hashid]) }}" method="POST" style="display:inline">
                            @method('DELETE')
                            @csrf

                            <button class="btn btn-danger text-white btn-delete" data-rowid="{{ $task->hashid }}"><i class="cil-trash"></i></button>
                        </form>

                    @endif

                        </form>
                    </td>

                </tr>


            @endforeach
        </tbody>
        </table>
    </ul>





