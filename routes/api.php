<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'json.response', 'prefix' => config('app.version')], function () {
    // auth routes from modules\auth.php
    Route::prefix('auth')->group(base_path('routes/modules/auth.php'));
    // tasks routes from modules\tasks.php
    Route::prefix('tasks')->group(base_path('routes/modules/tasks.php'));
    // statuses routes from modules\statuses.php
    Route::prefix('statuses')->group(base_path('routes/modules/statuses.php'));
    // users routes from modules\users.php
    Route::prefix('users')->group(base_path('routes/modules/users.php'));
});