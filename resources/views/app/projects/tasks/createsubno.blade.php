<x-app-layout>
    <x-slot name="content">
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
                        <x-card title="{{ __('ค่าใช้จ่ายสำนักงาน') }}">
                            <x-slot:toolbar>
                                {{-- <a href="{{ route('contract.create') }}" class="btn btn-success text-white">C</a>

  <a href="{{ route('project.task.createsub', $project) }}" class="btn btn-primary text-white">ไปยังหน้าการใช้จ่ายของงาน</a> --}}
                            </x-slot:toolbar>

                            <form method="POST" action="{{ route('project.task.storesubno', ['project' => $project, 'task' => $task]) }}" class="row g-3">

                                @csrf
                                <input {{--  type="hidden" --}} class="form-control" id="task_parent_display"
                                value="{{ $task->task_name }}" disabled readonly>

                                <input  type="hidden" class="form-control" id="task_id" name="task_id" value="{{ $task->task_id }}">






                                    <div class="d-none col-md-3">
                                        <label for="contract_type" class="form-label">{{ __('ประเภท') }} </label>
                                        {{ Form::select('contract_type', \Helper::contractType(), '4', ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...', 'id' => 'contract_type' ]) }}


                                    </div>




                            <h4>   ข้อมูลค่าใช้จ่าย  </h4>
                            <div >

                                <div>
                                    <div class="accordion-body">

                                        <!--ข้อมูลสัญญา 3 -->


                                </div>
                                <div class="accordion-body">

                                    <div id="mm_form" {{-- style="display:none;" --}}>


                                        <div class="callout callout-primary row mt-3">
                                            <div class="col-md-12 mt-3">
                                                <label for="task_name"
                                                    class="form-label">{{ __('ชื่อรายการที่ใช้จ่าย') }}</label> <span
                                                    class="text-danger">*</span>
                                                <input type="text" class="form-control" id="task_name" name="task_name"
                                                value= {{ session('contract_name') }}>
                                                <div class="invalid-feedback">
                                                    {{ __('ชื่อรายการที่ใช้จ่าย') }}
                                                </div>

                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <label for="taskcon_mm_name"
                                                    class="form-label">{{ __('ชื่อ MM / ชื่อบันทึกข้อความ') }}</label>


                                                <input type="text" class="form-control"
                                                    id="taskcon_mm_name" name="taskcon_mm_name" >
                                                <div class="invalid-feedback">
                                                    {{ __('ชื่อสัญญา ซ้ำ') }}
                                                </div>
                                            </div>


                                            <div class="col-md-4 mt-3">
                                                <label for="taskcon_mm"
                                                    class="form-label">{{ __('เลขที่ MM/เลขที่ สท.') }}</label>
                                                <span class="text-danger"></span>

                                                <input type="text" class="form-control"
                                                    id="taskcon_mm" name="taskcon_mm">
                                                <div class="invalid-feedback">
                                                    {{ __(' ') }}
                                                </div>
                                            </div>

                                            <div class="col-md-4 mt-3">
                                                <label for="taskcon_mm_budget"
                                                    class="form-label">{{ __('วงเงิน (บาท) MM') }}</label>
                                                <span class="text-danger"></span>

                                                <input type="text" placeholder="0.00"
                                                    step="0.01" class="form-control"
                                                    id="taskcon_mm_budget"
                                                    data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                    class="form-control numeral-mask"
                                                    name="taskcon_mm_budget" min="0">
                                            </div>



                                            <div class="col-md-12 mt-3">
                                                <label for="taskcon_name" id="taskcon_name_label"
                                                    class="form-label">{{ __('ชื่อ ค่าใช้จ่ายสำนักงาน') }}</label>

                                                <input type="text" class="form-control" id="contract_name"
                                                    name="taskcon_name" required autofocus>
                                                <div class="invalid-feedback">
                                                    {{ __('ชื่อสัญญา ซ้ำ') }}
                                                </div>
                                            </div>
                                            <div id="pr_form" style="display:none;">
                                                <div class="row mt-3">
                                                    <div class="col-md-4">
                                                        <label for="taskcon_pr"
                                                            class="form-label">{{ __('เลขที่ PR') }}</label>
                                                        <span class="text-danger"></span>

                                                        <input type="text" class="form-control"
                                                            id="taskcon_PR" name="contract_pr">
                                                        <div class="invalid-feedback">
                                                            {{ __(' ') }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="taskcon_pr_budget"
                                                            class="form-label">{{ __('จำนวนเงิน (บาท) PR') }}</label>
                                                        <span class="text-danger"></span>

                                                        <input type="taxt" placeholder="0.00"
                                                            step="0.01" class="form-control"
                                                            id="taskcon_pr_budget"
                                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                            class="form-control numeral-mask"
                                                            name="taskcon_pr_budget"
                                                            min="0">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="callout callout-success">
                                        <div id="pr_form" style="display:none;">
                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                    <label for="taskcon_pa"
                                                        class="form-label">{{ __('เลขที่ PA') }}</label>
                                                    <span class="text-danger"></span>

                                                    <input type="text" class="form-control"
                                                        id="taskcon_PA" name="taskcon_pa">
                                                    <div class="invalid-feedback">
                                                        {{ __(' ') }}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="taskcon_pa_budget"
                                                        class="form-label">{{ __('จำนวนเงิน (บาท) PA') }}</label>
                                                    <span class="text-danger"></span>

                                                    <input type="taxt" placeholder="0.00"
                                                        step="0.01" class="form-control"
                                                        id="taskcon_pa_budget"
                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                        class="form-control numeral-mask"
                                                        name="taskcon_pa_budget" min="0">
                                                </div>
                                            </div>
                                        </div>


                                        <div id="po_form" style="display:none;">
                                            <!-- PO form fields -->

                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                    <label for="taskcon_po"
                                                        class="form-label">{{ __('เลขที่ PO') }}</label>
                                                    <span class="text-danger"></span>

                                                    <input type="text" class="form-control"
                                                        id="taskcon_PO" name="taskcon_po">
                                                    <div class="invalid-feedback">
                                                        {{ __(' ') }}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="taskcon_po_budget"
                                                        class="form-label">{{ __('จำนวนเงิน (บาท) PO') }}</label>
                                                    <span class="text-danger"></span>

                                                    <input type="taxt" placeholder="0.00"
                                                        step="0.01" class="form-control"
                                                        id="taskcon_po_budget"
                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                        class="form-control numeral-mask"
                                                        name="taskcom_po_budget" min="0">
                                                </div>


                                                <div class="col-md-4">
                                                    <label for="taskcon_po_start_date"
                                                        class="form-label">{{ __('กำหนดวันที่ส่งของ') }}</label>
                                                    <span class="text-danger"></span>

                                                    <input type="text" class="form-control"
                                                        id="taskcon_po_start_date"
                                                        name="taskcon_po_start_date">
                                                    <div class="invalid-feedback">
                                                        {{ __(' ') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="er_form" style="display:none;">
                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                    <label for="taskcon_er"
                                                        class="form-label">{{ __('เลขที่ ER') }}</label>
                                                    <span class="text-danger"></span>

                                                    <input type="text" class="form-control"
                                                        id="taskcon_ER" name="taskcon_er">
                                                    <div class="invalid-feedback">
                                                        {{ __(' ') }}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="taskcon_er_budget"
                                                        class="form-label">{{ __('จำนวนเงิน (บาท) ER') }}</label>
                                                    <span class="text-danger"></span>

                                                    <input type="text" placeholder="0.00"
                                                        step="0.01" class="form-control"
                                                        id="taskcon_er_budget"
                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                        class="form-control numeral-mask"
                                                        name="taskcon_po_budget" min="0">
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="taskcon_er_start_date"
                                                        class="form-label">{{ __('กำหนดวันที่ส่งมอบงาน') }}</label>
                                                    <span class="text-danger"></span>

                                                    <input type="text" class="form-control"
                                                        id="taskcon_er_start_date"
                                                        name="taskcon_er_start_date">
                                                    <div class="invalid-feedback">
                                                        {{ __(' ') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="cn_form" style="display:none;">
                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                    <label for="taskcon_cn"
                                                        class="form-label">{{ __('เลขที่ CN') }}</label>
                                                    <span class="text-danger"></span>

                                                    <input type="text" class="form-control"
                                                        id="taskcon_cn" name="taskcon_cn">
                                                    <div class="invalid-feedback">
                                                        {{ __(' ') }}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="taskcon_cn_budget"
                                                        class="form-label">{{ __('จำนวนเงิน (บาท) CN') }}</label>
                                                    <span class="text-danger"></span>

                                                    <input type="text" placeholder="0.00"
                                                        step="0.01" class="form-control"
                                                        id="taskcon_cn_budget"
                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                        class="form-control numeral-mask"
                                                        name="taskcon_cn_budget" min="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="ba_form" {{-- style="display:none;" --}}>
                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                    <label for="taskcon_ba "
                                                        class="form-label">{{ __('เลขที่  BA ') }}</label>
                                                    {{--  officeexpenses ค่าใช้จ่ายสำนักงาน --}}
                                                    <span class="text-danger"></span>

                                                    <input type="text" class="form-control"
                                                        id="taskcon_ba" name="taskcon_cn">
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
                                                        id="taskcon_oe_budget"
                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                        class="form-control numeral-mask"
                                                        name="taskcon_oe_budget" min="0">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="bd_form" {{-- style="display:none; --}}">
                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                    <label for="taskcon_bd "
                                                        class="form-label">{{ __('เลขที่ BD') }}</label>
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
                                                    class="form-label">{{ __('เลขที่_PP ') }}</label>
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

                                                <input type="text" placeholder="0.00"
                                                    step="0.01" class="form-control"
                                                    id="taskcon_pay"
                                                    data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                    class="form-control numeral-mask"
                                                    name="taskcon_pay" min="0">
                                            </div>
                                        </div>


                                </div><!-- 1  -->
                            </div>
                        </div>

                        <div>

                           <h4>    ข้อมูล 2
                             (เลขทะเบียนคู่ค้า,วันที่เริ่มต้น-สิ้นสุด,ลงนามสัญญา,
                             ประก้น)    </h4>
                         <div >
                             <div class="accordion-body">


                                 <div class="row callout callout-info mt-3">

                                 <div class="row callout callout-warning  mt-3">

                                     <div class="col-md-3">
                                         <label for="taskcon_start_date"
                                             class="form-label">{{ __('วันที่เริ่มต้น') }}</label>

                                         <input type="text" class="form-control"
                                             id="taskcon_start_date"
                                             name="taskcon_start_date">

                                     </div>


                                     <div class="col-md-3">
                                         <label for="taskcon_end_date"
                                             class="form-label">{{ __('วันที่สิ้นสุด') }}</label>
                                         <input type="text" class="form-control"
                                             id="taskcon_end_date" name="taskcon_end_date">

</div>
                                     </div>

                                 </div>

                                 <div class="row callout callout-danger mt-3">
                                     <div class="col-md-3">
                                         <label for="insurance_start_date"
                                             class="form-label">{{ __('วันที่เริ่มต้น ประก้น') }}</label>
                                         <span class="text-danger"></span>
                                         <input type="text" class="form-control"
                                             id="insurance_start_date"
                                             name="insurance_start_date">

                                     </div>


                                     <div class="col-md-3">
                                         <label for="insurance_end_date"
                                             class="form-label">{{ __('วันที่สิ้นสุด ประกัน') }}</label>
                                         <span class="text-danger"></span>
                                         <input type="text" class="form-control"
                                             id="insurance_end_date" name="insurance_end_date">

                                     </div>

                                     <div class="row mt-3">
                                         <div class="col-md-3">
                                             <div class="row">
                                                 <div class="col-12">
                                                     {{ __('ประกัน จำนวนเดือน') }}
                                                 </div>
                                                 <div id="insurance_duration_months"
                                                     class="col-12">
                                                 </div>
                                             </div>
                                             <div class="row mt-3">
                                                 <div class="col-12">
                                                     {{ __('ประกัน จำนวนวัน') }}
                                                 </div>
                                                 <div id="insurance_duration_days"
                                                     class="col-12">
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <!--จบ ข้อมูลสัญญา 2-->
                             </div>
                         </div>
                     </div>
                     <div>


                         </div>
                     </div>
             </div>








             <x-button class="btn-success" type="submit">{{ __('coreuiforms.save') }}</x-button>

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

                                    <label>ชื่อ ` + (i + 1) + ` &nbsp: &nbsp</label><input type="text" name="tasks[` + i +
                            `][task_name]" value=" ` + (i + 1) + `"required>
                                </div>
                            </div>
                        </div>
                    `);
                    }
                });
            });
        </script>


        {{-- <script>
            $(document).ready(function() {
                $('#contract_type').change(function() {
                    var contract_type = $(this).val();
                    var contract_name_label = $('#contract_name_label');
                    var rounds_form = $('#rounds_form');
                    var rounds_label = $('#rounds_label');



                    if (contract_type == 1) {
                        contract_name_label.text('ชื่อ PO');
                        rounds_label.text('จำนวนงวด');
                        $('#mm_form').show();
                        $('#pr_form').show();
                        $('#pa_form').show();
                        $('#po_form').show();
                        $('#er_form').hide();
                        $('#cn_form').show();
                        $('#oe_form').hide();
                        $('#pp_form').hide();
                        $('#rounds_form').show();
                    } else if (contract_type == 2) {
                        contract_name_label.text('ชื่อ ER');
                        rounds_label.text('จำนวนงวด');
                        $('#mm_form').show();
                        $('#pr_form').show();
                        $('#pa_form').show();
                        $('#po_form').hide();
                        $('#er_form').show();
                        $('#cn_form').show();
                        $('#oe_form').hide();
                        $('#pp_form').hide();
                        $('#rounds_form').show();
                    } else if (contract_type == 3) {
                        contract_name_label.text('ชื่อ CN');
                        rounds_label.text('จำนวนงวด');
                        $('#mm_form').show();
                        $('#pr_form').show();
                        $('#pa_form').show();
                        $('#po_form').show();
                        $('#er_form').hide();
                        $('#cn_form').show();
                        $('#oe_form').hide();
                        $('#pp_form').hide();
                        $('#rounds_form').show();
                    } else if (contract_type == 4) {
                        contract_name_label.text('ชื่อ ค่าใช้จ่ายสำนักงาน');
                        rounds_label.text('ค่าใช้จ่ายสำนักงาน');
                        $('#mm_form').show();
                        $('#pr_form').hide();
                        $('#pa_form').hide();
                        $('#po_form').hide();
                        $('#er_form').hide();
                        $('#cn_form').hide();
                        $('#oe_form').show();
                        $('#pp_form').show();
                        $('#ba_form').show();
                        $('#bd_form').show();
                        $('#rounds_form').show();
                    } else {
                        contract_name_label.text('ชื่อ PO/ER/CN/ค่าใช้จ่ายสำนักงาน');
                        $('#mm_form').show();
                        $('#pr_form').show();
                        $('#pa_form').show();
                        $('#po_form').show();
                        $('#er_form').show();
                        $('#cn_form').show();
                        $('#oe_form').show();
                        $('#pp_form').show();
                        $('#ba_form').show();
                        $('#bd_form').show();
                        $('#rounds_form').show();
                    }
                });
            });
        </script> --}}


        <!--<script>
            function formatDate(date) {
                var parts = date.split("/");
                return parts[1] + "/" + parts[0] + "/" + parts[2];
            }

            $(document).ready(function() {
                $("#insurance_start_date, #insurance_end_date").change(function() {
                    var start = new Date(formatDate($("#insurance_start_date").val()));
                    var end = new Date(formatDate($("#insurance_end_date").val()));

                    // Calculate the difference in milliseconds
                    var diff = Math.abs(end - start);

                    // Calculate days
                    var days = Math.floor(diff / (1000 * 60 * 60 * 24));

                    // Calculate months
                    var months = Math.floor(diff / (1000 * 60 * 60 * 24 * 30.436875));

                    // Display result
                    $("#insurance_duration_months").text(months + " เดือน");
                    $("#insurance_duration_days").text(days + " วัน");
                });
            });
        </script> -->

        <script>
            $(function() {
                if (typeof jQuery == 'undefined' || typeof jQuery.ui == 'undefined') {
                    alert("jQuery or jQuery UI is not loaded");
                    return;
                }

                var d = new Date();
                var toDay = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 543);

                $("#contract_sign_date,#contract_start_date, #contract_end_date, #insurance_start_date, #insurance_end_date,#contract_er_start_date,#contract_po_start_date")
                    .datepicker({
                        dateFormat: 'dd/mm/yy',
                        isBuddhist: true,
                        defaultDate: toDay,
                        dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
                        dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
                        monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม',
                            'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
                        ],
                        monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.',
                            'ต.ค.', 'พ.ย.', 'ธ.ค.'
                        ],

                        onSelect: calculateDuration
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
