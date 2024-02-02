<x-app-layout>
    <x-slot:content>
        <div class="container-fluid">
            {{ Breadcrumbs::render('project.create') }}
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
                <div class="row mt-3">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <x-card title="{{ __('เพิ่มข้อมูล งาน/โครงการ') }}">

                            <form method="POST" action="{{ route('project.store') }}"
                            class="row needs-validation" enctype="multipart/form-data"
                                novalidate>
                                @csrf
                                <div class="row mt-3">
                                    <div class="col-md-2 ">
                                        <label for="project_type"
                                            class="form-label">{{ __('ประเภทงาน/โครงการ') }}</label> <span
                                            class="text-danger">*</span>
                                        <div>
                                            <input class="form-check-input" type="radio" name="project_type"
                                                id="project_type1" value="1" checked>
                                            <label class="form-check-label" for="project_type1">
                                                งานประจำ
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="project_type"
                                                id="project_type2" value="2">
                                            <label class="form-check-label" for="project_type2">
                                                โครงการ
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="project_fiscal_year"
                                            class="form-label">{{ __('ปีงบประมาณ') }}</label> <span
                                            class="text-danger">*</span>
                                            <input type="text" class="form-control" id="project_fiscal_year"
                                            name="project_fiscal_year" required autofocus>
                                        @error('project_fiscal_year')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div id="project_fiscal_year_feedback" class="invalid-feedback">
                                            ปีงบประมาณ
                                          </div>
                                    </div>


                            {{--         $fiscal_year,$reguiar_id --}}
                                    <div class="col-md-3">
                                        <label for="reguiar_id"
                                            class="form-label">{{ __('ลำดับ.ชื่องาน/โครงการ') }}</label>
                                        <span class="text-danger">*</span>
                                        <input type="number" class="form-control" id="reguiar_id" name="reguiar_id" required autofocus
                                        min="1" >
                                        <div id="reguiar_id_feedback" class="invalid-feedback">
                                            ลำดับ.ชื่องาน/โครงการ
                                          </div>



                                    </div>

                                    <div class="col-md-3 d-none">
                                        <label for="project_status"
                                            class="form-label">{{ __('สถานะงาน/โครงการ') }}</label> <span
                                            class="text-danger">*</span>
                                        <div>
                                            <input class="form-check-input" type="radio" name="project_status"
                                                id="project_status1" value="1" checked>
                                            <label class="form-check-label" for="project_status1" checked>
                                                อยู่ในระหว่างดำเนินการ
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="project_status"
                                                id="project_status2" value="2">
                                            <label class="form-check-label" for="project_status2">
                                                ดำเนินการแล้วเสร็จ
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="project_name" class="form-label">{{ __('ชื่องาน/โครงการ') }}</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" id="project_name" name="project_name" required autofocus>

                                        @if ($errors->has('project_name'))
                                            <div class="alert alert-danger">
                                                {{ $errors->first('project_name') }}
                                            </div>
                                        @endif
                                        <div id="project_name_feedback" class="invalid-feedback">
                                            ชื่องาน/โครงการ
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="project_start_date"
                                                class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span
                                                class="text-danger">*</span>
                                            <input type="text" class="form-control" id="project_start_date"
                                                name="project_start_date" required>
                                                <div id="project_start_date_feedback" class="invalid-feedback">
                                                    วันที่เริ่มต้น
                                                  </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="project_end_date"
                                                class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span
                                                class="text-danger">*</span>
                                            <input type="text" class="form-control" id="project_end_date"
                                                name="project_end_date" required>
                                                <div id="project_end_date_feedback" class="invalid-feedback">
                                                    วันที่สิ้นสุด
                                                  </div>
                                        </div>
                                    </div>

                                {{--     <div class="row">
                                        <div class="col-lg-4">
                                          <div data-coreui-locale="th-th" data-coreui-size="sm" data-coreui-toggle="date-picker"></div>
                                        </div>
                                      </div> --}}

                                    <div class="col-md-12 mt-3">
                                        <label for="project_description"
                                            class="form-label">{{ __('รายละเอียดงาน/โครงการ') }}</label>
                                        <textarea class="form-control" name="project_description" id="project_description" rows="10"></textarea>
                                        <div class="invalid-feedback">
                                            {{ __('รายละเอียดงาน/โครงการ') }}
                                        </div>
                                    </div>


                                    <div class=" col-md-12 mt-3">
                                        <label for="file"
                                            class="form-label">{{ __('เอกสารแนบ') }}</label>
                                    <div class="input-group control-group increment " >
                                        <input type="file" name="file[]" class="form-control" multiple >
                                        <div class="input-group-btn">
                                          <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
                                        </div>
                                      </div>
                                      <div class="clone d-none">
                                        <div class="control-group input-group" style="margin-top:10px">
                                          <input type="file" name="file[]" class="form-control" multiple>
                                          <div class="input-group-btn">
                                            <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>










                                    <div class="row mt-3">


                                        <div class="row mt-3">
                                            <h4>งบประมาณ</h4>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="budget_it_operating"
                                                        class="form-label">{{ __('งบกลาง ICT ') }}</label>

                                                    <input type="text" placeholder="0.00" step="0.01"
                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"


                                                        class="form-control numeral-mask" id="budget_it_operating"
                                                        name="budget_it_operating"


                                                        min="0">


                                                    <div class="invalid-feedback">
                                                        {{ __('ระบุงบกลาง ICT') }}
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <label for="budget_it_investment"
                                                        class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                    <input type="text" placeholder="0.00" step="0.01"
                                                         data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                        class="form-control numeral-mask" id="budget_it_investment"
                                                        name="budget_it_investment" min="0">
                                                    <div class="invalid-feedback">
                                                        {{ __('ระบุงบดำเนินงาน') }}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="budget_gov_utility"
                                                        class="form-label">{{ __('งบสาธารณูปโภค') }}</label>
                                                    <input type="text" placeholder="0.00" step="0.01"
                                                         data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                        class="form-control numeral-mask" id="budget_gov_utility"
                                                        name="budget_gov_utility" min="0">
                                                    <div class="invalid-feedback">
                                                        {{ __('ระบุงบสาธารณูปโภค') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    </div>
                    <x-button type="submit" class="btn-success" preventDouble icon="cil-save">
                        {{ __('Save') }}
                    </x-button>

                    <x-button link="{{ route('project.index') }}" class="text-black btn-light">
                        {{ __('coreuiforms.return') }}</x-button>
                    </form>

                    </x-card>


    </x-slot:content>
    <x-slot:css>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet"/>

    </x-slot:css>
    <x-slot:javascript>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js"></script>
   {{--  <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script> --}}
    <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>












   <script type="text/javascript">
        $(document).ready(function() {

          $(".btn-success").click(function(){
              var html = $(".clone").html();
              $(".increment").after(html);
          });

          $("body").on("click",".btn-danger",function(){
              $(this).parents(".control-group").remove();
          });

        });
    </script>
        <script>
            $(document).ready(function() {
                $(":input").inputmask();
            });
        </script>


 <script>
    $(document).ready(function() {
        $("#project_fiscal_year").datepicker({
        format: "yyyy", // กำหนดรูปแบบวันที่เป็นเฉพาะปี
        viewMode: "years", // กำหนดให้แสดงเฉพาะปี
        minViewMode: "years", // กำหนดให้เลือกเฉพาะปี
        language: "th-th"
    });
    });
</script>

<script>
    $(document).ready(function() {
        // Assuming your fiscal year dropdown has an ID of 'fiscal_year'
        $('#project_fiscal_year').on('change', function() {
            // Get the selected fiscal year
            var fiscalYear = $(this).val();
            // Assuming the fiscal year starts on October 1st and ends on September 30th
            // Update the following dates to match your fiscal year's start and end dates
            var fiscalYearStart = '01/10/' + (parseInt(fiscalYear) -1);
            var fiscalYearEnd = '30/09/' + fiscalYear;

            // Assuming your start and end date inputs have IDs 'start_date' and 'end_date'
            $('#project_start_date').val(fiscalYearStart);
            $('#project_end_date').val(fiscalYearEnd);
        });
    });
    </script>


<script>
    $(function() {
        $("#project_start_date, #project_end_date").datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            language: "th-th",
        });

        $('#project_fiscal_year').on('change', function() {
            // Get the selected fiscal year from the datepicker
            var fiscalYearDate = $(this).datepicker('getDate');
            var fiscalYear = fiscalYearDate ? fiscalYearDate.getFullYear() : new Date().getFullYear();
            // Calculate the start and end dates of the fiscal year
            var fiscalYearStartDate = new Date(fiscalYear - 1, 9, 1); // 1st October of the previous year
            var fiscalYearEndDate = new Date(fiscalYear, 8, 30); // 30th September of the fiscal year
            var fiscalYearEnd = '30/09/' + fiscalYear;
            // Set the date range for the project datepickers
            $("#project_start_date").datepicker("setStartDate", fiscalYearStartDate);
      //$("#project_end_date").datepicker("setEndDate", fiscalYearEnd);
        });

        $('#project_start_date').on('changeDate', function() {
            var startDate = $(this).datepicker('getDate');
          //  $("#project_end_date").datepicker("setStartDate", startDate);
        });

        $('#project_end_date').on('changeDate', function() {
            var endDate = $(this).datepicker('getDate');
            $("#project_start_date").datepicker("setEndDate", fiscalYearEnd);
        });
    });
