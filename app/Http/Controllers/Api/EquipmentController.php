<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::all();

        return response()->json([
            'status'  => 'success',
            'message' => 'Daftar peralatan berhasil diambil.',
            'data'    => EquipmentResource::collection($equipments),
        ]);
    }

    public function show(string $id)
    {
        $equipment = Equipment::find($id);

        if (!$equipment) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Peralatan tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Detail peralatan berhasil diambil.',
            'data'    => new EquipmentResource($equipment),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock'       => 'required|integer|min:0',
            'status'      => 'required|in:available,borrowed,maintenance',
        ]);

        $equipment = Equipment::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Peralatan berhasil ditambahkan.',
            'data'    => new EquipmentResource($equipment),
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        $equipment = Equipment::find($id);

        if (!$equipment) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Peralatan tidak ditemukan.',
            ], 404);
        }

        $validated = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'stock'       => 'sometimes|integer|min:0',
            'status'      => 'sometimes|in:available,borrowed,maintenance',
        ]);

        $equipment->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Peralatan berhasil diperbarui.',
            'data'    => new EquipmentResource($equipment),
        ]);
    }

    public function destroy(string $id)
    {
        $equipment = Equipment::find($id);

        if (!$equipment) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Peralatan tidak ditemukan.',
            ], 404);
        }

        $equipment->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Peralatan berhasil dihapus.',
        ]);
    }
}
