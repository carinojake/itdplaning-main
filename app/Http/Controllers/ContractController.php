<?php

namespace App\Http\Controllers;

use App\Libraries\Helper;
use App\Models\Contract;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Project;
use App\Models\Task;
use App\Models\Taskcon;
use App\Models\ContractHasTask;
use App\Models\ContractHasTaskcon;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ContractController extends Controller
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
            $records = contract::orderBy('contract_fiscal_year', 'desc');

            return Datatables::eloquent($records)
                ->addIndexColumn()
                ->addColumn('contract_number_output', function ($row) {
                    return $row->contract_number;
                })
                ->addColumn('contract_name_output', function ($row) {
                    $flag_status = $row->contract_status == 2 ? '<span class="badge bg-info">ดำเนินการแล้วเสร็จ</span>' : '';
                    $flag_status2 = $row->contract_refund_pa_status == 1 ? '<span class="badge bg-info">คืนเงิน PA </span>' : '<span class="badge bg-danger ">ยังไม่ได้คืนเงิน PA </span>';
                    $html        = $row->contract_name . ' ' . $flag_status;
                    $html .= '<br><span class="badge bg-info">' . Helper::Date4(date('Y-m-d H:i:s', $row->contract_start_date)) . '</span> -';
                    $html .= ' <span class="badge bg-info">' . Helper::date4(date('Y-m-d H:i:s', $row->contract_end_date)) . '</span>';


                    $startDate = Carbon::parse($row->contract_start_date);
                    $endDate = Carbon::parse($row->contract_end_date);
                    $diffInMonths = $endDate->diffInMonths($startDate);
                    $diffInMonthsend = $endDate->diffInMonths($startDate) - \Carbon\Carbon::parse($row->contract_start_date)->diffInMonths(\Carbon\Carbon::parse());
                    $diffInDays = $endDate->diffInDays($startDate);
                    $diffInDaysend = $endDate->diffInDays($startDate) - \Carbon\Carbon::parse($row->contract_start_date)->diffInDays(\Carbon\Carbon::parse());;

                    $html .= '<span>' . (isset($diffInMonthsend) && $diffInMonthsend < 3
                        ? '<span class="badge bg-danger style="color:red;">เหลือเวลา ' . $diffInMonthsend . '  เดือน / เหลือ ' . $diffInDaysend . ' วัน</span>'
                        : '<span class="badge bg-success  style="color:rgb(5, 255, 5);">เหลือเวลา ' . $diffInMonthsend . ' เดือน</span>')
                        . ' ' . ' </span>';
                    if ($row->task->count() > 0) {
                        $html .= ' <span class="badge bg-warning">' . $row->task->count() . ' กิจกรรม</span>';
                    }



                    return $html;
                })
                ->addColumn('contract_fiscal_year', function ($row) {
                    return $row->contract_fiscal_year;
                })


                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">';
                    $html .= '<a href="' . route('contract.show', $row->hashid) . '" class="btn btn-success text-white"><i class="cil-folder-open "></i></a>';
                    //if (Auth::user()->hasRole('admin')) {
                    $html .= '<a href="' . route('contract.edit', $row->hashid) . '" class="btn btn-warning btn-edit text-white"><i class="cil-pencil "></i></a>';
                    $html .= '<button data-rowid="' . $row->hashid . '" class="btn btn-danger btn-delete text-white"><i class="cil-trash "></i></button>';
                    //}
                    $html .= '</div>';

                    return $html;
                })
                ->rawColumns(['contract_name_output', 'action'])
                ->toJson();
        }

        return view('app.contracts.index');
    }

    public function show(Request $request, $contract)
    {
        $id = Hashids::decode($contract)[0];
        $latestContract = Contract::latest()->first();
        ($contract = Contract::find($id));

        $contract_start_date = \Carbon\Carbon::createFromTimestamp($contract->contract_start_date);
        $contract_end_date = \Carbon\Carbon::createFromTimestamp($contract->contract_end_date);

        ($duration = $contract_end_date->diff($contract_start_date)->days);

        ($duration_p =  \Carbon\Carbon::parse($contract->contract_end_date)
            ->diffInMonths(\Carbon\Carbon::parse($contract->contract_start_date))
            -  \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse()));
        // $gantt = '';

        // dd(Hashids::encode($contract->task->task_id));



        //    // คำนวณค่าเงินเบิกจ่ายทั้งหมดของContract
        ($contractgannt = Contract::select('contracts.*', 'a.total_cost', 'a.total_pay')

            ->leftJoin(
                DB::raw('(select  taskcons.contract_id,
            sum(COALESCE(taskcons.taskcon_cost_gov_utility,0))
          +sum(COALESCE(taskcons.taskcon_cost_it_operating,0))
           +sum(COALESCE(taskcons.taskcon_cost_it_investment,0)) as total_cost ,
          sum( COALESCE(taskcons.taskcon_pay,0)) as total_pay
          from taskcons  group by taskcons.contract_id) as a'),
                'a.contract_id',
                '=',
                'contracts.contract_id'
            )

            // ->leftJoin(
            //       DB::raw('(select taskcons.contract_id,
            //      sum(COALESCE(taskcons.taskcon_cost_gov_utility,0))
            //    +sum(COALESCE(taskcons.taskcon_cost_it_operating,0))
            //     +sum(COALESCE(taskcons.taskcon_cost_it_investment,0)) as cost_pa_1 ,
            //     sum( COALESCE(taskcons.taskcon_pay,0)) as total_pay
            //     from tasks  where taskcons.taskcon_type=1 group by taskcons.contract_id) as ab'),
            //        'ab.contract_id',
            //        '=',
            //        'contracts.contract_id'
            //    )

            // ->leftJoin(
            //      DB::raw('(select taskcons.contract_id,
            //   sum(COALESCE(taskcons.taskcon_cost_gov_utility,0))
            //   +sum(COALESCE(taskcons.taskcon_cost_it_operating,0))
            //    +sum(COALESCE(taskcons.taskcon_cost_it_investment,0))as cost_no_pa_2 ,
            //    sum( COALESCE(taskcons.taskcon_pay,0)) as total_pay
            //    from taskcons  where taskcons.taskcon_type=2 group by taskcons.contract_id) as ac'),
            //        'ac.contract_id',
            //        '=',
            //        'contracts.contract_id'
            //    )

            // ->join('tasks', 'tasks.project_id', '=', 'projects.id')
            // ->groupBy('projects.project_id')
            ->where('contracts.contract_id', $id)
            ->first()

            ->toArray()
        );
         ($contractgannt);

        //   คำนวณค่าเงินเบิกจ่ายทั้งหมดของโปรเจกต์
        //   (float) $__budget_gov = (float) $contract['budget_gov_operating'] + (float) $contract['budget_gov_utility'];
        //   (float) $__budget_it  = (float) $contract['budget_it_operating'] + (float) $contract['budget_it_investment'];
        //   (float) $__budget     = $__budget_gov + $__budget_it;
        //   (float) $__cost       = (float) $contract['project_cost'];
        //   (float) $__balance    = $__budget + (float) $contract['project_cost'];
        //  $__contract     = [];

        $gantt[] = [
            'id'                    => $contract['contract_id'],
            'text'                  => $contract['contract_name'],
            'start_date' => date('Y-m-d', strtotime($contract['contract_start_date'])),
            'end_date'   => date('Y-m-d', strtotime($contract['contract_end_date'])),


            'open'                  => true,
            'type'                  => 'project',
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

            'total_cost'            => $contractgannt['total_cost'],

            'total_pay'             => $contractgannt['total_pay'],
            //pro

            //             'p'                  => $contract['contract_type'],

            //             'end_date' => date('Y-m-d', $contract['contract_end_date']),
            //             'budget_gov_operating'  => $contract['budget_gov_operating'],
            //             'budget_gov_investment' => $contract['budget_gov_investment'],
            //             'budget_gov_utility'    => $contract['budget_gov_utility'],
            //             'budget_gov'            => $__budget_gov,
            //             'budget_it_operating'   => str_replace(',', '', $contract['budget_it_operating']),
            //             'budget_it_investment'  => $contract['budget_it_investment'],
            //             'budget_it'             => $__budget_it,
            //             'budget'                => $__budget,
            //             'balance'               => $__balance,
            //             'pbalance'               => $__balance,


            //             'cost'                  => $contract['contract_cost'],
            //             'cost_pa_1'             => $contract['cost_pa_1'],
            //             'cost_no_pa_2'             => $contract['cost_no_pa_2'],

            //             'owner'                 => $contract['contract_owner'],
            //             'open'                  => true,
            //            'type'                  => 'project',
            //             'duration'              => 360,

            //       'cost_disbursement'     => $project['cost_disbursement'],

            //             'pay'                   => $project['pay'],
            //  'project_cost_disbursement'     => $project['project_cost_disbursemen'],
        ];

        //dd($gantt);



        $taskcons =  Contract::find($id);
        ($taskcons = DB::table('taskcons')
            ->select('taskcons.*', 'a.total_cost', 'a.total_pay', 'ab.cost_pa_1', 'ac.cost_no_pa_2')
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
            ->where('contract_id', ($id))
            ->get()
            ->toArray());




        ($taskcons = json_decode(json_encode($taskcons), true));
        foreach ($taskcons as $task) {
            (float) $__budget_gov = (float) $task['taskcon_budget_gov_operating'] + (float) $task['taskcon_budget_gov_utility'] + (float) $task['taskcon_budget_gov_investment'];
            (float) $__budget_it  = (float) $task['taskcon_budget_it_operating'] + (float) $task['taskcon_budget_it_investment'];

            (float) $__budget     = $__budget_gov + $__budget_it;

            (float) $__cost = array_sum([
                // (double)$task['cost_disbursement'],
                $task['taskcon_cost_gov_operating'],
                $task['taskcon_cost_gov_investment'],
                $task['taskcon_cost_gov_utility'],
                $task['taskcon_cost_it_operating'],
                $task['taskcon_cost_it_investment'],
            ]);


            (float) $__taskcon_pay = array_sum([
                // (double)$task['cost_disbursement'],
                $task['taskcon_pay']

            ]);

            (float) $__balance = $__budget - ($__cost);



            // dd ($taskcons );
            $gantt[] = [
                'id'                    => 'T' . $task['taskcon_id'] . $task['contract_id'],
                'text'                  => $task['taskcon_name'],
                'start_date' => date('Y-m-d', strtotime($task['taskcon_start_date'])),
                'end_date'   => date('Y-m-d', strtotime($task['taskcon_end_date'])),

                'parent'                => $task['taskcon_parent'] ? 'T' . $task['taskcon_parent'] . $task['contract_id'] : $task['contract_id'],
                'type'                  => 'task',
                'open'                  => true,
                'budget_gov_operating'  => $task['taskcon_budget_gov_operating'],
                'budget_gov_investment' => $task['taskcon_budget_gov_investment'],
                'budget_gov_utility'    => $task['taskcon_budget_gov_utility'],
                'budget_gov'            => $__budget_gov,
                'budget_it_operating'   => $task['taskcon_budget_it_operating'],
                'budget_it_investment'  => $task['taskcon_budget_it_investment'],
                'contract_pa_budget'    => $contract['contract_pa_budget'],

                'budget_it'             => $__budget_it,
                'budget'                => $__budget,
                'balance'               => $__balance,
                'tbalance'               => $__balance,
                'cost'                  => $__cost,

                'taskcon_cost_gov_utility'    =>    $task['taskcon_cost_gov_utility'],
                'taskcon_cost_it_operating'    =>    $task['taskcon_cost_it_operating'],
                'taskcon_cost_it_investment'  =>    $task['taskcon_cost_it_investment'],
                'cost_pa_1'             => $task['cost_pa_1'],
                'cost_no_pa_2'             => $task['cost_no_pa_2'],
                // 'cost_disbursement'     => $project['cost_disbursement'],
                'total_cost'                => $task['total_cost'],
                'pay'                   => $task['taskcon_pay'],
                //   'cost_disbursement'     => $task['cost_disbursement'],
                'task_total_pay'             => $task['total_pay'],
                'taskcon_type'             => $task['taskcon_type']

                // 'owner' => $project['project_owner'],
            ];
            $__contract_cost[] = $__cost;
            ($__contract_pay[] = $task['taskcon_pay']);
            ($__contract_parent[] = $task['taskcon_parent'] ? 'T' . $task['taskcon_parent'] . $task['contract_id'] : $task['contract_id']);
            ($__contract_parent_cost[] = 'parent');
        }
        // ($gntt[0]['cost']    =array_sum($__project_cost));
        //  ($gantt[0]['pay']    = array_sum($__project_pay));
        // $gantt[0]['balance'] = $gantt[0]['balance'] - $gantt[0]['total_cost'];




        //$budget['cost']    = $gantt[0]['total_cost'];
        //$budget['balance'] = $gantt[0]['balance'];




      // dd($gantt);
        //  dd  ($taskcons);
        ($gantt = json_encode($gantt));


        return view('app.contracts.show', compact('contract', 'gantt', 'duration_p', 'latestContract', 'taskcons'));
    }




    public function createoe(Request $request, $project = null)
    {


        $origin = $request->origin;
        $project = $request->project;
        $task = $request->taskHashid;
        $id = Hashids::decode($project);



        $pro = $project;
        $ta = $task;

        $id_project = null;
        $id_task = null;
        $pro = null;
        $ta = null;

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

        //dd($id,$origin, $project, $task, $pro, $ta, $fiscal_year);


        return view('app.contracts.create', compact('origin', 'project', 'task', 'pro', 'ta', 'fiscal_year'));
    }


    public function create(Request $request, $project = null)
    {
        $origin = $request->origin;
        $project = $request->project;
        $task = $request->taskHashid;
        $id = $project ? Hashids::decode($project) : null;

        $tasks = Task::all();
        $id_project = $id_task = $pro = $ta = null;

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

        $fiscal_year = $request->input('fiscal_year', date('Y') + 543);

        $project_fiscal_year = $pro ? $pro->project_fiscal_year : null;
        $tasksData = DB::table('tasks')
            ->join('projects', 'tasks.project_id', '=', 'projects.project_id')
            ->select('tasks.*', 'projects.*')
            ->get();



        $tasksData = $tasksData->map(function ($task) {
            return [
                'id' => $task->task_id,
                'project_fiscal_year' => $task->project_fiscal_year,
                'project_id' => $task->project_id,
                'task_parent_id' => $task->task_parent,

                'project_name' => $task->project_name,

                'text' => $task->task_name,
                'budget_it_operating' => $task->task_budget_it_operating,
                'budget_it_investment' => $task->task_budget_it_investment,
                'budget_gov_utility' => $task->task_budget_gov_utility,
            ];
        });







       //  dd($tasksData);

        $tasksJson = json_encode($tasksData);

        return view('app.contracts.create', compact('origin', 'project', 'task', 'pro', 'ta', 'fiscal_year', 'tasks', 'tasksJson'));
    }









    public function store(Request $request)
    {

        $contract = new Contract;
        $task = new Task;
        // $tasks = Task::where('project_id', $id)->whereNull('task_parent')->get(); // Fetch all tasks for the project with no parent task

        $messages = [
            'date-picker-contract_end_date.after_or_equal' => 'วันที่สิ้นสุดต้องหลังจากวันที่เริ่มต้น',
        ];
        $request->validate([
            //   'contract_name'                   => 'required',
            //   'contract_pr_budget' => 'numeric|nullable',
            // 'contract_pa_budget' => 'numeric|nullable',
            // 'contract_number'                 => 'required',
            //'date-picker-contract_start_date' => 'required|date_format:d/m/Y',
            //'date-picker-contract_end_date'   => 'required|date_format:d/m/Y|after_or_equal:date-picker-contract_start_date',
            //'start_date' => 'required|date_format:d/m/Y',
            //'end_date' => 'required|date_format:d/m/Y|after_or_equal:start_date',
        ], $messages);
        //convert date
        function convertToGregorianDate($input_date)
        {
            $date_object = date_create_from_format('d/m/Y', $input_date);

            if ($date_object !== false) {
                // Convert to Gregorian calendar
                $date_object->modify('-543 years');
                $formatted_date = $date_object->format('Y-m-d');
            } else {
                $formatted_date = null; // Default value when the date can't be parsed
            }

            return $formatted_date;
        }

        $start_date = convertToGregorianDate($request->input('contract_start_date'));
        $end_date = convertToGregorianDate($request->input('contract_end_date'));
        $insurance_start_date = convertToGregorianDate($request->input('insurance_start_date'));
        $insurance_end_date = convertToGregorianDate($request->input('insurance_end_date'));
        $sign_date = convertToGregorianDate($request->input('contract_sign_date'));



        $contract_pr_budget = str_replace(',', '', $request->input('contract_pr_budget'));
        $contract_pa_budget = str_replace(',', '', $request->input('contract_pa_budget'));

        $contract_po_budget = str_replace(',', '', $request->input('contract_po_budget'));
        $contract_er_budget = str_replace(',', '', $request->input('contract_er_budget'));

        $contract_cn_budget = str_replace(',', '', $request->input('contract_cn_budget'));
        $contract_mm_budget = str_replace(',', '', $request->input('contract_mm_budget'));

        $contract_oe_budget = str_replace(',', '', $request->input('contract_oe_budget'));

        $contract_pay = str_replace(',', '', $request->input('contract_pay'));

        if ($contract_pr_budget === '') {
            $contract_pr_budget = null; // or '0'
        }

        if ($contract_pa_budget === '') {
            $contract_pa_budget = null; // or '0'
        }

        if ($contract_mm_budget === '') {
            $contract_mm_budget = null; // or '0'
        }
        if ($contract_po_budget === '') {
            $contract_po_budget = null; // or '0'
        }
        if ($contract_er_budget === '') {
            $contract_er_budget = null; // or '0'
        }
        if ($contract_cn_budget === '') {
            $contract_cn_budget = null; // or '0'
        }

        if ($contract_oe_budget === '') {
            $contract_oe_budget = null; // or '0'
        }
        if ($contract_pay === '') {
            $contract_pay = null; // or '0'
        }





        $contract->contract_name        = $request->input('contract_name');
        $contract->contract_number      = $request->input('contract_number');
        $contract->contract_description = trim($request->input('contract_description'));
        $contract->contract_fiscal_year = $request->input('contract_fiscal_year');
        $contract->contract_start_date  = $start_date ?? date('Y-m-d 00:00:00');
        $contract->contract_end_date    = $end_date ?? date('Y-m-d 00:00:00');


        $contract->insurance_start_date  =  $insurance_start_date ?? date('Y-m-d 00:00:00');
        $contract->insurance_end_date   =   $insurance_end_date ?? date('Y-m-d 00:00:00');




        $contract->contract_juristic_id = $request->input('contract_juristic_id') ?? null;
        $contract->contract_order_no    = $request->input('contract_order_no') ?? null;
        $contract->contract_type        = $request->input('contract_type') ?? null;
        $contract->contract_acquisition = $request->input('contract_acquisition') ?? null;
        $contract->contract_sign_date   = $sign_date ?? null;
        $contract->contract_projectplan        = $request->input('contract_projectplan');


        $contract->contract_mm        = $request->input('contract_mm');
        $contract->contract_pr        = $request->input('contract_pr');
        $contract->contract_pa        = $request->input('contract_pa');

        $contract->contract_pr_budget = $contract_pr_budget;
        $contract->contract_pa_budget = $contract_pa_budget;

        $contract->contract_po_budget = $contract_po_budget;
        $contract->contract_er_budget = $contract_er_budget;

        $contract->contract_mm_budget = $contract_mm_budget;
        $contract->contract_cn_budget = $contract_cn_budget;
        $contract->contract_oe_budget = $contract_oe_budget;

        $contract->contract_pay = $contract_pay;

        //    $contract->contract_pr_budget        = $request->input('contract_pr_budget');
        //  $contract->contract_pa_budget        = $request->input('contract_pa_budget');
        $contract->contract_owner        = $request->input('contract_owner');
        $contract->contract_refund_pa_status =  $request->input('contract_refund_pa_status');
        $contract->contract_peryear_pa_budget =  $request->input('contract_peryear_pa_budget');



        $origin = $request->input('origin');
        $project = $request->input('project');
        $task = $request->input('task');




        // Get the ID of the newly created contract
        $idproject =  $project;
        $idtask =  $task;
        $id = $project . '/' . $task;
        // Create a new directory for the contract if it doesn't exist
        $contractDir = public_path('uploads/contracts/' . $id);
        if (!file_exists($contractDir)) {
            mkdir($contractDir, 0755, true);
        }


        // Handle file upload
        if ($request->hasFile('contract_file')) {
            // Delete the old file if it exists
            if ($contract->contract_file) {
                $oldFilePath = public_path('uploads/contracts/' . $id . '/' . $contract->contract_file);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $file = $request->file('contract_file');
            $filename = $contract->contract_number  . $contract->contract_fiscal_year . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/contracts/'), $filename);
            $contract->contract_file  = $filename;
        }
        // Handle pr_file upload
        if ($request->hasFile('pr_file')) {
            // ...Your code for handling pr_file upload...
            if ($contract->pr_file) {
                $oldFilePath = public_path('uploads/contracts/' . $contract->pr_file);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $file = $request->file('pr_file');
            $filename = $id . '_PR_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/contracts/'), $filename);
            $contract->pr_file = $filename;
        }

        // Handle pa_file upload
        if ($request->hasFile('pa_file')) {
            // ...Your code for handling pa_file upload...
            if ($contract->pa_file) {
                $oldFilePath = public_path('uploads/contracts/' . $contract->pa_file);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $file = $request->file('pa_file');
            $filename = $id . '_PA_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/contracts/'), $filename);
            $contract->pa_file = $filename;
        }

        // Handle cn_file upload
        if ($request->hasFile('cn_file')) {
            // ...Your code for handling cn_file upload...
            if ($contract->cn_file) {
                $oldFilePath = public_path('uploads/contracts/' . $contract->cn_file);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $file = $request->file('cn_file');
            $filename = $id . '_CN_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/contracts/'), $filename);
            $contract->cn_file = $filename;
        }

        // Handle cn_file upload
        if ($request->hasFile('mm_file')) {
            // ...Your code for handling cn_file upload...
            if ($contract->mm_file) {
                $oldFilePath = public_path('uploads/contracts/' . $contract->mm_file);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $file = $request->file('mm_file');
            $filename = $id . '_mm_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/contracts/'), $filename);
            $contract->mm_file = $filename;
        }

        // $contract->budget_gov = $request->input('budget_gov');
        // $contract->budget_it  = $request->input('budget_it');

        // $contract->budget_gov_operating  = $request->input('budget_gov_operating');
        // $contract->budget_gov_investment = $request->input('budget_gov_investment');
        // $contract->budget_gov_utility    = $request->input('budget_gov_utility');
        // $contract->budget_it_operating   = $request->input('budget_it_operating');
        // $contract->budget_it_investment  = $request->input('budget_it_investment');

        //    if ($contract->save()) {
        //      return redirect()->route('contract.index');
        // }
        //

        if ($contract->save()) {


            //insert contract
            if ($request->input('task_parent')) {
                //insert contract
                $contract_has_task = new ContractHasTask;
                $contract_has_task->contract_id = $contract->contract_id;
                $contract_has_task->task_id = $request->input('task_parent');
                $contract_has_task->save();
            }

            if (is_array($request->tasks) || is_object($request->tasks)) {
                foreach ($request->tasks as $task) {
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




        Log::info('Contract saved successfully');
        Log::info('Request tasks:', ['tasks' => $request->tasks]);;
        if ($contract->save()) {





            $origin = $request->input('origin');
            $project = $request->input('project');
            $task = $request->input('task');

            // บันทึกข้อมูลลงใน session
            session()->flash('contract_id', $contract->contract_id);
            session()->flash('contract_number', $contract->contract_number);
            session()->flash('contract_name', $contract->contract_name);
            session()->flash('contract_pr_budget', $contract->contract_pr_budget);
            session()->flash('contract_pa_budget', $contract->contract_pa_budget);
            session()->flash('contract_pay', $contract->contract_pay);

            if ($origin) {
                return redirect()->route('project.task.createsub', ['project' => $project, 'task' => $task]);
            }

            return redirect()->route('contract.index');
        }
    }


    public function download($id)
    {
        $contract = Contract::findOrFail($id);

        if ($contract->contract_file) {
            $filePath = public_path('uploads/contracts/' . $id . $contract->contract_file);
            return response()->download($filePath, $contract->contract_file);
        }

        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $contract)
    {
        $id       = Hashids::decode($contract)[0];
        $contract = Contract::find($id);

        return view('app.contracts.edit', compact('contract'));
    }






    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $contract)
    {
        $id       = Hashids::decode($contract)[0];
        $contract = Contract::find($id);

        $request->validate([
            'contract_name'                   => 'required',
            //'date-picker-contract_start_date' => 'required',
            //'date-picker-contract_end_date'   => 'required',
        ]);

        //convert date
        $start_date = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-contract_start_date')), 'Y-m-d');
        $end_date   = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-contract_end_date')), 'Y-m-d');
        $sign_date  = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-contract_sign_date')), 'Y-m-d');

        $sign_date_input = $request->input('date-picker-contract_sign_date');
        $sign_date_object = date_create_from_format('d/m/Y', $sign_date_input);

        if ($sign_date_object !== false) {
            $sign_date = $sign_date_object->format('Y-m-d');
        } else {
            $sign_date = null; // ค่าเริ่มต้นเมื่อไม่สามารถแปลงข้อมูลวันที่
        }





        $contract->contract_name        = $request->input('contract_name');
        $contract->contract_number      = $request->input('contract_number');
        $contract->contract_status      = $request->input('contract_status');
        $contract->contract_description = trim($request->input('contract_description'));
        $contract->contract_fiscal_year = $request->input('contract_fiscal_year');
        $contract->contract_start_date  = $start_date ?? date('Y-m-d 00:00:00');
        $contract->contract_end_date    = $end_date ?? date('Y-m-d 00:00:00');

        $contract->contract_juristic_id = $request->input('contract_juristic_id') ?? null;
        $contract->contract_order_no    = $request->input('contract_order_no') ?? null;
        $contract->contract_type        = $request->input('contract_type') ?? null;
        $contract->contract_acquisition = $request->input('contract_acquisition') ?? null;
        $contract->contract_sign_date   = $sign_date ?? null;
        $contract->contract_projectplan        = $request->input('contract_projectplan');
        $contract->contract_mm        = $request->input('contract_mm');
        $contract->contract_pr        = $request->input('contract_pr');
        $contract->contract_pa        = $request->input('contract_pa');
        $contract->contract_pr_budget        = $request->input('contract_pr_budget');
        $contract->contract_pa_budget        = $request->input('contract_pa_budget');
        $contract->contract_refund_pa_budget        = $request->input('contract_refund_pa_budget');
        $contract->contract_owner        = $request->input('contract_owner');
        $contract->contract_refund_pa_status =  $request->input('contract_refund_pa_status');
        $contract->contract_peryear_pa_budget =  $request->input('contract_peryear_pa_budget');

        // $contract->budget_gov = $request->input('budget_gov');
        // $contract->budget_it  = $request->input('budget_it');

        // $contract->budget_gov_operating  = $request->input('budget_gov_operating');
        // $contract->budget_gov_investment = $request->input('budget_gov_investment');
        // $contract->budget_gov_utility    = $request->input('budget_gov_utility');
        // $contract->budget_it_operating   = $request->input('budget_it_operating');
        // $contract->budget_it_investment  = $request->input('budget_it_investment');

        if ($contract->save()) {
            return redirect()->route('contract.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy($contract)
    {
        $id       = Hashids::decode($contract)[0];
        $contract = Contract::find($id);
        if ($contract) {
            $contract->delete();
        }
        return redirect()->route('contract.index');
    }
    //////////////////////////////////////////////////////////////


    public function taskstorestore(Request $request, Contract $contract)
    {
        $request->validate([
            'taskcon_name' => 'required|string',

        ]);

        $task = new ContractTask();
        $task->name = $request->input('taskcon_name');

        $task->contract_id = $contract->id;
        $task->save();

        return redirect()->route('contract.task.index', $contract)->with('success', 'Task created successfully.');
    }





    public function taskstore(Request $request, $contract)
    {
        ($id        = Hashids::decode($contract)[0]);
        ($taskcons     = Taskcon::where('contract_id', $id)->get());
        ($contractcons = Contract::get());

        return view('app.contracts.tasks.create', compact('contractcons', 'taskcons', 'contract'));
    }



    public function taskconShow(Request $request, $contract, $taskcon)
    {
        ($id_contract = Hashids::decode($contract)[0]);
        $id_taskcon    = Hashids::decode($taskcon)[0];
        $contract    = Contract::find($id_contract);
        $taskcon       = taskcon::find($id_taskcon);

        // echo 'contract' . $task->contract->count();
        // dd($task->contract);
        return view('app.contracts.tasks.show', compact('contract', 'taskcon'));
        // return 'app.contracts.tasks.show';
    }

    public function taskconCreate(Request $request, $contract)
    {
        ($id        = Hashids::decode($contract)[0]);
        ($taskcons     = Taskcon::where('contract_id', $id)->get());
        ($contractcons = Contract::get());

        return view('app.contracts.tasks.create', compact('contractcons', 'taskcons', 'contract'));
    }



    public function taskconStore(Request $request, $contract)
    {
        $id   = Hashids::decode($contract)[0];
        $taskcon = new Taskcon;

        $messages = [
            'taskcon_end_date.after_or_equal' => 'วันที่สิ้นสุดต้องหลังจากวันที่เริ่มต้น',
        ];
        $request->validate([
            'taskcon_name'                   => 'required',
            // 'date-picker-task_start_date' => 'required',
            //'date-picker-task_end_date'   => 'required',
            // 'task_start_date' => 'required|date_format:d/m/Y',
            //'task_end_date' => 'required|date_format:d/m/Y|after_or_equal:task_start_date',
        ], $messages);
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





        //convert date
        //   $start_date = date_format(date_create_from_format('d/m/Y', $request->input('taskcon_start_date')), 'Y-m-d');
        // $end_date   = date_format(date_create_from_format('d/m/Y', $request->input('taskcon_end_date')), 'Y-m-d');

        $taskcon->contract_id       = $id;
        $taskcon->taskcon_name        = $request->input('taskcon_name');

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






        // $taskcon->taskcon_budget_gov_operating  = $request->input('taskcon_budget_gov_operating');
        // $taskcon->taskcon_budget_gov_investment = $request->input('taskcon_budget_gov_investment');
        // $taskcon->taskcon_budget_gov_utility    = $request->input('taskcon_budget_gov_utility');
        // $taskcon->taskcon_budget_it_operating   = $request->input('taskcon_budget_it_operating');
        // $taskcon->taskcon_budget_it_investment  = $request->input('taskcon_budget_it_investment');

        // $taskcon->taskcon_cost_gov_operating  = $request->input('taskcon_cost_gov_operating');
        // $taskcon->taskcon_cost_gov_investment = $request->input('taskcon_cost_gov_investment');
        // $taskcon->taskcon_cost_gov_utility    = $request->input('taskcon_cost_gov_utility');
        // $taskcon->taskcon_cost_it_operating   = $request->input('taskcon_cost_it_operating');
        // $taskcon->taskcon_cost_it_investment  = $request->input('taskcon_cost_it_investment');

        if ($taskcon->save()) {

            //insert contract
            if ($request->input('taskcon_contract')) {
                //insert contract
                $contract_has_taskscon = new ContractHasTaskcon;

                $contract_has_taskscon->taskcon_id = $request->input('taskcon_contract');
                $contract_has_taskscon->task_id     = $taskcon->taskcon_id;
                $contract_has_taskscon->save();
            }



            // dd($taskcon);

            return redirect()->route('contract.show', $contract);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $contract
     * @return \Illuminate\Http\Response
     */
    public function taskconEdit(Request $request, $contract, $taskcon)
    {
        $id_contract = Hashids::decode($contract)[0];
        $id_taskcon    = Hashids::decode($taskcon)[0];
        $contract    = Contract::find($id_contract);
        $taskcon       = Taskcon::find($id_taskcon);
        $taskcons      = Taskcon::where('contract_id', $id_contract)
            ->whereNot('taskcon_id', $id_taskcon)

            ->get();
        $tasks = task::get();
        $contractcons = Contract::get();

        //$id_taskcon    = Hashids::decode($taskcon)[0];  $taskcon,$contract
        // $id_contract = Hashids::decode($contract)[0];
        //$taskcon       = taskcon::find($id_taskcon);
        //$contract    = Contract::find($id_contract);
        //$taskcons = Taskcon::where('taskcon_id', $id_taskcon)
        //->where('contract_id', $id_contract)
        // ->get();

        // $taskcons      = Taskcon::where('contract_id', $id_contract)
        //   ->where('taskcon_id', $id_taskcon)
        // ->get();
        // $taskcon = Taskcon::first()->toArray();
        // $task= Task::get();  'contract', 'taskcon','taskcons','task'


        return view('app.contracts.tasks.edit', compact('contractcons', 'tasks', 'contract', 'taskcon', 'taskcons'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $contract
     * @return \Illuminate\Http\Response
     */
    public function taskconUpdate(Request $request, $contract, $taskcon)
    {
        $id_contract = Hashids::decode($contract)[0];
        $id_taskcon    = Hashids::decode($taskcon)[0];
        $contract    = Contract::find($id_contract);
        $taskcon       = taskcon::find($id_taskcon);

        $request->validate([
            'taskcon_name'                   => 'required',
            //  'date-picker-taskcon_start_date' => 'required',
            //'date-picker-taskcon_end_date'   => 'required',

        ]);

        //convert date
        // Convert date inputs to the correct format
        $start_date = \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('taskcon_start_date'))->format('Y-m-d');
        $end_date = \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('taskcon_end_date'))->format('Y-m-d');
        $pay_date = \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('taskcon_pay_date'))->format('Y-m-d');

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





        $taskcon->taskcon_id       = $id_taskcon;
        $taskcon->contract_id       = $id_contract;
        $taskcon->taskcon_name        = $request->input('taskcon_name');
        $taskcon->taskcon_status      = $request->input('taskcon_status');

        /*         $taskcon->taskcon_description = trim($request->input('taskcon_description'));
        $taskcon->taskcon_start_date  = $start_date ;
        $taskcon->taskcon_end_date    = $end_date ;
        $taskcon->taskcon_pay_date     =  $pay_date ; */



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

        $taskcon->taskcon_type                 = $request->input('taskcon_type');
        if ($taskcon->save()) {

            //update contract
            if ($request->input('taskcon_id')) {
                ContractHasTaskcon::where('taskcon_id', $id_taskcon)->delete();
                ContractHasTaskcon::Create([
                    // 'contract_id' => $request->input('taskcon_task'),
                    //'taskcon_id'     => $id_taskcon,
                    'task_id' => $request->input('taskcon_id'),
                    'taskcon_id'     => $id_taskcon,
                ]);
            } else {
                ContractHasTaskcon::where('taskcon_id', $id_taskcon)->delete();
            }

            return redirect()->route('contract.show',  $contract->hashid);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $contract
     * @param  int  $taskcon
     * @return \Illuminate\Http\Response
     */
    public function taskconDestroy($contract, $taskcon)
    {
        $id   = Hashids::decode($taskcon)[0];
        $taskcon = Taskcon::find($id);
        if ($taskcon) {
            $taskcon->delete();
        }
        return redirect()->route('contract.show', $contract);
    }


    /////////






}
