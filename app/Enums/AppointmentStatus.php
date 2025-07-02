<?php

namespace App\Enums;

enum AppointmentStatus: string
{
    case Scheduled = 'scheduled';
    case Completed = 'completed';
    case Canceled = 'canceled';
    case Missed = 'missed';
}
