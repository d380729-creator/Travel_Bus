<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('schedule')->get();
        return response()->json([
            'success' => true,
            'data' => $bookings
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jadwal_id' => 'required|exists:schedules,id',
            'nama_penumpang' => 'required|string|max:255',
            'email_penumpang' => 'required|email',
            'telepon_penumpang' => 'required|string|max:20',
            'jumlah_kursi' => 'required|integer|min:1',
            'jumlah_total' => 'required|numeric',
            'status' => 'in:pending,confirmed,cancelled',
            'notes' => 'nullable|string'
        ]);

        // Generate kode pemesanan unik
        $validated['kode_pemesanan'] = 'BOOK-' . strtoupper(uniqid());

        $booking = Booking::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pemesanan berhasil dibuat',
            'data' => $booking
        ], 201);
    }
}
