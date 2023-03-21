@@ -1,504 +1,513 @@
<?php

namespace App\Http\Controllers;

use App\Libraries\Helper;
use App\Models\Contract;
use App\Models\ContractHasTask;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Double;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $records = Project::orderBy('project_start_date', 'desc');

            return Datatables::eloquent($records)
                ->addIndexColumn()
                ->addColumn('project_name_output', function ($row) {
                    $flag_status = $row->project_status == 2 ? '<span class="badge bg-info">ดำเนินการแล้วเสร็จ</span>' : '';
                    $html        = $row->project_name . ' ' . $flag_status;
                    $html .= '<br><span class="badge bg-info">' . Helper::date($row->project_start_date) . '</span> -';
                    $html .= ' <span class="badge bg-info">' . Helper::date($row->project_end_date) . '</span>';

                    if ($row->task->count() > 0) {
                        $html .= ' <span class="badge bg-warning">' . $row->main_task->count() . 'กิจกรรม</span>';
                    }

                    if ($row->contract->count() > 0) {
                        $html .= ' <span class="badge bg-danger">' . $row->contract->count() . 'สัญญา</span>';
                    }

                    return $html;
                })
                ->addColumn('project_fiscal_year', function ($row) {
                    return $row->project_fiscal_year;
                })
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">';
                    $html .= '<a href="' . route('project.show', $row->hashid) . '" class="text-white btn btn-success"><i class="cil-folder-open "></i></a>';
                    //if (Auth::user()->hasRole('admin')) {
                    $html .= '<a href="' . route('project.edit', $row->hashid) . '" class="text-white btn btn-warning btn-edit"><i class="cil-pencil "></i></a>';
                    $html .= '<button data-rowid="' . $row->hashid . '" class="text-white btn btn-danger btn-delete"><i class="cil-trash "></i></button>';
                    //}
                    $html .= '</div>';

                    return $html;
                })
                ->rawColumns(['project_name_output', 'action'])
                ->toJson();
        }

        return view('app.projects.index');
    }

    public function gantt(Request $request)
    {
        $projects = Project::get()->toArray();

        foreach ($projects as $project) {
            (Int) $__budget_gov = (Int) $project['budget_gov_operating'] + (Int) $project['budget_gov_utility'] + (Int) $project['budget_gov_investment'];
            (Int) $__budget_it  = (Int) $project['budget_it_operating'] + (Int) $project['budget_it_investment'];
            (Int) $__budget     = $__budget_gov + $__budget_it;
            (Int) $__balance    = $__budget + (Int) $project['project_cost'];

            $gantt[] = [
                'id'                    => $project['project_id'],
                'text'                  => $project['project_name'],
                'start_date'            => date('Y-m-d', $project['project_start_date']),
                'end_date'              => date('Y-m-d', $project['project_end_date']),
                'budget_gov_operating'  => $project['budget_gov_operating'],
                'budget_gov_investment' => $project['budget_gov_investment'],
                'budget_gov_utility'    => $project['budget_gov_utility'],
                'budget_gov'            => $__budget_gov,
                'budget_it_operating'   => $project['budget_it_operating'],
                'budget_it_investment'  => $project['budget_it_investment'],
                'budget_it'             => $__budget_it,
                'budget'                => $__budget,
                'balance'               => $__balance,
                'cost'                  => $project['project_cost'],
                'owner'                 => $project['project_owner'],
                // 'type' => 'project',
                // 'duration' => 360,
            ];
        }

        // $tasks = Task::get()->toArray();
        // foreach($tasks as $task) {
        //     // (Int) $__budget_gov = (Int) $project['budget_gov_operating'] + (Int) $project['budget_gov_utility'] + (Int) $project['budget_gov_investment'];
        //     // (Int) $__budget_it = (Int) $project['budget_it_operating'] + (Int) $project['budget_it_investment'];
        //     // (Int) $__budget = $__budget_gov + $__budget_it;
        //     // (Int) $__balance = $__budget + (Int) $project['project_cost'];

        //     $gantt[] = [
        //         'id' => $task['task_id'].$task['project_id'],
        //         'text' => $task['task_name'],
        //         'start_date' => date('Y-m-d', $task['task_start_date']),
        //         'end_date' => date('Y-m-d', $task['task_end_date']),
        //         'parent' => $task['project_id'],
        //         'type' => 'task'
        //         // 'budget_gov_operating' => $project['budget_gov_operating'],
        //         // 'budget_gov_investment' => $project['budget_gov_investment'],
        //         // 'budget_gov_utility' => $project['budget_gov_utility'],
        //         // 'budget_gov' => $__budget_gov,
        //         // 'budget_it_operating' => $project['budget_it_operating'],
        //         // 'budget_it_investment' => $project['budget_it_investment'],
        //         // 'budget_it' => $__budget_it,
        //         // 'budget' => $__budget,
        //         // 'balance' => $__balance,
        //         // 'cost' => $project['project_cost'],
        //         // 'owner' => $project['project_owner'],
        //     ];
        // }

        $gantt = json_encode($gantt);

        return view('app.projects.gantt', compact('gantt'));
    }

    public function show(Request $request, $project)
    {
        $id = Hashids::decode($project)[0];

        $project = Project::find($id);

        (Double) $__budget_gov = (Double) $project['budget_gov_operating'] + (Double) $project['budget_gov_utility'] + (Double) $project['budget_gov_investment'];
        (Double) $__budget_it  = (Double) $project['budget_it_operating'] + (Double) $project['budget_it_investment'];
        (Double) $__budget     = $__budget_gov + $__budget_it;
        (Double) $__cost       = (Double) $project['project_cost'];
        (Double) $__balance    = $__budget + (Double) $project['project_cost'];
        $__project_cost     = [];

        $gantt[] = [
            'id'                    => $project['project_id'],
            'text'                  => $project['project_name'],
            'start_date'            => date('Y-m-d', $project['project_start_date']),
            // 'end_date' => date('Y-m-d', $project['project_end_date']),
            'budget_gov_operating'  => $project['budget_gov_operating'],
            'budget_gov_investment' => $project['budget_gov_investment'],
            'budget_gov_utility'    => $project['budget_gov_utility'],
            'budget_gov'            => $__budget_gov,
            'budget_it_operating'   => $project['budget_it_operating'],
            'budget_it_investment'  => $project['budget_it_investment'],
            'budget_it'             => $__budget_it,
            'budget'                => $__budget,
            'balance'               => $__balance,
            'cost'                  => $project['project_cost'],
            'owner'                 => $project['project_owner'],
            'open'                  => true,
            'type'                  => 'project',
            'duration'              => 360,
        ];

        $budget['total'] = $__budget;

        foreach ($project->task as $task) {
            (Double) $__budget_gov = (Double) $task['task_budget_gov_operating'] + (Double) $task['task_budget_gov_utility'] + (Double) $task['task_budget_gov_investment'];
            (Double) $__budget_it  = (Double) $task['task_budget_it_operating'] + (Double) $task['task_budget_it_investment'];
            (Double) $__budget     = $__budget_gov + $__budget_it;

            (Double) $__cost = array_sum([
                $task['task_cost_gov_operating'],
                $task['task_cost_gov_investment'],
                $task['task_cost_gov_utility'],
                $task['task_cost_it_operating'],
                $task['task_cost_it_investment'],
            ]);

            (Double) $__balance = $__budget - $__cost;

            $gantt[] = [
                'id'                    => 'T' . $task['task_id'] . $task['project_id'],
                'text'                  => $task['task_name'],
                'start_date'            => date('Y-m-d', $task['task_start_date']),
                'end_date'              => date('Y-m-d', $task['task_end_date']),
                'parent'                => $task['task_parent'] ? 'T' . $task['task_parent'] . $task['project_id'] : $task['project_id'],
                'type'                  => 'task',
                'open'                  => true,
                'budget_gov_operating'  => $task['task_budget_gov_operating'],
                'budget_gov_investment' => $task['task_budget_gov_investment'],
                'budget_gov_utility'    => $task['task_budget_gov_utility'],
                'budget_gov'            => $__budget_gov,
                'budget_it_operating'   => $task['task_budget_it_operating'],
                'budget_it_investment'  => $task['task_budget_it_investment'],
                'budget_it'             => $__budget_it,
                'budget'                => $__budget,
                'balance'               => $__balance,
                'cost'                  => $__cost,
                // 'owner' => $project['project_owner'],
            ];
            $__project_cost[] = $__cost;
        }
        $gantt[0]['cost']    = array_sum($__project_cost);
        $gantt[0]['balance'] = $gantt[0]['balance'] - $gantt[0]['cost'];

        $budget['cost']    = $gantt[0]['cost'];
        $budget['balance'] = $gantt[0]['balance'];

        $gantt = json_encode($gantt);

        return view('app.projects.show', compact('project', 'gantt', 'budget'));
    }

    public function create(Request $request)
    {
        return view('app.projects.create');
    }

    public function store(Request $request)
    {
        $project = new Project;

        $request->validate([
            'project_name'                   => 'required',
            'date-picker-project_start_date' => 'required',
            'date-picker-project_end_date'   => 'required',
        ]);

        //convert date
        $start_date = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-project_start_date')), 'Y-m-d');
        $end_date   = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-project_end_date')), 'Y-m-d');

        $project->project_name        = $request->input('project_name');
        $project->project_description = $request->input('project_description');
        $project->project_type        = $request->input('project_type');
        $project->project_fiscal_year = $request->input('project_fiscal_year');
        $project->project_start_date  = $start_date ?? date('Y-m-d 00:00:00');
        $project->project_end_date    = $end_date ?? date('Y-m-d 00:00:00');

        // $project->budget_gov = $request->input('budget_gov');
        // $project->budget_it  = $request->input('budget_it');

        $project->budget_gov_operating  = $request->input('budget_gov_operating');
        $project->budget_gov_investment = $request->input('budget_gov_investment');
        $project->budget_gov_utility    = $request->input('budget_gov_utility');
        $project->budget_it_operating   = $request->input('budget_it_operating');
        $project->budget_it_investment  = $request->input('budget_it_investment');
 $project->reguiar_id            = $request->input('reguiar_id');
        if ($project->save()) {
            return redirect()->route('project.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $project)
    {
        $id      = Hashids::decode($project)[0];
        $project = Project::find($id);

        return view('app.projects.edit', compact('project'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $project)
    {
        $id      = Hashids::decode($project)[0];
        $project = Project::find($id);

        $request->validate([
            'project_name'                   => 'required',
            'date-picker-project_start_date' => 'required',
            'date-picker-project_end_date'   => 'required',
        ]);

        //convert date
        $start_date = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-project_start_date')), 'Y-m-d');
        $end_date   = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-project_end_date')), 'Y-m-d');

        $project->project_name        = $request->input('project_name');
        $project->project_description = trim($request->input('project_description'));
        $project->project_type        = $request->input('project_type');
        $project->project_fiscal_year = $request->input('project_fiscal_year');
        $project->project_start_date  = $start_date ?? date('Y-m-d 00:00:00');
        $project->project_end_date    = $end_date ?? date('Y-m-d 00:00:00');

        $project->project_status = $request->input('project_status') ?? null;
        // $project->budget_gov = $request->input('budget_gov');
        // $project->budget_it  = $request->input('budget_it');

        $project->budget_gov_operating  = $request->input('budget_gov_operating');
        $project->budget_gov_investment = $request->input('budget_gov_investment');
        $project->budget_gov_utility    = $request->input('budget_gov_utility');
        $project->budget_it_operating   = $request->input('budget_it_operating');
        $project->budget_it_investment  = $request->input('budget_it_investment');
        $project->reguiar_id            = $request->input('reguiar_id');
        if ($project->save()) {
            return redirect()->route('project.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($project)
    {
        $id      = Hashids::decode($project)[0];
        $project = Project::find($id);
        if ($project) {
            $project->delete();
        }
        return redirect()->route('project.index');
    }
//////////////////////////////////////////////////////////////////////
    public function taskShow(Request $request, $project, $task)
    {
       ( $id_project = Hashids::decode($project)[0]);
        $id_task    = Hashids::decode($task)[0];
        $project    = Project::find($id_project);
        $task       = task::find($id_task);

        // echo 'contract' . $task->contract->count();
        // dd($task->contract);

        return 'Under Construction';
    }

    public function taskCreate(Request $request, $project)
    {
        $id        = Hashids::decode($project)[0];
        ($tasks     = Task::where('project_id', $id)->get());
        $contracts = Contract::get();

        return view('app.projects.tasks.create', compact('contracts', 'project', 'tasks'));
    }

    public function taskStore(Request $request, $project)
    {
        $id   = Hashids::decode($project)[0];
        $task = new Task;

        $request->validate([
            'task_name'                   => 'required',
            'date-picker-task_start_date' => 'required',
            'date-picker-task_end_date'   => 'required',
        ]);

        //convert date
        $start_date = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-task_start_date')), 'Y-m-d');
        $end_date   = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-task_end_date')), 'Y-m-d');

        $pay_date   = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-task_pay_date')), 'Y-m-d');

        $task->project_id       = $id;
        $task->task_name        = $request->input('task_name');
        $task->task_description = trim($request->input('task_description'));
        $task->task_start_date  = $start_date ?? date('Y-m-d 00:00:00');
        $task->task_end_date    = $end_date ?? date('Y-m-d 00:00:00');

        $task->task_parent = $request->input('task_parent') ?? null;

        $task->task_budget_gov_operating  = $request->input('task_budget_gov_operating');
        $task->task_budget_gov_investment = $request->input('task_budget_gov_investment');
        $task->task_budget_gov_utility    = $request->input('task_budget_gov_utility');
        $task->task_budget_it_operating   = $request->input('task_budget_it_operating');
        $task->task_budget_it_investment  = $request->input('task_budget_it_investment');

        $task->task_cost_gov_operating  = $request->input('task_cost_gov_operating');
        $task->task_cost_gov_investment = $request->input('task_cost_gov_investment');
        $task->task_cost_gov_utility    = $request->input('task_cost_gov_utility');
        $task->task_cost_it_operating   = $request->input('task_cost_it_operating');
        $task->task_cost_it_investment  = $request->input('task_cost_it_investment');
        $task->task_pay                 = $request->input('task_pay');
        $task->task_pay_date            =  $pay_date ?? date('Y-m-d 00:00:00');

        if ($task->save()) {

            //insert contract
            if ($request->input('task_contract')) {
                //insert contract
                $contract_has_task = new ContractHasTask;

                $contract_has_task->contract_id = $request->input('task_contract');
                $contract_has_task->task_id     = $task->task_id;
                $contract_has_task->save();
            }

            return redirect()->route('project.show', $project);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $project
     * @return \Illuminate\Http\Response
     */
    public function taskEdit(Request $request, $project, $task)
    {
        $id_project = Hashids::decode($project)[0];
        $id_task    = Hashids::decode($task)[0];
        $project    = Project::find($id_project);
        $task       = Task::find($id_task);
        $tasks      = Task::where('project_id', $id_project)
            ->whereNot('task_id', $id_task)
            ->get();
        $contracts = Contract::get();

        return view('app.projects.tasks.edit', compact('contracts', 'project', 'task', 'tasks'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $project
     * @return \Illuminate\Http\Response
     */
    public function taskUpdate(Request $request, $project, $task)
    {
        $id_project = Hashids::decode($project)[0];
        $id_task    = Hashids::decode($task)[0];
        $project    = Project::find($id_project);
        $task       = task::find($id_task);

        $request->validate([
            'task_name'                   => 'required',
            'date-picker-task_start_date' => 'required',
            'date-picker-task_end_date'   => 'required',

        ]);

        //convert date
        $start_date = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-task_start_date')), 'Y-m-d');
        $end_date   = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-task_end_date')), 'Y-m-d');
        $pay_date   = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-task_pay_date')), 'Y-m-d');


        $task->project_id       = $id_project;
        $task->task_name        = $request->input('task_name');
        $task->task_status      = $request->input('task_status');
        $task->task_description = trim($request->input('task_description'));
        $task->task_start_date  = $start_date ?? date('Y-m-d 00:00:00');
        $task->task_end_date    = $end_date ?? date('Y-m-d 00:00:00');

        $task->task_parent = $request->input('task_parent') ?? null;

        $task->task_budget_gov_operating  = $request->input('task_budget_gov_operating');
        $task->task_budget_gov_investment = $request->input('task_budget_gov_investment');
        $task->task_budget_gov_utility    = $request->input('task_budget_gov_utility');
        $task->task_budget_it_operating   = $request->input('task_budget_it_operating');
        $task->task_budget_it_investment  = $request->input('task_budget_it_investment');

        $task->task_cost_gov_operating  = $request->input('task_cost_gov_operating');
        $task->task_cost_gov_investment = $request->input('task_cost_gov_investment');
        $task->task_cost_gov_utility    = $request->input('task_cost_gov_utility');
        $task->task_cost_it_operating   = $request->input('task_cost_it_operating');
        $task->task_cost_it_investment  = $request->input('task_cost_it_investment');
        $task->task_pay                 = $request->input('task_pay');
        $task->task_pay_date            =  $pay_date ?? date('Y-m-d 00:00:00');

        if ($task->save()) {

            //update contract
            if ($request->input('task_contract')) {
                ContractHasTask::where('task_id', $id_task)->delete();
                ContractHasTask::Create([
                    'contract_id' => $request->input('task_contract'),
                    'task_id'     => $id_task,
                ]);
            } else {
                ContractHasTask::where('task_id', $id_task)->delete();
            }

            return redirect()->route('project.show', $project->hashid);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $project
     * @param  int  $task
     * @return \Illuminate\Http\Response
     */
    public function taskDestroy($project, $task)
    {
        $id   = Hashids::decode($task)[0];
        $task = Task::find($id);
        if ($task) {
            $task->delete();
        }
        return redirect()->route('project.show', $project);
    }

}
