<?php

use App\Http\Controllers\JourneyController;
use App\Http\Controllers\VehicleDocumentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDocumentController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QualificationController;
use App\Http\Controllers\TransactionController;

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

Route::post("/login", [AuthController::class, "auth"]);

/**
 * CRUD SERVICES
 */
Route::middleware("auth:sanctum")->group(function () {
  Route::apiResource('/users', UserController::class);
  Route::apiResource('/roles', RoleController::class);
  Route::apiResource('/vehicles', VehicleController::class);
  Route::apiResource('/addresses', AddressController::class);
  Route::apiResource('/userDocuments', UserDocumentController::class);
  Route::apiResource('/accounts', AccountController::class);
  Route::apiResource('/vehiclesDocuments', VehicleDocumentController::class);
  Route::apiResource('/journeys', JourneyController::class);
  Route::apiResource('/transactions', TransactionController::class);
  Route::apiResource('/qualifications', QualificationController::class);
  Route::post("/logout", [AuthController::class, "logout"]);

  Route::get("/journeys/summary", [JourneyController::class, "transactionSummary"]);
  Route::get("/vehiclesDocuments/pendingUsers", [VehicleDocumentController::class, "usersValidateDocs"]);
  Route::get("/vehiclesDocuments/byUser/{userId}/{vehiclePlate}", [VehicleDocumentController::class, "docsToValidateByUser"]);
  Route::get("/userDocuments/pendingUsers", [UserDocumentController::class, "usersValidateDocs"]);
  Route::get("/userDocuments/byUser/{userId}", [UserDocumentController::class, "docsByUser"]);
  Route::get('/qualifications/journey/{journeyId}',  [QualificationController::class, "getByJourney"]);
});
