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

use App\Http\Controllers\IotController;

Route::post('/update-drainage', [IotController::class, 'receiveData']);



use App\Http\Controllers\Api\SensorDataController;

Route::post('/sensor-data', [SensorDataController::class, 'store']);

//route for the GPS module:
Route::post('/update-location', [SensorDataController::class, 'updateLocation']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
