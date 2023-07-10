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
                        <x-card title="{{ __('ค่าใช้จ่ายสำนักงาน 1') }}">
                            <x-slot:toolbar>
                                {{-- <a href="{{ route('contract.create') }}" class="btn btn-success text-white">C</a>

  <a href="{{ route('project.task.createsub', $project) }}" class="btn btn-primary text-white">ไปยังหน้าการใช้จ่ายของงาน</a> --}}
                            </x-slot:toolbar>
                            <form method="POST" action="{{ route('project.task.storesubno', ['project' => $project]) }}"
                                class="row needs-validation" novalidate>
                                @csrf




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
                                                        <span class="text-danger">*</span>
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



                                                    <div class="col-md-3">
                                                        <label for="project_status"
                                                            class="form-label">{{ __('สถานะงาน/โครงการ') }}</label>
                                                        <!-- Here, you would need to fetch the actual status from $projectDetails -->
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-md-6">
                                                            <label for="task_start_date2"
                                                                class="form-label">{{ __('วันที่เริ่มต้น') }}</label>
                                                            <span class="text-danger">*</span>
                                                            <input class="form-control" id="task_start_date2"
                                                                name="task_start_date2" name="task_start_date2"
                                                                value={{ Helper::Date4(date('Y-m-d H:i:s', $projectDetails->project_start_date)) }}
                                                                disabled readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="task_end_date2"
                                                                class="form-label">{{ __('วันที่สิ้นสุด') }}</label>
                                                            <span class="text-danger">*</span>
                                                            <input class="form-control" id="task_end_date2"
                                                                name="task_end_date2" name="task_start_date2"
                                                                value={{ Helper::Date4(date('Y-m-d H:i:s', $projectDetails->project_end_date)) }}
                                                                disabled readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 mt-3">


                                                        <div class="col-md-12">
                                                            <label for="project_description"
                                                                class="form-label">{{ __('รายละเอียดโครงการ') }}</label>
                                                            <textarea class="form-control" id="project_description" name="project_description" disabled readonly>{{ $projectDetails->project_description }}</textarea>
                                                        </div>

                                                    </div>


                                                    <div class="row mt-3">
                                                        <h4>งบประมาณที่ได้รับจัดสรร</h4>
                                                        <div class="row">
                                                            @if ($projectDetails->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating > 0)
                                                                <div class="col-md-4">
                                                                    <label for="budget_it_operating"
                                                                        class="form-label">{{ __('งบกลาง ICT ') }}</label>
                                                                    <input type="text"
                                                                        placeholder="{{ number_format($projectDetails->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating, 2) }} บาท"
                                                                        step="0.01"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                        class="form-control numeral-mask"
                                                                        id="budget_it_operating"
                                                                        name="budget_it_operating" min="0"
                                                                        disabled readonly>
                                                                </div>
                                                            @endif

                                                            @if ($projectDetails->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment > 0)
                                                                <div class="col-4">
                                                                    <label for="budget_it_investment"
                                                                        class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                                    <input type="text"
                                                                        placeholder="{{ number_format($projectDetails->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment, 2) }} บาท"
                                                                        step="0.01"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                        class="form-control numeral-mask"
                                                                        id="budget_it_investment"
                                                                        name="budget_it_investment" min="0"
                                                                        disabled readonly>
                                                                </div>
                                                            @endif

                                                            @if ($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility > 0)
                                                                <div class="col-md-4">
                                                                    <label for="budget_gov_utility"
                                                                        class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                                    <input type="text"
                                                                        placeholder="{{ number_format($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility, 2) }} บาท"
                                                                        step="0.01"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                        class="form-control numeral-mask"
                                                                        id="budget_gov_utility"
                                                                        name="budget_gov_utility" min="0"
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



                                                <div id="mm_form">

                                                    <div class="d-none col-md-4">
                                                        <label for="task_status"
                                                            class="form-label">{{ __('สถานะกิจกรรม') }}</label>

                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="task_status" id="task_status1" value="1"
                                                                checked>
                                                            <label class="form-check-label" for="task_status1">
                                                                ระหว่างดำเนินการ
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="task_status" id="task_status2" value="2">
                                                            <label class="form-check-label" for="task_status2">
                                                                ดำเนินการแล้วเสร็จ
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="callout callout-primary row mt-3">
                                                        <div class="row">
                                                            <div class="col-md-4 mt-3">
                                                                <label for="task_mm"
                                                                    class="form-label">{{ __('เลขที่ MM/เลขที่ สท.') }}</label>
                                                                <span class="text-danger">*</span>

                                                                <input type="text" class="form-control"
                                                                    id="task_mm" name="task_mm" required>
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
                                                                <span class="text-danger">*</span>
                                                                <input class="form-control" id="task_start_date"
                                                                    name="task_start_date" name="task_start_date">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="task_end_date"
                                                                    class="form-label">{{ __('วันที่สิ้นสุด') }}</label>
                                                                <span class="text-danger">*</span>
                                                                <input class="form-control" id="task_end_date"
                                                                    name="task_end_date" name="task_start_date">
                                                            </div>
                                                        </div>
                                                        <div class="d-none col-md-4 mt-3">
                                                            <label for="task_mm_budget"
                                                                class="form-label">{{ __('วงเงิน (บาท) MM') }}</label>
                                                            <span class="text-danger"></span>

                                                            <input type="text" placeholder="0.00" step="0.01"
                                                                class="form-control" id="task_mm_budget"
                                                                data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                class="form-control numeral-mask"
                                                                name="task_mm_budget" min="0">
                                                        </div>
                                                    </div>
                                                    <div class="callout callout-warning">
                                                        <div class="row ">
                                                            <div class="col-md-4 mt-3">
                                                                <label for="project_select"
                                                                    class="form-label">{{ __('ประเภท งบประมาณ') }}</label>
                                                                <span class="text-danger">*</span>
                                                                <select class="form-control" name="project_select"
                                                                    id="project_select" required>
                                                                    <option selected disabled value="">
                                                                        เลือกประเภท...</option>
                                                                    @if ($projectDetails->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating > 0)
                                                                        <option value="task_budget_it_operating">งบกลาง
                                                                            ICT</option>
                                                                    @endif
                                                                    @if ($projectDetails->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment > 0)
                                                                        <option value="task_budget_it_investment">
                                                                            งบดำเนินงาน</option>
                                                                    @endif
                                                                    @if ($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility > 0)
                                                                        <option value="task_budget_gov_utility">
                                                                            ค่าสาธารณูปโภค</option>
                                                                    @endif
                                                                </select>
                                                            </div>

                                                            {{--    <div class="project_select">
                                                                    {{ __('ประเภท งบประมาณ') }}
                                                                </div> --}}
                                                        </div>
                                                        <!-- Contract Type -->

                                                        @if ($projectDetails->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating > 0)
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
                                                                            min="0">

                                                                        <div class="invalid-feedback">
                                                                            {{ __('ระบุงบกลาง ICT') }}
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label for="task_cost_it_operating"
                                                                            class="form-label">{{ __('รอการเบิก งบกลาง ICT ( ยอด pa / ไม่ pa )') }}</label>
                                                                        <input type="text" placeholder="0.00"
                                                                            step="0.01"
                                                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                            class="form-control numeral-mask"
                                                                            id="task_cost_it_operating"
                                                                            name="task_cost_it_operating"
                                                                            min="0"
                                                                            onchange="calculateRefund()">

                                                                        <div class="invalid-feedback">
                                                                            {{ __('งบกลาง ICT') }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if ($projectDetails->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment > 0)
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
                                                                            onchange="calculateRefund()">

                                                                        <div class="invalid-feedback">
                                                                            {{ __('งบดำเนินงาน') }}
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label for="task_cost_it_investment"
                                                                            class="form-label">{{ __('รอการเบิก งบดำเนินงาน ( ยอด pa /ไม่ pa )') }}</label>
                                                                        <input type="text" placeholder="0.00"
                                                                            step="0.01"
                                                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                            class="form-control numeral-mask"
                                                                            id="task_cost_it_investment"
                                                                            name="task_cost_it_investment"
                                                                            min="0"
                                                                            onchange="calculateRefund()">

                                                                        <div class="invalid-feedback">
                                                                            {{ __('งบดำเนินงาน') }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if ($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility > 0)
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
                                                                            onchange="calculateRefund()">

                                                                        <div class="invalid-feedback">
                                                                            {{ __('ค่าสาธารณูปโภค') }}
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label for="task_cost_gov_utility"
                                                                            class="form-label">{{ __('รอการเบิก งบสาธารณูปโภค (ยอด pa / ไม่ pa )') }}</label>
                                                                        <input type="text" placeholder="0.00"
                                                                            step="0.01"
                                                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                            class="form-control numeral-mask"
                                                                            id="task_cost_gov_utility"
                                                                            name="task_cost_gov_utility"
                                                                            min="0"
                                                                            onchange="calculateRefund()">

                                                                        <div class="invalid-feedback">
                                                                            {{ __('ค่าสาธารณูปโภค') }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div id="utility" {{-- style="display:none;" --}}>
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
                                                                        name="task_refund_pa_budget" min="0">

                                                                    {{--  <div class="invalid-feedback">
                                                                            {{ __('ค่าสาธารณูปโภค') }}
                                                                        </div> --}}
                                                                </div>


                                                            </div>
                                                        </div>


                                                        {{--
                                                         <div class="row mt-3">
                                                            <div class="col-md-3">
                                                                <label for="task_refund_pa_budget" class="form-label">{{ __('จำนวนคงเหลือหลังเงิน PA') }}</label> <span class="text-danger"></span>
                                                                <input type="number" placeholder="0.00" step="0.01" class="form-control" id="task_refund_pa_budget" name="task_refund_pa_budget" min="0" value="{{ $task->task_refund_pa_budget }}" >
                                                              </div>
                                                            </div> --}}

                                                    </div>



                                                </div>
                                                {{--


                                                            @if ($projectDetails->budget_it_operating - $sum_task_budget_it_operating > 0)
                                                                <div class="col-md-3 mt-3">
                                                                    <label for="task_budget_it_operating"
                                                                        class="form-label">{{ __('วงเงินที่ขออนุมัติ ') }}</label>
                                                                    <input type="text"
                                                                        placeholder="{{ number_format($projectDetails->budget_it_operating - $sum_task_budget_it_operating, 2) }} บาท"
                                                                        step="0.01"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                        class="form-control numeral-mask"
                                                                        id="task_budget_it_operating"
                                                                        name="task_budget_it_operating"
                                                                        min="0">
                                                                    ไม่เกิน
                                                                    {{ number_format($projectDetails->budget_it_operating - $sum_task_budget_it_operating, 2) }}
                                                                    บาท
                                                                </div>
                                                            @endif

                                                            @if ($projectDetails->budget_it_investment - $sum_task_budget_it_investment > 0)
                                                                <div class="col-md-3 mt-3">
                                                                    <label for="task_budget_it_investment"
                                                                        class="form-label">{{ __('วงเงินที่ขออนุมีติ') }}</label>
                                                                    <input type="text"
                                                                        placeholder="{{ number_format($projectDetails->budget_it_investment - $sum_task_budget_it_investment, 2) }} บาท"
                                                                        step="0.01"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                        class="form-control numeral-mask"
                                                                        id="task_budget_it_investment"
                                                                        name="task_budget_it_investment"
                                                                        min="0">
                                                                    ไม่เกิน
                                                                    {{ number_format($projectDetails->budget_it_investment - $sum_task_budget_it_investment, 2) }}
                                                                    บาท
                                                                </div>
                                                            @endif

                                                            @if ($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility > 0)
                                                                <div class="col-md-3 mt-3">
                                                                    <label for="task_budget_gov_utility"
                                                                        class="form-label">{{ __('วงเงินที่ขออนุมัติ') }}</label>
                                                                    <input type="text"
                                                                        placeholder="{{ number_format($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility, 2) }} บาท"
                                                                        step="0.01"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                        class="form-control numeral-mask"
                                                                        id="task_budget_gov_utility"
                                                                        name="task_budget_gov_utility" min="0">
                                                                    ไม่เกิน
                                                                    {{ number_format($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility, 2) }}
                                                                    บาท
                                                                </div>
                                                            @endif
                                                        </div>
 --}}


                                                {{--                      <div class="d-none col-md-4 mt-3">
                                                            <label for="taskcon_mm"
                                                                class="form-label">{{ __('เลขที่ MM/เลขที่ สท.') }}</label>
                                                            <span class="text-danger"></span>

                                                            <input type="text" class="form-control"
                                                                id="taskcon_mm" name="taskcon_mm">
                                                            <div class="invalid-feedback">
                                                                {{ __(' ') }}
                                                            </div>
                                                        </div> --}}


                                                {{--           <div class="col-md-4 mt-3">
                                                            <label for="taskcon_mm_budget"
                                                                class="form-label">{{ __('วงเงิน (บาท) MM') }}</label>
                                                            <span class="text-danger"></span>

                                                            <input type="text" placeholder="0.00" step="0.01"
                                                                class="form-control" id="taskcon_mm_budget"
                                                                data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                class="form-control numeral-mask"
                                                                name="taskcon_mm_budget" min="0">
                                                        </div>    </div> --}}

                                                <div class="callout callout-light">
                                                    <div id="ba_form" {{-- style="display:none;" --}}>
                                                        <div class="d-none row mt-3">
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
                                                        <div class="d-none row mt-3">
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
                                                                <label for="contract_bd_budget"
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

                                                    <div class=" col-md-12 mt-3">
                                                        <label for="task_description"
                                                            class="form-label">{{ __('หมายเหตุ') }}</label>
                                                        <textarea class="form-control" name="task_description" id="task_description" rows="5"></textarea>
                                                        <div class="invalid-feedback">
                                                            {{ __('รายละเอียดกิจกรรม') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--

                                            <div class=" d-none callout callout-info row mt-3">
                                                <div class="d-none row mt-3">
                                                    <div class="col-md-12">
                                                        <label for="task_name" class="form-label">{{ __('รายการใช้จ่าย ') }}</label>
                                                        <span class="text-danger">*</span>
                                                        <input type="text" class="form-control" id="task_name" name="task_name"
                                                           >
                                                    </div>
                                                </div> --}}


                                            <div class=" row mt-3">
                                                <div class="d-none col-md-4">
                                                    <label for="task_status"
                                                        class="form-label">{{ __('สถานะกิจกรรม') }}</label>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="task_status" id="task_status1" value="1"
                                                            checked>
                                                        <label class="form-check-label" for="task_status1">
                                                            ระหว่างดำเนินการ
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="task_status" id="task_status2" value="2">
                                                        <label class="form-check-label" for="task_status2">
                                                            ดำเนินการแล้วเสร็จ
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--     <div class=" col-md-12 mt-3">
                                                        <label for="task_description"
                                                            class="form-label">{{ __('หมายเหตุ') }}</label>
                                                        <textarea class="form-control" name="task_description" id="task_description" rows="10"></textarea>
                                                        <div class="invalid-feedback">
                                                            {{ __('รายละเอียดกิจกรรม') }}
                                                        </div>
                                                    </div> --}}
                                            {{--   <div class="row mt-3">
                                                        <h4>งบประมาณ c</h4>
                                                        <div class="row">
                                                            @if ($projectDetails->budget_it_operating - $sum_task_budget_it_operating > 0)
                                                                <div class="col-md-4">
                                                                    <label for="task_budget_it_operating"
                                                                        class="form-label">{{ __('งบกลาง ICT ') }}</label>
                                                                    <input type="text"
                                                                        placeholder="{{ number_format($projectDetails->budget_it_operating - $sum_task_budget_it_operating, 2) }} บาท"
                                                                        step="0.01"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                        class="form-control numeral-mask" id="task_budget_it_operating"
                                                                        name="task_budget_it_operating" min="0">
                                                                      ไม่เกิน   {{ number_format($projectDetails->budget_it_operating - $sum_task_budget_it_operating, 2) }} บาท
                                                                </div>
                                                            @endif

                                                            @if ($projectDetails->budget_it_investment - $sum_task_budget_it_investment > 0)
                                                                <div class="col-4">
                                                                    <label for="task_budget_it_investment"
                                                                        class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                                    <input type="text"
                                                                        placeholder="{{ number_format($projectDetails->budget_it_investment -$sum_task_budget_it_investment, 2) }} บาท"
                                                                        step="0.01"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                        class="form-control numeral-mask" id="task_budget_it_investment"
                                                                        name="task_budget_it_investment" min="0" >
                                                                        ไม่เกิน   {{ number_format($projectDetails->budget_it_investment -$sum_task_budget_it_investment, 2) }} บาท
                                                                </div>
                                                            @endif

                                                            @if ($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility > 0)
                                                                <div class="col-md-4">
                                                                    <label for="task_budget_gov_utility"
                                                                        class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                                    <input type="text"
                                                                        placeholder="{{ number_format($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility, 2) }} บาท"
                                                                        step="0.01"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                        class="form-control numeral-mask" id="task_budget_gov_utility"
                                                                        name="task_budget_gov_utility" min="0">
                                                                        ไม่เกิน {{ number_format($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility, 2) }} บสท
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>  --}}

                                            <div class="d-none col-md-3">
                                                <label for="contract_type" class="form-label">{{ __('ประเภท') }}
                                                </label>
                                                {{ Form::select('contract_type', \Helper::contractType(), '4', ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...', 'id' => 'contract_type']) }}

                                            </div>

                                            <div>
                                                <div id="pp_form"
                                                    class="callout callout-danger"{{--  style="display:none;" --}}>


                                                    <div class="row mt-3">
                                                        <div class="col-md-4">
                                                            <label for="taskcon_pp"
                                                                class="form-label">{{ __('งบใบสำคัญ_PP ') }}</label>
                                                            {{-- <span class="text-danger">*</span> --}}

                                                            <input type="text" class="form-control"
                                                                id="taskcon_pp" name="taskcon_pp"
                                                                >
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
                                                                   >
                                                            <div class="invalid-feedback">
                                                                {{ __(' กรอกรายการใช้จ่าย') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">

                                                        <div class="col-md-4">
                                                            <label for="task_pay_date"
                                                                class="form-label">{{ __('วันที่เบิกจ่าย') }}</label>
                                                         {{--    <span class="text-danger">*</span> --}}
                                                            <input  class="form-control"
                                                                id="task_pay_date"
                                                                name="task_pay_date"  >


                                                        </div>


                                                        <div  id="task_pay_d" class="col-md-4">
                                                            <label for="task_pay"
                                                                class="form-label">{{ __('จำนวนเงิน (บาท) PP') }}</label>
                                                           {{--  <span class="text-danger">*</span> --}}

                                                            <input type="text" placeholder="0.00"
                                                                step="0.01" class="form-control"
                                                                id="task_pay"
                                                                data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                class="form-control numeral-mask"
                                                                name="task_pay" min="0"
                                                                >
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                        <!--จบ ข้อมูลสัญญา 2-->
                                    </div>
                                </div>


                                {{--     <div class="accordion-item">
                                      <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                        <button class="accordion-button collapsed" type="button" data-coreui-toggle="collapse" data-coreui-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                            ข้อมูลค่าใช้จ่าย #3
                                        </button>
                                      </h2>
                                      <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                                        <div class="accordion-body">
                                            <div class="d-none col-md-3">
                                                <label for="contract_type" class="form-label">{{ __('ประเภท') }} </label>
                                                {{ Form::select('contract_type', \Helper::contractType(), '4', ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...', 'id' => 'contract_type']) }}

                                            </div>


                                            <div>

                                                <div>

                                                    <div class="accordion-body">
                                                        <h4> ข้อมูลค่าใช้จ่าย </h4>
                                                        <div id="mm_form">


                                                            <div class="callout callout-primary row mt-3">

                                                                <div class="col-md-12 mt-3">
                                                                    <label for="taskcon_mm_name"
                                                                        class="form-label">{{ __('ชื่อ MM / ชื่อบันทึกข้อความ') }}</label>


                                                                    <input type="text" class="form-control"
                                                                        id="taskcon_mm_name" name="taskcon_mm_name">
                                                                    <div class="invalid-feedback">
                                                                        {{ __('ชื่อสัญญา ซ้ำ') }}
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-4 mt-3">
                                                                    <label for="taskcon_mm"
                                                                        class="form-label">{{ __('เลขที่ MM/เลขที่ สท.') }}</label>
                                                                    <span class="text-danger"></span>

                                                                    <input type="text" class="form-control" id="taskcon_mm"
                                                                        name="taskcon_mm">
                                                                    <div class="invalid-feedback">
                                                                        {{ __(' ') }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 mt-3">
                                                                    <label for="taskcon_mm_budget"
                                                                        class="form-label">{{ __('วงเงิน (บาท) MM') }}</label>
                                                                    <span class="text-danger"></span>

                                                                    <input type="text" placeholder="0.00" step="0.01"
                                                                        class="form-control" id="taskcon_mm_budget"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                        class="form-control numeral-mask" name="taskcon_mm_budget"
                                                                        min="0">
                                                                </div>



                                                                <div id="ba_form" >
                                                                    <div class="row mt-3">
                                                                        <div class="col-md-4">
                                                                            <label for="taskcon_ba "
                                                                                class="form-label">{{ __('ใบยืมเงินรองจ่าย (BA) ') }}</label>

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

                                                                <div id="bd_form" >
                                                                    <div class="row mt-3">
                                                                        <div class="col-md-4">
                                                                            <label for="taskcon_bd "
                                                                                class="form-label">{{ __('ใบยืมเงินหน่อยงาน (BD)') }}</label>

                                                                            <span class="text-danger"></span>

                                                                            <input type="text" class="form-control"
                                                                                id="taskcon_bd" name="taskcon_bd">
                                                                            <div class="invalid-feedback">
                                                                                {{ __(' ') }}
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                            <label for="contract_bd_budget"
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
                                                                        <span class="text-danger"></span>

                                                                        <input type="text" placeholder="0.00" step="0.01"
                                                                            class="form-control" id="taskcon_pay"
                                                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                            class="form-control numeral-mask" name="taskcon_pay"
                                                                            min="0">
                                                                    </div>
                                                                </div>

                                                                <div class="row mt-3">
                                                                    <div class="col-md-4">
                                                                        <label for="taskcon_pay_date"
                                                                            class="form-label">{{ __('วันที่เบิกจ่าย') }}</label>
                                                                        <span class="text-danger">*</span>
                                                                        <input type="text" class="form-control"
                                                                            id="taskcon_pay_date" name="taskcon_pay_date"
                                                                            required>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div> --}}
                                {{--      <div class="col-md-6">
                                    <label for="contract_refund_pa_budget" class="form-label">{{ __('จำนวนคงเหลือหลังเงิน PA') }}</label> <span class="text-danger"></span>

                                     <input type="text"
                                     placeholder="{{ number_format($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility, 2) }} บาท"
                                     step="0.01"
                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                     class="form-control numeral-mask"
                                     id="contract_refund_pa_budget"
                                     name="contract_refund_pa_budget" min="0">
                                  </div>
 --}}



                                <x-button class="btn-success" type="submit">{{ __('coreuiforms.save') }}
                                </x-button>
                                <x-button link="{{ route('project.show', $project) }}" class="text-black btn-light">
                                    {{ __('coreuiforms.return') }}</x-button>
                            </form>
                        </x-card>
                    </div>
                </div>
            </div>
        </div>
        </x-slot:content>
        <x-slot:css>

        </x-slot:css>
        <x-slot:javascript>

            <!-- Add the necessary CSS and JS files for Select2 -->

            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


          {{--   <script>
                $(document).ready(function() {
                    $('#project_select').change(function() {
                        // ซ่อนทุกฟิลด์ก่อน
                        var project_select = $(this).val();


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
                        $('#project_select').change(function() {
                            // ซ่อนทุกฟิลด์ก่อน
                            $('#ICT').hide();
                            $('#inv').hide();
                            $('#utility').hide();
                            $('#task_pay_d').hide();


                            // แสดงฟิลด์ที่เกี่ยวข้องตามประเภทงบประมาณที่เลือก
                            if ($(this).val() == 'task_budget_it_operating') {
                                $('#ICT').show();
                              //  $('#task_pay_d').show();
                            } else if ($(this).val() == 'task_budget_it_investment') {
                                $('#inv').show();
                               // $('#task_pay_d').show();
                            } else if ($(this).val() == 'task_budget_gov_utility') {
                                $('#utility').show();
                              //  $('#task_pay_d').show();
                            }
                        });

                        // ทำการเรียกเมธอด change เมื่อโหลดหน้าเพื่อซ่อนฟิลด์ที่ไม่เกี่ยวข้อง
                        $('#project_select').change();
                    });
                </script>
                <script>
                    $(document).ready(function() {
                        // Initially hide the fields
                        $("#task_cost_it_operating, #task_cost_it_investment, #task_cost_gov_utility").parent().hide();
                        $("#task_pay_d").hide();

                        // Show the fields when a value is entered in task_budget_it_operating
                        $("#task_budget_it_operating, #task_budget_it_investment, #task_budget_gov_utility").on("input", function() {
                            var fieldId = $(this).attr('id');

                            if ($(this).val() != '') {
                                if (fieldId === "task_budget_it_operating") {
                                    $("#task_cost_it_operating").parent().show();
                                    $("#task_pay_d").hide();
                                } else if (fieldId === "task_budget_it_investment") {
                                    $("#task_cost_it_investment").parent().show();
                                    $("#task_pay_d").hide();
                                } else if (fieldId === "task_budget_gov_utility") {
                                    $("#task_cost_gov_utility").parent().show();
                                    $("#task_pay_d").hide();
                                }
                                $("#task_pay_d").hide();
                            } else {
                                $("#task_cost_it_operating, #task_cost_it_investment, #task_cost_gov_utility").parent().hide();
                                $("#task_pay_d").hide();
                            }
                        });

                        // Show the fields when a value is entered in task_cost_it_operating
                        $("#task_cost_it_operating, #task_cost_it_investment, #task_cost_gov_utility").on("input", function() {
                            if ($(this).val() != '') {
                                $("#task_pay_d").show();
                            } else {
                                $("#task_pay_d").hide();
                            }
                        });
                    });
                </script>



          {{--   <script>
                $(document).ready(function() {





                    // Hide all budget fields initially
                    $('#task_budget_it_operating').closest('.col-md-3').hide();
                    $('#task_budget_it_investment').closest('.col-md-3').hide();
                    $('#task_budget_gov_utility').closest('.col-md-3').hide();

                    $('#project_select').change(function() {
                        var project_type = $(this).val();

                        // Hide all budget fields initially
                        $('#task_budget_it_operating').closest('.col-md-3').hide();
                        $('#task_budget_it_investment').closest('.col-md-3').hide();
                        $('#task_budget_gov_utility').closest('.col-md-3').hide();

                        // Show the budget field that corresponds to the selected project type
                        if (project_type == 'task_budget_it_operating') {
                            $('#task_budget_it_operating').closest('.col-md-3').show();
                        } else if (project_type == 'task_budget_it_investment') {
                            $('#task_budget_it_investment').closest('.col-md-3').show();
                        } else if (project_type == 'task_budget_gov_utility') {
                            $('#task_budget_gov_utility').closest('.col-md-3').show();
                        }
                    });
                });
            </script> --}}




            {{--  <script>
                        $(document).ready(function() {
                            var projectData = {!! $projectsJson !!};

                            // Generate options
                            var options = projectData.map(function(project) {
                                return '<option value="' + project.id + '">' + project.project_name + '</option>';
                            });

                            // Add a placeholder option
                            var placeholderOption = '<option value="" disabled selected>เลือกโครงการ</option>';

                            $('#project_select').html(placeholderOption + options.join('')).select2({
                                allowClear: true
                            });

                            $('#project_select').on('select2:select', function(e) {
                                var projectId = e.params.data.id;
                                var selectedProject = projectData.find(function(project) {
                                    return project.id == projectId;
                                });
                                var budget = parseFloat(selectedProject.budget_it_investment) || parseFloat(selectedProject.budget_it_operating) || parseFloat(selectedProject.budget_gov_utility) || 0;

                                if (typeof budget === 'number') {
                                    budget = new Intl.NumberFormat('en-US', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }).format(budget);
                                }

                                $('#project-budget').val(budget);
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
            </script> --}}


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

                    $("#task_pay_date,#taskcon_pay_date,#task_start_date,#task_end_date,#project_start_date,#project_end_date, #contract_end_date, #insurance_start_date, #insurance_end_date,#contract_er_start_date,#contract_po_start_date")
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

            <script>
                $(document).ready(function() {
                    $("#task_budget_it_operating,#task_budget_it_investment, #task_budget_gov_utility").on("input",
                        function() {
                            var max = 0;
                            var fieldId = $(this).attr('id');

                            if (fieldId === "task_budget_it_investment") {
                                max = parseFloat(
                                    {{ $projectDetails->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment }}
                                    );
                            } else if (fieldId === "task_budget_it_operating") {
                                max = parseFloat(
                                    {{ $projectDetails->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating }}
                                    );
                            } else if (fieldId === "task_budget_gov_utility") {
                                max = parseFloat(
                                    {{ $projectDetails->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility }}
                                    );
                            }

                            var current = parseFloat($(this).val().replace(/,/g, ""));
                            if (current > max) {
    Swal.fire("จำนวนเงินที่ใส่ต้องไม่เกิน " + max.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + " บาท");
    $(this).val(max.toFixed(2));
}


                        });
                });
            </script>
            <script>
                $(document).ready(function() {
                    $("#task_cost_it_operating,#task_cost_it_investment, #task_cost_gov_utility").on("input", function() {
                        var max ;
                        var fieldId = $(this).attr('id');

                        if (fieldId === "task_cost_it_investment") {
                            max = parseFloat($("#task_budget_it_investment").val().replace(/,/g, ""));
                        } else if (fieldId === "task_cost_it_operating") {
                            max = parseFloat($("#task_budget_it_operating").val().replace(/,/g, ""));
                        } else if (fieldId === "task_cost_gov_utility") {
                            max = parseFloat($("#task_budget_gov_utility").val().replace(/,/g, ""));
                        }

                        var current = parseFloat($(this).val().replace(/,/g, ""));
                        if (current > max) {
                            Swal.fire("จำนวนเงินที่ใส่ต้องไม่เกิน " +max.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + " บาท");
                            $(this).val(max.toFixed(2));
                        }
                    });
                });
            </script>


<script>
    $(document).ready(function() {
        $("#task_pay").on("input", function() {
            var max;
            var budgetType = $("#project_select").val();

            // Disable the fields
/*             $("#task_budget_it_operating,#task_budget_it_investment, #task_budget_gov_utility, #task_cost_it_operating,#task_cost_it_investment, #task_cost_gov_utility").prop('disabled', true);
 */
            if (budgetType === "task_budget_it_operating") {
                max = parseFloat($("#task_cost_it_operating").val().replace(/,/g, ""));
            } else if (budgetType === "task_budget_it_investment") {
                max = parseFloat($("#task_cost_it_investment").val().replace(/,/g, ""));
            } else if (budgetType === "task_budget_gov_utility") {
                max = parseFloat($("#task_cost_gov_utility").val().replace(/,/g, ""));
            }

            var current = parseFloat($(this).val().replace(/,/g, ""));
            if (current > max) {
                Swal.fire("จำนวนเงินที่ใส่ต้องไม่เกิน " + max.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) +
                    " บาท");
                $(this).val(max.toFixed(2));
            }
        });

        // Enable the fields when input in #task_pay is finished
       /*  $("#task_pay").on("blur", function() {
            $("#task_budget_it_operating,#task_budget_it_investment, #task_budget_gov_utility, #task_cost_it_operating,#task_cost_it_investment, #task_cost_gov_utility").prop('disabled', false);
        }); */
    });
</script>

<script>
    $("#task_refund_pa_budget").on("input", function() {
        calculateRefund();
    });

    function calculateRefund() {
        var pr_budget, pa_budget, refund;
        var budgetType = $("#project_select").val();
/*         $("#task_budget_it_operating,#task_budget_it_investment, #task_budget_gov_utility, #task_cost_it_operating,#task_cost_it_investment, #task_cost_gov_utility").prop('disabled', true);
 */
        if (budgetType === "task_budget_it_operating")  {
            pr_budget = parseFloat($("#task_budget_it_operating").val().replace(/,/g, "")) || 0;
            pa_budget = parseFloat($("#task_cost_it_operating").val().replace(/,/g, "")) || 0;
            refund = pr_budget - pa_budget;
        }else if (budgetType === "task_budget_it_investment" ) {
            pr_budget = parseFloat($("#task_budget_it_investment").val().replace(/,/g, "")) || 0;
            pa_budget = parseFloat($("#task_cost_it_investment").val().replace(/,/g, "")) || 0;
            refund = pr_budget - pa_budget;
        }else  if (budgetType === "task_budget_gov_utility") {
            pr_budget = parseFloat($("#task_budget_gov_utility").val().replace(/,/g, "")) || 0;
            pa_budget = parseFloat($("#task_cost_gov_utility").val().replace(/,/g, "")) || 0;
            refund = pr_budget - pa_budget;
        }

        $("#task_refund_pa_budget").val(refund.toFixed(2));
    }
</script>





            {{-- <script>
    $("#task_refund_pa_budget").on("input", function() {
        calculateRefund();
    });

    function calculateRefund() {
        var pr_budget, pa_budget, refund;

        if (("task_cost_it_operating") > 1) {
            pr_budget = parseFloat($("#task_budget_it_operating").val().replace(/,/g , "")) || 0;
            pa_budget = parseFloat($("#task_cost_it_operating").val().replace(/,/g , "")) || 0;
            var pr_budget = document.getElementById("task_budget_it_operating").value.replace(/,/g , "") ? parseFloat(document.getElementById("task_budget_it_operating").value.replace(/,/g , "")) : 0;
            var pa_budget = document.getElementById("task_cost_it_operating").value.replace(/,/g , "") ? parseFloat(document.getElementById("task_cost_it_operating").value.replace(/,/g , "")) : 0;
            refund = pr_budget - pa_budget;
        } else if (("task_cost_it_investment") > 1) {

            var pr_budget = document.getElementById("task_budget_it_investment").value.replace(/,/g , "") ? parseFloat(document.getElementById("task_budget_it_investment").value.replace(/,/g , "")) : 0;
            var pa_budget = document.getElementById("task_cost_it_investment").value.replace(/,/g , "") ? parseFloat(document.getElementById("task_cost_it_investment").value.replace(/,/g , "")) : 0;
            refund = pr_budget - pa_budget;
        } else if (("task_cost_gov_utility") > 1) {
            var pr_budget = document.getElementById("task_budget_gov_utility").value.replace(/,/g , "") ? parseFloat(document.getElementById("task_budget_gov_utility").value.replace(/,/g , "")) : 0;
            var pa_budget = document.getElementById("task_cost_gov_utility").value.replace(/,/g , "") ? parseFloat(document.getElementById("task_cost_gov_utility").value.replace(/,/g , "")) : 0;
            refund = pr_budget - pa_budget;
        }

        $("#task_refund_pa_budget").val(refund.toFixed(2));
    }
</script>
 --}}













        </x-slot:javascript>
</x-app-layout>
