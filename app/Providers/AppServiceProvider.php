<?php

namespace App\Providers;

use App\Models\Parking;
use App\Models\Vehicle;
use App\Observers\ParkingObserver;
use App\Observers\VehicleObserver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vehicle::observe(VehicleObserver::class);
        Parking::observe(ParkingObserver::class);
        
        DB::beforeExecuting(function($query, $params) {
            Log::info("$query" . implode(", ", $params));
        });
    }
}
