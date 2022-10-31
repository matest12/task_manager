<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();



Route::group(['middleware' => 'auth'], function () {
  Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

  Route::resource('tasks', TaskController::class)->middleware('can:is-user'); 

  Route::resource('users', App\Http\Controllers\UserController::class)->middleware('can:is-admin');

});
