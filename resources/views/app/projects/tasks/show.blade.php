<x-app-layout>
    <x-slot:content>
        {{ Breadcrumbs::render('project.task.show', $project,$task) }}
        <x-card title="{{ Helper::projectsType($project->project_type ) }} {{ $project->project_name }} {{ $task->task_name }}">
            <x-slot:toolbar>
                <a href="{{ route('project.task.edit', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
                    class="btn btn-warning text-dark">แก้ไข {{ Helper::projectsType($project->project_type ) }} </a>
                <!--<a href="{{ route('project.task.create', $project->hashid ) }}"
                    class="btn btn-success text-white">เพิ่มงาน</a>
                -->
                    <a href="{{ route('project.task.createsub', ['projectHashid' => $project->hashid, 'taskHashid' => $task->hashid]) }}"
                        class="btn btn-success text-white">เพิ่มรายการที่ใช้จ่าย</a>


                <a href="{{ route('project.index') }}" class="btn btn-secondary">กลับ</a>
            </x-slot:toolbar>
            @if($task['task_parent'] == null)
    <h2>{{ $task->task_name }}</h2>
    <div class="container">
    <div class="row">
    <div class="col-sm">
      <div class="row">
          <div class="col-6">{{ __('ปีงบประมาณ') }}</div>

            {{ $project->project_fiscal_year }}

        </div>


    <div class="row">
    <div class="col-6">{{ __('รายละเอียดงาน/โครงการ') }}</div>
    {{ $task->task_description }}
    </div>

    </div>
    <div class="col-sm">
        <div class="row">
            <div class="col-6">{{ __('งบกลาง ICT') }}</div>
            {{ number_format($task->task_budget_it_operating) }}
            </div>
            <div class="row">
            <div class="col-6">{{ __('งบดำเนินงาน') }}</div>
            {{ number_format($task->task_budget_it_investment) }}
        </div>
        <div class="row">
            <div class="col-6">{{ __('ค่าสาธารณูปโภค') }}</div>
            {{ number_format($task->task_budget_gov_utility) }}
            </div>

    </div>
    </div>
    </div>



    <table class="table">
        <thead>
            <tr>
                <th width="50">No</th>
                <th>Task Name</th>
                <th>m</th>
                <th>Date</th>
                <th width="200"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($project->main_task as $task)
                <tr>
                    <td></td>
                    <td>


                        @if ($task->subtask->count() > 0)
                            <h6>รายการที่ใช้จ่าย</h6>
                            <ul>
                                @foreach ($task->subtask as $subtask)
                                    <li>
                                        {{ $subtask->task_name }}
                                        {{ $subtask->contract_peryear_pa_budget }}
                                        <span
                                            class="badge bg-primary">{{ \Helper::date4(date('Y-m-d H:i:s',$subtask->task_start_date)) }}</span>
                                        <span
                                            class="badge bg-primary">{{ \Helper::date4(date('Y-m-d H:i:s',$subtask->task_end_date)) }}</span>

                                        <a href="{{ route('project.task.show', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}"
                                            class="btn-sm btn btn-primary text-white" target="_blank"><i
                                                class="cil-folder-open "></i></a>
                                        <a href="{{ route('project.task.edit', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}"
                                            class="btn-sm btn btn-warning text-white" target="_blank"> <i
                                                class="cil-cog"></i> </a>
                                        <form
                                            action="{{ route('project.task.destroy', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}"
                                            method="POST" style="display:inline">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn-sm btn btn-danger text-white"><i
                                                    class="cil-trash"></i></button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                    <td>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>








    @endif
    @if ($contract)

            <h6>มีสัญญา</h2>
            <div class="container">
                <div class="row">
                <div class="col-sm">
                  <div class="row">
                      <div class="col-3">{{ __('สถานะสัญญา') }}</div>
                      <div class="col-9">
                          <?php
                          echo isset($contract) && $contract->contract_status == 2
                              ? '<span style="color:red;">ดำเนินการแล้วเสร็จ</span>'
                              : '<span style="color:green;">อยู่ในระหว่างดำเนินการ</span>';
                          ?>
                      </div>
                    </div>
                  <div class="row">
                <div class="col-3">{{ __('เลขที่สัญญา') }}</div>
                <div class="col-9">{{ $contract->contract_number }} </div>
                  </div>
                <div class="row">
                <div class="col-3">{{ __('คู่ค้า') }}</div>
                <div class="col-9">{{ $contract->contract_juristic_id }}</div>
                </div>
                <div class="row">
                <div class="col-3">{{ __('เลขที่สั่งซื้อ') }}</div>
                <div class="col-9">{{ $contract->contract_order_no }}</div>
                </div>
                <div class="row">
                <div class="col-3">{{ __('ประเภท') }}</div>
                <div class="col-9">{{ \Helper::contractType($contract->contract_type) }}</div>
                </div>
                <div class="row">
                <div class="col-3">{{ __('วิธีการได้มา') }}</div>
                <div class="col-9">{{ \Helper::contractAcquisition ($contract->contract_acquisition)  }}</div>
                </div>
                <div class="row">
                <div class="col-3">{{ __('วันที่เริ่มสัญญา') }}</div>
                <div class="col-9">{{   Helper::Date4(date('Y-m-d H:i:s',$contract->contract_start_date)) }}</div>
                </div>

                <div class="row">
                <div class="col-3">{{ __('วันที่สิ้นสุดสัญญา') }}</div>
                <div class="col-9">{{ Helper::Date4(date('Y-m-d H:i:s',$contract->contract_end_date))}}</div>
                </div>
                <div class="row">
                <div class="col-3">{{ __('จำนวนเดือน') }}</div>
                <div class="col-3">{{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse($contract->contract_end_date)) }} เดือน</div>
                <div class="col-3">{{ __('จำนวนวัน') }}</div>
                <div class="col-3">{{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInDays(\Carbon\Carbon::parse($contract->contract_end_date)) }} วัน</div>
                </div>
                <div class="row">
                <div class="col-3">{{ __('ดำเนินการมาแล้ว') }}</div>
                <div class="col-3">{{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse()) }} เดือน</div>
                <div class="col-3">{{ __('ดำเนินการมาแล้ว') }}</div>
                <div class="col-3">{{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInDays(\Carbon\Carbon::parse()) }} วัน</div>
                </div>

                <div class="row">
                <div class="col-3">{{ __('เตือน เหลือเวลา') }}</div>
                <div class="col-9" >

                    {{
                    \Carbon\Carbon::parse($contract->contract_end_date)
                    ->diffInMonths(\Carbon\Carbon::parse($contract->contract_start_date))
                    -  \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse())}}  เดือน;                </div>
                </div>



                </div>
                <div class="col-sm">
                <div class="row">
                <div class="col-6">{{ __('บันทึกข้อความ') }}</div>
                <div class="col-6">{{ $contract->contract_projectplan }}</div>
                </div>
                <div class="row">
                <div class="col-6">{{ __('เลขที่ PR') }}</div>
                <div class="col-6">{{ $contract->contract_pr }}</div>
                </div>
                <div class="row">
                <div class="col-6">{{ __('จำนวนเงิน PR') }}</div>
                <div class="col-6">{{ number_format($contract->contract_pr_budget) }}</div>
                </div>
                <div class="row">
                <div class="col-6">{{ __('เลขที่ PA') }}</div>
                <div class="col-6">{{ $contract->contract_pa }}</div>
                </div>
                <div class="row">
                <div class="col-6">{{ __('จำนวนเงิน PA') }}</div>
                <div class="col-6">{{ number_format($contract->contract_pa_budget) }}</div>
                </div>
                <div class="row">
                <div class="col-6">{{ __('จำนวนคงเหลือหลังเงิน PA') }}</div>
                <div class="col-6">{{ number_format($contract->contract_pr_budget-$contract->contract_pa_budget) }}</div>
                </div>

                <div class="row">
                <div class="col-6">{{ __('จำนวนเงินคงต่อปี PA') }}</div>
                <div class="col-6">{{ number_format($contract->contract_peryear_pa_budget)}}</div>
                </div>

                <!--<div class="row">
                <div class="col-6">{{ __('refund_pa_status') }}</div>
                <div class="col-6">{{($contract->contract_refund_pa_status)}}</div>
                </div>-->
                <div class="row">
                <div class="col-6">{{ __('เจ้าหน้าที่ผู้รับผิดชอบ') }}</div>
                <div class="col-6">{{ $contract->contract_owner }}</div>
                </div>
                </div>
                </div>
                @if($results->count() > 0)

                <table class="table">

                <thead>

                    <tr>








                        <th>Contract taskcon name</th>
                        <th>Contract taskcon pay</th>
                        <!-- Changed from Contract Description to Contract Year -->

                        <!-- Add other columns as needed -->

                    </tr>

                </thead>

                <tbody>

                    @foreach($results as $result)

                        <tr>



                            <td>{{ $result->taskcon_name }}</td>
                            <td>{{ $result->taskcon_pay }}</td>


                            <!-- Changed from contract_description to contract_year -->

                            <!-- Add other data rows as needed -->

                        </tr>

                    @endforeach

                </tbody>

                </table>

            @endif
            @endif
</x-card>
    </x-slot:content>
    <x-slot:css>
    </x-slot:css>



    <x-slot:javascript>
    </x-slot:javascript>
</x-app-layout>
