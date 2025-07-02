<?php

namespace App\Http\Actions;

use RRule\RRule;
use DateTimeZone;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Appointment;
use Carbon\CarbonImmutable;
use App\Jobs\SendAppointmentReminder;

class ScheduleAppointmentRemindersAction
{
    public function execute(Appointment $appointment): void
    {
        $client = $appointment->client;
        if (!$client) {
            return;
        }

        $offset = $appointment->reminder_offset_minutes ?? config('app.reminders.offset');
        $timezone = new DateTimeZone($client->timezone);
        $now = now($timezone);

        if ($appointment->recurrence_rule) {
            $rrule = new RRule([
                'RULE'    => $appointment->recurrence_rule,
                'DTSTART' => $appointment->start_time->setTimezone($timezone),
            ]);

            foreach ($rrule as $occurrence) {
                $occurrence = Carbon::instance($occurrence)->setTimezone($timezone);

                if ($occurrence <= $now) {
                    continue;
                }

                $reminderTime = $occurrence->subMinutes($offset);

                $reminder = $appointment->reminderDispatches()->create([
                    'client_id'     => $client->id,
                    'scheduled_for' => $reminderTime,
                ]);

                SendAppointmentReminder::dispatch($appointment, $client, $occurrence, $reminder->id)
                    ->delay($reminderTime->setTimezone('UTC'));
            }
        } else {
            $start = CarbonImmutable::parse($appointment->start_time)->setTimezone($timezone);
            $reminderTime = $start->subMinutes($offset);

            if ($reminderTime > $now) {
                $reminder = $appointment->reminderDispatches()->create([
                    'client_id'     => $client->id,
                    'scheduled_for' => $reminderTime,
                ]);

                SendAppointmentReminder::dispatch($appointment, $client, $start, $reminder->id)
                    ->delay($reminderTime->setTimezone('UTC'));
            }
        }
    }
}
