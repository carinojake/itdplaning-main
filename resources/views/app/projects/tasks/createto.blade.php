<x-app-layout>
    <x-slot:content>
        <div class="container-fluid">

            {{ Breadcrumbs::render('project.task.createsub', $project, $task) }}
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
                        <x-card>


                            <form method="POST" action="{{ route('project.task.store', $project) }}" class="row needs-validation"
                            novalidate >
                                @csrf
                                <h2> เพิ่ม กิจกรรม </h2>

                                <input {{-- type="hidden" --}} class="form-control" id="task_parent_display"
                                    value="{{ $task->task_name }}" disabled readonly>

                                <input type="hidden" class="form-control" id="task_parent" name="task_parent"
                                    value="{{ $task->task_id }}">

                                    <div class="d-none col-md-3">

                                        </label>
                                         {{ Form::select('task_parent_sub', \Helper::contractType(), '2', ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...', 'id' => 'contract_type']) }}

                                    </div>


                                <div class="d-none row mt-3">

                                    <div class="  col-md-2">
                                        <label for="task_status" class="form-label">{{ __('สถานะกิจกรรม') }}</label>
                                        <span class="text-danger">*</span>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="task_status"
                                                id="task_status1" value="1" >
                                            <label class="form-check-label" for="task_status1">
                                                ระหว่างดำเนินการ
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="task_status"
                                                id="task_status2" value="2">
                                            <label class="form-check-label" for="task_status2">
                                                ดำเนินการแล้วเสร็จ
                                            </label>
                                        </div>
                                    </div>

                                    <div class=" d-none col-md-2">
                                        <label for="task_type" class="form-label">{{ __('งาน/โครงการ') }}</label>

                                        <div>
                                            <input class="form-check-input" type="radio" name="task_type"
                                                id="task_type1" value="1" >
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

                                    <div class="col-md-5  d-none" id='contract_group'>
                                        <div class="form-group">
                                            <label for="task_contract"
                                                class="form-label">{{ __('สัญญา CN / ใบสั่งซื้อ PO / ใบสั่งจ้าง ER / ค่าใช้จ่ายสำนักงาน') }}</label>
                                            <select name="task_contract" id="task_contract"
                                                class="form-control js-example-basic-single">
                                                <option value="">ไม่มี</option>
                                                @foreach ($contracts as $contract)
                                                    <option value="{{ $contract->contract_id }}"
                                                        {{ session('contract_id') == $contract->contract_id ? 'selected' : '' }}>
                                                        [{{ $contract->contract_number }}]{{ $contract->contract_name }}

                                                    </option>
                                                @endforeach
                                            </select>
                                            {{--  <select name="task_contract" id="task_contract" class="form-control js-example-basic-single">
                                                <option value="">ไม่มี</option>
                                                @if (!empty($contracts['results']))
                                                    @foreach ($contracts['results'] as $group)
                                                        <optgroup label="{{ $group['text'] }}">
                                                            @foreach ($group['children'] as $contract)
                                                                <option value="{{ $contract['id'] }}" {{ session('contract_id') == $contract['id'] ? 'selected' : '' }}>
                                                                    [{{ $contract['text'] }}]{{ $contract['text'] }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                @endif
                                            </select> --}}


                                            <div d-none class="invalid-feedback">
                                                {{ __('สัญญา') }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 mt-3 d-none" id='add_contract_group'>
                                        {{--  <a href="{{ route('contract.create', ['origin' => $project,'project'=>$project ,'taskHashid' => $task->hashid]) }}" class="btn btn-success text-white">เพิ่มสัญญา/ใบจ้าง</a> --}}
                                        <a href="{{ route('contract.create', ['origin' => $project, 'project' => $project, 'taskHashid' => $task->hashid]) }}"
                                            class="btn btn-success text-white" target="contractCreate">เพิ่ม</a>
                                    </div>
                                </div>

                                @if (session('contract_id'))
                                    ID: {{ session('contract_id') }}
                                @endif
                                @if (session('contract_number'))
                                    Number: {{ session('contract_number') }}
                                @endif
                                @if (session('contract_name'))
                                    Name: {{ session('contract_name') }}
                                @endif
                                @if (session('contract_pr_budget'))
                                    วงเงินที่ขออนุมัติ: {{ session('contract_pr_budget') }}
                                @endif
                                @if (session('contract_pa_budget'))
                                    ค่าใช้จ่าย: {{ session('contract_pa_budget') }}
                                @endif
                                @if (session('contract_pay'))
                                    เบิก: {{ session('contract_pay') }}
                                @endif




                                <div class="col-md-12 mt-3">
                                    <label for="taskcon_mm_name" class="form-label">{{ __('ชื่อรายการกิจกรรม') }} <span
                                        class="text-danger">*</span></label>

                                    <input type="text" class="form-control" id="taskcon_mm_name" name="taskcon_mm_name" required
                                        autofocus>
                                    <div class="invalid-feedback">
                                        {{ __('ชื่อรายการ กิจกรรม') }}
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>

                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="task_start_date" class="form-label">{{ __('วันที่เริ่มต้น') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="task_start_date" name="task_start_date"
                                               value="{{ Helper::calculateFiscalYearDates($fiscalyear['fiscalyear_project'])['fiscalyear_start'] }}"
                                               required>
                                        <div class="invalid-feedback">
                                            {{ __('วันที่เริ่มต้น') }}
                                        </div>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="task_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }} <span class="text-danger">*</span></label>

                                        <input type="text" class="form-control" id="task_end_date" name="task_end_date"
                                               value="{{ Helper::calculateFiscalYearDates($fiscalyear['fiscalyear_project'])['fiscalyear_end'] }}"
                                               required>

                                        <div class="invalid-feedback">
                                            {{ __('วันที่สิ้นสุด') }}
                                        </div>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                </div>




                                <div class="col-md-12 mt-3">
                                    <label for="task_description" class="form-label">{{ __('รายละเอียด') }}</label>
                                    <textarea class="form-control" name="task_description" id="task_description" rows="10"></textarea>
                                    <div class="invalid-feedback">
                                        {{ __('รายละเอียดการ') }}
                                    </div>
                                </div>

                                {{--    <div class="row">
                                    <h4>งบประมาณ</h4>

                                    <div class="row">
                                        <div >
                                            <strong>วงเงินที่ขออนุมัติ</strong>

                                                <label for="task_budget_it_operating"
                                                    class="form-label">{{ __('งบกลาง ICT') }}</label>
                                                <!-- <input type="number" placeholder="0.00" step="0.01" class="form-control" id="task_budget_it_operating" name="task_budget_it_operating" min="0">-->
                                                <input type="text" placeholder="0.00" step="0.01"
                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control numeral-mask" id="task_budget_it_operating"
                                                    name="task_budget_it_operating" min="0">

                                                <div class="invalid-feedback">
                                                    {{ __('ระบุงบกลาง ICT') }}
                                                </div>


                                                <label for="task_budget_it_investment"
                                                    class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                <!--  <input type="number" placeholder="0.00" step="0.01" class="form-control" id="task_budget_it_investment" name="task_budget_it_investment" min="0">-->
                                                <input type="text" placeholder="0.00" step="0.01"
                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control numeral-mask" id="task_budget_it_investment"
                                                    name="task_budget_it_investment" min="0">

                                                <div class="invalid-feedback">
                                                    {{ __('ระบุงบดำเนินงาน') }}
                                                </div>

                                                <label for="task_budget_gov_utility"
                                                    class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                <!-- <input type="number" placeholder="0.00" step="0.01" class="form-control" id="task_budget_gov_utility" name="task_budget_gov_utility" min="0"> -->
                                                <input type="text" placeholder="0.00" step="0.01"
                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control numeral-mask" id="task_budget_gov_utility"
                                                    name="task_budget_gov_utility" min="0">

                                                <div class="invalid-feedback">
                                                    {{ __('ระบุค่าสาธารณูปโภค') }}
                                                </div>
                                            </div>
                                        </div>
 --}}

                                <div class="row">
                                    <h4>งบประมาณ <span
                                        class="text-danger">*</span> </h4>






                                  {{--   <div class="row mt-3">
                                        <div class="row">
                                            @if ($task->task_budget_it_operating > 0)
                                                <div id="task_budget_it_operating" class="col-6 fw-semibold ">{{ __('งบกลาง ICT') }}</div>
                                                {{ number_format($tasksDetails->task_budget_it_operating- $task_sub_sums['operating']['task_mm_budget']-$task_sub_refund_pa_budget['operating']['task_refund_pa_budget'] ) }}  บาท
                                            @endif
                                        </div>
                                        <div class="row">
                                            @if ($task->task_budget_it_investment > 0)
                                                <div  id="task_budget_it_investment"  class="col-6 fw-semibold ">{{ __('งบดำเนินงาน') }}</div>
                                                {{ number_format($tasksDetails->task_budget_it_investment- $task_sub_sums['investment']['task_mm_budget']-$task_sub_refund_pa_budget['investment']['task_refund_pa_budget'] ) }} บาท
                                            @endif
                                        </div>
                                        <div class="row">
                                            @if ($task->task_budget_gov_utility > 0)
                                                <div  id="task_budget_gov_utility" class="col-6 fw-semibold ">{{ __('ค่าสาธารณูปโภค') }}</div>
                                                {{ number_format($tasksDetails->task_budget_gov_utility - $task_sub_sums['utility']['task_mm_budget']-$task_sub_refund_pa_budget['utility']['task_refund_pa_budget'] ) }} บาท
                                            @endif
                                        </div>
                                    </div> --}}

                                    <div class="row mt-3">
                                        <div class="col-6">
                                            <strong>วงเงินที่ขออนุมัติ</strong>


                                            <div class="col-md-12">
                                                @if ($task->task_budget_it_operating > 0)
                                                    <label for="task_budget_it_operating"
                                                        class="form-label">{{ __('งบกลาง ICT') }}</label>
                                                    <input type="text" placeholder="0.00" step="0.01"
                                                         data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                        class="form-control numeral-mask"
                                                        id="task_budget_it_operating" name="task_budget_it_operating"
                                                        min="0" required>

                                                    <div class="invalid-feedback">
                                                        {{ __('ระบุงบกลาง ICT') }}
                                                    </div>
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>

                                              {{--       ไม่เกิน   {{ number_format(floatval(($task->task_budget_it_operating-$task_sub_sums['operating']['task_mm_budget'])+$task_sub_refund_pa_budget ['operating']['task_refund_pa_budget']), 2) }} บาท --}}
                                                    <div class="col-3">  ไม่เกิน    {{ number_format(floatval(($task->task_budget_it_operating-$task_sub_sums['operating']['task_mm_budget'])+$task_sub_refund_pa_budget ['operating']['task_refund_pa_budget']), 2) }} บาท</div>



                                                @endif

                                            </div>
                                            <div class="col-md-12">
                                                @if ($task->task_budget_it_investment > 0)
                                                    <label for="task_budget_it_investment"
                                                        class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                    <input type="text" placeholder="0.00" step="0.01"
                                                         data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                        class="form-control numeral-mask"
                                                        id="task_budget_it_investment"
                                                        name="task_budget_it_investment" min="0"  required>

                                                    <div class="invalid-feedback">
                                                        {{ __('ระบุงบดำเนินงาน') }}
                                                    </div>
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                   {{-- {{ number_format($tasksDetails->task_budget_it_investment- $task_sub_sums['investment']['task_mm_budget']-$task_sub_refund_pa_budget['investment']['task_refund_pa_budget'] ) }} --}}
                                                    <div class="col-3">  ไม่เกิน    {{ number_format(floatval(($task->task_budget_it_investment-$task_sub_sums['investment']['task_mm_budget'])+$task_sub_refund_pa_budget ['investment']['task_refund_pa_budget']), 2) }} บาท</div>

                                                @endif
                                            </div>
                                            <div class="col-md-12">
                                                @if ($task->task_budget_gov_utility > 0)
                                                    <label for="task_budget_gov_utility"
                                                        class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                    <input type="text" placeholder="0.00" step="0.01"
                                                         data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                        class="form-control numeral-mask" id="task_budget_gov_utility"
                                                        name="task_budget_gov_utility" min="0"  required>

                                                    <div class="invalid-feedback">
                                                        {{ __('ระบุค่าสาธารณูปโภค') }}
                                                    </div>
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
{{--                                                     ไม่เกิน  {{ number_format($tasksDetails->task_budget_gov_utility - $task_sub_sums['utility']['task_mm_budget']-$task_sub_refund_pa_budget['utility']['task_refund_pa_budget'] ) }} บาท
 --}}                                                    <div class="col-3">  ไม่เกิน    {{ number_format(floatval(($task->task_budget_gov_utility-$task_sub_sums['utility']['task_mm_budget'])+$task_sub_refund_pa_budget ['utility']['task_refund_pa_budget']), 2) }} บาท</div>

                                                @endif
                                            </div>

                                        </div>


                                        <div class="col-md-3 mt-3 d-none">

                                            <label for="task_mm_budget_1"
                                                class="form-label">{{ __('budget') }}</label>
                                            <input type="text" placeholder="0.00" step="0.01"
                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                class="form-control numeral-mask"
                                                id="task_mm_budget" name="task_mm_budget"
                                                min="0"  value={{ session('contract_mm_budget') }}  onchange="calculateRefund()" >

                                            <div class="invalid-feedback">
                                                {{ __('mm') }}
                                            </div>


                                        </div>

                                        {{--       <div class="col-6 ">
                                            <strong>ค่าใช้จ่าย</strong>
                                            <div class="col-md-12">
                                                <label for="task_cost_it_operating"
                                                    class="form-label">{{ __('งบกลาง ICT') }}</label>
                                                <!-- <input type="number"placeholder="0.00" step="0.01" class="form-control" id="task_cost_it_operating" name="task_cost_it_operating" min="0">-->
                                                <input type="text" placeholder="0.00" step="0.01"
                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control numeral-mask" id="task_cost_it_operating"
                                                    name="task_cost_it_operating" min="0">


                                                <div class="invalid-feedback">
                                                    {{ __('งบกลาง ICT') }}
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="task_cost_it_investment"
                                                    class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                <!-- <input type="number" placeholder="0.00" step="0.01"class="form-control" id="task_cost_it_investment" name="task_cost_it_investment" min="0"> -->
                                                <input type="text" placeholder="0.00" step="0.01"
                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control numeral-mask" id="task_cost_it_investment"
                                                    name="task_cost_it_investment" min="0">


                                                <div class="invalid-feedback">
                                                    {{ __('งบดำเนินงาน') }}
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="task_cost_gov_utility"
                                                    class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                <!-- <input type="number" placeholder="0.00" step="0.01" class="form-control" id="task_cost_gov_utility" name="task_cost_gov_utility" min="0"> -->
                                                <input type="text" placeholder="0.00" step="0.01"
                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control numeral-mask" id="task_cost_gov_utility"
                                                    name="task_cost_gov_utility" min="0">


                                                <div class="invalid-feedback">
                                                    {{ __('ระบุค่าสาธารณูปโภค') }}
                                                </div>
                                            </div>
                                        </div> --}}

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





    <script>
       $(document).ready(function() {
$("#task_budget_it_investment, #task_budget_gov_utility, #task_budget_it_operating").on("input", function() {
    var max = 0;
    var fieldId = $(this).attr('id');
    var budgetItOperating = $("#task_budget_it_operating").val();
        var budgetItInvestment = $("#task_budget_it_investment").val();
        var budgetGovUtility = $("#task_budget_gov_utility").val();
    if (fieldId === "task_budget_it_investment") {
        if (budgetItInvestment === "0" || budgetItInvestment === '' || parseFloat(budgetItInvestment) < -0) {
                $("#task_budget_it_investment").val('');
            }
        max = parseFloat({{  $tasksDetails->task_budget_it_investment-$task_sub_sums['investment']['task_mm_budget']+$task_sub_sums['investment']['task_refund_pa_budget'] }});
    } else if (fieldId === "task_budget_it_operating") {
        if (budgetItOperating === "0" || budgetItOperating === '' || parseFloat(budgetItOperating) < -0 ) {
                    $("#task_budget_it_operating").val('');
                }
        max = parseFloat({{ $tasksDetails->task_budget_it_operating -  $task_sub_sums['operating']['task_mm_budget']+$task_sub_sums['operating']['task_refund_pa_budget']}});
    } else if (fieldId === "task_budget_gov_utility") {
        if (budgetGovUtility === "0" || budgetGovUtility === '' || parseFloat(budgetGovUtility) < -0) {
                $("#task_budget_gov_utility").val('');
            }
        max = parseFloat({{ $tasksDetails->task_budget_gov_utility -  $task_sub_sums['utility']['task_mm_budget']+$task_sub_sums['utility']['task_refund_pa_budget']}});
    }

    var current = parseFloat($(this).val().replace(/,/g , ""));
    if (current > max) {


        Swal.fire("จำนวนเงินที่ใส่ต้องไม่เกิน " +max.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + " บาท");

        $(this).val(0);

        /* $(this).val(max.toFixed(2)); */
    }
});
});
    </script>


     {{--    <script>
            $(document).ready(function() {
                $("#task_budget_it_operating,#task_budget_it_investment, #task_budget_gov_utility").on("input",
                    function() {
                        var max = 0;
                        var fieldId = $(this).attr('id');

                        if (fieldId === "task_budget_it_investment") {

                                        max = parseFloat({{   $tasksDetails->task_budget_it_investment-$task_sub_sums['investment']['task_mm_budget']+$task_sub_sums['investment']['task_refund_pa_budget'] }});
                                    } else if (fieldId === "task_budget_it_operating") {
                                        max = parseFloat({{ $tasksDetails->task_budget_it_operating -  $task_sub_sums['operating']['task_mm_budget']+$task_sub_sums['operating']['task_refund_pa_budget']}});
                                    } else if (fieldId === "task_budget_gov_utility") {
                                        max = parseFloat({{ $tasksDetails->task_budget_gov_utility -  $task_sub_sums['utility']['task_mm_budget']+$task_sub_sums['utility']['task_refund_pa_budget']}});
                                    }

                        var current = parseFloat($(this).val().replace(/,/g, ""));
                        if (current > max) {
        Swal.fire("จำนวนเงินที่ใส่ต้องไม่เกินwwww " + max.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + " บาท");
         /*  $(this).val(max.toFixed(2)); */
$(this).val(0);
        }


                    });
            });
        </script> --}}







       <script>
            var budgetFields = ['task_budget_it_operating', 'task_budget_it_investment', 'task_budget_gov_utility'];

            function calculateRefund() {
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
                $(":input").inputmask();
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
        var task_start_date_str = "{{ Helper::Date4(date('Y-m-d H:i:s', $task->task_start_date)) }}"; // Wrap in quotes
        var task_end_date_str = "{{ Helper::Date4(date('Y-m-d H:i:s', $task->task_end_date)) }}"; // Wrap in quotes

        project_fiscal_year = project_fiscal_year - 543;

        var fiscalYearStartDate = new Date(project_fiscal_year - 1, 9, 1); // 1st October of the previous year
        var fiscalYearEndDate = new Date(project_fiscal_year, 8, 30); // 30th September of the fiscal year

        console.log(project_start_date_str);
        console.log(project_end_date_str);
        console.log(fiscalYearStartDate);
        console.log(fiscalYearEndDate);
        console.log(task_start_date_str);
        console.log(task_end_date_str)
// Set the start and end dates for the project_start_date datepicker
$("#task_start_date").datepicker("setStartDate", fiscalYearStartDate);
  //  $("#project_start_date").datepicker("setEndDate", fiscalYearEndDate);

    // Set the start and end dates for the project_end_date datepicker
   // $("#project_end_date").datepicker("setStartDate", fiscalYearStartDate);
   // $("#task_end_date").datepicker("setStartDate", fiscalYearStartDate);
    $("#task_end_date").datepicker("setEndDate", task_end_date_str);
   // $("#task_end_date").datepicker("fiscalYearEndDate","setEndDate");



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
            $(document).ready(function() {
                var contract_label = $('#contract_label');

                $('input[type=radio][name=task_type]').change(function() {
                    var task_type = $(this).val();

                    if (task_type == 1) {
                        contract_label.text('สัญญา');
                        $('#contract_group').show();
                        $('#add_contract_group').show();
                    } else if (task_type == 2) {
                        contract_label.text('สัญญา');
                        $('#contract_group').show();
                        $('#add_contract_group').show();
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
