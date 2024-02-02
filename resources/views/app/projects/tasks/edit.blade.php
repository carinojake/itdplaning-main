<x-app-layout>
    <x-slot:content>
        <div class="container-fluid">
           {{--  {{ Breadcrumbs::render('project.task.edit', $project, $task) }} --}}
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
                        <x-card title="{{ __('แก้ไขกิจกรรม') }} {{ $task->task_name }}">
                            <form id = 'formId' method="POST"
                                action="{{ route('project.task.update', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
                                class="row needs-validation"
                                novalidate>
                                @csrf
                                {{ method_field('PUT') }}

                                <div class="col-md-12 mt-3">
                                    <label for="task_name" class="form-label">{{ __('ชื่อกิจกรรม') }}</label> <span
                                        class="text-danger">*</span>
                                    <input type="text" class="form-control" id="task_name" name="task_name"
                                        value="{{ $task->task_name }}" required autofocus>
                                    <div class="invalid-feedback">
                                        {{ __('ชื่อกิจกรรม') }}
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">

                                        <label for="task_status" class="form-label">{{ __('สถานะกิจกรรม') }}</label>
                                        <span class="text-danger">*</span>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="task_status"
                                                id="task_status1" value="1" @checked($task->task_status == 1)>
                                            <label class="form-check-label" for="task_status1">
                                                ระหว่างดำเนินการ
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="task_status"
                                                id="task_status2" value="2" @checked($task->task_status == 2)>
                                            <label class="form-check-label" for="task_status2">
                                                ดำเนินการแล้วเสร็จ
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="row mt-3">

                                <div class="col-md-3">
                                    <label for="task_parent" class="form-label">{{ __('เป็นกิจกรรม') }}</label>
                                    <span class="text-danger">*</span>
                                    {{-- <input type="text" class="form-control" id="task_parent" name="task_parent"> --}}
                                    <select name="task_parent" id="task_parent" class="form-control">
                                        <option value="">ไม่มี</option>
                                        @foreach ($tasks as $subtask)
                            <option value="{{ $subtask->task_id }}"
                                                {{ $task->task_parent == $subtask->task_id ? 'selected' : '' }}>
                                                {{ $subtask->task_name }}</option>
                                    @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ __('กิจกรรม') }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="task_status" class="form-label">{{ __('สถานะกิจกรรม') }}</label> <span
                                        class="text-danger">*</span>
                                    <div >
                                        <input class="form-check-input" type="radio" name="task_status"
                                            id="task_status1" value="1"  @checked($task->task_status == 1)>
                                        <label class="form-check-label" for="task_status1">
                                            อยู่ในระหว่างดำเนินการ
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="task_status"
                                            id="task_status2" value="2"  @checked($task->task_status == 2)>
                                        <label class="form-check-label" for="task_status2">
                                            ดำเนินการแล้วเสร็จ
                                        </label>
                                    </div>
                                    <div class="invalid-feedback">
                                        {{ __('สถานะงาน/โครงการ') }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="task_type" class="form-label">{{ __('สถานะงาน/โครงการ') }}</label> <span class="text-danger">*</span>
                                    <div >
                                        <input class="form-check-input" type="radio" name="task_type" id="task_type1" value="1"
                                        @checked($task->task_type == 1)>
                                      <label class="form-check-label" for="task_type1">
                                        มี PA
                                      </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="task_type" id="task_type2" value="2"
                                        @checked($task->task_type == 2)>
                                      <label class="form-check-label" for="task_type2">
                                        ไม่มี PA
                                      </label>
                                    </div>
                            </div>-->



                                <!--  <div class="col-md-12">
                                <label for="task_contract" class="form-label">{{ __('สัญญา') }}</label> <span
                                    class="text-danger">*</span>
                                {{-- <input type="text" class="form-control" id="task_contract" name="task_contract"> --}}
                                <select name="task_contract" id="task_contract" class="form-control">
                                    <option value="">ไม่มี</option>
                                    @foreach ($contracts as $contract)
@if ($task->contract->count() > 0 && $contract->contract_id == $task->contract->first()->contract_id)
<option value="{{ $contract->contract_id }}"selected>
                                                [{{ $contract->contract_number }}]{{ $contract->contract_name }}
                                            </option>
@else
<option value="{{ $contract->contract_id }}">
                                                [{{ $contract->contract_number }}]{{ $contract->contract_name }}
                                            </option>
@endif
@endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{ __('สัญญา') }}
                                </div>
                            </div>-->



                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="task_start_date"
                                            class="form-label">{{ __('วันที่เริ่มต้น') }}</label>
                                        <input type="text" class="form-control" id="task_start_date" name="task_start_date"
                                            value="{{ \Helper::date4(date('Y-m-d H:i:s', $task->task_start_date)) }}" required>


                                        </div>



                                    <div class="col-md-6">
                                        <label for="task_end_date"
                                        type="text" class="form-label">{{ __('วันที่สิ้นสุด') }}</label>
                                        <input class="form-control" id="task_end_date" name="task_end_date"
                                            value="{{ \Helper::date4(date('Y-m-d H:i:s', $task->task_end_date)) }}" required>



                                        </div>
                                </div>




                                <div class="col-md-12 mt-3">
                                    <label for="task_description"
                                        class="form-label">{{ __('รายละเอียดกิจกรรม') }}</label>
                                    <textarea class="form-control" name="task_description" id="task_description" rows="10">
                    {{ $task->task_description }}
                  </textarea>
                                    <div class="invalid-feedback">
                                        {{ __('รายละเอียดกิจกรรม') }}
                                    </div>
                                </div>



                                <div class="row">


                                    <div class="row">
                                        <h4>งบประมาณ</h4>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="task_budget_it_operating"
                                                    class="form-label">{{ __('งบกลาง ICT ') }}</label>
                                                <!--<input type="text" placeholder="0.00" step="0.01" class="form-control" id="budget_it_investment" name="budget_it_investment" min="0" value="100000.00">-->
                                                <input type="text" placeholder="0.00" step="0.01"
                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control" id="task_budget_it_operating"
                                                    name="task_budget_it_operating" min="0"
                                                    value="{{ $task->task_budget_it_operating }}"
                                                    @if(($request->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating) == 0) readonly @endif required>

                                                <div  id="task_budget_it_operating_feedback" class="invalid-feedback">
                                                    {{ __('ระบุงบกลาง ICT') }}
                                                </div>



                                              ไม่เกิน
                                              {{ number_format($request->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating+ $increasedData->first()->total_it_operating,2) }}
                                              บาท                                              </div>
                                            <div class="col-4">
                                                <label for="task_budget_it_investment"
                                                    class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control" id="task_budget_it_investment"
                                                    name="task_budget_it_investment" min="0"
                                                    value="{{ $task->task_budget_it_investment }}"


                                                    @if(($request->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment) == 0) readonly @endif>
                                                <div  id="task_budget_it_investment_feedback"class="invalid-feedback">
                                                    {{ __('ระบุงบดำเนินงาน') }}
                                                </div>


                                              ไม่เกิน
                                                {{ number_format($request->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment+ $increasedData->first()->total_it_investment,2) }}
                                                บาท
                                            </div>

                                            <div class="col-md-4">
                                                <label for="task_budget_gov_utility"
                                                    class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control" id="task_budget_gov_utility"
                                                    name="task_budget_gov_utility" min="0"
                                                    value="{{ $task->task_budget_gov_utility }}"
                                                    @if(($request->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility) == 0) readonly @endif>
                                                <div id="task_budget_gov_utility_feedback" class="invalid-feedback">
                                                    {{ __('ระบุค่าสาธารณูปโภค') }}
                                                </div>


                                               ไม่เกิน
                                                {{ number_format($request->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility+ $increasedData->first()->total_gov_utility,2) }}
                                                บาท
                                            </div>
                                        </div>




                                    </div>

                                    <div class="col-md-12 mt-3">
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

                                    </div>


                                </div>

                              {{--   {{ $rootTaskbudget->root_two_cost }}
                                {{ $rootTaskbudget->wait_pay }} --}}


                               {{--  <div class="row mt-3">

                                    <div class="row mt-3">
                                        <h4>เบิกจ่าย</h4>
                                        <div class="col-md-6">
                                            <label for="task_pay_date"
                                                class="form-label">{{ __('วันที่เบิกจ่าย') }}</label>
                                            <input class="form-control" id="task_pay_date" name="task_pay_date"
                                                value="{{ \Helper::date4(date('Y-m-d H:i:s', $task->task_pay_date)) }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="task_pay" class="form-label">{{ __('เบิกจ่าย') }}</label>
                                            <input type="text" placeholder="0.00" step="0.01"
                                                class="form-control" id="task_pay" name="task_pay"
                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                min="0" value="{{ $task->task_pay }}">
                                            <div class="invalid-feedback">
                                                {{ __('เบิกจ่าย') }}
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                    </div>

                    <x-button type="submit" class="btn-success" preventDouble icon="cil-save">
                        {{ __('Save') }}
                    </x-button>                    <x-button link="{{ route('project.task.show', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
                        class="text-black btn-light">{{ __('show') }}</x-button>
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

  {{--       // คำนวณค่างบประมาณที่ถูกใช้ไปแล้ว
        var oldtaskmmValues = {
            operating: parseFloat('{{ $task_sub_sums["operating"]["task_mm_budget"] }}') || 0,
            investment: parseFloat('{{ $task_sub_sums["investment"]["task_mm_budget"] }}') || 0,
            utility: parseFloat('{{ $task_sub_sums["utility"]["task_mm_budget"] }}') || 0
        }; --}}
        <script>
            $(document).ready(function() {
                // ค่างบประมาณขั้นต่ำที่กำหนด
                var minBudgetValues = {
                    task_budget_it_operating: parseFloat('{{ $task_sub_sums["operating"]["task_mm_budget"] }}') || 0,
                    task_budget_it_investment:  parseFloat('{{ $task_sub_sums["investment"]["task_mm_budget"] }}') || 0,
                    task_budget_gov_utility: parseFloat('{{ $task_sub_sums["utility"]["task_mm_budget"] }}') || 0
                };
                console.log('minValues:', minBudgetValues);
                // ฟังก์ชันสำหรับการแปลงตัวเลขเป็นรูปแบบที่มีคอมม่า
                function numberFormat(number) {
                    return number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                }

                // ฟังก์ชันสำหรับตรวจสอบค่างบประมาณที่ป้อน
                function validateBudget(inputId) {
                    var enteredValue = parseFloat($('#' + inputId).val().replace(/,/g, '')) || 0;
                    var minBudget = minBudgetValues[inputId];
                    if (enteredValue < minBudget) {
                        $('#' + inputId + '_feedback').text('ค่างบประมาณที่ป้อนต้องไม่น้อยกว่า ' + numberFormat(minBudget) + ' บาท');
                        $('#' + inputId + '_feedback').show();
                        $('#' + inputId).addClass('is-invalid');
                        return false;
                    } else {
                        $('#' + inputId + '_feedback').hide();
                        $('#' + inputId).removeClass('is-invalid');
                        return true;
                    }
                }

                // ตรวจสอบเมื่อมีการป้อนข้อมูลในฟิลด์
                $('#formId input[type="text"]').on("input", function() {
                    validateBudget($(this).attr('id'));
                });

                // ตรวจสอบก่อนส่งฟอร์ม
                $('#formId').on('submit', function(e) {
                    var formIsValid = true;
                    $('#formId input[type="text"]').each(function() {
                        if (!validateBudget($(this).attr('id'))) {
                            formIsValid = false;
                        }
                    });

                    if (!formIsValid) {
                        e.preventDefault(); // ป้องกันการส่งฟอร์ม
                        Swal.fire({
                            title: 'ข้อผิดพลาด!',
                            text: 'กรุณาป้อนค่างบประมาณที่ถูกต้อง',
                            icon: 'error',
                            confirmButtonText: 'ตกลง'
                        });
                    }
                    // ถ้า formIsValid เป็น true ฟอร์มจะถูกส่งไปยังเซิร์ฟเวอร์
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
          //  console.log(budgetItOperating);
            //console.log(costItOperating);
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
            $(document).ready(function() {
     $("#task_budget_it_investment, #task_budget_gov_utility, #task_budget_it_operating").on("input", function() {
         var max = 0;
         var fieldId = $(this).attr('id');
         var budgetItOperating = $("#task_budget_it_operating").val();
                    var budgetItInvestment = $("#task_budget_it_investment").val();
                    var budgetGovUtility = $("#task_budget_gov_utility").val();

         if (fieldId === "task_budget_it_investment") {
             max = parseFloat({{$request->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment+ $increasedData->first()->total_it_investment}});
             if (budgetItInvestment === "0" || budgetItInvestment === '' || parseFloat(budgetItInvestment) < -0) {
                $("#task_budget_it_investment").val('');
            }


            } else if (fieldId === "task_budget_it_operating") {
             max = parseFloat({{$request->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating+ $increasedData->first()->total_it_operating}});
             if (budgetItOperating === "0" || budgetItOperating === '' || parseFloat(budgetItOperating) < -0 ) {
                    $("#task_budget_it_operating").val('');
                }



            } else if (fieldId === "task_budget_gov_utility") {
             max = parseFloat({{$request->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility+ $increasedData->first()->total_gov_utility}});
             if (budgetGovUtility === "0" || budgetGovUtility === '' || parseFloat(budgetGovUtility) < -0) {
                $("#task_budget_gov_utility").val('');
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
{{-- <script>
    $(document).ready(function() {
        // Define your sumbudget and budget_sub objects here as you did before

        // Define the min values for each budget type
        var minValues = {
            operating: parseFloat('{{ $task->task_budget_it_operating }}'),
            investment: parseFloat('{{ $task->task_budget_it_investment }}'),
            utility: parseFloat('{{ $task->task_budget_gov_utility }}')
        };

        console.log('minValues:', minValues);
        function numberFormat(number) {
        return number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }
    function validateBudget(fieldId, enteredValue) {
            var oldValue = oldValues[fieldId];
            if (enteredValue < oldValue) {
                console.log(fieldId + ":", enteredValue);
                console.log("old" + fieldId + ":", oldValue);
                $('#' + fieldId).addClass('is-invalid');
                $('.invalid-feedback').text('งบประมาณถูกใช้ไป แล้วจะไม่สามารถน้อยกว่านี้ได้11'); // "Warn not to do so."
                formIsValid = false;
                invalidFieldId = fieldId; // Track the invalid field
            } else {
                $('#' + fieldId).removeClass('is-invalid');
                $('.invalid-feedback').text('งบประมาณถูกใช้ไป แล้วจะไม่สามารถน้อยกว่านี้ได้22');
                if (fieldId === invalidFieldId) {
                    // If the current field was the one that caused the form to be invalid
                    invalidFieldId = 'งบประมาณถูกใช้ไป '  + ' แล้วจะไม่สามารถน้อยกว่านี้ได้'; // Reset invalid field tracking if it's now valid
                }
            }
        }

        // Check the budget amount entered when data is input
        $("#budget_it_operating, #budget_it_investment, #budget_gov_utility").on("input", function() {
            formIsValid = true; // Reset the form validity state on new input
            invalidFieldId = ''; // Reset the invalid field tracking

            validateBudget('budget_it_operating', parseFloat($("#budget_it_operating").val().replace(/,/g, "")) || 0);
            validateBudget('budget_it_investment', parseFloat($("#budget_it_investment").val().replace(/,/g, "")) || 0);
            validateBudget('budget_gov_utility', parseFloat($("#budget_gov_utility").val().replace(/,/g, "")) || 0);
        });


        // Form submission handler

        $('#formId').on('submit', function(e) {
            e.preventDefault();

            // Validate each budget field before form submission
            var isValid = true;
            var errorMessage = "";

            $('#task_budget_it_investment, #task_budget_gov_utility, #task_budget_it_operating').each(function() {
                var current = parseFloat($(this).val().replace(/,/g , "")) || 0;
                var fieldId = $(this).attr('id');
                var budgetType = fieldId.replace('task_budget_', ''); // e.g., 'it_operating'
                var min = minValues[budgetType];
                if (current > min) {
                    // Add error class and set the flag
                    $(this).addClass('is-invalid');
                    isValid = false;
                    errorMessage = "One or more fields have values less than the minimum required.";
                } else {
                    // Remove error class
                    $(this).removeClass('is-invalid');
                }
            });

            if (isValid) {
                // If all validations pass, submit the form
                this.submit();
            } else {
                // Otherwise, show an error message
                Swal.fire(errorMessage);
            }
        });

        // Your other code for handling the input events
    });
</script> --}}

        <script>
            const taskTypeRadios = document.querySelectorAll('input[name="task_type"]');
            const taskContractContainer = document.getElementById('task-contract-container');

            taskTypeRadios.forEach(radio => {
                radio.addEventListener('change', () => {
                    if (radio.value === '2') {
                        taskContractContainer.style.display = 'none';
                    } else {
                        taskContractContainer.style.display = 'block';
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
{{--         <script>
            $(document).ready(function() {
                $("#task_budget_it_investment, #task_budget_gov_utility, #task_budget_it_operating").on("input",
                    function() {
                        var max = 0;
                        var fieldId = $(this).attr('id');

                        if (fieldId === "task_budget_it_investment") {
                            max = parseFloat(
                                {{ $request->budget_it_investment - $sum_task_budget_it_investment }});
                        } else if (fieldId === "task_budget_gov_utility") {
                            max = parseFloat({{ $request->budget_gov_utility - $sum_task_budget_gov_utility }});
                        } else if (fieldId === "task_budget_it_operating") {
                            max = parseFloat({{ $request->budget_it_operating - $sum_task_budget_it_operating }});
                        }

                        var current = parseFloat($(this).val().replace(/,/g, ""));
                        if (current > max) {
                            Swal.fire("จำนวนเงินที่ใส่ต้องไม่เกิน " +max.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + " บาท");
                            $(this).val(max.toFixed(2));
                        }
                    });
            });
        </script>
 --}}



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
//วันที่สิ้นสุด * ไม่เกินวันที่สิ้นสุดโครงการ
  //  $("#project_start_date").datepicker("setEndDate", fiscalYearEndDate);

    // Set the start and end dates for the project_end_date datepicker
   // $("#project_end_date").datepicker("setStartDate", fiscalYearStartDate);
  // $("#task_end_date").datepicker("setStartDate", fiscalYearStartDate);
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


    </x-slot:javascript>
</x-app-layout>
