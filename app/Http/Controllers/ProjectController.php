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
                ->addColumn('project_fiscal_year_output', function ($row) {
                    return $row->project_fiscal_year;
                })
                ->addColumn('reguiar_id_output', function ($row) {
                    return $row->reguiar_id;
                })
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">';
                   // $html .= '<a href="' . route('project.show', $row->hashid) . '" class="text-white btn btn-success" ><i class="cil-folder-open "></i></a>';
                    $html .= '<a href="' . route('project.view', $row->hashid) . '" class="text-white btn btn-success" ><i class="cil-folder-open "></i></a>';

                    //if (Auth::user()->hasRole('admin')) {
                    $html .= '<a href="' . route('project.edit', $row->hashid) . '" class="text-white btn btn-warning btn-edit " ><i class="cil-pencil "></i></a>';
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

    public function show(Request $request, $project,$task)
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
            'projects.*','at.task_refund_pa_status','a.total_task_budget', 'a.total_task_refund_pa_budget',
            'a.total_cost', 'a.tta', 'a.ttb', 'a.total_pay',
            'a.total_task_mm_budget', 'ab.cost_pa_1', 'ac.cost_no_pa_2',
            'ad.total_taskcon_pay_con','ae.total_task_refund_pa_budget_3',
            'pab.p_total_task_mm_budget','pab.p_total_task_refund_pa_budget_3',
            'pab3.pp_total_task_refund_pa_budget_3','pabb3.ppb_total_task_refund_pa_budget_3',
            'putilityno.putilityno_task_budget',
            'putilityno.putilityno_total_task_mm_budget',
            'putilityno.putilityno_total_sum',
            'putilityno.putilityno_total_task_refund_pa_budget_3',
            'putility.putility_total_task_refund_pa_budget_3'
        )

       ->leftJoin(
            DB::raw('(select tasks.project_id,
            tasks.task_refund_pa_status
                from tasks
                where tasks.deleted_at IS NULL AND tasks.task_parent_sub IS NULL
                group by tasks.project_id , tasks.task_refund_pa_status
            ) as at'),
            'at.project_id',
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
                where tasks.deleted_at IS NULL AND tasks.task_parent_sub IS NULL
                group by tasks.project_id
            ) as a'),
            'a.project_id',
            '=',
            'projects.project_id'
        )
        ->leftJoin(
            DB::raw('(select tasks.project_id,
            sum(COALESCE(tasks.task_budget_gov_utility,0))
            +sum(COALESCE(tasks.task_budget_it_operating,0))
            +sum(COALESCE(tasks.task_budget_it_investment,0)) as putility_task_budget,
                sum(COALESCE(tasks.task_cost_gov_utility,0))
                +sum(COALESCE(tasks.task_cost_it_operating,0))
                +sum(COALESCE(tasks.task_cost_it_investment,0)) as putility_cost_pa_1 ,
                sum( COALESCE(tasks.task_mm_budget,0))  as putility_total_task_mm_budget,
                sum( COALESCE(tasks.task_pay,0)) as putility_total_pay,
                sum(COALESCE(tasks.task_refund_pa_budget,0)) as putility_total_task_refund_pa_budget_3

                from tasks
                where tasks.task_type = 1 And tasks.task_budget_gov_utility > 1 AND tasks.deleted_at IS NULL
                group by tasks.project_id
            ) as putility'),
            'putility.project_id',
            '=',
            'projects.project_id', 'where projects.projects_type = 1'

        )
        ->leftJoin(
            DB::raw('(select tasks.project_id,

            sum(COALESCE(tasks.task_budget_gov_utility,0))
         as putilityno_task_budget,
            sum(COALESCE(tasks.task_mm_budget,0))  as putilityno_total_task_mm_budget,

            sum(COALESCE(tasks.task_budget_gov_utility-tasks.task_mm_budget,0))  as  putilityno_total_sum,

            sum(COALESCE(tasks.task_refund_pa_budget,0)) as putilityno_total_task_refund_pa_budget_3

                from tasks
                where tasks.task_type = 2  AND tasks.task_budget_gov_utility > 0 AND tasks.task_parent_sub IS NULL  AND tasks.deleted_at IS NULL
                group by tasks.project_id
            ) as putilityno'),
            'putilityno.project_id',
            '=',
            'projects.project_id', 'where projects.projects_type = 1'

        )


        ->leftJoin(
            DB::raw('(select tasks.project_id,
                sum(COALESCE(tasks.task_cost_gov_utility,0))
                +sum(COALESCE(tasks.task_cost_it_operating,0))
                +sum(COALESCE(tasks.task_cost_it_investment,0)) as p_cost_pa_1 ,
                sum( COALESCE(tasks.task_mm_budget,0))  as p_total_task_mm_budget,
                sum( COALESCE(tasks.task_pay,0)) as p_total_pay,
                sum(COALESCE(tasks.task_refund_pa_budget,0)) as p_total_task_refund_pa_budget_3

                from tasks
                where tasks.task_type = 1 AND tasks.deleted_at IS NULL
                group by tasks.project_id
            ) as pab'),
            'pab.project_id',
            '=',
            'projects.project_id', 'where projects.projects_type = 2'

        )


        ->leftJoin(
            DB::raw('(select tasks.project_id,
                sum(COALESCE(tasks.task_cost_gov_utility,0))
                +sum(COALESCE(tasks.task_cost_it_operating,0))
                +sum(COALESCE(tasks.task_cost_it_investment,0)) as p_cost_pa_1 ,
                sum( COALESCE(tasks.task_mm_budget,0))  as p_total_task_mm_budget,
                sum( COALESCE(tasks.task_pay,0)) as p_total_pay,

                sum(COALESCE(tasks.task_refund_pa_budget,0)) as pp_total_task_refund_pa_budget_3

                from tasks
                where tasks.task_type = 1 AND  tasks.task_refund_pa_status = 3 and tasks.deleted_at IS NULL
                group by tasks.project_id
            ) as pab3'),
            'pab3.project_id',
            '=',
            'projects.project_id', 'where projects.projects_type = 2'

        )
        ->leftJoin(
            DB::raw('(select tasks.project_id,
                sum(COALESCE(tasks.task_cost_gov_utility,0))
                +sum(COALESCE(tasks.task_cost_it_operating,0))
                +sum(COALESCE(tasks.task_cost_it_investment,0)) as p_cost_pa_1 ,
                sum( COALESCE(tasks.task_mm_budget,0))  as p_total_task_mm_budget,
                sum( COALESCE(tasks.task_pay,0)) as p_total_pay,
                sum(COALESCE(tasks.task_refund_pa_budget,0)) as ppb_total_task_refund_pa_budget_3

                from tasks
                where tasks.task_type = 2 AND  tasks.task_refund_pa_status = 3 and tasks.deleted_at IS NULL
                group by tasks.project_id
            ) as pabb3'),
            'pabb3.project_id',
            '=',
            'projects.project_id', 'where projects.projects_type = 2'

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


                where  tasks.task_refund_pa_status = 3 AND tasks.deleted_at IS NULL

                group by tasks.project_id
            ) as ae'), // Changed the alias from `as` to `ae`     LEFT JOIN taskcons  ON contracts.contract_id = taskcons.contract_id
            'ae.project_id',
            '=',
            'projects.project_id'
        )




        ->where('projects.project_id', $id)
        ->first()
        //->toSql()
    );


            // ->toArray()

            //dd($project);
        /*      $project = Project::select('projects.*', 'tasks.*', 'contract_has_tasks.*', 'contracts.*', 'taskcons.*')
->join('tasks', 'tasks.project_id', '=', 'projects.project_id')
->join('contract_has_tasks', 'contract_has_tasks.task_id', '=', 'tasks.task_id')
->join('contracts', 'contracts.contract_id', '=', 'contract_has_tasks.contract_id')
->join('taskcons', 'taskcons.contract_id', '=', 'contracts.contract_id')
->where('projects.project_id', $id)
->first()
->toArray()
; */
        //($t=$project->main_task);

        //dd($p=$project->contract);

       // คำนวณค่าเงินเบิกจ่ายทั้งหมดของโปรเจกต์
        (float) $__budget_gov = (float) $project['budget_gov_operating'] + (float) $project['budget_gov_utility'];
        (float) $__budget_it  = (float) $project['budget_it_operating'] + (float) $project['budget_it_investment'];
        (float) $__budget_it_operating  = (float) $project['budget_it_operating'];
        (float) $__budget_it_investment = (float) $project['budget_it_investment'];
        (float) $__budget_gov_utility    = (float) $project['budget_gov_utility'];



        (float) $__budget     = $__budget_gov + $__budget_it;
        ((float) $__cost       = (float) $project['project_cost']);
        ((float) $__total_task_budget       = (float) $project['total_task_budget']);
        ((float) $__mm       = (float) $project['total_task_mm_budget']);
        ((float) $__pmm       = (float) $project['p_total_task_mm_budget']);

        ((float) $__pay       = (float) $project['total_pay']);
        ((float) $__paycon       = (float) $project['total_taskcon_pay_con']);
        ((float) $__prmm       = (float) $project['total_task_refund_pa_budget']);
        ((float) $__total_task_refund_pa_budget_3       = (float) $project['total_task_refund_pa_budget_3']);
        ((float) $__pptotal_task_refund_pa_budget_3       = (float) $project['pp_total_task_refund_pa_budget_3']);
        ((float) $__ppbtotal_task_refund_pa_budget_3       = (float) $project['ppb_total_task_refund_pa_budget_3']);



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
            'pay'                   => $__pay,
            'total_pay'              => $__pay+$__paycon,
            'total_task_budget'      => $__total_task_budget,
            'total_taskcon_pay_con'  => $__paycon,
            'budget_mm'             => $project['task_mm_budget'],
            'refund_pa_budget'      => $__prmm,
            'refund_pa_budget_end'  => $__total_task_refund_pa_budget_3 ,
            'pprefund_pa_budget_end'  => $__pptotal_task_refund_pa_budget_3 ,
            'ppbrefund_pa_budget_end'=>$__ppbtotal_task_refund_pa_budget_3,
            'budget_total_mm'             => $__mm,
            'budget_total_mm_p'             => $__pmm,
            'refund_pa_budget_p'  => $__prmm,
            //'budget_total_pr_sum'  =>   $__balance_pr_sum,
            'owner'                 => $project['project_owner'],
            'open'                  => true,
            'type'                  => 'project',
            // 'duration'              => 360,
        ];

        // dd($gantt);


       $budget['project_type'] = $project['project_type'];

         $budget['budget_it_operating'] = $__budget_it_operating ;
         $budget['budget_it_investment'] = $__budget_it_investment ;
         $budget['budget_gov_utility'] = $__budget_gov_utility  ;




         $budget['total'] = $__budget;
        ($budget['budget_total_mm'] = $__mm);


        $budget['budget_total_taskcon_pay_con'] = $__pay+$__paycon;

        $budget['total_task_budget']= $__total_task_budget;
        $budget['budget_total_refund_pa_budget'] = $__prmm;
        $budget['budget_total_refund_pa_budget_end'] = $__total_task_refund_pa_budget_3;
        $budget['budget_pptotal_refund_pa_budget_end'] =$__pptotal_task_refund_pa_budget_3;
        $budget['budget_ppbtotal_refund_pa_budget_end']=$__ppbtotal_task_refund_pa_budget_3;
        $budget['budget_total_task_budget']= ($__total_task_budget-$__mm);

        $budget['total'] = $__budget;
        $budget['total_task_budget']= $__total_task_budget;
        ($budget['budget_total_mm'] = $__mm);
        $budget['budget_total_refund_pa_budget_end'] = $__total_task_refund_pa_budget_3;

        $budget['budget_total_task_budget_end']= ($__budget-($__total_task_budget-$__mm-$__total_task_refund_pa_budget_3));



        $budget['budget_total_task_budget_end_p2']= ($__budget)-($__total_task_budget-($__pptotal_task_refund_pa_budget_3+$__ppbtotal_task_refund_pa_budget_3));


       $budget['budget_total_task_budget_end_p2_mm']= ($__total_task_budget-($__pptotal_task_refund_pa_budget_3+$__ppbtotal_task_refund_pa_budget_3));


        $budget['budget_total_mm_pr'] = ($__budget) - ($__mm-$__prmm);
        $budget['budget_total_pay_con'] = ($__budget)-($__pay+$__paycon) ;



     //dd($budget);

        //  $tasks =  Project::find($id);

        $tasks = DB::table('tasks')
        ->join('taskcons', 'tasks.task_id', '=', 'taskcons.task_id')
        ->select('tasks.*', 'taskcons.*')
         ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
        ->get();

//dd($tasks);


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





        ($project_cte = Project::find($id));

            if ($project_cte) {
                ($project_cte=$project->task);
            } else {
                // Handle the case where the project is not found
                return redirect()->route('some_route')->with('error', 'Project not found');
            }
           // dd($project_cte);


        //dd($taskconsSubquery);

       /*  $tasks = DB::table('t')
        ->select('t.*', 'p.project_id')
        ->withExpression('t', DB::table('tasks'))
        ->withExpression('p', function ($query) {
            $query->from('projects');
        })

        ->where('t.project_id',  $id )
        ->join('p', 'p.project_id', '=', 't.project_id')
        ->get();


          ($tasks); */



           //dd ($task_sub = Task::find(Hashids::decode($id_tasks)));
         // dd($id,$id_tasks);
         // $task_ids = array_column($id_tasks, 'task_id');
         // dd($id_tasks);

         $id_tasks = Task::select('task_id')->where('project_id', $id)
->whereNull('tasks.task_parent')->whereNull('tasks.deleted_at')->get()->pluck('task_id');

        $ids_project = Project::select('project_id')->where('project_id', $id)->get()->pluck('project_id');;


 //dd($id_tasks,$ids_project);


/* $taskcontract = DB::table('tasks')
         ->withRecursiveExpression('cte', function ($rec) use ($id_tasks) {
             $rec->select('t.task_id', 't.project_id', 't.task_parent',
                 DB::raw('t.task_id AS root'),
                 DB::raw('COALESCE(t.task_budget_gov_utility, 0) + COALESCE(t.task_budget_it_operating, 0) + COALESCE(t.task_budget_it_investment, 0) AS LeastBudget'),
                 DB::raw('COALESCE(t.task_cost_gov_utility, 0) + COALESCE(t.task_cost_it_operating, 0) + COALESCE(t.task_cost_it_investment, 0) AS LeastCost'),
                 DB::raw('COALESCE(t.task_pay, 0) AS LeastPay'),
                 DB::raw('COALESCE(t.task_refund_pa_budget, 0) AS Leasttask_refund_pa_budget'),
                 DB::raw('SUM(COALESCE(taskcons.taskcon_pay, 0)) AS total_taskcon_pay'),
                 DB::raw('SUM(COALESCE(t.task_pay, 0)) AS total_pay'),
                 'contracts.contract_id')
             ->leftJoin('contract_has_tasks', 't.task_id', '=', 'contract_has_tasks.task_id')
             ->leftJoin('contracts', 'contract_has_tasks.contract_id', '=', 'contracts.contract_id')
             ->leftJoin('taskcons', 'contracts.contract_id', '=', 'taskcons.contract_id')
             ->from('tasks as t')
             ->whereIn('t.task_id', $id_tasks)
             ->whereNull('t.deleted_at')
             ->groupBy('t.task_id', 't.project_id', 't.task_parent', 'contracts.contract_id')
             ->unionAll(function ($uni) {
                 $uni->select(
                     'tasks.task_id',
                     'tasks.task_parent',
                     'cte.root',
                     DB::raw('tasks.task_budget_it_operating + tasks.task_budget_it_investment + tasks.task_budget_gov_utility + cte.LeastBudget AS LeastBudget'),
                     DB::raw('tasks.task_cost_it_operating + tasks.task_cost_it_investment + tasks.task_cost_gov_utility + cte.LeastCost AS LeastCost'),
                     DB::raw('tasks.task_pay + cte.LeastPay AS LeastPay'),
                     DB::raw('tasks.task_refund_pa_budget + cte.Leasttask_refund_pa_budget AS Leasttask_refund_pa_budget')
                 )
                 ->from('tasks')
                 ->whereNull('tasks.deleted_at')
                 ->join('cte', 'tasks.task_parent', '=', 'cte.task_id');
             });
         });

     $taskcontract = $taskcontract->select('root',
         DB::raw('MIN(LeastBudget) AS totalLeastBudget'),
         DB::raw('SUM(LeastCost) AS totalLeastCost'),
         DB::raw('SUM(LeastPay) AS totalLeastPay'),
         DB::raw('SUM(Leasttask_refund_pa_budget) AS totalLeasttask_refund_pa_budget'))
         ->from('cte')
         ->groupBy('root')
         ->orderBy('root');

     dd($taskcontract->get()); */
     //dd($id);


