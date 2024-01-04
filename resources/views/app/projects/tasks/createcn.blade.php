<x-app-layout>
    <x-slot:content>
        <div class="container-fluid">
            {{ Breadcrumbs::render('project.task.create', $project) }}
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
                        <x-card title="{{ __('เพิ่ม สัญญา ') }}">




                                <div class="callout callout-primary row mt-3">

                                    <div class="col-md-3">
                                        <label for="project_fiscal_year"
                                            class="form-label">{{ __('ปีงบประมาณ') }}</label>
                                       {{ $projectDetails->project_fiscal_year }}

                                    </div>
                                    <div class="col-md-3">
                                        <label for="task_start_date2"
                                            class="form-label">{{ __('วันที่เริ่มต้น') }}</label>

                              {{ Helper::Date4(date('Y-m-d H:i:s', $projectDetails->project_start_date)) }}

                                    </div>
                                    <div class="col-md-3">
                                        <label for="task_end_date2"
                                            class="form-label">{{ __('วันที่สิ้นสุด') }}</label>

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



                                    <div class="col-md-3 d-none">
                                        <label for="project_status"
                                            class="form-label">{{ __('สถานะงาน/โครงการ') }}</label>
                                        <!-- Here, you would need to fetch the actual status from $projectDetails -->
                                    </div>
                                  {{--   <div class="row mt-3">
                                        <div class="col-md-2">
                                            <label for="task_start_date2"
                                                class="form-label">{{ __('วันที่เริ่มต้น') }}</label>

                                  {{ Helper::Date4(date('Y-m-d H:i:s', $projectDetails->project_start_date)) }}

                                        </div>
                                        <div class="col-md-3">
                                            <label for="task_end_date2"
                                                class="form-label">{{ __('วันที่สิ้นสุด') }}</label>

                                       {{ Helper::Date4(date('Y-m-d H:i:s', $projectDetails->project_end_date)) }}

                                        </div>
                                    </div>
 --}}
                                    <div class="col-md-12 mt-3">


                                        <div class="col-md-12">
                                            <label for="project_description"
                                                class="form-label">{{ __('รายละเอียดโครงการ') }}</label>
                                         {{ $projectDetails->project_description }}
                                        </div>

                                    </div>


