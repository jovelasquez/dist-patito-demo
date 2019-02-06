<?php

use Illuminate\Http\Request;
use App\Http\Middleware\AvailableHours;
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
Route::group(['namespace' => 'Api', 'middleware' => ['auth.api', 'available.hours']], function () {
    
    // Auth
    Route::post('auth/login', 'AuthController@login');
    Route::match(['put', 'patch'], 'auth/logout', 'AuthController@logout');

    // Module Distribuidor
    Route::resource('distributors', 'DistributorController', [
        'only' => [
            'index', 'store', 'update', 'destroy'
        ]
    ]);
    Route::get('distributors/{date}/tasks', 'DistributorController@report');

    // Module Tareas
    Route::resource('tasks', 'TaskController', [
        'only' => [
            'index', 'store', 'update', 'destroy'
        ]
    ]);

});