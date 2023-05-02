<x-app-layout>
  <x-slot:content>
    <div class="container-fluid">
      <div class="animated fadeIn">
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <x-card title="{{ $taskcon->taskcon_name }}">
              <x-slot:toolbar>

              </x-slot:toolbar>

<div class="container">
              <div class="row">
                <div class="col-sm">
                    <div class="row">


                    <div class="row">
                <div class="col-3">{{ __('ชื่อ') }}</div>
                <div class="col-9">{{ $taskcon->taskcon_name }} </div>
                    </div>
              <div class="row">
                <div class="col-3">{{ __('เรื่อง') }}</div>
                <div class="col-9">{{ $taskcon->taskcon_description }}</div>
              </div>
              <div class="row">
                <div class="col-3">{{ __('parent') }}</div>
                <div class="col-9">{{ $taskcon->taskcon_parent }}</div>
              </div>



            </div>
              <div class="col-sm">
              <div class="row">
                <div class="col-3">{{ __('บันทึกข้อความ') }}</div>
                <div class="col-9">{{ $taskcon->contract_projectplan }}</div>
              </div>
              <div class="row">
                <div class="col-3">{{ __('จำนวนเงิน PR') }}</div>
                <div class="col-9">{{ $taskcon->taskcon_cost_gov_utility }}</div>
              </div>
              <div class="row">
                <div class="col-3">{{ __('เลขที่ PA') }}</div>
                <div class="col-9">{{ $taskcon->taskcon_cost_it_operating }}</div>
              </div>
              <div class="row">
                <div class="col-3">{{ __('จำนวนเงิน PA') }}</div>
                <div class="col-9">{{ $taskcon->taskcon_cost_gov_investment}}</div>
              </div>
              <div class="row">
                <div class="col-3">{{ __('บันทึก PP') }}</div>
                <div class="col-9">{{ $taskcon->disbursement_taskcons_status}}</div>
              </div>
              <div class="row">
                <div class="col-3">{{ __('เวลา PP') }}</div>
                <div class="col-9">{{ $taskcon->disbursement_taskcons_date}}</div>
              </div>


            </div>




            </x-card>
          </div>
        </div>
      </div>
    </div>
  </x-slot:content>

  <x-slot:css>
    <link rel="stylesheet" href="{{ asset('/vendors/dhtmlx/dhtmlxgantt.css') }}" type="text/css">
  </x-slot:css>
  <x-slot:javascript>

    </script>
  </x-slot:javascript>
</x-app-layout>
