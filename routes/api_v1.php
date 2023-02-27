<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ParkingController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\VehicleController;
use App\Http\Controllers\Api\V1\VehileController;
use App\Http\Controllers\Api\V1\ZoneController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('signup', [AuthController::class, 'signup']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    Route::controller(ProfileController::class)->group(function() {
        Route::get('profile', 'show');
        Route::put('profile', 'updateInfo');
        Route::put('password', 'updatePassword');
    });
   

    Route::post('auth/logout', [AuthController::class, 'logout']);


    Route::apiResources([
        'vehicles' => VehicleController::class,
    ]);

    Route::post('parking/start', [ParkingController::class, 'start']);
    Route::post('parking/stop', [ParkingController::class, 'stop']);
    
});


Route::get('zones', [ZoneController::class, 'index']);