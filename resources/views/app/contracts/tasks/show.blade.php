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
                        <div class="col-3">{{ __('สถานะสัญญา') }}</div>
                        <div class="col-9">
                            <?php
                            echo isset($taskcon) && $taskcon->taskcon_status == 2
                                ? '<span style="color:red;">ดำเนินการแล้วเสร็จ</span>'
                                : '<span style="color:green;">อยู่ในระหว่างดำเนินการ</span>';
                            ?>
                        </div>
                      </div>
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
              <div class="row">
                <div class="col-3">{{ __('วันที่เริ่มสัญญา') }}</div>
                <div class="col-9">{{ \Helper::date($taskcon->taskcon_start_date) }}</div>
              </div>

              <div class="row">
                <div class="col-3">{{ __('วันที่สิ้นสุดสัญญา') }}</div>
                <div class="col-9">{{ \Helper::date($taskcon->taskcon_end_date) }}</div>
              </div>
              <div class="row">
                <div class="col-3">{{ __('จำนวนเดือน') }}</div>
                <div class="col-3">{{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse($contract->contract_end_date)) }} เดือน</div>
                <div class="col-3">{{ __('จำนวนวัน') }}</div>
                <div class="col-3">{{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInDays(\Carbon\Carbon::parse($contract->contract_end_date)) }} วัน</div>
              </div>
              <div class="row">
                <div class="col-3">{{ __('ดำเนินการมาแล้ว') }}</div>
                <div class="col-3">{{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse()) }} เดือน</div>
                <div class="col-3">{{ __('ดำเนินการมาแล้ว') }}</div>
                <div class="col-3">{{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInDays(\Carbon\Carbon::parse()) }} วัน</div>
              </div>

              <div class="row">
                <div class="col-3">{{ __('เตือน เหลือเวลา') }}</div>
                <div class="col-9" >


            </div>
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
