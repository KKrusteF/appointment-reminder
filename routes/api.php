<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;

Auth::routes(['verify' => false]);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('profile', ProfileController::class)->only(['index', 'store']);
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('profile/password', [ProfileController::class, 'password'])->name('profile.password');
});

Route::apiResource('appointment', AppointmentController::class);
