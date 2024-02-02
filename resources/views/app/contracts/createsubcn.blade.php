    <x-app-layout>
        <x-slot:content>
            <div class="container-fluid">

                {{-- {{ Breadcrumbs::render('contract.create') }} --}}

                <div class="d-none">
                    @if ($pro)
                        {{ $pro->project_name }}
                        {{ $pro->project_fiscal_year }}
                        {{ $pro->project_type }}
                    @endif

                    @if ($ta)
                        111
                        {{ $ta->task_id }}
                        {{ $ta->task_name }}
                     {{ $ta->task_type }}
                        {{ $ta->task_budget_it_operating }}
                        {{ $ta->task_budget_it_investment }}
                        {{ $ta->task_budget_gov_utility }}
                        {{ $ta->task_start_date }}
                        {{ $ta->task_end_date }}
                        {{ $ta->task_mm }}
                        {{ $ta->task_mm_name }}
                        {{ $ta->task_mm_budget }}
                        {{ $ta->task_budget_it_operating }}
                        {{ $ta->task_budget_it_investment }}
                        {{ $ta->task_budget_gov_utility }}
                        @elseif ($tasksDetails)
                        222
                        {{ $tasksDetails->project_id }}

                        {{ $tasksDetails->task_id }}
                        {{ $tasksDetails->task_name }}
                        {{ $tasksDetails->task_mm }}
                        {{ $tasksDetails->task_mm_name }}
                        {{ $tasksDetails->task_mm_budget }}
                        {{ $tasksDetails->task_budget_it_operating }}
                        {{ $tasksDetails->task_budget_it_investment }}
                        {{ $tasksDetails->task_budget_gov_utility }}
                    @endif
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

  <a href="{{ type="hidden" route('project.task.createsub', $project) }}" class="btn btn-primary text-white">ไปยังหน้าการใช้จ่ายของงาน</a> --}}
                                </x-slot:toolbar>


                                <form   enctype="multipart/form-data" id="formId" method="POST" action="{{ route('contract.store') }}" class="row needs-validation" novalidate >
                                    @csrf
                                    <div class="d-none">
                                    <input  name="origin" value="{{ $origin }}">


                                    <input  name="project" value="{{ $project }}">
                                    <input name="encodedProjectId" value="{{ $encodedProjectId }}">

                                    <input name="task" value="{{ isset($task) ? $task->hashid : '' }}">
                                    </div>

                                    <div class="d-none">
                                    @if($pro->project_type == 1)

                                        <input type="text" class="form-control" id="contract_project_type" name="contract_project_type" value="p" readonly>


                                    @elseif($pro->project_type == 2)
                                        <input type="text" class="form-control" id="contract_project_type" name="contract_project_type" value="j" readonly>

                                    @endif
                                    </div>

                                    <div class="row g-3 align-items-center callout callout-success ">


                                        <div class="row g-3 align-items-center">

                                            <!-- Fiscal Year -->
                                              {{--     <div class="col-md-3">
                                                <label for="contract_fiscal_year"
                                                    class="form-label">{{ __('ปีงบประมาณ') }}</label>
                                                <span class="text-danger">*</span>
                                                <select name="contract_fiscal_year"
                                                    class="form-select @error('contract_fiscal_year') is-invalid @enderror">
                                                    @for ($i = date('Y') + 541; $i <= date('Y') + 543 + 8; $i++)
                                                        <option value="{{ $i }}"
                                                            {{ $fiscal_year == $i ? 'selected' : '' }}>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                                @error('contract_fiscal_year')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div> --}}

                                            <div class="col-md-3">
                                                <label for="contract_fiscal_year"
                                                    class="form-label">{{ __('ปีงบประมาณ') }}</label>
                                                <span class="text-danger"></span>
                                                <input type="text" class="form-control" id="contract_fiscal_year"
                                                name="contract_fiscal_year"   value="{{  $pro->project_fiscal_year }}" readonly >
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
                                                    @if ($tasks)
                                                        @foreach ($tasks as $subtask)
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
                                                    <label for="contract_type"
                                                        class="form-label">{{ __('ประเภท') }}</label>
                                                        <span class="text-danger">*</span>
                                                    <select name="contract_type" id="contract_type"
                                                        class="form-control" required>
                                                        <option value="*" disabled selected>
                                                            {{ __('เลือกประเภท...') }}
                                                        </option>
                                                        @foreach (\Helper::contractType() as $key => $type)
                                                            <option value="{{ $key }}">{{ $type }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div id='contract_type_feedback' class="invalid-feedback">
                                                        You must agree before submitting.
                                                      </div>
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
                                                    <div id='contract_type_feedback' class="invalid-feedback">
                                                        You must agree before submitting.
                                                      </div>
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
                                                id="contract-type-budget" value="N/A">
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
                                        <div class="row fw-semibold mt-3">
                                            <div class="row">
                                                @if ($tasksDetails->task_budget_it_operating > 0)
                                                    <div class="col-md-4">
                                                        <label for="task_budget_it_operating0"
                                                            class="form-label">{{ __('งบกลาง ICT') }}</label>
                                                        <span>
                                                            {{ number_format(floatval($task->task_budget_it_operating - $task_sub_sums['operating']['task_mm_budget'] + $task_sub_refund_pa_budget['operating']['task_refund_pa_budget']), 2) }}
                                                            บาท
                                                        </span>
                                                        {{--     <div class="col-3">          {{ number_format(floatval(($task->task_budget_it_operating-$task_sub_sums['operating']['task_mm_budget'])+$task_sub_refund_pa_budget ['operating']['task_refund_pa_budget']), 2) }} บาท</div> --}}

                                                    </div>
                                                @endif

                                                @if ($tasksDetails->task_budget_it_investment > 0)
                                                    <div class="col-4">
                                                        <label for="task_budget_it_investment0"
                                                            class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                        <span>
                                                            {{ number_format(floatval($task->task_budget_it_investment - $task_sub_sums['investment']['task_mm_budget'] + $task_sub_refund_pa_budget['investment']['task_refund_pa_budget']), 2) }}
                                                            บาท
                                                        </span>
                                                    </div>
                                                @endif

                                                @if ($tasksDetails->task_budget_gov_utility > 0)
                                                    <div class="col-md-4">
                                                        <label for="task_budget_gov_utility0"
                                                            class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                        <span>{{ number_format($tasksDetails->task_budget_gov_utility - $task_sub_sums['utility']['task_mm_budget'] + $task_sub_refund_pa_budget['utility']['task_refund_pa_budget'], 2) }}
                                                            บาท</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        {{--     <div class="row mt-3">
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
                                                             data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
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
                                                             data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                            class="form-control numeral-mask"
                                                            id="budget_gov_utility"
                                                            name="budget_gov_utility" min="0"
                                                            disabled readonly>
                                                    </div>
                                                @endif
                                            </div>
                                        </div> --}}

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
                                                                                    $tasksDetails->task_budget_it_operating -
                                                                                        $task_sub_sums['operating']['task_mm_budget'] +
                                                                                        $task_sub_sums['operating']['task_refund_pa_budget'] >
                                                                                        0)
                                                                                    <option selected value="1">
                                                                                        งบกลาง ICT</option>
                                                                                @endif
                                                                                @if (
                                                                                    $tasksDetails->task_budget_it_investment -
                                                                                        $task_sub_sums['investment']['task_mm_budget'] +
                                                                                        $task_sub_sums['investment']['task_refund_pa_budget'] >
                                                                                        0)
                                                                                    <option selected value="2">
                                                                                        งบดำเนินงาน</option>
                                                                                @endif
                                                                                @if (
                                                                                    $tasksDetails->task_budget_gov_utility -
                                                                                        $task_sub_sums['utility']['task_mm_budget'] +
                                                                                        $task_sub_sums['utility']['task_refund_pa_budget'] >
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
                                                                        <div class="col-md-3">

                                                                            <label for="contract_mm"
                                                                                class="form-label">{{ __('บันทึกข้อความ (MM)/เลขที่ สท.') }}</label>
                                                                            <span class="text-danger">*</span>
                                                                            <input type="text" class="form-control"
                                                                                id="contract_mm"
                                                                                name="contract_mm"
                                                                                aria-describedby="contract_mm_Feedback"
                                                                                value="{{ $tasksDetails->task_mm }}"
                                                                                required >
                                                                            <div id="contract_mm_Feedback" name="contract_mm_Feedback"class="invalid-feedback">
                                                                                {{ __('บันทึกข้อความ (MM)/เลขที่ สท.') }}
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3 d-none">

                                                                            <label for="reguiar_contract_id"
                                                                                class="form-label">{{ __('no.') }}</label>
                                                                            <span class="text-danger"></span>
                                                                            <input type="text" class="form-control"
                                                                                id="reguiar_contract_id" name="reguiar_contract_id"
                                                                                >
                                                                            <div class="invalid-feedback">
                                                                                {{ __('') }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 ">
                                                                            <label for="contract_mm_name"
                                                                                class="form-label">{{ __('ชื่อ MM / ชื่อบันทึกข้อความ') }}</label>


                                                                            <input type="text" class="form-control"
                                                                                id="contract_mm_name"
                                                                                name="contract_mm_name"
                                                                                value="{{ $tasksDetails->task_mm_name }}"
                                                                                required autofocus>
                                                                            <div id="contract_mm_name_feedback" class="invalid-feedback">
                                                                                {{ __('ชื่อmm ') }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 ">
                                                                            <label for="contract_mm_budget"
                                                                                class="form-label">{{ __('วงเงิน (บาท) MM') }}</label>
                                                                            <span class="text-danger"></span>

                                                                            <input type="text" placeholder="0.00"
                                                                                step="0.01" class="form-control"
                                                                                id="contract_mm_budget"
                                                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                                                class="form-control numeral-mask"
                                                                                name="contract_mm_budget"
                                                                                min="0"
                                                                                value="@php
$value = 0;
                                                                                if ($tasksDetails->task_budget_it_operating - $task_sub_sums['operating']['task_mm_budget'] + $task_sub_sums['operating']['task_refund_pa_budget'] > 0) {
                                                                                    $value = $tasksDetails->task_budget_it_operating - $task_sub_sums['operating']['task_mm_budget'] + $task_sub_sums['operating']['task_refund_pa_budget'];
                                                                                } elseif ($tasksDetails->task_budget_it_investment - $task_sub_sums['investment']['task_mm_budget'] + $task_sub_sums['investment']['task_refund_pa_budget'] > 0) {
                                                                                    $value =($task->task_budget_it_investment-$task_sub_sums['investment']['task_mm_budget'])+$task_sub_refund_pa_budget['investment']['task_refund_pa_budget'];
                                                                                } elseif ($tasksDetails->task_budget_gov_utility - $task_sub_sums['utility']['task_mm_budget'] + $task_sub_sums['utility']['task_refund_pa_budget'] > 0) {
                                                                                    $value = $tasksDetails->task_budget_gov_utility - $task_sub_sums['utility']['task_mm_budget'] + $task_sub_sums['utility']['task_refund_pa_budget'];
                                                                                }
                                                                                echo $value; @endphp">

                                                                        </div>
                                                                    </div>
                                                                    <div class="row mt-3">
                                                                        <div class="col-md-3">
                                                                            <label for="contract_number"
                                                                                class="form-label">{{ __('เลขที่สัญญา  ') }}
                                                                            </label>
                                                                            <span class="text-danger">*</span>
                                                                            <input type="text" class="form-control"
                                                                                id="contract_number"
                                                                                name="contract_number" required>

                                                                            <div class="invalid-feedback">
                                                                                {{ __('เลขที่สัญญา') }}
                                                                            </div>
                                                                        </div>


                                                                        {{--                                                                     <input type="number" class="form-control" id="contract_reguiar_id" name="contract_reguiar_id" value="">
 --}}
                                                                        <div class="col-md-9 ">
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
                                                                                    name="contract_pr" required>
                                                                                <div class="invalid-feedback">
                                                                                    {{ __('ใบขอดำเนินการซื้อ/จ้าง (PR) ') }}
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-3">
                                                                                <label for="contract_pr_budget"
                                                                                    class="form-label">{{ __('จำนวนเงิน (บาท) PR') }}</label>
                                                                                <span class="text-danger"></span>
                                                                                <input type="text"
                                                                                    placeholder="0.00" step="0.01"
                                                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                                                    class="form-control numeral-mask"
                                                                                    id="contract_pr_budget"
                                                                                    name="contract_pr_budget"
                                                                                    min="0"
                                                                                    value="@php
$value = 0;
                                                                                    if ($tasksDetails->task_budget_it_operating - $task_sub_sums['operating']['task_mm_budget'] + $task_sub_sums['operating']['task_refund_pa_budget'] > 0) {
                                                                                        $value = $tasksDetails->task_budget_it_operating - $task_sub_sums['operating']['task_mm_budget'] + $task_sub_sums['operating']['task_refund_pa_budget'];
                                                                                    } elseif ($tasksDetails->task_budget_it_investment - $task_sub_sums['investment']['task_mm_budget'] + $task_sub_sums['investment']['task_refund_pa_budget'] > 0) {
                                                                                        $value = ($task->task_budget_it_investment-$task_sub_sums['investment']['task_mm_budget'])+$task_sub_refund_pa_budget['investment']['task_refund_pa_budget'];
                                                                                    } elseif ($tasksDetails->task_budget_gov_utility - $task_sub_sums['utility']['task_mm_budget'] + $task_sub_sums['utility']['task_refund_pa_budget'] > 0) {
                                                                                        $value = $tasksDetails->task_budget_gov_utility - $task_sub_sums['utility']['task_mm_budget'] + $task_sub_sums['utility']['task_refund_pa_budget'];
                                                                                    }
                                                                                    echo $value; @endphp"
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
                                                                                id="contract_PA" name="contract_pa"
                                                                                required>
                                                                            <div class="invalid-feedback">
                                                                                {{ __('ใบขออนุมัติซื้อ/จ้าง (PA) ') }}
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                            <label for="contract_pa_budget"
                                                                                class="form-label">{{ __('จำนวนเงิน (บาท) PA') }}</label>
                                                                            <span class="text-danger"></span>
                                                                            <input type="taxt" placeholder="0.00"
                                                                                step="0.01"
                                                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                                                class="form-control numeral-mask"
                                                                                id="contract_pa_budget"
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
                                                                                    name="contract_po_budget"
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
                                                                                    name="contract_cn">
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
                                                                                id="contract_pp" name="contract_cn">
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

                                                                {{--           <div id="rounds_form" style="display:none;">
                                                        <div class="row mt-3">
                                                            <div class="col-md-12">
                                                                <label for="rounds"
                                                                    class="form-label">{{ __('งวด/ค่าใช้จ่ายสำนักงาน') }}</label>
                                                                <span class="text-danger">*</span>

                                                                {{ Form::select('contract_type', \Helper::taskconrounds(), null, ['class' => 'js-example-basic-single', 'placeholder' => 'งวด...', 'id' => 'rounds', 'name' => 'change']) }}

                                                                <div id="tasksContainer"></div>
                                                                <div class="invalid-feedback">
                                                                    {{ __(' ') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
 --}}
                                                                <div id="rounds_form" class="callout callout-light"
                                                                    style="display:none;">
                                                                    <div class="row mt-3">


                                                                        <div class="row callout callout-warning  mt-3">

                                                                            <div class="col-md-3">
                                                                                <label for="contract_start_date"
                                                                                    class="form-label">{{ __('วันที่เริ่มต้น') }}</label>
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
                                                                                    class="form-label">{{ __('วันที่สิ้นสุด') }}</label>
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
                                                                                    name="contract_sign_date"
                                                                                      value={{ Helper::Date4(date('Y-m-d H:i:s', $projectDetails?->project_start_date)) }}


                                                                                    >
                                                                                <!--<div data-coreui-toggle="date-picker" id="contract_sign_date"
                                                                        data-coreui-format="dd/MM/yyyy"></div>-->
                                                                            </div>
                                                                        </div>

                                                                        <div id="cn_form" >
                                                                            <div class="row mt-3">





                                                                                        <div class="col-md-4">
                                                                                            <label for="total_pa_budget"
                                                                                                class="form-label">{{ __('จำนวนเงิน PA') }}</label>
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
                                                                                                class="form-label">{{ __('ใช้ไป เงินทั้งหมด') }}</label>
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





                                                                        <div class="col-md-12 mt-3">

                                                                         {{--    <table border="1">
                                                                                <tr>
                                                                                    <div>เงินทั้งหมด ได้ </div>
                                                                                    <div>เงินรวมทั้งหมด(งวด)</div>

                                                                                </tr>
                                                                                <tr>


                                                                                    <td>
                                                                                        <input id="expenses_delsum">
                                                                                    </td>
                                                                                    <td>
                                                                                        <input id="expenses_sum">
                                                                                    </td>
                                                                                </tr>


                                                                            </table> --}}

                                                                            <label id="rounds_label" for="rounds"
                                                                                class="form-label">{{ __('งวดที่') }}</label>
                                                                            <span class="text-danger">*</span>
                                                                            {{ Form::select('contract_type', \Helper::taskconrounds(), null, ['class' => ' js-example-basic-single', 'placeholder' => 'งวด...', 'id' => 'rounds', 'name' => 'change']) }}
                                                                            <div id="tasksContainer"></div>
                                                                            {{-- <div class="invalid-feedback">
                                                                                {{ __(' ') }}
                                                                            </div> --}}
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
                                                            ข้อมูลสัญญา เอกสารแนบ
                                                        </button>
                                                    </h2>
                                                    <div id="collapseThree" class="accordion-collapse collapse"
                                                        aria-labelledby="headingThree"
                                                        data-coreui-parent="#accordionExample">
                                                        <div class="accordion-body">

                                                            <!--ข้อมูลสัญญา 3 -->
                                                            {{--       <div class="col-md-12">
                                                                <label for="contract_file" class="form-label">{{ __('อัปโหลดไฟล์') }}</label>
                                                                <input type="file" class="form-control" id="contract_file" name="contract_file" multiple>
                                                                <div class="invalid-feedback">
                                                                    {{ __('เลือกไฟล์สัญญา') }}
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








                                            <x-button  class="btn-success" type="submit">
                                                {{ __('coreuiforms.save') }}
                                            </x-button>

                                            {{--
                @if ($origin && $task)
                    <x-button
                        link="{{ route('project.task.createsub', ['project' => $origin, 'task' => $task]) }}"
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
            {{--  <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script> --}}
            <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
            <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>


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
                $(document).ready(function() {
                    // Initially hide the fields
                    //$("#contract_pa_budget").parent().hide();


                    // Show the fields when a value is entered in task_cost_it_operating
                    $("#contract_pa_budget").on("change", function() {
                        if ($(this).val() != '') {
                            $("#rounds_form").show();
                        } else {
                            $("#rounds_form").hide();
                        }
                    });
                });
            </script>


          <script>
                $(document).ready(function() {
                    $(":input").inputmask();
                });
            </script>
            <script>
                var contractNumber = "contract_number";
                var parts = contractNumber.split("/");
                var contractReguiarId = parts[0];

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
                        $("#" + costField).on("change", calculateRefund);
                    });
                });
            </script>
            {{--
     <script>
        function calculateRefund() {
          var pr_budget = parseFloat(document.getElementById("contract_pr_budget").value);
          var pa_budget = parseFloat(document.getElementById("contract_pa_budget").value);
          var refund = pr_budget - pa_budget;
          document.getElementById("contract_refund_pa_budget").value = refund.toFixed(2);
        }
      </script> --}}




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
                       // console.log(selectedValue);
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
                    var task_budget_it_operating =
                        {{ $tasksDetails->task_budget_it_operating - $task_sub_sums['operating']['task_mm_budget'] + $task_sub_refund_pa_budget['operating']['task_refund_pa_budget'] }};
                    var task_budget_it_investment =
                        {{ $tasksDetails->task_budget_it_investment - $task_sub_sums['investment']['task_mm_budget'] + $task_sub_refund_pa_budget['investment']['task_refund_pa_budget'] }};
                    var task_budget_gov_utility =
                        {{ $tasksDetails->task_budget_gov_utility - $task_sub_sums['utility']['task_mm_budget'] + $task_sub_refund_pa_budget['utility']['task_refund_pa_budget'] }};

                    $("#contract_mm_budget").on("input", function() {
                        var max = 0;
                        var fieldId = $(this).attr('id');
                        var contract_mm_budget = parseFloat($("#contract_mm_budget").val().replace(/,/g, ""));
                        var contract_pr_budget = parseFloat($("#contract_pr_budget").val().replace(/,/g, ""));
                        var contract_pa_budget = parseFloat($("#contract_pa_budget").val().replace(/,/g, ""));
                        var contract_er_budget = parseFloat($("#contract_er_budget").val().replace(/,/g, ""));
                        var contract_po_budget = parseFloat($("#contract_po_budget").val().replace(/,/g, ""));
                        var contract_cn_budget = parseFloat($("#contract_cn_budget").val().replace(/,/g, ""));

                        if (fieldId === "contract_mm_budget") {
                            if (task_budget_it_operating > 0) {
                               // console.log("test");
                                if (contract_mm_budget < contract_pr_budget || contract_mm_budget < -0 ) {
    $("#contract_mm_budget").val(''); // Set the value of the input field
    $("#contract_pr_budget").val(''); // Set the value of the input field
    $("#contract_pa_budget").val(''); // Set the value of the input field
    $("#contract_er_budget").val(''); // Set the value of the input field
    $("#contract_po_budget").val(''); // Set the value of the input field
    $("#contract_cn_budget").val(''); // Set the value of the input field

}
                                max = parseFloat(task_budget_it_operating);
                            }


                            else if (task_budget_it_investment > 0) {
                              //  console.log(contract_mm_budget+"<"+contract_pr_budget);


                                if (contract_mm_budget < contract_pr_budget || contract_mm_budget < -0) {
                                    $("#contract_mm_budget").val(''); // Set the value of the input field
    $("#contract_pr_budget").val(''); // Set the value of the input field
    $("#contract_pa_budget").val(''); // Set the value of the input field
    $("#contract_er_budget").val(''); // Set the value of the input field
    $("#contract_po_budget").val(''); // Set the value of the input field
    $("#contract_cn_budget").val(''); // Set the value of the input field
}
                                max = parseFloat(task_budget_it_investment);
                            }



                            else if (task_budget_gov_utility > 0) {
                                if (contract_mm_budget < contract_pr_budget || contract_mm_budget < -0) {
                                    $("#contract_mm_budget").val(''); // Set the value of the input field
    $("#contract_pr_budget").val(''); // Set the value of the input field
    $("#contract_pa_budget").val('');
    $("#contract_er_budget").val(''); // Set the value of the input field
    $("#contract_po_budget").val(''); // Set the value of the input field
    $("#contract_cn_budget").val(''); // Set the value of the input field
                                 } // Set the
                                max = parseFloat(task_budget_gov_utility);
                            }
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
                            /* $(this).val(max.toFixed(2)); */
                            $(this).val(0);
                        }
                    });
                });
            </script>

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
                        var contract_pr_budget = parseFloat($("#contract_pr_budget").val().replace(/,/g, ""));
                        var contract_pa_budget = parseFloat($("#contract_pa_budget").val().replace(/,/g, ""));

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

                      //  console.log('a', groups);
                       // console.log('ab', task);


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

                        $('#contract-type-budget').val(budget);
                    });
                });
            </script>


