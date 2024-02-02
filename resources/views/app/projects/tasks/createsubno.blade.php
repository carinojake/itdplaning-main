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
                        <x-card title="{{ __('ค่าใช้จ่ายสำนักงาน') }}">
                            <x-slot:toolbar>
                                {{-- <a href="{{ route('contract.create') }}" class="btn btn-success text-white">C</a>

  <a href="{{ route('project.task.createsub', $project) }}" class="btn btn-primary text-white">ไปยังหน้าการใช้จ่ายของงาน</a> --}}
                            </x-slot:toolbar>
                            <form method="POST" action="{{ route('project.task.storesubno', ['project' => $project]) }}"
                                class="row needs-validation" enctype="multipart/form-data"  novalidate>
                                {{ csrf_field() }}




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
                                                       {{ $projectDetails->project_fiscal_year }}

                                                    </div>

                                                        <div class="col-md-4">
                                                            <label for="task_start_date2"
                                                                class="form-label">{{ __('วันที่เริ่มต้น') }}</label>
                                                          {{--   <span class="text-danger">*</span> --}}
                                                  {{ Helper::Date4(date('Y-m-d H:i:s', $projectDetails->project_start_date)) }}

                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="task_end_date2"
                                                                class="form-label">{{ __('วันที่สิ้นสุด') }}</label>
                                                      {{--       <span class="text-danger">*</span> --}}
                                                       {{ Helper::Date4(date('Y-m-d H:i:s', $projectDetails->project_end_date)) }}

                                                        </div>

                                                    <div class="row">
                                                        <div class="col-md-12 mt-3">
                                                        <label for="reguiar_id"
                                                            class="form-label">{{ __('ลำดับ') }}</label>
                                                    {{ $projectDetails->reguiar_id  }}

                                                    <label for="project_name"
                                                    class="form-label">{{ Helper::projectsType($projectDetails->project_type ) }}</label>
                                            {{  $projectDetails->project_name }}
                                                    </div>

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



                                                    <div class="col-md-12 mt-3">


                                                        <div class="col-md-12">
                                                            <label for="project_description"
                                                                class="form-label">{{ __('รายละเอียดโครงการ') }}</label>
                                                         {{ $projectDetails->project_description }}
                                                        </div>

                                                    </div>


                                              {{--       <div class="row mt-3">
                                                        <h4>งบประมาณที่ได้รับจัดสรร</h4>
                                                        <div class="row">
                                                            @if ($projectDetails->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating+$increasedData->first()->total_it_operating > 0)
                                                            <div class="col-3">{{ __('งบกลาง ICT ') }}</div>
                                                                <div class="col-3">{{ number_format(($projectDetails->budget_it_operating+$increasedData->first()->total_it_operating+ $sum_task_refund_budget_it_operating)-($sum_task_budget_it_operating ), 2) }} บาท</div>
                                                            @endif
                                                        </div>
                                                        <div class="row">
                                                            @if ($projectDetails->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment+$increasedData->first()->total_it_investment > 0)
                                                            <div class="col-3">{{ __('งบดำเนินงาน') }}</div>
                                                                <div class="col-3">     {{ number_format(($projectDetails->budget_it_investment+$increasedData->first()->total_it_investment+$sum_task_refund_budget_it_investment)-($sum_task_budget_it_investment), 2) }} บาท</div>
                                                            @endif
                                                        </div>
                                                        <div class="row">
                                                            @if ($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility+$increasedData->first()->total_gov_utility > 0)
                                                            <div class="col-3">{{ __('ค่าสาธารณูปโภค') }}</div>
                                                                <div class="col-3">{{ number_format(($projectDetails->budget_gov_utility+$increasedData->first()->total_gov_utility+$sum_task_refund_budget_gov_utility)-($sum_task_budget_gov_utility), 2) }} บาท</div>
                                                            @endif
                                                        </div>
                                                    </div> --}}
                                                    </div>
{{-- เพิ่ม 31/12/2566 --}}
<div class="callout callout-primary row mt-3">
    <div class="row mt-3">
        <label
        class="form-label">{{ __('งบประมาณที่ได้รับจัดสรร') }}</label>
