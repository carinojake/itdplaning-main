<?php

namespace App\Http\Controllers;

use App\Libraries\Helper;
use App\Models\Contract;

use App\Models\Project;
use App\Models\Task;
use App\Models\Taskcon;
use App\Models\ContractHasTask;
use App\Models\ContractHasTaskcon;
use App\Models\File; //add File Model
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Double;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Jenssegers\Date\Date;


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
            $records = Project::orderBy('project_fiscal_year', 'DESC')->orderBy('project_type', 'ASC')->orderBy('reguiar_id', 'ASC');

            return Datatables::eloquent($records)
                ->addIndexColumn()
                ->addColumn('project_name_output', function ($row) {
                    $flag_status = $row->project_status == 2 ? '<span class="badge bg-info">ดำเนินการแล้วเสร็จ</span>' : '';
                    $html        = $row->project_name . ' ' . $flag_status;
                    $html .= '<br><span class="badge bg-info">' . Helper::Date4(date('Y-m-d H:i:s', $row->project_start_date)) . '</span> -';
                    $html .= ' <span class="badge bg-info">' . Helper::Date4(date('Y-m-d H:i:s', $row->project_end_date)) . '</span>';

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
                ->addColumn('reguiar_id', function ($row) {
                    return $row->reguiar_id;
                })
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">';
                    $html .= '<a href="' . route('project.show', $row->hashid) . '" class="text-white btn btn-success" target="_blank"><i class="cil-folder-open "></i></a>';
                    //if (Auth::user()->hasRole('admin')) {
                    $html .= '<a href="' . route('project.edit', $row->hashid) . '" class="text-white btn btn-warning btn-edit " target="_blank"><i class="cil-pencil "></i></a>';
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
        ($id = Hashids::decode($project)[0]);


        /*    $taskconoverview = DB::table('taskcons')
        ->whereNotNull('taskcons.project_id')
        ->get();

    dd($taskconoverview);

 */

        $taskconssubno = DB::table('taskcons')
            ->join('projects', 'taskcons.project_id', '=', 'projects.project_id')
            ->where('projects.project_id', $id)
            ->select('projects.project_id', 'projects.*', 'taskcons.*')
            ->get();

        // dd($taskconssubno);

        // $taskcons = Task::join('taskcons', 'tasks.task_id', '=', 'taskcons.task_id')
        // ->select('tasks.*', 'taskcons.*')
        // ->where('tasks.task_id', $task->task_id)
        // ->get();
        //  $taskid = Hashids::decode($task)[0];
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
            ->where('projects.project_id', $id)
            ->first()

            // ->toArray()
        );

        /*      $project = Project::select('projects.*', 'tasks.*', 'contract_has_tasks.*', 'contracts.*', 'taskcons.*')
->join('tasks', 'tasks.project_id', '=', 'projects.project_id')
->join('contract_has_tasks', 'contract_has_tasks.task_id', '=', 'tasks.task_id')
->join('contracts', 'contracts.contract_id', '=', 'contract_has_tasks.contract_id')
->join('taskcons', 'taskcons.contract_id', '=', 'contracts.contract_id')
->where('projects.project_id', $id)
->first()
->toArray()
; */

        //dd($project);
        // คำนวณค่าเงินเบิกจ่ายทั้งหมดของโปรเจกต์
        (float) $__budget_gov = (float) $project['budget_gov_operating'] + (float) $project['budget_gov_utility'];
        (float) $__budget_it  = (float) $project['budget_it_operating'] + (float) $project['budget_it_investment'];
        (float) $__budget     = $__budget_gov + $__budget_it;
        ((float) $__cost       = (float) $project['project_cost']);
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

        //  $tasks =  Project::find($id);

        $tasks = DB::table('tasks')
            ->Join('taskcons', 'tasks.task_id', '=', 'taskcons.task_id')

            ->select('tasks.*', 'taskcons.*')
            ->get();

        //  dd ($tasks);

        ($tasks = DB::table('tasks')
            ->select('tasks.*', 'a.costs_disbursement', 'a.total_pay', 'ab.cost_pa_1', 'ac.cost_no_pa_2')
            ->leftJoin(
                DB::raw('(select tasks.task_parent,
        sum( COALESCE(tasks.task_cost_gov_utility,0))
        +sum( COALESCE(tasks.task_cost_it_operating,0))
        +sum( COALESCE(tasks.task_cost_it_investment,0))
        as costs_disbursement,
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

            //->Join('taskcons', 'tasks.task_id', '=', 'taskcons.task_id')

            //->select('tasks.*', 'taskcons.*')


            ->where('project_id', ($id))
            ->get()
            ->toArray());

        // dd($tasks);









        /*  ($tasks = DB::table('tasks')
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
            ->where('project_id', ($id))
            ->get()
            ->toArray()); */

        /*        $check_parent = DB::table('projects')
                ->join('tasks', 'projects.project_id', '=', 'tasks.project_id')
                ->select(
                    'tasks.task_id',
                    'tasks.task_parent'
                )
                ->where('projects.project_id', $project->project_id)
                ->where('tasks.task_id', $task->task_id)
                ->get();



            dd($check_parent);
 */



        ($tasks = json_decode(json_encode($tasks), true));
        foreach ($tasks as $task) {
            (float) $__budget_gov = (float) $task['task_budget_gov_operating'] + (float) $task['task_budget_gov_utility'] + (float) $task['task_budget_gov_investment'];
            (float) $__budget_it  = (float) $task['task_budget_it_operating'] + (float) $task['task_budget_it_investment'];



            (float) $__budget     = $__budget_gov + $__budget_it;

            (float) $__cost = array_sum([
                (float)
                //$task['cost_disbursement'],
                $task['task_cost_gov_operating'],
                $task['task_cost_gov_investment'],
                $task['task_cost_gov_utility'],
                $task['task_cost_it_operating'],
                $task['task_cost_it_investment'],
                // $task['task_cost_disbursement'],
                // $task['taskcon_ba_budget'],
                //$task['taskcon_bd_budget'],

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
                'tbalance'               => $__balance,
                'cost'                  => $__cost,



                'cost_pa_1'             => $task['cost_pa_1'],
                'cost_no_pa_2'             => $task['cost_no_pa_2'],
                //  'cost_disbursement'     => $project['cost_disbursement'],
                'pay'                   => $task['task_pay'],
                //'cost_disbursement'     => $task['cost_disbursement'],
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
        ($gantt[0]['balance'] = $gantt[0]['balance'] - $gantt[0]['total_cost']);



        // $budget['cost']    = $gantt[0]['total_cost'];
        $budget['cost']    = $gantt[0]['total_cost'];
        $budget['balance'] = $gantt[0]['balance'];
        //  $budget['balance'] = $gantt[0]['balance'];




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
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($operating_pa_sum));
        ($ospa = $json[0]->ospa);
        ($ospa = (float)$ospa);


        ($operating_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_cost_it_operating,0)) As osa')
            //->where('tasks.task_type', 1)
            ->where('tasks.task_type', 2)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($operating_sum));
        ($osa = $json[0]->osa);
        ($osa = (float)$osa);

        ($operating_pay_sum_1 = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_pay,0)) as iv')
            ->where('tasks.task_cost_it_operating', '>', 1)
            ->where('tasks.task_type', 1)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($operating_pay_sum_1));
        ($otpsa1 = $json[0]->iv);
        ($otpsa1 = (float)$otpsa1);



        ($operating_pay_sum_2 = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_pay,0)) as iv2')
            ->where('tasks.task_cost_it_operating', '>', 2)
            ->where('tasks.task_type', 2)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($operating_pay_sum_2));
        ($otpsa2 = $json[0]->iv2);
        ($otpsa2 = (float)$otpsa2);




        ($investment_pa_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_cost_it_investment,0)) As ispa')
            ->where('tasks.task_cost_it_investment', '>', 1)
            ->where('tasks.task_type', 1)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($investment_pa_sum));
        ($ispa = $json[0]->ispa);
        ($ispa = (float)$ispa);

        ($investment_pay_sum_1 = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_pay,0)) as iv')
            ->where('tasks.task_cost_it_investment', '>', 1)
            ->where('tasks.task_type', 1)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($investment_pay_sum_1));
        ($itpsa1 = $json[0]->iv);
        ($itpsa1 = (float)$itpsa1);

        ($investment_pay_sum_2 = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_pay,0)) as iv')
            ->where('tasks.task_cost_it_investment', '>', 1)
            ->where('tasks.task_type', 2)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($investment_pay_sum_2));
        ($itpsa2 = $json[0]->iv);
        ($itpsa2 = (float)$itpsa2);

        ($investment_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_cost_it_investment,0)) As isa')

            ->where('tasks.task_cost_it_investment', '>', 1)
            ->where('tasks.task_type', 2)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($investment_sum));
        ($isa = $json[0]->isa);
        ($isa = (float)$isa);

        ($investment_total_pay_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_pay,0)) as iv')
            ->where('tasks.task_cost_it_investment', '>', 1)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($investment_total_pay_sum));
        ($itpsa = $json[0]->iv);
        ($itpsa = (float)$itpsa);




        ($ut_budget_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_budget_gov_utility,0)) As ut_budget_sum')
            ->where('tasks.task_type', 1)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($ut_budget_sum));
        ($ut_budget_sum = $json[0]->ut_budget_sum);
        ($ut_budget_sum = (float)$ut_budget_sum);

        //dd($ut_budget_sum);

        ($ut_budget_sum_no = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_budget_gov_utility,0)) As ut_budget_sum_no')
            ->where('tasks.task_type', 2)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($ut_budget_sum_no));
        ($ut_budget_sum_no = $json[0]->ut_budget_sum_no);
        ($ut_budget_sum_no = (float)$ut_budget_sum_no);


        //dd($ut_budget_sum_no);





        ($ut_pa_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_cost_gov_utility,0)) As utpcs')
            ->where('tasks.task_type', 1)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($ut_pa_sum));
        ($utpcs = $json[0]->utpcs);
        ($utpcs = (float)$utpcs);



        ($ut_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_cost_gov_utility,0)) As utsc')
            ->where('tasks.task_type', 2)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($ut_sum));
        ($utsc = $json[0]->utsc);
        ($utsc = (float)$utsc);



        ($ut_pay_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_pay,0)) As utsc_pay  ')
            ->where('tasks.task_type', 2)
            ->where('task_cost_gov_utility', '>', 1)
            ->where('project_id', ($id))

            ->get());
        ($json = json_decode($ut_pay_sum));
        ($utsc_pay = $json[0]->utsc_pay);
        ($utsc_pay = (float)$utsc_pay);


        ($ut_pay_pa_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_pay,0)) As utsc_pay_pa  ')
            ->where('tasks.task_type', 1)
            ->where('task_cost_gov_utility', '>', 1)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($ut_pay_pa_sum));
        ($utsc_pay_pa = $json[0]->utsc_pay_pa);
        ($utsc_pay_pa = (float)$utsc_pay_pa);



        // dd($utpcs,$utsc_pay_pa,$utsc_pay);

        $parent_sum_pa = DB::table('tasks')
            ->select('tasks.task_parent', 'a.cost_a')

            ->leftJoin(
                DB::raw('(select tasks.task_parent
        , sum( COALESCE(tasks.task_cost_it_investment,0)+ COALESCE(tasks.task_cost_it_operating,0)+ COALESCE(tasks.task_budget_gov_utility,0))
        as cost_a from tasks where tasks.task_parent is not null group by tasks.task_parent) as a'),
                'tasks.task_parent',
                '=',
                'tasks.task_id'
            )
            ->whereNotNull('tasks.task_parent')
            ->where('project_id', $id)
            ->get();

        ($parent_sum_pa);




        ($parent_sum_cd = DB::table('tasks')
            ->select('task_parent', DB::raw('sum(task_pay) as cost_app'))
            ->whereNotNull('task_parent')
            ->groupBy('task_parent')
            ->get()
        );


        $taskconoverview = DB::table('tasks')
            ->select('tasks.task_id as task_id', 'tasks.project_id as project_id', 'taskcons.taskcon_id as taskcons_id', 'tasks.task_name as task_name', 'taskcons.taskcon_name as taskcons_name')
            ->leftJoin('taskcons', 'tasks.task_id', '=', 'taskcons.task_id') // assuming 'id' is the primary key in 'tasks' and 'task_id' is the foreign key in 'taskcons'
            ->where('tasks.project_id', $id)
            ->get();
        $taskconoverviewcon = DB::table('tasks')
            ->select('tasks.task_id as task_id', 'tasks.project_id as project_id', 'contracts.contract_id as contract_id', 'taskcons.taskcon_id as taskcons_id', 'tasks.task_name as task_name', 'taskcons.taskcon_name as taskcons_name')
            ->join('contract_has_tasks', 'tasks.task_id', '=', 'contract_has_tasks.task_id')
            ->join('contracts', 'contract_has_tasks.contract_id', '=', 'contracts.contract_id')
            ->join('taskcons', 'contracts.contract_id', '=', 'taskcons.contract_id')
            ->where('tasks.project_id', $id)
            ->get();
        $contractoverviewcon = DB::table('tasks')
            ->select('tasks.task_id', 'projects.project_id', 'tasks.project_id', 'projects.project_name as project_name', 'taskcons.taskcon_id as taskcons_id', 'tasks.task_name as task_name', 'taskcons.taskcon_name as taskcons_name')
            ->join('taskcons', 'tasks.task_id', '=', 'taskcons.task_id')
            ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            ->get();


        //  dd($project->main_task_activity);


        //  dd($taskconoverview,$taskconoverviewcon, $contractoverviewcon);


          //  dd($gantt,$budget);
        // dd($budget);
        $gantt = json_encode($gantt);

        return view('app.projects.show', compact(
            'ut_budget_sum',
            'ut_budget_sum_no',
            'taskconssubno',
            'project',
            'itpsa1',
            'itpsa2',
            'otpsa1',
            'gantt',
            'budget',
            'parent_sum_pa',
            'parent_sum_cd',
            'ispa',
            'isa',
            'utsc',
            'utpcs',
            'ospa',
            'osa',
            'itpsa',
            'utsc_pay',
            'utsc_pay_pa',
            'otpsa2',
            'tasks'

        ));
    }


    public function view(Request $request, $project)
    {
        ($id = Hashids::decode($project)[0]);


        /*    $taskconoverview = DB::table('taskcons')
        ->whereNotNull('taskcons.project_id')
        ->get();

    dd($taskconoverview);

 */

        $taskconssubno = DB::table('taskcons')
            ->join('projects', 'taskcons.project_id', '=', 'projects.project_id')
            ->where('projects.project_id', $id)
            ->select('projects.project_id', 'projects.*', 'taskcons.*')
            ->get();

        // dd($taskconssubno);

        // $taskcons = Task::join('taskcons', 'tasks.task_id', '=', 'taskcons.task_id')
        // ->select('tasks.*', 'taskcons.*')
        // ->where('tasks.task_id', $task->task_id)
        // ->get();
        //  $taskid = Hashids::decode($task)[0];
        // Query ดึงข้อมูลโปรเจคและคำนวณค่าใช้จ่ายและการจ่ายเงิน
        ($project = Project::select(
            'projects.*', 'a.total_task_refund_pa_budget',
             'a.total_cost', 'a.tta', 'a.ttb', 'a.total_pay',
             'a.total_task_mm_budget', 'ab.cost_pa_1', 'ac.cost_no_pa_2',
             'ad.total_taskcon_pay_con'



             )
            ->leftJoin(
                DB::raw('(select tasks.project_id,
                    sum(COALESCE(tasks.task_cost_gov_utility,0))
                +sum(COALESCE(tasks.task_cost_it_operating,0))
                +sum(COALESCE(tasks.task_cost_it_investment,0)) as total_cost ,
                sum( COALESCE(tasks.task_mm_budget,0))  as total_task_mm_budget,
                sum( COALESCE(tasks.task_refund_pa_budget,0)) as total_task_refund_pa_budget,
                sum( COALESCE(tasks.task_pay,0)) as total_pay,
                sum(COALESCE(tasks.task_mm_budget,0))- sum(COALESCE(tasks.task_cost_gov_utility,0))
                +sum(COALESCE(tasks.task_cost_it_operating,0))
                +sum(COALESCE(tasks.task_cost_it_investment,0))
                   as tta,
                   CASE
                   WHEN sum(COALESCE(tasks.task_cost_gov_utility,0)) = 0 THEN  sum(COALESCE(tasks.task_mm_budget,0))
                   WHEN sum(COALESCE(tasks.task_cost_gov_utility,0)) > 1 THEN sum( COALESCE(tasks.task_pay,0))
                   ELSE 0
               END as ttb
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
                sum( COALESCE(tasks.task_mm_budget,0))  as total_task_mm_budget,
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
                sum( COALESCE(tasks.task_mm_budget,0))  as total_task_mm_budget,
                sum( COALESCE(tasks.task_pay,0)) as total_pay
                from tasks  where tasks.task_type=2 group by tasks.project_id) as ac'),
                'ac.project_id',
                '=',
                'projects.project_id'
            )

            ->leftJoin(
                DB::raw('(select tasks.project_id,
                sum( COALESCE(tasks.task_mm_budget,0))  as total_task_mm_budget,
                sum( COALESCE(tasks.task_pay,0)) as total_pay,
                sum( COALESCE(taskcons.taskcon_pay,0)) as  total_taskcon_pay_con
                from tasks
                INNER JOIN
                contract_has_tasks
                ON
                    tasks.task_id = contract_has_tasks.task_id
                INNER JOIN
                contracts
                ON
                    contract_has_tasks.contract_id = contracts.contract_id
                INNER JOIN
                taskcons
                ON
                    contracts.contract_id = taskcons.contract_id
                where tasks.task_type=1 group by tasks.project_id) as ad'),
                'ad.project_id',
                '=',
                'projects.project_id'
            )



            // ->join('tasks', 'tasks.project_id', '=', 'projects.id')
            //->groupBy('projects.project_id')
            ->where('projects.project_id', $id)
            ->first()

            // ->toArray()
        );
       //  dd($project);
        /*      $project = Project::select('projects.*', 'tasks.*', 'contract_has_tasks.*', 'contracts.*', 'taskcons.*')
->join('tasks', 'tasks.project_id', '=', 'projects.project_id')
->join('contract_has_tasks', 'contract_has_tasks.task_id', '=', 'tasks.task_id')
->join('contracts', 'contracts.contract_id', '=', 'contract_has_tasks.contract_id')
->join('taskcons', 'taskcons.contract_id', '=', 'contracts.contract_id')
->where('projects.project_id', $id)
->first()
->toArray()
; */


        // คำนวณค่าเงินเบิกจ่ายทั้งหมดของโปรเจกต์
        (float) $__budget_gov = (float) $project['budget_gov_operating'] + (float) $project['budget_gov_utility'];
        (float) $__budget_it  = (float) $project['budget_it_operating'] + (float) $project['budget_it_investment'];
        (float) $__budget     = $__budget_gov + $__budget_it;
        ((float) $__cost       = (float) $project['project_cost']);
        ((float) $__mm       = (float) $project['total_task_mm_budget']);
        ((float) $__paycon       = (float) $project['total_taskcon_pay_con']);
        ((float) $__prmm       = (float) $project['total_task_refund_pa_budget']);
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
            'project_cost_disbursement'     => $project['project_cost_disbursemen'],
            'total_cost'                => $project['total_cost'],
            'cost'                  => $project['project_cost'],
            'cost_pa_1'             => $project['cost_pa_1'],
            'cost_no_pa_2'             => $project['cost_no_pa_2'],
           // 'cost_disbursement'     => $project['cost_disbursement'],
            'pay'                   => $project['pay'],
            'total_pay'              => $project['total_pay']+$__paycon,
            'total_taskcon_pay_con'  => $__paycon,
            'budget_mm'             => $project['task_mm_budget'],
            'refund_pa_budget'      => $__prmm,
            'budget_total_mm'             => $__mm,
            //'budget_total_pr_sum'  =>   $__balance_pr_sum,
            'owner'                 => $project['project_owner'],
            'open'                  => true,
            'type'                  => 'project',
            // 'duration'              => 360,
        ];

       //  dd($gantt);


        $budget['total'] = $__budget;
        ($budget['budget_total_mm'] = $__mm);
        $budget['budget_total_taskcon_pay_con'] = $__paycon;
        $budget['budget_total_refund_pa_budget'] = $__prmm;
        $budget['budget_total_mm_pr'] = $__budget - ($__mm - $__prmm);

          //dd($budget);

        //  $tasks =  Project::find($id);

        $tasks = DB::table('tasks')
            ->Join('taskcons', 'tasks.task_id', '=', 'taskcons.task_id')

            ->select('tasks.*', 'taskcons.*')
            ->get();

        // dd ($tasks);

        $taskconsSubquery = DB::table('tasks')
            ->select(
                'tasks.task_id as task_id',
                'tasks.project_id as project_id',
                'taskcons.taskcon_id as taskcons_id',
                'tasks.task_name as task_name',
                'taskcons.taskcon_name as taskcons_name',
                'taskcons.taskcon_name as taskcons_name',
                DB::raw('SUM(taskcons.taskcon_pay) as taskcons_pay')
            )
            ->leftJoin('taskcons', 'tasks.task_id', '=', 'taskcons.task_id')
            ->where('tasks.project_id', $id)
            ->groupBy('tasks.task_id')
            ->toSql();

        //dd($taskconsSubquery);


        ($tasks = DB::table('tasks')
            ->select(
                'tasks.*',
                'a.total_task_mm_budget_task',
                'a.costs_disbursement',

                'a.total_taskcon_cost',



                'ab.total_task_mm_budget_1',
                'ac.total_task_mm_budget_2',
                'ab.cost_pa_1',
                'ac.cost_no_pa_2',
                'a.total_pay',
                'ab.total_pay_1',
                'ac.total_pay_2',
                'a.total_taskcon_pay',
                'cc.s',
                'cc.c',
                'ad.total_taskcon_cost_pa_1',
                'ad.total_taskcon_pay_pa_1'
            )
            ->leftJoin(
                DB::raw('(select tasks.task_parent,
                sum( COALESCE(tasks.task_mm_budget,0))  as total_task_mm_budget_task,


                sum( COALESCE(tasks.task_cost_gov_utility,0))
        +sum( COALESCE(tasks.task_cost_it_operating,0))
        +sum( COALESCE(tasks.task_cost_it_investment,0))
        as costs_disbursement,

        sum(COALESCE(taskcons.taskcon_cost_gov_utility,0))
        +sum(COALESCE(taskcons.taskcon_cost_it_operating,0))
        +sum(COALESCE(taskcons.taskcon_cost_it_investment,0))
        as total_taskcon_cost ,



        sum(COALESCE(taskcons.taskcon_pay,0)) as total_taskcon_pay,


        sum( COALESCE(tasks.task_pay,0))  as total_pay




        from tasks
        INNER JOIN
        contract_has_tasks
        ON
            tasks.task_id = contract_has_tasks.task_id
        INNER JOIN
        contracts
        ON
            contract_has_tasks.contract_id = contracts.contract_id
        INNER JOIN
        taskcons
        ON
            contracts.contract_id = taskcons.contract_id


        group by tasks.task_parent) as a'),
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
        sum( COALESCE(tasks.task_mm_budget,0))  as total_task_mm_budget_1,
        sum( COALESCE(tasks.task_pay,0)) as total_pay_1
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
        as cost_no_pa_2 ,
        sum( COALESCE(tasks.task_mm_budget,0))  as total_task_mm_budget_2,
        sum( COALESCE(tasks.task_pay,0)) as total_pay_2
        from tasks  where tasks.task_type=2 group by tasks.task_parent) as ac'),
                'ac.task_parent',
                '=',
                'tasks.task_id'
            )
            ->leftJoin(DB::raw('(SELECT taskcons.task_id as s,
            taskcons.contract_id as c,
            taskcons.taskcon_pay
            FROM taskcons) as cc'), function ($join) {
                $join->on('cc.s', '=', 'tasks.task_id');
            })
            ->leftJoin(
                DB::raw('(select tasks.task_id,
                sum(COALESCE(tasks.task_pay,0)) as total_pay,
                sum(COALESCE(taskcons.taskcon_cost_gov_utility,0))
                +sum(COALESCE(taskcons.taskcon_cost_it_operating,0))
                +sum(COALESCE(taskcons.taskcon_cost_it_investment,0))
                as total_taskcon_cost_pa_1 ,
                sum(COALESCE(taskcons.taskcon_pay,0)) as total_taskcon_pay_pa_1

                from tasks
                INNER JOIN
                contract_has_tasks
                ON
                    tasks.task_id = contract_has_tasks.task_id
                INNER JOIN
                contracts
                ON
                    contract_has_tasks.contract_id = contracts.contract_id
                INNER JOIN
                taskcons
                ON
                    contracts.contract_id = taskcons.contract_id
                where tasks.task_type=1 group by tasks.task_id) as ad'),
                'ad.task_id',
                '=',
                'tasks.task_id'
            )



            ->where('project_id', ($id))
            ->get()
            ->toArray());
        //dd($tasks);


        ($tasks = json_decode(json_encode($tasks), true));

        foreach ($tasks as $task) {
            (float) $__budget_gov = (float) $task['task_budget_gov_operating'] + (float) $task['task_budget_gov_utility'] + (float) $task['task_budget_gov_investment'];
            (float) $__budget_it  = (float) $task['task_budget_it_operating'] + (float) $task['task_budget_it_investment'];

            ((float) $__budget_mm  = (float) $task['task_mm_budget']);
            ((float) $__costs  = (float) $task['costs_disbursement']);

            ((float) $__refund_pa_budget  = (float) $task['task_refund_pa_budget']);



            (float) $__budget     = $__budget_gov + $__budget_it;

            (float) $__cost = array_sum([
                (float)
                //$task['cost_disbursement'],




                $task['task_cost_gov_operating'],
                $task['task_cost_gov_investment'],
                $task['task_cost_gov_utility'],
                $task['task_cost_it_operating'],
                $task['task_cost_it_investment'],
              //  $task['total_taskcon_cost']
              //  $task['total_taskcon_cost_pa_1']
                // $task['task_cost_disbursement'],
                // $task['taskcon_ba_budget'],
                //$task['taskcon_bd_budget'],

            ]);

            // ((float) $__balance_pr = $__budget_mm - $__cost);
            //dd($__cost);


            $__balance_mmpr_sum = (float) $__budget_mm - $__refund_pa_budget;

            //dd($__balance_mmpr_sum);

            (float) $__balance = $__budget - $__cost;
            ($gantt[] = [
                'id'                    => 'T' . $task['task_id'] . $task['project_id'],
                'text'                  => $task['task_name'],
                'start_date'            => date('Y-m-d', strtotime($task['task_start_date'])),

                'end_date'              => date('Y-m-d', strtotime($task['task_end_date'])),
                'parent'                => $task['task_parent'] ? 'T' . $task['task_parent'] . $task['project_id'] : $task['project_id'],
                'parent_sum'            => '' . $task['task_id'] . $task['project_id'],

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
                'tbalance'               => $__balance,
                'cost'                  => $__cost+$task['cost_pa_1']+$task['cost_no_pa_2'],
                'total_taskcon_cost_pa_1'  => $task['total_taskcon_cost_pa_1'],


                'cost_pa_1'             => $task['cost_pa_1'],
                'cost_no_pa_2'             => $task['cost_no_pa_2'],
                'cost_disbursement'     => $project['cost_disbursement'],
                'pay'                   => $task['task_pay']+$task['total_taskcon_pay_pa_1']+$task['total_taskcon_pay']+$task['total_pay_1']+$task['total_pay_2'],
                'budget_mm'             => $task['task_mm_budget'],
                'task_refund_pa_budget'             => $task['task_refund_pa_budget'],

                'balanc_mmpr_sum'             => $__balance_mmpr_sum,
                'budget_total_task_mm'             => $task['total_task_mm_budget_task']+$task['total_task_mm_budget_1']+$task['total_task_mm_budget_2'],
                'budget_task_mm_1'             => $task['total_task_mm_budget_1'],
                'budget_task_mm_2'             => $task['total_task_mm_budget_2'],

                'cost_disbursement_task'     => $__costs,
                'task_total_pay'             => $task['total_pay']+$task['total_taskcon_pay']+$task['total_pay_1']+$task['total_pay_2'],

                'task_total_pay_1'             => $task['total_pay_1'],
                'task_total_pay_2'             => $task['total_pay_2'],
                'total_taskcon_pay'         =>  $task['total_taskcon_pay'],

                'total_taskcon_pay_pa_1'    =>  $task['total_taskcon_pay_pa_1'],
                'task_type'             => $task['task_type'],
                'type'                  => 'task',
                // 'owner' => $project['project_owner'],
            ]);

            $__project_cost[] = $__cost;
            ($__project_pay[] = $task['task_pay']);
            ($__project_parent[] = $task['task_parent'] ? 'T' . $task['task_parent'] . $task['project_id'] : $task['project_id']);
            ($__project_parent_cost[] = 'parent');
        }



       //  dd($gantt);


                    $contractgannt = DB::table('tasks')

                    ->join('contract_has_tasks', 'tasks.task_id', '=', 'contract_has_tasks.task_id')
                    ->join('contracts', 'contract_has_tasks.contract_id', '=', 'contracts.contract_id')
                    ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
                    ->join('taskcons', 'contracts.contract_id', '=', 'taskcons.contract_id')

                    ->select('tasks.*','tasks.*', 'contract_has_tasks.*', 'contracts.*','taskcons.*', 'a.total_cost', 'a.total_pay', 'ab.cost_pa_1', 'ac.cost_no_pa_2', 'projects.*')

                    ->leftJoin(
                        DB::raw('(select taskcons.taskcon_parent,
                sum( COALESCE(taskcons.taskcon_cost_gov_utility,0))
                +sum( COALESCE(taskcons.taskcon_cost_it_operating,0))
                +sum( COALESCE(taskcons.taskcon_cost_it_investment,0))
                as total_cost,
                sum( COALESCE(taskcons.taskcon_pay,0))  as total_pay
                from taskcons  group by taskcons.taskcon_parent) as a'),
                        'a.taskcon_parent',
                        '=',
                        'taskcons.taskcon_id'
                    )
                    ->leftJoin(
                        DB::raw('(select taskcons.taskcon_parent,
                sum(COALESCE(taskcons.taskcon_cost_gov_utility,0))
                +sum(COALESCE(taskcons.taskcon_cost_it_operating,0))
                +sum(COALESCE(taskcons.taskcon_cost_it_investment,0))
                as cost_pa_1 ,
                sum( COALESCE(taskcons.taskcon_pay,0)) as total_pay
                from taskcons
                where taskcons.taskcon_type=1 group by taskcons.taskcon_parent) as ab'),
                        'ab.taskcon_parent',
                        '=',
                        'taskcons.taskcon_id'
                    )
                    ->leftJoin(
                        DB::raw('(select taskcons.taskcon_parent,
                 sum(COALESCE(taskcons.taskcon_cost_gov_utility,0))
                +sum(COALESCE(taskcons.taskcon_cost_it_operating,0))
                +sum(COALESCE(taskcons.taskcon_cost_it_investment,0))
                as cost_no_pa_2 ,sum( COALESCE(taskcons.taskcon_pay,0))
                as total_pay
                from taskcons  where taskcons.taskcon_type=2 group by taskcons.taskcon_parent) as ac'),
                        'ac.taskcon_parent',
                        '=',
                        'taskcons.taskcon_id'
                    )





                    ->where('tasks.project_id', ($id))
                    ->get()
                    ->toArray();


                 //  dd($contractgannt);


        /*     $contractgannt = json_decode(json_encode($contractgannt), true);
           foreach ($contractgannt as $contract) {
            $gantt[] = [
                'id'                    =>'T' . $task['task_id'] . $task['project_id']. $contract['contract_id'],
                'task_parentd'           => $contract['task_parent'],
                'text'                  => $contract['contract_name'],

                'start_date' => date('Y-m-d', strtotime($contract['contract_start_date'])),
                'end_date'   => date('Y-m-d', strtotime($contract['contract_end_date'])),


                'open'                  => true,
                //'type'                  => 'project',
                'duration'              => 360,
                'contract_mm_budget'    => $contract['contract_mm_budget'],
                'contract_pr_budget'    => $contract['contract_pr_budget'],
                'contract_pa_budget'    => $contract['contract_pa_budget'],
                'contract_po_budget'    => $contract['contract_pa_budget'],
                'contract_er_budget'    => $contract['contract_er_budget'],
                'contract_cn_budget'    => $contract['contract_cn_budget'],
                'contract_oe_budget'    => $contract['contract_oe_budget'],
                'contract_ba_budget'    => $contract['contract_ba_budget'],
                'contract_bd_budget'    => $contract['contract_bd_budget'],
                'contract_pay'          => $contract['contract_pay'],
                'taskcon_pay'           => $contract['taskcon_pay'],
                'total_cost'            => $contract['total_cost'],
                'total_pay'             => $contract['total_pay'],
                'type'                  => 'contract',
            ];

        } */
           // dd($gantt);

          // dd($gantt);







           $data = DB::table('tasks')
           ->join('contract_has_tasks', 'tasks.task_id', '=', 'contract_has_tasks.task_id')
           ->join('contracts', 'contract_has_tasks.contract_id', '=', 'contracts.contract_id')
           ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
           ->join('taskcons', 'contracts.contract_id', '=', 'taskcons.contract_id')
           ->select(

               'taskcons.*'
           )
           ->where('tasks.project_id', ($id))
           ->get();


      //  dd($data);

        $data = json_decode(json_encode($data), true);
        /* foreach ($data as $taskcon) {
         $gantt[] = [

             'id'                    =>'T' . $task['task_id'] . $task['project_id']. $contract['contract_id'], $taskcon['taskcon_id'],
             'contract_id'                    => $taskcon['contract_id'],
             'task_parentd'           => $contract['task_parent'],
             'text'                  => $contract['contract_name'],

             'start_date' => date('Y-m-d', strtotime($contract['contract_start_date'])),
             'end_date'   => date('Y-m-d', strtotime($contract['contract_end_date'])),


             'open'                  => true,
             //'type'                  => 'project',
             'duration'              => 360,
             'contract_mm_budget'    => $contract['contract_mm_budget'],
             'contract_pr_budget'    => $contract['contract_pr_budget'],
             'contract_pa_budget'    => $contract['contract_pa_budget'],
             'contract_po_budget'    => $contract['contract_pa_budget'],
             'contract_er_budget'    => $contract['contract_er_budget'],
             'contract_cn_budget'    => $contract['contract_cn_budget'],
             'contract_oe_budget'    => $contract['contract_oe_budget'],
             'contract_ba_budget'    => $contract['contract_ba_budget'],
             'contract_bd_budget'    => $contract['contract_bd_budget'],
             'contract_pay'          => $contract['contract_pay'],

            // 'total_cost'            => $contractgannt['total_cost'],

             //'total_pay'             => $contractgannt['total_pay'],
             'type'                  => 'contract',
         ];

     } */








            // ($gntt[0]['cost']    =array_sum($__project_cost));
        //  ($gantt[0]['pay']    = array_sum($__project_pay));
        /*  if($__cost == 0)
        {
         $__balance_pr_sum = (float) $__cost;

     }elseif($__cost > 1)
     {
         $__balance_pr_sum = (float) $__budget_mm- $__cost;
     } */
        /*
        if($gantt[0]['total_cost'] == 0)
        {
            ($gantt[0]['balance_pr2'] = ( ($gantt[0]['budget']-$gantt[0]['budget_total_mm'])));

     }elseif($gantt[0]['total_cost']> 1)
     {
        ($gantt[0]['balance_pr1'] = ( ($gantt[0]['budget'])));
     } */

             //$gantt[0]['refund_pa_budget']= $gantt[0]['refund_pa_budget'];
       // ($gantt[0]['balance'] = $gantt[0]['balance'] - $gantt[0]['total_cost']);



        //  dd($gantt,$tasks);
        //  dd($gantt);
        // ($budget['mm']    = $gantt[0]['total_task_mm_budget']);
        //  $budget['balance_pr'] = $gantt[0]['balance_pr'];
        //$budget['budget_total_taskcon_pay_con'] = $__paycon;
        ($gantt[0]['budget_total_mm_pr2'] =  (($budget['total']-$gantt[0]['budget_total_mm'])+$gantt[0]['refund_pa_budget']));
       // $budget['budget_total_taskcon_pay_con'] = $gantt[0]['budget_total_taskcon_pay_con'];
        $budget['pay']    = $gantt[0]['total_pay']+$gantt[0]['total_taskcon_pay_con'];


        $budget['cost']    = $gantt[0]['total_cost'];
        //$budget['budget_total_mm_pr2'] = $gantt[0]['budget_total_mm_pr2'];
        $budget['balance'] = $gantt[0]['balance'];
        //  $budget['balance'] = $gantt[0]['balance'];




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

        //dd($labels,$fields);
        // งบict
        //1
        ($operating_budget_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_budget_it_operating,0)) As operating_budget_sum')
            ->where('tasks.task_type', 1)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($operating_budget_sum));
        ($operating_budget_sum = $json[0]->operating_budget_sum);
        ($operating_budget_sum = (float)$operating_budget_sum);



        ($operating_budget_sum_no = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_budget_it_operating,0)) As operating_budget_sum_no')
            ->where('tasks.task_type', 2)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($operating_budget_sum_no));
        ($operating_budget_sum_no = $json[0]->operating_budget_sum_no);
        ($operating_budget_sum_no = (float)$operating_budget_sum_no);

        ($op_budget= $operating_budget_sum+$operating_budget_sum_no);

        //dd($operating_budget_sum_no);
