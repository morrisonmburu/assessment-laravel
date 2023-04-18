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
});