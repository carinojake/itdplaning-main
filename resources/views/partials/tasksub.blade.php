@if ($task->subtask->count() == 0)
@if ($task->task_parent_sub === 2)
<x-slot:toolbar>

<form class="taskRefund-form" action="{{ route('project.task.taskRefundbudget', ['project' => $project->hashid, 'task' => $task->hashid]) }}" method="POST" style="display:inline">
    @method('POST') {{-- Use POST method to submit the form --}}
    @csrf
    <button class="btn btn-Light text-dark btn-taskRefund"><i class="cil-money"></i></button>
</form>

    <a href="{{ route('project.task.editsub', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
        class="btn btn-warning text-dark"> <i class="cil-cog"></i>{{-- แก้ไขedit {{ Helper::projectsType($project->project_type) }} --}}
    </a>

    <a href="{{ route('project.task.createto', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
        class="btn btn-info text-white">เพิ่มรายการ กิจกรรม </a>


    @if ($task->task_budget_it_operating > 0)
        <a href="{{ route('project.task.createsub', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
            class="btn btn-success text-white">เพิ่ม สัญญา</a>

        <a href="{{ route('project.task.createsubnop', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
            class="btn btn-dark text-white">เพิ่มรายการที่ใช้จ่าย </a>
    @elseif ($task->task_budget_it_investment > 0)
        <a href="{{ route('project.task.createsub', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
            class="btn btn-success text-white">เพิ่ม สัญญา</a>

        <a href="{{ route('project.task.createsubnop', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
            class="btn btn-dark text-white">เพิ่มรายการที่ใช้จ่าย </a>
    @elseif ($task->task_budget_gov_utility > 0)
        <a href="{{ route('project.task.createsub', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
            class="btn btn-success text-white">เพิ่ม สัญญา</a>

        <a href="{{ route('project.task.createsubnop', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
            class="btn btn-dark text-white">เพิ่มรายการที่ใช้จ่าย</a>
    @endif
    <a href="{{ route('project.view', ['project' => $project->hashid]) }}"
        class="btn btn-secondary">กลับ</a>

</x-slot:toolbar>


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
                        <div class="col-6">{{ number_format($task->task_budget_it_operating ) }}</div>
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
@endif
