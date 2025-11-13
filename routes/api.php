<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BusController;
use App\Http\Controllers\Api\RouteController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\TerminalController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AdminAuthController;

Route::get('/buses', [BusController::class, 'index']);
Route::post('/buses', [BusController::class, 'store']);

Route::get('/routes', [RouteController::class, 'index']);
Route::post('/routes', [RouteController::class, 'store']);

Route::get('/schedules', [ScheduleController::class, 'index']);
Route::post('/schedules', [ScheduleController::class, 'store']);

Route::get('/bookings', [BookingController::class, 'index']);
Route::post('/bookings', [BookingController::class, 'store']);

Route::put('/buses/{id}', [BusController::class, 'update']);
Route::delete('/buses/{id}', [BusController::class, 'destroy']);

Route::put('/routes/{id}', [RouteController::class, 'update']);
Route::delete('/routes/{id}', [RouteController::class, 'destroy']);

Route::put('/schedules/{id}', [ScheduleController::class, 'update']);
Route::delete('/schedules/{id}', [ScheduleController::class, 'destroy']);

Route::put('/bookings/{id}', [BookingController::class, 'update']);
Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);

Route::apiResource('terminals', TerminalController::class);
Route::get('/terminals/by-city', [TerminalController::class, 'getByCity']);


Route::patch('schedules/{id}/status', [ScheduleController::class, 'updateStatus']);


Route::prefix('admin')->group(function () {
    Route::post('/register', [AdminAuthController::class, 'register']);
    Route::post('/login', [AdminAuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AdminAuthController::class, 'profile']);
    Route::post('/logout', [AdminAuthController::class, 'logout']);
    Route::get('/list', [AdminAuthController::class, 'index']);
    Route::delete('/{id}', [AdminAuthController::class, 'destroy']);
    });
});