//2
        ($operating_pa_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_cost_it_operating,0)) As ospa')
            //->where('tasks.task_type', 1)
            ->where('tasks.task_type', 1)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($operating_pa_sum));
        ($ospa = $json[0]->ospa);
        ($ospa = (float)$ospa);


        ($operating_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_cost_it_operating,0)) As osa')
            //->where('tasks.task_type', 1)
            ->where('tasks.task_type', 2)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($operating_sum));
        ($osa = $json[0]->osa);
        ($osa = (float)$osa);


        //3

        ($operating_mm_pa = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_mm_budget,0)) As operating_mm_pa  ')
            ->where('tasks.task_budget_it_operating', '>', 1)
            ->where('tasks.task_type', 1)
            //->where('task_cost_gov_utility', '>', 1)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($operating_mm_pa));
        ($operating_mm_pa = $json[0]->operating_mm_pa);
        ($operating_mm_pa = (float)$operating_mm_pa);




        ($operating_mm_pa_no = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_mm_budget,0)) As operating_mm_pa_no')
            ->where('tasks.task_budget_it_operating', '>', 1)
            ->where('tasks.task_type', 2)
            //->where('task_cost_gov_utility', '>', 1)
            ->where('project_id', ($id))

            ->get());
        ($json = json_decode($operating_mm_pa_no));
        ($operating_mm_pa_no = $json[0]->operating_mm_pa_no);
        ($operating_mm_pa_no = (float)$operating_mm_pa_no);



       // dd($operating_mm_sum);

        //4

        ($operating_refund_pa = DB::table('tasks')
        ->selectRaw('SUM(COALESCE(task_refund_pa_budget,0)) As operating_refund_pa  ')
        ->where('tasks.task_budget_it_operating', '>', 1)
        ->where('tasks.task_type', 1)
        //->where('task_cost_gov_utility', '>', 1)
        ->where('project_id', ($id))
        ->get());
        ($json = json_decode($operating_refund_pa));
        ($operating_refund_pa = $json[0]->operating_refund_pa);
        ($operating_refund_pa = (float)$operating_refund_pa);


        ($operating_refund_pa_no = DB::table('tasks')
        ->selectRaw('SUM(COALESCE(task_refund_pa_budget,0)) As operating_refund_pa_no  ')
        ->where('tasks.task_budget_it_operating', '>', 1)
        ->where('tasks.task_type', 2)
        //->where('task_cost_gov_utility', '>', 1)
        ->where('project_id', ($id))
        ->get());
        ($json = json_decode($operating_refund_pa_no));
        ($operating_refund_pa_no = $json[0]->operating_refund_pa_no);
        ($operating_refund_pa_no = (float)$operating_refund_pa_no);
