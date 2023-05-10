<x-app-layout>
    <x-slot:content>
      <div class="container-fluid">

        {{ Breadcrumbs::render('contract.create') }}

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
              <x-card title="{{ __('เพิ่มสัญญา / ใบจ้าง') }}">
                <x-slot:toolbar>
      {{-- <a href="{{ route('contract.create') }}" class="btn btn-success text-white">C</a>

  <a href="{{ route('project.task.createsub', $project) }}" class="btn btn-primary text-white">ไปยังหน้าการใช้จ่ายของงาน</a>--}}
</x-slot:toolbar>
    <form method="POST" action="{{ route('contract.store') }}" class="row g-3" enctype="multipart/form-data">


    @csrf
     <input type="hidden"name="origin" value="{{ $origin }}">

    <input type="hidden" name="project" value="{{ $project }}">

    <input type="hidden" name="task" value="{{ $task }}">

                  <div class="row mt-3">
                  <div class="col-md-3">
                      <label for="contract_fiscal_year" class="form-label">{{ __('ปีงบประมาณ') }}</label> <span class="text-danger">*</span>
                      <input type="text" class="form-control" id="contract_fiscal_year" name="contract_fiscal_year" required>
                      <div class="invalid-feedback">
                        {{ __('ปีงบประมาณ') }}
                      </div>
                    </div>

                  <div class="col-md-3">
                    <label for="contract_number" class="form-label">{{ __('เลขที่สัญญา / ') }}</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" id="contract_number" name="contract_number" required>
                    <div class="invalid-feedback">
                      {{ __('เลขที่สัญญา ซ้ำ') }}
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="contract_juristic_id" class="form-label">{{ __('เลขทะเบียนคู่ค้า') }}</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" id="contract_juristic_id" name="contract_juristic_id" maxlength="13" required>
                    <div class="invalid-feedback">
                      {{ __('คู่ค้าซ้ำ') }}
                    </div>
                  </div>


                  <div class="col-md-3">
                    <label for="contract_order_no" class="form-label">{{ __('เลขที่ใบสั่งซื้อ CN/PO ') }}</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" id="contract_order_no" name="contract_order_no" maxlength="50" required>
                    <div class="invalid-feedback">
                      {{ __('เลขที่ใบสั่งซื้อ') }}
                    </div>
                  </div>
              </div>

                  <div class="col-md-12">
                      <label for="contract_name" class="form-label">{{ __('ชื่อสัญญา / ใบจ้าง') }}</label> <span class="text-danger">*</span>
                      <input type="text" class="form-control" id="contract_name" name="contract_name" required autofocus>
                      <div class="invalid-feedback">
                        {{ __('ชื่อสัญญา ซ้ำ') }}
                      </div>
                    </div>
                  <div class="col-md-12">
                    <label for="contract_description" class="form-label">{{ __('รายละเอียดสัญญา') }}</label>
                    <textarea class="form-control" name="contract_description" id="contract_description" rows="10"></textarea>
                    <div class="invalid-feedback">
                      {{ __('รายละเอียดงาน/โครงการ') }}
                    </div>
                  </div>

                  <div class="col-md-4">
                    <label for="contract_start_date" class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span class="text-danger">*</span>
                    {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                    <div data-coreui-toggle="date-picker" id="contract_start_date" data-coreui-format="dd/MM/yyyy"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="contract_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span class="text-danger">*</span>

                    <div data-coreui-toggle="date-picker" id="contract_end_date" data-coreui-format="dd/MM/yyyy"></div>
                  </div>
                  <div class="col-md-4">
                    <label for="contract_sign_date" class="form-label">{{ __('วันที่ลงนามสัญญา') }}</label>

                    <div data-coreui-toggle="date-picker" id="contract_sign_date" data-coreui-format="dd/MM/yyyy"></div>
                  </div>
                  <div class="col-md-6">
                      <label for="contract_acquisition" class="form-label">{{ __('วืธีการ') }}</label> <span class="text-danger">*</span>
                      {{ Form::select('contract_acquisition', \Helper::contractAcquisition(), null, ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...']) }}
                      <div class="invalid-feedback">
                        {{ __('สัญญา') }}
                      </div>
                    </div>
                  <div class="col-md-6">
                    <label for="contract_type" class="form-label">{{ __('ประเภทสัญญา') }}</label> <span class="text-danger">*</span>
                    {{ Form::select('contract_type', \Helper::contractType(), null, ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...']) }}
                    <div class="invalid-feedback">
                      {{ __('สัญญา') }}
                    </div>
                  </div>

                    <div class="col-md-12">
                      <label for="contract_projectplan" class="form-label">{{ __('หมายเหตุ') }}</label>
                      <input type="text" class="form-control" id="contract_projectplan" name="contract_projectplan" maxlength="50" >

                      <div class="invalid-feedback">
                        {{ __('หมายเหตุ') }}
                      </div>
                    </div>
                    <div class="col-md-6">
                        <label for="contract_mm" class="form-label">{{ __('เลขที่ MM') }}</label> <span class="text-danger"></span>

                        <input type="text" class="form-control" id="contract_mm" name="contract_mm" >
                        <div class="invalid-feedback">
                          {{ __(' ') }}
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label for="contract_mm_budget" class="form-label">{{ __('จำนวนเงิน  MM') }}</label> <span class="text-danger"></span>

                        <input type="number" placeholder="0.00" step="0.01" class="form-control" id="contract_mm_budget" name="contract_mm_budget" min="0">
                      </div>



                    <div class="col-md-6">
                      <label for="contract_pr" class="form-label">{{ __('เลขที่ PR') }}</label> <span class="text-danger">*</span>

                      <input type="text" class="form-control" id="contract_pr" name="contract_pr" >
                      <div class="invalid-feedback">
                        {{ __('เลขที่สัญญา ซ้ำ') }}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="contract_pr_budget" class="form-label">{{ __('จำนวนเงิน PR ') }}</label> <span class="text-danger">*</span>

                      <input type="number" placeholder="0.00" step="0.01" class="form-control" id="contract_pr_budget" name="contract_pr_budget" min="0">
                    </div>
                    <div class="col-md-6">
                      <label for="contract_pa" class="form-label">{{ __('เลขที่ PA') }}</label> <span class="text-danger">*</span>

                      <input type="text" class="form-control" id="contract_pa" name="contract_pa" >
                      <div class="invalid-feedback">
                        {{ __('เลขที่สัญญา ซ้ำ') }}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="contract_pa_budget" class="form-label">{{ __('จำนวนเงิน PA') }}</label> <span class="text-danger">*</span>

                      <input type="number" placeholder="0.00" step="0.01" class="form-control" id="contract_pa_budget" name="contract_pa_budget" min="0">
                    </div>
                    <div class="col-md-6">
                      <label for="contract_peryear_pa_budget" class="form-label">{{ __('จำนวนเงินต่อปี PA') }}</label> <span class="text-danger">*</span>

                      <input type="number" placeholder="0.00" step="0.01" class="form-control" id="contract_peryear_pa_budget" name="contract_peryear_pa_budget" min="0">
                    </div>


                    <div class="col-md-6">
                      <label for="contract_owner" class="form-label">{{ __('เจ้าหน้าที่ผู้รับผิดชอบ ') }}</label> <span class="text-danger">*</span>
                      <input type="text" class="form-control" id="contract_owner" name="contract_owner" maxlength="50" >
                    </div>

               <!--    <div class="col-md-6">
                      <label for="contract_refund_pa_budget" class="form-label">{{ __('จำนวนคงเหลือหลังเงิน PA') }}</label> <span class="text-danger"></span>
                      <input type="number" placeholder="0.00" step="0.01" class="form-control" id="contract_refund_pa_budget" name="contract_refund_pa_budget" min="0" >
                    </div>
                    <div class="col-md-12">
                      <label for="contract_file" class="form-label">{{ __('อัปโหลดไฟล์สัญญา') }}</label>
                      <input type="file" class="form-control" id="contract_file" name="contract_file">
                      <div class="invalid-feedback">
                          {{ __('เลือกไฟล์สัญญา') }}
                      </div>
                  </div>

                  <div class="col-md-12">
                    <label for="mm_file" class="form-label">{{ __('อัปโหลดไฟล์สัญญา') }}</label>
                    <input type="file" class="form-control" id="mm_file" name="mm_file">
                    <div class="invalid-feedback">
                        {{ __('เลือกไฟล์สัญญา') }}
                    </div>
                </div>
                  <div class="col-md-12">
                      <label for="pr_file" class="form-label">{{ __('อัปโหลดไฟล์ PR') }}</label>
                      <input type="file" class="form-control" id="pr_file" name="pr_file">
                      <div class="invalid-feedback">
                          {{ __('เลือกไฟล์ PR') }}
                      </div>
                  </div>
                  <div class="col-md-12">
                      <label for="pa_file" class="form-label">{{ __('อัปโหลดไฟล์ PA') }}</label>
                      <input type="file" class="form-control" id="pa_file" name="pa_file">
                      <div class="invalid-feedback">
                          {{ __('เลือกไฟล์ PA') }}
                      </div>
                  </div>
                  <div class="col-md-12">
                      <label for="cn_file" class="form-label">{{ __('อัปโหลดไฟล์ CN') }}</label>
                      <input type="file" class="form-control" id="cn_file" name="cn_file">
                      <div class="invalid-feedback">
                          {{ __('เลือกไฟล์ CN') }}
                      </div>
                  </div>
                -->
                  <x-button class="btn-success" type="submit">{{ __('coreuiforms.save') }}</x-button>
                  @if($origin)
                      <x-button link="{{ route('project.task.createsub', ['projectHashid' => $origin, 'taskHashid' => $task]) }}" class="text-black btn-light">{{ __('coreuiforms.return') }}</x-button>
                  @else

                  @endif

                 <!-- <x-button link="{{ route('contract.index') }}" class="btn-light text-black">{{ __('coreuiforms.return') }}</x-button>
                 -->

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
            function handleSubmit(event) {
                event.preventDefault();

                const form = event.target;
                const formData = new FormData(form);

                fetch(form.action, {
                    method: form.method,
                    body: formData,
                })
                    .then((response) => response.json())
                    .then((newContract) => {
                        window.opener.addContractOption(newContract);
                        window.close();
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            }
        </script>





    </x-slot:javascript>
  </x-app-layout>