{{-- <div class="col-md-2">
    <label class="form-label">ร้อยละ เงินงวด  ${i + 1} &nbsp: &nbsp</label>
    <input type="text" name="tasks[${i}][taskbudget_percentage]" id="tasks[${i}][taskbudget_percentage]" class="form-control custom-input numeral-mask exp"  data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false" >
    <div class="invalid-feedback">ระบุ ร้อยละ  เงินงวด</div>

</div> --}}


<script>
    $(document).ready(function() {





        $('#rounds').change(function() {
            var rounds = $(this).val();
            $('#tasksContainer').empty(); // clear the container
            var contract_fiscal_year = {{$pro->project_fiscal_year}};
contract_fiscal_year = contract_fiscal_year - 543;

var fiscalYearStartDate = new Date(contract_fiscal_year - 1, 9, 1); // 1st October of the previous year
var fiscalYearEndDate = new Date(contract_fiscal_year, 8, 30); // 30th September of the fiscal year


            for (var i = 0; i < rounds; i++) {
                var content = `
                <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">ชื่องวด ${i + 1} &nbsp: &nbsp</label>
                            <input class="form-control" type="text" name="tasks[${i}][task_name]" value="งวด ${i + 1}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">เงินงวด ${i + 1} &nbsp: &nbsp</label>

                            <span    id="tasks_${i}_taskbudget_feedback" class="text-danger">*</span>

                            <input aria-describedby="tasks_${i}_taskbudget_feedback"
                            id="[${i}][expenses]"
                            type="text"
                            name="tasks[${i}][taskbudget]"
                            class="form-control custom-input numeral-mask expenses"
                             data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false" required>
                            <div id="tasks_${i}_taskbudget_feedback"class="invalid-feedback">ระบุเงินงวด</div>

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
    /*if(i == 0){
        $(`#start_date_${i}`).datepicker({
            dateFormat: 'dd/mm/yy',
                    changeMonth: true,
                    changeYear: true,
                    language: "th-th",
            startDate: fiscalYearStartDate,
            endDate: fiscalYearEndDate,
            autoclose: true
            }).on('changeDate', function(selected) {
            // When a start date is selected, update the minDate of the next round's start date
            var index = parseInt(this.id.replace('start_date_', '')) + 1;
            var nextStartDatePicker = $('#start_date_' + index);
            if(nextStartDatePicker.length) {
                var newMinDate = selected.date;
                newMinDate.setDate(newMinDate.getDate() + 1); // Set next start date to at least one day after selected
                nextStartDatePicker.datepicker('setStartDate', newMinDate);
            }
        });
        $(`#end_date_${i}`).datepicker({
            dateFormat: 'dd/mm/yy',
                    changeMonth: true,
                    changeYear: true,
                    language: "th-th",
            startDate: fiscalYearStartDate,
            //endDate: fiscalYearEndDate,
            autoclose: true
            }).on('changeDate', function(selected) {
            // When an end date is selected, update the maxDate of the current round's start date
            var index = parseInt(this.id.replace('end_date_', ''));
            var startDatePicker = $('#start_date_' + index);
            if(startDatePicker.length) {
                var newMaxDate = selected.date;
                startDatePicker.datepicker('setEndDate', newMaxDate);
            }
        });
    }*/
    //var text_end_date = [];
   // var text_start_date = [];


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


/*
        function calculateInstallmentAmounts() {
var totalPA = parseFloat($('#contract_pa_budget').val().replace(/,/g, '')) || 0;
$('#tasksContainer .row').each(function() {
var percentage = parseFloat($(this).find('[name$="[taskbudget_percentage]"]').val()) || 0;
var installmentp = (totalPA * percentage) / 100;
$(this).find('[name$="[taskbudget]"]').val(installmentp.toFixed(2));
});
}
$('#tasksContainer').on('input', '[name$="[taskbudget_percentage]"]', calculateInstallmentAmounts);
// Initial calculation on page load
calculateInstallmentAmounts();
*/

            // การจัดการกับการเปลี่ยนแปลงของอินพุต "ร้อยละ เงินงวด"
         /*    $(document).on('change', '.exp', function() {
            function calculateInstallmentAmounts() {
            var totalPA = parseFloat($('#contract_pa_budget').val().replace(/,/g, '')) || 0;
            $('#tasksContainer .row').each(function() {
            var percentage = parseFloat($(this).find('[name$="[taskbudget_percentage]"]').val()) || 0;
            var installmentp = (totalPA * percentage) / 100;
            $(this).find('[name$="[taskbudget]"]').val(installmentp.toFixed(2));
            });
            }
            $('#tasksContainer').on('input', '[name$="[taskbudget_percentage]"]', calculateInstallmentAmounts);
            // Initial calculation on page load
            calculateInstallmentAmounts();
            }); */





                // When an expense input changes, update the total and check against the budget focus
                        $(document).on('input', '.expenses', function() {
                            var contract_pa_budget = parseFloat($("#contract_pa_budget").val().replace(/,/g, ""));
                            var sum = 0;
                            var index = $(this).data('index');
                            var tasksContainer = $('#tasksContainer');
                            var inputs = $('.expenses').map(function() {
                            // ตรวจสอบว่าค่าในอินพุตไม่ติดลบ
                var value = parseFloat($(this).val().replace(/,/g, "")) || 0;
                if (value < 0) {
                $(this).val(''); // รีเซ็ตค่าถ้าติดลบ  parseFloat($(this).find('[name$="[taskbudget_percentage]"]').val()) || 0;
                value = 0; // ใช้ค่า 0 สำหรับการคำนวณถัดไป
                }
                return value
                            }).get();
                            sum = inputs.reduce(function(a, b) {
                                return a + b;
                            }, 0);


                        //   console.log(sum.toFixed(2)+"-"+inputs[i]);

                            // Calculate the remaining budget after each installment
                            var remainingBudget = contract_pa_budget;
                            for (var i = 0; i < inputs.length; i++) {
                                remainingBudget -= inputs[i];
                            // console.log(remainingBudget.toFixed(2)+"-"+inputs[i]);


                                if (remainingBudget.toFixed(2) < 0) {
                // วน loop เพื่อรีเซ็ตค่าของอินพุตที่ทำให้เงินที่เหลือน้อยกว่าศูนย์
                $('.expenses').each(function() {
                if (parseFloat($(this).val()) < 0) {
                    $(this).val('');
                }
                });

                // console.log(remainingBudget);

                                    // If the remaining budget after any installment is negative, show an error
                                    Swal.fire({
                                        title: "เกิดข้อผิดพลาด",
                                        html: "จำนวนเงินที่ใส่ต้องไม่เกิน " + (contract_pa_budget - (sum -
                                                inputs[i])).toLocaleString('en-US', {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            }) + " บาท" +
                                            "<p>(จำนวนเงินทั้งหมดที่ใส่ต้องไม่เกิน " + (contract_pa_budget)
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
                            if (Math.abs(remainingBudget) < 0.01) {
                remainingBudget = 0;
                }

                if (Math.abs(sum) < 0.01) {
                sum = 0;
                }
                                $('#expenses_sum').val(sum.toLocaleString('en-US', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }));
                                $('#expenses_delsum').val(remainingBudget.toLocaleString('en-US', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2,


                                }));
                //console.log( remainingBudget);
                //console.log( sum);
                // Function to calculate the remaining budget
                function calculateRemainingBudget() {
                var sum = $('.expenses').map(function() {
                return parseFloat($(this).val().replace(/,/g, "")) || 0;
                }).get().reduce(function(a, b) {
                return a + b;
                }, 0);

                var contract_pa_budget = parseFloat($("#contract_pa_budget").val().replace(/,/g, "")) || 0;
                var remainingBudget = contract_pa_budget.toFixed(2) - sum.toFixed(2);
                return remainingBudget.toFixed(2);
                }

                /*   // Form submission handler
                $('#formId').on('submit', function(e) { // Make sure this is the ID of your form
                e.preventDefault();

                var remainingBudget = calculateRemainingBudget();

                if (remainingBudget !== 0) {
                $('#expenses_delsum').addClass('is-invalid');
                // $('.invalid-feedback').text(' ต้องเหลือ 0 '); // Set the text of the feedback
                } else {
                // If the remaining budget is zero, remove validation error
                $('#expenses_delsum').removeClass('is-invalid');
                $('.invalid-feedback').text(''); // Clear the feedback text
                    // ส่งฟอร์ม
                    this.submit();
                }
                }); */
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
                        $('#expenses_delsum').next('.invalid-feedback').text('ตรวงเงิน');
                        $('#expenses_sum').addClass('is-invalid');
                        $('#expenses_sum').next('.invalid-feedback').text('ตรวงเงิน');
                        $('.expenses').each(function(index) {
                            $(this).addClass('is-invalid');
                            $('#tasks_' + index + '_taskbudget_feedback').text('ตรวงเงิน');
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

                      /*   $('#formId input[type="text"]').each(function() {
                        var fieldId = $(this).attr('id');
                        if (typeof validateBudget === "function" && !validateBudget(fieldId)) {
                            formIsValid = false; // Set form as invalid
                        }
                    });
 */
                    /* if (contract_pa_budget !== sumOfExpenses) {
                        $('#' + fieldId).addClass('is-invalid');
                            $('#' + fieldId + '_feedback').text('เลขที่สัญญา มีอยู่แล้ว444');


                            formIsValid = false;

                        } else {
                            $('#' + fieldId).removeClass('is-invalid');
                            contract_pa_budget = sumOfExpenses
                            formIsValid = true;
                        }

                        $("form").on("submit", function(e) {
                        if (!formIsValid) {
                            e.preventDefault();
                            var alertText =  'เลขที่สัญญา มีอยู่แล้ว3333';
                            Swal.fire({
                                title: 'เตือน!',
                                text: alertText,
                                icon: 'warning',
                                confirmButtonText: 'Ok'
                            });
                        }
                    }); */






                    /*       if (formIsValid) {
                     // this.submit(); // Submit the form without jQuery to avoid re-triggering the submit handler
                     Swal.fire({
                            title: 'ข้อผิดพลาด!',
                            text: 'กรุณาป้อนค่างบประมาณที่ถูกต้อง',
                            icon: 'error',
                            confirmButtonText: 'ตกลง'
                        });
                    } else {
                        // If not valid, show an error modal
                       Swal.fire({
                            title: 'ข้อผิดพลาด!',
                            text: 'กรุณาป้อนค่างบประมาณที่ถูกต้อง',
                            icon: 'error',
                            confirmButtonText: 'ตกลง'
                        });
                    } */
                                    // ถ้า formIsValid เป็น true ฟอร์มจะถูกส่งไปยังเซิร์ฟเวอร์

                    //  this.submit(); // ส่งฟอร์ม





      /* $('#formId').on('submit', function(e) {
                    e.preventDefault(); // ป้องกันการส่งฟอร์มแบบปกติ

                    // คำนวณผลรวมของค่าใช้จ่าย
                }); */



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
// var budgetUsed = parseFloat($('#budget-used').val().replace(/,/g, "")) || 0;
var remainingBudget =totalInstallments;

// ใช้ Math.abs() เพื่อจัดการกับค่าที่ใกล้เคียง 0 และปัดเศษทศนิยม
if (Math.abs(remainingBudget) < 0.01) {
remainingBudget = 0;
}

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
$(document).on('change', '.installment', function() {
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





{{-- else if (remainingBudget > 0) {
    Swal.fire({
        title: "เกิดข้อผิดพลาด",
        html: "จำนวนเงินที่ใส่ต้องไม่เกิน fgffff" + (contract_pa_budget - (sum -
                inputs[i])).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }) + " บาท" +
            "<p>(จำนวนเงินทั้งหมดที่ใส่ต้องไม่เกิน " + (contract_pa_budget)
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
    break; // Exit the loop as we have
} --}}




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

var contract_fiscal_year = {{$pro->project_fiscal_year}};
var task_start_date = {{$ta->task_start_date}};
var task_end_date = {{$ta->task_end_date}};
var task_start_date_str = "{{ Helper::Date4(date('Y-m-d H:i:s', $ta->task_start_date)) }}"; // Wrap in quotes
var task_end_date_str = "{{ Helper::Date4(date('Y-m-d H:i:s', $ta->task_end_date)) }}"; // Wrap in quo
contract_fiscal_year =  contract_fiscal_year -543;
       // console.log( contract_fiscal_year);

        var fiscalYearStartDate = new Date( contract_fiscal_year - 1, 9, 1); // 1st October of the previous year
        var fiscalYearEndDate = new Date( contract_fiscal_year, 8, 30); // 30th September of the fiscal year

        //console.log(fiscalYearStartDate);
        //console.log(fiscalYearEndDate);


// Set the start and end dates for the project_start_date datepicker
$("#contract_start_date").datepicker("setStartDate", fiscalYearStartDate);
  //  $("#project_start_date").datepicker("setEndDate", fiscalYearEndDate);

    // Set the start and end dates for the project_end_date datepicker
   $("#contract_end_date").datepicker("setStartDate", fiscalYearStartDate);
    $("#contract_sign_date").datepicker("setEndDate", fiscalYearEndDate);




                    $('#contract_start_date').on('changeDate', function() {
                        var startDate = $(this).datepicker('getDate');
                        $("#contract_end_date").datepicker("setStartDate", startDate);
                        $("#insurance_end_date").datepicker("setStartDate", startDate);
                        $("#contract_sign_date").datepicker("setStartDate", startDate);
                        $("#contract_po_start_date").datepicker("setStartDate", startDate);
                        //  $("#contract_sign_date").datepicker("setStartDate", startDate);
                    });

                    $('#contract_end_date').on('changeDate', function() {
                        var endDate = $(this).datepicker('getDate');
                        $("#contract_start_date").datepicker("setEndDate", endDate);
                        $("#insurance_start_date").datepicker("setEndDate", endDate);


                    });
 // Add click event listener for the delete button    {{ $ta->task_end_date }}    {{ $ta->task_start_date }}

 $('#contract_end_date').click(function(e) {
    e.preventDefault();
    var contract_end_date_str = $("#contract_end_date").val();
    var contract_end_date = convertToDate(contract_end_date_str);
    var task_end_date = convertToDate(task_end_date_str);
      //console.log(task_end_date_str);
        //console.log(task_end_date);
        //console.log(contract_end_date);

    if (contract_end_date > task_end_date) {
        Swal.fire({
            title: 'วันที่ เกิน ?',
            text: "คุณจะทำตามวันที่เกินใช่หรือไม่!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ทำตามวันที่เกิน!',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(

                    'success'
                )
            }
        });
    }
});

function convertToDate(dateStr) {
        var parts = dateStr.split("/");
        var date = new Date(parts[2], parts[1] - 1, parts[0]);
        return date;
    }
 // Add click event listener for the delete button











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
                    var contract_fiscal_year = {{$pro->project_fiscal_year}};
contract_fiscal_year =  contract_fiscal_year -543;
        //console.log( contract_fiscal_year);

        var fiscalYearStartDate = new Date( contract_fiscal_year - 1, 9, 1); // 1st October of the previous year
        var fiscalYearEndDate = new Date( contract_fiscal_year, 8, 30); // 30th September of the fiscal year

       // console.log(fiscalYearStartDate);
      //  console.log(fiscalYearEndDate);

// Set the start and end dates for the project_start_date datepicker
$("#insurance_start_date").datepicker("setStartDate", fiscalYearStartDate);
  //  $("#project_start_date").datepicker("setEndDate", fiscalYearEndDate);

    // Set the start and end dates for the project_end_date datepicker
   $("#insurance_end_date").datepicker("setStartDate", fiscalYearStartDate);
  //Z  $("#insurance_end_date").datepicker("setEndDate", fiscalYearEndDate);




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

{{--

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
            </script> --}}

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

{{-- <script>
    $(document).ready(function(){
        var budgetFields = [
            'contract_mm_budget', 'contract_pr_budget', 'contract_pa_budget',
            'task_budget_it_operating', 'task_budget_it_investment', 'task_budget_gov_utility',
            'task_refund_pa_budget', 'contract_po_budget', 'contract_cn_budget',
            'contract_bd_budget', 'contract_pay', 'contract_pp'
        ];

        budgetFields.forEach(function(budgetField, index) {
            var budgetFieldValue = $("#" + budgetField).val();
            console.log(budgetFields);
            if (budgetFieldValue) {
                budgetFieldValue = parseFloat(budgetFieldValue.replace(/,/g, "")) || 0;

                if (budgetFieldValue < -0 || budgetFieldValue === 0) {
                    $("#contract_mm_budget").val('111');
                }
            }
        });
    });
    </script> --}}
        </x-slot:javascript>
    </x-app-layout>



    {{--

              <script>
                                $(document).ready(function() {
    $('#rounds').change(function() {
        var rounds = $(this).val();
        $('#tasksContainer').empty(); // clear the container
        for (var i = 0; i < rounds; i++) {
            var content = `
            <div class="row mt-3">
    <div class="col-md-12">
        <br> <!-- Line break for spacing -->
        <div class="col-md-3">
        <label class="custom-label">ชื่องวด ` + (i + 1) + ` &nbsp: &nbsp</label>
        <input type="text" name="tasks[` + i + `][task_name]" value="งวด ` + (i + 1) + `" class="custom-input">
</div>
        <br> <!-- Line break for spacing -->
        <div class="col-md-3">
        <label class="custom-label">เงินงวด ` + (i + 1) + ` &nbsp: &nbsp</label>
        <input type="text" name="tasks[` + i + `][taskbudget]" value="` + (i + 1) + `"   data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false" class="form-control custom-input numeral-mask">
    </div>
        <br> <!-- Line break for spacing -->
        <div class="col-md-3">
        <label class="custom-label">เงินเบิก ` + (i + 1) + ` &nbsp: &nbsp</label>
        <input type="text" name="tasks[` + i + `][taskcost]" value="` + (i + 1) + `"   data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false" class="form-control custom-input numeral-mask">
    </div>
    </div>
</div>
            `;
            $('#tasksContainer').append(content);
        }

        // ประยุกต์ใช้ inputmask กับ input elements ที่ถูกเพิ่มล่าสุด
        $(":input").inputmask();
    });
});
</script>










        <script>
                $(document).ready(function() {
                    // เมื่อมีการเลือกค่าในฟอร์ม task_parent
                    $('#contract_type_budget').on('change', function() {
                        // อ่านค่าของวงเงินที่เป็นตัวหลักจาก contract_type_budget
                        var contractTypeBudget = parseFloat($('#contract-type-budget').val());

                        // อ่านค่าของวงเงินในฟอร์มต่าง ๆ
                        var mmBudget = parseFloat($('#contract_mm_budget').val());
                        var prBudget = parseFloat($('#contract_pr_budget').val());
                        var paBudget = parseFloat($('#contract_pa_budget').val());
                        var poBudget = parseFloat($('#contract_po_budget').val());
                        var erBudget = parseFloat($('#contract_er_budget').val());
                        var cnBudget = parseFloat($('#contract_cn_budget').val());
                        var baBudget = parseFloat($('#contract_ba_budget').val());
                        var bdBudget = parseFloat($('#contract_bd_budget').val());

                        // ตรวจสอบเงื่อนไขว่าวงเงินในฟอร์มต่าง ๆ ต้องไม่เกินวงเงินตัวหลัก
                        if (mmBudget > contractTypeBudget) {
                            $('#modal-message').text('วงเงิน (บาท) MM เกินวงเงินที่กำหนด');
                            $('#modal').modal('show');
                        }
                        if (prBudget > contractTypeBudget) {
                            $('#modal-message').text('วงเงินในใบขอดำเนินการซื้อ/จ้าง (PR) เกินวงเงินที่กำหนด');
                            $('#modal').modal('show');
                        }
                        if (paBudget > contractTypeBudget) {
                            $('#modal-message').text('วงเงินในใบขออนุมัติซื้อ/จ้าง (PA) เกินวงเงินที่กำหนด');
                            $('#modal').modal('show');
                        }
                        if (poBudget > contractTypeBudget) {
                            $('#modal-message').text('วงเงินในใบสั่งซื้อ (PO) เกินวงเงินที่กำหนด');
                            $('#modal').modal('show');
                        }
                        if (erBudget > contractTypeBudget) {
                            $('#modal-message').text('วงเงินในใบสั่งจ้าง (ER) เกินวงเงินที่กำหนด');
                            $('#modal').modal('show');
                        }
                        if (cnBudget > contractTypeBudget) {
                            $('#modal-message').text('วงเงินในสัญญา (CN) เกินวงเงินที่กำหนด');
                            $('#modal').modal('show');
                        }
                        if (baBudget > contractTypeBudget) {
                            $('#modal-message').text('วงเงินในใบยืมเงินรองจ่าย (BA) เกินวงเงินที่กำหนด');
                            $('#modal').modal('show');
                        }
                        if (bdBudget > contractTypeBudget) {
                            $('#modal-message').text('วงเงินในใบยืมเงินหน่อยงาน (BD) เกินวงเงินที่กำหนด');
                            $('#modal').modal('show');
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




    {{--          <script>
                    $(document).ready(function() {
                        $("#contract_mm_budget, #contract_PR_butget").on("input", function() {
                            var max;
                            var fieldId = $(this).attr('id');

                            if (fieldId === "contract_mm_budget") {
                                max = parseFloat('{{ number_format($task_budget_it_investment) }}'.replace(/,/g,
                                    ""));
                            } else if (fieldId === "contract_mm_budget") {
                                max = parseFloat('{{ number_format($task_budget_gov_utility) }}'.replace(/,/g,
                                    ""));
                            }

                            var current = parseFloat($(this).val().replace(/,/g, ""));
                            if (current > max) {
                                alert("จำนวนเงินที่ใส่ต้องไม่เกิน " + max.toFixed(2) + " บาท");
                                $(this).val(max.toFixed(2));
                            }
                        });



                        $("#contract_PR").on("input", function() {
                            var maxUtility = parseFloat('{{ number_format($task_budget_gov_utility) }}'.replace(
                                /,/g, ""));
                            var current = parseFloat($(this).val().replace(/,/g, ""));
                            if (current > maxUtility) {
                                alert("จำนวนเงินที่ใส่ต้องไม่เกิน " + maxUtility.toFixed(2) + " บาท (ค่าสาธารณูปโภค)");
                                $(this).val(maxUtility.toFixed(2));
                            }
                        });
                    });
            </script> --}}















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
        </script> --}}

    {{-- <script>
                $(document).ready(function() {
                    var tasksData = {!! $tasksJson !!};

                    $('#task_parent').select2({
                        placeholder: 'เลือกกิจกรรม',
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

                        $('#contract-type-budget').val(budget);
                    });
                });
            </script>
 --}}
