<?php

namespace App\Queries;

use App\Models\Appointment;
use Spatie\QueryBuilder\AllowedFilter;

class AppointmentQuery extends DefaultQuery
{
    /**
     * Define the allowed query builder options.
     */
    public function __construct()
    {
        $appointments = Appointment::query();

        $config = [
            'includes' => [
                'client',
                'reminderDispatches'
            ],
            'sorts'    => [
                'id'         => 'id',
                'start_time' => 'start_time',
                'end_time'   => 'end_time',
                'created_at' => 'created_at',
            ],
            'filters'  => [
                'search'     => AllowedFilter::callback('search', fn($query, $keyword) => $query->whereLike(['title', 'notes'], $keyword)),
                'start_time' => AllowedFilter::callback('start_time', fn($query, $keyword) => $query->whereBetween('start_time', $keyword)),
                'end_time'   => AllowedFilter::callback('end_time', fn($query, $keyword) => $query->whereBetween('end_time', $keyword)),
                'timezone'   => AllowedFilter::exact('timezone'),
                'client_id'  => 'client_id',
                'created_at' => 'created_at',

                'reminder_dispatches.status' => AllowedFilter::exact('reminder_dispatches.status'),
            ],
            'others'   => [
                'per_page' => 'per_page'
            ]
        ];

        parent::__construct($appointments, $config);
    }
}
