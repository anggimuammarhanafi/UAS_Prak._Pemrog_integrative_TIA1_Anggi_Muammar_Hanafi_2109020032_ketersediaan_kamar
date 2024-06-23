<?php

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/rooms', App\Http\Controllers\Api\RoomController::class);
Route::apiResource('/patients', App\Http\Controllers\Api\PatientController::class);
Route::apiResource('/bookings', App\Http\Controllers\Api\BookingController::class);