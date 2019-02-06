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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['namespace' => 'Api', 'middleware' => ['available.hours']], function () {
    // Auth
    Route::post('auth/login', 'AuthController@login');
    Route::match(['put', 'patch'], 'auth/logout', 'AuthController@logout');

    // Module Distribuidor
    Route::get('distributors', 'DistributorController@index');
    Route::post('distributors', 'DistributorController@store');
    Route::match(['put', 'patch'], 'distributors/{id}', 'DistributorController@update');
    Route::delete('distributors/{id}', 'DistributorController@destroy');

    // Module Tareas
    Route::get('tasks', 'TaskController@index');
    Route::get('tasks/{id}', 'TaskController@show');
    Route::get('tasks/{date}/report', 'TaskController@report');
    Route::post('tasks', 'TaskController@store');
    Route::match(['put', 'patch'], 'tasks/{id}', 'TaskController@update');
    Route::delete('tasks/{id}', 'TaskController@destroy');
});