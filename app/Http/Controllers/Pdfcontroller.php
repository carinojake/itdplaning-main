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
        $title = 'รายงานประจำปี 2566';
        $contract = Contract::where('contract_fiscal_year', 2566)->get();
        $pdf = Pdf::loadView('app.pdf.ex1', [
            'title' => $title,
            'contract' => $contract
        ]);
        $pdf->setOption('enable_php', true);
        return $pdf->stream();
    }


    public function ex2()
    {
        $title = 'รายงานประจำปี 2566';

        ($project = DB::table('projects')
       ->select('project_id as id', 'project_name as name', 'reguiar_id as fiscal_year_b','project_fiscal_year as year',
                DB::raw('sum(COALESCE(budget_gov_operating,0) + COALESCE(budget_gov_investment,0) + COALESCE(budget_gov_utility,0)
                + COALESCE(budget_it_operating,0) + COALESCE(budget_it_investment,0)) as total_budgot'))
       ->where('project_fiscal_year', '=', 2566)
       ->groupBy('project_id', 'project_name', 'reguiar_id','project_fiscal_year')
       ->orderBy('reguiar_id', 'asc')
       ->get());

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



        $pdf = Pdf::loadView('app.pdf.ex2', [
            'title' => $title,
            'project' => $project,
            'taskcosttotals'  => $taskcosttotals,

        ]);
        $pdf->setOption('enable_php', true);
        return $pdf->stream();
    }


}
