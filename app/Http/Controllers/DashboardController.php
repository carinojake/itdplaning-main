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
use Carbon\Carbon;
use App\Models\Increasedbudget;
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


        $fiscal_years= [];
        $fiscal_year= [];
        $task_pay_xy= [];
        $chart_data_xy= [];
        $chart_data= [];
        $total_budget_cost= [];
        $project= [];
        $itpsa1= [];
        $itpsa2= [];
        $otpsa1= [];
        $parent_sum_cd= []; //task= [];
        $utsc_pay_pa= [];
        $otpsa2= [];
        $ispa= [];
        $isa= [];
        $utsc= [];
        $utpcs= [];
        $ospa= [];
        $osa= [];
        $itpsa= [];
        $utsc_pay= [];
        $contractsre= [];
        //taskconcosttotals= [];
        $cpr= [];
        $cpre= [];
        $cpa= [];
        $cpb= [];
        $contracts_pa_budget= [];
        $contracts_pr_budget= [];
        $taskcosttotals2_json= [];
        $taskcosttotals2= [];
        $project_groupby= [];
        $duration_p= [];
        $contractsstart= [];
        $project_type_p= [];
        $project_type_j= [];
        $totals_budgets= [];
        $totals_ict= [];
        $totals_inv= [];
        $totals_ut= [];
        $total_ict= [];
        $total_inv= [];
        $total_ut= [];
        $taskcostict= [];
        $taskcostinvestment= [];
        $budgetscentralict= [];
        $budgetsinvestment= [];
        $taskcosttotals= [];
        $project_bu_fiscal_years= [];
        $coats_inv= [];
        $coats_gov= [];
        $coats_ict= [];
        $coats_ut= [];
        $coatcons_inv= [];
        $coatcons_gov= [];
        $coatcons_ict= [];
        $coatcons_ut= [];
        $coatcons= [];
        $budgetsgov= [];
        $budgetsict= [];
        $budgetsut= [];
        $total_budgets= [];
        $coats= [];
        $taskcosttotal= [];
        $__cost= [];
        $budget= [];
        $budgets2= [];
        $budgets= [];
        $gantt= [];
        $project_groupby_reguiar= [];
        $project_groupby_task= [];
        $tasks= [];
        $projects_amount= [];
        $contracts= [];
        $contract_groupby_fiscal_years= [];
        $projects= [];
        $project_groupby_fiscal_years=[];




        $fiscal_year = $request->input('fiscal_year');
        if (!$fiscal_year) {
            $fiscal_year = date('Y') + 543; // Use current year if not provided
        }

        $fiscal_years = Project::whereNotNull('project_fiscal_year')->pluck('project_fiscal_year')->unique()->sort()->values();




       // dd($fiscal_years, $fiscal_year);

         (
            $taskcon_pay_sum_1 = DB::table('tasks')
            ->selectRaw("
                DATE_FORMAT((taskcons.taskcon_pay_date) + INTERVAL 543 YEAR, '%b %Y', 'th_TH') AS task_pay_month,
                DATE_FORMAT((taskcons.taskcon_pay_date)+ INTERVAL 543 YEAR, '%m', 'th_TH') AS taskcon_month,
                SUM(COALESCE(taskcons.taskcon_pay, 0)) AS iv,
                SUM(COALESCE(taskcons.taskcon_pay, 0)) AS total_taskcon_pay,

         COALESCE(SUM(taskcons.taskcon_cost_it_operating), 0) AS total_taskcon_cost_it_operating,
         COALESCE(SUM(taskcons.taskcon_cost_it_investment), 0) AS total_taskcon_cost_it_investment,
         COALESCE(SUM(taskcons.taskcon_cost_gov_utility), 0) AS total_costcon_gov_utility
            ")
          ->join('contract_has_tasks', 'tasks.task_id', '=', 'contract_has_tasks.task_id')
            ->join('contracts', 'contract_has_tasks.contract_id', '=', 'contracts.contract_id')
            ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            ->join('taskcons', 'contracts.contract_id', '=', 'taskcons.contract_id')
            //->where('tasks.task_cost_it_operating', '>', 1)
            //->where('tasks.task_type', 1)
            ->whereNull('tasks.deleted_at') // Replacing the original NULL check
            //->where('projects.project_fiscal_year', '=', $fiscal_year)
            ->where('projects.project_fiscal_year', '=', $fiscal_year)
           // ->where('total_taskcon_pay', '>', 1)
            ->groupBy('task_pay_month','taskcon_month')
            ->having('total_taskcon_pay', '>', 1)
            ->orderByRaw(Helper::budget_fiscal_year($fiscal_year))
            //->toSql()
            ->get()
           //->toJson(JSON_NUMERIC_CHECK)
    );










        ($taskcon_pay_sum_1);
        ($task_pay_xy  =
        DB::table('tasks')
            ->selectRaw("


        DATE_FORMAT((tasks.task_pay_date)+ INTERVAL 543 YEAR, '%b %Y', 'th_TH') AS task_pay_month,

        DATE_FORMAT((tasks.task_pay_date)+ INTERVAL 543 YEAR, '%m', 'th_TH') AS task_month,



        COALESCE(SUM(tasks.task_pay), 0)AS total_cost,

         COALESCE(SUM(tasks.task_cost_it_operating), 0) AS total_task_cost_it_operating,
         COALESCE(SUM(tasks.task_cost_it_investment), 0) AS total_task_cost_it_investment,
         COALESCE(SUM(tasks.task_cost_gov_utility), 0) AS total_cost_gov_utility



         ")

// DATE_FORMAT((taskcons.taskcon_pay_date)+ INTERVAL 543 YEAR, '%m', 'th_TH') AS taskcon_month,
         //->leftJoin(DB::raw("($taskcon_pay_sum_1 )"), 'taskcon_pay_sum_1.task_month', '=', 'tasks.task_month')

         ->leftJoin('contract_has_tasks', 'tasks.task_id', '=', 'contract_has_tasks.task_id')
         ->leftJoin('contracts', 'contract_has_tasks.contract_id', '=', 'contracts.contract_id')
         ->leftJoin('taskcons', 'contracts.contract_id', '=', 'taskcons.contract_id')
         ->leftJoin('projects', 'tasks.project_id', '=', 'projects.project_id')


            ->where('projects.project_fiscal_year', '=', $fiscal_year)
           // ->where('total_cost', '>', 1)
            ->where('tasks.deleted_at', NULL)
            ->having('total_cost', '>', 1)
            ->whereNotNull('tasks.task_pay_date')
            ->groupBy('task_pay_month','task_month')
            ->orderByRaw(Helper::budget_fiscal_year($fiscal_year))
            ->get()
           // ->toJson(JSON_NUMERIC_CHECK)
        );

       //dd($task_pay_xy,$taskcon_pay_sum_1);
        // Convert the chart data to an array

        $mergedCollection = $task_pay_xy->map(function($item) use ($taskcon_pay_sum_1) {
            // Find the corresponding item in $taskcon_pay_sum_1 based on 'taskcon_month'
            $correspondingItem = $taskcon_pay_sum_1->firstWhere('taskcon_month', $item->task_month);

            // Find the corresponding item in $taskcon_pay_sum_1 based on 'total_taskcon_pay'
            $correspondingItem2 = $taskcon_pay_sum_1->firstWhere('total_taskcon_pay', $item->total_taskcon_pay ?? null);

            // Find the corresponding item in $taskcon_pay_sum_1 based on 'total_cost'
            $correspondingItem3 = $taskcon_pay_sum_1->firstWhere('total_cost', $item->total_cost ?? null);

            // Initialize 'total_cost_pay' to zero
           // $total_cost_pay = 0;

            // If a corresponding item is found based on 'taskcon_month', merge the two items
            if ($correspondingItem) {
                $merged = (object) array_merge((array) $item, (array) $correspondingItem);
                $total_cost_pay = ($merged->total_taskcon_pay ?? 0) + ($merged->total_cost ?? 0);
                $merged->total_cost_pay = $total_cost_pay;
                return $merged;
            }

            // If no corresponding item is found, set 'total_cost_pay' to the sum of 'total_taskcon_pay' and 'total_cost'
            $total_cost_pay = ($item->total_taskcon_pay ?? 0) + ($item->total_cost ?? 0);

            // Add the 'total_cost_pay' field to the original item and return it
            $item->total_cost_pay = $total_cost_pay;
            return $item;
        });

       // dd($mergedCollection);


        $jsonMergedCollection = $mergedCollection->toJson(JSON_NUMERIC_CHECK);


      //  dd($jsonMergedCollection);
        // Now, $mergedCollection contains the merged data.
       // dd($mergedCollection);

        ($chart_data = $task_pay_xy);

        // Convert the chart data to JSON

      //  dd($mergedCollection->toJson(JSON_NUMERIC_CHECK));

       // dd($mergedCollection);
       ($chart_data_xy = ($jsonMergedCollection));

       // ($chart_data_xy = ($chart_data));


        ($contracts = Contract::where('contract_fiscal_year', $fiscal_year)->count());
        $projects  = Project::where('project_fiscal_year', $fiscal_year)->count();
        ($project_type_j  = Project::where('project_type', 'J')->where('project_fiscal_year', $fiscal_year)->count());
        ($project_type_p  = Project::where('project_type', 'P')->where('project_fiscal_year', $fiscal_year)->count());


        // $rebuts = contract::count($contract->taskcont);

        $tasks = Task::count();


        //  $tasksum = Task::with('project')->whereHas('project', function($query) {
        //    $query->where('project_fiscal_year', 2566);
        //})->count();


        $projects_amount = Project::count();

        ($budgets   = Project::where('project_fiscal_year', $fiscal_year)->sum(DB::raw('COALESCE(budget_gov_operating,0) + COALESCE(budget_gov_investment,0) + COALESCE(budget_gov_utility,0) + COALESCE(budget_it_operating,0) + COALESCE(budget_it_investment,0)')));
        $budgets2   = Project::where('project_fiscal_year', $fiscal_year)->sum(DB::raw('COALESCE(budget_gov_operating,0) + COALESCE(budget_gov_investment,0) + COALESCE(budget_gov_utility,0) + COALESCE(budget_it_operating,0) + COALESCE(budget_it_investment,0)'));
        ($budgetsgov =  Project::where('project_fiscal_year', $fiscal_year)->sum(DB::raw('COALESCE(budget_gov_operating,0) + COALESCE(budget_gov_investment,0)')));
        ($budgetsict = Project::where('project_fiscal_year', $fiscal_year)->sum(DB::raw('COALESCE(budget_it_operating,0) + COALESCE(budget_it_investment,0)')));

        ($budgetscentralict = Project::where('project_fiscal_year', $fiscal_year)->sum(DB::raw('COALESCE(budget_it_operating,0)')));
        ($budgetsinvestment = Project::where('project_fiscal_year', $fiscal_year)->sum(DB::raw('COALESCE(budget_it_investment,0)')));
        ($budgetsut  = Project::where('project_fiscal_year', $fiscal_year)->sum(DB::raw('COALESCE(budget_gov_utility,0)	')));
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
            ->where('tasks.deleted_at', NULL)
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
            ->where('tasks.deleted_at', NULL)
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
            ->where('tasks.deleted_at', NULL)
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
            ->where('tasks.deleted_at', NULL)
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

        //($coatstotal = $coats_ut+$coats_ict+$coats_gov) 3122266
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
            ->where('tasks.deleted_at', NULL)
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
            ->where('taskcons.deleted_at', NULL)
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
        ($cpb = (float)$cp);


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
        ($cpr = (float)$cby);

        ($contracts_pa_budget = DB::table('contracts')
            ->selectRaw('SUM(COALESCE(contract_pa_budget, 0)) AS cb')
            ->where('contract_fiscal_year', '=',  $fiscal_year)
            ->get()
            ->toJson(JSON_NUMERIC_CHECK));
        ($json = json_decode($contracts_pa_budget));
        ($cb = $json[0]->cb);
        ($cpa = (float)$cb);
        ($contractsre = DB::table('contracts')
            ->select(
                'contracts.contract_name',
                'contracts.contract_number',
                'contracts.contract_pr_budget',
                'contracts.contract_pa_budget',
                DB::raw('contracts.contract_pr_budget - contracts.contract_pa_budget AS remaining_amount'),
                'contracts.contract_id',
                'contract_has_tasks.contract_id',
                'contract_has_tasks.task_id',
                'tasks.task_id',
                'tasks.project_id',
                'projects.project_id',
                'projects.project_name'
            )
            ->join('contract_has_tasks', 'contracts.contract_id', '=', 'contract_has_tasks.contract_id')
            ->join('tasks', 'contract_has_tasks.task_id', '=', 'tasks.task_id')
            ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            ->where('tasks.deleted_at', NULL)
            ->where('contracts.deleted_at', NULL)
            ->where('contracts.contract_fiscal_year', '=',  $fiscal_year)
            ->where('contracts.contract_pa_budget', '!=', null)
            ->where(DB::raw('contracts.contract_pr_budget - contracts.contract_pa_budget'), '!=', 0)

            ->get()
        );

        //$remaining_amounts = [];

        //foreach ($contractsre as $contract) {
        //  $combined_properties = $contract->task_cost_it_operating . ',' . $contract->task_cost_it_investment. ',' . $contract->task_cost_gov_utility. ',' . $contract->remaining_amount;
        //$remaining_amounts[] = $combined_properties;
        //}


        //    ($remaining_amounts);   ->where('project_fiscal_year',  $fiscal_year)




        ($contract_refund_pa_budget =  DB::table('contracts')
            ->selectRaw('SUM(COALESCE(contract_refund_pa_budget, 0)) AS cbr')
            ->where('contract_fiscal_year', '=',  $fiscal_year)
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
            ->where('contracts.deleted_at', NULL)
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
           // ->where('project_fiscal_year', 2566)
            ->where('project_fiscal_year',  $fiscal_year)

            ->GroupBy('reguiar_id')
            ->orderBy('reguiar_id', 'ASC')
            ->get()
            ->toJson(JSON_NUMERIC_CHECK));


        ($taskcosttotals = DB::table('tasks')
            ->selectRaw('reguiar_id as fiscal_year_b


            ,sum(COALESCE(task_cost_gov_operating, 0)
            + COALESCE(task_cost_gov_investment, 0) + COALESCE(task_cost_gov_utility, 0)
            + COALESCE(task_cost_it_operating, 0) + COALESCE(task_cost_it_investment, 0))
             as total_cost')
            ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            ->where('tasks.deleted_at', NULL)
           // ->whereRaw('tasks.project_id = projects.project_id AND project_fiscal_year = 2566')
            ->where('project_fiscal_year',  $fiscal_year)

            ->groupBy('reguiar_id')
            ->get()
            ->toJson(JSON_NUMERIC_CHECK)
        );


        ($total_budget_cost = DB::table('tasks')
            ->selectRaw('


        sum(COALESCE(task_budget_gov_utility, 0)
        + COALESCE(task_budget_it_operating, 0) + COALESCE(task_budget_it_investment, 0))
         as total_task_budget,

         sum(COALESCE(task_cost_gov_operating, 0)
         + COALESCE(task_cost_gov_investment, 0) + COALESCE(task_cost_gov_utility, 0)
         + COALESCE(task_cost_it_operating, 0) + COALESCE(task_cost_it_investment, 0))
          as total_task_cost



       ')
            ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            ->where('tasks.deleted_at', NULL)
           // ->whereRaw('project_fiscal_year = 2566')
           ->where('project_fiscal_year',  $fiscal_year)

           ->groupBy('project_fiscal_year')
            ->get()
            ->toJson(JSON_NUMERIC_CHECK)
        );



    /*     ($taskconcosttotals = DB::table('taskcons')
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
        ); */




        // Calculate total budget by fiscal year and reguiar_id
        $project_groupby_reguiar = Project::selectRaw('reguiar_id as fiscal_year_b,
            sum(COALESCE(budget_gov_operating,0) + COALESCE(budget_gov_investment,0) + COALESCE(budget_gov_utility,0)
            + COALESCE(budget_it_operating,0) + COALESCE(budget_it_investment,0)) as total_budget')
            ->where('project_fiscal_year',  $fiscal_year)

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
            ->where('tasks.deleted_at', NULL)
            ->where('project_fiscal_year',  $fiscal_year)
            ->groupBy('reguiar_id')
            ->get()
            ->toJson(JSON_NUMERIC_CHECK);

        // Calculate percentage value for each reguiar_id    ->where('projects.project_fiscal_year', '=', $fiscal_year)
        ($taskcosttotals2 = collect(json_decode($costtotals, true))->map(function ($item) use ($project_groupby_reguiar) {
            $total_budget = collect(json_decode($project_groupby_reguiar, true))->where('fiscal_year_b', $item['fiscal_year_b'])->pluck('total_budget')->first();
            $percentage = $total_budget != 0 ? round($item['total_cost'] / $total_budget * 100, 2) : 0;
            return array_merge($item, ['percentage' => $percentage]);
        }));

        // Convert the result to JSON format
        ($taskcosttotals2_json = $taskcosttotals2->toJson(JSON_NUMERIC_CHECK));



        ($totals_ut = $budgetsut - $coats_ut);


        ($totals_budgets = $budgets - $cpb);
        $totals_ict = $budgetscentralict - $coats_ict;
        $totals_inv = $budgetsinvestment - $coats_inv;





        ($total_ut = $budgetsut - $coatcons_ut);
        ($total_budgets = $budgets - $coatcons);
        $total_ict = $budgetscentralict - $coatcons_ict;
        $total_inv = $budgetsinvestment - $coatcons_inv;

        ($task_pay_xy = Task::select(DB::raw("tasks.task_pay, DATE_FORMAT(tasks.task_pay_date, '%M') AS task_pay_month, tasks.task_id, tasks.project_id, tasks.task_name, tasks.task_description, tasks.task_parent, tasks.task_pay_date, tasks.task_start_date, tasks.task_end_date, projects.project_id, projects.reguiar_id, projects.project_status_during_year"))
            ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            ->whereNotNull('tasks.task_pay')
            ->where('tasks.deleted_at', NULL)
            ->where('projects.project_fiscal_year', '=', $fiscal_year)
            ->orderByRaw("CASE task_pay_month WHEN 'January' THEN 1 WHEN 'February' THEN 2 WHEN 'March' THEN 3 WHEN 'April' THEN 4 WHEN 'May' THEN 5 WHEN 'June' THEN 6 WHEN 'July' THEN 7 WHEN 'August' THEN 8 WHEN 'September' THEN 9 WHEN 'October' THEN 10 WHEN 'November' THEN 11 WHEN 'December' THEN 12 END")
            ->get()
            ->toArray()

        );








        // Query ดึงข้อมูลโปรเจคและคำนวณค่าใช้จ่ายและการจ่ายเงิน
        ($project = Project::select('projects.*','a.total_task_budget', 'a.total_task_refund_pa_budget',
        'a.total_cost', 'a.tta', 'a.ttb', 'a.total_pay',
        'a.total_task_mm_budget', 'ab.cost_pa_1', 'ac.cost_no_pa_2',
        'ad.total_taskcon_pay_con','ae.total_task_refund_pa_budget_3')

        ->leftJoin(
            DB::raw('(select tasks.project_id,

            sum(COALESCE(tasks.task_budget_gov_utility,0))
            +sum(COALESCE(tasks.task_budget_it_operating,0))
            +sum(COALESCE(tasks.task_budget_it_investment,0)) as total_task_budget ,

                sum(COALESCE(tasks.task_cost_gov_utility,0))
                +sum(COALESCE(tasks.task_cost_it_operating,0))
                +sum(COALESCE(tasks.task_cost_it_investment,0)) as total_cost ,
                sum(COALESCE(tasks.task_mm_budget,0))  as total_task_mm_budget,
                sum(COALESCE(tasks.task_refund_pa_budget,0)) as total_task_refund_pa_budget,
                sum(COALESCE(tasks.task_pay,0)) as total_pay,
                sum(COALESCE(tasks.task_mm_budget,0))- sum(COALESCE(tasks.task_cost_gov_utility,0))
                +sum(COALESCE(tasks.task_cost_it_operating,0))
                +sum(COALESCE(tasks.task_cost_it_investment,0)) as tta,
                CASE
                WHEN sum(COALESCE(tasks.task_cost_gov_utility,0)) = 0 THEN  sum(COALESCE(tasks.task_mm_budget,0))
                WHEN sum(COALESCE(tasks.task_cost_gov_utility,0)) > 1 THEN sum( COALESCE(tasks.task_pay,0))
                ELSE 0
                END as ttb
                from tasks
                where tasks.deleted_at IS NULL
                group by tasks.project_id
            ) as a'),
            'a.project_id',
            '=',
            'projects.project_id'
        )
        ->leftJoin(
            DB::raw('(select tasks.project_id,
                sum(COALESCE(tasks.task_cost_gov_utility,0))
                +sum(COALESCE(tasks.task_cost_it_operating,0))
                +sum(COALESCE(tasks.task_cost_it_investment,0)) as cost_pa_1 ,
                sum( COALESCE(tasks.task_mm_budget,0))  as total_task_mm_budget,
                sum( COALESCE(tasks.task_pay,0)) as total_pay
                from tasks
                where tasks.task_type = 1 AND tasks.deleted_at IS NULL
                group by tasks.project_id
            ) as ab'),
            'ab.project_id',
            '=',
            'projects.project_id'
        )
        ->leftJoin(
            DB::raw('(select tasks.project_id,
                sum(COALESCE(tasks.task_cost_gov_utility,0))
                +sum(COALESCE(tasks.task_cost_it_operating,0))
                +sum(COALESCE(tasks.task_cost_it_investment,0)) as cost_no_pa_2 ,
                sum( COALESCE(tasks.task_mm_budget,0))  as total_task_mm_budget,
                sum( COALESCE(tasks.task_pay,0)) as total_pay
                from tasks
                where tasks.task_type = 2 AND tasks.deleted_at IS NULL
                group by tasks.project_id
            ) as ac'),
            'ac.project_id',
            '=',
            'projects.project_id'
        )
        ->leftJoin(
            DB::raw('(select tasks.project_id,
                sum( COALESCE(tasks.task_mm_budget,0))  as total_task_mm_budget,
                sum( COALESCE(tasks.task_pay,0)) as total_pay,
                sum( COALESCE(taskcons.taskcon_pay,0)) as total_taskcon_pay_con
                from tasks
                INNER JOIN contract_has_tasks
                ON tasks.task_id = contract_has_tasks.task_id
                INNER JOIN contracts
                ON contract_has_tasks.contract_id = contracts.contract_id
                INNER JOIN taskcons
                ON contracts.contract_id = taskcons.contract_id
                where tasks.task_type = 1 AND tasks.deleted_at IS NULL
                group by tasks.project_id
            ) as ad'),
            'ad.project_id',
            '=',
            'projects.project_id'
        )
        ->leftJoin(
            DB::raw('(select tasks.project_id,

                 sum(COALESCE(tasks.task_refund_pa_budget,0)) as total_task_refund_pa_budget_3

                from tasks
                LEFT JOIN contract_has_tasks
                ON tasks.task_id = contract_has_tasks.task_id
                LEFT JOIN contracts
                ON contract_has_tasks.contract_id = contracts.contract_id
                LEFT JOIN taskcons
                ON contracts.contract_id = taskcons.contract_id

                where  tasks.task_refund_pa_status = 3 AND tasks.deleted_at IS NULL

                group by tasks.project_id
            ) as ae'), // Changed the alias from `as` to `ae`
            'ae.project_id',
            '=',
            'projects.project_id'
        )

        /* ->leftJoin(
                DB::raw('(select tasks.project_id,
                 sum(COALESCE(tasks.task_cost_gov_utility,0))
           +sum(COALESCE(tasks.task_cost_it_operating,0))
           +sum(COALESCE(tasks.task_cost_it_investment,0)) as total_cost ,
           sum( COALESCE(tasks.task_pay,0)) as total_pay
            from tasks   where tasks.deleted_at IS NULL group by tasks.project_id) as a'),
                'a.project_id',
                '=',
                'projects.project_id'
            )

            ->leftJoin(
                DB::raw('(select tasks.project_id,
                sum(COALESCE(tasks.task_cost_gov_utility,0))
           +sum(COALESCE(tasks.task_cost_it_operating,0))
           +sum(COALESCE(tasks.task_cost_it_investment,0)) as cost_pa_1 ,
           sum( COALESCE(tasks.task_pay,0)) as total_pay
           from tasks  where tasks.task_type=1  AND tasks.deleted_at IS NULL  group by tasks.project_id) as ab'),
                'ab.project_id',
                '=',
                'projects.project_id'
            )

            ->leftJoin(
                DB::raw('(select tasks.project_id,
           sum(COALESCE(tasks.task_cost_gov_utility,0))
           +sum(COALESCE(tasks.task_cost_it_operating,0))
           +sum(COALESCE(tasks.task_cost_it_investment,0))as cost_no_pa_2 ,
           sum( COALESCE(tasks.task_pay,0)) as total_pay
           from tasks  where tasks.task_type=2 AND tasks.deleted_at IS NULL group by tasks.project_id) as ac'),
                'ac.project_id',
                '=',
                'projects.project_id'
            )

            // ->join('tasks', 'tasks.project_id', '=', 'projects.id')
            //->groupBy('projects.project_id')
            ->where('project_fiscal_year', $fiscal_year) */

            ->get()
            ->toArray());
       // dd($project = ($project));

        // คำนวณค่าเงินเบิกจ่ายทั้งหมดของโปรเจกต์





        foreach ($project as $project) {
            ((float) $__budget_gov = (float) $project['budget_gov_operating'] + (float) $project['budget_gov_utility'] + (float) $project['budget_gov_investment']);
            ((float) $__budget_it  = (float) $project['budget_it_operating'] + (float) $project['budget_it_investment']);
            ((float) $__budget    = $__budget_gov + $__budget_it);
            (float) $__cost       = (float) $project['project_cost'];
            (float) $__balance    = $__budget + (float) $project['project_cost'];
            ((float) $__total_task_budget       = (float) $project['total_task_budget']);
            ((float) $__mm       = (float) $project['total_task_mm_budget']);
            ((float) $__paycon       = (float) $project['total_taskcon_pay_con']);
            ((float) $__prmm       = (float) $project['total_task_refund_pa_budget']);
            ((float) $__total_task_refund_pa_budget_3       = (float) $project['total_task_refund_pa_budget_3']);

            ((float) $__balance    = $__budget + (float) $project['project_cost']);




            $__project_cost     = [];

        $gantt[] = [
            'id'                    => $project['project_id'],
            'text'                  => $project['project_name'],
            'start_date'            => date('Y-m-d', $project['project_start_date']),
            'p'                  => $project['project_type'],
            'end_date' => date('Y-m-d', $project['project_end_date']),
            'budget_gov_operating'  => $project['budget_gov_operating'],
            'budget_gov_investment' => $project['budget_gov_investment'],
            'budget_gov_utility'    => $project['budget_gov_utility'],
            'budget_gov'            => $__budget_gov,
            'budget_it_operating'   => str_replace(',', '', $project['budget_it_operating']),
            'budget_it_investment'  => $project['budget_it_investment'],
            'budget_it'             => $__budget_it,
            'budget'                => $__budget,
            'balance'               => $__balance,
            'pbalance'               => $__balance,
           // 'project_cost_disbursement'     => $project['project_cost_disbursemen'],
            'total_cost'                => $project['total_cost'],
            'cost'                  => $project['project_cost'],
            'cost_pa_1'             => $project['cost_pa_1'],
            'cost_no_pa_2'             => $project['cost_no_pa_2'],
           // 'cost_disbursement'     => $project['cost_disbursement'],
          //  'pay'                   => $project['pay'],
            'total_pay'              => $project['total_pay']+$__paycon,
            'total_task_budget'      => $__total_task_budget,
            'total_taskcon_pay_con'  => $__paycon,
           // 'budget_mm'             => $project['task_mm_budget'],
            'refund_pa_budget'      => $__prmm,
            'refund_pa_budget_end'  => $__total_task_refund_pa_budget_3 ,
            'budget_total_mm'             => $__mm,
            //'budget_total_pr_sum'  =>   $__balance_pr_sum,
            'owner'                 => $project['project_owner'],
            'open'                  => true,
            'type'                  => 'project',
            // 'duration'              => 360,
        ];
         /*    $gantt[] = [
                'id'                    => $project['project_id'],
                'text'                  => $project['project_name'],
                'start_date' => date('Y-m-d', ($project['project_start_date'])),
                'end_date' => date('Y-m-d', ($project['project_end_date'])),
                'project_type'                  => $project['project_type'],

                'budget_gov_operating'  => $project['budget_gov_operating'],
                'budget_gov_investment' => $project['budget_gov_investment'],
                'budget_gov_utility'    => $project['budget_gov_utility'],
                'budget_gov'            => $__budget_gov,
                'budget_it_operating'   => $project['budget_it_operating'],
                'budget_it_investment'  => $project['budget_it_investment'],
                //  'project_cost_disbursement'     => $project['project_cost_disbursemen'],
                // 'cost_disbursement'     => $project['cost_disbursement'],
                'budget_it'             => $__budget_it,
                'budget'                => $__budget,
                'balance'               => $__balance,
                'pbalance'               => $__balance,
                //  'cost_disbursement'     => $project['cost_disbursement'],
                'cost'                  => $project['project_cost'],
                'owner'                 => $project['project_owner'],
                'project_fiscal_year'   => $project['project_fiscal_year'],


                //  'open'                  => true,
                //  'type'                  => 'project',

                'total_cost'                => $project['total_cost'],

                'cost_pa_1'             => $project['cost_pa_1'],
                'cost_no_pa_2'             => $project['cost_no_pa_2'],
                //'cost_disbursement'     => $project['cost_disbursement'],

                // 'pay'                   => $project['pay'],
                'total_pay'              => $project['total_pay'],


            ]; */


            ($budget['total'] = $__budget);


            //      ($tasks = DB::table('tasks')
            //      ->select('tasks.*', 'a.cost_disbursement','a.total_pay','ab.cost_pa_1','ac.cost_no_pa_2')
            //      ->leftJoin(DB::raw('(select tasks.task_parent,
            //      sum( COALESCE(tasks.task_cost_gov_utility,0))
            //      +sum( COALESCE(tasks.task_cost_it_operating,0))
            //         +sum( COALESCE(tasks.task_cost_it_investment,0))
            //        as cost_disbursement,
            //       sum( COALESCE(tasks.task_pay,0))  as total_pay
            //        from tasks  group by tasks.task_parent) as a'),
            //         'a.task_parent', '=', 'tasks.task_id')
            //
            //          ->leftJoin(DB::raw('(select tasks.task_parent,
            //            sum(COALESCE(tasks.task_cost_gov_utility,0))
            //            +sum(COALESCE(tasks.task_cost_it_operating,0))
            //            +sum(COALESCE(tasks.task_cost_it_investment,0))
            //            as cost_pa_1 ,
            //            sum( COALESCE(tasks.task_pay,0)) as total_pay
            //            from tasks
            //            where tasks.task_type=1 group by tasks.task_parent) as ab'),
            //         'ab.task_parent', '=', 'tasks.task_id')
            //
            //
            //          ->leftJoin(DB::raw('(select tasks.task_parent,
            //         sum(COALESCE(tasks.task_cost_gov_utility,0))
            //      +sum(COALESCE(tasks.task_cost_it_operating,0))
            //      +sum(COALESCE(tasks.task_cost_it_investment,0))
            //         as cost_no_pa_2 ,sum( COALESCE(tasks.task_pay,0))
            //         as total_pay
            //          from tasks  where tasks.task_type=2 group by tasks.task_parent) as ac'),
            //         'ac.task_parent', '=', 'tasks.task_id')
            //   ->where('project_id',($id))
            //    ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            //  ->where('project_fiscal_year', 2566)

            //   ->get()
            // ->toArray());
            //      ($tasks = json_decode(json_encode($tasks), true));


            //         foreach ($tasks as $task) {
            //             ($task);
            //             (double) $__budget_gov = (double) $task['task_budget_gov_operating'] + (double) $task['task_budget_gov_utility'] + (double) $task['task_budget_gov_investment'];
            //             (double) $__budget_it  = (double) $task['task_budget_it_operating'] + (double) $task['task_budget_it_investment'];
            //              (double) $__budget     = $__budget_gov + $__budget_it;
            //              (double) $__cost = array_sum([
            //                  (double)$task['cost_disbursement'],
            //                  $task['task_cost_gov_operating'],
            //                  $task['task_cost_gov_investment'],
            //                  $task['task_cost_gov_utility'],
            //                  $task['task_cost_it_operating'],
            //                  $task['task_cost_it_investment'],
            //              ]);
            //            (double) $__balance = $__budget - $__cost;



            //          $gantt[] = [
            //                'id'                    => 'T' . $task['task_id'] . $task['project_id'],
            //                'text'                  => $task['task_name'],
            //'start_date'            => date('Y-m-d', $task['task_start_date']),
            //'end_date'              => date('Y-m-d', $task['task_end_date']),
            //                'parent'                => $task['task_parent'] ? 'T' . $task['task_parent'] . $task['project_id'] : $task['project_id'],
            //                'task_type'                  => 'task',
            //                'open'                  => true,
            //                'task_budget_gov_operating'  => $task['task_budget_gov_operating'],
            //                'task_budget_gov_investment' => $task['task_budget_gov_investment'],
            //                'task_budget_gov_utility'    => $task['task_budget_gov_utility'],
            //                'task_budget_gov'            => $__budget_gov,
            //                'task_budget_it_operating'   => $task['task_budget_it_operating'],
            //                'task_budget_it_investment'  => $task['task_budget_it_investment'],
            //                 'task_budget_it'             => $__budget_it,
            //                'task_budget'                => $__budget,
            //                'task_cost'                  => $__cost,
            //                'task_balance'               => $__balance,
            //                  'task_cost_disbursement'     => $task['cost_disbursement'],
            //                   'task_pay'                   => $task['task_pay'],
            //
            //                   'task_total_pay'             => $task['total_pay'],
            //                    'task_task_type'             => $task['task_type'],
            //
            //                  'task_cost_pa_1'             => $task['cost_pa_1'],
            //                'task_cost_no_pa_2'             => $task['cost_no_pa_2'],
            //  'cost_disbursement'     => $project['cost_disbursement'],


            // 'owner' => $project['project_owner'],
            //          ];



            //          $__project_cost[] = $__cost;
            //    }
            //    $gantt[0]['cost']    = array_sum($__project_cost);

            $gantt[0]['balance'] = $gantt[0]['balance'] - $gantt[0]['total_cost'];
            ($budget['cost']    = $gantt[0]['total_cost']);
            $budget['balance'] = $gantt[0]['balance'];




            $labels = [
                'project' => 'โครงการ/งานประจำ',
                'budget' => 'งบประมาณ',
                'budget_it_operating' => 'งบกลาง ICT',
                'budget_it_investment' => 'งบดำเนินงาน',
                'budget_gov_utility' => 'งบสาธารณูปโภค',
            ];

            $fields = [
                'cost' => 'ค่าใช้จ่าย',
                'cost_pa_1' => 'PA',
                'cost_no_pa_2' => 'ไม่มี PA',
                'task_pay' => 'การเบิกจ่าย',

            ];
        }




        $parent_sum_pa = DB::table('tasks')
            ->select('tasks.task_parent', 'a.cost_a')

            ->leftJoin(DB::raw('(select tasks.task_parent, sum( COALESCE(tasks.task_cost_it_investment,0)+ COALESCE(tasks.task_cost_it_operating,0)+ COALESCE(tasks.task_budget_gov_utility,0)) as cost_a from tasks where tasks.task_parent is not null group by tasks.task_parent) as a'), 'tasks.task_parent', '=', 'tasks.task_id')
            ->where('tasks.deleted_at', NULL)
            ->whereNotNull('tasks.task_parent')

            ->get();



        ($gantt);
        // dd ($costsum = ($__project_cost))  ;
        ($gantt = json_encode($gantt));

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
        }


            ($operating_pay_sum_1 = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_pay,0))+sum(COALESCE(taskcons.taskcon_pay,0)) as iv,
            SUM(COALESCE(task_pay,0)) as total_task_pay ,
            sum(COALESCE(taskcons.taskcon_pay,0)) as total_taskcon_pay')
            ->join('contract_has_tasks', 'tasks.task_id', '=', 'contract_has_tasks.task_id')
            ->join('contracts', 'contract_has_tasks.contract_id', '=', 'contracts.contract_id')
            ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            ->join('taskcons', 'contracts.contract_id', '=', 'taskcons.contract_id')
            ->where('tasks.task_cost_it_operating', '>', 1)
            ->where('tasks.task_type', 1)
            ->where('tasks.deleted_at', NULL)
             ->where('projects.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at'))
                ->where('project_fiscal_year',  $fiscal_year)
                ->get());
            ($json = json_decode($operating_pay_sum_1));
            ($otpsa1 = $json[0]->iv);
            ($otpsa1 = (float)$otpsa1);



           /*  $operating_taskcon_pay_sum_1 = DB::table('taskcons')
                ->selectRaw('SUM(COALESCE(taskcon_pay, 0)) as iv')
                ->leftJoin('contracts', 'contracts.contract_id', '=', 'taskcons.contract_id')
                ->leftJoin('contract_has_tasks', 'contract_has_tasks.contract_id', '=', 'contracts.contract_id')
                ->leftJoin('tasks', 'tasks.task_id', '=', 'contract_has_tasks.task_id')
                ->leftJoin('projects', 'projects.project_id', '=', 'tasks.project_id')
                ->where('taskcons.taskcon_cost_it_operating', '>', 1)
                ->where('taskcons.taskcon_type', 1)
                ->where('projects.project_fiscal_year', $fiscal_year)
                ->get();

            $json = json_decode($operating_taskcon_pay_sum_1);
            $otpsataskcon1 = $json[0]->iv;
            ($otpsataskcon1 = (float) $otpsataskcon1); */



            ($operating_pay_sum_2 = DB::table('tasks')
                ->selectRaw('SUM(COALESCE(task_pay,0)) as iv2')
                ->where('tasks.task_cost_it_operating', '>', 2)
                ->where('tasks.task_type', 2)
                ->where('projects.deleted_at', NULL)
                ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
                ->where('tasks.deleted_at', NULL)
                ->where('project_fiscal_year',  $fiscal_year)
                ->get());
            ($json = json_decode($operating_pay_sum_2));
            ($otpsa2 = $json[0]->iv2);
            ($otpsa2 = (float)$otpsa2);

           /*  $operating_taskcon_pay_sum_2 = DB::table('taskcons')
                ->selectRaw('SUM(COALESCE(taskcon_pay, 0)) as iv')
                ->leftJoin('contracts', 'contracts.contract_id', '=', 'taskcons.contract_id')
                ->leftJoin('contract_has_tasks', 'contract_has_tasks.contract_id', '=', 'contracts.contract_id')
                ->leftJoin('tasks', 'tasks.task_id', '=', 'contract_has_tasks.task_id')
                ->leftJoin('projects', 'projects.project_id', '=', 'tasks.project_id')
                ->where('taskcons.taskcon_cost_it_operating', '>', 2)
                ->where('taskcons.taskcon_type', 2)
                ->where('projects.project_fiscal_year', $fiscal_year)
                ->get();

            $json = json_decode($operating_taskcon_pay_sum_2);
            $otpsataskcon2 = $json[0]->iv;
            ($otpsataskcon2 = (float) $otpsataskcon2);
 */











            ($operating_pa_sum = DB::table('tasks')
                ->selectRaw('SUM(COALESCE(task_cost_it_operating,0)) As ospa')
                //->where('tasks.task_type', 1)
                ->where('tasks.task_type', 1)
                ->where('projects.deleted_at', NULL)
                ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
                ->where('tasks.deleted_at', NULL)
                ->where('project_fiscal_year',  $fiscal_year)

                ->get());
            ($json = json_decode($operating_pa_sum));
            ($ospa = $json[0]->ospa);
            ($ospa = (float)$ospa);

            ($operating_sum = DB::table('tasks')
                ->selectRaw('SUM(COALESCE(task_cost_it_operating,0)) As osa')
                //->where('tasks.task_type', 1)
                ->where('tasks.task_type', 2)
                ->where('projects.deleted_at', NULL)
                ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
                ->where('tasks.deleted_at', NULL)
                ->where('project_fiscal_year',  $fiscal_year)
                ->get());
            ($json = json_decode($operating_sum));
            ($osa = $json[0]->osa);
            ($osa = (float)$osa);

          //  dd($osa,$ospa );







            ($investment_pa_sum = DB::table('tasks')
                ->selectRaw('SUM(COALESCE(task_cost_it_investment,0)) As ispa')
                ->where('tasks.task_type', 1)
                ->where('projects.deleted_at', NULL)
                ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
                ->where('project_fiscal_year',  $fiscal_year)
                ->where('tasks.deleted_at', NULL)
                ->get());
            ($json = json_decode($investment_pa_sum));
            ($ispa = $json[0]->ispa);
            ($ispa = (float)$ispa);

            ($investment_sum = DB::table('tasks')
                ->selectRaw('SUM(COALESCE(task_cost_it_investment,0)) As isa')
                ->where('tasks.task_type', 2)
                ->where('projects.deleted_at', NULL)
                ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
                ->where('project_fiscal_year',  $fiscal_year)
                ->where('tasks.deleted_at', NULL)
                ->get());
            ($json = json_decode($investment_sum));
            ($isa = $json[0]->isa);
            ($isa = (float)$isa);

            ($investment_total_pay_sum = DB::table('tasks')
                ->selectRaw('SUM(COALESCE(task_pay,0)) as iv')
                ->where('tasks.task_budget_gov_investment')
                ->where('projects.deleted_at', NULL)
                ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
                ->where('project_fiscal_year',  $fiscal_year)
                ->where('tasks.deleted_at', NULL)
                ->get());
            ($json = json_decode($investment_total_pay_sum));
            ($itpsa = $json[0]->iv);
            ($itpsa = (float)$itpsa);



         /*    ($investment_total_pay_sum = DB::table('taskcons')
                ->selectRaw('SUM(COALESCE(taskcon_pay,0)) as iv')
                ->leftJoin('contracts', 'contracts.contract_id', '=', 'taskcons.contract_id')
                ->leftJoin('contract_has_tasks', 'contract_has_tasks.contract_id', '=', 'contracts.contract_id')
                ->leftJoin('tasks', 'tasks.task_id', '=', 'contract_has_tasks.task_id')
                ->leftJoin('projects', 'projects.project_id', '=', 'tasks.project_id')
                ->where('taskcons.taskcon_budget_gov_investment')

                //  ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
                ->where('project_fiscal_year',  $fiscal_year)
                ->get());
            ($json = json_decode($investment_total_pay_sum));
            ($itpsa = $json[0]->iv);
            ($itpsa = (float)$itpsa);
 */
            /*   ->selectRaw('SUM(COALESCE(taskcon_pay, 0)) as iv')
        ->leftJoin('contracts', 'contracts.contract_id', '=', 'taskcons.contract_id')
        ->leftJoin('contract_has_tasks', 'contract_has_tasks.contract_id', '=', 'contracts.contract_id')
        ->leftJoin('tasks', 'tasks.task_id', '=', 'contract_has_tasks.task_id')
        ->leftJoin('projects', 'projects.project_id', '=', 'tasks.project_id')
        ->where('taskcons.taskcon_cost_it_operating', '>', 2)
        ->where('taskcons.taskcon_type', 2)
        ->where('projects.project_fiscal_year', $fiscal_year)
        ->get();
 */







 ($investment_pay_sum_1 = DB::table('tasks')


 ->selectRaw('SUM(COALESCE(task_pay,0))+sum(COALESCE(taskcons.taskcon_pay,0)) as iv,
 SUM(COALESCE(task_pay,0)) as total_task_pay ,
 sum(COALESCE(taskcons.taskcon_pay,0)) as total_taskcon_pay')
 ->join('contract_has_tasks', 'tasks.task_id', '=', 'contract_has_tasks.task_id')
 ->join('contracts', 'contract_has_tasks.contract_id', '=', 'contracts.contract_id')
 ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
 ->join('taskcons', 'contracts.contract_id', '=', 'taskcons.contract_id')





 ->where('tasks.task_cost_it_investment', '>', 1)
 ->where('tasks.task_type', 1)
  ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
// เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
                ->where('project_fiscal_year',  $fiscal_year)
                ->get());
            ($json = json_decode($investment_pay_sum_1));
            ($itpsa1 = $json[0]->iv);
            ($itpsa1 = (float)$itpsa1);

            ($investment_pay_sum_2 = DB::table('tasks')
                ->selectRaw('SUM(COALESCE(task_pay,0)) as iv')
                ->where('tasks.task_cost_it_investment', '>', 1)
                ->where('tasks.task_type', 2)
                ->where('projects.deleted_at', NULL)
                ->where('tasks.deleted_at', NULL)
                ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
                ->where('project_fiscal_year',  $fiscal_year)
                ->get());
            ($json = json_decode($investment_pay_sum_2));
            ($itpsa2 = $json[0]->iv);
            ($itpsa2 = (float)$itpsa2);



            ($ut_pa_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_cost_gov_utility,0)) As utpcs')
            ->where('tasks.task_type',1)

             ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
             ->where('projects.deleted_at', NULL)
             ->where('tasks.deleted_at', NULL)
             ->where('project_fiscal_year',  $fiscal_year)
            ->get());
            ($json = json_decode($ut_pa_sum));
            ($utpcs = $json[0]->utpcs);
           ($utpcs = (float)$utpcs);



           ($ut_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_cost_gov_utility,0)) As utsc')
            ->where('tasks.task_type',2)

            ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            ->where('projects.deleted_at', NULL)
            ->where('project_fiscal_year',  $fiscal_year)
            ->get());
            ($json = json_decode($ut_sum));
            ($utsc = $json[0]->utsc);
             ($utsc = (float)$utsc);



             ($ut_pay_sum = DB::table('tasks')
             ->selectRaw('SUM(COALESCE(task_pay,0)) As utsc_pay')
             ->where('tasks.task_cost_gov_utility', '>', 1)

             ->where('tasks.task_type',2)


             ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
             ->where('project_fiscal_year',  $fiscal_year)
             ->where('projects.deleted_at', NULL)

             ->where('tasks.deleted_at', NULL)
             ->get());
             ($json = json_decode($ut_pay_sum));
             ($utsc_pay = $json[0]->utsc_pay);
         ($utsc_pay = (float)$utsc_pay);





               ($ut_pay_pa_sum = DB::table('tasks')
               ->selectRaw('SUM(COALESCE(task_pay,0))+sum(COALESCE(taskcons.taskcon_pay,0)) as iv,
               SUM(COALESCE(task_pay,0)) as utsc_pay_pa ,
               sum(COALESCE(taskcons.taskcon_pay,0)) as total_taskcon_pay')
               ->join('contract_has_tasks', 'tasks.task_id', '=', 'contract_has_tasks.task_id')
               ->join('contracts', 'contract_has_tasks.contract_id', '=', 'contracts.contract_id')
               ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
               ->join('taskcons', 'contracts.contract_id', '=', 'taskcons.contract_id')





      ->where('tasks.task_cost_gov_utility', '>', 1)
      ->where('tasks.task_type',1)
      ->where('projects.deleted_at', NULL)
      ->where('tasks.deleted_at', NULL)


             ->where('project_fiscal_year',  $fiscal_year)
      ->get());
      ($json = json_decode($ut_pay_pa_sum));
      ($utsc_pay_pa = $json[0]->iv);
       ($utsc_pay_pa = (float)$utsc_pay_pa);


            $parent_sum_pa = DB::table('tasks')
                ->select('tasks.task_parent', 'a.cost_a')

                ->leftJoin(DB::raw('(select tasks.task_parent, sum( COALESCE(tasks.task_cost_it_investment,0)+ COALESCE(tasks.task_cost_it_operating,0)+ COALESCE(tasks.task_budget_gov_utility,0)) as cost_a from tasks where tasks.task_parent is not null group by tasks.task_parent) as a'), 'tasks.task_parent', '=', 'tasks.task_id')
                ->where('tasks.deleted_at', NULL)
                ->whereNotNull('tasks.task_parent')

                ->get();

            ($parent_sum_pa);


            ($parent_sum_cd = DB::table('tasks')
                ->select('task_parent', DB::raw('sum(task_pay) as cost_app'))
                ->where('tasks.deleted_at', NULL)
                ->whereNotNull('task_parent')
                ->groupBy('task_parent')
                ->get()
            );







            ($total_expenses = (($osa) + ($isa) + ($utsc)));;

            $increasedbudgetData = DB::table('increasedbudgets')
            ->join('projects', 'increasedbudgets.project_id', '=', 'projects.project_id')
            ->select('increasedbudgets.*')
           // ->where('project_id', $id)
            ->where('increasedbudgets.deleted_at', NULL)

         //   ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            ->where('project_fiscal_year',  $fiscal_year)
            ->orderBy('projects.project_fiscal_year', 'DESC')
            ->get();
           // dd($increasedbudgetData);

            $increasedbudget_sum_budget_it_operating =  $increasedbudgetData->sum('increased_budget_it_operating');
            $increasedbudget_sum_budget_it_investment =  $increasedbudgetData->sum('increased_budget_it_investment');
            $increasedbudget_sum_budget_gov_utility =  $increasedbudgetData->sum('increased_budget_gov_utility');
            $increasedbudget_sum = $increasedbudget_sum_budget_it_operating + $increasedbudget_sum_budget_it_investment + $increasedbudget_sum_budget_gov_utility;

            $increaseData['increasedbudget_sum'] = $increasedbudget_sum;
            $increaseData['increasedbudget_sum_budget_it_operating'] = $increasedbudget_sum_budget_it_operating;
            $increaseData['increasedbudget_sum_budget_it_investment'] = $increasedbudget_sum_budget_it_investment;
            $increaseData['increasedbudget_sum_budget_gov_utility'] = $increasedbudget_sum_budget_gov_utility;


           //dd($increaseData);

// คัดเลือก tasks ที่เป็นในไตรมาสที่ 2 และปี 2566



          /*   // First, let's get all tasks  $mergedCollection;

            $tasks = DB::table('tasks')->select('tasks.*')->get();


            $mergedCollection;
           // dd($mergedCollection);
            $tasksInQ2 = $mergedCollection->filter(function ($task) use ($fiscal_year) {
                $year = intval(substr($task->task_pay_month, -4)); // ตัดปีออกมาจาก task_pay_month
                $month = intval($task->task_month); // ใช้ task_month ที่เป็นตัวเลข
                return $year == $fiscal_year && in_array($month, [1, 2, 3]); // มกราคม, กุมภาพันธ์, มีนาคม
            });
            //dd($tasksInQ2);
            $summary = [
                'งบกลาง ICT' => $tasksInQ2->sum('total_task_cost_it_operating'),
                'งบดำเนินงาน' => $tasksInQ2->sum('total_task_cost_it_investment'),
                'งบสาธารณูปโภค' => $tasksInQ2->sum('total_cost_gov_utility'),
            ];

            $summary['รวมทั้งหมดในไตรมาสที่ 2'] = array_sum($summary);

            dd($summary,$mergedCollection,$tasksInQ2);; */

 return view (
                'app.dashboard.index',
                compact(
                    'increaseData',
                    'taskcon_pay_sum_1',
                    'fiscal_years',
                    'fiscal_year',
                    'task_pay_xy',
                    'chart_data_xy',
                    'chart_data',
                    'total_budget_cost',
                    'project',
                    'itpsa1',
                    'itpsa2',
                    'otpsa1',
                    'parent_sum_cd', //'task',
                    'utsc_pay_pa',
                    'otpsa2',
                    'ispa',
                    'isa',
                    'utsc',
                    'utpcs',
                    'ospa',
                    'osa',
                    'itpsa',
                    'utsc_pay',
                    'contractsre',
                    //'taskconcosttotals',
                    'cpr',
                    'cpre',
                    'cpa',
                    'cpb',
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


    public function gantt(Request $request)
    {

        $gantt= [];
        $fiscal_year = $request->input('fiscal_year');
        if (!$fiscal_year) {
            $fiscal_year = date('Y') + 543; // Use current year if not provided
        }

        $fiscal_years = Project::whereNotNull('project_fiscal_year')->pluck('project_fiscal_year')->unique()->sort()->values();


        // Query ดึงข้อมูลโปรเจคและคำนวณค่าใช้จ่ายและการจ่ายเงิน
      /*   ($project = Project::select('projects.*', 'a.total_cost', 'a.total_pay', 'ab.cost_pa_1', 'ac.cost_no_pa_2')

            ->leftJoin(
                DB::raw('(select tasks.project_id,
         sum(COALESCE(tasks.task_cost_gov_utility,0))
   +sum(COALESCE(tasks.task_cost_it_operating,0))
   +sum(COALESCE(tasks.task_cost_it_investment,0)) as total_cost ,
   sum( COALESCE(tasks.task_pay,0)) as total_pay
    from tasks
    where tasks.deleted_at IS NULL

    group by tasks.project_id) as a'),
                'a.project_id',
                '=',
                'projects.project_id'
            )

            ->leftJoin(
                DB::raw('(select tasks.project_id,
        sum(COALESCE(tasks.task_cost_gov_utility,0))
   +sum(COALESCE(tasks.task_cost_it_operating,0))
   +sum(COALESCE(tasks.task_cost_it_investment,0)) as cost_pa_1 ,
   sum( COALESCE(tasks.task_pay,0)) as total_pay
   from tasks  where tasks.task_type=1  AND tasks.deleted_at IS NULL


   group by tasks.project_id) as ab'),
                'ab.project_id',
                '=',
                'projects.project_id'
            )

            ->leftJoin(
                DB::raw('(select tasks.project_id,
   sum(COALESCE(tasks.task_cost_gov_utility,0))
   +sum(COALESCE(tasks.task_cost_it_operating,0))
   +sum(COALESCE(tasks.task_cost_it_investment,0))as cost_no_pa_2 ,
   sum( COALESCE(tasks.task_pay,0)) as total_pay
   from tasks  where tasks.task_type=2  AND tasks.deleted_at IS NULL

   group by tasks.project_id) as ac'),
                'ac.project_id',
                '=',
                'projects.project_id'
            ) */

            // ->join('tasks', 'tasks.project_id', '=', 'projects.id')
            //->groupBy('projects.project_id')


           // Query ดึงข้อมูลโปรเจคและคำนวณค่าใช้จ่ายและการจ่ายเงิน
      /*      $id_projects = Project::select('project_id')
           ->where('project_fiscal_year', $fiscal_year)
           ->get();

       foreach ($id_projects as $project) {
           // echo สมมติว่าคุณมีเมธอดหรือคุณสมบัติในโมเดล Project ที่สร้าง hashid
           $gantt[] = [
              // 'id'                    => $project['project_id'],
               'projects_id' => $project->hashid, // หรือใช้เมธอดของ Hashids ถ้ามี

           ];
       } */

      // dd($gantt);


        ($project = Project::select(
            'projects.*','a.total_task_budget', 'a.total_task_refund_pa_budget',
            'a.total_cost', 'a.tta', 'a.ttb', 'a.total_pay',
            'a.total_task_mm_budget', 'ab.cost_pa_1', 'ac.cost_no_pa_2',
            'ad.total_taskcon_pay_con','ae.total_task_refund_pa_budget_3',
            'a_increasedbudgets.total_task_budget_increasedbudgets'
        )

//
            ->leftJoin( // คำนวณงบประมาณทั้งหมดของโปรเจกต์
                DB::raw('(select increasedbudgets.project_id,
                sum(COALESCE(increasedbudgets.increased_budget_gov_utility,0))
                +sum(COALESCE(increasedbudgets.increased_budget_it_operating,0))
                +sum(COALESCE(increasedbudgets.increased_budget_it_investment,0)) as total_task_budget_increasedbudgets
                from increasedbudgets
                where increasedbudgets.deleted_at IS NULL
                group by increasedbudgets.project_id)
                as a_increasedbudgets'),
                'a_increasedbudgets.project_id',
                '=',
                'projects.project_id'
            )

        ->leftJoin(
            DB::raw('(select tasks.project_id,

            sum(COALESCE(tasks.task_budget_gov_utility,0))
            +sum(COALESCE(tasks.task_budget_it_operating,0))
            +sum(COALESCE(tasks.task_budget_it_investment,0)) as total_task_budget ,

                sum(COALESCE(tasks.task_cost_gov_utility,0))
                +sum(COALESCE(tasks.task_cost_it_operating,0))
                +sum(COALESCE(tasks.task_cost_it_investment,0)) as total_cost ,
                sum(COALESCE(tasks.task_mm_budget,0))  as total_task_mm_budget,
                sum(COALESCE(tasks.task_refund_pa_budget,0)) as total_task_refund_pa_budget,
                sum(COALESCE(tasks.task_pay,0)) as total_pay,
                sum(COALESCE(tasks.task_mm_budget,0))- sum(COALESCE(tasks.task_cost_gov_utility,0))
                +sum(COALESCE(tasks.task_cost_it_operating,0))
                +sum(COALESCE(tasks.task_cost_it_investment,0)) as tta,
                CASE
                WHEN sum(COALESCE(tasks.task_cost_gov_utility,0)) = 0 THEN  sum(COALESCE(tasks.task_mm_budget,0))
                WHEN sum(COALESCE(tasks.task_cost_gov_utility,0)) > 1 THEN sum( COALESCE(tasks.task_pay,0))
                ELSE 0
                END as ttb
                from tasks
                where tasks.deleted_at IS NULL
                group by tasks.project_id
            ) as a'),
            'a.project_id',
            '=',
            'projects.project_id'
        )
        ->leftJoin(
            DB::raw('(select tasks.project_id,
                sum(COALESCE(tasks.task_cost_gov_utility,0))
                +sum(COALESCE(tasks.task_cost_it_operating,0))
                +sum(COALESCE(tasks.task_cost_it_investment,0)) as cost_pa_1 ,
                sum( COALESCE(tasks.task_mm_budget,0))  as total_task_mm_budget,
                sum( COALESCE(tasks.task_pay,0)) as total_pay
                from tasks
                where tasks.task_type = 1 AND tasks.deleted_at IS NULL
                group by tasks.project_id
            ) as ab'),
            'ab.project_id',
            '=',
            'projects.project_id'
        )
        ->leftJoin(
            DB::raw('(select tasks.project_id,
                sum(COALESCE(tasks.task_cost_gov_utility,0))
                +sum(COALESCE(tasks.task_cost_it_operating,0))
                +sum(COALESCE(tasks.task_cost_it_investment,0)) as cost_no_pa_2 ,
                sum( COALESCE(tasks.task_mm_budget,0))  as total_task_mm_budget,
                sum( COALESCE(tasks.task_pay,0)) as total_pay
                from tasks
                where tasks.task_type = 2 AND tasks.deleted_at IS NULL
                group by tasks.project_id
            ) as ac'),
            'ac.project_id',
            '=',
            'projects.project_id'
        )
        ->leftJoin(
            DB::raw('(select tasks.project_id,
                sum( COALESCE(tasks.task_mm_budget,0))  as total_task_mm_budget,
                sum( COALESCE(tasks.task_pay,0)) as total_pay,
                sum( COALESCE(taskcons.taskcon_pay,0)) as total_taskcon_pay_con
                from tasks
                INNER JOIN contract_has_tasks
                ON tasks.task_id = contract_has_tasks.task_id
                INNER JOIN contracts
                ON contract_has_tasks.contract_id = contracts.contract_id
                INNER JOIN taskcons
                ON contracts.contract_id = taskcons.contract_id
                where tasks.task_type = 1 AND tasks.deleted_at IS NULL AND taskcons.deleted_at IS NULL
                group by tasks.project_id
            ) as ad'),
            'ad.project_id',
            '=',
            'projects.project_id'
        )
        ->leftJoin(
            DB::raw('(select tasks.project_id,

                 sum(COALESCE(tasks.task_refund_pa_budget,0)) as total_task_refund_pa_budget_3

                from tasks
                LEFT JOIN contract_has_tasks
                ON tasks.task_id = contract_has_tasks.task_id
                LEFT JOIN contracts
                ON contract_has_tasks.contract_id = contracts.contract_id
                LEFT JOIN taskcons
                ON contracts.contract_id = taskcons.contract_id

                where  tasks.task_refund_pa_status = 3 AND tasks.deleted_at IS NULL

                group by tasks.project_id
            ) as ae'), // Changed the alias from `as` to `ae`
            'ae.project_id',
            '=',
            'projects.project_id'
        )


            ->where('project_fiscal_year', $fiscal_year)

            ->get()
            //->toArray()
        );


        //  dd($project = ($project));

        // คำนวณค่าเงินเบิกจ่ายทั้งหมดของโปรเจกต์



        /* // Create an empty object to store your URLs
        $projectViewUrls = [];

        // Let's say you have your projects data in a variable called `projects`
        foreach($projects as $project)
            // Add a new property to the projectViewUrls object with the hashid as the key and the URL as the value
            projectViewUrls["{{ $project->hashid }}"] = "{{ route('project.view', $project->hashid) }}";
        endforeach */





        foreach ($project as $project) {
            ((float) $__budget_gov = (float) $project['budget_gov_operating'] + (float) $project['budget_gov_utility'] + (float) $project['budget_gov_investment']);
            ((float) $__budget_it  = (float) $project['budget_it_operating'] + (float) $project['budget_it_investment']);
            ((float) $__budget_total_task_budget_increasedbudgets  = (float) $project['total_task_budget_increasedbudgets']);





            (float) $__budget     = $__budget_gov + $__budget_it;
            ((float) $__cost       = (float) $project['project_cost']);
            ((float) $__total_task_budget       = (float) $project['total_task_budget']);
            ((float) $__mm       = (float) $project['total_task_mm_budget']);
            ((float) $__paycon       = (float) $project['total_taskcon_pay_con']);
            ((float) $__prmm       = (float) $project['total_task_refund_pa_budget']);
            ((float) $__total_task_refund_pa_budget_3       = (float) $project['total_task_refund_pa_budget_3']);






            ((float) $__balance    = $__budget + (float) $project['project_cost']);




            $__project_cost     = [];
            $gantt[] = [
                'id'                    => $project['project_id'],
      // ... other attributes
      'hashid' => $project->hashid,
      'projectViewUrls' => route('project.view', ['project' => $project->hashid]),
      // ... other attributes
                'text'                  => $project['project_name'],
                'start_date' =>     date('Y-m-d', ($project['project_start_date'])),
                'end_date' =>       date('Y-m-d', ($project['project_end_date'])),
                'project_type'                  => $project['project_type'],

                'budget_gov_operating'  => $project['budget_gov_operating'],
                'budget_gov_investment' => $project['budget_gov_investment'],
                'budget_gov_utility'    => $project['budget_gov_utility'],
                'budget_gov'            => $__budget_gov,
                'budget_it_operating'   => $project['budget_it_operating'],
                'budget_it_investment'  => $project['budget_it_investment'],
                //  'project_cost_disbursement'     => $project['project_cost_disbursemen'],
                // 'cost_disbursement'     => $project['cost_disbursement'],
                'budget_it'             => $__budget_it,
                'budget'                => $__budget+ $__budget_total_task_budget_increasedbudgets,
                'balance'               => $__balance,
                'pbalance'               => $__balance,
                //  'cost_disbursement'     => $project['cost_disbursement'],
                'cost'                  => $project['project_cost'],
                'owner'                 => $project['project_owner'],
                'project_fiscal_year'   => $project['project_fiscal_year'],


                //  'open'                  => true,
                //  'type'                  => 'project',

                'total_cost'                => $project['total_cost'],

                'cost_pa_1'             => $project['cost_pa_1'],
                'cost_no_pa_2'             => $project['cost_no_pa_2'],
                //'cost_disbursement'     => $project['cost_disbursement'],


               // 'pay'                   => $project['pay'],
                'total_pay'              => $project['total_pay'],
                'total_pay_paycon'              => $project['total_pay']+$__paycon,
                'total_task_budget'      => $__total_task_budget,
                'total_taskcon_pay_con'  => $__paycon,
                //'budget_mm'             => $project['task_mm_budget'],
                'refund_pa_budget'      => $__prmm,
                'refund_pa_budget_end'  => $__total_task_refund_pa_budget_3 ,
                'budget_total_mm'             => $__mm,
                // 'pay'                   => $project['pay'],

                'open'                  => true,
                'type'                  => 'project',


            ];


            ($budget['total'] = $__budget);


            //      ($tasks = DB::table('tasks')
            //      ->select('tasks.*', 'a.cost_disbursement','a.total_pay','ab.cost_pa_1','ac.cost_no_pa_2')
            //      ->leftJoin(DB::raw('(select tasks.task_parent,
            //      sum( COALESCE(tasks.task_cost_gov_utility,0))
            //      +sum( COALESCE(tasks.task_cost_it_operating,0))
            //         +sum( COALESCE(tasks.task_cost_it_investment,0))
            //        as cost_disbursement,
            //       sum( COALESCE(tasks.task_pay,0))  as total_pay
            //        from tasks  group by tasks.task_parent) as a'),
            //         'a.task_parent', '=', 'tasks.task_id')
            //
            //          ->leftJoin(DB::raw('(select tasks.task_parent,
            //            sum(COALESCE(tasks.task_cost_gov_utility,0))
            //            +sum(COALESCE(tasks.task_cost_it_operating,0))
            //            +sum(COALESCE(tasks.task_cost_it_investment,0))
            //            as cost_pa_1 ,
            //            sum( COALESCE(tasks.task_pay,0)) as total_pay
            //            from tasks
            //            where tasks.task_type=1 group by tasks.task_parent) as ab'),
            //         'ab.task_parent', '=', 'tasks.task_id')
            //
            //
            //          ->leftJoin(DB::raw('(select tasks.task_parent,
            //         sum(COALESCE(tasks.task_cost_gov_utility,0))
            //      +sum(COALESCE(tasks.task_cost_it_operating,0))
            //      +sum(COALESCE(tasks.task_cost_it_investment,0))
            //         as cost_no_pa_2 ,sum( COALESCE(tasks.task_pay,0))
            //         as total_pay
            //          from tasks  where tasks.task_type=2 group by tasks.task_parent) as ac'),
            //         'ac.task_parent', '=', 'tasks.task_id')
            //   ->where('project_id',($id))
            //    ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            //  ->where('project_fiscal_year', 2566)

            //   ->get()
            // ->toArray());
            //      ($tasks = json_decode(json_encode($tasks), true));


            //         foreach ($tasks as $task) {
            //             ($task);
            //             (double) $__budget_gov = (double) $task['task_budget_gov_operating'] + (double) $task['task_budget_gov_utility'] + (double) $task['task_budget_gov_investment'];
            //             (double) $__budget_it  = (double) $task['task_budget_it_operating'] + (double) $task['task_budget_it_investment'];
            //              (double) $__budget     = $__budget_gov + $__budget_it;
            //              (double) $__cost = array_sum([
            //                  (double)$task['cost_disbursement'],
            //                  $task['task_cost_gov_operating'],
            //                  $task['task_cost_gov_investment'],
            //                  $task['task_cost_gov_utility'],
            //                  $task['task_cost_it_operating'],
            //                  $task['task_cost_it_investment'],
            //              ]);
            //            (double) $__balance = $__budget - $__cost;



            //          $gantt[] = [
            //                'id'                    => 'T' . $task['task_id'] . $task['project_id'],
            //                'text'                  => $task['task_name'],
            //'start_date'            => date('Y-m-d', $task['task_start_date']),
            //'end_date'              => date('Y-m-d', $task['task_end_date']),
            //                'parent'                => $task['task_parent'] ? 'T' . $task['task_parent'] . $task['project_id'] : $task['project_id'],
            //                'task_type'                  => 'task',
            //                'open'                  => true,
            //                'task_budget_gov_operating'  => $task['task_budget_gov_operating'],
            //                'task_budget_gov_investment' => $task['task_budget_gov_investment'],
            //                'task_budget_gov_utility'    => $task['task_budget_gov_utility'],
            //                'task_budget_gov'            => $__budget_gov,
            //                'task_budget_it_operating'   => $task['task_budget_it_operating'],
            //                'task_budget_it_investment'  => $task['task_budget_it_investment'],
            //                 'task_budget_it'             => $__budget_it,
            //                'task_budget'                => $__budget,
            //                'task_cost'                  => $__cost,
            //                'task_balance'               => $__balance,
            //                  'task_cost_disbursement'     => $task['cost_disbursement'],
            //                   'task_pay'                   => $task['task_pay'],
            //
            //                   'task_total_pay'             => $task['total_pay'],
            //                    'task_task_type'             => $task['task_type'],
            //
            //                  'task_cost_pa_1'             => $task['cost_pa_1'],
            //                'task_cost_no_pa_2'             => $task['cost_no_pa_2'],
            //  'cost_disbursement'     => $project['cost_disbursement'],


            // 'owner' => $project['project_owner'],
            //          ];



            //          $__project_cost[] = $__cost;
            //    }
            //    $gantt[0]['cost']    = array_sum($__project_cost);

            $gantt[0]['balance'] = $gantt[0]['balance'] - $gantt[0]['total_cost'];
            ($budget['cost']    = $gantt[0]['total_cost']);
            $budget['balance'] = $gantt[0]['balance'];




            $labels = [
                'project' => 'โครงการ/งานประจำ',
                'budget' => 'งบประมาณ',
                'budget_it_operating' => 'งบกลาง ICT',
                'budget_it_investment' => 'งบดำเนินงาน',
                'budget_gov_utility' => 'งบสาธารณูปโภค',
            ];

            $fields = [
                'cost' => 'ค่าใช้จ่าย',
                'cost_pa_1' => 'PA',
                'cost_no_pa_2' => 'ไม่มี PA',
                'task_pay' => 'การเบิกจ่าย',

            ];
        }


      //dd($gantt);
        // dd ($costsum = ($__project_cost))  ;
     /*    ($gantt = json_encode($gantt));
        ($id = Hashids::decode($project));
        dd($id = $id[0]); */

       //($id = Hashids::decode($project));
        $id_tasks = Task::select('task_id')
            ->whereNull('tasks.task_parent')->whereNull('tasks.deleted_at')->get()->pluck('task_id');



            ($gantt = json_encode($gantt));
   // dd($gantt);


            return view(
            'app.dashboard.gantt',


            compact(
                'fiscal_year',
                    'fiscal_years',
                'gantt',

            )
        );
    }
}
