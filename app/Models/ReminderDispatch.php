<?php

namespace App\Models;

use App\Enums\ReminderPreference;
use App\Enums\ReminderDispatchStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReminderDispatch extends Model
{
    protected $fillable = [
        'appointment_id',
        'client_id',
        'scheduled_for',
        'sent_at',
        'status',
        'notes',
        'error_message',
        'reminder_via'
    ];

    protected $attributes = [
        'status'       => ReminderDispatchStatus::Scheduled,
        'reminder_via' => ReminderPreference::Both
    ];

    protected function casts(): array
    {
        return [
            'status'       => ReminderDispatchStatus::class,
            'reminder_via' => ReminderPreference::class
        ];
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
