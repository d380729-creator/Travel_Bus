<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Route;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::all();
        return response()->json([
            'success' => true,
            'data' => $routes
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asal' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
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
}
