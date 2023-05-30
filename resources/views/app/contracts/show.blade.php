<x-app-layout>
    <x-slot:content>
        <div class="container-fluid">
           {{--  {{ Breadcrumbs::render('contract.show', $contract) }} --}}
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <x-card title="{{ $contract->contract_name }}">

                            <x-slot:toolbar>
                                <div class="row">
                                    <div class="col-3">{{ __('เตือน เหลือเวลา') }}</div>
                                    <div class="col-9">
                                        <?php
                                        echo isset($duration_p) && $duration_p < 3 ? '<span style="color:red;">' . $duration_p . '</span>' : '<span style="color:rgb(5, 255, 5);">' . $duration_p . '</span>';
                                        ?> เดือน


                                    </div>
                                </div>
                                <a href="{{ route('contract.edit', $contract->hashid) }}" class="btn btn-warning">Edit</a>
                                <a href="{{ route('contract.task.create', $contract->hashid) }}"
                                    class="text-white btn btn-success">เพิ่มค่าใช้จ่าย</a>

                                <a href="{{ route('contract.index') }}" class="btn btn-secondary">Back</a>
                            </x-slot:toolbar>
                            <div class="row  callout callout-primary mb-3">
                                <div class="col-sm-6 col-md-3 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="text-medium-emphasis text-end mb-4">

                                            </div>
                                            <div class="fs-4 fw-semibold">
                                                {{ number_format($contract->contract_pa_budget + $contract->contract_oe_budget ) }}
                                            </div><small
                                                class="text-medium-emphasis text-uppercase fw-semibold">จำนวนเงิน</small>
                                            <div class="progress progress-thin mt-3 mb-0">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                    style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="text-medium-emphasis text-end mb-4">

                                            </div>
                                            <div class="fs-4 fw-semibold"></div><small
                                                class="text-medium-emphasis text-uppercase fw-semibold">ค่าใช้จ่าย</small>
                                            <div class="progress progress-thin mt-3 mb-0">
                                                <div class="progress-bar bg-danger" role="progressbar"
                                                    style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="text-medium-emphasis text-end mb-4">

                                            </div>
                                            <div class="fs-4 fw-semibold"></div><small
                                                class="text-medium-emphasis text-uppercase fw-semibold">คงเหลือ</small>
                                            <div class="progress progress-thin mt-3 mb-0">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>








                            <table class="table callout callout-danger">
                                <thead>
                                    <tr>
                                        <th>สำดับ</th>
                                        <th>project</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contract->taskcont as $task)
                                        <tr>
                                            <td></td>
                                            <td>
                                                {{ $task['task_name'] }}<br>

                                                <span
                                                    class="badge bg-primary">{{ Helper::Date4(date('Y-m-d H:i:s', $task->task_start_date)) }}</span>
                                                <span
                                                    class="badge bg-primary">{{ Helper::Date4(date('Y-m-d H:i:s', $task->task_end_date)) }}</span>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('project.show', ['project' => $task->project_hashid]) }}"
                                                    class="text-white btn btn-success"><i class="cil-folder-open "></i>
                                                    Project</a>
                                                <a href="{{ route('project.task.show', ['project' => $task->project_hashid, 'task' => $task->hashid]) }}"
                                                    class="text-white btn btn-primary"><i class="cil-folder-open "></i>
                                                    Task</a>
                                                {{-- <a href="{{ route('contract.task.edit', ['contract' => $contract->hashid, 'task' => $task->hashid]) }}" class="text-white btn btn-warning"> <i class="cil-cog"></i> </a>
                        <form action="{{ route('contract.task.destroy', ['contract' => $contract->hashid, 'task' => $task->hashid]) }}" method="POST" style="display:inline">
                          @method('DELETE')
                          @csrf
                          <button class="text-white btn btn-danger"><i class="cil-trash"></i></button>
                        </form> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                            <div class="container">
                                <div class="callout callout-info">
                                <div class="row ">
                                    <div class="col-sm">
                                        <div class="row">
                                            <div class="col-3">{{ __('สถานะสัญญา') }}</div>
                                            <div class="col-9">
                                                <?php
                                                echo isset($contract) && $contract->contract_status == 2 ? '<span style="color:red;">ดำเนินการแล้วเสร็จ</span>' : '<span style="color:green;">อยู่ในระหว่างดำเนินการ</span>';
                                                ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">{{ __('เลขที่ สัญญา') }}</div>
                                            <div class="col-9">{{ $contract->contract_number }} </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">{{ __('เลขที่ คู่ค้า') }}</div>
                                            <div class="col-9">{{ $contract->contract_juristic_id }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">{{ __('เลขที่สั่งซื้อ') }}</div>
                                            <div class="col-9">{{ $contract->contract_order_no }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">{{ __('ประเภท') }}</div>
                                            <div class="col-9">{{ \Helper::contractType($contract->contract_type) }}
                                            </div>
                                        </div>
                                        {{-- <div class="row">
                                            <div class="col-3">{{ __('วิธีการได้มา') }}</div>
                                            <div class="col-9">
                                                {{ \Helper::contractAcquisition($contract->contract_acquisition) }}
                                            </div>
                                        </div> --}}
                                        <div class="row">
                                            <div class="col-3">{{ __('วันที่เริ่มสัญญา') }}</div>
                                            <div class="col-9">
                                                {{ Helper::Date4(date('Y-m-d H:i:s', $contract->contract_start_date)) }}
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-3">{{ __('วันที่สิ้นสุดสัญญา') }}</div>
                                            <div class="col-9">
                                                {{ Helper::Date4(date('Y-m-d H:i:s', $contract->contract_end_date)) }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">{{ __('จำนวนเดือน') }}</div>
                                            <div class="col-3">
                                                {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse($contract->contract_end_date)) }}
                                                เดือน</div>
                                            <div class="col-3">{{ __('จำนวนวัน') }}</div>
                                            <div class="col-3">
                                                {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInDays(\Carbon\Carbon::parse($contract->contract_end_date)) }}
                                                วัน</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">{{ __('ดำเนินการมาแล้ว') }}</div>
                                            <div class="col-3">
                                                {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse()) }}
                                                เดือน</div>
                                            <div class="col-3">{{ __('ดำเนินการมาแล้ว') }}</div>
                                            <div class="col-3">
                                                {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInDays(\Carbon\Carbon::parse()) }}
                                                วัน</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-3">{{ __('เตือน เหลือเวลา') }}</div>
                                            <div class="col-9">
                                                <?php
                                                echo isset($duration_p) && $duration_p < 3 ? '<span style="color:red;">' . $duration_p . '</span>' : '<span style="color:rgb(5, 255, 5);">' . $duration_p . '</span>';
                                                ?> เดือน


                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-sm">
                                        <div class="row">
                                            <div class="col-6">{{ __('หมายเหตุ') }}</div>
                                            <div class="col-6">{{ $contract->contract_projectplan }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">{{ __('เลขที่ MM') }}</div>
                                            <div class="col-6">{{ $contract->contract_mm }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">{{ __('จำนวนเงิน MM') }}</div>
                                            <div class="col-6">{{ $contract->contract_mm_bodget }}</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">{{ __('เลขที่ PR') }}</div>
                                            <div class="col-6">{{ $contract->contract_pr }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">{{ __('จำนวนเงิน PR') }}</div>
                                            <div class="col-6">{{ number_format($contract->contract_pr_budget) }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">{{ __('เลขที่ PA') }}</div>
                                            <div class="col-6">{{ $contract->contract_pa }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">{{ __('จำนวนเงิน PA') }}</div>
                                            <div class="col-6">{{ number_format($contract->contract_pa_budget) }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">{{ __('จำนวนคงเหลือหลังเงิน PA') }}</div>
                                            <div class="col-6">
                                                {{ number_format($contract->contract_pr_budget - $contract->contract_pa_budget) }}
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">{{ __('จำนวนเงิน ที่ใช้จ่ายต่อปี') }}</div>
                                            <div class="col-6">
                                                {{ number_format($contract->contract_peryear_pa_budget) }}</div>
                                        </div>


                                    </div>


                                </div>

                                        {{-- <!--<div class="row">
                <div class="col-6">{{ __('refund_pa_status') }}</div>
                <div class="col-6">{{ $contract->contract_refund_pa_status }}</div>
              </div>-->
                                        <div class="row">
                                            <div class="col-6">{{ __('เจ้าหน้าที่ผู้รับผิดชอบ') }}</div>
                                            <div class="col-6">{{ $contract->contract_owner }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">{{ __('สัญญา File') }}</div>
                                    <div class="col-6">
                                        @if ($contract->contract_file)
                                            <a href="{{ url('uploads/contracts/' . $contract->contract_file) }}"
                                                target="_blank">{{ __('Download Contract File') }}</a>
                                        @else
                                            {{ __('No file uploaded') }}
                                        @endif
                                    </div>
                                </div>


                                <!-- Add this for pr_file -->
                                <div class="row">
                                    <div class="col-6">{{ __('PR File') }}</div>
                                    <div class="col-6">
                                        @if ($contract->pr_file)
                                            <a href="{{ url('uploads/contracts/' . $contract->pr_file) }}"
                                                target="_blank">{{ __('Download PR File') }}</a>
                                        @else
                                            {{ __('No file uploaded') }}
                                        @endif
                                    </div>
                                </div>

                                <!-- Add this for pa_file -->
                                <div class="row">
                                    <div class="col-6">{{ __('PA File') }}</div>
                                    <div class="col-6">
                                        @if ($contract->pa_file)
                                            <a href="{{ url('uploads/contracts/' . $contract->pa_file) }}"
                                                target="_blank">{{ __('Download PA File') }}</a>
                                        @else
                                            {{ __('No file uploaded') }}
                                        @endif
                                    </div>
                                </div>

                                <!-- Add this for cn_file -->
                                <div class="row">
                                    <div class="col-6">{{ __('CN File') }}</div>
                                    <div class="col-6">
                                        @if ($contract->cn_file)
                                            <a href="{{ url('uploads/contracts/' . $contract->cn_file) }}"
                                                target="_blank">{{ __('Download CN File') }}</a>
                                        @else
                                            {{ __('No file uploaded') }}
                                        @endif
                                    </div>
                                </div> --}}







                            {{--    <table class="table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Task Name</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($contract->taskcon as $taskcon)
                    <tr>
                      <td></td>
                      <td>
                        {{ $taskcon['taskcon_name'] }}<br>
                        <span class="badge bg-primary">{{ \Helper::date($taskcon->taskcon_start_date) }}</span>
                        <span class="badge bg-primary">{{ \Helper::date($taskcon->taskcon_end_date) }}</span>
                      </td>
                      <td class="text-end">
                        <a href="{{ route('contract.task.show', ['contract' => $contract->hashid, 'taskcon' => $taskcon->hashid]) }}" class="text-white btn btn-primary"><i class="cil-folder-open "></i> ข้อมูล</a>
                        <a href="{{ route('contract.task.edit', ['contract' => $contract->hashid, 'taskcon' => $taskcon->hashid]) }}" class="text-white btn btn-primary"><i class="cil-folder-open "></i> Taske</a>
                        <a href="{{ route('project.show', ['project' => $task->project_hashid]) }}" class="text-white btn btn-success"><i class="cil-folder-open "></i> Project</a>
                        <a href="{{ route('project.task.show', ['project' => $task->project_hashid, 'task' => $task->hashid]) }}" class="text-white btn btn-primary"><i class="cil-folder-open "></i> Task</a>
                         <a href="{{ route('contract.task.edit', ['contract' => $contract->hashid, 'task' => $task->hashid]) }}" class="text-white btn btn-warning"> <i class="cil-cog"></i> </a>
                        <form action="{{ route('contract.task.destroy', ['contract' => $contract->hashid, 'task' => $task->hashid]) }}" method="POST" style="display:inline">
                          @method('DELETE')
                          @csrf
                          <button class="text-white btn btn-danger"><i class="cil-trash"></i></button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>   --}}


            </div>

                            <table class="table callout callout-primary">
                                <thead>
                                    <tr>
                                        {{-- <th width="50">ลำดับ</th> --}}
                                        <th>กิจกรรม</th>
                                        <th>วันที่</th>
                                        <th>การเบิกจ่าย</th>
                                        <th>วันที่ ใช้จ่าย</th>
                                        <th width="200"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contract->main_taskcon as $taskcon)
                                        <tr>
                                            {{-- <td></td> --}}
                                            <td>
                                                {{ $taskcon->taskcon_name }} {!! $taskcon->taskcon_status == 2 ? '<span class="badge bg-info">ดำเนินการแล้วเสร็จ</span>' : '' !!}

                                                @if ($taskcon->subtaskcon->count() > 0)
                                                    <h6>Sub task</h6>
                                                    <ul>
                                                        @foreach ($taskcon->subtaskcon as $subtaskcon)
                                                            <li>
                                                                {{ $subtaskcon->taskcon_name }}
                                                                <a href="{{ route('contract.task.show', ['contract' => $contract->hashid, 'taskcon' => $subtaskcon->hashid]) }}"
                                                                    class="btn-sm btn btn-primary text-white"><i
                                                                        class="cil-folder-open "></i></a>
                                                                <a href="{{ route('contract.task.edit', ['contract' => $contract->hashid, 'taskcon' => $subtaskcon->hashid]) }}"
                                                                    class="btn-sm btn btn-warning text-white">
                                                                    <i class="cil-cog"></i> </a>
                                                                <form
                                                                    action="{{ route('contract.task.destroy', ['contract' => $contract->hashid, 'taskcon' => $subtaskcon->hashid]) }}"
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
                                                <span
                                                    class="badge bg-primary">{{ Helper::date4(date('Y-m-d H:i:s', $taskcon->taskcon_start_date)) }}</span>
                                                -
                                                <span
                                                    class="badge bg-primary">{{ Helper::date4(date('Y-m-d H:i:s', $taskcon->taskcon_end_date)) }}</span>
                                            </td>
                                            <td>
                                                {{ number_format($taskcon->taskcon_pay) }}

                                            </td>
                                            <td>
                                                {{ $taskcon->taskcon_pay_date ? Helper::Date4($taskcon->taskcon_pay_date) : '' }}
                                            </td>


                                            <td class="text-end">

                                                <a href="{{ route('contract.task.show', ['contract' => $contract->hashid, 'taskcon' => $taskcon->hashid]) }}"
                                                    class="btn-sm btn btn-primary text-white"><i
                                                        class="cil-folder-open "></i></a>
                                                <a href="{{ route('contract.task.edit', ['contract' => $contract->hashid, 'taskcon' => $taskcon->hashid]) }}"
                                                    class="btn-sm btn btn-warning text-white"> <i class="cil-cog"></i>
                                                </a>
                                                <form
                                                    action="{{ route('contract.task.destroy', ['contract' => $contract->hashid, 'taskcon' => $taskcon->hashid]) }}"
                                                    method="POST" style="display:inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-danger text-white"><i
                                                            class="cil-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>




                            <div class="mb-3 row">
                                <div class="card">
                                    <div class="card-body">

                                        <div id="gantt_here" style='width:100%; height:60vh;'></div>
                                    </div>
                                </div>
                            </div>


                        </x-card>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:content>

    <x-slot:css>
        <link rel="stylesheet" href="{{ asset('/vendors/dhtmlx/dhtmlxgantt.css') }}" type="text/css">

    </x-slot:css>
    <x-slot:javascript>
        <script src="https://docs.dhtmlx.com/gantt/codebase/dhtmlxgantt.js?v=7.1.13"></script>
        <script>
            gantt.plugins({
                marker: true,
                fullscreen: true,
                critical_path: true,
                // auto_scheduling: true,
                tooltip: true,
                // undo: true
            });

            //Marker
            var date_to_str = gantt.date.date_to_str(gantt.config.task_date);
            var today = new Date();
            gantt.addMarker({
                start_date: today,
                css: "today",
                text: "Today",
                title: "Today: " + date_to_str(today)
            });

            //Template
            var leftGridColumns = {
                columns: [{
                        name: "",
                        width: 60,

                        resize: true,
                        template: function(task) {
                            return "<span class='gantt_grid_wbs'>" + gantt.getWBSCode(task) + "</span>"
                        }
                    },
                    {
                        name: "text",
                        width: 400,
                        label: "โครงการ/งานประจำ",
                        tree: true,

                        template(task) {
                            if (gantt.getState().selected_task == task.id) {
                                return "<b>" + task.text + "</b>";
                            } else {
                                return task.text;
                            };
                        }
                    },
                    //{name:"start_date", label:"Start time", align: "center" },
                    // {name:"owner", width: 200, label:"Owner", template:function(task){
                    //   return task.owner}
                    // }
                ]
            };
            var rightGridColumns = {
                columns: [{
                        name: "budget",
                        width: 100,
                        label: "งบประมาณ/งวด",
                        tree: true,
                        template: function(task) {
                            //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));
                            if (task.contract_pa_budget) {
                                return new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.contract_pa_budget);
                            } else {
                                return '';
                            }
                        }
                    },
                 {
                        name: "-",
                        width: 100,
                        label: "รอการเบิกจ่าย",
                        tree: true,
                        resize: true,

                        template: function(task) {
                            if (task.cost - task.pay > 0) {
                                return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.cost - task.pay) + '</span>';}
                                else {
                                return '-';
                            }



                        }
                    },
                    {
                        name: "pay",
                        width: 50,
                        label: "การเบิกจ่าย",
                        tree: true,
                        resize: true,
                        template: function(task) {
                            //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));

                            if (task.task_total_pay > 0) {
                                return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.task_total_pay) + '</span>';
                            } else if (task.task_type == 1 && task.pay > 0) {
                                return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.pay) + '</span>';
                            } else if (task.task_type == 2 && task.pay > 0) {
                                return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.pay) + '</span>';
                            } else if (task.total_pay > 0) {
                                return '<span style="color:#6010f6;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.total_pay) + '</span>';
                            } else if (task.pay > 0) {
                                return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.pay) + '</span>';
                            } else {
                                return '-';
                            }
                        }
                    },


                    {
                        name: "balance",
                        width: 50,
                        label: "คงเหลือ",
                        template: function(task) {
                            //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));
                            if (task.balance) {
                                var tmp_class = task.balance > 0 ? 'green' : 'red';
                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.balance) + '</span>';
                            } else {
                                return '';
                            }
                        }
                    }
                ]
            };



            gantt.ext.fullscreen.getFullscreenElement = function() {
                return document.querySelector("#gantt_here");
            };
            //Config
            gantt.config.date_format = "%Y-%m-%d";
            gantt.config.drag_links = false;
            gantt.config.drag_move = false;
            gantt.config.drag_progress = false;
            gantt.config.drag_resize = false;
            gantt.config.grid_resize = true;
            gantt.config.layout = {
                css: "gantt_container",
                rows: [{
                        cols: [{
                                view: "grid",
                                width: 600,
                                scrollX: "scrollHor",
                                scrollY: "scrollVer",
                                config: leftGridColumns
                            },
                            {
                                resizer: true,
                                width: 1
                            },
                            {
                                view: "timeline",
                                scrollX: "scrollHor",
                                scrollY: "scrollVer"
                            },
                            {
                                resizer: true,
                                width: 1
                            },
                            {
                                view: "grid",
                                width: 500,
                                bind: "task",
                                scrollY: "scrollVer",
                                config: rightGridColumns
                            },
                            {
                                view: "scrollbar",
                                id: "scrollVer"
                            }
                        ]

                    },
                    {
                        view: "scrollbar",
                        id: "scrollHor",
                        height: 20
                    }
                ]
            };
            gantt.config.readonly = true;
            gantt.config.scales = [{
                    unit: "year",
                    step: 1,
                    format: function(date) {
                        return parseInt(gantt.date.date_to_str("%Y")(date)) + 543;
                    },
                },
                {
                    unit: "month",
                    step: 2,
                    format: function(date) {
                        //const thaiMonthNames = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
                        const thaiMonthNames = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.",
                            "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
                        ];
                        const thaiYearNumber = parseInt(gantt.date.date_to_str("%Y")(date)) + 543;
                        const thaiMonthName = thaiMonthNames[date.getMonth()];
                        return thaiMonthName + " " + thaiYearNumber;
                    }
                },
                // {unit: "day", step: 3, format: "%D %M, %Y"},
            ];
            //ganttModules.zoom.setZoom("months")

            gantt.init("gantt_here");
            gantt.parse({
                data: {!! $gantt !!}
            });
        </script>
    </x-slot:javascript>
</x-app-layout>
