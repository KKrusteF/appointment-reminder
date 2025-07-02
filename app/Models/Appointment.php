<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use App\Observers\AppointmentObserver;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\QueryBuilderBindable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(AppointmentObserver::class)]
class Appointment extends Model
{
    use QueryBuilderBindable;

    protected $fillable = [
        'number',
        'user_id',
        'client_id',
        'title',
        'notes',
        'start_time',
        'end_time',
        'timezone',
        'recurrence_rule',
        'reminder_offset_minutes',
        'status'
    ];

    protected $attributes = [
        'timezone' => 'UTC',
        'status'   => AppointmentStatus::Scheduled
    ];

    protected function casts(): array
    {
        return [
            'status' => AppointmentStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function reminderDispatches(): HasMany
    {
        return $this->hasMany(ReminderDispatch::class);
    }
}
