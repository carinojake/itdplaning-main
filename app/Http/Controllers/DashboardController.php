<?php

namespace App\Http\Controllers;


use App\Libraries\Helper;
use App\Models\Contract;
use App\Models\Project;
use App\Models\ContractHasTask;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Mail\Mailables\Content;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller


{

    /**
     * Create a new controller instance.
     *
     * @return void
     * @var double $taskcosttotal
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        ($contracts = Contract::where('contract_fiscal_year', 2566)->count());
        $projects  = Project::where('project_fiscal_year', 2566)->count();
        ($project_type_j  = Project::where('project_type', 'J')->where('project_fiscal_year', 2566)->count());
        ($project_type_p  = Project::where('project_type', 'P')->where('project_fiscal_year', 2566)->count());


       // $rebuts = contract::count($contract->taskcont);

        $tasks = Task::count();


        //  $tasksum = Task::with('project')->whereHas('project', function($query) {
        //    $query->where('project_fiscal_year', 2566);
        //})->count();


        $projects_amount = Project::count();

        ($budgets   = Project::where('project_fiscal_year', 2566)->sum(DB::raw('	COALESCE(budget_gov_operating,0) + COALESCE(budget_gov_investment,0) + COALESCE(budget_gov_utility,0) + COALESCE(budget_it_operating,0) + COALESCE(budget_it_investment,0)')));
        $budgets2   = Project::where('project_fiscal_year', 2566)->sum(DB::raw('	COALESCE(budget_gov_operating,0) + COALESCE(budget_gov_investment,0) + COALESCE(budget_gov_utility,0) + COALESCE(budget_it_operating,0) + COALESCE(budget_it_investment,0)'));
        ($budgetsgov =  Project::where('project_fiscal_year', 2566)->sum(DB::raw('	COALESCE(budget_gov_operating,0) + COALESCE(budget_gov_investment,0)')));
        ($budgetsict = Project::where('project_fiscal_year', 2566)->sum(DB::raw('COALESCE(budget_it_operating,0) + COALESCE(budget_it_investment,0)')));

        ($budgetscentralict = Project::where('project_fiscal_year', 2566)->sum(DB::raw('COALESCE(budget_it_operating,0)')));
        ($budgetsinvestment = Project::where('project_fiscal_year', 2566)->sum(DB::raw('COALESCE(budget_gov_investment,0) + COALESCE(budget_it_investment,0)')));
        ($budgetsut  = Project::where('project_fiscal_year', 2566)->sum(DB::raw('COALESCE(budget_gov_utility,0)	')));
        ///จ่ายงบict
        ($taskcostict = DB::table('tasks')
            ->selectRaw('sum(
      COALESCE(task_cost_it_operating, 0)
      + COALESCE(task_cost_gov_operating, 0)) as b')
            ->whereExists(
                function ($query) {
                    $query->select('*')
                        ->from('projects')
                        ->whereRaw('tasks.project_id = projects.project_id AND project_fiscal_year = 2566')
                        ->GroupBy('reguiar_id');
                }
            )
            ->get()
            ->toJson());
        ($json = json_decode($taskcostict));
        ($b = $json[0]->b);
        ($coats_ict = (float) $b);

        ///จ่ายงบict หลัก pa
        ($taskconcostict = DB::table('taskcons')
            ->selectRaw('sum(
  COALESCE(taskcon_cost_it_operating, 0)
  + COALESCE(taskcon_cost_gov_operating, 0)) as b')
            ->get()
            ->toJson());
        ($json = json_decode($taskconcostict));
        ($b = $json[0]->b);
        ($coatcons_ict = (float) $b);


        //จ่ายงบดำการดำเนิน
        ($taskcostinvestment = DB::table('tasks')
            ->selectRaw('sum(COALESCE(task_cost_it_investment, 0)
  + COALESCE(task_cost_gov_investment, 0))

as c')
            ->whereExists(
                function ($query) {
                    $query->select('*')
                        ->from('projects')
                        ->whereRaw('tasks.project_id = projects.project_id AND project_fiscal_year = 2566')
                        ->GroupBy('reguiar_id');
                }
            )
            ->get()
            ->toJson());
        ($json = json_decode($taskcostinvestment));
        ($c = $json[0]->c);
        ($coats_inv = (float) $c);
        //pa
        ($taskconcostinvestment = DB::table('taskcons')
            ->selectRaw('sum(COALESCE(taskcon_cost_it_investment, 0)
+ COALESCE(taskcon_cost_gov_investment, 0))

as c')
            //->whereExists(
            //  function ($query) {
            //    $query->select('*')
            //      ->from('projects')
            //    ->whereRaw('tasks.project_id = projects.project_id AND project_fiscal_year = 2566')
            //  ->GroupBy('reguiar_id');
            //}
            //)
            ->get()
            ->toJson());
        ($json = json_decode($taskconcostinvestment));
        ($c = $json[0]->c);
        ($coatcons_inv = (float) $c);


        ///////////////////
        ($taskcostgov = DB::table('tasks')
            ->selectRaw('sum(COALESCE(task_cost_gov_operating, 0)
     + COALESCE(task_cost_gov_investment, 0))

   as c')
            ->whereExists(
                function ($query) {
                    $query->select('*')
                        ->from('projects')
                        ->whereRaw('tasks.project_id = projects.project_id AND project_fiscal_year = 2566')
                        ->GroupBy('reguiar_id');
                }
            )
            ->get()
            ->toJson());
        ($json = json_decode($taskcostgov));
        ($c = $json[0]->c);
        ($coats_gov = (float) $c);




        ($taskconcostgov = DB::table('taskcons')
            ->selectRaw('sum(COALESCE(taskcon_cost_gov_operating, 0)
     + COALESCE(taskcon_cost_gov_investment, 0))

   as c')
            // ->whereExists(
            //   function ($query) {
            //     $query->select('*')
            //       ->from('projects')
            //     ->whereRaw('tasks.project_id = projects.project_id AND project_fiscal_year = 2566')
            //   ->GroupBy('reguiar_id');
            //}
            //)
            ->get()
            ->toJson());
        ($json = json_decode($taskconcostgov));
        ($c = $json[0]->c);
        ($coatcons_gov = (float) $c);

        ///////////

        ($taskcostut = DB::table('tasks')
            ->selectRaw('sum( COALESCE(task_cost_gov_utility, 0))

   as d')
            ->whereExists(
                function ($query) {
                    $query->select('*')
                        ->from('projects')
                        ->whereRaw('tasks.project_id = projects.project_id AND project_fiscal_year = 2566')
                        ->GroupBy('reguiar_id');
                }
            )
            ->get()
            ->toJson());
        ($json = json_decode($taskcostut));
        ($d = $json[0]->d);

        ($coats_ut = (float) $d);

        ($taskconcostut = DB::table('taskcons')
            ->selectRaw('sum( COALESCE(taskcon_cost_gov_utility, 0))

as d')
            // ->whereExists(
            //   function ($query) {
            //     $query->select('*')
            //       ->from('projects')
            //     ->whereRaw('tasks.project_id = projects.project_id AND project_fiscal_year = 2566')
            //   ->GroupBy('reguiar_id');
            //}
            //)
            ->get()
            ->toJson());
        ($json = json_decode($taskconcostut));
        ($d = $json[0]->d);
        ($coatcons_ut = (float) $d);

        //($coatstotal = $coats_ut+$coats_ict+$coats_gov)

        ($taskcosttotal = DB::table('tasks')
            ->selectRaw('sum(COALESCE(task_cost_gov_operating, 0)
         + COALESCE(task_cost_gov_investment, 0)
         + COALESCE(task_cost_gov_utility, 0)
         + COALESCE(task_cost_it_operating, 0)
         + COALESCE(task_cost_it_investment, 0)) as a')
            ->whereExists(
                function ($query) {
                    $query->select('*')
                        ->from('projects')
                        ->whereRaw('tasks.project_id = projects.project_id AND project_fiscal_year = 2566')
                        ->GroupBy('reguiar_id');
                }
            )
            ->get()
            ->toJson(JSON_NUMERIC_CHECK));
        ($json = json_decode($taskcosttotal));
        ($a = $json[0]->a);
        ($coats = (float)$a);


        ($taskconcosttotal = DB::table('taskcons')
            ->selectRaw('sum(COALESCE(taskcon_cost_gov_operating, 0)
     + COALESCE(taskcon_cost_gov_investment, 0)
     + COALESCE(taskcon_cost_gov_utility, 0)
     + COALESCE(taskcon_cost_it_operating, 0)
     + COALESCE(taskcon_cost_it_investment, 0)) as a')
            // ->whereExists(
            //   function ($query) {
            //     $query->select('*')
            //       ->from('projects')
            //     ->whereRaw('tasks.project_id = projects.project_id AND project_fiscal_year = 2566')
            //   ->GroupBy('reguiar_id');
            // }
            //)
            ->get()
            ->toJson(JSON_NUMERIC_CHECK));
        ($json = json_decode($taskconcosttotal));
        ($a = $json[0]->a);
        ($coatcons = (float)$a);












        $contracts_pr_budget = DB::table('contracts')
        ->selectRaw('SUM(COALESCE(contract_pr_budget, 0)) AS cp')
        ->get()
        ->toJson(JSON_NUMERIC_CHECK);
        ($json = json_decode($contracts_pr_budget));
        ($cp = $json[0]->cp);
       ($cpr = (float)$cp);


       // ->get()
       // ->toJson(JSON_NUMERIC_CHECK);
       // ($json = json_decode($contracts_pr_budget));
       // ($cp = $json[0]->cp);
     //   ($cpb = (float)$cp);
    // $contracts_pr_budget is now a collection containing a single object
    // with a 'cb' property representing the sum of the contract_pr_budget column
    // If the contracts table is empty, the value of 'cb' will be null
    $contract_peryear_pa_budget = DB::table('contracts')
    ->selectRaw('SUM(COALESCE(contract_peryear_pa_budget, 0)) AS cby')
    ->get()
    ->toJson(JSON_NUMERIC_CHECK);
    ($json = json_decode($contract_peryear_pa_budget));
    ($cby = $json[0]->cby);
   ($cpy = (float)$cby);

    ($contracts_pa_budget = DB::table('contracts')
    ->selectRaw('SUM(COALESCE(contract_pa_budget, 0)) AS cb')
    ->where('contract_fiscal_year', '=', 2566)
    ->get()
    ->toJson(JSON_NUMERIC_CHECK));
    ($json = json_decode($contracts_pa_budget));
    ($cb = $json[0]->cb);
    ($cpa = (float)$cb);










    ($contractsre = DB::table('contracts')
   ->select('contracts.contract_name',
            'contracts.contract_number',
            'contracts.contract_pr_budget',
            'contracts.contract_pa_budget',
            DB::raw('contracts.contract_pr_budget - contracts.contract_pa_budget AS remaining_amount'),
            'contracts.contract_id',
            'contract_has_tasks.contract_id',
            'contract_has_tasks.task_id',
            'tasks.task_id',
            'tasks.project_id',
            'task_cost_gov_operating',
            'task_cost_gov_investment',
            'task_cost_gov_utility',
            'task_cost_it_operating',
            'task_cost_it_investment',
            'projects.project_id',
            'projects.project_name')
   ->join('contract_has_tasks', 'contracts.contract_id', '=', 'contract_has_tasks.contract_id')
   ->join('tasks', 'contract_has_tasks.task_id', '=', 'tasks.task_id')
   ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
   ->where('contracts.contract_fiscal_year', '=', 2566)
   ->where('contracts.contract_pa_budget', '!=', null)
   ->where(DB::raw('contracts.contract_pr_budget - contracts.contract_pa_budget'), '!=', 0)

   ->get()
);

$remaining_amounts = [];

foreach ($contractsre as $contract) {
    $combined_properties = $contract->task_cost_it_operating . ',' . $contract->task_cost_it_investment. ',' . $contract->task_cost_gov_utility. ',' . $contract->remaining_amount;
    $remaining_amounts[] = $combined_properties;
}


      ($remaining_amounts);



($contract_refund_pa_budget =  DB::table('contracts')
    ->selectRaw('SUM(COALESCE(contract_refund_pa_budget, 0)) AS cbr')
    ->where('contract_fiscal_year', '=', 2566)
    ->where('contract_refund_pa_status', '=', 1)
    ->get()
    ->toJson(JSON_NUMERIC_CHECK));
    ($json = json_decode($contract_refund_pa_budget));
    ($cbrr = $json[0]->cbr);
    ($cpre = (float)$cbrr);
















        ($project_bu_fiscal_years = Project::selectRaw('project_fiscal_year as fiscal_year, sum(COALESCE(budget_gov_operating,0) + COALESCE(budget_gov_investment,0) + COALESCE(budget_gov_utility,0) + COALESCE(budget_it_operating,0) + COALESCE(budget_it_investment,0)) as total_budget')

            ->groupBy('project_fiscal_year')
            ->get()

            ->toJson(JSON_NUMERIC_CHECK));






        ($contract_groupby_fiscal_years = Contract::selectRaw('contract_fiscal_year as fiscal_year, count(*) as total')
            ->GroupBy('contract_fiscal_year')
            ->orderBy('contract_fiscal_year', 'desc')
            ->get()
            ->toJson(JSON_NUMERIC_CHECK));


        ($project_groupby_fiscal_years = Project::selectRaw('project_fiscal_year as fiscal_year, count(*) as total')
            ->GroupBy('project_fiscal_year')
            ->orderBy('project_fiscal_year', 'desc')
            ->get()
            ->toJson(JSON_NUMERIC_CHECK));

        $project_groupby_task = Task::selectRaw('project_id as fiscal_year, count(*) as total')
            ->GroupBy('project_id')
            ->orderBy('project_id', 'desc')
            ->get()
            ->toJson(JSON_NUMERIC_CHECK);



        ($project_groupby = Project::selectRaw('reguiar_id as fiscal_year_b,
            sum(COALESCE(budget_gov_operating,0) + COALESCE(budget_gov_investment,0) + COALESCE(budget_gov_utility,0)
            + COALESCE(budget_it_operating,0) + COALESCE(budget_it_investment,0)) as total_budgot')
            ->where('project_fiscal_year', 2566)
            ->GroupBy('reguiar_id')
            ->orderBy('reguiar_id', 'ASC')
            ->get()
            ->toJson(JSON_NUMERIC_CHECK));


        ($taskcosttotals = DB::table('tasks')
            ->selectRaw('reguiar_id as fiscal_year_b,sum(COALESCE(task_cost_gov_operating, 0)
            + COALESCE(task_cost_gov_investment, 0) + COALESCE(task_cost_gov_utility, 0)
            + COALESCE(task_cost_it_operating, 0) + COALESCE(task_cost_it_investment, 0))
             as total_cost')
            ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            ->whereRaw('tasks.project_id = projects.project_id AND project_fiscal_year = 2566')
            ->groupBy('reguiar_id')
            ->get()
            ->toJson(JSON_NUMERIC_CHECK)
        );

       ($taskconcosttotals = DB::table('taskcons')
       ->select(
           DB::raw('reguiar_id as fiscal_year_b,SUM(

               + COALESCE(taskcon_cost_gov_utility, 0)

           ) AS totalcon_cost'),

       )
       ->join('contracts', 'taskcons.contract_id', '=', 'contracts.contract_id')
       ->join('contract_has_tasks', 'contracts.contract_id', '=', 'contract_has_tasks.contract_id')
       ->join('tasks', 'contract_has_tasks.task_id', '=', 'tasks.task_id')
       ->join('projects', 'tasks.project_id', '=', 'projects.project_id')

       ->groupBy('projects.reguiar_id')
       ->get()
       ->toJson(JSON_NUMERIC_CHECK)
);




        // Calculate total budget by fiscal year and reguiar_id
        $project_groupby_reguiar = Project::selectRaw('reguiar_id as fiscal_year_b,
            sum(COALESCE(budget_gov_operating,0) + COALESCE(budget_gov_investment,0) + COALESCE(budget_gov_utility,0)
            + COALESCE(budget_it_operating,0) + COALESCE(budget_it_investment,0)) as total_budget')
            ->where('project_fiscal_year', 2566)
            ->groupBy('reguiar_id')
            ->orderBy('reguiar_id', 'ASC')
            ->get()
            ->toJson(JSON_NUMERIC_CHECK);

        // Calculate total cost by fiscal year and reguiar_id
        $costtotals = DB::table('tasks')
            ->selectRaw('reguiar_id as fiscal_year_b,sum(COALESCE(task_cost_gov_operating, 0)
            + COALESCE(task_cost_gov_investment, 0) + COALESCE(task_cost_gov_utility, 0)
            + COALESCE(task_cost_it_operating, 0) + COALESCE(task_cost_it_investment, 0))
             as total_cost')
            ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            ->where('project_fiscal_year', 2566)
            ->groupBy('reguiar_id')
            ->get()
            ->toJson(JSON_NUMERIC_CHECK);

        // Calculate percentage value for each reguiar_id
        ($taskcosttotals2 = collect(json_decode($costtotals, true))->map(function ($item) use ($project_groupby_reguiar) {
            $total_budget = collect(json_decode($project_groupby_reguiar, true))->where('fiscal_year_b', $item['fiscal_year_b'])->pluck('total_budget')->first();
            $percentage = $total_budget != 0 ? round($item['total_cost'] / $total_budget * 100, 2) : 0;
            return array_merge($item, ['percentage' => $percentage]);
        }));

        // Convert the result to JSON format
        ($taskcosttotals2_json = $taskcosttotals2->toJson(JSON_NUMERIC_CHECK));



        ($totals_ut = $budgetsut - $coats_ut);


        ($totals_budgets = $budgets - $cpr);
        $totals_ict = $budgetscentralict - $coats_ict;
        $totals_inv = $budgetsinvestment - $coats_inv;





        ($total_ut = $budgetsut - $coatcons_ut);
       ($total_budgets = $budgets - $coatcons);
        $total_ict = $budgetscentralict - $coatcons_ict;
        $total_inv = $budgetsinvestment - $coatcons_inv;










        // dd( $taskcost = Task::selectRaw('project_id as fiscal_year,
        // sum(COALESCE(task_cost_gov_operating,0) + COALESCE(task_cost_gov_investment,0) + COALESCE(task_cost_gov_utility,0)
        //+ COALESCE(task_cost_it_operating,0) + COALESCE(task_cost_it_investment,0)) as total')
        //->GroupBy('project_id')
        //->get()->toJson());
        //  $project = Project::get()->toArray();

        $project =  Project::where('project_fiscal_year', 2566)->get();

        ($project = Project::select('projects.*', 'a.cost_disbursement')
        ->leftJoin(DB::raw('(select tasks.project_id, sum(COALESCE(tasks.task_cost_gov_utility,0))
+sum(COALESCE(tasks.task_cost_it_operating,0))+sum(COALESCE(tasks.task_cost_it_investment,0))
as cost_disbursement from tasks  group by tasks.project_id) as a'), 'a.project_id', '=', 'projects.project_id')
       // ->join('tasks', 'tasks.project_id', '=', 'projects.id')
       //->groupBy('projects.project_id')
        //->where('projects.project_id', $id)
        ->where('project_fiscal_year', 2566)
        ->get());



        foreach ($project as $project) {
            ((double) $__budget_gov = (double) $project['budget_gov_operating'] + (double) $project['budget_gov_utility'] + (double) $project['budget_gov_investment']);
            ((double) $__budget_it  = (double) $project['budget_it_operating'] + (double) $project['budget_it_investment']);
            ((double) $__budget    = $__budget_gov + $__budget_it);
            (double) $__cost       = (double) $project['project_cost'];
            (double) $__balance    = $__budget + (double) $project['project_cost'];
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
                'project_cost_disbursement'     => $project['project_cost_disbursemen'],
            'cost_disbursement'     => $project['cost_disbursement'],
                'cost'                  => $project['project_cost'],
                'owner'                 => $project['project_owner'],
                'project_fiscal_year'   => $project['project_fiscal_year'],

            ];
            ($budget['total'] = $__budget);


            ($tasks = DB::table('tasks')
        ->select('tasks.*', 'a.cost_disbursement')
        ->leftJoin(DB::raw('(select tasks.task_parent, sum(COALESCE(tasks.task_cost_gov_utility,0))
           +sum(COALESCE(tasks.task_cost_it_operating,0))+sum(COALESCE(tasks.task_cost_it_investment,0))
           as cost_disbursement from tasks  group by tasks.task_parent) as a'), 'a.task_parent', '=', 'tasks.task_id')
           ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
        ->where('projects.project_fiscal_year', 2566)
        ->get()
        ->toArray());
        $tasks = json_decode(json_encode($tasks), true);
            foreach ($tasks as $task) {
                (double) $__budget_gov = (double) $task['task_budget_gov_operating'] + (double) $task['task_budget_gov_utility'] + (double) $task['task_budget_gov_investment'];
                (double) $__budget_it  = (double) $task['task_budget_it_operating'] + (double) $task['task_budget_it_investment'];
                (double) $__budget     = $__budget_gov + $__budget_it;
                (double) $__cost = array_sum([
                    $task['task_cost_gov_operating'],
                    $task['task_cost_gov_investment'],
                    $task['task_cost_gov_utility'],
                    $task['task_cost_it_operating'],
                    $task['task_cost_it_investment'],
                ]);
                (double) $__balance = $__budget - $__cost;



                $gantt[] = [
                    'id'                    => 'T' . $task['task_id'] . $task['project_id'],
                    'text'                  => $task['task_name'],
                    'start_date'            => date('Y-m-d', strtotime($task['task_start_date'])),
                    'end_date'              => date('Y-m-d', strtotime($task['task_end_date'])),
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
                    'cost'                  => $__cost,
                    'balance'               => $__balance,
                    'cost_disbursement'     => $task['cost_disbursement'],

                    // 'owner' => $project['project_owner'],
                ];



                $__project_cost[] = $__cost;
            }
             //   $gantt[0]['cost']    = array_sum($__project_cost);
           // $gantt[0]['balance'] = $gantt[0]['balance'] - $gantt[0]['cost'];
            //($budget['cost']    = $gantt[0]['cost']);
            //$budget['balance'] = $gantt[0]['balance'];


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

        // dd ($costsum = ($__project_cost))  ;
        $gantt = json_encode($gantt);

        $contractsstart = Contract::all();

        foreach ($contractsstart as $contractdr) {
            $start_date = \Carbon\Carbon::createFromTimestamp($contractdr->contract_start_date);
            $end_date = \Carbon\Carbon::createFromTimestamp($contractdr->contract_end_date);
            ($duration = $end_date->diff($start_date)->days);


            ($duration_p =  \Carbon\Carbon::parse($contractdr->contract_end_date)
                ->diffInMonths(\Carbon\Carbon::parse($contractdr->contract_start_date))
                -  \Carbon\Carbon::parse($contractdr->contract_start_date)
                ->diffInMonths(\Carbon\Carbon::parse()));
            // do something with $duration and $duration_p
            ($contractsstart = Contract::paginate(10));









            return view(
                'app.dashboard.index',
                compact(
                    'contractsre',
                    'taskconcosttotals',
                    'cpy',
                    'cpre',
                    'cpa',
                    'cpr',
                    'contracts_pa_budget',
                    'contracts_pr_budget',
                    'taskcosttotals2_json',
                    'taskcosttotals2',
                    'project_groupby',
                    'duration_p',
                    'contractsstart',

                    'project_type_p',
                    'project_type_j',
                    'totals_budgets',
                    'totals_ict',
                    'totals_inv',
                    'totals_ut',
                    'total_ict',
                    'total_inv',
                    'total_ut',
                    'taskcostict',
                    'taskcostinvestment',
                    'budgetscentralict',
                    'budgetsinvestment',
                    'taskcosttotals',
                    'project_bu_fiscal_years',
                    'coats_inv',
                    'coats_gov',
                    'coats_ict',
                    'coats_ut',
                    'coatcons_inv',
                    'coatcons_gov',
                    'coatcons_ict',
                    'coatcons_ut',
                    'coatcons',
                    'budgetsgov',
                    'budgetsict',
                    'budgetsut',
                    'total_budgets',
                    'coats',
                    'taskcosttotal',
                    '__cost',
                    'budget',
                    'budgets2',
                    'budgets',
                    'gantt',
                    'project_groupby_reguiar',
                    'project_groupby_task',
                    'tasks',
                    'projects_amount',
                    'contracts',
                    'contract_groupby_fiscal_years',
                    'projects',
                    'project_groupby_fiscal_years'
                )
            );
        }
    }
}
