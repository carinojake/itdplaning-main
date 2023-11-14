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
                        <x-card title="{{ __('แก้ไขกิจกรรม11111') }} {{ $taskcon->taskcon_name }}">
                            <form method="POST"
                                action="{{ route('contract.task.update', ['contract' => $contract->Hashid, 'taskcon' => $taskcon->hashid]) }}"
                                class="row needs-validation"
                                novalidate>
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

                                        <input readonly class="form-control" id="taskcon_start_date" name="taskcon_start_date"
                                        value="{{ \Helper::date4(date('Y-m-d H:i:s', ($taskcon->taskcon_start_date))) }}">
                                </div>


                                    <div class="col-md-6">
                                        <label for="task_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }}</label>
                                     {{--    <span class="text-danger"></span> --}}
                                     <input readonly class="form-control" id="taskcon_end_date" name="taskcon_end_date"
                                     value="{{ \Helper::date4(date('Y-m-d H:i:s', ($taskcon->taskcon_end_date))) }}">
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








                                        <div class="row mt-3">
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
                                        >
                                        </div>



                                        <div class="col-md-4 mt-3">
                                            <label for="taskcon_pp" class="form-label">{{ __('PP ใบเบิก') }}</label>
                                            <input class="form-control" id="taskcon_pp" name="taskcon_pp" value="{{ $taskcon->taskcon_pp }}">

                                            <div class="invalid-feedback">
                                                {{ __('ใบเบิกจ่าย') }}
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label for="taskcon_pay" class="form-label">{{ __('เบิกจ่าย (บาท)') }}</label>
                                            <input type="text" placeholder="0.00" step="0.01"
                                             data-inputmask="'alias': 'decimal', 'groupSeparator': ','" class="form-control numeral-mask"
                                             id="taskcon_pay" name="taskcon_pay" min="0" value="{{ $taskcon->taskcon_pay }}">
                                            <div class="invalid-feedback">
                                                {{ __('เบิกจ่าย (บาท)') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    <button type="submit" class="btn btn-primary">Save Changes</button>
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

    <script>
        $(document).ready(function() {
            $("#taskcon_pay").on("input", function() {
                var max = 0;  // Initialize max to 0
                var fieldId = $(this).attr('id');
                var costFields = ['taskcon_cost_it_operating', 'taskcon_cost_it_investment', 'taskcon_cost_gov_utility'];

                // Check if the fieldId is "task_pay"
                if (fieldId === "taskcon_pay") {
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

        $("#taskcon_start_date,#taskcon_end_date, #taskcon_pay_date")
            .datepicker({
                dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            language:"th-th",


            });
    });
</script>









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
    </script>



    <script>
        $(document).ready(function(){
       $(":input").inputmask();
       });
       </script>>
    </x-slot:javascript>
</x-app-layout>
