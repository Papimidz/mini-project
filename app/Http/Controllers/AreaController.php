<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::latest()->paginate(10);

        return view('areas.index', compact('areas'));
    }

    public function create()
    {
        return view('areas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:areas,name',
            'description' => 'nullable|string',
        ]);

        Area::create($validated);

        return redirect()->route('areas.index')
            ->with('success', 'Wilayah berhasil ditambahkan.');
    }

    public function edit(Area $area)
    {
        return view('areas.edit', compact('area'));
    }

    public function update(Request $request, Area $area)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:areas,name,' . $area->id,
            'description' => 'nullable|string',
        ]);

        $area->update($validated);

        return redirect()->route('areas.index')
            ->with('success', 'Wilayah berhasil diperbarui.');
    }

    public function destroy(Area $area)
    {
        if ($area->fireReports()->exists()) {
            return redirect()->route('areas.index')
                ->with('error', 'Wilayah tidak dapat dihapus karena masih digunakan dalam laporan.');
        }

        $area->delete();

        return redirect()->route('areas.index')
            ->with('success', 'Wilayah berhasil dihapus.');
    }
}