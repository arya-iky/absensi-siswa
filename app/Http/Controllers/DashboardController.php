<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard aplikasi dengan ringkasan data sesuai hak akses.
     */
    public function index(): View
    {
        $user = Auth::user();

        $stats = [
            'total_siswa' => Student::count(),
            'total_kelas' => Kelas::count(),
            'total_guru' => Guru::count(),
            'total_mapel' => Mapel::count(),
        ];

        $latestStudents = Student::latest()->limit(5)->get();

        return view('dashboard', compact('user', 'stats', 'latestStudents'));
    }
}

