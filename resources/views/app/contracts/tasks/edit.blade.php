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
            <x-card title="{{ __('แก้ไขกิจกรรม') }} {{ $taskcon->taskcon_name }}">
                <form method="POST" action="{{ route('contract.task.update', ['contract' => $contract->Hashid, 'taskcon' => $taskcon->hashid]) }}" class="row g-3">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="taskcon_name">Taskcon Name</label>
                        <input type="text" class="form-control" id="taskcon_name" name="taskcon_name" value="{{ $taskcon->taskcon_name }}">
                    </div>
                    <div class="form-group">
                        <label for="taskcon_description">Taskcon Description</label>
                        <textarea class="form-control" id="taskcon_description" name="taskcon_description">{{ $taskcon->taskcon_description }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="taskcon_start_date" class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span class="text-danger">*</span>
                        {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                        <div data-coreui-toggle="date-picker" id="taskcon_start_date" data-coreui-format="dd/MM/yyyy" data-coreui-date="{{ date('m/d/Y', $taskcon->taskcon_start_date) }}"></div>
                      </div>
                      <div class="col-md-6">
                        <label for="taskcon_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span class="text-danger">*</span>
                        {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                        <div data-coreui-toggle="date-picker" id="taskcon_end_date" data-coreui-format="dd/MM/yyyy" data-coreui-date="{{ date('m/d/Y', $taskcon->taskcon_end_date) }}"></div>
                      </div>
                    <div class="form-group">
                        <label for="taskcon_budget_gov_utility">Budget (Govt. Utility)</label>
                        <input type="text" class="form-control" id="taskcon_budget_gov_utility" name="taskcon_budget_gov_utility" value="{{ $taskcon->taskcon_budget_gov_utility }}">
                    </div>
                    <div class="form-group">
                        <label for="taskcon_cost_gov_utility">Cost (Govt. Utility)</label>
                        <input type="text" class="form-control" id="taskcon_cost_gov_utility" name="taskcon_cost_gov_utility" value="{{ $taskcon->taskcon_cost_gov_utility }}">
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
