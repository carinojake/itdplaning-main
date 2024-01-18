<?php

namespace App\Http\Controllers;

use App\Libraries\Helper;
use App\Models\Contract;
use App\Models\ContractHasTask;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\DB;

class PdfController extends Controller
{
    public function index()
    {
        return view('app.pdf.index');
    }

    public function ex1()
    {
        $title = 'ทะเบียนสัญญา ปีงบประมาณ 2566 2566';
        $contract = Contract::where('contract_fiscal_year', 2566)->get();
        $pdf = Pdf::loadView('app.pdf.ex1', [
            'title' => $title,
            'contract' => $contract
        ]);
        $pdf->setPaper('A3', 'landscape');
        $pdf->setOption('enable_php', true);

        return $pdf->stream();
    }


    public function ex2()
    {
        DB::statement('SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,"ONLY_FULL_GROUP_BY",""));');
        DB::statement('SET SESSION sql_mode=@@global.sql_mode;');
        $year_q = '2566';
        $title = 'รายงานประจำปี ';

        ($budgetscentralict = Project::where('project_fiscal_year', 2566) ->where('deleted_at', '=', null)->sum(DB::raw('COALESCE(budget_gov_operating,0) + COALESCE(budget_it_operating,0)')));
        ($budgetsinvestment = Project::where('project_fiscal_year', 2566) ->where('deleted_at', '=', null)->sum(DB::raw('COALESCE(budget_gov_investment,0) + COALESCE(budget_it_investment,0)')));
        ($budgetsut  = Project::where('project_fiscal_year', 2566) ->where('deleted_at', '=', null)->sum(DB::raw('COALESCE(budget_gov_utility,0)	')));




       // dd($budgetscentralict,$budgetsinvestment,$budgetsut);
       $projects = DB::table('projects')
       ->select(
           'project_id as id',
           'project_type',
           'project_name as name',
           'reguiar_id as reguiar_id',
           'project_fiscal_year as year',
           DB::raw('sum(COALESCE(budget_gov_operating,0) + COALESCE(budget_gov_investment,0) + COALESCE(budget_gov_utility,0)
            + COALESCE(budget_it_operating,0) + COALESCE(budget_it_investment,0)) as total_budgot')
       )
       ->where('project_fiscal_year', '=', 2566)
       ->groupBy('project_id', 'project_name', 'reguiar_id', 'project_fiscal_year')
       ->where('deleted_at', '=', null)
       ->orderBy('project_type', 'asc')
       ->orderBy('reguiar_id', 'asc')
       ->get();
      // dd($projects);




      $taskcosttotals = DB::table('tasks')
      ->selectRaw('reguiar_id as reguiar_id, sum(COALESCE(task_cost_gov_operating, 0)
      + COALESCE(task_cost_gov_investment, 0) + COALESCE(task_cost_gov_utility, 0)
      + COALESCE(task_cost_it_operating, 0) + COALESCE(task_cost_it_investment, 0))
       as total_cost, sum(COALESCE(task_pay, 0)) as total_pay'
       )
      ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
      ->whereRaw('tasks.project_id = projects.project_id AND project_fiscal_year = 2566')
      ->whereRaw('(' . Helper::budget_fiscal_quarter($year_q) . ' = 1 OR ' . Helper::budget_fiscal_quarter($year_q) . ' = 2 OR ' . Helper::budget_fiscal_quarter($year_q) . ' = 3 OR ' . Helper::budget_fiscal_quarter($year_q) . ' = 4)')
      ->whereNull('tasks.deleted_at')
      ->groupBy('reguiar_id')
      ->get();




      dd($taskcosttotals);






/*
        ($project_data = $projects->toArray());
        ($taskcost_data = $taskcosttotals->toArray());

        ($combined_data = array_combine(array_column($project_data, 'total_budgot'), array_column($taskcost_data, 'total_cost')));
 */


