<?php

namespace App\Http\Controllers;


use App\Libraries\Helper;
use App\Models\Contract;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Task;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
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

    public function index(Request $request )
   {

        $contracts = Contract::count();
        $projects  = Project::count();


        $tasks = Task::count();
        $projects_amount = Project::count();

        $budgets   = Project::where('project_fiscal_year', 2566)->sum(DB::raw('	COALESCE(budget_gov_operating,0) + COALESCE(budget_gov_investment,0) + COALESCE(budget_gov_utility,0) + COALESCE(budget_it_operating,0) + COALESCE(budget_it_investment,0)'));



        $budgets2   = Project::where('project_fiscal_year', 2566)->sum(DB::raw('	COALESCE(budget_gov_operating,0) + COALESCE(budget_gov_investment,0) + COALESCE(budget_gov_utility,0) + COALESCE(budget_it_operating,0) + COALESCE(budget_it_investment,0)'));

















        $contract_groupby_fiscal_years = Contract::selectRaw('contract_fiscal_year as fiscal_year, count(*) as total')
            ->GroupBy('contract_fiscal_year')
            ->orderBy('contract_fiscal_year', 'desc')
            ->get()
            ->toJson();

        $project_groupby_fiscal_years = Project::selectRaw('project_fiscal_year as fiscal_year, count(*) as total')
            ->GroupBy('project_fiscal_year')
            ->orderBy('project_fiscal_year', 'desc')
            ->get()
            ->toJson();

            $project_groupby_task = Task::selectRaw('project_id as fiscal_year, count(*) as total')
            ->GroupBy('project_id')
            ->orderBy('project_id', 'desc')
            ->get()
            ->toJson();


            $project_groupby_reguiar = Project::selectRaw('reguiar_id as fiscal_year, count(*) as total')
            ->where('project_fiscal_year', 2566)
            ->GroupBy('reguiar_id')
            ->orderBy('reguiar_id', 'ASC')
            ->get()
            ->toJson();







          //  $project = Project::get()->toArray();
         $project =  Project::where('project_fiscal_year', 2566)->get();



            foreach ($project as $project) {

                (Int) $__budget_gov = (Int) $project['budget_gov_operating'] + (Int) $project['budget_gov_utility'] + (Int) $project['budget_gov_investment'];
                (Int) $__budget_it  = (Int) $project['budget_it_operating'] + (Int) $project['budget_it_investment'];
                (Int) $__budget    = $__budget_gov + $__budget_it;
                (Int) $__cost       = (Int) $project['project_cost'];
                (Int) $__balance    = $__budget + (Int) $project['project_cost'];
                $__project_cost     = [];



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
                    'project_fiscal_year'   => $project['project_fiscal_year'],

                ];





                $budget['total'] = $__budget;

              foreach ($project->task as $task) {

                    (Int) $__budget_gov = (Int) $task['task_budget_gov_operating'] + (Int) $task['task_budget_gov_utility'] + (Int) $task['task_budget_gov_investment'];
                    (Int) $__budget_it  = (Int) $task['task_budget_it_operating'] + (Int) $task['task_budget_it_investment'];
                    (Int) $__budget     = $__budget_gov + $__budget_it;




                    (Int) $__cost = array_sum([
                        $task['task_cost_gov_operating'],
                        $task['task_cost_gov_investment'],
                        $task['task_cost_gov_utility'],
                        $task['task_cost_it_operating'],
                        $task['task_cost_it_investment'],
                    ]);


                  (Int) $__balance = $__budget - $__cost;

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

                        'budget'                => $__budget ,

                        'cost'                  => $__cost,
                        'balance'               => $__balance,

                        // 'owner' => $project['project_owner'],
                    ];



                   $__project_cost[] = $__cost;

                }



         // $gantt[0]['cost']    = array_sum($__project_cost);


         $gantt[0]['balance'] = $gantt[0]['balance']- $gantt[0]['cost'];
           //     $budget['cost']    = $gantt[0]['cost'];
             //  $budget['balance'] = $gantt[0]['balance'];








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
            }
            $gantt = json_encode($gantt);







      return view('app.dashboard.index', compact('budgets2','budgets','gantt','project_groupby_reguiar' ,'project_groupby_task','tasks',  'projects_amount',     'contracts', 'contract_groupby_fiscal_years', 'projects', 'project_groupby_fiscal_years'));
    }
}
