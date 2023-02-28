<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CategoriesController;
use App\Http\Controllers\Api\V1\ParkingController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\VehicleController;
use App\Http\Controllers\Api\V1\VehileController;
use App\Http\Controllers\Api\V1\ZoneController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('signup', [AuthController::class, 'signup']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    Route::post('profile/verify', [AuthController::class, 'verify']);
    Route::get('profile/get-verify-code', [AuthController::class, 'GetVerifyCode']);


    Route::controller(ProfileController::class)->group(function() {
        Route::get('profile', 'show');
        Route::put('profile', 'updateInfo');
        Route::put('password', 'updatePassword');
    });
   

    Route::post('auth/logout', [AuthController::class, 'logout']);
    

    Route::post('parking/start', [ParkingController::class, 'start']);
    Route::post('parking/stop', [ParkingController::class, 'stop']);
    

    Route::middleware('email.verified.token')->group(function () {
        Route::apiResources([
            'vehicles' => VehicleController::class,
        ]);
    });


    Route::get('categories', [CategoriesController::class, 'index']);
    Route::get('categories/{category}', [CategoriesController::class, 'show']);
    // Route::apiResources([
    //     'products' => VehicleController::class,
    // ]);
});







Route::get('zones', [ZoneController::class, 'index']);
