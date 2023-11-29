<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalToggleLabel" style="color:dark">งบประมาณที่คงเหลือที่ใช้ได้</h5>
          <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="color:dark">


            @if ($project['budget_it_operating'] > 0)
            @if($budget['budget_it_operating']<$budget['op_totol_task_budget_it_operating'] ||$budget['budget_it_operating']===$budget['op_totol_task_budget_it_operating'] )
            งบกลาง ICT 1 :    {{   number_format(($budget['budget_it_operating']-$budget['op_totol_task_budget_it_operating'])+$budget['op_total_task_refund_pa_budget_3'],2)}} บาท <br>

               <!-- Content for Activity tab -->
               @include('partials.icttopactivity')

            @elseif($budget['budget_it_operating']>$budget['op_totol_task_budget_it_operating'])
            งบกลาง ICT 2 :  {{ number_format($budget['budget_total_task_budget_end_operating'], 2) }} บาท <br>
            @endif


            @endif


            @if ($project['budget_it_investment'] > 0)
           @if($budget['budget_it_investment']<$budget['in_totol_task_budget_it_investment'] ||$budget['budget_it_investment']===$budget['in_totol_task_budget_it_investment']  )
           <p>
           งบดำเนินงาน :   {{ number_format(($budget['budget_it_investment']-$budget['in_totol_task_budget_it_investment'])+ $budget['in_total_task_refund_pa_budget_3'],2)}} บาท <br>
               <p>
               <!-- Content for Activity tab -->
               @include('partials.intopactivity')


               @elseif($budget['budget_it_investment']>$budget['in_totol_task_budget_it_investment'])

                   <p>
               งบดำเนินงาน 2 :  {{ number_format($budget['budget_total_task_budget_end_investment'], 2) }} บาท <br>

               @include('partials.intopactivity')
               @endif

            @endif
        @if ($project['budget_gov_utility'] > 0)
            @if($budget['budget_gov_utility']<$budget['ut_totol_task_budget_gov_utility'] ||$budget['budget_gov_utility']===$budget['ut_totol_task_budget_gov_utility']  )
            <p>
            งบสาธารณูปโภค 1:    {{  number_format(($budget['budget_gov_utility']-$budget['ut_totol_task_budget_gov_utility'])+ $budget['ut_total_task_refund_pa_budget_3'],2)}} บาท <br>
            <p>   <!-- Content for Activity tab -->
               @include('partials.uttopactivity')

               @elseif($budget['budget_gov_utility']>$budget['ut_totol_task_budget_gov_utility'])
               <p>
               งบสาธารณูปโภค 2:  {{ number_format($budget['budget_total_task_budget_end_utility'], 2) }} บาท <br>


        @endif
        @endif





        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" data-coreui-target="#exampleModalToggle2" data-coreui-toggle="modal">Open second modal</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalToggleLabel2">Modal 2</h5>
          <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Hide this modal and show the first with the button below.

        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" data-coreui-target="#exampleModalToggle" data-coreui-toggle="modal">Back to first</button>
        </div>
      </div>
    </div>
  </div>





  <button class="btn btn" data-coreui-target="#exampleModalToggle" data-coreui-toggle="modal">



    <div class="fs-4 fw-semibold text-blue">
        {{--                                     <p> {{ number_format( $budget['budget_total_refund_pa_budget_end'], 2) }}
         --}}



                                                            @if ( $budget['project_type'] == 1)
                                            @if($budget['total']>$budget['total_op_totol_task_budget_it_op_in_ut_root'] || $budget['total']===$budget['total_task_budget'])
                                          {{ number_format($budget['budget_total_refund_pa_budget_end'], 2) }}


                                          @elseif($budget['total']<$budget['total_op_totol_task_budget_it_op_in_ut_root']  )
                                            {{ number_format(floatval($budget['totalrefund_top']), 2) }}

                                            @endif
                                           {{--  {{ number_format($budget['budget_total_refund_pa_budget_end'], 2) }}
         --}}



                                            @elseif( $budget['project_type'] == 2 )
                                            {{ number_format(floatval( $budget['budget_total_task_root_op_in_ut_rf']), 2) }}

                                            @elseif( $budget['project_type'] == 2)
                                            {{ number_format(floatval( $budget['budget_total_task_root_op_in_ut_rf']), 2) }}



                                            @endif
                                        </div></button>
