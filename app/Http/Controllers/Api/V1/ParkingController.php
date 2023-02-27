<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ParkingResource;
use App\Models\Parking;
use App\Models\Vehicle;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ParkingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function start(Request $request)
    {
        $parkingData = $request->validate([

            'vehicle_id' => [
                'required', 'integer',

                Rule::unique('parkings')->where(function ($query) {
                    return $query->where('end_time', null);
                }),

                function ($attribute, $value, $fail) {
                    $exists = Vehicle::find($value);

                    if (!$exists) {
                        $fail('That car is not your');
                    }
                },
            ],

            'zone_id' => ['required', 'integer', 'exists:zones,id'],
        ]);

        $parking = Parking::create($parkingData);
        $parking->load('vehicle', 'zone');

        return ParkingResource::make($parking);
    }

    /**
     * Display the specified resource.
     */
    public function show(Parking $parking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Parking $parking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Parking $parking)
    {
        //
    }
}
