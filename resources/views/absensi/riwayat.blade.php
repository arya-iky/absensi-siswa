@extends('layouts.app')

@section('title', 'Riwayat Absensi Saya - Sistem Absensi Siswa')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6 mb-3 mb-md-0">
        <h3 class="fw-bold text-dark mb-1">Riwayat Kehadiran Saya</h3>
        <p class="text-muted mb-0">Catatan kehadiran dan statistik absensi Anda di sekolah.</p>
    </div>
</div>

@if($student)
    {{-- Card Profil Siswa --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" 
                     style="width: 56px; height: 56px; font-size: 1.5rem;">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1 text-dark">{{ $student->nama }}</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-light text-dark border font-monospace">NIS: {{ $student->nis }}</span>
                        <span class="badge bg-secondary-subtle text-secondary">Kelas {{ $student->kelas }}</span>
                        <span class="badge bg-primary-subtle text-primary">{{ $student->jurusan }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <span class="badge bg-success-subtle text-success p-2 rounded-3 mx-auto mb-2 fs-5">
                    <i class="bi bi-check-circle-fill"></i>
                </span>
                <small class="text-muted d-block fw-semibold">HADIR</small>
                <h4 class="fw-bold text-success mb-0">{{ $stats['Hadir'] }}</h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <span class="badge bg-info-subtle text-info p-2 rounded-3 mx-auto mb-2 fs-5">
                    <i class="bi bi-info-circle-fill"></i>
                </span>
                <small class="text-muted d-block fw-semibold">IZIN</small>
                <h4 class="fw-bold text-info mb-0">{{ $stats['Izin'] }}</h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <span class="badge bg-warning-subtle text-warning p-2 rounded-3 mx-auto mb-2 fs-5">
                    <i class="bi bi-heart-pulse-fill"></i>
                </span>
                <small class="text-muted d-block fw-semibold">SAKIT</small>
                <h4 class="fw-bold text-warning mb-0">{{ $stats['Sakit'] }}</h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <span class="badge bg-danger-subtle text-danger p-2 rounded-3 mx-auto mb-2 fs-5">
                    <i class="bi bi-x-circle-fill"></i>
                </span>
                <small class="text-muted d-block fw-semibold">ALPA</small>
                <h4 class="fw-bold text-danger mb-0">{{ $stats['Alpa'] }}</h4>
            </div>
        </div>
    </div>

    {{-- Tabel Riwayat Kehadiran --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="bi bi-calendar-check text-primary me-2"></i> Log Catatan Kehadiran
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small text-uppercase text-secondary">
                        <tr>
                            <th style="width: 50px;" class="text-center">No</th>
                            <th>Hari & Tanggal</th>
                            <th>Status Kehadiran</th>
                            <th>Catatan / Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $index => $item)
                            <tr>
                                <td class="text-center text-muted fw-semibold">{{ $index + 1 }}</td>
                                <td class="fw-medium text-dark">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}</td>
                                <td>
                                    @if($item->status === 'Hadir')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1">Hadir</span>
                                    @elseif($item->status === 'Izin')
                                        <span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-1">Izin</span>
                                    @elseif($item->status === 'Sakit')
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1">Sakit</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1">Alpa</span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $item->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-calendar-x fs-1 d-block mb-2 text-secondary"></i>
                                    Belum ada catatan kehadiran yang terekam.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($attendances->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $attendances->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@else
    <div class="card border-0 shadow-sm text-center py-5">
        <div class="card-body">
            <i class="bi bi-person-x fs-1 text-muted d-block mb-2"></i>
            <h5 class="fw-bold text-dark">Data Siswa Tidak Ditemukan</h5>
            <p class="text-muted col-md-6 mx-auto mb-0">Akun Anda belum terhubung dengan data siswa di database.</p>
        </div>
    </div>
@endif
@endsection