//dd($id_tasks, $id);
















     $cteQuery = DB::table('tasks')
     ->withRecursiveExpression('cte', function ($rec) use ($id_tasks, $id){
         $rec->select(
             't.task_id',
             't.project_id',
             't.task_parent',
             't.task_id AS root',
             't.project_id AS root_project_id',
             //'t.task_refund_pa_status AS root_task_refund_pa_status',
             't.task_mm_budget as Leasttask_mm_budget',
             DB::raw('
             CASE
                 WHEN t.task_budget_gov_utility > 1 THEN "utility"
                 WHEN t.task_budget_it_operating > 1 THEN "operating"
                 WHEN t.task_budget_it_investment > 1 THEN "investment"
                 ELSE NULL
             END AS budget_type_oiu'),
             DB::raw('COALESCE(t.task_budget_gov_utility, 0)
              + COALESCE(t.task_budget_it_operating, 0) + COALESCE(t.task_budget_it_investment, 0) AS LeastBudget'),

              DB::raw('COALESCE(t.task_cost_gov_utility, 0) +
             COALESCE(t.task_cost_it_operating, 0) + COALESCE(t.task_cost_it_investment, 0) AS LeastCost'),

             't.task_pay as LeastPay',

             't.task_refund_pa_budget as Leasttask_refund_pa_budget',

             DB::raw(
                '(COALESCE(t.task_budget_gov_utility, 0)
                + COALESCE(t.task_budget_it_operating, 0) + COALESCE(t.task_budget_it_investment, 0))-(COALESCE(t.task_cost_gov_utility, 0) +
             COALESCE(t.task_cost_it_operating, 0) + COALESCE(t.task_cost_it_investment, 0)) AS Least_Budget_Cost_sum'),

             DB::raw('(
                SELECT MAX(temp.total_cost_1)
                FROM (
                    SELECT inner_tasks.task_parent,
                           SUM(COALESCE(inner_tasks.task_cost_gov_utility, 0)) +
                           SUM(COALESCE(inner_tasks.task_cost_it_operating, 0)) +
                           SUM(COALESCE(inner_tasks.task_cost_it_investment, 0)) AS total_cost_1
                    FROM tasks as inner_tasks
                    WHERE inner_tasks.task_type = 1 AND inner_tasks.deleted_at IS NULL
                    GROUP BY inner_tasks.task_parent
                ) AS temp
                WHERE temp.task_parent = t.task_id
            ) AS ab_1
    ')
    ,
    DB::raw('(
        SELECT MAX(temp.total_cost_2)
        FROM (
            SELECT inner_tasks.task_parent,
                   SUM(COALESCE(inner_tasks.task_cost_gov_utility, 0)) +
                   SUM(COALESCE(inner_tasks.task_cost_it_operating, 0)) +
                   SUM(COALESCE(inner_tasks.task_cost_it_investment, 0)) AS total_cost_2
            FROM tasks as inner_tasks
            WHERE inner_tasks.task_type = 2 AND inner_tasks.deleted_at IS NULL
            GROUP BY inner_tasks.task_parent
        ) AS temp
        WHERE temp.task_parent = t.task_id
    ) AS ab_2
'),
             DB::raw('(
                SELECT sum(COALESCE(taskcons.taskcon_pay,0))
             FROM contract_has_tasks
             JOIN contracts ON contract_has_tasks.contract_id = contracts.contract_id
             JOIN taskcons ON contracts.contract_id = taskcons.contract_id
             WHERE contracts.deleted_at IS NULL AND contract_has_tasks.task_id = t.task_id
             )
             as Leasttask_taskcon_pay')
             )
             ->from('tasks as t')
             ->whereIn('t.task_id', $id_tasks)

             ->whereNull('t.deleted_at')

             ->unionAll(function ($uni) {
                 $uni->select(
                     'tasks.task_id',
                     'tasks.project_id',
                     'tasks.task_parent',
                    // 'tasks.task_refund_pa_status' ,
                     'cte.root',
                     'cte.root_project_id',
                     DB::raw('NULL AS budget_type_oiu'),

                     DB::raw('tasks.task_mm_budget + cte.Leasttask_mm_budget as Leasttask_mm_budget'),

                     DB::raw('tasks.task_budget_it_operating + tasks.task_budget_it_investment + tasks.task_budget_gov_utility + cte.LeastBudget AS LeastBudget'),
                     DB::raw('tasks.task_cost_it_operating + tasks.task_cost_it_investment + tasks.task_cost_gov_utility + cte.LeastCost AS LeastCost'),

                     DB::raw(
                        '(COALESCE(tasks.task_budget_gov_utility, 0)
                        + COALESCE(tasks.task_budget_it_operating, 0) + COALESCE(tasks.task_budget_it_investment, 0))-(COALESCE(tasks.task_cost_gov_utility, 0) +
                     COALESCE(tasks.task_cost_it_operating, 0) + COALESCE(tasks.task_cost_it_investment, 0))+cte.Least_Budget_Cost_sum AS Least_Budget_Cost_sum'),



                     DB::raw('tasks.task_pay + cte.LeastPay AS LeastPay'),
                     DB::raw('tasks.task_refund_pa_budget+cte.Leasttask_refund_pa_budget AS Leasttask_refund_pa_budget'),
                     DB::raw('(
                        SELECT MAX(temp.total_cost_1)
                        FROM (
                            SELECT inner_tasks.task_parent,
                                   SUM(COALESCE(inner_tasks.task_cost_gov_utility, 0)) +
                                   SUM(COALESCE(inner_tasks.task_cost_it_operating, 0)) +
                                   SUM(COALESCE(inner_tasks.task_cost_it_investment, 0)) AS total_cost_1
                            FROM tasks as inner_tasks
                            WHERE inner_tasks.task_type = 1 AND inner_tasks.deleted_at IS NULL
                            GROUP BY inner_tasks.task_parent
                        ) AS temp
                        WHERE temp.task_parent = tasks.task_id
                    ) AS ab_1
            '),

            DB::raw('(
                SELECT MAX(temp.total_cost_2)
                FROM (
                    SELECT inner_tasks.task_parent,
                           SUM(COALESCE(inner_tasks.task_cost_gov_utility, 0)) +
                           SUM(COALESCE(inner_tasks.task_cost_it_operating, 0)) +
                           SUM(COALESCE(inner_tasks.task_cost_it_investment, 0)) AS total_cost_2
                    FROM tasks as inner_tasks
                    WHERE inner_tasks.task_type = 2 AND inner_tasks.deleted_at IS NULL
                    GROUP BY inner_tasks.task_parent
                ) AS temp
                WHERE temp.task_parent = tasks.task_id
            ) AS ab_2
    '),
                     DB::raw('(SELECT sum(COALESCE(taskcons.taskcon_pay,0))
                     FROM contract_has_tasks
                     JOIN contracts ON contract_has_tasks.contract_id = contracts.contract_id
                     JOIN taskcons ON contracts.contract_id = taskcons.contract_id
                     WHERE contracts.deleted_at IS NULL AND contract_has_tasks.task_id = tasks.task_id)
                     AS Leasttask_taskcon_pay
                     ')

                 )
                     ->from('tasks')
                     ->whereNull('tasks.deleted_at')
                    ->whereNotNull('tasks.task_refund_pa_status')
                    ->whereNull('cte.budget_type_oiu')
                     ->join('cte', 'tasks.task_parent', '=', 'cte.task_id');
             });
     });


 $combinedQuery = $cteQuery
     ->from('cte')
     ->groupBy('cte.root', 'cte.root_project_id', 'cte.budget_type_oiu') // เพิ่ม 'cte.budget_type_oiu' ที่นี่
     // Add these columns to the GROUP BY clause ,'cte.root_task_refund_pa_status'
     ->select(
         'cte.root',
         'cte.root_project_id',

         'cte.budget_type_oiu AS budget_type_oiu',

         DB::raw('sum(cte.Leasttask_mm_budget) AS totalLeasttask_mm_budget'),

         DB::raw('MIN(cte.Least_Budget_Cost_sum) AS totalLeast_Budget_Cost_sum_min'),
         DB::raw('sum(cte.Least_Budget_Cost_sum) AS totalLeast_Budget_Cost_sum_sum'),
         DB::raw('max(cte.Least_Budget_Cost_sum) AS totalLeast_Budget_Cost_sum_max'),

         DB::raw('MIN(cte.LeastBudget) AS totalLeastBudget'),
         DB::raw('sum(cte.LeastBudget) AS totalLeastBudget_sum'),
         DB::raw('max(cte.LeastBudget) AS totalLeastBudget_sum_max'),
         DB::raw('SUM(cte.LeastCost) AS totalLeastCost'),
         DB::raw('SUM(cte.LeastPay) AS totalLeastPay'),

         DB::raw('(MIN(cte.LeastBudget) - SUM(cte.LeastCost)) AS totalleactdifference'), // Corrected line


         DB::raw('sum(cte.Leasttask_taskcon_pay) AS totalLeastconPay'),

         DB::raw('max(cte.Leasttask_refund_pa_budget) AS totalLeasttask_refund_pa_budget'),
         DB::raw('sum(cte.Leasttask_refund_pa_budget) AS totalLeasttask_refund_pa_budget1'),
         DB::raw('min(cte.Leasttask_refund_pa_budget) AS totalLeasttask_refund_pa_budget2'),

         DB::raw('SUM(cte.LeastCost) AS totalLeastCost_1'),
         DB::raw('SUM(cte.ab_1) AS total_Leasttask_cost_1'), // Updated this line
         DB::raw('SUM(cte.ab_2) AS total_Leasttask_cost_2'), // Updated this line

     )
     //->groupBy('cte.root_project_id')
    // ->orderBy('cte.root_project_id')
    // ->whereNull('cte.deleted_at')


    ->get();


//dd($combinedQuery);


  //dd($cteQuery[0]['root'])



  //dd($cteQuery->get());


  $totalLeasttask_mm_budget_sum = $combinedQuery->sum('totalLeasttask_mm_budget');
  $totalLeastBudget_sum = $combinedQuery->sum('totalLeastBudget_sum');
    $totalLeastCost = $combinedQuery->sum('totalLeastCost');

    $rootsums = $combinedQuery->reduce(function ($carry, $item) {
        $carry['totalLeasttask_mm_budget'] += $item->totalLeasttask_mm_budget;
        $carry['totalLeastBudget_sum'] += $item->totalLeastBudget_sum;
        $carry['totalLeastCost'] += $item->totalLeastCost;
        $carry['totalLeastPay'] += $item->totalLeastPay;
        $carry['totalLeasttask_refund_pa_budget'] += $item->totalLeasttask_refund_pa_budget;



        // ... ฟิลด์อื่น ๆ ...
        return $carry;
    }, ['totalLeasttask_mm_budget' => 0, 'totalLeastBudget_sum' => 0, 'totalLeastCost' => 0 ,'totalLeastPay'=> 0, 'totalLeasttask_refund_pa_budget' => 0]);

    //dd($rootsums); // จะแสดงผลรวมของฟิลด์ที่กำหนด

    $cteQueryResults = $cteQuery->get();
    //dd($cteQuery->get());

;



// กรองข้อมูลใน Collection ที่มี "budget_type_oiu" เท่ากับ "investment"
$investmentItems = $combinedQuery->filter(function ($item) {
    return $item->budget_type_oiu === 'investment';
});

//dd($investmentItems);

$rootsums_investment = $investmentItems->reduce(function ($carry, $item) {
    $carry['totalLeasttask_mm_budget_investment'] += $item->totalLeasttask_mm_budget;
    $carry['totalLeastBudget_sum_investment'] += $item->totalLeastBudget_sum;
    $carry['totalLeastCost_investment'] += $item->totalLeastCost;
    $carry['totalLeastPay_investment'] += $item->totalLeastPay;
    $carry['totalLeasttask_refund_pa_budget_investment'] += $item->totalLeasttask_refund_pa_budget;
    // ... ฟิลด์อื่น ๆ ...
    return $carry;
}, [
    'totalLeasttask_mm_budget_investment' => 0,
    'totalLeastBudget_sum_investment' => 0,
    'totalLeastCost_investment' => 0,
    'totalLeastPay_investment' => 0,
    'totalLeasttask_refund_pa_budget_investment' => 0
]);

//dd($rootsums_investment);
// รวมข้อมูลที่ต้องการ
//$totalLeastBudgetSum_in = $investmentItems->sum('totalLeastBudget_sum');
//$totalLeastCost_in = $investmentItems->sum('totalLeastCost');



// และอื่น ๆ ตามที่คุณต้องการ












/* $cteQueryResult = $cteQuery->get(); // หรือ ->get() ถ้าคุณต้องการทุกรายการ
if($cteQueryResult) {
    $budget['cteQuery_root'] = $cteQueryResult->root;

} else {
    $budget['cteQuery_root'] = null; // หรือค่า default อื่นๆ ถ้าไม่มีข้อมูล


} */
$cteQueryResults = $cteQuery->get(); // รับทุกรายการจาก query result
$roots = [];
$root_project_id = [];
$root_Leasttask_mm_budget = [];
foreach($cteQueryResults as $result) {
    $roots[] = $result->root ?? null; // ใช้ null coalescing operator ในกรณีที่ property ไม่มี
    $root_project_id[] = $result->root_project_id ?? null;
    $root_totalLeasttask_mm_budget[] = $result->totalLeasttask_mm_budget ?? null; // ตรวจสอบว่า property นี้มีอยู่จริงใน object
   // $root_task_refund_pa_status[] =$result->root_task_refund_pa_status ;


}


$budget['root_totalLeasttask_mm_budget'] = $rootsums['totalLeasttask_mm_budget'];
$budget['root_totalLeastBudget_sum'] = $rootsums['totalLeastBudget_sum'];
$budget['root_totalLeastCost'] = $rootsums['totalLeastCost'];
$budget['root_totalLeastPay'] = $rootsums['totalLeastPay'];
$budget['root_totalLeasttask_refund_pa_budget'] = $rootsums['totalLeasttask_refund_pa_budget'];
//$budget['cteQuery_root_totalLeasttask_mm_budget'] = $root_totalLeasttask_mm_budget;
//$budget['cteQuery_root_task_refund_pa_status'] = $root_task_refund_pa_status;

//dd($cteQuery->get());

//dd($budget);



$projectcte_investment_Query = DB::table('tasks')
->withRecursiveExpression('cte', function ($rec) use ($id_tasks, $id,$ids_project){
    $rec->select(
        't.task_id',
        't.project_id',
        't.task_parent',
        't.task_id AS root',
        't.project_id AS root_project_id',
        DB::raw('COALESCE(t.task_budget_it_investment, 0) AS LeastBudget_investment'),
        DB::raw('COALESCE(t.task_budget_it_investment, 0) AS LeastCost_investment'),
        't.task_pay as LeastPay_investment',
        't.task_refund_pa_budget as Leasttask_refund_pa_budget_investment',
           DB::raw('(
           SELECT sum(COALESCE(taskcons.taskcon_pay,0))
        FROM contract_has_tasks
        JOIN contracts ON contract_has_tasks.contract_id = contracts.contract_id
        JOIN taskcons ON contracts.contract_id = taskcons.contract_id
        WHERE contracts.deleted_at IS NULL AND contract_has_tasks.task_id = t.task_id
        )
        as Leasttask_taskcon_pay')
        )
        ->from('tasks as t')
        ->whereIn('t.task_id', $id_tasks)
        ->where('t.task_budget_it_investment', '>', 1)
        ->whereNull('t.deleted_at')
        ->unionAll(function ($uni) {
            $uni->select(
                'tasks.task_id',
                'tasks.project_id',
                'tasks.task_parent',
                'cte.root',
                'cte.root_project_id',
                DB::raw('tasks.task_budget_it_investment + cte.LeastBudget_investment AS LeastBudget_investment'),

                DB::raw('tasks.task_budget_it_investment + cte.LeastCost_investment AS LeastCost_investment'),

                DB::raw('tasks.task_pay + cte.LeastPay_investment AS LeastPay_investment'),
                DB::raw('tasks.task_refund_pa_budget +cte.Leasttask_refund_pa_budget_investment AS Leasttask_refund_pa_budget_investment'),

                DB::raw('(SELECT sum(COALESCE(taskcons.taskcon_pay,0))
                FROM contract_has_tasks
                JOIN contracts ON contract_has_tasks.contract_id = contracts.contract_id
                JOIN taskcons ON contracts.contract_id = taskcons.contract_id
                WHERE contracts.deleted_at IS NULL AND contract_has_tasks.task_id = tasks.task_id)
                AS Leasttask_taskcon_pay
                ')
            )
                ->from('tasks')
                ->whereNull('tasks.deleted_at')
                ->join('cte', 'tasks.task_parent', '=', 'cte.task_id');
        });
});

$projectcombinedQuery = $projectcte_investment_Query
->from('cte')
->groupBy( 'cte.root_project_id') // Add these columns to the GROUP BY clause
->select(
    'cte.root_project_id',

    DB::raw('SUM(cte.LeastBudget_investment) AS totalLeastBudgetSum_investment'),
    DB::raw('MIN(cte.LeastBudget_investment) AS totalLeastBudget_investment'),
    DB::raw('max(cte.LeastBudget_investment) AS totalLeastBudgetSum_investment_max'),
    DB::raw('SUM(cte.LeastCost_investment) AS totalLeastCost_investment'),
    DB::raw('SUM(cte.LeastPay_investment) AS totalLeastPay_investment'),
    DB::raw('sum(cte.Leasttask_taskcon_pay) AS totalLeastconPay_investment'),
    DB::raw('max(cte.Leasttask_refund_pa_budget_investment) AS totalLeasttask_refund_pa_budget_investment'),
    DB::raw('sum(cte.Leasttask_refund_pa_budget_investment) AS totalLeasttask_refund_pa_budget1_investment'),
    DB::raw('min(cte.Leasttask_refund_pa_budget_investment) AS totalLeasttask_refund_pa_budget2_investment'),
    DB::raw('SUM(cte.LeastCost_investment) AS totalLeastCost_1_investment'),
)
//->groupBy('cte.root_project_id')
// ->orderBy('cte.root_project_id')
// ->whereNull('cte.deleted_at')


->get();


//dd($projectcombinedQuery);

//dd($projectcte_investment_Query->get());


/* $projectcteutilityQuery = DB::table('projects')
->withRecursiveExpression('cte', function ($rec) use ($id_tasks, $id){
    $rec->select(
        't.task_id',
        't.project_id',
        't.task_parent',
        't.task_id AS root',
        't.project_id AS root_project_id',
        DB::raw('COALESCE(t.task_budget_gov_utility, 0) AS LeastBudget_utility'),
        DB::raw('COALESCE(t.task_cost_gov_utility, 0) AS LeastCost_utility'),
        't.task_pay as LeastPay_utility',
        't.task_refund_pa_budget as Leasttask_refund_pa_budget_utility',
           DB::raw('(
           SELECT sum(COALESCE(taskcons.taskcon_pay,0))
        FROM contract_has_tasks
        JOIN contracts ON contract_has_tasks.contract_id = contracts.contract_id
        JOIN taskcons ON contracts.contract_id = taskcons.contract_id
        WHERE contracts.deleted_at IS NULL AND contract_has_tasks.task_id = t.task_id
        )
        as Leasttask_taskcon_pay')
        )
        ->from('tasks as t')
        ->whereIn('t.task_id', $id_tasks)
        ->where('t.task_budget_gov_utility', '>', 1)
        ->whereNull('t.deleted_at')
        ->unionAll(function ($uni) {
            $uni->select(
                'tasks.task_id',
                'tasks.project_id',
                'tasks.task_parent',
                'cte.root',
                'cte.root_project_id',
                DB::raw('tasks.task_budget_gov_utility + cte.LeastBudget_utility AS LeastBudget_utility'),
                DB::raw('tasks.task_cost_gov_utility + cte.LeastCost_utility AS LeastCost_utility'),
                DB::raw('tasks.task_pay + cte.LeastPay_utility AS LeastPay_utility'),
                DB::raw('tasks.task_refund_pa_budget +
                cte.Leasttask_refund_pa_budget_utility AS Leasttask_refund_pa_budget_utility'),
                DB::raw('(SELECT sum(COALESCE(taskcons.taskcon_pay,0))
                FROM contract_has_tasks
                JOIN contracts ON contract_has_tasks.contract_id = contracts.contract_id
                JOIN taskcons ON contracts.contract_id = taskcons.contract_id
                WHERE contracts.deleted_at IS NULL AND contract_has_tasks.task_id = tasks.task_id)
                AS Leasttask_taskcon_pay
                ')
            )
                ->from('tasks')
                ->whereNull('tasks.deleted_at')
                ->join('cte', 'tasks.task_parent', '=', 'cte.task_id');
        });
});

  $projectcombinedQuery = $projectcteutilityQuery
->from('cte')
->groupBy(  'cte.root_id','cte.root_project_id') // Add these columns to the GROUP BY clause
->select(
    'cte.root_project_id',
    'cte.root_project_id',
    DB::raw('SUM(cte.LeastBudget_utility) AS totalLeastBudgetSum'),

    DB::raw('max(cte.LeastBudget_utility) AS totalLeastBudgetmax'),
    DB::raw('SUM(cte.LeastCost_utility) AS totalLeastCost'),
    DB::raw('SUM(cte.LeastPay_utility) AS totalLeastPay'),
    DB::raw('sum(cte.Leasttask_taskcon_pay) AS totalLeastconPay'),

    DB::raw('MIN(cte.LeastBudget_utility) AS totalLeastBudget'),

    DB::raw('max(cte.Leasttask_refund_pa_budget_utility) AS totalLeasttask_refund_pa_budget'),
    DB::raw('sum(cte.Leasttask_refund_pa_budget_utility) AS totalLeasttask_refund_pa_budget1'),
    DB::raw('min(cte.Leasttask_refund_pa_budget_utility) AS totalLeasttask_refund_pa_budget2'),

    DB::raw('SUM(cte.LeastCost_utility) AS totalLeastCost_1_utility'),
)
//->groupBy('cte.root_project_id')
// ->orderBy('cte.root_project_id')
// ->whereNull('cte.deleted_at')


->get(); */






//dd($projectcombinedQuery);
//dd($combinedQuery);

//dd($projectcteutilityQuery->get());

/*
    $sumTotalLeastBudget = array_reduce($items, function($carry, $cteQuery) {
        if ($cteQuery->root_project_id == 32) {
            $carry += floatval($cteQuery->totalLeastBudget);
        }
        return $carry;
    }, 0);

    echo "Sum of totalLeastBudget for project_id 32: " . $sumTotalLeastBudget; */


/*
      $subQuery = DB::table('tasks')
          ->select('tasks.task_parent',
          DB::raw('sum(COALESCE(taskcons.taskcon_pay,0)) as total_taskcon_pay'),
          DB::raw('sum(COALESCE(tasks.			COALESCE(t.task_cost_gov_utility, 0) + COALESCE(t.task_cost_it_operating, 0) + COALESCE(t.task_cost_it_investment, 0) AS LeastBudgetcost
,0)) as total_pay'))
          ->join('contract_has_tasks', 'tasks.task_id', '=', 'contract_has_tasks.task_id')
          ->join('contracts', 'contract_has_tasks.contract_id', '=', 'contracts.contract_id')
          ->join('taskcons', 'contracts.contract_id', '=', 'taskcons.contract_id')
          ->whereNull('tasks.deleted_at')
          ->groupBy('tasks.task_parent')
        ->get()
          ;
          dd($subQuery); */
    //    $mainQuery = DB::table(DB::raw("({$cteQuery->toSql()}) as cte"))
    //    ->mergeBindings($cteQuery)
    //    ->select(
    //        'cte.task_id','cte.pid', 'cte.task_parent',
    //        DB::raw('SUM(cte.task_cost_it_operating) AS total_cost_it_operatingzo'),
    //        DB::raw('SUM(cte.task_cost_it_investment) AS total_cost_it_investmentzo'),
    //        DB::raw('SUM(cte.task_cost_gov_utility) AS total_cost_gov_utilityzo'),
    //        DB::raw(' sum( COALESCE(cte.task_cost_gov_utility,0))
    //        +sum( COALESCE(cte.task_cost_it_operating,0))
    //        +sum( COALESCE(cte.task_cost_it_investment,0))
    //        as costs_disbursement_sumzo'),
    //        DB::raw('SUM(cte.task_pay) AS total_task_payzo'),
    //        DB::raw('sum(a.total_pay) as total_payazo'),
    //        DB::raw('SUM(a.total_taskcon_pay) AS total_taskcon_payzo')
    //    )
    //    ->leftJoin(DB::raw("({$subQuery->toSql()}) as a"), 'a.task_parent', '=', 'cte.task_id')
      // ->whereNull('cte.task_parent')
      // ->groupBy('cte.task_id') // Removed the aggregate fields from the GROUP BY clause
      // ->havingRaw('SUM(a.total_taskcon_pay) ') // Example condition: total_cost_it_operatingzo must be greater than 0
    //  ->where('cte.task_id', $task_ids) // specify table name
     // ->groupByRaw('1')

    // ->get()
      // ;
      // $mainQuery = $mainQuery->get();
      // dd($mainQuery);
         // Manually merge the bindings
//($mergedBindings = array_merge($cteQuery->getBindings(), $subQuery->getBindings()));

// Get the results

//($results = DB::select($mainQuery->toSql(), $mergedBindings));

     //  dd($results);



//dd($results);

/*  $cteQuery = DB::table('tasks')
    ->withRecursiveExpression('Final', function ($rec) use ($id, $id_tasks) {
        $rec->select('task_id as Origin', 'task_parent as Destination',
                     DB::raw('COALESCE(task_cost_gov_utility, 0) + COALESCE(task_cost_it_operating, 0) + COALESCE(task_cost_it_investment, 0) as LeastCost'))
            ->from('tasks')
            ->whereIn('tasks.task_id', [1616,1617])
            ->unionAll(function ($uni) use ($id, $id_tasks) {
                $uni->select('tasks.task_id as Origin', 'Final.Destination',
                             DB::raw('tasks.task_cost_it_operating + tasks.task_cost_it_investment + tasks.task_cost_gov_utility + Final.LeastCost as LeastCost'))
                    ->from('tasks')
                    ->join('Final', 'tasks.task_parent', '=', 'Final.Origin');
            });
    })
    ->from('Final')
    ->groupBy('Origin', 'Destination')
    ->select('Origin', 'Destination', DB::raw('min(LeastCost) as LeastCost'))
   ->tosql();

dd($cteQuery); */

    ($tasks = DB::table('tasks')
            ->select(
                'tasks.*',

               //'acte.total_task_task_budget_cte',
                'asum.total_task_mm_budget_task_sum',
                'asum.costs_disbursement_sum',
                'asum.total_task_task_budget',
                'a.total_task_mm_budget_task',
                'a.costs_disbursement',
                'a.total_taskcon_cost',
                'a.total_task_refund_pa_budget',
                'a.total_taskcon_pay',
                'ab.total_task_refund_pa_budget_1',
                'ac.total_task_refund_pa_budget_2',
                'ab.total_task_mm_budget_1',
                'ac.total_task_mm_budget_2',
                'ab.cost_pa_1',
                'ac.cost_no_pa_2',
                'a.total_pay',
                'ab.total_pay_1',
                'ac.total_pay_2',
                'a.total_taskcon_pay',
                'cc.taskcons_task_id',
                'cc.taskcons_contract_id',
                'ad.total_taskcon_cost_pa_1',
                'ad.total_taskcon_pay_pa_1',
                'astatus_pa.total_task_refund_pa_budget_status',
                'astatus.total_task_refund_no_pa_budget_status',

                'astaaksub.task_tasksub_type2',// taaksub 2
                'astaaksub.total_task_refund_no_pa_budget_parent',
                'astaaksubrefund.total_task_refund_sub_budget_parent',
                //'cte.total_cost_it_operatingzo',
                //'cte.costs_disbursement_sumzo',
                //'cte.pid',
                'cte.root as tt',
                'cte.totalLeastBudget',
                'cte.totalLeastCost',
                'cte.totalLeastPay',
                'cte.totalLeastconPay',
                'cte.totalLeasttask_refund_pa_budget2',
                'cte.total_Leasttask_cost_1',
                'cte.total_Leasttask_cost_2',
                'cte.totalleactdifference'

            )

            //->leftJoin(DB::raw("($cteQuery) as acte"), 'acte.task_parent', '=', 'cte.task_id')

            ->leftJoin(
                DB::raw('(select tasks.task_parent,
                sum( COALESCE(tasks.task_mm_budget,0))  as total_task_mm_budget_task_sum,

                sum(COALESCE(tasks.task_budget_gov_utility,0))
                +sum(COALESCE(tasks.task_budget_it_operating,0))
                +sum(COALESCE(tasks.task_budget_it_investment,0)) as total_task_task_budget ,


                sum( COALESCE(tasks.task_cost_gov_utility,0))
        +sum( COALESCE(tasks.task_cost_it_operating,0))
        +sum( COALESCE(tasks.task_cost_it_investment,0))
        as costs_disbursement_sum


        from tasks


                    where tasks.deleted_at IS NULL

        group by tasks.task_parent) as asum'),
                'asum.task_parent',
                '=',
                'tasks.task_id'
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


        sum( COALESCE(tasks.task_pay,0))  as total_pay,

        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget


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
            where tasks.deleted_at IS NULL

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
        sum( COALESCE(tasks.task_pay,0)) as total_pay_1,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget_1

        from tasks
        where tasks.task_type=1   AND tasks.deleted_at IS NULL group by tasks.task_parent) as ab'),
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
        sum( COALESCE(tasks.task_pay,0)) as total_pay_2,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget_2
        from tasks  where tasks.task_type=2   AND tasks.deleted_at IS NULL group by tasks.task_parent) as ac'),
                'ac.task_parent',
                '=',
                'tasks.task_id'
            )

            ->leftJoin(
                DB::raw('(select tasks.task_parent,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget_status
        from tasks  where tasks.task_type=1  AND  tasks.task_refund_pa_status=2   AND tasks.deleted_at IS NULL group by tasks.task_parent) as astatus_pa'),
                'astatus_pa.task_parent',
                '=',
                'tasks.task_id'
            )


            ->leftJoin(
                DB::raw('(select tasks.task_parent,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_no_pa_budget_status
        from tasks  where tasks.task_type=2
        AND  tasks.task_refund_pa_status=2
        AND tasks.deleted_at IS NULL group by tasks.task_parent) as astatus'),
                'astatus.task_parent',
                '=',
                'tasks.task_id'
            )







            ->leftJoin(
                DB::raw('(select tasks.task_parent as task_tasksub_type2,
                    sum(COALESCE(tasks.task_refund_pa_budget, 0)) as total_task_refund_no_pa_budget_parent
                    from tasks
                    where tasks.task_type=2
                    AND tasks.task_refund_pa_status=2
                    AND tasks.deleted_at IS NULL
                    group by tasks.task_parent) as astaaksub'),
                'astaaksub.task_tasksub_type2',
                '=',
                'tasks.task_parent'
            )


            ->leftJoin(
                DB::raw('(select tasks.task_parent as task_tasksub_type2,
                    sum(COALESCE(tasks.task_refund_pa_budget, 0)) as total_task_refund_sub_budget_parent
                    from tasks
                    where tasks.task_type=3
                    AND tasks.task_refund_pa_status=2
                    AND tasks.deleted_at IS NULL
                    group by tasks.task_parent) as astaaksubrefund'),
                'astaaksubrefund.task_tasksub_type2',
                '=',
                'tasks.task_parent'
            )




            ->leftJoin(DB::raw('(SELECT taskcons.task_id as taskcons_task_id,
            taskcons.contract_id as taskcons_contract_id,
            taskcons.taskcon_pay
            FROM taskcons) as cc'), function ($join) {
                $join->on('cc.taskcons_task_id', '=', 'tasks.task_id');
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
                where tasks.task_type=1  AND tasks.deleted_at IS NULL  group by tasks.task_id) as ad'),
                'ad.task_id',
                '=',
                'tasks.task_id'
            )


            ->leftJoin(DB::raw("({$cteQuery->toSql()} )  as cte"), 'cte.root', '=', 'tasks.task_id')
            ->mergeBindings($cteQuery) // Merge the bindings from the main query
            ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
            ->where('project_id', ($id))
            ->get()
            ->toArray());

           //dd($tasks);


           $tasks = json_decode(json_encode($tasks), true);
           $cteQueryArray = json_decode(json_encode($cteQuery), true);

         //  dd(['tasks' => $tasksArray, 'cteQuery' => $cteQueryArray]);

        foreach ($tasks as $task) {
            (float) $__budget_gov = (float) $task['task_budget_gov_operating'] + (float) $task['task_budget_gov_utility'] + (float) $task['task_budget_gov_investment'];
            (float) $__budget_it  = (float) $task['task_budget_it_operating'] + (float) $task['task_budget_it_investment'];

            ((float) $__budget_mm  = (float) $task['task_mm_budget']);
            ((float) $__costs  = (float) $task['costs_disbursement']);

            ((float) $__refund_pa_budget  = (float) $task['task_refund_pa_budget']);

            ((float) $__task_parent_sub_budget  = (float) $task['task_parent_sub_budget']);


            ((float) $__task_parent_sub_cost  = (float) $task['task_parent_sub_cost']);

            ((float) $__task_parent_sub_refund_pa_budget  = (float) $task['task_parent_sub_refund_budget']);

           // ((float) $__total_cost_it_operatingzo = (float) $task['total_cost_it_operatingzo']);

           ((float) $__totalLeastBudget = (float) $task['totalLeastBudget']);
           ((float) $__totalLeastCost = (float) $task['totalLeastCost']);
           ((float) $__totalLeastPay = (float) $task['totalLeastPay']);
            ((float) $__totalLeastconPay = (float) $task['totalLeastconPay']);
            ((float) $__totalLeasttask_refund_pa_budget2 = (float) $task['totalLeasttask_refund_pa_budget2']);
            ((float) $__total_Leasttask_cost_1 = (float) $task['total_Leasttask_cost_1']);

            ((float) $__total_Leasttask_cost_2 = (float) $task['total_Leasttask_cost_2']);

            ((float) $__total_totalleactdifference= (float) $task['totalleactdifference']);





           // ((float) $__total_taskcon_payzo = (float) $task['total_taskcon_payzo']);


            (float) $__totalLeastPay_Least =  $__totalLeastPay+$__totalLeastconPay ;
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
                'tbalance_sub'               => $__balance,
                'cost'                  => $__cost,
                'total_task_cost'                  => $__cost+$task['cost_pa_1']+$task['cost_no_pa_2'],
                'total_taskcon_cost_pa_1'  => $task['total_taskcon_cost_pa_1'],


                'cost_pa_1'             => $task['cost_pa_1'],
                'cost_no_pa_2'             => $task['cost_no_pa_2'],
                'cost_disbursement'     => $project['cost_disbursement'],
                'pay'                   => $task['task_pay']+$task['total_taskcon_pay_pa_1']+$task['total_taskcon_pay']+$task['total_pay_1']+$task['total_pay_2'],
                'budget_mm'             => $task['task_mm_budget'],
                'task_refund_pa_budget'             => $__refund_pa_budget,
                'total_task_refund_pa_budget'             => $task['total_task_refund_pa_budget_1']+$task['total_task_refund_pa_budget_2'],
                'total_task_refund_pa_budget_1'             => $task['total_task_refund_pa_budget_1'],
                'total_task_refund_pa_budget_2'             => $task['total_task_refund_pa_budget_2'],

                'total_task_refund_budget_status'      => $task['total_task_refund_pa_budget_status']+$task['total_task_refund_no_pa_budget_status'],

                'task_refund_pa_budget_status'      => $task['total_task_refund_pa_budget_status'],
                'task_refund_no_pa_budget_status'      => $task['total_task_refund_no_pa_budget_status'],


                'balanc_mmpr_sum'             => $__balance_mmpr_sum,
                'budget_total_task_mm'             => $task['total_task_mm_budget_task'],
                'budget_total_task_mm_sum'             => $task['total_task_mm_budget_task_sum'],
                'budget_task_mm_1'             => $task['total_task_mm_budget_1'],
                'budget_task_mm_2'             => $task['total_task_mm_budget_2'],

                'cost_disbursement_task'     => $__costs,
                'task_total_pay'             => $task['total_pay']+$task['total_taskcon_pay']+$task['total_pay_1']+$task['total_pay_2'],

                'task_total_pay_1'             => $task['total_pay_1'],
                'task_total_pay_2'             => $task['total_pay_2'],
                'total_taskcon_pay'         =>  $task['total_taskcon_pay'],

                'total_taskcon_pay_pa_1'    =>  $task['total_taskcon_pay_pa_1'],
                'task_type'             => $task['task_type'],
                'task_status'             => $task['task_status'],
                'task_refund_pa_status'             => $task['task_refund_pa_status'],
                'task_parent_sub_refund_pa_status'  => $task['task_parent_sub_refund_pa_status'],
                'task_parent_sub'             => $task['task_parent_sub'],


                'task_parent_sub_refund'             =>    $task['total_task_refund_sub_budget_parent'],
                'task_parent_sub_budget'                =>   $__task_parent_sub_budget,
                'task_parent_sub_cost'                    =>    $__task_parent_sub_cost,
                'task_parent_sub_refund_budget'            =>      $__task_parent_sub_refund_pa_budget,
                'task_parent_sub_pay'                    =>      $task['task_parent_sub_pay']+$task['total_taskcon_pay'],
                //'total_cost_it_operatingzo'             =>  $__total_cost_it_operatingzo,


                'totalLeastCost'              =>  $__totalLeastCost ,
                'totalLeastPay_Least'              =>  $__totalLeastPay_Least ,

               'totalLeasttask_refund_pa_budget' => $__totalLeasttask_refund_pa_budget2,
                'total_Leasttask_cost_1'       => $__total_Leasttask_cost_1,
                'total_Leasttask_cost_2'       => $__total_Leasttask_cost_2,
                'totalleactdifference'         => $__total_totalleactdifference,


                //'total_taskcon_payzo'  => $__total_taskcon_payzo,
                   //'total_task_taskcon_payzo '                     => $__total_task_taskcon_payzo ,


                'type'                  => 'task',
                // 'owner' => $project['project_owner'],
            ]);

            $__project_cost[] = $__cost;
            ($__project_pay[] = $task['task_pay']);
            ($__project_parent[] = $task['task_parent'] ? 'T' . $task['task_parent'] . $task['project_id'] : $task['project_id']);
            ($__project_parent_cost[] = 'parent');
        }





  // dd($gantt);


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


                  //dd($contractgannt);


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

           //dd($gantt);







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
        ($gantt[0]['budget_total_mm_pr2_2'] =  (($budget['total']-$gantt[0]['budget_total_mm_p'])+$gantt[0]['refund_pa_budget']));
        ($gantt[0]['budget_total_task_budget_end'] = $budget['budget_total_task_budget_end']);
        ($gantt[0]['budget_total_task_budget_end_p2'] = $budget['budget_total_task_budget_end_p2']);

        // $budget['budget_total_taskcon_pay_con'] = $gantt[0]['budget_total_taskcon_pay_con'];
        $budget['pay']    = $gantt[0]['total_pay']+$gantt[0]['total_taskcon_pay_con'];


        $budget['cost']    = $gantt[0]['total_cost'];
        //$budget['budget_total_mm_pr2'] = $gantt[0]['budget_total_mm_pr2'];
        $budget['balance'] = $gantt[0]['balance'];
        //  $budget['balance'] = $gantt[0]['balance'];


       // dd($gantt,$budget);


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
        ($operating_budget_sum_task = DB::table('tasks')
        ->selectRaw('SUM(COALESCE(task_budget_it_operating,0)) As operating_budget_sum_task')
       // ->where('tasks.task_type', 1)
        ->where('project_id', ($id))
         ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
// เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
        ->get());
    ($json = json_decode($operating_budget_sum_task));
    ($operating_budget_sum_task = $json[0]->operating_budget_sum_task);
    ($operating_budget_sum_task = (float)$operating_budget_sum_task);

    ($op_budget_task = $operating_budget_sum_task);

   // dd($op_budget_task);

        ($operating_budget_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_budget_it_operating,0)) As operating_budget_sum')
            ->where('tasks.task_type', 1)
            ->where('project_id', ($id))
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
            ->get());
        ($json = json_decode($operating_budget_sum));
        ($operating_budget_sum = $json[0]->operating_budget_sum);
        ($operating_budget_sum = (float)$operating_budget_sum);



        ($operating_budget_sum_no = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_budget_it_operating,0)) As operating_budget_sum_no')
            ->where('tasks.task_type', 2)
            ->where('project_id', ($id))
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
            ->get());
        ($json = json_decode($operating_budget_sum_no));
        ($operating_budget_sum_no = $json[0]->operating_budget_sum_no);
        ($operating_budget_sum_no = (float)$operating_budget_sum_no);

        ($op_budget= $operating_budget_sum+$operating_budget_sum_no);

        //dd($operating_budget_sum);
        //($operating_budget_sum_no);
