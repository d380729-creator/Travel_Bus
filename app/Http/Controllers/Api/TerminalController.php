<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Terminal;

class TerminalController extends Controller
{
    public function index()
    {
        $terminals = Terminal::all();
        return response()->json(['success' => true, 'data' => $terminals]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'kota' => 'required|string|max:100',
            'alamat' => 'nullable|string|max:255',
        ]);

        $terminal = Terminal::create($validated);

        return response()->json(['success' => true, 'data' => $terminal], 201);
    }

    public function show($id)
    {
        $terminal = Terminal::findOrFail($id);
        return response()->json(['success' => true, 'data' => $terminal]);
    }

    public function update(Request $request, $id)
    {
        $terminal = Terminal::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:100',
            'kota' => 'sometimes|required|string|max:100',
            'alamat' => 'nullable|string|max:255',
        ]);

        $terminal->update($validated);

        return response()->json(['success' => true, 'data' => $terminal]);
    }

    public function destroy($id)
    {
        $terminal = Terminal::findOrFail($id);
        $terminal->delete();

        return response()->json(['success' => true, 'message' => 'Terminal deleted successfully']);
    }

    public function getByCity(Request $request)
{
    $asal = $request->query('asal');
    $tujuan = $request->query('tujuan');

    $terminals = Terminal::query();

    if ($asal) {
        $asal_terminals = $terminals->where('kota', $asal)->get();
        return response()->json([
            'success' => true,
            'type' => 'asal',
            'data' => $asal_terminals
        ]);
    }

    if ($tujuan) {
        $tujuan_terminals = $terminals->where('kota', $tujuan)->get();
        return response()->json([
            'success' => true,
            'type' => 'tujuan',
            'data' => $tujuan_terminals
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Kota tidak ditemukan'
    ], 400);
}

}
