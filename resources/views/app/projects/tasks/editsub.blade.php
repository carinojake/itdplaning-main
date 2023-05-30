<x-app-layout>
    <x-slot:content>
        <div class="container-fluid">
            {{ Breadcrumbs::render('project.task.editsub', $project, $task) }}
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
                        <x-card title="{{ __('วงเงินที่ขออนุมัติ/การใช้จ่าย ของ ') }}{{ $task->task_name }}">

                            <form method="POST"
                                action="{{ route('project.task.update', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
                                class="row g-3">
                                @csrf
                                {{ method_field('PUT') }}

                                <div class="row mt-3 callout callout-primary">

                                    <div class="col-md-6">
                                        <label for="task_parent" class="form-label">{{ __('เป็นกิจกรรม') }}</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" id="task_parent_display"
                                            value="{{ $task->task_name }}" disabled readonly>

                                        <input type="hidden" class="form-control" id="task_parent" name="task_parent"
                                            value="{{ $task->task_id }}">

                                        <div class="invalid-feedback">
                                            {{ __('กิจกรรม') }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="task_status" class="form-label">{{ __('สถานะกิจกรรม') }}</label>
                                        <span class="text-danger">*</span>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="task_status"
                                                id="task_status1" value="1" @checked($task->task_status == 1)>
                                            <label class="form-check-label" for="task_status1"
                                                @checked($task->task_status == 1)>
                                                ระหว่างดำเนินการ
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="task_status"
                                                id="task_status2" value="2" @checked($task->task_status == 2)>
                                            <label class="form-check-label" for="task_status2"
                                                @checked($task->task_status == 2)>
                                                ดำเนินการแล้วเสร็จ
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="task_type" class="form-label">{{ __('งาน/โครงการ') }}</label> <span
                                            class="text-danger">*</span>
                                        <div>
                                            <input class="form-check-input" type="radio" name="task_type"
                                                id="task_type1" value="1" @checked($task->task_type == 1)>
                                            <label class="form-check-label" for="task_type1"
                                                @checked($task->task_type == 1)>
                                                มี PA
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="task_type"
                                                id="task_type2" value="2" @checked($task->task_type == 2)>
                                            <label class="form-check-label" for="task_type2"
                                                @checked($task->task_type == 2)>
                                                ไม่มี PA
                                            </label>
                                        </div>
                                    </div>


                                    @if (session('contract_id'))
                                        ID: {{ session('contract_id') }}
                                    @endif
                                    @if (session('contract_number'))
                                        Number: {{ session('contract_number') }}
                                    @endif
                                    @if (session('contract_name'))
                                        Name: {{ session('contract_name') }}
                                    @endif
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="task_contract"
                                                    class="form-label">{{ __('สัญญา') }}</label> <span
                                                    class="text-danger">*</span>
                                                <select name="task_contract" id="task_contract" class="form-control">
                                                    <option value="">ไม่มี</option>
                                                    @foreach ($contracts as $contract)
                                                        <option value="{{ $contract->contract_id }}"
                                                            {{ session('contract_id') == $contract->contract_id ? 'selected' : '' }}>
                                                            [{{ $contract->contract_number }}]{{ $contract->contract_name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <div class="invalid-feedback">
                                                    {{ __('สัญญา') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-4">
                                            {{--  <a href="{{ route('contract.create', ['origin' => $project,'project'=>$project ,'taskHashid' => $task->hashid]) }}" class="btn btn-success text-white">เพิ่มสัญญา/ใบจ้าง</a> --}}
                                            <a href="{{ route('contract.create', ['origin' => $project, 'project' => $project, 'taskHashid' => $task->hashid]) }}"
                                                class="btn btn-success text-white"
                                                target="contractCreate">เพิ่มสัญญา/ใบจ้าง</a>
                                        </div>
                                    </div>
                               {{--      <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="task_start_date"
                                                class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span
                                                class="text-danger">*</span>
                                            <div data-coreui-toggle="date-picker" id="task_start_date"
                                                data-coreui-format="dd/MM/yyyy"
                                                data-coreui-date="{{ date('m/d/Y', $task->task_start_date) }} "></div>

                                        </div>
                                        <div class="col-md-6">
                                            <label for="task_end_date"
                                                class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span
                                                class="text-danger">*</span>

                                            <div data-coreui-toggle="date-picker" id="task_end_date"
                                                data-coreui-format="dd/MM/yyyy"
                                                data-coreui-date="{{ date('m/d/Y', $task->task_end_date) }} "></div>
                                        </div>
                                    </div> --}}


                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="task_start_date" class="form-label">{{ __('วันที่เริ่มต้น') }}</label>
                                            <input class="form-control" id="task_start_date" name="task_start_date"
                                                value="{{ \Helper::date4(date('Y-m-d H:i:s', $task->task_start_date)) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="task_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }}</label>
                                            <input class="form-control" id="task_end_date" name="task_end_date"
                                                value="{{ \Helper::date4(date('Y-m-d H:i:s', $task->task_end_date)) }}">
                                        </div>
                                    </div>







                                    <div class="col-md-12 mt-3">
                                        <label for="task_name"
                                            class="form-label">{{ __('ชื่อรายการที่ใช้จ่าย') }}</label> <span
                                            class="text-danger">*</span>
                                        <input type="text" class="form-control" id="task_name" name="task_name"
                                            value="{{ $task->task_name }}" required autofocus>
                                        <div class="invalid-feedback">
                                            {{ __('ชื่อรายการที่ใช้จ่าย') }}
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label for="task_description"
                                            class="form-label">{{ __('รายละเอียดที่ใช้จ่าย') }}</label>
                                        <textarea class="form-control" name="task_description" id="task_description" rows="10">


                                {{ $task->task_description }}
                            </textarea>
                                        <div class="invalid-feedback">
                                            {{ __('รายละเอียดการที่ใช้จ่าย') }}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <h4>งบประมาณ</h4>

                                        <div class="row">
                                            <div class="col-6">
                                                <strong>วงเงินที่ขออนุมัติ</strong>
                                                <div class="col-md-12">
                                                    <label for="task_budget_it_operating"
                                                        class="form-label">{{ __('งบกลาง ICT') }}</label>
                                                   {{--  <input type="text" placeholder="0.00" step="0.01"
                                                        class="form-control" id="task_budget_it_operating"
                                                        name="task_budget_it_operating" min="0"
                                                        value="{{ $task->task_budget_it_operating }}"> --}}

                                                        <input type="text" placeholder="0.00" step="0.01"
                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                         class="form-control numeral-mask" id="task_budget_it_operating"
                                                         name="task_budget_it_operating" min="0"   value="{{ $task->task_budget_it_operating }}">


                                                    <div class="invalid-feedback">
                                                        {{ __('ระบุงบกลาง ICT') }}
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="task_budget_it_investment"
                                                        class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                         {{--            <input type="text" placeholder="0.00" step="0.01"
                                                        class="form-control" id="task_budget_it_investment"
                                                        name="task_budget_it_investment" min="0"
                                                        value="{{ $task->task_budget_it_investment }}"> --}}
                                                        <input type="text" placeholder="0.00" step="0.01"
                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                         class="form-control numeral-mask" id="task_budget_it_investment"
                                                         name="task_budget_it_investment" min="0"   value="{{ $task->task_budget_it_investment }}">

                                                    <div class="invalid-feedback">
                                                        {{ __('ระบุงบดำเนินงาน') }}
                                                    </div>
                                                </div>


                                                <div class="col-md-12">
                                                    <label for="task_budget_gov_utility"
                                                        class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                              {{--       <input type="text" placeholder="0.00" step="0.01"
                                                        class="form-control" id="task_budget_gov_utility"
                                                        name="task_budget_gov_utility" min="0"
                                                        value="{{ $task->task_budget_gov_utility }}"> --}}

                                                        <input type="text" placeholder="0.00" step="0.01"
                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                         class="form-control numeral-mask" id="task_budget_gov_utility"
                                                         name="task_budget_gov_utility" min="0"   value="{{ $task->task_budget_gov_utility }}">


                                                    <div class="invalid-feedback">
                                                        {{ __('ระบุค่าสาธารณูปโภค') }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6 ">
                                                <strong>ค่าใช้จ่าย</strong>
                                                <div class="col-md-12">
                                                    <label for="task_cost_it_operating"
                                                        class="form-label">{{ __('งบกลาง ICT') }}</label>
                                                {{--     <input type="text"placeholder="0.00" step="0.01"
                                                        class="form-control" id="task_cost_it_operating"
                                                        name="task_cost_it_operating" min="0"
                                                        value="{{ $task->task_cost_it_operating }}">
 --}}
                                                        <input type="text" placeholder="0.00" step="0.01"
                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                         class="form-control numeral-mask" id="task_cost_it_operating"
                                                         name="task_cost_it_operating" min="0"   value="{{ $task->task_cost_it_operating }}">

                                                        <div class="invalid-feedback">
                                                        {{ __('งบกลาง ICT') }}
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="task_cost_it_investment"
                                                        class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                           {{--          <input type="text" placeholder="0.00"
                                                        step="0.01"class="form-control"
                                                        id="task_cost_it_investment" name="task_cost_it_investment"
                                                        min="0" value="{{ $task->task_cost_it_investment }}"> --}}


                                                        <input type="text" placeholder="0.00" step="0.01"
                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                         class="form-control numeral-mask" id="task_cost_it_investment"
                                                         name="task_cost_it_investment" min="0"   value="{{ $task->task_cost_it_investment }}">




                                                        <div class="invalid-feedback">
                                                        {{ __('งบดำเนินงาน') }}
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="task_cost_gov_utility"
                                                        class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                   {{--  <input type="text" placeholder="0.00" step="0.01"
                                                        class="form-control" id="task_cost_gov_utility"
                                                        name="task_cost_gov_utility" min="0"
                                                        value="{{ $task->task_cost_gov_utility }}"> --}}

                                                        <input type="text" placeholder="0.00" step="0.01"
                                                        data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                         class="form-control numeral-mask" id="task_cost_gov_utility"
                                                         name="task_cost_gov_utility" min="0"   value="{{ $task->task_cost_gov_utility }}">



                                                        <div class="invalid-feedback">
                                                        {{ __('ระบุค่าสาธารณูปโภค') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <h4>เบิกจ่าย</h4>
                                        <div class="col-md-6">
                                            <label for="task_pay_date"
                                                class="form-label">{{ __('วันที่เบิกจ่าย') }}</label>
                                                <input class="form-control" id="task_pay_date" name="task_pay_date"
                                                value="{{  \Helper::date4(date('Y-m-d H:i:s', $task->task_pay_date))  }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="task_pay" class="form-label">{{ __('เบิกจ่าย') }}</label>

                                            <input type="text" placeholder="0.00" step="0.01"
                                             data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                              class="form-control numeral-mask" id="task_pay"
                                              name="task_pay" min="0"   value="{{ $task->task_pay }}">

                                         <!--   <input type="number" placeholder="0.00" step="0.01"
                                                class="form-control" id="task_pay" name="task_pay" min="0"  value="{{ $task->task_pay }}">-->
                                            <div class="invalid-feedback">
                                                {{ __('เบิกจ่าย') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>








                                <x-button class="btn-success" type="submit">{{ __('coreuiforms.save') }}</x-button>
                                <x-button link="{{ route('project.show', $project->hashid) }}"
                                    class="btn-light text-black">
                                    {{ __('coreuiforms.return') }}</x-button>
                            </form>
                        </x-card>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:content>
    <x-slot:css>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    </x-slot:css>
    <x-slot:javascript>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

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
