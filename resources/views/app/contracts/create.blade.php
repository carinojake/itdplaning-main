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
            <x-card title="{{ __('เพิ่มสัญญา') }}">
              <form method="POST" action="{{ route('contract.store') }}" class="row g-3">
                @csrf
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
                  <input type="text" class="form-control" id="contract_name" name="contract_name" required autofocus>
                  <div class="invalid-feedback">
                    {{ __('ชื่อสัญญา ซ้ำ') }}
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="contract_number" class="form-label">{{ __('เลขที่สัญญา') }}</label> <span class="text-danger">*</span>
                  <input type="text" class="form-control" id="contract_number" name="contract_number" required>
                  <div class="invalid-feedback">
                    {{ __('เลขที่สัญญา ซ้ำ') }}
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="contract_juristic_id" class="form-label">{{ __('เลขทะเบียนคู่ค้า') }}</label> <span class="text-danger">*</span>
                  <input type="text" class="form-control" id="contract_juristic_id" name="contract_juristic_id" maxlength="13" required>
                  <div class="invalid-feedback">
                    {{ __('คู่ค้าซ้ำ') }}
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="contract_order_no" class="form-label">{{ __('เลขที่ใบสั่งซื้อ') }}</label> <span class="text-danger">*</span>
                  <input type="text" class="form-control" id="contract_order_no" name="contract_order_no" maxlength="50" required>
                  <div class="invalid-feedback">
                    {{ __('เลขที่ใบสั่งซื้อ') }}
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="contract_description" class="form-label">{{ __('รายละเอียดสัญญา') }}</label>
                  <textarea class="form-control" name="contract_description" id="contract_description" rows="10"></textarea>
                  <div class="invalid-feedback">
                    {{ __('รายละเอียดงาน/โครงการ') }}
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="contract_fiscal_year" class="form-label">{{ __('ปีงบประมาณ') }}</label> <span class="text-danger">*</span>
                  <input type="text" class="form-control" id="contract_fiscal_year" name="contract_fiscal_year" required>
                  <div class="invalid-feedback">
                    {{ __('ชื่องาน/โครงการ ซ้ำ') }}
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="contract_start_date" class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span class="text-danger">*</span>
                  {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                  <div data-coreui-toggle="date-picker" id="contract_start_date" data-coreui-format="dd/MM/yyyy"></div>
                </div>
                <div class="col-md-6">
                  <label for="contract_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span class="text-danger">*</span>
                  {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                  <div data-coreui-toggle="date-picker" id="contract_end_date" data-coreui-format="dd/MM/yyyy"></div>
                </div>
                <div class="col-md-6">
                  <label for="contract_sign_date" class="form-label">{{ __('วันที่ลงนามสัญญา') }}</label>
                  {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                  <div data-coreui-toggle="date-picker" id="contract_sign_date" data-coreui-format="dd/MM/yyyy"></div>
                </div>

                <div class="col-md-12">
                  <label for="contract_type" class="form-label">{{ __('ประเภทสัญญา') }}</label> <span class="text-danger">*</span>
                  {{ Form::select('contract_type', \Helper::contractType(), null, ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...']) }}
                  <div class="invalid-feedback">
                    {{ __('สัญญา') }}
                  </div>
                </div>



                  <div class="col-md-12">
                    <label for="contract_projectplan" class="form-label">{{ __('บันทึกข้อความ') }}</label>
                    <input type="text" class="form-control" id="contract_projectplan" name="contract_projectplan" maxlength="50" >

                    <div class="invalid-feedback">
                      {{ __('บันทึกข้อความ') }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="contract_pr" class="form-label">{{ __('เลขที่ PR') }}</label> <span class="text-danger">*</span>
                    {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                    <input type="text" class="form-control" id="contract_pr" name="contract_pr" >
                    <div class="invalid-feedback">
                      {{ __('เลขที่สัญญา ซ้ำ') }}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="contract_pr_budget" class="form-label">{{ __('จำนวนเงิน PR') }}</label> <span class="text-danger">*</span>
                    {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                    <input type="number" placeholder="0.00" step="0.01" class="form-control" id="contract_pr_budget" name="contract_pr_budget" min="0">
                  </div>
                  <div class="col-md-6">
                    <label for="contract_pa" class="form-label">{{ __('เลขที่ PA') }}</label> <span class="text-danger">*</span>
                    {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                    <input type="text" class="form-control" id="contract_pa" name="contract_pa" >
                    <div class="invalid-feedback">
                      {{ __('เลขที่สัญญา ซ้ำ') }}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="contract_pa_budget" class="form-label">{{ __('จำนวนเงิน PA') }}</label> <span class="text-danger">*</span>
                    {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                    <input type="number" placeholder="0.00" step="0.01" class="form-control" id="contract_pa_budget" name="contract_pa_budget" min="0">
                  </div>

                  <div class="col-md-6">
                    <label for="contract_owner" class="form-label">{{ __('เจ้าหน้าที่ผู้รับผิดชอบ ') }}</label> <span class="text-danger">*</span>
                    {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                    <input type="text" class="form-control" id="contract_owner" name="contract_owner" maxlength="50" >
                  </div>

                  <div class="col-md-6">
                    <label for="contract_refund_pa_budget" class="form-label">{{ __('จำนวนคงเหลือหลังเงิน PA') }}</label> <span class="text-danger"></span>
                    <input type="number" placeholder="0.00" step="0.01" class="form-control" id="contract_refund_pa_budget" name="contract_refund_pa_budget" min="0" >
                  </div>
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
  </x-slot:css>
  <x-slot:javascript>
    <script>
        // Get references to the input fields
        var prInput = document.getElementById('contract_pr_budget');
        var paInput = document.getElementById('contract_pa_budget');
        var refundInput = document.getElementById('contract_refund_pa_budget');

        // Add event listeners to the input fields to detect changes
        prInput.addEventListener('input', updateRefund);
        paInput.addEventListener('input', updateRefund);

        // Function to update the refund input field based on the PR and PA input fields
        function updateRefund() {
          // Calculate the difference between the PR and PA input fields
          var refund = prInput.value - paInput.value;

          // Update the refund input field with the calculated value
          refundInput.value = refund;
        }
      </script>
  </x-slot:javascript>
</x-app-layout>