//5

            $op_mm=$operating_mm_pa+$operating_mm_pa_no;
            ($op_refund = $operating_refund_pa+$operating_refund_pa_no);
            $op_refund_mm_pr = $project['budget_it_operating']-($op_mm-$op_refund);

           // dd($op_refund_mm_pr);
//6
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
            ->where('projects.project_id', ($id))
            ->get());



            ($json = json_decode($operating_pay_sum_1));
        ($otpsa1 = $json[0]->iv);
        ($otpsa1 = (float)$otpsa1);



        ($operating_pay_sum_2 = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_pay,0)) as iv2')
            ->where('tasks.task_cost_it_operating', '>', 1)
            ->where('tasks.task_type', 2)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($operating_pay_sum_2));
        ($otpsa2 = $json[0]->iv2);
        ($otpsa2 = (float)$otpsa2);





        //ดำเนิน
        //1
        ($investment_budget_sum = DB::table('tasks')
        ->selectRaw('SUM(COALESCE(task_budget_it_investment,0)) As investment_budget_sum')
        ->where('tasks.task_type', 1)
        ->where('project_id', ($id))
        ->get());
    ($json = json_decode($investment_budget_sum));
    ($investment_budget_sum = $json[0]->investment_budget_sum);
    ($investment_budget_sum = (float)$investment_budget_sum);



    ($investment_budget_sum_no = DB::table('tasks')
        ->selectRaw('SUM(COALESCE(task_budget_it_investment,0)) As investment_budget_sum_no')
        ->where('tasks.task_type', 2)
        ->where('project_id', ($id))
        ->get());
    ($json = json_decode($investment_budget_sum_no));
    ($investment_budget_sum_no = $json[0]->investment_budget_sum_no);
    ($investment_budget_sum_no = (float)$investment_budget_sum_no);



    $is_budget = $investment_budget_sum + $investment_budget_sum_no ;


   // dd($is_budget);



