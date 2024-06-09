<?php

use App\Http\Controllers\ListsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('/');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/mylists', [ListsController::class, 'all'])->name('mylists');
    Route::get('/list/show/{id}', [ListsController::class, 'showList'])->name('list.show');
    Route::post('/list/create', [ListsController::class, 'create'])->name('list.create');
    Route::post('/list/delete', [ListsController::class, 'delete'])->name('list.delete');
    Route::post('/list/share', [ListsController::class, 'share'])->name('list.share');
    Route::post('/list/removeShared', [ListsController::class, 'removeShared'])->name('list.removeSharedID');

    Route::post('/list/task/create', [TaskController::class, 'create'])->name('task.create');
    Route::post('/list/task/update', [TaskController::class, 'update'])->name('task.update');
    Route::post('/list/task/addImage', [TaskController::class, 'addImage'])->name('task.addImage');
    Route::post('/list/task/delete', [TaskController::class, 'delete'])->name('task.delete');

    Route::post('/list/task/search', [TaskController::class, 'search'])->name('task.tag.search');
    Route::post('/list/tags/set', [TaskController::class, 'setTag'])->name('task.tag.set');
    Route::post('/list/tags/remove', [TaskController::class, 'removeTag'])->name('task.tag.remove');
});

require __DIR__.'/auth.php';
