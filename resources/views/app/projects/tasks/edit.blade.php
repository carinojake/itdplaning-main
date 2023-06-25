<x-app-layout>
    <x-slot:content>
        <div class="container-fluid">
           {{--  {{ Breadcrumbs::render('project.task.edit', $project, $task) }} --}}
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
                <div class="row ">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <x-card title="{{ __('แก้ไขกิจกรรม') }} {{ $task->task_name }}">
                            <form method="POST"
                                action="{{ route('project.task.update', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
                                class="row g-3">
                                @csrf
                                {{ method_field('PUT') }}

                                <div class="col-md-12 mt-3">
                                    <label for="task_name" class="form-label">{{ __('ชื่อกิจกรรม') }}</label> <span
                                        class="text-danger">*</span>
                                    <input type="text" class="form-control" id="task_name" name="task_name"
                                        value="{{ $task->task_name }}" required autofocus>
                                    <div class="invalid-feedback">
                                        {{ __('ชื่อกิจกรรมซ้ำ') }}
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">

                                        <label for="task_status" class="form-label">{{ __('สถานะกิจกรรม') }}</label>
                                        <span class="text-danger">*</span>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="task_status"
                                                id="task_status1" value="1" @checked($task->task_status == 1)>
                                            <label class="form-check-label" for="task_status1">
                                                ระหว่างดำเนินการ
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="task_status"
                                                id="task_status2" value="2" @checked($task->task_status == 2)>
                                            <label class="form-check-label" for="task_status2">
                                                ดำเนินการแล้วเสร็จ
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="row mt-3">

                                <div class="col-md-3">
                                    <label for="task_parent" class="form-label">{{ __('เป็นกิจกรรม') }}</label>
                                    <span class="text-danger">*</span>
                                    {{-- <input type="text" class="form-control" id="task_parent" name="task_parent"> --}}
                                    <select name="task_parent" id="task_parent" class="form-control">
                                        <option value="">ไม่มี</option>
                                        @foreach ($tasks as $subtask)
                            <option value="{{ $subtask->task_id }}"
                                                {{ $task->task_parent == $subtask->task_id ? 'selected' : '' }}>
                                                {{ $subtask->task_name }}</option>
                                    @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ __('กิจกรรม') }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="task_status" class="form-label">{{ __('สถานะกิจกรรม') }}</label> <span
                                        class="text-danger">*</span>
                                    <div >
                                        <input class="form-check-input" type="radio" name="task_status"
                                            id="task_status1" value="1"  @checked($task->task_status == 1)>
                                        <label class="form-check-label" for="task_status1">
                                            อยู่ในระหว่างดำเนินการ
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="task_status"
                                            id="task_status2" value="2"  @checked($task->task_status == 2)>
                                        <label class="form-check-label" for="task_status2">
                                            ดำเนินการแล้วเสร็จ
                                        </label>
                                    </div>
                                    <div class="invalid-feedback">
                                        {{ __('สถานะงาน/โครงการ') }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="task_type" class="form-label">{{ __('สถานะงาน/โครงการ') }}</label> <span class="text-danger">*</span>
                                    <div >
                                        <input class="form-check-input" type="radio" name="task_type" id="task_type1" value="1"
                                        @checked($task->task_type == 1)>
                                      <label class="form-check-label" for="task_type1">
                                        มี PA
                                      </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="task_type" id="task_type2" value="2"
                                        @checked($task->task_type == 2)>
                                      <label class="form-check-label" for="task_type2">
                                        ไม่มี PA
                                      </label>
                                    </div>
                            </div>-->



                                <!--  <div class="col-md-12">
                                <label for="task_contract" class="form-label">{{ __('สัญญา') }}</label> <span
                                    class="text-danger">*</span>
                                {{-- <input type="text" class="form-control" id="task_contract" name="task_contract"> --}}
                                <select name="task_contract" id="task_contract" class="form-control">
                                    <option value="">ไม่มี</option>
                                    @foreach ($contracts as $contract)
@if ($task->contract->count() > 0 && $contract->contract_id == $task->contract->first()->contract_id)
<option value="{{ $contract->contract_id }}"selected>
                                                [{{ $contract->contract_number }}]{{ $contract->contract_name }}
                                            </option>
@else
<option value="{{ $contract->contract_id }}">
                                                [{{ $contract->contract_number }}]{{ $contract->contract_name }}
                                            </option>
@endif
@endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{ __('สัญญา') }}
                                </div>
                            </div>-->



                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="task_start_date"
                                            class="form-label">{{ __('วันที่เริ่มต้น') }}</label>
                                        <input class="form-control" id="task_start_date" name="task_start_date"
                                            value="{{ \Helper::date4(date('Y-m-d H:i:s', $task->task_start_date)) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="task_end_date"
                                            class="form-label">{{ __('วันที่สิ้นสุด') }}</label>
                                        <input class="form-control" id="task_end_date" name="task_end_date"
                                            value="{{ \Helper::date4(date('Y-m-d H:i:s', $task->task_end_date)) }}">
                                    </div>
                                </div>




                                <div class="col-md-12 mt-3">
                                    <label for="task_description"
                                        class="form-label">{{ __('รายละเอียดกิจกรรม') }}</label>
                                    <textarea class="form-control" name="task_description" id="task_description" rows="10">
                    {{ $task->task_description }}
                  </textarea>
                                    <div class="invalid-feedback">
                                        {{ __('รายละเอียดกิจกรรม') }}
                                    </div>
                                </div>



                                <div class="row">


                                    <div class="row">
                                        <h4>งบประมาณ</h4>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="task_budget_it_operating"
                                                    class="form-label">{{ __('งบกลาง ICT ') }}</label>
                                                <!--<input type="text" placeholder="0.00" step="0.01" class="form-control" id="budget_it_investment" name="budget_it_investment" min="0" value="100000.00">-->
                                                <input type="text" placeholder="0.00" step="0.01"
                                                    data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                    class="form-control" id="task_budget_it_operating"
                                                    name="task_budget_it_operating" min="0"
                                                    value="{{ $task->task_budget_it_operating }}">
                                                <div class="invalid-feedback">
                                                    {{ __('ระบุงบกลาง ICT') }}
                                                </div>
                                                ไม่เกิน
                                                {{ number_format($request->budget_it_operating - $sum_task_budget_it_operating) }}
                                                บาท
                                            </div>
                                            <div class="col-4">
                                                <label for="task_budget_it_investment"
                                                    class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                    data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                    class="form-control" id="task_budget_it_investment"
                                                    name="task_budget_it_investment" min="0"
                                                    value="{{ $task->task_budget_it_investment }}">
                                                <div class="invalid-feedback">
                                                    {{ __('ระบุงบดำเนินงาน') }}
                                                </div>
                                                ไม่เกิน
                                                {{ number_format($request->budget_it_investment - $sum_task_budget_it_investment) }}
                                                บาท
                                            </div>

                                            <div class="col-md-4">
                                                <label for="task_budget_gov_utility"
                                                    class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                    data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                    class="form-control" id="task_budget_gov_utility"
                                                    name="task_budget_gov_utility" min="0"
                                                    value="{{ $task->task_budget_gov_utility }}">
                                                <div class="invalid-feedback">
                                                    {{ __('ระบุค่าสาธารณูปโภค') }}
                                                </div>
                                                ไม่เกิน
                                                {{ number_format($request->budget_gov_utility - $sum_task_budget_gov_utility) }}
                                                บาท
                                            </div>
                                        </div>




                                    </div>
                                </div>









                               {{--  <div class="row mt-3">

                                    <div class="row mt-3">
                                        <h4>เบิกจ่าย</h4>
                                        <div class="col-md-6">
                                            <label for="task_pay_date"
                                                class="form-label">{{ __('วันที่เบิกจ่าย') }}</label>
                                            <input class="form-control" id="task_pay_date" name="task_pay_date"
                                                value="{{ \Helper::date4(date('Y-m-d H:i:s', $task->task_pay_date)) }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="task_pay" class="form-label">{{ __('เบิกจ่าย') }}</label>
                                            <input type="text" placeholder="0.00" step="0.01"
                                                class="form-control" id="task_pay" name="task_pay"
                                                data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                min="0" value="{{ $task->task_pay }}">
                                            <div class="invalid-feedback">
                                                {{ __('เบิกจ่าย') }}
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                    </div>

                    <x-button class="btn-success" type="submit">{{ __('coreuiforms.save') }}</x-button>
                    <x-button link="{{ route('project.show', $project->hashid) }}" class="btn-light text-black">
                        {{ __('coreuiforms.return') }}</x-button>
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
            const taskTypeRadios = document.querySelectorAll('input[name="task_type"]');
            const taskContractContainer = document.getElementById('task-contract-container');

            taskTypeRadios.forEach(radio => {
                radio.addEventListener('change', () => {
                    if (radio.value === '2') {
                        taskContractContainer.style.display = 'none';
                    } else {
                        taskContractContainer.style.display = 'block';
                    }
                });
            });
        </script>
        >

        <script>
            $(document).ready(function() {
                $(":input").inputmask();
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
                $("#task_budget_it_investment, #task_budget_gov_utility, #task_budget_it_operating").on("input",
                    function() {
                        var max = 0;
                        var fieldId = $(this).attr('id');

                        if (fieldId === "task_budget_it_investment") {
                            max = parseFloat(
                                {{ $request->budget_it_investment - $sum_task_budget_it_investment }});
                        } else if (fieldId === "task_budget_gov_utility") {
                            max = parseFloat({{ $request->budget_gov_utility - $sum_task_budget_gov_utility }});
                        } else if (fieldId === "task_budget_it_operating") {
                            max = parseFloat({{ $request->budget_it_operating - $sum_task_budget_it_operating }});
                        }

                        var current = parseFloat($(this).val().replace(/,/g, ""));
                        if (current > max) {
                            alert("จำนวนเงินที่ใส่ต้องไม่เกิน " + max.toFixed(2) + " บาท");
                            $(this).val(max.toFixed(2));
                        }
                    });
            });
        </script>




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

                $("#task_start_date, #task_end_date,#task_pay_date").datepicker({
                    changeMonth: true,
                    changeYear: true,

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
                    ]
                });
            });
        </script>

    </x-slot:javascript>
</x-app-layout>
