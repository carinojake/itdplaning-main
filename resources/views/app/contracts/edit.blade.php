<x-app-layout>
  <x-slot:content>
    <div class="container-fluid">
        {{ Breadcrumbs::render('contract.edit',$contract) }}
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
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
            <x-card title="{{ __('แก้ไขสัญญา') }}">
              <form method="POST" action="{{ route('contract.update', $contract->hashid) }}"
                class="row needs-validation"
                novalidate >
                @csrf
                {{ method_field('PUT') }}

                <div class="container mt-3">
                    <div class="row">
                      <!-- ปีงบประมาณ -->
                      <div class="col-md-4 mb-3">
                        <label for="contract_fiscal_year" class="form-label">{{ __('ปีงบประมาณ') }}</label> <span class="text-danger">*</span>
                        <input type="text" class="form-control" id="contract_fiscal_year" name="contract_fiscal_year" value="{{ $contract->contract_fiscal_year }}" readonly>
                        <div class="invalid-feedback">
                          {{ __('ปีงบประมาณ') }}
                        </div>
                      </div>

                      <!-- สถานะสัญญา -->
                      <div class="col-md-4 mb-3">
                        <label for="contract_status" class="form-label">{{ __('สถานะสัญญา') }}</label> <span class="text-danger">*</span>
                        <div >
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="contract_status" id="contract_status1" value="1" @checked($contract->contract_status == 1)>
                            <label class="form-check-label" for="contract_status1">
                              อยู่ในระหว่างดำเนินการ
                            </label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="contract_status" id="contract_status2" value="2" @checked($contract->contract_status == 2)>
                            <label class="form-check-label" for="contract_status2">
                              ดำเนินการแล้วเสร็จ
                            </label>
                          </div>
                        </div>
                        <div class="invalid-feedback">
                          {{ __('สถานะสัญญา') }}
                        </div>
                      </div>

                      <!-- ประเภทงาน/โครงการ -->
                      <div class="col-md-4 mb-3">
                        <label for="contract_project_type" class="form-label">{{ __('ประเภทงาน/โครงการ') }}</label> <span class="text-danger">*</span>
                        <div >
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="contract_project_type" id="contract_project_type1" value="p" @checked($contract->contract_project_type == "p")>
                            <label class="form-check-label" for="contract_project_type1">
                              งานประจำ
                            </label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="contract_project_type" id="contract_project_type2" value="j" @checked($contract->contract_project_type == "j")>
                            <label class="form-check-label" for="contract_project_type2">
                              โครงการ
                            </label>
                          </div>
                        </div>
                        <div class="invalid-feedback">
                          {{ __('ประเภทงาน/โครงการ') }}
                        </div>
                      </div>
                    </div>
                  </div>

            <div class="row">
                <div class="col-md-2">
                    <label for="contract_number" class="form-label">{{ __('เลขที่สัญญา') }}</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" id="contract_number" name="contract_number" value="{{ $contract->contract_number }}" required>
                    <div class="invalid-feedback">
                      {{ __('เลขที่สัญญา ซ้ำ') }}
                    </div>
                  </div>
                <div class="col-md-10">
                    <label for="contract_name" class="form-label">{{ __('ชื่อสัญญา') }}</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" id="contract_name" name="contract_name" value="{{ $contract->contract_name }}" required autofocus>
                    <div class="invalid-feedback">
                      {{ __('ชื่อสัญญา ซ้ำ') }}
                    </div>
                  </div>

            </div>
         {{--    <div class="row mt-3">
                <div class="col-md-3">
                    <label for="contract_pr" class="form-label">{{ __('เลขที่ PR') }}</label>
                    <span class="text-danger"></span>

                    <input type="text" class="form-control"
                     id="contract_pr" name="contract_pr" value="{{ $contract->contract_pr }}" required>
                    <div class="invalid-feedback">
                      {{ __('เลขที่ PR ซ้ำ') }}
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label for="contract_pr_budget" class="form-label">{{ __('จำนวนเงิน PR') }}</label> <span class="text-danger">*</span>
                    <input type="text" placeholder="0.00"
                    step="0.01"   data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                    class="form-control numeral-mask" id="contract_pr_budget"
                    name="contract_pr_budget" min="0"
                    value="{{ $contract->contract_pr_budget }}" onchange="calculateRefund()">
                  </div>

                  <div class="col-md-3">
                    <label for="contract_pa" class="form-label">{{ __('เลขที่ PA') }}</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" id="contract_pa" name="contract_pa" value="{{ $contract->contract_pa }}" required>
                    <div class="invalid-feedback">
                      {{ __('เลขที่สัญญา ซ้ำ') }}
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="contract_pa_budget" class="form-label">{{ __('จำนวนเงิน PA') }}</label> <span class="text-danger">*</span>
                    <input type="text" placeholder="0.00"
                    step="0.01"   data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                    class="form-control numeral-mask"
                     id="contract_pa_budget" name="contract_pa_budget"
                     min="0" value="{{ $contract->contract_pa_budget }}" onchange="calculateRefund()">
                  </div>

            </div> --}}



                <div class="col-md-12">
                  <label for="contract_description" class="form-label">{{ __('รายละเอียดสัญญา') }}</label>
                  <textarea class="form-control" name="contract_description" id="contract_description" rows="10">{{ $contract->contract_description }}</textarea>
                  <div class="invalid-feedback">
                    {{ __('รายละเอียดงาน/โครงการ') }}
                  </div>
                </div>

                <div class="col-md-6 mt-3">
                  <label for="contract_start_date" class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span class="text-danger">*</span>

                <input type="text" class="form-control"
                id="contract_start_date"
                name="contract_start_date"
             value="{{ \Helper::date4(date('Y-m-d H:i:s', $contract->contract_start_date)) }}">
                </div>
                <div class="col-md-6 mt-3">
                  <label for="contract_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span class="text-danger">*</span>
                  {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
              {{--     <div data-coreui-toggle="date-picker"
                   data-coreui-locale="th-th"id="contract_end_date"
                   data-coreui-format="dd/MM/yyyy"
                    data-coreui-date="{{ date('m/d/Y', $contract->contract_end_date) }}">
                </div> --}}
                <input type="text" class="form-control"
                id="contract_end_date"
                name="contract_end_date"
                                    value="{{ \Helper::date4(date('Y-m-d H:i:s', $contract->contract_end_date)) }}">
                </div>
                <div class="col-md-6 mt-3">
                  <label for="contract_sign_date" class="form-label">{{ __('วันที่ลงนามสัญญา') }}</label>
                  {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
       {{--            <div data-coreui-toggle="date-picker"
                   data-coreui-locale="th-th" id="contract_sign_date"
                    data-coreui-format="dd/MM/yyyy"
                    data-coreui-date="{{ $contract->contract_sign_date ? date('m/d/Y', $contract->contract_sign_date) : '' }}"></div> --}}
                    <input  type="text" class="form-control"
                    id="contract_sign_date"
                    name="contract_sign_date"
                    value="{{ \Helper::date4(date('Y-m-d H:i:s', $contract->contract_sign_date)) }}">

                </div>
                <div class="col-md-3 mt-3">
                    <label for="contract_juristic_id" class="form-label">{{ __('เลขทะเบียนคู่ค้า') }}</label>
                    <input type="text" class="form-control" id="contract_juristic_id" name="contract_juristic_id" value="{{ $contract->contract_juristic_id }}" maxlength="13" >
                    <div class="invalid-feedback">
                      {{ __('คู่ค้าซ้ำ') }}
                    </div>
                  </div>
                  <div class="col-md-3 mt-3">
                    <label for="contract_order_no" class="form-label">{{ __('เลขที่ใบสั่งซื้อ') }}</label>
                    <input type="text" class="form-control" id="contract_order_no" name="contract_order_no" value="{{ $contract->contract_order_no }}" maxlength="50" >
                    <div class="invalid-feedback">
                      {{ __('เลขที่ใบสั่งซื้อ') }}
                    </div>
                  </div>
                <div class="col-md-12 mt-3">
                  <label for="contract_type" class="form-label">{{ __('ประเภทสัญญา') }}</label> <span class="text-danger">*</span>
                  {{ Form::select('contract_type', \Helper::contractType(), $contract->contract_type, ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...']) }}
                  <div class="invalid-feedback">
                    {{ __('สัญญา') }}
                  </div>
                </div>
                <div class="col-md-12 mt-3">
                  <label for="contract_acquisition" class="form-label">{{ __('ประเภทการได้มาของสัญญา') }}</label>
                  {{ Form::select('contract_acquisition', \Helper::contractAcquisition(), $contract->contract_acquisition, ['class' => 'form-control', 'placeholder' => 'เลือกประเภทการได้มาของสัญญา...']) }}
                  <div class="invalid-feedback">
                    {{ __('สัญญา') }}
                  </div>
                </div>
                <div class="col-md-12 mt-3">
                    <label for="contract_projectplan" class="form-label">{{ __('บันทึกข้อความ') }}</label>
                    <input type="text" class="form-control" id="contract_projectplan" name="contract_projectplan" maxlength="50" value="{{ $contract->contract_projectplan }}" >

                    <div class="invalid-feedback">
                      {{ __('บันทึกข้อความ') }}
                    </div>
                  </div>

                  <div class="col-md-4 mt-3">
                    <label for="contract_mm" class="form-label">{{ __('เลขที่ mm') }}</label>
                    <span class="text-danger"></span>
                    {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                    <input type="text" class="form-control"
                     id="contract_mm" name="contract_mm" value="{{ $contract->contract_mm }}"  readonly>
                    <div class="invalid-feedback">
                      {{ __('เลขที่ mm') }}
                    </div>
                  </div>

                  <div class="col-md-4 mt-3">
                    <label for="contract_pr" class="form-label">{{ __('เลขที่ PR') }}</label>
                    <span class="text-danger"></span>
                    {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                    <input type="text" class="form-control"
                     id="contract_pr" name="contract_pr" value="{{ $contract->contract_pr }}" >
                    <div class="invalid-feedback">
                      {{ __('เลขที่สัญญา ซ้ำ') }}
                    </div>
                  </div>

                  <div class="col-md-4 mt-3">
                    <label for="contract_pa" class="form-label">{{ __('เลขที่ PA') }}</label> <span class="text-danger">*</span>
                    {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                    <input type="text" class="form-control" id="contract_pa" name="contract_pa" value="{{ $contract->contract_pa }}" required>
                    <div class="invalid-feedback">
                      {{ __('เลขที่สัญญา ซ้ำ') }}
                    </div>
                  </div>

                  <div class="col-md-4 mt-3">
                    <label for="contract_mm_budget" class="form-label">{{ __('จำนวนเงิน mm') }}</label> <span class="text-danger">*</span>
                    <input type="text" placeholder="0.00"
                    step="0.01"   data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                    class="form-control numeral-mask" id="contract_mm_budget"
                    name="contract_mm_budget" min="0"
                    value="{{ $contract->contract_mm_budget }}"  readonly >
                  </div>


                  <div class="col-md-4 mt-3">
                    <label for="contract_pr_budget" class="form-label">{{ __('จำนวนเงิน PR') }}</label> <span class="text-danger">*</span>
                    <input type="text" placeholder="0.00"
                    step="0.01"   data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                    class="form-control numeral-mask" id="contract_pr_budget"
                    name="contract_pr_budget" min="0"
                    value="{{ $contract->contract_pr_budget }}" onchange="calculateRefund()">
                  </div>

                  <div class="col-md-4 mt-3">
                    <label for="contract_pa_budget" class="form-label">{{ __('จำนวนเงิน PA') }}</label> <span class="text-danger">*</span>
                    <input type="text" placeholder="0.00"
                    step="0.01"   data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                    class="form-control numeral-mask"
                     id="contract_pa_budget" name="contract_pa_budget"
                     min="0" value="{{ $contract->contract_pa_budget }}" onchange="calculateRefund()">
                  </div>


                  <div class="col-md-6 mt-3">
                    <label for="contract_refund_pa_budget" class="form-label">{{ __('จำนวนคงเหลือหลังเงิน PA') }}</label> <span class="text-danger"></span>
                    <input type="text" placeholder="0.00"
                    step="0.01"   data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                    class="form-control numeral-mask"


                    id="contract_refund_pa_budget" name="contract_refund_pa_budget" min="0" value="{{ $contract->contract_refund_pa_budget }}" readonly>
                  </div>

                  <div class="col-md-6 mt-3">
                    <label for="contract_peryear_pa_budget" class="form-label">{{ __('ต่อปี') }}</label> <span class="text-danger"></span>
                    <input type="text" placeholder="0.00" step="0.01"
                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                    class="form-control numeral-mask"

                     id="contract_peryear_pa_budget" name="contract_peryear_pa_budget" min="0" value="{{ $contract->contract_refund_pa_budget }}" readonly>
                  </div>




                  <div class="col-md-4 mt-3">
                    <label for="contract_cn" class="form-label">{{ __('เลขที่ cn') }}</label>
                    {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> <span class="text-danger">*</span> --}}
                    <input type="text" class="form-control" id="contract_cn" name="contract_cn" value="{{ $contract->contract_cn }}" >
                    <div class="invalid-feedback">
                      {{ __('เลขที่สัญญา ซ้ำ') }}
                    </div>
                  </div>


                  <div class="col-md-4 mt-3">
                    <label for="contract_cn_budget"
                        class="form-label">{{ __('จำนวนเงิน (บาท) cn') }}</label>
                    <span class="text-danger"></span>

                    <input type="text"
                        placeholder="0.00" step="0.01"
                        class="form-control"
                        id="contract_cn_budget"
                         data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                        class="form-control numeral-mask"
                        name="contract_cn_budget"
                        min="0"
                        value="{{ $contract->contract_cn_budget }}"

                        >
                </div>


            </div>
        </div>
         {{--          <div class="col-md-6">
                    <label for="contract_owner" class="form-label">{{ __('เจ้าหน้าที่ผู้รับผิดชอบ ') }}</label> --}}
                    {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                    {{-- <input type="text" class="form-control" id="contract_owner" name="contract_owner" maxlength="50" value="{{ $contract->contract_owner }}">
                  </div> --}}
                  @if(auth()->user()->isAdmin())
                <div class="col-md-12">
                    <label for="contract_refund_pa_status" class="form-label">{{ __('contract_refund_pa_status') }}</label> <span class="text-danger"></span>
                    <div class="form-check form-check-inline ms-5">
                      <input class="form-check-input" type="radio" name="contract_refund_pa_status" id="contract_refund_pa_status" value="1" checked>
                      <label class="form-check-label" for="1">
                        ไม่ได้คืน
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="contract_refund_pa_status" id="contract_refund_pa_status" value="2">
                      <label class="form-check-label" for="contract_refund_pa_status2">
                      คืน
                      </label>
                    </div>
                </div>
                @endif
                <x-button class="btn-success" type="submit">{{ __('coreuiforms.save') }}</x-button>
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
            $("#contract_pr_budget").on("input", function() {
              //  var contract_mm_budget = parseFloat($("#contract_mm_budget").val().replace(/,/g, ""));
                var contract_pr_budget = parseFloat($("#contract_pr_budget").val().replace(/,/g, ""));
                var contract_pa_budget = parseFloat($("#contract_pa_budget").val().replace(/,/g, ""));


                var contract_cn_budget = parseFloat($("#contract_cn_budget").val().replace(/,/g, ""));
              //  var contract_mm_budget = parseFloat($("#contract_mm_budget").val().replace(/,/g, ""));
              var contract_mm_budget = {{$contract->contract_mm_budget}} ;
              console.log(contract_mm_budget);

                var current = parseFloat($(this).val().replace(/,/g, ""));
                if (contract_pr_budget < contract_pa_budget  ) {
//$("#contract_pr_budget").val('0'); // Set the value of the input field
$("#contract_pa_budget").val(''); // Set the value of the input field
}   else if (contract_pr_budget < -0  ) {
$("#contract_pr_budget").val(''); // Set the value of the input field

};

                if (current > contract_mm_budget) {
                    Swal.fire({
                        title: "เกิดข้อผิดพลาด",
                        text: "วงเงิน (บาท) MM จำนวนเงินที่ใส่ต้องไม่เกิน " + contract_mm_budget
                            .toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }) + " บาท",
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "ตกลง"
                    });
                    /*  $(this).val(contract_mm_budget.toFixed(2)); */
                    $(this).val(0);
                }
            });
        });
    </script>

<script>
    $(document).ready(function() {
        $("#contract_pa_budget").on("input", function() {
            var contract_pr_budget = parseFloat($("#contract_pr_budget").val().replace(/,/g, ""));
            var contract_pa_budget = parseFloat($("#contract_pa_budget").val().replace(/,/g, ""));

            var current = parseFloat($(this).val().replace(/,/g, ""));


            if (contract_pa_budget > contract_pr_budget ) {
//$("#contract_pr_budget").val('0'); // Set the value of the input field
$("#contract_pr_budget").val(''); // Set the value of the input field
}
        else if (contract_pa_budget < -0  ) {

$("#contract_pa_budget").val(''); // Set the value of the input field
        }
            if (current > contract_pr_budget || contract_pr_budget === "") {
                Swal.fire({
                    title: "เกิดข้อผิดพลาด",
                    text: "วงเงิน (บาท) PR จำนวนเงินที่ใส่ต้องไม่เกิน " + contract_pr_budget
                        .toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }) + " บาท",
                    icon: "error",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "ตกลง"
                });
                /*  $(this).val(contract_mm_budget.toFixed(2)); */
                $(this).val(0);
            }
        });
    });
</script>



<script>
    $(document).ready(function() {
        $("#contract_cn_budget").on("input", function() {
            var contract_pa_budget = parseFloat($("#contract_pa_budget").val().replace(/,/g, ""));

            var contract_cn_budget = parseFloat($("#contract_cn_budget").val().replace(/,/g, ""));
            var current = parseFloat($(this).val().replace(/,/g, ""));

            if (contract_cn_budget < -0) {

$("#contract_cn_budget").val(''); // Set the value of the input field
}



            if (current > contract_pa_budget) {
                Swal.fire({
                    title: "เกิดข้อผิดพลาด",
                    text: "วงเงิน (บาท) PA จำนวนเงินที่ใส่ต้องไม่เกิน" + contract_pa_budget
                        .toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }) + " บาท",
                    icon: "error",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "ตกลง"
                });
                /*                 $(this).val(contract_pa_budget.toFixed(2)); */
                $(this).val(0);
            }
        });
    });
