<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// --- Rute Tamu (Guest) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// --- Rute Terproteksi (Wajib Login) ---
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', fn () => redirect()->route('dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Fitur Utama Absensi Harian & Rekapitulasi (Admin & Guru)
    Route::middleware('role:admin,guru')->group(function () {
        Route::get('/absensi', [\App\Http\Controllers\AttendanceController::class, 'index'])->name('absensi.index');
        Route::post('/absensi', [\App\Http\Controllers\AttendanceController::class, 'store'])->name('absensi.store');
        Route::get('/rekap', [\App\Http\Controllers\AttendanceController::class, 'rekap'])->name('absensi.rekap');

        // Manajemen Data Induk
        Route::resource('siswa', StudentController::class)->parameters(['siswa' => 'siswa']);
        Route::resource('kelas', KelasController::class);
        Route::resource('guru', GuruController::class);
        Route::resource('mapel', MapelController::class);
    });

    // Riwayat Kehadiran Mandiri untuk Siswa
    Route::get('/riwayat-absensi', [\App\Http\Controllers\AttendanceController::class, 'riwayat'])->name('absensi.riwayat');
});