//2
        ($operating_pa_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_cost_it_operating,0)) As ospa')
            //->where('tasks.task_type', 1)
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
            ->where('tasks.task_type', 1)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($operating_pa_sum));
        ($ospa = $json[0]->ospa);
        ($ospa = (float)$ospa);


        ($operating_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_cost_it_operating,0)) As osa')
            //->where('tasks.task_type', 1)
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
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
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
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
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
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
         ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
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
         ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
        //->where('task_cost_gov_utility', '>', 1)
        ->where('project_id', ($id))
        ->get());
        ($json = json_decode($operating_refund_pa_no));
        ($operating_refund_pa_no = $json[0]->operating_refund_pa_no);
        ($operating_refund_pa_no = (float)$operating_refund_pa_no);
//5

            $op_mm=$operating_mm_pa+$operating_mm_pa_no;
            ($op_refund = $operating_refund_pa+$operating_refund_pa_no);
            $op_refund_mm_pr = $project['budget_it_operating'] -($op_mm-$op_refund);

            $op_refund_budget_pr = $project['budget_it_operating'] -($op_budget_task-$op_refund);


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
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
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
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
            ->get());
        ($json = json_decode($operating_pay_sum_2));
        ($otpsa2 = $json[0]->iv2);
        ($otpsa2 = (float)$otpsa2);





        //ดำเนิน
        //1
 //1
