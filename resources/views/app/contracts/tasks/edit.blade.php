<x-app-layout>
    <x-slot:content>

        <div class="container-fluid">

            {{ Breadcrumbs::render('contract.task.edit', $contract, $taskcon) }}
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
                        <x-card title="{{ __('แก้ไขกิจกรรม') }} {{ $taskcon->taskcon_name }}">
                            <form method="POST"
                                action="{{ route('contract.task.update', ['contract' => $contract->Hashid, 'taskcon' => $taskcon->hashid]) }}"
                                class="row needs-validation"
                                novalidate enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <div class="col-md-12 ">
                                        <label for="taskcon_contract" class="form-label">{{ __('สัญญา') }}</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" id="taskcon_contract"
                                            name="taskcon_contract"
                                            value="[{{ $contract->contract_number }}]{{ $contract->contract_name }}"
                                            readonly>
                                    </div>


                                    <div class="col-md-12 mt-3 ">
                                        <label for="taskcon_name">ชื่อ กิจกรรม</label>
                                        <input readonly type="text" class="form-control" id="taskcon_name" name="taskcon_name"
                                            value="{{ $taskcon->taskcon_name }}">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="taskcon_description">กิจกรรม</label>
                                        <textarea readonly class="form-control" id="taskcon_description" name="taskcon_description">{{ $taskcon->taskcon_description }}</textarea>
                                    </div>
                                </div>


                            {{--     <div class="row">
                                    <div class="col-md-6 mt-3">
                                        <label for="taskcon_start_date"
                                            class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span
                                            class="text-danger">*</span>

                                        <div data-coreui-toggle="date-picker" id="taskcon_start_date"
                                            data-coreui-format="dd/MM/yyyy" data-coreui-locale="th-TH"
                                            data-coreui-date="{{ date('m/d/Y', $taskcon->taskcon_start_date) }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label for="taskcon_end_date"
                                            class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span
                                            class="text-danger">*</span>

                                        <div data-coreui-toggle="date-picker" id="taskcon_end_date"
                                            data-coreui-format="dd/MM/yyyy" data-coreui-locale="th-TH"
                                            data-coreui-date="{{ date('m/d/Y', $taskcon->taskcon_end_date) }}">
                                        </div>
                                    </div>
                                </div>
 --}}


                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="task_start_date" class="form-label">{{ __('วันที่เริ่มต้น') }}</label>
                                        <div class="col-9">  {{ $taskcon->taskcon_start_date ? \Helper::date4(date('Y-m-d H:i:s', ($taskcon->taskcon_end_date))) : '' }}
                                        </div>
                                       {{--  <input readonly class="form-control" id="taskcon_start_date" name="taskcon_start_date"
                                        value="{{ \Helper::date4(date('Y-m-d H:i:s', ($taskcon->taskcon_start_date))) }}"> --}}
                                </div>


                                    <div class="col-md-6">
                                        <label for="task_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }}</label>
                                     {{--    <span class="text-danger"></span> --}}
                                     <div class="col-9">  {{ $taskcon->taskcon_end_date ? \Helper::date4(date('Y-m-d H:i:s', ($taskcon->taskcon_end_date))): '' }}
                                    </div>
                                {{--      <input readonly class="form-control" id="taskcon_end_date" name="taskcon_end_date"
                                     value="{{ \Helper::date4(date('Y-m-d H:i:s', ($taskcon->taskcon_end_date))) }}"> --}}
                             </div>
                                </div>



                                        <div class="row mt-3">
                                            <h4>งบประมาณ</h4>

                                            <div class="row mt-3">
                                                <div class="col-6">
                                                    <strong>เงินงบประมาณ (งวด/ต่อครั้ง)</strong>
                                                    @if($taskcon->taskcon_budget_it_operating >1)
                                                    <div class="col-md-12 mt-3">
                                                        <label for="taskcon_budget_it_operating" class="form-label">{{ __('งบกลาง ICT') }}</label>
                                                        <input type="text" placeholder="0.00" step="0.01" data-inputmask="'alias': 'decimal', 'groupSeparator': ','" class="form-control numeral-mask" id="taskcon_budget_it_operating" name="taskcon_budget_it_operating" min="0" value="{{ $taskcon->taskcon_budget_it_operating }}"

                                                        readonly>
                                                        <div class="invalid-feedback">
                                                            {{ __('ระบุงบกลาง ICT') }}
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if($taskcon->taskcon_budget_it_investment >1)
                                                    <div class="col-md-12">
                                                        <label for="taskcon_budget_it_investment" class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                        <input readonly type="text" placeholder="0.00" step="0.01" data-inputmask="'alias': 'decimal', 'groupSeparator': ','" class="form-control numeral-mask" id="taskcon_budget_it_investment" name="taskcon_budget_it_investment" min="0" value="{{ $taskcon->taskcon_budget_it_investment }}">
                                                        <div class="invalid-feedback">
                                                            {{ __('ระบุงบดำเนินงาน') }}
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if($taskcon->taskcon_budget_gov_utility >1)
                                                    <div class="col-md-12">
                                                        <label for="taskcon_budget_gov_utility" class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                        <input readonly type="text" placeholder="0.00" step="0.01" data-inputmask="'alias': 'decimal', 'groupSeparator': ','" class="form-control numeral-mask" id="taskcon_budget_gov_utility" name="taskcon_budget_gov_utility" min="0" value="{{ $taskcon->taskcon_budget_gov_utility }}">
                                                        <div class="invalid-feedback">
                                                            {{ __('ระบุงบค่าสาธารณูปโภค') }}
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>

                                                <div class="col-6">
                                                    <strong>ค่าใช้จ่าย  (งวด/ต่อครั้ง)</strong>
                                                    @if($taskcon->taskcon_cost_it_operating >1)
                                                        <div class="col-md-12 mt-3">
                                                            <label for="taskcon_cost_it_operating" class="form-label">{{ __('ค่าใช้จ่ายงบกลาง ICT') }}</label>
                                                            <input readonly type="text" placeholder="0.00" step="0.01" data-inputmask="'alias': 'decimal', 'groupSeparator': ','" class="form-control numeral-mask" id="taskcon_cost_it_operating" name="taskcon_cost_it_operating" min="0" value="{{ $taskcon->taskcon_cost_it_operating }}">
                                                            <div class="invalid-feedback">
                                                                {{ __('ค่าใช้จ่ายงบกลาง ICT') }}
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if($taskcon->taskcon_cost_it_investment >1)
                                                        <div class="col-md-12">
                                                            <label for="taskcon_cost_it_investment" class="form-label">{{ __('ค่าใช้จ่ายงบดำเนินงาน') }}</label>
                                                            <input readonly type="text" placeholder="0.00" step="0.01" data-inputmask="'alias': 'decimal', 'groupSeparator': ','" class="form-control numeral-mask" id="taskcon_cost_it_investment" name="taskcon_cost_it_investment" min="0" value="{{ $taskcon->taskcon_cost_it_investment }}">
                                                            <div class="invalid-feedback">
                                                                {{ __('ค่าใช้จ่ายงบดำเนินงาน') }}
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if($taskcon->taskcon_cost_gov_utility >1)
                                                        <div class="col-md-12">
                                                            <label for="taskcon_cost_gov_utility" class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                            <input readonly type="text" placeholder="0.00" step="0.01" data-inputmask="'alias': 'decimal', 'groupSeparator': ','" class="form-control numeral-mask" id="taskcon_cost_gov_utility" name="taskcon_cost_gov_utility" min="0" value="{{ $taskcon->taskcon_cost_gov_utility }}">
                                                            <div class="invalid-feedback">
                                                                {{ __('ระบุงบค่าสาธารณูปโภค') }}
                                                            </div>
                                                            @endif</div>

                                                </div>








                                     <div  id="taskcon_pp_toto" class="row mt-3">
                                        <h4>เบิกจ่าย</h4>


                                        <div class="col-md-12">
                                            <label for="taskcon_projectplan" class="form-label">{{ __('บันทึกข้อความ') }}</label>
                                   {{--          <input type="textarea" class="form-control" id="taskcon_projectplan" name="taskcon_projectplan" value="{{ $taskcon->taskcon_projectplan }}" > --}}
                                            <textarea class="form-control" id="taskcon_projectplan" name="taskcon_projectplan" style="height: 100px">{{ $taskcon->taskcon_projectplan }}</textarea>
                                            <div class="invalid-feedback">
                                              {{ __('บันทึกข้อความ') }}
                                            </div>
                                          </div>
                                        <div class="col-md-4 mt-3" >
                                            <label for="taskcon_pay_date" class="form-label">{{ __('วันที่เบิกจ่าย') }}</label>
                                            <input class="form-control" id="taskcon_pay_date" name="taskcon_pay_date"

                                            value="{{ $taskcon->taskcon_pay_date ? \Helper::date4($taskcon->taskcon_pay_date) : '' }}"
                                            {{ $taskcon->task_status == 2 ? 'readonly' : '' }}

                                            >
                                        </div>



                                        <div class="col-md-4 mt-3">
                                            <label for="taskcon_pp" class="form-label">{{ __('PP ใบเบิกจ่าย') }}</label>
                                            <input class="form-control" id="taskcon_pp" name="taskcon_pp" value="{{ $taskcon->taskcon_pp }}"
                                            {{ $taskcon->task_status == 2 ? 'readonly' : '' }}
                                            >

                                            <div class="invalid-feedback">
                                                {{ __('ใบเบิกจ่าย') }}
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label for="taskcon_pay" class="form-label">{{ __('เบิกจ่าย (บาท)') }}</label>
                                            <input type="text" placeholder="0.00" step="0.01"
                                             data-inputmask="'alias': 'decimal', 'groupSeparator': ','" class="form-control numeral-mask"
                                             id="taskcon_pay" name="taskcon_pay" min="0" value="{{ $taskcon->taskcon_pay }}"
                                             {{ $taskcon->task_status == 2 ? 'readonly' : '' }}


                                             >
                                            <div class="invalid-feedback">
                                                {{ __('เบิกจ่าย (บาท)') }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="task_status"
                                            class="form-label">{{ __('task_status') }}</label>
                                        <span class="text-danger"></span>

                                        <input type="text" placeholder="0.00"
                                            step="0.01"
                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                            class="form-control numeral-mask"
                                            id="task_status"
                                            name="task_status"  value="{{ $taskcon->task_status }}" readonly>

                                        {{--  <div class="invalid-feedback">
                                                    {{ __('ค่าสาธารณูปโภค') }}
                                                </div> --}}
                                    </div>

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
                                    @if(count($files_taskcon) > 0)
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                           {{--  <th>Photo</th> --}}
                                            <th>File Name</th>
                                          {{--   <th>File project_id</th>
                                            <th>File task_id</th>
                                            <th>File contract_id</th> --}}
                                            <th>File Size</th>
                                            <th>Date Uploaded</th>
                                            <th>File Location</th>
                                            <th>ลบ</th>
                                        </thead>
                                        <tbody>
                                            @if (count($files_taskcon) > 0)
                                            @foreach ($files_taskcon as $file)
                                                    <tr>
                                                       {{--  <td><img src='storage/{{$file->name}}' name="{{$file->name}}" style="width:90px;height:90px;"></td> --}}
                                                        <td>{{ $file->name }}</td>
                                               {{--          <td>{{ $file->project_id }}</td>
                                                        <td>{{ $file->task_id }}</td>
                                                        <td>{{ $file->contract_id }}</td> --}}


                                                        <td>
                                                            @if($file->size < 1000)
                                                                {{ number_format($file->size,2) }} bytes
                                                            @elseif($file->size >= 1000000)
                                                                {{ number_format($file->size/1000000,2) }} mb
                                                            @else
                                                                {{ number_format($file->size/1000,2) }} kb
                                                            @endif
                                                        </td>
                                                        <td>{{ date('M d, Y h:i A', strtotime($file->created_at)) }}</td>


                                                        <td><a href="{{ asset('storage/uploads/contracts/' . $file->project_id . '/' . $file->task_id . '/' . $file->name) }}">{{ $file->name }}</a></td>

                                                        <td>
                                                            <a href="{{ route('contract.task.filesdel', ['contract' => $contract->hashid, 'taskcon' => $taskcon->hashid]) }}" class="btn btn-danger">
                                                                <i class="glyphicon glyphicon-remove"></i> Remove
                                                            </a>
                                                        </td>


                                                        {{--  <td><a href="{{ $file->location }}">{{ $file->location }}</a></td> --}}



                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="12" class="text-center">No Table Data</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    @endif




                                </div>
                            </div>
                        </div>


                    <button type="submit" class="btn btn-success">Save Changes</button>
                    <x-button link="{{ route('contract.index') }}" class="btn-light text-black">{{ __('coreuiforms.return') }}</x-button>

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

<!-- JavaScript to set fields as read-only based on the task status -->

    <script>
        var costFields = ['taskcon_cost_it_operating', 'taskcon_cost_it_investment', 'taskcon_cost_gov_utility'];
        var budgetFields = ['taskcon_budget_it_operating', 'taskcon_budget_it_investment', 'taskcon_budget_gov_utility'];
        var taskcon_pay = ['taskcon_pay']
        var tackconstatus = ['task_status'];
        console.log(costFields);
        console.log(budgetFields);
        console.log(taskcon_pay);
        console.log(tackconstatus);

        function calculateRefundstatus() {
            var totalRefundsstatus = 1; // Assuming you want to start with a default value of 0

            costFields.forEach(function(costField, index) {
                var pa_value = $("#" + costField).val();
                var pr_value = $("#" + budgetFields[index]).val();
                var pay_value = $("#" + taskcon_pay).val();
                console.log(pa_value);
        console.log(pr_value);
        console.log(taskcon_pay);

                if (pa_value && pr_value && pay_value) {
                    var pa_budget = parseFloat(pa_value.replace(/,/g, "")) || 0;
                    var pr_budget = parseFloat(pr_value.replace(/,/g, "")) || 0;
                    var pay_value = parseFloat(pay_value.replace(/,/g, "")) || 0;
                    // Use '===' for strict comparison if you expect the same type, or '==' if types can differ
                    if (pr_budget - pay_value === 0) {
                        // Assuming you want to set some status when the budgets are equal
                        totalRefundsstatus = 2;
                    } else {
                        // Assuming you want to set a different status when the budgets are not equal
                        totalRefundsstatus = 1;
                    }
                }
            });

            $("#task_status").val(totalRefundsstatus);
        }

        $(document).ready(function() {
            // The 'calculateRefund' function was not defined. Assuming it should be 'calculateRefundstatus'
            taskcon_pay.forEach(function(taskcon_pay) {
                $("#" + taskcon_pay).on("input", calculateRefundstatus);
            });
        });
    </script>



    <script>
        $(document).ready(function() {
            $("#taskcon_pay").on("input", function() {
                var taskcon_pay = $("#taskcon_pay").val();
                var max = 0;  // Initialize max to 0
                var fieldId = $(this).attr('id');
                var costFields = ['taskcon_cost_it_operating', 'taskcon_cost_it_investment', 'taskcon_cost_gov_utility'];

                // Check if the fieldId is "task_pay"
                if (fieldId === "taskcon_pay") {
                    if (taskcon_pay < -0) {

                        $(this).val(0);
                    }

                    // Iterate through the costFields array
                    costFields.forEach(function(field) {
                        // Get the value of each field, remove commas, convert to float, and add to max
                        var fieldValue = $("#" + field).val();
                        if (fieldValue) {  // Check if fieldValue is defined
                            max += parseFloat(fieldValue.replace(/,/g, ""));
                        }
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
    $(function() {
        if (typeof jQuery == 'undefined' || typeof jQuery.ui == 'undefined') {
            alert("jQuery or jQuery UI is not loaded");
            return;
        }

        var d = new Date();
        var toDay = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 543);
        var taskconstartdate = "{{ Helper::Date4(date('Y-m-d H:i:s', $taskcon->taskcon_start_date)) }}";

        console.log(taskconstartdate);
        $("#taskcon_start_date,#taskcon_end_date, #taskcon_pay_date")
            .datepicker({
                dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            language:"th-th",


            });
            $("#taskcon_pay_date").datepicker("setStartDate", taskconstartdate);
            $("#taskcon_start_date").datepicker({});
        $("#taskcon_end_date").datepicker({ });
        $('#taskcon_start_date').change(function() {
                        startDate = $(this).datepicker('getDate');
                        $("#taskcon_end_date").datepicker("setStartDate", startDate);
                        $("#taskcon_pay_date").datepicker("setStartDate", startDate);

                    })

                    $('#taskcon_end_date').change(function() {
                        endDate = $(this).datepicker('getDate');
                        $("#taskcon_start_date").datepicker("option", "maxDate", endDate);
                    })

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


<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        var task_Status = {!! json_encode($taskcon->task_status) !!}; // Ensure this is a number, not a string
        if (task_Status === 2) {
            var formInputs = document.querySelectorAll('#taskcon_pay input, #taskcon_projectplan textarea, #taskcon_pp input, #taskcon_pay_date input');
            formInputs.forEach(function(input) {
                input.setAttribute('readonly', true); // Set to read-only
            });
        }
    });
</script>



{{--
<script>
    $(document).ready(function() {
       $("#taskcon_start_date").datepicker({});
        $("#taskcon_end_date").datepicker({ });
        $('#taskcon_start_date').change(function() {
                        startDate = $(this).datepicker('getDate');
                        $("#taskcon_end_date").datepicker("option", "minDate", startDate);
                        $("#taskcon_pay_date").datepicker("option", "minDate", startDate);

                    })

                    $('#taskcon_end_date').change(function() {
                        endDate = $(this).datepicker('getDate');
                        $("#taskcon_start_date").datepicker("option", "maxDate", endDate);
                    })

    });
    </script> --}}



    <script>
        $(document).ready(function(){
       $(":input").inputmask();
       });
       </script>>
    </x-slot:javascript>
</x-app-layout>
