

                      <div class="container">
                            @foreach ($taskcons as $taskcon)
                            <x-slot:toolbar>
                            <form class="taskRefund-form" action="{{ route('project.task.taskRefund', ['project' => $project->hashid, 'task' => $task->hashid]) }}" method="POST" style="display:inline">
                                @method('POST') {{-- Use POST method to submit the form --}}
                                @csrf
                                <button class="btn btn-warning text-white btn-taskRefund-sub"><i class="cil-money"></i></button>
                            </form>
                            <a onclick="history.back()"
                                class="btn btn-secondary">กลับ</a>
{{--
                            <form class="taskRefund-form" action="{{ route('project.task.taskRefundbudget_sub', ['project' => $project->hashid, 'task' => $task->hashid]) }}" method="POST" style="display:inline">
                                @method('POST')
                                @csrf
                                <button class="btn btn-danger text-white btn-delete"><i class="cil-money"></i></button>
                            </form> --}}

                        </x-slot:toolbar>
                                {{-- <div>{{ $taskcon->task_id }}</div>
                                <div>{{ $taskcon->taskcon_id }}</div> --}}
                                <div class="row">
                                    <div class="col-sm">


                                        <div class="fs-4 fw-semibold btn">
                                            {!! $task->task_status == 1 ? '<span class=" bg-warning">ระหว่างดำเนินการ
                                            </span>' : '' !!}
                                        {!! $task->task_status == 2 ? '<span class=" bg-success">ดำเนินการแล้วเสร็จ</span>' : '' !!}
                                        </div>


                                        <div id="bodgetcost" class="callout callout-primary"{{--  style="display:none;" --}}>
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-3">{{ __('เลขที่ MM/เลขที่ สท. *') }}</div>
                                                <div class="col-9">{{ $taskcon->taskcon_mm }} </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">{{ __('เรื่อง') }}</div>
                                                <div class="col-9">{{ $taskcon->task_name }} </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">{{ __('วันที่เริ่มต้น') }}</div>
                                                <div class="col-9">{{\Helper::date4(date('Y-m-d H:i:s', $task->task_start_date)) }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">{{ __('วันที่สิ้นสุด') }}</div>
                                                <div class="col-9">{{\Helper::date4(date('Y-m-d H:i:s', $task->task_end_date)) }}</div>
                                            </div>

                                          {{--   <div class="row">
                                                <div class="col-3">{{ __('เรื่อง') }}</div>
                                                <div class="col-9">{{ $taskcon->task_description }}</div>
                                            </div> --}}
                                           {{--  <div class="row">
                                                <div class="col-3">{{ __('parent') }}</div>
                                                <div class="col-9">{{ $taskcon->task_parent }}</div>
                                            </div> --}}
                                        </div>
                                        </div>

                                        <div id="bodgetcost" class="callout callout-danger"{{--  style="display:none;" --}}>
                                        @if ($taskcon->task_budget_it_operating > 0)
                                        <div id="ICT" {{-- style="display:none;" --}}>
                                                <div class="row mt-3">
                                                    <div class="col-md-4">
                                                        <label for="task_budget_it_operating"
                                                            class="form-label">{{ __('วงเงินที่ขออนุมัติ งบกลาง ICT') }}</label>
                                                        <div>{{ number_format($taskcon->task_budget_it_operating,2) }}</div>

                                                        <div class="invalid-feedback">
                                                            {{ __('ระบุงบกลาง ICT') }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="task_cost_it_operating"
                                                            class="form-label">{{ __('รอการเบิก งบกลาง ICT') }}</label>
                                                        <div>{{ number_format($taskcon->task_cost_it_operating,2) }}</div>


                                                        <div class="invalid-feedback">
                                                            {{ __('งบกลาง ICT') }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="task_refund_pa_budget"
                                                            class="form-label">{{ __('จำนวนคงเหลือหลังเงิน PA') }}</label>
                                                        <div>{{ number_format($taskcon->task_refund_pa_budget,2) }}</div>


                                                    </div>
                                                </div>

                                        </div>
                                        @elseif ($taskcon->task_budget_it_investment > 0)
                            <div id="inv" {{-- style="display:none;" --}}>

                                    <div class="row mt-3">

                                        <div class="col-md-4">
                                            <label for="task_budget_it_investment"
                                                class="form-label">{{ __('วงเงินที่ขออนุมัติ งบดำเนินงาน') }}</label>
                                            <div>{{ number_format($taskcon->task_budget_it_investment,2) }}</div>


                                            <div class="invalid-feedback">
                                                {{ __('งบดำเนินงาน') }}
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="task_cost_it_investment"
                                                class="form-label">{{ __('รอการเบิก งบดำเนินงาน') }}</label>
                                            <div>{{ number_format($taskcon->task_cost_it_investment,2) }}</div>

                                            <div class="invalid-feedback">
                                                {{ __('งบดำเนินงาน') }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="task_refund_pa_budget"
                                                class="form-label">{{ __('จำนวนคงเหลือหลังเงิน PA') }}</label>
                                            <div>{{number_format ($taskcon->task_refund_pa_budget,2) }}</div>


                                        </div>
                                    </div>

                            </div>

                            @elseif ($taskcon->task_budget_gov_utility > 0)
                            <div id="utility" {{-- style="display:none;" --}}>

                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label for="task_budget_gov_utility"
                                                class="form-label">{{ __('วงเงินที่ขออนุมัติ งบสาธารณูปโภค') }}</label>
                                            <div>{{ number_format($taskcon->task_budget_gov_utility,2) }}</div>
                                            <div class="invalid-feedback">
                                                {{ __('ค่าสาธารณูปโภค') }}
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="task_cost_gov_utility"
                                                class="form-label">{{ __('รอการเบิก งบสาธารณูปโภค') }}</label>
                                            <div>{{ number_format($taskcon->task_cost_gov_utility,2) }}</div>

                                            <div class="invalid-feedback">
                                                {{ __('ค่าสาธารณูปโภค') }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="task_refund_pa_budget"
                                                class="form-label">{{ __('จำนวนคงเหลือหลังเงิน PA') }}</label>
                                            <div>{{ number_format($taskcon->task_refund_pa_budget,2) }}</div>


                                        </div>
                                    </div>
                            </div>


                            @endif



                                    </div>



                            <div id="pp_form" class="callout callout-warning"{{--  style="display:none;" --}}>

                                <div class="row">
                                    <div class="col-3">{{ __('งบใบสำคัญ_PP') }}</div>
                                    <div class="col-9">{{ $taskcon->taskcon_pp }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-3">{{ __('รายการใช้จ่าย ') }}</div>
                                    <div class="col-9">{{ $taskcon->taskcon_pp_name }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-3">{{ __('เวลา PP') }}</div>
                                    <div class="col-9">{{\Helper::date4(date('Y-m-d H:i:s', $task->task_pay_date)) }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-3">{{ __('จำนวนเงิน (บาท) PP') }}</div>
                                    <div class="col-9">{{ number_format($task->task_pay,2) }}</div>
                                </div>

                            </div>
                            @if(count($files) > 0)
                            <table class="table table-bordered table-striped">
                                <thead>
                                   {{--  <th>Photo</th> --}}
                                    <th>File Name</th>
                                  {{--   <th>File project_id</th>
                                    <th>File task_id</th>
                                    <th>File contract_id</th> --}}
                                    <th>File Size</th>
                                    <th>Date Uploaded</th>
                                    <th>File Location</th>
                                   {{--  <th>File Location</th> --}}
                                </thead>
                                <tbody>
                                    @if(count($files) > 0)
                                        @foreach($files as $file)
                                            <tr>
                                               {{--  <td><img src='storage/{{$file->name}}' name="{{$file->name}}" style="width:90px;height:90px;"></td> --}}
                                                <td>{{ $file->name }}</td>
                                       {{--          <td>{{ $file->project_id }}</td>
                                                <td>{{ $file->task_id }}</td>
                                                <td>{{ $file->contract_id }}</td> --}}


                                                <td>
                                                    @if($file->size < 1000)
                                                        {{ number_format($file->size,2) }} bytes
                                                    @elseif($file->size >= 1000000)
                                                        {{ number_format($file->size/1000000,2) }} mb
                                                    @else
                                                        {{ number_format($file->size/1000,2) }} kb
                                                    @endif
                                                </td>
                                                <td>{{ date('M d, Y h:i A', strtotime($file->created_at)) }}</td>


                                                <td><a href="{{ asset('storage/uploads/contracts/' . $file->project_id . '/' . $file->task_id . '/' . $file->name) }}">{{ $file->name }}</a></td>

                                               {{--  <td><a href="{{ $file->location }}">{{ $file->location }}</a></td> --}}



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

                        </div>
                        </div>
                        </div>
                        @endforeach
