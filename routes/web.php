<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\PostCondition;

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

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/create', [PostController::class, 'create'])->name('create');
Route::post('/create.store', [PostController::class, 'create_store'])->name('create.store');
Route::get('/post/show/{id}', [PostController::class, 'post_show'])->name('post.show');

Route::delete('delete/{id}', [PostController::class, 'delete'])->name('delete');
Route::get('/post/edit/{id}', [PostController::class, 'post_edit'])->name('post.edit');
Route::post('/post/update/{id}', [PostController::class, 'update'])->name('post.update');


//softdelete er route
Route::get('/soft-delete', [PostController::class, 'softDelete'])->name('soft-delete');
Route::delete('/force/delete/{id}', [PostController::class, 'forceDelete'])->name('force.delete');
Route::get('/soft/restor/{id}', [PostController::class, 'restore'])->name('soft.restor');
