<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Actions\ProfileAction;
use App\Http\Resources\UserResource;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use App\Http\Actions\Auth\PasswordAction;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): UserResource
    {
        return new UserResource(auth()->user());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfileRequest $request, ProfileAction $action): UserResource
    {
        $profile = $action->execute($request->validated());

        return new UserResource($profile);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(): JsonResponse
    {
        $user = auth()->user();
        $user->delete();

        return response()->json(status: 204);
    }

    public function password(PasswordRequest $request, PasswordAction $action): JsonResponse
    {
        $action->execute($request->validated());

        return response()->json(status: 204);
    }
}
