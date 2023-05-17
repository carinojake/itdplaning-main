public function taskCreate(Request $request, $project,$task=null)
{
    $id        = Hashids::decode($project)[0];
    $project = $request->project;
  //  ($project = Project::find($id)); // รับข้อมูลของโครงการจากฐานข้อมูล
    ($tasks     = Task::where('project_id', $id)->get());
    $contracts = contract::orderBy('contract_fiscal_year', 'desc')->get();


    if ($task) {
        $taskId = Hashids::decode($task)[0];
        $task = Task::find($taskId);
    } else {
        $task = null;
    }

    return view('app.projects.tasks.create', compact('contracts', 'project', 'tasks'));
}
