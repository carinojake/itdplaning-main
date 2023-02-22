<?php

namespace App\Http\Controllers;

use App\Libraries\Helper;
use App\Models\Contract;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Task;
use App\Models\Taskcon;
use App\Models\ContractHasTask;
use App\Models\ContractHasTaskcon;
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

        $contract_start_date = \Carbon\Carbon::createFromTimestamp($contract->contract_start_date);
        $contract_end_date = \Carbon\Carbon::createFromTimestamp($contract->contract_end_date);

        $duration = $contract_end_date->diff($contract_start_date)->days;

        ($duration_p =  \Carbon\Carbon::parse($contract->contract_start_date)
        ->diffInMonths(\Carbon\Carbon::parse($contract->contract_end_date))
                -  \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse())) ;


       // $gantt = '';

        // dd(Hashids::encode($contract->task->task_id));


        $gantt[] = [
            'id'                    => $contract['contract_id'],
            'text'                  => $contract['contract_name'],
            'start_date'            => date('Y-m-d', $contract['contract_id_start_date']),
            // 'end_date' => date('Y-m-d', $project['project_end_date']),

            'open'                  => true,
            'type'                  => 'project',
            'duration'              => 360,
        ];

        foreach ($contract->taskcon as $task) {

            $gantt[] = [
                'id'                    => 'T' . $task['taskcon_id'] . $task['contract_id'],
                'text'                  => $task['taskcon_name'],
                'start_date'            => date('Y-m-d', $task['taskcon_start_date']),
                'end_date'              => date('Y-m-d', $task['taskcon_end_date']),
                'parent'                => $task['taskcon_parent'] ? 'T' . $task['taskcon_parent'] . $task['contract_id'] : $task['contract_id'],
                'type'                  => 'taskcon',
                'open'                  => true,

                // 'owner' => $project['project_owner'],
            ];

        }



        $gantt = json_encode($gantt);














































        return view('app.contracts.show', compact('contract', 'gantt','duration_p'));
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
        $contract->contract_projectplan        = $request->input('contract_projectplan');
        $contract->contract_mm        = $request->input('contract_mm');
        $contract->contract_pr        = $request->input('contract_pr');
        $contract->contract_pa        = $request->input('contract_pa');
        $contract->contract_pr_budget        = $request->input('contract_pr_budget');
        $contract->contract_pa_budget        = $request->input('contract_pa_budget');
        $contract->contract_owner        = $request->input('contract_owner');


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
        $contract->contract_projectplan        = $request->input('contract_projectplan');
        $contract->contract_mm        = $request->input('contract_mm');
        $contract->contract_pr        = $request->input('contract_pr');
        $contract->contract_pa        = $request->input('contract_pa');
        $contract->contract_pr_budget        = $request->input('contract_pr_budget');
        $contract->contract_pa_budget        = $request->input('contract_pa_budget');
        $contract->contract_owner        = $request->input('contract_owner');
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
//////////////////////////////////////////////////////////////


public function taskstorestore(Request $request, Contract $contract)
    {
        $request->validate([
            'taskcon_name' => 'required|string',

        ]);

        $task = new ContractTask();
        $task->name = $request->input('taskcon_name');

        $task->contract_id = $contract->id;
        $task->save();

        return redirect()->route('contract.task.index', $contract)->with('success', 'Task created successfully.');
    }





public function taskstore(Request $request, $contract)
{
    ($id        = Hashids::decode($contract)[0]);
    ($taskcons     = Taskcon::where('contract_id', $id)->get());
       ( $contractcons = Contract::get());

        return view('app.contracts.tasks.create', compact('contractcons', 'taskcons','contract'));



}



public function taskconShow(Request $request, $contract, $taskcon)
{
   ( $id_contract = Hashids::decode($contract)[0]);
    $id_taskcon    = Hashids::decode($taskcon)[0];
    $contract    = Contract::find($id_contract);
   $taskcon       = taskcon::find($id_taskcon);

    // echo 'contract' . $task->contract->count();
    // dd($task->contract);

    return 'Under Construction';
}

public function taskconCreate(Request $request, $contract)
{
    ($id        = Hashids::decode($contract)[0]);
($taskcons     = Taskcon::where('contract_id', $id)->get());
   ( $contractcons = Contract::get());

    return view('app.contracts.tasks.create', compact('contractcons', 'taskcons','contract'));
}



