@extends('layouts.app')

@section('title', 'Dashboard - Sistem Absensi Siswa')

@section('content')
{{-- Welcome Card Banner --}}
<div class="card border-0 shadow-sm mb-4 bg-primary text-white position-relative overflow-hidden">
    <div class="card-body p-4 p-md-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-white text-primary mb-2 px-3 py-2 fw-semibold">
                    <i class="bi bi-person-check-fill me-1"></i>
                    @if($user->isAdmin())
                        Role: Administrator Kurikulum
                    @elseif($user->isGuru())
                        Role: Tenaga Pendidik / Guru
                    @else
                        Role: Siswa / Orang Tua
                    @endif
                </span>
                <h2 class="fw-bold mb-2">Halo, {{ $user->name }}!</h2>
                <p class="mb-0 text-white-50 fs-6">
                    Selamat datang di Sistem Absensi Siswa. Hari ini: <strong>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</strong>.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                @if($user->isAdmin() || $user->isGuru())
                    <a href="{{ route('siswa.create') }}" class="btn btn-light text-primary fw-semibold px-4 py-2 shadow-sm">
                        <i class="bi bi-person-plus-fill me-1"></i> Tambah Siswa Baru
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Statistik Data Induk --}}
<div class="row g-3 mb-4">
    {{-- Total Siswa --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="bg-primary-subtle text-primary p-3 rounded-4 fs-3">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <small class="text-muted fw-semibold d-block">TOTAL SISWA</small>
                    <h3 class="fw-bold text-dark mb-0">{{ $stats['total_siswa'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Kelas --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="bg-success-subtle text-success p-3 rounded-4 fs-3">
                    <i class="bi bi-door-open-fill"></i>
                </div>
                <div>
                    <small class="text-muted fw-semibold d-block">TOTAL KELAS</small>
                    <h3 class="fw-bold text-dark mb-0">{{ $stats['total_kelas'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Guru --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="bg-warning-subtle text-warning p-3 rounded-4 fs-3">
                    <i class="bi bi-person-badge-fill"></i>
                </div>
                <div>
                    <small class="text-muted fw-semibold d-block">TOTAL GURU</small>
                    <h3 class="fw-bold text-dark mb-0">{{ $stats['total_guru'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Mapel --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="bg-info-subtle text-info p-3 rounded-4 fs-3">
                    <i class="bi bi-book-half"></i>
                </div>
                <div>
                    <small class="text-muted fw-semibold d-block">MATA PELAJARAN</small>
                    <h3 class="fw-bold text-dark mb-0">{{ $stats['total_mapel'] }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Tabel Siswa Terbaru --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-clock-history text-primary me-2"></i> Siswa Terdaftar Terbaru
                </h5>
                @if($user->isAdmin() || $user->isGuru())
                    <a href="{{ route('siswa.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                @endif
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light small text-uppercase text-secondary">
                            <tr>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>L/P</th>
                                @if($user->isAdmin() || $user->isGuru())
                                    <th class="text-center">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestStudents as $siswa)
                                <tr>
                                    <td><span class="badge bg-light text-dark border font-monospace">{{ $siswa->nis }}</span></td>
                                    <td class="fw-semibold text-dark">{{ $siswa->nama }}</td>
                                    <td><span class="badge bg-secondary-subtle text-secondary">{{ $siswa->kelas }}</span></td>
                                    <td>
                                        @if($siswa->jenis_kelamin === 'Laki-laki')
                                            <span class="badge bg-primary-subtle text-primary">L</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">P</span>
                                        @endif
                                    </td>
                                    @if($user->isAdmin() || $user->isGuru())
                                        <td class="text-center">
                                            <a href="{{ route('siswa.show', $siswa->id) }}" class="btn btn-sm btn-outline-info py-0 px-2" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada siswa terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Menu Pintas & Info Hak Akses UKK --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-grid-fill text-primary me-2"></i> Menu Cepat</h6>
            </div>
            <div class="card-body p-3 d-flex flex-column gap-2">
                @if($user->isAdmin() || $user->isGuru())
                    <a href="{{ route('siswa.index') }}" class="btn btn-outline-primary text-start d-flex justify-content-between align-items-center p-2">
                        <span><i class="bi bi-people-fill me-2"></i> Kelola Siswa</span>
                        <i class="bi bi-chevron-right small text-muted"></i>
                    </a>
                    <a href="{{ route('kelas.index') }}" class="btn btn-outline-success text-start d-flex justify-content-between align-items-center p-2">
                        <span><i class="bi bi-door-open-fill me-2"></i> Kelola Kelas</span>
                        <i class="bi bi-chevron-right small text-muted"></i>
                    </a>
                    <a href="{{ route('guru.index') }}" class="btn btn-outline-warning text-start d-flex justify-content-between align-items-center p-2">
                        <span><i class="bi bi-person-badge-fill me-2 text-dark"></i> Kelola Guru</span>
                        <i class="bi bi-chevron-right small text-muted"></i>
                    </a>
                    <a href="{{ route('mapel.index') }}" class="btn btn-outline-info text-start d-flex justify-content-between align-items-center p-2">
                        <span><i class="bi bi-book-half me-2"></i> Kelola Mata Pelajaran</span>
                        <i class="bi bi-chevron-right small text-muted"></i>
                    </a>
                @else
                    <div class="alert alert-info small mb-0">
                        <i class="bi bi-info-circle-fill me-1"></i> Anda login sebagai siswa. Halaman riwayat absensi pribadi akan aktif pada Tahap 3.
                    </div>
                @endif
            </div>
        </div>

        {{-- Kartu Progres Penilaian UKK --}}
        <div class="card border-0 shadow-sm bg-light">
            <div class="card-body p-3">
                <h6 class="fw-bold text-dark small mb-2"><i class="bi bi-patch-check-fill text-success me-1"></i> Status Penilaian UKK</h6>
                <div class="small text-muted mb-2">
                    <span class="badge bg-success-subtle text-success me-1">Tahap 1</span> CRUD Master Data: <strong>Selesai</strong><br>
                    <span class="badge bg-success-subtle text-success me-1">Tahap 2</span> Multi-User Login: <strong>Selesai</strong><br>
                    <span class="badge bg-warning-subtle text-warning me-1">Tahap 3</span> Checklist Absensi: <em>Siap Dikerjakan</em>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

