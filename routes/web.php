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
/*
| Core Route
 */
require __DIR__ . '/core.php';

/*
| App Route
 */
Route::group(['middleware' => ['role:user', 'get.menu']], function () {

    //Project
Route::get('/contract/{project}/create', [ContractController::class, 'create'])->name('contract.create');



    Route::get('/project/gantt', [ProjectController::class, 'gantt'])->name('project.gantt');
    Route::get('/project/{project}/task/create', [ProjectController::class, 'taskCreate'])->name('project.task.create');
    Route::post('/project/{project}/task/create', [ProjectController::class, 'taskStore'])->name('project.task.store');


    Route::get('/project/{project}/task/createsub', [ProjectController::class, 'taskCreateSub'])->name('project.task.createsub');
    Route::post('/project/{project}/task/createsub', [ProjectController::class, 'taskStore'])->name('project.task.store');

Route::get('/project/{projectHashid}/task/{taskHashid}/createsub', [ProjectController::class, 'taskCreateSub'])->name('project.task.createsub');


    Route::get('/project/{project}/task/{task}/edit', [ProjectController::class, 'taskEdit'])->name('project.task.edit');
    Route::PUT('/project/{project}/task/{task}/update', [ProjectController::class, 'taskUpdate'])->name('project.task.update');
    Route::DELETE('/project/{project}/task/{task}/destroy', [ProjectController::class, 'taskDestroy'])->name('project.task.destroy');
    Route::get('/project/{project}/task/{task}', [ProjectController::class, 'taskShow'])->name('project.task.show');

    Route::resource('project', ProjectController::class);

    //Contract
    Route::resource('contract', ContractController::class);
    Route::post('/contract/{contract}/task/create', [ContractController::class,'taskconstore'])->name('contract.task.store');
    Route::get('/contract/{contract}/task/create', [ContractController::class, 'taskconCreate'])->name('contract.task.create');





    Route::get('/contract/{contract}/task/{taskcon}/edit', [ContractController::class, 'taskconEdit'])->name('contract.task.edit');
    Route::PUT('/contract/{contract}/task/{taskcon}/update', [ContractController::class, 'taskconUpdate'])->name('contract.task.update');
    Route::DELETE('/contract/{contract}/task/{taskcon}/destroy', [ContractController::class, 'taskconDestroy'])->name('contract.task.destroy');
    Route::get('/contract/{contract}/task/{taskcon}', [ContractController::class, 'taskconShow'])->name('contract.task.show');

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
//wordexcel


//Route::get('/sortable', [SortableController::class, 'index'])->name('sortable.index');
//Route::post('/sortable/updateorder', [SortableController::class, 'updateOrder'])->name('sortable.updateorder');

Route::get('/sortable', [SortableController::class, 'index'])->name('sortable.index');
Route::post('/sortable/updateorder', [SortableController::class, 'updateOrder'])->name('sortable.updateorder');
Route::get('/sortable/sortable-list', [SortableController::class, 'index'])->name('sortable.index');

Route::get('/sortable/Custom','App\Http\Controllers\ordersController@index');
Route::post('Custom-sortable','App\Http\Controllers\ordersController@update');










Route::get('/sortable/post','App\Http\Controllers\PostController@index');
Route::post('post-sortable','App\Http\Controllers\PostController@update');

});