/*  ($investment_budget_sum = DB::table('tasks')
 ->selectRaw('SUM(COALESCE(task_budget_it_investment,0)) As investment_budget_sum')
 //->where('tasks.task_type', 1)
 ->where('project_id', ($id))
  ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
// เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 ->get());
($json = json_decode($investment_budget_sum));
($investment_budget_sum = $json[0]->investment_budget_sum);
($investment_budget_sum = (float)$investment_budget_sum);

        dd($investment_budget_sum); */




        ($investment_budget_sum = DB::table('tasks')
        ->selectRaw('SUM(COALESCE(task_budget_it_investment,0)) As investment_budget_sum')
        ->where('tasks.task_type', 1)
        ->where('project_id', ($id))
         ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
        ->get());
    ($json = json_decode($investment_budget_sum));
    ($investment_budget_sum = $json[0]->investment_budget_sum);
    ($investment_budget_sum = (float)$investment_budget_sum);



    ($investment_budget_sum_no = DB::table('tasks')
        ->selectRaw('SUM(COALESCE(task_budget_it_investment,0)) As investment_budget_sum_no')
        ->where('tasks.task_type', 2)
         ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
        ->where('project_id', ($id))
        ->get());
    ($json = json_decode($investment_budget_sum_no));
    ($investment_budget_sum_no = $json[0]->investment_budget_sum_no);
    ($investment_budget_sum_no = (float)$investment_budget_sum_no);



    $is_budget = $investment_budget_sum + $investment_budget_sum_no ;


   //dd($is_budget);



