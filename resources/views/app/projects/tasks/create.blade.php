<x-app-layout>
    <x-slot:content>
        <div class="container-fluid">
            {{ Breadcrumbs::render('project.task.create', $project) }}
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
                            <div class="callout callout-primary row mt-3">

                                <div class="col-md-3">
                                    <label for="project_fiscal_year"
                                        class="form-label">{{ __('ปีงบประมาณ') }}</label>
                                   {{ $projectDetails->project_fiscal_year }}

                                </div>
                                <div class="col-md-3">
                                    <label for="task_start_date2"
                                        class="form-label">{{ __('วันที่เริ่มต้น') }}</label>

                          {{ Helper::Date4(date('Y-m-d H:i:s', $projectDetails->project_start_date)) }}

                                </div>
                                <div class="col-md-3">
                                    <label for="task_end_date2"
                                        class="form-label">{{ __('วันที่สิ้นสุด') }}</label>

                               {{ Helper::Date4(date('Y-m-d H:i:s', $projectDetails->project_end_date)) }}

                                </div>
                                <div class="row">
                                    <div class="col-md-12 mt-3">
                                    <label for="reguiar_id"
                                        class="form-label">{{ __('ลำดับ') }}</label>
                                {{ $projectDetails->reguiar_id  }}

                                <label for="project_name"
                                class="form-label">{{ Helper::projectsType($projectDetails->project_type ) }}</label>
                        {{  $projectDetails->project_name }}
                                </div>

                            </div>


                                <div class="col-md-12 mt-3">
                                    <div class="col-md-12">
                                        <label for="project_description"
                                            class="form-label">{{ __('รายละเอียดโครงการ') }}</label>
                                     {{ $projectDetails->project_description }}
                                    </div>
                                </div>


                               {{--  <div class="row mt-3">
                                    <label
                                    class="form-label">{{ __('งบประมาณที่ได้รับจัดสรร') }}</label>
                            </div>
                                <div class="row">
                                    @if ($projectDetails->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating > 0)
                               @if($projectDetails->budget_it_operating >= $sum_task_budget_it_operating )
             @if($projectDetails->budget_it_operating > 0.01)
                                   <div class="col-2">{{ __('งบกลาง ICT ') }}</div>
                                    <div class="col-2">{{ number_format($projectDetails->budget_it_operating, 2) }} บาท</div>

                                   @if ($projectDetails->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating > 0)

                                        <div class="col-2">{{ number_format(($projectDetails->budget_it_operating- $sum_task_budget_it_operating)+$budget_task['sum_task_refund_budget_type_it_operating']  , 2) }} บาท</div>
                                        @elseif($projectDetails->budget_it_operating <$sum_task_budget_it_operating)
                                        <div class="col-2"> 0 บาท</div>
                                        @endif
                                        @if($budget_task['sum_task_refund_budget_it_operating'])
                                        <div class="col-2">{{ __('งบกลาง ICT คืน ') }}</div>
                                        <div class="col-2"> {{ number_format($budget_task['sum_task_refund_budget_it_operating'] -$budget_task['sum_task_refund_budget_type_it_operating'], 2) }}  บาท</div>
                                        @endif

                                        @if($increasedData->isNotEmpty() && $increasedData->first()->total_it_operating)
                                        <div class="col-2">{{ __('งบกลาง ICT เพิ่ม ') }}</div>
                                        <div class="col-2">{{ number_format($increasedData->first()->total_it_operating, 2) }} บาท</div>
                                    @endif
                                @endif


                                        @endif
                                </div>


                                <div class="row">
                                    @if ($projectDetails->budget_it_investment > 0)
                                    <div class="col-2">{{ __('งบดำเนินงาน') }}</div>
                                        <div class="col-2">{{ number_format($projectDetails->budget_it_investment, 2) }} บาท</div>
                                         <div class="col-2">     {{ number_format(($projectDetails->budget_it_investment - $sum_task_budget_it_investment)+$budget_task['sum_task_refund_budget_type_it_investment'] , 2) }} บาท</div>
                                         @elseif($projectDetails->budget_it_investment < $sum_task_budget_it_investment)
                                        <div class="col-2"> 0 บาท</div>
                                        @endif



                                        @if($budget_task['sum_task_refund_budget_it_investment'])
                                        <div class="col-2">{{ __('งบดำเนินงาน คืน') }}</div>
                                        <div class="col-2">{{ number_format($budget_task['sum_task_refund_budget_it_investment'] -$budget_task['sum_task_refund_budget_type_it_investment'] , 2) }} บาท</div>
                                        @endif
                                        @if($increasedData->isNotEmpty() && $increasedData->first()->total_it_investment)
                                        <div class="col-2">{{ __('งบดำเนินงาน เพิ่ม ') }}</div>
                                        <div class="col-2">{{ number_format($increasedData->first()->total_it_investment, 2) }} บาท</div>
                                    @endif
                                </div>
                                <div class="row">
                                    @if ($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility > 0)
                                    <div class="col-2">{{ __('งบค่าสาธารณูปโภค') }}</div>
                                        <div class="col-2">{{ number_format($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility, 2) }}บาท</div>
                                     <div class="col-2">{{ number_format(($projectDetails->budget_gov_utility - $sum_task_budget_gov_utility)+$budget_task['sum_task_refund_budget_type_gov_utility'] , 2) }} บาท</div>
                                        @elseif($projectDetails->budget_gov_utility <$sum_task_budget_gov_utility)
                                        <div class="col-2"> 0 บาท</div>
                                        @endif
                                        @if($budget_task['sum_task_refund_budget_gov_utility'])
                                        <div class="col-2">{{ __('งบค่าสาธารณูปโภค คืน') }}</div>
                                        <div class="col-2">{{ number_format($budget_task['sum_task_refund_budget_gov_utility'] -$budget_task['sum_task_refund_budget_type_gov_utility'], 2) }} บาท</div>
                                        @endif
                                        @if($increasedData->isNotEmpty() && $increasedData->first()->total_gov_utility)
                                        <div class="col-2">{{ __('งบค่าสาธารณูปโภค เพิ่ม ') }}</div>
                                        <div class="col-2">{{ number_format($increasedData->first()->total_gov_utility, 2) }} บาท</div>
                                    @endif


                                </div>
 --}}




                            </div>
{{-- เพิ่ม 31/12/2566 --}}

                              <div class="callout callout-primary row mt-3">
                                <div class="row mt-3">
                                    <label
                                    class="form-label">{{ __('งบประมาณที่ได้รับจัดสรร') }}</label>
                            </div>

                            <div class="row">
                                @if($request->budget_it_operating > 0)
                                <div id='ICT' class="col-2">{{ __('งบกลาง ICT ') }}</div>
                                <div id='ICT' class="col-2">{{ number_format($projectDetails->budget_it_operating, 2) }} บาท</div>   {{-- งบกลาง ICT --}}
                                @endif
                                @if($request->budget_it_investment > 0)
                                <div class="col-2">{{ __('งบดำเนินงาน') }}</div>
                                <div class="col-2">{{ number_format($projectDetails->budget_it_investment, 2) }} บาท</div> {{-- งบดำเนินงาน --}}
                                @endif
                                @if($request->budget_gov_utility > 0)
                                <div class="col-2">{{ __('งบค่าสาธารณูปโภค') }}</div>
                                <div class="col-2">{{ number_format($projectDetails->budget_gov_utility, 2) }} บาท</div> {{-- งบค่าสาธารณูปโภค --}}
                                @endif
                            </div>
                     @if( $budget_task['sum_task_refund_budget_it_operating']||$budget_task['sum_task_refund_budget_it_investment']||$budget_task['sum_task_refund_budget_gov_utility']||$increasedData->first()->total_it_operating||$increasedData->first()->total_it_investment||$increasedData->first()->total_gov_utility)  {{-- row --}}
                            <div class="row">


                                @if($increasedData->first()->total_it_operating||$increasedData->first()->total_it_investment||$increasedData->first()->total_gov_utility)
                                @if($request->budget_it_operating > 0)
                                <div class="col-2">{{ __('งบกลาง ICT เพิ่ม ') }}</div>
                                <div class="col-2">{{ number_format($increasedData->first()->total_it_operating, 2) }} บาท</div> {{-- งบกลาง ICT เพิ่ม --}}
                                @endif
                                @if($request->budget_it_investment > 0)
                                <div class="col-2">{{ __('งบดำเนินงาน เพิ่ม ') }}</div>
                                <div class="col-2">{{ number_format($increasedData->first()->total_it_investment, 2) }} บาท</div> {{-- งบดำเนินงาน เพิ่ม --}}
                                @endif
                                @if($request->budget_gov_utility > 0)
                                <div class="col-2">{{ __('งบค่าสาธารณูปโภค เพิ่ม ') }}</div>
                                <div class="col-2">{{ number_format($increasedData->first()->total_gov_utility, 2) }} บาท</div> {{-- งบค่าสาธารณูปโภค เพิ่ม --}}
                                @endif
                                @endif

                            </div>
                            <hr width="200px"/>{{-- row --}}
                            <div class="row">
                                @if($request->budget_it_operating > 0)
                                <div class="col-2">{{ __('งบกลาง ICT คืน ') }}</div>
                                <div class="col-2"><b class=text-blue-ganll  >{{ number_format($budget_task['sum_task_refund_budget_it_operating'] -$budget_task['sum_task_refund_budget_type_it_operating'], 2) }} </b> บาท</div> {{-- งบกลาง ICT คืน --}}
                                @endif
                                @if($request->budget_it_investment > 0)
                                <div class="col-2">{{ __('งบดำเนินงาน คืน') }}</div>
                                <div class="col-2"><b class=text-blue-ganll  >{{ number_format($budget_task['sum_task_refund_budget_it_investment']-$budget_task['sum_task_refund_budget_type_it_investment'], 2) }}</b> บาท</div> {{-- งบดำเนินงาน คืน --}}
                                @endif
                                @if($request->budget_gov_utility > 0)
                                <div class="col-2">{{ __('งบค่าสาธารณูปโภค คืน') }}</div>
                                <div class="col-2"><b class=text-blue-ganll  >{{ number_format($budget_task['sum_task_refund_budget_gov_utility']-$budget_task['sum_task_refund_budget_type_gov_utility'], 2) }} </b>บาท</div> {{-- งบค่าสาธารณูปโภค คืน --}}
                                @endif
                                <hr width="200px"/>

                            </div>  {{-- row --}}


                    @endif
                    <div class="row">
                        {{--                                 @if($increasedData->first()->total_it_operating||$increasedData->first()->total_it_investment||$increasedData->first()->total_gov_utility)
                         --}}
                         @if($request->budget_it_operating > 0)
                          <div class="col-2">{{ __('งบกลาง ICT คงเหลือ ') }}</div>
                                                        <div class="col-2"><b class=text-success>{{number_format(($request->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating+ $increasedData->first()->total_it_operating) ,2)}}</b> บาท</div> {{-- งบกลาง ICT คงเหลือ --}}

                                                        @endif
                                                        @if($request->budget_it_investment > 0)
                                                        <div class="col-2">{{ __('งบดำเนินงาน คงเหลือ ') }}</div>
                                                        <div class="col-2"><b class=text-success>{{ number_format(($request->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment+ $increasedData->first()->total_it_investment) ,2) }}</b> บาท</div> {{-- งบดำเนินงาน คงเหลือ --}}
                                                        @endif
                                                        @if($request->budget_gov_utility > 0)

                                                        <div class="col-2">{{ __('งบค่าสาธารณูปโภค คงเหลือ ') }}</div>
                                                        <div class="col-2"><b class=text-success>{{ number_format(($request->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility+ $increasedData->first()->total_gov_utility) ,2) }}</b> บาท</div> {{-- งบค่าสาธารณูปโภค คงเหลือ --}}
                                                        @endif
                                                        {{--  @endif --}}
                                                </div>
                </div>     {{-- </div> ปิด--}}

                <div class="callout callout-primary row mt-3">
                            <form method="POST" action="{{ route('project.task.create', $project) }}"
                            class="row needs-validation" enctype="multipart/form-data"
                            novalidate>
                                @csrf


                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label for="taskcon_mm_name" class="form-label">{{ __('ชื่อกิจกรรม') }}</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" id="taskcon_mm_name" name="taskcon_mm_name"
                                            required autofocus>
                                        <div class="invalid-feedback">
                                            {{ __('กรุณากรอกชื่อกิจกรรม') }}

                                    </div>


                                </div>
                                <div class=" row mt-3">
                                    <div class="d-none col-md-4">
                                        <label for="task_status" class="form-label">{{ __('สถานะกิจกรรม') }}</label>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="task_status"
                                                id="task_status1" value="1" checked>
                                            <label class="form-check-label" for="task_status1">
                                                ระหว่างดำเนินการ
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="task_status"
                                                id="task_status2" value="2">
                                            <label class="form-check-label" for="task_status2">
                                                ดำเนินการแล้วเสร็จ
                                            </label>
                                        </div>
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


                                <div id="contractSelection">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="task_contract" class="form-label">{{ __('สัญญา') }}</label>

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
                                    <div class="col-md-3 mt-4">

                                        <a href="{{ route('contract.create', ['origin' => $project, 'project' => $project]) }}"
                                            class="btn btn-success text-white"
                                            target="contractCreate">เพิ่มสัญญา/ใบจ้าง</a>
                                    </div>
                                </div>


                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="task_start_date"
                                            class="form-label">{{ __('วันที่เริ่มต้น') }}</label>
                                        <span class="text-danger">*</span>
                                        <input class="form-control" id="task_start_date" name="task_start_date"
                                     {{--    value=   {{ Helper::Date4(date('Y-m-d H:i:s', $projectDetails->project_start_date)) }} --}}
                                        value="{{ Helper::calculateFiscalYearDates($projectDetails['project_fiscal_year'])['fiscalyear_start'] }}"


                                        required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="task_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }}</label>
                                        <span class="text-danger">*</span>
                                        <input class="form-control" id="task_end_date" name="task_end_date"

                                        value="{{ Helper::calculateFiscalYearDates($projectDetails['project_fiscal_year'])['fiscalyear_end'] }}" required>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label for="task_description"
                                        class="form-label">{{ __('รายละเอียดกิจกรรม') }}</label>
                                    <textarea class="form-control" name="task_description" id="task_description" rows="10"></textarea>
                                    <div class="invalid-feedback">
                                        {{ __('รายละเอียดกิจกรรม') }}
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <h4>งบประมาณ</h4>
                                    <div class="row">


                                  {{--   @if($budget_task['sum_task_refund_budget_oiu'])
                                        <div class="col-md-2">
                                            <label for="task_refund_budget_type_0" class="form-label">{{ __('งบประมาณ') }}</label> <span class="text-danger"></span>
                                            <div>
                                                <input class="form-check-input" type="radio" name="task_refund_budget_type" id="task_refund_budget_type_0" value="0">
                                                <label class="form-check-label" for="task_refund_budget_type_0">งบประมาณ</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                               class="form-control numeral-mask" id="task_refund_budget"
                                               name="task_refund_budget"
                                              value=            @if($request->budget_it_operating - $sum_task_budget_it_operating > 0)
                                              {{ number_format($request->budget_it_operating - $sum_task_budget_it_operating ,2) }}

                                              @elseif($request->budget_it_operating - $sum_task_budget_it_operating < 0)
                                                0.00
                                              @endif>
                                            </div>
                                            <div class="invalid-feedback">{{ __('งบประมาณ ') }}</div>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="task_refund_budget_type_1" class="form-label">{{ __('งบประมาณคืน') }}</label> <span class="text-danger"></span>
                                            <div>
                                                <input class="form-check-input" type="radio" name="task_refund_budget_type" id="task_refund_budget_type_1" value="1">
                                                <label class="form-check-label" for="task_refund_pa_budget">งบประมาณคืน</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                               class="form-control numeral-mask" id="task_refund_budget"
                                               name="task_refund_budget"
                                              value= {{ number_format($request->budget_it_operating - $sum_task_budget_it_operating+ $sum_task_refund_budget_it_operating,2) }}>
                                            </div>
                                            <div class="invalid-feedback">{{ __('งบประมาณ ') }}</div>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="task_refund_budget_type_2" class="form-label">{{ __('งบประมาณ+งบประมาณคืน') }}</label> <span class="text-danger"></span>
                                            <div>
                                                <input class="form-check-input" type="radio" name="task_refund_budget_type" id="task_refund_budget_type_2" value="1">
{{--
                                                <label class="form-check-label" for="task_refund_budget_left">งบประมาณ+งบประมาณคืน</label>

                                                <label class="form-check-label" for="task_refund_budget_left">งบประมาณคืน</label>
 --}}
                                           {{--  {{ number_format($request->budget_it_operating - $sum_task_budget_it_operating+ $sum_task_refund_budget_it_operating,2) }} --}}
                                             {{--  <label class="form-check-label" for="task_refund_budget_left">งบกลาง ICT เพิ่ม</label> --}}
                                             {{-- {{number_format($increasedData->first()->total_it_operating,2) }} --}}

                              {{--               </div>
                                            <div class="invalid-feedback">{{ __('งบประมาณ ') }}</div>

                                        </div>
                                    @endif --}}





                                <div class="row mt-3">


                                        <div class="row mt-3">
                                            <div class="col-md-4 " >
                                                <label for="task_budget_it_operating"
                                                    class="form-label">{{ __('งบกลาง ICT') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control numeral-mask" id="task_budget_it_operating"
                                                    name="task_budget_it_operating"
                                                    @if(($request->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating+ $increasedData->first()->total_it_operating) == 0) readonly @endif>


                                                <div class="invalid-feedback">
                                                    {{ __('ระบุงบกลาง ICT') }}

                                                </div>

                                                ไม่เกิน
                                                {{ number_format($request->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating+ $increasedData->first()->total_it_operating,2) }}
                                                บาท <br>
                                                <div class="d-none">
                                                @if($request->budget_it_operating - $sum_task_budget_it_operating > 0)
                                                {{ number_format($request->budget_it_operating - $sum_task_budget_it_operating ,2) }}
                                                บาท <br>
                                                @elseif($request->budget_it_operating - $sum_task_budget_it_operating < 0)
                                                งบกลาง ICT 0.00 บาท <br>
                                                @endif

                                                @if($sum_task_refund_budget_it_operating)

                                                งบกลาง ICT คืน {{ number_format($request->budget_it_operating - $sum_task_budget_it_operating+ $sum_task_refund_budget_it_operating,2) }} <br>
                                                @endif
                                                @if($increasedData->isNotEmpty() && $increasedData->first()->total_it_operating)
                                                งบกลาง ICT เพิ่ม   {{ number_format($increasedData->first()->total_it_operating,2) }}
                                                @endif
                                                </div>


                                              <span id="password-error"> </span>


                                            </div>
                                            <div class="col-md-4">
                                                <label for="task_budget_it_investment"
                                                    class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control numeral-mask" id="task_budget_it_investment"
                                                    name="task_budget_it_investment"

                                                    @if(($request->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment+ $increasedData->first()->total_it_investment) == 0) readonly @endif>

                                                <div class="invalid-feedback">
                                                    {{ __('ระบุงบดำเนินงาน') }}
                                                </div>
                                                ไม่เกิน
                                                {{ number_format($request->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment+ $increasedData->first()->total_it_investment,2) }}
                                                บาท
                                            </div>
                                            <div class="col-md-4">
                                                <label for="task_budget_gov_utility"
                                                    class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control numeral-mask" id="task_budget_gov_utility"
                                                    name="task_budget_gov_utility"
                                                    @if(($request->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility+ $increasedData->first()->total_gov_utility) == 0) readonly @endif>

                                                <div class="invalid-feedback">
                                                    {{ __('ระบุค่าสาธารณูปโภค') }}
                                                </div>
                                                ไม่เกิน
                                                {{ number_format($request->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility+ $increasedData->first()->total_gov_utility,2) }}


                                                บาท
                                            </div>
                                        </div>
                                    </div>
                                  {{--
                                    20/12/2566 ตัดออก
                                    <div type="hidden" class="form-check form-check-inline">
                                        <input type="hidden" class="form-check-input" type="radio" name="task_refund_pa_status"
                                            id="task_refund_pa_status" value="3" checked>

                                    </div> --}}








                                </div>
                             <div id="refundItemRow" class="d-none">
                                <div class="col-md-2">
                                    <label for="budget_return_input" class="form-label">งบประมาณคืน</label>
                                    <input type="text" placeholder="0.00" class="form-control numeral-mask" id="budget_return_input" name="budget_return" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false">
                                </div>

                                <div class="col-md-2">
                                    <label for="budget_increase_input" class="form-label">งบกลาง ICT เพิ่ม</label>
                                    <input type="text" placeholder="0.00" class="form-control numeral-mask" id="budget_increase_input" name="budget_increase" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false">
                                </div>

                                <div class="col-md-2">
                                    <label for="total_budget_input" class="form-label">งบประมาณ+งบประมาณคืน</label>
                                    <input type="text" class="form-control" id="total_budget_input" name="total_budget" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label for="task_refund_budget" class="form-label">+งบประมาณคืน</label>
                                    <input type="text" class="form-control" id="task_refund_budget" name="task_refund_budget" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label for="task_refund_budget_left" class="form-label">งบประมาณ+งบประมาณคืน</label>
                                    <input type="text" class="form-control" id="task_refund_budget_left" name="task_refund_budget_left" readonly>
                                </div>


                                <div class="col-md-4 ">
                                    <label for="task_refund_budget_type"
                                        class="form-label">{{ __('task_refund_budget_type ') }}</label>
                                    <span class="text-danger"></span>

                                    <input type="text"
                                        class="form-control"
                                        id="task_refund_budget_type"
                                        name="task_refund_budget_type"  readonly>


                                </div>
                             </div>

                                <div class="d-none col-md-3 mt-3">

                                </label>

                                <input type="hidden" class="form-check-input" type="radio" name="task_budget_no"
                                id="task_budget_no" value="1" checked>



{{--                                 {{ Form::select('task_parent_sub', \Helper::contractType(), '1', ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...', 'id' => 'contract_type']) }}
 --}}
                            </div>

                        {{--     <div class="row mt-3">
                                @foreach ($taskRefundPaBudget as $index => $refundItem)
                                @php
                                 Check if $task is not null before performing the calculation
                             $task_refund_budget_left =  $refundItem->task_refund_pa_budget - $task->task_budget_it_operating : 0;
                            @endphp
                                <div  id="task_id">
                                    <input name="tasks[{{ $index }}][id]"
                                        value="{{ $refundItem->task_id }}">
                                </div>


                                <div class="col-md-3">
                                    <label class="form-label">ชื่องวด</label>
                                    <input class="form-control" type="text"
                                        name="tasks[{{ $index }}][task_name]"
                                        value="{{ $refundItem->task_name }}">
                                </div>

                    <div class="col-md-3">
                        <label class="form-label">คืนเงิน</label>
                        <input type="text" placeholder="0.00" step="0.01"     min="0"
                        class="form-control numeral-mask installment-amount"
                                data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                name="tasks[{{ $index }}][task_refund_pa_budget]" value="{{ number_format($refundItem->task_refund_pa_budget, 2) }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">ใช้ไปเงิน</label>
                        <input type="text" placeholder="0.00" step="0.01" min="0"
                            class="form-control numeral-mask installment-amount"
                            data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                            name="tasks[{{ $index }}][task_refund_budget_left]"
                           >
                    </div>


                    <div class="row mt-3 refundItemRow">

                        <div class="col-md-3">
                            <input type="text" class="form-control refundAmount" name="tasks[{{ $index }}][task_refund_pa_budget]" value="{{ number_format($refundItem->task_refund_pa_budget, 2) }}">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control usedAmount" name="tasks[{{ $index }}][task_used_amount]"  readonly>
                        </div>
                        <div class="col-md-3">
                            <span class="remainingAmount"></span>
                        </div>
                    </div>
                                @endforeach

                            </div> --}}

                            <div class="row mt-3">





                                <x-button class="btn-success" type="submit">{{ __('coreuiforms.save') }}</x-button>
                                <x-button onclick="history.back()" class="text-black btn-light">
                                    {{ __('coreuiforms.return') }}</x-button>

                                       <!-- SweetAlert2 Trigger Button -->

                            </form>
                        </x-card>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:content>
    <x-slot:css>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet"/>

    </x-slot:css>
    <x-slot:javascript>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js"></script>
       {{--  <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script> --}}
        <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
        <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>
{{--

 <script>
                $(document).ready(function() {
                    $('#project_select').change(function() {
                        // ซ่อนทุกฟิลด์ก่อน
                        var project_select = $(this).val();


                        $('#ICT').hide();
                        $('#inv').hide();
                        $('#utility').hide();

                        // แสดงฟิลด์ที่เกี่ยวข้องตามประเภทงบประมาณที่เลือก
                        if ($request->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating+ $increasedData->first()->total_it_operating) == 0 {
                            $('#ICT').hide();
                        } else if ($(this).val() == 'task_budget_it_investment') {
                            $('#inv').show();
                        } else if ($(this).val() == 'task_budget_gov_utility') {
                            $('#utility').show();
                        }
                    });
                });
            </script> --}}

{{--       <script>
    $(document).ready(function() {
        // Define the function outside of the event listener
        function calculateDebtPayment(totalBudget, debt1, dabt2Paid_it_operating, dabt2Paid_it_investment, dabt2Paid_gov_utility) {
            var debt1Paid = parseFloat(debt1);
            var dabt2Paid_it_operating = parseFloat(dabt2Paid_it_operating);
            var dabt2Paid_it_investment = parseFloat(dabt2Paid_it_investment);
            var dabt2Paid_gov_utility = parseFloat(dabt2Paid_gov_utility);

            // ชำระหนี้คนที่ 1 ก่อน
            if (totalBudget >= debt1Paid) {
                totalBudget -= debt1Paid;
            } else {
                debt1Paid = totalBudget;
                totalBudget = 0;
            }

            // ชำระหนี้คนที่ 2 it_operating หากยังมีงบประมาณเหลือ
            if (totalBudget >= dabt2Paid_it_operating) {
                totalBudget -= dabt2Paid_it_operating;
            } else {
                dabt2Paid_it_operating = totalBudget;
                totalBudget = 0;
            }

            // ชำระหนี้คนที่ 2 it_investment หากยังมีงบประมาณเหลือ
            if (totalBudget >= dabt2Paid_it_investment) {
                totalBudget -= dabt2Paid_it_investment;
            } else {
                dabt2Paid_it_investment = totalBudget;
                totalBudget = 0;
            }

            // ชำระหนี้คนที่ 2 gov_utility หากยังมีงบประมาณเหลือ
            if (totalBudget >= dabt2Paid_gov_utility) {
                totalBudget -= dabt2Paid_gov_utility;
            } else {
                dabt2Paid_gov_utility = totalBudget;
                totalBudget = 0;
            }

            return {
                debt1Paid: debt1Paid,
                dabt2Paid_it_operating: dabt2Paid_it_operating,
                dabt2Paid_it_investment: dabt2Paid_it_investment,
                dabt2Paid_gov_utility: dabt2Paid_gov_utility,
                remainingBudget: totalBudget
            };
        }

        // Event listener for input changes
        $("#task_budget_it_investment, #task_budget_gov_utility, #task_budget_it_operating").on("input", function() {
            var budgetItOperating = parseFloat($("#task_budget_it_operating").val().replace(/,/g, "")) || 0;
            var budgetItInvestment = parseFloat($("#task_budget_it_investment").val().replace(/,/g, "")) || 0;
            var budgetGovUtility = parseFloat($("#task_budget_gov_utility").val().replace(/,/g, "")) || 0;
            var totalRemainingBudget = budgetItOperating + budgetItInvestment + budgetGovUtility;


            var result = calculateDebtPayment(totalRemainingBudget, debt1, dabt2Paid_it_operating, dabt2Paid_it_investment, dabt2Paid_gov_utility);
            console.log(result);
        });
    });
</script>
 --}}


 <script>
      $(document).ready(function() {
        // Define the function outside of the event listener
        function calculateDebtPayment(totalBudget, debt1, debt2) {
            var debt1Paid = parseFloat(debt1);
            var debt2Paid = parseFloat(debt2);

            // ชำระหนี้คนที่ 1 ก่อน
            if (totalBudget >= debt1Paid) {
                totalBudget -= debt1Paid;
            } else {
                debt1Paid = totalBudget;
                totalBudget = 0;
            }

            // ชำระหนี้คนที่ 2 หากยังมีงบประมาณเหลือ
            if (totalBudget >= debt2Paid) {
                totalBudget -= debt2Paid;
            } else {
                debt2Paid = totalBudget;
                totalBudget = 0;
            }

            return {
                remainingBudget: totalBudget,
                debt1Paid: debt1Paid,
                debt2Paid: debt2Paid
            };
        }

        // Event listener for input changes
        $("#task_budget_it_operating").on("input", function() {
            var budgetItOperating = parseFloat($("#task_budget_it_operating").val().replace(/,/g, "")) || 0;

            var totalRemainingBudget = budgetItOperating ;

        var debt1 = {{ json_encode($request->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating) }};
        var debt2 = {{$increased['total_it_operating']}};

        var result_operating = calculateDebtPayment(totalRemainingBudget, debt1, debt2);
        console.log(result_operating);

//        $("#task_refund_budget").val(result.debt1Paid);

  //      $("#task_refund_budget_left").val(result.debt2Paid);
    });

   // Event listener for input changes
   $("#task_budget_it_investment").on("input", function() {
            var budgetItInvestment = parseFloat($("#task_budget_it_investment").val().replace(/,/g, "")) || 0;

            var totalRemainingBudget = budgetItInvestment ;

            var debt1 = {{ json_encode($request->budget_it_investment - $sum_task_budget_it_investment + $sum_task_refund_budget_it_investment) }};
            var debt2 = {{$increased['total_it_investment']}};

        var result_investment = calculateDebtPayment(totalRemainingBudget, debt1, debt2);
        console.log(result_investment);

        $("#task_refund_budget").val(result_investment.debt1Paid);

        $("#task_refund_budget_left").val(result_investment.debt2Paid);
    });


// Event listener for input changes
$("#task_budget_gov_utility").on("input", function() {
            var budgetGovUtility = parseFloat($("#task_budget_gov_utility").val().replace(/,/g, "")) || 0;

            var totalRemainingBudget = budgetGovUtility ;

            var debt1 = {{ json_encode($request->budget_gov_utility - $sum_task_budget_gov_utility + $sum_task_refund_budget_gov_utility) }};
            var debt2 = {{$increased['total_gov_utility']}};

        var result_gov_utility = calculateDebtPayment(totalRemainingBudget, debt1, debt2);
        console.log(result_gov_utility);

        $("#task_refund_budget").val(result_gov_utility.debt1Paid);

        $("#task_refund_budget_left").val(result_gov_utility.debt2Paid);
    });
});







</script>


<script>
    var costFields = ['task_cost_it_operating', 'task_cost_it_investment', 'task_cost_gov_utility'];
    var budgetFields = ['task_budget_it_operating', 'task_budget_it_investment', 'task_budget_gov_utility'];

    function calculateRefund() {
        var totalRefund = 0;

        costFields.forEach(function(costField, index) {
            var pa_value = $("#" + costField).val();
            var pr_value = $("#" + budgetFields[index]).val();

            if (pa_value && pr_value) {
                var pa_budget = parseFloat(pa_value.replace(/,/g, "")) || 0;
                var pr_budget = parseFloat(pr_value.replace(/,/g, "")) || 0;

                if (pa_budget != 0) {
                    var refund = pr_budget - pa_budget;
                    totalRefund += refund;
                }
            }
        });

        $("#task_refund_pa_budget").val(totalRefund.toFixed(2));
    }

    $(document).ready(function() {
        costFields.forEach(function(costField, index) {
            $("#" + costField).on("input", calculateRefund);
        });
    });
</script>


{{-- <script>
    $(document).ready(function() {
        // Function to calculate remaining amount for each task
        var budgetFields = ['task_budget_it_operating', 'task_budget_it_investment', 'task_budget_gov_utility'];



        function calculateRemaining() {
            $('.refundItemRow').each(function() {
                var refundAmount = parseFloat($(this).find('.refundAmount').val().replace(/,/g, '') || 0);
                var usedAmount = parseFloat($(this).find('.usedAmount').val().replace(/,/g, '') || 0);
                var remaining = refundAmount - usedAmount;
                $(this).find('.remainingAmount').text(remaining.toFixed(2));
            });
        }

        // Calculate on page load
        calculateRemaining();

        // Recalculate when any refund amount changes
        $(document).on('input', '.refundAmount', function() {
            calculateRemaining();
        });
    });
    </script>

      <script>
            $(document).ready(function() {
                $(".numeral-mask").inputmask();
            });
        </script> --}}

      <script>
        $(document).ready(function() {
            $(".numeral-mask").inputmask();
        });
    </script>

<script>
    $(function() {
        $("#task_start_date, #task_end_date").datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            language:"th-th",

        });

        var project_fiscal_year = {{$projectDetails->project_fiscal_year}};
        var project_start_date_str = "{{ Helper::Date4(date('Y-m-d H:i:s', $projectDetails->project_start_date)) }}"; // Wrap in quotes
        var project_end_date_str = "{{ Helper::Date4(date('Y-m-d H:i:s', $projectDetails->project_end_date)) }}"; // Wrap in quotes

        //var task_end_date_str = $("#task_end_date").val();


        project_fiscal_year = project_fiscal_year - 543;

        var fiscalYearStartDate = new Date(project_fiscal_year - 1, 9, 1); // 1st October of the previous year
        var fiscalYearEndDate = new Date(project_fiscal_year, 8, 30); // 30th September of the fiscal year

        console.log(project_start_date_str);
        console.log(project_end_date_str);
        console.log(fiscalYearStartDate);
        console.log(fiscalYearEndDate);
// Set the start and end dates for the project_start_date datepicker
$("#task_start_date").datepicker("setStartDate", fiscalYearStartDate);
$("#task_end_date").datepicker("setStartDate", fiscalYearStartDate);
   $("#project_start_date").datepicker("setEndDate", fiscalYearEndDate);

    // Set the start and end dates for the project_end_date datepicker
    $("#project_end_date").datepicker("setStartDate", fiscalYearStartDate);
   var task_end_date_str = $("#task_end_date").val();
    var task_end_date = (task_end_date_str);
    var project_end_date =(project_end_date_str);
     // console.log(task_end_date_str);
       // console.log(task_end_date);
        //console.log(project_end_date);


  // Add click event listener for the delete button
  $('#task_end_date').click(function(e) {
    e.preventDefault();
    var task_end_date_str = $("#task_end_date").val();
    var task_end_date = convertToDate(task_end_date_str);
    var project_end_date = convertToDate(project_end_date_str);
      console.log(task_end_date_str);
        console.log(task_end_date);
        console.log(project_end_date);

    if (task_end_date > project_end_date) {
        Swal.fire({
            title: 'วันที่ เกิน ?',
            text: "คุณจะทำตามวันที่เกินใช่หรือไม่!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ทำตามวันที่เกิน!',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(

                    'success'
                )
            }
        });
    }
});

$("#task_end_date").datepicker("setEndDate", project_end_date_str);







    $('#task_start_date').on('changeDate', function() {
            var startDate = $(this).datepicker('getDate');
            $("#task_end_date").datepicker("setStartDate", startDate);
        });

         $('#task_end_date').on('changeDate', function() {
            var endDate = $(this).datepicker('getDate');
            $("#task_start_date").datepicker("setEndDate", endDate);
        });
    });

    function convertToDate(dateStr) {
        var parts = dateStr.split("/");
        var date = new Date(parts[2], parts[1] - 1, parts[0]);
        return date;
    }
</script>




        <script>
           $(document).ready(function() {
    $("#task_budget_it_investment, #task_budget_gov_utility, #task_budget_it_operating").on("input", function() {
        var max = 0;
        var fieldId = $(this).attr('id');
  var budgetItOperating = $("#task_budget_it_operating").val();
        var budgetItInvestment = $("#task_budget_it_investment").val();
        var budgetGovUtility = $("#task_budget_gov_utility").val();

        if (fieldId === "task_budget_it_investment") {


            max = parseFloat({{ $request->budget_it_investment - $sum_task_budget_it_investment+ $sum_task_refund_budget_it_investment+ $increasedData->first()->total_it_investment }});

            if (budgetItInvestment === "0" || budgetItInvestment === '' || parseFloat(budgetItInvestment) < -0) {
                $("#task_budget_it_investment").val('');
            }

        }


        else if (fieldId === "task_budget_gov_utility") {
            max = parseFloat({{ $request->budget_gov_utility - $sum_task_budget_gov_utility+ $sum_task_refund_budget_gov_utility+ $increasedData->first()->total_gov_utility }});


            if (budgetGovUtility === "0" || budgetGovUtility === '' || parseFloat(budgetGovUtility) < -0) {
                $("#task_budget_gov_utility").val('');
            }

        }

        else if (fieldId === "task_budget_it_operating") {
            max = parseFloat({{ $request->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating+ $increasedData->first()->total_it_operating }});
                if (budgetItOperating === "0" || budgetItOperating === '' || parseFloat(budgetItOperating) < -0 ) {
                    $("#task_budget_it_operating").val('');
                }
            }

        var current = parseFloat($(this).val().replace(/,/g , ""));
        if (current > max) {


            Swal.fire("จำนวนเงินที่ใส่ต้องไม่เกิน " +max.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + " บาท");

            $(this).val(0);

            /* $(this).val(max.toFixed(2)); */
        }

    });
});
        </script>


       <script>
            $(document).ready(function() {
                // Check initial state of the "มี PA" radio button


                if ($('#task_type1').is(':checked')) {
                    $('#contractSelection').show();
                } else {
                    $('#contractSelection').hide();
                }

                // Listen for changes on the radio buttons
                $('input[type=radio][name=task_type]').change(function() {
                    if (this.value == '1') {
                        $('#contractSelection').show();
                    } else {
                        $('#contractSelection').hide();
                    }
                });
            });
        </script>


<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
<script type="text/javascript">
// ส่วนของการคำนวณงบประมาณที่เหลือ
    var budgetItInvestmentMax = {{ $request->budget_it_investment + 0.01 }};
    var budgetGovUtilityMax = {{ $request->budget_gov_utility + 0.01 }};
    var budgetItOperatingMax = {{ $request->budget_it_operating + 0.01 }};
    var budgetItInvestment_total = {{  $sum_task_budget_it_investment }};
    var budgetGovUtility_total = {{ $sum_task_budget_gov_utility }};
    var budgetItOperating_total = {{ $sum_task_budget_it_operating }};
    var budget_sum_task_refund_budget_oiu = {{ $budget_task['sum_task_refund_budget_oiu'] }};
    // ... คล้ายๆ กันสำหรับตัวแปรอื่นๆ $request->budget_it_operating-1  < $sum_task_budget_it_operating

    console.log(budget_sum_task_refund_budget_oiu);
</script>

 <script>
    $(document).ready(function() {



        $("#task_budget_it_investment, #task_budget_gov_utility, #task_budget_it_operating").on("input", function() {
            var fieldId = $(this).attr('id');
            var fieldValue = parseFloat($(this).val().replace(/,/g, '')) || 0;

            console.log(budgetGovUtilityMax);
            console.log(budgetGovUtility_total);
            console.log(budgetItOperatingMax);
            console.log(budgetItOperating_total);
            console.log(budgetItInvestmentMax);
            console.log(budgetItInvestment_total);
        console.log(fieldId);
        console.log(fieldValue);

        if (fieldId === "task_budget_it_investment") {
            if (  budgetItInvestmentMax  < fieldValue + budgetItInvestment_total && budget_sum_task_refund_budget_oiu > 1) {
                $("#task_refund_budget_type").val(1);
            } else {
                $("#task_refund_budget_type").val(0); // หรือค่าเริ่มต้นที่ควรจะเป็น
            }
        }

        else if (fieldId === "task_budget_it_operating") {
        if (  budgetItOperatingMax  < fieldValue + budgetItOperating_total && budget_sum_task_refund_budget_oiu > 1) {
                $("#task_refund_budget_type").val(1);
            } else {
                $("#task_refund_budget_type").val(0); // หรือค่าเริ่มต้นที่ควรจะเป็น
            }
        }

        else if (fieldId === "task_budget_gov_utility") {
        if (  budgetGovUtilityMax  < fieldValue + budgetGovUtility_total && budget_sum_task_refund_budget_oiu > 1) {
                $("#task_refund_budget_type").val(1);
            } else {
                $("#task_refund_budget_type").val(0); // หรือค่าเริ่มต้นที่ควรจะเป็น
            }
        }





        });
    });
</script>














    </x-slot:javascript>
</x-app-layout>

     {{--  <script>
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
                   language:'th-th',
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

<script>
    $(document).ready(function() {
       $("#task_start_date").datepicker({});
        $("#task_end_date").datepicker({ });
        $('#task_start_date').change(function() {
                        startDate = $(this).datepicker('getDate');
                        $("#task_end_date").datepicker("option", "minDate", startDate);
                    })

                    $('#task_end_date').change(function() {
                        endDate = $(this).datepicker('getDate');
                        $("#task_start_date").datepicker("option", "maxDate", endDate);
                    })

    });
    </script> --}}


{{--     <script>
        $(document).ready(function() {
    // Assume #budget_return_input is the ID for the "Budget Return" input
    // Assume #budget_increase_input is the ID for the "Budget Increase" input
    // Assume #total_budget_input is the ID for the "Total Budget" input

    // Function to calculate the total budget
    function calculateTotalBudget() {
        var budgetReturn = parseFloat($('#budget_return_input').val()) || 0;
        var budgetIncrease = parseFloat($('#budget_increase_input').val()) || 0;

        var totalBudget = budgetReturn + budgetIncrease;

        $('#total_budget_input').val(totalBudget.toFixed(2)); // toFixed(2) for two decimal places
    }

    // Event listener for when the "Budget Return" input changes
    $('#budget_return_input').on('input', function() {
        calculateTotalBudget();
    });

    // Event listener for when the "Budget Increase" input changes
    $('#budget_increase_input').on('input', function() {
        calculateTotalBudget();
    });

    // Initial calculation on page load
    calculateTotalBudget();
});
</script> --}}



  {{--     <script>
            // Assuming you have jQuery available
            $(document).ready(function() {
                // Function to calculate and display the budget based on the selected option and input values
                function calculateBudget() {
                    let budget = parseFloat($('#task_budget_it_operating').val().replace(/,/g, '')) || 0;
                    let refundBudget = parseFloat($('#task_refund_budget').val().replace(/,/g, '')) || 0;

                    // Determine which radio button is checked
                    let budgetType = $('input[name="task_refund_budget_type"]:checked').val();

                    // Perform calculation based on the selected budget type
                    switch(budgetType) {
                        case '0': // Just the budget
                            // No additional action needed
                            break;
                        case '1': // Just the refund
                            budget = refundBudget;
                            break;
                        case '2': // Budget plus refund
                            budget += refundBudget;
                            break;
                    }

                    // Update the input field with the calculated value
                    $('#task_refund_budget').val(budget.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ','));

                    // Additional logic to handle other fields can be added here
                }

                // Event listener for when the refund budget input changes
                $('#task_refund_budget').on('input', calculateBudget);

                // Event listener for when the budget type radio buttons change
                $('input[name="task_refund_budget_type"]').on('change', calculateBudget);

                // Call the calculateBudget function on initial load
                calculateBudget();
            });
        </script> --}}

{{--
        <script>
            // This function updates the remaining budget based on the inputs
            function updateRemainingBudget() {
                // Get the values from the inputs, default to 0 if empty
                var allocatedBudget = parseFloat(document.getElementById('allocated_budget').value) || 0;
                var refundAmount = parseFloat(document.getElementById('refund_amount').value) || 0;
                var additionalBudget = parseFloat(document.getElementById('additional_budget').value) || 0;

                // Calculate the remaining budget
                var remainingBudget = allocatedBudget - refundAmount + additionalBudget;

                // Update the remaining budget field
                document.getElementById('remaining_budget').value = remainingBudget.toFixed(2);
            }

            // Attach the updateRemainingBudget function to the 'input' event for each field
            document.getElementById('allocated_budget').addEventListener('input', updateRemainingBudget);
            document.getElementById('refund_amount').addEventListener('input', updateRemainingBudget);
            document.getElementById('additional_budget').addEventListener('input', updateRemainingBudget);

            // Update the remaining budget on page load
            document.addEventListener('DOMContentLoaded', updateRemainingBudget);
            </script> --}}
{{-- <script>
    // Initialize SweetAlert2 Click Handler
    $(document).ready(function() {
    // Click event for SweetAlert trigger button
    $('.swalDefaultSuccess').click(function() {
        var budgetItOperating = $("#task_budget_it_operating").val();
        var budgetItInvestment = $("#task_budget_it_investment").val();
        var budgetGovUtility = $("#task_budget_gov_utility").val();

        Swal.fire({
            title: 'Sweet Success!',
            text: 'Budget IT Operating: ' + budgetItOperating +
                  ', Budget IT Investment: ' + budgetItInvestment +
                  ', Budget Government Utility: ' + budgetGovUtility,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, save!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Reference the form and submit
                $("#formId").submit(); // Ensure there is an id="formId" on the form
            }
        });
    });
});

</script> --}}
