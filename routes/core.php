<?php

use App\Http\Controllers\Core\LanguageController;
use App\Http\Controllers\Core\LocaleController;
use App\Http\Controllers\Core\MenuController;
use App\Http\Controllers\Core\MenuElementController;
use App\Http\Controllers\Core\RolesController;
use App\Http\Controllers\Core\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Core Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

/*
| Global Route
 */
Route::get('/404', function () {return view('layouts.template.404');});
Route::get('/500', function () {return view('layouts.template.500');});
Route::get('/', function () {
    if (Auth::user()) {
        return redirect('dashboard');
    } else {
        return redirect('login');
    }
});

/*
| Auth Route
 */
require __DIR__ . '/auth.php';

/*
| Admin Route
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['role:admin', 'get.menu']], function () {
    Route::resource('users', UsersController::class);
    Route::resource('languages', LanguageController::class);
    Route::resource('roles', RolesController::class);
    Route::get('/roles/move/move-up', [RolesController::class, 'moveUp'])->name('roles.up');
    Route::get('/roles/move/move-down', [RolesController::class, 'moveDown'])->name('roles.down');
    Route::prefix('menu/element')->group(function () {
        Route::get('/', [MenuElementController::class, 'index'])->name('menu.index');
        Route::get('/move-up', [MenuElementController::class, 'moveUp'])->name('menu.up');
        Route::get('/move-down', [MenuElementController::class, 'moveDown'])->name('menu.down');
        Route::get('/create', [MenuElementController::class, 'create'])->name('menu.create');
        Route::post('/store', [MenuElementController::class, 'store'])->name('menu.store');
        Route::get('/get-parents', [MenuElementController::class, 'getParents']);
        Route::get('/edit', [MenuElementController::class, 'edit'])->name('menu.edit');
        Route::post('/update', [MenuElementController::class, 'update'])->name('menu.update');
        Route::get('/show', [MenuElementController::class, 'show'])->name('menu.show');
        Route::get('/delete', [MenuElementController::class, 'delete'])->name('menu.delete');
    });
    Route::prefix('menu/menu')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('menu.menu.index');
        Route::get('/create', [MenuController::class, 'create'])->name('menu.menu.create');
        Route::post('/store', [MenuController::class, 'store'])->name('menu.menu.store');
        Route::get('/edit', [MenuController::class, 'edit'])->name('menu.menu.edit');
        Route::post('/update', [MenuController::class, 'update'])->name('menu.menu.update');
        //Route::get('/show',     [MenuController::class, 'show'])->name('menu.menu.show');
        Route::get('/delete', [MenuController::class, 'delete'])->name('menu.menu.delete');
    });

});

Route::get('/locale', [LocaleController::class, 'locale'])->name('locale');

/*
| App Route
 */
Route::middleware(['auth', 'get.menu'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