//2
        ($investment_pa_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_cost_it_investment,0)) As ispa')
            ->where('tasks.task_cost_it_investment', '>', 1)
            ->where('tasks.task_type', 1)
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($investment_pa_sum));
        ($ispa = $json[0]->ispa);
        ($ispa = (float)$ispa);

        ($investment_sum = DB::table('tasks')
        ->selectRaw('SUM(COALESCE(task_cost_it_investment,0)) As isa')

        ->where('tasks.task_cost_it_investment', '>', 1)
        ->where('tasks.task_type', 2)
         ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
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
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
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
              ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
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
                     ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
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
                     ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
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
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
            ->where('projects.project_id', ($id))
            ->get());
        ($json = json_decode($investment_pay_sum_1));
        ($itpsa1 = $json[0]->iv);
        ($itpsa1 = (float)$itpsa1);

        ($investment_pay_sum_2 = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_pay,0)) as iv')
            ->where('tasks.task_cost_it_investment', '>', 1)
            ->where('tasks.task_type', 2)
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($investment_pay_sum_2));
        ($itpsa2 = $json[0]->iv);
        ($itpsa2 = (float)$itpsa2);


        ($investment_total_pay_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_pay,0)) as iv')
            ->where('tasks.task_cost_it_investment', '>', 1)
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($investment_total_pay_sum));
        ($itpsa = $json[0]->iv);
        ($itpsa = (float)$itpsa);













        // สาธู
        ($ut_budget_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_budget_gov_utility,0)) As ut_budget_sum')
            ->where('tasks.task_type', 1)
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($ut_budget_sum));
        ($ut_budget_sum = $json[0]->ut_budget_sum);
        ($ut_budget_sum = (float)$ut_budget_sum);

        //dd($ut_budget_sum);

        ($ut_budget_sum_no = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_budget_gov_utility,0)) As ut_budget_sum_no')
            ->where('tasks.task_type', 2)
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($ut_budget_sum_no));
        ($ut_budget_sum_no = $json[0]->ut_budget_sum_no);
        ($ut_budget_sum_no = (float)$ut_budget_sum_no);


       // dd($ut_budget_sum_no);

        ($ut_pa_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_cost_gov_utility,0)) As utpcs')
            ->where('tasks.task_type', 1)
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($ut_pa_sum));
        ($utpcs = $json[0]->utpcs);
        ($utpcs = (float)$utpcs);

        ($ut_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_cost_gov_utility,0)) As utsc')
            ->where('tasks.task_type', 2)
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($ut_sum));
        ($utsc = $json[0]->utsc);
        ($utsc = (float)$utsc);



        ($ut_mm_pa_sum = DB::table('tasks')
        ->selectRaw('SUM(COALESCE(task_mm_budget,0)) As utsc_mm_pa  ')
        ->where('tasks.task_budget_gov_utility', '>', 1)
        ->where('tasks.task_type', 1)
         ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
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
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
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
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
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
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
            //->where('task_cost_gov_utility', '>', 1)
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($ut_refund_pa_no));
        ($ut_refund_pa_no = $json[0]->ut_refund_pa_no);
        ($ut_refund_pa_no = (float)$ut_refund_pa_no);


        $utsc_mm = $utsc_mm_pa + $utsc_mm_pa_no;
        ($ut_refund = $ut_refund_pa + $ut_refund_pa_no);
        $ut_refund_mm_pr = $project['budget_gov_utility'] - ($utsc_mm - $ut_refund);

       // $ut_refund_mm_pr_sum = $project['budget_gov_utility'] - ($utsc_mm - $ut_refund);

         //dd($utsc_mm,$ut_refund,$ut_refund_mm_pr,$ut_refund_pa_no,$utpcs,$utsc,$utsc_mm_pa,$utsc_mm_pa_no);



        ($ut_pay_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_pay,0)) As utsc_pay  ')
            ->where('tasks.task_type', 2)
            ->where('task_cost_gov_utility', '>', 1)
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
            ->where('project_id', ($id))

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
            ->where('tasks.task_type', 1)
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
            ->where('task_cost_gov_utility', '>', 1)
            ->where('projects.project_id', ($id))
            ->get());
        ($json = json_decode($ut_pay_pa_sum));
        ($utsc_pay_pa = $json[0]->iv);
        ($utsc_pay_pa = (float)$utsc_pay_pa);






         //dd($utpcs,$utsc_pay_pa,$utsc_pay);





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
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
            ->where('project_id', $id)
            ->get();

        ($parent_sum_pa);




        ($parent_sum_cd = DB::table('tasks')
            ->select('task_parent', DB::raw('sum(task_pay) as cost_app'))
            ->whereNotNull('task_parent')
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
            ->groupBy('task_parent')
            ->get()
        );


        $taskconoverview = DB::table('tasks')
            ->select('tasks.task_id as task_id', 'tasks.project_id as project_id', 'taskcons.taskcon_id as taskcons_id', 'tasks.task_name as task_name', 'taskcons.taskcon_name as taskcons_name')
            ->leftJoin('taskcons', 'tasks.task_id', '=', 'taskcons.task_id') // assuming 'id' is the primary key in 'tasks' and 'task_id' is the foreign key in 'taskcons'
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
            ->where('tasks.project_id', $id)
            ->get();
        $taskconoverviewcon = DB::table('tasks')
            ->select('tasks.task_id as task_id', 'tasks.project_id as project_id', 'contracts.contract_id as contract_id', 'taskcons.taskcon_id as taskcons_id', 'tasks.task_name as task_name', 'taskcons.taskcon_name as taskcons_name')
            ->join('contract_has_tasks', 'tasks.task_id', '=', 'contract_has_tasks.task_id')
            ->join('contracts', 'contract_has_tasks.contract_id', '=', 'contracts.contract_id')
            ->join('taskcons', 'contracts.contract_id', '=', 'taskcons.contract_id')
             ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
            ->where('tasks.project_id', $id)
            ->get();
        $contractoverviewcon = DB::table('tasks')
            ->select('tasks.task_id', 'projects.project_id', 'tasks.project_id', 'projects.project_name as project_name', 'taskcons.taskcon_id as taskcons_id', 'tasks.task_name as task_name', 'taskcons.taskcon_name as taskcons_name')
            ->join('taskcons', 'tasks.task_id', '=', 'taskcons.task_id')
            ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
             ->whereNotNull('tasks.deleted_at') // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
            ->get();


          //dd($project->main_task_activity);

         //dd($taskconoverview,$taskconoverviewcon, $contractoverviewcon);

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

 //dd($gantt,$budget,$result,$project);

         // dd($gantt);
        $gantt = json_encode($gantt);


       ($projectcontract = $project->contract);

        $contractIds = $projectcontract->pluck('contract_id');
   //    dd ($contractIds);
        $contract_tasks = Contract::whereIn('contract_id', $contractIds)->get();


   //  dd ($contract_tasks);
       // $contractId = $projectcontract->contract_id;

        //dd($project);



        //dd($project->main_task);

        return view('app.projects.view', compact(
            'cteQuery',
            'contract_tasks',
            'is_refund_mm_pr',
            'is_budget',

            'op_refund_budget_pr',
            'op_refund_mm_pr',
            'op_budget',
            'operating_budget_sum_task',



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
        //dd($task);
       ($tasks=$task->subtask);
        //  dd($task);
        // dd($project,$task);
        ($tasks_sub=$task->subtask);



        //($id = Hashids::decode($project));
        $id_tasks = Task::select('task_id')->where('task_id', $task->task_id)
->whereNull('tasks.task_parent')->whereNull('tasks.deleted_at')->get()->pluck('task_id');
$id_tasks_sub = Task::select('task_id')->where('task_parent', $task->task_id)
->whereNull('tasks.deleted_at')->get()->pluck('task_id');
               // dd($id_tasks,$id_tasks_sub);
        $cteQuery = DB::table('tasks')
        ->withRecursiveExpression('cte', function ($rec) use ($id_tasks, $project,$id_tasks_sub) {
            $rec->select(
                't.task_id',

                't.project_id',
                't.task_parent',
                't.task_id AS root',
                DB::raw('COALESCE(t.task_budget_gov_utility, 0)
                 + COALESCE(t.task_budget_it_operating, 0) + COALESCE(t.task_budget_it_investment, 0) AS LeastBudget'),
                DB::raw('COALESCE(t.task_cost_gov_utility, 0) +
                COALESCE(t.task_cost_it_operating, 0) + COALESCE(t.task_cost_it_investment, 0) AS LeastCost'),


                't.task_pay as LeastPay',
                't.task_refund_pa_budget as Leasttask_refund_pa_budget',

                DB::raw('(
                   SELECT MAX(temp.total_cost_1)
                   FROM (
                       SELECT inner_tasks.task_parent,
                              SUM(COALESCE(inner_tasks.task_cost_gov_utility, 0)) +
                              SUM(COALESCE(inner_tasks.task_cost_it_operating, 0)) +
                              SUM(COALESCE(inner_tasks.task_cost_it_investment, 0)) AS total_cost_1
                       FROM tasks as inner_tasks
                       WHERE inner_tasks.task_type = 1 AND inner_tasks.deleted_at IS NULL
                       GROUP BY inner_tasks.task_parent
                   ) AS temp
                   WHERE temp.task_parent = t.task_id  -- assuming t is the alias of tasks in your main query
               ) AS ab_1
       ')

       ,

       DB::raw('(
           SELECT MAX(temp.total_cost_2)
           FROM (
               SELECT inner_tasks.task_parent,
                      SUM(COALESCE(inner_tasks.task_cost_gov_utility, 0)) +
                      SUM(COALESCE(inner_tasks.task_cost_it_operating, 0)) +
                      SUM(COALESCE(inner_tasks.task_cost_it_investment, 0)) AS total_cost_2
               FROM tasks as inner_tasks
               WHERE inner_tasks.task_type = 2 AND inner_tasks.deleted_at IS NULL
               GROUP BY inner_tasks.task_parent
           ) AS temp
           WHERE temp.task_parent = t.task_id  -- assuming t is the alias of tasks in your main query
       ) AS ab_2
   '),
                DB::raw('(
                   SELECT sum(COALESCE(taskcons.taskcon_pay,0))
                FROM contract_has_tasks
                JOIN contracts ON contract_has_tasks.contract_id = contracts.contract_id
                JOIN taskcons ON contracts.contract_id = taskcons.contract_id
                WHERE contracts.deleted_at IS NULL AND contract_has_tasks.task_id = t.task_id
                )

                as Leasttask_taskcon_pay')

                )

                ->from('tasks as t')
                ->whereIn('t.task_id', $id_tasks_sub)
                ->whereNull('t.deleted_at')
                ->unionAll(function ($uni) {
                    $uni->select(
                        'tasks.task_id',
                        'tasks.project_id',
                        'tasks.task_parent',
                        'cte.root',
                        DB::raw('tasks.task_budget_it_operating + tasks.task_budget_it_investment + tasks.task_budget_gov_utility + cte.LeastBudget AS LeastBudget'),
                        DB::raw('tasks.task_cost_it_operating + tasks.task_cost_it_investment + tasks.task_cost_gov_utility + cte.LeastCost AS LeastCost'),
                        DB::raw('tasks.task_pay + cte.LeastPay AS LeastPay'),
                        DB::raw('tasks.task_refund_pa_budget +cte.Leasttask_refund_pa_budget AS Leasttask_refund_pa_budget'),
                        DB::raw('(
                           SELECT MAX(temp.total_cost_1)
                           FROM (
                               SELECT inner_tasks.task_parent,
                                      SUM(COALESCE(inner_tasks.task_cost_gov_utility, 0)) +
                                      SUM(COALESCE(inner_tasks.task_cost_it_operating, 0)) +
                                      SUM(COALESCE(inner_tasks.task_cost_it_investment, 0)) AS total_cost_1
                               FROM tasks as inner_tasks
                               WHERE inner_tasks.task_type = 1 AND inner_tasks.deleted_at IS NULL
                               GROUP BY inner_tasks.task_parent
                           ) AS temp
                           WHERE temp.task_parent = tasks.task_id  -- assuming t is the alias of tasks in your main query
                       ) AS ab_1
               '),

               DB::raw('(
                   SELECT MAX(temp.total_cost_2)
                   FROM (
                       SELECT inner_tasks.task_parent,
                              SUM(COALESCE(inner_tasks.task_cost_gov_utility, 0)) +
                              SUM(COALESCE(inner_tasks.task_cost_it_operating, 0)) +
                              SUM(COALESCE(inner_tasks.task_cost_it_investment, 0)) AS total_cost_2
                       FROM tasks as inner_tasks
                       WHERE inner_tasks.task_type = 2 AND inner_tasks.deleted_at IS NULL
                       GROUP BY inner_tasks.task_parent
                   ) AS temp
                   WHERE temp.task_parent = tasks.task_id  -- assuming t is the alias of tasks in your main query
               ) AS ab_2
       '),

                        DB::raw('(SELECT sum(COALESCE(taskcons.taskcon_pay,0))
                        FROM contract_has_tasks
                        JOIN contracts ON contract_has_tasks.contract_id = contracts.contract_id
                        JOIN taskcons ON contracts.contract_id = taskcons.contract_id
                        WHERE contracts.deleted_at IS NULL AND contract_has_tasks.task_id = tasks.task_id)
                        AS Leasttask_taskcon_pay
                        ')

                    )
                        ->from('tasks')
                        ->whereNull('tasks.deleted_at')
                        ->join('cte', 'tasks.task_parent', '=', 'cte.task_id');
                });
        });


    $combinedQuery = $cteQuery
        ->from('cte')

        ->groupBy('cte.root',) // Add these columns to the GROUP BY clause
        ->select(
            'cte.root',
            DB::raw('MIN(cte.LeastBudget) AS totalLeastBudget'),
            DB::raw('SUM(cte.LeastCost) AS totalLeastCost'),
            DB::raw('SUM(cte.LeastPay) AS totalLeastPay'),


            DB::raw('sum(cte.Leasttask_taskcon_pay) AS totalLeastconPay'),
            DB::raw('max(cte.Leasttask_refund_pa_budget) AS totalLeasttask_refund_pa_budget'),
            DB::raw('sum(cte.Leasttask_refund_pa_budget) AS totalLeasttask_refund_pa_budget1'),
            DB::raw('min(cte.Leasttask_refund_pa_budget) AS totalLeasttask_refund_pa_budget2'),
            DB::raw('SUM(cte.LeastCost) AS totalLeastCost_1'),

            DB::raw('SUM(cte.ab_1) AS total_Leasttask_cost_1'), // Updated this line
            DB::raw('SUM(cte.ab_2) AS total_Leasttask_cost_2'), // Updated this line

        )
        ->orderBy('cte.root')
       // ->whereNull('cte.deleted_at')
        ->get();


   //dd($combinedQuery);
  // dd($task->subtask);
     // dd($cteQuery->get());

     ($combinedQuery);
      //$cteQuery = $cteQuery->first();


      //dd($cteQuery);

        ($sum_task_budget_it_operating = $task->whereNull('task_parent') ->where('tasks.deleted_at', NULL)->sum('task_budget_it_operating'));
        $sum_task_budget_it_investment = $task->whereNull('task_parent') ->where('tasks.deleted_at', NULL)->sum('task_budget_it_investment');
        $sum_task_budget_gov_utility = $task->whereNull('task_parent') ->where('tasks.deleted_at', NULL)->sum('task_budget_gov_utility');

        ($sum_task_budget_it_operating_ts = $tasks->where('task_parent') ->where('tasks.deleted_at', NULL)->sum('task_budget_it_operating'));
        $sum_task_refund_budget_it_operating= $tasks->where('task_parent') ->where('tasks.deleted_at', NULL)->where('task_budget_it_operating', '>', 1)->sum('task_refund_pa_budget');


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

         //dd($taskcons);

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



            $results_sum = Contract::join('taskcons', 'contracts.contract_id', '=', 'taskcons.contract_id')
            ->join('contract_has_tasks', 'contracts.contract_id', '=', 'contract_has_tasks.contract_id')
            ->join('tasks', 'contract_has_tasks.task_id', '=', 'tasks.task_id')
            ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            ->select('taskcons.taskcon_pay','contracts.*', 'tasks.*')
            ->where('projects.project_id', $project->project_id)
            ->where('tasks.task_id', $task->task_id)
            ->get();




      //  dd($results,$results2,$results_sum);

       // dd($task->subtask);



                $task_sub = $task->subtask ->where('tasks.deleted_at', NULL);

                $sum_tasksub_budget_it_operating = $task_sub->sum('task_budget_it_operating');
                $sum_tasksub_cost_budget_it_operating= $task_sub->where('task_budget_it_operating', '>', 1)->sum('task_cost_it_operating');
                $sum_tasksub_refund_budget_it_operating= $task_sub->where('task_budget_it_operating', '>', 1)->sum('task_refund_pa_budget');
                $sum_tasksub_mm_budget= $task_sub->where('task_budget_it_operating', '>', 1)->sum('task_mm_budget');
                $sum_tasksub_pay= $task_sub->where('task_pay', '>', 1);

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
                        $carry['operating']['task_pay'] += $subtask->task_pay;
                    }

                    if ($subtask->task_budget_it_investment > 1) {
                        $carry['investment']['task_budget'] += $subtask->task_budget_it_investment;
                        $carry['investment']['task_cost'] += $subtask->task_cost_it_investment;



                        $carry['investment']['task_refund_pa_status'] =  $subtask->task_refund_pa_status;
                        $carry['investment']['task_pay'] += $subtask->task_pay;

                        // ($carry); // เพิ่มบรรทัดนี้เพื่อดูค่าของ $refundPaBudget


                        $refundPaBudget = is_int($subtask->task_refund_pa_status) ? collect([$subtask->task_refund_pa_status]) : $subtask->task_refund_pa_status;
                        ($refundPaBudget); // เพิ่มบรรทัดนี้เพื่อดูค่าของ $refundPaBudget

                        // ใช้ฟังก์ชัน where() กับคอลเลกชัน
                   //  ($filteredRefundTasks = $refundPaBudget->where('task_refund_pa_status', 2));
                    //    $carry['investment']['task_refund_pa_budget'] += $filteredRefundTasks->sum('task_refund_pa_budget');


                        $carry['investment']['task_refund_pa_budget_2'] += $subtask->task_refund_pa_budget;
                        $carry['investment']['task_mm_budget'] += $subtask->task_mm_budget;
                    }

                    if ($subtask->task_budget_gov_utility > 1) {
                        $carry['utility']['task_budget'] += $subtask->task_budget_gov_utility;
                        $carry['utility']['task_cost'] += $subtask->task_cost_gov_utility;
                        $carry['utility']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;
                        $carry['utility']['task_mm_budget'] += $subtask->task_mm_budget;
                        $carry['utility']['task_pay'] += $subtask->task_pay;

                        // Add other fields as necessary...
                    }

                    return $carry;
                }, ['operating' => ['task_budget' => 0, 'task_cost' => 0, 'task_refund_pa_budget' => 0, 'task_mm_budget' => 0, 'task_pay' => 0],
                    'investment' => ['task_budget' => 0, 'task_cost' => 0,  'task_refund_pa_budget' => 0, 'task_refund_pa_budget_2' => 0, 'task_mm_budget' => 0, 'task_pay' => 0],
                    'utility' => ['task_budget' => 0, 'task_cost' => 0, 'task_refund_pa_budget' => 0, 'task_mm_budget' => 0, 'task_pay' => 0]]);


              // dd($task_sub_sums);

               $task_sub_refund = $task->subtask->where('task_refund_pa_status', 2);
           //   dd($task_sub_refund);




               $task_sub_refund_pa_budget = $task_sub_refund->reduce(function ($carry, $subtask) {
                if ($subtask->task_budget_it_operating > 1) {
                    $carry['operating']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;
                }

                if ($subtask->task_budget_it_investment > 1) {
                    $carry['investment']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;

                }

                if ($subtask->task_budget_gov_utility > 1) {

                    $carry['utility']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;

                    // Add other fields as necessary...
                }

                return $carry;
            }, ['operating' => ['task_refund_pa_budget' => 0],
                'investment' => [ 'task_refund_pa_budget' => 0],
                'utility' => ['task_refund_pa_budget' => 0]]);


               // dd($task_sub_refund_pa_budget);





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

             //  dd($task_sub_sums,$sum_tasksub_budget_it_operating,$sum_tasksub_cost_budget_it_operating,$sum_tasksub_refund_budget_it_operating,$sum_tasksub_mm_budget);


             ($latestContract = Contract::latest()->first());

       // dd($task);

       //dd($task->subtask);

     //  dd($contract);



        //dd($latestContract,$results,$taskcons,$contract,$project,$task);

      ($projectcontract = $project->contract);

        $contractIds = $projectcontract->pluck('contract_id');
       ($contractIds);
        $contract_tasks = Contract::whereIn('contract_id', $contractIds)->get();


       $single_contract = $contract_tasks->first();

      //dd($single_contract,$project);

        return view('app.projects.tasks.show', compact('projectcontract','contractIds','single_contract','contract_tasks','combinedQuery','cteQuery','task_sub_refund_pa_budget','files_contract','files','task_sub_sums','taskcons',
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
        $sum_task_refund_budget_it_operating= $tasks->whereNull('task_parent')->where('task_budget_it_operating', '>', 1)->where('task_refund_pa_status', '=', 3)->sum('task_refund_pa_budget');

        // Sum the task_budget_it_investment for all tasks
        $sum_task_budget_it_investment = $tasks->whereNull('task_parent')->sum('task_budget_it_investment');
        $sum_task_refund_budget_it_investment= $tasks->whereNull('task_parent') ->where('task_budget_it_investment', '>', 1)->where('task_refund_pa_status', '=', 3)->sum('task_refund_pa_budget');

        // Sum the task_budget_gov_utility for all tasks
        $sum_task_budget_gov_utility = $tasks->whereNull('task_parent')->sum('task_budget_gov_utility');
        $sum_task_refund_budget_gov_utility= $tasks->whereNull('task_parent')->where('task_budget_gov_utility', '>', 1)->where('task_refund_pa_status', '=', 3)->sum('task_refund_pa_budget');

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
        $sum_task_refund_budget_it_operating= $tasks->whereNull('task_parent')->where('task_budget_it_operating', '>', 1)->where('task_refund_pa_status', '=', 3)->sum('task_refund_pa_budget');


        // Sum the task_budget_it_investment for all tasks
        $sum_task_budget_it_investment = $tasks->whereNull('task_parent')->sum('task_budget_it_investment');
        $sum_task_refund_budget_it_investment= $tasks->whereNull('task_parent') ->where('task_budget_it_investment', '>', 1)->where('task_refund_pa_status', '=', 3)->sum('task_refund_pa_budget');

        // Sum the task_budget_gov_utility for all tasks
        $sum_task_budget_gov_utility = $tasks->whereNull('task_parent')->sum('task_budget_gov_utility');
        $sum_task_refund_budget_gov_utility= $tasks->whereNull('task_parent')->where('task_budget_gov_utility', '>', 1)->where('task_refund_pa_status', '=', 3)->sum('task_refund_pa_budget');

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





    if ($task) {
        $task_sub = $task->subtask;

    if ($task_sub) {


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
      //วใ dd($task_sub_sums);
    } else {
        // จัดการเมื่อ $task_sub เป็น null
        $task_sub = null;
        // เพิ่มโค้ดเพิ่มเติมหากต้องการ...
    }
} else {
    // จัดการเมื่อ $task เป็น null
    // ตัวอย่างเช่น นำไป redirect ไปยังหน้าแสดงข้อผิดพลาดหรือคืนค่า response ข้อผิดพลาด
    // คุณสามารถปรับแต่งตามความต้องการของแอปพลิเคชันได้
}



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
    'projectDetails',
        ));
    }


    public function taskCreateTo(Request $request, $project, $task = null)
    {
        $id = Hashids::decode($project)[0];

        ($tasks = Task::where('project_id', $id)->get());
        $contracts = Contract::orderBy('contract_fiscal_year', 'desc')->get();
        ($request = Project::find($id));

        // Get the task_budget_it_operating for $task->task_id tasks
        $task_budget_it_operating = $tasks->where('task_parent', null)->whereNotNull('tasks.deleted_at')->pluck('task_budget_it_operating')->sum();

        // Get the task_budget_it_investment for $task->task_id tasks
        $task_budget_it_investment = $tasks->where('task_parent', null)->whereNotNull('tasks.deleted_at')->pluck('task_budget_it_investment')->sum();

        // Get the task_budget_gov_utility for $task->task_id tasks
        $task_budget_gov_utility = $tasks->where('task_parent', null)->whereNotNull('tasks.deleted_at')->pluck('task_budget_gov_utility')->sum();



        if ($task) {
            $taskId = Hashids::decode($task)[0];
            $task = Task::find($taskId);
        } else {
            $task = null;
        }

       // dd($task->subtask);

        if ($task) {
            $task_sub = $task->subtask ;

        if ($task_sub) {


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
          // dd($task_sub_sums);
        } else {
            // จัดการเมื่อ $task_sub เป็น null
           // $task_sub = null;
            // เพิ่มโค้ดเพิ่มเติมหากต้องการ...
        }
    } else {
        // จัดการเมื่อ $task เป็น null
        // ตัวอย่างเช่น นำไป redirect ไปยังหน้าแสดงข้อผิดพลาดหรือคืนค่า response ข้อผิดพลาด
        // คุณสามารถปรับแต่งตามความต้องการของแอปพลิเคชันได้
    }
        // dd($tasks);
        //dd($task_sub_sums);
       $task_sub_refund = $task->subtask->where('task_refund_pa_status', 2);
       //    dd($task_sub_refund);




           $task_sub_refund_pa_budget = $task_sub_refund->reduce(function ($carry, $subtask) {
            if ($subtask->task_budget_it_operating > 1) {
                $carry['operating']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;
            }

            if ($subtask->task_budget_it_investment > 1) {
                $carry['investment']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;

            }

            if ($subtask->task_budget_gov_utility > 1) {

                $carry['utility']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;

                // Add other fields as necessary...
            }

            return $carry;
        }, ['operating' => ['task_refund_pa_budget' => 0],
            'investment' => [ 'task_refund_pa_budget' => 0],
            'utility' => ['task_refund_pa_budget' => 0]]);


           // dd($task_sub_refund_pa_budget);

           $tasksDetails = $task;


        return view('app.projects.tasks.createto', compact('request',
        'tasksDetails',
        'task_sub_sums',
        'task_sub_refund_pa_budget',
        'contracts', 'project', 'tasks', 'task',
        'task_budget_it_operating', 'task_budget_it_investment', 'task_budget_gov_utility'));
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
        $sum_task_budget_it_investment = $tasks->whereNull('task_parent')->whereNotNull('tasks.deleted_at')->sum('task_budget_it_investment');
        ($sum_task_cost_it_investment= $tasks->where('task_parent')->whereNotNull('tasks.deleted_at')->sum('task_cost_it_investment'));


        ($sum_task_refund_budget_it_investment= $tasks->where('task_parent')->sum('task_refund_pa_budget'));

        // Sum the task_budget_gov_utility for all tasks
        ($sum_task_budget_gov_utility = $tasks->whereNull('task_parent')->whereNotNull('tasks.deleted_at')->sum('task_budget_gov_utility'));
        ($sum_task_cost_gov_utility= $tasks->where('task_parent')->whereNotNull('tasks.deleted_at')->sum('task_cost_gov_utility'));
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


        ($task_sub = $task->subtask);
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
          //วใ dd($task_sub_sums);

          $task_sub_refund = $task->subtask->where('task_refund_pa_status', 2);
          //    dd($task_sub_refund);




              $task_sub_refund_pa_budget = $task_sub_refund->reduce(function ($carry, $subtask) {
               if ($subtask->task_budget_it_operating > 1) {
                   $carry['operating']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;
               }

               if ($subtask->task_budget_it_investment > 1) {
                   $carry['investment']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;

               }

               if ($subtask->task_budget_gov_utility > 1) {

                   $carry['utility']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;

                   // Add other fields as necessary...
               }

               return $carry;
           }, ['operating' => ['task_refund_pa_budget' => 0],
               'investment' => [ 'task_refund_pa_budget' => 0],
               'utility' => ['task_refund_pa_budget' => 0]]);


              // dd($task_sub_refund_pa_budget);
        $tasksDetails = $task;
        //  dd($contracts);
        return view('app.projects.tasks.createsub', compact(
            'task_sub_refund_pa_budget',
            'task_sub_sums',
            'request',
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


        $sum_task_budget_it_operating = $tasks->whereNull('task_parent')->sum('task_budget_it_operating');
        $sum_task_refund_budget_it_operating= $tasks->whereNull('task_parent')->where('task_budget_it_operating', '>', 1)->where('task_refund_pa_status', '=', 3)->sum('task_refund_pa_budget');


        // Sum the task_budget_it_investment for all tasks
        $sum_task_budget_it_investment = $tasks->whereNull('task_parent')->sum('task_budget_it_investment');
        $sum_task_refund_budget_it_investment= $tasks->whereNull('task_parent') ->where('task_budget_it_investment', '>', 1)->where('task_refund_pa_status', '=', 3)->sum('task_refund_pa_budget');

        // Sum the task_budget_gov_utility for all tasks
        $sum_task_budget_gov_utility = $tasks->whereNull('task_parent')->sum('task_budget_gov_utility');
        $sum_task_refund_budget_gov_utility= $tasks->whereNull('task_parent')->where('task_budget_gov_utility', '>', 1)->where('task_refund_pa_status', '=', 3)->sum('task_refund_pa_budget');

        //dd( $sum_task_refund_budgt_operating,$sum_task_refund_budget_it_investment,$sum_task_refund_budget_gov_utility);

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



    if ($task) {
        $task_sub = $task->subtask ;

    if ($task_sub) {


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
      // dd($task_sub_sums);
    } else {
        // จัดการเมื่อ $task_sub เป็น null
        $task_sub = null;
        // เพิ่มโค้ดเพิ่มเติมหากต้องการ...
    }
} else {
    // จัดการเมื่อ $task เป็น null
    // ตัวอย่างเช่น นำไป redirect ไปยังหน้าแสดงข้อผิดพลาดหรือคืนค่า response ข้อผิดพลาด
    // คุณสามารถปรับแต่งตามความต้องการของแอปพลิเคชันได้
}
        // dd($projectData);

       // $task_sub_refund = $task->subtask->where('task_refund_pa_status', 2);
       //    dd($task_sub_refund);




        /*    $task_sub_refund_pa_budget = $task_sub_refund->reduce(function ($carry, $subtask) {
            if ($subtask->task_budget_it_operating > 1) {
                $carry['operating']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;
            }

            if ($subtask->task_budget_it_investment > 1) {
                $carry['investment']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;

            }

            if ($subtask->task_budget_gov_utility > 1) {

                $carry['utility']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;

                // Add other fields as necessary...
            }

            return $carry;
        }, ['operating' => ['task_refund_pa_budget' => 0],
            'investment' => [ 'task_refund_pa_budget' => 0],
            'utility' => ['task_refund_pa_budget' => 0]]);
 */

           // dd($task_sub_refund_pa_budget);

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


        ($task_sub = $task->subtask);
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
          //วใ dd($task_sub_sums);


        $tasksDetails = $task;


        $task_sub_refund = $task->subtask->where('task_refund_pa_status', 2);
       //    dd($task_sub_refund);




           $task_sub_refund_pa_budget = $task_sub_refund->reduce(function ($carry, $subtask) {
            if ($subtask->task_budget_it_operating > 1) {
                $carry['operating']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;
            }

            if ($subtask->task_budget_it_investment > 1) {
                $carry['investment']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;

            }

            if ($subtask->task_budget_gov_utility > 1) {

                $carry['utility']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;

                // Add other fields as necessary...
            }

            return $carry;
        }, ['operating' => ['task_refund_pa_budget' => 0],
            'investment' => [ 'task_refund_pa_budget' => 0],
            'utility' => ['task_refund_pa_budget' => 0]]);


           // dd($task_sub_refund_pa_budget);


  // dd( $tasksDetails ,$projectDetails,$projectyear ,$contracts,$tasks,$task);
        return view('app.projects.tasks.createsubnop', compact(
            'task_sub_refund_pa_budget',
            'request',
            'task_sub_sums',
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
        $task_budget_it_operating = $request->input('task_budget_it_operating') !== null ? (float) str_replace(',', '', $request->input('task_budget_it_operating')) : null;
        $task_budget_gov_utility = $request->input('task_budget_gov_utility') !== null ? (float) str_replace(',', '', $request->input('task_budget_gov_utility')) : null;
        $task_budget_it_investment = $request->input('task_budget_it_investment') !== null ? (float) str_replace(',', '', $request->input('task_budget_it_investment')) : null;

        $task_cost_it_operating = $request->input('task_cost_it_operating') !== null ? (float) str_replace(',', '', $request->input('task_cost_it_operating')) : null;
        $task_cost_gov_utility = $request->input('task_cost_gov_utility') !== null ? (float) str_replace(',', '', $request->input('task_cost_gov_utility')) : null;
        $task_cost_it_investment = $request->input('task_cost_it_investment') !== null ? (float) str_replace(',', '', $request->input('task_cost_it_investment')) : null;
        $task_refund_pa_budget = $request->input('task_refund_pa_budget') !== null ? (float) str_replace(',', '', $request->input('task_refund_pa_budget')) : null;

        $task_pay = $request->input('task_pay') !== null ? (float) str_replace(',', '', $request->input('task_pay')) : null;
        $taskcon_pay = $request->input('taskcon_pay') !== null ? (float) str_replace(',', '', $request->input('taskcon_pay')) : null;
        $task_mm_budget = $request->input('task_mm_budget') !== null ? (float) str_replace(',', '', $request->input('task_mm_budget')) : null;
        $taskcon_pay = $request->input('taskcon_pay') !== null ? (float) str_replace(',', '', $request->input('taskcon_pay')) : null;

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
       // $task->task_name = $request->input('taskcon_mm_name');
        $task->task_mm = $request->input('taskcon_mm');

        $task->task_mm_name = $request->input('taskcon_mm_name');

        $task->task_name = $request->input('taskcon_mm_name');
        $task->task_description = trim($request->input('task_description'));

        $task->task_parent = $request->input('task_parent') ?? null;
        $task->task_parent_sub = $request->input('task_parent_sub') ?? null;

        $task->task_budget_gov_utility = $task_budget_gov_utility;
        $task->task_budget_it_operating = $task_budget_it_operating;
        $task->task_budget_it_investment = $task_budget_it_investment;

        $task->task_cost_gov_utility = $task_cost_gov_utility;
        $task->task_cost_it_operating = $task_cost_it_operating;
        $task->task_cost_it_investment = $task_cost_it_investment;

        $task->task_pay = $task_pay;

        $task->task_mm_budget = $task_mm_budget;

        $task->task_refund_pa_budget = $task_refund_pa_budget;

        $task->task_refund_pa_status = $request->input('task_refund_pa_status');


        $task->task_parent_sub_refund_pa_status = $request->input('task_refund_pa_status') ?? null;
        $task->task_parent_sub_budget = $task_budget_gov_utility+$task_budget_it_operating+$task_budget_it_investment ?? null;
        $task->task_parent_sub_cost = $task_cost_gov_utility+$task_cost_it_operating+$task_cost_it_investment?? null;
        $task->task_parent_sub_refund_budget = $task_refund_pa_budget ?? null;
        $task->task_type = $request->input('task_type');
        // dd($task);
        if ($task->save()) {
            //insert contract
         /*    if( $task->task_parent_sub= 2){


        $task->task_parent_sub_refund_pa_status = $request->input('task_refund_pa_status') ?? null;
        $task->task_parent_sub_budget = $task_budget_gov_utility+$task_budget_it_operating+$task_budget_it_investment ?? null;
        $task->task_parent_sub_cost = $task_cost_gov_utility+$task_cost_it_operating+$task_cost_it_investment?? null;
        $task->task_parent_sub_refund_budget = $task_refund_pa_budget ?? null;
        $task->save();

            } */

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
            $task_parent_sub = Task::where('task_id', $task->task_parent)->first();




            if ($task_parent_sub !== null) {
                $totol_task_cost = $task_cost_gov_utility + $task_cost_it_operating + $task_cost_it_investment ?? null;

                $task_parent_sub->task_parent_sub_cost = $task_parent_sub->task_parent_sub_cost + $totol_task_cost;
                $task_parent_sub->task_parent_sub_refund_budget = $task_parent_sub->task_parent_sub_refund_budget + $task_refund_pa_budget ?? null;
                $task_parent_sub->task_parent_sub_pay = $task_parent_sub->task_parent_sub_pay + $task_pay;
                $task_parent_sub->save();

                $task_parent_st = Task::where('task_id', $task_parent_sub->task_parent)->first();



                if ($task_parent_st !== null) {
                    $task_parent_st->task_parent_sub_cost = $task_parent_st->task_parent_sub_cost + $totol_task_cost;
                    $task_parent_st->task_parent_sub_pay = $task_parent_st->task_parent_sub_pay + $task_pay;
                    $task_parent_st->task_parent_sub_refund_budget = $task_refund_pa_budget;
                    $task_parent_st->save();
                }
            }







              //dd($task);
             // return redirect()->route('project.index');
             return redirect()->route('project.view', $project);
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
        $pay_date_obj = date_create_from_format('d/m/Y', $request->input('task_pay_date'));

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
        $task_po_budget = str_replace(',', '', $request->input('task_po_budget'));

        $task_er_budget = str_replace(',', '', $request->input('task_er_budget'));

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

        if ($task_po_budget === '') {
            $task_po_budget = null; // or '0'
        }
        if ($task_er_budget === '') {
            $task_er_budget = null; // or '0'
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



        if ($pay_date_obj === false) {
            // Handle date conversion error
            // You can either return an error message or use a default date
        } else {

            $pay_date_obj->modify('-543 years');

            $pay_date = date_format($pay_date_obj, 'Y-m-d');

            // Check if $pay_date_obj is not null before trying to modify and format it

        }



        $task->project_id = $id;
        $task->task_name = $request->input('taskcon_mm_name');
        $task->task_description = trim($request->input('task_description'));
        $task->task_status = $request->input('task_status');

        $task->task_parent = $request->input('task_parent') ?? null;
        $task->task_start_date  = $start_date ?? date('Y-m-d 00:00:00');
        $task->task_end_date    = $end_date ?? date('Y-m-d 00:00:00');

        $task->task_pay_date    = $pay_date ?? date('Y-m-d 00:00:00');

        $task->task_budget_it_operating = $task_budget_it_operating;
        $task->task_budget_it_investment = $task_budget_it_investment;
        $task->task_budget_gov_utility = $task_budget_gov_utility;

        $task->task_cost_it_operating = $task_cost_it_operating;
        $task->task_cost_it_investment = $task_cost_it_investment;
        $task->task_cost_gov_utility = $task_cost_gov_utility;

        $task->task_refund_pa_budget = $task_refund_pa_budget;
        $task->task_mm_budget                 =  $task_budget_gov_utility + $task_budget_it_operating + $task_budget_it_investment;
        $task->task_mm_name        = $request->input('taskcon_mm_name');
        $task->task_mm        = $request->input('taskcon_mm');
        //$task->task_cost_disbursement =  $taskcon_bd_budget +$taskcon_ba_budget  ;
        $task->task_pay = $task_pay;
        // $task->taskcon_pp_name        = $request->input('taskcon_pp_name');
        // $task->taskcon_pp        = $request->input('taskcon_pp');
        $task->task_type = $request->input('task_type');
        //


        $task->task_po_name = $request->input('task_po_name');
        $task->task_er_name = $request->input('task_er_name');


        $task->task_po_budget = $task_po_budget;
        $task->task_er_budget = $task_er_budget;
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
        if ($task_po_budget === '') {
            $task_po_budget = null; // or '0'
        }
        if ($task_er_budget === '') {
            $task_er_budget = null; // or '0'
        }





        //convert date
        //   $start_date = date_format(date_create_from_format('d/m/Y', $request->input('taskcon_start_date')), 'Y-m-d');
        // $end_date   = date_format(date_create_from_format('d/m/Y', $request->input('taskcon_end_date')), 'Y-m-d');
        // $taskcon->taskcon_name        = $request->input('task_name');



      //  $taskcon->taskcon_po_budget = $task_po_budget;
//$taskcon->taskcon_er_budget = $task_er_budget;

$taskcon->task_id = $task->task_id; // Use the id of the newly created project
$taskcon->taskcon_name        = $request->input('task_name');
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






  //dd($task_parent_sub) แปล;
      // $task_parent_sub->task_parent_sub_budget = $task_budget_gov_utility+$task_budget_it_operating+$task_budget_it_investment ?? null;
     /*
       if($task_parent_sub->task_parent_sub_cost == null){
        $task_parent_sub->task_parent_sub_cost = $task_cost_gov_utility+$task_cost_it_operating+$task_cost_it_investment?? null;
        $task_parent_sub->task_parent_sub_refund_budget = $task_refund_pa_budget ?? null;

      } else { }







      */














      $task_parent_sub = Task::where('task_id', $task->task_parent)->first();

      if ($task_parent_sub !== null) {
      $totol_task_cost = $task_cost_gov_utility+$task_cost_it_operating+$task_cost_it_investment?? null;



      $task_parent_sub->task_parent_sub_cost = $task_parent_sub['task_parent_sub_cost'] + $totol_task_cost;


      $task_parent_sub->task_parent_sub_refund_budget = $task_parent_sub['task_parent_sub_refund_budget'] +$task_refund_pa_budget ?? null;

      $task_parent_sub->task_parent_sub_pay = $task_parent_sub['task_parent_sub_pay'] + $task_pay;

      $task_parent_sub->save();


      $task_parent_st = Task::where('task_id', $task_parent_sub->task_parent)->first();

      if ($task_parent_st !== null) {
          $task_parent_st->task_parent_sub_cost = $task_parent_st['task_parent_sub_cost'] +$totol_task_cost;
          $task_parent_st->task_parent_sub_pay = $task_parent_st['task_parent_sub_pay'] +$task_pay;
          $task_parent_st->task_parent_sub_refund_budget = $task_refund_pa_budget;
          $task_parent_st->save();
      }
    }



    // dd($task,$task_parent_sub, $task_parent_st);








    if ($task) {
        if (!$task->save()) {
            return redirect()->back()->withErrors('An error occurred while saving the project. Please try again.');
        }
    } else {
        return redirect()->back()->withErrors('Task object is null.');
    }

    if ($taskcon) {
        if (!$taskcon->save()) {
            return redirect()->back()->withErrors('An error occurred while saving the task. Please try again.');
        }
    } else {
        return redirect()->back()->withErrors('Taskcon object is null.');
    }

    if ($task_parent_sub) {
        if (!$task_parent_sub->save()) {
            return redirect()->back()->withErrors('An error occurred while saving the task parent sub. Please try again.');
        }
    } else {
        return redirect()->route('project.view', $project);
    }

    return redirect()->route('project.view', $project);

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

        $task_po_budget = str_replace(',', '', $request->input('task_po_budget'));

        $task_er_budget = str_replace(',', '', $request->input('task_er_budget'));




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

        if ($task_po_budget === '') {
            $task_po_budget = null; // or '0'
        }
        if ($task_er_budget === '') {
            $task_er_budget = null; // or '0'
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

        $task->task_po_name = $request->input('task_po_name');
        $task->task_er_name = $request->input('task_er_name');


        $task->task_po_budget = $task_po_budget;
        $task->task_er_budget = $task_er_budget;

        $task->task_refund_pa_budget = $task_refund_pa_budget;
        $task->task_pay = $task_pay;
        // $task->task_cost_disbursement =  $taskcon_bd_budget + $taskcon_ba_budget;

        $task->task_type = $request->input('task_type');

       //  dd($task);
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


        $taskcon->taskcon_po_name = $request->input('task_po_name');
        $taskcon->taskcon_er_name = $request->input('task_er_name');
        $taskcon->taskcon_po_budget = $task_po_budget;
        $taskcon->taskcon_er_budget = $task_er_budget;


        $taskcon->taskcon_name        = $request->input('task_name');
        $taskcon->taskcon_mm_name        = $request->input('task_name');
        $taskcon->taskcon_mm        = $request->input('taskcon_mm');
        $taskcon->taskcon_ba        = $request->input('taskcon_ba');
        $taskcon->taskcon_bd       = $request->input('taskcon_bd');

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

         // Sum the task_budget_it_operating for all tasks               ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')

         $sum_task_budget_it_operating = $tasks->whereNull('task_parent')->where('tasks.deleted_at', NULL) ->sum('task_budget_it_operating');
         $sum_task_refund_budget_it_operating= $tasks->whereNull('task_parent')->where('tasks.deleted_at', NULL) ->where('task_budget_it_operating', '>', 1)->sum('task_refund_pa_budget');

         // Sum the task_budget_it_investment for all tasks
         $sum_task_budget_it_investment = $tasks->whereNull('task_parent')->where('tasks.deleted_at', NULL) ->sum('task_budget_it_investment');
         $sum_task_refund_budget_it_investment= $tasks->whereNull('task_parent')->where('tasks.deleted_at', NULL)  ->where('task_budget_it_investment', '>', 1)->sum('task_refund_pa_budget');

         // Sum the task_budget_gov_utility for all tasks
         $sum_task_budget_gov_utility = $tasks->whereNull('task_parent')->where('tasks.deleted_at', NULL) ->sum('task_budget_gov_utility');
         $sum_task_refund_budget_gov_utility= $tasks->whereNull('task_parent')->where('tasks.deleted_at', NULL) ->where('task_budget_gov_utility', '>', 1)->sum('task_refund_pa_budget');

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
            ->whereNull('tasks.deleted_at')
            ->get();

        ($contracts = contract::orderBy('contract_fiscal_year', 'desc')->get());
        ($contract = $contracts->toJson()); // Convert the collection to JSON
        //  $contract = $contracts->first();


        $contract_s = Contract::join('contract_has_tasks', 'contracts.contract_id', '=', 'contract_has_tasks.contract_id')
        ->join('tasks', 'contract_has_tasks.task_id', '=', 'tasks.task_id')
        ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
        ->select('contracts.*', 'projects.*', 'tasks.*')




        ->where('projects.project_id', $project->project_id)
        ->where('tasks.task_id', $task->task_id)
        ->whereNull('tasks.deleted_at')
        ->first();

       // dd($contract_s);


        $task_budget_it_operating = Task::where('project_id', $id_project)->whereNull('tasks.deleted_at')->where('task_id', '!=', $id_task)->sum('task_budget_it_operating');
        $task_budget_it_investment = Task::where('project_id', $id_project)->whereNull('tasks.deleted_at')->where('task_id', '!=', $id_task)->sum('task_budget_it_investment');
        $task_budget_gov_utility = Task::where('project_id', $id_project)->whereNull('tasks.deleted_at')->where('task_id', '!=', $id_task)->sum('task_budget_gov_utility');


        if ($task !== null) {
        ($task_sub = $task->subtask);
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

        } else {
            // handle error
        }

        $task_parent_sub = Task::where('task_id', $task->task_parent)->first();

        if ($task_parent_sub !== null) {
        $task_parent_sub = Task::where('task_id', $task->task_parent)->first();
        $task_parent_st = Task::where('task_id', $task_parent_sub->task_parent)->first();
        ($task_sub = $task_parent_sub->subtask->whereNull('tasks.deleted_at'));
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
         // dd($task_sub_sums);
        } else {
            // handle error
        }
         $task_sub_refund = $task->subtask->where('task_refund_pa_status', 2);
         $task_sub_refund_pa_budget = $task_sub_refund->reduce(function ($carry, $subtask) {
            if ($subtask->task_budget_it_operating > 1) {
                $carry['operating']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;
            }

            if ($subtask->task_budget_it_investment > 1) {
                $carry['investment']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;

            }

            if ($subtask->task_budget_gov_utility > 1) {

                $carry['utility']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;

                // Add other fields as necessary...
            }

            return $carry;
        }, ['operating' => ['task_refund_pa_budget' => 0],
            'investment' => [ 'task_refund_pa_budget' => 0],
            'utility' => ['task_refund_pa_budget' => 0]]);



            // dd($task_sub_refund_pa_budget);

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
          $tasksDetails = $task;



      // dd($tasksDetails,$task_sub_sums,$task_parent_sub,$task_parent_st);

         //dd($tasksDetails);

        return view('app.projects.tasks.editsub', compact(
            'task_parent_sub',
            'task_sub_refund_pa_budget',
            'tasksDetails',
            'task_sub_sums',
            'contract_s',
            'contracts', 'project', 'task', 'tasks', 'contract', 'task_budget_it_operating', 'task_budget_it_investment', 'task_budget_gov_utility'));
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


       /*  $task = Task::join('taskcons', 'tasks.task_id', '=', 'taskcons.task_id')
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
            ->first(); */

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



      ($task_sub = $task->subtask);
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
        //วใ dd($task_sub_sums);

        $tasksDetails = $task;
        //dd($tasks);



        return view('app.projects.tasks.editsubno', compact(
            'task_sub_sums','tasksDetails',

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


                            $task->task_refund_pa_status = $request->input('task_refund_pa_status');

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
                          // dd($task);


                            if ($task->save()) {
                                // Update contract
                                if ($request->input('task_contract')) {
                                    ContractHasTask::where('task_id', $id_task)->delete();
                                    ContractHasTask::create([
                                        'contract_id' => $request->input('task_contract'),
                                        'task_id' => $id_task,
                                    ]);
                                } else {

                                }

                    // Assign the project_id to the Taskcon
                    $taskcon = Taskcon::where('task_id', $task->task_id)->first();
                    if ($taskcon === null) {
                        // Handle the error, e.g., create a new Taskcon, show an error message, etc.
                        // For example, to create a new Taskcon:
                        //$taskcon = new Taskcon;
                        //$taskcon->task_id = $task->task_id;
                        // Set other properties of $taskcon as needed
                            // หลังจากปรับปรุงข้อมูลเสร็จแล้ว ให้ใช้ back() เพื่อกลับหน้าเดิม
                            //return redirect()->route('project.task.view',['project' => $project->hashid, 'task' => $task->hashid]);
                        return redirect()->route('project.view', $project->hashid);
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




                   // $task_parent_sub = Task::where('task_id', $task->task_parent)->first();





                    $task_parent_sub = Task::where('task_id', $task->task_parent)->first();




                    if ($task_parent_sub !== null) {
                        $totol_task_cost = $task_cost_gov_utility + $task_cost_it_operating + $task_cost_it_investment ?? null;

                        if ($task->task_parent_sub_cost > 1) {
                            $task_parent_sub->task_parent_sub_pay = $task_parent_sub->task_parent_sub_pay + $task_pay;

                            ($task_parent_sub);
                            $task_parent_sub->save();


                        } elseif ($task->task_parent_sub_cost !== null) {
                            $task_parent_sub->task_parent_sub_pay = $task_parent_sub->task_parent_sub_pay + $task_pay;
                           // $task_parent_sub->task_parent_sub_cost = $task_parent_sub->task_parent_sub_cost + $totol_task_cost;
                            //dd($task_parent_sub);
                            $task_parent_sub->save();
                        } else {


                            $task_parent_st = Task::where('task_id', $task_parent_sub->task_parent)->first();

                            if ($task_parent_st !== null) {
                              //  $task_parent_st->task_parent_sub_cost = $task_parent_st->task_parent_sub_cost + $totol_task_cost;
                                $task_parent_st->task_parent_sub_pay = $task_parent_st->task_parent_sub_pay + $task_pay;
                                $task_parent_st->save();
                            }
                        }

                    }









                    if (!$taskcon) {
                        return redirect()->back()->withErrors('Taskcon not found.');
                    }





                    if (!$taskcon->save()) {
                        // If the Taskcon failed to save, redirect back with an error message
                        return redirect()->back()->withErrors('An error occurred while saving the task. Please try again.');
                    }


                                //  dd($task);
                                return redirect()->route('project.view', $project->hashid);
                            }

                            // Create a new Taskcon object
                            //  $taskcon = new Taskcon;

                            // Fill the Taskcon fields from the request
                            // replace 'field1', 'field2', 'field3' with the actual fields of Taskcon


                            // If both the Project and Taskcon saved successfully, redirect to project.inde

                            return redirect()->route('project.view', $project->hashid);
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
        return redirect()->route('project.view', $project);
    }

    public function taskRefund($project, $task)
    {
        $id   = Hashids::decode($task)[0];
        $task = Task::find($id);
        if ($task) {
            $task->task_refund_pa_status = '2';
            $task->task_status = '2';

            $task->save();
        }
        return redirect()->route('project.view', $project);

    }

    public function taskRefund_task_parent_null($project, $task)
    {
        $id   = Hashids::decode($task)[0];
        $task = Task::find($id);
        if ($task) {
            $task->task_refund_pa_status = '3';
            $task->task_status = '3';

            $task->save();
        }
        return redirect()->route('project.view', $project);

    }

    public function taskRefundcontract_project_type_sub_2($project, $task)
    {
        $id   = Hashids::decode($task)[0];
        $idproject   = Hashids::decode($project)[0];

        $task = Task::find($id);
        $idproject = project::find($idproject);


        $task->task_refund_pa_status = '2';

        if ($task->contract) {
            foreach ($task->contract as $contract) {
                $contract->contract_refund_pa_status = '2';
                $contract->save();
            }
        }
        $task->save();
        return redirect()->route('project.view', $project);

    }
    public function taskRefundcontract_project_type_2($project, $task)
    {
        $taskId = Hashids::decode($task)[0];
        $task = Task::find($taskId);




        if (!$task || !$project) {
            return redirect()->route('error_route');  // Replace 'error_route' with your actual error route
        }

        $task->task_refund_pa_status = '3';

        if ($task->contract) {
            foreach ($task->contract as $contract) {
                $contract->contract_refund_pa_status = '2';
                $contract->save();
            }
        }

        $task->save();

        return redirect()->route('project.view', $project);
    }


    public function taskRefundbudget(Request $request,$project, $task)
    {
        $id   = Hashids::decode($task)[0];

        ($task = Task::find($id));
        ($idproject = Hashids::decode($project)[0]);
        $tasks = DB::table('tasks')
        ->join('taskcons', 'tasks.task_id', '=', 'taskcons.task_id')
        ->select('tasks.*', 'taskcons.*')
         ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
        ->get();

//dd($tasks);

(       $tasks = DB::table('tasks')
            ->select(
                'tasks.*',
                'asum.tt',
                'asum.total_task_mm_budget_task_sum',
                'asum.costs_disbursement_sum',
                'asum.total_task_task_budget',
                'a.total_task_mm_budget_task',
                'a.costs_disbursement',

                'a.total_taskcon_cost',
                'a.total_task_refund_pa_budget',
                'a.total_taskcon_pay',
                'ab.total_task_refund_pa_budget_1',
                'ac.total_task_refund_pa_budget_2',
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
                'ad.total_taskcon_pay_pa_1',
                'astatus_pa.total_task_refund_pa_budget_status',
                'astatus.total_task_refund_no_pa_budget_status'
            )

            ->leftJoin(
                DB::raw('(select tasks.task_parent,

                sum(tasks.task_budget_gov_utility) +
                sum(tasks.task_budget_it_operating) +
                sum(tasks.task_budget_it_investment) as tt,


                sum( COALESCE(tasks.task_mm_budget,0))  as total_task_mm_budget_task_sum,

                sum(COALESCE(tasks.task_budget_gov_utility,0))
                +sum(COALESCE(tasks.task_budget_it_operating,0))
                +sum(COALESCE(tasks.task_budget_it_investment,0)) as total_task_task_budget ,


                sum( COALESCE(tasks.task_cost_gov_utility,0))
        +sum( COALESCE(tasks.task_cost_it_operating,0))
        +sum( COALESCE(tasks.task_cost_it_investment,0))
        as costs_disbursement_sum


        from tasks


                    where tasks.deleted_at IS NULL

        group by tasks.task_parent) as asum'),
                'asum.task_parent',
                '=',
                'tasks.task_id'
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


        sum( COALESCE(tasks.task_pay,0))  as total_pay,

        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget


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
            where tasks.deleted_at IS NULL

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
        sum( COALESCE(tasks.task_pay,0)) as total_pay_1,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget_1

        from tasks
        where tasks.task_type=1   AND tasks.deleted_at IS NULL group by tasks.task_parent) as ab'),
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
        sum( COALESCE(tasks.task_pay,0)) as total_pay_2,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget_2
        from tasks  where tasks.task_type=2   AND tasks.deleted_at IS NULL group by tasks.task_parent) as ac'),
                'ac.task_parent',
                '=',
                'tasks.task_id'
            )

            ->leftJoin(
                DB::raw('(select tasks.task_parent,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget_status
        from tasks  where tasks.task_type=1  AND  tasks.task_refund_pa_status=2   AND tasks.deleted_at IS NULL group by tasks.task_parent) as astatus_pa'),
                'astatus_pa.task_parent',
                '=',
                'tasks.task_id'
            )


            ->leftJoin(
                DB::raw('(select tasks.task_parent,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_no_pa_budget_status
        from tasks  where tasks.task_type=2  AND  tasks.task_refund_pa_status=2   AND tasks.deleted_at IS NULL group by tasks.task_parent) as astatus'),
                'astatus.task_parent',
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
                where tasks.task_type=1  AND tasks.deleted_at IS NULL  group by tasks.task_id) as ad'),
                'ad.task_id',
                '=',
                'tasks.task_id'
            )




            ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')

            ->where('project_id', ($idproject))

            ->get()
            ->toArray());
      // dd($tasks);





      // ค้นหาข้อมูลงานที่ตรงกับ ID ที่คุณต้องการ
      $tasksum = collect($tasks)->firstWhere('task_id', $id);

     // dd($tasksum);

     ($task_sub = $task->subtask);
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
       //วใ dd($task_sub_sums);

       $task_sub_refund = $task->subtask->where('task_refund_pa_status', 2);
       //    dd($task_sub_refund);




           $task_sub_refund_pa_budget = $task_sub_refund->reduce(function ($carry, $subtask) {
            if ($subtask->task_budget_it_operating > 1) {
                $carry['operating']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;
            }

            if ($subtask->task_budget_it_investment > 1) {
                $carry['investment']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;

            }

            if ($subtask->task_budget_gov_utility > 1) {

                $carry['utility']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;

                // Add other fields as necessary...
            }

            return $carry;
        }, ['operating' => ['task_refund_pa_budget' => 0],
            'investment' => [ 'task_refund_pa_budget' => 0],
            'utility' => ['task_refund_pa_budget' => 0]]);


            //dd($task_sub_refund_pa_budget);



        if ($task) {

            $task->task_status = '2';
            $task->task_refund_pa_status = '3';

            $task->task_refund_pa_budget =
            (($tasksum->task_budget_it_operating +$tasksum->task_budget_it_investment+ $tasksum->task_budget_gov_utility)
            -
            ($task_sub_sums['operating']['task_mm_budget']+$task_sub_sums['investment']['task_mm_budget'] + ($task_sub_sums['utility']['task_mm_budget'])))
            +
            ($task_sub_sums['operating']['task_refund_pa_budget']+$task_sub_sums['investment']['task_refund_pa_budget'] + ($task_sub_sums['utility']['task_refund_pa_budget']))
            ;

       // dd($task);

            $task->save();
        }

        return redirect()->route('project.view', $project);

    }


    public function taskRefundbudget_str(Request $request,$project, $task)
    {
        $id   = Hashids::decode($task)[0];

        ($task = Task::find($id));
        ($idproject = Hashids::decode($project)[0]);
        $tasks = DB::table('tasks')
        ->join('taskcons', 'tasks.task_id', '=', 'taskcons.task_id')
        ->select('tasks.*', 'taskcons.*')
         ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
        ->get();

//dd($tasks);

(       $tasks = DB::table('tasks')
            ->select(
                'tasks.*',
                'asum.tt',
                'asum.total_task_mm_budget_task_sum',
                'asum.costs_disbursement_sum',
                'asum.total_task_task_budget',
                'a.total_task_mm_budget_task',
                'a.costs_disbursement',

                'a.total_taskcon_cost',
                'a.total_task_refund_pa_budget',
                'a.total_taskcon_pay',
                'ab.total_task_refund_pa_budget_1',
                'ac.total_task_refund_pa_budget_2',
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
                'ad.total_taskcon_pay_pa_1',
                'astatus_pa.total_task_refund_pa_budget_status',
                'astatus.total_task_refund_no_pa_budget_status'
            )

            ->leftJoin(
                DB::raw('(select tasks.task_parent,

                sum(tasks.task_budget_gov_utility) +
                sum(tasks.task_budget_it_operating) +
                sum(tasks.task_budget_it_investment) as tt,


                sum( COALESCE(tasks.task_mm_budget,0))  as total_task_mm_budget_task_sum,

                sum(COALESCE(tasks.task_budget_gov_utility,0))
                +sum(COALESCE(tasks.task_budget_it_operating,0))
                +sum(COALESCE(tasks.task_budget_it_investment,0)) as total_task_task_budget ,


                sum( COALESCE(tasks.task_cost_gov_utility,0))
        +sum( COALESCE(tasks.task_cost_it_operating,0))
        +sum( COALESCE(tasks.task_cost_it_investment,0))
        as costs_disbursement_sum


        from tasks


                    where tasks.deleted_at IS NULL

        group by tasks.task_parent) as asum'),
                'asum.task_parent',
                '=',
                'tasks.task_id'
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


        sum( COALESCE(tasks.task_pay,0))  as total_pay,

        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget


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
            where tasks.deleted_at IS NULL

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
        sum( COALESCE(tasks.task_pay,0)) as total_pay_1,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget_1

        from tasks
        where tasks.task_type=1   AND tasks.deleted_at IS NULL group by tasks.task_parent) as ab'),
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
        sum( COALESCE(tasks.task_pay,0)) as total_pay_2,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget_2
        from tasks  where tasks.task_type=2   AND tasks.deleted_at IS NULL group by tasks.task_parent) as ac'),
                'ac.task_parent',
                '=',
                'tasks.task_id'
            )

            ->leftJoin(
                DB::raw('(select tasks.task_parent,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget_status
        from tasks  where tasks.task_type=1  AND  tasks.task_refund_pa_status=2   AND tasks.deleted_at IS NULL group by tasks.task_parent) as astatus_pa'),
                'astatus_pa.task_parent',
                '=',
                'tasks.task_id'
            )


            ->leftJoin(
                DB::raw('(select tasks.task_parent,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_no_pa_budget_status
        from tasks  where tasks.task_type=2  AND  tasks.task_refund_pa_status=2   AND tasks.deleted_at IS NULL group by tasks.task_parent) as astatus'),
                'astatus.task_parent',
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
                where tasks.task_type=1  AND tasks.deleted_at IS NULL  group by tasks.task_id) as ad'),
                'ad.task_id',
                '=',
                'tasks.task_id'
            )




            ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')

            ->where('project_id', ($idproject))

            ->get()
            ->toArray());
      // dd($tasks);





      // ค้นหาข้อมูลงานที่ตรงกับ ID ที่คุณต้องการ
      $tasksum = collect($tasks)->firstWhere('task_id', $id);

     // dd($tasksum);

     ($task_sub = $task->subtask);
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
       // dd($task_sub_sums);

       $task_sub_refund = $task->subtask->where('task_refund_pa_status', 2);
       //    dd($task_sub_refund);




           $task_sub_refund_pa_budget = $task_sub_refund->reduce(function ($carry, $subtask) {
            if ($subtask->task_budget_it_operating > 1) {
                $carry['operating']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;
            }

            if ($subtask->task_budget_it_investment > 1) {
                $carry['investment']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;

            }

            if ($subtask->task_budget_gov_utility > 1) {

                $carry['utility']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;

                // Add other fields as necessary...
            }

            return $carry;
        }, ['operating' => ['task_refund_pa_budget' => 0],
            'investment' => [ 'task_refund_pa_budget' => 0],
            'utility' => ['task_refund_pa_budget' => 0]]);


          //  dd($task_sub_refund_pa_budget);

//taskRefundbudget_str
            $task_parent_sub = Task::where('task_id', $task->task_parent)->first();
                //$task_parent_st = Task::where('task_id', $task_parent_sub->task_parent)->first();
                //dd($task_parent_sub);
                if ($task_parent_sub) {
                    $task_parent_sub->task_task_parent_sub_refund_budget == 2;
                    $task_parent_sub->task_refund_pa_budget =
                     $task_sub_refund_pa_budget['operating']['task_refund_pa_budget']
                    +$task_sub_refund_pa_budget['investment']['task_refund_pa_budget']+$task_sub_refund_pa_budget['utility']['task_refund_pa_budget']
                    ;
               // dd($task_parent_sub);
               // $task_parent_sub->save();
            }
            if ($task) {

                $task->task_status = '2';
                $task->task_refund_pa_status = '3';

                $task->task_refund_pa_budget =

                ($tasksum->task_budget_it_operating +$tasksum->task_budget_it_investment+ $tasksum->task_budget_gov_utility)
                -
                ($task_sub_sums['operating']['task_mm_budget']+$task_sub_sums['investment']['task_mm_budget']
                + ($task_sub_sums['utility']['task_mm_budget']))
                +
                ($task_sub_sums['operating']['task_refund_pa_budget']+$task_sub_sums['investment']['task_refund_pa_budget'] + ($task_sub_sums['utility']['task_refund_pa_budget']))
                ;


       // dd($task,$task_parent_sub);

            $task->save();
        }

        return redirect()->route('project.view', $project);

    }

    public function taskRefundbudget_str_root(Request $request,$project, $task)
    {
        $id   = Hashids::decode($task)[0];

        ($task = Task::find($id));
        ($idproject = Hashids::decode($project)[0]);
        $tasks = DB::table('tasks')
        ->join('taskcons', 'tasks.task_id', '=', 'taskcons.task_id')
        ->select('tasks.*', 'taskcons.*')
         ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
        ->get();

//dd($tasks);

(       $tasks = DB::table('tasks')
            ->select(
                'tasks.*',
                'asum.tt',
                'asum.total_task_mm_budget_task_sum',
                'asum.costs_disbursement_sum',
                'asum.total_task_task_budget',
                'a.total_task_mm_budget_task',
                'a.costs_disbursement',

                'a.total_taskcon_cost',
                'a.total_task_refund_pa_budget',
                'a.total_taskcon_pay',
                'ab.total_task_refund_pa_budget_1',
                'ac.total_task_refund_pa_budget_2',
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
                'ad.total_taskcon_pay_pa_1',
                'astatus_pa.total_task_refund_pa_budget_status',
                'astatus.total_task_refund_no_pa_budget_status'
            )

            ->leftJoin(
                DB::raw('(select tasks.task_parent,

                sum(tasks.task_budget_gov_utility) +
                sum(tasks.task_budget_it_operating) +
                sum(tasks.task_budget_it_investment) as tt,


                sum( COALESCE(tasks.task_mm_budget,0))  as total_task_mm_budget_task_sum,

                sum(COALESCE(tasks.task_budget_gov_utility,0))
                +sum(COALESCE(tasks.task_budget_it_operating,0))
                +sum(COALESCE(tasks.task_budget_it_investment,0)) as total_task_task_budget ,


                sum( COALESCE(tasks.task_cost_gov_utility,0))
        +sum( COALESCE(tasks.task_cost_it_operating,0))
        +sum( COALESCE(tasks.task_cost_it_investment,0))
        as costs_disbursement_sum


        from tasks


                    where tasks.deleted_at IS NULL

        group by tasks.task_parent) as asum'),
                'asum.task_parent',
                '=',
                'tasks.task_id'
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


        sum( COALESCE(tasks.task_pay,0))  as total_pay,

        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget


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
            where tasks.deleted_at IS NULL

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
        sum( COALESCE(tasks.task_pay,0)) as total_pay_1,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget_1

        from tasks
        where tasks.task_type=1   AND tasks.deleted_at IS NULL group by tasks.task_parent) as ab'),
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
        sum( COALESCE(tasks.task_pay,0)) as total_pay_2,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget_2
        from tasks  where tasks.task_type=2   AND tasks.deleted_at IS NULL group by tasks.task_parent) as ac'),
                'ac.task_parent',
                '=',
                'tasks.task_id'
            )

            ->leftJoin(
                DB::raw('(select tasks.task_parent,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget_status
        from tasks  where tasks.task_type=1  AND  tasks.task_refund_pa_status=2   AND tasks.deleted_at IS NULL group by tasks.task_parent) as astatus_pa'),
                'astatus_pa.task_parent',
                '=',
                'tasks.task_id'
            )


            ->leftJoin(
                DB::raw('(select tasks.task_parent,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_no_pa_budget_status
        from tasks  where tasks.task_type=2  AND  tasks.task_refund_pa_status=2   AND tasks.deleted_at IS NULL group by tasks.task_parent) as astatus'),
                'astatus.task_parent',
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
                where tasks.task_type=1  AND tasks.deleted_at IS NULL  group by tasks.task_id) as ad'),
                'ad.task_id',
                '=',
                'tasks.task_id'
            )




            ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')

            ->where('project_id', ($idproject))

            ->get()
            ->toArray());
      // dd($tasks);





      // ค้นหาข้อมูลงานที่ตรงกับ ID ที่คุณต้องการ
      $tasksum = collect($tasks)->firstWhere('task_id', $id);

     // dd($tasksum);

     ($task_sub = $task->subtask);
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
       //วใ dd($task_sub_sums);

       $task_sub_refund = $task->subtask->where('task_refund_pa_status', 2);
       //    dd($task_sub_refund);




           $task_sub_refund_pa_budget = $task_sub_refund->reduce(function ($carry, $subtask) {
            if ($subtask->task_budget_it_operating > 1) {
                $carry['operating']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;
            }

            if ($subtask->task_budget_it_investment > 1) {
                $carry['investment']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;

            }

            if ($subtask->task_budget_gov_utility > 1) {

                $carry['utility']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;

                // Add other fields as necessary...
            }

            return $carry;
        }, ['operating' => ['task_refund_pa_budget' => 0],
            'investment' => [ 'task_refund_pa_budget' => 0],
            'utility' => ['task_refund_pa_budget' => 0]]);


            //dd($task_sub_refund_pa_budget);
        //taskRefundbudget_str_root

            $task_parent_sub = Task::where('task_id', $task->task_parent)->first();
                //$task_parent_st = Task::where('task_id', $task_parent_sub->task_parent)->first();
                //dd($task_parent_sub);
                if ($task_parent_sub) {
                    $task_parent_sub->task_parent_sub_refund_pa_status = '2';

                    $task_parent_sub->task_refund_pa_budget =

                    (($tasksum->task_budget_it_operating +$tasksum->task_budget_it_investment+ $tasksum->task_budget_gov_utility)
                    -
                    ($task_sub_sums['operating']['task_mm_budget']+$task_sub_sums['investment']['task_mm_budget'] + ($task_sub_sums['utility']['task_mm_budget'])))
                    +
                    ($task_sub_sums['operating']['task_refund_pa_budget']+$task_sub_sums['investment']['task_refund_pa_budget'] + ($task_sub_sums['utility']['task_refund_pa_budget']))
                    ;
               // dd($task_parent_sub);
                $task_parent_sub->save();
            }
            if ($task) {

                $task->task_status = '2';
                $task->task_refund_pa_status = '2';

                $task->task_refund_pa_budget =
                (($tasksum->task_budget_it_operating +$tasksum->task_budget_it_investment+ $tasksum->task_budget_gov_utility)
                -
                ($task_sub_sums['operating']['task_mm_budget']+$task_sub_sums['investment']['task_mm_budget'] + ($task_sub_sums['utility']['task_mm_budget'])))
                +
                ($task_sub_sums['operating']['task_refund_pa_budget']+$task_sub_sums['investment']['task_refund_pa_budget'] + ($task_sub_sums['utility']['task_refund_pa_budget']))
                ;


        dd($task,$task_parent_sub);

            $task->save();
        }

        return redirect()->route('project.view', $project);

    }

    public function taskRefundbudget_sub(Request $request,$project, $task)
    {
        $id   = Hashids::decode($task)[0];

        ($task = Task::find($id));
        ($idproject = Hashids::decode($project)[0]);
        $tasks = DB::table('tasks')
        ->join('taskcons', 'tasks.task_id', '=', 'taskcons.task_id')
        ->select('tasks.*', 'taskcons.*')
         ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
        ->get();

//dd($tasks);

(       $tasks = DB::table('tasks')
            ->select(
                'tasks.*',
                'asum.tt',
                'asum.total_task_mm_budget_task_sum',
                'asum.costs_disbursement_sum',
                'asum.total_task_task_budget',
                'a.total_task_mm_budget_task',
                'a.costs_disbursement',

                'a.total_taskcon_cost',
                'a.total_task_refund_pa_budget',
                'a.total_taskcon_pay',
                'ab.total_task_refund_pa_budget_1',
                'ac.total_task_refund_pa_budget_2',
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
                'ad.total_taskcon_pay_pa_1',
                'astatus_pa.total_task_refund_pa_budget_status',
                'astatus.total_task_refund_no_pa_budget_status'
            )

            ->leftJoin(
                DB::raw('(select tasks.task_parent,

                sum(tasks.task_budget_gov_utility) +
                sum(tasks.task_budget_it_operating) +
                sum(tasks.task_budget_it_investment) as tt,


                sum( COALESCE(tasks.task_mm_budget,0))  as total_task_mm_budget_task_sum,

                sum(COALESCE(tasks.task_budget_gov_utility,0))
                +sum(COALESCE(tasks.task_budget_it_operating,0))
                +sum(COALESCE(tasks.task_budget_it_investment,0)) as total_task_task_budget ,


                sum( COALESCE(tasks.task_cost_gov_utility,0))
        +sum( COALESCE(tasks.task_cost_it_operating,0))
        +sum( COALESCE(tasks.task_cost_it_investment,0))
        as costs_disbursement_sum


        from tasks


                    where tasks.deleted_at IS NULL

        group by tasks.task_parent) as asum'),
                'asum.task_parent',
                '=',
                'tasks.task_id'
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


        sum( COALESCE(tasks.task_pay,0))  as total_pay,

        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget


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
            where tasks.deleted_at IS NULL

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
        sum( COALESCE(tasks.task_pay,0)) as total_pay_1,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget_1

        from tasks
        where tasks.task_type=1   AND tasks.deleted_at IS NULL group by tasks.task_parent) as ab'),
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
        sum( COALESCE(tasks.task_pay,0)) as total_pay_2,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget_2
        from tasks  where tasks.task_type=2   AND tasks.deleted_at IS NULL group by tasks.task_parent) as ac'),
                'ac.task_parent',
                '=',
                'tasks.task_id'
            )

            ->leftJoin(
                DB::raw('(select tasks.task_parent,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget_status
        from tasks  where tasks.task_type=1  AND  tasks.task_refund_pa_status=2   AND tasks.deleted_at IS NULL group by tasks.task_parent) as astatus_pa'),
                'astatus_pa.task_parent',
                '=',
                'tasks.task_id'
            )


            ->leftJoin(
                DB::raw('(select tasks.task_parent,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_no_pa_budget_status
        from tasks  where tasks.task_type=2  AND  tasks.task_refund_pa_status=2   AND tasks.deleted_at IS NULL group by tasks.task_parent) as astatus'),
                'astatus.task_parent',
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
                where tasks.task_type=1  AND tasks.deleted_at IS NULL  group by tasks.task_id) as ad'),
                'ad.task_id',
                '=',
                'tasks.task_id'
            )




            ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')

            ->where('project_id', ($idproject))

            ->get()
            ->toArray());
       //dd($tasks);





      // ค้นหาข้อมูลงานที่ตรงกับ ID ที่คุณต้องการ
      $tasksum = collect($tasks)->firstWhere('task_id', $id);

      //dd($tasksum);
      ($task_sub = $task->subtask);
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
        //วใ dd($task_sub_sums);

        $task_sub_refund = $task->subtask->where('task_refund_pa_status', 2);
        //    dd($task_sub_refund);




            $task_sub_refund_pa_budget = $task_sub_refund->reduce(function ($carry, $subtask) {
             if ($subtask->task_budget_it_operating > 1) {
                 $carry['operating']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;
             }

             if ($subtask->task_budget_it_investment > 1) {
                 $carry['investment']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;

             }

             if ($subtask->task_budget_gov_utility > 1) {

                 $carry['utility']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;

                 // Add other fields as necessary...
             }

             return $carry;
         }, ['operating' => ['task_refund_pa_budget' => 0],
             'investment' => [ 'task_refund_pa_budget' => 0],
             'utility' => ['task_refund_pa_budget' => 0]]);


             //dd($task_sub_refund_pa_budget);

