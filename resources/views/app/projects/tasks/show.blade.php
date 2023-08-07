<x-app-layout>
    <x-slot:content>
        {{ Breadcrumbs::render('project.task.show', $project, $task) }}
        <x-card>

            @if ($task['task_parent'] == null)
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
            @endif

            @if ($contract)
                <x-slot:toolbar>
                    <a href="{{ route('project.task.editsub', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
                        class="btn btn-warning text-dark">แก้ไขeditsub
                        {{ Helper::projectsType($project->project_type) }} </a>


                    <!-- <a href="{{ route('project.task.createsub', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
                        class="btn btn-success text-white">เพิ่มรายการที่ใช้จ่าย</a>-->
                    <a href="{{ route('project.show', ['project' => $project->hashid]) }}"
                        class="btn btn-secondary">กลับ</a>
                </x-slot:toolbar>
            @endif

              {{--   @include('partials.taskx') กิจกรรม --}}
              @include('partials.taskx')
            @include('partials.xx')  {{-- กิจกรรม --}}


       @include('partials.y')  {{-- สญ. --}}

      {{--  @include('partials.yy')  {{-- สญ. --}}



            @include('partials.z')

            {{--
            @foreach ($taskcons as $taskcon)

                         <div>{{ $taskcon->task_id}}</div>
                        <div>{{ $taskcon->taskcon_id}}</div
            @endforeach --}}







        </x-card>
    </x-slot:content>
    <x-slot:css>


    </x-slot:css>
    <x-slot:javascript>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <script>
            $(document).ready(function() {
                // Add click event listener for the delete button กิจกรรม
                $('.btn-taskRefund-sub').click(function(e) {
                    e.preventDefault();

                    var form = $(this).closest('form');

                    Swal.fire({
                        title: 'คืนเงิน กิจกรรม คุณแน่ใจหรือไม่?',
                        text: "การกระทำนี้ไม่สามารถย้อนกลับได้!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ใช่, คือเงิน'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });


                  // Add click event listener for the delete button
                  $('.btn-taskRefund').click(function(e) {
                    e.preventDefault();

                    var form = $(this).closest('form');

                    Swal.fire({
                        title: 'คืนเงิน งานประจำ คุณแน่ใจหรือไม่?',
                        text: "การกระทำนี้ไม่สามารถย้อนกลับได้!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ใช่, คือเงิน'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
                // Add click event listener for the delete_1 button
                $('.btn-delete').click(function(e) {
                    e.preventDefault();

                    var form = $(this).closest('form');

                    Swal.fire({
                        title: 'คุณแน่ใจหรือไม่?',
                        text: "การกระทำนี้ไม่สามารถย้อนกลับได้!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'ใช่, ลบข้อมูล'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>





    </x-slot:javascript>
</x-app-layout>
