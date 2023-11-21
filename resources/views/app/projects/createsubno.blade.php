<x-app-layout>
    <x-slot name="content">
        <div class="container-fluid">
            {{--  {{ Breadcrumbs::render('project.task.createsub', $project, $task) }} --}}
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
                        <x-card title="{{ __('ค่าใช้จ่ายสำนักงาน') }}">
                            <x-slot:toolbar>
                                {{-- <a href="{{ route('contract.create') }}" class="btn btn-success text-white">C</a>

  <a href="{{ route('project.task.createsub', $project) }}" class="btn btn-primary text-white">ไปยังหน้าการใช้จ่ายของงาน</a> --}}
                            </x-slot:toolbar>

                            <form method="POST" action="{{ route('project.storesubno') }}" class="row needs-validation"
                                novalidate>

                                @csrf
                                {{--   <input  type="hidden"  class="form-control" id="task_parent_display"
                                value="{{ $task->task_name }}" disabled readonly>

                                <input  type="hidden" class="form-control" id="task_id" name="task_id" value="{{ $task->task_id }}">
 --}}

                                <div class="callout callout-primary row mt-3">
                                    <div class="col-md-3">
                                        <label for="project_fiscal_year"
                                            class="form-label">{{ __('ปีงบประมาณ') }}</label> <span
                                            class="text-danger">*</span>
                                        <select name="project_fiscal_year"
                                            class="form-select @error('project_fiscal_year') is-invalid @enderror">
                                            @for ($i = date('Y') + 541; $i <= date('Y') + 543 + 3; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $fiscal_year == $i ? 'selected' : '' }}>{{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('project_fiscal_year')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 ">
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
                                        <label for="reguiar_id"
                                            class="form-label">{{ __('งบประมาณที่ได้รับจัดสรร') }}</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" id="reguiar_id" name="reguiar_id"
                                            required autofocus>
                                        <!-- <select name="reguiar_id" class="form-select @error('reguiar_id') is-invalid @enderror">
                @for ($i = $reguiar_id; $i <= $reguiar_id; $i++)
<option value="{{ $i }}" {{ $reguiar_id == $i ? 'selected' : '' }}>{{ $i }}</option>
@endfor
            </select>-->
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            ชื่องาน/โครงการ
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
                                        <div class="col-md-3 ">
                                            <label for="reguiar_id"
                                                class="form-label">{{ __('ลำดับงาน/โครงการ') }}</label>
                                            <span class="text-danger">*</span>



                                            <input type="text" class="form-control" id="reguiar_id" name="reguiar_id"
                                                required autofocus>
                                            <!-- <select name="reguiar_id" class="form-select @error('reguiar_id') is-invalid @enderror">
                    @for ($i = $reguiar_id; $i <= $reguiar_id; $i++)
<option value="{{ $i }}" {{ $reguiar_id == $i ? 'selected' : '' }}>{{ $i }}</option>
@endfor
                </select>-->
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                ชื่องาน/โครงการ
                                            </div>






                                        </div>

                                        <div class="col-md-9 ">
                                            <label for="project_name"
                                                class="form-label">{{ __('ชื่องาน/โครงการ') }}</label>
                                            <span class="text-danger">*</span>
                                            <input type="text" class="form-control" id="project_name"
                                                name="project_name" required autofocus>

                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
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
                                            </div>
                                            <div class="col-md-6">
                                                <label for="project_end_date"
                                                    class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span
                                                    class="text-danger">*</span>
                                                <input type="text" class="form-control" id="project_end_date"
                                                    name="project_end_date" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--
    <div class="col-md-12 mt-3">
        <label for="project_description"
            class="form-label">{{ __('รายละเอียดงาน/โครงการ') }}</label>
        <textarea class="form-control" name="project_description" id="project_description" rows="10"></textarea>
        <div class="invalid-feedback">
            {{ __('รายละเอียดงาน/โครงการ') }}
        </div>
    </div> --}}

                                <div class="d-none col-md-3">
                                    <label for="contract_type" class="form-label">{{ __('ประเภท') }} </label>
                                    {{ Form::select('contract_type', \Helper::contractType(), '4', ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...', 'id' => 'contract_type']) }}

                                </div>


                                <div>

                                    <div>

                                        <div class="accordion-body">
                                            <h4> ข้อมูลค่าใช้จ่าย </h4>
                                            <div id="mm_form" {{-- style="display:none;" --}}>


                                                <div class="callout callout-primary row mt-3">
                                                    {{--  <div class="col-md-12 mt-3">
                                                <label for="task_name"
                                                    class="form-label">{{ __('ชื่อรายการที่ใช้จ่าย') }}</label> <span
                                                    class="text-danger">*</span>
                                                <input type="text" class="form-control" id="task_name" name="task_name"
                                                value= {{ session('contract_name') }}>
                                                <div class="invalid-feedback">
                                                    {{ __('ชื่อรายการที่ใช้จ่าย') }}
                                                </div>

                                            </div> --}}
                                                    <div class="col-md-12 mt-3">
                                                        <label for="taskcon_mm_name"
                                                            class="form-label">{{ __('ชื่อ MM / ชื่อบันทึกข้อความ') }}</label>


                                                        <input type="text" class="form-control"
                                                            id="taskcon_mm_name" name="taskcon_mm_name">
                                                        <div class="invalid-feedback">
                                                            {{ __('ชื่อสัญญา ซ้ำ') }}
                                                        </div>
                                                    </div>


                                                    <div class="col-md-4 mt-3">
                                                        <label for="taskcon_mm"
                                                            class="form-label">{{ __('เลขที่ MM/เลขที่ สท.') }}</label>
                                                        <span class="text-danger"></span>

                                                        <input type="text" class="form-control" id="taskcon_mm"
                                                            name="taskcon_mm">
                                                        <div class="invalid-feedback">
                                                            {{ __(' ') }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-3">
                                                        <label for="taskcon_mm_budget"
                                                            class="form-label">{{ __('วงเงิน (บาท) MM') }}</label>
                                                        <span class="text-danger"></span>

                                                        <input type="text" placeholder="0.00" step="0.01"
                                                            class="form-control" id="taskcon_mm_budget"
                                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                            class="form-control numeral-mask" name="taskcon_mm_budget"
                                                            min="0">
                                                    </div>



                                                    <div id="ba_form" {{-- style="display:none;" --}}>
                                                        <div class="row mt-3">
                                                            <div class="col-md-4">
                                                                <label for="taskcon_ba "
                                                                    class="form-label">{{ __('ใบยืมเงินรองจ่าย (BA) ') }}</label>
                                                                {{--  officeexpenses ค่าใช้จ่ายสำนักงาน --}}
                                                                <span class="text-danger"></span>

                                                                <input type="text" class="form-control"
                                                                    id="taskcon_ba" name="taskcon_ba">
                                                                <div class="invalid-feedback">
                                                                    {{ __(' ') }}
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label for="taskcon_ba_budget"
                                                                    class="form-label">{{ __('จำนวนเงิน (บาท) BA') }}</label>
                                                                <span class="text-danger"></span>

                                                                <input type="text" placeholder="0.00"
                                                                    step="0.01" class="form-control"
                                                                    id="taskcon_ba_budget"
                                                                    data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                    class="form-control numeral-mask"
                                                                    name="taskcon_ba_budget" min="0">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="bd_form" {{-- style="display:none; --}}>
                                                        <div class="row mt-3">
                                                            <div class="col-md-4">
                                                                <label for="taskcon_bd "
                                                                    class="form-label">{{ __('ใบยืมเงินหน่อยงาน (BD)') }}</label>
                                                                {{--  officeexpenses ค่าใช้จ่ายสำนักงาน --}}
                                                                <span class="text-danger"></span>

                                                                <input type="text" class="form-control"
                                                                    id="taskcon_bd" name="taskcon_bd">
                                                                <div class="invalid-feedback">
                                                                    {{ __(' ') }}
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label for="contract_bd_budget"
                                                                    class="form-label">{{ __('จำนวนเงิน (บาท) BD') }}</label>
                                                                <span class="text-danger"></span>

                                                                <input type="text" placeholder="0.00"
                                                                    step="0.01" class="form-control"
                                                                    id="taskcon_bd_budget"
                                                                    data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                    class="form-control numeral-mask"
                                                                    name="taskcon_bd_budget" min="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="pp_form"
                                                    class="callout callout-danger"{{--  style="display:none;" --}}>



                                                    <div class="row mt-3">
                                                        <div class="col-md-4">
                                                            <label for="contract_pay"
                                                                class="form-label">{{ __('งบใบสำคัญ_PP ') }}</label>
                                                            <span class="text-danger"></span>

                                                            <input type="text" class="form-control"
                                                                id="taskcon_pp" name="taskcon_cn">
                                                            <div class="invalid-feedback">
                                                                {{ __(' ') }}
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="taskcon_pay"
                                                                class="form-label">{{ __('จำนวนเงิน (บาท) PP') }}</label>
                                                            <span class="text-danger"></span>

                                                            <input type="text" placeholder="0.00" step="0.01"
                                                                class="form-control" id="taskcon_pay"
                                                                data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                class="form-control numeral-mask" name="taskcon_pay"
                                                                min="0">
                                                        </div>
                                                    </div>

                                                    <div class="row mt-3">
                                                        <div class="col-md-4">
                                                            <label for="taskcon_pay_date"
                                                                class="form-label">{{ __('วันที่เบิกจ่าย') }}</label>
                                                            <span class="text-danger">*</span>
                                                            <input type="text" class="form-control"
                                                                id="taskcon_pay_date" name="taskcon_pay_date"
                                                                required>
                                                        </div>

                                                    </div>
                                                </div>











                                            </div>
                                        </div>
                                    </div>








                                    <x-button class="btn-success" type="submit">{{ __('coreuiforms.save') }}
                                    </x-button>

                            </form>
                        </x-card>
                    </div>
                </div>
            </div>
        </div>
        </x-slot:content>
        <x-slot:css>

        </x-slot:css>
        <x-slot:javascript>

            <!-- Add the necessary CSS and JS files for Select2 -->

            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


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
                    $('#rounds').change(function() {
                        var rounds = $(this).val();
                        $('#tasksContainer').empty(); // clear the container
                        for (var i = 0; i < rounds; i++) {
                            $('#tasksContainer').append(`
                        <div class="row mt-3">
                            <div class="col-md-12">

                                    <label>ชื่อ ` + (i + 1) + ` &nbsp: &nbsp</label><input type="text" name="tasks[` +
                                i +
                                `][task_name]" value=" ` + (i + 1) + `"required>
                                </div>
                            </div>
                        </div>
                    `);
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
     //   var toDay = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 543);

        var dateBefore=null;
        $("#project_start_date, #project_end_date").datepicker({
            dateFormat: 'dd-mm-yy',
       // showOn: 'button',
//      buttonImage: 'http://jqueryui.com/demos/datepicker/images/calendar.gif',
       // buttonImageOnly: false,
        dayNamesMin: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
        monthNamesShort: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
        changeMonth: true,
        changeYear: true,
        beforeShow:function(){
            if($(this).val()!=""){
                var arrayDate=$(this).val().split("-");
                arrayDate[2]=parseInt(arrayDate[2])-543;
                $(this).val(arrayDate[0]+"-"+arrayDate[1]+"-"+arrayDate[2]);
            }
            setTimeout(function(){
                $.each($(".ui-datepicker-year option"),function(j,k){
                    var textYear=parseInt($(".ui-datepicker-year option").eq(j).val())+543;
                    $(".ui-datepicker-year option").eq(j).text(textYear);
                });
            },50);
        },
        onChangeMonthYear: function(){
            setTimeout(function(){
                $.each($(".ui-datepicker-year option"),function(j,k){
                    var textYear=parseInt($(".ui-datepicker-year option").eq(j).val())+543;
                    $(".ui-datepicker-year option").eq(j).text(textYear);
                });
            },50);
        },
        onClose:function(){
            if($(this).val()!="" && $(this).val()==dateBefore){
                var arrayDate=dateBefore.split("-");
                arrayDate[2]=parseInt(arrayDate[2])+543;
                $(this).val(arrayDate[0]+"/"+arrayDate[1]+"/"+arrayDate[2]);
            }
        },
        onSelect: function(dateText, inst){
            dateBefore=$(this).val();
            var arrayDate=dateText.split("-");
            arrayDate[2]=parseInt(arrayDate[2])+543;
            $(this).val(arrayDate[0]+"/"+arrayDate[1]+"/"+arrayDate[2]);
        }
    });
});
</script>
            <script>
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

                $(document).ready(function() {
                    $('#insurance_start_date, #insurance_end_date').datepicker({

                        dateFormat: "dd/mm/yy",


                        onSelect: calculateDuration
                    });
                });
            </script>

            <script>
                $(document).ready(function() {
                    $(":input").inputmask();
                });
            </script>



        </x-slot:javascript>
</x-app-layout>
