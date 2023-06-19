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

                        <x-card>


                            <form method="POST" action="{{ route('project.storesub') }}" class="row g-3 needs-validation" novalidate>
                                @csrf
                                <h2>เพิ่มรายการ สัญญา</h2>


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
                                <div class=" row mt-3">

                                    <div class="d-none  col-md-4">
                                        <label for="task_type" class="form-label">{{ __('งาน/โครงการ') }}</label> <span
                                            class="text-danger">*</span>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="task_type"
                                                id="task_type1" value="1" checked>
                                            <label class="form-check-label" for="task_type1">
                                                มี PA
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="task_type"
                                                id="task_type2" value="2">
                                            <label class="form-check-label" for="task_type2">
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
                                    @if (session('contract_mm_budget'))
                                        MM: {{ session('contract_mm_budget') }}
                                    @endif
                                    @if (session('contract_pr_budget'))
                                    Pr: {{ session('contract_pr_budget') }}
                                @endif
                                @if (session('contract_pa_budget'))
                                pa: {{ session('contract_pa_budget') }}
                            @endif
                            @if (session('contract_start_date'))
                            start_date:  {{ Helper::Date4(date('Y-m-d H:i:s', (session('contract_start_date')))) }}



                        @endif
                        @if (session('contract_end_date'))
                        end_date:  {{ Helper::Date4(date('Y-m-d H:i:s', (session('contract_end_date')))) }}
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

                                        @if (session('contract_id') == 0)
                                        <div class="col-md-3 mt-4">
                                            {{--  <a href="{{ route('contract.create', ['origin' => $project,'project'=>$project ,'taskHashid' => $task->hashid]) }}" class="btn btn-success text-white">เพิ่มสัญญา/ใบจ้าง</a> --}}
                                            <a href="{{ route('contract.create', ['origin' => $project, 'project' => $project]) }}"
                                                class="btn btn-success text-white"
                                                target="contractCreate">เพิ่มสัญญา</a>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="task_start_date" class="form-label">{{ __('วันที่เริ่มต้น') }}</label>
                                            <span class="text-danger">*</span>
                                            <input class="form-control" id="project_start_date" name="project_start_date"
                                                value= {{ Helper::Date4(date('Y-m-d H:i:s', (session('contract_start_date')))) }}
                                                 required>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="task_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }}</label>
                                            <span class="text-danger">*</span>
                                            <input class="form-control" id="project_end_date" name="project_end_date"
                                                value= {{ Helper::Date4(date('Y-m-d H:i:s', (session('contract_end_date')))) }}
                                                required>
                                        </div>
                                    </div>



                                    <div class="col-md-12 mt-3">
                                        <label for="task_name"
                                            class="form-label">{{ __('ชื่อรายการที่ใช้จ่าย') }}</label> <span
                                            class="text-danger">*</span>
                                        <input type="text" class="form-control" id="project_name" name="task_name"
                                        value= {{ session('contract_name') }}>
                                        <div class="invalid-feedback">
                                            {{ __('ชื่อรายการที่ใช้จ่าย') }}
                                        </div>

                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label for="task_description"
                                            class="form-label">{{ __('รายละเอียดที่ใช้จ่าย') }}</label>
                                        <textarea class="form-control" name="project_description" id="task_description" rows="10"></textarea>
                                        <div class="invalid-feedback">
                                            {{ __('รายละเอียดการที่ใช้จ่าย') }}
                                        </div>
                                    </div>
                            </div>
                        </div>
                                <x-button class="btn-success" type="submit">{{ __('coreuiforms.save') }}</x-button>
                                <x-button link="{{ route('project.index') }}" class="text-black btn-light">
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

      {{--  <script>
            $(document).ready(function() {
                $("#task_budget_it_investment, #task_budget_gov_utility, #task_budget_it_operating      ,#task_cost_it_investment,#task_cost_gov_utility,#task_cost_it_operating").on("input",
                    function() {
                        var max = 0;
                        var fieldId = $(this).attr('id');

                        if (fieldId === "task_budget_it_investment" ) {
                            max = parseFloat({{ $task->task_budget_it_investment }});
                        } else if (fieldId === "task_budget_gov_utility"   ) {
                            max = parseFloat({{ $task->task_budget_gov_utility }});
                        } else if (fieldId === "task_budget_it_operating"  ) {
                            max = parseFloat({{ $task->task_budget_it_operating }});
                        } else if (fieldId === "task_cost_it_investment"  ) {
                            max = parseFloat({{ $task->task_budget_it_investment }});
                        } else if (fieldId === "task_cost_gov_utility"  ) {
                            max = parseFloat({{ $task->task_budget_gov_utility }});
                        } else if (fieldId === "task_cost_it_operating"  ) {
                            max = parseFloat({{ $task->task_budget_it_operating }});
                        }
                        var current = parseFloat($(this).val().replace(/,/g, ""));
                        if (current > max) {
                            alert("จำนวนเงินที่ใส่ต้องไม่เกิน " + max.toFixed(2) + " บาท");
                            $(this).val(max.toFixed(2));
                        }
                    });
            });
        </script> --}}




        <script>
            // สร้างฟังก์ชันสำหรับเพิ่มรายการสัญญา
            function addContractOption(contract) {
                const selectElement = document.getElementById('task_contract');
                const optionElement = document.createElement('option');
                optionElement.value = contract.contract_id;
                optionElement.textContent = `[${contract.contract_number}]${contract.contract_name}`;
                selectElement.appendChild(optionElement);
            }

            // ตั้งค่าฟังก์ชันเมื่อกดปุ่ม "เพิ่มสัญญา/ใบจ้าง"
            const addContractButton = document.querySelector('.add-contract-button');
            addContractButton.addEventListener('click', async () => {
                // ทำ AJAX request เพื่อเพิ่มสัญญาใหม่
                const contractData = {}; // รับข้อมูลสัญญาจากฟอร์ม
                const response = await fetch('/api/contracts', {
                    method: 'POST',
                    body: JSON.stringify(contractData),
                    headers: {
                        'Content-Type': 'application/json'
                    },
                });

                if (response.ok) {
                    const newContract = await response.json();
                    // เพิ่มรายการสัญญาใหม่ลงใน <select>
                    addContractOption(newContract);
                }
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

                $("#task_start_date, #task_end_date").datepicker({

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