</script>





<script>
    $(document).ready(function() {
        var isReadOnly = {{ $taskcons && $taskcons->taskcon_pay > 1 ? 'true' : 'false' }};

        if (isReadOnly) {
            // If the condition is true, set the fields to readonly or disabled
            $('input, select, textarea').prop('readonly', true);
           // $('select').prop('disabled', true); // Use 'disabled' for select elements
            //$('input[type=radio], input[type=checkbox]').prop('disabled', true); // Use 'disabled' for radio and checkbox inputs
        }
    });
</script>


<script>
    $(function() {
        if (typeof jQuery == 'undefined' || typeof jQuery.ui == 'undefined') {
            alert("jQuery or jQuery UI is not loaded");
            return;
        }

        //   var d = new Date();
        // var toDay = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 543);

        $("#contract_sign_date,#contract_start_date, #contract_end_date,#contract_er_start_date,#contract_po_start_date,#insurance_start_date, #insurance_end_date")
            .datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                language: "th-th",
                /*     defaultDate: toDay,
                     dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
                     dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
                     monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม',
                         'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
                     ],
                     monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.',
                         'ต.ค.', 'พ.ย.', 'ธ.ค.'
                     ], */


            });

var contract_fiscal_year = {{$contract->contract_fiscal_year}};
contract_fiscal_year =  contract_fiscal_year -543;
console.log( contract_fiscal_year);