</div>

<div class="row">
    @if($projectDetails->budget_it_operating > 0)
    <div id='ICT' class="col-2">{{ __('งบกลาง ICT ') }}</div>
    <div id='ICT' class="col-2">{{ number_format($projectDetails->budget_it_operating, 2) }} บาท</div>   {{-- งบกลาง ICT --}}
    @endif
    @if($projectDetails->budget_it_investment > 0)
    <div class="col-2">{{ __('งบดำเนินงาน') }}</div>
    <div class="col-2">{{ number_format($projectDetails->budget_it_investment, 2) }} บาท</div> {{-- งบดำเนินงาน --}}
    @endif
    @if($projectDetails->budget_gov_utility > 0)
    <div class="col-2">{{ __('งบค่าสาธารณูปโภค') }}</div>
    <div class="col-2">{{ number_format($projectDetails->budget_gov_utility, 2) }} บาท</div> {{-- งบค่าสาธารณูปโภค --}}
    @endif
</div>
@if( $budget_task['sum_task_refund_budget_it_operating']||$budget_task['sum_task_refund_budget_it_investment']||$budget_task['sum_task_refund_budget_gov_utility']||$increasedData->first()->total_it_operating||$increasedData->first()->total_it_investment||$increasedData->first()->total_gov_utility)  {{-- row --}}
<div class="row">


    @if($increasedData->first()->total_it_operating||$increasedData->first()->total_it_investment||$increasedData->first()->total_gov_utility)
    @if($projectDetails->budget_it_operating > 0)
    <div class="col-2">{{ __('งบกลาง ICT เพิ่ม ') }}</div>
    <div class="col-2">{{ number_format($increasedData->first()->total_it_operating, 2) }} บาท</div> {{-- งบกลาง ICT เพิ่ม --}}
    @endif
    @if($projectDetails->budget_it_investment > 0)
    <div class="col-2">{{ __('งบดำเนินงาน เพิ่ม ') }}</div>
    <div class="col-2">{{ number_format($increasedData->first()->total_it_investment, 2) }} บาท</div> {{-- งบดำเนินงาน เพิ่ม --}}
    @endif
    @if($projectDetails->budget_gov_utility > 0)
    <div class="col-2">{{ __('งบค่าสาธารณูปโภค เพิ่ม ') }}</div>
    <div class="col-2">{{ number_format($increasedData->first()->total_gov_utility, 2) }} บาท</div> {{-- งบค่าสาธารณูปโภค เพิ่ม --}}
    @endif
    @endif

</div>
<hr width="200px"/>{{-- row --}}
<div class="row">
    @if($projectDetails->budget_it_operating > 0)
    <div class="col-2">{{ __('งบกลาง ICT คืน ') }}</div>
    <div class="col-2"><b class=text-blue-ganll  >{{ number_format($budget_task['sum_task_refund_budget_it_operating'] -$budget_task['sum_task_refund_budget_type_it_operating'], 2) }} </b> บาท</div> {{-- งบกลาง ICT คืน --}}
    @endif
    @if($projectDetails->budget_it_investment > 0)
    <div class="col-2">{{ __('งบดำเนินงาน คืน') }}</div>
    <div class="col-2"><b class=text-blue-ganll  >{{ number_format($budget_task['sum_task_refund_budget_it_investment']-$budget_task['sum_task_refund_budget_type_it_investment'], 2) }}</b> บาท</div> {{-- งบดำเนินงาน คืน --}}
    @endif
    @if($projectDetails->budget_gov_utility > 0)
    <div class="col-2">{{ __('งบค่าสาธารณูปโภค คืน') }}</div>
    <div class="col-2"><b class=text-blue-ganll  >{{ number_format($budget_task['sum_task_refund_budget_gov_utility']-$budget_task['sum_task_refund_budget_type_gov_utility'], 2) }} </b>บาท</div> {{-- งบค่าสาธารณูปโภค คืน --}}
    @endif
    <hr width="200px"/>

</div>  {{-- row --}}


