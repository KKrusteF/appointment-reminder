<?php

namespace App\Http\Actions;

use App\Models\Appointment;

class CreateAppointmentAction
{
    public function execute(array $attributes): Appointment
    {
        $user = auth()->user();

        return $user->appointments()->create($attributes);
    }
}
