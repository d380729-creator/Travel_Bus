<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['bus', 'route'])->get();
        return response()->json([
            'success' => true,
            'data' => $schedules
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'route_id' => 'required|exists:routes,id',
            'waktu_keberangkatan' => 'required|date',
            'waktu_kedatangan' => 'required|date',
            'kursi_tersedia' => 'required|integer',
            'harga' => 'required|numeric'
        ]);

        $schedule = Schedule::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil ditambahkan',
            'data' => $schedule
        ], 201);
    }
}