var fiscalYearStartDate = new Date( contract_fiscal_year - 1, 9, 1); // 1st October of the previous year
var fiscalYearEndDate = new Date( contract_fiscal_year, 8, 30); // 30th September of the fiscal year

console.log(fiscalYearStartDate);
console.log(fiscalYearEndDate);


// Set the start and end dates for the project_start_date datepicker
$("#contract_start_date").datepicker("setStartDate", fiscalYearStartDate);
//  $("#project_start_date").datepicker("setEndDate", fiscalYearEndDate);

// Set the start and end dates for the project_end_date datepicker
$("#contract_end_date").datepicker("setStartDate", fiscalYearStartDate);
//$("#contract_end_date").datepicker("setEndDate", fiscalYearEndDate);
//$("#contract_sign_date").datepicker("setStartDate", new Date(fiscalYearStartDate.getFullYear() - 1, fiscalYearStartDate.getMonth(), fiscalYearStartDate.getDate()));



        $('#contract_start_date').on('changeDate', function() {
            var startDate = $(this).datepicker('getDate');
            $("#contract_end_date").datepicker("setStartDate", startDate);
            $("#insurance_end_date").datepicker("setStartDate", startDate);
            $("#contract_sign_date").datepicker("setStartDate", new Date(startDate.getFullYear(), startDate.getMonth()-2, startDate.getDate()));
            //  $("#contract_sign_date").datepicker("setStartDate", startDate);
        });

        $('#contract_end_date').on('changeDate', function() {
            var endDate = $(this).datepicker('getDate');
            $("#contract_start_date").datepicker("setEndDate", endDate);
            $("#insurance_start_date").datepicker("setEndDate", endDate);


        });
    });
