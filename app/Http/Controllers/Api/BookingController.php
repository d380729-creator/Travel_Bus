<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        // sekarang ada relationship schedule() di model
        $bookings = Booking::with('schedule')->get();
        return response()->json([
            'success' => true,
            'data' => $bookings
        ], 200);
    }

   public function store(Request $request)
{
    // 1️⃣ Validasi input
    $validated = $request->validate([
        'schedule_id' => 'required|exists:schedules,id',
        'nama_penumpang' => 'required|string|max:255',
        'email_penumpang' => 'required|email',
        'telepon_penumpang' => 'required|string|max:20',
        'jumlah_kursi' => 'required|integer|min:1',
        'jumlah_total' => 'required|numeric',
        'status' => 'in:pending,confirmed,cancelled',
        'notes' => 'nullable|string'
    ]);

    // 2️⃣ Ambil schedule terkait
    $schedule = \App\Models\Schedule::find($validated['schedule_id']);

    // 3️⃣ Cek apakah kursi cukup
    if ($schedule->kursi_tersedia < $validated['jumlah_kursi']) {
        return response()->json([
            'success' => false,
            'message' => 'Maaf, kursi tidak cukup tersedia',
        ], 400);
    }

    // 4️⃣ Generate kode pemesanan unik
    $validated['kode_pemesanan'] = 'BOOK-' . strtoupper(uniqid());

    // 5️⃣ Buat booking
    $booking = Booking::create($validated);

    // 6️⃣ Kurangi kursi tersedia di schedule
    $schedule->decrement('kursi_tersedia', $validated['jumlah_kursi']);

    return response()->json([
        'success' => true,
        'message' => 'Pemesanan berhasil dibuat',
        'data' => $booking
    ], 201);
}


    public function update(Request $request, $id)
{
    $booking = Booking::find($id);

    if (!$booking) {
        return response()->json([
            'success' => false,
            'message' => 'Pemesanan tidak ditemukan',
        ], 404);
    }

    $validated = $request->validate([
        'jadwal_id' => 'sometimes|required|exists:schedules,id',
        'nama_penumpang' => 'sometimes|required|string|max:255',
        'email_penumpang' => 'sometimes|required|email',
        'telepon_penumpang' => 'sometimes|required|string|max:20',
        'jumlah_kursi' => 'sometimes|required|integer|min:1',
        'jumlah_total' => 'sometimes|required|numeric',
        'status' => 'in:pending,confirmed,cancelled',
        'notes' => 'nullable|string',
    ]);

    $booking->update($validated);

    return response()->json([
        'success' => true,
        'message' => 'Pemesanan berhasil diperbarui',
        'data' => $booking,
    ], 200);
}

public function destroy($id)
{
    $booking = Booking::find($id);

    if (!$booking) {
        return response()->json([
            'success' => false,
            'message' => 'Pemesanan tidak ditemukan',
        ], 404);
    }

    $booking->delete();

    return response()->json([
        'success' => true,
        'message' => 'Pemesanan berhasil dihapus',
    ], 200);
}

}
