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
                        <x-card title="{{ __('เพิ่มข้อมูลงาน/โครงการ') }}">

                            <form method="POST" action="{{ route('project.store') }}" class="row g-3">
                                @csrf

                                <div class="col-md-3">
                                    <label for="project_fiscal_year" class="form-label">{{ __('ปีงบประมาณ') }}</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" id="project_fiscal_year"
                                        name="project_fiscal_year" required>
                                    <div class="invalid-feedback">
                                        {{ __('ปีงบประมาณ') }}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label for="reguiar_id" class="form-label">{{ __('งาน/โครงการ ที่') }}</label> <span
                                        class="text-danger"></span>
                                    <input type="text" class="form-control" id="reguiar_id" name="reguiar_id">
                                    <div class="invalid-feedback">
                                        {{ __('no.ชื่องาน/โครงการ ') }}
                                    </div>
                                </div>
                                <div class="invalid-feedback">
                                    {{ __('ชื่องาน/โครงการ ซ้ำ') }}
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-6">
                                        <div>
                                            <label for="project_type"
                                                class="form-label">{{ __('ประเภทงาน/โครงการ') }}</label>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="project_type"
                                                id="project_type1" value="1" >
                                            <label class="form-check-label" for="project_type1">
                                                งานประจำ
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="project_type"
                                                id="project_type2" value="2">
                                            <label class="form-check-label" for="project_type2">
                                                โครงการ
                                            </label>
                                        </div>
                                        <div class="invalid-feedback">
                                            {{ __('ประเภทงาน/โครงการ') }}
                                        </div>
                                    </div>
                                </div>
                    </div>



                    <div class="col-md-12">
                        <label for="project_name" class="form-label">{{ __('ชื่องาน/โครงการ') }}</label> <span
                            class="text-danger">*</span>
                        <input type="text" class="form-control" id="project_name" name="project_name" required
                            autofocus>
                        <div class="invalid-feedback">
                            {{ __('ชื่องาน/โครงการ ซ้ำ') }}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="project_description" class="form-label">{{ __('รายละเอียดงาน/โครงการ') }}</label>
                        <textarea class="form-control" name="project_description" id="project_description" rows="10"></textarea>
                        <div class="invalid-feedback">
                            {{ __('รายละเอียดงาน/โครงการ') }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="project_start_date" class="form-label">{{ __('วันที่เริ่มต้น') }}</label> <span
                                class="text-danger">*</span>
                            {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                            <div data-coreui-toggle="date-picker" id="project_start_date"
                                data-coreui-format="dd/MM/yyyy" data-coreui-locale="th-TH"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="project_end_date" class="form-label">{{ __('วันที่สิ้นสุด') }}</label> <span
                                class="text-danger">*</span>
                            {{-- <input type="text" class="form-control" id="register_date" name="register_date" required> --}}
                            <div data-coreui-toggle="date-picker" id="project_end_date" data-coreui-format="dd/MM/yyyy"
                                data-coreui-locale="th-TH"></div>
                        </div>
                    </div>

                    <div class="row">
                        <h4>งบประมาณ</h4>
                        <div class="col-md-4">
                            <label for="budget_it_operating" class="form-label">{{ __('งบกลาง ICT ') }}</label>
                            <input type="number" placeholder="0.00" step="0.01" class="form-control"
                                id="budget_it_operating" name="budget_it_operating" min="0">
                            <div class="invalid-feedback">
                                {{ __('ระบุงบกลาง ICT') }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="budget_it_investment" class="form-label">{{ __('งบดำเนินงาน') }}</label>
                            <input type="number" placeholder="0.00" step="0.01" class="form-control"
                                id="budget_it_investment" name="budget_it_investment" min="0">
                            <div class="invalid-feedback">
                                {{ __('ระบุงบดำเนินงาน') }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="budget_gov_utility" class="form-label">{{ __('ค่าสาธารณูปโภค') }}</label>
                            <input type="number" placeholder="0.00" step="0.01" class="form-control"
                                id="budget_gov_utility" name="budget_gov_utility" min="0">
                            <div class="invalid-feedback">
                                {{ __('ระบุค่าสาธารณูปโภค') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



                    <x-button class="btn-success" type="submit">{{ __('coreuiforms.save') }}</x-button>
                    <x-button link="{{ route('project.index') }}" class="text-black btn-light">
                        {{ __('coreuiforms.return') }}</x-button>
                    </form>

                    </x-card>


    </x-slot:content>
    <x-slot:css>
    </x-slot:css>
    <x-slot:javascript>

    </x-slot:javascript>
</x-app-layout>