//2
        ($investment_pa_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_cost_it_investment,0)) As ispa')
            ->where('tasks.task_cost_it_investment', '>', 1)
            ->where('tasks.task_type', 1)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($investment_pa_sum));
        ($ispa = $json[0]->ispa);
        ($ispa = (float)$ispa);

        ($investment_sum = DB::table('tasks')
        ->selectRaw('SUM(COALESCE(task_cost_it_investment,0)) As isa')

        ->where('tasks.task_cost_it_investment', '>', 1)
        ->where('tasks.task_type', 2)
        ->where('project_id', ($id))
        ->get());
    ($json = json_decode($investment_sum));
    ($isa = $json[0]->isa);
    ($isa = (float)$isa);
            //3
            ($investment_mm_pa = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_mm_budget,0)) As investment_mm_pa  ')
            ->where('tasks.task_budget_it_investment', '>', 1)
            ->where('tasks.task_type', 1)
            //->where('task_cost_gov_utility', '>', 1)
            ->where('project_id', ($id))
            ->get());
            ($json = json_decode($investment_mm_pa));
            ($investment_mm_pa = $json[0]->investment_mm_pa);
            ($investment_mm_pa = (float)$investment_mm_pa);


            ($investment_mm_pa_no = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_mm_budget,0)) As investment_mm_pa_no')
            ->where('tasks.task_budget_it_investment', '>', 1)
            ->where('tasks.task_type', 2)
            //->where('task_cost_gov_utility', '>', 1)
            ->where('project_id', ($id))

            ->get());
            ($json = json_decode($investment_mm_pa_no));
            ($investment_mm_pa_no = $json[0]->investment_mm_pa_no);
            ($investment_mm_pa_no = (float)$investment_mm_pa_no);

           // $is_mm = $investment_mm_pa +$investment_mm_pa_no ;

             //dd($is_mm);


                    //4

                    ($investment_refund_pa = DB::table('tasks')
                    ->selectRaw('SUM(COALESCE(task_refund_pa_budget,0)) As investment_refund_pa  ')
                    ->where('tasks.task_budget_it_investment', '>', 1)
                    ->where('tasks.task_type', 1)
                    //->where('task_cost_gov_utility', '>', 1)
                    ->where('project_id', ($id))
                    ->get());
                    ($json = json_decode($investment_refund_pa));
                    ($investment_refund_pa = $json[0]->investment_refund_pa);
                    ($investment_refund_pa = (float)$investment_refund_pa);


                    ($investment_refund_pa_no = DB::table('tasks')
                    ->selectRaw('SUM(COALESCE(task_refund_pa_budget,0)) As investment_refund_pa_no  ')
                    ->where('tasks.task_budget_it_investment', '>', 1)
                    ->where('tasks.task_type', 2)
                    //->where('task_cost_gov_utility', '>', 1)
                    ->where('project_id', ($id))
                    ->get());
                    ($json = json_decode($investment_refund_pa_no));
                    ($investment_refund_pa_no = $json[0]->investment_refund_pa_no);
                    ($investment_refund_pa_no = (float)$investment_refund_pa_no);
                    //5
                          $is_mm = $investment_mm_pa +$investment_mm_pa_no ;

                        ($is_refund = $investment_refund_pa+$investment_refund_pa_no);
                        $is_refund_mm_pr = $project['budget_it_investment']-($is_mm-$is_refund);

                        // dd($op_refund_mm_pr);
                    //6
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
            ->where('projects.project_id', ($id))
            ->get());
        ($json = json_decode($investment_pay_sum_1));
        ($itpsa1 = $json[0]->iv);
        ($itpsa1 = (float)$itpsa1);

        ($investment_pay_sum_2 = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_pay,0)) as iv')
            ->where('tasks.task_cost_it_investment', '>', 1)
            ->where('tasks.task_type', 2)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($investment_pay_sum_2));
        ($itpsa2 = $json[0]->iv);
        ($itpsa2 = (float)$itpsa2);


        ($investment_total_pay_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_pay,0)) as iv')
            ->where('tasks.task_cost_it_investment', '>', 1)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($investment_total_pay_sum));
        ($itpsa = $json[0]->iv);
        ($itpsa = (float)$itpsa);













        // สาธู
        ($ut_budget_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_budget_gov_utility,0)) As ut_budget_sum')
            ->where('tasks.task_type', 1)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($ut_budget_sum));
        ($ut_budget_sum = $json[0]->ut_budget_sum);
        ($ut_budget_sum = (float)$ut_budget_sum);

        //dd($ut_budget_sum);

        ($ut_budget_sum_no = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_budget_gov_utility,0)) As ut_budget_sum_no')
            ->where('tasks.task_type', 2)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($ut_budget_sum_no));
        ($ut_budget_sum_no = $json[0]->ut_budget_sum_no);
        ($ut_budget_sum_no = (float)$ut_budget_sum_no);


        //dd($ut_budget_sum_no);

        ($ut_pa_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_cost_gov_utility,0)) As utpcs')
            ->where('tasks.task_type', 1)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($ut_pa_sum));
        ($utpcs = $json[0]->utpcs);
        ($utpcs = (float)$utpcs);

        ($ut_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_cost_gov_utility,0)) As utsc')
            ->where('tasks.task_type', 2)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($ut_sum));
        ($utsc = $json[0]->utsc);
        ($utsc = (float)$utsc);



        ($ut_mm_pa_sum = DB::table('tasks')
        ->selectRaw('SUM(COALESCE(task_mm_budget,0)) As utsc_mm_pa  ')
        ->where('tasks.task_budget_gov_utility', '>', 1)
        ->where('tasks.task_type', 1)
        //->where('task_cost_gov_utility', '>', 1)
        ->where('project_id', ($id))
        ->get());
    ($json = json_decode($ut_mm_pa_sum));
    ($utsc_mm_pa = $json[0]->utsc_mm_pa);
    ($utsc_mm_pa = (float)$utsc_mm_pa);





        ($utsc_mm_pa_no = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_mm_budget,0)) As utsc_mm_pa_no  ')
            ->where('tasks.task_budget_gov_utility', '>', 1)
            ->where('tasks.task_type', 2)
            //->where('task_cost_gov_utility', '>', 1)
            ->where('project_id', ($id))

            ->get());
        ($json = json_decode($utsc_mm_pa_no));
        ($utsc_mm_pa_no = $json[0]->utsc_mm_pa_no);
        ($utsc_mm_pa_no = (float)$utsc_mm_pa_no);



        ($ut_refund_pa = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_refund_pa_budget,0)) As ut_refund_pa  ')
            ->where('tasks.task_budget_gov_utility', '>', 1)
            ->where('tasks.task_type', 1)
            //->where('task_cost_gov_utility', '>', 1)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($ut_refund_pa));
        ($ut_refund_pa = $json[0]->ut_refund_pa);
        ($ut_refund_pa = (float)$ut_refund_pa);


        ($ut_refund_pa_no = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_refund_pa_budget,0)) As ut_refund_pa_no  ')
            ->where('tasks.task_budget_gov_utility', '>', 1)
            ->where('tasks.task_type', 2)
            //->where('task_cost_gov_utility', '>', 1)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($ut_refund_pa_no));
        ($ut_refund_pa_no = $json[0]->ut_refund_pa_no);
        ($ut_refund_pa_no = (float)$ut_refund_pa_no);


        $utsc_mm = $utsc_mm_pa + $utsc_mm_pa_no;
        ($ut_refund = $ut_refund_pa + $ut_refund_pa_no);
        $ut_refund_mm_pr = $project['budget_gov_utility'] - ($utsc_mm - $ut_refund);


        // dd($utsc_mm,$ut_refund,$ut_refund_mm_pr,$ut_refund_pa_no,$utpcs,$utsc,$utsc_mm_pa,$utsc_mm_pa_no);



        ($ut_pay_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_pay,0)) As utsc_pay  ')
            ->where('tasks.task_type', 2)
            ->where('task_cost_gov_utility', '>', 1)
            ->where('project_id', ($id))

            ->get());
        ($json = json_decode($ut_pay_sum));
        ($utsc_pay = $json[0]->utsc_pay);
        ($utsc_pay = (float)$utsc_pay);


        ($ut_pay_pa_sum = DB::table('tasks')


            ->selectRaw('SUM(COALESCE(task_pay,0))+sum(COALESCE(taskcons.taskcon_pay,0)) as utsc_pay_pa,
            SUM(COALESCE(task_pay,0)) as utsc_pay_pa ,
            sum(COALESCE(taskcons.taskcon_pay,0)) as total_taskcon_pay')
            ->join('contract_has_tasks', 'tasks.task_id', '=', 'contract_has_tasks.task_id')
            ->join('contracts', 'contract_has_tasks.contract_id', '=', 'contracts.contract_id')
            ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            ->join('taskcons', 'contracts.contract_id', '=', 'taskcons.contract_id')




            ->where('tasks.task_type', 1)
            ->where('task_cost_gov_utility', '>', 1)
            ->where('projects.project_id', ($id))
            ->get());
        ($json = json_decode($ut_pay_pa_sum));
        ($utsc_pay_pa = $json[0]->utsc_pay_pa);
        ($utsc_pay_pa = (float)$utsc_pay_pa);






        // dd($utpcs,$utsc_pay_pa,$utsc_pay);





        $parent_sum_pa = DB::table('tasks')
            ->select('tasks.task_parent', 'a.cost_a')

            ->leftJoin(
                DB::raw('(select tasks.task_parent
        , sum( COALESCE(tasks.task_cost_it_investment,0)+ COALESCE(tasks.task_cost_it_operating,0)+ COALESCE(tasks.task_budget_gov_utility,0))
        as cost_a from tasks where tasks.task_parent is not null group by tasks.task_parent) as a'),
                'tasks.task_parent',
                '=',
                'tasks.task_id'
            )
            ->whereNotNull('tasks.task_parent')
            ->where('project_id', $id)
            ->get();

        ($parent_sum_pa);




        ($parent_sum_cd = DB::table('tasks')
            ->select('task_parent', DB::raw('sum(task_pay) as cost_app'))
            ->whereNotNull('task_parent')
            ->groupBy('task_parent')
            ->get()
        );


        $taskconoverview = DB::table('tasks')
            ->select('tasks.task_id as task_id', 'tasks.project_id as project_id', 'taskcons.taskcon_id as taskcons_id', 'tasks.task_name as task_name', 'taskcons.taskcon_name as taskcons_name')
            ->leftJoin('taskcons', 'tasks.task_id', '=', 'taskcons.task_id') // assuming 'id' is the primary key in 'tasks' and 'task_id' is the foreign key in 'taskcons'
            ->where('tasks.project_id', $id)
            ->get();
        $taskconoverviewcon = DB::table('tasks')
            ->select('tasks.task_id as task_id', 'tasks.project_id as project_id', 'contracts.contract_id as contract_id', 'taskcons.taskcon_id as taskcons_id', 'tasks.task_name as task_name', 'taskcons.taskcon_name as taskcons_name')
            ->join('contract_has_tasks', 'tasks.task_id', '=', 'contract_has_tasks.task_id')
            ->join('contracts', 'contract_has_tasks.contract_id', '=', 'contracts.contract_id')
            ->join('taskcons', 'contracts.contract_id', '=', 'taskcons.contract_id')
            ->where('tasks.project_id', $id)
            ->get();
        $contractoverviewcon = DB::table('tasks')
            ->select('tasks.task_id', 'projects.project_id', 'tasks.project_id', 'projects.project_name as project_name', 'taskcons.taskcon_id as taskcons_id', 'tasks.task_name as task_name', 'taskcons.taskcon_name as taskcons_name')
            ->join('taskcons', 'tasks.task_id', '=', 'taskcons.task_id')
            ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            ->get();


        //  dd($project->main_task_activity);

        // dd($taskconoverview,$taskconoverviewcon, $contractoverviewcon);

        //dd($project);
       // dd($gantt,$budget);

        //  $budget['total'] = $__budget;
        // ($budget['budget_total_mm'] = $__mm);



        $budget['ab'] = $budget['budget_total_mm'] - $budget['cost'];


        $budget['x'] = $budget['total'] - $budget['budget_total_mm'];
        $budget['xx'] = ($budget['total'] - $budget['budget_total_mm']) + $budget['ab'];
        $budget['y'] = $budget['total'] - $budget['cost'];


        $budget['z'] = max($budget['xx'], $budget['x']);

        //dd($budget,$tasks);

        //dd($budget = $request->all()); // รับข้อมูล budget ทั้งหมดจาก request

        $result = ($budget['xx'] > $budget['x']) ? $budget['xx'] - $budget['cost'] : $budget['x'];


        //dd($gantt,$budget,$result);

         // dd($gantt);
        $gantt = json_encode($gantt);

        return view('app.projects.view', compact(
            'is_refund_mm_pr',
            'is_budget',

            'op_refund_mm_pr',
            'op_budget',



            'ut_refund_mm_pr',
            'ut_refund_pa',
            'ut_refund_pa_no',
            'result',
            'utsc_mm_pa',
            'utsc_mm',
            'ut_budget_sum',
            'ut_budget_sum_no',
            'taskconssubno',
            'project',
            'itpsa1',
            'itpsa2',
            'otpsa1',
            'gantt',
            'budget',
            'parent_sum_pa',
            'parent_sum_cd',
            'ispa',
            'isa',
            'utsc',
            'utpcs',
            'ospa',
            'osa',
            'itpsa',
            'utsc_pay',
            'utsc_pay_pa',
            'otpsa2',
            'tasks'

        ));
    }


    public function create(Request $request)
    {
        $fiscal_year = $request->input('fiscal_year');
        if (!$fiscal_year) {
            $fiscal_year = date('Y') + 543; // Use current year if not provided
        }

        $reguiar_id = $request->input('reguiar_id');
        if (!$reguiar_id) {
            $reguiar_id = 1; // Use 1 as default if not provided
        }
        return view('app.projects.create', compact('fiscal_year', 'reguiar_id'));
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => 'กรุณากรอกข้อมูล :attribute',
            'date_format' => 'รูปแบบวันที่ไม่ถูกต้อง :attribute',
            'after_or_equal' => 'วันที่สิ้นสุดต้องเป็นวันที่หลังหรือเท่ากับวันที่เริ่มต้น :attribute',
            'integer' => 'กรุณากรอกตัวเลขเท่านั้น :attribute',
            // เพิ่มข้อความผิดพลาดเพิ่มเติมตามความเหมาะสม
        ];

        $request->validate([
            'project_name' => 'required',
            'reguiar_id' => 'required',
            'project_start_date' => 'required|date_format:d/m/Y',
            'project_end_date' => 'required|date_format:d/m/Y|after_or_equal:project_start_date',
            /*    'project_fiscal_year' => 'required|integer',
            'budget_gov_operating' => 'nullable|numeric',
            'budget_gov_investment' => 'nullable|numeric',
            'budget_gov_utility' => 'nullable|numeric',
            'budget_it_operating' => 'nullable|numeric',
            'budget_it_investment' => 'nullable|numeric',*/
        ], $messages);

        $start_date_obj = date_create_from_format('d/m/Y', $request->input('project_start_date'));
        $end_date_obj = date_create_from_format('d/m/Y', $request->input('project_end_date'));

        if ($start_date_obj === false || $end_date_obj === false) {
            // Handle date conversion error
            // You can either return an error message or use a default date
        } else {
            $start_date_obj->modify('-543 years');
            $end_date_obj->modify('-543 years');

            $start_date = date_format($start_date_obj, 'Y-m-d');
            $end_date = date_format($end_date_obj, 'Y-m-d');
        }

        // convert input to decimal or set it to null if empty
        $budget_gov_operating = $request->input('budget_gov_operating') !== null ? (float) str_replace(',', '', $request->input('budget_gov_operating')) : null;
        $budget_gov_investment = $request->input('budget_gov_investment') !== null ? (float) str_replace(',', '', $request->input('budget_gov_investment')) : null;
        $budget_gov_utility = $request->input('budget_gov_utility') !== null ? (float) str_replace(',', '', $request->input('budget_gov_utility')) : null;
        $budget_it_operating = $request->input('budget_it_operating') !== null ? (float) str_replace(',', '', $request->input('budget_it_operating')) : null;
        $budget_it_investment = $request->input('budget_it_investment') !== null ? (float) str_replace(',', '', $request->input('budget_it_investment')) : null;

        $project = new Project;
        $project->project_name = $request->input('project_name');
        $project->project_description = $request->input('project_description');
        $project->project_type = $request->input('project_type');
        $project->project_fiscal_year = $request->input('project_fiscal_year');
        $project->project_start_date = $start_date ?? date('Y-m-d 00:00:00');
        $project->project_end_date = $end_date ?? date('Y-m-d 00:00:00');
        $project->project_status = $request->input('project_status') ?? null;
        $project->budget_gov_operating = $budget_gov_operating;
        $project->budget_gov_investment = $budget_gov_investment;
        $project->budget_gov_utility = $budget_gov_utility;
        $project->budget_it_operating = $budget_it_operating;
        $project->budget_it_investment = $budget_it_investment;
        $project->reguiar_id = $request->input('reguiar_id');

        //   dd($project);

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
        ($project = Project::find($id));

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
        $id = Hashids::decode($project)[0];
        $project = Project::find($id);

        $messages = [
            'required' => 'กรุณากรอกข้อมูล :attribute',
            'date_format' => 'รูปแบบวันที่ไม่ถูกต้อง :attribute',
            'after_or_equal' => 'วันที่สิ้นสุดต้องเป็นวันที่หลังหรือเท่ากับวันที่เริ่มต้น :attribute',
            'integer' => 'กรุณากรอกตัวเลขเท่านั้น :attribute',
            // เพิ่มข้อความผิดพลาดเพิ่มเติมตามความเหมาะสม
        ];

        $request->validate([
            'project_name' => 'required',
            'reguiar_id' => 'required',
            'project_start_date' => 'required|date_format:d/m/Y',
            'project_end_date' => 'required|date_format:d/m/Y|after_or_equal:project_start_date',
            'project_fiscal_year' => 'required|integer',
            //'budget_gov_operating' => 'nullable|numeric',
            //'budget_gov_investment' => 'nullable|numeric',
            //'budget_gov_utility' => 'nullable|numeric',
            //'budget_it_operating' => 'nullable|numeric',
            //'budget_it_investment' => 'nullable|numeric',
        ], $messages);


        $start_date_obj = date_create_from_format('d/m/Y', $request->input('project_start_date'));
        $end_date_obj = date_create_from_format('d/m/Y', $request->input('project_end_date'));

        if ($start_date_obj === false || $end_date_obj === false) {
            // Handle date conversion error
            // You can either return an error message or use a default date
        } else {
            $start_date_obj->modify('-543 years');
            $end_date_obj->modify('-543 years');

            $start_date = date_format($start_date_obj, 'Y-m-d');
            $end_date = date_format($end_date_obj, 'Y-m-d');
        }

        // convert input to decimal or set it to null if empty
        $budget_gov_operating = $request->input('budget_gov_operating') !== null ? (float) str_replace(',', '', $request->input('budget_gov_operating')) : null;
        $budget_gov_investment = $request->input('budget_gov_investment') !== null ? (float) str_replace(',', '', $request->input('budget_gov_investment')) : null;
        $budget_gov_utility = $request->input('budget_gov_utility') !== null ? (float) str_replace(',', '', $request->input('budget_gov_utility')) : null;
        $budget_it_operating = $request->input('budget_it_operating') !== null ? (float) str_replace(',', '', $request->input('budget_it_operating')) : null;
        $budget_it_investment = $request->input('budget_it_investment') !== null ? (float) str_replace(',', '', $request->input('budget_it_investment')) : null;



        $project->project_name = $request->input('project_name');
        $project->project_description = trim($request->input('project_description'));
        $project->project_type = $request->input('project_type');
        $project->project_fiscal_year = $request->input('project_fiscal_year');
        $project->project_start_date = $start_date ?? date('Y-m-d 00:00:00');
        $project->project_end_date = $end_date ?? date('Y-m-d 00:00:00');
        $project->project_status = $request->input('project_status') ?? null;

        //convert input to decimal or set it to null if empty
        $budget_gov_utility = $request->input('budget_gov_utility') !== '' ? (float) str_replace(',', '', $request->input('budget_gov_utility')) : null;
        $budget_it_operating = $request->input('budget_it_operating') !== '' ? (float) str_replace(',', '', $request->input('budget_it_operating')) : null;
        $budget_it_investment = $request->input('budget_it_investment') !== '' ? (float) str_replace(',', '', $request->input('budget_it_investment')) : null;

        $project->budget_gov_operating = $budget_gov_operating;
        $project->budget_gov_investment = $budget_gov_investment;
        $project->budget_gov_utility = $budget_gov_utility;
        $project->budget_it_operating = $budget_it_operating;
        $project->budget_it_investment = $budget_it_investment;
        $project->reguiar_id = $request->input('reguiar_id');

        if ($project->save()) {
            return redirect()->route('project.index');
        }
    }

    public function CreateSubno(Request $request, $project, $task = null)
    {
        // $id = Hashids::decode($project)[0];
        $taskcons     = new Taskcon;
        $fiscal_year = $request->input('fiscal_year');
        if (!$fiscal_year) {
            $fiscal_year = date('Y') + 543; // Use current year if not provided
        }

        $reguiar_id = $request->input('reguiar_id');
        if (!$reguiar_id) {
            $reguiar_id = 1; // Use 1 as default if not provided
        }

        return view('app.projects.createsubno', compact('request',  'project', 'taskcons', 'fiscal_year', 'reguiar_id'));

        /*   return view('app.projects.tasks.createsub', compact(   'request','contracts', 'project', 'tasks', 'task')); */
    }


    public function Storesubno(Request $request)
    {
        // Create a new Project object
        $project = new Project;
        $project->project_name = $request->input('project_name');
        $project->reguiar_id = $request->input('reguiar_id');
        $project->project_fiscal_year = $request->input('project_fiscal_year');
        $project->project_type = $request->input('project_type');
        $start_date_obj = date_create_from_format('d/m/Y', $request->input('project_start_date'));
        $end_date_obj = date_create_from_format('d/m/Y', $request->input('project_end_date'));

        if ($start_date_obj === false || $end_date_obj === false) {
            // Handle date conversion error
            // You can either return an error message or use a default date
        } else {
            $start_date_obj->modify('-543 years');
            $end_date_obj->modify('-543 years');

            $start_date = date_format($start_date_obj, 'Y-m-d');
            $end_date = date_format($end_date_obj, 'Y-m-d');
        }

        // Save the Project
        if (!$project->save()) {
            // If the Project failed to save, redirect back with an error message
            return redirect()->back()->withErrors('An error occurred while saving the project. Please try again.');
        }  // <-- This closing bracket was missing

        // Create a new Taskcon object
        $taskcon = new Taskcon;

        // Fill the Taskcon fields from the request
        $taskcon->fill($request->only(['field1', 'field2', 'field3'])); // replace 'field1', 'field2', 'field3' with the actual fields of Taskcon

        // Assign the project_id to the Taskcon
        $taskcon->project_id = $project->project_id; // Use the id of the newly created project
        $taskcon->taskcon_name        = $request->input('taskcon_name');

        $start_date_obj = date_create_from_format('d/m/Y', $request->input('taskcon_start_date'));
        $end_date_obj = date_create_from_format('d/m/Y', $request->input('taskcon_end_date'));
        $pay_date_obj = date_create_from_format('d/m/Y', $request->input('taskcon_pay_date'));

        if ($start_date_obj === false || $end_date_obj === false  || $pay_date_obj === false) {
            // Handle date conversion error
            // You can either return an error message or use a default date
        } else {
            $start_date_obj->modify('-543 years');
            $end_date_obj->modify('-543 years');
            $pay_date_obj->modify('-543 years');
            $start_date = date_format($start_date_obj, 'Y-m-d');
            $end_date = date_format($end_date_obj, 'Y-m-d');
            $pay_date = date_format($pay_date_obj, 'Y-m-d');
        }


        // convert input to decimal or set it to null if empty
        $taskcon_budget_it_operating = str_replace(',', '', $request->input('taskcon_budget_it_operating'));
        $taskcon_budget_gov_utility = str_replace(',', '', $request->input('taskcon_budget_gov_utility'));
        $taskcon_budget_it_investment = str_replace(',', '', $request->input('taskcon_budget_it_investment'));


        $taskcon_cost_it_operating = str_replace(',', '', $request->input('taskcon_cost_it_operating'));
        $taskcon_cost_gov_utility = str_replace(',', '', $request->input('taskcon_cost_gov_utility'));
        $taskcon_cost_it_investment = str_replace(',', '', $request->input('taskcon_cost_it_investment'));

        $taskcon_pay = str_replace(',', '', $request->input('taskcon_pay'));

        $taskcon_mm_budget = str_replace(',', '', $request->input('taskcon_mm_budget'));

        $taskcon_ba_budget = str_replace(',', '', $request->input('taskcon_ba_budget'));

        $taskcon_bd_budget = str_replace(',', '', $request->input('taskcon_bd_budget'));


        if ($taskcon_budget_it_operating === '') {
            $taskcon_budget_it_operating = null; // or '0'
        }

        if ($taskcon_budget_gov_utility === '') {
            $taskcon_budget_gov_utility = null; // or '0'
        }

        if ($taskcon_budget_it_investment === '') {
            $taskcon_budget_it_investment = null; // or '0'
        }

        if ($taskcon_cost_it_operating === '') {
            $taskcon_cost_it_operating = null; // or '0'
        }

        if ($taskcon_cost_gov_utility === '') {
            $taskcon_cost_gov_utility = null; // or '0'
        }

        if ($taskcon_cost_it_investment === '') {
            $taskcon_cost_it_investment = null; // or '0'
        }

        if ($taskcon_pay === '') {
            $taskcon_pay = null; // or '0'
        }
        if ($taskcon_mm_budget === '') {
            $taskcon_mm_budget = null; // or '0'
        }
        if ($taskcon_ba_budget === '') {
            $taskcon_ba_budget = null; // or '0'
        }
        if ($taskcon_bd_budget === '') {
            $taskcon_bd_budget = null; // or '0'
        }


        //convert date
        //   $start_date = date_format(date_create_from_format('d/m/Y', $request->input('taskcon_start_date')), 'Y-m-d');
        // $end_date   = date_format(date_create_from_format('d/m/Y', $request->input('taskcon_end_date')), 'Y-m-d');


        $taskcon->taskcon_name        = $request->input('taskcon_name');
        $taskcon->taskcon_mm_name        = $request->input('taskcon_mm_name');
        $taskcon->taskcon_mm        = $request->input('taskcon_mm');
        $taskcon->taskcon_ba        = $request->input('taskcon_ba');
        $taskcon->taskcon_bd       = $request->input('taskcon_bd');

        $taskcon->taskcon_description = trim($request->input('taskcon_description'));
        $taskcon->taskcon_start_date  = $start_date ?? date('Y-m-d 00:00:00');
        $taskcon->taskcon_end_date    = $end_date ?? date('Y-m-d 00:00:00');
        $taskcon->taskcon_pay_date     =  $pay_date ?? date('Y-m-d 00:00:00');

        $taskcon->taskcon_parent = $request->input('taskcon_parent') ?? null;
        //convert input to decimal or set it to null if empty

        $taskcon->taskcon_budget_gov_utility    = $taskcon_budget_gov_utility;
        $taskcon->taskcon_budget_it_operating   = $taskcon_budget_it_operating;
        $taskcon->taskcon_budget_it_investment  = $taskcon_budget_it_investment;

        $taskcon->taskcon_cost_gov_utility    = $taskcon_cost_gov_utility;
        $taskcon->taskcon_cost_it_operating   = $taskcon_cost_it_operating;
        $taskcon->taskcon_cost_it_investment  = $taskcon_cost_it_investment;
        $taskcon->taskcon_pay                 =  $taskcon_pay;
        $taskcon->taskcon_mm_budget                 =  $taskcon_mm_budget;
        $taskcon->taskcon_ba_budget                 =  $taskcon_ba_budget;
        $taskcon->taskcon_bd_budget                 =  $taskcon_bd_budget;

        $taskcon->taskcon_description = trim($request->input('taskcon_description'));
        // Save the Taskcon
        if (!$taskcon->save()) {
            // If the Taskcon failed to save, redirect back with an error message
            return redirect()->back()->withErrors('An error occurred while saving the task. Please try again.');
        }

        // If both the Project and Taskcon saved successfully, redirect to project.index
        return redirect()->route('project.index');
    }



    public function CreateSub(Request $request)
    {
        // Get $project from $request, if it's there. If not, set to null.
        $project = $request->get('project', null);

        // ดึงข้อมูลทั้งหมดจากตาราง contracts โดยเรียงตาม contract_fiscal_year จากมากไปน้อย
        $contracts = Contract::orderBy('contract_fiscal_year', 'desc')->get();
        $fiscal_year = $request->input('fiscal_year');
        if (!$fiscal_year) {
            $fiscal_year = date('Y') + 543; // Use current year if not provided
        }

        $reguiar_id = $request->input('reguiar_id');
        if (!$reguiar_id) {
            $reguiar_id = 1; // Use 1 as default if not provided
        }
        // ถอดรหัสตัวแปร $project และดึงข้อมูล Project
        if ($project) {
            $decodedProjectId = Hashids::decode($project)[0];
            $project = Project::find($decodedProjectId);
        } else {
            $project = null;
        }

        // ส่งคืน view พร้อมกับข้อมูลที่จำเป็น
        return view('app.projects.createsub', compact('request', 'contracts', 'project', 'fiscal_year', 'reguiar_id'));
    }





    public function Storesub(Request $request)
    {
        // Create a new Project object
        $project = new Project;
        $project->project_name = $request->input('project_name');
        $project->reguiar_id = $request->input('reguiar_id');
        $project->project_fiscal_year = $request->input('project_fiscal_year');
        $project->project_type = $request->input('project_type');

        // Save the project
        if (!$project->save()) {
            // If the project failed to save, redirect back with an error message
            return redirect()->back()->withErrors('An error occurred while saving the project. Please try again.');
        }

        // Assuming taskcon_name is an array with contract_id as the key and taskcon_name as the value
        if ($request->has('taskcon_name')) {
            foreach ($request->input('taskcon_name') as $contract_id => $taskcon_name) {
                $contract = $project->contracts->firstWhere('contract_id', $contract_id);

                if (!$contract) {
                    continue;
                }

                $taskcon = $contract->taskcons->firstWhere('taskcon_name', $taskcon_name);

                if (!$taskcon) {
                    continue;
                }

                // Use $taskcon here
            }
        }

        // Continue processing as needed...

        // If both the Project and Taskcon saved successfully, redirect to project.index
        return redirect()->route('project.index');
    }








    /*  public function store(Request $request)
    {


        $messages = [
            // 'project_end_date.after_or_equal' => 'วันที่สิ้นสุดต้องหลังจากวันที่เริ่มต้น',
        ];

        $request->validate([
            'project_name' => 'required',
            'reguiar_id' => 'required',
            // 'project_start_date' => 'required|date_format:d/m/Y',
            //'project_end_date' => 'required|date_format:d/m/Y',
            //'project_fiscal_year' => 'required|integer',
            //'start_date' => 'required|date_format:d/m/Y',
            //'end_date' => 'required|date_format:d/m/Y|after_or_equal:start_date',
        ], $messages);

        $start_date_obj = date_create_from_format('d/m/Y', $request->input('project_start_date'));
        $end_date_obj = date_create_from_format('d/m/Y', $request->input('project_end_date'));

        if ($start_date_obj === false || $end_date_obj === false) {
            // Handle date conversion error
            // You can either return an error message or use a default date
        } else {
            $start_date_obj->modify('-543 years');
            $end_date_obj->modify('-543 years');

            $start_date = date_format($start_date_obj, 'Y-m-d');
            $end_date = date_format($end_date_obj, 'Y-m-d');
        }



        // convert input to decimal or set it to null if empty
        $budget_it_operating = str_replace(',', '', $request->input('budget_it_operating'));
        $budget_gov_utility = str_replace(',', '', $request->input('budget_gov_utility'));
        $budget_it_investment = str_replace(',', '', $request->input('budget_it_investment'));

        if ($budget_it_operating === '') {
            $budget_it_operating = null; // or '0'
        }

        if ($budget_gov_utility === '') {
            $budget_gov_utility = null; // or '0'
        }

        if ($budget_it_investment === '') {
            $budget_it_investment = null; // or '0'
        }

        $project = new Project;
        $project->project_name        = $request->input('project_name');
        $project->project_description = $request->input('project_description');
        $project->project_type        = $request->input('project_type');
        $project->project_fiscal_year = $request->input('project_fiscal_year');
        $project->project_start_date  = $start_date ?? date('Y-m-d 00:00:00');
        $project->project_end_date    = $end_date ?? date('Y-m-d 00:00:00');
        $project->project_status      = $request->input('project_status') ?? null;

        $project->budget_gov_operating  = $request->input('budget_gov_operating');
        $project->budget_gov_investment = $request->input('budget_gov_investment');
        $project->budget_gov_utility    = $budget_gov_utility;
        $project->budget_it_operating   = $budget_it_operating;
        $project->budget_it_investment  = $budget_it_investment;
        $project->reguiar_id            = $request->input('reguiar_id');


        ($project);

        if ($project->save()) {
            return redirect()->route('project.index');
        }
    } */



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

        ($project = Project::find(Hashids::decode($project)[0]));
        ($task = Task::find(Hashids::decode($task)[0]));

        /*
        $contract    = Contract::find($contract_id);
        $taskcon       = taskcon::find($taskcon_id);
        ($id_contract = Hashids::decode($contract)[0]);
        $id_taskcon    = Hashids::decode($taskcon)[0]; */

       ($tasks=$task->subtask);
        //  dd($task);
        //   dd($project,$task);
        ($sum_task_budget_it_operating = $task->whereNull('task_parent')->sum('task_budget_it_operating'));
        $sum_task_budget_it_investment = $task->whereNull('task_parent')->sum('task_budget_it_investment');
        $sum_task_budget_gov_utility = $task->whereNull('task_parent')->sum('task_budget_gov_utility');

        ($sum_task_budget_it_operating_ts = $tasks->where('task_parent')->sum('task_budget_it_operating'));
        $sum_task_refund_budget_it_operating= $tasks->where('task_parent')->where('task_budget_it_operating', '>', 1)->sum('task_refund_pa_budget');


       // dd($sum_task_budget_it_operating_ts, $sum_task_refund_budget_it_operating);

        $contract = Contract::join('contract_has_tasks', 'contracts.contract_id', '=', 'contract_has_tasks.contract_id')
            ->join('tasks', 'contract_has_tasks.task_id', '=', 'tasks.task_id')
            ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            ->select('contracts.*', 'projects.*', 'tasks.*')




            ->where('projects.project_id', $project->project_id)
            ->where('tasks.task_id', $task->task_id)
            ->first();

        /*
        $contract = Contract::join('contract_has_tasks', 'contracts.contract_id', '=', 'contract_has_tasks.contract_id')
            ->join('tasks', 'contract_has_tasks.task_id', '=', 'tasks.task_id')
            ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            ->select('contracts.*', 'projects.*', 'tasks.*')
            ->where('projects.project_id', $project->project_id)
            ->where('tasks.task_id', $task->task_id)
            ->first(); */

        //   dd($contract);

        $taskcons = Task::join('taskcons', 'tasks.task_id', '=', 'taskcons.task_id')
            ->select(
                'tasks.*',
                'taskcons.taskcon_mm',
                'taskcons.taskcon_mm_name',
                'taskcons.taskcon_pp',
                'taskcons.taskcon_pp_name',
                'taskcons.taskcon_pay_date',
                'taskcons.taskcon_pay'
            )
            ->where('tasks.task_id', $task->task_id)
            ->get();

        // dd($taskcons);

        /*         $task = Task::
         join('taskcons', 'tasks.task_id', '=', 'taskcons.task_id')
         ->select('tasks.*','taskcons.taskcon_id', 'taskcons.taskcon_mm','taskcons.taskcon_mm_name','taskcons.taskcon_pay','taskcons.taskcon_pp_name','taskcons.taskcon_pay_date','taskcons.taskcon_pp') // make sure taskcon_mm is included in taskcons.*
         ->where('tasks.task_id', $id_task)
         ->first(); */

        $results = Contract::join('taskcons', 'contracts.contract_id', '=', 'taskcons.contract_id')
            ->join('contract_has_tasks', 'contracts.contract_id', '=', 'contract_has_tasks.contract_id')
            ->join('tasks', 'contract_has_tasks.task_id', '=', 'tasks.task_id')
            ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            ->select('contracts.*', 'taskcons.*', 'projects.*', 'tasks.*')
            ->where('projects.project_id', $project->project_id)
            ->where('tasks.task_id', $task->task_id)
            ->get();


        $results2 = DB::table('taskcons')
            ->join('tasks', 'tasks.task_id', '=', 'taskcons.task_id')
            ->join('projects', 'projects.project_id', '=', 'tasks.project_id')
            ->select('taskcons.*')
            ->where('projects.project_id', $project->project_id)
            ->where('tasks.task_id', $task->task_id)
            ->get();







        //dd($results,$results2);

       // dd($task->subtask);



                $task_sub = $task->subtask;

                $sum_tasksub_budget_it_operating = $task_sub->sum('task_budget_it_operating');
                $sum_tasksub_cost_budget_it_operating= $task_sub->where('task_budget_it_operating', '>', 1)->sum('task_cost_it_operating');
                $sum_tasksub_refund_budget_it_operating= $task_sub->where('task_budget_it_operating', '>', 1)->sum('task_refund_pa_budget');
                $sum_tasksub_mm_budget= $task_sub->where('task_budget_it_operating', '>', 1)->sum('task_mm_budget');