@endif
<div class="row">
{{--                                 @if($increasedData->first()->total_it_operating||$increasedData->first()->total_it_investment||$increasedData->first()->total_gov_utility)
--}}
@if($projectDetails->budget_it_operating > 0)
<div class="col-2">{{ __('งบกลาง ICT คงเหลือ ') }}</div>
                            <div class="col-2"><b class=text-success>{{number_format(($projectDetails->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating+ $increasedData->first()->total_it_operating) ,2)}}</b> บาท</div> {{-- งบกลาง ICT คงเหลือ --}}

                            @endif
                            @if($projectDetails->budget_it_investment > 0)
                            <div class="col-2">{{ __('งบดำเนินงาน คงเหลือ ') }}</div>
                            <div class="col-2"><b class=text-success>{{ number_format(($projectDetails->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment+ $increasedData->first()->total_it_investment) ,2) }}</b> บาท</div> {{-- งบดำเนินงาน คงเหลือ --}}
                            @endif
                            @if($projectDetails->budget_gov_utility > 0)

                            <div class="col-2">{{ __('งบค่าสาธารณูปโภค คงเหลือ ') }}</div>
                            <div class="col-2"><b class=text-success>{{ number_format(($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility+ $increasedData->first()->total_gov_utility) ,2) }}</b> บาท</div> {{-- งบค่าสาธารณูปโภค คงเหลือ --}}
                            @endif
                            {{--  @endif --}}
                    </div>
