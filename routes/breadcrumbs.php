        <?php // routes/breadcrumbs.php

        // Note: Laravel will automatically resolve `Breadcrumbs::` without
        // this import. This is nice for IDE syntax and refactoring.
        use Diglactic\Breadcrumbs\Breadcrumbs;

        use App\Models\Project;
        use App\Models\task;
        // This import is also not required, and you could replace `BreadcrumbTrail $trail`
        //  with `$trail`. This is nice for IDE type checking and completion.
        use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;



        // Home
        Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
            $trail->push('Dashboard', route('dashboard.index'));
        });

        //  project มีทั้ง 8 มีแล้ว

        // 1 project project.index    มีแล้ว
        Breadcrumbs::for('project', function (BreadcrumbTrail $trail) {
            $trail->push('งาน/โครงการ', route('project.index'));
        });

        //2 project.create  มีแล้ว
        Breadcrumbs::for('project.create', function (BreadcrumbTrail $trail) {
            $trail->push('งาน/โครงการ', route('project.index'));
            $trail->push('เพิ่มข้อมูลงาน โครงการ', route('project.create'));
        });

        // 3 project project.show มีแล้ว
        Breadcrumbs::for('project.show', function (BreadcrumbTrail $trail, $project) {

      //  dd($project);
            //  $trail->parent('dashboard');
           // $trail->push('Project', route('project.index'));
           $trail->push('ปีงบประมาณ ' . $project->project_fiscal_year, route('project.index'));
            $trail->push( Helper::projectsType($project->project_type ), route('project.index'));
            $trail->push($project->project_name, route('project.show', ['project' => $project->project_id]));
            // $trail->push($project->project_name, route('project.edit', ['project' => $project->project_id]));
        });


        // 4 project.edit มีแล้ว
        Breadcrumbs::for('project.edit', function (BreadcrumbTrail $trail, $project) {
           // $trail->push('Project', route('project.index'));
           $trail->push('ปีงบประมาณ ' . $project->project_fiscal_year, route('project.index'));
           $trail->push( Helper::projectsType($project->project_type ), route('project.index'));
            $trail->push($project->project_name, route('project.show', ['project' => $project->hashid]));
            $trail->push('แก้ไข', route('project.edit', ['project' => $project->project_id]));
        });

        // 5 projects.task.create มีแล้ว
        Breadcrumbs::for('project.task.create', function (BreadcrumbTrail $trail, $project) {


            $id = Hashids::decode($project)[0];

            $project = App\Models\Project::find($id);
            $trail->push('ปีงบประมาณ ' . $project->project_fiscal_year, route('project.index'));
           // $trail->push('Project', route('project.index'));
            //$trail->push($project->project_name, route('project.show', ['project' => $project->hashid]));
            $trail->push( Helper::projectsType($project->project_type ), route('project.index'));
            $trail->push($project->project_name, route('project.show', ['project' => $project->hashid]));
           // $trail->push('กิจกรรม');
            $trail->push('เพิ่มกิจกรรม');
        });

        // 6 projects.task.show   มีแล้ว
        Breadcrumbs::for('project.task.show', function (BreadcrumbTrail $trail, $project, $task) {
            $trail->push('ปีงบประมาณ ' . $project->project_fiscal_year, route('project.index'));
            $trail->push(Helper::projectsType($project->project_type), route('project.index'));
            $trail->push($project->project_name, route('project.show', ['project' => $project->hashid]));
            $trail->push('กิจกรรม',  route('project.task.show', ['project' => $project->hashid, 'task' => $task->hashid]));
           // $trail->push($project->task_parent,  route('project.task.show', ['project' => $project->hashid, 'task' => $task->hashid]));
          // $trail->push($task->task_parent, route('project.show', ['project' => $project->hashid]));
          if($task->task_parent > 1) {
            $parentTask = Task::find($task->task_parent);
            if ($parentTask) {
                $trail->push($parentTask->task_name,  route('project.task.show', ['project' => $project->hashid, 'task' => $task->hashid]));       ;
            }
        }


           $trail->push($task->task_name);
        });

       // 6-2 projects.task.show   มีแล้ว
       Breadcrumbs::for('project.task.show2', function (BreadcrumbTrail $trail, $project, $task) {
        $trail->push('ปีงบประมาณ ' . $project->project_fiscal_year, route('project.index'));
        $trail->push(Helper::projectsType($project->project_type), route('project.index'));
        $trail->push($project->project_name, route('project.show', ['project' => $project->hashid]));
        $trail->push('กิจกรรม',  route('project.task.show', ['project' => $project->hashid, 'task' => $task->hashid]));
        $trail->push($project->task_parent,  route('project.task.show', ['project' => $project->hashid, 'task' => $task->hashid]));
        $trail->push($task->task_name);
    });


        // 7 projects.task.edit   มีแล้ว
        Breadcrumbs::for('project.task.edit', function (BreadcrumbTrail $trail, $project, $task) {
            $trail->push('Project', route('project.index'));
            $trail->push($project->project_name, route('project.show', ['project' => $project->hashid]));
            //$trail->push('Task',  route('project.task.show', ['project' => $project->hashid, 'task' => $task->hashid]));
            $trail->push($task->task_name);
            $trail->push('Edit');
        });


            // 8 projects.task.createsub  มีแล้ว
            Breadcrumbs::for('project.task.createsub', function (BreadcrumbTrail $trail, $project) {
                $id = Hashids::decode($project)[0];

                $project = App\Models\Project::find($id);
                ($project);
               // $trail->push('Project', route('project.index'));
               $trail->push('ปีงบประมาณ ' . $project->project_fiscal_year, route('project.index'));
               $trail->push(Helper::projectsType($project->project_type), route('project.index'));
                $trail->push($project->project_name, route('project.show', ['project' => $project->hashid]));
                $trail->push('กิจกรรม');
          //      $trail->push($task->task_name,  route('project.task.show', ['project' => $project->hashid, 'task' => $task->hashid]   ) );
                $trail->push('เพิ่ม');
            });


      // 7 projects.task.editsub   มีแล้ว
      Breadcrumbs::for('project.task.editsub', function (BreadcrumbTrail $trail, $project, $task) {
        $trail->push('Project', route('project.index'));
        $trail->push($project->project_name, route('project.show', ['project' => $project->hashid]));
        //$trail->push('Task',  route('project.task.show', ['project' => $project->hashid, 'task' => $task->hashid]));
        $trail->push($task->task_name);
        $trail->push('EditSub');
    });
        ////////////////////////////////////////////////////////////////////////////////////////

        //  contract 7 มีทั้ง

        // 1 contract contract.index    มีแล้ว
        Breadcrumbs::for('contract', function (BreadcrumbTrail $trail) {
            $trail->push('contract', route('contract.index'));
        });

        //2 project.create  มีแล้ว
        Breadcrumbs::for('contract.create', function (BreadcrumbTrail $trail) {
            //$trail->push('contract', route('contract.index'));
            $trail->push('เพิ่มสัญญา CN / ใบสั่งซื้อ PO / ใบสั่งจ้าง ER', route('contract.create'));
        });


      /*   // 3 contract contract.show มีแล้ว
        Breadcrumbs::for('contract.show', function (BreadcrumbTrail $trail, $contract) {

            $trail->push('contract', route('contract.index'));
            $trail->push($contract->contract_name, route('contract.show', ['contract' => $contract->contract_id]));
        });
 */
        // 4 contract.edit มีแล้ว
        Breadcrumbs::for('contract.edit', function (BreadcrumbTrail $trail, $contract) {
            $trail->push('contract', route('contract.index'));
            $trail->push($contract->contract_name, route('contract.show', ['contract' => $contract->hashid]));
            $trail->push('แก้ไข', route('contract.edit', ['contract' => $contract->contract_id]));
        });

        // 5 contract.task.create มีแล้ว
        Breadcrumbs::for('contract.task.create', function (BreadcrumbTrail $trail, $contract) {
            $id = Hashids::decode($contract)[0];

            $contract = App\Models\contract::find($id);
            ($contract);
            $trail->push('contract', route('contract.index'));

            $trail->push($contract->contract_name, route('contract.show', ['contract' => $contract->hashid]));
            $trail->push('กิจกรรม');
            $trail->push('เพี่ม');
        });

        // 6 contract.task.show   มีแล้ว
        Breadcrumbs::for('contract.task.show', function (BreadcrumbTrail $trail, $contract, $taskcon) {
            $trail->push('contract', route('contract.index'));
            $trail->push($contract->contract_name, route('contract.show', ['contract' => $contract->hashid]));
            $trail->push('กิจกรรม',  route('contract.task.show', ['contract' => $contract->hashid, 'taskcon' => $taskcon->hashid]));
            $trail->push($taskcon->taskcon_name);
        });

      //   7 contract.task.edit
        Breadcrumbs::for('contract.task.edit', function (BreadcrumbTrail $trail, $contract, $taskcon) {
            $trail->push('contract', route('contract.index'));
            $trail->push($contract->contract_name, route('contract.show', ['contract' => $contract->hashid]));
            $trail->push('กิจกรรม',  route('contract.task.show', ['contract' => $contract->hashid, 'taskcon' => $contract->hashid]));
            $trail->push($taskcon->taskcon_name);
            $trail->push('แก้ไข');
        });




