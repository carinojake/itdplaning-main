<x-app-layout>
  <x-slot:content>
    <div class="container-fluid">

        {{ Breadcrumbs::render('contract.task.create',$contract) }}
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
            <x-card title="{{ __('เพิ่มค่าใช้จ่าย ( ครั้งเดียว/งวด)') }}">
             <form method="POST" action="{{ route('contract.task.store', $contract) }}" class="row g-3">

                @csrf


                <div class="row  callout callout-primary mb-3">


                    <div class="col-md-3">
                        <label for="contract_fiscal_year"
                            class="form-label">{{ __('ปีงบประมาณ') }}</label>
                       {{ $contractconsst['contract_fiscal_year'] }}
                    </div>
                    <div class="col-md-3">
                        <label for="contract_name"
                            class="form-label">{{ __('สัญญา') }}</label>
                       {{ $contractconsst['contract_name'] }}
                    </div>

                    <div class="col-md-3">
                        <label for="contract_budget_type"
                            class="form-label">{{ __('งบประมาณ') }}</label>
                       {{ \Helper::project_select($contractconsst['contract_budget_type']) }}

                        </div>

                    <div class="col-md-3">
                        <label for="contract_budget"
                            class="form-label">{{ __('งบประมาณ') }}</label>
                       {{  number_format($contractconsst['contract_pa_budget']) }}
                    </div>




                </div>



                <div class="col-md-12">
                  <label for="taskcon_name" class="form-label">{{ __('ชื่อกิจกรรม') }}</label> <span class="text-danger">*</span>
                  <input type="text" class="form-control" id="taskcon_name" name="taskcon_name" required autofocus>
                  <div class="invalid-feedback">
                    {{ __('ชื่อกิจกรรมซ้ำ') }}
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="taskcon_description" class="form-label">{{ __('รายละเอียดกิจกรรม') }}</label>
                  <textarea class="form-control" name="taskcon_description" id="taskcon_description" rows="10"></textarea>
                  <div class="invalid-feedback">
                    {{ __('รายละเอียดกิจกรรม') }}
                  </div>
                </div>


                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="taskcon_start_date"
                            class="form-label">{{ __('วันที่เริ่มต้น ประก้น') }}</label>
                        <span class="text-danger"></span>
                        <input type="text" class="form-control"
                            id="taskcon_start_date"
                            name="taskcon_start_date">
                    </div>
                    <div class="col-md-6">
                        <label for="task_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }}</label>
                        <span class="text-danger"></span>
                        <input class="form-control" id="taskcon_end_date" name="taskcon_end_date" >
                    </div>
                </div>



                <div class="row  mt-3" >
                  <h4>งบประมาณ</h4>

                  <div class="row mt-3 ">
                    <div   class="col-6 d-none">
                      <strong>เงินงบประมาณ (งวด/ต่อครั้ง)</strong>


                      <div class="col-md-12 mt-3">
                        <label for="taskcon_budget_it_operating" class="form-label">{{ __('งบกลาง ICT') }}</label>
                        <input type="text" placeholder="0.00" step="0.01"
                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                         class="form-control numeral-mask"

                        class="form-control"
                        id="taskcon_budget_it_operating" name="taskcon_budget_it_operating" min="0">
                        <div class="invalid-feedback">
                          {{ __('ระบุงบกลาง ICT') }}
                        </div>
                      </div>
                      <div class="col-md-12">
                        <label for="taskcon_budget_it_investment" class="form-label">{{ __('งบดำเนินงาน') }}</label>
                        <input type="text" placeholder="0.00" step="0.01"
                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                         class="form-control numeral-mask"
                        class="form-control"
                         id="taskcon_budget_it_investment" name="taskcon_budget_it_investment" min="0">
                        <div class="invalid-feedback">
                          {{ __('งบดำเนินงาน)') }}
                        </div>
                      </div>
                      <div class="col-md-12">
                        <label for="taskcon_budget_gov_utility" class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                        <input type="text" placeholder="0.00" step="0.01"
                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                         class="form-control numeral-mask"


                        class="form-control"
                        id="taskcon_budget_gov_utility" name="taskcon_budget_gov_utility" min="0">
                        <div class="invalid-feedback">
                          {{ __('ระบุค่าสาธารณูปโภค') }}
                        </div>
                      </div>
                    </div>

                    <div class="col-6">
                      <strong>ค่าใช้จ่าย  (งวด/ต่อครั้ง)</strong>

                      @if($contractconsst['contract_budget_type'] ==1)
                      <div class="col-md-12 mt-3">
                        <label for="taskcon_cost_it_operating" class="form-label">{{ __('งบกลาง ICT') }}</label>
                        <input type="text"

                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                         class="form-control numeral-mask"  placeholder="0.00" step="0.01"

                        class="form-control" id="taskcon_cost_it_operating"
                        name="taskcon_cost_it_operating" min="0">
                        <div class="invalid-feedback">
                          {{ __('งบกลาง ICT') }}
                        </div>
                      </div>
                        @endif
                        @if($contractconsst['contract_budget_type'] ==2)
                      <div class="col-md-12">
                        <label for="taskcon_cost_it_investment" class="form-label">{{ __('งบดำเนินงาน') }}</label>
                        <input type="text" placeholder="0.00" step="0.01"
                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                         class="form-control numeral-mask"

                        class="form-control" id="taskcon_cost_it_investment"
                         name="taskcon_cost_it_investment" min="0">
                        <div class="invalid-feedback">
                          {{ __('งบดำเนินงาน)') }}
                        </div>
                      </div>
                        @endif
                        @if($contractconsst['contract_budget_type'] ==3)
                     <div class="col-md-12">
                      <label for="taskcon_cost_gov_utility" class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                      <input type="text"  placeholder="0.00" step="0.01"
                      class="form-control" id="taskcon_cost_gov_utility"
                      data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                      class="form-control numeral-mask"

                      name="taskcon_cost_gov_utility" min="0">
                      <div class="invalid-feedback">
                        {{ __('ระบุค่าสาธารณูปโภค') }}
                      </div>
                    </div>
                        @endif

                    </div>
{{--
                         <div class="row mt-3">

                                <h4>เบิกจ่าย</h4>
                                <div class="col-md-6">


                                      <label for="taskcon_pay_date" class="form-label">{{ __('วันที่เบิกจ่าย') }}</label>
                                      <span class="text-danger"></span>
                                      <input class="form-control" id="taskcon_pay_date" name="taskcon_pay_date" >

                                    </div>

                                    <div class="col-md-6">
                                      <label for="taskcon_pay" class="form-label">{{ __('เบิกจ่าย') }}</label>
                                      <input type="text" placeholder="0.00" step="0.01"

                                      class="form-control" id="taskcon_pay"
                                      data-inputmask="'alias': 'decimal', 'groupSeparator': ','"

                                      name="taskcon_pay" min="0" >
                                      <div class="invalid-feedback">
                                        {{ __('เบิกจ่าย') }}
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>

            </div>

                <x-button class="btn-success" type="submit">{{ __('coreuiforms.save') }}</x-button>
                <x-button link="{{ route('contract.show', $contract) }}" class="text-black btn-light">{{ __('coreuiforms.return') }}</x-button>

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
    // Example starter JavaScript for disabling form submissions if there are invalid fields
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
        } else {
            // เพิ่มเงื่อนไขการตรวจสอบความถูกต้องของข้อมูลของคุณที่นี่
            // เช่น ตรวจสอบชื่อโครงการซ้ำ
            if (someValidationCondition) {
                event.preventDefault() // ป้องกันการส่งข้อมูลเซฟ
            }
        }

        form.classList.add('was-validated')
    }, false)
})
})()

