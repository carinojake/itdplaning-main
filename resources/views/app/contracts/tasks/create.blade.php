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
            <x-card title="{{ __('เพิ่มกิจกรรม (สัญญา)') }}">
             <form method="POST" action="{{ route('contract.task.store', $contract) }}" class="row g-3">

                @csrf
                <div class="col-md-12">
                  <label for="taskcon_name" class="form-label">{{ __('ชื่อกิจกรรม') }}</label> <span class="text-danger">*</span>
                  <input type="text" class="form-control" id="taskcon_name" name="taskcon_name" required autofocus>
                  <div class="invalid-feedback">
                    {{ __('ชื่อกิจกรรมซ้ำ') }}
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="taskcon_description" class="form-label">{{ __('รายละเอียดกิจกรรม') }}</label>
                  <textarea class="form-control" name="taskcon_description" id="taskcon_description" rows="10"></textarea>
                  <div class="invalid-feedback">
                    {{ __('รายละเอียดกิจกรรม') }}
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="taskcon_parent" class="form-label">{{ __('เป็นกิจกรรมย่อย') }}</label> <span class="text-danger">*</span>
                  {{-- <input type="text" class="form-control" id="taskcon_parent" name="taskcon_parent"> --}}
                  <select name="taskcon_parent" id="taskcon_parent" class="from-control">
                    <option value="">ไม่มี</option>
                     @foreach ($taskcons as $taskcon)
                      <option value="{{ $taskcon->taskcon_id }}">{{ $taskcon->taskcon_name }}</option>
                    @endforeach
                  </select>
                  <div class="invalid-feedback">
                    {{ __('กิจกรรมย่อย') }}
                  </div>
                </div>

                <div class="col-md-12">
                  <label for="taskcon_contract" class="form-label">{{ __('สัญญา') }}</label> <span class="text-danger">*</span>
                  {{-- <input type="text" class="form-control" id="taskcon_contract" name="taskcon_contract"> --}}
                  <select name="taskcon_contract" id="taskcon_contract" class="from-control">
                    <option value="">ไม่มี</option>
                    @foreach ($contractcons as $contract)
                      <option value="{{ $contract->contract_id }}">[{{ $contract->contract_number }}]{{ $contract->contract_name }}</option>
                    @endforeach
                  </select>
                  <div class="invalid-feedback">
                    {{ __('สัญญา') }}
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="taskcon_start_date" class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span class="text-danger">*</span>
                  {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                  <div data-coreui-toggle="date-picker" id="taskcon_start_date" data-coreui-format="dd/MM/yyyy"></div>
                </div>
                <div class="col-md-6">
                  <label for="taskcon_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span class="text-danger">*</span>
                  {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                  <div data-coreui-toggle="date-picker" id="taskcon_end_date" data-coreui-format="dd/MM/yyyy"></div>
                </div>


                <div class="row">
                  <h4>งบประมาณ</h4>

                  <div class="row">
                    <div class="col-6">
                      <strong>เงินงบประมาณ</strong>


                      <div class="col-md-12">
                        <label for="taskcon_budget_it_operating" class="form-label">{{ __('งบกลาง ICT') }}</label>
                        <input type="number" placeholder="0.00" step="0.01" class="form-control" id="taskcon_budget_it_operating" name="taskcon_budget_it_operating" min="0">
                        <div class="invalid-feedback">
                          {{ __('ระบุงบกลาง ICT') }}
                        </div>
                      </div>
                      <div class="col-md-12">
                        <label for="taskcon_budget_it_investment" class="form-label">{{ __('งบดำเนินงาน') }}</label>
                        <input type="number" placeholder="0.00" step="0.01" class="form-control" id="taskcon_budget_it_investment" name="taskcon_budget_it_investment" min="0">
                        <div class="invalid-feedback">
                          {{ __('งบดำเนินงาน)') }}
                        </div>
                      </div>
                      <div class="col-md-12">
                        <label for="taskcon_budget_gov_utility" class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                        <input type="number" placeholder="0.00" step="0.01" class="form-control" id="taskcon_budget_gov_utility" name="taskcon_budget_gov_utility" min="0">
                        <div class="invalid-feedback">
                          {{ __('ระบุค่าสาธารณูปโภค') }}
                        </div>
                      </div>
                    </div>

                    <div class="col-6">
                      <strong>ค่าใช้จ่าย</strong>
                      <div class="col-md-12">
                        <label for="taskcon_cost_it_operating" class="form-label">{{ __('งบกลาง ICT') }}</label>
                        <input type="number" class="form-control" id="taskcon_cost_it_operating" name="taskcon_cost_it_operating" min="0">
                        <div class="invalid-feedback">
                          {{ __('งบกลาง ICT') }}
                        </div>
                      </div>
                      <div class="col-md-12">
                        <label for="taskcon_cost_it_investment" class="form-label">{{ __('งบดำเนินงาน') }}</label>
                        <input type="number" class="form-control" id="taskcon_cost_it_investment" name="taskcon_cost_it_investment" min="0">
                        <div class="invalid-feedback">
                          {{ __('งบดำเนินงาน)') }}
                        </div>
                      </div>
                     <div class="col-md-12">
                      <label for="taskcon_cost_gov_utility" class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                      <input type="number" class="form-control" id="taskcon_cost_gov_utility" name="taskcon_cost_gov_utility" min="0">
                      <div class="invalid-feedback">
                        {{ __('ระบุค่าสาธารณูปโภค') }}
                      </div>
                    </div>


                    </div>
                  </div>
                </div>


            </div>

                <x-button class="btn-success" type="submit">{{ __('coreuiforms.save') }}</x-button>
                <x-button link="{{ route('contract.show', $contract) }}" class="text-black btn-light">{{ __('coreuiforms.return') }}</x-button>

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


