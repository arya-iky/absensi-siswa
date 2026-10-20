<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Kelas;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    /**
     * Halaman Input Absensi Harian (Checklist Cepat H, I, S, A).
     */
    public function index(Request $request): View
    {
        $selectedTanggal = $request->input('tanggal', Carbon::today()->toDateString());
        $selectedKelas = $request->input('kelas');

        // Daftar kelas untuk dropdown
        $daftarKelas = Kelas::orderBy('nama_kelas')->pluck('nama_kelas');

        $students = collect();
        $attendancesMap = [];

        if ($selectedKelas) {
            $students = Student::where('kelas', $selectedKelas)
                ->orderBy('nama')
                ->get();

            // Ambil absensi yang sudah tercatat pada tanggal dan siswa-siswa ini
            $attendances = Attendance::where('tanggal', $selectedTanggal)
                ->whereIn('student_id', $students->pluck('id'))
                ->get();

            $attendancesMap = $attendances->keyBy('student_id')->toArray();
        }

        return view('absensi.index', compact(
            'selectedTanggal',
            'selectedKelas',
            'daftarKelas',
            'students',
            'attendancesMap'
        ));
    }

    /**
     * Simpan / Perbarui Absensi Siswa Harian secara Massal (Bulk Save).
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'tanggal' => ['required', 'date'],
            'kelas' => ['required', 'string'],
            'attendances' => ['required', 'array'],
            'attendances.*.status' => ['required', 'in:Hadir,Izin,Sakit,Alpa'],
            'attendances.*.keterangan' => ['nullable', 'string', 'max:255'],
        ], [
            'tanggal.required' => 'Tanggal absensi wajib diisi.',
            'kelas.required' => 'Pilih kelas terlebih dahulu.',
            'attendances.required' => 'Data kehadiran siswa tidak boleh kosong.',
        ]);

        $tanggal = $request->input('tanggal');
        $kelas = $request->input('kelas');

        foreach ($request->input('attendances') as $studentId => $data) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'tanggal' => $tanggal,
                ],
                [
                    'status' => $data['status'] ?? 'Hadir',
                    'keterangan' => $data['keterangan'] ?? null,
                ]
            );
        }

        return redirect()->route('absensi.index', ['tanggal' => $tanggal, 'kelas' => $kelas])
            ->with('success', "Absensi kelas {$kelas} tanggal " . Carbon::parse($tanggal)->translatedFormat('d F Y') . " berhasil disimpan.");
    }

    /**
     * Halaman Rekapitulasi Absensi Bulanan & Cetak Laporan.
     */
    public function rekap(Request $request): View
    {
        $bulanTahun = $request->input('bulan', Carbon::now()->format('Y-m'));
        $selectedKelas = $request->input('kelas');
        $daftarKelas = Kelas::orderBy('nama_kelas')->pluck('nama_kelas');

        $rekapData = collect();

        if ($selectedKelas) {
            $startDate = Carbon::parse($bulanTahun . '-01')->startOfMonth()->toDateString();
            $endDate = Carbon::parse($bulanTahun . '-01')->endOfMonth()->toDateString();

            $students = Student::where('kelas', $selectedKelas)
                ->with(['attendances' => function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('tanggal', [$startDate, $endDate]);
                }])
                ->orderBy('nama')
                ->get();

            $rekapData = $students->map(function ($student) {
                $hadir = $student->attendances->where('status', 'Hadir')->count();
                $izin = $student->attendances->where('status', 'Izin')->count();
                $sakit = $student->attendances->where('status', 'Sakit')->count();
                $alpa = $student->attendances->where('status', 'Alpa')->count();
                $totalPertemuan = $student->attendances->count();

                $persentase = $totalPertemuan > 0 
                    ? round(($hadir / $totalPertemuan) * 100, 1) 
                    : 0;

                return [
                    'student' => $student,
                    'hadir' => $hadir,
                    'izin' => $izin,
                    'sakit' => $sakit,
                    'alpa' => $alpa,
                    'total' => $totalPertemuan,
                    'persentase' => $persentase,
                ];
            });
        }

        return view('absensi.rekap', compact(
            'bulanTahun',
            'selectedKelas',
            'daftarKelas',
            'rekapData'
        ));
    }

    /**
     * Halaman Riwayat Kehadiran Siswa Mandiri (Untuk Role Siswa / Wali).
     */
    public function riwayat(): View
    {
        $user = Auth::user();

        // Cari data siswa yang cocok dengan nama atau akun user, atau siswa pertama jika data demo
        $student = Student::where('nama', 'like', "%{$user->name}%")
            ->orWhere('id', 1)
            ->first();

        $attendances = collect();
        $stats = ['Hadir' => 0, 'Izin' => 0, 'Sakit' => 0, 'Alpa' => 0];

        if ($student) {
            $attendances = Attendance::where('student_id', $student->id)
                ->orderByDesc('tanggal')
                ->paginate(15);

            $stats['Hadir'] = Attendance::where('student_id', $student->id)->where('status', 'Hadir')->count();
            $stats['Izin'] = Attendance::where('student_id', $student->id)->where('status', 'Izin')->count();
            $stats['Sakit'] = Attendance::where('student_id', $student->id)->where('status', 'Sakit')->count();
            $stats['Alpa'] = Attendance::where('student_id', $student->id)->where('status', 'Alpa')->count();
        }

        return view('absensi.riwayat', compact('student', 'attendances', 'stats'));
    }
}

