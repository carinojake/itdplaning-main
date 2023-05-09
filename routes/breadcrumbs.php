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


// project project.show
Breadcrumbs::for('project.show', function (BreadcrumbTrail $trail, $project) {
  //  $trail->parent('dashboard');
    $trail->push('Project', route('project.index'));
    $trail->push($project->project_name, route('project.show', ['project' => $project->project_id]));
   // $trail->push($project->project_name, route('project.edit', ['project' => $project->project_id]));
});
// project.create
Breadcrumbs::for('project.create', function (BreadcrumbTrail $trail) {
    $trail->push('Project', route('project.index'));
    $trail->push('Create', route('project.create'));
});
// project.edit
Breadcrumbs::for('project.edit', function (BreadcrumbTrail $trail, $project) {
    $trail->push('Project', route('project.index'));
    $trail->push($project->project_name, route('project.show', ['project' => $project->hashid]));
    $trail->push('Edit', route('project.edit', ['project' => $project->project_id]));
});

// projects.task.create
Breadcrumbs::for('project.task.create', function (BreadcrumbTrail $trail, $project) {


    $id = Hashids::decode($project)[0];
// Query ดึงข้อมูลโปรเจคและคำนวณค่าใช้จ่ายและการจ่ายเงิน
    $project = App\Models\Project::find($id);
($project);
    $trail->push('Project', route('project.index'));

    $trail->push($project->project_name, route('project.show', ['project' => $project->hashid]));
    $trail->push('Task');
    $trail->push('Create');
});



// projects.task.show
Breadcrumbs::for('project.task.show', function (BreadcrumbTrail $trail, $project,$task) {
    $trail->push('Project', route('project.index'));
    $trail->push($project->project_name, route('project.show', ['project' => $project->hashid]));
    $trail->push('Task',  route('project.task.show', ['project' => $project->hashid, 'task' => $task->hashid]));
    $trail->push($task->task_name);

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
