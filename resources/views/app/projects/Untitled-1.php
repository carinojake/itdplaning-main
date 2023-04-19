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
use Illuminate\Support\Facades\DB;

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
            (int) $__budget_gov = (int) $project['budget_gov_operating'] + (int) $project['budget_gov_utility'] + (int) $project['budget_gov_investment'];
            (int) $__budget_it  = (int) $project['budget_it_operating'] + (int) $project['budget_it_investment'];
            (int) $__budget     = $__budget_gov + $__budget_it;
            (int) $__balance    = $__budget + (int) $project['project_cost'];

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
// Query ดึงข้อมูลโปรเจคและคำนวณค่าใช้จ่ายและการจ่ายเงิน
        ($project = Project::select('projects.*', 'a.total_cost','a.total_pay','ab.cost_pa_1','ac.cost_no_pa_2')

        ->leftJoin(DB::raw('(select tasks.project_id,
         sum(COALESCE(tasks.task_cost_gov_utility,0))
   +sum(COALESCE(tasks.task_cost_it_operating,0))
   +sum(COALESCE(tasks.task_cost_it_investment,0)) as total_cost ,
   sum( COALESCE(tasks.task_pay,0)) as total_pay
    from tasks  group by tasks.project_id) as a'),
     'a.project_id', '=', 'projects.project_id')

       ->leftJoin(DB::raw('(select tasks.project_id,
        sum(COALESCE(tasks.task_cost_gov_utility,0))
   +sum(COALESCE(tasks.task_cost_it_operating,0))
   +sum(COALESCE(tasks.task_cost_it_investment,0)) as cost_pa_1 ,
   sum( COALESCE(tasks.task_pay,0)) as total_pay
   from tasks  where tasks.task_type=1 group by tasks.project_id) as ab'),
    'ab.project_id', '=', 'projects.project_id')

   ->leftJoin(DB::raw('(select tasks.project_id,
   sum(COALESCE(tasks.task_cost_gov_utility,0))
   +sum(COALESCE(tasks.task_cost_it_operating,0))
   +sum(COALESCE(tasks.task_cost_it_investment,0))as cost_no_pa_2 ,
   sum( COALESCE(tasks.task_pay,0)) as total_pay
   from tasks  where tasks.task_type=2 group by tasks.project_id) as ac'),
   'ac.project_id', '=', 'projects.project_id')

   // ->join('tasks', 'tasks.project_id', '=', 'projects.id')
       //->groupBy('projects.project_id')
        ->where('projects.project_id', $id)
        ->first());

