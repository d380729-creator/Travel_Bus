<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bus;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::all();
        return response()->json([
            'success' => true,
            'data' => $buses
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'plat_nomor' => 'required|string|unique:buses',
            'jumlah_kursi' => 'required|integer',
            'type' => 'required|in:AC,Non-AC,Executive',
            'is_active' => 'boolean'
        ]);

        $bus = Bus::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Bus berhasil ditambahkan',
            'data' => $bus
        ], 201);
    }
    
    public function update(Request $request, $id)
{
    $bus = Bus::find($id);

    if (!$bus) {
        return response()->json([
            'success' => false,
            'message' => 'Bus tidak ditemukan',
        ], 404);
    }

    $validated = $request->validate([
        'nama' => 'sometimes|required|string|max:255',
        'plat_nomor' => 'sometimes|required|string|unique:buses,plat_nomor,' . $bus->id,
        'jumlah_kursi' => 'sometimes|required|integer',
        'type' => 'sometimes|required|in:AC,Non-AC,Executive',
        'is_active' => 'boolean',
    ]);

    $bus->update($validated);

    return response()->json([
        'success' => true,
        'message' => 'Data bus berhasil diperbarui',
        'data' => $bus,
    ], 200);
}

public function destroy($id)
{
    $bus = Bus::find($id);

    if (!$bus) {
        return response()->json([
            'success' => false,
            'message' => 'Bus tidak ditemukan',
        ], 404);
    }

    $bus->delete();

    return response()->json([
        'success' => true,
        'message' => 'Bus berhasil dihapus',
    ], 200);
}
}
