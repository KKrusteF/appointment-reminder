<?php

namespace App\Enums;

enum ReminderDispatchStatus: string
{
    case Scheduled = 'scheduled';
    case Sent = 'sent';
    case Failed = 'failed';
    case Cancelled = 'cancelled';
}
