<?php

namespace App\Http\Controllers;

use App\Libraries\Helper;
use App\Models\Contract;
use App\Models\ContractHasTask;
use App\Models\Project;
use App\Models\Task;
use App\Models\Taskcon;
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
        $id = Hashids::decode($project)[0];
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
            //'project_cost_disbursement'     => $project['project_cost_disbursemen'],
            'total_cost'                => $project['total_cost'],
            'cost'                  => $project['project_cost'],
            'cost_pa_1'             => $project['cost_pa_1'],
            'cost_no_pa_2'             => $project['cost_no_pa_2'],
            // 'cost_disbursement'     => $project['cost_disbursement'],

            // 'pay'                   => $project['pay'],
            'total_pay'              => $project['total_pay'],
            'owner'                 => $project['project_owner'],
            'open'                  => true,
            'type'                  => 'project',
            // 'duration'              => 360,
        ];

        $budget['total'] = $__budget;
        $tasks =  Project::find($id);



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
            ->where('project_id', ($id))
            ->get()
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
                'tbalance'               => $__balance,
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
        ($gantt[0]['balance'] = $gantt[0]['balance'] - $gantt[0]['total_cost']);




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
            ->whereNotNull('task_cost_gov_utility')
            ->where('project_id', ($id))

            ->get());
        ($json = json_decode($ut_pay_sum));
        ($utsc_pay = $json[0]->utsc_pay);
        ($utsc_pay = (float)$utsc_pay);


        ($ut_pay_pa_sum = DB::table('tasks')
            ->selectRaw('SUM(COALESCE(task_pay,0)) As utsc_pay_pa  ')
            ->where('tasks.task_type', 1)
            ->whereNotNull('task_cost_gov_utility')
            ->where('project_id', ($id))
            ->get());
        ($json = json_decode($ut_pay_pa_sum));
        ($utsc_pay_pa = $json[0]->utsc_pay_pa);
        ($utsc_pay_pa = (float)$utsc_pay_pa);

        $parent_sum_pa = DB::table('tasks')
            ->select('tasks.task_parent', 'a.cost_a')

            ->leftJoin(DB::raw('(select tasks.task_parent, sum( COALESCE(tasks.task_cost_it_investment,0)+ COALESCE(tasks.task_cost_it_operating,0)+ COALESCE(tasks.task_budget_gov_utility,0)) as cost_a from tasks where tasks.task_parent is not null group by tasks.task_parent) as a'), 'tasks.task_parent', '=', 'tasks.task_id')
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




        ($gantt);

        $gantt = json_encode($gantt);

        return view('app.projects.show', compact(
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
            'otpsa2'
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
            'project_fiscal_year' => 'required|integer',
            'budget_gov_operating' => 'nullable|numeric',
            'budget_gov_investment' => 'nullable|numeric',
            'budget_gov_utility' => 'nullable|numeric',
            'budget_it_operating' => 'nullable|numeric',
            'budget_it_investment' => 'nullable|numeric',
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

        if ($project->save()) {
            return redirect()->route('project.index');
        }
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
    public function taskShow($project, $task)
    {
        // ดึงข้อมูล Project และ Task

        // ดึงข้อมูล Contract และ Taskcon โดยใช้คำสั่ง SQL

        ($project = Project::find(Hashids::decode($project)[0]));
        ($task = Task::find(Hashids::decode($task)[0]));



        ($contract = Contract::join('contract_has_tasks', 'contracts.contract_id', '=', 'contract_has_tasks.contract_id')
            ->join('tasks', 'contract_has_tasks.task_id', '=', 'tasks.task_id')
            ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            ->select(
                'contracts.*',

                'projects.*',
                'tasks.*'
            )
            ->where('projects.project_id', $project->project_id)
            ->where('tasks.task_id', $task->task_id)
            ->first());







        ($results = Contract::join('taskcons', 'contracts.contract_id', '=', 'taskcons.contract_id')
            ->join('contract_has_tasks', 'contracts.contract_id', '=', 'contract_has_tasks.contract_id')
            ->join('tasks', 'contract_has_tasks.task_id', '=', 'tasks.task_id')
            ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            ->select(
                'contracts.*',
                'taskcons.*',
                'projects.*',
                'tasks.*'
            )
            ->where('projects.project_id', $project->project_id)
            ->where('tasks.task_id', $task->task_id) // Replaced 'contracts.contract_id' with 'tasks.task_id'
            ->get());


        $latestContract = Contract::latest()->first();


        // ตรวจสอบค่าตัวแปร
        ($results);

        //dd($project, $task, $results);

        // ส่งข้อมูลไปยัง view
        return view('app.projects.tasks.show', compact('project', 'task', 'results', 'contract', 'latestContract'));
    }


    public function taskCreate(Request $request, $project, $task = null)
    {
        $id        = Hashids::decode($project)[0];
        $project = $request->project;
        //  ($project = Project::find($id)); // รับข้อมูลของโครงการจากฐานข้อมูล
        ($tasks     = Task::where('project_id', $id)->get());
        $contracts = contract::orderBy('contract_fiscal_year', 'desc')->get();

        ($request = Project::find($id));

        // Sum the task_budget_it_operating for all tasks
        $sum_task_budget_it_operating = $tasks->sum('task_budget_it_operating');
        $sum_task_budget_it_investment = $tasks->sum('task_budget_it_investment');
        $sum_task_budget_gov_utility = $tasks->sum('task_budget_gov_utility');

        if ($task) {
            $taskId = Hashids::decode($task)[0];
            $task = Task::find($taskId);
        } else {
            $task = null;
        }


        //       dd ($request,$contracts, $project,$tasks,$task, $sum_task_budget_it_operating, $sum_task_budget_it_investment, $sum_task_budget_gov_utility);


        return view('app.projects.tasks.create', compact('request', 'contracts', 'project', 'tasks', 'task', 'sum_task_budget_it_operating', 'sum_task_budget_it_investment', 'sum_task_budget_gov_utility'));
    }



    public function taskCreateSub(Request $request, $project, $task = null)
    {
        $id = Hashids::decode($project)[0];
        //$project = Project::find($projectId);
        $tasks = Task::where('project_id', $id)->get();
        ($contracts = contract::orderBy('contract_fiscal_year', 'desc')->get());
        // ($request = contract::orderBy('contract_fiscal_year', 'desc')->get());

        //dd ($request);
        //  if ($project) {
        //    $projectId = Hashids::decode($id)[0];
        //    $project = Task::find($projectId);
        //} else {
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
        if ($task) {
            $taskId = Hashids::decode($task)[0];
            $task = Task::find($taskId);
        } else {
            $task = null;
        }


        //  dd($contracts);
        return view('app.projects.tasks.createsub', compact('request', 'contracts', 'project', 'tasks', 'task'));

        /*   return view('app.projects.tasks.createsub', compact(   'request','contracts', 'project', 'tasks', 'task')); */
    }


    public function taskCreateSubno(Request $request, $project, $task = null)
    {
        ($id = Hashids::decode($project)[0]);
        $tasks = Task::where('project_id', $id)->get();
        $projectyear = Project::where('project_id', $id)->first(); // เปลี่ยนจาก get() เป็น first()
        $contracts = Contract::orderBy('contract_fiscal_year', 'desc')->get();

        $contractText = ''; // กำหนดค่าเริ่มต้นให้กับ $contractText



        //dd ($request);
        //  if ($project) {
        //    $projectId = Hashids::decode($id)[0];
        //    $project = Task::find($projectId);
        //} else {
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
        if ($task) {
            $taskId = Hashids::decode($task)[0];
            $task = Task::find($taskId);
        } else {
            $task = null;
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

     //  dd($contracts);

        return view('app.projects.tasks.createsubno', compact('request', 'contracts', 'project', 'projectyear', 'tasks', 'task', 'contractText'));

        /*   return view('app.projects.tasks.createsub', compact(   'request','contracts', 'project', 'tasks', 'task')); */
    }









   /*  public function taskStore(Request $request, $project)
    {
        $id   = Hashids::decode($project)[0];
        $task = new Task;

        $messages = [
            'task_end_date.after_or_equal' => 'วันที่สิ้นสุดต้องหลังจากวันที่เริ่มต้น',
        ];
        $request->validate([
        //    'task_name'                   => 'required',
            // 'date-picker-task_start_date' => 'required',
            //'date-picker-task_end_date'   => 'required',
            // 'task_start_date' => 'required|date_format:d/m/Y',
            //'task_end_date' => 'required|date_format:d/m/Y|after_or_equal:task_start_date',
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
        // convert input to decimal or set it to null if empty
        $task_budget_it_operating = str_replace(',', '', $request->input('task_budget_it_operating'));
        $task_budget_gov_utility = str_replace(',', '', $request->input('task_budget_gov_utility'));
        $task_budget_it_investment = str_replace(',', '', $request->input('task_budget_it_investment'));


        $task_cost_it_operating = str_replace(',', '', $request->input('task_cost_it_operating'));
        $task_cost_gov_utility = str_replace(',', '', $request->input('task_cost_gov_utility'));
        $task_cost_it_investment = str_replace(',', '', $request->input('task_cost_it_investment'));

        $task_pay = str_replace(',', '', $request->input('task_pay'));



        if ($task_budget_it_operating === '') {
            $task_budget_it_operating = null; // or '0'
        }

        if ($task_budget_gov_utility === '') {
            $task_budget_gov_utility = null; // or '0'
        }

        if ($task_budget_it_investment === '') {
            $task_budget_it_investment = null; // or '0'
        }

        if ($task_cost_it_operating === '') {
            $task_cost_it_operating = null; // or '0'
        }

        if ($task_cost_gov_utility === '') {
            $task_cost_gov_utility = null; // or '0'
        }

        if ($task_cost_it_investment === '') {
            $task_cost_it_investment = null; // or '0'
        }

        if ($task_pay === '') {
            $task_pay = null; // or '0'
        }


        $task->project_id       = $id;
        $task->task_name        = $request->input('task_name');
        $task->task_description = trim($request->input('task_description'));

        $task->task_start_date  = $start_date ?? date('Y-m-d 00:00:00');
        $task->task_end_date    = $end_date ?? date('Y-m-d 00:00:00');
        $task->task_pay_date     =  $pay_date ?? date('Y-m-d 00:00:00');


        $task->task_parent = $request->input('task_parent') ?? null;



        //convert input to decimal or set it to null if empty

        $task->task_budget_gov_utility    = $task_budget_gov_utility;
        $task->task_budget_it_operating   = $task_budget_it_operating;
        $task->task_budget_it_investment  = $task_budget_it_investment;

        $task->task_cost_gov_utility    = $task_cost_gov_utility;
        $task->task_cost_it_operating   = $task_cost_it_operating;
        $task->task_cost_it_investment  = $task_cost_it_investment;


        $task->task_pay                 =  $task_pay;

        //  $task->task_budget_gov_operating  = $request->input('task_budget_gov_operating');
        //$task->task_budget_gov_investment = $request->input('task_budget_gov_investment');
        // $task->task_budget_gov_utility    = $request->input('task_budget_gov_utility');
        // $task->task_budget_it_operating   = $request->input('task_budget_it_operating');
        // $task->task_budget_it_investment  = $request->input('task_budget_it_investment');

        // $task->task_cost_gov_operating  = $task_cost_gov_operating;
        // $task->task_cost_gov_investment = $task_cost_gov_investment;
        // $task->task_cost_gov_operating  = $request->input('task_cost_gov_operating');
        // $task->task_cost_gov_investment = $request->input('task_cost_gov_investment');
        // $task->task_cost_gov_utility    = $request->input('task_cost_gov_utility');
        // $task->task_cost_it_operating   = $request->input('task_cost_it_operating');
        // $task->task_cost_it_investment  = $request->input('task_cost_it_investment');


        $task->task_type                 = $request->input('task_type');

        $tasks      = Task::where('project_id', $id)
            ->whereNot('task_id', $task)
            ->get();
        $contracts = contract::orderBy('contract_fiscal_year', 'desc')->get();


        if ($contract->save()) {
            if(is_array($request->tasks) || is_object($request->tasks)) {
                foreach($request->tasks as $task){
                    $taskName = isset($task['task_name']) ? $task['task_name'] : 'Default Task Name';

                    Taskcon::create([
                        'contract_id' => $contract->contract_id,
                        'taskcon_name' => $taskName,
                        'updated_at' => now(),
                        'created_at' => now()
                    ]);
                }
            }
        }

        if ($task->save()) {

            //insert contract
            if ($request->input('task_contract')) {
                //insert contract
                $contract_has_task = new ContractHasTask;
                $contract_has_task->contract_id = $request->input('task_contract');
                $contract_has_task->task_id     = $task->task_id;
                $contract_has_task->save();
            }
            //($task);
            return redirect()->route('project.show', $project);
        }
    } */

    public function taskStore(Request $request, $project)
{
    $id = Hashids::decode($project)[0];
    $task = new Task;
    $tasks = Task::where('project_id', $id)->get(); // Fetch all tasks for the project
    $tasksum= Task::where('project_id', $id)->whereNull('task_parent')->get(); // Fetch all tasks for the project with no parent task
    ($sum_task_budget_it_operating = $tasksum->sum('task_budget_it_operating'));
($sum_task_budget_it_investment = $tasksum->sum('task_budget_it_investment'));
    ($sum_task_budget_gov_utility = $tasksum->sum('task_budget_gov_utility'));

    $messages = [
        'task_end_date.after_or_equal' => 'วันที่สิ้นสุดต้องหลังจากวันที่เริ่มต้น',
        'task_budget_it_operating.required' => 'กรุณาระบุงบกลาง ICT',
        'task_budget_it_operating.numeric' => 'กรุณากรอกจำนวนให้ถูกต้องและเป็นตัวเลข',
        'task_budget_it_operating.min' => 'กรุณาระบุงบกลาง ICT เป็นจำนวนบวก',
        'task_budget_it_investment.required' => 'กรุณาระบุงบดำเนินงาน',
        'task_budget_it_investment.numeric' => 'กรุณากรอกจำนวนให้ถูกต้องและเป็นตัวเลข',
        'task_budget_it_investment.min' => 'กรุณาระบุงบดำเนินงานเป็นจำนวนบวก',
        'task_budget_gov_utility.required' => 'กรุณาระบุค่าสาธารณูปโภค',
        'task_budget_gov_utility.numeric' => 'กรุณากรอกจำนวนให้ถูกต้องและเป็นตัวเลข',
        'task_budget_gov_utility.min' => 'กรุณาระบุค่าสาธารณูปโภคเป็นจำนวนบวก',
    ];

    $request->validate([
        'task_name' => 'required',
        'task_start_date' => 'required|date_format:d/m/Y',
        'task_end_date' => 'required|date_format:d/m/Y|after_or_equal:task_start_date',
        //'task_budget_it_operating' => 'required|numeric|min:0|max:' ,
       // 'task_budget_it_investment' => 'required|numeric|min:0|max:' ,
     //  'task_budget_gov_utility' => 'required|numeric|min:0|max:',
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

    // convert input to decimal or set it to null if empty
    $task_budget_it_operating = $request->input('task_budget_it_operating') !== '' ? (float) str_replace(',', '', $request->input('task_budget_it_operating')) : null;
    $task_budget_gov_utility = $request->input('task_budget_gov_utility') !== '' ? (float) str_replace(',', '', $request->input('task_budget_gov_utility')) : null;
    $task_budget_it_investment = $request->input('task_budget_it_investment') !== '' ? (float) str_replace(',', '', $request->input('task_budget_it_investment')) : null;

    $task_cost_it_operating = $request->input('task_cost_it_operating') !== '' ? (float) str_replace(',', '', $request->input('task_cost_it_operating')) : null;
    $task_cost_gov_utility = $request->input('task_cost_gov_utility') !== '' ? (float) str_replace(',', '', $request->input('task_cost_gov_utility')) : null;
    $task_cost_it_investment = $request->input('task_cost_it_investment') !== '' ? (float) str_replace(',', '', $request->input('task_cost_it_investment')) : null;

    $task_pay = $request->input('task_pay') !== '' ? (float) str_replace(',', '', $request->input('task_pay')) : null;

    $task->project_id = $id;
    $task->task_name = $request->input('task_name');
    $task->task_description = trim($request->input('task_description'));

    $task->task_start_date = $start_date ?? date('Y-m-d 00:00:00');
    $task->task_end_date = $end_date ?? date('Y-m-d 00:00:00');
    $task->task_pay_date = $pay_date ?? date('Y-m-d 00:00:00');

    $task->task_parent = $request->input('task_parent') ?? null;

    $task->task_budget_gov_utility = $task_budget_gov_utility;
    $task->task_budget_it_operating = $task_budget_it_operating;
    $task->task_budget_it_investment = $task_budget_it_investment;

    $task->task_cost_gov_utility = $task_cost_gov_utility;
    $task->task_cost_it_operating = $task_cost_it_operating;
    $task->task_cost_it_investment = $task_cost_it_investment;

    $task->task_pay = $task_pay;

    $task->task_type = $request->input('task_type');

    if ($task->save()) {
        //insert contract
        if ($request->input('task_contract')) {
            //insert contract
            $contract_has_task = new ContractHasTask;
            $contract_has_task->contract_id = $request->input('task_contract');
            $contract_has_task->task_id = $task->task_id;
            $contract_has_task->save();
        }

        if ($request->has('tasks')) {
            foreach ($request->tasks as $contractData) {
                $contractName = isset($contractData['contract_name']) ? $contractData['contract_name'] : 'Default Contract Name';

                $contract = new Contract;
                $contract->contract_name = $contractName;
                $contract->save();
            }
        }

        if ($request->has('tasks')) {
            foreach ($request->tasks as $taskData) {
                $taskName = isset($taskData['task_name']) ? $taskData['task_name'] : 'Default Task Name';

                Taskcon::create([
                    'contract_id' => $request->input('task_contract'),
                    'taskcon_name' => $taskName,
                    'updated_at' => now(),
                    'created_at' => now()
                ]);
            }
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
        ($project    = Project::find($id_project));
        $task       = Task::find($id_task);
        $tasks      = Task::where('project_id', $id_project)
            ->whereNot('task_id', $id_task)
            ->get();
        $contracts = contract::orderBy('contract_fiscal_year', 'desc')->get();

        return view('app.projects.tasks.edit', compact('contracts', 'project', 'task', 'tasks'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $project
     * @return \Illuminate\Http\Response
     */
    public function taskEditSub(Request $request, $project, $task)
    {
        $id_project = Hashids::decode($project)[0];
        $id_task    = Hashids::decode($task)[0];
        ($project    = Project::find($id_project));
        $task       = Task::find($id_task);
        $tasks      = Task::where('project_id', $id_project)
            ->whereNot('task_id', $id_task)
            ->get();
        $contracts = contract::orderBy('contract_fiscal_year', 'desc')->get();















        return view('app.projects.tasks.editsub', compact('contracts', 'project', 'task', 'tasks'));
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
        $task = Task::find($id_task);

        $request->validate([
            'task_name' => 'required',
            // 'date-picker-task_start_date' => 'required',
            // 'date-picker-task_end_date' => 'required',
        ]);

        $start_date_obj = date_create_from_format('d/m/Y', $request->input('task_start_date'));
        $end_date_obj = date_create_from_format('d/m/Y', $request->input('task_end_date'));
        $pay_date_obj = date_create_from_format('d/m/Y', $request->input('task_pay_date'));

        if ($start_date_obj === false || $end_date_obj === false || $pay_date_obj === false) {
            // จัดการข้อผิดพลาดการแปลงวันที่
            // คุณสามารถคืนค่าข้อความแสดงข้อผิดพลาดหรือใช้วันที่เริ่มต้นเริ่มต้นได้
        } else {
            $start_date_obj->modify('-543 years');
            $end_date_obj->modify('-543 years');
            $pay_date_obj->modify('-543 years');

            $start_date = $start_date_obj->format('Y-m-d H:i:s');
            $end_date = $end_date_obj->format('Y-m-d H:i:s');
            $pay_date = $pay_date_obj->format('Y-m-d H:i:s');
        }

        // แปลงข้อมูลเป็นทศนิยมหรือตั้งค่าเป็น null หากไม่มีข้อมูล
        $task_budget_it_operating = str_replace(',', '', $request->input('task_budget_it_operating'));
        $task_budget_gov_utility = str_replace(',', '', $request->input('task_budget_gov_utility'));
        $task_budget_it_investment = str_replace(',', '', $request->input('task_budget_it_investment'));

        // แปลงข้อมูลเป็นทศนิยมหรือตั้งค่าเป็น null หากไม่มีข้อมูล
        $task_cost_it_operating = str_replace(',', '', $request->input('task_cost_it_operating'));
        $task_cost_gov_utility = str_replace(',', '', $request->input('task_cost_gov_utility'));
        $task_cost_it_investment = str_replace(',', '', $request->input('task_cost_it_investment'));

        $task_pay = str_replace(',', '', $request->input('task_pay'));

        if ($task_cost_it_operating === '') {
            $task_cost_it_operating = null; // หรือ '0'
        }

        if ($task_cost_gov_utility === '') {
            $task_cost_gov_utility = null; // หรือ '0'
        }

        if ($task_cost_it_investment === '') {
            $task_cost_it_investment = null; // หรือ '0'
        }

        if ($task_budget_it_operating === '') {
            $task_budget_it_operating = null; // หรือ '0'
        }

        if ($task_budget_gov_utility === '') {
            $task_budget_gov_utility = null; // หรือ '0'
        }

        if ($task_budget_it_investment === '') {
            $task_budget_it_investment = null; // หรือ '0'
        }

        if ($task_pay === '') {
            $task_pay = null; // หรือ '0'
        }

        $task->task_start_date = $start_date ?? date('Y-m-d H:i:s');
        $task->task_end_date = $end_date ?? date('Y-m-d H:i:s');
        $task->task_pay_date = $pay_date ?? date('Y-m-d H:i:s');

        $task->project_id = $id_project;
        $task->task_name = $request->input('task_name');
        $task->task_status = $request->input('task_status');
        $task->task_description = trim($request->input('task_description'));

        // อัปเดตแอตทริบิวต์งานอื่นๆ ตามที่ต้องการ

        if ($task->save()) {
            // อัปเดตสัญญา
            if ($request->input('task_contract')) {
                ContractHasTask::where('task_id', $id_task)->delete();
                ContractHasTask::create([
                    'contract_id' => $request->input('task_contract'),
                    'task_id' => $id_task,
                ]);
            } else {
                ContractHasTask::where('task_id', $id_task)->delete();
            }

            //dd($task);
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
