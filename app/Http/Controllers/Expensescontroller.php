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


class ExpensesController extends Controller
{
    /**
     * Display a listing of the expenses.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }




    // ...

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $records = Contract::where('contract_type', 4)->orderBy('contract_fiscal_year', 'desc')->get();

            return DataTables::of($records)
                ->addIndexColumn()
                ->addColumn('contract_number_output', function ($row) {
                    return $row->contract_number;
                })
                ->addColumn('contract_type', function ($row) {
                    return $row->contract_type;
                })
                ->addColumn('contract_name_output', function ($row) {
                    $flag_status = $row->contract_status == 2 ? '<span class="badge bg-info">ดำเนินการแล้วเสร็จ</span>' : '';
                    $flag_status2 = $row->contract_refund_pa_status == 1 ? '<span class="badge bg-info">คืนเงิน PA </span>' : '<span class="badge bg-danger ">ยังไม่ได้คืนเงิน PA </span>';
                    $html = $row->contract_name . ' ' . $flag_status;
                    $html .= '<br><span class="badge bg-info">' . Helper::Date4(date('Y-m-d H:i:s', $row->contract_start_date)) . '</span> -';
                    $html .= ' <span class="badge bg-info">' . Helper::date4(date('Y-m-d H:i:s', $row->contract_end_date)) . '</span>';

                    $startDate = Carbon::parse($row->contract_start_date);
                    $endDate = Carbon::parse($row->contract_end_date);
                    $diffInMonths = $endDate->diffInMonths($startDate);
                    $diffInMonthsend = $endDate->diffInMonths($startDate) - \Carbon\Carbon::parse($row->contract_start_date)->diffInMonths(\Carbon\Carbon::parse());
                    $diffInDays = $endDate->diffInDays($startDate);
                    $diffInDaysend = $endDate->diffInDays($startDate) - \Carbon\Carbon::parse($row->contract_start_date)->diffInDays(\Carbon\Carbon::parse());

                    $html .= '<span>' . (isset($diffInMonthsend) && $diffInMonthsend < 3
                        ? '<span class="badge bg-danger style="color:red;">เหลือเวลา ' . $diffInMonthsend . '  เดือน / เหลือ ' . $diffInDaysend . ' วัน</span>'
                        : '<span class="badge bg-success  style="color:rgb(5, 255, 5);">เหลือเวลา ' . $diffInMonthsend . ' เดือน</span>') . ' ' . ' </span>';
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
                    $html .= '<a href="' . route('expenses.show', $row->hashid) . '" class="btn btn-success text-white"><i class="cil-folder-open"></i></a>';
                    $html .= '<a href="' . route('expenses.edit', $row->hashid) . '" class="btn btn-warning btn-edit text-white"><i class="cil-pencil"></i></a>';
                    $html .= '<button data-rowid="' . $row->hashid . '" class="btn btn-danger btn-delete text-white"><i class="cil-trash"></i></button>';
                    $html .= '</div>';

                    return $html;
                })
                ->rawColumns(['contract_name_output', 'action'])
                ->toJson();
        }

        return view('app.expenses.index');
    }

    /**
     * Show the form for creating a new expense.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $project = null)
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


        return view('app.expenses.create', compact('origin', 'project', 'task', 'pro', 'ta', 'fiscal_year'));
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
                 DB::raw('(select taskcons.contract_id,
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
         //dd  ($contract);

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
             //   'start_date'            => date('Y-m-d', $contract['contract_id_start_date']),
             // 'end_date' => date('Y-m-d', $project['project_end_date']),

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



         //    dd  ($taskcons);
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
                 //'start_date'            => date('Y-m-d', $task['taskcon_start_date']),
                 //'end_date'              => date('Y-m-d', $task['taskcon_end_date']),
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




       //  dd($gantt);

         ($gantt = json_encode($gantt));


         return view('app.expenses.show', compact('contract', 'gantt', 'duration_p', 'latestContract'));
     }


     public function store(Request $request)
     {
         $request->validate([
             'contract_name' => 'required',
             'contract_mm_name' => 'required',
             // Add other validation rules for contract data
         ]);

         // Convert dates to Gregorian format
         function convertToGregorianDate($input_date) {
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

         // Set contract data
         $contract = new Contract;
         $contract->contract_fiscal_year = $request->input('contract_fiscal_year');
         $contract->contract_type = $request->input('contract_type');
         $contract->contract_name = $request->input('contract_name');
         $contract->contract_mm_name = $request->input('contract_mm_name');
         $contract->contract_number = $request->input('contract_number');


         $contract->contract_start_date  = $start_date ?? date('Y-m-d 00:00:00');
         $contract->contract_end_date    = $end_date ?? date('Y-m-d 00:00:00');
         $contract->contract_description = $request->input('contract_description');

         // Save the contract
         if ($contract->save()) {
             // Handle tasks creation
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

             //dd($contract);

             // Redirect to the appropriate page
             if ($request->origin) {
                 return redirect()->route('project.task.createsub', ['project' => $request->project, 'task' => $request->task]);
             }

             return redirect()->route('expenses.index');
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

     public function edit(Request $request, $contract)
     {
         $id = Hashids::decode($contract)[0];
         $contract = Contract::find($id);

         return view('app.expenses.edit', compact('contract'));
     }

     public function update(Request $request, $contract)
     {
         $id = Hashids::decode($contract)[0];
         $contract = Contract::find($id);

         $request->validate([
             'contract_name' => 'required',
             //'date-picker-contract_start_date' => 'required',
             //'date-picker-contract_end_date'   => 'required',
         ]);

         // Convert dates to the desired format
         $start_date = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-contract_start_date')), 'Y-m-d');
         $end_date = date_format(date_create_from_format('d/m/Y', $request->input('date-picker-contract_end_date')), 'Y-m-d');

         // Set contract data
         $contract->contract_name = $request->input('contract_name');
         $contract->contract_number = $request->input('contract_number');
         $contract->contract_status = $request->input('contract_status');
         $contract->contract_description = trim($request->input('contract_description'));
         $contract->contract_fiscal_year = $request->input('contract_fiscal_year');
         $contract->contract_start_date = $start_date ?? date('Y-m-d 00:00:00');
         $contract->contract_end_date = $end_date ?? date('Y-m-d 00:00:00');
         $contract->contract_juristic_id = $request->input('contract_juristic_id') ?? null;
         $contract->contract_order_no = $request->input('contract_order_no') ?? null;
         $contract->contract_type = $request->input('contract_type') ?? null;
         $contract->contract_acquisition = $request->input('contract_acquisition') ?? null;
         $contract->contract_sign_date = $sign_date ?? null;
         $contract->contract_projectplan = $request->input('contract_projectplan');
         $contract->contract_mm = $request->input('contract_mm');
         $contract->contract_pr = $request->input('contract_pr');
         $contract->contract_pa = $request->input('contract_pa');
         $contract->contract_pr_budget = $request->input('contract_pr_budget');
         $contract->contract_pa_budget = $request->input('contract_pa_budget');
         $contract->contract_refund_pa_budget = $request->input('contract_refund_pa_budget');
         $contract->contract_owner = $request->input('contract_owner');
         $contract->contract_refund_pa_status = $request->input('contract_refund_pa_status');
         $contract->contract_peryear_pa_budget = $request->input('contract_peryear_pa_budget');

         if ($contract->save()) {
             return redirect()->route('expenses.index');
         }
     }

     public function destroy($contract)
     {
         $id = Hashids::decode($contract)[0];
         $contract = Contract::find($id);
         if ($contract) {
             $contract->delete();
         }
         return redirect()->route('expenses.index');
     }

     //////////////////////////////////////////////////////////////
    }
