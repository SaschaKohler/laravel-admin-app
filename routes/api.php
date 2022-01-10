<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MonsterChildController;
use App\Http\Controllers\MonsterController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;
use Okami101\LaravelAdmin\Http\Middleware\Impersonate;

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
    Route::account();
    Route::impersonate();
    Route::upload();

    /**
     * API resources controllers
     */
    Route::apiResources([
        'users' => UserController::class,

        'events' => EventController::class,
        'customers' => CustomerController::class,
        'vehicles' => VehicleController::class,
        'statistics' => StatisticsController::class,
        'tools' => ToolController::class,
    ]);
});
