<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BusController;
use App\Http\Controllers\Api\RouteController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\BookingController;

Route::get('/buses', [BusController::class, 'index']);
Route::post('/buses', [BusController::class, 'store']);

Route::get('/routes', [RouteController::class, 'index']);
Route::post('/routes', [RouteController::class, 'store']);

Route::get('/schedules', [ScheduleController::class, 'index']);
Route::post('/schedules', [ScheduleController::class, 'store']);

Route::get('/bookings', [BookingController::class, 'index']);
Route::post('/bookings', [BookingController::class, 'store']);