//taskRefundbudget_sub

             if ($task) {

                $task->task_status = '2';
                $task->task_refund_pa_status = '3';

                $task->task_refund_pa_budget =
                (($tasksum->task_budget_it_operating +$tasksum->task_budget_it_investment+ $tasksum->task_budget_gov_utility)
                -
                ($task_sub_sums['operating']['task_mm_budget']+$task_sub_sums['investment']['task_mm_budget'] + ($task_sub_sums['utility']['task_mm_budget'])))
                +
                ($task_sub_sums['operating']['task_refund_pa_budget']+$task_sub_sums['investment']['task_refund_pa_budget'] + ($task_sub_sums['utility']['task_refund_pa_budget']))
                ;


         // dd($task);
          $task->save();
        }



        return redirect()->route('project.view', $project);

    }




    public function taskRefundbudget_sub_st(Request $request,$project, $task)
    {
        $id   = Hashids::decode($task)[0];

        ($task = Task::find($id));
        ($idproject = Hashids::decode($project)[0]);
        $tasks = DB::table('tasks')
        ->join('taskcons', 'tasks.task_id', '=', 'taskcons.task_id')
        ->select('tasks.*', 'taskcons.*')
         ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
 // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')
        ->get();

//dd($tasks);

(       $tasks = DB::table('tasks')
            ->select(
                'tasks.*',
                'asum.tt',
                'asum.total_task_mm_budget_task_sum',
                'asum.costs_disbursement_sum',
                'asum.total_task_task_budget',
                'a.total_task_mm_budget_task',
                'a.costs_disbursement',

                'a.total_taskcon_cost',
                'a.total_task_refund_pa_budget',
                'a.total_taskcon_pay',
                'ab.total_task_refund_pa_budget_1',
                'ac.total_task_refund_pa_budget_2',
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
                'ad.total_taskcon_pay_pa_1',
                'astatus_pa.total_task_refund_pa_budget_status',
                'astatus.total_task_refund_no_pa_budget_status'
            )

            ->leftJoin(
                DB::raw('(select tasks.task_parent,

                sum(tasks.task_budget_gov_utility) +
                sum(tasks.task_budget_it_operating) +
                sum(tasks.task_budget_it_investment) as tt,


                sum( COALESCE(tasks.task_mm_budget,0))  as total_task_mm_budget_task_sum,

                sum(COALESCE(tasks.task_budget_gov_utility,0))
                +sum(COALESCE(tasks.task_budget_it_operating,0))
                +sum(COALESCE(tasks.task_budget_it_investment,0)) as total_task_task_budget ,


                sum( COALESCE(tasks.task_cost_gov_utility,0))
        +sum( COALESCE(tasks.task_cost_it_operating,0))
        +sum( COALESCE(tasks.task_cost_it_investment,0))
        as costs_disbursement_sum


        from tasks


                    where tasks.deleted_at IS NULL

        group by tasks.task_parent) as asum'),
                'asum.task_parent',
                '=',
                'tasks.task_id'
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


        sum( COALESCE(tasks.task_pay,0))  as total_pay,

        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget


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
            where tasks.deleted_at IS NULL

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
        sum( COALESCE(tasks.task_pay,0)) as total_pay_1,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget_1

        from tasks
        where tasks.task_type=1   AND tasks.deleted_at IS NULL group by tasks.task_parent) as ab'),
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
        sum( COALESCE(tasks.task_pay,0)) as total_pay_2,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget_2
        from tasks  where tasks.task_type=2   AND tasks.deleted_at IS NULL group by tasks.task_parent) as ac'),
                'ac.task_parent',
                '=',
                'tasks.task_id'
            )

            ->leftJoin(
                DB::raw('(select tasks.task_parent,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_pa_budget_status
        from tasks  where tasks.task_type=1  AND  tasks.task_refund_pa_status=2   AND tasks.deleted_at IS NULL group by tasks.task_parent) as astatus_pa'),
                'astatus_pa.task_parent',
                '=',
                'tasks.task_id'
            )


            ->leftJoin(
                DB::raw('(select tasks.task_parent,
        sum( COALESCE(tasks.task_refund_pa_budget,0))  as total_task_refund_no_pa_budget_status
        from tasks  where tasks.task_type=2  AND  tasks.task_refund_pa_status=2   AND tasks.deleted_at IS NULL group by tasks.task_parent) as astatus'),
                'astatus.task_parent',
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
                where tasks.task_type=1  AND tasks.deleted_at IS NULL  group by tasks.task_id) as ad'),
                'ad.task_id',
                '=',
                'tasks.task_id'
            )




            ->where('tasks.deleted_at', NULL) // เปลี่ยนจาก where('tasks.deleted_at', notnull) เป็น whereNotNull('tasks.deleted_at')

            ->where('project_id', ($idproject))

            ->get()
            ->toArray());
      // dd($tasks);





      // ค้นหาข้อมูลงานที่ตรงกับ ID ที่คุณต้องการ
      $tasksum = collect($tasks)->firstWhere('task_id', $id);

      //dd($tasksum);

      ($task_sub = $task->subtask);
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
        //วใ dd($task_sub_sums);

        $task_sub_refund = $task->subtask->where('task_refund_pa_status', 2);
        //    dd($task_sub_refund);




            $task_sub_refund_pa_budget = $task_sub_refund->reduce(function ($carry, $subtask) {
             if ($subtask->task_budget_it_operating > 1) {
                 $carry['operating']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;
             }

             if ($subtask->task_budget_it_investment > 1) {
                 $carry['investment']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;

             }

             if ($subtask->task_budget_gov_utility > 1) {

                 $carry['utility']['task_refund_pa_budget'] += $subtask->task_refund_pa_budget;

                 // Add other fields as necessary...
             }

             return $carry;
         }, ['operating' => ['task_refund_pa_budget' => 0],
             'investment' => [ 'task_refund_pa_budget' => 0],
             'utility' => ['task_refund_pa_budget' => 0]]);


             //dd($task_sub_refund_pa_budget)

