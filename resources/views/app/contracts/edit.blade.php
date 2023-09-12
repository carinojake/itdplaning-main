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
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <x-card title="{{ __('แก้ไขสัญญา') }}">
              <form method="POST" action="{{ route('contract.update', $contract->hashid) }}" class="row g-3">
                @csrf
                {{ method_field('PUT') }}
                {{-- <div class="col-md-12">
                  <label for="contract_type" class="form-label">{{ __('ประเภทงาน/โครงการ') }}</label> <span class="text-danger">*</span>
                  <div class="form-check form-check-inline ms-5">
                    <input class="form-check-input" type="radio" name="contract_type" id="contract_type1" value="J" checked>
                    <label class="form-check-label" for="contract_type1">
                      งานประจำ
                    </label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="contract_type" id="contract_type2" value="P">
                    <label class="form-check-label" for="contract_type2">
                      โครงการ
                    </label>
                  </div>
                  <div class="invalid-feedback">
                    {{ __('ประเภทงาน/โครงการ') }}
                  </div>
                </div> --}}
                <div class="col-md-12">
                  <label for="contract_name" class="form-label">{{ __('ชื่อสัญญา') }}</label> <span class="text-danger">*</span>
                  <input type="text" class="form-control" id="contract_name" name="contract_name" value="{{ $contract->contract_name }}" required autofocus>
                  <div class="invalid-feedback">
                    {{ __('ชื่อสัญญา ซ้ำ') }}
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="contract_status" class="form-label">{{ __('สถานะสัญญา') }}</label> <span class="text-danger">*</span>
                  <div class="form-check form-check-inline ms-5">
                    <input class="form-check-input" type="radio" name="contract_status" id="contract_status1" value="1" checked>
                    <label class="form-check-label" for="contract_status1">
                      อยู่ในระหว่างดำเนินการ
                    </label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="contract_status" id="contract_status2" value="2">
                    <label class="form-check-label" for="contract_status2">
                      ดำเนินการแล้วเสร็จ
                    </label>
                  </div>
                  <div class="invalid-feedback">
                    {{ __('สถานะสัญญา') }}
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="contract_number" class="form-label">{{ __('เลขที่สัญญา') }}</label> <span class="text-danger">*</span>
                  <input type="text" class="form-control" id="contract_number" name="contract_number" value="{{ $contract->contract_number }}" required>
                  <div class="invalid-feedback">
                    {{ __('เลขที่สัญญา ซ้ำ') }}
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="contract_juristic_id" class="form-label">{{ __('เลขทะเบียนคู่ค้า') }}</label>
                  <input type="text" class="form-control" id="contract_juristic_id" name="contract_juristic_id" value="{{ $contract->contract_juristic_id }}" maxlength="13" >
                  <div class="invalid-feedback">
                    {{ __('คู่ค้าซ้ำ') }}
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="contract_order_no" class="form-label">{{ __('เลขที่ใบสั่งซื้อ') }}</label>
                  <input type="text" class="form-control" id="contract_order_no" name="contract_order_no" value="{{ $contract->contract_order_no }}" maxlength="50" >
                  <div class="invalid-feedback">
                    {{ __('เลขที่ใบสั่งซื้อ') }}
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="contract_description" class="form-label">{{ __('รายละเอียดสัญญา') }}</label>
                  <textarea class="form-control" name="contract_description" id="contract_description" rows="10">{{ $contract->contract_description }}</textarea>
                  <div class="invalid-feedback">
                    {{ __('รายละเอียดงาน/โครงการ') }}
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="contract_fiscal_year" class="form-label">{{ __('ปีงบประมาณ') }}</label> <span class="text-danger">*</span>
                  <input type="text" class="form-control" id="contract_fiscal_year" name="contract_fiscal_year" value="{{ $contract->contract_fiscal_year }}" required>
                  <div class="invalid-feedback">
                    {{ __('ชื่องาน/โครงการ ซ้ำ') }}
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="contract_start_date" class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span class="text-danger">*</span>
                  {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                 {{--  <div data-coreui-toggle="date-picker" data-coreui-locale="th-th"
                  id="contract_start_date" data-coreui-format="dd/MM/yyyy"
                  data-coreui-date="{{ date('m/d/Y', $contract->contract_start_date) }}">
                </div> --}}
                <input class="form-control" id="contract_start_date" name="contract_start_date"
                                    value="{{ \Helper::date4(date('Y-m-d H:i:s', $contract->contract_start_date)) }}">
                </div>
                <div class="col-md-6">
                  <label for="contract_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span class="text-danger">*</span>
                  {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
              {{--     <div data-coreui-toggle="date-picker"
                   data-coreui-locale="th-th"id="contract_end_date"
                   data-coreui-format="dd/MM/yyyy"
                    data-coreui-date="{{ date('m/d/Y', $contract->contract_end_date) }}">
                </div> --}}
                <input class="form-control" id="contract_end_date" name="contract_end_date"
                                    value="{{ \Helper::date4(date('Y-m-d H:i:s', $contract->contract_end_date)) }}">
                </div>
                <div class="col-md-6">
                  <label for="contract_sign_date" class="form-label">{{ __('วันที่ลงนามสัญญา') }}</label>
                  {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
       {{--            <div data-coreui-toggle="date-picker"
                   data-coreui-locale="th-th" id="contract_sign_date"
                    data-coreui-format="dd/MM/yyyy"
                    data-coreui-date="{{ $contract->contract_sign_date ? date('m/d/Y', $contract->contract_sign_date) : '' }}"></div> --}}
                    <input class="form-control" id="contract_sign_date" name="contract_sign_date"
                    value="{{ \Helper::date4(date('Y-m-d H:i:s', $contract->contract_sign_date)) }}">

                </div>

                <div class="col-md-12">
                  <label for="contract_type" class="form-label">{{ __('ประเภทสัญญา') }}</label> <span class="text-danger">*</span>
                  {{ Form::select('contract_type', \Helper::contractType(), $contract->contract_type, ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...']) }}
                  <div class="invalid-feedback">
                    {{ __('สัญญา') }}
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="contract_acquisition" class="form-label">{{ __('ประเภทการได้มาของสัญญา') }}</label>
                  {{ Form::select('contract_acquisition', \Helper::contractAcquisition(), $contract->contract_acquisition, ['class' => 'form-control', 'placeholder' => 'เลือกประเภทการได้มาของสัญญา...']) }}
                  <div class="invalid-feedback">
                    {{ __('สัญญา') }}
                  </div>
                </div>





                <div class="col-md-12">
                    <label for="contract_projectplan" class="form-label">{{ __('บันทึกข้อความ') }}</label>
                    <input type="text" class="form-control" id="contract_projectplan" name="contract_projectplan" maxlength="50" value="{{ $contract->contract_projectplan }}" >

                    <div class="invalid-feedback">
                      {{ __('บันทึกข้อความ') }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="contract_pr" class="form-label">{{ __('เลขที่ PR') }}</label> <span class="text-danger">*</span>
                    {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                    <input type="text" class="form-control" id="contract_pr" name="contract_pr" value="{{ $contract->contract_pr }}"required>
                    <div class="invalid-feedback">
                      {{ __('เลขที่สัญญา ซ้ำ') }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="contract_pa" class="form-label">{{ __('เลขที่ PA') }}</label> <span class="text-danger">*</span>
                    {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                    <input type="text" class="form-control" id="contract_pa" name="contract_pa" value="{{ $contract->contract_pa }}"required>
                    <div class="invalid-feedback">
                      {{ __('เลขที่สัญญา ซ้ำ') }}
                    </div>
                  </div>











                  <div class="col-md-6">
                    <label for="contract_pr_budget" class="form-label">{{ __('จำนวนเงิน PR') }}</label> <span class="text-danger">*</span>



                    <input type="text" placeholder="0.00"
                    step="0.01"  data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                    class="form-control numeral-mask" id="contract_pr_budget"
                    name="contract_pr_budget" min="0"
                    value="{{ $contract->contract_pr_budget }}" onchange="calculateRefund()">
                  </div>
                  <div class="col-md-6">
                    <label for="contract_pa_budget" class="form-label">{{ __('จำนวนเงิน PA') }}</label> <span class="text-danger">*</span>
                    <input type="text" placeholder="0.00"
                    step="0.01"  data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                    class="form-control numeral-mask"
                     id="contract_pa_budget" name="contract_pa_budget"
                     min="0" value="{{ $contract->contract_pa_budget }}" onchange="calculateRefund()">
                  </div>
                  <div class="col-md-6">
                    <label for="contract_refund_pa_budget" class="form-label">{{ __('จำนวนคงเหลือหลังเงิน PA') }}</label> <span class="text-danger"></span>
                    <input type="text" placeholder="0.00"
                    step="0.01"  data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                    class="form-control numeral-mask"


                    id="contract_refund_pa_budget" name="contract_refund_pa_budget" min="0" value="{{ $contract->contract_refund_pa_budget }}" readonly>
                  </div>

                  <div class="col-md-6">
                    <label for="contract_peryear_pa_budget" class="form-label">{{ __('ต่อปี') }}</label> <span class="text-danger"></span>
                    <input type="text" placeholder="0.00" step="0.01"
                    data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                    class="form-control numeral-mask"

                     id="contract_peryear_pa_budget" name="contract_peryear_pa_budget" min="0" value="{{ $contract->contract_refund_pa_budget }}">
                  </div>

                  <div class="col-md-4">
                    <label for="contract_cn_budget"
                        class="form-label">{{ __('จำนวนเงิน (บาท) cn') }}</label>
                    <span class="text-danger"></span>

                    <input type="text"
                        placeholder="0.00" step="0.01"
                        class="form-control"
                        id="contract_cn_budget"
                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
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
              {{--     <div class="col-md-12">
                    <label for="contract_refund_pa_status" class="form-label">{{ __('contract_refund_pa_status') }}</label> <span class="text-danger"></span>
                    <div class="form-check form-check-inline ms-5">
                      <input class="form-check-input" type="radio" name="contract_refund_pa_status" id="contract_refund_pa_status" value="1" checked>
                      <label class="form-check-label" for="1">
                        คืน
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="contract_refund_pa_status" id="contract_refund_pa_status" value="2">
                      <label class="form-check-label" for="contract_refund_pa_status2">
                        ไม่ได้คืน
                      </label>
                    </div>
                </div> --}}

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js"></script>
   {{--  <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script> --}}
    <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>


    <script>
        $(document).ready(function() {
            $(":input").inputmask();
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

<script>
    $(function() {
/*         if (typeof jQuery == 'undefined' || typeof jQuery.ui == 'undefined') {
            alert("jQuery or jQuery UI is not loaded");
            return;
        }

        var d = new Date();
        var toDay = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 543); */

        $("#contract_sign_date,#contract_start_date, #contract_end_date, #insurance_start_date,#insurance_end_date,#contract_er_start_date,#contract_po_start_date")
            .datepicker({
                dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            language:"th-th",

                //onSelect: calculateDuration
            });
    });
</script>
  </x-slot:javascript>
</x-app-layout>



