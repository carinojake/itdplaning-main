<x-app-layout>
    <x-slot name="content">
        <div class="container-fluid">
            {{ Breadcrumbs::render('project.task.createsub', $project) }}
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
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <x-card title="{{ __('ค่าใช้จ่ายสำนักงาน 2') }}">
                            <x-slot:toolbar>
                                {{-- <a href="{{ route('contract.create') }}" class="btn btn-success text-white">C</a>

  <a href="{{ route('project.task.createsub', $project) }}" class="btn btn-primary text-white">ไปยังหน้าการใช้จ่ายของงาน</a> --}}
                            </x-slot:toolbar>
                            <form method="POST" action="{{ route('project.task.storesubno', ['project' => $project]) }}"
                                class="row needs-validation" novalidate>
                                @csrf


                                <input type="hidden" class="form-control" id="task_parent_display"
                                    value="{{ $task->task_name }}" disabled readonly>

                                <input type="hidden" class="form-control" id="task_parent" name="task_parent"
                                    value="{{ $task->task_id }}">

                                <div class="accordion" id="accordionPanelsStayOpenExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                            <button class="accordion-button" type="button"
                                                data-coreui-toggle="collapse"
                                                data-coreui-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                                aria-controls="panelsStayOpen-collapseOne">
                                                ข้อมูลงาน #1
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                                            aria-labelledby="panelsStayOpen-headingOne">
                                            <div class="accordion-body">
                                                <div class="callout callout-primary row mt-3">

                                                    <div class="col-md-3">
                                                        <label for="project_fiscal_year"
                                                            class="form-label">{{ __('ปีงบประมาณ') }}</label>
                                                        <input class="form-control" id="project_fiscal_year"
                                                            name="project_fiscal_year"
                                                            value="{{ $projectDetails->project_fiscal_year }}" disabled
                                                            readonly>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <label for="reguiar_id"
                                                            class="form-label">{{ __('ลำดับ งาน/โครงการ') }}</label>
                                                        <input class="form-control" id="reguiar_id" name="reguiar_id"
                                                            value="{{ $projectDetails->reguiar_id . '-' . $projectDetails->project_name }}"
                                                            disabled readonly>
                                                    </div>
                                                    <div class="d-none col-md-3 ">
                                                        <label for="project_type"
                                                            class="form-label">{{ __('ประเภทงาน/โครงการ') }}</label>

                                                        <div>
                                                            <input class="form-check-input" type="radio"
                                                                name="project_type" id="project_type1" value="1"
                                                                checked>
                                                            <label class="form-check-label" for="project_type1">
                                                                งานประจำ
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="project_type" id="project_type2" value="2">
                                                            <label class="form-check-label" for="project_type2">
                                                                โครงการ
                                                            </label>
                                                        </div>
                                                    </div>



                                                    <div class="col-md-3 d-none">
                                                        <label for="project_status"
                                                            class="form-label">{{ __('สถานะงาน/โครงการ') }}</label>

                                                    </div>

                                                    <div class="col-md-12 mt-3">
                                                        <div class="col-md-12">
                                                            <label for="task_name"
                                                                class="form-label">{{ __('กิจกรรม') }}</label>
                                                           {{--  <input class="form-control" id="task_name" name="task_name"
                                                                value="{{ $task->task_name }}" disabled readonly> --}}
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label for="task_description"
                                                                class="form-label">{{ __('รายละเอียดกิจกรรม') }}</label>
                                                       {{--      <input class="form-control" id="task_description"
                                                                name="task_description"
                                                                value="{{ $task->task_description }}" disabled
                                                                readonly> --}}
                                                        </div>

                                                    </div>


                                                    <div class="row mt-3">
                                                        <h4>งบประมาณที่ได้รับจัดสรร</h4>
                                                        <div class="row">
                                                            @if ($task->task_budget_it_operating > 0)
                                                                <div class="col-md-4">
                                                                    <label for="task_budget_it_operating"
                                                                        class="form-label">{{ __('งบกลาง ICT ') }}</label>
                                                                    <input type="text"
                                                                        placeholder="{{ number_format($task->task_budget_it_operating, 2) }} บาท"
                                                                        step="0.01"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                        class="form-control numeral-mask"
                                                                        id="task_budget_it_operating"
                                                                        name="task_budget_it_operating" min="0"
                                                                        disabled readonly>
                                                                </div>
                                                            @endif

                                                            @if ($task->task_budget_it_investment > 0)
                                                                <div class="col-4">
                                                                    <label for="task_budget_it_investment"
                                                                        class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                                    <input type="text"
                                                                        placeholder="{{ number_format($task->task_budget_it_investment, 2) }} บาท"
                                                                        step="0.01"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                        class="form-control numeral-mask"
                                                                        id="task_budget_it_investment"
                                                                        name="task_budget_it_investment"
                                                                        min="0" disabled readonly>
                                                                </div>
                                                            @endif

                                                            @if ($task->task_budget_gov_utility > 0)
                                                                <div class="col-md-4">
                                                                    <label for="task_budget_gov_utility"
                                                                        class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                                    <input type="text"
                                                                        placeholder=" {{ number_format($task->task_budget_gov_utility, 2) }} บาท"
                                                                        step="0.01"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                        class="form-control numeral-mask"
                                                                        id="task_budget_gov_utility"
                                                                        name="task_budget_gov_utility" min="0"
                                                                        disabled readonly>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>







                                                    <div class="d-none  col-md-4">
                                                        <label for="task_type"
                                                            class="form-label">{{ __('งาน/โครงการ') }}</label> <span
                                                            class="text-danger">*</span>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="task_type" id="task_type1" value="1">
                                                            <label class="form-check-label" for="task_type1">
                                                                มี PA
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="task_type" id="task_type2" value="2"
                                                                checked>
                                                            <label class="form-check-label" for="task_type2">
                                                                ไม่มี PA
                                                            </label>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                            <button class="accordion-button collapsed" type="button"
                                                data-coreui-toggle="collapse"
                                                data-coreui-target="#panelsStayOpen-collapseTwo" aria-expanded="false"
                                                aria-controls="panelsStayOpen-collapseTwo">
                                                ข้อมูลค่าใช้จ่าย #2
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse"
                                            aria-labelledby="panelsStayOpen-headingTwo">
                                            <div class="accordion-body">
                                                <div class="d-none col-md-3">
                                                    <label for="contract_type" class="form-label">{{ __('ประเภท') }}
                                                    </label>
                                                    {{ Form::select('contract_type', \Helper::contractType(), '4', ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...', 'id' => 'contract_type']) }}

                                                </div>


                                                <div id="mm_form">
                                                    <div class="d-none col-md-4">
                                                        <label for="task_status" class="form-label">{{ __('สถานะกิจกรรม') }}</label>

                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="task_status"
                                                                id="task_status1" value="1" checked>
                                                            <label class="form-check-label" for="task_status1">
                                                                ระหว่างดำเนินการ
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="task_status"
                                                                id="task_status2" value="2">
                                                            <label class="form-check-label" for="task_status2">
                                                                ดำเนินการแล้วเสร็จ
                                                            </label>
                                                        </div>
                                                    </div>

                                         <div class="callout callout-primary row mt-3">

                                            <div class="row">
                                                <div class="col-md-4 mt-3">
                                                    <label for="taskcon_mm"
                                                        class="form-label">{{ __('เลขที่ MM/เลขที่ สท.') }}</label>
                                                    <span class="text-danger">*</span>

                                                    <input type="text" class="form-control"
                                                        id="taskcon_mm" name="taskcon_mm" required>
                                                    <div class="invalid-feedback">
                                                        {{ __('เลขที่ MM/เลขที่ สท. ') }}
                                                    </div>
                                                </div>

                                                <div class="col-md-8 mt-3">
                                                    <label for="taskcon_mm_name"
                                                        class="form-label">{{ __('ชื่อ MM / ชื่อบันทึกข้อความ') }}</label>


                                                    <input type="text" class="form-control"
                                                        id="taskcon_mm_name" name="taskcon_mm_name">
                                                    <div class="invalid-feedback">
                                                        {{ __('ชื่อสัญญา ซ้ำ') }}
                                                    </div>
                                                </div>
                                            </div>

                                                        <div class="row mt-3">
                                                            <div class="col-md-6">
                                                                <label for="task_start_date"
                                                                    class="form-label">{{ __('วันที่เริ่มต้น') }}</label>
                                                                <span class="text-danger"></span>
                                                                <input class="form-control" id="task_start_date"
                                                                    name="task_start_date" name="task_start_date">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="task_end_date"
                                                                    class="form-label">{{ __('วันที่สิ้นสุด') }}</label>
                                                                <span class="text-danger"></span>
                                                                <input class="form-control" id="task_end_date"
                                                                    name="task_end_date" name="task_start_date">
                                                            </div>
                                                        </div>
                                         </div>
                                                        <div class="callout callout-warning">
                                                         <div class="row ">
                                            {{--            <div class="col-md-4 mt-3">
                                                                <label for="project_select"
                                                                    class="form-label">{{ __('ประเภท งบประมาณ') }}</label>


                                                                <select class="form-control" name="project_select"
                                                                    id="project_select">
                                                                    <option selected>เลือกประเภท...</option>
                                                                    <option value="task_budget_it_operating">งบกลาง ICT
                                                                    </option>
                                                                    <option value="task_budget_it_investment">
                                                                        งบดำเนินงาน</option>
                                                                    <option value="task_budget_gov_utility">
                                                                        ค่าสาธารณูปโภค</option>
                                                                </select>


                                                                <div class="invalid-feedback">
                                                                    {{ __('กิจกรรม') }}
                                                                </div>
                                                            </div> --}}

                                                            <!-- Contract Type -->
                                                            @if ($task->task_budget_it_operating > 0)
                                                            <div id="ICT" {{-- style="display:none;" --}}>

                                                                <div class="row mt-3">
                                                                  <div class="col-md-4">
                                                                        <label for="task_budget_it_operating"
                                                                            class="form-label">{{ __('วงเงินที่ขออนุมัติ งบกลาง ICT') }}</label>
                                                                        <input type="text" placeholder="0.00"
                                                                            step="0.01"
                                                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                            class="form-control numeral-mask"
                                                                            id="task_budget_it_operating"
                                                                            name="task_budget_it_operating"
                                                                            min="0"
                                                                           >

                                                                        <div class="invalid-feedback">
                                                                            {{ __('ระบุงบกลาง ICT') }}
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label for="task_cost_it_operating"
                                                                        class="form-label">{{ __('รอการเบิก งบกลาง ICT') }}</label>
                                                                        <input type="text" placeholder="0.00" step="0.01"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                         class="form-control numeral-mask" id="task_cost_it_operating"
                                                                         name="task_cost_it_operating" min="0"   >

                                                                        <div class="invalid-feedback">
                                                                        {{ __('งบกลาง ICT') }}
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif

                                                            @if ($task->task_budget_it_investment > 0)
                                                            <div id="inv" {{-- style="display:none;" --}}>
                                                                <div class="row mt-3">
                                                                  <div class="col-md-4">
                                                                        <label for="task_budget_it_investment"
                                                                            class="form-label">{{ __('วงเงินที่ขออนุมัติ งบดำเนินงาน') }}</label>
                                                                        <input type="text" placeholder="0.00"
                                                                            step="0.01"
                                                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                            class="form-control numeral-mask"
                                                                            id="task_budget_it_investment"
                                                                            name="task_budget_it_investment"
                                                                            min="0"
                                                                           >

                                                                        <div class="invalid-feedback">
                                                                            {{ __('งบดำเนินงาน') }}
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label for="task_cost_it_investment"
                                                                        class="form-label">{{ __('รอการเบิก งบดำเนินงาน') }}</label>
                                                                        <input type="text" placeholder="0.00" step="0.01"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                         class="form-control numeral-mask" id="task_cost_it_investment"
                                                                         name="task_cost_it_investment" min="0"   >

                                                                        <div class="invalid-feedback">
                                                                        {{ __('งบดำเนินงาน') }}
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            @endif

                                                            @if ($task->task_budget_gov_utility > 0)
                                                            <div id="utility" {{-- style="display:none;" --}}>
                                                                <div class="row mt-3">
                                                                  <div class="col-md-4">
                                                                        <label for="task_budget_gov_utility"
                                                                            class="form-label">{{ __('วงเงินที่ขออนุมัติ งบสาธารณูปโภค') }}</label>
                                                                        <input type="text" placeholder="0.00"
                                                                            step="0.01"
                                                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                            class="form-control numeral-mask"
                                                                            id="task_budget_gov_utility"
                                                                            name="task_budget_gov_utility"
                                                                            min="0"
                                                                           >

                                                                        <div class="invalid-feedback">
                                                                            {{ __('ค่าสาธารณูปโภค') }}
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label for="task_cost_gov_utility"
                                                                        class="form-label">{{ __('รอการเบิก งบสาธารณูปโภค') }}</label>
                                                                        <input type="text" placeholder="0.00" step="0.01"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                         class="form-control numeral-mask" id="task_cost_gov_utility"
                                                                         name="task_cost_gov_utility" min="0"   >

                                                                        <div class="invalid-feedback">
                                                                        {{ __('ค่าสาธารณูปโภค') }}
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                         </div>
                                                        </div>
                                                        @endif
                                                    </div>

                                                        {{--     @if ($task->task_budget_it_operating > 0)
                                                                <div class="col-md-3 mt-3">
                                                                    <label for="task_budget_it_operating"
                                                                        class="form-label">{{ __('วงเงินที่ขออนุมัติ ') }}</label>
                                                                    <input type="text"
                                                                        placeholder="{{ number_format($task_budget_it_operating, 2) }} บาท"
                                                                        step="0.01"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                        class="form-control numeral-mask"
                                                                        id="task_budget_it_operating"
                                                                        name="task_budget_it_operating" min="0"
                                                                        onchange="calculateRefund()">
                                                                    ไม่เกิน
                                                                    {{ number_format($task->task_budget_it_operating, 2) }}
                                                                    บาท
                                                                </div>
                                                            @endif

                                                            @if ($task->task_budget_it_investment > 0)
                                                                <div class="col-md-3 mt-3">
                                                                    <label for="task_budget_it_investment"
                                                                        class="form-label">{{ __('วงเงินที่ขออนุมีติ') }}</label>
                                                                    <input type="text"
                                                                        placeholder="{{ number_format($task->task_budget_it_investment, 2) }} บาท"
                                                                        step="0.01"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                        class="form-control numeral-mask"
                                                                        id="task_budget_it_investment"
                                                                        name="task_budget_it_investment"
                                                                        min="0" onchange="calculateRefund()">
                                                                    ไม่เกิน
                                                                    {{ number_format($task->task_budget_it_investment, 2) }}
                                                                    บาท
                                                                </div>
                                                            @endif

                                                            @if ($task->task_budget_gov_utility > 0)
                                                                <div class="col-md-3 mt-3">
                                                                    <label for="task_budget_gov_utility"
                                                                        class="form-label">{{ __('วงเงินที่ขออนุมัติ') }}</label>
                                                                    <input type="text"
                                                                        placeholder="{{ number_format($task->task_budget_gov_utility, 2) }} บาท"
                                                                        step="0.01"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                        class="form-control numeral-mask"
                                                                        id="task_budget_gov_utility"
                                                                        name="task_budget_gov_utility" min="0"
                                                                        onchange="calculateRefund()">
                                                                    ไม่เกิน
                                                                    {{ number_format($task->task_budget_gov_utility, 2) }}
                                                                    บาท
                                                                </div>
                                                            @endif
                                                        </div>
 --}}
                                                       {{--  <div class="d-none  col-md-12 mt-3">
                                                            <label for="taskcon_mm_name"
                                                                class="form-label">{{ __('ชื่อ MM / ชื่อบันทึกข้อความ 2') }}</label>


                                                            <input type="text" class="form-control"
                                                                id="taskcon_mm_name" name="taskcon_mm_name">
                                                            <div class="invalid-feedback">
                                                                {{ __('ชื่อสัญญา ซ้ำ') }}
                                                            </div>
                                                        </div> --}}




                                                       {{--  <div class="d-none col-md-4 mt-3">
                                                            <label for="taskcon_mm_budget"
                                                                class="form-label">{{ __('วงเงิน (บาท) MM') }}</label>
                                                            <span class="text-danger"></span>

                                                            <input type="text" placeholder="0.00" step="0.01"
                                                                class="form-control" id="taskcon_mm_budget"
                                                                data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                class="form-control numeral-mask"
                                                                name="taskcon_mm_budget" min="0">
                                                        </div> --}}



                                                        <div id="ba_form" {{-- style="display:none;" --}}>
                                                            <div class="row mt-3">
                                                                <div class="col-md-4">
                                                                    <label for="taskcon_ba "
                                                                        class="form-label">{{ __('ใบยืมเงินรองจ่าย (BA) ') }}</label>
                                                                    {{--  officeexpenses ค่าใช้จ่ายสำนักงาน --}}
                                                                    <span class="text-danger"></span>

                                                                    <input type="text" class="form-control"
                                                                        id="taskcon_ba" name="taskcon_ba">
                                                                    <div class="invalid-feedback">
                                                                        {{ __(' ') }}
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label for="taskcon_ba_budget"
                                                                        class="form-label">{{ __('จำนวนเงิน (บาท) BA') }}</label>
                                                                    <span class="text-danger"></span>

                                                                    <input type="text" placeholder="0.00"
                                                                        step="0.01" class="form-control"
                                                                        id="taskcon_ba_budget"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                        class="form-control numeral-mask"
                                                                        name="taskcon_ba_budget" min="0">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div id="bd_form" {{-- style="display:none; --}}>
                                                            <div class="row mt-3">
                                                                <div class="col-md-4">
                                                                    <label for="taskcon_bd "
                                                                        class="form-label">{{ __('ใบยืมเงินหน่อยงาน (BD)') }}</label>
                                                                    {{--  officeexpenses ค่าใช้จ่ายสำนักงาน --}}
                                                                    <span class="text-danger"></span>

                                                                    <input type="text" class="form-control"
                                                                        id="taskcon_bd" name="taskcon_bd">
                                                                    <div class="invalid-feedback">
                                                                        {{ __(' ') }}
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label for="taskcon_bd_budget"
                                                                        class="form-label">{{ __('จำนวนเงิน (บาท) BD') }}</label>
                                                                    <span class="text-danger"></span>

                                                                    <input type="text" placeholder="0.00"
                                                                        step="0.01" class="form-control"
                                                                        id="taskcon_bd_budget"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                        class="form-control numeral-mask"
                                                                        name="taskcon_bd_budget" min="0">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="pp_form"
                                                        class="callout callout-danger"{{--  style="display:none;" --}}>


                                                        <div class="row mt-3">
                                                            <div class="col-md-4">
                                                                <label for="taskcon_pp"
                                                                    class="form-label">{{ __('งบใบสำคัญ_PP ') }}</label>
                                                                <span class="text-danger"></span>

                                                                <input type="text" class="form-control"
                                                                    id="taskcon_pp" name="taskcon_pp">
                                                                <div class="invalid-feedback">
                                                                    {{ __(' ') }}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <label for="task_pp_name"
                                                                    class="form-label">{{ __('รายการใช้จ่าย ') }}</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" class="form-control"
                                                                    id="task_pp_name" name="task_pp_name">
                                                            </div>
                                                            {{--   <div class="d-none row mt-3">
                                                        <div class="col-md-12">
                                                            <label for="task_name" class="form-label">{{ __('รายการใช้จ่าย ') }}</label>
                                                            <span class="text-danger">*</span>
                                                            <input type="text" class="form-control" id="task_name" name="task_name"
                                                                >
                                                        </div> --}}
                                                        </div>
                                                        <div class="row mt-3">

                                                            <div class="col-md-4">
                                                                <label for="taskcon_pay_date"
                                                                    class="form-label">{{ __('วันที่เบิกจ่าย') }}</label>

                                                                <input type="text" class="form-control"
                                                                    id="taskcon_pay_date" name="taskcon_pay_date"
                                                                    required>
                                                            </div>


                                                            <div class="col-md-4">
                                                                <label for="taskcon_pay"
                                                                    class="form-label">{{ __('จำนวนเงิน (บาท) PP') }}</label>
                                                                <span class="text-danger"></span>

                                                                <input type="text" placeholder="0.00"
                                                                    step="0.01" class="form-control"
                                                                    id="task_pay"
                                                                    data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                    class="form-control numeral-mask" name="task_pay"
                                                                    min="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!--จบ ข้อมูลสัญญา 2-->
                                    </div>
                                </div>
                    </div>
                </div>
            </div>
        </div>
        {{--  <div class="accordion-item">
                                            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-coreui-toggle="collapse"
                                                    data-coreui-target="#panelsStayOpen-collapseThree"
                                                    aria-expanded="false"
                                                    aria-controls="panelsStayOpen-collapseThree">
                                                    ข้อมูลค่าใช้จ่าย #3
                                                </button>
                                            </h2>
                                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse"
                                                aria-labelledby="panelsStayOpen-headingThree">
                                                <div class="accordion-body">
                                                    <div class="d-none col-md-3">
                                                        <label for="contract_type"
                                                            class="form-label">{{ __('ประเภท') }} </label>
                                                        {{ Form::select('contract_type', \Helper::contractType(), '4', ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...', 'id' => 'contract_type']) }}

                                                    </div>


                                                    <div>



                                                        <div class="accordion-body">
                                                            <h4> ข้อมูลค่าใช้จ่าย </h4>
                                                            <div id="mm_form">


                                                                <div class="callout callout-primary row mt-3">

                                                                    <div class="col-md-12 mt-3">
                                                                        <label for="taskcon_mm_name"
                                                                            class="form-label">{{ __('ชื่อ MM / ชื่อบันทึกข้อความ') }}</label>


                                                                        <input type="text" class="form-control"
                                                                            id="taskcon_mm_name"
                                                                            name="taskcon_mm_name" required>
                                                                        <div class="invalid-feedback">
                                                                            {{ __('ชื่อสัญญา ซ้ำ') }}
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-md-4 mt-3">
                                                                        <label for="taskcon_mm"
                                                                            class="form-label">{{ __('เลขที่ MM/เลขที่ สท.') }}</label>
                                                                        <span class="text-danger"></span>

                                                                        <input type="text" class="form-control"
                                                                            id="taskcon_mm" name="taskcon_mm">
                                                                        <div class="invalid-feedback">
                                                                            {{ __(' ') }}
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-md-4 mt-3">
                                                                        <label for="taskcon_mm_budget"
                                                                            class="form-label">{{ __('วงเงิน (บาท) MM') }}</label>
                                                                        <span class="text-danger"></span>

                                                                        <input type="text" placeholder="0.00"
                                                                            step="0.01" class="form-control"
                                                                            id="taskcon_mm_budget"
                                                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                            class="form-control numeral-mask"
                                                                            name="taskcon_mm_budget" min="0">
                                                                    </div>



                                                                    <div id="ba_form" >
                                                                        <div class="row mt-3">
                                                                            <div class="col-md-4">
                                                                                <label for="taskcon_ba "
                                                                                    class="form-label">{{ __('ใบยืมเงินรองจ่าย (BA) ') }}</label>

                                                                                <span class="text-danger"></span>

                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    id="taskcon_ba" name="taskcon_ba">
                                                                                <div class="invalid-feedback">
                                                                                    {{ __(' ') }}
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-4">
                                                                                <label for="taskcon_ba_budget"
                                                                                    class="form-label">{{ __('จำนวนเงิน (บาท) BA') }}</label>
                                                                                <span class="text-danger"></span>

                                                                                <input type="text"
                                                                                    placeholder="0.00" step="0.01"
                                                                                    class="form-control"
                                                                                    id="taskcon_ba_budget"
                                                                                    data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                                    class="form-control numeral-mask"
                                                                                    name="taskcon_ba_budget"
                                                                                    min="0">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div id="bd_form" >
                                                                        <div class="row mt-3">
                                                                            <div class="col-md-4">
                                                                                <label for="taskcon_bd "
                                                                                    class="form-label">{{ __('ใบยืมเงินหน่อยงาน (BD)') }}</label>

                                                                                <span class="text-danger"></span>

                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    id="taskcon_bd" name="taskcon_bd">
                                                                                <div class="invalid-feedback">
                                                                                    {{ __(' ') }}
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-4">
                                                                                <label for="contract_bd_budget"
                                                                                    class="form-label">{{ __('จำนวนเงิน (บาท) BD') }}</label>
                                                                                <span class="text-danger"></span>

                                                                                <input type="text"
                                                                                    placeholder="0.00" step="0.01"
                                                                                    class="form-control"
                                                                                    id="taskcon_bd_budget"
                                                                                    data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                                    class="form-control numeral-mask"
                                                                                    name="taskcon_bd_budget"
                                                                                    min="0">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="pp_form"
                                                                    class="callout callout-danger">



                                                                    <div class="row mt-3">
                                                                        <div class="col-md-4">
                                                                            <label for="contract_pay"
                                                                                class="form-label">{{ __('งบใบสำคัญ_PP ') }}</label>
                                                                            <span class="text-danger"></span>

                                                                            <input type="text" class="form-control"
                                                                                id="taskcon_pp" name="taskcon_cn">
                                                                            <div class="invalid-feedback">
                                                                                {{ __(' ') }}
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                            <label for="taskcon_pay"
                                                                                class="form-label">{{ __('จำนวนเงิน (บาท) PP') }}</label>


                                                                            <input type="text" placeholder="0.00"
                                                                                step="0.01" class="form-control"
                                                                                id="taskcon_pay"
                                                                                data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                                class="form-control numeral-mask"
                                                                                name="taskcon_pay" min="0">
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mt-3">
                                                                        <div class="col-md-4">
                                                                            <label for="taskcon_pay_date"
                                                                                class="form-label">{{ __('วันที่เบิกจ่าย') }}</label>

                                                                            <input type="text" class="form-control"
                                                                                id="taskcon_pay_date"
                                                                                name="taskcon_pay_date">
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
        {{--           <div class="col-md-6">
                                            <label for="contract_refund_pa_budget" class="form-label">{{ __('จำนวนคงเหลือหลังเงิน PA') }}</label> <span class="text-danger"></span>
                                            <input type="number" placeholder="0.00" step="0.01" class="form-control" id="contract_refund_pa_budget" name="contract_refund_pa_budget" min="0" readonly>
                                          </div>
                                    </div> --}}

        <x-button class="btn-success" type="submit">{{ __('coreuiforms.save') }}
        </x-button>
        <x-button link="{{ route('project.show', $project) }}" class="text-black btn-light">
            {{ __('coreuiforms.return') }}</x-button>

        </form>
        </x-card>

        </x-slot:content>
        <x-slot:css>

        </x-slot:css>
        <x-slot:javascript>

            <!-- Add the necessary CSS and JS files for Select2 -->

            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

            <script>
                $(document).ready(function() {
                    // When any of the budget fields change, recalculate the refund
                    // $('#task_budget_it_operating, #task_budget_it_investment, #task_budget_gov_utility').change(calculateRefund);

                    function calculateRefund() {
                        var task_budget_it_operating = parseFloat($('#task_budget_it_operating').val()) || 0;
                        var task_budget_it_investment = parseFloat($('#task_budget_it_investment').val()) || 0;
                        var task_budget_gov_utility = parseFloat($('#task_budget_gov_utility').val()) || 0;
                        var refund = task_budget_it_operating + task_budget_it_investment + task_budget_gov_utility;

                        document.getElementById("contract_refund_pa_budget").value = refund.toFixed(2);
                    }
                });
            </script>

<script>
    $(document).ready(function() {
$('#project_select').change(function() {
// ซ่อนทุกฟิลด์ก่อน
$('#ICT').hide();
$('#inv').hide();
$('#utility').hide();

// แสดงฟิลด์ที่เกี่ยวข้องตามประเภทงบประมาณที่เลือก
if ($(this).val() == 'task_budget_it_operating') {
$('#ICT').show();
} else if ($(this).val() == 'task_budget_it_investment') {
$('#inv').show();
} else if ($(this).val() == 'task_budget_gov_utility') {
$('#utility').show();
}
});
});
</script>
            <script>
                $(document).ready(function() {
                    $('#project_select').change(function() {
                        // ซ่อนทุกฟิลด์ก่อน
                        $('#task_budget_it_operating').parent().hide();
                        $('#task_budget_it_investment').parent().hide();
                        $('#task_budget_gov_utility').parent().hide();

                        // แสดงฟิลด์ที่เกี่ยวข้องตามประเภทงบประมาณที่เลือก
                        if ($(this).val() == 'task_budget_it_operating') {
                            $('#task_budget_it_operating').parent().show();
                        } else if ($(this).val() == 'task_budget_it_investment') {
                            $('#task_budget_it_investment').parent().show();
                        } else if ($(this).val() == 'task_budget_gov_utility') {
                            $('#task_budget_gov_utility').parent().show();
                        }
                    });
                });
            </script>


          {{--   <script>
                // Example starter JavaScript for disabling form submissions if there are invalid fields
                (function() {
                    'use strict'

                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.querySelectorAll('.needs-validation')

                    // Loop over them and prevent submission
                    Array.prototype.slice.call(forms)
                        .forEach(function(form) {
                            form.addEventListener('submit', function(event) {
                                if (!form.checkValidity()) {
                                    event.preventDefault()
                                    event.stopPropagation()
                                }

                                form.classList.add('was-validated')
                            }, false)
                        })
                })()
            </script> --}}
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
                    $('#rounds').change(function() {
                        var rounds = $(this).val();
                        $('#tasksContainer').empty(); // clear the container
                        for (var i = 0; i < rounds; i++) {
                            $('#tasksContainer').append(`
                        <div class="row mt-3">
                            <div class="col-md-12">

                                    <label>ชื่อ ` + (i + 1) + ` &nbsp: &nbsp</label><input type="text" name="tasks[` +
                                i +
                                `][task_name]" value=" ` + (i + 1) + `"required>
                                </div>
                            </div>
                        </div>
                    `);
                        }
                    });
                });
            </script>


            {{-- <script>
            $(document).ready(function() {
                $('#contract_type').change(function() {
                    var contract_type = $(this).val();
                    var contract_name_label = $('#contract_name_label');
                    var rounds_form = $('#rounds_form');
                    var rounds_label = $('#rounds_label');



                    if (contract_type == 1) {
                        contract_name_label.text('ชื่อ PO');
                        rounds_label.text('จำนวนงวด');
                        $('#mm_form').show();
                        $('#pr_form').show();
                        $('#pa_form').show();
                        $('#po_form').show();
                        $('#er_form').hide();
                        $('#cn_form').show();
                        $('#oe_form').hide();
                        $('#pp_form').hide();
                        $('#rounds_form').show();
                    } else if (contract_type == 2) {
                        contract_name_label.text('ชื่อ ER');
                        rounds_label.text('จำนวนงวด');
                        $('#mm_form').show();
                        $('#pr_form').show();
                        $('#pa_form').show();
                        $('#po_form').hide();
                        $('#er_form').show();
                        $('#cn_form').show();
                        $('#oe_form').hide();
                        $('#pp_form').hide();
                        $('#rounds_form').show();
                    } else if (contract_type == 3) {
                        contract_name_label.text('ชื่อ CN');
                        rounds_label.text('จำนวนงวด');
                        $('#mm_form').show();
                        $('#pr_form').show();
                        $('#pa_form').show();
                        $('#po_form').show();
                        $('#er_form').hide();
                        $('#cn_form').show();
                        $('#oe_form').hide();
                        $('#pp_form').hide();
                        $('#rounds_form').show();
                    } else if (contract_type == 4) {
                        contract_name_label.text('ชื่อ ค่าใช้จ่ายสำนักงาน');
                        rounds_label.text('ค่าใช้จ่ายสำนักงาน');
                        $('#mm_form').show();
                        $('#pr_form').hide();
                        $('#pa_form').hide();
                        $('#po_form').hide();
                        $('#er_form').hide();
                        $('#cn_form').hide();
                        $('#oe_form').show();
                        $('#pp_form').show();
                        $('#ba_form').show();
                        $('#bd_form').show();
                        $('#rounds_form').show();
                    } else {
                        contract_name_label.text('ชื่อ PO/ER/CN/ค่าใช้จ่ายสำนักงาน');
                        $('#mm_form').show();
                        $('#pr_form').show();
                        $('#pa_form').show();
                        $('#po_form').show();
                        $('#er_form').show();
                        $('#cn_form').show();
                        $('#oe_form').show();
                        $('#pp_form').show();
                        $('#ba_form').show();
                        $('#bd_form').show();
                        $('#rounds_form').show();
                    }
                });
            });
        </script> --}}


            <!--<script>
                function formatDate(date) {
                    var parts = date.split("/");
                    return parts[1] + "/" + parts[0] + "/" + parts[2];
                }

                $(document).ready(function() {
                    $("#insurance_start_date, #insurance_end_date").change(function() {
                        var start = new Date(formatDate($("#insurance_start_date").val()));
                        var end = new Date(formatDate($("#insurance_end_date").val()));

                        // Calculate the difference in milliseconds
                        var diff = Math.abs(end - start);

                        // Calculate days
                        var days = Math.floor(diff / (1000 * 60 * 60 * 24));

                        // Calculate months
                        var months = Math.floor(diff / (1000 * 60 * 60 * 24 * 30.436875));

                        // Display result
                        $("#insurance_duration_months").text(months + " เดือน");
                        $("#insurance_duration_days").text(days + " วัน");
                    });
                });
            </script> -->

            <script>
                $(function() {
                    if (typeof jQuery == 'undefined' || typeof jQuery.ui == 'undefined') {
                        alert("jQuery or jQuery UI is not loaded");
                        return;
                    }

                    var d = new Date();
                    var toDay = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 543);

                    $("#taskcon_pay_date,#project_start_date,#project_end_date, #contract_end_date, #insurance_start_date, #insurance_end_date,#contract_er_start_date,#contract_po_start_date")
                        .datepicker({
                            dateFormat: 'dd/mm/yy',
                            changeMonth: true,
                            changeYear: true,
                            isBuddhist: true,
                            defaultDate: toDay,
                            dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
                            dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
                            monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม',
                                'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
                            ],
                            monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.',
                                'ต.ค.', 'พ.ย.', 'ธ.ค.'
                            ],

                            onSelect: calculateDuration
                        });
                });
            </script>
            <script>
                function calculateDuration() {
                    var startDate = $('#insurance_start_date').datepicker('getDate');
                    var endDate = $('#insurance_end_date').datepicker('getDate');
                    if (startDate && endDate) {
                        var diff = Math.abs(endDate - startDate);
                        var days = Math.floor(diff / (1000 * 60 * 60 * 24));
                        var months = Math.floor(diff / (1000 * 60 * 60 * 24 * 30.436875));
                        $('#insurance_duration_months').text(months + " เดือน");
                        $('#insurance_duration_days').text(days + " วัน");
                    }
                }

                $(document).ready(function() {
                    $('#insurance_start_date, #insurance_end_date').datepicker({

                        dateFormat: "dd/mm/yy",


                        onSelect: calculateDuration
                    });
                });
            </script>

            <script>
                $(document).ready(function() {
                    $(":input").inputmask();
                });
            </script>



        </x-slot:javascript>
</x-app-layout>
