<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['bus', 'route.asal_terminal', 'route.tujuan_terminal'])->get();

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
        'waktu_kedatangan' => 'required|date|after:waktu_keberangkatan',
        'kursi_tersedia' => 'required|integer|min:1',
        'harga' => 'required|numeric|min:0',
        'status' => 'in:upcoming,ongoing,completed'
    ]);

    // Set default status jika tidak dikirim
    if (!isset($validated['status'])) {
        $validated['status'] = 'upcoming';
    }

    $schedule = Schedule::create($validated);

    return response()->json([
        'success' => true,
        'message' => 'Jadwal berhasil ditambahkan',
        'data' => $schedule
    ], 201);
}


    public function update(Request $request, $id)
{
    $schedule = Schedule::find($id);

    if (!$schedule) {
        return response()->json([
            'success' => false,
            'message' => 'Jadwal tidak ditemukan',
        ], 404);
    }

    $validated = $request->validate([
        'bus_id' => 'sometimes|required|exists:buses,id',
        'route_id' => 'sometimes|required|exists:routes,id',
        'waktu_keberangkatan' => 'sometimes|required|date',
        'waktu_kedatangan' => 'sometimes|required|date',
        'kursi_tersedia' => 'sometimes|required|integer',
        'harga' => 'sometimes|required|numeric',
    ]);

    $schedule->update($validated);

    return response()->json([
        'success' => true,
        'message' => 'Jadwal berhasil diperbarui',
        'data' => $schedule,
    ], 200);
}

public function destroy($id)
{
    $schedule = Schedule::find($id);

    if (!$schedule) {
        return response()->json([
            'success' => false,
            'message' => 'Jadwal tidak ditemukan',
        ], 404);
    }

    $schedule->delete();

    return response()->json([
        'success' => true,
        'message' => 'Jadwal berhasil dihapus',
    ], 200);
}

public function updateStatus(Request $request, $id)
{
    $schedule = Schedule::find($id);

    if (!$schedule) {
        return response()->json([
            'success' => false,
            'message' => 'Jadwal tidak ditemukan',
        ], 404);
    }

    $validated = $request->validate([
        'status' => 'required|in:upcoming,ongoing,completed'
    ]);

    $schedule->update($validated);

    // Jika status completed, update current_location bus
    if ($validated['status'] === 'completed') {
        $schedule->bus->update([
            'current_location' => $schedule->route->tujuan // pastikan route memiliki kolom tujuan
        ]);

        // Opsional: update semua booking jadi completed
        $schedule->bookings()->update(['status' => 'confirmed']); // atau status lain yang sesuai
    }

    return response()->json([
        'success' => true,
        'message' => 'Status perjalanan berhasil diperbarui',
        'data' => $schedule,
    ], 200);
}

public function show($id)
{
    $schedule = Schedule::with('bus', 'route')->find($id);

    if (!$schedule) {
        return response()->json([
            'success' => false,
            'message' => 'Jadwal tidak ditemukan',
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => [
            'schedule' => $schedule,
            'kursi_tersedia' => $schedule->kursi_tersedia
        ],
    ], 200);
}


}
