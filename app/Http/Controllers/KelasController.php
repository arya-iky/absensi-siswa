<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class KelasController extends Controller
{
    public function index(Request $request): View
    {
        $query = Kelas::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nama_kelas', 'like', "%{$search}%")
                  ->orWhere('jurusan', 'like', "%{$search}%")
                  ->orWhere('wali_kelas', 'like', "%{$search}%");
        }

        $classes = $query->orderBy('nama_kelas')->paginate(10)->withQueryString();

        return view('kelas.index', compact('classes'));
    }

    public function create(): View
    {
        return view('kelas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kelas' => ['required', 'string', 'max:50', 'unique:classes,nama_kelas'],
            'jurusan' => ['required', 'string', 'max:100'],
            'wali_kelas' => ['nullable', 'string', 'max:100'],
        ], [
            'nama_kelas.required' => 'Nama kelas wajib diisi.',
            'nama_kelas.unique' => 'Nama kelas ini sudah ada.',
            'jurusan.required' => 'Jurusan wajib diisi.',
        ]);

        Kelas::create($validated);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kela): View
    {
        return view('kelas.edit', ['kelas' => $kela]);
    }

    public function update(Request $request, Kelas $kela): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kelas' => ['required', 'string', 'max:50', Rule::unique('classes', 'nama_kelas')->ignore($kela->id)],
            'jurusan' => ['required', 'string', 'max:100'],
            'wali_kelas' => ['nullable', 'string', 'max:100'],
        ], [
            'nama_kelas.required' => 'Nama kelas wajib diisi.',
            'nama_kelas.unique' => 'Nama kelas ini sudah digunakan.',
            'jurusan.required' => 'Jurusan wajib diisi.',
        ]);

        $kela->update($validated);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kela): RedirectResponse
    {
        $kela->delete();

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil dihapus.');
    }
}

