<x-app-layout>
    <x-slot:content>
        <div class="container-fluid">
            {{ Breadcrumbs::render('project.task.editsub', $project, $task) }}
            <div class="animated fadeIn">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row ">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <x-card title="{{ __('วงเงินที่ขออนุมัติ/การใช้จ่าย ของ') }}{{ $task->task_name }}">
                            <div id="budget_form" >
                            <form method="POST"
                                action="{{ route('project.task.update', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
                                class="row needs-validation" enctype="multipart/form-data"
                                novalidate>
                                @csrf
                                {{ method_field('PUT') }}

                                <div class="row mt-3 callout callout-primary">

                                    <div class="col-md-6">
                                        <label for="task_parent" class="form-label">{{ __('เป็นกิจกรรม') }}</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" id="task_parent_display"
                                            value="{{ $task_parent_sub->task_name }}" disabled readonly>

                                        <input type="hidden" class="form-control" id="task_parent" name="task_parent"
                                            value="{{ $task->task_id }}">

                                        <div class="invalid-feedback">
                                            {{ __('กิจกรรม') }}
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        {{--  @if($task->task_status == 1) --}}
                                        <label for="task_status" class="form-label">{{ __('สถานะกิจกรรม') }}</label>
                                        <span class="text-danger">*</span>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="task_status"
                                                id="task_status1" value="1" @checked($task_parent_sub->task_status == 1)>
                                            <label class="form-check-label" for="task_status1"
                                                @checked($task_parent_sub->task_status == 1)>
                                                ระหว่างดำเนินการ
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="task_status"
                                                id="task_status2" value="2" @checked($task->task_status == 2)>
                                            <label class="form-check-label" for="task_status2"
                                                @checked($task_parent_sub->task_status == 2)>
                                                ดำเนินการแล้วเสร็จ
                                            </label>
                                        </div>
                                        {{-- @elseif($task->task_status == 2) --}}
                                        @if(auth()->user()->isAdmin())
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="task_status"
                                                id="task_status2" value="2" @checked($task_parent_sub->task_status == 2)>
                                            <label class="form-check-label" for="task_status2"
                                                @checked($task_parent_sub->task_status == 2)>
                                                ดำเนินการแล้วเสร็จ
                                            </label>
                                        </div>
                                        @endif
                                    {{--      @endif --}}
                                    </div>


                                    <div class="col-md-3 d-none">
                                        <label for="task_type" class="form-label">{{ __('งาน/โครงการ') }}</label> <span
                                            class="text-danger">*</span>
                                        <div>
                                            <input class="form-check-input" type="radio" name="task_type"
                                                id="task_type1" value="1" @checked($task->task_type == 1)>
                                            <label class="form-check-label" for="task_type1"
                                                @checked($task->task_type == 1)>
                                                มี PA
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="task_type"
                                                id="task_type2" value="2" @checked($task->task_type == 2)>
                                            <label class="form-check-label" for="task_type2"
                                                @checked($task->task_type == 2)>
                                                ไม่มี PA
                                            </label>
                                        </div>
                                    </div>


                                    <div  class="d-none">
                                        @if (session('contract_id'))
                                            ID: {{ session('contract_id') }}
                                        @endif
                                        @if (session('contract_number'))
                                            Number: {{ session('contract_number') }}
                                        @endif
                                        @if (session('contract_mm'))
                                        Name_mm: {{ session('contract_mm') }}
                                    @endif
                                        @if (session('contract_mm_name'))
                                        Name_mm: {{ session('contract_mm_name') }}
                                    @endif
                                        @if (session('contract_name'))
                                            Name: {{ session('contract_name') }}
                                        @endif
                                        @if (session('contract_mm_budget'))
                                            MM: {{ session('contract_mm_budget') }}
                                        @endif
                                        @if (session('contract_pr_budget'))
                                        Pr: {{ session('contract_pr_budget') }}
                                    @endif
                                    @if (session('contract_pa_budget'))
                                    pa: {{ session('contract_pa_budget') }}
                                @endif
                                @if (session('contract_refund_pa_budget'))
                                refund_pa_budget: {{ session('contract_refund_pa_budget') }}
                            @endif
                                @if (session('contract_start_date'))
                                start_date:  {{ Helper::Date4(date('Y-m-d H:i:s', (session('contract_start_date')))) }}



                            @endif
                            @if (session('contract_end_date'))
                            end_date:  {{ Helper::Date4(date('Y-m-d H:i:s', (session('contract_end_date')))) }}
                        @endif

                                        </div >
                                    <div class="row">

                                     {{--   <div class="col-sm">
                                            <div class="row">
                                                @if ($task_parent_sub->task_budget_it_operating > 0)
                                                    <div class="col-6 fw-semibold">{{ __('คงเหลือ งบกลาง ICT') }}</div>

                                                    @if($task_parent_sub->task_refund_pa_status == 2)

                                                                @endif

                                                    บาท
                                                @endif
                                            </div>

                                            <div class="row">
                                                @if ($task->task_budget_it_investment > 0)
                                                    <div class="col-6 fw-semibold">{{ __('คงเหลือ งบดำเนินงาน') }}</div>








                                                    @endif
                                            </div>
                                            <div class="row">
                                                @if ($task->task_budget_gov_utility > 0)
                                                    <div class="col-6 fw-semibold">{{ __('คงเหลือ งบสาธารณูปโภค') }}</div>
                                                    <div class="col-6">

                                                    </div>
                                                @endif
                                            </div>
                                        </div> --}}
                                        @if ($task->task_type == 1)
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="task_contract" class="form-label">{{ __('สัญญา') }}</label> <span class="text-danger">*</span>
                                                @if (isset($contract_s->contract_number) && $contract_s->contract_number != null)
                                                <input type="text" class="form-control" id="contract_number"
                                                value=" {{ $contract_s->contract_number }}" disabled readonly>


                                                @else
                                                    <select name="task_contract" id="task_contract" class="form-control">
                                                        <option value="">ไม่มี</option>
                                                        @foreach ($contracts as $contract)
                                                            <option value="{{ $contract->contract_id }}"
                                                                {{ session('contract_id') == $contract->contract_id ? 'selected' : '' }}>
                                                                [{{ $contract->contract_number }}]{{ $contract->contract_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        {{ __('สัญญา') }}
                                                    </div>

                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-4">
                                            <span class="text-danger"> <a href="{{ route('contract.createsubcn', [ 'origin' =>  2, 'project' =>  $project->hashid,'projecthashid' => $project->hashid, 'taskHashid' => $task->hashid]) }}"
                                                class="btn btn-success text-white"
                                                target="contractCreate">เพิ่มสัญญา/ใบจ้าง</a>
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                </div>

                               {{--      <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="task_start_date"
                                                class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span
                                                class="text-danger">*</span>
                                            <div data-coreui-toggle="date-picker" id="task_start_date"
                                                data-coreui-format="dd/MM/yyyy"
                                                data-coreui-date="{{ date('m/d/Y', $task->task_start_date) }} "></div>

                                        </div>
                                        <div class="col-md-6">
                                            <label for="task_end_date"
                                                class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span
                                                class="text-danger">*</span>

                                            <div data-coreui-toggle="date-picker" id="task_end_date"
                                                data-coreui-format="dd/MM/yyyy"
                                                data-coreui-date="{{ date('m/d/Y', $task->task_end_date) }} "></div>
                                        </div>
                                    </div> --}}


                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="task_start_date" class="form-label">{{ __('วันที่เริ่มต้น') }}</label>
                                            <input class="form-control" id="task_start_date" name="task_start_date"
                                                value="{{ \Helper::date4(date('Y-m-d H:i:s', $task->task_start_date)) }}"  {{ $task->task_status == 2 ? 'readonly' : '' }}>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="task_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }}</label>
                                            <input class="form-control" id="task_end_date" name="task_end_date"
                                                value="{{ \Helper::date4(date('Y-m-d H:i:s', $task->task_end_date)) }}"  {{ $task->task_status == 2 ? 'readonly' : '' }}>
                                        </div>
                                    </div>







                                    <div class="col-md-12 mt-3">
                                        <label for="task_name"
                                            class="form-label">{{ __('ชื่อรายการที่ใช้จ่าย') }}</label> <span
                                            class="text-danger">*</span>
                                        <input type="text" class="form-control" id="task_name" name="task_name"
                                            value="{{ $task->task_name  }}" required autofocus  {{ $task->task_status == 2 ? 'readonly' : '' }}>
                                        <div class="invalid-feedback">
                                            {{ __('ชื่อรายการที่ใช้จ่าย') }}
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label for="task_description"
                                            class="form-label">{{ __('รายละเอียดที่ใช้จ่าย') }}</label>
                                        <textarea class="form-control" name="task_description" id="task_description" rows="10">


                                {{ $task->task_description }}
                            </textarea>
                                        <div class="invalid-feedback">
                                            {{ __('รายละเอียดการที่ใช้จ่าย') }}
                                        </div>
                                    </div>






                                        </div>

                                        <div id="budget_pay_form" >

                                        <div class="row mt-3">
                                            <div class="col-6 mt-3">
                                                <strong><h4>วงเงินที่ขออนุมัติ  PR </h4></strong>
                                                @if ($task->task_budget_it_operating > 0)
                                                <div class="col-md-12">
                                                    <label for="task_budget_it_operating"
                                                        class="form-label">{{ __('งบกลาง ICT') }}</label>
                                                   {{--  <input type="text" placeholder="0.00" step="0.01"
                                                        class="form-control" id="task_budget_it_operating"
                                                        name="task_budget_it_operating" min="0"
                                                        value="{{ $task->task_budget_it_operating }}"> --}}

                                                        <input type="text" placeholder="0.00" step="0.01"
                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                         class="form-control numeral-mask" id="task_budget_it_operating"
                                                         name="task_budget_it_operating" min="0"   value="{{ $task->task_budget_it_operating }}">


                                                    <div class="invalid-feedback">
                                                        {{ __('ระบุงบกลาง ICT') }}
                                                    </div>



                                                </div>
                                                @endif
                                                @if ($task->task_budget_it_investment > 0)
                                                <div class="col-md-12">
                                                    <label for="task_budget_it_investment"
                                                        class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                         {{--            <input type="text" placeholder="0.00" step="0.01"
                                                        class="form-control" id="task_budget_it_investment"
                                                        name="task_budget_it_investment" min="0"
                                                        value="{{ $task->task_budget_it_investment }}"> --}}
                                                        <input type="text" placeholder="0.00" step="0.01"
                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                         class="form-control numeral-mask" id="task_budget_it_investment"
                                                         name="task_budget_it_investment" min="0"   value="{{ $task->task_budget_it_investment }}">

                                                    <div class="invalid-feedback">
                                                        {{ __('ระบุงบดำเนินงาน') }}
                                                    </div>
                                                </div>
                                                @endif
                                                @if ($task->task_budget_gov_utility > 0)
                                                <div class="col-md-12">
                                                    <label for="task_budget_gov_utility"
                                                        class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                              {{--       <input type="text" placeholder="0.00" step="0.01"
                                                        class="form-control" id="task_budget_gov_utility"
                                                        name="task_budget_gov_utility" min="0"
                                                        value="{{ $task->task_budget_gov_utility }}"> --}}

                                                        <input type="text" placeholder="0.00" step="0.01"
                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                         class="form-control numeral-mask" id="task_budget_gov_utility"
                                                         name="task_budget_gov_utility" min="0"   value="{{ $task->task_budget_gov_utility }}">


                                                    <div class="invalid-feedback">
                                                        {{ __('ระบุค่าสาธารณูปโภค') }}
                                                    </div>
                                                </div>
                                                @endif
                                            </div>

                                            @if ($task->task_parent_sub < 2)
                                            <div class="col-6 mt-3">
                                                <strong><h4>ค่าใช้จ่าย  (PA/ไม่มี PA)</h4></strong>

                                                @if ($task->task_budget_it_operating > 0)
                                                <div class="col-md-12">
                                                    <label for="task_cost_it_operating"
                                                        class="form-label">{{ __('งบกลาง ICT') }}</label>
                                                {{--     <input type="text"placeholder="0.00" step="0.01"
                                                        class="form-control" id="task_cost_it_operating"
                                                        name="task_cost_it_operating" min="0"
                                                        value="{{ $task->task_cost_it_operating }}">
 --}}
                                                        <input type="text" placeholder="0.00" step="0.01"
                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                         class="form-control numeral-mask" id="task_cost_it_operating"
                                                         name="task_cost_it_operating" min="0"  value={{ session('contract_pa_budget') }} value="{{ $task->task_cost_it_operating }}">

                                                        <div class="invalid-feedback">
                                                        {{ __('งบกลาง ICT') }}
                                                    </div>
                                                </div>
                                                @endif
                                                @if ($task->task_budget_it_investment > 0)
                                                <div class="col-md-12">
                                                    <label for="task_cost_it_investment"
                                                        class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                           {{--          <input type="text" placeholder="0.00"
                                                        step="0.01"class="form-control"
                                                        id="task_cost_it_investment" name="task_cost_it_investment"
                                                        min="0" value="{{ $task->task_cost_it_investment }}"> --}}


                                                        <input type="text" placeholder="0.00" step="0.01"
                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                         class="form-control numeral-mask" id="task_cost_it_investment"
                                                         name="task_cost_it_investment" min="0" value={{ session('contract_pa_budget') }}  value="{{ $task->task_cost_it_investment }}">




                                                        <div class="invalid-feedback">
                                                        {{ __('งบดำเนินงาน') }}
                                                    </div>
                                                </div>
                                                @endif
                                                @if ($task->task_budget_gov_utility > 0)
                                                <div class="col-md-12">
                                                    <label for="task_cost_gov_utility"
                                                        class="form-label">{{ __('งบค่าสาธารณูปโภค') }}</label>
                                                   {{--  <input type="text" placeholder="0.00" step="0.01"
                                                        class="form-control" id="task_cost_gov_utility"
                                                        name="task_cost_gov_utility" min="0"
                                                        value="{{ $task->task_cost_gov_utility }}"> --}}

                                                        <input type="text" placeholder="0.00" step="0.01"
                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                         class="form-control numeral-mask" id="task_cost_gov_utility"
                                                         name="task_cost_gov_utility" min="0"  value={{ session('contract_pa_budget') }} value="{{ $task->task_cost_gov_utility }}">



                                                        <div class="invalid-feedback">
                                                        {{ __('ระบุค่าสาธารณูปโภค') }}
                                                    </div>
                                                </div>
                                                @endif
                                            </div>


                                            <div id="refund" {{-- style="display:none;" --}}>
                                                <div class=" row mt-3">
                                                    <div class="col-md-4">
                                                        <label for="task_refund_pa_budget"
                                                            class="form-label">{{ __('จำนวนคงเหลือหลังเงิน PA') }}</label>
                                                        <span class="text-danger"></span>

                                                        <input type="text" placeholder="0.00"
                                                            step="0.01"
                                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                            class="form-control numeral-mask"
                                                            id="task_refund_pa_budget"
                                                            name="task_refund_pa_budget" min="0"   value={{ session('contract_refund_pa_budget') }} value={{ $task->task_refund_pa_budget,2 }} readonly >

                                                        {{--  <div class="invalid-feedback">
                                                                {{ __('ค่าสาธารณูปโภค') }}
                                                            </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                @if ($task->task_parent_sub < 2)
                                @if($taskcon)
                                    <div id="pay_form" >
                                    <div >
                                    <h4>เบิกจ่าย</h4>
                                    <div class="row mt-3">

                                        <div class="col-md-4">
                                            <label for="taskcon_pp"
                                                class="form-label">{{ __('งบใบสำคัญ_PP ') }}</label>
                                            {{-- <span class="text-danger">*</span> --}}
                                           {{--  @if($taskcon) --}}
                                            <input type="text" class="form-control"
                                                id="taskcon_pp" name="taskcon_pp"
                                                value="{{ $taskcon->taskcon_pp }}"    {{ $task->task_status == 2 ? 'readonly' : '' }}>
                                            <div class="invalid-feedback">
                                                {{ __(' กรอกงบใบสำคัญ_PP') }}
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <label for="taskcon_pp_name"
                                                class="form-label">{{ __('รายการใช้จ่าย ') }}</label>
                                          {{--   <span class="text-danger">*</span> --}}
                                            <input type="text" class="form-control"
                                                id="taskcon_pp_name" name="taskcon_pp_name"
                                                value="{{ $taskcon->taskcon_pp_name }}"    {{ $task->task_status == 2 ? 'readonly' : '' }}  >
                                            <div class="invalid-feedback">
                                                {{ __(' กรอกรายการใช้จ่าย') }}
                                            </div>
                                        </div>
                                    </div>



                                    <div class="row mt-3">



                                        <div class="col-md-6">
                                            <label for="task_pay_date" class="form-label">{{ __('วันที่เบิกจ่าย') }}</label>
                                            <input class="form-control" id="task_pay_date" name="task_pay_date"
                                                value="{{ \Helper::date4(date('Y-m-d H:i:s', $task->task_pay_date)) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="task_pay" class="form-label">{{ __('เบิกจ่าย') }}</label>
                                            <input type="text" placeholder="0.00" step="0.01"
                                                data-inputmask="'alias': 'decimal', 'groupSeparator': ','" class="form-control numeral-mask"
                                                id="task_pay" name="task_pay" min="0" value="{{ $task->task_pay }}">
                                            <!-- <input type="number" placeholder="0.00" step="0.01"
                                                class="form-control" id="task_pay" name="task_pay" min="0" value="{{ $task->task_pay }}"> -->
                                            <div class="invalid-feedback">
                                                {{ __('เบิกจ่าย') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class=" col-md-12 mt-3">
                                    <label for="file"
                                        class="form-label">{{ __('เอกสารแนบ') }}</label>
                                <div class="input-group control-group increment " >
                                    <input type="file" name="file[]" class="form-control" multiple >
                                    <div class="input-group-btn">
                                      <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
                                    </div>
                                  </div>
                                  <div class="clone d-none">
                                    <div class="control-group input-group" style="margin-top:10px">
                                      <input type="file" name="file[]" class="form-control" multiple>
                                      <div class="input-group-btn">
                                        <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                      </div>
                                    </div>
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
                                        <th>ลบ</th>
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

                                                    <td>
                                                        <a href="{{ route('project.task.filesdel', ['project' => $project->hashid, 'task' => $task->hashid]) }}" class="btn btn-danger">
                                                            <i class="glyphicon glyphicon-remove"></i> Remove
                                                        </a>
                                                    </td>


                                                    {{--  <td><a href="{{ $file->location }}">{{ $file->location }}</a></td> --}}



                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="12" class="text-center">No Table Data</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                @endif
                                @if(auth()->user()->isAdmin())
                                    <div class="col-md-12 mt-3">
                                        @if($task->task_refund_pa_status == 1)
                                        <label for="task_refund_pa_status" class="form-label">{{ __('งบประมาณ ') }}</label> <span class="text-danger"></span>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="task_refund_pa_status" id="task_refund_pa_status" value="1" @checked($task->task_refund_pa_status == 1)>
                                            <label class="form-check-label" for="task_refund_pa_status1" @checked($task->task_refund_pa_status == 1) >
                                              ไม่ได้คืน
                                            </label>
                                          </div>
                                        <div class="form-check form-check-inline ms-5">
                                          <input class="form-check-input" type="radio" name="task_refund_pa_status" id="task_refund_pa_status" value="2" @checked($task->task_refund_pa_status == 2)>
                                          <label class="form-check-label" for="task_refund_pa_status2"  @checked($task->task_refund_pa_status == 2)>
                                            คืน
                                          </label>
                                        </div>
                                        @elseif($task->task_refund_pa_status == 2)
                                        <div class=" d-nome form-check form-check-inline ms-5">
                                            <input class="form-check-input" type="radio" name="task_refund_pa_status" id="task_refund_pa_status" value="2" @checked($task->task_refund_pa_status == 2) {{-- {{ $task->task_refund_pa_status == 3 ? 'readonly' : '' }}  --}}>
                                            <label class="form-check-label" for="task_refund_pa_status3"  @checked($task->task_refund_pa_status == 2) >
                                              คืน
                                            </label>
                                          </div>
                                        @endif

                                    </div>


                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="task_refund_pa_status" id="task_refund_pa_status" value="1" @checked($task->task_refund_pa_status == 1)>
                                        <label class="form-check-label" for="task_refund_pa_status1" @checked($task->task_refund_pa_status == 1) >
                                          ไม่ได้คืน
                                        </label>
                                      </div>

    {{-- Content for admin --}}
    1


    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="task_budget_type" id="task_budget_type" value="1" @checked($task->task_budget_type == 1)>
      <label class="form-check-label" for="task_budget_type1" @checked($task->task_budget_type == 1) >
        คืน1task_budget_type1
      </label>
    </div>



    <div class=" d-nome form-check form-check-inline ms-5">
      <input class="form-check-input" type="radio" name="task_budget_type" id="task_budget_type" value="2" @checked($task->task_refund_pa_status == 2) {{-- {{ $task->task_refund_pa_status == 3 ? 'readonly' : '' }}  --}}>
      <label class="form-check-label" for="task_budget_type2"  @checked($task->task_refund_pa_status == 2) >
        คืนtask_budget_type2
      </label>
    </div>

    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="task_budget_type" id="task_budget_type" value="" @checked(is_null($task->task_refund_pa_status))>
      <label class="form-check-label" for="task_refund_pa_status0" @checked(is_null($task->task_refund_pa_status))>
        ไม่ได้คืน task_budget_type
      </label>
  </div>


                                      @endif




                                  @else
                                      {{-- Content for regular user --}}
                              @endif


                                </div>
                                    @if ($task->task_parent_sub == 2)

                                    <div id="task_parent_sub_budget"  {{-- style="display:none;" --}}>
                                        <div class=" row mt-3 d-none ">
                                            <div class="col-md-4">
                                                <label for="task_parent_sub_budget"
                                                    class="form-label">{{ __('task_parent_sub_budget ') }}</label>
                                                <span class="text-danger"></span>

                                                <input type="text" placeholder="0.00"
                                                    step="0.01"
                                                    data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                    class="form-control numeral-mask"
                                                    id="task_parent_sub_budget"
                                                    name="task_parent_sub_budget" min="0"    value={{ $task->task_parent_sub_budget }} readonly >

                                                {{--  <div class="invalid-feedback">
                                                        {{ __('ค่าสาธารณูปโภค') }}
                                                    </div> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div id="task_parent_sub_cost" {{-- style="display:none;" --}}>
                                        <div class=" row mt-3 d-none ">
                                            <div class="col-md-4">
                                                <label for="task_parent_sub_cost"
                                                    class="form-label">{{ __('task_parent_sub_cost') }}</label>
                                                <span class="text-danger"></span>

                                                <input type="text" placeholder="0.00"
                                                    step="0.01"
                                                    data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                    class="form-control numeral-mask"
                                                    id="task_parent_sub_cost"
                                                    name="task_parent_sub_cost" min="0"    value={{ $task->task_parent_sub_cost }} readonly >

                                                {{--  <div class="invalid-feedback">
                                                        {{ __('ค่าสาธารณูปโภค') }}
                                                    </div> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div id="task_parent_sub_refund_budget" {{-- style="display:none;" --}}>
                                        <div class=" row mt-3 d-none">
                                            <div class="col-md-4">
                                                <label for="task_parent_sub_refund_budget"
                                                    class="form-label">{{ __('task_parent_sub_refund_budget') }}</label>
                                                <span class="text-danger"></span>

                                                <input type="text" placeholder="0.00"
                                                    step="0.01"
                                                    data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                    class="form-control numeral-mask"
                                                    id="task_parent_sub_refund_budget"
                                                    name="task_parent_sub_refund_budget" min="0"  value={{ $task->task_parent_sub_refund_budget }} readonly >

                                                {{--  <div class="invalid-feedback">
                                                        {{ __('ค่าสาธารณูปโภค') }}
                                                    </div> --}}
                                            </div>
                                        </div>
                                    </div>


                                    @endif
                                </div>
        </div>

                                <div class="col-md-3 mt-3 d-none">
                                    <label for="task_mm_budget_1"
                                    class="form-label">{{ __('budget') }}</label>
                                <input type="text" placeholder="0.00" step="0.01"
                                    data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                    class="form-control numeral-mask"
                                    id="task_mm_budget" name="task_mm_budget"
                                    min="0"  value={{ $task->task_mm_budget }}  onchange="calculateRefund1()" >

                                <div class="invalid-feedback">
                                    {{ __('mm') }}
                                </div>





                                </div>






                                </div>


                                <x-button class="btn-success" type="submit">{{ __('coreuiforms.save') }}</x-button>
                           <x-button onclick="history.back()" class="text-black btn-light">
                                    {{ __('coreuiforms.return') }}</x-button>
                            </form>
                        </x-card>
                    </div>
                </div>
            </div>
        </div>

    </x-slot:content>
    <x-slot:css>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet"/>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    </x-slot:css>
    <x-slot:javascript>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js"></script>
       {{--  <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script> --}}
        <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
        <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>

        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function() {
                var taskRefundPaStatus = {!! json_encode($task->task_refund_pa_status) !!};  // รับค่าจาก Laravel ไปยัง JavaScript
                if (taskRefundPaStatus == 2) {
                    var formInputs = document.querySelectorAll('#budget_form input, #mm_form textarea, #mm_form select');  // เลือกทั้งหมด input, textarea, และ select ภายใน #mm_form
                    formInputs.forEach(function(input) {
                        input.setAttribute('readonly', true);  // ตั้งค่าแอตทริบิวต์ readonly
                    });
                }
            });
        </script>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        var task_Status = {!! json_encode($task->task_status) !!};  // รับค่าจาก Laravel ไปยัง JavaScript
        if (task_Status == 2) {
            var formInputs = document.querySelectorAll('#pay_form input, #mm_form textarea, #mm_form select,#budget_form input');  // เลือกทั้งหมด input, textarea, และ select ภายใน #mm_form
            formInputs.forEach(function(input) {
                input.setAttribute('readonly', true);  // ตั้งค่าแอตทริบิวต์ readonly
            });
        }
    });
</script>


 <script type="text/javascript">


    $(document).ready(function() {

      $(".btn-success").click(function(){
          var html = $(".clone").html();
          $(".increment").after(html);
      });

      $("body").on("click",".btn-danger",function(){
          $(this).parents(".control-group").remove();
      });

    });

</script>


<script>
    $(document).ready(function() {
        // Initialize Select2 on the select element
        $('.js-example-basic-single').select2();

        $('.js-example-basic-single').on('change', function() {
            // Get the selected value
            const selectedValue = $(this).val();
            // Handle the selected value as needed
            console.log(selectedValue);
        });
    });
</script>

        <script>
            $(document).ready(function() {
                // Initialize Select2 on the select element
                $('.js-example-basic-single').select2();

                $('.js-example-basic-single').on('change', function() {
                    // Get the selected value
                    const selectedValue = $(this).val();
                    // Handle the selected value as needed
                    console.log(selectedValue);
                });
            });
        </script>

                <script>
                    $(document).ready(function() {
                        $(":input").inputmask();
                    });
                </script>





<script>
    $(function() {
        $("#task_start_date, #task_end_date,#task_pay_date").datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            language:"th-th",

        });
        var project_fiscal_year = {{$projectDetails->project_fiscal_year}};
        var project_start_date_str = "{{ Helper::Date4(date('Y-m-d H:i:s', $projectDetails->project_start_date)) }}"; // Wrap in quotes
        var project_end_date_str = "{{ Helper::Date4(date('Y-m-d H:i:s', $projectDetails->project_end_date)) }}"; // Wrap in quotes

        project_fiscal_year = project_fiscal_year - 543;

        var fiscalYearStartDate = new Date(project_fiscal_year - 1, 9, 1); // 1st October of the previous year
        var fiscalYearEndDate = new Date(project_fiscal_year, 8, 30); // 30th September of the fiscal year

        console.log(project_start_date_str);
        console.log(project_end_date_str);
        console.log(fiscalYearStartDate);
        console.log(fiscalYearEndDate);
// Set the start and end dates for the project_start_date datepicker
$("#task_start_date").datepicker("setStartDate", fiscalYearStartDate);
  //  $("#project_start_date").datepicker("setEndDate", fiscalYearEndDate);

    // Set the start and end dates for the project_end_date datepicker
   // $("#project_end_date").datepicker("setStartDate", fiscalYearStartDate);
    $("#task_end_date").datepicker("setEndDate", project_end_date_str);



        $('#task_start_date').on('changeDate', function() {
            var startDate = $(this).datepicker('getDate');
            $("#task_end_date").datepicker("setStartDate", startDate);
            $("#task_pay_date").datepicker("setStartDate", startDate);
        });

        $('#task_end_date').on('changeDate', function() {
            var endDate = $(this).datepicker('getDate');
            $("#task_start_date").datepicker("setEndDate", endDate);
            $("#task_pay_date").datepicker("setEndDate", project_end_date_str);
        });
    });
</script>



{{-- <script>
    $(document).ready(function() {
        // Initially hide the fields
        $("#task_cost_it_operating, #task_cost_it_investment, #task_cost_gov_utility").parent().hide();
        $("#task_pay_d").hide();

        // Show the fields when a value is entered in task_budget_it_operating
        $("#task_budget_it_operating, #task_budget_it_investment, #task_budget_gov_utility").on("input", function() {
            var fieldId = $(this).attr('id');




            /* if ($(this).val() != '') {
            if (fieldId === "task_budget_it_operating" && $(this).val() > 1) {
                $("#task_cost_it_operating").parent().show();
                $("#task_cost_it_investment, #task_cost_gov_utility").parent().hide();
                $("#task_pay_d").hide();
            } else if (fieldId === "task_budget_it_investment" && $(this).val() > 1) {
                $("#task_cost_it_investment").parent().show();
                $("#task_cost_it_operating, #task_cost_gov_utility").parent().hide();
                $("#task_pay_d").hide();
            } else if (fieldId === "task_budget_gov_utility" && $(this).val() > 1) {
                $("#task_cost_gov_utility").parent().show();
                $("#task_cost_it_operating, #task_cost_it_investment").parent().hide();
                $("#task_pay_d").hide();
            }
        } else {
            $("#task_cost_it_operating, #task_cost_it_investment, #task_cost_gov_utility").parent().hide();
            $("#task_pay_d").hide();
            }
        }); */

        // Show the fields when a value is entered in task_cost_it_operating
        $("#task_cost_it_operating, #task_cost_it_investment, #task_cost_gov_utility").on("input", function() {
            if ($(this).val() != '') {
                $("#task_pay_d").show();
            } else {
                $("#task_pay_d").hide();
            }
        });
    });
</script> --}}





<script>
                        $(document).ready(function() {
                            $("#task_budget_it_operating,#task_budget_it_investment, #task_budget_gov_utility").on("input",
                                function() {
                                    var max = 0;
                                    var fieldId = $(this).attr('id');
                                    var budgetItOperating = $("#task_budget_it_operating").val();
    var budgetItInvestment = $("#task_budget_it_investment").val();
    var budgetGovUtility = $("#task_budget_gov_utility").val();
                                    if (fieldId === "task_budget_it_investment") {
        max = parseFloat({{  $tasksDetails->task_budget_it_investment+($task_parent_sub->task_budget_it_investment-$task_sub_sums['investment']['task_mm_budget'])+$task_sub_sums['investment']['task_refund_pa_budget'] }})
        if (budgetItInvestment === "0" || budgetItInvestment === '' || parseFloat(budgetItInvestment) < -0) {
                $("#task_budget_it_investment").val('');
            }

    } else if (fieldId === "task_budget_it_operating") {
        max = parseFloat({{ $task->task_budget_it_operating +($task_parent_sub->task_budget_it_operating- $task_sub_sums['operating']['task_mm_budget']) + $task_sub_refund_pa_budget['operating']['task_refund_pa_budget']}});
        if (budgetItOperating === "0" || budgetItOperating === '' || parseFloat(budgetItOperating) < -0) {
                $("#task_budget_it_operating").val('');
            }


    } else if (fieldId === "task_budget_gov_utility") {
        max = parseFloat({{ $tasksDetails->task_budget_gov_utility +($task_parent_sub->task_budget_gov_utility-$task_sub_sums['utility']['task_mm_budget'])+$task_sub_sums['utility']['task_refund_pa_budget']}});
        if (budgetGovUtility === "0" || budgetGovUtility === '' || parseFloat(budgetGovUtility) < -0) {
                $("#task_budget_gov_utility").val('');
            }

    }

                                    var current = parseFloat($(this).val().replace(/,/g, ""));
                                    if (current > max) {
                    Swal.fire("จำนวนเงินที่ใส่ต้องไม่เกิน " + max.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + " บาท");
                     /*  $(this).val(max.toFixed(2)); */
           $(this).val(0);
                    }


                                });
                        });
                    </script>

<script>
    $(document).ready(function() {
        $("#task_cost_it_operating,#task_cost_it_investment, #task_cost_gov_utility").on("input", function() {
            var max;
            var fieldId = $(this).attr('id');
            var costItOperating = $("#task_cost_it_operating").val();
                    var costItInvestment = $("#task_cost_it_investment").val();
                    var costGovUtility = $("#task_cost_gov_utility").val();
                    var taskpay = $("#task_pay").val();
            if (fieldId === "task_cost_it_investment") {
                max = parseFloat($("#task_budget_it_investment").val().replace(/,/g , ""));
                if (costItInvestment === "0" || costItInvestment === '' || parseFloat(costItInvestment) < -0) {
                $("#task_cost_it_investment").val('');
            }
            } else if (fieldId === "task_cost_it_operating") {
                max = parseFloat($("#task_budget_it_operating").val().replace(/,/g , ""));
                if (costItOperating === "0" || costItOperating === '' || parseFloat(costItOperating) < -0) {
                $("#task_cost_it_operating").val('');
            }
            } else if (fieldId === "task_cost_gov_utility") {
                max = parseFloat($("#task_budget_gov_utility").val().replace(/,/g , ""));
                if (costGovUtility === "0" || costGovUtility === '' || parseFloat(costGovUtility) < -0) {
                $("#task_cost_gov_utility").val('');
                }
            }

            var current = parseFloat($(this).val().replace(/,/g , ""));
            if (current > max) {
                Swal.fire("จำนวนเงินที่ใส่ต้องไม่เกิน " + max.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + " บาท");
             /*  $(this).val(max.toFixed(2)); */
             $(this).val(0);
            }
        });
    });
    </script>


                <script>
    $(document).ready(function() {
        $("#task_pay").on("input", function() {
            var max = 0;  // Initialize max to 0
            var fieldId = $(this).attr('id');
            var costFields = ['task_cost_it_operating', 'task_cost_it_investment', 'task_cost_gov_utility'];
            var pay = $("#task_pay").val();
            // Check if the fieldId is "task_pay"
            if (fieldId === "task_pay") {
                // Iterate through the costFields array
                costFields.forEach(function(field) {
                    // Get the value of each field, remove commas, convert to float, and add to max
                    var fieldValue = $("#" + field).val();
                    if (fieldValue) {  // Check if fieldValue is defined
                        if (pay === "0" || pay === '' || parseFloat(pay) < -0) {
                            $("#task_pay").val('');
                        }
                        max += parseFloat(fieldValue.replace(/,/g, ""));
                    }
                });
            }

            var current = parseFloat($(this).val().replace(/,/g, ""));
            if (current > max) {
                Swal.fire("จำนวนเงินที่ใส่ต้องไม่เกิน " + max.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) +
                    " บาท");
                $(this).val(0);
            }
        });
    });
</script>



<script>
    var budgetFields = ['task_budget_it_operating', 'task_budget_it_investment', 'task_budget_gov_utility'];

    function calculateRefund1() {
        var totalRefund = 0;

        budgetFields.forEach(function(costField, index) {
            var pr_value = $("#" + costField).val();

            if (pr_value) {
                var pr_budget = parseFloat(pr_value.replace(/,/g, "")) || 0;

                if (pr_budget != 0) { // Corrected comparison operator from '=' to '!='
                    var refund = pr_budget;
                    totalRefund += refund;
                }
            }
        });

        $("#task_mm_budget").val(totalRefund.toFixed(2));
    }

    $(document).ready(function() {
        budgetFields.forEach(function(costField, index) {
            $("#" + costField).on("input", calculateRefund1);
        });
    });
</script>


<script>
    var costFields = ['task_cost_it_operating', 'task_cost_it_investment', 'task_cost_gov_utility'];
    var budgetFields = ['task_budget_it_operating', 'task_budget_it_investment', 'task_budget_gov_utility'];

    function calculateRefund() {
        var totalRefund = 0;
        var totalRefund_2 = 0;

        costFields.forEach(function(costField, index) {
            var pa_value = $("#" + costField).val();
            var pr_value = $("#" + budgetFields[index]).val();

            if (pa_value && pr_value) {
                var pa_budget = parseFloat(pa_value.replace(/,/g, "")) || 0;
                var pr_budget = parseFloat(pr_value.replace(/,/g, "")) || 0;

                if (pa_budget != 0) {
                    var refund = pr_budget - pa_budget;
                    totalRefund += refund;
                }
            }
        });

        $("#task_refund_pa_budget").val(totalRefund.toFixed(2));
        $("#task_pay").val(totalRefund_2.toFixed(2));
    }

    $(document).ready(function() {
        costFields.forEach(function(costField, index) {
            $("#" + costField).on("input", calculateRefund);
        });

    });


</script>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict'
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')
        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>

    </x-slot:javascript>
</x-app-layout>
