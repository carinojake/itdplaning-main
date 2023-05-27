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

        //  dd  ($records = Contract::where('contract_type', 4)->get());
        return view('app.expenses.index');
    }

}
