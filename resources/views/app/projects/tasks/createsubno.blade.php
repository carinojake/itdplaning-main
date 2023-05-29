<x-app-layout>
    <x-slot name="content">
        <div class="container-fluid">
            {{ Breadcrumbs::render('project.task.createsub', $project, $task) }}
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
                        <x-card>
                            <form method="POST" action="{{ route('project.task.store', $project) }}" class="row g-3">
                                @csrf
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-3">
                                        <label for="contract_fiscal_year" class="form-label">{{ __('ปีงบประมาณ') }}</label>
                                        <input type="text" class="form-control" id="contract_fiscal_year" value="{{ $projectyear->project_fiscal_year }}" disabled readonly>
                                        @error('contract_fiscal_year')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <input type="hidden" class="form-control" id="task_parent_display"
                                    value="{{ $task->task_name }}" disabled readonly>

                                <input {{-- type="hidden"  --}}class="form-control" id="task_parent" name="task_parent"
                                    value="{{ $task->task_id }}">

                                <!-- Add the rest of the form fields here -->
                                <!-- ... -->

                                <div class="{{-- d-none --}} row callout callout-primary mt-3">

                                    <div class="col-md-2">
                                        <label for="task_status" class="form-label">{{ __('สถานะกิจกรรม') }}</label>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="task_status"
                                                id="task_status1" value="1" checked>
                                            <label class="form-check-label" for="task_status1">
                                                ระหว่างดำเนินการ
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="task_status"
                                                id="task_status2" value="2">
                                            <label class="form-check-label" for="task_status2">
                                                ดำเนินการแล้วเสร็จ
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="task_type" class="form-label">{{ __('งาน/โครงการ') }}</label>

                                        <div class="form-check form-check-inline" type="hidden">
                                            <input class="form-check-input" type="radio" name="task_type"
                                                id="task_type2" value="2" checked>
                                            <label class="form-check-label" for="task_type2">
                                                ไม่มี PA
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-5" id='contract_group'>
                                        {{-- <div class="form-group">
                                            <label for="task_contract"
                                                class="form-label">{{ __(' ค่าใช้จ่ายสำนักงาน') }}</label>
                                            <select name="task_contract" id="task_contract"
                                                class="form-control js-example-basic-single">
                                                <option value="">ไม่มี</option>
                                                @foreach ($contracts as $contract)
                                                    <option value="{{ $contract->contract_id }}"
                                                        {{ session('contract_id') == $contract->contract_id ? 'selected' : '' }}>
                                                        [{{ $contract->contract_number }}]{{ $contract->contract_name }}

                                                    </option>
                                                @endforeach
                                            </select> --}}
                                            {{-- <select name="task_contract" id="task_contract" class="form-control js-example-basic-single">
                                                <option value="">ไม่มี</option>
                                                @if (!empty($contracts['results']))
                                                    @foreach ($contracts['results'] as $group)
                                                        <optgroup label="{{ $group['text'] }}">
                                                            @foreach ($group['children'] as $contract)
                                                                <option value="{{ $contract['id'] }}" {{ session('contract_id') == $contract['id'] ? 'selected' : '' }}>
                                                                    [{{ $contract['text'] }}]{{ $contract['text'] }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                @endif
                                            </select> --}}


                                            <div class="invalid-feedback">
                                                {{ __('สัญญา') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-3" id='add_contract_group'>
                                        {{--  <a href="{{ route('contract.create', ['origin' => $project,'project'=>$project ,'taskHashid' => $task->hashid]) }}" class="btn btn-success text-white">เพิ่มสัญญา/ใบจ้าง</a> --}}
                                        <a href="{{ route('contract.create', ['origin' => $project, 'project' => $project, 'taskHashid' => $task->hashid]) }}"
                                            class="btn btn-success text-white" target="contractCreate">เพิ่ม</a>
                                    </div>


                                </div>

                                @if (session('contract_id'))
                                    ID: {{ session('contract_id') }}
                                @endif

                                @if (session('contract_name'))
                                    Name: {{ session('contract_name') }}
                                @endif
                                @if (session('contract_pr_budget'))
                                    วงเงินที่ขออนุมัติ: {{ session('contract_pr_budget') }}
                                @endif
                                @if (session('contract_pa_budget'))
                                    ค่าใช้จ่าย: {{ session('contract_pa_budget') }}
                                @endif
                                @if (session('contract_pay'))
                                    เบิก: {{ session('contract_pay') }}
                                @endif



                    <div class=" row mt-3   callout callout-primary">
                        <div class="col-md-6 ">
                            <label for="task_start_date"
                                class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span
                                class="text-danger"></span>
                            <input class="form-control" id="task_start_date" name="task_start_date">
                        </div>
                        <div class="col-md-6">
                            <label for="task_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }}</label>
                            <span class="text-danger"></span>
                            <input class="form-control" id="task_end_date" name="task_end_date">
                        </div>
                    </div>

                    <div class=" callout callout-info">
                        <div class="col-md-12 mt-3">
                            <label for="task_name"
                                class="form-label">{{ __('ชื่อรายการที่ใช้จ่าย') }}</label>

                            <input type="text" class="form-control" id="task_name" name="task_name"
                                required autofocus>
                            <div class="invalid-feedback">
                                {{ __('ชื่อรายการที่ใช้จ่าย') }}
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="task_description"
                                class="form-label">{{ __('รายละเอียดที่ใช้จ่าย') }}</label>
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
                                        <label for="task_budget_it_operating"
                                            class="form-label">{{ __('งบกลาง ICT') }}</label>
                                        <!-- <input type="number" placeholder="0.00" step="0.01" class="form-control" id="task_budget_it_operating" name="task_budget_it_operating" min="0">-->
                                        <input type="text" placeholder="0.00" step="0.01"
                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                            class="form-control numeral-mask"
                                            id="task_budget_it_operating" name="task_budget_it_operating"
                                            min="0">

                                        <div class="invalid-feedback">
                                            {{ __('ระบุงบกลาง ICT') }}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="task_budget_it_investment"
                                            class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                        <!--  <input type="number" placeholder="0.00" step="0.01" class="form-control" id="task_budget_it_investment" name="task_budget_it_investment" min="0">-->
                                        <input type="text" placeholder="0.00" step="0.01"
                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                            class="form-control numeral-mask"
                                            id="task_budget_it_investment"
                                            name="task_budget_it_investment" min="0">

                                        <div class="invalid-feedback">
                                            {{ __('ระบุงบดำเนินงาน') }}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="task_budget_gov_utility"
                                            class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                        <!-- <input type="number" placeholder="0.00" step="0.01" class="form-control" id="task_budget_gov_utility" name="task_budget_gov_utility" min="0"> -->
                                        <input type="text" placeholder="0.00" step="0.01"
                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                            class="form-control numeral-mask" id="task_budget_gov_utility"
                                            name="task_budget_gov_utility" min="0">

                                        <div class="invalid-feedback">
                                            {{ __('ระบุค่าสาธารณูปโภค') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 ">
                                    <strong>ค่าใช้จ่าย</strong>
                                    <div class="col-md-12">
                                        <label for="task_cost_it_operating"
                                            class="form-label">{{ __('งบกลาง ICT') }}</label>
                                        <!-- <input type="number"placeholder="0.00" step="0.01" class="form-control" id="task_cost_it_operating" name="task_cost_it_operating" min="0">-->
                                        <input type="text" placeholder="0.00" step="0.01"
                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                            class="form-control numeral-mask" id="task_cost_it_operating"
                                            name="task_cost_it_operating" min="0">


                                        <div class="invalid-feedback">
                                            {{ __('งบกลาง ICT') }}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="task_cost_it_investment"
                                            class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                        <!-- <input type="number" placeholder="0.00" step="0.01"class="form-control" id="task_cost_it_investment" name="task_cost_it_investment" min="0"> -->
                                        <input type="text" placeholder="0.00" step="0.01"
                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                            class="form-control numeral-mask" id="task_cost_it_investment"
                                            name="task_cost_it_investment" min="0">


                                        <div class="invalid-feedback">
                                            {{ __('งบดำเนินงาน') }}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="task_cost_gov_utility"
                                            class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                        <!-- <input type="number" placeholder="0.00" step="0.01" class="form-control" id="task_cost_gov_utility" name="task_cost_gov_utility" min="0"> -->
                                        <input type="text" placeholder="0.00" step="0.01"
                                            data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                            class="form-control numeral-mask" id="task_cost_gov_utility"
                                            name="task_cost_gov_utility" min="0">


                                        <div class="invalid-feedback">
                                            {{ __('ระบุค่าสาธารณูปโภค') }}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="callout callout-warning">



                            <div class=" col-md-3">
                                <label for="contract_type" class="form-label">{{ __('ประเภท') }}</label>
                                {{ Form::select('contract_type', \Helper::contractType(), '4', ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...', 'id' => 'contract_type']) }}

                                {{--   {{ Form::select('contract_type', \Helper::contractType(), null, ['class' => 'form-control', 'placeholder' => 'เลือกประเภท...', 'id' => 'contract_type = 4']) }} --}}
                            </div>

                            <div {{-- class="accordion accordion-flush" id="accordionFlushExample" --}}>
                                {{--    <div class="accordion-item">
                                       <h2 class="accordion-header" id="flush-headingOne">
                                           <button class="accordion-button collapsed" type="button"
                                               data-coreui-toggle="collapse"
                                               data-coreui-target="#flush-collapseOne" aria-expanded="true"
                                               aria-controls="flush-collapseOne">
                                               ข้อมูลค่าใช้จ่าย
                                           </button>
                                       </h2> --}}

                                       <h4>   ข้อมูลค่าใช้จ่าย  </h4>
                                       <div {{-- id="flush-collapseOne" class="accordion-collapse collapse"
                                           aria-labelledby="flush-headingOne"
                                           data-coreui-parent="#accordionFlushExample" --}}>
                                           <div class="accordion-body">
                                               <div id="mm_form" {{-- style="display:none;" --}}>
                                                   <div class="callout callout-primary row mt-3">
                                                       <div class="col-md-4">
                                                           <label for="contract_mm"
                                                               class="form-label">{{ __('เลขที่ MM/เลขที่ สท.') }}</label>
                                                           <span class="text-danger"></span>

                                                           <input type="text" class="form-control"
                                                               id="contract_mm" name="contract_mm">
                                                           <div class="invalid-feedback">
                                                               {{ __(' ') }}
                                                           </div>
                                                       </div>

                                                       <div class="col-md-4">
                                                           <label for="contract_mm_budget"
                                                               class="form-label">{{ __('วงเงิน (บาท) MM') }}</label>
                                                           <span class="text-danger"></span>

                                                           <input type="text" placeholder="0.00"
                                                               step="0.01" class="form-control"
                                                               id="contract_mm_budget"
                                                               data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                               class="form-control numeral-mask"
                                                               name="contract_mm_budget" min="0">
                                                       </div>
                                                       <div id="pr_form" style="display:none;">
                                                           <div class="row mt-3">
                                                               <div class="col-md-4">
                                                                   <label for="contract_pr"
                                                                       class="form-label">{{ __('เลขที่ PR') }}</label>
                                                                   <span class="text-danger"></span>

                                                                   <input type="text" class="form-control"
                                                                       id="contract_PR" name="contract_pr">
                                                                   <div class="invalid-feedback">
                                                                       {{ __(' ') }}
                                                                   </div>
                                                               </div>

                                                               <div class="col-md-4">
                                                                   <label for="contract_pr_budget"
                                                                       class="form-label">{{ __('จำนวนเงิน (บาท) PR') }}</label>
                                                                   <span class="text-danger"></span>

                                                                   <input type="taxt" placeholder="0.00"
                                                                       step="0.01" class="form-control"
                                                                       id="contract_pr_budget"
                                                                       data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                       class="form-control numeral-mask"
                                                                       name="contract_pr_budget"
                                                                       min="0">
                                                               </div>
                                                           </div>
                                                       </div>

                                                   </div>
                                               </div>
                                               <div class="callout callout-success">
                                                   <div id="pr_form" style="display:none;">
                                                       <div class="row mt-3">
                                                           <div class="col-md-4">
                                                               <label for="contract_pa"
                                                                   class="form-label">{{ __('เลขที่ PA') }}</label>
                                                               <span class="text-danger"></span>

                                                               <input type="text" class="form-control"
                                                                   id="contract_PA" name="contract_pa">
                                                               <div class="invalid-feedback">
                                                                   {{ __(' ') }}
                                                               </div>
                                                           </div>

                                                           <div class="col-md-4">
                                                               <label for="contract_pa_budget"
                                                                   class="form-label">{{ __('จำนวนเงิน (บาท) PA') }}</label>
                                                               <span class="text-danger"></span>

                                                               <input type="taxt" placeholder="0.00"
                                                                   step="0.01" class="form-control"
                                                                   id="contract_pa_budget"
                                                                   data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                   class="form-control numeral-mask"
                                                                   name="contract_pa_budget" min="0">
                                                           </div>
                                                       </div>
                                                   </div>


                                                   <div id="po_form" style="display:none;">
                                                       <!-- PO form fields -->

                                                       <div class="row mt-3">
                                                           <div class="col-md-4">
                                                               <label for="contract_po"
                                                                   class="form-label">{{ __('เลขที่ PO') }}</label>
                                                               <span class="text-danger"></span>

                                                               <input type="text" class="form-control"
                                                                   id="contract_PO" name="contract_po">
                                                               <div class="invalid-feedback">
                                                                   {{ __(' ') }}
                                                               </div>
                                                           </div>

                                                           <div class="col-md-4">
                                                               <label for="contract_po_budget"
                                                                   class="form-label">{{ __('จำนวนเงิน (บาท) PO') }}</label>
                                                               <span class="text-danger"></span>

                                                               <input type="taxt" placeholder="0.00"
                                                                   step="0.01" class="form-control"
                                                                   id="contract_po_budget"
                                                                   data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                   class="form-control numeral-mask"
                                                                   name="contract_po_budget" min="0">
                                                           </div>


                                                           <div class="col-md-4">
                                                               <label for="contract_po_start_date"
                                                                   class="form-label">{{ __('กำหนดวันที่ส่งของ') }}</label>
                                                               <span class="text-danger"></span>

                                                               <input type="text" class="form-control"
                                                                   id="contract_po_start_date"
                                                                   name="contract_po_start_date">
                                                               <div class="invalid-feedback">
                                                                   {{ __(' ') }}
                                                               </div>
                                                           </div>
                                                       </div>
                                                   </div>
                                                   <div id="er_form" style="display:none;">
                                                       <div class="row mt-3">
                                                           <div class="col-md-4">
                                                               <label for="contract_er"
                                                                   class="form-label">{{ __('เลขที่ ER') }}</label>
                                                               <span class="text-danger"></span>

                                                               <input type="text" class="form-control"
                                                                   id="contract_ER" name="contract_er">
                                                               <div class="invalid-feedback">
                                                                   {{ __(' ') }}
                                                               </div>
                                                           </div>

                                                           <div class="col-md-4">
                                                               <label for="contract_er_budget"
                                                                   class="form-label">{{ __('จำนวนเงิน (บาท) ER') }}</label>
                                                               <span class="text-danger"></span>

                                                               <input type="text" placeholder="0.00"
                                                                   step="0.01" class="form-control"
                                                                   id="contract_er_budget"
                                                                   data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                   class="form-control numeral-mask"
                                                                   name="contract_po_budget" min="0">
                                                           </div>

                                                           <div class="col-md-4">
                                                               <label for="contract_er_start_date"
                                                                   class="form-label">{{ __('กำหนดวันที่ส่งมอบงาน') }}</label>
                                                               <span class="text-danger"></span>

                                                               <input type="text" class="form-control"
                                                                   id="contract_er_start_date"
                                                                   name="contract_er_start_date">
                                                               <div class="invalid-feedback">
                                                                   {{ __(' ') }}
                                                               </div>
                                                           </div>
                                                       </div>
                                                   </div>

                                                   <div id="cn_form" style="display:none;">
                                                       <div class="row mt-3">
                                                           <div class="col-md-4">
                                                               <label for="contract_cn"
                                                                   class="form-label">{{ __('เลขที่ CN') }}</label>
                                                               <span class="text-danger"></span>

                                                               <input type="text" class="form-control"
                                                                   id="contract_cn" name="contract_cn">
                                                               <div class="invalid-feedback">
                                                                   {{ __(' ') }}
                                                               </div>
                                                           </div>

                                                           <div class="col-md-4">
                                                               <label for="contract_cn_budget"
                                                                   class="form-label">{{ __('จำนวนเงิน (บาท) CN') }}</label>
                                                               <span class="text-danger"></span>

                                                               <input type="text" placeholder="0.00"
                                                                   step="0.01" class="form-control"
                                                                   id="contract_cn_budget"
                                                                   data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                   class="form-control numeral-mask"
                                                                   name="contract_cn_budget" min="0">
                                                           </div>
                                                       </div>
                                                   </div>
                                                   <div id="ba_form" {{-- style="display:none;" --}}>
                                                       <div class="row mt-3">
                                                           <div class="col-md-4">
                                                               <label for="contract_ba "
                                                                   class="form-label">{{ __('เลขที่  BA ') }}</label>
                                                               {{--  officeexpenses ค่าใช้จ่ายสำนักงาน --}}
                                                               <span class="text-danger"></span>

                                                               <input type="text" class="form-control"
                                                                   id="contract_ba" name="contract_cn">
                                                               <div class="invalid-feedback">
                                                                   {{ __(' ') }}
                                                               </div>
                                                           </div>

                                                           <div class="col-md-4">
                                                               <label for="contract_ba_budget"
                                                                   class="form-label">{{ __('จำนวนเงิน (บาท) BA') }}</label>
                                                               <span class="text-danger"></span>

                                                               <input type="text" placeholder="0.00"
                                                                   step="0.01" class="form-control"
                                                                   id="contract_oe_budget"
                                                                   data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                   class="form-control numeral-mask"
                                                                   name="contract_oe_budget" min="0">
                                                           </div>
                                                       </div>
                                                   </div>

                                                   <div id="bd_form" {{-- style="display:none; --}}">
                                                       <div class="row mt-3">
                                                           <div class="col-md-4">
                                                               <label for="contract_bd "
                                                                   class="form-label">{{ __('เลขที่ BD') }}</label>
                                                               {{--  officeexpenses ค่าใช้จ่ายสำนักงาน --}}
                                                               <span class="text-danger"></span>

                                                               <input type="text" class="form-control"
                                                                   id="contract_bd" name="contract_bd">
                                                               <div class="invalid-feedback">
                                                                   {{ __(' ') }}
                                                               </div>
                                                           </div>

                                                           <div class="col-md-4">
                                                               <label for="contract_bd_budget"
                                                                   class="form-label">{{ __('จำนวนเงิน (บาท) BD') }}</label>
                                                               <span class="text-danger"></span>

                                                               <input type="text" placeholder="0.00"
                                                                   step="0.01" class="form-control"
                                                                   id="contract_bd_budget"
                                                                   data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                                   class="form-control numeral-mask"
                                                                   name="contract_bd_budget" min="0">
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>
                                               <div id="pp_form"
                                                   class="callout callout-danger"{{--  style="display:none;" --}}>
                                                   <div class="row mt-3">
                                                       <div class="col-md-4">
                                                           <label for="contract_pay"
                                                               class="form-label">{{ __('เลขที่_PP ') }}</label>
                                                           <span class="text-danger"></span>

                                                           <input type="text" class="form-control"
                                                               id="contract_pp" name="contract_cn">
                                                           <div class="invalid-feedback">
                                                               {{ __(' ') }}
                                                           </div>
                                                       </div>

                                                       <div class="col-md-4">
                                                           <label for="contract_pay"
                                                               class="form-label">{{ __('จำนวนเงิน (บาท) PP') }}</label>
                                                           <span class="text-danger"></span>

                                                           <input type="text" placeholder="0.00"
                                                               step="0.01" class="form-control"
                                                               id="contract_pay"
                                                               data-inputmask="'alias': 'decimal', 'groupSeparator': ','"
                                                               class="form-control numeral-mask"
                                                               name="contract_pay" min="0">
                                                       </div>
                                                   </div>

                                               <div id="rounds_form" class="callout callout-warning"
                                                  {{--  style="display:none;" --}}>
                                                   <div class="row mt-3">
                                                       <div class="col-md-12">
                                                           <label id="rounds_label" for="rounds"
                                                               class="form-label">{{ __('ค่าใช้จ่ายสำนักงาน') }}</label>

                                                           {{ Form::select('contract_type', \Helper::taskconrounds(), null, ['class' => ' js-example-basic-single', 'placeholder' => 'item...', 'id' => 'rounds', 'name' => 'change']) }}
                                                           <div id="tasksContainer"></div>
                                                           <div class="invalid-feedback">
                                                               {{ __(' ') }}
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div><!-- 1  -->
                                       </div>
                                   </div>

                                   <div {{-- class="  accordion-item" --}}>
                                    {{-- <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button"
                                            data-coreui-toggle="collapse"
                                            data-coreui-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                            ข้อมูลสัญญา 2
                                            (เลขที่สัญญา,เลขทะเบียนคู่ค้า,วันที่เริ่มต้น-สิ้นสุด,ลงนามสัญญา,
                                            ประก้น)
                                        </button>
                                      </h2> --}}

                                      <h4>    ข้อมูลสัญญา 2
                                        (เลขที่สัญญา,เลขทะเบียนคู่ค้า,วันที่เริ่มต้น-สิ้นสุด,ลงนามสัญญา,
                                        ประก้น)    </h4>
                                    <div {{--  id="collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwo"
                                        data-coreui-parent="#accordionExample" --}}>
                                        <div class="accordion-body">


                                            <div class="row callout callout-info mt-3">
                                                <div class="col-md-3">
                                                    <label for="contract_number" class="form-label">{{ __('เลขที่สัญญา') }}</label>
                                                    {{-- <span class="text-danger">*</span> --}}
                                                    <input type="text" class="form-control" id="contract_number" name="contract_number">
                                                    <div class="invalid-feedback">
                                                        {{ __('เลขที่สัญญา ซ้ำ') }}
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="contract_juristic_id"
                                                        class="form-label">{{ __('เลขทะเบียนคู่ค้า') }}</label>
                                                    <input type="text" class="form-control"
                                                        id="contract_juristic_id"
                                                        name="contract_juristic_id" maxlength="13">
                                                    <div class="invalid-feedback">
                                                        {{ __('คู่ค้าซ้ำ') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row callout callout-warning  mt-3">

                                                <div class="col-md-3">
                                                    <label for="contract_start_date"
                                                        class="form-label">{{ __('วันที่เริ่มต้น') }}</label>
                                                    {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                                                    <input type="text" class="form-control"
                                                        id="contract_start_date"
                                                        name="contract_start_date">
                                                    <!--<div data-coreui-toggle="date-picker" id="contract_start_date"
            data-coreui-format="dd/MM/yyyy"></div>-->
                                                </div>


                                                <div class="col-md-3">
                                                    <label for="contract_end_date"
                                                        class="form-label">{{ __('วันที่สิ้นสุด') }}</label>
                                                    <input type="text" class="form-control"
                                                        id="contract_end_date" name="contract_end_date">
                                                    <!-- <div data-coreui-toggle="date-picker" id="contract_end_date"
            data-coreui-format="dd/MM/yyyy">
        </div>-->
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="contract_sign_date"
                                                        class="form-label">{{ __('วันที่ลงนามสัญญา') }}</label>
                                                    <input type="text" class="form-control"
                                                        id="contract_sign_date" name="contract_sign_date">
                                                    <!--<div data-coreui-toggle="date-picker" id="contract_sign_date"
            data-coreui-format="dd/MM/yyyy"></div>-->
                                                </div>
                                            </div>

                                            <div class="row callout callout-danger mt-3">
                                                <div class="col-md-3">
                                                    <label for="insurance_start_date"
                                                        class="form-label">{{ __('วันที่เริ่มต้น ประก้น') }}</label>
                                                    <span class="text-danger"></span>
                                                    <input type="text" class="form-control"
                                                        id="insurance_start_date"
                                                        name="insurance_start_date">
                                                    <!-- <div data-coreui-toggle="date-picker" id="insurance_start_date"
            data-coreui-format="dd/MM/yyyy"></div>-->
                                                </div>


                                                <div class="col-md-3">
                                                    <label for="insurance_end_date"
                                                        class="form-label">{{ __('วันที่สิ้นสุด ประกัน') }}</label>
                                                    <span class="text-danger"></span>
                                                    <input type="text" class="form-control"
                                                        id="insurance_end_date" name="insurance_end_date">
                                                    <!-- <div data-coreui-toggle="date-picker" id="insurance_end_date"
            data-coreui-format="dd/MM/yyyy">
        </div>-->
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-md-3">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                {{ __('ประกัน จำนวนเดือน') }}
                                                            </div>
                                                            <div id="insurance_duration_months"
                                                                class="col-12">
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-12">
                                                                {{ __('ประกัน จำนวนวัน') }}
                                                            </div>
                                                            <div id="insurance_duration_days"
                                                                class="col-12">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--จบ ข้อมูลสัญญา 2-->
                                        </div>
                                    </div>
                                </div>
                                <div {{-- class="d-none accordion-item" --}}>
                                    {{--     <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button collapsed" type="button"
                                                data-coreui-toggle="collapse"
                                                data-coreui-target="#collapseThree" aria-expanded="false"
                                                aria-controls="collapseThree">
                                                ข้อมูลสัญญา 3
                                            </button>
                                        </h2> --}}
                                        <h4>  ข้อมูลสัญญา 3</h4>
                                        <div {{-- id="collapseThree" class="accordion-collapse collapse"
                                            aria-labelledby="headingThree"
                                            data-coreui-parent="#accordionExample" --}}>
                                            <div class="accordion-body">

                                                <!--ข้อมูลสัญญา 3 -->
                                                <div class="col-md-12 mt-3">
                                                    <label for="task_name" class="form-label">{{ __('ชื่อรายการที่ใช้จ่าย') }}</label>

                                                    <input type="text" class="form-control" id="task_name" name="task_name" required
                                                        autofocus>
                                                    <div class="invalid-feedback">
                                                        {{ __('ชื่อรายการที่ใช้จ่าย') }}
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mt-3">
                                                    <label for="task_description"
                                                        class="form-label">{{ __('รายละเอียดที่ใช้จ่าย') }}</label>
                                                    <textarea class="form-control" name="task_description" id="task_description" rows="10"></textarea>
                                                    <div class="invalid-feedback">
                                                        {{ __('รายละเอียดการที่ใช้จ่าย') }}
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mt-3">
                                                    <label for="contract_name"
                                                        class="form-label">{{ __('ชื่อ MM / ชื่อบันทึกข้อความ') }}</label>


                                                    <input type="text" class="form-control"
                                                        id="contract_mm_name" name="contract_mm_name" required
                                                        autofocus>
                                                    <div class="invalid-feedback">
                                                        {{ __('ชื่อสัญญา ซ้ำ') }}
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <label for="contract_name" id="contract_name_label"
                                                        class="form-label">{{ __('ชื่อ ค่าใช้จ่ายสำนักงาน') }}</label>

                                                    <input type="text" class="form-control"
                                                        id="contract_name" name="contract_name" required
                                                        autofocus>
                                                    <div class="invalid-feedback">
                                                        {{ __('ชื่อสัญญา ซ้ำ') }}
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="contract_description"
                                                        class="form-label">{{ __('รายละเอียดสัญญา') }}</label>
                                                    <textarea class="form-control" name="contract_description" id="contract_description" rows="10"></textarea>
                                                    <div class="invalid-feedback">
                                                        {{ __('รายละเอียดงาน/โครงการ') }}
                                                    </div>
                                                </div>
                                            </div>

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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    </x-slot:css>

    <x-slot:javascript>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src = "https://code.jquery.com/jquery-3.6.0.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#rounds').change(function() {
                var rounds = $(this).val();
                $('#tasksContainer').empty(); // clear the container
                for (var i = 0; i < rounds; i++) {
                    $('#tasksContainer').append(`
                    <div class="row mt-3">
                        <div class="col-md-12">

                                <label>ชื่อ ` + (i + 1) + ` &nbsp: &nbsp</label>
                        <input type="text" name="tasks[` + i + `][task_name]" value=" ` + (i + 1) + `">



                        <label> &nbsp: &nbspใช้ไป &nbsp: &nbsp</label>
                        <input type="text" name="tasks[` + i + `][task_pay]" value=" ">


                        </div>
                    </div>
                `);
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#contract_type').change(function() {
                var contract_type = $(this).val();
                var contract_name_label = $('#contract_name_label');
                var rounds_form = $('#rounds_form');
                var rounds_label = $('#rounds_label');



                if (contract_type == 1) {
                    contract_name_label.text('ชื่อ PO');
                    rounds_label.text('จำนวนงวด');
                    $('#mm_form').show();
                    $('#pr_form').show();
                    $('#pa_form').show();
                    $('#po_form').show();
                    $('#er_form').hide();
                    $('#cn_form').show();
                    $('#oe_form').hide();
                    $('#pp_form').hide();
                    $('#rounds_form').show();
                } else if (contract_type == 2) {
                    contract_name_label.text('ชื่อ ER');
                    rounds_label.text('จำนวนงวด');
                    $('#mm_form').show();
                    $('#pr_form').show();
                    $('#pa_form').show();
                    $('#po_form').hide();
                    $('#er_form').show();
                    $('#cn_form').show();
                    $('#oe_form').hide();
                    $('#pp_form').hide();
                    $('#rounds_form').show();
                } else if (contract_type == 3) {
                    contract_name_label.text('ชื่อ CN');
                    rounds_label.text('จำนวนงวด');
                    $('#mm_form').show();
                    $('#pr_form').show();
                    $('#pa_form').show();
                    $('#po_form').show();
                    $('#er_form').hide();
                    $('#cn_form').show();
                    $('#oe_form').hide();
                    $('#pp_form').hide();
                    $('#rounds_form').show();
                } else if (contract_type == 4) {
                    contract_name_label.text('ชื่อ ค่าใช้จ่ายสำนักงาน');
                    rounds_label.text('ค่าใช้จ่ายสำนักงาน');
                    $('#mm_form').show();
                    $('#pr_form').hide();
                    $('#pa_form').hide();
                    $('#po_form').hide();
                    $('#er_form').hide();
                    $('#cn_form').hide();
                    $('#oe_form').show();
                    $('#pp_form').show();
                    $('#ba_form').show();
                    $('#bd_form').show();
                    $('#rounds_form').show();
                } else {
                    contract_name_label.text('ชื่อ PO/ER/CN/ค่าใช้จ่ายสำนักงาน');
                    $('#mm_form').show();
                    $('#pr_form').show();
                    $('#pa_form').show();
                    $('#po_form').show();
                    $('#er_form').show();
                    $('#cn_form').show();
                    $('#oe_form').show();
                    $('#pp_form').show();
                    $('#ba_form').show();
                    $('#bd_form').show();
                    $('#rounds_form').show();
                }
            });
        });
    </script>

<script>
    $(document).ready(function() {
        // Initialize Select2 on the select element
        $('.js-example-basic-single').select2();

        $('.js-example-basic-single').on('change', function() {
            // Get the selected value
            const selectedValue = $(this).val();
            // Handle the selected value as needed
            console.log(selectedValue);
        });
    });
</script>


{{-- <script>
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
            headers: {
                'Content-Type': 'application/json'
            },
        });

        if (response.ok) {
            const newContract = await response.json();
            // เพิ่มรายการสัญญาใหม่ลงใน <select>
            addContractOption(newContract);
        }
    });
</script> --}}




<script>
    $(document).ready(function() {
        $(":input").inputmask();
    });
</script>

<script>
    $(function() {
        if (typeof jQuery == 'undefined' || typeof jQuery.ui == 'undefined') {
            alert("jQuery or jQuery UI is not loaded");
            return;
        }

        var d = new Date();
        var toDay = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 543);

        $("#task_start_date, #task_end_date").datepicker({
            dateFormat: 'dd/mm/yy',
            isBuddhist: true,
            defaultDate: toDay,
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
        var contract_label = $('#contract_label');

        $('input[type=radio][name=task_type]').change(function() {
            var task_type = $(this).val();

            if (task_type == 1) {
                contract_label.text('สัญญา');
                $('#contract_group').show();
                $('#add_contract_group').show();
            } else if (task_type == 2) {
                contract_label.text('สัญญา');
                $('#contract_group').show();
                $('#add_contract_group').show();
            }
        });
    });
</script>






    </x-slot:javascript>
  </x-app-layout>
