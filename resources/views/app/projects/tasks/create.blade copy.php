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
            <x-card title="{{ __('เพิ่มกิจกรรม') }}">
              <form method="POST" action="{{ route('project.task.store', $project) }}" class="row g-3">
                @csrf
                <div class="col-md-12">
                  <label for="task_name" class="form-label">{{ __('ชื่อกิจกรรม') }}</label> <span class="text-danger">*</span>
                  <input type="text" class="form-control" id="task_name" name="task_name" required autofocus>
                  <div class="invalid-feedback">
                    {{ __('ชื่อกิจกรรมซ้ำ') }}
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="task_description" class="form-label">{{ __('รายละเอียดกิจกรรม') }}</label>
                  <textarea class="form-control" name="task_description" id="task_description" rows="10"></textarea>
                  <div class="invalid-feedback">
                    {{ __('รายละเอียดกิจกรรม') }}
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="task_parent" class="form-label">{{ __('เป็นกิจกรรมย่อย') }}</label> <span class="text-danger">*</span>
                  {{-- <input type="text" class="form-control" id="task_parent" name="task_parent"> --}}
                  <select name="task_parent" id="task_parent" class="from-control">
                    <option value="">ไม่มี</option>
                    @foreach ($tasks as $task)
                      <option value="{{ $task->task_id }}">{{ $task->task_name }}</option>
                    @endforeach
                  </select>
                  <div class="invalid-feedback">
                    {{ __('กิจกรรมย่อย') }}
                  </div>
                </div>

                <div class="col-md-12">
                  <label for="task_contract" class="form-label">{{ __('สัญญา') }}</label> <span class="text-danger">*</span>
                  {{-- <input type="text" class="form-control" id="task_contract" name="task_contract"> --}}
                  <select name="task_contract" id="task_contract" class="from-control">
                    <option value="">ไม่มี</option>
                    @foreach ($contracts as $contract)
                      <option value="{{ $contract->contract_id }}">[{{ $contract->contract_number }}]{{ $contract->contract_name }}</option>
                    @endforeach
                  </select>
                  <div class="invalid-feedback">
                    {{ __('สัญญา') }}
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="task_start_date" class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span class="text-danger">*</span>
                  {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                  <div data-coreui-toggle="date-picker" id="task_start_date" data-coreui-format="dd/MM/yyyy"></div>
                </div>
                <div class="col-md-6">
                  <label for="task_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span class="text-danger">*</span>
                  {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                  <div data-coreui-toggle="date-picker" id="task_end_date" data-coreui-format="dd/MM/yyyy"></div>
                </div>


                <div class="row">
                  <h4>งบประมาณ</h4>

                  <div class="row">
                    <div class="col-6">
                      <strong>เงินงบประมาณ (งบประมาณขอรัฐบาล)</strong>
                      <div class="col-md-12">
                        <label for="task_budget_gov_operating" class="form-label">{{ __('งบดำเนินงาน (ค่าใช้สอยต่างๆ)') }}</label>
                        <input type="number" placeholder="0.00" step="0.01" class="form-control" id="task_budget_gov_operating" name="task_budget_gov_operating" min="0">
                        <div class="invalid-feedback">
                          {{ __('ระบุงบดำเนินงาน (ค่าใช้สอยต่างๆ)') }}
                        </div>
                      </div>
                      <div class="col-md-12">
                        <label for="task_budget_gov_investment" class="form-label">{{ __('งบลงทุน IT (ครุภัณฑ์ต่างๆ)') }}</label>
                        <input type="number" placeholder="0.00" step="0.01" class="form-control" id="task_budget_gov_investment" name="task_budget_gov_investment" min="0">
                        <div class="invalid-feedback">
                          {{ __('ระบุงบลงทุน IT (ครุภัณฑ์ต่างๆ)') }}
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

                    <div class="col-6">
                      <strong>เงินงบกลาง IT</strong>
                      <div class="col-md-12">
                        <label for="task_budget_it_operating" class="form-label">{{ __('งบดำเนินงาน (ค่าใช้สอยต่างๆ)') }}</label>
                        <input type="number" placeholder="0.00" step="0.01" class="form-control" id="task_budget_it_operating" name="task_budget_it_operating" min="0">
                        <div class="invalid-feedback">
                          {{ __('ระบุงบดำเนินงาน (ค่าใช้สอยต่างๆ)') }}
                        </div>
                      </div>
                      <div class="col-md-12">
                        <label for="task_budget_it_investment" class="form-label">{{ __('งบลงทุน IT (ครุภัณฑ์ต่างๆ)') }}</label>
                        <input type="number" placeholder="0.00" step="0.01" class="form-control" id="task_budget_it_investment" name="task_budget_it_investment" min="0">
                        <div class="invalid-feedback">
                          {{ __('ระบุงบลงทุน IT (ครุภัณฑ์ต่างๆ)') }}
                        </div>
                      </div>

                    </div>
                  </div>
                </div>

                <div class="row">
                  <h4>ค่าใช้จ่าย</h4>

                  <div class="row">
                    <div class="col-6">
                      <strong>เงินงบประมาณ (งบประมาณขอรัฐบาล)</strong>
                      <div class="col-md-12">
                        <label for="task_cost_gov_operating" class="form-label">{{ __('งบดำเนินงาน (ค่าใช้สอยต่างๆ)') }}</label>
                        <input type="number" class="form-control" id="task_cost_gov_operating" name="task_cost_gov_operating" min="0">
                        <div class="invalid-feedback">
                          {{ __('ระบุงบดำเนินงาน (ค่าใช้สอยต่างๆ)') }}
                        </div>
                      </div>
                      <div class="col-md-12">
                        <label for="task_cost_gov_investment" class="form-label">{{ __('งบลงทุน IT (ครุภัณฑ์ต่างๆ)') }}</label>
                        <input type="number" class="form-control" id="task_cost_gov_investment" name="task_cost_gov_investment" min="0">
                        <div class="invalid-feedback">
                          {{ __('ระบุงบลงทุน IT (ครุภัณฑ์ต่างๆ)') }}
                        </div>
                      </div>
                      <div class="col-md-12">
                        <label for="task_cost_gov_utility" class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                        <input type="number" class="form-control" id="task_cost_gov_utility" name="task_cost_gov_utility" min="0">
                        <div class="invalid-feedback">
                          {{ __('ระบุค่าสาธารณูปโภค') }}
                        </div>
                      </div>
                    </div>

                    <div class="col-6">
                      <strong>เงินงบกลาง IT</strong>
                      <div class="col-md-12">
                        <label for="task_cost_it_operating" class="form-label">{{ __('งบดำเนินงาน (ค่าใช้สอยต่างๆ)') }}</label>
                        <input type="number" class="form-control" id="task_cost_it_operating" name="task_cost_it_operating" min="0">
                        <div class="invalid-feedback">
                          {{ __('ระบุงบดำเนินงาน (ค่าใช้สอยต่างๆ)') }}
                        </div>
                      </div>
                      <div class="col-md-12">
                        <label for="task_cost_it_investment" class="form-label">{{ __('งบลงทุน IT (ครุภัณฑ์ต่างๆ)') }}</label>
                        <input type="number" class="form-control" id="task_cost_it_investment" name="task_cost_it_investment" min="0">
                        <div class="invalid-feedback">
                          {{ __('ระบุงบลงทุน IT (ครุภัณฑ์ต่างๆ)') }}
                        </div>
                      </div>

                    </div>
                  </div>
                </div>

                <x-button class="btn-success" type="submit">{{ __('coreuiforms.save') }}</x-button>
                <x-button link="{{ route('project.show', $project) }}" class="btn-light text-black">{{ __('coreuiforms.return') }}</x-button>
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

  </x-slot:javascript>
</x-app-layout>
