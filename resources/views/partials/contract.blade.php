
<ul>


    <div class="card mb-3">
        <table class="table">
            <thead>
                <tr>
                    <th width="50">ลำดับ</th>
                    <th >รายการ</th>
                    <th>ชื่อ</th>
                    <th>ประเภท</th>
                    <th width="200"> คำสั่ง</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($contract_tasks) && is_array($contract_tasks))
                @foreach ($contract_tasks as $index => $task)
                <tr>
                    <td>{{ $index + 1 }}</td>
                        <td>สัญญา {{ $task->contract_number }}</td>
                        <!-- Include other data columns here, like date, budget type, etc. -->
                        <td> {{ $task->contract_name }}</td>
                        <td> {{Helper::contractType($task->contract_type) }}</td>

                        <td>
                        <div>
                        <a href="{{ route('project.task.show', ['project' => $project->hashid, 'task' => $task->hashid]) }}" class="btn btn-primary text-white" target="_blank"><i class="cil-folder-open"></i></a>
                            <a href="{{ route('project.edit', ['project' => $project->hashid, ]) }}" class="btn btn-warning btn-sm" target="_blank"><i class="cil-cog"></i></a>
                           {{--  <form action="{{ route('project.task.destroy', ['project' => $project->hashid, ]) }}" method="POST" style="display:inline">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger btn-sm"><i class="cil-trash"></i></button>
                            </form> --}}
                        </div>
                    </td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>

</ul>





