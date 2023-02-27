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
    public function index() {
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

        $year_q = '2566';
        $title = 'รายงานประจำปี ';

        ($budgetscentralict = Project::where('project_fiscal_year', 2566)->sum(DB::raw('	COALESCE(budget_gov_operating,0) + COALESCE(budget_it_operating,0)')));
       ($budgetsinvestment = Project::where('project_fiscal_year', 2566)->sum(DB::raw('COALESCE(budget_gov_investment,0) + COALESCE(budget_it_investment,0)')));
        ($budgetsut  = Project::where('project_fiscal_year', 2566)->sum(DB::raw('COALESCE(budget_gov_utility,0)	')));


        $projects = DB::table('projects')
        ->select('project_id as id', 'project_name as name', 'reguiar_id as fiscal_year_b','project_fiscal_year as year',
                 DB::raw('sum(COALESCE(budget_gov_operating,0) + COALESCE(budget_gov_investment,0) + COALESCE(budget_gov_utility,0)
                 + COALESCE(budget_it_operating,0) + COALESCE(budget_it_investment,0)) as total_budgot'))
        ->where('project_fiscal_year', '=', 2566)
        ->groupBy('project_id', 'project_name', 'reguiar_id','project_fiscal_year')
        ->orderBy('reguiar_id', 'asc')
        ->get();

    ($taskcosttotals = DB::table('tasks')
        ->selectRaw('reguiar_id as fiscal_year_b,sum(COALESCE(task_cost_gov_operating, 0)
        + COALESCE(task_cost_gov_investment, 0) + COALESCE(task_cost_gov_utility, 0)
        + COALESCE(task_cost_it_operating, 0) + COALESCE(task_cost_it_investment, 0))
         as total_cost')
        ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
        ->whereRaw('tasks.project_id = projects.project_id AND project_fiscal_year = 2566')
        ->groupBy('reguiar_id')
        ->get());






 ($project_data = $projects->toArray());
   ($taskcost_data =$taskcosttotals->toArray());

   ($combined_data = array_combine(array_column($project_data, 'total_budgot'), array_column($taskcost_data, 'total_cost')));



        $pdf = Pdf::loadView('app.pdf.ex2', [
            'title' => $title,
            'project' => $projects,
            'taskcosttotals'  => $taskcosttotals,
            'combined_data'  => $combined_data,
            'budgetscentralict' => $budgetscentralict,
            'budgetsinvestment'=> $budgetsinvestment,
            'budgetsut'=> $budgetsut,

'year_q'=> $year_q,
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
        dd($gantt[] = [
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



        ($taskcost_data =$taskcosttotals->toArray());

       // ($combined_data = array_combine(array_column($project_data, 'budget'), array_column($taskcost_data, 'total_cost')));

    $pdf = Pdf::loadView('app.pdf.ex3', [
        'title' => $title,
        'project' => $project,
        'taskcosttotals'=> $taskcosttotals,

     //   'combined_data'  => $combined_data,

    ]);
    $pdf->setPaper('A4', 'landscape');
    $pdf->setOption('enable_php', true);
    return $pdf->stream();
}
}
}
