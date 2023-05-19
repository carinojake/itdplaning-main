<x-app-layout>
    <x-slot:content>
        <div class="container-fluid">

            {{ Breadcrumbs::render('contract.create') }}
            {{ $pro->project_name }}

            {{ $ta->task_name }}


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
                        <x-card title="{{ __('เพิ่มสัญญา CN / ใบสั่งซื้อ PO / ใบสั่งจ้าง ER') }}">
                            <x-slot:toolbar>
                                {{-- <a href="{{ route('contract.create') }}" class="btn btn-success text-white">C</a>

  <a href="{{ route('project.task.createsub', $project) }}" class="btn btn-primary text-white">ไปยังหน้าการใช้จ่ายของงาน</a> --}}
                            </x-slot:toolbar>


                            <form method="POST" action="{{ route('contract.store') }}" class="row g-3"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <input type="text"name="origin" value="{{ $origin }}">

                                        <input type="text" name="project" value="{{ $project }}">

                                        <input type="text" name="task" value="{{ $task }}">

                                    </div>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-auto">
                                        <label for="contract_type" class="form-label">{{ __('ประเภทสัญญา') }}</label>
                                    </div>
                                    <div class="col-auto">
                                        {{ Form::select('contract_type', \Helper::contractType(), null, ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...', 'id' => 'contract_type']) }}
                                    </div>
                                </div>
                                <!--    -->
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                      <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button collapsed" type="button" data-coreui-toggle="collapse" data-coreui-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                ข้อมูลการจัดซื่อจับจ้าง
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-coreui-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="row mt-3">

                                                    <div class="col-md-4">
                                                        <label for="contract_mm"
                                                            class="form-label">{{ __('เลขที่ MM/เลขที่ สท.') }}</label>
                                                        <span class="text-danger"></span>

                                                        <input type="text" class="form-control" id="contract_mm"
                                                            name="contract_mm">
                                                        <div class="invalid-feedback">
                                                            {{ __(' ') }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="contract_mm_budget"
                                                            class="form-label">{{ __('จำนวนเงิน (บาท) MM') }}</label> <span
                                                            class="text-danger"></span>

                                                        <input type="text" placeholder="0.00" step="0.01"
                                                            class="form-control" id="contract_mm_budget"
                                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                            class="form-control numeral-mask"
                                                            name="contract_mm_budget" min="0">
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-md-4">
                                                        <label for="contract_pr"
                                                            class="form-label">{{ __('เลขที่ PR') }}</label> <span
                                                            class="text-danger"></span>

                                                        <input type="text" class="form-control" id="contract_PR"
                                                            name="contract_pr">
                                                        <div class="invalid-feedback">
                                                            {{ __(' ') }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="contract_pr_budget"
                                                            class="form-label">{{ __('จำนวนเงิน (บาท) PR') }}</label> <span
                                                            class="text-danger"></span>

                                                        <input type="taxt" placeholder="0.00" step="0.01"
                                                            class="form-control" id="contract_pr_budget"
                                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                            class="form-control numeral-mask"
                                                            name="contract_pr_budget" min="0">
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-4">
                                                        <label for="contract_pa"
                                                            class="form-label">{{ __('เลขที่ PA') }}</label> <span
                                                            class="text-danger"></span>

                                                        <input type="text" class="form-control" id="contract_PA"
                                                            name="contract_pa">
                                                        <div class="invalid-feedback">
                                                            {{ __(' ') }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="contract_pa_budget"
                                                            class="form-label">{{ __('จำนวนเงิน (บาท) PA') }}</label> <span
                                                            class="text-danger"></span>

                                                        <input type="taxt" placeholder="0.00" step="0.01"
                                                            class="form-control" id="contract_pa_budget"
                                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                            class="form-control numeral-mask"
                                                            name="contract_pa_budget" min="0">
                                                    </div>
                                                </div>

                                                <div id="po_form" style="display:none;">
                                                <!-- PO form fields -->
                                                <div class="row mt-3">
                                                    <div class="col-md-4">
                                                        <label for="contract_po"
                                                            class="form-label">{{ __('เลขที่ PO') }}</label> <span
                                                            class="text-danger"></span>

                                                        <input type="text" class="form-control" id="contract_PO"
                                                            name="contract_po">
                                                        <div class="invalid-feedback">
                                                            {{ __(' ') }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="contract_po_budget"
                                                            class="form-label">{{ __('จำนวนเงิน (บาท) PO') }}</label> <span
                                                            class="text-danger"></span>

                                                        <input type="taxt" placeholder="0.00" step="0.01"
                                                            class="form-control" id="contract_po_budget"
                                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                            class="form-control numeral-mask"
                                                            name="contract_po_budget" min="0">
                                                    </div>


                                                    <div class="col-md-4">
                                                        <label for="contract_po_start_date"
                                                            class="form-label">{{ __('กำหนดวันที่ส่งของ') }}</label>
                                                        <span class="text-danger"></span>

                                                        <input type="text" class="form-control"
                                                            id="contract_po_start_date" name="contract_po_start_date">
                                                        <div class="invalid-feedback">
                                                            {{ __(' ') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="er_form" style="display:none;">
                                                <div class="row mt-3">
                                                    <div class="col-md-4">
                                                        <label for="contract_er"
                                                            class="form-label">{{ __('เลขที่ ER') }}</label>
                                                        <span class="text-danger"></span>

                                                        <input type="text" class="form-control" id="contract_ER"
                                                            name="contract_er">
                                                        <div class="invalid-feedback">
                                                            {{ __(' ') }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="contract_er_budget"
                                                            class="form-label">{{ __('จำนวนเงิน (บาท) ER') }}</label> <span
                                                            class="text-danger"></span>

                                                        <input type="text" placeholder="0.00" step="0.01"
                                                            class="form-control" id="contract_er_budget"
                                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                            class="form-control numeral-mask"
                                                            name="contract_po_budget" min="0">
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="contract_er_start_date"
                                                            class="form-label">{{ __('กำหนดวันที่ส่งมอบงาน') }}</label>
                                                        <span class="text-danger"></span>

                                                        <input type="text" class="form-control"
                                                            id="contract_er_start_date" name="contract_er_start_date">
                                                        <div class="invalid-feedback">
                                                            {{ __(' ') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-4">
                                                        <label for="contract_cn"
                                                            class="form-label">{{ __('เลขที่ CN') }}</label>
                                                        <span class="text-danger"></span>

                                                        <input type="text" class="form-control" id="contract_cn"
                                                            name="contract_cn">
                                                        <div class="invalid-feedback">
                                                            {{ __(' ') }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="contract_cn_budget"
                                                            class="form-label">{{ __('จำนวนเงิน (บาท) CN') }}</label> <span
                                                            class="text-danger"></span>

                                                        <input type="text" placeholder="0.00" step="0.01"
                                                            class="form-control" id="contract_cn_budget"
                                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                            class="form-control numeral-mask"
                                                            name="contract_cn_budget" min="0">
                                                    </div>
                                                </div>

                                            </div><!-- 1  -->
                                        </div>
                                    </div>


                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed" type="button"
                                                data-coreui-toggle="collapse" data-coreui-target="#collapseTwo"
                                                aria-expanded="false" aria-controls="collapseTwo">
                                                ข้อมูลสญญา 2
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse"
                                            aria-labelledby="headingTwo" data-coreui-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="row mt-3">
                                                    <div class="col-md-3">
                                                        <label for="contract_number"
                                                            class="form-label">{{ __('เลขที่สัญญา  ') }}</label> <span
                                                            class="text-danger"></span>
                                                        <input type="text" class="form-control" id="contract_number"
                                                            name="contract_number">
                                                        <div class="invalid-feedback">
                                                            {{ __('เลขที่สัญญา ซ้ำ') }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="contract_sign_date"
                                                            class="form-label">{{ __('วันที่ลงนามสัญญา') }}</label>
                                                            <input type="text" class="form-control" id="contract_sign_date" name="contract_sign_date" >
                                                        <!--<div data-coreui-toggle="date-picker" id="contract_sign_date"
                                                            data-coreui-format="dd/MM/yyyy"></div>-->
                                                    </div>


                                                </div>



                                                <div class="row mt-3">
                                                    <div class="col-md-3">
                                                        <label for="contract_juristic_id"
                                                            class="form-label">{{ __('เลขทะเบียนคู่ค้า') }}</label> <span
                                                            class="text-danger"></span>
                                                        <input type="text" class="form-control" id="contract_juristic_id"
                                                            name="contract_juristic_id" maxlength="13">
                                                        <div class="invalid-feedback">
                                                            {{ __('คู่ค้าซ้ำ') }}
                                                        </div>
                                                    </div>


                                                    <div class="col-md-3">
                                                        <label for="contract_start_date"
                                                            class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span
                                                            class="text-danger">*</span>
                                                        {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                                                        <input type="text" class="form-control" id="contract_start_date" name="contract_start_date" >
                                                        <!--<div data-coreui-toggle="date-picker" id="contract_start_date"
                                                            data-coreui-format="dd/MM/yyyy"></div>-->
                                                    </div>


                                                    <div class="col-md-3">
                                                        <label for="contract_end_date"
                                                            class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span
                                                            class="text-danger"></span>
                                                            <input type="text" class="form-control" id="contract_end_date" name="contract_end_date" >
                                                       <!-- <div data-coreui-toggle="date-picker" id="contract_end_date"
                                                            data-coreui-format="dd/MM/yyyy">
                                                        </div>-->
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-md-3">
                                                        <label for="insurance_start_date"
                                                            class="form-label">{{ __('วันที่เริ่มต้น ประก้น') }}</label> <span
                                                            class="text-danger"></span>
                                                         <input type="text" class="form-control" id="insurance_start_date" name="insurance_start_date" >
                                                       <!-- <div data-coreui-toggle="date-picker" id="insurance_start_date"
                                                            data-coreui-format="dd/MM/yyyy"></div>-->
                                                    </div>


                                                    <div class="col-md-3">
                                                        <label for="insurance_end_date"
                                                            class="form-label">{{ __('วันที่สิ้นสุด ประกัน') }}</label> <span
                                                            class="text-danger">*</span>
                                                            <input type="text" class="form-control" id="insurance_end_date" name="insurance_end_date">
                                                       <!-- <div data-coreui-toggle="date-picker" id="insurance_end_date"
                                                            data-coreui-format="dd/MM/yyyy">
                                                        </div>-->
                                                    </div>

                                                    <div class="row mt-3">
                                                        <div class="col-md-3">
                                                            <div class="row">
                                                                <div class="col-12">{{ __('ประกัน จำนวนเดือน') }}</div>
                                                                <div id="insurance_duration_months" class="col-12"></div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col-12">{{ __('ประกัน จำนวนวัน') }}</div>
                                                                <div id="insurance_duration_days" class="col-12"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--จบ ข้อมูลสัญญา 2-->




                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button collapsed" type="button"
                                                data-coreui-toggle="collapse" data-coreui-target="#collapseThree"
                                                aria-expanded="false" aria-controls="collapseThree">
                                                ข้อมูลสัญญา 3
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse"
                                            aria-labelledby="headingThree" data-coreui-parent="#accordionExample">
                                            <div class="accordion-body">

                                <!--ข้อมูลสัญญา 3 -->
                                <div class="col-md-12 mt-3">
                                    <label for="contract_name" class="form-label">{{ __('ชื่อ MM') }}</label> <span
                                        class="text-danger">*</span>
                                    <input type="text" class="form-control" id="contract_name"
                                        name="contract_name" required autofocus>
                                    <div class="invalid-feedback">
                                        {{ __('ชื่อสัญญา ซ้ำ') }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="contract_name" id="contract_name_label" class="form-label">{{ __('ชื่อ PO/ER/CN') }}</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" id="contract_name"
                                        name="contract_name" required autofocus>
                                    <div class="invalid-feedback">
                                        {{ __('ชื่อสัญญา ซ้ำ') }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="contract_description"
                                        class="form-label">{{ __('รายละเอียดสัญญา') }}</label>
                                    <textarea class="form-control" name="contract_description" id="contract_description" rows="10"></textarea>
                                    <div class="invalid-feedback">
                                        {{ __('รายละเอียดงาน/โครงการ') }}
                                    </div>
                                </div>
                    </div>




                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- -->

                    <!--   <div class="col-md-4">
                        <label for="contract_start_date" class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span
                            class="text-danger">*</span>
                        {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                        <div data-coreui-toggle="date-picker" id="contract_start_date"
                            data-coreui-format="dd/MM/yyyy"></div>
                    </div>
                    <div class="col-md-4">
                        <label for="contract_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span
                            class="text-danger">*</span>

                        <div data-coreui-toggle="date-picker" id="contract_end_date" data-coreui-format="dd/MM/yyyy">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="contract_sign_date" class="form-label">{{ __('วันที่ลงนามสัญญา') }}</label>

                        <div data-coreui-toggle="date-picker" id="contract_sign_date"
                            data-coreui-format="dd/MM/yyyy"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="contract_acquisition" class="form-label">{{ __('วืธีการ') }}</label>
                        <span class="text-danger">*</span>
                        {{ Form::select('contract_acquisition', \Helper::contractAcquisition(), null, ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...']) }}
                        <div class="invalid-feedback">
                            {{ __('สัญญา') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="contract_type" class="form-label">{{ __('ประเภทสัญญา') }}</label>
                        <span class="text-danger">*</span>
                        {{ Form::select('contract_type', \Helper::contractType(), null, ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...']) }}
                        <div class="invalid-feedback">
                            {{ __('สัญญา') }}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="contract_projectplan" class="form-label">{{ __('หมายเหตุ') }}</label>
                        <input type="text" class="form-control" id="contract_projectplan"
                            name="contract_projectplan" maxlength="50">

                        <div class="invalid-feedback">
                            {{ __('หมายเหตุ') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="contract_mm" class="form-label">{{ __('เลขที่ MM') }}</label> <span
                            class="text-danger"></span>

                        <input type="text" class="form-control" id="contract_mm" name="contract_mm">
                        <div class="invalid-feedback">
                            {{ __(' ') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="contract_mm_budget" class="form-label">{{ __('จำนวนเงิน  MM') }}</label> <span
                            class="text-danger"></span>

                        <input type="number" placeholder="0.00" step="0.01" class="form-control"
                            id="contract_mm_budget" name="contract_mm_budget" min="0">
                    </div>



                    <div class="col-md-6">
                        <label for="contract_pr" class="form-label">{{ __('เลขที่ PR') }}</label> <span
                            class="text-danger">*</span>

                        <input type="text" class="form-control" id="contract_pr" name="contract_pr">
                        <div class="invalid-feedback">
                            {{ __('เลขที่สัญญา ซ้ำ') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="contract_pr_budget" class="form-label">{{ __('จำนวนเงิน PR ') }}</label> <span
                            class="text-danger">*</span>

                        <input type="number" placeholder="0.00" step="0.01" class="form-control"
                            id="contract_pr_budget" name="contract_pr_budget" min="0">
                    </div>
                    <div class="col-md-6">
                        <label for="contract_pa" class="form-label">{{ __('เลขที่ PA') }}</label> <span
                            class="text-danger">*</span>

                        <input type="text" class="form-control" id="contract_pa" name="contract_pa">
                        <div class="invalid-feedback">
                            {{ __('เลขที่สัญญา ซ้ำ') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="contract_pa_budget" class="form-label">{{ __('จำนวนเงิน PA') }}</label> <span
                            class="text-danger">*</span>

                        <input type="number" placeholder="0.00" step="0.01" class="form-control"
                            id="contract_pa_budget" name="contract_pa_budget" min="0">
                    </div>
                    <div class="col-md-6">
                        <label for="contract_peryear_pa_budget"
                            class="form-label">{{ __('จำนวนเงินต่อปี PA') }}</label> <span
                            class="text-danger">*</span>

                        <input type="number" placeholder="0.00" step="0.01" class="form-control"
                            id="contract_peryear_pa_budget" name="contract_peryear_pa_budget" min="0">
                    </div>


                    <div class="col-md-6">
                        <label for="contract_owner" class="form-label">{{ __('เจ้าหน้าที่ผู้รับผิดชอบ ') }}</label>
                        <span class="text-danger">*</span>
                        <input type="text" class="form-control" id="contract_owner" name="contract_owner"
                            maxlength="50">
                    </div>

                    <div class="col-md-6">
                        <label for="contract_refund_pa_budget"
                            class="form-label">{{ __('จำนวนคงเหลือหลังเงิน PA') }}</label> <span
                            class="text-danger"></span>
                        <input type="number" placeholder="0.00" step="0.01" class="form-control"
                            id="contract_refund_pa_budget" name="contract_refund_pa_budget" min="0">
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
                    @if ($origin)
                        <x-button
                            link="{{ route('project.task.createsub', ['projectHashid' => $origin, 'taskHashid' => $task]) }}"
                            class="text-black btn-light">{{ __('coreuiforms.return') }}</x-button>
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
    $(document).ready(function() {
        $('#contract_type').change(function() {
            var contract_type = $(this).val();
            var contract_name_label = $('#contract_name_label');
            if(contract_type == 1) {
                contract_name_label.text('ชื่อ PO');
                $('#po_form').show();
                $('#er_form').hide();
            } else if(contract_type == 2) {
                contract_name_label.text('ชื่อ ER');
                $('#po_form').hide();
                $('#er_form').show();
            } else if(contract_type == 3) {
                contract_name_label.text('ชื่อ CN');
                $('#po_form').show();
                $('#er_form').hide();
            } else {
                contract_name_label.text('ชื่อ /CN');
                $('#po_form').hide();
                $('#er_form').hide();
            }
        });
    });
    </script>


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
        $(function () {
          if (typeof jQuery == 'undefined' || typeof jQuery.ui == 'undefined') {
            alert("jQuery or jQuery UI is not loaded");
            return;
          }

          var d = new Date();
          var toDay = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 543);











          $("#contract_sign_date,#contract_start_date, #contract_end_date, #insurance_start_date, #insurance_end_date,#contract_er_start_date,#contract_po_start_date").datepicker({
            dateFormat: 'dd/mm/yy',
            isBuddhist: true,
            defaultDate: toDay,
            dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
            dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
            monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
            monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],

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
    $(document).ready(function(){
   $(":input").inputmask();
   });
   </script>



    </x-slot:javascript>
</x-app-layout>
