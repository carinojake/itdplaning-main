                    <tbody>
                                    @foreach ($project->main_task as $task)
                                        <tr>
                                           {{--  <td> </td> --}}
                                            <td>
                                                {{ $task->task_name }} {!! $task->task_status == 2 ? '<span class="badge bg-info">ดำเนินการแล้วเสร็จ</span>' : '' !!}
                                                @if ($task->contract->count() > 0)
                                                    {{-- <span class="badge bg-warning">{{ $task->contract->count() }} สัญญา</span> --}}
                                                    @foreach ($task->contract as $contract)
                                                        <a
                                                            href="{{ route('contract.show', ['contract' => $contract->hashid]) }}"><span
                                                                class="badge bg-warning">{{ $contract->contract_number }}</span></a>
                                                    @endforeach
                                                @endif
                                                @if ($task->subtask->count() > 0)
                                                    <h6>รายการที่ใช้จ่าย</h6>
                                                    <ul>
                                                        @foreach ($task->subtask as $subtask)
                                                            <li>
                                                                {{ $subtask->task_name }}
                                                              {{--   <span
                                                                    class="badge bg-primary">{{ \Helper::date4(date('Y-m-d H:i:s', $subtask->task_start_date)) }}</span>
                                                                <span
                                                                    class="badge bg-primary">{{ \Helper::date4(date('Y-m-d H:i:s', $subtask->task_end_date)) }}</span> --}}
                                                                @if ($subtask->contract->count() > 0)
                                                                    @foreach ($subtask->contract as $contract)
                                                                       {{--  <a
                                                                            href="{{ route('contract.show', ['contract' => $contract->hashid]) }}">
                                                                            <span
                                                                                class="badge bg-warning">{{ $contract->contract_number }}</span>
                                                                        </a> --}}


                                                                        <!-- Button trigger modal -->
                                                                        <button type="button" class="btn btn-success text-white"
                                                                            data-coreui-toggle="modal"

                                                                            data-coreui-target="#exampleModal{{ $contract->hashid }}">
                                                                           สญ.ที่ {{ $contract->contract_number }}

                                                                        </button>


                                                                                        {{--  --}}
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button"
                                                                                            class="btn btn-secondary"
                                                                                            data-coreui-dismiss="modal">Close</button>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif


                                                                <a href="{{ route('project.task.show', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}"
                                                                    class="btn-sm btn btn-primary text-white"
                                                                    target="_blank"><i
                                                                        class="cil-folder-open "></i></a>
                                                                <a href="{{ route('project.task.editsub', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}"
                                                                    class="btn-sm btn btn-warning text-white"
                                                                    target="_blank"> <i class="cil-cog"></i> </a>
                                                                <form
                                                                    action="{{ route('project.task.destroy', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}"
                                                                    method="POST" style="display:inline">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button class="btn-sm btn btn-danger text-white"><i
                                                                            class="cil-trash"></i></button>
                                                                </form>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </td>
                                            <td>