</script>


<script>
    $(document).ready(function() {
$("#budget_it_investment, #budget_gov_utility, #budget_it_operating").on("input", function() {

 var fieldId = $(this).attr('id');
var budgetItOperating = $("#budget_it_operating").val();
 var budgetItInvestment = $("#budget_it_investment").val();
 var budgetGovUtility = $("#budget_gov_utility").val();

     if (budgetItInvestment === "0" || budgetItInvestment === '' || parseFloat(budgetItInvestment) < -0) {
         $("#budget_it_investment").val('');
     }



     if (budgetGovUtility === "0" || budgetGovUtility === '' || parseFloat(budgetGovUtility) < -0) {
         $("#budget_gov_utility").val('');
     }




         if (budgetItOperating === "0" || budgetItOperating === ''|| parseFloat(budgetItOperating) < -0 ) {
             $("#budget_it_operating").val('');
         }
});
});
 </script>





        <script>

  // Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
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
        // เมื่อมีการเปลี่ยนค่าในฟิลด์ project_fiscal_year
        $('#project_fiscal_year, #project_type').on('change', function() {
            var fiscalYear = $(this).val(); // รับค่า project_fiscal_year จากฟิลด์
            var projectType = $('input[name="project_type"]:checked').val(); // รับค่า project_type จากฟิลด์
 var formIsValid = true; // ตรวจสอบความถูกต้องของฟอร์
            // ทำการส่งค่า project_fiscal_year ไปยัง Laravel โดยใช้ Ajax
            $.ajax({
                method: 'GET',
                url: '{{ route("project.check-project") }}',
                data: { project_fiscal_year: fiscalYear, project_type: projectType }, // ส่งค่า project_fiscal_year และ project_type ไปยัง Laravel
                success: function(data) {
                    // ทำอะไรกับข้อมูลที่ได้รับกลับมา
                    console.log(data);
                    $('#reguiar_id').val(data.data); // อัปเดตค่า reguiar_id
                },
                error: function(xhr, status, error) {
                    // กรณีเกิดข้อผิดพลาด
                    console.error(error);
                }
            });
        });

    });
