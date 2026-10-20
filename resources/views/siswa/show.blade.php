@extends('layouts.app')

@section('title', 'Detail Siswa - ' . $siswa->nama)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}" class="text-decoration-none">Data Siswa</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail Siswa</li>
            </ol>
        </nav>

        {{-- Profil Siswa Card --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 pb-3 border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 64px; height: 64px; font-size: 1.75rem;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1 text-dark">{{ $siswa->nama }}</h4>
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <span class="badge bg-light text-dark border font-monospace">NIS: {{ $siswa->nis }}</span>
                                <span class="badge bg-secondary-subtle text-secondary">Kelas {{ $siswa->kelas }}</span>
                                @if($siswa->jenis_kelamin === 'Laki-laki')
                                    <span class="badge bg-primary-subtle text-primary">
                                        <i class="bi bi-gender-male me-1"></i>Laki-laki
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">
                                        <i class="bi bi-gender-female me-1"></i>Perempuan
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-warning px-3">
                            <i class="bi bi-pencil-square me-1"></i> Edit Data
                        </a>
                        <a href="{{ route('siswa.index') }}" class="btn btn-outline-secondary px-3">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>

                {{-- Detail Info Grid --}}
                <div class="row g-4 mt-1">
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 bg-light">
                            <small class="text-muted d-block mb-1">Jurusan</small>
                            <span class="fw-semibold text-dark">{{ $siswa->jurusan ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 bg-light">
                            <small class="text-muted d-block mb-1">Nomor HP / WhatsApp</small>
                            <span class="fw-semibold text-dark">
                                @if($siswa->no_hp)
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $siswa->no_hp)) }}" 
                                       target="_blank" class="text-decoration-none text-success">
                                        <i class="bi bi-whatsapp me-1"></i>{{ $siswa->no_hp }}
                                    </a>
                                @else
                                    -
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 rounded-3 bg-light">
                            <small class="text-muted d-block mb-1">Alamat Tempat Tinggal</small>
                            <span class="fw-semibold text-dark">{{ $siswa->alamat ?? 'Belum ada informasi alamat.' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="small text-muted">
                            <i class="bi bi-calendar-event me-1"></i> Terdaftar pada: {{ $siswa->created_at ? $siswa->created_at->translatedFormat('d F Y H:i') : '-' }}
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="small text-muted">
                            <i class="bi bi-clock-history me-1"></i> Terakhir diubah: {{ $siswa->updated_at ? $siswa->updated_at->diffForHumans() : '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Riwayat Absensi Terakhir --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-calendar-check text-primary me-2"></i> Riwayat Absensi Terakhir
                </h6>
                <span class="badge bg-primary-subtle text-primary">{{ $siswa->attendances->count() }} Catatan</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light small text-uppercase text-secondary">
                            <tr>
                                <th style="width: 50px;" class="text-center">No</th>
                                <th>Tanggal</th>
                                <th>Status Kehadiran</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa->attendances as $index => $absen)
                                <tr>
                                    <td class="text-center text-muted">{{ $index + 1 }}</td>
                                    <td class="fw-medium">{{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d F Y') }}</td>
                                    <td>
                                        @if($absen->status === 'Hadir')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle">Hadir</span>
                                        @elseif($absen->status === 'Izin')
                                            <span class="badge bg-info-subtle text-info border border-info-subtle">Izin</span>
                                        @elseif($absen->status === 'Sakit')
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Sakit</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Alpa</span>
                                        @endif
                                    </td>
                                    <td class="text-muted">{{ $absen->keterangan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted small">
                                        <i class="bi bi-info-circle me-1"></i> Belum ada riwayat absensi untuk siswa ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