public function taskconStore(Request $request, $contract)
{
    $id   = Hashids::decode($contract)[0];
    $taskcon = new Taskcon;

    $request->validate([
        'taskcon_name'                   => 'required',
        'date-picker-taskcon_start_date' => 'required',
        'date-picker-taskcon_end_date'   => 'required',
    ]);

    //convert date
    $start_date = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-taskcon_start_date')), 'Y-m-d');
    $end_date   = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-taskcon_end_date')), 'Y-m-d');

    $taskcon->contract_id       = $id;
    $taskcon->taskcon_name        = $request->input('taskcon_name');
    $taskcon->taskcon_description = trim($request->input('taskcon_description'));
    $taskcon->taskcon_start_date  = $start_date ?? date('Y-m-d 00:00:00');
    $taskcon->taskcon_end_date    = $end_date ?? date('Y-m-d 00:00:00');

    $taskcon->taskcon_parent = $request->input('taskcon_parent') ?? null;

    $taskcon->taskcon_budget_gov_operating  = $request->input('taskcon_budget_gov_operating');
    $taskcon->taskcon_budget_gov_investment = $request->input('taskcon_budget_gov_investment');
    $taskcon->taskcon_budget_gov_utility    = $request->input('taskcon_budget_gov_utility');
    $taskcon->taskcon_budget_it_operating   = $request->input('taskcon_budget_it_operating');
    $taskcon->taskcon_budget_it_investment  = $request->input('taskcon_budget_it_investment');

    $taskcon->taskcon_cost_gov_operating  = $request->input('taskcon_cost_gov_operating');
    $taskcon->taskcon_cost_gov_investment = $request->input('taskcon_cost_gov_investment');
    $taskcon->taskcon_cost_gov_utility    = $request->input('taskcon_cost_gov_utility');
    $taskcon->taskcon_cost_it_operating   = $request->input('taskcon_cost_it_operating');
    $taskcon->taskcon_cost_it_investment  = $request->input('taskcon_cost_it_investment');

    if ($taskcon->save()) {

        //insert contract
        if ($request->input('taskcon_contract')) {
            //insert contract
            $contract_has_taskscon = new ContractHasTaskcon;

            $contract_has_taskscon->task_id = $request->input('taskcon_contract');
            $contract_has_taskscon->taskcon_id     = $taskcon->taskcon_id;
            $contract_has_taskscon->save();
        }

        return redirect()->route('contract.show', $contract);
    }
}

/**
     * Remove the specified resource from storage.
     *
     * @param  int  $contract
     * @return \Illuminate\Http\Response
     */
    public function taskconEdit(Request $request, $contract, $taskcon)
    {
        $id_contract = Hashids::decode($contract)[0];
        $id_taskcon    = Hashids::decode($taskcon)[0];
        $contracts    = Contract::find($id_contract);
        $taskcon       = Taskcon::find($id_taskcon);
        $taskcons      = Taskcon::where('taskcon_id', $id_taskcon)
            ->whereNot('contract_id', $id_contract)
            ->get();
            $task = Task::get();

        return view('app.contract.tasks.edit', compact('contracts', 'taskcon', 'task','taskcons'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $contract
     * @return \Illuminate\Http\Response
     */
    public function taskconUpdate(Request $request, $contract, $taskcon)
    {
        $id_contract = Hashids::decode($contract)[0];
        $id_taskcon    = Hashids::decode($taskcon)[0];
        $contract    = Contract::find($id_contract);
        $taskcon       = taskcon::find($id_taskcon);

        $request->validate([
            'taskcon_name'                   => 'required',
            'date-picker-taskcon_start_date' => 'required',
            'date-picker-taskcon_end_date'   => 'required',
        ]);

        //convert date
        $start_date = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-taskcon_start_date')), 'Y-m-d');
        $end_date   = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-taskcon_end_date')), 'Y-m-d');

        $taskcon->contract_id       = $id_contract;
        $taskcon->taskcon_name        = $request->input('taskcon_name');
        $taskcon->taskcon_status      = $request->input('taskcon_status');
        $taskcon->taskcon_description = trim($request->input('taskcun_description'));
        $taskcon->taskcon_start_date  = $start_date ?? date('Y-m-d 00:00:00');
        $taskcon->taskcon_end_date    = $end_date ?? date('Y-m-d 00:00:00');

        $taskcon->taskcon_parent = $request->input('taskcon_parent') ?? null;

        $taskcon->taskcon_budget_gov_operating  = $request->input('taskcon_budget_gov_operating');
        $taskcon->taskcon_budget_gov_investment = $request->input('taskcon_budget_gov_investment');
        $taskcon->taskcon_budget_gov_utility    = $request->input('taskcon_budget_gov_utility');
        $taskcon->taskcon_budget_it_operating   = $request->input('taskcon_budget_it_operating');
        $taskcon->taskcon_budget_it_investment  = $request->input('taskcon_budget_it_investment');

        $taskcon->taskcon_cost_gov_operating  = $request->input('taskcon_cost_gov_operating');
        $taskcon->taskcon_cost_gov_investment = $request->input('taskcon_cost_gov_investment');
        $taskcon->taskcon_cost_gov_utility    = $request->input('taskcon_cost_gov_utility');
        $taskcon->taskcon_cost_it_operating   = $request->input('taskcon_cost_it_operating');
        $taskcon->taskcon_cost_it_investment  = $request->input('taskcon_cost_it_investment');

        if ($taskcon->save()) {

            //update contract
            if ($request->input('taskcom_contract')) {
                ContractHasTaskcon::where('taskcom_id', $id_taskcon)->delete();
                ContractHasTaskcon::Create([
                    'contract_id' => $request->input('task_contract'),
                    'taskcon_id'     => $id_taskcon,
                ]);
            } else {
                ContractHasTaskcon::where('taskcon_id', $id_taskcon)->delete();
            }

            return redirect()->route('contract.show', $contract->hashid);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $contract
     * @param  int  $taskcon
     * @return \Illuminate\Http\Response
     */
    public function taskconDestroy($contract, $taskcon)
    {
        $id   = Hashids::decode($taskcon)[0];
        $taskcon = Taskcon::find($id);
        if ($taskcon) {
            $taskcon->delete();
        }
        return redirect()->route('contract.show', $contract);
    }


/////////






}





