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
            <x-card title="{{ __('วงเงินที่ขออนุมัติ/การใช้จ่าย ของ ') }}{{ $task->task_name }}">


              <form method="POST" action="{{ route('project.task.store', $project) }}" class="row g-3">
                @csrf


                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="task_parent" class="form-label">{{ __('เป็นกิจกรรม') }}</label>
                        <span class="text-danger">*</span>
                        <input type="text" class="form-control" id="task_parent_display" value="{{ $task->task_name }}" disabled readonly>

                        <input type="hidden" class="form-control" id="task_parent" name="task_parent" value="{{$task->task_id }}">

                        <div class="invalid-feedback">
                            {{ __('กิจกรรม') }}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="task_status" class="form-label">{{ __('สถานะกิจกรรม') }}</label>
                        <span class="text-danger">*</span>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="task_status"
                                id="task_status1" value="1" checked >
                            <label class="form-check-label" for="task_status1">
                                ระหว่างดำเนินการ
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="task_status"
                                id="task_status2" value="2" >
                            <label class="form-check-label" for="task_status2">
                                ดำเนินการแล้วเสร็จ
                            </label>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="task_type" class="form-label">{{ __('งาน/โครงการ') }}</label> <span class="text-danger">*</span>
                        <div >
                            <input class="form-check-input" type="radio" name="task_type" id="task_type1" value="1"
                            >
                          <label class="form-check-label" for="task_type1">
                            มี PA
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="task_type" id="task_type2" value="2"
                           >
                          <label class="form-check-label" for="task_type2">
                            ไม่มี PA
                          </label>
                        </div>
                </div>

                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="task_contract" class="form-label">{{ __('สัญญา') }}</label> <span class="text-danger">*</span>
                            <select name="task_contract" id="task_contract" class="form-control">
                                <option value="">ไม่มี</option>
                                @foreach ($contracts as $contract)
                                    <option value="{{ $contract->contract_id }}">[{{ $contract->contract_number }}]{{ $contract->contract_name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                {{ __('สัญญา') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mt-4">
    <a href="{{ route('contract.create', ['origin' => $project,'project'=>$project ,'taskHashid' => $task->hashid]) }}" class="btn btn-success text-white">เพิ่มสัญญา/ใบจ้าง</a>
</div>



                </div>

                <div class="row mt-3">
                          <div class="col-md-6">
                          <label for="task_start_date" class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span class="text-danger">*</span>
                          {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                          <div data-coreui-toggle="date-picker" id="task_start_date" data-coreui-format="dd/MM/yyyy" ></div>

                        </div>
                        <div class="col-md-6">
                          <label for="task_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span class="text-danger">*</span>
                          {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                          <div data-coreui-toggle="date-picker" id="task_end_date" data-coreui-format="dd/MM/yyyy" ></div>
                        </div>
                    </div>
                <div class="col-md-12 mt-3">
                  <label for="task_name" class="form-label">{{ __('ชื่อรายการที่ใช้จ่าย') }}</label> <span class="text-danger">*</span>
                  <input type="text" class="form-control" id="task_name" name="task_name" required autofocus>
                  <div class="invalid-feedback">
                    {{ __('ชื่อรายการที่ใช้จ่าย') }}
                  </div>
                </div>

                <div class="col-md-12 mt-3">
                  <label for="task_description" class="form-label">{{ __('รายละเอียดที่ใช้จ่าย') }}</label>
                  <textarea class="form-control" name="task_description" id="task_description" rows="10"></textarea>
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
                          <label for="task_budget_it_operating" class="form-label">{{ __('งบกลาง ICT') }}</label>
                          <input type="number" placeholder="0.00" step="0.01" class="form-control" id="task_budget_it_operating" name="task_budget_it_operating" min="0">
                          <div class="invalid-feedback">
                            {{ __('ระบุงบกลาง ICT') }}
                          </div>
                        </div>
                        <div class="col-md-12">
                          <label for="task_budget_it_investment" class="form-label">{{ __('งบดำเนินงาน') }}</label>
                          <input type="number" placeholder="0.00" step="0.01" class="form-control" id="task_budget_it_investment" name="task_budget_it_investment" min="0">
                          <div class="invalid-feedback">
                            {{ __('ระบุงบดำเนินงาน') }}
                          </div>
                        </div>
                        <div class="col-md-12">
                          <label for="task_budget_gov_utility" class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                          <input type="number" placeholder="0.00" step="0.01" class="form-control" id="task_budget_gov_utility" name="task_budget_gov_utility" min="0">
                          <div class="invalid-feedback">
                            {{ __('ระบุค่าสาธารณูปโภค') }}
                          </div>
                        </div>
                      </div>

                      <div class="col-6 ">
                        <strong>ค่าใช้จ่าย</strong>
                        <div class="col-md-12">
                            <label for="task_cost_it_operating" class="form-label">{{ __('งบกลาง ICT') }}</label>
                            <input type="number"placeholder="0.00" step="0.01" class="form-control" id="task_cost_it_operating" name="task_cost_it_operating" min="0">
                            <div class="invalid-feedback">
                              {{ __('งบกลาง ICT') }}
                          </div>
                        </div>
                        <div class="col-md-12">
                            <label for="task_cost_it_investment" class="form-label">{{ __('งบดำเนินงาน') }}</label>
                            <input type="number" placeholder="0.00" step="0.01"class="form-control" id="task_cost_it_investment" name="task_cost_it_investment" min="0">
                            <div class="invalid-feedback">
                              {{ __('งบดำเนินงาน') }}
                          </div>
                        </div>
                        <div class="col-md-12">
                            <label for="task_cost_gov_utility" class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                            <input type="number" placeholder="0.00" step="0.01" class="form-control" id="task_cost_gov_utility" name="task_cost_gov_utility" min="0">
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
                                      <label for="task_pay_date" class="form-label">{{ __('วันที่เบิกจ่าย') }}</label> <span class="text-danger">*</span>
                                      {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                                      <div data-coreui-toggle="date-picker" id="task_pay_date" data-coreui-format="dd/MM/yyyy" data-coreui-locale="th-TH"></div>
                                    </div>

                                    <div class="col-md-6">
                                      <label for="task_pay" class="form-label">{{ __('เบิกจ่าย') }}</label>
                                      <input type="number" placeholder="0.00" step="0.01" class="form-control" id="task_pay" name="task_pay" min="0" >
                                      <div class="invalid-feedback">
                                        {{ __('เบิกจ่าย') }}
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
                headers: { 'Content-Type': 'application/json' },
            });

            if (response.ok) {
                const newContract = await response.json();
                // เพิ่มรายการสัญญาใหม่ลงใน <select>
                addContractOption(newContract);
            }
        });
    </script>

  </x-slot:javascript>
</x-app-layout>
