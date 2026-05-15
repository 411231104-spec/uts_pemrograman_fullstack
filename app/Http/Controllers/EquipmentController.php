<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::latest()->get();
        return view('equipments.index', compact('equipments'));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin()) abort(403);
        return view('equipments.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) abort(403);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock'       => 'required|integer|min:0',
            'status'      => 'required|in:available,borrowed,maintenance',
        ], [
            'name.required'   => 'Nama peralatan wajib diisi.',
            'stock.required'  => 'Jumlah stok wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        Equipment::create($validated);

        return redirect()->route('equipments.index')
            ->with('success', 'Peralatan berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        if (!Auth::user()->isAdmin()) abort(403);
        $equipment = Equipment::findOrFail($id);
        return view('equipments.edit', compact('equipment'));
    }

    public function update(Request $request, string $id)
    {
        if (!Auth::user()->isAdmin()) abort(403);

        $equipment = Equipment::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock'       => 'required|integer|min:0',
            'status'      => 'required|in:available,borrowed,maintenance',
        ]);

        $equipment->update($validated);

        return redirect()->route('equipments.index')
            ->with('success', 'Peralatan berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        if (!Auth::user()->isAdmin()) abort(403);
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();

        return redirect()->route('equipments.index')
            ->with('success', 'Peralatan berhasil dihapus.');
    }
}
