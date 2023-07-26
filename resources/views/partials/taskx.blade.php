@if ($task->task_mm != null)
    <h2>{{ $task->task_name }}</h2>
    <div class="container">
        <div class="row mt-5">
            <div class="col-sm">
                <div class="row">
                    <div class="col-6 fw-semibold">{{ __('ปีงบประมาณ') }}</div>
                    {{ $project->project_fiscal_year }}
                </div>
            </div>
            <div class="col-sm">
                <div class="row">
                    @if ($task->task_budget_it_operating > 0)
                        <div class="col-6 fw-semibold">{{ __('งบกลาง ICT') }}</div>
                        {{ number_format($task->task_budget_it_operating) }}
                    @endif
                </div>
                <div class="row">
                    @if ($task->task_budget_it_investment > 0)
                        <div class="col-6 fw-semibold">{{ __('งบดำเนินงาน') }}</div>
                        {{ number_format($task->task_budget_it_investment) }}
                    @endif
                </div>
                <div class="row">
                    @if ($task->task_budget_gov_utility > 0)
                        <div class="col-6 fw-semibold">{{ __('ค่าสาธารณูปโภค') }}</div>
                        {{ number_format($task->task_budget_gov_utility) }}
                    @endif
                </div>
            </div>
            <div class="col-sm">
                <div class="row">
                    @if ($task->task_budget_it_operating > 0)
                        <div class="col-6 fw-semibold">{{ __('คงเหลือ งบกลาง ICT') }}</div>
                        <div class="col-6">{{ number_format($task->task_budget_it_operating - $sum_task_budget_it_operating_ts + $sum_task_refund_budget_it_operating) }}</div>
                    @endif
                </div>
                <div class="row">
                    @if ($task->task_budget_it_investment > 0)
                        <div class="col-6 fw-semibold">{{ __('คงเหลือ งบดำเนินงาน') }}</div>
                        <div class="col-6">{{ number_format($task->task_budget_it_investment) }}</div>
                    @endif
                </div>
                <div class="row">
                    @if ($task->task_budget_gov_utility > 0)
                        <div class="col-6 fw-semibold">{{ __('คงเหลือ งบสาธารณูปโภค') }}</div>
                        <div class="col-6">{{ number_format($task->task_budget_gov_utility) }}</div>
                    @endif
                </div>
            </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <h5>{{ __('รายละเอียดงาน/โครงการ') }}</h5>
                    </div>
                    {{ $task->task_description }}
                </div>

        </div>
    </div>
@endif
