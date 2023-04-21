<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tasks\TasksController;
use App\Http\Controllers\Tasks\UserTasksController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('/', TasksController::class);
    Route::get('show/{id}', [TasksController::class, 'show']);
    Route::post('update/{id}', [TasksController::class, 'update']);
    Route::post('delete/{id}', [TasksController::class, 'destroy']);

    Route::group(['prefix' => 'user-tasks'], function () {
        Route::apiResource('/', UserTasksController::class);
        Route::get('/{id}', [UserTasksController::class, 'show']);
        Route::post('update/{id}', [UserTasksController::class, 'update']);
        Route::post('delete/{id}', [UserTasksController::class, 'destroy']);
    });
});