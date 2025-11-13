<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Route;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::with(['asal_terminal', 'tujuan_terminal'])->get();

        return response()->json([
           'success' => true,
           'data' => $routes
        ]);
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'asal_terminal_id' => 'required|exists:terminals,id',
        'tujuan_terminal_id' => 'required|exists:terminals,id',
        'jarak_km' => 'required|integer',
        'estimated_duration_minutes' => 'required|integer',
        'harga_dasar' => 'required|numeric',
        'deskripsi' => 'nullable|string',
    ]);

    $route = Route::create($validated);

    return response()->json([
        'success' => true,
        'message' => 'Rute berhasil ditambahkan',
        'data' => $route
    ], 201);
}


    public function update(Request $request, $id)
{
    $route = Route::find($id);

    if (!$route) {
        return response()->json([
            'success' => false,
            'message' => 'Rute tidak ditemukan',
        ], 404);
    }

    $validated = $request->validate([
        'asal' => 'sometimes|required|string|max:255',
        'tujuan' => 'sometimes|required|string|max:255',
        'jarak_km' => 'sometimes|required|integer',
        'estimated_duration_minutes' => 'sometimes|required|integer',
        'harga_dasar' => 'sometimes|required|numeric',
        'deskripsi' => 'nullable|string',
    ]);

    $route->update($validated);

    return response()->json([
        'success' => true,
        'message' => 'Data rute berhasil diperbarui',
        'data' => $route,
    ], 200);
}

public function destroy($id)
{
    $route = Route::find($id);

    if (!$route) {
        return response()->json([
            'success' => false,
            'message' => 'Rute tidak ditemukan',
        ], 404);
    }

    $route->delete();

    return response()->json([
        'success' => true,
        'message' => 'Rute berhasil dihapus',
    ], 200);
}

}