</div>




    {{-- </div> ปิด--}}

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
                                                        <div class="row ">
                                                            <div class="col-md-3 mt-3">
                                                                <label for="project_select"
                                                                    class="form-label">{{ __('ประเภท งบประมาณ') }}</label>
                                                                <span class="text-danger">*</span>
                                                                <select class="form-control"
                                                                    name="project_select"
                                                                    id="project_select" required>
                                                                    <option selected disabled
                                                                        value="">เลือกประเภท...
                                                                    </option>
                                                                    @if (
                                                                $projectDetails->budget_it_operating+$increasedData->first()->total_it_operating+ $sum_task_refund_budget_it_operating-$sum_task_budget_it_operating > 0)

                                                                        <option selected value="1">
                                                                            งบกลาง ICT</option>
                                                                    @endif
                                                                    @if($projectDetails->budget_it_investment+$increasedData->first()->total_it_investment+ $sum_task_refund_budget_it_investment-$sum_task_budget_it_investment > 0)
                                                                        <option selected value="2">
                                                                            งบดำเนินงาน</option>
                                                                    @endif
                                                                    @if($projectDetails->budget_gov_utility+$increasedData->first()->total_gov_utility+ $sum_task_refund_budget_gov_utility-$sum_task_budget_gov_utility > 0)
                                                                        <option selected value="3">
                                                                            ค่าสาธารณูปโภค</option>
                                                                    @endif
                                                                </select>
                                                            </div>

                                                            {{--    <div class="project_select">
                                                                    {{ __('ประเภท งบประมาณ') }}
                                                                </div> --}}
                                                        </div>
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

                                                                    <span class="text-danger">*</span>
                                                                <input type="text" class="form-control"
                                                                    id="taskcon_mm_name" name="taskcon_mm_name" required>
                                                                <div class="invalid-feedback">
                                                                    {{ __('ชื่อ MM / ชื่อบันทึกข้อความ') }}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mt-3">
                                                            <div class="col-md-6">
                                                                <label for="task_start_date"
                                                                    class="form-label">{{ __('วันที่เริ่มต้น') }}</label>
                                                                <span class="text-danger">*</span>
                                                                <input class="form-control" id="task_start_date"
                                                                    name="task_start_date" name="task_start_date"
                                                                    value="{{ Helper::calculateFiscalYearDates($projectDetails['project_fiscal_year'])['fiscalyear_start'] }}"
                                                                    required

                                                                    >
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="task_end_date"
                                                                    class="form-label">{{ __('วันที่สิ้นสุด') }}</label>
                                                                <span class="text-danger">*</span>
                                                                <input class="form-control" id="task_end_date"
                                                                    name="task_end_date" name="task_start_date"
                                                                    value="{{ Helper::calculateFiscalYearDates($projectDetails['project_fiscal_year'])['fiscalyear_end'] }}"
                                                                    required
                                                                    >

                                                                </div>
                                                        </div>
                                                        <div class="d-none col-md-4 mt-3">
                                                            <label for="task_mm_budget"
                                                                class="form-label">{{ __('วงเงิน (บาท) MM') }}</label>
                                                            <span class="text-danger"></span>

                                                            <input type="text" placeholder="0.00" step="0.01"
                                                                class="form-control" id="task_mm_budget"
                                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                                class="form-control numeral-mask"
                                                                name="task_mm_budget" min="0">
                                                        </div>
                                                    </div>
                                                    <div class="callout callout-warning">
                                                        <div class="row ">
                                                          {{--   <div class="col-md-4 mt-3">
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
                                                            </div> --}}

                                                            {{--    <div class="project_select">
                                                                    {{ __('ประเภท งบประมาณ') }}
                                                                </div> --}}
                                                        </div>
                                                        <!-- Contract Type -->

                                                        @if ($projectDetails->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating +$increasedData->first()->total_it_operating> 0)
                                                            <div id="ICT" {{-- style="display:none;" --}}>

                                                                <div class="row mt-3">
                                                                    <div class="col-md-4">
                                                                        <label for="task_budget_it_operating"
                                                                            class="form-label">{{ __('วงเงินที่ขออนุมัติ งบกลาง ICT') }}</label>
                                                                        <input type="text" placeholder="0.00"
                                                                            step="0.01"
                                                                             data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                                            class="form-control numeral-mask"
                                                                            id="task_budget_it_operating"
                                                                            name="task_budget_it_operating"
                                                                            min="0"
                                                                            onchange="calculateRefund()"
                                                                            >

                                                                        <div class="invalid-feedback">
                                                                            {{ __('ระบุงบกลาง ICT') }}
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label for="task_cost_it_operating"
                                                                            class="form-label">{{ __('รอการเบิก งบกลาง ICT ( ยอด pa / ไม่ pa )') }}</label>
                                                                        <input type="text" placeholder="0.00"
                                                                            step="0.01"
                                                                             data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
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

                                                        @if ($projectDetails->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment  +$increasedData->first()->total_it_investment > 0)
                                                            <div id="inv" {{-- style="display:none;" --}}>

                                                                <div class="row mt-3">
                                                                    <div class="col-md-4">
                                                                        <label for="task_budget_it_investment"
                                                                            class="form-label">{{ __('วงเงินที่ขออนุมัติ งบดำเนินงาน') }}</label>
                                                                        <input type="text" placeholder="0.00"
                                                                            step="0.01"
                                                                             data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
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
                                                                             data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
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

                                                        @if ($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility+$increasedData->first()->total_gov_utility> 0)
                                                            <div id="utility" {{-- style="display:none;" --}}>
                                                                <div class="row mt-3">
                                                                    <div class="col-md-4">
                                                                        <label for="task_budget_gov_utility"
                                                                            class="form-label">{{ __('วงเงินที่ขออนุมัติ งบสาธารณูปโภค') }}</label>
                                                                        <input type="text" placeholder="0.00"
                                                                            step="0.01"
                                                                             data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
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
                                                                             data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
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
                                                        <div id="refund" {{-- style="display:none;" --}}>
                                                            <div class=" row mt-3">
                                                                <div class="col-md-4">
                                                                    <label for="task_refund_pa_budget"
                                                                        class="form-label">{{ __('จำนวนคงเหลือหลังเงิน PA') }}</label>
                                                                    <span class="text-danger"></span>

                                                                    <input type="text" placeholder="0.00"
                                                                        step="0.01"
                                                                         data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                                        class="form-control numeral-mask"
                                                                        id="task_refund_pa_budget"
                                                                        name="task_refund_pa_budget" min="0" readonly>

                                                                    {{--  <div class="invalid-feedback">
                                                                            {{ __('ค่าสาธารณูปโภค') }}
                                                                        </div> --}}
                                                                </div>

                                                                <div class="col-md-4 d-none">
                                                                    <label for="task_refund_pa_status"
                                                                        class="form-label">{{ __('task_refund_pa_status PA') }}</label>
                                                                    <span class="text-danger"></span>

                                                                    <input type="text" placeholder="0.00"
                                                                    step="0.01"
                                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                                    class="form-control numeral-mask"
                                                                        id="task_refund_pa_status"
                                                                        name="task_refund_pa_status"  readonly>

                                                                    {{--  <div class="invalid-feedback">
                                                                            {{ __('ค่าสาธารณูปโภค') }}
                                                                        </div> --}}
                                                                </div>
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
                                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
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
                                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
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


                                                </div>
                                            </div>


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
                                                                name="task_pay_date"
                                                                value={{ Helper::Date4(date('Y-m-d H:i:s', $task?->task_pay_date )) }}

                                                                >


                                                        </div>


                                                        <div  id="task_pay_d" class="col-md-4">
                                                            <label for="task_pay"
                                                                class="form-label">{{ __('จำนวนเงิน (บาท) PP') }}</label>
                                                           {{--  <span class="text-danger">*</span> --}}

                                                            <input type="text" placeholder="0.00"
                                                                step="0.01" class="form-control"
                                                                id="task_pay"
                                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
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
                                <div class="d-none col-md-3">

                                </label>
                                {{ Form::select('task_parent_sub', \Helper::contractType(), '99', ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...', 'id' => 'contract_type']) }}
                                <input type="hidden" class="form-check-input" type="radio" name="task_budget_no"
                                id="task_budget_no" value="1" checked>
                            </div>
                       {{--      @if($request->budget_it_operating+1  < $sum_task_budget_it_operating|| $request->budget_it_investment+1 < $sum_task_budget_it_investment || $request->budget_gov_utility+1 < $sum_task_budget_gov_utility)


                            <input type="hidden" class="form-check-input" type="radio" name="task_refund_budget_type"
                            id="task_refund_budget_type" value="1" checked>
                            @endif --}}
                                        <!--จบ ข้อมูลสัญญา 2-->
                                    </div>
                                </div>
                           {{--      {{ $projectDetails->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment }}
                                {{ number_format($projectDetails->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment, 2) }} --}}
                                       <x-button type="submit" class="btn-success" preventDouble icon="cil-save">
                                    {{ __('Save') }}
                                </x-button>
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

        </x-slot:css>
        <x-slot:javascript>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <!-- Add the necessary CSS and JS files for Select2 -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js"></script>
           {{--  <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script> --}}
            <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
            <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>

           {{--  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> --}}
          {{--   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> --}}
          <script>
            $(document).ready(function() {
                $('#project_select').change(function() {
                    // ซ่อนทุกฟิลด์ก่อน
                    $('#ICT').hide();
                    $('#inv').hide();
                    $('#utility').hide();
                    $('#task_pay_d').hide();


                    // แสดงฟิลด์ที่เกี่ยวข้องตามประเภทงบประมาณที่เลือก
                    if ($(this).val() == '1') {
                        $('#ICT').show();
                        //  $('#task_pay_d').show();
                    } else if ($(this).val() == '2') {
                        $('#inv').show();
                        // $('#task_pay_d').show();
                    } else if ($(this).val() == '3') {
                        $('#utility').show();
                        //  $('#task_pay_d').show();
                    }
                });

                // ทำการเรียกเมธอด change เมื่อโหลดหน้าเพื่อซ่อนฟิลด์ที่ไม่เกี่ยวข้อง
                $('#project_select').change();
            });
        </script>

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
                var costFields = ['task_cost_it_operating', 'task_cost_it_investment', 'task_cost_gov_utility'];
                var budgetFields = ['task_budget_it_operating', 'task_budget_it_investment', 'task_budget_gov_utility'];

                function calculateRefundstatus() {
                    var totalRefundsstatus = 0; // Assuming you want to start with a default value of 0

                    costFields.forEach(function(costField, index) {
                        var pa_value = $("#" + costField).val();
                        var pr_value = $("#" + budgetFields[index]).val();

                        if (pa_value && pr_value) {
                            var pa_budget = parseFloat(pa_value.replace(/,/g, "")) || 0;
                            var pr_budget = parseFloat(pr_value.replace(/,/g, "")) || 0;

                            // Use '===' for strict comparison if you expect the same type, or '==' if types can differ
                            if (pr_budget - pa_budget === 0) {
                                // Assuming you want to set some status when the budgets are equal
                                totalRefundsstatus = 2;
                            } else {
                                // Assuming you want to set a different status when the budgets are not equal
                                totalRefundsstatus = 1;
                            }
                        }
                    });

                    $("#task_refund_pa_status").val(totalRefundsstatus);
                }

                $(document).ready(function() {
                    // The 'calculateRefund' function was not defined. Assuming it should be 'calculateRefundstatus'
                    costFields.forEach(function(costField) {
                        $("#" + costField).on("input", calculateRefundstatus);
                    });
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
                        $('#project_select').change(function() {
                            // ซ่อนทุกฟิลด์ก่อน

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
                      //  $("#task_cost_it_operating, #task_cost_it_investment, #task_cost_gov_utility").parent().hide();
                        $("#task_pay_d").hide();

                        // Show the fields when a value is entered in task_budget_it_operating
                        $("#task_budget_it_operating, #task_budget_it_investment, #task_budget_gov_utility").on("input", function() {
                            var fieldId = $(this).attr('id');
                            var task_budget_it_operating = $("#task_budget_it_operating").val().length != 0;
                          //  alert(fieldId);


                            if ($(this).val() != '') {
                                if ($("#task_budget_it_operating").val() === "0" || $("#task_budget_it_operating").val() === '') {
                                   // $("#task_cost_it_operating").parent().show();
                                   $("#task_cost_it_operating").val(0);
                                    $("#task_pay_d").hide();

                                   // alert(task_budget_it_operating);
                                }
                                else if (fieldId === "task_budget_it_investment") {
                                 //   $("#task_cost_it_investment").parent().show();
                                    $("#task_pay_d").hide();
                                } else if (fieldId === "task_budget_gov_utility") {
                                  //  $("#task_cost_gov_utility").parent().show();
                                    $("#task_pay_d").hide();
                                }
                                $("#task_pay_d").hide();
                            } else {
                              //  $("#task_cost_it_operating, #task_cost_it_investment, #task_cost_gov_utility").parent().hide();
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
                <script>
                    $(document).ready(function() {
                // Function to check and update the task cost fields
                function updateTaskCostFields() {
                    var budgetItOperating = $("#task_budget_it_operating").val();
                    var budgetItInvestment = $("#task_budget_it_investment").val();
                    var budgetGovUtility = $("#task_budget_gov_utility").val();
                    var costItOperating = $("#task_cost_it_operating").val();
                    var costItInvestment = $("#task_cost_it_investment").val();
                    var costGovUtility = $("#task_cost_gov_utility").val();
                    var taskpay = $("#task_pay").val();
                    // Check for task_budget_it_operating
                    console.log(budgetItOperating);
                    console.log(costItOperating);
                    if (budgetItOperating === "0" || budgetItOperating === '' || budgetItOperating > costItOperating || parseFloat(budgetItOperating) < -0 ) {
                        $("#task_cost_it_operating").val('');
                        $("#task_pay").val('');
                    }

                    // Check for task_budget_it_investment
                    if (budgetItInvestment === "0" || budgetItInvestment === '' || budgetItInvestment > costItInvestment || parseFloat(budgetItInvestment) < -0) {
                        $("#task_cost_it_investment").val('');
                        $("#task_pay").val('');
                    }

                    // Check for task_budget_gov_utility
                    if (budgetGovUtility === "0" || budgetGovUtility === '' || budgetGovUtility > costGovUtility || parseFloat(budgetGovUtility) < -0) {
                        $("#task_cost_gov_utility").val('');
                        $("#task_pay").val('');
                    }
                }

                // Attach event handlers to the budget fields
                $("#task_budget_it_operating, #task_budget_it_investment, #task_budget_gov_utility").on("input", function() {
                    updateTaskCostFields();

                    // Your existing code for showing/hiding fields
                    // ...
                });

                // Call the function on page load to handle the initial state
                updateTaskCostFields();
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
   //วันที่สิ้นสุด *
 $("#task_end_date").datepicker("setEndDate", project_end_date_str);

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
                var budgetItOperating = $("#task_budget_it_operating").val();
                    var budgetItInvestment = $("#task_budget_it_investment").val();
                    var budgetGovUtility = $("#task_budget_gov_utility").val();


                if (fieldId === "task_budget_it_investment") {
                    max = parseFloat(
                        {{ ($projectDetails->budget_it_investment+$increasedData->first()->total_it_investment+ $sum_task_refund_budget_it_investment)-($sum_task_budget_it_investment)  }} );
                        if (budgetItInvestment === "0" || budgetItInvestment === '' || parseFloat(budgetItInvestment) < -0) {
                $("#task_budget_it_investment").val('');
            }
                } else if (fieldId === "task_budget_it_operating") {
                    max = parseFloat(
                        {{ ($projectDetails->budget_it_operating+$increasedData->first()->total_it_operating+ $sum_task_refund_budget_it_operating)-($sum_task_budget_it_operating)  }} );


                        if (budgetItOperating === "0" || budgetItOperating === '' || parseFloat(budgetItOperating) < -0 ) {
                    $("#task_budget_it_operating").val('');
                }
                } else if (fieldId === "task_budget_gov_utility") {
                    max = parseFloat(
                        {{ ($projectDetails->budget_gov_utility+$increasedData->first()->total_gov_utility+ $sum_task_refund_budget_gov_utility)-($sum_task_budget_gov_utility)  }}

                        );

                        if (budgetGovUtility === "0" || budgetGovUtility === '' || parseFloat(budgetGovUtility) < -0) {
                $("#task_budget_gov_utility").val('');
            }
                }

                var current = parseFloat($(this).val().replace(/,/g, ""));
                if (current > max) {
Swal.fire("จำนวนเงินที่ใส่ต้องไม่เกิน " + max.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + " บาท");
$(this).val(0);
}


            });
    });
</script>

            <script>
                $(document).ready(function() {
                    $("#task_cost_it_operating,#task_cost_it_investment, #task_cost_gov_utility").on("input", function() {
                        var max ;
                        var fieldId = $(this).attr('id');
                        var costItOperating = $("#task_cost_it_operating").val();
                    var costItInvestment = $("#task_cost_it_investment").val();
                    var costGovUtility = $("#task_cost_gov_utility").val();

                        if (fieldId === "task_cost_it_investment") {
                            max = parseFloat($("#task_budget_it_investment").val().replace(/,/g, ""))|| 0;
                            if (costItInvestment === "0" || costItInvestment === '' || parseFloat(costItInvestment) < -0) {
                $("#task_cost_it_investment").val('');
                            }


                        } else if (fieldId === "task_cost_it_operating") {
                            max = parseFloat($("#task_budget_it_operating").val().replace(/,/g, ""))|| 0;
                            if (costItOperating === "0" || costItOperating === '' || parseFloat(costItOperating) < -0) {
                $("#task_cost_it_operating").val('');
                            }
                        } else if (fieldId === "task_cost_gov_utility") {
                            max = parseFloat($("#task_budget_gov_utility").val().replace(/,/g, ""))|| 0;
                            if (costGovUtility === "0" || costGovUtility === '' || parseFloat(costGovUtility) < -0) {
                $("#task_cost_gov_utility").val('');
                            }




                        }

                        var current = parseFloat($(this).val().replace(/,/g, ""));
                        if (current > max) {
                            Swal.fire("จำนวนเงินที่ใส่ต้องไม่เกิน " +max.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + " บาท");
                          /*  $(this).val(max.toFixed(2)); */
           $(this).val(0);
                        }
                    });
                });
            </script>


{{-- <script>
    $(document).ready(function() {
        $("#task_pay").on("input", function() {
            var max;
            var budgetType = $("#project_select").val();
            var costFields = ['task_cost_it_operating', 'task_cost_it_investment', 'task_cost_gov_utility'];

// Check if the fieldId is "task_pay"
if (fieldId === "task_pay") {
    // Iterate through the costFields array
    costFields.forEach(function(field) {
        // Get the value of each field, remove commas, convert to float, and add to max
        var fieldValue = $("#" + field).val();
        if (fieldValue) {  // Check if fieldValue is defined
            max += parseFloat(fieldValue.replace(/,/g, ""));
        }
    });
}

            // Disable the fields
/*             $("#task_budget_it_operating,#task_budget_it_investment, #task_budget_gov_utility, #task_cost_it_operating,#task_cost_it_investment, #task_cost_gov_utility").prop('disabled', true);
 */
       /*      if (budgetType === "task_budget_it_operating") {
                max = parseFloat($("#task_cost_it_operating").val().replace(/,/g, ""));
            } else if (budgetType === "task_budget_it_investment") {
                max = parseFloat($("#task_cost_it_investment").val().replace(/,/g, ""));
            } else if (budgetType === "task_budget_gov_utility") {
                max = parseFloat($("#task_cost_gov_utility").val().replace(/,/g, ""));
            } */

            var current = parseFloat($(this).val().replace(/,/g, ""));
            if (current > max) {
                Swal.fire("จำนวนเงินที่ใส่ต้องไม่เกิน " + max.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) +
                    " บาท");
                 /*  $(this).val(max.toFixed(2)); */
           $(this).val(0);
            }
        });

        // Enable the fields when input in #task_pay is finished
       /*  $("#task_pay").on("blur", function() {
            $("#task_budget_it_operating,#task_budget_it_investment, #task_budget_gov_utility, #task_cost_it_operating,#task_cost_it_investment, #task_cost_gov_utility").prop('disabled', false);
        }); */
    });
</script> --}}
<script>
    $(document).ready(function() {
        $("#task_pay").on("input", function() {
            var max = 0;  // Initialize max to 0
            var fieldId = $(this).attr('id');
            var costFields = ['task_cost_it_operating', 'task_cost_it_investment', 'task_cost_gov_utility'];
            var taskpay = $("#task_pay").val();
            // Check if the fieldId is "task_pay"
            if (fieldId === "task_pay") {
                // Iterate through the costFields array
                costFields.forEach(function(field) {
                    // Get the value of each field, remove commas, convert to float, and add to max
                    var fieldValue = $("#" + field).val();
                    if (fieldValue) {  // Check if fieldValue is defined
                        max += parseFloat(fieldValue.replace(/,/g, ""));

                    }

                    if (taskpay === "0" || taskpay === '' || parseFloat(taskpay) < -0) {
                $("#task_pay").val('');}
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
    $("#task_refund_pa_budget").on("input", function() {
        calculateRefund();
    });

    function calculateRefund() {
        var pr_budget, pa_budget, refund;
        var budgetType = $("#project_select").val();

        if (budgetType === "task_budget_it_operating")  {
            pr_budget = parseFloat($("#task_budget_it_operating").val().replace(/,/g, "")) || 0;
            pa_budget = parseFloat($("#task_cost_it_operating").val().replace(/,/g, "")) || 0;
            if(pa_budget != 0){
               refund = pr_budget - pa_budget;
            } else {
               return;  // Skip calculation if pa_budget is 0
            }
        } else if (budgetType === "task_budget_it_investment" ) {
            pr_budget = parseFloat($("#task_budget_it_investment").val().replace(/,/g, "")) || 0;
            pa_budget = parseFloat($("#task_cost_it_investment").val().replace(/,/g, "")) || 0;
            if(pa_budget != 0){
               refund = pr_budget - pa_budget;
            } else {
               return;  // Skip calculation if pa_budget is 0
            }
        } else  if (budgetType === "task_budget_gov_utility") {
            pr_budget = parseFloat($("#task_budget_gov_utility").val().replace(/,/g, "")) || 0;
            pa_budget = parseFloat($("#task_cost_gov_utility").val().replace(/,/g, "")) || 0;
            if(pa_budget != 0){
               refund = pr_budget - pa_budget;
            } else {
               return;  // Skip calculation if pa_budget is 0
            }
        }

        $("#task_refund_pa_budget").val(refund.toFixed(2));
    }
</script> --}}






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
