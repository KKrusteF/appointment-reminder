<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                      => $this->id,
            'title'                   => $this->title,
            'description'             => $this->description,
            'start_time'              => $this->start_time,
            'reminder_offset_minutes' => $this->reminder_offset_minutes,
            'recurrence_rule'         => $this->recurrence_rule,
            'client'                  => new ClientResource($this->whenLoaded('client')),
            'created_at'              => $this->created_at,
        ];
    }
}
