@if ($task['task_parent'] == null)
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
                    <div class="col-6">{{ number_format($task->task_budget_it_operating - $sum_task_budget_it_operating_ts + $sum_task_refund_budget_it_operating            ) }}</div>
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
        @if ($task->subtask->count() > 1)
        <div class="row mt-3">
            <div class="col-12">
                <h5>{{ __('รายละเอียดงาน/โครงการ') }}</h5>
            </div>
            {{ $task->task_description }}
        </div>
    </div>

    <table class="table mt-3">
        <table class="table mt-3">
            <tbody>
                <tr>
                    <th width="50">ลำดับ</th>
                    <th>กิจกรรม</th>
                    <th>วันที่</th>
                    <th>ที่สัญญา</th>
                    <th>ที่ค่าใช้จ่าย</th>
                    <th width="200"> ดู</th>
                </tr>
                @if ($task->subtask->count() > 0)
                    @foreach ($task->subtask as $index => $subtask)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $subtask->task_name }}{!! $task->task_status == 2 ? '<span class="badge bg-info">ดำเนินการแล้วเสร็จ</span>' : '' !!}</td>
                            <td>
                                <span
                                    class="badge bg-primary">{{ \Helper::date4(date('Y-m-d H:i:s', $subtask->task_start_date)) }}</span>
                                <span
                                    class="badge bg-primary">{{ \Helper::date4(date('Y-m-d H:i:s', $subtask->task_end_date)) }}</span>
                            </td>


                            <td>

                                @if ($subtask->contract->count() > 0)
                                    @foreach ($subtask->contract as $contract)
                                        <button type="button" class="badge btn btn-success text-white"
                                            data-bs-toggle="modal"
                                            data-bs-target="#exampleModal{{ $contract->hashid }}">

                                            @if ($contract->contract_type == 4)
                                                {{ \Helper::contractType($contract->contract_type) }}"_"{{ strtolower($contract->contract_number) }}
                                            @else
                                                สญ.ที่ {{ strtolower($contract->contract_number) }}
                                            @endif
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade"
                                            id="exampleModal{{ $contract->hashid }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            สัญญา {{ $contract->contract_number }}</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                ที่ค่าใช้จ่าย
                            </td>
                            <td>
                                <a href="{{ route('project.task.show', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}"
                                    class="btn btn-primary btn-sm" ><i
                                        class="cil-folder-open">ข้อมูล</i></a>
                                <a href="{{ route('project.task.editsub', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}"
                                    class="btn btn-warning btn-sm" >
                                    <i class="cil-cog"></i></a>
                                <form
                                class="delete-form"   action="{{ route('project.task.destroy', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}"
                                    method="POST" style="display:inline">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-danger  text-white btn-delete"><i
                                            class="cil-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
@endif
@endif
