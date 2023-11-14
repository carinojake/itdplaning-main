<x-app-layout>
  <x-slot:content>
    <div class="container-fluid">
        {{ Breadcrumbs::render('contract.task.show', $contract,$taskcon) }}
      <div class="animated fadeIn">
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <x-card title="{{ $taskcon->taskcon_name }}">
              <x-slot:toolbar>
                <a href="{{ route('contract.task.editview', ['contract' => $contract->hashid, 'taskcon' => $taskcon->hashid]) }}"
                    class="btn-sm btn btn-warning text-white"> <i class="cil-cog">
                      </i>
                </a>
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
              {{-- <div class="row">
                <div class="col-3">{{ __('parent') }}</div>
                <div class="col-9">{{ $taskcon->taskcon_parent }}</div>
              </div> --}}



            </div>
              <div class="col-sm">
               <div class="row">
                <div class="col-3">{{ __('บันทึกข้อความ') }}</div>
                <div class="col-9">{{ $taskcon->taskcon_projectplan }}</div>
              </div>
              <div class="row">
                <div class="col-3">{{ __('การเบิกจ่าย') }}</div>


                <div class="col-9">

                    @if($taskcon->taskcon_budget_it_operating > 0)
                    {{ number_format($taskcon->taskcon_cost_it_operating,2) }} บาท
                    @elseif($taskcon->taskcon_budget_it_investment > 0)
                    {{ number_format($taskcon->taskcon_cost_it_investment,2) }} บาท
                    @elseif ($taskcon->taskcon_budget_gov_utility > 0)
                    {{ number_format($taskcon->taskcon_cost_gov_utility,2) }} บาท
                    @endif


                </div>
              </div>
              <div class="row">
                <div class="col-3">{{ __('เลขที่ PP') }}</div>
                <div class="col-9">{{ $taskcon->taskcon_pp }}</div>
              </div>
              <div class="row">
                <div class="col-3">{{ __('จำนวนเงิน PP') }}</div>
                <div class="col-9">{{ number_format($taskcon->taskcon_pay,2)}} บาท</div>
              </div>
             {{--  <div class="row">
                <div class="col-3">{{ __('บันทึก PP') }}</div>
                <div class="col-9">{{ $taskcon->disbursement_taskcons_status}}</div>
              </div> --}}
              <div class="row">
                <div class="col-3">{{ __('เวลา PP') }}</div>
                <div class="col-9">  {{ $taskcon->taskcon_pay_date ? Helper::Date4($taskcon->taskcon_pay_date) : '' }}
                </div>
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
