<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\WordexcelController;
use App\Http\Controllers\Post;
use App\Http\Controllers\order;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SortableController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ExpensesController;
/*
| Core Route
 */

require __DIR__ . '/core.php';

/*
| App Route
 */
Route::group(['middleware' => ['role:user', 'get.menu']], function () {

    /*   //Project
    Route::get('/contract/{project}/create', [ContractController::class, 'create'])->name('contract.create');
    Route::get('/project/gantt', [ProjectController::class, 'gantt'])->name('project.gantt');
    Route::get('/project/{project}/task/create', [ProjectController::class, 'taskCreate'])->name('project.task.create');
    Route::post('/project/{project}/task/create', [ProjectController::class, 'taskStore'])->name('project.task.store');
    Route::get('/project/{project}/task/createsub', [ProjectController::class, 'taskCreateSub'])->name('project.task.createsub');
    Route::post('/project/{project}/task/createsub', [ProjectController::class, 'taskStore'])->name('project.task.store');
    //Route::get('/project/{project}/task/{task}/createsub', [ProjectController::class, 'taskCreateSub'])->name('project.task.createsub');
    Route::get('/project/{project}/task/{task}/createsub', [ProjectController::class, 'taskCreateSub'])->name('project.task.createsub');
    Route::get('/project/{project}/task/{task}/editsub', [ProjectController::class, 'taskEditSub'])->name('project.task.editsub');
//    Route::get('/project/{projectHashid}/task/{taskHashid}/createsub', [ProjectController::class, 'taskCreateSub'])->name('project.task.createsub');
  //  Route::get('/project/{projectHashid}/task/{taskHashid}/editsub', [ProjectController::class, 'taskEditSub'])->name('project.task.editsub');
   Route::get('/project/{project}/task/{task}/edit', [ProjectController::class, 'taskEdit'])->name('project.task.edit');
   Route::get('/project/{project}/task/{task}/editsub', [ProjectController::class, 'taskEditSub'])->name('project.task.editsub');
   Route::get('/project/{project}/task/{task}', [ProjectController::class, 'taskShow'])->name('project.task.show');
    Route::PUT('/project/{project}/task/{task}/update', [ProjectController::class, 'taskUpdate'])->name('project.task.update');
    Route::DELETE('/project/{project}/task/{task}/destroy', [ProjectController::class, 'taskDestroy'])->name('project.task.destroy');
    Route::resource('project', ProjectController::class);
    //  Route::get('/project/{project}/task/editsub', [ProjectController::class, 'taskEditSub'])->name('project.task.editsub');
    Route::post('/project/{project}/task/editsub', [ProjectController::class, 'taskStore'])->name('project.task.store');
    //Contract
    Route::resource('contract', ContractController::class);
    Route::post('/contract/{contract}/task/create', [ContractController::class,'taskconstore'])->name('contract.task.store');
    Route::get('/contract/{contract}/task/create', [ContractController::class, 'taskconCreate'])->name('contract.task.create');
    Route::get('/contract/{contract}/task/{taskcon}/edit', [ContractController::class, 'taskconEdit'])->name('contract.task.edit');
    Route::PUT('/contract/{contract}/task/{taskcon}/update', [ContractController::class, 'taskconUpdate'])->name('contract.task.update');
    Route::DELETE('/contract/{contract}/task/{taskcon}/destroy', [ContractController::class, 'taskconDestroy'])->name('contract.task.destroy');
    Route::get('/contract/{contract}/task/{taskcon}', [ContractController::class, 'taskconShow'])->name('contract.task.show');
    */
    // Project

    Route::resource('project', ProjectController::class);
    Route::get('/project/{project}/task/createcn', [ProjectController::class, 'taskCreatecn'])->name('project.task.createcn');
    Route::get('/project/{project}/task/createsubno', [ProjectController::class, 'taskCreatesubno'])->name('project.task.createsubno');


    Route::get('/project/gantt', [ProjectController::class, 'gantt'])->name('project.gantt');





    Route::get('/project/{project}/task/create', [ProjectController::class, 'taskCreate'])->name('project.task.create');
    Route::post('/project/{project}/task/create', [ProjectController::class, 'taskStore'])->name('project.task.store');


    Route::get('/project/{project}/task/createsubno', [ProjectController::class, 'taskCreatesubno'])->name('project.task.createsubno');
    Route::post('/project/{project}/task/createsubno', [ProjectController::class, 'taskStoresubno'])->name('project.task.storesubno');






    Route::get('/project/createsubno', [ProjectController::class, 'CreateSubno'])->name('project.createsubno');
    Route::post('/project/storesubno', [ProjectController::class, 'Storesubno'])->name('project.storesubno');

    Route::get('/project/createsub', [ProjectController::class, 'CreateSub'])->name('project.createsub');

    Route::post('/project/storesub', [ProjectController::class, 'Storesub'])->name('project.storesub');



    Route::post('/project/{project}/task/store', [ProjectController::class, 'taskStore'])->name('project.task.store');
    Route::get('/project/{project}/task/{task}/edit', [ProjectController::class, 'taskEdit'])->name('project.task.edit');
    Route::put('/project/{project}/task/{task}/update', [ProjectController::class, 'taskUpdate'])->name('project.task.update');
    Route::delete('/project/{project}/task/{task}/destroy', [ProjectController::class, 'taskDestroy'])->name('project.task.destroy');
    Route::get('/project/{project}/task/{task}', [ProjectController::class, 'taskShow'])->name('project.task.show');

    Route::get('/project/{project}/task/{task}/editsubno', [ProjectController::class, 'taskEditSubno'])->name('project.task.editsubno');
    Route::get('/project/{project}/task/{task}/editsub', [ProjectController::class, 'taskEditSub'])->name('project.task.editsub');



//  Route::post('/project/{project}/task/createsub', [ProjectController::class, 'taskStoresub'])->name('project.task.storesub');
    //Route::post('/project/{project}/task/createsubno', [ProjectController::class, 'taskStoresubno'])->name('project.task.storesubno');




   // Route::post('/project/{project}/task/storesubno', [ProjectController::class, 'taskStoresubno'])->name('project.task.storesubno');



    Route::get('/project/{project}/task/{task}/createsub', [ProjectController::class, 'taskCreateSub'])->name('project.task.createsub');
    Route::post('/project/{project}/task/{task}/storesub', [ProjectController::class, 'taskStoreSub'])->name('project.task.storesub');


    //Route::get('/project/{project}/task/{task}/createsub', [ProjectController::class, 'taskCreateSub'])->name('project.task.createsub');

    Route::get('/project/{project}/task/{task}/createto', [ProjectController::class, 'taskCreateTo'])->name('project.task.createto');
    Route::post('/project/{project}/task/{task}/storeto', [ProjectController::class, 'taskStoreTo'])->name('project.task.storeTo');

    Route::get('/project/{project}/task/{task}/createsubnop', [ProjectController::class, 'taskCreateSubnop'])->name('project.task.createsubnop');
    Route::post('/project/{project}/task/{task}/storesubnop', [ProjectController::class, 'taskStoreSubnop'])->name('project.task.storesubnop');


    Route::get('/project/view/{project}', [ProjectController::class, 'view'])->name('project.view');
















    // Contract
    Route::resource('contract', ContractController::class);
    Route::get('/contract/modal', [ContractController::class, 'createModal'])->name('contract.createModal');


    Route::get('/contract/createsubno', [ContractController::class, 'createsubno'])->name('contract.createsubno');



    /* Route::get('/contract/{contract}/task/create', [ContractController::class, 'taskCreate'])->name('contract.task.create');
Route::post('/contract/{contract}/task/store', [ContractController::class, 'taskStore'])->name('contract.task.store');
Route::get('/contract/{contract}/task/{task}/edit', [ContractController::class, 'taskEdit'])->name('contract.task.edit');
Route::put('/contract/{contract}/task/{task}/update', [ContractController::class, 'taskUpdate'])->name('contract.task.update');
Route::delete('/contract/{contract}/task/{task}/destroy', [ContractController::class, 'taskDestroy'])->name('contract.task.destroy');
Route::get('/contract/{contract}/task/{task}', [ContractController::class, 'taskShow'])->name('contract.task.show'); */

    Route::post('/contract/{contract}/task/create', [ContractController::class, 'taskconstore'])->name('contract.task.store');
    Route::get('/contract/{contract}/task/create', [ContractController::class, 'taskconCreate'])->name('contract.task.create');

    Route::get('/contract/{contract}/task/{taskcon}/edit', [ContractController::class, 'taskconEdit'])->name('contract.task.edit');
    Route::PUT('/contract/{contract}/task/{taskcon}/update', [ContractController::class, 'taskconUpdate'])->name('contract.task.update');
    Route::DELETE('/contract/{contract}/task/{taskcon}/destroy', [ContractController::class, 'taskconDestroy'])->name('contract.task.destroy');
    Route::get('/contract/{contract}/task/{taskcon}', [ContractController::class, 'taskconShow'])->name('contract.task.show');


    Route::resource('expenses', ExpensesController::class);
    //Route::post('/expensrs', [ExpensrController::class, 'store'])->name('expensrs.store');

    Route::get('/expenses/createsubno', [ExpensesController::class, 'createsubno'])->name('expenses.createsubno');
    // routes/web.php

    Route::get('/contract/getdata', [ContractController::class, 'getData'])->name('contract.getdata');



    /* Route::get('/contract/{contract}/task/create', [ContractController::class, 'taskCreate'])->name('contract.task.create');
Route::post('/contract/{contract}/task/store', [ContractController::class, 'taskStore'])->name('contract.task.store');
Route::get('/contract/{contract}/task/{task}/edit', [ContractController::class, 'taskEdit'])->name('contract.task.edit');
Route::put('/contract/{contract}/task/{task}/update', [ContractController::class, 'taskUpdate'])->name('contract.task.update');
Route::delete('/contract/{contract}/task/{task}/destroy', [ContractController::class, 'taskDestroy'])->name('contract.task.destroy');
Route::get('/contract/{contract}/task/{task}', [ContractController::class, 'taskShow'])->name('contract.task.show'); */

    Route::post('/expenses/{contract}/task/create', [ExpensesController::class, 'taskconstore'])->name('expenses.task.store');
    Route::get('/expenses/{contract}/task/create', [ExpensesController::class, 'taskconCreate'])->name('expenses.task.create');

    Route::get('/expenses/{contract}/task/{taskcon}/edit', [ExpensesController::class, 'taskconEdit'])->name('expenses.task.edit');
    Route::PUT('/expenses/{contract}/task/{taskcon}/update', [ExpensesController::class, 'taskconUpdate'])->name('expenses.task.update');
    Route::DELETE('/expenses/{contract}/task/{taskcon}/destroy', [ExpensesController::class, 'taskconDestroy'])->name('expenses.task.destroy');
    Route::get('/expenses/{contract}/task/{taskcon}', [ExpensesController::class, 'taskconShow'])->name('expenses.task.show');

    // localhost/laravel-report/pdf
    Route::get('/pdf', [PdfController::class, 'index'])->name('pdf');

    // localhost/laravel-report/pdf/ex1
    Route::get('/pdf/ex1', [PdfController::class, 'ex1'])->name('pdfex1');
    // localhost/laravel-report/pdf/ex2
    Route::get('/pdf/ex2', [PdfController::class, 'ex2'])->name('pdfex2');
    // localhost/laravel-report/pdf/ex3
    Route::get('/pdf/ex3', [PdfController::class, 'ex3'])->name('pdfex3');
    // localhost/laravel-report/pdf/ex4
    Route::get('/pdf/ex4', [PdfController::class, 'ex4'])->name('pdfex4');

    //word excel route
    // localhost/laravel-report/exports
    Route::get('/export', [WordExcelController::class, 'index'])->name('export.index');
    // localhost/laravel-report/export/msword
    Route::get('/export/msword', [WordExcelController::class, 'exportMSWord'])->name('export.msword');

    // localhost/laravel-report/export/excelcsv
    Route::get('/export/excelcsv', [WordExcelController::class, 'exportExcelCSV'])->name('export.excelcsv');
    // localhost/laravel-report/import/excelcsv
    Route::get('/import/excelcsv', [WordExcelController::class, 'importExcelCSV'])->name('import.excelcsv');

    //gen Chart
    // localhost/laravel-report/genchart
    Route::get('/genchart', [WordExcelController::class, 'genChart'])->name('genchart');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('/dashboard', [DashboardController::class, 'index'])->name('dashboard.post');

    Route::get('/dashboard/gantt', [DashboardController::class, 'gantt'])->name('dashboard.gantt');
    Route::post('/dashboard/gantt', [DashboardController::class, 'gantt'])->name('dashboard.post');




    //Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.gantt');



    //wordexcel


    //Route::get('/sortable', [SortableController::class, 'index'])->name('sortable.index');
    //Route::post('/sortable/updateorder', [SortableController::class, 'updateOrder'])->name('sortable.updateorder');

    Route::get('/sortable', [SortableController::class, 'index'])->name('sortable.index');
    Route::post('/sortable/updateorder', [SortableController::class, 'updateOrder'])->name('sortable.updateorder');
    Route::get('/sortable/sortable-list', [SortableController::class, 'index'])->name('sortable.index');

    Route::get('/sortable/Custom', 'App\Http\Controllers\ordersController@index');
    Route::post('Custom-sortable', 'App\Http\Controllers\ordersController@update');










    Route::get('/sortable/post', 'App\Http\Controllers\PostController@index');
    Route::post('post-sortable', 'App\Http\Controllers\PostController@update');
});
