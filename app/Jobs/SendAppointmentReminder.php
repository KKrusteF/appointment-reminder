<?php

namespace App\Jobs;

use Throwable;
use DateTimeZone;
use App\Models\Client;
use DateTimeInterface;
use App\Models\Appointment;
use Illuminate\Support\Carbon;
use App\Models\ReminderDispatch;
use Illuminate\Support\Facades\Log;
use App\Enums\ReminderDispatchStatus;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendAppointmentReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Appointment       $appointment,
        protected Client            $client,
        protected DateTimeInterface $occurrenceTime,
        protected ReminderDispatch  $reminderDispatch,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->reminderDispatch) {
            return;
        }

        $this->reminderDispatch->update([
            'status'  => ReminderDispatchStatus::Sent,
            'sent_at' => now()
        ]);
        $timezone = new DateTimeZone($this->client->timezone);
        $localTime = Carbon::instance($this->occurrenceTime)->setTimezone($timezone);

        Log::info("Sending reminder to client {$this->client->email} for appointment '{$this->appointment->title}' at {$localTime->format('Y-m-d H:i')} ({$timezone->getName()})");
    }

    /**
     * Handle a job failure.
     */
    public function failed(Throwable $exception): void
    {
        $this->reminderDispatch->update([
            'status'        => 'failed',
            'error_message' => $exception->getMessage(),
        ]);
    }
}
