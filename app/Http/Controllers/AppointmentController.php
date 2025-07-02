<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Queries\AppointmentQuery;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\AppointmentResource;
use App\Http\Resources\AppointmentCollection;
use App\Http\Actions\CreateAppointmentAction;
use App\Http\Actions\UpdateAppointmentAction;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AppointmentQuery $query): AppointmentCollection
    {
        $query->where('user_id', auth()->id());

        return new AppointmentCollection($query->paginated());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request, CreateAppointmentAction $action): AppointmentResource
    {
        $appointment = $action->execute($request->validated());

        return new AppointmentResource($appointment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment): AppointmentResource
    {
        return new AppointmentResource($appointment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment, UpdateAppointmentAction $action): AppointmentResource
    {
        $appointment = $action->execute($request->validated(), $appointment);

        return new AppointmentResource($appointment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment): JsonResponse
    {
        $appointment->delete();

        return response()->json(status: 204);
    }
}
