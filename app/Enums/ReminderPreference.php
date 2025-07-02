<?php

namespace App\Enums;

enum ReminderPreference: string
{
    case Email = 'email';
    case Sms = 'sms';
    case Both = 'both';
}
