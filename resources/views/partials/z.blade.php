                        <div class="container">
                            @foreach ($taskcons as $taskcon)
                                {{-- <div>{{ $taskcon->task_id }}</div>
                                <div>{{ $taskcon->taskcon_id }}</div> --}}
                                <div class="row">
                                    <div class="col-sm">

                                        <div id="bodgetcost" class="callout callout-primary"{{--  style="display:none;" --}}>
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-3">{{ __('เลขที่ MM/เลขที่ สท. *') }}</div>
                                                <div class="col-9">{{ $taskcon->taskcon_mm }} </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">{{ __('ชื่อ') }}</div>
                                                <div class="col-9">{{ $taskcon->task_name }} </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">{{ __('เรื่อง') }}</div>
                                                <div class="col-9">{{ $taskcon->task_description }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">{{ __('parent') }}</div>
                                                <div class="col-9">{{ $taskcon->task_parent }}</div>
                                            </div>
                                        </div>
                                        </div>

                                        <div id="bodgetcost" class="callout callout-warning"{{--  style="display:none;" --}}>
                                        @if ($taskcon->task_budget_it_operating > 0)
                                        <div id="ICT" {{-- style="display:none;" --}}>
                                                <div class="row mt-3">
                                                    <div class="col-md-4">
                                                        <label for="task_budget_it_operating"
                                                            class="form-label">{{ __('วงเงินที่ขออนุมัติ งบกลาง ICT') }}</label>
                                                        <div>{{ $taskcon->task_budget_it_operating }}</div>

                                                        <div class="invalid-feedback">
                                                            {{ __('ระบุงบกลาง ICT') }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="task_cost_it_operating"
                                                            class="form-label">{{ __('รอการเบิก งบกลาง ICT') }}</label>
                                                        <div>{{ $taskcon->task_cost_it_operating }}</div>


                                                        <div class="invalid-feedback">
                                                            {{ __('งบกลาง ICT') }}
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        @elseif ($taskcon->task_budget_it_investment > 0)
                            <div id="inv" {{-- style="display:none;" --}}>

                                    <div class="row mt-3">

                                        <div class="col-md-4">
                                            <label for="task_budget_it_investment"
                                                class="form-label">{{ __('วงเงินที่ขออนุมัติ งบดำเนินงาน') }}</label>
                                            <div>{{ $taskcon->task_budget_it_investment }}</div>


                                            <div class="invalid-feedback">
                                                {{ __('งบดำเนินงาน') }}
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="task_cost_it_investment"
                                                class="form-label">{{ __('รอการเบิก งบดำเนินงาน') }}</label>
                                            <div>{{ $taskcon->task_cost_it_investment }}</div>

                                            <div class="invalid-feedback">
                                                {{ __('งบดำเนินงาน') }}
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            @elseif ($taskcon->task_budget_gov_utility > 0)
                            <div id="utility" {{-- style="display:none;" --}}>

                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label for="task_budget_gov_utility"
                                                class="form-label">{{ __('วงเงินที่ขออนุมัติ งบสาธารณูปโภค') }}</label>
                                            <div>{{ $taskcon->task_budget_gov_utility }}</div>
                                            <div class="invalid-feedback">
                                                {{ __('ค่าสาธารณูปโภค') }}
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="task_cost_gov_utility"
                                                class="form-label">{{ __('รอการเบิก งบสาธารณูปโภค') }}</label>
                                            <div>{{ $taskcon->task_cost_gov_utility }}</div>

                                            <div class="invalid-feedback">
                                                {{ __('ค่าสาธารณูปโภค') }}
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            @endif
                                    </div>



                            <div id="pp_form" class="callout callout-danger"{{--  style="display:none;" --}}>

                                <div class="row">
                                    <div class="col-3">{{ __('งบใบสำคัญ_PP') }}</div>
                                    <div class="col-9">{{ $taskcon->taskcon_pp }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-3">{{ __('รายการใช้จ่าย ') }}</div>
                                    <div class="col-9">{{ $taskcon->taskcon_pp_nane }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-3">{{ __('เวลา PP') }}</div>
                                    <div class="col-9">{{ $taskcon->taskcon_pp_date }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-3">{{ __('จำนวนเงิน (บาท) PP') }}</div>
                                    <div class="col-9">{{ $taskcon->taskcon_pay }}</div>
                                </div>

                            </div>
                        </div>
                        </div>
                        </div>
                        @endforeach
