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
                        <x-card title="{{ __('เพิ่มกิจกรรม') }}">

                            <form method="POST" action="{{ route('project.task.create', $project) }}"
                                class="row g-3 needs-validation" novalidate>

                                @csrf
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label for="taskcon_mm_name" class="form-label">{{ __('ชื่อกิจกรรม') }}</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" id="taskcon_mm_name" name="taskcon_mm_name"
                                            required autofocus>
                                    </div>

                                </div>





                                <div class=" row mt-3">
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

                      {{--           <div class="col-md-3">
                    <label for="task_parent" class="form-label">{{ __('เป็นกิจกรรมย่อย') }}</label>


                        <select name="task_parent" id="task_parent" class="form-control">

                            <option value="">ไม่มี</option>
                            @foreach ($tasks as $task)
                              <option value="{{ $task->task_id }}">{{ $task->task_name }}</option>
                            @endforeach
                          </select>
                </select>
                      </select>
                    <div class="invalid-feedback">
                        {{ __('กิจกรรมย่อย') }}
                    </div>
                </div> --}}
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


                                <div id="contractSelection">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="task_contract" class="form-label">{{ __('สัญญา') }}</label>

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

                                        <a href="{{ route('contract.create', ['origin' => $project, 'project' => $project]) }}"
                                            class="btn btn-success text-white"
                                            target="contractCreate">เพิ่มสัญญา/ใบจ้าง</a>
                                    </div>
                                </div>


                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="task_start_date"
                                            class="form-label">{{ __('วันที่เริ่มต้น') }}</label>
                                        <span class="text-danger">*</span>
                                        <input class="form-control" id="task_start_date" name="task_start_date"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="task_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }}</label>
                                        <span class="text-danger">*</span>
                                        <input class="form-control" id="task_end_date" name="task_end_date" required>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label for="task_description"
                                        class="form-label">{{ __('รายละเอียดกิจกรรม') }}</label>
                                    <textarea class="form-control" name="task_description" id="task_description" rows="10"></textarea>
                                    <div class="invalid-feedback">
                                        {{ __('รายละเอียดกิจกรรม') }}
                                    </div>
                                </div>

                                <div class="row">
                                    <h4>งบประมาณ</h4>
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-md-4 needs-validation" novalidate>
                                                <label for="task_budget_it_operating"
                                                    class="form-label">{{ __('งบกลาง ICT') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                    data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                    class="form-control numeral-mask" id="task_budget_it_operating"
                                                    name="task_budget_it_operating"
                                                    @if(($request->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating) == 0) readonly @endif>


                                                <div class="invalid-feedback">
                                                    {{ __('ระบุงบกลาง ICT') }}

                                                </div>

                                                ไม่เกิน
                                                {{ number_format($request->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating,2) }}
                                                บาท


                                              <span id="password-error"> </span>


                                            </div>
                                            <div class="col-md-4">
                                                <label for="task_budget_it_investment"
                                                    class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                    data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                    class="form-control numeral-mask" id="task_budget_it_investment"
                                                    name="task_budget_it_investment"

                                                    @if(($request->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment) == 0) readonly @endif>

                                                <div class="invalid-feedback">
                                                    {{ __('ระบุงบดำเนินงาน') }}
                                                </div>
                                                ไม่เกิน
                                                {{ number_format($request->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment,2) }}
                                                บาท
                                            </div>
                                            <div class="col-md-4">
                                                <label for="task_budget_gov_utility"
                                                    class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                    data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                    class="form-control numeral-mask" id="task_budget_gov_utility"
                                                    name="task_budget_gov_utility"
                                                    @if(($request->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility) == 0) readonly @endif>

                                                <div class="invalid-feedback">
                                                    {{ __('ระบุค่าสาธารณูปโภค') }}
                                                </div>
                                                ไม่เกิน
                                                {{ number_format($request->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility,2) }} บาท
                                            </div>
                                        </div>
                                    </div>
                                    <div type="hidden" class="form-check form-check-inline">
                                        <input type="hidden" class="form-check-input" type="radio" name="task_refund_pa_status"
                                            id="task_refund_pa_status" value="3" checked>

                                    </div>
                                </div>

                                <div class="d-none col-md-3">

                                </label>
{{--                                 {{ Form::select('task_parent_sub', \Helper::contractType(), '1', ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...', 'id' => 'contract_type']) }}
 --}}
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
        var project_start_date = {{$projectDetails->project_start_date}};
        var project_end_date = {{$projectDetails->project_end_date}};
        project_fiscal_year = project_fiscal_year -543;
        console.log(project_fiscal_year);


        var fiscalYearStartDate = new Date(project_fiscal_year - 1, 9, 1); // 1st October of the previous year
        var fiscalYearEndDate = new Date(project_fiscal_year, 8, 30); // 30th September of the fiscal year

        var fiscalproject_start_date =  Date(project_start_date);
        var fiscalproject_end_date =  Date(project_end_date);

        console.log(fiscalproject_start_date);
        console.log(fiscalproject_end_date);
        console.log(fiscalYearStartDate);
        console.log(fiscalYearEndDate);
// Set the start and end dates for the project_start_date datepicker
$("#task_start_date").datepicker("setStartDate", fiscalYearStartDate);
  //  $("#project_start_date").datepicker("setEndDate", fiscalYearEndDate);

    // Set the start and end dates for the project_end_date datepicker
   // $("#project_end_date").datepicker("setStartDate", fiscalYearStartDate);
    $("#task_end_date").datepicker("setEndDate", fiscalYearEndDate);



        $('#task_start_date').on('changeDate', function() {
            var startDate = $(this).datepicker('getDate');
            $("#task_end_date").datepicker("setStartDate", startDate);
        });

     /*    $('#task_end_date').on('changeDate', function() {
            var endDate = $(this).datepicker('getDate');
            $("#task_start_date").datepicker("setEndDate", endDate);
        }); */
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

        <script>
           $(document).ready(function() {
    $("#task_budget_it_investment, #task_budget_gov_utility, #task_budget_it_operating").on("input", function() {
        var max = 0;
        var fieldId = $(this).attr('id');
  var budgetItOperating = $("#task_budget_it_operating").val();
        var budgetItInvestment = $("#task_budget_it_investment").val();
        var budgetGovUtility = $("#task_budget_gov_utility").val();

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

        }

        else if (fieldId === "task_budget_it_operating") {
            max = parseFloat({{ $request->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating }});
                if (budgetItOperating === "0" || budgetItOperating === '' || parseFloat(budgetItOperating) < -0) {
                    $("#task_budget_it_operating").val('');
                }
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

















    </x-slot:javascript>
</x-app-layout>

     {{--  <script>
            $(function() {
                if (typeof jQuery == 'undefined' || typeof jQuery.ui == 'undefined') {
                    alert("jQuery or jQuery UI is not loaded");
                    return;
                }

                var d = new Date();
                var toDay = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 543);

                $("#task_start_date, #task_end_date").datepicker({

                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'dd/mm/yy',

                    isBuddhist: true,
                    defaultDate: toDay,
                   language:'th-th',
                    dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
                    dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
                    monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม',
                        'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
                    ],
                    monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.',
                        'ต.ค.', 'พ.ย.', 'ธ.ค.'
                    ]
                });
            });
        </script>

<script>
    $(document).ready(function() {
       $("#task_start_date").datepicker({});
        $("#task_end_date").datepicker({ });
        $('#task_start_date').change(function() {
                        startDate = $(this).datepicker('getDate');
                        $("#task_end_date").datepicker("option", "minDate", startDate);
                    })

                    $('#task_end_date').change(function() {
                        endDate = $(this).datepicker('getDate');
                        $("#task_start_date").datepicker("option", "maxDate", endDate);
                    })

    });
    </script> --}}
