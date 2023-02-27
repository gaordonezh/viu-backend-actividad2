<?php

use App\Http\Controllers\VehicleDocumentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDocumentController;
use App\Http\Controllers\AccountController;

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
Route::apiResource('/vehicles', VehicleController::class);
Route::apiResource('/addresses', AddressController::class);
Route::apiResource('/users', UserController::class);
Route::apiResource('/userDocuments', UserDocumentController::class);
Route::apiResource('/accounts', AccountController::class);
Route::apiResource('/vehiclesDocuments', VehicleDocumentController::class);
