<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
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

Route::get('report' , [ReportController::class,'index'])->name('report');


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
        'tools' => ToolController::class,
        'tickets' => TicketController::class,
        'report' => ReportController::class,

    ]);

    Route::post('events/{event}/sendConfirmMail', [EventController::class, 'sendConfirmMail'])->name('events.sendConfirmMail');
    Route::post('events/{event}/sendDismissMail', [EventController::class, 'sendDismissMail'])->name('events.sendDismissMail');
});
