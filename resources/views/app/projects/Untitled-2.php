


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
