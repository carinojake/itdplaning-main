<x-app-layout>
    <x-slot:content>
        <div class="container-fluid">
            {{ Breadcrumbs::render('project.task.create',$project) }}
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
                        <x-card title="{{ __('เพิ่มกิจกรรม ') }}">
                            <form method="POST" action="{{ route('project.task.create', $project) }}" class="row g-3 needs-validation" novalidate>
                                @csrf
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label for="task_name" class="form-label">{{ __('ชื่อกิจกรรม') }}</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" id="task_name" name="task_name" required autofocus>
                                    </div>
                                </div>

                                <div class="row mt-3 d-none">
                                    <div class="col-md-6">
                                        <label for="task_status" class="form-label">{{ __('สถานะกิจกรรม') }}</label>
                                        <span class="text-danger">*</span>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="task_status" id="task_status1" value="1" checked>
                                            <label class="form-check-label" for="task_status1">
                                                ระหว่างดำเนินการ
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="task_status" id="task_status2" value="2">
                                            <label class="form-check-label" for="task_status2">
                                                ดำเนินการแล้วเสร็จ
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="task_start_date" class="form-label">{{ __('วันที่เริ่มต้น') }}</label>
                                        <span class="text-danger">*</span>
                                        <input class="form-control" id="task_start_date" name="task_start_date" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="task_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }}</label>
                                        <span class="text-danger">*</span>
                                        <input class="form-control" id="task_end_date" name="task_end_date" required>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label for="task_description" class="form-label">{{ __('รายละเอียดกิจกรรม') }}</label>
                                    <textarea class="form-control" name="task_description" id="task_description" rows="10"></textarea>
                                    <div class="invalid-feedback">
                                        {{ __('รายละเอียดกิจกรรม') }}
                                    </div>
                                </div>

                                <div class="row">
                                    <h4>งบประมาณ</h4>
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-md-4 needs-validation" novalidate>
                                                <label for="task_budget_it_operating" class="form-label">{{ __('งบกลาง ICT') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01" data-inputmask="'alias': 'decimal', 'groupSeparator': ','" class="form-control numeral-mask" id="task_budget_it_operating" name="task_budget_it_operating" min="0" >


                                                <div class="invalid-feedback">
                                                    {{ __('ระบุงบกลาง ICT') }}
                                                </div>
                                                ไม่เกิน {{ number_format($request->budget_it_operating - $sum_task_budget_it_operating) }} บาท
                                            </div>
                                            <div class="col-md-4">
                                                <label for="task_budget_it_investment" class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01" data-inputmask="'alias': 'decimal', 'groupSeparator': ','" class="form-control numeral-mask" id="task_budget_it_investment" name="task_budget_it_investment" min="0" >
                                                <div class="invalid-feedback">
                                                    {{ __('ระบุงบดำเนินงาน') }}
                                                </div>
                                                ไม่เกิน {{ number_format($request->budget_it_investment - $sum_task_budget_it_investment) }} บาท
                                            </div>
                                            <div class="col-md-4">
                                                <label for="task_budget_gov_utility" class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01" data-inputmask="'alias': 'decimal', 'groupSeparator': ','" class="form-control numeral-mask" id="task_budget_gov_utility" name="task_budget_gov_utility" min="0" >
                                                <div class="invalid-feedback">
                                                    {{ __('ระบุค่าสาธารณูปโภค') }}
                                                </div>
                                                ไม่เกิน {{ number_format($request->budget_gov_utility - $sum_task_budget_gov_utility) }} บาท
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <x-button class="btn-success" type="submit">{{ __('coreuiforms.save') }}</x-button>
                                <x-button link="{{ route('project.show', $project) }}" class="text-black btn-light">{{ __('coreuiforms.return') }}</x-button>
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

        <script>
            $(document).ready(function(){
                $(":input").inputmask();
            });
        </script>

        <script>
            $(function () {
                if (typeof jQuery == 'undefined' || typeof jQuery.ui == 'undefined') {
                    alert("jQuery or jQuery UI is not loaded");
                    return;
                }

                var d = new Date();
                var toDay = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 543);

                $("#task_start_date, #task_end_date").datepicker({
                    dateFormat: 'dd/mm/yy',
                    isBuddhist: true,
                    defaultDate: toDay,
                    dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
                    dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
                    monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
                    monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.']
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
    </x-slot:javascript>
</x-app-layout>
