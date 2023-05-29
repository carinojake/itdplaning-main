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
    //
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }




    public function index(Request $request)
    {

        ($request);

        if ($request->ajax()) {
            ($records = Contract::where('contract_type', 4)->get());
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
                    $html .= '<a href="' . route('expenses.show', $row->hashid) . '" class="btn btn-success text-white"><i class="cil-folder-open "></i></a>';
                    //if (Auth::user()->hasRole('admin')) {
                    $html .= '<a href="' . route('expenses.edit', $row->hashid) . '" class="btn btn-warning btn-edit text-white"><i class="cil-pencil "></i></a>';
                    $html .= '<button data-rowid="' . $row->hashid . '" class="btn btn-danger btn-delete text-white"><i class="cil-trash "></i></button>';
                    //}
                    $html .= '</div>';

                    return $html;
                })
                ->rawColumns(['contract_name_output', 'action'])
                ->toJson();


            }

        //  dd  ($records = Contract::where('contract_type', 4)->get());
        return view('app.expenses.index');
    }

public function getContractData()
{
    $records = Contract::where('contract_type', 4)->get();












    return response()->json($records);
}

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






    public function store(Request $request)
    {
        $contract = new Contract;
        $messages = [
            //'date-picker-contract_end_date.after_or_equal' => 'วันที่สิ้นสุดต้องหลังจากวันที่เริ่มต้น',
        ];
        $request->validate([
        //    'contract_name'                   => 'required',
         //   'contract_pr_budget' => 'numeric|nullable',
           // 'contract_pa_budget' => 'numeric|nullable',
            // 'contract_number'                 => 'required',
            //'date-picker-contract_start_date' => 'required|date_format:d/m/Y',
            //'date-picker-contract_end_date'   => 'required|date_format:d/m/Y|after_or_equal:date-picker-contract_start_date',
            //'start_date' => 'required|date_format:d/m/Y',
            //'end_date' => 'required|date_format:d/m/Y|after_or_equal:start_date',
        ], $messages);
        //convert date
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


          //dd($contract);

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
