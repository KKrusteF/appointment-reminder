<?php

namespace App\Http\Actions;

use App\Models\Appointment;

class UpdateAppointmentAction
{
    public function execute(array $attributes, Appointment $appointment): Appointment
    {
        $appointment->update($attributes);

        return $appointment->refresh();
    }
}
