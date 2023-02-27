<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParkingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'zone' => [
                'name' => $this->zone->name,
                'price_per_hour' => $this->zone->price_per_hour,
            ],
            'vehicle' => [
                'plate_number' => $this->vehicle->plate_number,
            ],
            'start_time' => $this->start_time->toDateTimeString(),
            'end_time' => $this->end_time?->toDateTimeString(),
            'total_price' => $this->total_price,
            'user_id' => $this->user_id
        ];
    }
}
