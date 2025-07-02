<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReminderDispatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'scheduled_for' => $this->scheduled_for,
            'dispatched_at' => $this->dispatched_at,
            'status'        => $this->status,
            'appointment'   => new AppointmentResource($this->whenLoaded('appointment')),
            'client'        => new ClientResource($this->whenLoaded('client')),
        ];
    }
}