// คำนวณค่าเงินเบิกจ่ายทั้งหมดของโปรเจกต์

        (float) $__budget_gov = (float) $project['budget_gov_operating'] + (float) $project['budget_gov_utility'] ;
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
            'project_cost_disbursement'     => $project['project_cost_disbursemen'],
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
        $tasks =  Project::find($id);



        ($tasks = DB::table('tasks')
        ->select('tasks.*', 'a.cost_disbursement','a.total_pay','ab.cost_pa_1','ac.cost_no_pa_2')
        ->leftJoin(DB::raw('(select tasks.task_parent,
        sum( COALESCE(tasks.task_cost_gov_utility,0))
        +sum( COALESCE(tasks.task_cost_it_operating,0))
        +sum( COALESCE(tasks.task_cost_it_investment,0))
        as cost_disbursement,
        sum( COALESCE(tasks.task_pay,0))  as total_pay
        from tasks  group by tasks.task_parent) as a'),
         'a.task_parent', '=', 'tasks.task_id')

        ->leftJoin(DB::raw('(select tasks.task_parent,
        sum(COALESCE(tasks.task_cost_gov_utility,0))
        +sum(COALESCE(tasks.task_cost_it_operating,0))
        +sum(COALESCE(tasks.task_cost_it_investment,0))
        as cost_pa_1 ,
        sum( COALESCE(tasks.task_pay,0)) as total_pay
        from tasks
        where tasks.task_type=1 group by tasks.task_parent) as ab'),
        'ab.task_parent', '=', 'tasks.task_id')


        ->leftJoin(DB::raw('(select tasks.task_parent,
         sum(COALESCE(tasks.task_cost_gov_utility,0))
        +sum(COALESCE(tasks.task_cost_it_operating,0))
        +sum(COALESCE(tasks.task_cost_it_investment,0))
        as cost_no_pa_2 ,sum( COALESCE(tasks.task_pay,0))
        as total_pay
        from tasks  where tasks.task_type=2 group by tasks.task_parent) as ac'),
        'ac.task_parent', '=', 'tasks.task_id')
        ->where('project_id',($id))
        ->get()
        ->toArray());
       ($tasks = json_decode(json_encode($tasks), true));
        foreach ($tasks as $task) {
            (float) $__budget_gov = (float) $task['task_budget_gov_operating'] + (float) $task['task_budget_gov_utility'] + (float) $task['task_budget_gov_investment'];
            (float) $__budget_it  = (float) $task['task_budget_it_operating'] + (float) $task['task_budget_it_investment'];
            (float) $__budget     = $__budget_gov + $__budget_it;

            (float) $__cost = array_sum([
                (double)$task['cost_disbursement'],
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

                'end_date'              => date('Y-m-d',strtotime($task['task_end_date'])),
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




        ($operating_pa_sum = DB::table('tasks')
        ->selectRaw('SUM(COALESCE(task_cost_it_operating,0)) As ospa')
         //->where('tasks.task_type', 1)
         ->where('tasks.task_type', 1)
         ->where('project_id',($id))
         ->get());
         ($json = json_decode($operating_pa_sum));
         ($ospa = $json[0]->ospa);
        ($ospa = (float)$ospa);


        ($operating_sum = DB::table('tasks')
        ->selectRaw('SUM(COALESCE(task_cost_it_operating,0)) As osa')
         //->where('tasks.task_type', 1)
         ->where('tasks.task_type', 2)
         ->where('project_id',($id))
         ->get());
         ($json = json_decode($operating_sum));
         ($osa = $json[0]->osa);
        ($osa = (float)$osa);

        ($operating_pay_sum_1 = DB::table('tasks')
       ->selectRaw('SUM(COALESCE(task_pay,0)) as iv')
       ->where ('tasks.task_cost_it_operating','>', 1)
       ->where('tasks.task_type', 1)
       ->where('project_id',($id))
       ->get());
       ($json = json_decode($operating_pay_sum_1));
       ($otpsa1 = $json[0]->iv);
      ($otpsa1 = (float)$otpsa1);



     ($operating_pay_sum_2 = DB::table('tasks')
      ->selectRaw('SUM(COALESCE(task_pay,0)) as iv2')
      ->where ('tasks.task_cost_it_operating','>', 2)
      ->where('tasks.task_type', 2)
      ->where('project_id',($id))
      ->get());
      ($json = json_decode($operating_pay_sum_2));
     ($otpsa2 = $json[0]->iv2);
     ($otpsa2 = (float)$otpsa2);




        ($investment_pa_sum = DB::table('tasks')
       ->selectRaw('SUM(COALESCE(task_cost_it_investment,0)) As ispa')
       ->where ('tasks.task_cost_it_investment','>', 1)
        ->where('tasks.task_type', 1)
        ->where('project_id',($id))
        ->get());
        ($json = json_decode($investment_pa_sum));
        ($ispa = $json[0]->ispa);
       ($ispa = (float)$ispa);

       ($investment_pay_sum_1 = DB::table('tasks')
       ->selectRaw('SUM(COALESCE(task_pay,0)) as iv')
       ->where ('tasks.task_cost_it_investment','>', 1)
       ->where('tasks.task_type', 1)
       ->where('project_id',($id))
       ->get());
       ($json = json_decode($investment_pay_sum_1));
       ($itpsa1 = $json[0]->iv);
      ($itpsa1 = (float)$itpsa1);

      ($investment_pay_sum_2 = DB::table('tasks')
       ->selectRaw('SUM(COALESCE(task_pay,0)) as iv')
       ->where ('tasks.task_cost_it_investment','>', 1)
       ->where('tasks.task_type', 2)
       ->where('project_id',($id))
       ->get());
       ($json = json_decode($investment_pay_sum_2));
       ($itpsa2 = $json[0]->iv);
      ($itpsa2 = (float)$itpsa2);

       ($investment_sum = DB::table('tasks')
        ->selectRaw('SUM(COALESCE(task_cost_it_investment,0)) As isa')

        ->where ('tasks.task_cost_it_investment','>', 1)
        ->where('tasks.task_type',2)
        ->where('project_id',($id))
        ->get());
        ($json = json_decode($investment_sum));
        ($isa = $json[0]->isa);
       ($isa = (float)$isa);

       ($investment_total_pay_sum = DB::table('tasks')
        ->selectRaw('SUM(COALESCE(task_pay,0)) as iv')
        ->where ('tasks.task_cost_it_investment','>', 1)
        ->where('project_id',($id))
        ->get());
        ($json = json_decode($investment_total_pay_sum));
        ($itpsa = $json[0]->iv);
       ($itpsa = (float)$itpsa);



       ($ut_pa_sum = DB::table('tasks')
       ->selectRaw('SUM(COALESCE(task_cost_gov_utility,0)) As utpcs')
       ->where('tasks.task_type',1)
       ->where('project_id',($id))
       ->get());
       ($json = json_decode($ut_pa_sum));
       ($utpcs = $json[0]->utpcs);
      ($utpcs = (float)$utpcs);



      ($ut_sum = DB::table('tasks')
       ->selectRaw('SUM(COALESCE(task_cost_gov_utility,0)) As utsc')
       ->where('tasks.task_type',2)
       ->where('project_id',($id))
       ->get());
       ($json = json_decode($ut_sum));
       ($utsc = $json[0]->utsc);
        ($utsc = (float)$utsc);



       ($ut_pay_sum = DB::table('tasks')
        ->selectRaw('SUM(COALESCE(task_pay,0)) As utsc_pay  ')
        ->where('tasks.task_type',2)
        ->whereNotNull('task_cost_gov_utility')
        ->where('project_id',($id))

        ->get());
        ($json = json_decode($ut_pay_sum));
        ($utsc_pay = $json[0]->utsc_pay);
         ($utsc_pay = (float)$utsc_pay);


         ($ut_pay_pa_sum = DB::table('tasks')
->selectRaw('SUM(COALESCE(task_pay,0)) As utsc_pay_pa  ')
->where('tasks.task_type',1)
->whereNotNull('task_cost_gov_utility')
->where('project_id',($id))
->get());
($json = json_decode($ut_pay_pa_sum));
($utsc_pay_pa = $json[0]->utsc_pay_pa);
 ($utsc_pay_pa = (float)$utsc_pay_pa);

       $parent_sum_pa = DB::table('tasks')
        ->select('tasks.task_parent', 'a.cost_a')

        ->leftJoin(DB::raw('(select tasks.task_parent, sum( COALESCE(tasks.task_cost_it_investment,0)+ COALESCE(tasks.task_cost_it_operating,0)+ COALESCE(tasks.task_budget_gov_utility,0)) as cost_a from tasks where tasks.task_parent is not null group by tasks.task_parent) as a'), 'tasks.task_parent', '=', 'tasks.task_id')
        ->whereNotNull('tasks.task_parent')
        ->where('project_id',$id)
        ->get();

    ($parent_sum_pa);


        ($parent_sum_cd = DB::table('tasks')
            ->select('task_parent', DB::raw('sum(task_pay) as cost_app'))
            ->whereNotNull('task_parent')
            ->groupBy('task_parent')
            ->get()
        );



    ($gantt);

        $gantt = json_encode($gantt);

        return view('app.projects.show', compact('project','itpsa1','itpsa2','otpsa1',
        'gantt', 'budget', 'parent_sum_pa', 'parent_sum_cd','task',
        'ispa','isa','utsc','utpcs','ospa','osa','itpsa','utsc_pay','utsc_pay_pa','otpsa2'));
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
        ($id_project = Hashids::decode($project)[0]);
        $id_task    = Hashids::decode($task)[0];
        $project    = Project::find($id_project);
        $task       = task::find($id_task);
        $contracts = Contract::get();




        // echo 'contract' . $task->contract->count();
        // dd($task->contract);

        return view('app.projects.tasks.show', compact('contracts', 'project', 'task'));
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


<script src="{{ asset('vendors/DataTables/datatables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var token = $('meta[name="csrf-token"]').attr('content');
        var modal = $('.modal')
        var form = $('.form')
        var btnAdd = $('.add'),
            btnSave = $('.btn-save'),
            btnUpdate = $('.btn-update');
        var table = $('#datatables').DataTable({
            autoWidth: false,
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('contract.index') }}",
            language: {
                processing: "กำลังประมวลผล...",
                search: "ค้นหา:",
                lengthMenu: "แสดง _MENU_ รายการ",
                info: "แสดงรายที่ _START_ ถึง _END_ ทั้งหมด _TOTAL_ รายการ",
                infoEmpty: "แสดงรายที่ 0 ถึง 0 ทั้งหมด 0 รายการ",
                infoFiltered: "(กรองจากทั้งหมด _MAX_ รายการ)",
                infoPostFix: "",
                loadingRecords: "Chargement en cours...",
                zeroRecords: "ไม่พบข้อมูล",
                emptyTable: "ไม่พบข้อมูล",
                paginate: {
                    first: "หน้าแรก",
                    previous: "ย้อนกลับ",
                    next: "ถัดไป",
                    last: "หน้าสุดท้าย"
                },
                aria: {
                    sortAscending: ": เรียงจากน้อยไปหามาก",
                    sortDescending: ": เรียงจากมากไปหาน้อย"
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'contract_number_output',
                    name: 'contract_number'
                },
                {
                    data: 'contract_name_output',
                    name: 'contract_name'
                },
                {
                    data: 'contract_fiscal_year'
                },
                {
                    className: "text-end",
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
        btnUpdate.click(function() {
            if (!confirm("Are you sure?")) return;
            var formData = form.serialize() + '&_method=PUT&_token=' + token
            var updateId = form.find('input[name="id"]').val()
            $.ajax({
                type: "POST",
                url: "/" + updateId,
                data: formData,
                success: function(data) {
                    if (data.success) {
                        table.draw();
                        modal.modal('hide');
                    }
                }
            }); //end ajax
        })
        $(document).on('click', '.btn-delete', function() {
            if (!confirm("Are you sure?")) return;
            var rowid = $(this).data('rowid')
            var el = $(this)
            if (!rowid) return;
            $.ajax({
                type: "POST",
                dataType: 'JSON',
                url: "{{ url('contract') }}/" + rowid,
                data: {
                    _method: 'delete',
                    _token: token
                },
                success: function(data) {
                    if (data.success) {
                        table.row(el.parents('tr'))
                            .remove()
                            .draw();
                    }
                }
            }); //end ajax
        })
    });
</script>

<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-responsive-sm table-striped" id="datatables">
                        <thead>
                            <tr>

                                <th>{{ __('ลำดับ') }}</th>
                                <th>{{ __('สัญญาที่') }}</th>
                                <th></th>
                                <th>{{ __('กี่เดีอนเหลือ') }}</th>
                                <th>{{ __('กี่เดีอนเหลือ2') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>


