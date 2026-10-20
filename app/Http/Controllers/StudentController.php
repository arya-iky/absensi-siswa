<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Menampilkan daftar data siswa dengan pencarian dan filter kelas.
     */
    public function index(Request $request): View
    {
        $query = Student::query();

        // Fitur Pencarian (NIS, Nama, Kelas, Jurusan)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('kelas', 'like', "%{$search}%")
                  ->orWhere('jurusan', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kelas
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->input('kelas'));
        }

        // Urutkan siswa berdasarkan nama atau waktu dibuat
        $students = $query->latest()->paginate(10)->withQueryString();

        // Ambil daftar kelas unik untuk dropdown filter
        $daftarKelas = Student::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');

        return view('siswa.index', compact('students', 'daftarKelas'));
    }

    /**
     * Menampilkan form tambah siswa baru.
     */
    public function create(): View
    {
        return view('siswa.create');
    }

    /**
     * Menyimpan data siswa baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:20', 'unique:students,nis'],
            'nama' => ['required', 'string', 'max:100'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'kelas' => ['required', 'string', 'max:50'],
            'jurusan' => ['nullable', 'string', 'max:100'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:500'],
        ], [
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS ini sudah terdaftar.',
            'nama.required' => 'Nama siswa wajib diisi.',
            'jenis_kelamin.required' => 'Pilih jenis kelamin.',
            'jenis_kelamin.in' => 'Pilihan jenis kelamin tidak valid.',
            'kelas.required' => 'Kelas wajib diisi.',
        ]);

        Student::create($validated);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail informasi siswa beserta riwayat absensinya.
     */
    public function show(Student $siswa): View
    {
        $siswa->load(['attendances' => function ($q) {
            $q->latest('tanggal')->limit(10);
        }]);

        return view('siswa.show', ['siswa' => $siswa]);
    }

    /**
     * Menampilkan form edit data siswa.
     */
    public function edit(Student $siswa): View
    {
        return view('siswa.edit', ['siswa' => $siswa]);
    }

    /**
     * Memperbarui data siswa di database.
     */
    public function update(Request $request, Student $siswa): RedirectResponse
    {
        $validated = $request->validate([
            'nis' => [
                'required',
                'string',
                'max:20',
                Rule::unique('students', 'nis')->ignore($siswa->id),
            ],
            'nama' => ['required', 'string', 'max:100'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'kelas' => ['required', 'string', 'max:50'],
            'jurusan' => ['nullable', 'string', 'max:100'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:500'],
        ], [
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS ini sudah digunakan oleh siswa lain.',
            'nama.required' => 'Nama siswa wajib diisi.',
            'jenis_kelamin.required' => 'Pilih jenis kelamin.',
            'jenis_kelamin.in' => 'Pilihan jenis kelamin tidak valid.',
            'kelas.required' => 'Kelas wajib diisi.',
        ]);

        $siswa->update($validated);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Menghapus data siswa dari database.
     */
    public function destroy(Student $siswa): RedirectResponse
    {
        $siswa->delete();

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}