//taskRefundbudget_sub_st
             if ($task) {

                $task->task_status = '2';
                $task->task_refund_pa_status = '3';

                $task->task_refund_pa_budget =
                (($tasksum->task_budget_it_operating +$tasksum->task_budget_it_investment+ $tasksum->task_budget_gov_utility)
                -
                ($task_sub_sums['operating']['task_mm_budget']+$task_sub_sums['investment']['task_mm_budget'] + ($task_sub_sums['utility']['task_mm_budget'])))
                +
                ($task_sub_sums['operating']['task_refund_pa_budget']+$task_sub_sums['investment']['task_refund_pa_budget'] + ($task_sub_sums['utility']['task_refund_pa_budget']))
                ;

           // $task->task_refund_pa_budget =

         // ($task->task_parent_sub_budget-$task->task_parent_sub_cost);
       //  dd($task);
          $task->save();
        }

        return redirect()->route('project.view', $project);

    }

















    public function taskRefundbudget_4($project, $task)
    {
        $id = Hashids::decode($task)[0];
        $task = Task::find($id);

        if ($task) {
            $subtasks = $task->subtask;

            foreach ($subtasks as $subtask) {

                $subtask->task_status = '2';
                $subtask->task_refund_pa_status = '4';
                $subtask->save();
            }
        }

        return redirect()->route('project.view', $project);
    }

    public function taskRefundDestroy($project, $task)
    {
        $id   = Hashids::decode($task)[0];
        $task = Task::find($id);
        if ($task) {
            $task->task_parent_sub_budget = null;
            $task->task_parent_sub_cost = null;
            $task->task_parent_sub_refund_budget = null;
            $task->task_parent_sub_pay = null;
            $task->save();
        }
        return redirect()->route('project.view', $project);

    }



}