        $pdf = Pdf::loadView('app.pdf.ex2', [
            'title' => $title,
            'project' => $projects,
            'taskcosttotals'  => $taskcosttotals,
            'combined_data'  => $combined_data,
            'budgetscentralict' => $budgetscentralict,
            'budgetsinvestment' => $budgetsinvestment,
            'budgetsut' => $budgetsut,

            'year_q' => $year_q,
        ]);
        $pdf->setPaper('A4', 'landscape');
        $pdf->setOption('enable_php', true);
        return $pdf->stream();
    }


    public function ex3()
    {

        $title = 'My PDF Report';
        ($project =  Project::where('project_fiscal_year', 2566)->get());
        foreach ($project as $projects) {
            ((int) $__budget_gov = (int) $projects['budget_gov_operating'] + (int) $projects['budget_gov_utility'] + (int) $projects['budget_gov_investment']);
            ((int) $__budget_it  = (int) $projects['budget_it_operating'] + (int) $projects['budget_it_investment']);
            ((int) $__budget    = $__budget_gov + $__budget_it);
            (int) $__cost       = (int) $projects['project_cost'];
            (int) $__balance    = $__budget + (int) $projects['project_cost'];
            $__project_cost     = [];
            ($gantt[] = [
                'id'                    => $projects['project_id'],
                'text'                  => $projects['project_name'],
                'start_date'            => date('Y-m-d', $projects['project_start_date']),
                'end_date'              => date('Y-m-d', $projects['project_end_date']),
                'budget_gov_operating'  => $projects['budget_gov_operating'],
                'budget_gov_investment' => $projects['budget_gov_investment'],
                'budget_gov_utility'    => $projects['budget_gov_utility'],
                'budget_gov'            => $__budget_gov,
                'budget_it_operating'   => $projects['budget_it_operating'],
                'budget_it_investment'  => $projects['budget_it_investment'],
                'budget_it'             => $__budget_it,
                'budget'                => $__budget,
                'balance'               => $__balance,
                'cost'                  => $projects['project_cost'],
                'owner'                 => $projects['project_owner'],
                'project_fiscal_year'   => $projects['project_fiscal_year'],

            ]);

            ($budget['total'] = $__budget);
            foreach ($projects->task as $task) {
                (int) $__budget_gov = (int) $task['task_budget_gov_operating'] + (int) $task['task_budget_gov_utility'] + (int) $task['task_budget_gov_investment'];
                (int) $__budget_it  = (int) $task['task_budget_it_operating'] + (int) $task['task_budget_it_investment'];
                (int) $__budget     = $__budget_gov + $__budget_it;
                (int) $__cost = array_sum([
                    $task['task_cost_gov_operating'],
                    $task['task_cost_gov_investment'],
                    $task['task_cost_gov_utility'],
                    $task['task_cost_it_operating'],
                    $task['task_cost_it_investment'],
                ]);
                (int) $__balance = $__budget - $__cost;
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
                    'cost'                  => $__cost,
                    'balance'               => $__balance,

                    // 'owner' => $project['project_owner'],
                ];

                $__project_cost[] = $__cost;
            }
            //    $gantt[0]['cost']    = array_sum($__project_cost);
            $gantt[0]['balance'] = $gantt[0]['balance'] - $gantt[0]['cost'];
            ($budget['cost']    = $gantt[0]['cost']);
            $budget['balance'] = $gantt[0]['balance'];


            ($taskcosttotals = DB::table('tasks')
                ->selectRaw('reguiar_id as fiscal_year_b,sum(COALESCE(task_cost_gov_operating, 0)
        + COALESCE(task_cost_gov_investment, 0) + COALESCE(task_cost_gov_utility, 0)
        + COALESCE(task_cost_it_operating, 0) + COALESCE(task_cost_it_investment, 0))
         as total_cost')
                ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
                ->whereRaw('tasks.project_id = projects.project_id AND project_fiscal_year = 2566')
                ->groupBy('reguiar_id')
                ->get());



            ($taskcost_data = $taskcosttotals->toArray());

            // ($combined_data = array_combine(array_column($project_data, 'budget'), array_column($taskcost_data, 'total_cost')));

            $pdf = Pdf::loadView('app.pdf.ex3', [
                'title' => $title,
                'project' => $project,
                'taskcosttotals' => $taskcosttotals,

                //   'combined_data'  => $combined_data,

            ]);
            $pdf->setPaper('A4', 'landscape');
            $pdf->setOption('enable_php', true);
            return $pdf->stream();
        }
    }

    public function ex4()

    {



        $year_q = '2566';
        $title = 'รายงานประจำปี ';





        // Query ดึงข้อมูลโปรเจคและคำนวณค่าใช้จ่ายและการจ่ายเงิน
        ($project = Project::select('projects.*', 'a.total_cost', 'a.total_pay', 'ab.cost_pa_1', 'ac.cost_no_pa_2')

            ->leftJoin(
                DB::raw('(select tasks.project_id,
 sum(COALESCE(tasks.task_cost_gov_utility,0))
+sum(COALESCE(tasks.task_cost_it_operating,0))
+sum(COALESCE(tasks.task_cost_it_investment,0)) as total_cost ,
sum( COALESCE(tasks.task_pay,0)) as total_pay
from tasks  group by tasks.project_id) as a'),
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
from tasks  where tasks.task_type=1 group by tasks.project_id) as ab'),
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
from tasks  where tasks.task_type=2 group by tasks.project_id) as ac'),
                'ac.project_id',
                '=',
                'projects.project_id'
            )

            // ->join('tasks', 'tasks.project_id', '=', 'projects.id')
            //->groupBy('projects.project_id')

            ->first());

        // คำนวณค่าเงินเบิกจ่ายทั้งหมดของโปรเจกต์

        (float) $__budget_gov = (float) $project['budget_gov_operating'] + (float) $project['budget_gov_utility'];
        (float) $__budget_it  = (float) $project['budget_it_operating'] + (float) $project['budget_it_investment'];
        (float) $__budget     = $__budget_gov + $__budget_it;
        (float) $__cost       = (float) $project['project_cost'];
        (float) $__balance    = $__budget + (float) $project['project_cost'];
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
            //'project_cost_disbursement'     => $project['project_cost_disbursemen'],
            'total_cost'                => $project['total_cost'],
            'cost'                  => $project['project_cost'],
            'cost_pa_1'             => $project['cost_pa_1'],
            'cost_no_pa_2'             => $project['cost_no_pa_2'],
            'cost_disbursement'     => $project['cost_disbursement'],

            'pay'                   => $project['pay'],
            'total_pay'              => $project['total_pay'],
            'owner'                 => $project['project_owner'],
            'open'                  => true,
            'type'                  => 'project',
            // 'duration'              => 360,
        ];

        $budget['total'] = $__budget;




        ($tasks = DB::table('tasks')
            ->select('tasks.*', 'a.cost_disbursement', 'a.total_pay', 'ab.cost_pa_1', 'ac.cost_no_pa_2')
            ->leftJoin(
                DB::raw('(select tasks.task_parent,
sum( COALESCE(tasks.task_cost_gov_utility,0))
+sum( COALESCE(tasks.task_cost_it_operating,0))
+sum( COALESCE(tasks.task_cost_it_investment,0))
as cost_disbursement,
sum( COALESCE(tasks.task_pay,0))  as total_pay
from tasks  group by tasks.task_parent) as a'),
                'a.task_parent',
                '=',
                'tasks.task_id'
            )

            ->leftJoin(
                DB::raw('(select tasks.task_parent,
sum(COALESCE(tasks.task_cost_gov_utility,0))
+sum(COALESCE(tasks.task_cost_it_operating,0))
+sum(COALESCE(tasks.task_cost_it_investment,0))
as cost_pa_1 ,
sum( COALESCE(tasks.task_pay,0)) as total_pay
from tasks
where tasks.task_type=1 group by tasks.task_parent) as ab'),
                'ab.task_parent',
                '=',
                'tasks.task_id'
            )


            ->leftJoin(
                DB::raw('(select tasks.task_parent,
 sum(COALESCE(tasks.task_cost_gov_utility,0))
+sum(COALESCE(tasks.task_cost_it_operating,0))
+sum(COALESCE(tasks.task_cost_it_investment,0))
as cost_no_pa_2 ,sum( COALESCE(tasks.task_pay,0))
as total_pay
from tasks  where tasks.task_type=2 group by tasks.task_parent) as ac'),
                'ac.task_parent',
                '=',
                'tasks.task_id'
            )

            ->toArray());
        ($tasks = json_decode(json_encode($tasks), true));
        foreach ($tasks as $task) {
            (float) $__budget_gov = (float) $task['task_budget_gov_operating'] + (float) $task['task_budget_gov_utility'] + (float) $task['task_budget_gov_investment'];
            (float) $__budget_it  = (float) $task['task_budget_it_operating'] + (float) $task['task_budget_it_investment'];
            (float) $__budget     = $__budget_gov + $__budget_it;

            (float) $__cost = array_sum([
                (float)$task['cost_disbursement'],
                $task['task_cost_gov_operating'],
                $task['task_cost_gov_investment'],
                $task['task_cost_gov_utility'],
                $task['task_cost_it_operating'],
                $task['task_cost_it_investment'],
            ]);

            (float) $__balance = $__budget - $__cost;
            ($gantt[] = [
                'id'                    => 'T' . $task['task_id'] . $task['project_id'],
                'text'                  => $task['task_name'],
                'start_date'            => date('Y-m-d', strtotime($task['task_start_date'])),

                'end_date'              => date('Y-m-d', strtotime($task['task_end_date'])),
                'parent'                => $task['task_parent'] ? 'T' . $task['task_parent'] . $task['project_id'] : $task['project_id'],
                'parent_sum'            => '' . $task['task_id'] . $task['project_id'],
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



                'cost_pa_1'             => $task['cost_pa_1'],
                'cost_no_pa_2'             => $task['cost_no_pa_2'],
                'cost_disbursement'     => $project['cost_disbursement'],
                'pay'                   => $task['task_pay'],
                'cost_disbursement'     => $task['cost_disbursement'],
                'task_total_pay'             => $task['total_pay'],
                'task_type'             => $task['task_type']
                // 'owner' => $project['project_owner'],
            ]);

            $__project_cost[] = $__cost;
            ($__project_pay[] = $task['task_pay']);
            ($__project_parent[] = $task['task_parent'] ? 'T' . $task['task_parent'] . $task['project_id'] : $task['project_id']);
            ($__project_parent_cost[] = 'parent');
        }
        // ($gntt[0]['cost']    =array_sum($__project_cost));
        //  ($gantt[0]['pay']    = array_sum($__project_pay));
        $gantt[0]['balance'] = $gantt[0]['balance'] - $gantt[0]['total_cost'];




        $budget['cost']    = $gantt[0]['total_cost'];
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





        ($project_data = $project->toArray());
        ($taskcost_data = $tasks->toArray());

        ($combined_data = array_combine(array_column($project_data, 'total_budgot'), array_column($taskcost_data, 'total_cost')));







        $pdf = Pdf::loadView('app.pdf.ex2', [
            'title' => $title,
            'project' => $project,
            'taskcosttotals'  => $tasks,
            'combined_data'  => $combined_data,


            'year_q' => $year_q,
        ]);
        $pdf->setPaper('A4', 'landscape');
        $pdf->setOption('enable_php', true);
        return $pdf->stream();
    }
}
