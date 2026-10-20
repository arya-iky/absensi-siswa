<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MapelController extends Controller
{
    public function index(Request $request): View
    {
        $query = Mapel::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nama_mapel', 'like', "%{$search}%")
                  ->orWhere('kode_mapel', 'like', "%{$search}%");
        }

        $subjects = $query->orderBy('nama_mapel')->paginate(10)->withQueryString();

        return view('mapel.index', compact('subjects'));
    }

    public function create(): View
    {
        return view('mapel.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_mapel' => ['required', 'string', 'max:20', 'unique:subjects,kode_mapel'],
            'nama_mapel' => ['required', 'string', 'max:100'],
            'jam_pelajaran' => ['required', 'integer', 'min:1', 'max:10'],
        ], [
            'kode_mapel.required' => 'Kode mata pelajaran wajib diisi.',
            'kode_mapel.unique' => 'Kode mata pelajaran sudah ada.',
            'nama_mapel.required' => 'Nama mata pelajaran wajib diisi.',
            'jam_pelajaran.required' => 'Jumlah jam pelajaran wajib diisi.',
        ]);

        Mapel::create($validated);

        return redirect()->route('mapel.index')->with('success', 'Data mata pelajaran berhasil ditambahkan.');
    }

    public function edit(Mapel $mapel): View
    {
        return view('mapel.edit', compact('mapel'));
    }

    public function update(Request $request, Mapel $mapel): RedirectResponse
    {
        $validated = $request->validate([
            'kode_mapel' => ['required', 'string', 'max:20', Rule::unique('subjects', 'kode_mapel')->ignore($mapel->id)],
            'nama_mapel' => ['required', 'string', 'max:100'],
            'jam_pelajaran' => ['required', 'integer', 'min:1', 'max:10'],
        ], [
            'kode_mapel.required' => 'Kode mata pelajaran wajib diisi.',
            'kode_mapel.unique' => 'Kode mata pelajaran sudah ada.',
            'nama_mapel.required' => 'Nama mata pelajaran wajib diisi.',
            'jam_pelajaran.required' => 'Jumlah jam pelajaran wajib diisi.',
        ]);

        $mapel->update($validated);

        return redirect()->route('mapel.index')->with('success', 'Data mata pelajaran berhasil diperbarui.');
    }

    public function destroy(Mapel $mapel): RedirectResponse
    {
        $mapel->delete();

        return redirect()->route('mapel.index')->with('success', 'Data mata pelajaran berhasil dihapus.');
    }
}

