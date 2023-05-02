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
use Jenssegers\Date\Date;
class SortableController extends Controller
{
    //

    public function index()
    {
        // ดึงข้อมูลรายการจากฐานข้อมูล
        $items = Project::orderBy('order_column', 'asc')->get();

        // ส่งข้อมูลรายการไปยัง sortable-list.blade.php

        return view('app.sortable.sortable-list', compact('items'));
    }
    public function updateOrder(Request $request)
    {
        $items = $request->input('items');

        if (!$items) {
            return response()->json(['status' => 'error', 'message' => 'No items provided.']);
        }

        // Update the new order in the database
        foreach ($items as $order => $itemId) {
            $item = Project::findOrFail($itemId);
            $item->update(['order_column' => $order]);
        }

        return response()->json(['status' => 'success', 'message' => 'Order updated.']);
    }
}

