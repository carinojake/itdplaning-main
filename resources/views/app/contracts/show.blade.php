<x-app-layout>
    <x-slot:content>
        <div class="container-fluid">
           {{--  {{ Breadcrumbs::render('contract.show', $contract) }} --}}
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <x-card title="เลขที่ สัญญา {{ $contract->contract_number }} {{ $contract->contract_name }}">

                            <x-slot:toolbar>

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
                                                {{ __('สถานะสัญญา') }}  {!! isset($contract) && $contract->contract_status == 2 ? '<span class="text-success">ดำเนินการแล้วเสร็จ</span>' : '<span class="text-danger">อยู่ในระหว่างดำเนินการ</span>' !!}
                                            </div><small
                                                class="text-medium-emphasis text-uppercase fw-semibold"></small>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="text-medium-emphasis text-end mb-4">

                                            </div>
                                            <div class="fs-4 fw-semibold">

                                                เตือน เหลือเวลา
                                                {!! isset($contract) && $contract->contract_status == 2 ?
                                                    '-'
                                                    :  (isset($duration_p) && $duration_p < 3 ? '<span style="color:red;">' . $duration_p . '</span>' : '<span style="color:rgb(5, 255, 5);">' . $duration_p . '</span>')
                                                !!} เดือน
                                           </div><small
                                                class="text-medium-emphasis text-uppercase fw-semibold"></small>

                                        </div>
                                    </div>
                                </div>
                                <div class = "row">
                                <div class=" col-sm-6 col-md-3 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="text-medium-emphasis text-end mb-4">

                                            </div>
                                            <div class="fs-4 fw-semibold">
                                                {{ number_format($contractgannt['contract_pa_budget'],2 ) }}
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
                                            <div class="fs-4 fw-semibold">

                                                {{ number_format($contractgannt['contract_pa_budget']-$contractgannt['total_pay'],2) }}

                                            </div><small
                                                class="text-medium-emphasis text-uppercase fw-semibold">รอการเบิกจ่าย</small>
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
                                            <div class="fs-4 fw-semibold">
                                                {{ number_format($contractgannt['total_pay'],2) }}


                                            </div><small
                                                class="text-medium-emphasis text-uppercase fw-semibold">การเบิกจ่าย</small>
                                            <div class="progress progress-thin mt-3 mb-0">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
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
                                    @foreach ($contract->taskcont as $index => $task)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            {{ $task['task_name'] }}<br>
                                            <span class="badge bg-primary">{{ Helper::Date4(date('Y-m-d H:i:s', $task->task_start_date)) }}</span>
                                            <span class="badge bg-primary">{{ Helper::Date4(date('Y-m-d H:i:s', $task->task_end_date)) }}</span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('project.view', ['project' => $task->project_hashid]) }}"
                                                class="text-white btn btn-success"><i class="cil-folder-open "></i> Project</a>
                                            <a href="{{ route('project.task.show', ['project' => $task->project_hashid, 'task' => $task->hashid]) }}"
                                                class="text-white btn btn-primary"><i class="cil-folder-open "></i> Task</a>
                                            {{-- <a href="{{ route('contract.task.edit', ['contract' => $contract->hashid, 'task' => $task->hashid]) }}"
                                                class="text-white btn btn-warning"><i class="cil-cog"></i></a>
                                            <form action="{{ route('contract.task.destroy', ['contract' => $contract->hashid, 'task' => $task->hashid]) }}"
                                                method="POST" style="display:inline">
                                                @method('DELETE')
                                                @csrf
                                                <button class="text-white btn btn-danger"><i class="cil-trash"></i></button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>


                        {{-- <div class="callout callout-info">
                                <div class="row  ">
                                    <div class="col-sm ">
                                        <div class="row">
                                            <div class="col-3 fw-semibold"><h5>{{ __('1.สถานะสัญญา') }}</h5></div>
                                            <div class="col-9">

                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-3 fw-semibold"><h5>{{ __('1.งบ') }}</h5></div>
                                            <div class="col-9">
                                                @if($contract->contract_budget_type != null)
                                                <h5>{{ \Helper::project_select($contract->contract_budget_type) }}</h5>
                                            @else
                                                <h5>-</h5>
                                            @endif

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div  class="col-3 fw-semibold"> <h5>{{ __('1.เลขที่ สัญญา') }}</h5></div>
                                            <div class="col-9"><h5>{{ $contract->contract_number }} </h5></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 fw-semibold"><h5>{{ __('1.เลขที่ คู่ค้า') }}</h5></div>
                                            <div class="col-9"><h5>{{ $contract->contract_juristic_id }}</h5></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 fw-semibold"><h5>{{ __('1.เลขที่สั่งซื้อ') }}</h5></div>
                                            <div class="col-9"><h5>{{ $contract->contract_order_no }}</h5></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 fw-semibold"><h5>{{ __('1.ประเภท') }}</h5></div>
                                          {{--   <div class="col-9">{{ \Helper::contractType($contract->contract_type) }}
                                            </div>
                                        </div>
                                    <div class="row">
                                            <div class="col-3">{{ __('วิธีการได้มา') }}</div>
                                            <div class="col-9">
                                                {{ \Helper::contractAcquisition($contract->contract_acquisition) }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 fw-semibold"><h5>{{ __('1.วันที่เริ่มสัญญา') }}</h5></div>
                                            <div class="col-9">
                                                <h5>     {{ Helper::Date4(date('Y-m-d H:i:s', $contract->contract_start_date)) }}</h5>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-3 fw-semibold"><h5>{{ __('1.วันที่สิ้นสุดสัญญา') }}</h5></div>
                                            <div class="col-9">
                                                <h5>   {{ Helper::Date4(date('Y-m-d H:i:s', $contract->contract_end_date)) }}</h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 fw-semibold"><h5>{{ __('1.จำนวนเดือน') }}</h5></div>
                                            <div class="col-3">
                                                <h5> {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse($contract->contract_end_date)) }}
                                                เดือน</h5></div>
                                            <div class="col-3 fw-semibold"><h5>{{ __('1.จำนวนวัน') }}</div>
                                            <div class="col-3">
                                                <h5>    {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInDays(\Carbon\Carbon::parse($contract->contract_end_date)) }}
                                                วัน</h5></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 fw-semibold"><h5>{{ __('1.ดำเนินการมาแล้ว') }}</h5></div>
                                            <div class="col-3">
                                                <h5> {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse()) }}
                                                เดือน</h5></div>
                                            <div class="col-3 fw-semibold"><h5>{{ __('1.ดำเนินการมาแล้ว') }}</h5></div>
                                            <div class="col-3">
                                                <h5>   {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInDays(\Carbon\Carbon::parse()) }}
                                                วัน</h5></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-3 fw-semibold"><h5>{{ __('1.เตือน เหลือเวลา') }}</h5></div>
                                            <div class="col-9">
                                                <h5> เดือน</h5>


                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-sm">
                                        <div class="row">
                                            <div class="col-6 fw-semibold"><h5>{{ __('1.หมายเหตุ') }}</h5></div>
                                            <div class="col-6"><h5>{{ $contract->contract_projectplan }}</h5></div>
                                        </div>


                                        <div class="row">
                                            <div class="col-6 fw-semibold"><h5>{{ __('2.งบประมาณ') }}</h5></div>
                                            <div class="col-6">{{ \Helper::project_select($contract->contract_budget_type) }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 fw-semibold"><h5>{{ __('2.1เลขที่ MM') }}</h5></div>
                                            <div class="col-6"><h5>{{ $contract->contract_mm }}</h5></div>

                                        </div>
                                        <div class="row">
                                            <div class="col-6 fw-semibold"><h5>{{ __('2.1จำนวนเงิน MM') }}</h5></div>
                                            <div class="col-6"><h5>{{ $contract->contract_mm_bodget }}</h5></div>


                                        </div>

                                        <div class="row">
                                            <div class="col-6 fw-semibold"><h5>{{ __('2.2เลขที่ PR') }}</h5></div>
                                            <div class="col-6"><h5>{{ $contract->contract_pr }}</h5></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 fw-semibold"><h5>{{ __('2.2จำนวนเงิน PR') }}</h5></div>
                                            <div class="col-6"><h5>{{ number_format($contract->contract_pr_budget) }}</h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 fw-semibold"><h5>{{ __('2.3เลขที่ PA') }}</h5></div>
                                            <div class="col-6"><h5>{{ $contract->contract_pa }}</h5></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 fw-semibold"><h5>{{ __('2.3จำนวนเงิน PA') }}</h5></div>
                                            <div class="col-6"><h5>{{ number_format($contract->contract_pa_budget) }}</h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 fw-semibold"><h5>{{ __('2.3จำนวนคงเหลือหลังเงิน PA') }}</h5></div>
                                            <div class="col-6">
                                                <h5>   {{ number_format($contract->contract_pr_budget - $contract->contract_pa_budget) }}
                                                </h5>  </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6 fw-semibold"><h5>{{ __('2.3จำนวนเงิน ที่ใช้จ่ายต่อปี') }}</h5></div>
                                            <div class="col-6">
                                                <h5>    {{ number_format($contract->contract_peryear_pa_budget) }}</h5></div>
                                        </div>

                                         <div class="row">
                                            <div class="col-6 fw-semibold">{{ __('contract_file') }}</div>
                                            <div class="col-6">
                                                @if ($contract->contract_file)
                                                    <a href="{{ asset('uploads/contracts/' . $id . '/' . $contract->contract_file) }}" target="_blank">{{ $contract->contract_file }}</a>
                                                @else
                                                    {{ __('No file uploaded') }}
                                                @endif
                                            </div>
                                        </div>


                                    </div>
                                </div>
            </div> --}}


            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-6">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('สถานะสัญญา') }}</h5>
                            <p class="card-text">
                                {!! isset($contract) && $contract->contract_status == 2 ? '<span class="text-danger">ดำเนินการแล้วเสร็จ</span>' : '<span class="text-success">อยู่ในระหว่างดำเนินการ</span>' !!}
                            </p>

                            <h5 class="card-title">{{ __('เลขที่ สัญญา') }}</h5>
                            <p class="card-text">{{ $contract->contract_number }}</p>

                            <h5 class="card-title">{{ __('เลขที่ คู่ค้า') }}</h5>
                            <p class="card-text">{{ $contract->contract_juristic_id }}</p>

                            <h5 class="card-title">{{ __('เลขที่สั่งซื้อ') }}</h5>
                            <p class="card-text">{{ $contract->contract_order_no }}</p>

                            <h5 class="card-title">{{ __('ประเภท') }}</h5>
                            <p class="card-text">{{ \Helper::contractType($contract->contract_type) }}</p>
                            <h5 class="card-title">{{ __('หมายเหตุ') }}</h5>
                            <p class="card-text">{{ $contract->contract_projectplan }}</p>
                            <!-- Continue with the rest of your details -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-body">


                            <h5 class="card-title">{{ __('งบประมาณ') }} </h5>
                            <p class="card-text">{{ \Helper::project_select($contract->contract_budget_type) }}</p>


                            <h5 class="card-title">{{ __('วันที่เริ่มสัญญา') }} - {{ __('วันที่สิ้นสุดสัญญา') }}</h5>
                            <p class="card-text">{{ \Helper::Date4(date('Y-m-d H:i:s', $contract->contract_start_date)) }} - {{ \Helper::Date4(date('Y-m-d H:i:s', $contract->contract_end_date)) }}</p>

                            <h5 class="card-title">{{ __('วันที่สิ้นสุดสัญญา') }}</h5>
                            <p class="card-text">{{ \Helper::Date4(date('Y-m-d H:i:s', $contract->contract_end_date)) }}</p>

                            <h5 class="card-title">{{ __('จำนวนเดือน') }}</h5>
                            <p class="card-text">{{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse($contract->contract_end_date)) }} เดือน</p>

                            <h5 class="card-title">{{ __('จำนวนวัน') }}</h5>
                            <p class="card-text">{{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInDays(\Carbon\Carbon::parse($contract->contract_end_date)) }} วัน</p>


                            <!-- Continue with the rest of your details -->
                        </div>
                    </div>
                </div>
            </div>


            <div class="card mb-3">
                <table class="table h5">
                    <tr>
                        <th>2.1 เลขที่ MM</th>
                        <th>2.2 เลขที่ PR</th>
                        <th>2.3 เลขที่ PA</th>
                        <th>2.4 เลขที่ ER/PO</th>
                        <th>2.5 เลขที่ CN</th>
                    </tr>
                    <tr>
                        <td>{{ $contract->contract_mm }}</td>
                        <td>{{ $contract->contract_pr }}</td>
                        <td>{{ $contract->contract_pa }}</td>
                        @if($contract->contract_er_budget > 1)
                        <td>{{ ($contract->contract_er) }}</td>
