<?php

namespace App\Http\Controllers;

use App\Libraries\Helper;
use App\Models\Contract;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\Facades\DataTables;



class ContractController extends Controller
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
            $records = contract::orderBy('contract_end_date', 'desc');

            return Datatables::eloquent($records)
                ->addIndexColumn()
                ->addColumn('contract_number_output', function ($row) {
                    return $row->contract_number;
                })
                ->addColumn('contract_name_output', function ($row) {
                    $flag_status = $row->contract_status == 2 ? '<span class="badge bg-info">ดำเนินการแล้วเสร็จ</span>' : '';
                    $html        = $row->contract_name . ' ' . $flag_status;
                    $html .= '<br><span class="badge bg-info">' . Helper::date($row->contract_start_date) . '</span> -';
                    $html .= ' <span class="badge bg-info">' . Helper::date($row->contract_end_date) . '</span>';

                    if ($row->task->count() > 0) {
                        $html .= ' <span class="badge bg-warning">' . $row->task->count() . ' กิจกรรม</span>';
                    }

                    return $html;
                })
                ->addColumn('contract_fiscal_year', function ($row) {
                    return $row->contract_fiscal_year;
                })
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">';
                    $html .= '<a href="' . route('contract.show', $row->hashid) . '" class="text-white btn btn-success"><i class="cil-folder-open "></i></a>';
                    //if (Auth::user()->hasRole('admin')) {
                    $html .= '<a href="' . route('contract.edit', $row->hashid) . '" class="text-white btn btn-warning btn-edit"><i class="cil-pencil "></i></a>';
                    $html .= '<button data-rowid="' . $row->hashid . '" class="text-white btn btn-danger btn-delete"><i class="cil-trash "></i></button>';
                    //}
                    $html .= '</div>';

                    return $html;
                })
                ->rawColumns(['contract_name_output', 'action'])
                ->toJson();
        }

        return view('app.contracts.index');
    }

    public function show(Request $request, $contract)
    {
        $id = Hashids::decode($contract)[0];

        $contract = Contract::find($id);

        $gantt = '';

        // dd(Hashids::encode($contract->task->task_id));

        return view('app.contracts.show', compact('contract', 'gantt'));
    }

    public function create(Request $request)
    {
        return view('app.contracts.create');
    }

    public function store(Request $request)
    {
        $contract = new Contract;

        $request->validate([
            'contract_name'                   => 'required',
            'contract_number'                 => 'required',
            'date-picker-contract_start_date' => 'required',
            'date-picker-contract_end_date'   => 'required',
        ]);

        //convert date
        $start_date = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-contract_start_date')), 'Y-m-d');
        $end_date   = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-contract_end_date')), 'Y-m-d');
        $sign_date  = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-contract_sign_date')), 'Y-m-d');

        $contract->contract_name        = $request->input('contract_name');
        $contract->contract_number      = $request->input('contract_number');
        $contract->contract_description = trim($request->input('contract_description'));
        $contract->contract_fiscal_year = $request->input('contract_fiscal_year');
        $contract->contract_start_date  = $start_date ?? date('Y-m-d 00:00:00');
        $contract->contract_end_date    = $end_date ?? date('Y-m-d 00:00:00');

        $contract->contract_juristic_id = $request->input('contract_juristic_id') ?? null;
        $contract->contract_order_no    = $request->input('contract_order_no') ?? null;
        $contract->contract_type        = $request->input('contract_type') ?? null;
        $contract->contract_acquisition = $request->input('contract_acquisition') ?? null;
        $contract->contract_sign_date   = $sign_date ?? null;

        // $contract->budget_gov = $request->input('budget_gov');
        // $contract->budget_it  = $request->input('budget_it');

        // $contract->budget_gov_operating  = $request->input('budget_gov_operating');
        // $contract->budget_gov_investment = $request->input('budget_gov_investment');
        // $contract->budget_gov_utility    = $request->input('budget_gov_utility');
        // $contract->budget_it_operating   = $request->input('budget_it_operating');
        // $contract->budget_it_investment  = $request->input('budget_it_investment');

        if ($contract->save()) {
            return redirect()->route('contract.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $contract)
    {
        $id       = Hashids::decode($contract)[0];
        $contract = Contract::find($id);

        return view('app.contracts.edit', compact('contract'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $contract)
    {
        $id       = Hashids::decode($contract)[0];
        $contract = Contract::find($id);

        $request->validate([
            'contract_name'                   => 'required',
            'date-picker-contract_start_date' => 'required',
            'date-picker-contract_end_date'   => 'required',
        ]);

        //convert date
        $start_date = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-contract_start_date')), 'Y-m-d');
        $end_date   = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-contract_end_date')), 'Y-m-d');
        $sign_date  = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-contract_sign_date')), 'Y-m-d');

        $contract->contract_name        = $request->input('contract_name');
        $contract->contract_number      = $request->input('contract_number');
        $contract->contract_status      = $request->input('contract_status');
        $contract->contract_description = trim($request->input('contract_description'));
        $contract->contract_fiscal_year = $request->input('contract_fiscal_year');
        $contract->contract_start_date  = $start_date ?? date('Y-m-d 00:00:00');
        $contract->contract_end_date    = $end_date ?? date('Y-m-d 00:00:00');

        $contract->contract_juristic_id = $request->input('contract_juristic_id') ?? null;
        $contract->contract_order_no    = $request->input('contract_order_no') ?? null;
        $contract->contract_type        = $request->input('contract_type') ?? null;
        $contract->contract_acquisition = $request->input('contract_acquisition') ?? null;
        $contract->contract_sign_date   = $sign_date ?? null;

        // $contract->budget_gov = $request->input('budget_gov');
        // $contract->budget_it  = $request->input('budget_it');

        // $contract->budget_gov_operating  = $request->input('budget_gov_operating');
        // $contract->budget_gov_investment = $request->input('budget_gov_investment');
        // $contract->budget_gov_utility    = $request->input('budget_gov_utility');
        // $contract->budget_it_operating   = $request->input('budget_it_operating');
        // $contract->budget_it_investment  = $request->input('budget_it_investment');

        if ($contract->save()) {
            return redirect()->route('contract.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy($contract)
    {
        $id       = Hashids::decode($contract)[0];
        $contract = Contract::find($id);
        if ($contract) {
            $contract->delete();
        }
        return redirect()->route('contract.index');
    }






////////////////////////////////////////////////////////



public function taskShow(Request $request, $project, $task)
{
    $id_project = Hashids::decode($project)[0];
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
        $tasks     = Task::where('project_id', $id)->get();
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
        $task       = task::find($id_task);
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
