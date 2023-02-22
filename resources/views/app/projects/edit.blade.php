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
            <x-card title="{{ __('แก้ไขข้อมูลงาน/โครงการ') }} {{ $project->project_name }}">
              <form method="POST" action="{{ route('project.update', $project->hashid) }}" class="row g-3">
                @csrf
                {{ method_field('PUT') }}
                <div class="col-md-12">
                  <label for="project_type" class="form-label">{{ __('ประเภทงาน/โครงการ') }}</label> <span class="text-danger">*</span>
                  <div class="form-check form-check-inline ms-5">
                    <input class="form-check-input" type="radio" name="project_type" id="project_type1" value="J" checked>
                    <label class="form-check-label" for="project_type1">
                      งานประจำ
                    </label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="project_type" id="project_type2" value="P">
                    <label class="form-check-label" for="project_type2">
                      โครงการ
                    </label>
                  </div>
                  <div class="invalid-feedback">
                    {{ __('สถานะงาน/โครงการ') }}
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="project_status" class="form-label">{{ __('สถานะงาน/โครงการ') }}</label> <span class="text-danger">*</span>
                  <div class="form-check form-check-inline ms-5">
                    <input class="form-check-input" type="radio" name="project_status" id="project_status1" value="1" checked>
                    <label class="form-check-label" for="project_status1">
                      อยู่ในระหว่างดำเนินการ
                    </label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="project_status" id="project_status2" value="2">
                    <label class="form-check-label" for="project_status2">
                      ดำเนินการแล้วเสร็จ
                    </label>
                  </div>
                  <div class="invalid-feedback">
                    {{ __('สถานะงาน/โครงการ') }}
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="project_name" class="form-label">{{ __('ชื่องาน/โครงการ') }}</label> <span class="text-danger">*</span>
                  <input type="text" class="form-control" id="project_name" name="project_name" value="{{ $project->project_name }}" required autofocus>
                  <div class="invalid-feedback">
                    {{ __('ชื่องาน/โครงการ ซ้ำ') }}
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="project_description" class="form-label">{{ __('รายละเอียดงาน/โครงการ') }}</label>
                  <textarea class="form-control" name="project_description" id="project_description" rows="10">
                    {{ $project->project_description }}
                  </textarea>
                  <div class="invalid-feedback">
                    {{ __('รายละเอียดงาน/โครงการ') }}
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="project_fiscal_year" class="form-label">{{ __('ปีงบประมาณ') }}</label> <span class="text-danger">*</span>
                  <input type="text" class="form-control" id="project_fiscal_year" name="project_fiscal_year" value="{{ $project->project_fiscal_year }}" required>
                  <div class="invalid-feedback">
                    {{ __('ชื่องาน/โครงการ ซ้ำ') }}
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="project_start_date" class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span class="text-danger">*</span>
                  {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                  <div data-coreui-toggle="date-picker" id="project_start_date" data-coreui-format="dd/MM/yyyy" data-coreui-date="{{ date('m/d/Y', $project->project_start_date) }}"></div>
                </div>
                <div class="col-md-6">
                  <label for="project_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span class="text-danger">*</span>
                  {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                  <div data-coreui-toggle="date-picker" id="project_end_date" data-coreui-format="dd/MM/yyyy" data-coreui-date="{{ date('m/d/Y', $project->project_end_date) }}"></div>
                </div>

                <div class="row">
                  <h4>งบประมาณ</h4>

                  <div class="row">
                    <div class="col-6">
                      <strong>เงินงบประมาณ (งบประมาณขอรัฐบาล)</strong>
                      <div class="col-md-12">
                        <label for="budget_gov_operating" class="form-label">{{ __('งบดำเนินงาน (ค่าใช้สอยต่างๆ)') }}</label>
                        <input type="number" placeholder="0.00" step="0.01" class="form-control" id="budget_gov_operating" name="budget_gov_operating" min="0" value="{{ $project->budget_gov_operating }}">
                        <div class="invalid-feedback">
                          {{ __('ระบุงบดำเนินงาน (ค่าใช้สอยต่างๆ)') }}
                        </div>
                      </div>
                      <div class="col-md-12">
                        <label for="budget_gov_investment" class="form-label">{{ __('งบลงทุน IT (ครุภัณฑ์ต่างๆ)') }}</label>
                        <input type="number" placeholder="0.00" step="0.01" class="form-control" id="budget_gov_investment" name="budget_gov_investment" min="0" value="{{ $project->budget_gov_investment }}">
                        <div class="invalid-feedback">
                          {{ __('ระบุงบลงทุน IT (ครุภัณฑ์ต่างๆ)') }}
                        </div>
                      </div>
                      <div class="col-md-12">
                        <label for="budget_gov_utility" class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                        <input type="number" placeholder="0.00" step="0.01" class="form-control" id="budget_gov_utility" name="budget_gov_utility" min="0" value="{{ $project->budget_gov_utility }}">
                        <div class="invalid-feedback">
                          {{ __('ระบุค่าสาธารณูปโภค') }}
                        </div>
                      </div>
                    </div>

                    <div class="col-6">
                      <strong>เงินงบกลาง IT</strong>
                      <div class="col-md-12">
                        <label for="budget_it_operating" class="form-label">{{ __('งบดำเนินงาน (ค่าใช้สอยต่างๆ)') }}</label>
                        <input type="number" placeholder="0.00" step="0.01" class="form-control" id="budget_it_operating" name="budget_it_operating" min="0" value="{{ $project->budget_it_operating }}">
                        <div class="invalid-feedback">
                          {{ __('ระบุงบดำเนินงาน (ค่าใช้สอยต่างๆ)') }}
                        </div>
                      </div>
                      <div class="col-md-12">
                        <label for="budget_it_investment" class="form-label">{{ __('งบลงทุน IT (ครุภัณฑ์ต่างๆ)') }}</label>
                        <input type="number" placeholder="0.00" step="0.01" class="form-control" id="budget_it_investment" name="budget_it_investment" min="0" value="{{ $project->budget_it_investment }}">
                        <div class="invalid-feedback">
                          {{ __('ระบุงบลงทุน IT (ครุภัณฑ์ต่างๆ)') }}
                        </div>
                      </div>

                    </div>
                  </div>
                </div>


                <x-button class="btn-success" type="submit">{{ __('coreuiforms.save') }}</x-button>
                <x-button link="{{ route('project.index') }}" class="btn-light text-black">{{ __('coreuiforms.return') }}</x-button>
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