/*
                $task_sub_op_sums = $task_sub->reduce(function ($carry, $subtask) {
                    if ($subtask->task_budget_it_operating > 1) {
                        $carry['task_budget_it_operating'] += $subtask->task_budget_it_operating;
                        $carry['task_cost_it_operating'] += $subtask->task_cost_it_operating;
                        $carry['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;
                        $carry['task_mm_budget'] += $subtask->task_mm_budget;
                    }
                    return $carry;
                }, ['task_budget_it_operating' => 0, 'task_cost_it_operating' => 0, 'task_refund_pa_budget' => 0, 'task_mm_budget' => 0]); */



                $task_sub_sums = $task_sub->reduce(function ($carry, $subtask) {
                    if ($subtask->task_budget_it_operating > 1) {
                        $carry['operating']['task_budget'] += $subtask->task_budget_it_operating;
                        $carry['operating']['task_cost'] += $subtask->task_cost_it_operating;
                        $carry['operating']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;
                        $carry['operating']['task_mm_budget'] += $subtask->task_mm_budget;
                    }

                    if ($subtask->task_budget_it_investment > 1) {
                        $carry['investment']['task_budget'] += $subtask->task_budget_it_investment;
                        $carry['investment']['task_cost'] += $subtask->task_cost_it_investment;
                        $carry['investment']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;
                        $carry['investment']['task_mm_budget'] += $subtask->task_mm_budget;


                        // Add other fields as necessary...
                    }

                    if ($subtask->task_budget_gov_utility > 1) {
                        $carry['utility']['task_budget'] += $subtask->task_budget_gov_utility;
                        $carry['utility']['task_cost'] += $subtask->task_cost_gov_utility;
                        $carry['utility']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;
                        $carry['utility']['task_mm_budget'] += $subtask->task_mm_budget;


                        // Add other fields as necessary...
                    }

                    return $carry;
                }, ['operating' => ['task_budget' => 0, 'task_cost' => 0, 'task_refund_pa_budget' => 0, 'task_mm_budget' => 0],
                    'investment' => ['task_budget' => 0, 'task_cost' => 0, 'task_refund_pa_budget' => 0, 'task_mm_budget' => 0],
                    'utility' => ['task_budget' => 0, 'task_cost' => 0, 'task_refund_pa_budget' => 0, 'task_mm_budget' => 0]]);

                    ($files = File::join('tasks', 'files.task_id', '=', 'tasks.task_id')
                    ->where('tasks.task_id', $task->task_id)
                    ->get());


                    ($files_contract = File::join('contracts', 'files.contract_id', '=', 'contracts.contract_id')
                   // ->join('taskcons', 'contracts.contract_id', '=', 'taskcons.contract_id')
            ->join('contract_has_tasks', 'contracts.contract_id', '=', 'contract_has_tasks.contract_id')
            ->join('tasks', 'contract_has_tasks.task_id', '=', 'tasks.task_id')
            ->join('projects', 'tasks.project_id', '=', 'projects.project_id')

                    ->where('tasks.task_id', $task->task_id)


                    ->get());

               //dd($task_sub_sums,$sum_tasksub_budget_it_operating,$sum_tasksub_cost_budget_it_operating,$sum_tasksub_refund_budget_it_operating,$sum_tasksub_mm_budget);
        ($latestContract = Contract::latest()->first());

      //  dd($task->subtask);

       //dd($contract);

       // dd($latestContract,$results,$taskcons,$contract,$project,$task);
        return view('app.projects.tasks.show', compact('files_contract','files','task_sub_sums','taskcons',
        'project', 'task', 'results', 'contract', 'latestContract',
        'sum_task_budget_it_operating', 'sum_task_budget_it_investment', 'sum_task_budget_gov_utility'));
    }




    public function taskCreate(Request $request, $project, $task = null)
    {
        $id        = Hashids::decode($project)[0];
        $project = $request->project;
        //  ($project = Project::find($id)); // รับข้อมูลของโครงการจากฐานข้อมูล
        ($tasks     = Task::where('project_id', $id)->get());
        ($taskcons     = Taskcon::where('task_id', $id)->get());
        $contracts = contract::orderBy('contract_fiscal_year', 'desc')->get();

        ($request = Project::find($id));

        $sum_task_budget_it_operating = $tasks->whereNull('task_parent')->sum('task_budget_it_operating');
        $sum_task_refund_budget_it_operating= $tasks->whereNull('task_parent')->where('task_budget_it_operating', '>', 1)->sum('task_refund_pa_budget');

        // Sum the task_budget_it_investment for all tasks
        $sum_task_budget_it_investment = $tasks->whereNull('task_parent')->sum('task_budget_it_investment');
        $sum_task_refund_budget_it_investment= $tasks->whereNull('task_parent') ->where('task_budget_it_investment', '>', 1)->sum('task_refund_pa_budget');

        // Sum the task_budget_gov_utility for all tasks
        $sum_task_budget_gov_utility = $tasks->whereNull('task_parent')->sum('task_budget_gov_utility');
        $sum_task_refund_budget_gov_utility= $tasks->whereNull('task_parent')->where('task_budget_gov_utility', '>', 1)->sum('task_refund_pa_budget');

        if ($task) {
            $taskId = Hashids::decode($task)[0];
            $task = Task::find($taskId);
        } else {
            $task = null;
        }
        //dd ($taskcons,$request,$contracts, $project,$tasks,$task, $sum_task_budget_it_operating, $sum_task_budget_it_investment, $sum_task_budget_gov_utility);
        return view('app.projects.tasks.create', compact('request',
         'taskcons', 'contracts', 'project', 'tasks', 'task',
         'sum_task_budget_it_operating',
         'sum_task_budget_it_investment',
         'sum_task_budget_gov_utility',
         'sum_task_refund_budget_it_operating',
         'sum_task_refund_budget_it_investment',
         'sum_task_refund_budget_gov_utility'));
    }



    public function taskCreatecn(Request $request, $project, $task = null)
    {
        $id        = Hashids::decode($project)[0];
        $project = $request->project;
        $projectDetails = Project::find($id);
        //  ($project = Project::find($id)); // รับข้อมูลของโครงการจากฐานข้อมูล
        ($tasks     = Task::where('project_id', $id)->get());
        $contracts = contract::orderBy('contract_fiscal_year', 'desc')->get();
        $projectyear = Project::where('project_id', $id)->first(); // เปลี่ยนจาก get() เป็น first()

        ($request = Project::find($id));






        $sum_task_budget_it_operating = $tasks->whereNull('task_parent')->sum('task_budget_it_operating');
        $sum_task_refund_budget_it_operating= $tasks->whereNull('task_parent')->where('task_budget_it_operating', '>', 1)->sum('task_refund_pa_budget');

        // Sum the task_budget_it_investment for all tasks
        $sum_task_budget_it_investment = $tasks->whereNull('task_parent')->sum('task_budget_it_investment');
        $sum_task_refund_budget_it_investment= $tasks->whereNull('task_parent') ->where('task_budget_it_investment', '>', 1)->sum('task_refund_pa_budget');

        // Sum the task_budget_gov_utility for all tasks
        $sum_task_budget_gov_utility = $tasks->whereNull('task_parent')->sum('task_budget_gov_utility');
        $sum_task_refund_budget_gov_utility= $tasks->whereNull('task_parent')->where('task_budget_gov_utility', '>', 1)->sum('task_refund_pa_budget');

        //dd( $sum_task_refund_budget_it_operating,$sum_task_refund_budget_it_investment,$sum_task_refund_budget_gov_utility);





  /*       // Sum the task_budget_it_operating for all tasks
        $sum_task_budget_it_operating = $tasks->whereNull('task_parent')->sum('task_budget_it_operating');

        // Sum the task_budget_it_investment for all tasks
        $sum_task_budget_it_investment = $tasks->whereNull('task_parent')->sum('task_budget_it_investment');

        // Sum the task_budget_gov_utility for all tasks
        $sum_task_budget_gov_utility = $tasks->whereNull('task_parent')->sum('task_budget_gov_utility');

 */



        if ($task) {
            $taskId = Hashids::decode($task)[0];
            $task = Task::find($taskId);
        } else {
            $task = null;
        }


        $projectData = DB::table('projects')
        //  ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
        ->select('projects.*')
        ->where('project_id', $id)
        //->orderBy('projects.project_fiscal_year', 'DESC')
        ->get();
    //  dd($projectData);
    $projectData = $projectData->map(function ($p) {
        return [
            'id' => $p->project_id,
            'project_fiscal_year' => $p->project_fiscal_year,
            'project_id' => $p->project_id,
            'project_name' => $p->project_name,
            // 'task_parent_id' => $task->task_parent,
            //'text' => $task->task_name,
            'budget_it_operating' => $p->budget_it_operating,
            'budget_it_investment' => $p->budget_it_investment,
            'budget_gov_utility' => $p->budget_gov_utility,
        ];
    });

    // dd($projectData);

    $projectsJson = json_encode($projectData);






        //       dd ($request,$contracts, $project,$tasks,$task, $sum_task_budget_it_operating, $sum_task_budget_it_investment, $sum_task_budget_gov_utility);
        return view('app.projects.tasks.createcn', compact('request',
        'contracts', 'project', 'tasks', 'task',
        'sum_task_budget_it_operating',
        'sum_task_budget_it_investment',
        'sum_task_budget_gov_utility',
        'sum_task_refund_budget_it_operating',
        'sum_task_refund_budget_it_investment',
        'sum_task_refund_budget_gov_utility',
    'projectData',
        'projectsJson',
    'projectyear',
    'projectDetails'));
    }

    public function taskCreateTo(Request $request, $project, $task = null)
    {
        $id = Hashids::decode($project)[0];

        ($tasks = Task::where('project_id', $id)->get());
        $contracts = Contract::orderBy('contract_fiscal_year', 'desc')->get();
        ($request = Project::find($id));

        // Get the task_budget_it_operating for $task->task_id tasks
        $task_budget_it_operating = $tasks->where('task_parent', null)->pluck('task_budget_it_operating')->sum();

        // Get the task_budget_it_investment for $task->task_id tasks
        $task_budget_it_investment = $tasks->where('task_parent', null)->pluck('task_budget_it_investment')->sum();

        // Get the task_budget_gov_utility for $task->task_id tasks
        $task_budget_gov_utility = $tasks->where('task_parent', null)->pluck('task_budget_gov_utility')->sum();



        if ($task) {
            $taskId = Hashids::decode($task)[0];
            $task = Task::find($taskId);
        } else {
            $task = null;
        }


        // dd($tasks);

        return view('app.projects.tasks.createto', compact('request', 'contracts', 'project', 'tasks', 'task', 'task_budget_it_operating', 'task_budget_it_investment', 'task_budget_gov_utility'));
    }




    public function taskCreateSub(Request $request, $project, $task = null)
    {
        $id = Hashids::decode($project)[0];
        //$project = Project::find($projectId);
        $tasks = Task::where('project_id', $id)->get();
        ($contracts = contract::orderBy('contract_fiscal_year', 'desc')->get());







        // Sum the task_budget_it_operating for all tasks
        $sum_task_budget_it_operating = $tasks->whereNull('task_parent')->sum('task_budget_it_operating');
        ($sum_task_cost_it_operating= $tasks->where('task_parent')->sum('task_cost_it_operating'));

        $sum_task_refund_budget_it_operating= $tasks->where('task_parent')->sum('task_refund_pa_budget');

        // Sum the task_budget_it_investment for all tasks
        $sum_task_budget_it_investment = $tasks->whereNull('task_parent')->sum('task_budget_it_investment');
        ($sum_task_cost_it_investment= $tasks->where('task_parent')->sum('task_cost_it_investment'));


        ($sum_task_refund_budget_it_investment= $tasks->where('task_parent')->sum('task_refund_pa_budget'));

        // Sum the task_budget_gov_utility for all tasks
        ($sum_task_budget_gov_utility = $tasks->whereNull('task_parent')->sum('task_budget_gov_utility'));
        ($sum_task_cost_gov_utility= $tasks->where('task_parent')->sum('task_cost_gov_utility'));
        ($sum_task_refund_budget_gov_utility= $tasks->where('task_parent')->sum('task_refund_pa_budget'));























        if (!empty($contracts['results'])) {
            foreach ($contracts['results'] as $group) {
                if (isset($group['text']) && isset($group['children']) && is_array($group['children'])) {
                    // ตรวจสอบกลุ่มสัญญา
                    $groupName = $group['text'];
                    $groupChildren = $group['children'];

                    // ตรวจสอบสัญญาในกลุ่ม
                    foreach ($groupChildren as $contract) {
                        if (isset($contract['id']) && isset($contract['text'])) {
                            // ข้อมูลสัญญาที่ถูกต้อง
                            $contractId = $contract['id'];
                            $contractText = $contract['text'];

                            // นำข้อมูลสัญญาไปใช้งานตามต้องการ
                        } else {
                            // ข้อมูลสัญญาไม่ถูกต้อง

                        }
                    }
                } else {
                    // ข้อมูลกลุ่มสัญญาไม่ถูกต้อง
                }
            }
        } else {
            // ไม่มีข้อมูลกลุ่มสัญญาในผลลัพธ์
        }
        if ($task) {
            $taskId = Hashids::decode($task)[0];
            $task = Task::find($taskId);
        } else {
            $task = null;
        }

        $tasksDetails = $task;
        //  dd($contracts);
        return view('app.projects.tasks.createsub', compact('request',
        'tasksDetails', 'contracts',
         'project', 'tasks',
          'task',

          'sum_task_budget_it_operating',
          'sum_task_budget_it_investment',
          'sum_task_budget_gov_utility',
          'sum_task_refund_budget_it_operating',
          'sum_task_refund_budget_it_investment',
          'sum_task_refund_budget_gov_utility',
          'sum_task_cost_it_operating',
          'sum_task_cost_it_investment',
          'sum_task_cost_gov_utility'









        ));

        /*   return view('app.projects.tasks.createsub', compact(   'request','contracts', 'project', 'tasks', 'task')); */
    }




    public function taskCreateSubno(Request $request, $project, $task = null)
    {
        ($id = Hashids::decode($project)[0]);
        $projectDetails = Project::find($id);

        $tasks = Task::where('project_id', $id)->get();
        $taskcons     = new Taskcon;
        $projectyear = Project::where('project_id', $id)->first(); // เปลี่ยนจาก get() เป็น first()
        $contracts = Contract::orderBy('contract_fiscal_year', 'desc')->get();

        $contractText = ''; // กำหนดค่าเริ่มต้นให้กับ $contractText

        //$taskcons     = new Taskcon ;
         // Sum the task_budget_it_operating for all tasks
         $sum_task_budget_it_operating = $tasks->whereNull('task_parent')->sum('task_budget_it_operating');
         $sum_task_refund_budget_it_operating= $tasks->whereNull('task_parent')->where('task_budget_it_operating', '>', 1)->sum('task_refund_pa_budget');

         // Sum the task_budget_it_investment for all tasks
         $sum_task_budget_it_investment = $tasks->whereNull('task_parent')->sum('task_budget_it_investment');
         $sum_task_refund_budget_it_investment= $tasks->whereNull('task_parent') ->where('task_budget_it_investment', '>', 1)->sum('task_refund_pa_budget');

         // Sum the task_budget_gov_utility for all tasks
         $sum_task_budget_gov_utility = $tasks->whereNull('task_parent')->sum('task_budget_gov_utility');
         $sum_task_refund_budget_gov_utility= $tasks->whereNull('task_parent')->where('task_budget_gov_utility', '>', 1)->sum('task_refund_pa_budget');

         //dd( $sum_task_refund_budget_it_operating,$sum_task_refund_budget_it_investment,$sum_task_refund_budget_gov_utility);

        $reguiar_id = $request->input('reguiar_id');
        if (!$reguiar_id) {
            $reguiar_id = 1; // Use 1 as default if not provided
        }

        if ($task) {
            $taskId = Hashids::decode($task)[0];
            $task = Task::find($taskId);
        } else {
            $task = null;
        }
        //  ($request);
        //  if ($project) {
        //    $projectId = Hashids::decode($id)[0];
        //    $project = Task::find($projectId);
        // } else {
        //    $project = null;
        // }
        if (!empty($contracts['results'])) {
            foreach ($contracts['results'] as $group) {
                if (isset($group['text']) && isset($group['children']) && is_array($group['children'])) {
                    // ตรวจสอบกลุ่มสัญญา
                    $groupName = $group['text'];
                    $groupChildren = $group['children'];

                    // ตรวจสอบสัญญาในกลุ่ม
                    foreach ($groupChildren as $contract) {
                        if (isset($contract['id']) && isset($contract['text'])) {
                            // ข้อมูลสัญญาที่ถูกต้อง
                            $contractId = $contract['id'];
                            $contractText = $contract['text'];

                            // นำข้อมูลสัญญาไปใช้งานตามต้องการ
                        } else {
                            // ข้อมูลสัญญาไม่ถูกต้อง

                        }
                    }
                } else {
                    // ข้อมูลกลุ่มสัญญาไม่ถูกต้อง
                }
            }
        } else {
            // ไม่มีข้อมูลกลุ่มสัญญาในผลลัพธ์
        }
        if ($project && $task) {
            $decodedProject = Hashids::decode($project);
            $decodedTask = Hashids::decode($task);

            if (isset($decodedProject[0]) && isset($decodedTask[0])) {
                $id_project = $decodedProject[0];
                $id_task = $decodedTask[0];

                $pro = Project::find($id_project);
                $ta = Task::find($id_task);
            }
        }

        $fiscal_year = $request->input('fiscal_year');
        if (!$fiscal_year) {
            $fiscal_year = date('Y') + 543; // Use current year if not provided
        }
        $projectData = DB::table('projects')
            //  ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            ->select('projects.*')
            ->where('project_id', $id)
            //->orderBy('projects.project_fiscal_year', 'DESC')
            ->get();
        //  dd($projectData);
        $projectData = $projectData->map(function ($p) {
            return [
                'id' => $p->project_id,
                'project_fiscal_year' => $p->project_fiscal_year,
                'project_id' => $p->project_id,
                'project_name' => $p->project_name,
                // 'task_parent_id' => $task->task_parent,
                //'text' => $task->task_name,
                'budget_it_operating' => $p->budget_it_operating,
                'budget_it_investment' => $p->budget_it_investment,
                'budget_gov_utility' => $p->budget_gov_utility,
            ];
        });

        // dd($projectData);

        $projectsJson = json_encode($projectData);

        //dd($projectDetails, $sum_task_budget_gov_utility, $sum_task_refund_budget_gov_utility);

        //  dd($projectDetails,$tasks,$taskcons,$projectyear);

        return view('app.projects.tasks.createsubno', compact(
            'request',
            'projectData',
            'projectsJson',
            'contracts',
            'project',
            'projectyear',
            'tasks',
            'task',
            'contractText',
            'taskcons',
            'fiscal_year',
            'reguiar_id',
            'projectDetails',
            'sum_task_budget_it_operating',
            'sum_task_budget_it_investment',
            'sum_task_budget_gov_utility',
            'sum_task_refund_budget_it_operating',
            'sum_task_refund_budget_it_investment',
            'sum_task_refund_budget_gov_utility'
        ));

        /*   return view('app.projects.tasks.createsub', compact(   'request','contracts', 'project', 'tasks', 'task')); */
    }


    public function taskCreateSubnop(Request $request, $project, $task = null)
    {
        $id = Hashids::decode($project)[0];
        // $projectDetails = Project::find($id);
        $projectDetails = Project::find($id);



        //$project = Project::find($projectId);
        $projectyear = Project::where('project_id', $id)->first(); // เปลี่ยนจาก get() เป็น first()
        ($tasks = Task::where('project_id', $id)->get());
        ($contracts = contract::orderBy('contract_fiscal_year', 'desc')->get());

        // Sum the task_budget_it_operating for all tasks
        $sum_task_budget_it_operating = $tasks->whereNull('task_parent')->sum('task_budget_it_operating');
        ($sum_task_cost_it_operating= $tasks->where('task_parent')->sum('task_cost_it_operating'));

        $sum_task_refund_budget_it_operating= $tasks->where('task_parent')->sum('task_refund_pa_budget');

        // Sum the task_budget_it_investment for all tasks
        $sum_task_budget_it_investment = $tasks->whereNull('task_parent')->sum('task_budget_it_investment');
        ($sum_task_cost_it_investment= $tasks->where('task_parent')->sum('task_cost_it_investment'));


        ($sum_task_refund_budget_it_investment= $tasks->where('task_parent')->sum('task_refund_pa_budget'));

        // Sum the task_budget_gov_utility for all tasks
        ($sum_task_budget_gov_utility = $tasks->whereNull('task_parent')->sum('task_budget_gov_utility'));
        ($sum_task_cost_gov_utility= $tasks->where('task_parent')->sum('task_cost_gov_utility'));
        ($sum_task_refund_budget_gov_utility= $tasks->where('task_parent')->sum('task_refund_pa_budget'));





      //  dd ($sum_task_cost_gov_utility);
       // ($sum_task_refund_budget_it_operating,$sum_task_refund_budget_it_investment,$sum_task_refund_budget_gov_utility);

        if (!empty($contracts['results'])) {
            foreach ($contracts['results'] as $group) {
                if (isset($group['text']) && isset($group['children']) && is_array($group['children'])) {
                    // ตรวจสอบกลุ่มสัญญา
                    $groupName = $group['text'];
                    $groupChildren = $group['children'];

                    // ตรวจสอบสัญญาในกลุ่ม
                    foreach ($groupChildren as $contract) {
                        if (isset($contract['id']) && isset($contract['text'])) {
                            // ข้อมูลสัญญาที่ถูกต้อง
                            $contractId = $contract['id'];
                            $contractText = $contract['text'];

                            // นำข้อมูลสัญญาไปใช้งานตามต้องการ
                        } else {
                            // ข้อมูลสัญญาไม่ถูกต้อง

                        }
                    }
                } else {
                    // ข้อมูลกลุ่มสัญญาไม่ถูกต้อง
                }
            }
        } else {
            // ไม่มีข้อมูลกลุ่มสัญญาในผลลัพธ์
        }
        if ($task) {
            $taskId = Hashids::decode($task)[0];
            $task = Task::find($taskId);
        } else {
            $task = null;
        }


        $fiscal_year = $request->input('fiscal_year');
        if (!$fiscal_year) {
            $fiscal_year = date('Y') + 543; // Use current year if not provided
        }



        $tasksDetails = $task;
   //dd( $tasksDetails ,$projectDetails,$projectyear ,$contracts,$tasks,$task);
        return view('app.projects.tasks.createsubnop', compact(
            'request',
            'tasksDetails',
            'projectDetails',
            'contracts',
            'project',
            'tasks',
            'task',
            'fiscal_year',
            'sum_task_budget_it_operating',
            'sum_task_budget_it_investment',
            'sum_task_budget_gov_utility',
            'sum_task_refund_budget_it_operating',
            'sum_task_refund_budget_it_investment',
            'sum_task_refund_budget_gov_utility',
            'sum_task_cost_it_operating',
            'sum_task_cost_it_investment',
            'sum_task_cost_gov_utility'
        ));
    }









    public function taskStore(Request $request, $project)
    {
        $id = Hashids::decode($project)[0];

        ($task = new Task);
        //dd($request);
        $tasks = Task::where('project_id', $id)->whereNull('task_parent')->get(); // Fetch all tasks for the project with no parent task
        // convert input to decimal or set it to null if empty
        $task_budget_it_operating = $request->input('task_budget_it_operating') !== '' ? (float) str_replace(',', '', $request->input('task_budget_it_operating')) : null;
        $task_budget_gov_utility = $request->input('task_budget_gov_utility') !== '' ? (float) str_replace(',', '', $request->input('task_budget_gov_utility')) : null;
        $task_budget_it_investment = $request->input('task_budget_it_investment') !== '' ? (float) str_replace(',', '', $request->input('task_budget_it_investment')) : null;

        $task_cost_it_operating = $request->input('task_cost_it_operating') !== '' ? (float) str_replace(',', '', $request->input('task_cost_it_operating')) : null;
        $task_cost_gov_utility = $request->input('task_cost_gov_utility') !== '' ? (float) str_replace(',', '', $request->input('task_cost_gov_utility')) : null;
        $task_cost_it_investment = $request->input('task_cost_it_investment') !== '' ? (float) str_replace(',', '', $request->input('task_cost_it_investment')) : null;
        $task_refund_pa_budget = $request->input('task_refund_pa_budget') !== '' ? (float) str_replace(',', '', $request->input('task_refund_pa_budget')) : null;

        $task_pay = $request->input('task_pay') !== '' ? (float) str_replace(',', '', $request->input('task_pay')) : null;
        $taskcon_pay = $request->input('taskcon_pay') !== '' ? (float) str_replace(',', '', $request->input('taskcon_pay')) : null;
        $task_mm_budget = $request->input('task_mm_budget') !== '' ? (float) str_replace(',', '', $request->input('task_mm_budget')) : null;
        $taskcon_pay = $request->input('taskcon_pay') !== '' ? (float) str_replace(',', '', $request->input('taskcon_pay')) : null;






        // $tasks = Task::where('project_id', $id)->get(); // Fetch all tasks for the project

        ($sum_task_budget_it_operating = $tasks->sum('task_budget_it_operating'));
        ($sum_task_budget_it_investment = $tasks->sum('task_budget_it_investment'));
        ($sum_task_budget_gov_utility = $tasks->sum('task_budget_gov_utility'));

        $messages = [
            //  'task_end_date.after_or_equal' => 'วันที่สิ้นสุดต้องหลังจากวันที่เริ่มต้น',
            'task_budget_it_operating.required' => 'กรุณาระบุงบกลาง ICT',
            'task_budget_it_operating.numeric' => 'กรุณากรอกจำนวนให้ถูกต้องและเป็นตัวเลข กลาง ICT',
            'task_budget_it_operating.min' => 'กรุณาระบุงบกลาง ICT เป็นจำนวนบวก min',
            'task_budget_it_operating.max' => 'งบประมาณงานที่ดำเนินการต้องไม่เกิน  งบกลาง ICT max',

            'task_budget_it_investment.required' => 'กรุณาระบุงบดำเนินงาน',
            'task_budget_it_investment.numeric' => 'กรุณากรอกจำนวนให้ถูกต้องและเป็นตัวเลข งบดำเนินงาน',
            'task_budget_it_investment.min' => 'กรุณาระบุงบดำเนินงานเป็นจำนวนบวก min',
            'task_budget_it_investment.max' => 'งบประมาณงานที่ดำเนินการต้องไม่เกิน งบดำเนินงาน max',


            'task_budget_gov_utility.required' => 'กรุณาระบุค่าสาธารณูปโภค',
            'task_budget_gov_utility.numeric' => 'กรุณากรอกจำนวนให้ถูกต้องและเป็นตัวเลข ค่าสาธารณูปโภค',
            'task_budget_gov_utility.min' => 'กรุณาระบุค่าสาธารณูปโภคเป็นจำนวนบวก',
            'task_budget_gov_utility.max' => 'งบประมาณงานที่ดำเนินการต้องไม่เกิน ค่าสาธารณูปโภค max',

        ];
        $request->validate([
            // 'task_name' => 'required',
            //    'task_start_date' => 'required|date_format:d/m/Y',
            //'task_end_date' => 'required|date_format:d/m/Y|after_or_equal:task_start_date',
            //  'task_budget_it_operating' => 'nullable|min:0|max:' . ($request->input('budget_it_operating') - $sum_task_budget_it_operating),
            // 'task_budget_it_investment' => 'nullable|min:0|max:' . ($request->input('budget_it_investment') - $sum_task_budget_it_investment),
            // 'task_budget_gov_utility' => 'nullable|min:0|max:' . ($request->input('budget_gov_utility') - $sum_task_budget_gov_utility),
        ], $messages);




        $start_date_obj = date_create_from_format('d/m/Y', $request->input('task_start_date'));
        $end_date_obj = date_create_from_format('d/m/Y', $request->input('task_end_date'));
        // $pay_date_obj = date_create_from_format('d/m/Y', $request->input('task_pay_date'));

        if ($start_date_obj === false || $end_date_obj === false) {
            // Handle date conversion error
            // You can either return an error message or use a default date
        } else {
            $start_date_obj->modify('-543 years');
            $end_date_obj->modify('-543 years');
            //   $pay_date_obj->modify('-543 years');
            $start_date = date_format($start_date_obj, 'Y-m-d');
            $end_date = date_format($end_date_obj, 'Y-m-d');
            //    $pay_date = date_format($pay_date_obj, 'Y-m-d');
        }



        $task->task_start_date = $start_date ?? date('Y-m-d 00:00:00');
        $task->task_end_date = $end_date ?? date('Y-m-d 00:00:00');
        $task->task_pay_date = $pay_date ?? date('Y-m-d 00:00:00');


        $task->task_status = $request->input('task_status');



        $task->project_id = $id;
        $task->task_mm = $request->input('taskcon_mm');
        $task->task_mm_name = $request->input('taskcon_mm_name');

        $task->task_name = $request->input('task_name');
        $task->task_description = trim($request->input('task_description'));

        $task->task_parent = $request->input('task_parent') ?? null;

        $task->task_budget_gov_utility = $task_budget_gov_utility;
        $task->task_budget_it_operating = $task_budget_it_operating;
        $task->task_budget_it_investment = $task_budget_it_investment;

        $task->task_cost_gov_utility = $task_cost_gov_utility;
        $task->task_cost_it_operating = $task_cost_it_operating;
        $task->task_cost_it_investment = $task_cost_it_investment;

        $task->task_pay = $task_pay;

        $task->task_mm_budget = $task_mm_budget;

        $task->task_refund_pa_budget = $task_refund_pa_budget;





        $task->task_type = $request->input('task_type');
        // dd($task);
        if ($task->save()) {
            //insert contract
            if ($request->input('task_contract')) {
                //insert contract
                $contract_has_task = new ContractHasTask;
                $contract_has_task->contract_id = $request->input('task_contract');
                $contract_has_task->task_id = $task->task_id;
                $contract_has_task->save();
            }

            // if ($request->input('task_contract')) {
            //     //insert task-taskcon link
            //     $task_has_taskcon = new TasktHasTaskcon;
            //     $task_has_taskcon->task_id = $task->task_id; // This should be task_id from the Task object
            //     $task_has_taskcon->taskcon_id = $taskcon->taskcon_id; // Please ensure $taskcon is defined and has an id
            //     $task_has_taskcon->save();
            // }

            else if ($request->has('contracts')) {
                foreach ($request->contracts as $contractData) {
                    $contractName = isset($contractData['contract_mm_name']) ? $contractData['contract_mm_name'] : 'Default Contract Name';
                    $contractNumber = isset($contractData['contract_number']) ? $contractData['contract_number'] : 'Default Number';

                    $contract = new Contract;
                    $contract->contract_name = $contractName;
                    $contract->contract_number = $contractNumber; // Add this line

                    $contract->save();
                }
            } else  if ($request->has('tasks')) {
                foreach ($request->tasks as $taskData) {
                    $taskName = isset($taskData['task_name']) ? $taskData['task_name'] : 'Default Task Name';

                    Taskcon::create([
                        //'task_id' => $
                        'taskcon_name' => $taskName,
                        'updated_at' => now(),
                        'created_at' => now()
                    ]);
                }
            }




              //dd($task);
            return redirect()->route('project.show', $project);
        }
    }



    // public function taskStoresubno(Request $request, $project)
    // {
    //     // สร้าง Taskcon object ใหม่
    //     $taskcon = new Taskcon;
    //     $task = new Task;

    //     // กำหนดค่าให้กับ field ที่ต้องการให้รับค่าจาก request parameter
    //     // ในที่นี้คือการกำหนดค่าทั้งหมดที่ส่งมาจาก request ให้กับ object นี้
    //     $taskcon->fill($request->all());

    //     $taskcon->task_id = $request->input('task_id');
    //     // กำหนด task_id ให้กับ taskcon ตามที่ส่งมาใน parameter


    //    // dd($taskcon,$task);

    //     if ($taskcon->save()) {


    //         $origin = $request->input('origin');
    //         $project = $request->input('project');
    //         $task = $request->input('task');

    //         // บันทึกข้อมูลลงใน session
    //         session()->flash('taskcon_id', $taskcon->taskcon_id);
    //         session()->flash('taskcon_number', $taskcon->taskcon_number);
    //         session()->flash('taskcon_name', $taskcon->taskcon_name);
    //         session()->flash('taskcon_mm_budget', $taskcon->taskcon_mm_budget);
    //         session()->flash('taskcon_pr_budget', $taskcon->taskcon_pr_budget);
    //         session()->flash('taskcon_pa_budget', $taskcon->taskcon_pa_budget);
    //         session()->flash('taskcon_pay', $taskcon->taskcon_pay);
    //         session()->flash('taskcon_start_date', $taskcon->taskcon_start_date);
    //         session()->flash('taskcon_end_date', $taskcon->taskcon_end_date);

    //         if ($origin) {
    //             return redirect()->route('project.task.createsubno', ['project' => $project, 'task' => $task]);
    //         }

    //         return redirect()->route('project.index');
    //     }

    //     // You might want to add some error handling here, in case saving fails
    //     return redirect()->back()->withErrors('An error occurred while saving the task. Please try again.');
    // }

    public function taskStoresubno(Request $request, $project)
    { // Create a new Project object


        $messages = [
              'task_end_date.after_or_equal' => 'วันที่สิ้นสุดต้องหลังจากวันที่เริ่มต้น',

             // 'task_budget_it_operating.required' => 'กรุณาระบุงบกลาง ICT',

              'task_budget_it_operating.numeric' => 'กรุณากรอกจำนวนให้ถูกต้องและเป็นตัวเลข',
             'task_budget_it_operating.min' => 'กรุณาระบุงบกลาง ICT เป็นจำนวนบวก',

            // 'task_budget_it_investment.required' => 'กรุณาระบุงบดำเนินงาน',

             'task_budget_it_investment.numeric' => 'กรุณากรอกจำนวนให้ถูกต้องและเป็นตัวเลข',
             'task_budget_it_investment.min' => 'กรุณาระบุงบดำเนินงานเป็นจำนวนบวก',

            // 'task_budget_gov_utility.required' => 'กรุณาระบุค่าสาธารณูปโภค',

             'task_budget_gov_utility.numeric' => 'กรุณากรอกจำนวนให้ถูกต้องและเป็นตัวเลข',
             'task_budget_gov_utility.min' => 'กรุณาระบุค่าสาธารณูปโภคเป็นจำนวนบวก',


             'task_budget_it_operating.max' => 'งบประมาณงานที่ดำเนินการต้องไม่เกิน ', ];

        $request->validate([
            //    'task_name' => 'required',
            //   'task_start_date' => 'required|date_format:d/m/Y',
             'task_end_date' => 'required|date_format:d/m/Y|after_or_equal:task_start_date',
            //'task_budget_it_operating' => 'required|numeric|min:0|max:' . ($request->input('budget_it_operating') ),
            //'task_budget_it_investment' => 'required|numeric|min:0|max:' . ($request->input('budget_it_investment') ),
            //'task_budget_gov_utility' => 'required|numeric|min:0|max:' . ($request->input('budget_gov_utility') ),
        ], $messages);






        $id = Hashids::decode($project)[0];
        ($task = new Task);
        $tasks = Task::where('project_id', $id)->whereNull('task_parent')->get();

        $start_date_obj = date_create_from_format('d/m/Y', $request->input('task_start_date'));
        $end_date_obj = date_create_from_format('d/m/Y', $request->input('task_end_date'));


        // convert input to decimal or set it to null if empty
        $task_budget_it_operating = $request->input('task_budget_it_operating') !== '' ? (float) str_replace(',', '', $request->input('task_budget_it_operating')) : null;
        $task_budget_gov_utility = $request->input('task_budget_gov_utility') !== '' ? (float) str_replace(',', '', $request->input('task_budget_gov_utility')) : null;
        $task_budget_it_investment = $request->input('task_budget_it_investment') !== '' ? (float) str_replace(',', '', $request->input('task_budget_it_investment')) : null;

        $task_cost_it_operating = $request->input('task_cost_it_operating') !== '' ? (float) str_replace(',', '', $request->input('task_cost_it_operating')) : null;
        $task_cost_gov_utility = $request->input('task_cost_gov_utility') !== '' ? (float) str_replace(',', '', $request->input('task_cost_gov_utility')) : null;
        $task_cost_it_investment = $request->input('task_cost_it_investment') !== '' ? (float) str_replace(',', '', $request->input('task_cost_it_investment')) : null;
        $task_refund_pa_budget = $request->input('task_refund_pa_budget') !== '' ? (float) str_replace(',', '', $request->input('task_refund_pa_budget')) : null;





        $task_pay = $request->input('task_pay') !== '' ? (float) str_replace(',', '', $request->input('task_pay')) : null;
        $taskcon_pay = $request->input('taskcon_pay') !== '' ? (float) str_replace(',', '', $request->input('taskcon_pay')) : null;

        // convert input to decimal or set it to null if empty
        $taskcon_budget_it_operating = str_replace(',', '', $request->input('taskcon_budget_it_operating'));
        $taskcon_budget_gov_utility = str_replace(',', '', $request->input('taskcon_budget_gov_utility'));
        $taskcon_budget_it_investment = str_replace(',', '', $request->input('taskcon_budget_it_investment'));


        $taskcon_cost_it_operating = str_replace(',', '', $request->input('taskcon_cost_it_operating'));
        $taskcon_cost_gov_utility = str_replace(',', '', $request->input('taskcon_cost_gov_utility'));
        $taskcon_cost_it_investment = str_replace(',', '', $request->input('taskcon_cost_it_investment'));

        $taskcon_pay = str_replace(',', '', $request->input('taskcon_pay'));

        $task_refund_pa_budget = str_replace(',', '', $request->input('task_refund_pa_budget'));


        $taskcon_mm_budget = str_replace(',', '', $request->input('taskcon_mm_budget'));
        $task_mm_budget = str_replace(',', '', $request->input('task_mm_budget'));

        $taskcon_ba_budget = str_replace(',', '', $request->input('taskcon_ba_budget'));

        $taskcon_bd_budget = str_replace(',', '', $request->input('taskcon_bd_budget'));


        if ($taskcon_budget_it_operating === '') {
            $taskcon_budget_it_operating = null; // or '0'
        }

        if ($taskcon_budget_gov_utility === '') {
            $taskcon_budget_gov_utility = null; // or '0'
        }

        if ($taskcon_budget_it_investment === '') {
            $taskcon_budget_it_investment = null; // or '0'
        }

        if ($taskcon_cost_it_operating === '') {
            $taskcon_cost_it_operating = null; // or '0'
        }

        if ($taskcon_cost_gov_utility === '') {
            $taskcon_cost_gov_utility = null; // or '0'
        }

        if ($taskcon_cost_it_investment === '') {
            $taskcon_cost_it_investment = null; // or '0'
        }

        if ($taskcon_pay === '') {
            $taskcon_pay = null; // or '0'
        }
        if ($task_refund_pa_budget === '') {
            $task_refund_pa_budget = null; // or '0'
        }
        if ($taskcon_mm_budget === '') {
            $taskcon_mm_budget = null; // or '0'
        }
        if ($task_mm_budget === '') {
            $task_mm_budget = null; // or '0'
        }
        if ($taskcon_ba_budget === '') {
            $taskcon_ba_budget = null; // or '0'
        }
        if ($taskcon_bd_budget === '') {
            $taskcon_bd_budget = null; // or '0'
        }

        if ($start_date_obj === false || $end_date_obj === false) {
            // Handle date conversion error
            // You can either return an error message or use a default date
        } else {
            $start_date_obj->modify('-543 years');
            $end_date_obj->modify('-543 years');

            $start_date = date_format($start_date_obj, 'Y-m-d');
            $end_date = date_format($end_date_obj, 'Y-m-d');
        }



        $task->project_id = $id;
        $task->task_name = $request->input('taskcon_mm_name');
        $task->task_description = trim($request->input('task_description'));
        $task->task_status = $request->input('task_status');

        $task->task_parent = $request->input('task_parent') ?? null;
        $task->task_start_date  = $start_date ?? date('Y-m-d 00:00:00');
        $task->task_end_date    = $end_date ?? date('Y-m-d 00:00:00');


        $task->task_budget_it_operating = $task_budget_it_operating;
        $task->task_budget_it_investment = $task_budget_it_investment;
        $task->task_budget_gov_utility = $task_budget_gov_utility;

        $task->task_cost_it_operating = $task_cost_it_operating;
        $task->task_cost_it_investment = $task_cost_it_investment;
        $task->task_cost_gov_utility = $task_cost_gov_utility;

        $task->task_refund_pa_budget = $task_refund_pa_budget;
        $task->task_mm_budget                 =  $task_budget_gov_utility + $task_budget_it_operating + $task_budget_it_investment;
        $task->task_mm_name        = $request->input('task_mm_name');
        $task->task_mm        = $request->input('task_mm');
        //$task->task_cost_disbursement =  $taskcon_bd_budget +$taskcon_ba_budget  ;
        $task->task_pay = $task_pay;
        // $task->taskcon_pp_name        = $request->input('taskcon_pp_name');
        // $task->taskcon_pp        = $request->input('taskcon_pp');
        $task->task_type = $request->input('task_type');
        //

        //dd($task);
        // Save the Project
        if (!$task->save()) {


            // If the Project failed to save, redirect back with an error message
            return redirect()->back()->withErrors('An error occurred while saving the project. Please try again.');
        }  // <-- This closing bracket was missing


        // Create a new Taskcon object
        $taskcon = new Taskcon;

        // Fill the Taskcon fields from the request
        // replace 'field1', 'field2', 'field3' with the actual fields of Taskcon

        // Assign the project_id to the Taskcon
        $start_date_obj = date_create_from_format('d/m/Y', $request->input('taskcon_start_date'));
        $end_date_obj = date_create_from_format('d/m/Y', $request->input('taskcon_end_date'));
        $pay_date_obj = date_create_from_format('d/m/Y', $request->input('taskcon_pay_date'));

        if ($start_date_obj === false || $end_date_obj === false  || $pay_date_obj === false) {
            // Handle date conversion error
            // You can either return an error message or use a default date
        } else {
            $start_date_obj->modify('-543 years');
            $end_date_obj->modify('-543 years');
            $pay_date_obj->modify('-543 years');
            $start_date = date_format($start_date_obj, 'Y-m-d');
            $end_date = date_format($end_date_obj, 'Y-m-d');
            $pay_date = date_format($pay_date_obj, 'Y-m-d');
        }


        // convert input to decimal or set it to null if empty
        $taskcon_budget_it_operating = str_replace(',', '', $request->input('taskcon_budget_it_operating'));
        $taskcon_budget_gov_utility = str_replace(',', '', $request->input('taskcon_budget_gov_utility'));
        $taskcon_budget_it_investment = str_replace(',', '', $request->input('taskcon_budget_it_investment'));


        $taskcon_cost_it_operating = str_replace(',', '', $request->input('taskcon_cost_it_operating'));
        $taskcon_cost_gov_utility = str_replace(',', '', $request->input('taskcon_cost_gov_utility'));
        $taskcon_cost_it_investment = str_replace(',', '', $request->input('taskcon_cost_it_investment'));

        $taskcon_pay = str_replace(',', '', $request->input('taskcon_pay'));

        $taskcon_mm_budget = str_replace(',', '', $request->input('taskcon_mm_budget'));

        $taskcon_ba_budget = str_replace(',', '', $request->input('taskcon_ba_budget'));

        $taskcon_bd_budget = str_replace(',', '', $request->input('taskcon_bd_budget'));


        if ($taskcon_budget_it_operating === '') {
            $taskcon_budget_it_operating = null; // or '0'
        }

        if ($taskcon_budget_gov_utility === '') {
            $taskcon_budget_gov_utility = null; // or '0'
        }

        if ($taskcon_budget_it_investment === '') {
            $taskcon_budget_it_investment = null; // or '0'
        }

        if ($taskcon_cost_it_operating === '') {
            $taskcon_cost_it_operating = null; // or '0'
        }

        if ($taskcon_cost_gov_utility === '') {
            $taskcon_cost_gov_utility = null; // or '0'
        }

        if ($taskcon_cost_it_investment === '') {
            $taskcon_cost_it_investment = null; // or '0'
        }

        if ($taskcon_pay === '') {
            $taskcon_pay = null; // or '0'
        }
        if ($taskcon_mm_budget === '') {
            $taskcon_mm_budget = null; // or '0'
        }
        if ($taskcon_ba_budget === '') {
            $taskcon_ba_budget = null; // or '0'
        }
        if ($taskcon_bd_budget === '') {
            $taskcon_bd_budget = null; // or '0'
        }






        //convert date
        //   $start_date = date_format(date_create_from_format('d/m/Y', $request->input('taskcon_start_date')), 'Y-m-d');
        // $end_date   = date_format(date_create_from_format('d/m/Y', $request->input('taskcon_end_date')), 'Y-m-d');
        // $taskcon->taskcon_name        = $request->input('task_name');
        $taskcon->task_id = $task->task_id; // Use the id of the newly created project
        $taskcon->taskcon_name        = $request->input('task_name');
        $taskcon->taskcon_pp_name        = $request->input('taskcon_pp_name');
        $taskcon->taskcon_pp        = $request->input('taskcon_pp');
        // $taskcon->taskcon_name        = $request->input('task_name');

        $taskcon->taskcon_mm_name        = $request->input('task_mm_name');
        $taskcon->taskcon_mm        = $request->input('task_mm');
        $taskcon->taskcon_ba        = $request->input('taskcon_ba');
        $taskcon->taskcon_bd       = $request->input('taskcon_bd');

        $taskcon->taskcon_description = trim($request->input('task_description'));
        $taskcon->taskcon_start_date  = $start_date ?? date('Y-m-d 00:00:00');
        $taskcon->taskcon_end_date    = $end_date ?? date('Y-m-d 00:00:00');
        $taskcon->taskcon_pay_date     =  $pay_date ?? date('Y-m-d 00:00:00');

        $taskcon->taskcon_parent = $request->input('taskcon_parent') ?? null;
        //convert input to decimal or set it to null if empty
        $taskcon->taskcon_budget_gov_utility    = $task_budget_gov_utility;
        $taskcon->taskcon_budget_it_operating   = $task_budget_it_operating;
        $taskcon->taskcon_budget_it_investment  = $task_budget_it_investment;

        $taskcon->taskcon_cost_gov_utility    = $taskcon_cost_gov_utility;
        $taskcon->taskcon_cost_it_operating   = $taskcon_cost_it_operating;
        $taskcon->taskcon_cost_it_investment  = $taskcon_cost_it_investment;
        $taskcon->taskcon_pay                 =  $task_pay;
        $taskcon->taskcon_mm_budget                 =  $task_budget_gov_utility + $task_budget_it_operating + $task_budget_it_investment;
        $taskcon->taskcon_ba_budget                 =  $taskcon_ba_budget;
        $taskcon->taskcon_bd_budget                 =  $taskcon_bd_budget;

        //$taskcon->taskcon_description = trim($request->input('taskcon_description'));

        // dd($task,$taskcon);


        $origin = $request->input('origin');



        $files = new File;
        $idproject = $id;
        $idtask = $task->task_id;
        $idup = $idproject . '/' . $idtask;

        $contractDir = public_path('storage/uploads/contracts/' . $idup);
        if (!file_exists($contractDir)) {
            mkdir($contractDir, 0755, true);
        }

        if($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                $filename = time().'_'.$file->getClientOriginalName();
                $filesize = $file->getSize();
                $file->storeAs('public/',$filename);
                $file->move($contractDir, $filename);

                $fileModel = new File;
                $fileModel->name = $filename;
                //$fileModel->project_id = $idproject;
                $fileModel->task_id = $idtask;
                $fileModel->size = $filesize;
                $fileModel->location = 'storage/uploads/contracts/' . $idup . '/' . $filename;

                if (!$fileModel->save()) {
                    // If the file failed to save, redirect back with an error message
                    return redirect()->back()->withErrors('An error occurred while saving the file. Please try again.');
                }
            }
        }






        if (!$task->save()) {
            // If the Project failed to save, redirect back with an error message
            return redirect()->back()->withErrors('An error occurred while saving the project. Please try again.');
        }  // <-- This closing bracket was missing
        // Save the Taskcon
        if (!$taskcon->save()) {
            // If the Taskcon failed to save, redirect back with an error message
            return redirect()->back()->withErrors('An error occurred while saving the task. Please try again.');
        }

        // If both the Project and Taskcon saved successfully, redirect to project.index
        return redirect()->route('project.show', $project);
    }




    public function taskStoresubnop(Request $request, $project)
    { // Create a new Project object
        $id = Hashids::decode($project)[0];
        ($task = new Task);
        $tasks = Task::where('project_id', $id)->whereNull('task_parent')->get();

        $start_date_obj = date_create_from_format('d/m/Y', $request->input('task_start_date'));
        $end_date_obj = date_create_from_format('d/m/Y', $request->input('task_end_date'));


        // convert input to decimal or set it to null if empty
        $task_budget_it_operating = $request->input('task_budget_it_operating') !== '' ? (float) str_replace(',', '', $request->input('task_budget_it_operating')) : null;
        $task_budget_gov_utility = $request->input('task_budget_gov_utility') !== '' ? (float) str_replace(',', '', $request->input('task_budget_gov_utility')) : null;
        $task_budget_it_investment = $request->input('task_budget_it_investment') !== '' ? (float) str_replace(',', '', $request->input('task_budget_it_investment')) : null;

        $task_cost_it_operating = $request->input('task_cost_it_operating') !== '' ? (float) str_replace(',', '', $request->input('task_cost_it_operating')) : null;
        $task_cost_gov_utility = $request->input('task_cost_gov_utility') !== '' ? (float) str_replace(',', '', $request->input('task_cost_gov_utility')) : null;
        $task_cost_it_investment = $request->input('task_cost_it_investment') !== '' ? (float) str_replace(',', '', $request->input('task_cost_it_investment')) : null;

        $task_refund_pa_budget = $request->input('task_refund_pa_budget') !== '' ? (float) str_replace(',', '', $request->input('task_refund_pa_budget')) : null;


        $task_pay = $request->input('task_pay') !== '' ? (float) str_replace(',', '', $request->input('task_pay')) : null;
        $taskcon_pay = $request->input('taskcon_pay') !== '' ? (float) str_replace(',', '', $request->input('taskcon_pay')) : null;

        // convert input to decimal or set it to null if empty
        $taskcon_budget_it_operating = str_replace(',', '', $request->input('taskcon_budget_it_operating'));
        $taskcon_budget_gov_utility = str_replace(',', '', $request->input('taskcon_budget_gov_utility'));
        $taskcon_budget_it_investment = str_replace(',', '', $request->input('taskcon_budget_it_investment'));


        $taskcon_cost_it_operating = str_replace(',', '', $request->input('taskcon_cost_it_operating'));
        $taskcon_cost_gov_utility = str_replace(',', '', $request->input('taskcon_cost_gov_utility'));
        $taskcon_cost_it_investment = str_replace(',', '', $request->input('taskcon_cost_it_investment'));
        //$task_refund_pa_budget = str_replace(',', '', $request->input('task_refund_pa_budget'));

        $taskcon_pay = str_replace(',', '', $request->input('taskcon_pay'));

        $taskcon_mm_budget = str_replace(',', '', $request->input('taskcon_mm_budget'));

        $taskcon_ba_budget = str_replace(',', '', $request->input('taskcon_ba_budget'));

        $taskcon_bd_budget = str_replace(',', '', $request->input('taskcon_bd_budget'));


        if ($taskcon_budget_it_operating === '') {
            $taskcon_budget_it_operating = null; // or '0'
        }

        if ($taskcon_budget_gov_utility === '') {
            $taskcon_budget_gov_utility = null; // or '0'
        }

        if ($taskcon_budget_it_investment === '') {
            $taskcon_budget_it_investment = null; // or '0'
        }

        if ($taskcon_cost_it_operating === '') {
            $taskcon_cost_it_operating = null; // or '0'
        }

        if ($taskcon_cost_gov_utility === '') {
            $taskcon_cost_gov_utility = null; // or '0'
        }

        if ($taskcon_cost_it_investment === '') {
            $taskcon_cost_it_investment = null; // or '0'
        }

        if ($taskcon_pay === '') {
            $taskcon_pay = null; // or '0'
        }
        if ($taskcon_mm_budget === '') {
            $taskcon_mm_budget = null; // or '0'
        }
        if ($taskcon_ba_budget === '') {
            $taskcon_ba_budget = null; // or '0'
        }
        if ($taskcon_bd_budget === '') {
            $taskcon_bd_budget = null; // or '0'
        }

        if ($start_date_obj === false || $end_date_obj === false) {
            // Handle date conversion error
            // You can either return an error message or use a default date
        } else {
            $start_date_obj->modify('-543 years');
            $end_date_obj->modify('-543 years');

            $start_date = date_format($start_date_obj, 'Y-m-d');
            $end_date = date_format($end_date_obj, 'Y-m-d');
        }



        $task->project_id = $id;
        $task->task_name = $request->input('task_name');
        $task->task_description = trim($request->input('task_description'));
        $task->task_status = $request->input('task_status');
        $task->task_parent = $request->input('task_parent') ?? null;
        $task->task_start_date  = $start_date ?? date('Y-m-d 00:00:00');
        $task->task_end_date    = $end_date ?? date('Y-m-d 00:00:00');

        $task->task_budget_gov_utility = $task_budget_gov_utility;
        $task->task_budget_it_operating = $task_budget_it_operating;
        $task->task_budget_it_investment = $task_budget_it_investment;

        $task->task_cost_gov_utility = $task_cost_gov_utility;
        $task->task_cost_it_operating = $task_cost_it_operating;
        $task->task_cost_it_investment = $task_cost_it_investment;


        $task->task_refund_pa_budget = $task_refund_pa_budget;
        $task->task_pay = $task_pay;
        // $task->task_cost_disbursement =  $taskcon_bd_budget + $taskcon_ba_budget;

        $task->task_type = $request->input('task_type');

        // dd($task);
        // Save the Project


        // Create a new Taskcon object
        $taskcon = new Taskcon;

        // Fill the Taskcon fields from the request
        // replace 'field1', 'field2', 'field3' with the actual fields of Taskcon

        // Assign the project_id to the Taskcon



        $start_date_obj = date_create_from_format('d/m/Y', $request->input('taskcon_start_date'));
        $end_date_obj = date_create_from_format('d/m/Y', $request->input('taskcon_end_date'));
        $pay_date_obj = date_create_from_format('d/m/Y', $request->input('taskcon_pay_date'));

        if ($start_date_obj === false || $end_date_obj === false  || $pay_date_obj === false) {
            // Handle date conversion error
            // You can either return an error message or use a default date
        } else {
            $start_date_obj->modify('-543 years');
            $end_date_obj->modify('-543 years');
            $pay_date_obj->modify('-543 years');
            $start_date = date_format($start_date_obj, 'Y-m-d');
            $end_date = date_format($end_date_obj, 'Y-m-d');
            $pay_date = date_format($pay_date_obj, 'Y-m-d');
        }


        // convert input to decimal or set it to null if empty
        $taskcon_budget_it_operating = str_replace(',', '', $request->input('taskcon_budget_it_operating'));
        $taskcon_budget_gov_utility = str_replace(',', '', $request->input('taskcon_budget_gov_utility'));
        $taskcon_budget_it_investment = str_replace(',', '', $request->input('taskcon_budget_it_investment'));


        $taskcon_cost_it_operating = str_replace(',', '', $request->input('taskcon_cost_it_operating'));
        $taskcon_cost_gov_utility = str_replace(',', '', $request->input('taskcon_cost_gov_utility'));
        $taskcon_cost_it_investment = str_replace(',', '', $request->input('taskcon_cost_it_investment'));

        $taskcon_pay = str_replace(',', '', $request->input('taskcon_pay'));

        $taskcon_mm_budget = str_replace(',', '', $request->input('taskcon_mm_budget'));

        $taskcon_ba_budget = str_replace(',', '', $request->input('taskcon_ba_budget'));

        $taskcon_bd_budget = str_replace(',', '', $request->input('taskcon_bd_budget'));


        if ($taskcon_budget_it_operating === '') {
            $taskcon_budget_it_operating = null; // or '0'
        }

        if ($taskcon_budget_gov_utility === '') {
            $taskcon_budget_gov_utility = null; // or '0'
        }

        if ($taskcon_budget_it_investment === '') {
            $taskcon_budget_it_investment = null; // or '0'
        }

        if ($taskcon_cost_it_operating === '') {
            $taskcon_cost_it_operating = null; // or '0'
        }

        if ($taskcon_cost_gov_utility === '') {
            $taskcon_cost_gov_utility = null; // or '0'
        }

        if ($taskcon_cost_it_investment === '') {
            $taskcon_cost_it_investment = null; // or '0'
        }

        if ($taskcon_pay === '') {
            $taskcon_pay = null; // or '0'
        }
        if ($taskcon_mm_budget === '') {
            $taskcon_mm_budget = null; // or '0'
        }
        if ($taskcon_ba_budget === '') {
            $taskcon_ba_budget = null; // or '0'
        }
        if ($taskcon_bd_budget === '') {
            $taskcon_bd_budget = null; // or '0'
        }


        //convert date
        //   $start_date = date_format(date_create_from_format('d/m/Y', $request->input('taskcon_start_date')), 'Y-m-d');
        // $end_date   = date_format(date_create_from_format('d/m/Y', $request->input('taskcon_end_date')), 'Y-m-d');

        $taskcon->task_id = $task->task_id; // Use the id of the newly created project

        $taskcon->taskcon_name        = $request->input('task_name');
        $taskcon->taskcon_mm_name        = $request->input('task_name');
        $taskcon->taskcon_mm        = $request->input('taskcon_mm');
        $taskcon->taskcon_ba        = $request->input('taskcon_ba');
        $taskcon->taskcon_bd       = $request->input('taskcon_bd');

        $taskcon->taskcon_description = trim($request->input('taskcon_description'));
        $taskcon->taskcon_start_date  = $start_date ?? date('Y-m-d 00:00:00');
        $taskcon->taskcon_end_date    = $end_date ?? date('Y-m-d 00:00:00');
        $taskcon->taskcon_pay_date     =  $pay_date ?? date('Y-m-d 00:00:00');

        $taskcon->taskcon_parent = $request->input('taskcon_parent') ?? null;
        //convert input to decimal or set it to null if empty

        $taskcon->taskcon_budget_gov_utility    = $task_budget_gov_utility;
        $taskcon->taskcon_budget_it_operating   = $task_budget_it_operating;
        $taskcon->taskcon_budget_it_investment  = $task_budget_it_investment;

        /*
        $taskcon->taskcon_budget_gov_utility    = $request->input('task_budget_gov_utility');
        $taskcon->taskcon_budget_it_operating   = $request->input('task_budget_it_operating');
        $taskcon->taskcon_budget_it_investment  = $request->input('task_cost_it_investment'); */

        $taskcon->taskcon_cost_gov_utility    = $taskcon_cost_gov_utility;
        $taskcon->taskcon_cost_it_operating   = $taskcon_cost_it_operating;
        $taskcon->taskcon_cost_it_investment  = $taskcon_cost_it_investment;
        //  $taskcon->taskcon_pay                 =  $task_pay;
        $taskcon->taskcon_mm_budget                 =  $taskcon_mm_budget;
        $taskcon->taskcon_ba_budget                 =  $taskcon_ba_budget;
        $taskcon->taskcon_bd_budget                 =  $taskcon_bd_budget;
        $taskcon->taskcon_pp                =   $request->input('taskcon_pp');
        $taskcon->taskcon_pp_name                =   $request->input('taskcon_pp_name');
        $taskcon->taskcon_pay                 =  $taskcon_pay;
        $taskcon->taskcon_mm_budget                 =  $taskcon_mm_budget;


        $taskcon->taskcon_description = trim($request->input('taskcon_description'));
        // Save the Taskcon
       // dd($task, $taskcon);

        if (!$task->save()) {
            // If the Project failed to save, redirect back with an error message
            return redirect()->back()->withErrors('An error occurred while saving the project. Please try again.');
        }  // <-- This closing bracket was missing
        if (!$taskcon->save()) {
            // If the Taskcon failed to save, redirect back with an error message
            return redirect()->back()->withErrors('An error occurred while saving the task. Please try again.');
        }

        // If both the Project and Taskcon saved successfully, redirect to project.index
        return redirect()->route('project.index');
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
        ($project    = Project::find($id_project));
        $task       = Task::find($id_task);
        $tasks      = Task::where('project_id', $id_project)
            ->whereNot('task_id', $id_task)
            ->get();
        $contracts = contract::orderBy('contract_fiscal_year', 'desc')->get();

        ($request = Project::find($id_project));

         // Sum the task_budget_it_operating for all tasks
         $sum_task_budget_it_operating = $tasks->whereNull('task_parent')->sum('task_budget_it_operating');
         $sum_task_refund_budget_it_operating= $tasks->whereNull('task_parent')->where('task_budget_it_operating', '>', 1)->sum('task_refund_pa_budget');

         // Sum the task_budget_it_investment for all tasks
         $sum_task_budget_it_investment = $tasks->whereNull('task_parent')->sum('task_budget_it_investment');
         $sum_task_refund_budget_it_investment= $tasks->whereNull('task_parent') ->where('task_budget_it_investment', '>', 1)->sum('task_refund_pa_budget');

         // Sum the task_budget_gov_utility for all tasks
         $sum_task_budget_gov_utility = $tasks->whereNull('task_parent')->sum('task_budget_gov_utility');
         $sum_task_refund_budget_gov_utility= $tasks->whereNull('task_parent')->where('task_budget_gov_utility', '>', 1)->sum('task_refund_pa_budget');

        return view('app.projects.tasks.edit', compact('request',
         'contracts', 'project', 'task', 'tasks'
         , 'sum_task_budget_it_operating', 'sum_task_budget_it_investment', 'sum_task_budget_gov_utility',

         'sum_task_refund_budget_it_operating', 'sum_task_refund_budget_it_investment', 'sum_task_refund_budget_gov_utility',

        ));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $project
     * @return \Illuminate\Http\Response
     */
    public function taskEditSub(Request $request, $project, $task)
    {

        ($id_project = Hashids::decode($project)[0]);
        $id_task    = Hashids::decode($task)[0];
        ($project    = Project::find($id_project));


        $task       = Task::find($id_task);
        $tasks      = Task::where('project_id', $id_project)
            ->whereNot('task_id', $id_task)
            ->get();

        ($contracts = contract::orderBy('contract_fiscal_year', 'desc')->get());
        ($contract = $contracts->toJson()); // Convert the collection to JSON
        //  $contract = $contracts->first();

        $task_budget_it_operating = Task::where('project_id', $id_project)->where('task_id', '!=', $id_task)->sum('task_budget_it_operating');
        $task_budget_it_investment = Task::where('project_id', $id_project)->where('task_id', '!=', $id_task)->sum('task_budget_it_investment');
        $task_budget_gov_utility = Task::where('project_id', $id_project)->where('task_id', '!=', $id_task)->sum('task_budget_gov_utility');


         // dd($tasks);

        return view('app.projects.tasks.editsub', compact('contracts', 'project', 'task', 'tasks', 'contract', 'task_budget_it_operating', 'task_budget_it_investment', 'task_budget_gov_utility'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $project
     * @return \Illuminate\Http\Response
     */

    public function taskEditSubno(Request $request, $project, $task)
    {

        ($id_project = Hashids::decode($project)[0]);
        $id_task    = Hashids::decode($task)[0];
        ($project    = Project::find($id_project));
        $projectDetails = Project::find($id_project);

        $task       = Task::find($id_task);
        //dd($task);
        $tasks      = Task::where('project_id', $id_project)
            ->whereNot('task_id', $id_task)
            ->get();

        //dd($task);

        $task = Task::join('taskcons', 'tasks.task_id', '=', 'taskcons.task_id')
            ->select(
                'tasks.*',
                'taskcons.taskcon_id',
                'taskcons.taskcon_mm',
                'taskcons.taskcon_mm_name',
                'taskcons.taskcon_pay',
                'taskcons.taskcon_pay_date',
                'taskcons.taskcon_pp_name',
                'taskcons.taskcon_pp'
            ) // make sure taskcon_mm is included in taskcons.*
            ->where('tasks.task_id', $id_task)
            ->first();

        //dd($task);
        ($contracts = contract::orderBy('contract_fiscal_year', 'desc')->get());
        ($contract = $contracts->toJson()); // Convert the collection to JSON
        //  $contract = $contracts->first();

        $task_budget_it_operating = Task::where('project_id', $id_project)->where('task_id', '!=', $id_task)->sum('task_budget_it_operating');
        $task_budget_it_investment = Task::where('project_id', $id_project)->where('task_id', '!=', $id_task)->sum('task_budget_it_investment');
        $task_budget_gov_utility = Task::where('project_id', $id_project)->where('task_id', '!=', $id_task)->sum('task_budget_gov_utility');
      // Sum the task_budget_it_operating for all tasks
      $sum_task_budget_it_operating = $tasks->whereNull('task_parent')->sum('task_budget_it_operating');
      $sum_task_refund_budget_it_operating= $tasks->whereNull('task_parent')->where('task_budget_it_operating', '>', 1)->sum('task_refund_pa_budget');

      // Sum the task_budget_it_investment for all tasks
      $sum_task_budget_it_investment = $tasks->whereNull('task_parent')->sum('task_budget_it_investment');
      $sum_task_refund_budget_it_investment= $tasks->whereNull('task_parent') ->where('task_budget_it_investment', '>', 1)->sum('task_refund_pa_budget');

      // Sum the task_budget_gov_utility for all tasks
      $sum_task_budget_gov_utility = $tasks->whereNull('task_parent')->sum('task_budget_gov_utility');
      $sum_task_refund_budget_gov_utility= $tasks->whereNull('task_parent')->where('task_budget_gov_utility', '>', 1)->sum('task_refund_pa_budget');


        //dd($tasks);

        return view('app.projects.tasks.editsubno', compact(

        'sum_task_refund_budget_it_operating', 'sum_task_refund_budget_it_investment', 'sum_task_refund_budget_gov_utility','sum_task_budget_gov_utility', 'sum_task_budget_it_investment', 'sum_task_budget_it_operating', 'projectDetails', 'contracts', 'project', 'task', 'tasks', 'contract', 'task_budget_it_operating', 'task_budget_it_investment', 'task_budget_gov_utility'));
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
                            $id_task = Hashids::decode($task)[0];
                            $project = Project::find($id_project);
                            ($task = Task::find($id_task));
                            $tasks = Task::where('project_id', $id_project)
                                ->where('task_id', '!=', $id_task)
                                ->get();
                            $contracts = Contract::orderBy('contract_fiscal_year', 'desc')->get();

                            $tasks_without_parent = Task::where('project_id', $id_project)
                                ->whereNull('task_parent')
                                ->get();
                            $task_budget_it_operating = $tasks_without_parent->sum('task_budget_it_operating');
                            $task_budget_it_investment = $tasks_without_parent->sum('task_budget_it_investment');
                            $task_budget_gov_utility = $tasks_without_parent->sum('task_budget_gov_utility');


                            //  dd($tasks_without_parent);


                            $messages = [
                                 'task_end_date.after_or_equal' => 'วันที่สิ้นสุดต้องหลังจากวันที่เริ่มต้น',
                                /*'task_budget_it_operating.required' => 'กรุณาระบุงบกลาง ICT',
                                'task_budget_it_operating.numeric' => 'กรุณากรอกจำนวนให้ถูกต้องและเป็นตัวเลข',
                                'task_budget_it_operating.min' => 'กรุณาระบุงบกลาง ICT เป็นจำนวนบวก',
                                'task_budget_it_investment.required' => 'กรุณาระบุงบดำเนินงาน',
                                'task_budget_it_investment.numeric' => 'กรุณากรอกจำนวนให้ถูกต้องและเป็นตัวเลข',
                                'task_budget_it_investment.min' => 'กรุณาระบุงบดำเนินงานเป็นจำนวนบวก',
                                'task_budget_gov_utility.required' => 'กรุณาระบุค่าสาธารณูปโภค',
                                'task_budget_gov_utility.numeric' => 'กรุณากรอกจำนวนให้ถูกต้องและเป็นตัวเลข',
                                'task_budget_gov_utility.min' => 'กรุณาระบุค่าสาธารณูปโภคเป็นจำนวนบวก',
                                'task_budget_it_operating.max' => 'งบประมาณงานที่ดำเนินการต้องไม่เกิน ', */];

                            $request->validate([
                                //    'task_name' => 'required',
                                   'task_start_date' => 'required|date_format:d/m/Y',
                                 'task_end_date' => 'required|date_format:d/m/Y|after_or_equal:task_start_date',
                                //'task_budget_it_operating' => 'required|numeric|min:0|max:' . ($request->input('budget_it_operating') - $sum_task_budget_it_operating),
                                //'task_budget_it_investment' => 'required|numeric|min:0|max:' . ($request->input('budget_it_investment') - $sum_task_budget_it_investment),
                                //'task_budget_gov_utility' => 'required|numeric|min:0|max:' . ($request->input('budget_gov_utility') - $sum_task_budget_gov_utility),
                            ], $messages);

                         //   $task_pay_date = $request->input('task_pay_date');


/*
                            if ($task_pay_date) {
                                $pay_date_obj = date_create_from_format('d/m/Y', $task_pay_date);
                            } else {
                                $pay_date_obj = null;
                            } */

                            $start_date_obj = date_create_from_format('d/m/Y', $request->input('task_start_date'));
                            $end_date_obj = date_create_from_format('d/m/Y', $request->input('task_end_date'));
                            $pay_date_obj = date_create_from_format('d/m/Y', $request->input('task_pay_date'));


                            if ($start_date_obj === false || $end_date_obj === false) {
                                // Handle date conversion error
                                // You can either return an error message or use a default date
                            } else {
                                $start_date_obj->modify('-543 years');
                                $end_date_obj->modify('-543 years');

                                $start_date = date_format($start_date_obj, 'Y-m-d');
                                $end_date = date_format($end_date_obj, 'Y-m-d');


                                // Check if $pay_date_obj is not null before trying to modify and format it

                            }

                            if ($pay_date_obj === false) {
                                // Handle date conversion error
                                // You can either return an error message or use a default date
                            } else {

                                $pay_date_obj->modify('-543 years');

                                $pay_date = date_format($pay_date_obj, 'Y-m-d');

                                // Check if $pay_date_obj is not null before trying to modify and format it

                            }


                            $task->task_start_date = $start_date ?? date('Y-m-d 00:00:00');
                            $task->task_end_date = $end_date ?? date('Y-m-d 00:00:00');
                            $task->task_pay_date = $pay_date ?? date('Y-m-d 00:00:00');



                            // Convert data to decimal or set it to null if empty
                            $task_budget_it_operating = $request->input('task_budget_it_operating') !== '' ? (float) str_replace(',', '', $request->input('task_budget_it_operating')) : null;
                            $task_budget_gov_utility = $request->input('task_budget_gov_utility') !== '' ? (float) str_replace(',', '', $request->input('task_budget_gov_utility')) : null;
                            $task_budget_it_investment = $request->input('task_budget_it_investment') !== '' ? (float) str_replace(',', '', $request->input('task_budget_it_investment')) : null;

                            $task_cost_it_operating = $request->input('task_cost_it_operating') !== '' ? (float) str_replace(',', '', $request->input('task_cost_it_operating')) : null;
                            $task_cost_gov_utility = $request->input('task_cost_gov_utility') !== '' ? (float) str_replace(',', '', $request->input('task_cost_gov_utility')) : null;
                            $task_cost_it_investment = $request->input('task_cost_it_investment') !== '' ? (float) str_replace(',', '', $request->input('task_cost_it_investment')) : null;
                            $task_mm_budget = $request->input('task_mm_budget') !== '' ? (float) str_replace(',', '', $request->input('task_mm_budget')) : null;
                            $task_pay = $request->input('task_pay') !== '' ? (float) str_replace(',', '', $request->input('task_pay')) : null;

                            $task_refund_pa_budget = $request->input('task_refund_pa_budget') !== '' ? (float) str_replace(',', '', $request->input('task_refund_pa_budget')) : null;


                            $task->project_id = $id_project;
                            $task->task_name = $request->input('task_name');
                            $task->task_mm = $request->input('task_mm');
                            $task->task_status = $request->input('task_status');

                            $task->task_description = trim($request->input('task_description'));


                            $task->task_budget_it_operating = $task_budget_it_operating;
                            $task->task_budget_gov_utility = $task_budget_gov_utility;
                            $task->task_budget_it_investment = $task_budget_it_investment;
                            $task->task_budget_it_operating = $task_budget_it_operating;


                            $task->task_cost_it_operating = $task_cost_it_operating;
                            $task->task_cost_gov_utility =  $task_cost_gov_utility;
                            $task->task_cost_it_investment = $task_cost_it_investment;
                            $task->task_refund_pa_budget = $task_refund_pa_budget;
                            $task->task_mm_budget = $task_mm_budget;
                            $task->task_pay = $task_pay;
                            $task->task_type = $request->input('task_type');
                            // Update other task attributes as needed
                            //  $task->taskcon_pp_name        = $request->input('taskcon_pp_name');
                            // $task->taskcon_pp        = $request->input('taskcon_pp');
                         //   dd($task);


                            if ($task->save()) {
                                // Update contract
                                if ($request->input('task_contract')) {
                                    ContractHasTask::where('task_id', $id_task)->delete();
                                    ContractHasTask::create([
                                        'contract_id' => $request->input('task_contract'),
                                        'task_id' => $id_task,
                                    ]);
                                } else {
                                    ContractHasTask::where('task_id', $id_task)->delete();
                                }

                    // Assign the project_id to the Taskcon
                    $taskcon = Taskcon::where('task_id', $task->task_id)->first();
                    if ($taskcon === null) {
                        // Handle the error, e.g., create a new Taskcon, show an error message, etc.
                        // For example, to create a new Taskcon:
                        //$taskcon = new Taskcon;
                        //$taskcon->task_id = $task->task_id;
                        // Set other properties of $taskcon as needed
                        return redirect()->route('project.show', $project->hashid);
                    } else {
                        // If $taskcon is not null, you can safely set its properties
                        $taskcon->task_id = $task->task_id;
                        // Set other properties of $taskcon as needed
                    }

                    $start_date_obj = date_create_from_format('d/m/Y', $request->input('taskcon_start_date'));
                    $end_date_obj = date_create_from_format('d/m/Y', $request->input('taskcon_end_date'));
                    $pay_date_obj = date_create_from_format('d/m/Y', $request->input('taskcon_pay_date'));

                    if ($start_date_obj === false || $end_date_obj === false  || $pay_date_obj === false) {
                        // Handle date conversion error
                        // You can either return an error message or use a default date
                    } else {
                        $start_date_obj->modify('-543 years');
                        $end_date_obj->modify('-543 years');
                        $pay_date_obj->modify('-543 years');
                        $start_date = date_format($start_date_obj, 'Y-m-d');
                        $end_date = date_format($end_date_obj, 'Y-m-d');
                        $pay_date = date_format($pay_date_obj, 'Y-m-d');
                    }


                    // convert input to decimal or set it to null if empty
                    $taskcon_budget_it_operating = str_replace(',', '', $request->input('taskcon_budget_it_operating'));
                    $taskcon_budget_gov_utility = str_replace(',', '', $request->input('taskcon_budget_gov_utility'));
                    $taskcon_budget_it_investment = str_replace(',', '', $request->input('taskcon_budget_it_investment'));


                    $taskcon_cost_it_operating = str_replace(',', '', $request->input('taskcon_cost_it_operating'));
                    $taskcon_cost_gov_utility = str_replace(',', '', $request->input('taskcon_cost_gov_utility'));
                    $taskcon_cost_it_investment = str_replace(',', '', $request->input('taskcon_cost_it_investment'));

                    $taskcon_pay = str_replace(',', '', $request->input('taskcon_pay'));

                    $taskcon_mm_budget = str_replace(',', '', $request->input('taskcon_mm_budget'));

                    $taskcon_ba_budget = str_replace(',', '', $request->input('taskcon_ba_budget'));

                    $taskcon_bd_budget = str_replace(',', '', $request->input('taskcon_bd_budget'));


                    if ($taskcon_budget_it_operating === '') {
                        $taskcon_budget_it_operating = null; // or '0'
                    }

                    if ($taskcon_budget_gov_utility === '') {
                        $taskcon_budget_gov_utility = null; // or '0'
                    }

                    if ($taskcon_budget_it_investment === '') {
                        $taskcon_budget_it_investment = null; // or '0'
                    }

                    if ($taskcon_cost_it_operating === '') {
                        $taskcon_cost_it_operating = null; // or '0'
                    }

                    if ($taskcon_cost_gov_utility === '') {
                        $taskcon_cost_gov_utility = null; // or '0'
                    }

                    if ($taskcon_cost_it_investment === '') {
                        $taskcon_cost_it_investment = null; // or '0'
                    }

                    if ($taskcon_pay === '') {
                        $taskcon_pay = null; // or '0'
                    }
                    if ($taskcon_mm_budget === '') {
                        $taskcon_mm_budget = null; // or '0'
                    }
                    if ($taskcon_ba_budget === '') {
                        $taskcon_ba_budget = null; // or '0'
                    }
                    if ($taskcon_bd_budget === '') {
                        $taskcon_bd_budget = null; // or '0'
                    }






                    //convert date
                    //   $start_date = date_format(date_create_from_format('d/m/Y', $request->input('taskcon_start_date')), 'Y-m-d');
                    // $end_date   = date_format(date_create_from_format('d/m/Y', $request->input('taskcon_end_date')), 'Y-m-d');
                    // $taskcon->taskcon_name        = $request->input('task_name');
                    $taskcon->task_id = $task->task_id; // Use the id of the newly created project
                    // $task->taskcon_mm = $request->input('task_mm');
                   // $taskcon->taskcon_name        = $request->input('taskcon_mm_name');
                    $taskcon->taskcon_pp_name        = $request->input('taskcon_pp_name');
                    $taskcon->taskcon_pp        = $request->input('taskcon_pp');

                    // $taskcon->taskcon_name        = $request->input('task_name');

                    $taskcon->taskcon_mm_name        = $request->input('taskcon_mm_name');
                    $taskcon->taskcon_mm        = $request->input('taskcon_mm');
                    $taskcon->taskcon_ba        = $request->input('taskcon_ba');
                    $taskcon->taskcon_bd       = $request->input('taskcon_bd');

                    $taskcon->taskcon_description = trim($request->input('task_description'));
                    $taskcon->taskcon_start_date  = $start_date ?? date('Y-m-d 00:00:00');
                    $taskcon->taskcon_end_date    = $end_date ?? date('Y-m-d 00:00:00');
                    $taskcon->taskcon_pay_date     =  $pay_date ?? date('Y-m-d 00:00:00');

                    $taskcon->taskcon_parent = $request->input('taskcon_parent') ?? null;
                    //convert input to decimal or set it to null if empty
                    $taskcon->taskcon_budget_gov_utility    = $task_budget_gov_utility;
                    $taskcon->taskcon_budget_it_operating   = $task_budget_it_operating;
                    $taskcon->taskcon_budget_it_investment  = $task_budget_it_investment;

                    $taskcon->taskcon_cost_gov_utility    = $taskcon_cost_gov_utility;
                    $taskcon->taskcon_cost_it_operating   = $taskcon_cost_it_operating;
                    $taskcon->taskcon_cost_it_investment  = $taskcon_cost_it_investment;
                    $taskcon->taskcon_pay                 =  $task_pay;
                    $taskcon->taskcon_mm_budget                 =  $taskcon_mm_budget;
                    $taskcon->taskcon_ba_budget                 =  $taskcon_ba_budget;
                    $taskcon->taskcon_bd_budget                 =  $taskcon_bd_budget;

                    //$taskcon->taskcon_description = trim($request->input('taskcon_description'));
                    // Save the Taskcon
                    //dd($task,$taskcon);


                    if (!$taskcon) {
                        return redirect()->back()->withErrors('Taskcon not found.');
                    }





                    if (!$taskcon->save()) {
                        // If the Taskcon failed to save, redirect back with an error message
                        return redirect()->back()->withErrors('An error occurred while saving the task. Please try again.');
                    }


                                //  dd($task);
                                return redirect()->route('project.show', $project->hashid);
                            }

                            // Create a new Taskcon object
                            //  $taskcon = new Taskcon;

                            // Fill the Taskcon fields from the request
                            // replace 'field1', 'field2', 'field3' with the actual fields of Taskcon


                            // If both the Project and Taskcon saved successfully, redirect to project.index
                            return redirect()->route('project.show', $project);
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