</script>

<script>
    /*    function calculateDuration() {
            var startDate = $('#insurance_start_date').datepicker('getDate');
            var endDate = $('#insurance_end_date').datepicker('getDate');
            if (startDate && endDate) {
                var diff = Math.abs(endDate - startDate);
                var days = Math.floor(diff / (1000 * 60 * 60 * 24));
                var months = Math.floor(diff / (1000 * 60 * 60 * 24 * 30.436875));
                $('#insurance_duration_months').text(months + " เดือน");
                $('#insurance_duration_days').text(days + " วัน");
            }
        } */

    $(document).ready(function() {
        $('#insurance_start_date, #insurance_end_date').datepicker({

            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            language: "th-th",

        });
        var contract_fiscal_year = {{$contract->contract_fiscal_year}};
contract_fiscal_year =  contract_fiscal_year -543;
console.log( contract_fiscal_year);

var fiscalYearStartDate = new Date( contract_fiscal_year - 1, 9, 1); // 1st October of the previous year
var fiscalYearEndDate = new Date( contract_fiscal_year, 8, 30); // 30th September of the fiscal year

console.log(fiscalYearStartDate);
console.log(fiscalYearEndDate);

// Set the start and end dates for the project_start_date datepicker
$("#insurance_start_date").datepicker("setStartDate", fiscalYearStartDate);
//  $("#project_start_date").datepicker("setEndDate", fiscalYearEndDate);

// Set the start and end dates for the project_end_date datepicker
$("#insurance_end_date").datepicker("setStartDate", fiscalYearStartDate);
$("#insurance_end_date").datepicker("setEndDate", fiscalYearEndDate);




    });

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

    function grandTotal() {
        calculateDuration();
        var days = $("#insurance_start_date").val();
        var rooms = $("#insurance_end_date").val();

        if (days != "" && parseInt(days) > 0) {
            if (rooms != "") {
                var total = parseInt(days) * parseInt(rooms) * roomPrice;
                $("#grandtotal").val(total.toFixed(2)).css("color", "black");
            } else {
                $("#grandtotal").val("").css("color", "black");
            }
        }
    }

    $("#insurance_start_date, #insurance_end_date").on("change", function() {
        grandTotal();
        $(".datepicker").hide();
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
        $(document).ready(function() {
            $(":input").inputmask();
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


<script>
    var costFields = ['contract_pa_budget', 'task_cost_it_investment', 'task_cost_gov_utility'];
    var budgetFields = ['contract_pr_budget', 'task_budget_it_investment', 'task_budget_gov_utility'];

    function calculateRefund() {
        var totalRefund = 0;

        costFields.forEach(function(costField, index) {
            var pa_value = $("#" + costField).val();
            var pr_value = $("#" + budgetFields[index]).val();

            if (pa_value && pr_value) {
                var pa_budget = parseFloat(pa_value.replace(/,/g, "")) || 0;
                var pr_budget = parseFloat(pr_value.replace(/,/g, "")) || 0;

                if (pa_budget != 0) {
                    var refund = pr_budget - pa_budget;
                    totalRefund += refund;
                }
            }
        });

        $("#contract_refund_pa_budget").val(totalRefund.toFixed(2));
    }

    $(document).ready(function() {
        costFields.forEach(function(costField, index) {
            $("#" + costField).on("input", calculateRefund);
        });
    });
</script>


{{--
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        var contract_Status = {!! json_encode($contract_Status->contract_Status) !!}; // รับค่าจาก Laravel ไปยัง JavaScript
        if (contract_Status == 2) {
            var formInputs = document.querySelectorAll(
                '#pay_form input, #mm_form textarea, #mm_form select,#budget_form input'
                ); // เลือกทั้งหมด input, textarea, และ select ภายใน #mm_form
            formInputs.forEach(function(input) {
                input.setAttribute('readonly', true); // ตั้งค่าแอตทริบิวต์ readonly
            });
        }
    });
</script> --}}




  </x-slot:javascript>
</x-app-layout>



