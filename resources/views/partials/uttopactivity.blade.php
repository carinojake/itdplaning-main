



                                            @foreach ($project->main_task as $index => $task)
                            @if ($task->task_budget_gov_utility > 0 && $task->task_budget_type == 0 && $task->task_refund_budget_type == 1)
                                            <P>-
                                            {{ $task->task_name }}
                                            {{ number_format($task->task_refund_pa_budget, 2) }} บาท
                                            @endif
                                            @endforeach

