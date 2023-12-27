<x-app-layout>
    <x-slot:content>
        <div class="container-fluid">

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
                        <x-card title="{{ __('แก้ไขงวด') }}">
                            <form id="formId" method="POST"
                                action="{{ route('contract.updatepay', $contract->hashid) }}" class="row needs-validation"
                                novalidate>
                                @csrf
                                {{ method_field('PUT') }}

                                <div class="container mt-3">
                                    <div class="row ">
                                        <!-- ปีงบประมาณ -->
                                        <h5 class="card-title">{{ __('งบประมาณ') }} </h5>
                                        <p class="card-text">
                                            {{ \Helper::project_select($contract->contract_budget_type) }}</p>
                                        <div class="accordion accordion-flush  " id="accordionFlushExample">
                                            <div class="callout callout-info accordion-item">
                                                <h2 class="accordion-header " id="flush-headingOne">
                                                    <button class="accordion-button collapsed bg-primary text-white" type="button"
                                                        data-coreui-toggle="collapse"
                                                        data-coreui-target="#flush-collapseOne" aria-expanded="false"
                                                        aria-controls="flush-collapseOne">
                                                        ข้อมูลการจัดซื้อจัดจ้าง (เลขที่สัญญา,MM,PR)
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseOne" class="accordion-collapse "
                                                    aria-labelledby="flush-headingOne"
                                                    data-coreui-parent="#accordionFlushExample">
                                                    <div class="accordion-body ">
                                                        <div class="row  callout callout-primary mb-3">
                                                            <div class="card mb-3">
                                                                <table class="table h6">
                                                                    <tr>
                                                                        <th>2.1 เลขที่ MM</th>
                                                                        <th>2.2 เลขที่ PR</th>
                                                                        <th>2.3 เลขที่ PA</th>
                                                                        <th>2.4 เลขที่ CN</th>
                                                                        <th>2.5 จำนวนคงเหลือหลังเงิน PA</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>{{ $contract->contract_mm }}</td>
                                                                        <td>{{ $contract->contract_pr }}</td>
                                                                        <td>{{ $contract->contract_pa }}</td>


                                                                        <td>{{ $contract->contract_cn }}</td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>2.1 จำนวนเงิน MM</th>
                                                                        <th>2.2 จำนวนเงิน PR</th>
                                                                        <th>2.3 จำนวนเงิน PA</th>
                                                                        <th>2.4 จำนวนเงิน CN</th>
                                                                        <th>2.5 จำนวนคงเหลือหลังเงิน PA</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>{{ $contract->contract_mm_bodget }}</td>
                                                                        <td>{{ number_format($contract->contract_pr_budget, 2) }}
                                                                        </td>
                                                                        <td>{{ number_format($contract->contract_pa_budget, 2) }}
                                                                        </td>


                                                                        <td>{{ number_format($contract->contract_cn_budget, 2) }}
                                                                        </td>

                                                                        <td>{{ number_format($contract->contract_refund_pa_budget, 2) }}
                                                                        </td>

                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="cn_form">
                                                <div class="row  callout callout-primary mb-3">
                                                    <div class="row mt-3">
                                                        <div class="col-md-4">
                                                            <label for="total_pa_budget"
                                                                class="form-label">{{ __('จำนวนเงิน PA') }}</label>
                                                            <span class="text-danger"></span>
                                                            <input type="text" placeholder="0.00" step="0.01"
                                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                                class="form-control numeral-mask" id="total_pa_budget"
                                                                name="total_pa_budget" min="0"
                                                                value="{{ number_format($contract->contract_pa_budget, 2) }}"
                                                                readonly>
                                                        </div>
                                                       {{--  <div class="col-md-4">
                                                            <label for="expenses_delsum"
                                                                class="form-label">{{ __('เงินงวดทั้งหมด') }}</label>
                                                            <span class="text-danger"></span>

                                                            <input type="text" class="form-control installment-amount"
                                                                id="installment" name="installment"


                                                                readonly>
                                                            <div class="invalid-feedback">
                                                                {{ __('เงินงวดทั้งหมด รวมกัน ต้อง = 0 ') }}
                                                            </div>
                                                        </div> --}}

                                                        <div class="col-md-4">
                                                            <label for="total_installments"
                                                                class="form-label">{{ __('ใช้ไป เงินทั้งหมด') }}</label>
                                                            <span class="text-danger"></span>
                                                            <input type="text" class="form-control" id="total_installments"
                                                            value="{{ number_format($contract->contract_pa_budget, 2) }}"
                                                            readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- งวด -->
                                            <div class="mt-3">
                                                @foreach ($taskcons as $index => $taskcon)
                                                    <div class="row mb-3">
                                                        <div class="d-none" id="taskcon_id">
                                                            <input name="tasks[{{ $index }}][id]"
                                                                value="{{ $taskcon->taskcon_id }}">
                                                        </div>


                                                        <div class="col-md-2">
                                                            <label class="form-label">ชื่องวด</label>
                                                            <input class="form-control" type="text"
                                                                name="tasks[{{ $index }}][task_name]"
                                                                value="{{ $taskcon->taskcon_name }}">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">เงินงวด</label>
                                                            <input type="text" placeholder="0.00" step="0.01"     min="0"
                                                            class="form-control numeral-mask installment-amount"
                                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"

                                       @if ($contract->contract_budget_type == 1) name="tasks[{{ $index }}][taskcon_cost_it_operating]"
                                                value="{{ number_format($taskcon->taskcon_cost_it_operating, 2) }}"

                                                @elseif($contract->contract_budget_type == 2)
                                                name="tasks[{{ $index }}][taskcon_cost_it_investment]"
                                                value="{{ number_format($taskcon->taskcon_cost_it_investment, 2) }}"

                                                @elseif($contract->contract_budget_type == 3)
                                                name="tasks[{{ $index }}][taskcon_cost_gov_utility]"
                                                value="{{ number_format($taskcon->taskcon_cost_gov_utility, 2) }}"

                                                @endif>


                                                <div class="invalid-feedback">ระบุเงินงวด</div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-label">เบิกเงินงวด</label>
                                                            <input type="text" placeholder="0.00" step="0.01"
                                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                                class="form-control numeral-mask" min="0"
                                                                name="tasks[{{ $index }}][taskpay]"
                                                                value="{{ $taskcon->taskcon_pay }}">
                                                            <div class="invalid-feedback">ระบุเงินงวด</div>
                                                        </div>



                                                        <div class="col-md-2">
                                                            <label class="form-label">วันที่เริ่มต้นงวด</label>
                                                            <input type="text" class="form-control datepickerop"
                                                                name="tasks[{{ $index }}][start_date]"
                                                                value="{{ \Helper::date4(date('Y-m-d H:i:s', $taskcon->taskcon_start_date)) }}">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">วันที่สิ้นสุดงวด</label>
                                                            <input type="text" class="form-control datepickeropend"
                                                                name="tasks[{{ $index }}][end_date]"
                                                                value="{{ \Helper::date4(date('Y-m-d H:i:s', $taskcon->taskcon_end_date)) }}">
                                                        </div>
                                                    </div>


                                                @endforeach
                                            </div>



                                            <div class="row">
                                                <div class="col-12 text-center mt-4">
                                                    <x-button class="btn-success"
                                                        type="submit">{{ __('coreuiforms.save') }}</x-button>
                                                    <x-button link="{{ route('contract.index') }}"
                                                        class="btn-light text-black">{{ __('coreuiforms.return') }}</x-button>
                                                </div>
                                            </div>
                                        </div>
                            </form>
                        </x-card>
                    </div>
                </div>


            </div>
        </div>
    </x-slot:content>
    <x-slot:css>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
            rel="stylesheet" />

    </x-slot:css>
    <x-slot:javascript>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js">
        </script>
        {{--  <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script> --}}
        <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
        <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>


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
                $(":input").inputmask();
            });
        </script>

 {{--    <script>
        $(document).ready(function() {
            // Function to calculate the sum of the installments.
            function calculateInstallmentsTotal() {
                var total = 0;
                // Add up all the values of the inputs with class 'installment-amount'.
                $('.installment-amount').each(function() {
                    var value = parseFloat($(this).val().replace(/,/g, '')) || 0;
                    total += value;
                });
                return total;
            }

            // Whenever an 'installment-amount' input value changes, update the 'total-amount-used'.
            $(document).on('input', '.installment-amount', function() {
                var total = calculateInstallmentsTotal();
                $('#total-amount-used').val(total.toFixed(2));
            });
        });
        </script> --}}


     {{--    <script>
            $(document).ready(function() {
                // Function to calculate and update the total of installments
                function updateTotalInstallments() {
                    var totalInstallments = 0;
                    $('.installment-amount').each(function() {
                        var installmentValue = parseFloat($(this).val().replace(/,/g, '')) || 0;
                        totalInstallments += installmentValue;
                    });
                    $('#total_installments').val(totalInstallments.toFixed(2));
                }

                // Function to update the expenses and check against the budget
                function updateExpenses() {
                    var contract_pa_budget = parseFloat($("#contract_pa_budget").val().replace(/,/g, ""));
                    var sum = 0;

                    $('.expenses').each(function() {
                        var value = parseFloat($(this).val().replace(/,/g, "")) || 0;
                        if (value < 0) {
                            $(this).val('');
                            value = 0;
                        }
                        sum += value;
                    });

                    if (sum > contract_pa_budget) {
                        // If the sum of expenses exceeds the budget, show an error and reset the last input
                        $('.expenses').last().val('');
                        alert("จำนวนเงินที่ใส่ต้องไม่เกิน " + contract_pa_budget.toFixed(2) + " บาท");
                    }

                    $('#expenses_sum').val(sum.toFixed(2));
                }

                // Event listener for changes in the expenses inputs
                $(document).on('input', '.expenses', function() {
                    updateExpenses();
                });

                // Event listener for changes in the installment inputs
                $(document).on('input', '.installment-amount', function() {
                    updateTotalInstallments();
                });

                // Initial calculation on page load
                updateExpenses();
                updateTotalInstallments();
            });
            </script> --}}





    </x-slot:javascript>
</x-app-layout>
