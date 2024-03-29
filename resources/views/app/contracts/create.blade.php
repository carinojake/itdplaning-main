    <x-app-layout>
        <x-slot:content>
            <div class="container-fluid">

                {{-- {{ Breadcrumbs::render('contract.create') }} --}}
                <div class="d-none">
                @if ($projectDetails)
                    {{ $projectDetails->project_name }}
                    {{ $projectDetails->project_fiscal_year }}
                    {{ $projectDetails->project_type }}
                    {{ $projectDetails->budget_it_operating }}
                    {{ $projectDetails->budget_it_investment }}
                    {{ $projectDetails->budget_gov_utility }}
                    @else
                @endif

                @if ($ta)
                    {{ $ta->task_name }}
                @else
                @endif

                {{ $projecthashid }}

            </div>


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
                            <x-card title="{{ __('เพิ่มสัญญา CN ') }}">
                                <x-slot:toolbar>
                                    {{-- <a href="{{ route('contract.create') }}" class="btn btn-success text-white">C</a>

  <a href="{{ route('project.task.createsub', $project) }}" class="btn btn-primary text-white">ไปยังหน้าการใช้จ่ายของงาน</a> --}}
                                </x-slot:toolbar>






                                <form   id="formId" method="POST" action="{{ route('contract.store') }}" class="row needs-validation"
                                novalidate enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="origin" value="{{ $origin }}">

                                    <input type="hidden" name="project" value="{{ $project}}">

                                    <input type="hidden" name="task" value="{{ $task }}">

                                    <input type="hidden" name="projecthashid" value="{{ $projecthashid }}">
                                    <div class="row g-3 align-items-center callout callout-success ">


                                        <div class="row g-3 align-items-center">
                                            <div class="d-none">
                                                @if($projectDetails->project_type == 1)

                                                    <input type="text" class="form-control" id="contract_project_type" name="contract_project_type" value="p" readonly>


                                                @elseif($projectDetails->project_type == 2)
                                                    <input type="text" class="form-control" id="contract_project_type" name="contract_project_type" value="j" readonly>

                                                @endif
                                                </div>
                                            <!-- Fiscal Year -->
                                            <div class="col-md-3">
                                                <label for="contract_fiscal_year"
                                                    class="form-label">{{ __('ปีงบประมาณ') }}</label>
                                                <span class="text-danger"></span>
                                                <input type="text" class="form-control" id="contract_fiscal_year"
                                                name="contract_fiscal_year"    value="{{  $projectDetails->project_fiscal_year }}"  readonly >
                                                @error('contract_fiscal_year')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="d-none  col-md-4">
                                                <label for="contract_type_pa"
                                                    class="form-label">{{ __('งาน/โครงการ') }}</label> <span
                                                    class="text-danger">*</span>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="contract_type_pa" id="contract_type_pa" value="1"
                                                        checked>
                                                    <label class="form-check-label" for="contract_type_pa1">
                                                        มี PA
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="contract_type_pa" id="contract_type_pa2" value="2">
                                                    <label class="form-check-label" for="contract_type_pa2">
                                                        ไม่มี PA
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Task Parent -->
                                            {{--  <div class="col-md-3">
                                                <label for="task_parent" class="form-label">{{ __('เป็นกิจกรรม') }}</label>
                                                <select name="task_parent" id="task_parent" class="form-control">
                                                    <option value="">ไม่มี</option>
                                                    @if ($ta?sks)
                                                        @foreach ($ta?sks as $subtask)
                                                            @if ($subtask->task_id)
                                                                <option value="{{ $subtask->task_id }}" {{ $subtask->task_parent == $subtask->task_id ? 'selected' : '' }}>
                                                                    {{ $subtask->task_name }}
                                                                </option>
                                                            @elseif ($subtask->task_parent == 1 && $subtask->task_id)
                                                                <!-- code to display when condition is true -->
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{ __('กิจกรรม') }}
                                                </div>
                                            </div> --}}
                                            <!-- Contract Type -->

                                            @if ($origin)

                                                <div class="col-md-3">
                                                    <label for="contract_type" class="form-label">{{ __('ประเภท') }}
                                                        <span class="text-danger">*</span></label>
                                                    <select name="contract_type" id="contract_type"
                                                        class="form-control" required>
                                                        <option value="" disabled selected>
                                                            {{ __('เลือกประเภท...') }}
                                                        </option>
                                                        @foreach (\Helper::contractType() as $key => $type)
                                                            <option value="{{ $key }}">{{ $type }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @else
                                                <div class="col-md-3">
                                                    <label for="contract_type"
                                                        class="form-label">{{ __('ประเภท') }}</label>
                                                    <span class="text-danger">*</span>
                                                    <select name="contract_type" id="contract_type"
                                                        class="form-control" required>
                                                        <option value="" disabled selected>
                                                            {{ __('เลือกประเภท...') }}
                                                        </option>
                                                        @foreach (\Helper::contractType() as $key => $type)
                                                            <option value="{{ $key }}">{{ $type }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                        </div>




                                        <!-- Task Parent -->
                                        <div class="col-md-6">
                                            <label for="task_parent"
                                                class="form-label">{{ __('อยู่ภายใต้กิจกรรม') }}</label>
                                            <select class="form-control" name="task_parent" id="task_parent">
                                                <option value="">{{ __('เลือกประเภท...') }}
                                                </option>
                                            </select>
                                            <div class="invalid-feedback">
                                                {{ __('กิจกรรม') }}
                                            </div>
                                        </div>
                                        <!-- Contract Type -->
                                        <div class="col-md-3 mt-3">
                                            <label for="contract_type_budget"
                                                class="form-label">{{ __('วงเงิน') }}</label>
                                            <input type="text" class="form-control" name="contract_type_budget"
                                                id="contract_type_budget" value="-">
                                        </div>
                                        @endif
                                        {{--
                                         {{ Form::select('contract_type', \Helper::taskconrounds(), null, ['class' => ' js-example-basic-single', 'placeholder' => 'งวด...', 'id' => 'rounds', 'name' => 'change']) }}

                                        <div class="col-md-3">
                                    <label for="contract_type" class="form-label">{{ __('ค่าใช้จ่ายสำนักงาน') }}</label>

                                    {{ Form::select('contract_type', \Helper::contractType(), null, ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...', 'id' => 'contract_type']) }}
                                </div>
                            </div> --}}

                                        <!--  1  -->
                                        {{--   <div class="row fw-semibold mt-3">

                                            <div class="row">
                                                @if ($sum_task_budget_it_operating > 0)
                                                    <div class="col-6">{{ __('งบกลาง ICT') }}</div>
                                                    {{ number_format($sum_task_budget_it_operating) }} บาท
                                                @endif
                                            </div>
                                            <div class="row">
                                                @if ($sum_task_budget_it_investment > 0)
                                                    <div class="col-6">{{ __('งบดำเนินงาน') }}</div>
                                                    {{ number_format($sum_task_budget_it_investment) }} บาท
                                                @endif
                                            </div>
                                            <div class="row">
                                                @if ($sum_task_budget_gov_utility > 0)
                                                    <div class="col-6">{{ __('ค่าสาธารณูปโภค') }}</div>
                                                    {{ number_format($sum_task_budget_gov_utility) }} บาท
                                                @endif
                                            </div>
                                        </div> --}}
                                        @if ($projectDetails != null)
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
                                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                                class="form-control numeral-mask"
                                                                id="budget_it_operating" name="budget_it_operating"
                                                                min="0" disabled readonly>
                                                        </div>
                                                    @endif

                                                    @if ($projectDetails->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment > 0)
                                                        <div class="col-4">
                                                            <label for="budget_it_investment"
                                                                class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                            <input type="text"
                                                                placeholder="{{ number_format($projectDetails->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment, 2) }} บาท"
                                                                step="0.01"
                                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                                class="form-control numeral-mask"
                                                                id="budget_it_investment" name="budget_it_investment"
                                                                min="0" disabled readonly>
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
                                                                id="budget_gov_utility" name="budget_gov_utility"
                                                                min="0" disabled readonly>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        <div class="callout callout-info">
                                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="flush-headingOne">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-coreui-toggle="collapse"
                                                            data-coreui-target="#flush-collapseOne"
                                                            aria-expanded="false" aria-controls="flush-collapseOne">
                                                            ข้อมูลการจัดซื้อจัดจ้าง (เลขที่สัญญา,MM,PR)
                                                        </button>
                                                    </h2>
                                                    <div id="flush-collapseOne" class="accordion-collapse collapse"
                                                        aria-labelledby="flush-headingOne"
                                                        data-coreui-parent="#accordionFlushExample">
                                                        <div class="accordion-body">


                                                            <div id="mm_form" style="display:none;">
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
                                                                                  $projectDetails->budget_it_operating  >
                                                                                        0)
                                                                                    <option selected value="1">
                                                                                        งบกลาง ICT</option>
                                                                                @endif
                                                                                @if (  $projectDetails->budget_it_investment
                                                                                       >
                                                                                        0)
                                                                                    <option selected value="2">
                                                                                        งบดำเนินงาน</option>
                                                                                @endif
                                                                                @if (
                                                                                     $projectDetails->budget_gov_utility >
                                                                                        0)
                                                                                    <option selected value="3">
                                                                                        ค่าสาธารณูปโภค</option>
                                                                                @endif
                                                                            </select>
                                                                        </div>

                                                                        {{--    <div class="project_select">
                                                                                {{ __('ประเภท งบประมาณ') }}
                                                                            </div> --}}
                                                                    </div>
                                                                    <div class="row mt-3">

                                                                        <div class="row mt-3">
                                                                            <div class="col-md-3">

                                                                                <label for="contract_mm"
                                                                                    class="form-label">{{ __('บันทึกข้อความ (MM)/เลขที่ สท.') }}</label>
                                                                                <span class="text-danger"></span>
                                                                                <input type="text"
                                                                                class="form-control "
                                                                                    id="contract_mm"
                                                                                    name="contract_mm"
                                                                                    value="{{ $ta?->task_mm }}"
                                                                                    required autofocus
                                                                                    >

                                                                                    <div class="invalid-feedback">
                                                                                        {{ __('บันทึกข้อความ (MM)/เลขที่ สท.') }}
                                                                                    </div>
                                                                            </div>


                                                                            <div class="col-md-6 ">
                                                                                <label for="contract_mm_name"
                                                                                    class="form-label">{{ __('ชื่อ MM / ชื่อบันทึกข้อความ') }}</label>


                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    id="contract_mm_name"
                                                                                    name="contract_mm_name"
                                                                                    value="{{ $ta?->task_mm_name }}"

                                                                                    required
                                                                                    autofocus>
                                                                                    <div id="contract_mm_name_feedback" class="invalid-feedback">
                                                                                        {{ __('ชื่อmm ') }}
                                                                                    </div>
                                                                            </div>
                                                                            <div class="col-md-3 ">
                                                                                <label for="contract_mm_budget"
                                                                                    class="form-label">{{ __('วงเงิน (บาท) MM') }}</label>
                                                                                <span class="text-danger"></span>

                                                                                <input type="text"
                                                                                    placeholder="0.00" step="0.01"
                                                                                    class="form-control"
                                                                                    id="contract_mm_budget"
                                                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                                                    class="form-control numeral-mask"
                                                                                    name="contract_mm_budget"
                                                                                    min="0"
                                                                                    value="{{ $ta?->task_mm_budget }}"
                                                                                    required autofocus>
                                                                            </div>
                                                                        </div>


                                                                        <div class="col-md-3 mt-3">
                                                                            <label for="contract_number"
                                                                                class="form-label">{{ __('เลขที่สัญญา  ') }}</label>
                                                                            <span class="text-danger">*</span>
                                                                            <input type="text" class="form-control"
                                                                                id="contract_number"
                                                                                name="contract_number" required
                                                                                autofocus>

                                                                            <div id="contract_number" class="invalid-feedback">
                                                                                {{ __('เลขที่สัญญา') }}
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-9 mt-3 ">
                                                                            <label for="contract_name"
                                                                                id="contract_name_label"
                                                                                class="form-label">{{ __('ชื่อ PO/ER/CN/ ค่าใช้จ่ายสำนักงาน') }}</label>

                                                                            <input type="text" class="form-control"
                                                                                id="contract_name"
                                                                                name="contract_name" required
                                                                                autofocus>
                                                                                <div  id="contract_name_label_feedback" class="invalid-feedback">
                                                                                    {{ __('ชื่อสัญญา') }}
                                                                                </div>
                                                                        </div>


                                                                    </div>



                                                                    <div id="pr_form" style="display:none;">
                                                                        <div class="row mt-3">
                                                                            <div class="col-md-3">
                                                                                <label for="contract_pr"
                                                                                    class="form-label">{{ __('ใบขอดำเนินการซื้อ/จ้าง (PR)') }}</label>
                                                                                <span class="text-danger"></span>

                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    id="contract_PR"
                                                                                    name="contract_pr"
                                                                                    required
                                                                                    autofocus


                                                                                    >
                                                                                <div class="invalid-feedback">
                                                                                    {{ __('ใบขอดำเนินการซื้อ/จ้าง (PR)') }}
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-3">
                                                                                <label for="contract_pr_budget"
                                                                                    class="form-label">{{ __('จำนวนเงิน (บาท) PR') }}</label>
                                                                                <span class="text-danger"></span>

                                                                                <input type="taxt"
                                                                                    placeholder="0.00" step="0.01"
                                                                                    class="form-control"
                                                                                    id="contract_pr_budget"
                                                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                                                    class="form-control numeral-mask"
                                                                                    name="contract_pr_budget"
                                                                                    min="0"
                                                                                    value="{{ $ta?->task_mm_budget }}"
                                                                                    onchange="calculateRefund()">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>






                                                            <div id="pa_form" style="display:none;">
                                                                <div class="callout callout-warning">

                                                                    <div class="row mt-3">
                                                                        <div class="col-md-4">
                                                                            <label for="contract_pa"
                                                                                class="form-label">{{ __('ใบขออนุมัติซื้อ/จ้าง (PA)') }}</label>
                                                                            <span class="text-danger"></span>

                                                                            <input type="text" class="form-control"
                                                                                id="contract_PA" name="contract_pa"  required autofocus>
                                                                            <div class="invalid-feedback">
                                                                                {{ __('ใบขออนุมัติซื้อ/จ้าง (PA) ') }}
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                            <label for="contract_pa_budget"
                                                                                class="form-label">{{ __('จำนวนเงิน (บาท) PA') }}</label>
                                                                            <span class="text-danger"></span>

                                                                            <input type="taxt" placeholder="0.00"
                                                                                step="0.01" class="form-control"
                                                                                id="contract_pa_budget"
                                                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                                                class="form-control numeral-mask"
                                                                                name="contract_pa_budget"
                                                                                min="0"
                                                                                onchange="calculateRefund()">
                                                                        </div>
                                                                    </div>
                                                                    <div id="contract_refund_pa_budget_2">
                                                                        <div class=" row mt-3">
                                                                            <div class="col-md-4">
                                                                                <label for="contract_refund_pa_budget"
                                                                                    class="form-label">{{ __('จำนวนคงเหลือหลังเงิน PA') }}</label>
                                                                                <span class="text-danger"></span>

                                                                                <input type="text"
                                                                                    placeholder="0.00" step="0.01"
                                                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                                                    class="form-control numeral-mask"
                                                                                    id="contract_refund_pa_budget"
                                                                                    name="contract_refund_pa_budget"
                                                                                    min="0" readonly>

                                                                            </div>


                                                                        </div>
                                                                    </div>

                                                                    <div id="po_form" style="display:none;">
                                                                        <!-- PO form fields -->

                                                                        <div class="row mt-3">
                                                                            <div class="col-md-4">
                                                                                <label for="contract_po"
                                                                                    class="form-label">{{ __('ใบสั่งซื้อ (PO)') }}</label>
                                                                                <span class="text-danger"></span>

                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    id="contract_PO"
                                                                                    name="contract_po">
                                                                                <div class="invalid-feedback">
                                                                                    {{ __(' ') }}
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-4">
                                                                                <label for="contract_po_budget"
                                                                                    class="form-label">{{ __('จำนวนเงิน (บาท) PO') }}</label>
                                                                                <span class="text-danger"></span>

                                                                                <input type="taxt"
                                                                                    placeholder="0.00" step="0.01"
                                                                                    class="form-control"
                                                                                    id="contract_po_budget"
                                                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                                                    class="form-control numeral-mask"
                                                                                    name="contract_po_budget"
                                                                                    min="0">
                                                                            </div>






                                                                            <div class="col-md-4">
                                                                                <label for="contract_po_start_date"
                                                                                    class="form-label">{{ __('กำหนดวันที่ส่งของ') }}</label>
                                                                                <span class="text-danger"></span>

                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    id="contract_po_start_date"
                                                                                    name="contract_po_start_date">
                                                                                <div class="invalid-feedback">
                                                                                    {{ __(' ') }}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div id="er_form" style="display:none;">
                                                                        <div class="row mt-3">
                                                                            <div class="col-md-4">
                                                                                <label for="contract_er"
                                                                                    class="form-label">{{ __('ใบสั่งจ้าง (ER)') }}</label>
                                                                                <span class="text-danger"></span>

                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    id="contract_ER"
                                                                                    name="contract_er">
                                                                                <div class="invalid-feedback">
                                                                                    {{ __(' ') }}
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-4">
                                                                                <label for="contract_er_budget"
                                                                                    class="form-label">{{ __('จำนวนเงิน (บาท) ER') }}</label>
                                                                                <span class="text-danger"></span>

                                                                                <input type="text"
                                                                                    placeholder="0.00" step="0.01"
                                                                                    class="form-control"
                                                                                    id="contract_er_budget"
                                                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                                                    class="form-control numeral-mask"
                                                                                    name="contract_er_budget"
                                                                                    min="0">
                                                                            </div>

                                                                            <div class="col-md-4">
                                                                                <label for="contract_er_start_date"
                                                                                    class="form-label">{{ __('กำหนดวันที่ส่งมอบงาน') }}</label>
                                                                                <span class="text-danger"></span>

                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    id="contract_er_start_date"
                                                                                    name="contract_er_start_date">
                                                                                <div class="invalid-feedback">
                                                                                    {{ __(' ') }}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div id="cn_form" style="display:none;">
                                                                        <div class="row mt-3">
                                                                            <div class="col-md-4">
                                                                                <label for="contract_cn"
                                                                                    class="form-label">{{ __('สัญญา (CN)') }}</label>
                                                                                <span class="text-danger"></span>

                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    id="contract_cn"
                                                                                    name="contract_cn">
                                                                                <div class="invalid-feedback">
                                                                                    {{ __(' ') }}
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-4">
                                                                                <label for="contract_cn_budget"
                                                                                    class="form-label">{{ __('จำนวนเงิน (บาท) CN') }}</label>
                                                                                <span class="text-danger"></span>

                                                                                <input type="text"
                                                                                    placeholder="0.00" step="0.01"
                                                                                    class="form-control"
                                                                                    id="contract_cn_budget"
                                                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                                                    class="form-control numeral-mask"
                                                                                    name="contract_cn_budget"
                                                                                    min="0">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <label for="contract_description"
                                                                            class="form-label">{{ __('รายละเอียดสัญญา') }}</label>
                                                                        <textarea class="form-control" name="contract_description" id="contract_description" rows="10"></textarea>
                                                                        <div class="invalid-feedback">
                                                                            {{ __('รายละเอียดงาน/โครงการ') }}
                                                                        </div>
                                                                    </div>

                                                                    <div id="ba_form" style="display:none;">
                                                                        <div class="row mt-3">
                                                                            <div class="col-md-4">
                                                                                <label for="contract_ba "
                                                                                    class="form-label">{{ __('ใบยืมเงินรองจ่าย (BA) ') }}</label>
                                                                                {{--  officeexpenses ค่าใช้จ่ายสำนักงาน --}}
                                                                                <span class="text-danger"></span>

                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    id="contract_ba"
                                                                                    name="contract_ba">
                                                                                <div class="invalid-feedback">
                                                                                    {{ __(' ') }}
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-4">
                                                                                <label for="ใบยืมเงินรองจ่าย (BA)"
                                                                                    class="form-label">{{ __('จำนวนเงิน (บาท) BA') }}</label>
                                                                                <span class="text-danger"></span>

                                                                                <input type="text"
                                                                                    placeholder="0.00" step="0.01"
                                                                                    class="form-control"
                                                                                    id="contract_ba_budget"
                                                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                                                    class="form-control numeral-mask"
                                                                                    name="contract_ba_budget"
                                                                                    min="0">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div id="bd_form" style="display:none;">
                                                                        <div class="row mt-3">
                                                                            <div class="col-md-4">
                                                                                <label for="contract_bd "
                                                                                    class="form-label">{{ __('ใบยืมเงินหน่อยงาน (BD)') }}</label>
                                                                                {{--  officeexpenses ค่าใช้จ่ายสำนักงาน --}}
                                                                                <span class="text-danger"></span>

                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    id="contract_bd"
                                                                                    name="contract_bd">
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
                                                                                    id="contract_bd_budget"
                                                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                                                    class="form-control numeral-mask"
                                                                                    name="contract_bd_budget"
                                                                                    min="0">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="pp_form" class="callout callout-danger"
                                                                    style="display:none;">
                                                                    <div class="row mt-3">
                                                                        <div class="col-md-4">
                                                                            <label for="contract_pay"
                                                                                class="form-label">{{ __('งบใบสำคัญ (PP) ') }}</label>
                                                                            <span class="text-danger"></span>

                                                                            <input type="text" class="form-control"
                                                                                id="contract_pp" name="contract_pp">
                                                                            <div class="invalid-feedback">
                                                                                {{ __(' ') }}
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                            <label for="contract_pay"
                                                                                class="form-label">{{ __('จำนวนเงิน (บาท) PP') }}</label>
                                                                            <span class="text-danger"></span>

                                                                            <input type="text" placeholder="0.00"
                                                                                step="0.01" class="form-control"
                                                                                id="contract_pay"
                                                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                                                class="form-control numeral-mask"
                                                                                name="contract_pay" min="0">
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div id="rounds_form" class="callout callout-light"
                                                                    style="display:none;">
                                                                    <div class="row callout callout-warning  mt-3">
                                                                        <label for="contract_juristic_id"
                                                                        class="form-label">{{ __('สัญญา') }}</label>

                                                                        <div class="col-md-3">
                                                                            <label for="contract_start_date"
                                                                                class="form-label">{{ __('วันที่เริ่มต้น สัญญา') }}</label>
                                                                            {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                                                                            <input type="text" class="form-control"
                                                                                id="contract_start_date"
                                                                                name="contract_start_date"
                                                                                value={{ Helper::Date4(date('Y-m-d H:i:s', $projectDetails?->project_start_date)) }}

                                                                                >
                                                                            <!--<div data-coreui-toggle="date-picker" id="contract_start_date"
                                                                    data-coreui-format="dd/MM/yyyy"></div>-->
                                                                        </div>


                                                                        <div class="col-md-3">
                                                                            <label for="contract_end_date"
                                                                                class="form-label">{{ __('วันที่สิ้นสุด สัญญา') }}</label>
                                                                            <input type="text" class="form-control"
                                                                                id="contract_end_date"
                                                                                name="contract_end_date"
                                                                                value={{ Helper::Date4(date('Y-m-d H:i:s', $projectDetails?->project_end_date)) }}

                                                                                >
                                                                            <!-- <div data-coreui-toggle="date-picker" id="contract_end_date"
                                                                    data-coreui-format="dd/MM/yyyy">
                                                                </div>-->
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label for="contract_sign_date"
                                                                                class="form-label">{{ __('วันที่ลงนามสัญญา') }}</label>
                                                                            <input type="text" class="form-control"
                                                                                id="contract_sign_date"
                                                                                name="contract_sign_date">
                                                                            <!--<div data-coreui-toggle="date-picker" id="contract_sign_date"
                                                                    data-coreui-format="dd/MM/yyyy"></div>-->
                                                                        </div>
                                                                    </div>

                                                                    <div id="cn_form" >
                                                                        <div class="row mt-3">





                                                                                    <div class="col-md-4">
                                                                                        <label for="total_pa_budget"
                                                                                            class="form-label">{{ __('เงิน PA') }}</label>
                                                                                        <span class="text-danger"></span>

                                                                                        <input type="text"
                                                                                            placeholder="0.00" step="0.01"
                                                                                             data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                                                            class="form-control numeral-mask"
                                                                                            id="total_pa_budget"
                                                                                            name="total_pa_budget"
                                                                                            min="0"


                                                                                            readonly>

                                                                                    </div>


                                                                                    <div class="col-md-4">
                                                                                        <label for="expenses_sum"
                                                                                            class="form-label">{{ __('ใช้ไป เงินงวดทั้งหมด') }}</label>
                                                                                        <span class="text-danger"></span>
                                                                                        <input type="text"
                                                                                        class="form-control"
                                                                                        id="expenses_sum"
                                                                                        name="expenses_sum" readonly>
                                                                                        <div id="expenses_sum_feedback"class="invalid-feedback">
                                                                                            {{ __('เงินงวดทั้งหมด รวมกันเท่ากับ PA') }}
                                                                                        </div>
                                                                                    </div>




                                                                            <div class="col-md-4">
                                                                                <label for="expenses_delsum"
                                                                                    class="form-label">{{ __('เงินงวดทั้งหมด') }}</label>
                                                                                <span class="text-danger"></span>

                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    id="expenses_delsum"
                                                                                    name="expenses_delsum" readonly>
                                                                                    <div id="expenses_delsum_feedback"class="invalid-feedback">
                                                                                        {{ __('เงินงวดทั้งหมด รวมกันเท่ากับ PA') }}
                                                                                    </div>
                                                                            </div>


                                                                        </div>
                                                                    </div>

                                                                    <div class="row mt-3">
                                                                        <div class="col-md-12">
                                                                            <label id="rounds_label" for="rounds"
                                                                                class="form-label">{{ __('งวดที่') }}</label>
                                                                            <span class="text-danger">*</span>
                                                                            {{ Form::select('contract_type', \Helper::taskconrounds(), null, ['class' => ' js-example-basic-single', 'placeholder' => 'งวด...', 'id' => 'rounds', 'name' => 'change']) }}
                                                                            <div id="tasksContainer"></div>
                                                                            <div class="invalid-feedback">
                                                                                {{ __(' ') }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- 1  -->
                                                    </div>
                                                </div>


                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-coreui-toggle="collapse"
                                                            data-coreui-target="#collapseTwo" aria-expanded="false"
                                                            aria-controls="collapseTwo">
                                                            ข้อมูลสัญญา 2
                                                            (เลขทะเบียนคู่ค้า,วันที่เริ่มต้น-สิ้นสุด,ลงนามสัญญา,
                                                            ประก้น)
                                                        </button>
                                                    </h2>
                                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                                        aria-labelledby="headingTwo"
                                                        data-coreui-parent="#accordionExample">
                                                        <div class="accordion-body">

                                                            <div class="row  callout callout-info mt-3">



                                                                <div class="col-md-3">
                                                                    <label for="contract_juristic_id"
                                                                        class="form-label">{{ __('เลขทะเบียนคู่ค้า') }}</label>
                                                                    <input type="text" class="form-control"
                                                                        id="contract_juristic_id"
                                                                        name="contract_juristic_id" maxlength="13">
                                                                    <div class="invalid-feedback">
                                                                        {{ __('คู่ค้าซ้ำ') }}
                                                                    </div>
                                                                </div>



                                                            </div>






                                                            <div class="row callout callout-danger mt-3">
                                                                <div class="col-md-3">
                                                                    <label for="insurance_start_date"
                                                                        class="form-label">{{ __('วันที่เริ่มต้น ประก้น') }}</label>
                                                                    <span class="text-danger"></span>
                                                                    <input type="text" class="form-control"
                                                                        id="insurance_start_date"
                                                                        name="insurance_start_date">
                                                                    <!-- <div data-coreui-toggle="date-picker" id="insurance_start_date"
                                                            data-coreui-format="dd/MM/yyyy"></div>-->
                                                                </div>


                                                                <div class="col-md-3">
                                                                    <label for="insurance_end_date"
                                                                        class="form-label">{{ __('วันที่สิ้นสุด ประกัน') }}</label>
                                                                    <span class="text-danger"></span>
                                                                    <input type="text" class="form-control"
                                                                        id="insurance_end_date"
                                                                        name="insurance_end_date">
                                                                    <!-- <div data-coreui-toggle="date-picker" id="insurance_end_date"
                                                            data-coreui-format="dd/MM/yyyy">
                                                        </div>-->
                                                                </div>

                                                                <div class="row mt-3">
                                                                    <div class="col-md-3">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                {{ __('ประกัน จำนวนเดือน') }}
                                                                            </div>
                                                                            <div id="insurance_duration_months"
                                                                                class="col-12">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mt-3">
                                                                            <div class="col-12">
                                                                                {{ __('ประกัน จำนวนวัน') }}
                                                                            </div>
                                                                            <div id="insurance_duration_days"
                                                                                class="col-12">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--จบ ข้อมูลสัญญา 2-->




                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingThree">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-coreui-toggle="collapse"
                                                            data-coreui-target="#collapseThree" aria-expanded="false"
                                                            aria-controls="collapseThree">
                                                            เอกสารแนบ
                                                        </button>
                                                    </h2>
                                                    <div id="collapseThree" class="accordion-collapse collapse"
                                                        aria-labelledby="headingThree"
                                                        data-coreui-parent="#accordionExample">
                                                        <div class="accordion-body">

                                                            <!--ข้อมูลสัญญา 3 -->
                                                            {{--        <div class="col-md-12">
                                                                <label for="contract_file" class="form-label">{{ __('อัปโหลดไฟล์') }}</label>
                                                                <input type="file" class="form-control" id="contract_file" name="contract_file">
                                                                <div class="invalid-feedback">
                                                                    {{ __('เอกสารแนบ') }}
                                                                </div>
                                                            </div> --}}
                                                            <div class=" col-md-12 mt-3">
                                                                <label for="file"
                                                                    class="form-label">{{ __('เอกสารแนบ') }}</label>
                                                                <div class="input-group control-group increment ">
                                                                    <input type="file" name="file[]"
                                                                        class="form-control" multiple>
                                                                    <div class="input-group-btn">
                                                                        <button class="btn btn-success"
                                                                            type="button"><i
                                                                                class="glyphicon glyphicon-plus"></i>Add</button>
                                                                    </div>
                                                                </div>
                                                                <div class="clone d-none">
                                                                    <div class="control-group input-group"
                                                                        style="margin-top:10px">
                                                                        <input type="file" name="file[]"
                                                                            class="form-control" multiple>
                                                                        <div class="input-group-btn">
                                                                            <button class="btn btn-danger"
                                                                                type="button"><i
                                                                                    class="glyphicon glyphicon-remove"></i>
                                                                                Remove</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{--  <div class="col-md-12 mt-3">
                                                                <label for="contract_mm_name"
                                                                    class="form-label">{{ __('ชื่อ MM / ชื่อบันทึกข้อความ') }}</label>


                                                                <input type="text" class="form-control"
                                                                    id="contract_mm_name" name="contract_mm_name"
                                                                    required autofocus>
                                                                <div class="invalid-feedback">
                                                                    {{ __('ชื่อสัญญา ซ้ำ') }}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 mt-3">
                                                                <label for="contract_name" id="contract_name_label"
                                                                    class="form-label">{{ __('ชื่อ PO/ER/CN/ ค่าใช้จ่ายสำนักงาน') }}</label>

                                                                <input type="text" class="form-control"
                                                                    id="contract_name" name="contract_name" required
                                                                    autofocus>
                                                                <div class="invalid-feedback">
                                                                    {{ __('ชื่อสัญญา ซ้ำ') }}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label for="contract_description"
                                                                    class="form-label">{{ __('รายละเอียดสัญญา') }}</label>
                                                                <textarea class="form-control" name="contract_description" id="contract_description" rows="10"></textarea>
                                                                <div class="invalid-feedback">
                                                                    {{ __('รายละเอียดงาน/โครงการ') }}
                                                                </div>
                                                            </div>
                                                        </div> --}}




                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- -->

                                            <!--   <div class="col-md-4">
                        <label for="contract_start_date" class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span
                            class="text-danger">*</span>
                        {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                        <div data-coreui-toggle="date-picker" id="contract_start_date"
                            data-coreui-format="dd/MM/yyyy"></div>
                    </div>
                    <div class="col-md-4">
                        <label for="contract_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span
                            class="text-danger">*</span>

                        <div data-coreui-toggle="date-picker" id="contract_end_date" data-coreui-format="dd/MM/yyyy">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="contract_sign_date" class="form-label">{{ __('วันที่ลงนามสัญญา') }}</label>

                        <div data-coreui-toggle="date-picker" id="contract_sign_date"
                            data-coreui-format="dd/MM/yyyy"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="contract_acquisition" class="form-label">{{ __('วืธีการ') }}</label>
                        <span class="text-danger">*</span>
                        {{ Form::select('contract_acquisition', \Helper::contractAcquisition(), null, ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...']) }}
                        <div class="invalid-feedback">
                            {{ __('สัญญา') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="contract_type" class="form-label">{{ __('ประเภทสัญญา') }}</label>
                        <span class="text-danger">*</span>
                        {{ Form::select('contract_type', \Helper::contractType(), null, ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...']) }}
                        <div class="invalid-feedback">
                            {{ __('สัญญา') }}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="contract_projectplan" class="form-label">{{ __('หมายเหตุ') }}</label>
                        <input type="text" class="form-control" id="contract_projectplan"
                            name="contract_projectplan" maxlength="50">

                        <div class="invalid-feedback">
                            {{ __('หมายเหตุ') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="contract_mm" class="form-label">{{ __('เลขที่ MM') }}</label> <span
                            class="text-danger"></span>

                        <input type="text" class="form-control" id="contract_mm" name="contract_mm">
                        <div class="invalid-feedback">
                            {{ __(' ') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="contract_mm_budget" class="form-label">{{ __('จำนวนเงิน  MM') }}</label> <span
                            class="text-danger"></span>

                        <input type="number" placeholder="0.00" step="0.01" class="form-control"
                            id="contract_mm_budget" name="contract_mm_budget" min="0">
                    </div>



                    <div class="col-md-6">
                        <label for="contract_pr" class="form-label">{{ __('เลขที่ PR') }}</label> <span
                            class="text-danger">*</span>

                        <input type="text" class="form-control" id="contract_pr" name="contract_pr">
                        <div class="invalid-feedback">
                            {{ __('เลขที่สัญญา ซ้ำ') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="contract_pr_budget" class="form-label">{{ __('จำนวนเงิน PR ') }}</label> <span
                            class="text-danger">*</span>

                        <input type="number" placeholder="0.00" step="0.01" class="form-control"
                            id="contract_pr_budget" name="contract_pr_budget" min="0">
                    </div>
                    <div class="col-md-6">
                        <label for="contract_pa" class="form-label">{{ __('เลขที่ PA') }}</label> <span
                            class="text-danger">*</span>

                        <input type="text" class="form-control" id="contract_pa" name="contract_pa">
                        <div class="invalid-feedback">
                            {{ __('เลขที่สัญญา ซ้ำ') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="contract_pa_budget" class="form-label">{{ __('จำนวนเงิน PA') }}</label> <span
                            class="text-danger">*</span>

                        <input type="number" placeholder="0.00" step="0.01" class="form-control"
                            id="contract_pa_budget" name="contract_pa_budget" min="0">
                    </div>
                    <div class="col-md-6">
                        <label for="contract_peryear_pa_budget"
                            class="form-label">{{ __('จำนวนเงินต่อปี PA') }}</label> <span
                            class="text-danger">*</span>

                        <input type="number" placeholder="0.00" step="0.01" class="form-control"
                            id="contract_peryear_pa_budget" name="contract_peryear_pa_budget" min="0">
                    </div>


                    <div class="col-md-6">
                        <label for="contract_owner" class="form-label">{{ __('เจ้าหน้าที่ผู้รับผิดชอบ ') }}</label>
                        <span class="text-danger">*</span>
                        <input type="text" class="form-control" id="contract_owner" name="contract_owner"
                            maxlength="50">
                    </div>

                    <div class="col-md-6">
                        <label for="contract_refund_pa_budget"
                            class="form-label">{{ __('จำนวนคงเหลือหลังเงิน PA') }}</label> <span
                            class="text-danger"></span>
                        <input type="number" placeholder="0.00" step="0.01" class="form-control"
                            id="contract_refund_pa_budget" name="contract_refund_pa_budget" min="0">
                    </div>
                    <div class="col-md-12">
                        <label for="contract_file" class="form-label">{{ __('อัปโหลดไฟล์สัญญา') }}</label>
                        <input type="file" class="form-control" id="contract_file" name="contract_file">
                        <div class="invalid-feedback">
                            {{ __('เลือกไฟล์สัญญา') }}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="mm_file" class="form-label">{{ __('อัปโหลดไฟล์สัญญา') }}</label>
                        <input type="file" class="form-control" id="mm_file" name="mm_file">
                        <div class="invalid-feedback">
                            {{ __('เลือกไฟล์สัญญา') }}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="pr_file" class="form-label">{{ __('อัปโหลดไฟล์ PR') }}</label>
                        <input type="file" class="form-control" id="pr_file" name="pr_file">
                        <div class="invalid-feedback">
                            {{ __('เลือกไฟล์ PR') }}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="pa_file" class="form-label">{{ __('อัปโหลดไฟล์ PA') }}</label>
                        <input type="file" class="form-control" id="pa_file" name="pa_file">
                        <div class="invalid-feedback">
                            {{ __('เลือกไฟล์ PA') }}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="cn_file" class="form-label">{{ __('อัปโหลดไฟล์ CN') }}</label>
                        <input type="file" class="form-control" id="cn_file" name="cn_file">
                        <div class="invalid-feedback">
                            {{ __('เลือกไฟล์ CN') }}
                        </div>
                    </div>
                -->








               <x-button type="submit" class="btn-success" preventDouble icon="cil-save">
                                    {{ __('Save') }}
                                </x-button>
                                            {{--
                @if ($origin && $ta?sk)
                    <x-button
                        link="{{ route('project.task.createsub', ['project' => $origin, 'task' => $ta?sk]) }}"
                        class="text-black btn-light">
                        {{ __('coreuiforms.return') }}
                    </x-button>
                    @elseif
                <x-button
                link="{{ route('project.task.createcn', ['project' => $origin]) }}"
                class="text-black btn-light">
                {{ __('coreuiforms.return') }}
            </x-button>
            @endif --}}
                                            <x-button link="{{ route('contract.index') }}"
                                                class="btn-light text-black">
                                                {{ __('coreuiforms.return') }}
                                            </x-button>


                                </form>

                            </x-card>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot:content>
        <x-slot:css>
            <link
                href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
                rel="stylesheet" />

        </x-slot:css>
        <x-slot:javascript>

            <!-- Add the necessary CSS and JS files for Select2 -->
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js">
            </script>
            {{--  $projectDetails  <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script> --}}
            <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
            <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>


            <script>
                $(document).ready(function() {
                    var oldContract_number = ''; // เก็บเลขที่สัญญาเดิม
                    var oldValues = {}; // เก็บค่าเดิมของฟิลด์
                    var formIsValid = true; // ตรวจสอบความถูกต้องของฟอร์ม

                    $('#contract_fiscal_year, #contract_number').on('change', function() {
                        var contract_number = $('#contract_number').val();
                        var fiscalYear = $('#contract_fiscal_year').val();
                        var fieldId = $(this).attr('id');

                        $.ajax({
    method: 'GET',
   // url: '{{ route("contract.check-contract") }}',
    url: '{{ route("project.check-project") }}',
    data: {
        contract_fiscal_year: fiscalYear,
        contract_number: contract_number
    },
    success: function(data) {
        if (data.exists_contract_number) {
            $('#' + fieldId).addClass('is-invalid');
            $('#' + fieldId + '_feedback').text('เลขที่สัญญา มีอยู่แล้ว');
            formIsValid = false;
        } else {
            $('#' + fieldId).removeClass('is-invalid');
            oldValues[fieldId] = contract_number;
            formIsValid = true;
        }
    },
    error: function(xhr, status, error) {
        // เมื่อมีข้อผิดพลาดในการเรียก AJAX สามารถแสดงข้อความข้อผิดพลาดได้ที่นี่
        console.error(error);
    }
});

                        if (oldContract_number === contract_number) {
                            $('#' + fieldId).addClass('is-invalid');
                            $('#' + fieldId + '_feedback').text('เลขที่สัญญา มีอยู่แล้ว');
                            formIsValid = false;
                        } else {
                            $('#' + fieldId).removeClass('is-invalid');
                            oldValues[fieldId] = contract_number;
                            formIsValid = true;
                        }
                    });

                    $("form").on("submit", function(e) {
                        if (!formIsValid) {
                            e.preventDefault();
                            var alertText =  'เลขที่สัญญา มีอยู่แล้ว';
                            Swal.fire({
                                title: 'เตือน!',
                                text: alertText,
                                icon: 'warning',
                                confirmButtonText: 'Ok'
                            });
                        }
                    });
                });
            </script>

<script>
    var budgetFields_pa = ['contract_pa_budget'];

    function calculateRefund_pa() {
        var totalRefund_pa = 0;

        budgetFields_pa.forEach(function(costField, index) {
            var pr_value = $("#" + costField).val();

            if (pr_value) {
                var pr_budget = parseFloat(pr_value.replace(/,/g, "")) || 0;

                if (pr_budget != 0) { // Corrected comparison operator from '=' to '!='
                    var refund = pr_budget;
                    totalRefund_pa += refund;
                }
            }
        });

        $("#total_pa_budget").val(totalRefund_pa.toFixed(2));
        $("#contract_cn_budget").val(totalRefund_pa.toFixed(2));
    }

    $(document).ready(function() {
        budgetFields_pa.forEach(function(costField) {
            $("#" + costField).on("change", calculateRefund_pa);
        });
    });
</script>

            <script>
                var costFields = ['contract_pa_budget', 'task_cost_it_investment', 'task_cost_gov_utility'];
                var budgetFields = ['contract_pr_budget', 'task_budget_it_investment', 'task_budget_gov_utility'];

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

                    $("#contract_refund_pa_budget").val(totalRefund.toFixed(2));
                }

                $(document).ready(function() {
                    costFields.forEach(function(costField, index) {
                        $("#" + costField).on("input", calculateRefund);
                    });
                });
            </script>



            <script type="text/javascript">
                $(document).ready(function() {

                    $(".btn-success").click(function() {
                        var html = $(".clone").html();
                        $(".increment").after(html);
                    });

                    $("body").on("click", ".btn-danger", function() {
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



            <script>
                $(document).ready(function() {
                        //$increasedData->first()->total_it_operating) ,2)}}</b> บาท</div> {{-- งบกลาง ICT คงเหลือ --}}
                    var project_budget_it_operating =
                        {{ isset($projectDetails) ? ($projectDetails->budget_it_operating+$increased['total_it_operating'] ) - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating : 0 }};

                    var project_budget_it_investment =
                        {{ isset($projectDetails) ? ($projectDetails->budget_it_investment+$increased['total_it_investment'])  - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment : 0 }};

                    var project_budget_gov_utility =
                        {{ isset($projectDetails) ? ($projectDetails->budget_gov_utility+$increased['total_gov_utility'] ) - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility : 0 }};


                    $("#contract_mm_budget, #contract_pr_budget").on("input", function() {
                        // var max = 0;
                        var fieldId = $(this).attr('id');
                        var budgettype = $("#project_select").val();
                        var contract_mm_budget = parseFloat($("#contract_mm_budget").val().replace(/,/g, ""));
                        var contract_pr_budget = parseFloat($("#contract_pr_budget").val().replace(/,/g, ""));
                        var contract_pa_budget = parseFloat($("#contract_pa_budget").val().replace(/,/g, ""));
                        var contract_er_budget = parseFloat($("#contract_er_budget").val().replace(/,/g, ""));
                        var contract_po_budget = parseFloat($("#contract_po_budget").val().replace(/,/g, ""));
                        var contract_cn_budget = parseFloat($("#contract_cn_budget").val().replace(/,/g, ""));
                        var contract_cn_budget = parseFloat($("#contract_cn_budget").val().replace(/,/g, ""));



                        if ($projectDetails = null) {
                          //  $("#contract_pa_budget").val('11111111'); // Set the value of the input field
                        } else if (budgettype === "1") {
                            if ( contract_mm_budget < -0 ) {
    $("#contract_mm_budget").val(''); // Set the value of the input field
    $("#contract_pr_budget").val(''); // Set the value of the input field
    $("#contract_pa_budget").val(''); // Set the value of the input field
    $("#contract_er_budget").val(''); // Set the value of the input field
    $("#contract_po_budget").val(''); // Set the value of the input field
    $("#contract_cn_budget").val(''); // Set the value of the input field

}



                            max = parseFloat(project_budget_it_operating);
                        } else if (budgettype === "2" ) {
                            if ( contract_mm_budget < -0 ) {
    $("#contract_mm_budget").val(''); // Set the value of the input field
    $("#contract_pr_budget").val(''); // Set the value of the input field
    $("#contract_pa_budget").val(''); // Set the value of the input field
    $("#contract_er_budget").val(''); // Set the value of the input field
    $("#contract_po_budget").val(''); // Set the value of the input field
    $("#contract_cn_budget").val(''); // Set the value of the input field

}

                            max = parseFloat(project_budget_it_investment);
                        }


                        else if (budgettype === "3") {
                            if ( contract_mm_budget < -0 ) {
    $("#contract_mm_budget").val(''); // Set the value of the input field
    $("#contract_pr_budget").val(''); // Set the value of the input field
    $("#contract_pa_budget").val(''); // Set the value of the input field
    $("#contract_er_budget").val(''); // Set the value of the input field
    $("#contract_po_budget").val(''); // Set the value of the input field
    $("#contract_cn_budget").val(''); // Set the value of the input field

}
                            max = parseFloat(project_budget_gov_utility);
                        }


                        var current = parseFloat($(this).val().replace(/,/g, ""));
                        if (current > max) {
                            Swal.fire({
                                title: "เกิดข้อผิดพลาด",
                                text: "จำนวนเงินที่ใส่ต้องไม่เกิน " + max.toLocaleString('en-US', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }) + " บาท",
                                icon: "error",
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "ตกลง"
                            });
                            $(this).val(0);
                        }
                    });

                    /*  $("#contract_pa_budget").on("input", function() {
                            var contract_mm_budget = parseFloat($("#contract_mm_budget").val().replace(/,/g, ""));
                            if (current > contract_mm_budget) {
                                Swal.fire({
                                    title: "เกิดข้อผิดพลาด",
                                    text: "จำนวนเงิน PA ต้องไม่เกิน " + contract_mm_budget.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + " บาท",
                                    icon: "error",
                                    confirmButtonColor: "#3085d6",
                                    confirmButtonText: "ตกลง"
                                });
                                $(this).val(contract_mm_budget.toFixed(2));
                            }
                        }); */
                });
            </script>


            {{--
<script>
   $(document).ready(function() {
 /*    var task_budget_it_operating = {{ $sum_task_budget_it_operating }};
    var task_budget_it_investment = {{ $sum_task_budget_it_investment }};
    var task_budget_gov_utility = {{ $sum_task_budget_gov_utility }}; */


    var project_budget_it_operating = {{ $projectDetails->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating }};
    var project_budget_it_investment = {{  $projectDetails->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment }};
    var project_budget_gov_utility = {{  $projectDetails->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility }};


    $("#contract_mm_budget, #contract_pr_budget").on("input", function() {
        var max = 0;
        var fieldId = $(this).attr('id');

        if (fieldId === "contract_mm_budget" || fieldId === "contract_pr_budget" ) {
            if (project_budget_it_operating > 0) {
                max = parseFloat(project_budget_it_operating);
            } else if (project_budget_it_investment > 0) {
                max = parseFloat(project_budget_it_investment);
            } else if (project_budget_gov_utility > 0) {
                max = parseFloat(project_budget_gov_utility);
            }
        }

        var current = parseFloat($(this).val().replace(/,/g, ""));
        if (current > max) {
            Swal.fire({
                title: "เกิดข้อผิดพลาด",
                text: "จำนวนเงินที่ใส่ต้องไม่เกิน " + max.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + " บาท",
                icon: "error",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "ตกลง"
            });
            $(this).val(max.toFixed(2));
        }
    });

   /*  $("#contract_pa_budget").on("input", function() {
        var contract_mm_budget = parseFloat($("#contract_mm_budget").val().replace(/,/g, ""));
        if (current > contract_mm_budget) {
            Swal.fire({
                title: "เกิดข้อผิดพลาด",
                text: "จำนวนเงิน PA ต้องไม่เกิน " + contract_mm_budget.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + " บาท",
                icon: "error",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "ตกลง"
            });
            $(this).val(contract_mm_budget.toFixed(2));
        }
    }); */
});

</script> --}}
<script>
    $(document).ready(function() {
        $("#contract_pr_budget").on("input", function() {
          //  var contract_mm_budget = parseFloat($("#contract_mm_budget").val().replace(/,/g, ""));
            var contract_pr_budget = parseFloat($("#contract_pr_budget").val().replace(/,/g, ""));
            var contract_pa_budget = parseFloat($("#contract_pa_budget").val().replace(/,/g, ""));
            var contract_er_budget = parseFloat($("#contract_er_budget").val().replace(/,/g, ""));
            var contract_po_budget = parseFloat($("#contract_po_budget").val().replace(/,/g, ""));
            var contract_cn_budget = parseFloat($("#contract_cn_budget").val().replace(/,/g, ""));



            var contract_mm_budget = parseFloat($("#contract_mm_budget").val().replace(/,/g, ""));
            var current = parseFloat($(this).val().replace(/,/g, ""));
            if (contract_pr_budget < contract_pa_budget  ) {
//$("#contract_pr_budget").val('0'); // Set the value of the input field
$("#contract_pa_budget").val(''); // Set the value of the input field
}   else if (contract_pr_budget < -0  ) {
$("#contract_pr_budget").val(''); // Set the value of the input field



};

            if (current > contract_mm_budget) {
                Swal.fire({
                    title: "เกิดข้อผิดพลาด",
                    text: "วงเงิน (บาท) MM จำนวนเงินที่ใส่ต้องไม่เกิน " + contract_mm_budget
                        .toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }) + " บาท",
                    icon: "error",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "ตกลง"
                });
                /*  $(this).val(contract_mm_budget.toFixed(2)); */
                $(this).val(0);
            }
        });
    });
</script>
            <script>
                $(document).ready(function() {
                    $("#contract_pa_budget").on("input", function() {
                        var contract_mm_budget = parseFloat($("#contract_mm_budget").val().replace(/,/g, ""));
                        var contract_pa_budget = parseFloat($("#contract_pa_budget").val().replace(/,/g, ""));
                        var contract_pr_budget = parseFloat($("#contract_pr_budget").val().replace(/,/g, ""));
                        var current = parseFloat($(this).val().replace(/,/g, ""));


                        if (contract_pa_budget > contract_pr_budget ) {
    //$("#contract_pr_budget").val('0'); // Set the value of the input field
   // $("#contract_pr_budget").val(''); // Set the value of the input field
}
                    else if (contract_pa_budget < -0  ) {

    $("#contract_pa_budget").val(''); // Set the value of the input field
                    }
                        if (current > contract_pr_budget || contract_pr_budget === "") {
                            Swal.fire({
                                title: "เกิดข้อผิดพลาด",
                                text: "วงเงิน (บาท) PR จำนวนเงินที่ใส่ต้องไม่เกิน " + contract_pr_budget
                                    .toLocaleString('en-US', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }) + " บาท",
                                icon: "error",
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "ตกลง"
                            });
                            /*  $(this).val(contract_mm_budget.toFixed(2)); */
                            $(this).val(0);
                        }
                    });
                });
            </script>

            <script>
          $(document).ready(function() {
                    $("#contract_er_budget,#contract_po_budget,#contract_cn_budget").on("input", function() {
                        var contract_pa_budget = parseFloat($("#contract_pa_budget").val().replace(/,/g, ""));
                        var contract_er_budget = parseFloat($("#contract_er_budget").val().replace(/,/g, ""));
                        var contract_po_budget = parseFloat($("#contract_po_budget").val().replace(/,/g, ""));
                        var contract_cn_budget = parseFloat($("#contract_cn_budget").val().replace(/,/g, ""));
                        var current = parseFloat($(this).val().replace(/,/g, ""));

                        if (contract_er_budget < -0 || contract_po_budget < -0 || contract_cn_budget < -0) {
    //$("#contract_pr_budget").val('0'); // Set the value of the input field
    $("#contract_er_budget").val(''); // Set the value of the input field
    $("#contract_po_budget").val(''); // Set the value of the input field
    $("#contract_cn_budget").val(''); // Set the value of the input field
}



                        if (current > contract_pa_budget) {
                            Swal.fire({
                                title: "เกิดข้อผิดพลาด",
                                text: "วงเงิน (บาท) PA จำนวนเงินที่ใส่ต้องไม่เกิน" + contract_pa_budget
                                    .toLocaleString('en-US', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }) + " บาท",
                                icon: "error",
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "ตกลง"
                            });
                            /*                 $(this).val(contract_pa_budget.toFixed(2)); */
                            $(this).val(0);
                        }
                    });
                });
            </script>

            <script>
          $(document).ready(function() {
                    $("#contract_cn_budget").on("input", function() {
                        var contract_pa_budget = parseFloat($("#contract_pa_budget").val().replace(/,/g, ""));
                        var current = parseFloat($(this).val().replace(/,/g, ""));
                        if (current > contract_pa_budget) {
                            Swal.fire({
                                title: "เกิดข้อผิดพลาด",
                                text: "วงเงิน (บาท) PA จำนวนเงินที่ใส่ต้องไม่เกิน " + contract_pa_budget
                                    .toLocaleString('en-US', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }) + " บาท",
                                icon: "error",
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "ตกลง"
                            });
                            /*  $(this).val(contract_pa_budget.toFixed(2)); */
                            $(this).val(0);
                        }
                    });
                });
            </script>

            <script>
                $(document).ready(function() {
                    var tasksData = {!! $tasksJson !!};

                    // Group tasks by project parent ID and project fiscal year
                    // Group tasks by project parent ID and project fiscal year
                    var groupedTasks = tasksData.reduce(function(groups, task) {

                        //console.log('a', groups);
                        //console.log('ab', task);


                        var projectParent = task.task_parent_id;
                        if (projectParent === null) {
                            return groups; // Skip tasks with null task_parent_id
                        }
                        var projectYear = task.project_fiscal_year;
                        var taskId = task.task_id;
                        var taskName = task.task_name;
                        var projectName = task.project_name;
                        var groupKey = projectName + '_' + projectYear;

                        if (!groups[groupKey]) {
                            groups[groupKey] = [];
                        }
                        groups[groupKey].push({
                            id: taskId,
                            text: taskName,
                            ...task
                        });
                        return groups;
                    }, {});



                    // Sort project fiscal years in descending order
                    var sortedYears = Object.keys(groupedTasks).sort(function(a, b) {
                        return b.split('_')[1] - a.split('_')[1];
                    });

                    // Generate options with groupings
                    var options = sortedYears.map(function(groupKey) {
                        var groupParts = groupKey.split('_');
                        // var projectParent = groupParts[0];
                        // var projectYear = groupParts[0];
                        var projectName = groupParts[0];
                        var projectYear = groupParts[1];
                        var tasks = groupedTasks[groupKey];
                        var taskOptions = tasks.map(function(task) {
                            return '<option value="' + task.id + '">' + task.text + '</option>';
                        }).join('');
                        return '<optgroup label="' + projectYear + ' - ' + projectName + '">' + taskOptions +
                            '</optgroup>';
                    });

                    // Add a placeholder option
                    var placeholderOption = '<option value="" disabled selected>เลือกกิจกรรม</option>';

                    $('#task_parent').html(placeholderOption + options.join('')).select2({
                        allowClear: true,
                        data: tasksData
                    });



                    $('#task_parent').on('select2:select', function(e) {
                        var data = e.params.data;
                        var budget = parseFloat(data.budget_it_investment) || parseFloat(data
                            .budget_it_operating) || parseFloat(data.budget_gov_utility) || 0;

                        if (typeof budget === 'number') {
                            budget = new Intl.NumberFormat('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }).format(budget);
                        }

                        $('#contract_type_budget').val(budget);
                    });
                });
            </script>

            <script>
                $(document).ready(function() {
                    $('#rounds').change(function() {
                        var rounds = $(this).val();
                        $('#tasksContainer').empty(); // clear the container
                        var contract_fiscal_year = {{$projectDetails->project_fiscal_year}};
            contract_fiscal_year = contract_fiscal_year - 543;

            var fiscalYearStartDate = new Date(contract_fiscal_year - 1, 9, 1); // 1st October of the previous year
            var fiscalYearEndDate = new Date(contract_fiscal_year, 8, 30); // 30th September of the fiscal year

  //console.log( contract_fiscal_year);
  //console.log( fiscalYearStartDate);
   // console.log( fiscalYearStartDate);
                        for (var i = 0; i < rounds; i++) {
                            var content = `
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">ชื่องวด ${i + 1} &nbsp: &nbsp</label>
                            <input class="form-control" type="text" name="tasks[${i}][task_name]" value="งวด ${i + 1}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">เงินงวด ${i + 1} &nbsp: &nbsp</label>
                            <input
                            id="[${i}][expenses]"
                            type="text"
                            name="tasks[${i}][taskbudget]"
                            class="form-control custom-input numeral-mask expenses"
                             data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false" required>
                            <div id="tasks_${i}_taskbudget_feedback" class="invalid-feedback">ระบุเงินงวด</div>

                        </div>
                        <div class="col-md-3">
                            <label class="form-label">งวด ${i + 1} วันที่เริ่มต้น</label>
                            <input type="text" class="form-control datepickerop" id="start_date_${i}" name="tasks[${i}][start_date]">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">งวด ${i + 1} วันที่สิ้นสุด </label>
                            <input type="text" class="form-control datepickeropend" id="end_date_${i}" name="tasks[${i}][end_date]">
                        </div>
                    </div>`;

                $('#tasksContainer').append(content);
                initializeDatepickers(i, fiscalYearStartDate, fiscalYearEndDate);
                // Initialize the datepickers for the newly added elements

                //console.log("round===="+i);

            }






                        // Apply inputmask to the newly added input elements
                        $(":input").inputmask();
                    });

                    function initializeDatepickers(i, fiscalYearStartDate, fiscalYearEndDate) {
            var text_start_date = '#start_date_' + i;
            var text_end_date = '#end_date_' + i;
            var next_start_date = '#start_date_' + (i + 1);
    var prev_end_date = '#end_date_' + (i - 1);
    var next_start_date = i + 1 < 10 ? '#start_date_' + (i + 1) : null; // ตรวจสอบว่ามีงวดถัดไปหรือไม่


            // Initialize start date datepicker
            $(text_start_date).datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                language: "th-th",
                startDate: fiscalYearStartDate,
               // endDate: fiscalYearEndDate,
                autoclose: true
            }).on('changeDate', function(selected) {
           // Set the start date of the end date datepicker to the selected start date
           var newStartDate = selected.date;
        $(text_end_date).datepicker("setStartDate", newStartDate);

        // If there is a next start date datepicker, set its start date to the day after the selected end date
        if (next_start_date && $(next_start_date).length) {
            var newEndDate = new Date(newStartDate);
            newEndDate.setDate(newEndDate.getDate() + 1); // Set the minimum start date of the next period to one day after the end date of the current period
            $(next_start_date).datepicker("setStartDate", newEndDate);
        }

            });

            // Initialize end date datepicker
            $(text_end_date).datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                language: "th-th",
                autoclose: true
            }).on('changeDate', function(selected) {
               // If there is a next start date datepicker, set its start date to the day after the selected end date
        if (next_start_date && $(next_start_date).length) {
            var newStartDate = new Date(selected.date);
            newStartDate.setDate(newStartDate.getDate() + 1); // Plus one day
            $(next_start_date).datepicker("setStartDate", newStartDate);
        }
            });
        }




                    // When an expense input changes, update the total and check against the budget
                    $(document).on('input', '.expenses', function() {
                        var contract_pa_budget = parseFloat($("#contract_pa_budget").val().replace(/,/g, ""));
                        var sum = 0;
                        var index = $(this).data('index');
                        var tasksContainer = $('#tasksContainer');
                        var inputs = $('.expenses').map(function() {
                           // ตรวจสอบว่าค่าในอินพุตไม่ติดลบ
        var value = parseFloat($(this).val().replace(/,/g, "")) || 0;
        if (value < 0) {
            $(this).val(''); // รีเซ็ตค่าถ้าติดลบ
            value = 0; // ใช้ค่า 0 สำหรับการคำนวณถัดไป
        }
        return value




                        }).get();

                        sum = inputs.reduce(function(a, b) {

                            return a + b;
                        }, 0);

                        // Calculate the remaining budget after each installment
                        var remainingBudget = contract_pa_budget;
                        for (var i = 0; i < inputs.length; i++) {
                            remainingBudget -= inputs[i];

                            if (remainingBudget < 0) {
   // วน loop เพื่อรีเซ็ตค่าของอินพุตที่ทำให้เงินที่เหลือน้อยกว่าศูนย์
   $('.expenses').each(function() {
            if (parseFloat($(this).val()) < 0) {
                $(this).val('');
            }
        });

                                // If the remaining budget after any installment is negative, show an error
                                Swal.fire({
                                    title: "เกิดข้อผิดพลาด",
                                    html: "จำนวนเงินที่ใส่ต้องไม่เกิน " + (contract_pa_budget - (sum -
                                            inputs[i])).toLocaleString('en-US', {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        }) + " บาท" +
                                        "<p>จำนวนเงินทั้งหมดที่ใส่ต้องไม่เกิน " + (contract_pa_budget)
                                        .toLocaleString('en-US', {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        }) + " บาท)",


                                    icon: "error",
                                    confirmButtonColor: "#3085d6",
                                    confirmButtonText: "ตกลง"
                                }).then((result) => {
                                    if (result.value) {
                                        $('.expenses').eq(i).val(
                                        ''); // Reset the value of the input that caused the error
                                        $('.expenses').eq(i).trigger(
                                        'input'); // Trigger input event to recalculate
                                    }
                                });
                                break; // Exit the loop as we have found an error

                            }



                        }



                            $('#expenses_sum').val(sum.toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }));
                            $('#expenses_delsum').val(remainingBudget.toLocaleString('budgeten-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2,


                            }));

  // Function to calculate the remaining budget
  function calculateRemainingBudget() {
        var sum = $('.expenses').map(function() {
            return parseFloat($(this).val().replace(/,/g, "")) || 0;
        }).get().reduce(function(a, b) {
            return a + b;
        }, 0);

        var contract_pa_budget = parseFloat($("#contract_pa_budget").val().replace(/,/g, "")) || 0;
        var remainingBudget = contract_pa_budget - sum;
        return remainingBudget;
    }

             var sumOfExpenses = 0;
                $('.expenses').each(function(index) {
                sumOfExpenses += parseFloat($(this).val().replace(/,/g, "")) || 0;
                // ลบคลาส 'is-invalid' ก่อนการตรวจสอบใหม่
                $(this).removeClass('is-invalid');
                $('#tasks_' + index + '_taskbudget_feedback').text('');
                });
          // คำนวณงบประมาณที่เหลือ
          var contract_pa_budget = parseFloat($("#contract_pa_budget").val().replace(/,/g, "")) || 0;
                    var remainingBudgetform = contract_pa_budget - sumOfExpenses;
        // แสดงผลค่าที่คำนวณได้บน console สำหรับการตรวจสอบ
                      console.log('Contract PA Budget-1:', contract_pa_budget);
                    console.log('Sum of Expenses-2:', sumOfExpenses);
                    console.log('Remaining Budget-3:', remainingBudgetform);
 // var formIsValid = true; // Initialize form validity state
                    // ตรวจสอบว่าผลรวมของค่าใช้จ่ายเท่ากับงบประมาณหรือไม่
                    if (remainingBudgetform !== 0) {
                        // ถ้าไม่เท่ากันแสดงข้อความผิดพลาด
                        $('#expenses_delsum').addClass('is-invalid');
                        $('#expenses_delsum').next('.invalid-feedback').text('ผลรวมของเงินงวดไม่เท่ากับงบประมาณ1');
                        $('#expenses_sum').addClass('is-invalid');
                        $('#expenses_sum').next('.invalid-feedback').text('ผลรวมของเงินงวดไม่เท่ากับงบประมาณ2');
                        $('.expenses').each(function(index) {
                            $(this).addClass('is-invalid');
                            $('#tasks_' + index + '_taskbudget_feedback').text('ผลรวมของเงินงวดไม่เท่ากับงบประมาณ3');
                        });
                        //$('.expenses, #expenses_delsum, #expenses_sum').addClass('is-invalid');
                        //$('.invalid-feedback').text('ผลรวมของเงินงวดไม่เท่ากับงบประมาณ');
                       // formIsValid = false; // Set form as invalid
                       formIsValid = false; // Set form as invalid
                    } else {
                        // ถ้าเท่ากันลบคลาส 'is-invalid' และส่งฟอร์ม
                        $('#expenses_delsum').removeClass('is-invalid');
                        $('#expenses_delsum').next('.invalid-feedback').text('');
                        $('#expenses_sum').removeClass('is-invalid');
                        $('#expenses_sum').next('.invalid-feedback').text('');
                        $('.expenses').each(function(index) {
                            $(this).removeClass('is-invalid');
                            $('#tasks_' + index + '_taskbudget_feedback').text('');

                            formIsValid = true;
                        });
                    }

                    $("form").on("submit", function(e) {
                        if (!formIsValid) {
                            e.preventDefault();
                            var alertText =  'ผลรวมของเงินงวดไม่เท่ากับงบประมาณ3';
                            Swal.fire({
                                title: 'เตือน!',
                                text: alertText,
                                icon: 'warning',
                                confirmButtonText: 'Ok'
                            });
                        }
                    });



                    });

                     // ฟังก์ชันสำหรับคำนวณผลรวมของเงินงวดทั้งหมด
    function calculateTotalInstallments() {
        var total = 0;
        $('.installment').each(function() {
            var amount = parseFloat($(this).val().replace(/,/g, "")) || 0;
            total += amount;
        });
        return total;
    }

    // ฟังก์ชันสำหรับตรวจสอบว่าผลรวมของเงินงวดเท่ากับเงินที่ใช้ไปทั้งหมดหรือไม่
    function checkTotalAgainstBudget() {
        var totalInstallments = calculateTotalInstallments();
        var budgetUsed = parseFloat($('#budget-used').val().replace(/,/g, "")) || 0;
        var remainingBudget = budgetUsed - totalInstallments;

        $('#expenses_sum').val(totalInstallments.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));
        $('#expenses_delsum').val(remainingBudget.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));

        if(remainingBudget !== 0) {
            alert('เงินเหลือทั้งหมด ' + remainingBudget.toFixed(2) + ' บาท ต้องเหลือ 0 บาท');
        }
    }

    // ตรวจสอบเมื่อมีการป้อนข้อมูลในฟิลด์เงินงวด
    $(document).on('input', '.installment', function() {
        checkTotalAgainstBudget();
    });

    // ตรวจสอบเมื่อมีการเปลี่ยนแปลงจำนวนงวด
    $('#rounds').change(function() {
        // ... โค้ดสำหรับการเปลี่ยนแปลงจำนวนงวด ...
        // เรียกใช้ checkTotalAgainstBudget เมื่อเพิ่มฟิลด์เงินงวดใหม่
        checkTotalAgainstBudget();
    });
                });
            </script>

<script>
    $(document).ready(function() {
        $('#contract_type').change(function() {
            var contract_type = $(this).val();
            var contract_name_label = $('#contract_name_label');
            var contract_name_label_feedback = $('#contract_name_label_feedback');
            var rounds_form = $('#rounds_form');
            var rounds_label = $('#rounds_label');



            if (contract_type == 1) {
                contract_name_label.text('ชื่อ สั่งจ้าง PO');
                contract_name_label_feedback.text('ชื่อ สั่งจ้าง PO');

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
                contract_name_label.text('ชื่อ สั่งจ้าง ER');
                contract_name_label_feedback.text('ชื่อ สั่งจ้าง ER')
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
                contract_name_label.text('ชื่อ สัญญา CN');
                contract_name_label_feedback.text('ชื่อ สัญญา CN')
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
                contract_name_label_feedback.text('ชื่อ ค่าใช้จ่ายสำนักงาน')
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
                contract_name_label_feedback.text('ชื่อ PO/ER/CN/ค่าใช้จ่ายสำนักงาน')
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
</script>

<script>
    $(function() {
        if (typeof jQuery == 'undefined' || typeof jQuery.ui == 'undefined') {
            alert("jQuery or jQuery UI is not loaded");
            return;
        }

        //   var d = new Date();
        // var toDay = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 543);

        $("#contract_sign_date,#contract_start_date, #contract_end_date,#contract_er_start_date,#contract_po_start_date,#insurance_start_date, #insurance_end_date")
            .datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                language: "th-th",
                /*     defaultDate: toDay,
                     dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
                     dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
                     monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม',
                         'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
                     ],
                     monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.',
                         'ต.ค.', 'พ.ย.', 'ธ.ค.'
                     ], */


            });

var contract_fiscal_year = {{$projectDetails->project_fiscal_year}};
contract_fiscal_year =  contract_fiscal_year -543;
console.log( contract_fiscal_year);

var fiscalYearStartDate = new Date( contract_fiscal_year - 1, 9, 1); // 1st October of the previous year
var fiscalYearEndDate = new Date( contract_fiscal_year, 8, 30); // 30th September of the fiscal year

console.log(fiscalYearStartDate);
console.log(fiscalYearEndDate);


// Set the start and end dates for the project_start_date datepicker
$("#contract_start_date").datepicker("setStartDate", fiscalYearStartDate);
//  $("#project_start_date").datepicker("setEndDate", fiscalYearEndDate);

// Set the start and end dates for the project_end_date datepicker
$("#contract_end_date").datepicker("setStartDate", fiscalYearStartDate);
//$("#contract_end_date").datepicker("setEndDate", fiscalYearEndDate);
//$("#contract_sign_date").datepicker("setStartDate", new Date(fiscalYearStartDate.getFullYear() - 1, fiscalYearStartDate.getMonth(), fiscalYearStartDate.getDate()));



        $('#contract_start_date').on('changeDate', function() {
            var startDate = $(this).datepicker('getDate');
            $("#contract_end_date").datepicker("setStartDate", startDate);
            $("#insurance_end_date").datepicker("setStartDate", startDate);
            $("#contract_sign_date").datepicker("setStartDate", new Date(startDate.getFullYear(), startDate.getMonth()-2, startDate.getDate()));
            $("#contract_po_start_date").datepicker("setStartDate", startDate);
            $("#contract_er_start_date").datepicker("setStartDate", startDate);
        });

        $('#contract_end_date').on('changeDate', function() {
            var endDate = $(this).datepicker('getDate');
            $("#contract_start_date").datepicker("setEndDate", endDate);
            $("#insurance_start_date").datepicker("setEndDate", endDate);


        });
    });
</script>



            {{-- <script>
    $(document).ready(function() {
       $("#contract_start_date").datepicker({});
        $("#contract_end_date").datepicker({ });
        $("#contract_sign_date").datepicker({ });



        $('#contract_start_date').change(function() {
                        startDate = $(this).datepicker('getDate');
                        $("#contract_end_date").datepicker("option", "minDate", startDate);
                        $("#contract_sign_date").datepicker("option", "minDate", startDate);
                        $("#insurance_start_date").datepicker("option", "minDate", startDate);
                        $("#insurance_end_date").datepicker("option", "minDate", startDate);
                    })

                    $('#contract_end_date').change(function() {
                        endDate = $(this).datepicker('getDate');
                        $("#contract_start_date").datepicker("option", "maxDate", endDate);

                    })

    });
    </script> --}}



    <script>
        /*    function calculateDuration() {
                var startDate = $('#insurance_start_date').datepicker('getDate');
                var endDate = $('#insurance_end_date').datepicker('getDate');
                if (startDate && endDate) {
                    var diff = Math.abs(endDate - startDate);
                    var days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    var months = Math.floor(diff / (1000 * 60 * 60 * 24 * 30.436875));
                    $('#insurance_duration_months').text(months + " เดือน");
                    $('#insurance_duration_days').text(days + " วัน");
                }
            } */

        $(document).ready(function() {
            $('#insurance_start_date, #insurance_end_date').datepicker({

                dateFormat: "dd/mm/yy",
                changeMonth: true,
                changeYear: true,
                language: "th-th",

            });
            var contract_fiscal_year = {{$projectDetails->project_fiscal_year}};
contract_fiscal_year =  contract_fiscal_year -543;
console.log( contract_fiscal_year);

var fiscalYearStartDate = new Date( contract_fiscal_year - 1, 9, 1); // 1st October of the previous year
var fiscalYearEndDate = new Date( contract_fiscal_year, 8, 30); // 30th September of the fiscal year

console.log(fiscalYearStartDate);
console.log(fiscalYearEndDate);

// Set the start and end dates for the project_start_date datepicker
$("#insurance_start_date").datepicker("setStartDate", fiscalYearStartDate);
//  $("#project_start_date").datepicker("setEndDate", fiscalYearEndDate);

// Set the start and end dates for the project_end_date datepicker
$("#insurance_end_date").datepicker("setStartDate", fiscalYearStartDate);
$("#insurance_end_date").datepicker("setEndDate", fiscalYearEndDate);




        });

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

        function grandTotal() {
            calculateDuration();
            var days = $("#insurance_start_date").val();
            var rooms = $("#insurance_end_date").val();

            if (days != "" && parseInt(days) > 0) {
                if (rooms != "") {
                    var total = parseInt(days) * parseInt(rooms) * roomPrice;
                    $("#grandtotal").val(total.toFixed(2)).css("color", "black");
                } else {
                    $("#grandtotal").val("").css("color", "black");
                }
            }
        }

        $("#insurance_start_date, #insurance_end_date").on("change", function() {
            grandTotal();
            $(".datepicker").hide();
        });
    </script>
            <script>
                $(document).ready(function() {
                    $(":input").inputmask();
                });
            </script>
            <script>
                $(document).ready(function() {

                    $('#contract_type option[value="99"]').remove();
                    $('#contract_type option[value="4"]').remove();
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
