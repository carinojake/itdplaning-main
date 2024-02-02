<x-app-layout>
    <x-slot:content>
        <div class="container-fluid">
            {{ Breadcrumbs::render('project.edit', $project) }}
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
            <x-card
                       title="{{ __('แก้ไข') }} {{ Helper::projectsType($project->project_type) }} {{ $project->project_name }}">




            <form id='formId' method="POST" action="{{ route('project.update', $project->hashid) }}"
                                class="row needs-validation"  novalidate >
                                @csrf
                                {{ method_field('PUT') }}

                        <div class="row mt-3">


                                <div class="col-md-2">
                                    <label for="project_type"
                                        class="form-label">{{ __('ประเภทงาน/โครงการ') }}</label> <span
                                        class="text-danger">*</span>
                                    <div>
                                        <input class="form-check-input" type="radio" name="project_type"
                                            id="project_type1" value="1" @checked($project->project_type == 1)>
                                        <label class="form-check-label" for="project_type1"
                                            @checked($project->project_type == 1)>
                                            งานประจำ
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="project_type"
                                            id="project_type2" value="2" @checked($project->project_type == 2)>
                                        <label class="form-check-label" for="project_type2"
                                            @checked($project->project_type == 2)>
                                            โครงการ
                                        </label>
                                    </div>
                                    <div class="invalid-feedback">
                                        {{ __('สถานะงาน/โครงการ') }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="project_fiscal_year" class="form-label">{{ __('ปีงบประมาณ') }}</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" id="project_fiscal_year"
                                        name="project_fiscal_year" value="{{ $project->project_fiscal_year }}"
                                        readonly>
                                    <div class="invalid-feedback">
                                        {{ __('ปีงบประมาณ') }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="reguiar_id" class="form-label">{{ __('ลำดับ.ชื่องาน/โครงการ *') }}</label>
                                    <span class="text-danger"></span>
                                    <input type="number" class="form-control" id="reguiar_id" name="reguiar_id"
                                        value="{{ $project->reguiar_id }}" min="1">
                                    <div class="invalid-feedback">
                                        {{ __('ลำดับ.ชื่องาน/โครงการ * ') }}
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <label for="project_status"
                                        class="form-label">{{ __('สถานะงาน/โครงการ') }}</label> <span
                                        class="text-danger">*</span>
                                    <div >
                                        <input class="form-check-input" type="radio" name="project_status"
                                            id="project_status1" value="1" @checked($project->project_status == 1)>
                                        <label class="form-check-label" for="project_status1"
                                            @checked($project->project_status == 1)>
                                            อยู่ในระหว่างดำเนินการ
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="project_status"
                                            id="project_status2" value="2" @checked($project->project_status == 2)>
                                        <label class="form-check-label" for="project_status2"
                                            @checked($project->project_status == 1)>
                                            ดำเนินการแล้วเสร็จ
                                        </label>
                                    </div>
                                <div class="invalid-feedback">
                                    {{ __('สถานะงาน/โครงการ') }}
                                </div>
                            </div>
                        </div>
{{--
                        <div class="col-md-6">
                            <label for="project_start_date"
                                class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span
                                class="text-danger">*</span>

                            <div data-coreui-toggle="date-picker" id="project_start_date"
                                data-coreui-format="dd/MM/yyyy" data-coreui-locale="th-TH"
                                data-coreui-date="{{ date('m/d/Y', $project->project_start_date) }} "></div>
                        </div>
                        <div class="col-md-6">
                            <label for="project_end_date"
                                class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span
                                class="text-danger">*</span>

                            <div data-coreui-toggle="date-picker" id="project_end_date"
                                data-coreui-format="dd/MM/yyyy" data-coreui-locale="th-TH"
                                data-coreui-date="{{ date('m/d/Y', $project->project_end_date) }}"></div>
                        </div>
 --}}

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="project_start_date"
                                class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span
                                class="text-danger">*</span>
                                <input type="text" class="form-control" id="project_start_date" name="project_start_date"
                                    value="{{ \Helper::date4(date('Y-m-d H:i:s', $project->project_start_date)) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="project_end_date"
                                                class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span
                                                class="text-danger">*</span>
                                <input type="text" class="form-control" id="project_end_date" name="project_end_date"
                                    value="{{ \Helper::date4(date('Y-m-d H:i:s', $project->project_end_date)) }}">
                            </div>
                        </div>



                                <div id='project_name_form'class="col-md-12">
                                    <label for="project_name" class="form-label">{{ __('ชื่องาน/โครงการ') }}</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" id="project_name" name="project_name"
                                        value="{{ $project->project_name }}" required autofocus>
                                    <div class="invalid-feedback">
                                        {{ __('ชื่องาน/โครงการ') }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="project_description"
                                        class="form-label">{{ __('รายละเอียดงาน/โครงการ') }}</label>
                                    <textarea class="form-control" name="project_description" id="project_description" rows="10">
                    {{$project->project_description}}
                  </textarea>
                                    <div class="invalid-feedback">
                                        {{ __('รายละเอียดงาน/โครงการ') }}
                                    </div>
                                </div>

                                <div  id='budget_form'class="row">


                                    <div class=" mt-3">
                                        <h4>งบประมาณ</h4>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="budget_it_operating"
                                                    class="form-label">{{ __('งบกลาง ICT ') }}</label>
                                                <!--<input type="text" placeholder="0.00" step="0.01" class="form-control" id="budget_it_investment" name="budget_it_investment" min="0" value="100000.00">-->
                                                <input type="text" placeholder="0.00" step="0.01"
                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control" id="budget_it_operating"
                                                    name="budget_it_operating" min="0"
                                                    value="{{ $project->budget_it_operating }}"
                                                    @foreach($increasedbudgetData as $key => $increaseData)
                                                    {{ $increaseData->increased_budget_it_operating  > 1 ||$increaseData->increased_budget_it_investment  > 1 || $increaseData->increased_budget_gov_utility  > 1? 'readonly' : '' }}
                                                    @endforeach
                                                    >
                                                  {{--   <div class="mt-3">
                                                        @if( $budget['totalBudgetItOperating'])
                                                        งบประมาณมีการถูกใช้ไปแล้วไม่สามารถต่ำ  {{number_format(  $project->budget_it_operating)}} บาท@endif
                                                    </div> --}}
                                                <div id="budget_it_operating_feedback" class="invalid-feedback">
                                                    {{ __('ระบุงบกลาง ICT') }}
                                                </div>
                                            </div>



                                            <div class="col-4">
                                                <label for="budget_it_investment"
                                                    class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control" id="budget_it_investment"
                                                    name="budget_it_investment" min="0"
                                                    value="{{ $project->budget_it_investment }}"
                                                    @foreach($increasedbudgetData as $key => $increaseData)
                                                    {{ $increaseData->increased_budget_it_operating  > 1 ||$increaseData->increased_budget_it_investment  > 1 || $increaseData->increased_budget_gov_utility  > 1? 'readonly' : '' }}
                                                    @endforeach


                                                    >
                                                  {{--   <div class="mt-3">
                                                        @if( $budget['totalBudgetItInvestment'])

                                                        งบประมาณมีการถูกใช้ไปแล้วไม่สามารถต่ำ   {{number_format( $project->budget_it_investment)}}  บาท@endif
                                                    </div> --}}
                                                <div id='budget_it_investment_feedback' class="invalid-feedback">
                                                    {{ __('ระบุงบดำเนินงาน') }}
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="budget_gov_utility"
                                                    class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control" id="budget_gov_utility"
                                                    name="budget_gov_utility" min="0"
                                                    value="{{ $project->budget_gov_utility }}"
                                                    @foreach($increasedbudgetData as $key => $increaseData)
                                                    {{ $increaseData->increased_budget_it_operating  > 1 ||$increaseData->increased_budget_it_investment  > 1 || $increaseData->increased_budget_gov_utility  > 1? 'readonly' : '' }}
                                                    @endforeach

                                                    >
                                  {{--                   <div class="mt-3">
                                                        @if( $budget['totalBudgetGovUtility'])

                                                        งบประมาณมีการถูกใช้ไปแล้วไม่สามารถต่ำ {{number_format( $project->budget_gov_utility)}} บาท@endif
                                                    </div> --}}

                                                <div id='budget_gov_utility_feedback' class="invalid-feedback">
                                                    {{ __('ระบุค่าสาธารณูปโภค') }}
                                                </div>
                                            </div>
                                        </div>




                                    </div>
                                </div>

                                <div id="increaseData_form" class="row mt-3">
                                    @foreach($increasedbudgetData as $key => $increaseData)
                                        <div class="mt-3">
                                            <h4>งบประมาณ เพิ่ม ครั้งที่ {{ $key +1}}</h4>
                                            <input  type="hidden"  name="increaseData[{{ $key + 1 }}][increased_budget_id]" value="{{ $increaseData->increased_budget_id }}">

                                            <div class="row">
                                                <!-- Input for increased_budget_it_operating -->
                                                <div class="col-md-4">
                                                    <input type="text" placeholder="0.00" step="0.01"
                                                    data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                       class="form-control"
                                                           id="increased_budget_it_operating_{{ $key +1 }}"
                                                           name="increaseData[{{ $key +1 }}][increased_budget_it_operating]"
                                                           min="0"
                                                           value="{{ $increaseData->increased_budget_it_operating }}"
                                                           {{ $key < count($increasedbudgetData) - 1 ? 'readonly' : '' }}>
                                                </div>




                                                <!-- Input for increased_budget_it_investment -->
                                                <div class="col-md-4">
                                                    <input type="text" placeholder="0.00" step="0.01"
                                                    data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                       class="form-control"
                                                           id="increased_budget_it_investment_{{ $key +1 }}"
                                                           name="increaseData[{{ $key +1 }}][increased_budget_it_investment]"
                                                           min="0"
                                                           value="{{ $increaseData->increased_budget_it_investment }}"
                                                           {{ $key < count($increasedbudgetData) - 1 ? 'readonly' : '' }}>
                                                </div>

                                                <!-- Input for increased_budget_gov_utility -->
                                                <div class="col-md-4">
                                                    <input type="text" placeholder="0.00" step="0.01"
                                                    data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                       class="form-control"
                                                           id="increased_budget_gov_utility_{{ $key +1 }}"
                                                           name="increaseData[{{ $key +1 }}][increased_budget_gov_utility]"
                                                           min="0"
                                                           value="{{ $increaseData->increased_budget_gov_utility }}"
                                                           {{ $key < count($increasedbudgetData) - 1 ? 'readonly' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                               {{--  <div  id='totalbudget' class="row">
                                    <div class="col-md-4">
                                        <label for="budget_it_operating"
                                            class="form-label">{{ __('งบกลาง ICT ') }}</label>
                                        <!--<input type="text" placeholder="0.00" step="0.01" class="form-control" id="budget_it_investment" name="budget_it_investment" min="0" value="100000.00">-->
                                        <input type="text" placeholder="0.00" step="0.01"
                                         data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                            class="form-control" id="budget_it_operating"
                                            name="budget_it_operating" min="0"
                                            value="{{ $budget['totalBudgetItOperating'] }}"
                                            readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="budget_it_investment"
                                            class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                        <input type="text" placeholder="0.00" step="0.01"
                                         data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                            class="form-control" id="budget_it_investment"
                                            name="budget_it_investment" min="0"
                                            value="{{ $budget['totalBudgetItInvestment'] }}"
                                            readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="budget_gov_utility"
                                                class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                            <input type="text" placeholder="0.00" step="0.01"
                                             data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                class="form-control" id="budget_gov_utility"
                                                name="budget_gov_utility" min="0"
                                                value="{{ $budget['totalBudgetGovUtility'] }}"
                                                readonly>






                                </div> --}}




                                <div class="row mt-3  ">

                                    <div id='increased_budget_status'class="col-md-3">
                                        <label for="increased_budget_status"
                                            class="form-label">{{ __('งบประมาณ เพิ่ม') }}</label> <span
                                            class="text-danger"></span>
                                        <div >
                                            <input class="form-check-input" type="checkbox" name="increased_budget_status"
                                                id="increased_budget_status" value="1" >
                                            <label class="form-check-label" for="increased_budget_status"
                                               >
                                                งบประมาณ เพิ่ม
                                            </label>
                                        </div>

                                    <div class="invalid-feedback">
                                        {{ __('งบประมาณ เพิ่ม') }}
                                    </div>
                                </div>


                                <div id='increased_budget_new' class="mt-3">
                                        <h4>งบประมาณ เพิ่ม</h4>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="increased_budget_it_operating_new"
                                                    class="form-label">{{ __('งบกลาง ICT ') }}</label>
                                                <!--<input type="text" placeholder="0.00" step="0.01" class="form-control" id="budget_it_investment" name="budget_it_investment" min="0" value="100000.00">-->
                                                <input type="text" placeholder="0.00" step="0.01"
                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control" id="increased_budget_it_operating_new"
                                                    name="increased_budget_it_operating_new" min="0"
                                                    >
                                                <div class="invalid-feedback">
                                                    {{ __('ระบุงบกลาง ICT') }}
                                                </div>
                                            </div>



                                            <div class="col-md-4">
                                                <label for="increased_budget_it_investment_new"
                                                    class="form-label">{{ __('งบดำเนินงาน') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control" id="increased_budget_it_investment_new"
                                                    name="increased_budget_it_investment_new" min="0"
                                                    >
                                                <div class="invalid-feedback">
                                                    {{ __('ระบุงบดำเนินงาน') }}
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="increased_budget_gov_utility_new"
                                                    class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                                                <input type="text" placeholder="0.00" step="0.01"
                                                 data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                                    class="form-control" id="increased_budget_gov_utility_new"
                                                    name="increased_budget_gov_utility_new" min="0"
                                                >
                                                <div class="invalid-feedback">
                                                    {{ __('ระบุค่าสาธารณูปโภค') }}
                                                </div>
                                            </div>
                                        </div>




                                    </div>

                                </div>

                                {{-- <div class="col-md-4">
                                    <label for="budget_it_operating"
                                        class="form-label">{{ __('งบกลาง ICT ') }}</label>
                                    <!--<input type="text" placeholder="0.00" step="0.01" class="form-control" id="budget_it_investment" name="budget_it_investment" min="0" value="100000.00">-->
                                    <input type="text" placeholder="0.00" step="0.01"
                                     data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
                                        class="form-control" id="budget_it_operating"
                                        name="budget_it_operating" min="0"
                                        value=" {{$projectDetails->budget_it_operating}}"


                                        >
                                    <div class="invalid-feedback">
                                        {{ __('ระบุงบกลาง ICT') }}
                                    </div>
                                </div> --}}

                    </div>
                 {{--    <x-button link="{{ route('project.view', ['project' => $project->hashid]) }}"
                        class="btn-warning text-black">{{ __('view') }}</x-button> --}}
                        <x-button type="submit" class="btn-success" preventDouble icon="cil-save">
                            {{ __('Save') }}
                        </x-button>
                    <x-button link="{{ route('project.view', ['project' => $project->hashid]) }}" class="btn-light text-black">
                        {{ __('coreuiforms.return') }}</x-button>
        </form>
         </x-card>
                </div>
            </div>
        </div>
        </div>

        <div class="row ">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <x-card title="{{ __('เอกสารแนบ ของ') }}{{-- {{ $task->task_name }} --}}">
                    <form id = 'formId_file' method="POST"
                         action="{{ route('project.filesprojectup', ['project' => $project->hashid]) }}"
                        enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <div class=" col-md-12 mt-3">
                            <label for="file" class="form-label">{{ __('เอกสารแนบ') }}</label>
                            <div class="input-group control-group increment ">
                                <input type="file" name="file[]" class="form-control" multiple>
                                <div class="input-group-btn">
                                    <button class="btn btn-success" type="button"><i
                                            class="glyphicon glyphicon-plus"></i>Add</button>

                                </div>
                            </div>
                            <div class="clone d-none">
                                <div class="control-group input-group" style="margin-top:10px">
                                    <input type="file" name="file[]" class="form-control" multiple>
                                    <div class="input-group-btn">
                                        <button class="btn btn-danger" type="button"><i
                                                class="glyphicon glyphicon-remove"></i> Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (count($filesproject) > 0)
                        <table class="table table-bordered table-striped">
                            <thead>
                                {{--  <th>Photo</th> --}}
                                <th>File Name</th>
                                {{--   <th>File project_id</th>
                                    <th>File task_id</th>
                                    <th>File contract_id</th> --}}
                                <th>File Size</th>
                                <th>Date Uploaded</th>
                                <th>File Location</th>

                                <th>ลบ</th>
                            </thead>
                            <tbody>
                                @if (count($filesproject) > 0)
                                    @foreach ($filesproject as $filedel)
                                        <tr>
                                            {{--  <td><img src='storage/{{$file->name}}' name="{{$file->name}}" style="width:90px;height:90px;"></td> --}}
                                            <td>{{ $filedel->name }}</td>
                                            {{--          <td>{{ $file->project_id }}</td>
                                                <td>{{ $file->task_id }}</td>
                                                <td>{{ $file->contract_id }}</td> --}}


                                            <td>
                                                @if ($filedel->size < 1000)
                                                    {{ number_format($file->size, 2) }} bytes
                                                @elseif($filedel->size >= 1000000)
                                                    {{ number_format($filedel->size / 1000000, 2) }} mb
                                                @else
                                                    {{ number_format($filedel->size / 1000, 2) }} kb
                                                @endif
                                            </td>
                                            <td>{{ date('M d, Y h:i A', strtotime($filedel->created_at)) }}</td>


                                            <td><a
                                                    href="{{ asset('storage/uploads/contracts/' . $filedel->project_id . '/0/' . $filedel->name) }}">{{ $filedel->name }}</a>
                                            </td>

                                            <td>
                                                @if(isset($task) && !empty($task->hashid))
                                                <a href="{{ route('project.task.filesdel', ['project' => $project->hashid, 'task' => $task->hashid]) }}" class="btn btn-danger">
                                                    <i class="glyphicon glyphicon-remove"></i> Remove
                                                </a>
                                            @else
                                                <!-- Handle the case where $task is not set as expected -->
                                                <a href="{{ route('project.task.filesdel', ['project' => $project->hashid, 'task' => 0]) }}" class="btn btn-danger">
                                                    <i class="glyphicon glyphicon-remove"></i> Remove
                                                </a>
                                            @endif

                                            </td>


                                            {{--  <td><a href="{{ $file->location }}">{{ $file->location }}</a></td> --}}



                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="12" class="text-center">No Table Data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    @endif
                        <!-- Submit Button -->
                        <div class="mt-3">
                        <button type="submit" class="btn btn-primary ">Upload</button>
{{--                         <x-button link="{{ route('project.task.show', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
                            class="btn-warning text-black">{{ __('show') }}</x-button> --}}



                    </form>
            </div>
            </x-card>
        </div>



    </x-slot:content>
    <x-slot:css>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet"/>

    </x-slot:css>
    <x-slot:javascript>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js"></script>
       {{--  <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script> --}}
        <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
        <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>



















        <script>
            // เมื่อเอกสารโหลดเสร็จสมบูรณ์
            document.addEventListener("DOMContentLoaded", function() {
                // รับอินพุตฟิลด์สำหรับงบกลาง ICT
                var budgetItOperatingInput = document.getElementById("budget_it_operating");
                // รับทุกอินพุตฟิลด์ที่เกี่ยวข้องกับงบประมาณที่เพิ่มขึ้น
                var increasedBudgetInputs = document.querySelectorAll('input[id^="increased_budget_it_operating_"]');
                // ตั้งค่าเริ่มต้นของงบประมาณจากฐานข้อมูล
                var oldtaskValues = {
                    'totalBudgetItOperating': {{ $budget['totalBudgetItOperating'] }},
                };

                // ฟังก์ชันสำหรับคำนวณงบประมาณที่เหลือ
                function calculateRemainingBudget(totalBudget, debt1, debt2, debt3) {
                    // แปลงค่าจากฟอร์มเป็นตัวเลขและลบเครื่องหมายคอมม่า
                    var budgetItOperating = parseFloat(budgetItOperatingInput.value.replace(/,/g, '')) || 0;
                    var totalIncreasedBudget = 0;
                    var debt1Paid = parseFloat(debt1);
            var debt2Paid = parseFloat(debt2);
            var debt3Paid = parseFloat(debt3);



                    // รวมค่าจากทุกอินพุตฟิลด์ของงบประมาณที่เพิ่มขึ้น
                    increasedBudgetInputs.forEach(function(input) {
                        var value = parseFloat(input.value.replace(/,/g, '')) || 0;
                        totalIncreasedBudget += value;
                    });


                    var budgetItOperating_inc = (budgetItOperating + totalIncreasedBudget);
                    // คำนวณงบประมาณที่เหลือโดยการหักด้วยค่าที่เพิ่มขึ้น
                    var remainingBudget = (budgetItOperating + totalIncreasedBudget) - oldtaskValues.totalBudgetItOperating;

                    // แสดงค่างบประมาณที่เหลือในคอนโซล
                    console.log('budgetItOperating', budgetItOperating);
                    console.log('totalIncreasedBudget', totalIncreasedBudget);
                    console.log('budgetItOperating_inc', budgetItOperating_inc);
                    console.log('oldtaskValues.totalBudgetItOperating', oldtaskValues.totalBudgetItOperating);
                    console.log('remainingBudget', remainingBudget);

                    // ตั้งค่าอินพุตฟิลด์เป็น readonly หากงบประมาณที่เหลือน้อยกว่า 0
                    increasedBudgetInputs.forEach(function(input) {
//input.readOnly = (oldtaskValues.totalBudgetItOperating = 0);









});
                }

                // เพิ่มตัวจับเหตุการณ์สำหรับอินพุตฟิลด์
                budgetItOperatingInput.addEventListener('input', calculateRemainingBudget);
                increasedBudgetInputs.forEach(function(input) {
                    input.addEventListener('input', calculateRemainingBudget);
                });

                // โหลดฟังก์ชันคำนวณเมื่อเพจโหลดเสร็จสมบูรณ์
                calculateRemainingBudget();

            });
            </script>




            <script>
                $(document).ready(function() {
                    // Initial check
                    $('#increased_budget_new').toggle($('#increased_budget_status').prop('checked'));

                    // Listen for changes on the checkbox
                    $('#increased_budget_status').change(function() {
                        $('#increased_budget_new').toggle(this.checked);
                    });
                });
            </script>


{{--
        <script>
            $(document).ready(function() {
                // Check initial state of the "มี PA" radio button


                if ($('#increased_budget_status').is(':checked')) {
                    $('#increased_budget_new').show();
                } else {
                    $('#increased_budget_new').hide();
                }

                // Listen for changes on the radio buttons
                $('input[type=radio][name=increased_budget_status]').change(function() {
                    if (this.value == '1') {
                        $('#increased_budget_new').show();
                    } else {
                        $('#increased_budget_new').hide();
                    }
                });
            });
        </script> --}}
{{--
        <script>
            $(document).ready(function() {
                // Initial check
                var  totalbudget_budget = $budget['totalbudget_budget']
                if (totalbudget_budget)
                $('#increased_budget_new').toggle($('#increased_budget_status').prop('checked'));
                // Listen for changes on the checkbox
                $('#increased_budget_status').change(function() {
                    $('#increased_budget_new').toggle(this.checked);
                });
                else
            });
        </script> --}}




 {{--        <script>
            $(document).ready(function() {
                $('form').on('submit', function(e) {
                    // ตรวจสอบว่าไฟล์ถูกเลือกหรือไม่
                    if ($('#file').get(0).files.length === 0) {
                        e.preventDefault(); // หยุดการส่งฟอร์ม
                        alert('กรุณาเลือกไฟล์');
                    }
                });
            });
        </script> --}}

        <script type="text/javascript">
            $(document).ready(function() {

                $(".btn-success").click(function() {
                    var html = $(".clone").html();
                    $(".increment").after(html);
                });

                $("body").on("click", ".btn-danger", function() {
                    $(this).parents(".control-group").remove();
                });

            });
        </script>










        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function() {
                var project_status_during_year = {!! json_encode($project->project_status_during_year == 2) !!}; // รับค่าจาก Laravel ไปยัง JavaScript
                if (project_status_during_year == 2) {
                    var formInputs = document.querySelectorAll(
                        '#increaseData_form input, #mm_form textarea, #mm_form select,#budget_form input'
                        ); // เลือกทั้งหมด input, textarea, และ select ภายใน #mm_form
                    formInputs.forEach(function(input) {
                        input.setAttribute('readonly', true); // ตั้งค่าแอตทริบิวต์ readonly
                    });
                }
            });
        </script>
        <script>
         $(document).ready(function(){
    $(":input").inputmask();
});
    </script>


<script>
    $(function() {
        $("#project_start_date, #project_end_date").datepicker({
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
     //   var fiscalYearEndDate = new Date(project_fiscal_year, 8, 30); // 30th September of the fiscal year

        console.log(project_start_date_str);
        console.log(project_end_date_str);
        console.log(fiscalYearStartDate);
      //  console.log(fiscalYearEndDate);
// Set the start and end dates for the project_start_date datepicker
//$("#project_start_date").datepicker("setStartDate", fiscalYearStartDate);
//วันที่สิ้นสุด * ห้ามเกินวันที่เริ่มต้น
 // $("#project_start_date").datepicker("setEndDate", fiscalYearEndDate);

    // Set the start and end dates for the project_end_date datepicker
    $("#project_end_date").datepicker("setStartDate", fiscalYearStartDate);
   //var task_end_date_str = $("#task_end_date").val();
   // var task_end_date = (task_end_date_str);
   // var project_end_date =(project_end_date_str);
     // console.log(task_end_date_str);
       // console.log(task_end_date);
        //console.log(project_end_date);


  // Add click event listener for the delete button
/*   $('#project_end_date').click(function(e) {
    e.preventDefault();
    var project_end_date_str = $("#project_end_date").val();
    var project_end_date = convertToDate(project_end_date_str);
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
}); */

var project_end_date_str = "{{ Helper::Date4(date('Y-m-d H:i:s', $projectDetails->project_end_date)) }}"; // Wrap in quotes
    $('#project_start_date').on('changeDate', function() {
            var startDate = $(this).datepicker('getDate');
            $("#project_end_date").datepicker("setStartDate", startDate);
        });

     /*    $('#task_end_date').on('changeDate', function() {
            var endDate = $(this).datepicker('getDate');
            $("#task_start_date").datepicker("setEndDate", endDate);
        }); */
    });

    function convertToDate(dateStr) {
        var parts = dateStr.split("/");
        var date = new Date(parts[2], parts[1] - 1, parts[0]);
        return date;
    }
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

 <script>
    $(document).ready(function() {
$("#budget_it_operating,#budget_it_investment,#budget_gov_utility,#increased_budget_it_operating,#increased_budget_it_investment,#increased_budget_gov_utility,#increased_budget_it_operating_new,#increased_budget_it_investment_new,#increased_budget_gov_utility_new").on("input", function() {
 var max = 0;
 var fieldId = $(this).attr('id');
    var key = $(this).data('key');



 var budgetItOperating = $("#budget_it_operating").val();
 var budgetItInvestment = $("#budget_it_investment").val();
 var budgetGovUtility = $("#budget_gov_utility").val();
    var increasedBudgetItOperating = $("#increased_budget_it_operating").val();
    var increasedBudgetItInvestment = $("#increased_budget_it_investment").val();
    var increasedBudgetGovUtility = $("#increased_budget_gov_utility").val();

    var increasedBudgetItOperating_new = $("#increased_budget_it_operating_new").val();
    var increasedBudgetItInvestment_new = $("#increased_budget_it_investment_new").val();
    var increasedBudgetGovUtility_new = $("#increased_budget_gov_utility_new").val();

    var olebudgetItOperating = {{ $project->budget_it_operating }} || 0;
var olebudgetItInvestment = {{ $project->budget_it_investment }} || 0;
var olebudgetGovUtility = {{ $project->budget_gov_utility }} || 0;


    if (fieldId === "budget_it_investment") {

     if (budgetItInvestment === "0" || budgetItInvestment === '' || parseFloat(budgetItInvestment) < -0) {
         $("#budget_it_investment").val('');
     }

 }

  if (fieldId === "budget_it_operating") {


         if (budgetItOperating === "0" || budgetItOperating === '' || parseFloat(budgetItOperating) < -0 ) {
             $("#budget_it_operating").val('');
         }
     }


     if (fieldId === "budget_gov_utility") {

        if (parseFloat(budgetGovUtility) < olebudgetGovUtility ) {
                $(this).addClass('is-invalid');

            } else {
                $(this).removeClass('is-invalid');

            }
     if (budgetGovUtility === "0" || budgetGovUtility === '' || parseFloat(budgetGovUtility) < -0) {
         $("#budget_gov_utility").val('');
     }

 }

    if (fieldId === "increased_budget_it_investment") {

     if (increasedBudgetItInvestment === "0" || increasedBudgetItInvestment === '' || parseFloat(increasedBudgetItInvestment) < -0) {
         $("#increased_budget_it_investment").val('');
     }
    }
    if (fieldId === "increased_budget_it_operating") {

     if (increasedBudgetItOperating === "0" || increasedBudgetItOperating === '' || parseFloat(increasedBudgetItOperating) < -0) {
         $("#increased_budget_it_operating").val('');
     }


    }

    if (fieldId === "increased_budget_gov_utility") {

     if (increasedBudgetGovUtility === "0" || increasedBudgetGovUtility === '' || parseFloat(increasedBudgetGovUtility) < -0) {
         $("#increased_budget_gov_utility").val('');
     }
    }


    if (fieldId === "increased_budget_it_investment_new") {

     if (increasedBudgetItInvestment_new === "0" || increasedBudgetItInvestment_new === '' || parseFloat(increasedBudgetItInvestment_new) < -0) {
         $("#increased_budget_it_investment_new").val('');
     }
    }

    if (fieldId === "increased_budget_it_operating_new") {

     if (increasedBudgetItOperating_new === "0" || increasedBudgetItOperating_new === '' || parseFloat(increasedBudgetItOperating_new) < -0) {
         $("#increased_budget_it_operating_new").val('');
     }
    }

    if (fieldId === "increased_budget_gov_utility_new") {

     if (increasedBudgetGovUtility_new === "0" || increasedBudgetGovUtility_new === '' || parseFloat(increasedBudgetGovUtility_new) < -0) {
         $("#increased_budget_gov_utility_new").val('');
     }
    }

 var current = parseFloat($(this).val().replace(/,/g , ""));


});
});
 </script>



<script>
    $(document).ready(function() {
        $(document).ready(function() {
    // Define a function to validate the input
    function validateInput(value, oldValue, selector) {
        if (value === "0" || value === '' || parseFloat(value) < 0) {
            $(selector).val('');
        }
        if (parseFloat(value) < oldValue) {
            $(selector).addClass('is-invalid');
        } else {
            $(selector).removeClass('is-invalid');
        }
    }

    // Event listener for input fields
    $("[id^=increased_budget_]").on("input", function() {
        var fieldId = $(this).attr('id');
        var key = fieldId.split('_').pop(); // Assuming the last part of ID is the key
        var value = $(this).val().replace(/,/g , "");
        var oldValue = 0; // Set the old value based on the fieldId

        // Add your logic to determine oldValue here based on fieldId

        validateInput(value, oldValue, '#' + fieldId);
    });

    // Similar event listeners for other fields...
});


    });

        </script>

<script>
    $(document).ready(function() {
        var formIsValid = true;
        var invalidFieldId = '';
            // Define oldValues with ternary operators
            var oldValues = {
            'budget_it_operating': {{$budget['totalBudgetItOperating']}} ? parseFloat({{$project->budget_it_operating}}) : 0,
            'budget_it_investment': {{$budget['totalBudgetItInvestment']}} ? parseFloat({{$project->budget_it_investment}}) : 0,
            'budget_gov_utility': {{$budget['totalBudgetGovUtility']}} ? parseFloat({{$project->budget_gov_utility}}) : 0
        };

        var oldtaskValues = {
            'totalBudgetItOperating':  {{$budget['totalBudgetItOperating']}} ,
            'totalBudgetItInvestment': {{$budget['totalBudgetItInvestment']}} ,
            'totalBudgetGovUtility': {{$budget['totalBudgetGovUtility']}}

        };







        console.log('oldValues:',oldValues);
        console.log('oldtaskValues:',oldtaskValues);

         // Check if any of the values in oldtaskValues is greater than 0
    var anyValueGreaterThanZero = Object.values(oldtaskValues).some(value => value > 0);
    console.log('anyValueGreaterThanZero:',anyValueGreaterThanZero);
if (anyValueGreaterThanZero === false) {
    $('#increased_budget_status').hide();

}


        //console.log('oldtaskValuesmm:',oldtaskValuesmm);


        function numberFormat(number) {
        return number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }

function validateBudget(fieldId) {
        var enteredValue = parseFloat($('#' + fieldId).val().replace(/,/g, '')) || 0;
        var oldValue = oldValues[fieldId];
        if (enteredValue < oldValue) {
            console.log(fieldId + ":", enteredValue, "oldValue:", oldValue);
            $('#' + fieldId).addClass('is-invalid');
            $('#' + fieldId + '_feedback').text('งบประมาณถูกใช้ไป แล้วจะไม่สามารถน้อยกว่านี้ได้');


            return false;
        } else {
            $('#' + fieldId).removeClass('is-invalid');
            $('#' + fieldId + '_feedback').text('');
            return true;
        }
    }

    // Validate individual fields on input
    $('#formId input[type="text"]').on("input", function() {
        validateBudget($(this).attr('id'));
    });
        // Check the budget amount entered when data is input
        $("#budget_it_operating, #budget_it_investment, #budget_gov_utility").on("input", function() {
            formIsValid = false; // Reset the form validity state on new input
            invalidFieldId = ''; // Reset the invalid field tracking

            validateBudget('budget_it_operating', parseFloat($("#budget_it_operating").val().replace(/,/g, "")) || 0);
            validateBudget('budget_it_investment', parseFloat($("#budget_it_investment").val().replace(/,/g, "")) || 0);
            validateBudget('budget_gov_utility', parseFloat($("#budget_gov_utility").val().replace(/,/g, "")) || 0);
        });

        // Prevent form submission if validation fails
    // Prevent form submission if validation fails
  // Validate all fields on form submission
  $('#formId').on('submit', function(e) {
        var formIsValid = true;
        var invalidFieldId = '';

      // Validate each input field and determine if the form is valid
      $('#formId input[type="text"]').each(function() {
        var fieldId = $(this).attr('id');
        if (!validateBudget(fieldId)) {
            formIsValid = false;
            invalidFieldId = fieldId; // Track the first invalid field ID
            return false; // Exit the .each() loop on first invalid field
        }
    });

    // If the form is not valid, prevent submission and show an alert
    if (!formIsValid && invalidFieldId) {
        e.preventDefault(); // Prevent form submission

        var formattedOldValue = numberFormat(oldValues[invalidFieldId]);
        var alertText = 'งบประมาณถูกใช้ไป ' + formattedOldValue + ' แล้วจะไม่สามารถน้อยกว่านี้ได้';

        Swal.fire({
            title: 'เตือน!',
            text: alertText,
            icon: 'warning',
            confirmButtonText: 'Ok'
        });
    }
    });
    });
    </script>



<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        var oldtaska = {
            'totalBudgetItOperating':  {{$budget['totalBudgetItOperating']}} || 0,
            'totalBudgetItInvestment': {{$budget['totalBudgetItInvestment']}} || 0,
            'totalBudgetGovUtility': {{$budget['totalBudgetGovUtility']}} || 0
        };

        var project_status_during_year = {!! json_encode($project->project_status_during_year == 2) !!}; // รับค่าจาก Laravel ไปยัง JavaScript

        // Assuming you want to set form inputs to readonly if any budget value is greater than 1
        if (oldtaska.totalBudgetItOperating > 1 || oldtaska.totalBudgetItInvestment > 1 || oldtaska.totalBudgetGovUtility > 1) {
            var formInputs = document.querySelectorAll('#budget_form input,#project_name_form input');
            formInputs.forEach(function(input) {
                input.setAttribute('readonly', true); // ตั้งค่าแอตทริบิวต์ readonly
            });
        }
    });
</script>


<script>
 $(document).ready(function() {
let debt = 1000000; // งบทั้งหมด
let debt_inc = 7000000 // งบทั้งหมดเพิ่ม
let installments = 4; // จำนวนงวดที่ต้องชำระ
let availableAmount = 6200000; // จำนวนเงินที่มีอยู่


let totaldebt = debt + debt_inc; // คำนวณจำนวนเงินที่ต้องชำระทั้งหมด
// คำนวณจำนวนเงินที่ต้องชำระต่องวด
let paymentPerInstallment = Math.floor(totaldebt / installments);

// คำนวณจำนวนงวดที่คุณสามารถชำระได้ด้วยจำนวนเงินที่มีอยู่
let installmentsPaid = Math.floor(availableAmount / paymentPerInstallment);

//ปัดเศษขึ้น
installmentsPaidup = Math.ceil(availableAmount / paymentPerInstallment);

// คำนวณจำนวนเงินที่เหลืออยู่หลังจากชำระเงินแล้ว
let remainingAmount = totaldebt-availableAmount;

console.log(`Total Debt: ${debt}`);
console.log(`Total Debt Increased: ${debt_inc}`);
console.log(`Total Debt: ${totaldebt}`);
console.log(`Number of Installments: ${installments}`);
console.log(`Payment per Installment: ${paymentPerInstallment}`);
console.log(`Available Amount: ${availableAmount}`);
console.log(`Installments Paid: ${installmentsPaid}`);
console.log(`ปัดเศษขึ้น: ${installmentsPaidup}`);
console.log(`Remaining Amount: ${remainingAmount}`);
 });



    </script>

{{-- <script>
    $(document).ready(function() {
$("#task_budget_it_investment, #task_budget_gov_utility, #task_budget_it_operating").on("input", function() {
 var max = 0;
 var fieldId = $(this).attr('id');
var budgetItOperating = $("#task_budget_it_operating").val();
 var budgetItInvestment = $("#task_budget_it_investment").val();
 var budgetGovUtility = $("#task_budget_gov_utility").val();

 if (fieldId === "task_budget_it_investment") {
     max = parseFloat({{ $request->budget_it_investment - $sum_task_budget_it_investment+ $sum_task_refund_budget_it_investment }});

     if (budgetItInvestment === "0" || budgetItInvestment === '' || parseFloat(budgetItInvestment) < -0) {
         $("#task_budget_it_investment").val('');
     }

 }


 else if (fieldId === "task_budget_gov_utility") {
     max = parseFloat({{ $request->budget_gov_utility - $sum_task_budget_gov_utility+ $sum_task_refund_budget_gov_utility }});
     if (budgetGovUtility === "0" || budgetGovUtility === '' || parseFloat(budgetGovUtility) < -0) {
         $("#task_budget_gov_utility").val('');
     }

 }

 else if (fieldId === "task_budget_it_operating") {
     max = parseFloat({{ $request->budget_it_operating - $sum_task_budget_it_operating + $sum_task_refund_budget_it_operating }});
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
 </script> --}}



    </x-slot:javascript>
</x-app-layout>
