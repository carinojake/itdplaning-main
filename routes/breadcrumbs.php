        <?php // routes/breadcrumbs.php

        // Note: Laravel will automatically resolve `Breadcrumbs::` without
        // this import. This is nice for IDE syntax and refactoring.
        use Diglactic\Breadcrumbs\Breadcrumbs;

        use App\Models\Project;
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
            $trail->push('project', route('project.index'));
        });

        //2 project.create  มีแล้ว
        Breadcrumbs::for('project.create', function (BreadcrumbTrail $trail) {
            $trail->push('Project', route('project.index'));
            $trail->push('Create', route('project.create'));
        });

        // 3 project project.show มีแล้ว
        Breadcrumbs::for('project.show', function (BreadcrumbTrail $trail, $project) {
            //  $trail->parent('dashboard');
            $trail->push('Project', route('project.index'));
            $trail->push($project->project_name, route('project.show', ['project' => $project->project_id]));
            // $trail->push($project->project_name, route('project.edit', ['project' => $project->project_id]));
        });


        // 4 project.edit มีแล้ว
        Breadcrumbs::for('project.edit', function (BreadcrumbTrail $trail, $project) {
            $trail->push('Project', route('project.index'));
            $trail->push($project->project_name, route('project.show', ['project' => $project->hashid]));
            $trail->push('Edit', route('project.edit', ['project' => $project->project_id]));
        });

        // 5 projects.task.create มีแล้ว
        Breadcrumbs::for('project.task.create', function (BreadcrumbTrail $trail, $project) {
            $id = Hashids::decode($project)[0];

            $project = App\Models\Project::find($id);
            ($project);
            $trail->push('Project', route('project.index'));

            $trail->push($project->project_name, route('project.show', ['project' => $project->hashid]));
            $trail->push('Task');
            $trail->push('Create');
        });

        // 6 projects.task.show   มีแล้ว
        Breadcrumbs::for('project.task.show', function (BreadcrumbTrail $trail, $project, $task) {
            $trail->push('Project', route('project.index'));
            $trail->push($project->project_name, route('project.show', ['project' => $project->hashid]));
            $trail->push('Task',  route('project.task.show', ['project' => $project->hashid, 'task' => $task->hashid]));
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
            Breadcrumbs::for('project.task.createsub', function (BreadcrumbTrail $trail, $project, $task) {
                $id = Hashids::decode($project)[0];

                $project = App\Models\Project::find($id);
                ($project);
                $trail->push('Project', route('project.index'));

                $trail->push($project->project_name, route('project.show', ['project' => $project->hashid]));
                $trail->push('Task');
                $trail->push($task->task_name,  route('project.task.show', ['project' => $project->hashid, 'task' => $task->hashid]   ) );
                $trail->push('Create');
            });
        ////////////////////////////////////////////////////////////////////////////////////////

        //  contract 7 มีทั้ง

        // 1 contract contract.index    มีแล้ว
        Breadcrumbs::for('contract', function (BreadcrumbTrail $trail) {
            $trail->push('contract', route('contract.index'));
        });

        //2 project.create  มีแล้ว
        Breadcrumbs::for('contract.create', function (BreadcrumbTrail $trail) {
            $trail->push('contract', route('contract.index'));
            $trail->push('Create', route('contract.create'));
        });


        // 3 contract contract.show มีแล้ว
        Breadcrumbs::for('contract.show', function (BreadcrumbTrail $trail, $contract) {

            $trail->push('contract', route('contract.index'));
            $trail->push($contract->contract_name, route('contract.show', ['contract' => $contract->contract_id]));
        });

        // 4 contract.edit มีแล้ว
        Breadcrumbs::for('contract.edit', function (BreadcrumbTrail $trail, $contract) {
            $trail->push('contract', route('contract.index'));
            $trail->push($contract->contract_name, route('contract.show', ['contract' => $contract->hashid]));
            $trail->push('Edit', route('contract.edit', ['contract' => $contract->contract_id]));
        });

        // 5 contract.task.create มีแล้ว
        Breadcrumbs::for('contract.task.create', function (BreadcrumbTrail $trail, $contract) {
            $id = Hashids::decode($contract)[0];

            $contract = App\Models\contract::find($id);
            ($contract);
            $trail->push('contract', route('contract.index'));

            $trail->push($contract->contract_name, route('contract.show', ['contract' => $contract->hashid]));
            $trail->push('Task');
            $trail->push('Create');
        });

        // 6 contract.task.show   มีแล้ว
        Breadcrumbs::for('contract.task.show', function (BreadcrumbTrail $trail, $contract, $taskcon) {
            $trail->push('contract', route('contract.index'));
            $trail->push($contract->contract_name, route('contract.show', ['contract' => $contract->hashid]));
            $trail->push('Task',  route('contract.task.show', ['contract' => $contract->hashid, 'taskcon' => $taskcon->hashid]));
            $trail->push($taskcon->taskcon_name);
        });

      //   7 contract.task.edit
        Breadcrumbs::for('contract.task.edit', function (BreadcrumbTrail $trail, $contract, $taskcon) {
            $trail->push('contract', route('contract.index'));
            $trail->push($contract->contract_name, route('contract.show', ['contract' => $contract->hashid]));
            $trail->push('Task',  route('contract.task.show', ['contract' => $contract->hashid, 'taskcon' => $contract->hashid]));
            $trail->push($taskcon->taskcon_name);
            $trail->push('Edit');
        });

        //// Home > Blog
        //Breadcrumbs::for('blog', function (BreadcrumbTrail $trail) {
        //    $trail->parent('home');
        //    $trail->push('Blog', route('blog'));
        //});
        //
        //// Home > Blog > [Category]
        //Breadcrumbs::for('category', function (BreadcrumbTrail $trail, $category) {
        //    $trail->parent('blog');
        //    $trail->push($category->title, route('category', $category));
        //});
        //