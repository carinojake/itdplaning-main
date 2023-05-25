<x-app-layout>
    <x-slot:content>

        <div class="container-fluid">

            {{ Breadcrumbs::render('contract.task.edit', $contract, $taskcon) }}
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
                        <x-card title="{{ __('แก้ไขกิจกรรม') }} {{ $taskcon->taskcon_name }}">
                            <form method="POST"
                                action="{{ route('contract.task.update', ['contract' => $contract->Hashid, 'taskcon' => $taskcon->hashid]) }}"
                                class="row g-3">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <div class="col-md-12 ">
                                        <label for="taskcon_contract" class="form-label">{{ __('สัญญา') }}</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" id="taskcon_contract"
                                            name="taskcon_contract"
                                            value="[{{ $contract->contract_number }}]{{ $contract->contract_name }}"
                                            readonly>
                                    </div>


                                    <div class="col-md-12 mt-3 ">
                                        <label for="taskcon_name">ชื่อ กิจกรรม</label>
                                        <input type="text" class="form-control" id="taskcon_name" name="taskcon_name"
                                            value="{{ $taskcon->taskcon_name }}">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="taskcon_description">กิจกรรม</label>
                                        <textarea class="form-control" id="taskcon_description" name="taskcon_description">{{ $taskcon->taskcon_description }}</textarea>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6 mt-3">
                                        <label for="taskcon_start_date"
                                            class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span
                                            class="text-danger">*</span>
                                        {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                                        <div data-coreui-toggle="date-picker" id="taskcon_start_date"
                                            data-coreui-format="dd/MM/yyyy" data-coreui-locale="th-TH"
                                            data-coreui-date="{{ date('m/d/Y', $taskcon->taskcon_start_date) }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label for="taskcon_end_date"
                                            class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span
                                            class="text-danger">*</span>
                                        {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                                        <div data-coreui-toggle="date-picker" id="taskcon_end_date"
                                            data-coreui-format="dd/MM/yyyy" data-coreui-locale="th-TH"
                                            data-coreui-date="{{ date('m/d/Y', $taskcon->taskcon_end_date) }}">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <h4>งบประมาณ</h4>

                                    <div class="row">
                                        <div class="col-6">
                                            <strong>เงินงบประมาณ </strong>
                                            <div class="col-md-12">
                                                <label for="taskcon_budget_it_operating"
                                                    class="form-label">{{ __('งบกลาง ICT') }}</label>
                                                <input type="number" placeholder="0.00" step="0.01"
                                                    class="form-control" id="taskcon_budget_it_operating"
                                                    name="taskcon_budget_it_operating" min="0"
                                                    value="{{ $taskcon->taskcon_budget_it_operating }}">
                                                <div class="invalid-feedback">
                                                    {{ __('ระบุงบกลาง ICT') }}
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="taskcon_budget_it_investment"
                                                    class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                <input type="number" placeholder="0.00" step="0.01"
                                                    class="form-control" id="taskcon_budget_it_investment"
                                                    name="taskcon_budget_it_investment" min="0"
                                                    value="{{ $taskcon->taskcon_budget_it_investment }}">
                                                <div class="invalid-feedback">
                                                    {{ __('ระบุงบดำเนินงาน') }}
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="taskcon_budget_gov_utility"
                                                    class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                <input type="number" placeholder="0.00" step="0.01"
                                                    class="form-control" id="taskcon_budget_gov_utility"
                                                    name="taskcon_budget_gov_utility" min="0"
                                                    value="{{ $taskcon->taskcon_budget_gov_utility }}">
                                                <div class="invalid-feedback">
                                                    {{ __('ระบุค่าสาธารณูปโภค') }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <strong>ค่าใช้จ่าย</strong>
                                            <div class="col-md-12">
                                                <label for="taskcon_cost_it_operating"
                                                    class="form-label">{{ __('งบกลาง ICT') }}</label>
                                                <input type="number" placeholder="0.00" step="0.01"
                                                    class="form-control" id="taskcon_cost_it_operating"
                                                    name="taskcon_cost_it_operating" min="0"
                                                    value="{{ $taskcon->taskcon_cost_it_operating }}">
                                                <div class="invalid-feedback">
                                                    {{ __('งบกลาง ICT') }}
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="taskcon_cost_it_investment"
                                                    class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                <input type="number" placeholder="0.00" step="0.01"
                                                    class="form-control" id="taskcon_cost_it_investment"
                                                    name="taskcon_cost_it_investment" min="0"
                                                    value="{{ $taskcon->taskcon_cost_it_investment }}">
                                                <div class="invalid-feedback">
                                                    {{ __('งบดำเนินงาน') }}
                                                </div>
                                            </div>




                                            <div class="col-md-12">
                                                <label for="taskcon_cost_gov_utility"
                                                    class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                <input type="number" placeholder="0.00" step="0.01"
                                                    class="form-control" id="taskcon_cost_gov_utility"
                                                    name="taskcon_cost_gov_utility" min="0"
                                                    value="{{ $taskcon->taskcon_cost_gov_utility }}">
                                                <div class="invalid-feedback">
                                                    {{ __('ระบุค่าสาธารณูปโภค') }}
                                                </div>
                                            </div>
                                        </div>

                                    </div>




                                </div>




                                <div class="row mt-3">
                                    <h4>เบิกจ่าย</h4>

                                <div class="col-md-4">
                                    <label for="taskcon_pay_date"
                                        class="form-label">{{ __('วันที่เบิกจ่าย') }}</label>

                                    {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                                    <div data-coreui-toggle="date-picker" id="taskcon_pay_date"
                                        data-coreui-locale="th-TH" data-coreui-format="dd/MM/yyyy"
                                        data-coreui-date="{{ $taskcon->taskcon_pay_date }}"></div>
                                </div>



                                <div class="col-md-4">
                                    <label for="disbursement_taskcons_status"
                                        class="form-label">{{ __('เลขที่ PP') }}</label>

                                        <input type="text" class="form-control" id="disbursement_taskcons_status" name="disbursement_taskcons_status"
                                            value="{{ $taskcon->disbursement_taskcons_status }}">
                                    {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}




                                </div>



                                <div class="col-md-4">
                                    <label for="taskcon_pay" class="form-label">{{ __('เบิกจ่าย') }}</label>
                                    <input type="number" placeholder="0.00" step="0.01" class="form-control"
                                        id="taskcon_pay" name="taskcon_pay" min="0"
                                        value="{{ $taskcon->taskcon_pay }}">
                                    <div class="invalid-feedback">
                                        {{ __('เบิกจ่าย') }}
                                    </div>
                                </div>
                                </div>
                                 {{--  <div class="col-md-12">
                                    <label for="taskcon_parent"
                                        class="form-label">{{ __('เป็นกิจกรรมย่อย') }}</label> <span
                                        class="text-danger"></span>
                                    <input type="text" class="form-control" id="taskcon_parent"
                                        name="taskcon_parent" value="{{ $taskcon->taskcon_parent }}">
                                     <select name="taskcon_parent" id="taskcon_parent" class="from-control">
                          <option value="">ไม่มี</option>
                           @foreach ($taskcons as $taskcon)
                            <option value="{{ $taskcon->taskcon_id }}">{{ $taskcon->taskcon_name }}</option>
                          @endforeach
                        </select>
                        <div class="invalid-feedback">
                          {{ __('กิจกรรมย่อย') }}
                        </div> --}}
                                </div>


                                {{-- <select name="taskcon_contract" id="taskcon_contract" class="from-control">
                          <option value="">ไม่มี</option>
                          @foreach ($contractcons as $contract)
                            <option value="{{ $contract->contract_id }}">[{{ $contract->contract_number }}]{{ $contract->contract_name }}</option>
                          @endforeach
                        </select>
                        <div class="invalid-feedback">
                          {{ __('สัญญา') }}
                        </div> --}}



                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
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
