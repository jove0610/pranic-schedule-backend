<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\UserController;
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

Route::post('auth/login', [AuthController::class, 'login']);

Route::apiResource('countries', CountryController::class)->only(['index', 'show']);
Route::apiResource('courses', CourseController::class)->only(['index', 'show']);
Route::apiResource('offices', OfficeController::class)->only(['index', 'show']);
Route::apiResource('schedules', ScheduleController::class)->only(['index', 'show']);
Route::apiResource('states', StateController::class)->only(['index', 'show']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/user', [AuthController::class, 'user']);
    Route::apiResource('schedules', ScheduleController::class)->except(['index', 'show']);

    Route::group(['middleware' => 'is.admin'], function () {
        Route::apiResource('countries', CountryController::class)->except(['index', 'show']);
        Route::apiResource('courses', CourseController::class)->except(['index', 'show']);
        Route::apiResource('offices', OfficeController::class)->except(['index', 'show']);
        Route::apiResource('states', StateController::class)->except(['index', 'show']);
        Route::apiResource('users', UserController::class);
    });
});