{{--
                                        <div class="row">
                                            @if ($projectDetails->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating > 0)
                                                <div class="col-md-4">
                                                    <label for="budget_it_operating"
                                                        class="form-label">{{ __('งบกลาง ICT ') }}</label>
                                                        <div class="col-3">
                                                      {{ number_format($projectDetails->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating, 2) }} บาท

                                                </div>
                                            @endif

                                            @if ($projectDetails->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment > 0)
                                                <div class="col-4">
                                                    <label for="budget_it_investment"
                                                        class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                        <div class="col-3">
                                                       {{ number_format($projectDetails->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment, 2) }} บาท

                                                </div>
                                            @endif

                                            @if ($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility > 0)
                                                <div class="col-md-4">
                                                    <label for="budget_gov_utility"
                                                        class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                    <input type="text"
                                                        placeholder="{{ number_format($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility, 2) }} บาท"
                                                        step="0.01"
                                                         data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                        class="form-control numeral-mask"
                                                        id="budget_gov_utility"
                                                        name="budget_gov_utility" min="0"
                                                        disabled readonly>
                                                </div>
                                            @endif --}}

                                            <div class="row mt-3">
                                                <label
                                                class="form-label">{{ __('งบประมาณที่ได้รับจัดสรร') }}</label>
                                        </div>
                                            <div class="row">
                                                @if ($projectDetails->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating > 0)
                                                <div class="col-3">{{ __('งบกลาง ICT ') }}</div>
                                                    <div class="col-3">{{ number_format($projectDetails->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating, 2) }} บาท</div>

                                                    @endif
                                            </div>
                                            <div class="row">
                                                @if ($projectDetails->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment > 0)
                                                <div class="col-3">{{ __('งบดำเนินงาน') }}</div>
                                                    <div class="col-3">     {{ number_format($projectDetails->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment, 2) }} บาท</div>
                                                @endif
                                            </div>
                                            <div class="row">
                                                @if ($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility > 0)
                                                <div class="col-3">{{ __('ค่าสาธารณูปโภค') }}</div>
                                                    <div class="col-3">{{ number_format($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility, 2) }}บาท</div>
                                                @endif
                                            </div>
                                        </div>




                                                {{--        <div class="d-none  col-md-4">
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
                                                        </div> --}}
                                </div>

                                <form method="POST"
                                action="{{ route('project.task.store', $project) }}"

                                class="row needs-validation"
                                novalidate>
                                @csrf
                                <div class="d-none  col-md-4">
                                    <label for="task_type" class="form-label">{{ __('งาน/โครงการ') }}</label> <span
                                        class="text-danger">*</span>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="task_type"
                                            id="task_type1" value="1" checked>
                                        <label class="form-check-label" for="task_type1">
                                            มี PA
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="task_type"
                                            id="task_type2" value="2">
                                        <label class="form-check-label" for="task_type2">
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
                                    @if (session('contract_budget_type'))
                                    contract_budget_type : {{ session('contract_budget_type') }}
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



                                <div id="mm_form">

                              {{--       <div class="d-none col-md-4">
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
                                    </div> --}}
                                    <div class="callout callout-primary row mt-3">

                                        <div class="row">
                                            <div class="col-md-4 mt-3">
                                                <label for="task_mm"
                                                    class="form-label">{{ __('เลขที่ MM/เลขที่ สท.') }}</label>
                                                <span class="text-danger">*</span>

                                                <input type="text" class="form-control"
                                                    id="task_mm" name="task_mm"  required  >
                                                <div class="invalid-feedback">
                                                    {{ __('เลขที่ MM/เลขที่ สท. ') }}
                                                </div>
                                            </div>

                                            <div class="col-md-8 mt-3">
                                                <label for="taskcon_mm_name"
                                                    class="form-label">{{ __('ชื่อ MM / ชื่อบันทึกข้อความ') }}</label>


                                                <input type="text" class="form-control"
                                                    id="taskcon_mm_name" name="taskcon_mm_name"  value= {{ session('contract_mm_name') }}>
                                                <div class="invalid-feedback">
                                                    {{ __('ชื่อสัญญา ซ้ำ') }}
                                                </div>
                                            </div>

                                            <div class="col-md-3 mt-3">

                                                <label for="task_mm_budget"
                                                    class="form-label">{{ __('วงเงินที่ขออนุมัติ') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control numeral-mask"
                                                    id="task_mm_budget" name="task_mm_budget"
                                                    min="0"  value={{ session('contract_mm_budget') }} >

                                                <div class="invalid-feedback">
                                                    {{ __('mm') }}
                                                </div>


                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-9 mt-3">
                                                <div class="form-group">
                                                    <label for="task_contract"
                                                        class="form-label">{{ __('สัญญา') }}</label> <span
                                                        class="text-danger"></span>
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

                                            @if (session('contract_id') == 0)
                                            <div class="col-md-3 mt-4">
                                                {{--  <a href="{{ route('contract.create', ['origin' => $project,'project'=>$project ,'taskHashid' => $task->hashid]) }}" class="btn btn-success text-white">เพิ่มสัญญา/ใบจ้าง</a> --}}
                                    {{--             <a href="{{ route('contract.create', ['origin' => $project, 'project' => $project, 'taskHashid' => $task->hashid]) }}"
                                                    class="btn btn-success text-white"
                                                    target="contractCreate">เพิ่มสัญญา</a> --}}

                                                <a href="{{ route('contract.create', ['origin' => $project, 'project' => $project]) }}"
                                                    class="btn btn-success text-white"
                                                    target="contractCreate">เพิ่มสัญญา</a>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label for="task_name"
                                                class="form-label">{{ __('ชื่อรายการ') }}</label>
                                               {{--  <span class="text-danger">*</span> --}}
                                            <input type="text" class="form-control" id="task_name" name="task_name"
                                            value= {{ session('contract_name') }}>
                                            <div class="invalid-feedback">
                                                {{ __('ชื่อรายการ') }}
                                            </div>

                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label for="task_start_date"
                                                    class="form-label">{{ __('วันที่เริ่มต้น') }}</label>
                                                <span class="text-danger">*</span>
                                                <input class="form-control" id="task_start_date"
                                                    name="task_start_date" name="task_start_date"
                                                    @if (session('contract_id') == 0)
                                                    value="{{ Helper::calculateFiscalYearDates($projectDetails['project_fiscal_year'])['fiscalyear_start'] }}"
                                                    @else
                                                    value= {{ Helper::Date4(date('Y-m-d H:i:s', (session('contract_start_date')))) }}
                                                    @endif
                                                    required>


                                            </div>
                                            <div class="col-md-6">
                                                <label for="task_end_date"
                                                    class="form-label">{{ __('วันที่สิ้นสุด') }}</label>
                                                <span class="text-danger">*</span>
                                                <input class="form-control" id="task_end_date"
                                                    name="task_end_date" name="task_start_date"
                                                    @if (session('contract_id') == 0)
                                                    value="{{ Helper::calculateFiscalYearDates($projectDetails['project_fiscal_year'])['fiscalyear_end'] }}"
                                                    @else
                                                    value= {{ Helper::Date4(date('Y-m-d H:i:s', (session('contract_end_date')))) }}
                                                    @endif
                                                    required>
                                            </div>
                                        </div>
                               {{--          <div class="col-md-4 mt-3">
                                            <label for="task_mm_budget"
                                                class="form-label">{{ __('วงเงิน (บาท) MM') }}</label>
                                                <input type="text" placeholder="0.00"
                                                step="0.01"
                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                class="form-control numeral-mask"
                                                id="task_mm_budget"
                                                name="task_mm_budget"
                                                min="0"
                                                value={{ session('contract_mm_budget') }}>

                                        </div> --}}
                                    </div>




                                    <div class="callout callout-warning">
                                        <div class="row ">
                                           {{--  <div class="col-md-4 mt-3">
                                                <label for="project_select"
                                                    class="form-label">{{ __('ประเภท งบประมาณ') }}</label>
                                                <span class="text-danger">*</span>
                                                <select class="form-control" name="project_select" id="project_select" required>
                                                    <option selected disabled value="">เลือกประเภท...</option>
                                                        <option value="1" {{ session('contract_budget_type') == 1 ? 'selected' : '' }}>งบกลาง ICT</option>

                                                        <option value="2" {{ session('contract_budget_type') == 2 ? 'selected' : '' }}>งบดำเนินงาน</option>

                                                        <option value="3" {{ session('contract_budget_type') == 3 ? 'selected' : '' }}>ค่าสาธารณูปโภค</option>

                                                </select>

                                            </div> --}}

                                            {{--    <div class="project_select">
                                                    {{ __('ประเภท งบประมาณ') }}
                                                </div> --}}
                                                <div class="row mt-3">
                                                    <label
                                                    class="form-label">{{ __('งบประมาณที่ได้รับจัดสรร') }}</label>
                                            </div>
                                                <div class="row">
                                                    @if ($projectDetails->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating > 0)
                                                    <div class="col-3">{{ __('งบกลาง ICT ') }}</div>
                                                        <div class="col-3">{{ number_format($projectDetails->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating, 2) }} บาท</div>
                                                    @endif
                                                </div>
                                                <div class="row">
                                                    @if ($projectDetails->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment > 0)
                                                    <div class="col-3">{{ __('งบดำเนินงาน') }}</div>
                                                        <div class="col-3">     {{ number_format($projectDetails->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment, 2) }} บาท</div>
                                                    @endif
                                                </div>
                                                <div class="row">
                                                    @if ($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility > 0)
                                                    <div class="col-3">{{ __('ค่าสาธารณูปโภค') }}</div>
                                                        <div class="col-3">{{ number_format($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility, 2) }}บาท</div>
                                                    @endif
                                                </div>
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
                                                             data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                            class="form-control numeral-mask"
                                                            id="task_budget_it_operating"
                                                            name="task_budget_it_operating"
                                                            min="0"   value= {{ session('contract_budget_type') == 1 ? session('contract_mm_budget') : '' }}>


                                                        <div class="invalid-feedback">
                                                            {{ __('ระบุงบกลาง ICT') }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="task_cost_it_operating"
                                                            class="form-label">{{ __('รอการเบิก งบกลาง ICT ') }}</label>
                                                        <input type="text" placeholder="0.00"
                                                            step="0.01"
                                                             data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                            class="form-control numeral-mask"
                                                            id="task_cost_it_operating"
                                                            name="task_cost_it_operating"
                                                            min="0"
                                                            onchange="calculateRefund()"  value={{ session('contract_budget_type') == 1 ? session('contract_pa_budget') : '' }}>


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
                                                             data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                            class="form-control numeral-mask"
                                                            id="task_budget_it_investment"
                                                            name="task_budget_it_investment"
                                                            min="0"
                                                            onchange="calculateRefund()" value={{ session('contract_budget_type') == 2 ? session('contract_mm_budget') : '' }}>


                                                        <div class="invalid-feedback">
                                                            {{ __('งบดำเนินงาน') }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="task_cost_it_investment"
                                                            class="form-label">{{ __('รอการเบิก งบดำเนินงาน ') }}</label>
                                                        <input type="text" placeholder="0.00"
                                                            step="0.01"
                                                             data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                            class="form-control numeral-mask"
                                                            id="task_cost_it_investment"
                                                            name="task_cost_it_investment"
                                                            min="0"
                                                            onchange="calculateRefund()" value={{ session('contract_budget_type') == 2 ? session('contract_pa_budget') : '' }}>


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
                                                             data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                            class="form-control numeral-mask"
                                                            id="task_budget_gov_utility"
                                                            name="task_budget_gov_utility"
                                                            min="0"
                                                            onchange="calculateRefund()"  value={{ session('contract_budget_type') == 3 ? session('contract_mm_budget') : '' }}>


                                                        <div class="invalid-feedback">
                                                            {{ __('ค่าสาธารณูปโภค') }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="task_cost_gov_utility"
                                                            class="form-label">{{ __('รอการเบิก งบสาธารณูปโภค ') }}</label>
                                                        <input type="text" placeholder="0.00"
                                                            step="0.01"
                                                             data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                            class="form-control numeral-mask"
                                                            id="task_cost_gov_utility"
                                                            name="task_cost_gov_utility"
                                                            min="0"
                                                            onchange="calculateRefund()"   value={{ session('contract_budget_type') == 3 ? session('contract_pa_budget') : '' }}>


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
                                                        name="task_refund_pa_budget" min="0" readonly value={{ session('contract_refund_pa_budget') }} >




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
                                <div class="d-none col-md-3">

                                </label>
                                {{ Form::select('task_parent_sub', \Helper::contractType(), '99', ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...', 'id' => 'contract_type']) }}

                            </div>
                              {{--   <div class="row">
                                    <h4>งบประมาณ</h4>
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-md-4 needs-validation" novalidate>
                                                <label for="task_budget_it_operating"
                                                    class="form-label">{{ __('งบกลาง ICT') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control numeral-mask" id="task_budget_it_operating"
                                                    name="task_budget_it_operating"     value=
                                                    {{ session('contract_budget_type') == 1 ? session('contract_pa_budget') : '' }}>

                                                <div class="invalid-feedback">
                                                    {{ __('ระบุงบกลาง ICT') }}

                                                </div>

                                                ไม่เกิน
                                                {{ number_format($request->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating) }}
                                                บาท


                                              <span id="password-error"> </span>


                                            </div>
                                            <div class="col-md-4">
                                                <label for="task_budget_it_investment"
                                                    class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control numeral-mask" id="task_budget_it_investment"
                                                    name="task_budget_it_investment"   value=
                                                    {{ session('contract_budget_type') == 2 ? session('contract_pa_budget') : ''  }}>
                                                <div class="invalid-feedback">
                                                    {{ __('ระบุงบดำเนินงาน') }}
                                                </div>
                                                ไม่เกิน
                                                {{ number_format($request->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment) }}
                                                บาท
                                            </div>
                                            <div class="col-md-4">
                                                <label for="task_budget_gov_utility"
                                                    class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control numeral-mask" id="task_budget_gov_utility"
                                                    name="task_budget_gov_utility"  value=
                                                    {{ session('contract_budget_type') == 3 ?  session('contract_pa_budget') : '' }}>
                                                <div class="invalid-feedback">
                                                    {{ __('ระบุค่าสาธารณูปโภค') }}
                                                </div>
                                                ไม่เกิน
                                                {{ number_format($request->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility) }}
                                                บาท
                                            </div>
                                        </div>
                                    </div>
                                         {{ $request->budget_it_investment - $sum_task_budget_it_investment+ $sum_task_refund_budget_it_investment }}
                                {{ $request->budget_gov_utility - $sum_task_budget_gov_utility+ $sum_task_refund_budget_gov_utility }}
                                {{ $request->budget_it_operating - $sum_task_budget_it_operating+ $sum_task_refund_budget_it_operating }}

                                </div> --}}

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

    </x-slot:css>
    <x-slot:javascript>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js"></script>
       {{--  <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script> --}}
        <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
        <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>

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
                $(".numeral-mask").inputmask();
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
        });

        $('#task_end_date').on('changeDate', function() {
            var endDate = $(this).datepicker('getDate');
            $("#task_start_date").datepicker("setEndDate", endDate);
        });
    });
</script>







        <script>
           $(document).ready(function() {
    $("#task_budget_it_investment, #task_budget_gov_utility, #task_budget_it_operating").on("input", function() {
        var max = 0;
        var fieldId = $(this).attr('id');
        var budgetItOperating = $("#task_budget_it_operating").val();
        var budgetItInvestment = $("#task_budget_it_investment").val();
        var budgetGovUtility = $("#task_budget_gov_utility").val();
        var costItOperating = $("#task_cost_it_operating").val();
        var costItInvestment = $("#task_cost_it_investment").val();
        var costGovUtility = $("#task_cost_gov_utility").val();


        if (fieldId === "task_budget_it_investment") {

            max = parseFloat({{ $request->budget_it_investment - $sum_task_budget_it_investment+ $sum_task_refund_budget_it_investment }});
            if (budgetItInvestment === "0" || budgetItInvestment === '' || parseFloat(budgetItInvestment) < -0) {
                $("#task_budget_it_investment").val('');
            }

        }


        else if (fieldId === "task_budget_gov_utility") {
            max = parseFloat({{ $request->budget_gov_utility - $sum_task_budget_gov_utility+ $sum_task_refund_budget_gov_utility }});
            if (budgetGovUtility === "0" || budgetGovUtility === '' || parseFloat(budgetGovUtility) < -0) {
                $("#task_budget_gov_utility").val('');
            }
        } else if (fieldId === "task_budget_it_operating") {
            if (budgetItOperating === "0" || budgetItOperating === '' ||  parseFloat(budgetItOperating) < -0) {
                    $("#task_budget_it_operating").val('');
                }

            max = parseFloat({{ $request->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating }});
        }

        var current = parseFloat($(this).val().replace(/,/g , ""));
        if (current > max) {
            Swal.fire("จำนวนเงินที่ใส่ต้องไม่เกิน "  + max.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + " บาท");
           /*  $(this).val(max.toFixed(2)); */
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
            var budgetItOperating = $("#task_budget_it_operating").val();
        var budgetItInvestment = $("#task_budget_it_investment").val();
        var budgetGovUtility = $("#task_budget_gov_utility").val();
        var costItOperating = $("#task_cost_it_operating").val();
        var costItInvestment = $("#task_cost_it_investment").val();
        var costGovUtility = $("#task_cost_gov_utility").val();

            if (fieldId === "task_cost_it_investment") {
                if(costItInvestment === "0" || costItInvestment === '' || parseFloat(costItInvestment) < -0){
                    $("#task_cost_it_investment").val('');
                }
                max = parseFloat($("#task_budget_it_investment").val().replace(/,/g, ""))|| 0;
            } else if (fieldId === "task_cost_it_operating") {
                if(costItOperating === "0" || costItOperating === '' || parseFloat(costItOperating) < -0){
                    $("#task_cost_it_operating").val('');
                }
                max = parseFloat($("#task_budget_it_operating").val().replace(/,/g, ""))|| 0;
            } else if (fieldId === "task_cost_gov_utility") {
                if(costGovUtility === "0" || costGovUtility === '' || parseFloat(costGovUtility) < -0){
                    $("#task_cost_gov_utility").val('');
                }
                max = parseFloat($("#task_budget_gov_utility").val().replace(/,/g, ""))|| 0;
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


       <script>
            $(document).ready(function() {
                // Check initial state of the "มี PA" radio button


                if ($('#task_type1').is(':checked')) {
                    $('#contractSelection').show();
                } else {
                    $('#contractSelection').hide();
                }

                // Listen for changes on the radio buttons
                $('input[type=radio][name=task_type]').change(function() {
                    if (this.value == '1') {
                        $('#contractSelection').show();
                    } else {
                        $('#contractSelection').hide();
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

    // Check for task_budget_it_operating
    console.log(budgetItOperating);
    console.log(costItOperating);
    if (budgetItOperating === "0" || budgetItOperating === '' || budgetItOperating > costItOperating  ) {
        $("#task_cost_it_operating").val('');
    }

    // Check for task_budget_it_investment
    if (budgetItInvestment === "0" || budgetItInvestment === '' || budgetItInvestment > costItInvestment) {
        $("#task_cost_it_investment").val('');
    }

    // Check for task_budget_gov_utility
    if (budgetGovUtility === "0" || budgetGovUtility === '' || budgetGovUtility > costGovUtility) {
        $("#task_cost_gov_utility").val('');
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
    $(document).ready(function() {
        $("#task_mm_budget").on("input", function() {
            var max = 0;  // Initialize max to 0
            var fieldId = $(this).attr('id');
            var taskmmbudget = $("#task_mm_budget").val();
            // If using blade syntax to inject PHP variables into JavaScript, ensure this part is correct.
            var budgetFields = [
                {{ $request->budget_it_investment - $sum_task_budget_it_investment+ $sum_task_refund_budget_it_investment }},
                {{ $request->budget_it_operating - $sum_task_budget_it_operating+ $sum_task_refund_budget_it_operating }},
                {{ $request->budget_gov_utility - $sum_task_budget_gov_utility+ $sum_task_refund_budget_gov_utility }}

            ];

            // Check if the fieldId is "task_mm_budget"
            if (fieldId === "task_mm_budget") {
                if (taskmmbudget === "0" || taskmmbudget === '' || parseFloat(taskmmbudget) < -0 ) {
        $("#task_mm_budget").val('');
    }
                // Iterate through the budgetFields array
                budgetFields.forEach(function(fieldValue) {
                    if (fieldValue) {  // Check if fieldValue is defined
                        max += fieldValue;  // Assuming fieldValue is a number, if not, use parseFloat(fieldValue) or similar
                    }
                });
            }

            var current = parseFloat($(this).val().replace(/,/g, ""));
            if (current > max) {
                Swal.fire("จำนวนเงินที่ใส่ต้องไม่เกิน <P> งบประมาณ" + max.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + " บาท");
                $(this).val(0);
            }
        });
    });
</script>





<script>
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
</script>




    </x-slot:javascript>
</x-app-layout>