@elseif($contract->contract_po_budget > 1)
                      <td>{{ ($contract->contract_po) }}</td>
@endif
<td></td>
<td>{{ ($contract->contract_cn) }}</td>
                    </tr>
                    <tr>
                        <th>2.1 จำนวนเงิน MM</th>
                        <th>2.2 จำนวนเงิน PR</th>
                        <th>2.3 จำนวนเงิน PA</th>
                        <th>2.4 จำนวนเงิน ER/PO</th>
                        <th>2.5 จำนวนเงิน CN</th>
                    </tr>
                    <tr>
                        <td>{{ $contract->contract_mm_bodget }}</td>
                        <td>{{ number_format($contract->contract_pr_budget,2) }}</td>
                        <td>{{ number_format($contract->contract_pa_budget,2) }}</td>

                        @if($contract->contract_er_budget > 1)
                        <td>{{ number_format($contract->contract_er_budget,2) }}</td>
                        @elseif($contract->contract_po_budget > 1)
                        <td>{{ number_format($contract->contract_po_budget,2) }}</td>
                        @endif
                        <td></td>

                        <td>{{  number_format($contract->contract_cn_budget,2)}}</td>

                    </tr>
                </table>
            </div>





            @if(count($files_contract) > 0)
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
            @endif



                            <table class="table callout callout-primary">
                                <thead>
                                    <tr>
                                        {{-- <th width="50">ลำดับ</th> --}}
                                        <th>กิจกรรม</th>
                                        <th>วันที่</th>
                                        <th>งวด</th>
                                        <th>รอการเบิกจ่าย</th>
                                        <th>การเบิกจ่าย</th>
                                        <th>วันที่ ใช้จ่าย</th>
                                        <th width="250"> คำสั่ง</th>
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
                                                @if($taskcon->taskcon_budget_it_operating > 0)
                                                {{ number_format($taskcon->taskcon_budget_it_operating,2) }}

                                                @elseif($taskcon->taskcon_budget_it_investment > 0)
                                                {{ number_format($taskcon->taskcon_budget_it_investment,2) }}

                                                @elseif ($taskcon->taskcon_budget_gov_utility > 0)
                                                {{ number_format($taskcon->taskcon_budget_gov_utility,2) }}
                                                @endif

                                            </td>

                                             <td>
                                                @if($taskcon->taskcon_budget_it_operating > 0)
                                                {{ number_format($taskcon->taskcon_cost_it_operating,2) }}
                                                @elseif($taskcon->taskcon_budget_it_investment > 0)
                                                {{ number_format($taskcon->taskcon_cost_it_investment,2) }}
                                                @elseif ($taskcon->taskcon_budget_gov_utility > 0)
                                                {{ number_format($taskcon->taskcon_cost_gov_utility,2) }}
                                                @endif

                                            </td>
                                            <td>
                                                {{ number_format($taskcon->taskcon_pay,2) }}

                                            </td>
                                            <td>
                                                {{ $taskcon->taskcon_pay_date ? Helper::Date4($taskcon->taskcon_pay_date) : '' }}
                                            </td>


                                            <td class="text-end">

                                                <a href="{{ route('contract.task.show', ['contract' => $contract->hashid, 'taskcon' => $taskcon->hashid]) }}"
                                                    class="btn-sm btn btn-primary text-white"><i
                                                        class="cil-folder-open ">ข้อมูล </i></a>
                                                <a href="{{ route('contract.task.edit', ['contract' => $contract->hashid, 'taskcon' => $taskcon->hashid]) }}"
                                                    class="btn-sm btn btn-warning text-white"> <i class="cil-cog"> เบิกจ่าย</i>
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
                            if (task.type == 'project') {
                                return new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.contract_pa_budget);
                            }  else if (task.type == 'task' ) {
                                return new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget);
                            }





                            else {
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
                            if (task.type == 'project') {
                                return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.total_cost - task.total_pay) + '</span>';}

                                else if (task.cost - task.pay > 0) {
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
