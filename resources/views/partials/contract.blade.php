@foreach ($project->main_task as $index => $task)
    @if ($task->contract->count() > 2)
        {{ __('สัญญา') }}
    @else
        {{ __('กิจกรรม') }}
    @endif
@endforeach
