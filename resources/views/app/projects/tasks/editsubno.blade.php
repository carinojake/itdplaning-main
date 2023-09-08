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
                        <x-card title="{{ __('วงเงินที่ขออนุมัติ/การใช้จ่าย ของ ') }}{{ $task->task_name }}">

                            <form method="POST"
                                action="{{ route('project.task.update', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
                                class="row g-3">
                                @csrf
                                {{ method_field('PUT') }}




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
                                                            @if ($projectDetails->budget_it_operating - $sum_task_budget_it_operating+$sum_task_refund_budget_it_operating > 0)
                                                                <div class="col-md-4">
                                                                    <label for="budget_it_operating"
                                                                        class="form-label">{{ __('งบกลาง ICT ') }}</label>  {{-- $project_task_budget_it_operating --}}
                                                                    <input type="text"
                                                                        placeholder="{{ number_format($projectDetails->budget_it_operating - $sum_task_budget_it_operating+$sum_task_refund_budget_it_operating  , 2) }} บาท"
                                                                        step="0.01"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                        class="form-control numeral-mask"
                                                                        id="budget_it_operating"
                                                                        name="budget_it_operating" min="0"
                                                                        disabled readonly>
                                                                </div>
                                                            @endif

                                                            @if ($projectDetails->budget_it_investment -$sum_task_budget_it_investment+$sum_task_refund_budget_it_investment > 0)
                                                                <div class="col-4">
                                                                    <label for="budget_it_investment"
                                                                        class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                                    <input type="text"
                                                                        placeholder="{{ number_format($projectDetails->budget_it_investment -$sum_task_budget_it_investment+$sum_task_refund_budget_it_investment, 2) }} บาท"
                                                                        step="0.01"
                                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                        class="form-control numeral-mask"
                                                                        id="budget_it_investment"
                                                                        name="budget_it_investment" min="0"
                                                                        disabled readonly>
                                                                </div>
                                                            @endif

                                                            @if ($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility+$sum_task_refund_budget_gov_utility> 0)
                                                                <div class="col-md-4">
                                                                    <label for="budget_gov_utility"
                                                                        class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                                    <input type="text"
                                                                        placeholder="{{ number_format($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility+$sum_task_refund_budget_gov_utility , 2) }} บาท"
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


                                                    <div class="callout callout-primary row mt-3">
                                                        <div class="row">
                                                            <div class="col-md-4 mt-3">
                                                                <label for="taskcon_mm"
                                                                    class="form-label">{{ __('เลขที่ MM/เลขที่ สท.') }}</label>
                                                                <span class="text-danger">*</span>

                                                                <input type="text" class="form-control"
                                                                    id="taskcon_mm" name="taskcon_mm"   value="{{$task->taskcon_mm  }}" >
                                                                <div class="invalid-feedback">
                                                                    {{ __('เลขที่ MM/เลขที่ สท. ') }}
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8 mt-3">
                                                                <label for="taskcon_mm_name"
                                                                    class="form-label">{{ __('ชื่อ MM / ชื่อบันทึกข้อความ') }}</label>


                                                                <input type="text" class="form-control"
                                                                    id="task_name" name="task_name"   value="{{ $task->task_name }}" >
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
                                                                    name="task_start_date" name="task_start_date"    value={{ Helper::Date4(date('Y-m-d H:i:s', $task->task_start_date)) }}>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="task_end_date"
                                                                    class="form-label">{{ __('วันที่สิ้นสุด') }}</label>
                                                                <span class="text-danger"></span>
                                                                <input class="form-control" id="task_end_date"
                                                                    name="task_end_date" name="task_start_date"
                                                                     value={{ Helper::Date4(date('Y-m-d H:i:s', $task->task_end_date)) }} >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mt-3">
                                                            <label for="task_mm_budget"
                                                                class="form-label">{{ __('วงเงิน (บาท) MM') }}</label>
                                                            <span class="text-danger"></span>

                                                            <input type="text" placeholder="0.00" step="0.01"
                                                                class="form-control" id="task_mm_budget"
                                                                data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                class="form-control numeral-mask"
                                                                name="task_mm_budget" min="0"  value="{{ $task->task_mm_budget }}">
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
                                                                            min="0" value="{{ $task->task_budget_it_operating }}"  onchange="calculateRefund()"
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
                                                                         name="task_cost_it_operating" min="0" value="{{ $task->task_cost_it_operating }}"   onchange="calculateRefund()" >

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
                                                                            min="0" value="{{ $task->task_budget_it_investment }} "  onchange="calculateRefund()"
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
                                                                         name="task_cost_it_investment" min="0"  value="{{ $task->task_cost_it_investment }}"  onchange="calculateRefund()"  >

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
                                                                            value="{{ $task->task_budget_gov_utility }}" onchange="calculateRefund()">

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
                                                                         name="task_cost_gov_utility" min="0" value="{{ $task->task_cost_gov_utility }}" onchange="calculateRefund()"  >

                                                                        <div class="invalid-feedback">
                                                                        {{ __('ค่าสาธารณูปโภค') }}
                                                                    </div>
                                                                    </div>
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
                                                                            name="task_refund_pa_budget" min="0"   value={{ $task->task_refund_pa_budget }} readonly>

                                                                        {{--  <div class="invalid-feedback">
                                                                                {{ __('ค่าสาธารณูปโภค') }}
                                                                            </div> --}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
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
                                                                <textarea class="form-control" name="task_description" id="task_description" rows="5" value="{{ $task->task_description }}"></textarea>
                                                                <div class="invalid-feedback">
                                                                    {{ __('รายละเอียดกิจกรรม') }}
                                                                </div>
                                                            </div>
                                                        </div>

                                            </div>
                                                        <div class=" row mt-3">
                                                            <div class="d-none col-md-4">
                                                                <label for="task_status"
                                                                    class="form-label">{{ __('สถานะกิจกรรม') }}</label>

                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="task_status" id="task_status1"
                                                                        value="1" checked>
                                                                    <label class="form-check-label"
                                                                        for="task_status1">
                                                                        ระหว่างดำเนินการ
                                                                    </label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="task_status" id="task_status2"
                                                                        value="2">
                                                                    <label class="form-check-label"
                                                                        for="task_status2">
                                                                        ดำเนินการแล้วเสร็จ
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="d-none col-md-3">
                                                                <label for="contract_type"
                                                                    class="form-label">{{ __('ประเภท') }} </label>
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
                                                                                value="{{ $task->taskcon_pp }}" >
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
                                                                                value="{{ $task->taskcon_pp_name }}"   >
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
                                                                                name="task_pay_date"  value={{ Helper::Date4(date('Y-m-d H:i:s', $task->task_pay_date )) }}>


                                                                        </div>


                                                                        <div class="col-md-4">
                                                                            <label for="task_pay"
                                                                                class="form-label">{{ __('จำนวนเงิน (บาท) PP') }}</label>
                                                                           {{--  <span class="text-danger">*</span> --}}

                                                                            <input type="text" placeholder="0.00"
                                                                                step="0.01" class="form-control"
                                                                                id="task_pay"
                                                                                data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                                class="form-control numeral-mask"
                                                                                name="task_pay" min="0"  value="{{ $task->task_pay }}"
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

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js"></script>
   {{--  <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script> --}}
    <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>



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
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
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
    var costFields = ['task_cost_it_operating', 'task_cost_it_investment', 'task_cost_gov_utility'];
    var budgetFields = ['task_budget_it_operating', 'task_budget_it_investment', 'task_budget_gov_utility'];

    function calculateRefund() {
        var totalRefund = 0;

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
    }

    $(document).ready(function() {
        costFields.forEach(function(costField, index) {
            $("#" + costField).on("input", calculateRefund);
        });
    });
</script>
{{-- <script>
    $("#task_pay").on("input", function() {
        calculateRefund();
    });

    function calculateRefund() {
        var pr_budget, pa_budget, refund;

        if (parseFloat($("#task_cost_it_operating").val().replace(/,/g , "")) > 1) {
            pr_budget = parseFloat($("#task_budget_it_operating").val().replace(/,/g , "")) || 0;
            pa_budget = parseFloat($("#task_cost_it_operating").val().replace(/,/g , "")) || 0;
            refund = pr_budget - pa_budget;
        }  if (parseFloat($("#task_cost_it_investment").val().replace(/,/g , "")) > 1) {
            pr_budget = parseFloat($("#task_budget_it_investment").val().replace(/,/g , "")) || 0;
            pa_budget = parseFloat($("#task_cost_it_investment").val().replace(/,/g , "")) || 0;
            refund = pr_budget - pa_budget;
        }  if (parseFloat($("#task_cost_gov_utility").val().replace(/,/g , "")) > 1) {
            pr_budget = parseFloat($("#task_budget_gov_utility").val().replace(/,/g , "")) || 0;
            pa_budget = parseFloat($("#task_cost_gov_utility").val().replace(/,/g , "")) || 0;
            refund = pr_budget - pa_budget;
        }

        $("#task_refund_pa_budget").val(refund.toFixed(2));
    }
</script> --}}

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




{{--     <script>
        $(document).ready(function() {
            $("#task_budget_it_investment, #task_budget_gov_utility, #task_budget_it_operating").on("input", function() {
                var max = 0;
                var fieldId = $(this).attr('id');

                if (fieldId === "task_budget_it_investment") {
                    max = parseFloat('{{ $task_budget_it_investment }}'.replace(/,/g , ""));
                } else if (fieldId === "task_budget_gov_utility") {
                    max = parseFloat('{{ $task_budget_gov_utility }}'.replace(/,/g , ""));
                } else if (fieldId === "task_budget_it_operating") {
                    max = parseFloat('{{ $task_budget_it_operating }}'.replace(/,/g , ""));
                }

                var current = parseFloat($(this).val().replace(/,/g , ""));
                if (current > max) {
                    alert("จำนวนเงินที่ใส่ต้องไม่เกิน " + max.toFixed(2) + " บาท");
                    $(this).val(max.toFixed(2));
                }
            });
        });
        </script>
 --}}









      {{--   <script>
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
 --}}
                <script>
                    $(document).ready(function() {
                        $(":input").inputmask();
                    });
                </script>




                  <script>
                        $(document).ready(function() {
                    $("#task_budget_it_operating,#task_budget_it_investment, #task_budget_gov_utility").on("input", function() {
                    var max = 0;
                    var fieldId = $(this).attr('id');

                    if (fieldId === "task_budget_it_investment") {
                        max = parseFloat({{$projectDetails->budget_it_investment - $sum_task_budget_it_investment+$sum_task_refund_budget_it_investment }});
                    }  else if (fieldId === "task_budget_it_operating") {
                        max = parseFloat({{$projectDetails->budget_it_operating -  $sum_task_budget_it_operating+$sum_task_refund_budget_it_operating }});
                    } else if (fieldId === "task_budget_gov_utility") {
                        max = parseFloat({{ $projectDetails->budget_gov_utility - $sum_task_budget_gov_utility+$sum_task_refund_budget_gov_utility }});
                    }

                    var current = parseFloat($(this).val().replace(/,/g , ""));
                    if (current > max) {


                        Swal.fire("จำนวนเงินที่ใส่ต้องไม่เกิน " +max.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})+ " บาท");



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

            if (fieldId === "task_cost_it_investment") {
                max = parseFloat($("#task_budget_it_investment").val().replace(/,/g , ""));
            } else if (fieldId === "task_cost_it_operating") {
                max = parseFloat($("#task_budget_it_operating").val().replace(/,/g , ""));
            } else if (fieldId === "task_cost_gov_utility") {
                max = parseFloat($("#task_budget_gov_utility").val().replace(/,/g , ""));
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
        var max;
        var budgetType = $("#project_select").val();

        if (budgetType === "task_budget_it_operating") {
            max = parseFloat($("#task_cost_it_operating").val().replace(/,/g , ""));
        } else if (budgetType === "task_budget_it_investment") {
            max = parseFloat($("#task_cost_it_investment").val().replace(/,/g , ""));
        } else if (budgetType === "task_budget_gov_utility") {
            max = parseFloat($("#task_cost_gov_utility").val().replace(/,/g , ""));
        }

        var current = parseFloat($(this).val().replace(/,/g , ""));
        if (current > max) {
                Swal.fire("จำนวนเงินที่ใส่ต้องไม่เกิน " + max.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})+ " บาท");
                 /*  $(this).val(max.toFixed(2)); */
           $(this).val(0);
            }
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
    $(function() {
        $("#task_start_date, #task_end_date").datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            language:"th-th",

        });

        $('#task_start_date').on('changeDate', function() {
            var startDate = $(this).datepicker('getDate');
            $("#task_end_date").datepicker("setStartDate", startDate);
            $("#task_pay_date").datepicker("setStartDate", startDate);
        });

        $('#task_end_date').on('changeDate', function() {
            var endDate = $(this).datepicker('getDate');
            $("#task_start_date").datepicker("setEndDate", endDate);
        });
    });
</script>
{{-- <script>
    $("#task_pay").on("input", function() {
        calculateRefund();
    });

    function calculateRefund() {
        var pr_budget , pa_budget , refund ;

        if (parseFloat($("#task_cost_it_operating").val().replace(/,/g, "")) > 1) {
            pr_budget = parseFloat($("#task_budget_it_operating").val().replace(/,/g, "")) || 0;
            pa_budget = parseFloat($("#task_cost_it_operating").val().replace(/,/g, "")) || 0;
            refund = pr_budget - pa_budget;
        }
        else if (parseFloat($("#task_cost_it_investment").val().replace(/,/g, "")) > 1) {
            pr_budget = parseFloat($("#task_budget_it_investment").val().replace(/,/g, "")) || 0;
            pa_budget = parseFloat($("#task_cost_it_investment").val().replace(/,/g, "")) || 0;
            refund = pr_budget - pa_budget;
        }
        else if (parseFloat($("#task_cost_gov_utility").val().replace(/,/g, "")) > 1) {
            pr_budget = parseFloat($("#task_budget_gov_utility").val().replace(/,/g, "")) || 0;
            pa_budget = parseFloat($("#task_cost_gov_utility").val().replace(/,/g, "")) || 0;
            refund = pr_budget - pa_budget;
        }

        $("#task_refund_pa_budget").val(refund.toFixed(2));
    }
</script> --}}


    </x-slot:javascript>
</x-app-layout>
