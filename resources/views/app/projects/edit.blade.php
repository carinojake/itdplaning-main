<x-app-layout>
    <x-slot:content>
        <div class="container-fluid">
            {{ Breadcrumbs::render('project.edit', $project) }}
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
                        <x-card
                            title="{{ __('แก้ไข') }} {{ Helper::projectsType($project->project_type) }} {{ $project->project_name }}">




                            <form method="POST" action="{{ route('project.update', $project->hashid) }}"
                                class="row g-3"  class="row needs-validation"
                                novalidate >
                                @csrf
                                {{ method_field('PUT') }}

                        <div class="row mt-3">
                                <div class="col-md-3">
                                    <label for="project_fiscal_year" class="form-label">{{ __('ปีงบประมาณ') }}</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" id="project_fiscal_year"
                                        name="project_fiscal_year" value="{{ $project->project_fiscal_year }}"
                                        readonly>
                                    <div class="invalid-feedback">
                                        {{ __('ปีงบประมาณ') }}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label for="project_type"
                                        class="form-label">{{ __('ประเภทงาน/โครงการ') }}</label> <span
                                        class="text-danger">*</span>
                                    <div>
                                        <input class="form-check-input" type="radio" name="project_type"
                                            id="project_type1" value="1" @checked($project->project_type == 1)>
                                        <label class="form-check-label" for="project_type1"
                                            @checked($project->project_type == 1)>
                                            งานประจำ
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="project_type"
                                            id="project_type2" value="2" @checked($project->project_type == 2)>
                                        <label class="form-check-label" for="project_type2"
                                            @checked($project->project_type == 2)>
                                            โครงการ
                                        </label>
                                    </div>
                                    <div class="invalid-feedback">
                                        {{ __('สถานะงาน/โครงการ') }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="reguiar_id" class="form-label">{{ __('ลำดับ.ชื่องาน/โครงการ *') }}</label>
                                    <span class="text-danger"></span>
                                    <input type="text" class="form-control" id="reguiar_id" name="reguiar_id"
                                        value="{{ $project->reguiar_id }}">
                                    <div class="invalid-feedback">
                                        {{ __('ลำดับ.ชื่องาน/โครงการ * ') }}
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <label for="project_status"
                                        class="form-label">{{ __('สถานะงาน/โครงการ') }}</label> <span
                                        class="text-danger">*</span>
                                    <div >
                                        <input class="form-check-input" type="radio" name="project_status"
                                            id="project_status1" value="1" @checked($project->project_status == 1)>
                                        <label class="form-check-label" for="project_status1"
                                            @checked($project->project_status == 1)>
                                            อยู่ในระหว่างดำเนินการ
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="project_status"
                                            id="project_status2" value="2" @checked($project->project_status == 2)>
                                        <label class="form-check-label" for="project_status2"
                                            @checked($project->project_status == 1)>
                                            ดำเนินการแล้วเสร็จ
                                        </label>
                                    </div>
                                <div class="invalid-feedback">
                                    {{ __('สถานะงาน/โครงการ') }}
                                </div>
                            </div>
                        </div>
{{--
                        <div class="col-md-6">
                            <label for="project_start_date"
                                class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span
                                class="text-danger">*</span>

                            <div data-coreui-toggle="date-picker" id="project_start_date"
                                data-coreui-format="dd/MM/yyyy" data-coreui-locale="th-TH"
                                data-coreui-date="{{ date('m/d/Y', $project->project_start_date) }} "></div>
                        </div>
                        <div class="col-md-6">
                            <label for="project_end_date"
                                class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span
                                class="text-danger">*</span>

                            <div data-coreui-toggle="date-picker" id="project_end_date"
                                data-coreui-format="dd/MM/yyyy" data-coreui-locale="th-TH"
                                data-coreui-date="{{ date('m/d/Y', $project->project_end_date) }}"></div>
                        </div>
 --}}

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="project_start_date"
                                class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span
                                class="text-danger">*</span>
                                <input type="text" class="form-control" id="project_start_date" name="project_start_date"
                                    value="{{ \Helper::date4(date('Y-m-d H:i:s', $project->project_start_date)) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="project_end_date"
                                                class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span
                                                class="text-danger">*</span>
                                <input type="text" class="form-control" id="project_end_date" name="project_end_date"
                                    value="{{ \Helper::date4(date('Y-m-d H:i:s', $project->project_end_date)) }}">
                            </div>
                        </div>



                                <div class="col-md-12">
                                    <label for="project_name" class="form-label">{{ __('ชื่องาน/โครงการ') }}</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" id="project_name" name="project_name"
                                        value="{{ $project->project_name }}" required autofocus>
                                    <div class="invalid-feedback">
                                        {{ __('ชื่องาน/โครงการ ซ้ำ') }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="project_description"
                                        class="form-label">{{ __('รายละเอียดงาน/โครงการ') }}</label>
                                    <textarea class="form-control" name="project_description" id="project_description" rows="10">
                    {{ $project->project_description }}
                  </textarea>
                                    <div class="invalid-feedback">
                                        {{ __('รายละเอียดงาน/โครงการ') }}
                                    </div>
                                </div>




                                <div  id='budget_form'class="row">


                                    <div class="row">
                                        <h4>งบประมาณ</h4>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="budget_it_operating"
                                                    class="form-label">{{ __('งบกลาง ICT ') }}</label>
                                                <!--<input type="text" placeholder="0.00" step="0.01" class="form-control" id="budget_it_investment" name="budget_it_investment" min="0" value="100000.00">-->
                                                <input type="text" placeholder="0.00" step="0.01"
                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control" id="budget_it_operating"
                                                    name="budget_it_operating" min="0"
                                                    value="{{ $project->budget_it_operating }}"


                                                    >
                                                <div class="invalid-feedback">
                                                    {{ __('ระบุงบกลาง ICT') }}
                                                </div>
                                            </div>



                                            <div class="col-4">
                                                <label for="budget_it_investment"
                                                    class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control" id="budget_it_investment"
                                                    name="budget_it_investment" min="0"
                                                    value="{{ $project->budget_it_investment }}">
                                                <div class="invalid-feedback">
                                                    {{ __('ระบุงบดำเนินงาน') }}
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="budget_gov_utility"
                                                    class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control" id="budget_gov_utility"
                                                    name="budget_gov_utility" min="0"
                                                    value="{{ $project->budget_gov_utility }}">
                                                <div class="invalid-feedback">
                                                    {{ __('ระบุค่าสาธารณูปโภค') }}
                                                </div>
                                            </div>
                                        </div>




                                    </div>
                                </div>



                                <div id="increaseData_form"class="row mt-3">
                                    @foreach($increasedbudgetData as $key => $increaseData)
                                    <div class="row mt-3">
                                        <h4>งบประมาณ เพิ่ม {{ $key+1 }}</h4>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="increased_budget_it_operating"
                                                    class="form-label">{{ __('งบกลาง ICT ') }}</label>
                                                <!--<input type="text" placeholder="0.00" step="0.01" class="form-control" id="budget_it_investment" name="budget_it_investment" min="0" value="100000.00">-->
                                                <input type="text" placeholder="0.00" step="0.01"
                                                data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                class="form-control" id="increased_budget_it_operating_{{ $key }}"
                                                name="increased_budget_it_operating[{{ $key }}]" min="0"
                                                value="{{ $increaseData->increased_budget_it_operating }}" >

                                                <div class="invalid-feedback">
                                                    {{ __('ระบุงบกลาง ICT') }}
                                                </div>
                                            </div>



                                            <div class="col-4">
                                                <label for="increased_budget_it_investment"
                                                    class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control" id="increased_budget_it_investment[{{ $key }}]"
                                                    name="increased_budget_it_investment" min="0"
                                                    value="{{ $increaseData->increased_budget_it_investment }}" >
                                                <div class="invalid-feedback">
                                                    {{ __('ระบุงบดำเนินงาน') }}
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="increased_budget_gov_utility"
                                                    class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control" id="increased_budget_gov_utility[{{ $key }}]"
                                                    name="increased_budget_gov_utility" min="0"
                                                    value="{{$increaseData->increased_budget_gov_utility}}" >
                                                <div class="invalid-feedback">
                                                    {{ __('ระบุค่าสาธารณูปโภค') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="row mt-3">

                                    <div class="col-md-3">
                                        <label for="increased_budget_status"
                                            class="form-label">{{ __('งบประมาณ เพิ่ม') }}</label> <span
                                            class="text-danger"></span>
                                        <div >
                                            <input class="form-check-input" type="radio" name="increased_budget_status"
                                                id="increased_budget_status" value="1" >
                                            <label class="form-check-label" for="increased_budget_status"
                                               >
                                                งบประมาณ เพิ่ม
                                            </label>
                                        </div>

                                    <div class="invalid-feedback">
                                        {{ __('งบประมาณ เพิ่ม') }}
                                    </div>
                                </div>
                                    <div class="row">
                                        <h4>งบประมาณ เพิ่ม</h4>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="increased_budget_it_operating"
                                                    class="form-label">{{ __('งบกลาง ICT ') }}</label>
                                                <!--<input type="text" placeholder="0.00" step="0.01" class="form-control" id="budget_it_investment" name="budget_it_investment" min="0" value="100000.00">-->
                                                <input type="text" placeholder="0.00" step="0.01"
                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control" id="increased_budget_it_operating"
                                                    name="increased_budget_it_operating" min="0"
                                                    >
                                                <div class="invalid-feedback">
                                                    {{ __('ระบุงบกลาง ICT') }}
                                                </div>
                                            </div>



                                            <div class="col-4">
                                                <label for="increased_budget_it_investment"
                                                    class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control" id="increased_budget_it_investment"
                                                    name="increased_budget_it_investment" min="0"
                                                    >
                                                <div class="invalid-feedback">
                                                    {{ __('ระบุงบดำเนินงาน') }}
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="increased_budget_gov_utility"
                                                    class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control" id="increased_budget_gov_utility"
                                                    name="increased_budget_gov_utility" min="0"
                                                >
                                                <div class="invalid-feedback">
                                                    {{ __('ระบุค่าสาธารณูปโภค') }}
                                                </div>
                                            </div>
                                        </div>




                                    </div>

                                </div>



                    </div>


                    <x-button class="btn-success" type="submit">{{ __('coreuiforms.save') }}</x-button>
                    <x-button link="{{ route('project.index') }}" class="btn-light text-black">
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
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js"></script>
       {{--  <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script> --}}
        <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
        <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>



        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function() {
                var project_status_during_year = {!! json_encode($project->project_status_during_year == 2) !!}; // รับค่าจาก Laravel ไปยัง JavaScript
                if (project_status_during_year == 2) {
                    var formInputs = document.querySelectorAll(
                        '#increaseData_form input, #mm_form textarea, #mm_form select,#budget_form input'
                        ); // เลือกทั้งหมด input, textarea, และ select ภายใน #mm_form
                    formInputs.forEach(function(input) {
                        input.setAttribute('readonly', true); // ตั้งค่าแอตทริบิวต์ readonly
                    });
                }
            });
        </script>
        <script>
         $(document).ready(function(){
    $(":input").inputmask();
});
    </script>


<script>
    $(function() {
        $("#project_start_date, #project_end_date").datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            language:"th-th",
        });

      var project_fiscal_year = {{$projectDetails->project_fiscal_year}};
        var project_start_date_str = "{{ Helper::Date4(date('Y-m-d H:i:s', $projectDetails->project_start_date)) }}"; // Wrap in quotes
        var project_end_date_str = "{{ Helper::Date4(date('Y-m-d H:i:s', $projectDetails->project_end_date)) }}"; // Wrap in quotes
        //var task_end_date_str = $("#task_end_date").val();


        project_fiscal_year = project_fiscal_year - 543;

        var fiscalYearStartDate = new Date(project_fiscal_year - 1, 9, 1); // 1st October of the previous year
        var fiscalYearEndDate = new Date(project_fiscal_year, 8, 30); // 30th September of the fiscal year

        console.log(project_start_date_str);
        console.log(project_end_date_str);
        console.log(fiscalYearStartDate);
        console.log(fiscalYearEndDate);
// Set the start and end dates for the project_start_date datepicker
$("#project_start_date").datepicker("setStartDate", fiscalYearStartDate);
  $("#project_start_date").datepicker("setEndDate", fiscalYearEndDate);

    // Set the start and end dates for the project_end_date datepicker
   // $("#project_end_date").datepicker("setStartDate", fiscalYearStartDate);
   //var task_end_date_str = $("#task_end_date").val();
   // var task_end_date = (task_end_date_str);
   // var project_end_date =(project_end_date_str);
     // console.log(task_end_date_str);
       // console.log(task_end_date);
        //console.log(project_end_date);


  // Add click event listener for the delete button
/*   $('#project_end_date').click(function(e) {
    e.preventDefault();
    var project_end_date_str = $("#project_end_date").val();
    var project_end_date = convertToDate(project_end_date_str);
    var project_end_date = convertToDate(project_end_date_str);
      console.log(task_end_date_str);
        console.log(task_end_date);
        console.log(project_end_date);

    if (task_end_date > project_end_date) {
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
}); */

$("#project_end_date").datepicker("setEndDate", fiscalYearEndDate);
    $('#project_start_date').on('changeDate', function() {
            var startDate = $(this).datepicker('getDate');
            $("#project_end_date").datepicker("setStartDate", startDate);
        });

     /*    $('#task_end_date').on('changeDate', function() {
            var endDate = $(this).datepicker('getDate');
            $("#task_start_date").datepicker("setEndDate", endDate);
        }); */
    });

    function convertToDate(dateStr) {
        var parts = dateStr.split("/");
        var date = new Date(parts[2], parts[1] - 1, parts[0]);
        return date;
    }
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
$("#budget_it_operating,#budget_it_investment,#budget_gov_utility").on("input", function() {
 var max = 0;
 var fieldId = $(this).attr('id');
var budgetItOperating = $("#budget_it_operating").val();
 var budgetItInvestment = $("#budget_it_investment").val();
 var budgetGovUtility = $("#budget_gov_utility").val();

 if (fieldId === "budget_it_investment") {

     if (budgetItInvestment === "0" || budgetItInvestment === '' || parseFloat(budgetItInvestment) < -0) {
         $("#budget_it_investment").val('');
     }

 }



  if (fieldId === "budget_it_operating") {
         if (budgetItOperating === "0" || budgetItOperating === '' || parseFloat(budgetItOperating) < -0 ) {
             $("#budget_it_operating").val('');
         }
     }


     if (fieldId === "budget_gov_utility") {
     if (budgetGovUtility === "0" || budgetGovUtility === '' || parseFloat(budgetGovUtility) < -0) {
         $("#budget_gov_utility").val('');
     }

 }

 var current = parseFloat($(this).val().replace(/,/g , ""));


});
});
 </script>








{{-- <script>
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
         if (budgetItOperating === "0" || budgetItOperating === '' || parseFloat(budgetItOperating) < -0 ) {
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
 </script> --}}



    </x-slot:javascript>
</x-app-layout>