</script>

<script>
    $(document).ready(function() {
        var oldProjectName = ''; // เก็บชื่อโครงการเดิม
        var oldValues = {}; // เก็บค่าเดิมของฟิลด์
        var formIsValid = true; // ตรวจสอบความถูกต้องของฟอร์ม

        $('#project_fiscal_year, #project_name').on('change', function() {
            var project_name = $('#project_name').val();
            var fiscalYear = $('#project_fiscal_year').val();
            var fieldId = $(this).attr('id');

            $.ajax({
                method: 'GET',
                url: '{{ route("project.check-project") }}',
                data: {
                    project_fiscal_year: fiscalYear,
                    project_name: project_name
                },
                success: function(data) {
                    if (data.exists) {
                        $('#' + fieldId).addClass('is-invalid');
                        $('#' + fieldId + '_feedback').text('ชื่องาน/โครงการซ้ำกับงาน/โครงการที่มีอยู่แล้ว');
                        formIsValid = false;
                    } else {
                        $('#' + fieldId).removeClass('is-invalid');
                        oldValues[fieldId] = project_name;
                        formIsValid = true;
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

            if (oldProjectName === project_name) {
                $('#' + fieldId).addClass('is-invalid');
                $('#' + fieldId + '_feedback').text('ชื่องาน/โครงการซ้ำกับงาน/โครงการที่มีอยู่แล้ว');
                formIsValid = false;
            } else {
                $('#' + fieldId).removeClass('is-invalid');
                oldValues[fieldId] = project_name;
                formIsValid = true;
            }
        });

        $("form").on("submit", function(e) {
            if (!formIsValid) {
                e.preventDefault();
                var alertText =  'ชื่องาน/โครงการซ้ำกับงาน/โครงการที่มีอยู่แล้ว';
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
    $(document).ready(function() {
        var oldReguiarId = ''; // เก็บค่าเดิมของฟิลด์
        var formIsValid = true; // ตรวจสอบความถูกต้องของฟอร์ม

        // ฟังก์ชันสำหรับตรวจสอบโครงการที่มีอยู่แล้ว
        function checkProjectExists(reguiar_id, fiscalYear, projectType) {
            var fieldId = 'reguiar_id'; // ใช้ ID ของฟิลด์ reguiar_id สำหรับอ้างอิงและแสดงผล
            $.ajax({
                method: 'GET',
                url: '{{ route("project.check-project") }}', // ตรวจสอบ URL ให้ถูกต้องตามการตั้งค่า route ของคุณ
                data: {
                    project_fiscal_year: fiscalYear,
                    projectType: projectType,
                    reguiar_id: reguiar_id
                },
                success: function(data) {
                    if (data.exists_reguiar_id) {
                        $('#' + fieldId).addClass('is-invalid');
                        $('#' + fieldId + '_feedback').text('ลำดับ.ชื่องาน/โครงการซ้ำกับงาน/โครงการที่มีอยู่แล้ว');
                        formIsValid = false;
                    } else {
                        $('#' + fieldId).removeClass('is-invalid');
                        formIsValid = true;
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    formIsValid = false; // ตั้งค่าฟอร์มให้ไม่ถูกต้องหากเกิดข้อผิดพลาด
                }
            });
        }

        // ตรวจจับการเปลี่ยนแปลงของฟิลด์ reguiar_id และ project_fiscal_year
        $('#reguiar_id, #project_fiscal_year, input[name="project_type"]').on('change', function() {
            var reguiar_id = $('#reguiar_id').val();
            var fiscalYear = $('#project_fiscal_year').val();
            var projectType = $('input[name="project_type"]:checked').val(); // รับค่าประเภทโครงการ

            // ตรวจสอบโครงการที่มีอยู่แล้ว
            checkProjectExists(reguiar_id, fiscalYear, projectType);
        });

        // ตรวจจับการส่งฟอร์ม
        $("form").on("submit", function(e) {
            if (!formIsValid) {
                e.preventDefault(); // ป้องกันไม่ให้ฟอร์มส่งข้อมูลหากมีข้อผิดพลาด
                Swal.fire({
                    title: 'เตือน!',
                    text: 'ลำดับ.ชื่องาน/โครงการซ้ำกับงาน/โครงการที่มีอยู่แล้ว',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                });
            }
        });

        // ตรวจจับการเปลี่ยนแปลงประเภทโครงการและคืนค่าฟิลด์เป็นค่าเริ่มต้น
        $('input[name="project_type"]').on('change', function() {
            if(formIsValid) { // ตรวจสอบเฉพาะเมื่อฟอร์มถูกต้อง
                $('#reguiar_id').val(oldReguiarId); // คืนค่า reguiar_id เป็นค่าเดิม
            }
        });
    });
    </script>




<script>
    $(document).ready(function() {
        var fieldId = $(this).attr('id');
      // กำหนดเหตุการณ์ 'change' สำหรับปุ่ม radio
      $("input[name='project_type']").on("change", function() {
        // ตรวจสอบค่าของปุ่ม radio ที่เลือก
        if ($("#project_type1").is(":checked")) {
          // ถ้าเลือก 'งานประจำ' ทำการล้างค่าในฟิลด์ 'ปีงบประมาณ' และ 'ลำดับ.ชื่องาน/โครงการ'
          $("#project_fiscal_year").val('').removeClass('is-invalid');
          $("#reguiar_id").val('').removeClass('is-invalid');
            $('#' + fieldId).removeClass('is-invalid');
         //  $("#reguiar_id").removeClass('is-invalid');
           // ล้างค่าข้อความเตือน 6/02/2567
        } else if ($("#project_type2").is(":checked")) {
          // ถ้าเลือก 'โครงการ' ทำการล้างค่าในฟิลด์ 'ปีงบประมาณ' และ 'ลำดับ.ชื่องาน/โครงการ'

          $("#project_fiscal_year").val('').removeClass('is-invalid');
          $("#reguiar_id").val('').removeClass('is-invalid');
         // $("#reguiar_id").removeClass('is-invalid');
          $('#' + fieldId).removeClass('is-invalid');
             // ล้างค่าข้อความเตือน 6/02/2567
        }
      });
    });
    </script>
    </x-slot:javascript>
</x-app-layout>

{{-- <script>
    $(document).ready(function() {
        var oldprojectname = $('#project_name').val();
        var $project_name = 'ค่าที่คุณต้องการเปรียบเทียบ';
        $.ajax({
            method: 'GET',
            data: { project_fiscal_year: fiscalYear, project_name: name }, // ส่งค่า project_fiscal_year และ project_name ไปยัง Laravel
            success: function(data) {
                // ทำอะไรกับข้อมูลที่ได้รับกลับมา
                console.log(data);
                if (data.exists) {
                    $('#project_name').val('');
                    $('.invalid-feedback').text('ชื่อโครงการนี้มีอยู่แล้ว');
                } else {
                    // ไม่มีชื่อโครงการที่ซ้ำ
                    // คุณสามารถทำอะไรก็ได้ที่นี่
                }
            },
            error: function(xhr, status, error) {
                // กรณีเกิดข้อผิดพลาด
                console.error(error);
            }
        });

        if (oldprojectname === $project_name) {
            $('#project_name').val('');
            $('.invalid-feedback').text('ชื่องาน/โครงการซ้ำกับงาน/โครงการที่มีอยู่แล้ว');
        } else {
            // ไม่ซ้ำ
            // คุณสามารถทำอะไรก็ได้ที่นี่
        }
    });
</script> --}}

{{-- <script>
    $(document).ready(function() {
        // เมื่อมีการเปลี่ยนค่าในฟิลด์ project_fiscal_year
        $('#project_fiscal_year,#project_type').on('change', function() {
            var fiscalYear = $(this).val(); // รับค่า project_fiscal_year จากฟิลด์
            var projectType = $('input[name="project_type"]:checked').val(); // รับค่า project_type จากฟิลด์
            console.log("Fiscal Year: " + fiscalYear + ", Project Type: " + projectType);
            // ทำการส่งค่า project_fiscal_year ไปยัง Laravel โดยใช้ Ajax
            $.ajax({
                method: 'GET',
                data: { project_fiscal_year: fiscalYear ,project_type:projectType}, // ส่งค่า project_fiscal_year ไปยัง Laravel
                success: function(data) {
                    // ทำอะไรกับข้อมูลที่ได้รับกลับมา
                    console.log(data);
                    $('#reguiar_id').val(data);
                },
                error: function(xhr, status, error) {
                    // กรณีเกิดข้อผิดพลาด
                    console.error(error);
                }
            });
        });


    });
</script> --}}



<!-- ใส่สคริปต์นี้ในเทมเพลต Blade ของคุณในแท็ก head หรือ body -->
{{--  <script>
    $(document).ready(function() {
        function checkFiscalYear() {
            var fiscalYear = $('#project_fiscal_year').val();
            var projectType = $('input[name="project_type"]:checked').val();
            console.log("Fiscal Year: " + fiscalYear + ", Project Type: " + projectType);

            if(fiscalYear && projectType) {
                // ทำการเรียก AJAX ไปยังเส้นทางของ Laravel ที่ส่งกลับค่า 'reguiar_id' สูงสุด
                $.get('/api/getMaxRegularId', { fiscal_year: fiscalYear, project_type: projectType }, function(data) {
                    // สมมุติว่า 'data' มีค่า 'reguiar_id' สูงสุด
                    $('#reguiar_id').val(data.max_reguiar_id);
                });
            } else {
                $('#reguiar_id').val('Default Value');
            }
        }

        $('#project_fiscal_year, input[name="project_type"]').on('change', checkFiscalYear);
        checkFiscalYear(); // ตรวจสอบค่าเริ่มต้น
    });
</script> --}}


<!-- Blade Template: resources/views/app/projects/create.blade.php -->
{{-- <script>
    $(document).ready(function() {
        // Function to update 'reguiar_id' based on 'project_fiscal_year' and 'project_type'
        function updateReguiarId() {
            var fiscalYear = $('#project_fiscal_year').val();
            var projectType = $('input[name="project_type"]:checked').val();

           // ใน Blade template
$.get('/getMaxRegularId', { fiscal_year: fiscalYear, project_type: projectType }, function(data) {
    // อัปเดต 'reguiar_id' ด้วยข้อมูลที่ได้รับจากเซิร์ฟเวอร์
    $('#reguiar_id').val(data.max_reguiar_id);
});
        }

        // Event listener for when the fiscal year or project type changes
        $('#project_fiscal_year, input[name="project_type"]').change(updateReguiarId);

        // Initial update on page load
        updateReguiarId();
    });
    </script> --}}



{{-- <script>
$('#project_fiscal_year,#project_name').on('change', function() {
  //  var fiscalYear = $(this).val(); // รับค่า project_fiscal_year จากฟิลด์
    var oldprojectname = $('#project_name').val();
    var project_name = 'ค่าที่คุณต้องการเปรียบเทียบ';

    // Ajax request เพื่อตรวจสอบชื่อโครงการซ้ำกัน
    $.ajax({
        method: 'GET',
        data: {  project_name: name }, // ส่งค่า project_fiscal_year และ project_name ไปยัง Laravel
        success: function(data) {
            // ทำอะไรกับข้อมูลที่ได้รับกลับมา
            console.log(data);
            if (data.exists) {
                $('#project_name').val(data.exists);
                $('.invalid-feedback').text('ชื่อโครงการนี้มีอยู่แล้ว');
            } else {
                // ไม่มีชื่อโครงการที่ซ้ำ
                // คุณสามารถทำอะไรก็ได้ที่นี่
            }
        },
        error: function(xhr, status, error) {
            // กรณีเกิดข้อผิดพลาด
            console.error(error);
        }
    });

    if (oldprojectname === project_name) {
        $('#project_name').val('');
        $('.invalid-feedback').text('ชื่องาน/โครงการซ้ำกับงาน/โครงการที่มีอยู่แล้ว');
    } else {
        // ไม่ซ้ำ
        // คุณสามารถทำอะไรก็ได้ที่นี่
    }
})
</script> --}}

{{-- <script>
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
