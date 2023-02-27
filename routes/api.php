<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

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

Route::apiResource('/roles', RoleController::class);
Route::apiResource('/vehiculos', VehicleController::class);
Route::apiResource('/addresses', AddressController::class);
Route::apiResource('/users', UserController::class);