</script>


<script>
    $(function() {
        $("#taskcon_start_date, #taskcon_end_date").datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            language: "th-th",
        });

        $('#contract_fiscal_year').on('change', function() {
            // Get the selected fiscal year from the datepicker
            var fiscalYearDate = $(this).datepicker('getDate');
            var fiscalYear = fiscalYearDate ? fiscalYearDate.getFullYear() : new Date().getFullYear();
            // Calculate the start and end dates of the fiscal year
            var fiscalYearStartDate = new Date(fiscalYear - 1, 9, 1); // 1st October of the previous year
            var fiscalYearEndDate = new Date(fiscalYear, 8, 30); // 30th September of the fiscal year
            var fiscalYearEnd = '30/09/' + fiscalYear;
            // Set the date range for the project datepickers
            $("#taskcon_start_date").datepicker("setStartDate", fiscalYearStartDate);
      //$("#project_end_date").datepicker("setEndDate", fiscalYearEnd);
        });

        $('#taskcon_start_date').on('changeDate', function() {
            var startDate = $(this).datepicker('getDate');
          //  $("#project_end_date").datepicker("setStartDate", startDate);
        });

        $('#taskcon_end_date').on('changeDate', function() {
            var endDate = $(this).datepicker('getDate');
            $("#taskcon_start_date").datepicker("setEndDate", fiscalYearEnd);
        });
    });
</script>







<script>
    $(document).ready(function(){
   $(":input").inputmask();
   });
   </script>



<script>
    $(document).ready(function() {
$("#taskcon_budget_it_investment, #taskcon_budget_gov_utility, #taskcon_budget_it_operating,#taskcon_cost_it_operating,#taskcon_cost_it_investment,#taskcon_cost_gov_utility").on("input", function() {

 var fieldId = $(this).attr('id');
var budgetItOperating = $("#taskcon_budget_it_operating").val();
 var budgetItInvestment = $("#taskcon_budget_it_investment").val();
 var budgetGovUtility = $("#taskcon_budget_gov_utility").val();
 var costItOperating = $("#taskcon_cost_it_operating").val();
    var costItInvestment = $("#taskcon_cost_it_investment").val();
    var costGovUtility = $("#taskcon_cost_gov_utility").val();

     if (budgetItInvestment === "0" || budgetItInvestment === '' || parseFloat(budgetItInvestment) < -0) {
         $("#taskcon_budget_it_investment").val('');
     }



     if (budgetGovUtility === "0" || budgetGovUtility === '' || parseFloat(budgetGovUtility) < -0) {
         $("#taskcon_budget_gov_utility").val('');
     }

         if (budgetItOperating === "0" || budgetItOperating === ''|| parseFloat(budgetItOperating) < -0 ) {
             $("#taskcon_budget_it_operating").val('');
         }

            if (costItOperating === "0" || costItOperating === ''|| parseFloat(costItOperating) < -0 ) {
                $("#taskcon_cost_it_operating").val('');
            }

            if (costItInvestment === "0" || costItInvestment === ''|| parseFloat(costItInvestment) < -0 ) {
                $("#taskcon_cost_it_investment").val('');
            }

            if (costGovUtility === "0" || costGovUtility === ''|| parseFloat(costGovUtility) < -0 ) {
                $("#taskcon_cost_gov_utility").val('');
            }
});
});
 </script>















  </x-slot:javascript>
</x-app-layout>


