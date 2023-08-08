

@if ($task['task_parent_sub'] == 2)
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
tasksubsubsub

@endif
