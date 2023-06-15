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

                            <form method="POST" action="{{ route('project.store') }}" class="row needs-validation"
                                novalidate>
                                @csrf
                                <div class="row mt-3">
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
                                            class="form-label">{{ __('ลำดับ.ชื่องาน/โครงการ') }}</label>
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
                                                ลำดับ ชื่องาน/โครงการ
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
                                        <label for="project_name"
                                            class="form-label">{{ __('ชื่องาน/โครงการ') }}</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" id="project_name" name="project_name"
                                            required autofocus>

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



                                    <div class="col-md-12 mt-3">
                                        <label for="project_description"
                                            class="form-label">{{ __('รายละเอียดงาน/โครงการ') }}</label>
                                        <textarea class="form-control" name="project_description" id="project_description" rows="10"></textarea>
                                        <div class="invalid-feedback">
                                            {{ __('รายละเอียดงาน/โครงการ') }}
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
                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                        class="form-control numeral-mask" id="budget_it_operating"
                                                        name="budget_it_operating" min="0">


                                                    <div class="invalid-feedback">
                                                        {{ __('ระบุงบกลาง ICT') }}
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <label for="budget_it_investment"
                                                        class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                    <input type="text" placeholder="0.00" step="0.01"
                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                        class="form-control numeral-mask" id="budget_it_investment"
                                                        name="budget_it_investment" min="0">
                                                    <div class="invalid-feedback">
                                                        {{ __('ระบุงบดำเนินงาน') }}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="budget_gov_utility"
                                                        class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                    <input type="text" placeholder="0.00" step="0.01"
                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                        class="form-control numeral-mask" id="budget_gov_utility"
                                                        name="budget_gov_utility" min="0">
                                                    <div class="invalid-feedback">
                                                        {{ __('ระบุค่าสาธารณูปโภค') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    </div>
                    <x-button class="btn-success" type="submit">{{ __('coreuiforms.save') }}
                    </x-button>
                    <x-button link="{{ route('project.index') }}" class="text-black btn-light">
                        {{ __('coreuiforms.return') }}</x-button>
                    </form>

                    </x-card>


    </x-slot:content>
    <x-slot:css>
    </x-slot:css>
    <x-slot:javascript>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>




        <script>
            $(document).ready(function() {
                $(":input").inputmask();
            });
        </script>


        <script>
            $(function() {
                if (typeof jQuery == 'undefined' || typeof jQuery.ui == 'undefined') {
                    alert("jQuery or jQuery UI is not loaded");
                    return;
                }

                var d = new Date();
                var toDay = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 543);

                $("#project_start_date, #project_end_date").datepicker({
                    dateFormat: 'dd/mm/yy',
                    changeMonth: true,
                    changeYear: true,
                    isBuddhist: true,
                    defaultDate: toDay,
                    dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
                    dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
                    monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม',
                        'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
                    ],
                    monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.',
                        'ต.ค.', 'พ.ย.', 'ธ.ค.'
                    ]
                });
            });
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





    </x-slot:javascript>
</x-app-layout>
