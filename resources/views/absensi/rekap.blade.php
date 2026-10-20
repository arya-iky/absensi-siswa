@extends('layouts.app')

@section('title', 'Rekapitulasi Kehadiran - Sistem Absensi Siswa')

@push('styles')
<style>
    @media print {
        nav, footer, .no-print, .btn, .card-header form {
            display: none !important;
        }
        body {
            background-color: #ffffff !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .print-only {
            display: block !important;
        }
    }
    .print-only {
        display: none;
    }
</style>
@endpush

@section('content')
<div class="row mb-4 align-items-center no-print">
    <div class="col-md-6 mb-3 mb-md-0">
        <h3 class="fw-bold text-dark mb-1">Rekapitulasi Kehadiran</h3>
        <p class="text-muted mb-0">Laporan akumulasi kehadiran bulanan siswa per kelas.</p>
    </div>
    <div class="col-md-6 text-md-end">
        @if($selectedKelas && $rekapData->isNotEmpty())
            <button type="button" class="btn btn-secondary px-3 py-2 shadow-sm" onclick="window.print()">
                <i class="bi bi-printer-fill me-1"></i> Cetak / Export PDF
            </button>
        @endif
        <a href="{{ route('absensi.index') }}" class="btn btn-outline-primary px-3 py-2 shadow-sm">
            <i class="bi bi-check2-square me-1"></i> Input Absensi Harian
        </a>
    </div>
</div>

{{-- Header Kop Khusus Cetak --}}
<div class="print-only text-center mb-4 pb-3 border-bottom">
    <h3 class="fw-bold mb-1">LAPORAN REKAPITULASI KEHADIRAN SISWA</h3>
    <h5 class="fw-semibold text-secondary mb-1">SMK / SEKOLAH MENENGAH KEJURUAN</h5>
    <p class="mb-0 text-muted">Kelas: <strong>{{ $selectedKelas }}</strong> | Periode: <strong>{{ \Carbon\Carbon::parse($bulanTahun . '-01')->translatedFormat('F Y') }}</strong></p>
</div>

{{-- Filter Bulan & Kelas --}}
<div class="card mb-4 border-0 shadow-sm no-print">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('absensi.rekap') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="bulan" class="form-label fw-semibold small text-secondary">Bulan & Tahun</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-calendar-month"></i></span>
                    <input type="month" name="bulan" id="bulan" class="form-control border-start-0 ps-0" 
                           value="{{ $bulanTahun }}" required>
                </div>
            </div>
            <div class="col-md-5">
                <label for="kelas" class="form-label fw-semibold small text-secondary">Pilih Kelas</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-door-open"></i></span>
                    <select name="kelas" id="kelas" class="form-select border-start-0 ps-0" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($daftarKelas as $k)
                            <option value="{{ $k }}" {{ $selectedKelas === $k ? 'selected' : '' }}>
                                Kelas {{ $k }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100 py-2">
                    <i class="bi bi-filter me-1"></i> Tampilkan Rekap
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Tabel Rekapitulasi --}}
@if($selectedKelas)
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark">
                Rekap Kehadiran: Kelas {{ $selectedKelas }}
            </h5>
            <span class="badge bg-primary-subtle text-primary">
                Periode {{ \Carbon\Carbon::parse($bulanTahun . '-01')->translatedFormat('F Y') }}
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light small text-uppercase text-secondary text-center">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="width: 120px;">NIS</th>
                            <th class="text-start">Nama Siswa</th>
                            <th style="width: 60px;" class="text-success">H</th>
                            <th style="width: 60px;" class="text-info">I</th>
                            <th style="width: 60px;" class="text-warning">S</th>
                            <th style="width: 60px;" class="text-danger">A</th>
                            <th style="width: 90px;">Total Hari</th>
                            <th style="width: 120px;">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekapData as $index => $row)
                            <tr>
                                <td class="text-center text-muted fw-semibold">{{ $index + 1 }}</td>
                                <td class="text-center font-monospace">{{ $row['student']->nis }}</td>
                                <td class="fw-semibold text-dark">{{ $row['student']->nama }}</td>
                                <td class="text-center fw-bold text-success">{{ $row['hadir'] }}</td>
                                <td class="text-center fw-bold text-info">{{ $row['izin'] }}</td>
                                <td class="text-center fw-bold text-warning">{{ $row['sakit'] }}</td>
                                <td class="text-center fw-bold text-danger">{{ $row['alpa'] }}</td>
                                <td class="text-center text-muted">{{ $row['total'] }}</td>
                                <td class="text-center">
                                    @if($row['total'] > 0)
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            <span class="fw-bold {{ $row['persentase'] >= 85 ? 'text-success' : ($row['persentase'] >= 70 ? 'text-warning' : 'text-danger') }}">
                                                {{ $row['persentase'] }}%
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    Belum ada data siswa di kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light border-0 py-3">
            <div class="small text-muted d-flex gap-4">
                <span><strong>Keterangan:</strong></span>
                <span><span class="badge bg-success">H</span> Hadir</span>
                <span><span class="badge bg-info text-white">I</span> Izin</span>
                <span><span class="badge bg-warning text-dark">S</span> Sakit</span>
                <span><span class="badge bg-danger">A</span> Alpa</span>
            </div>
        </div>
    </div>
@else
    <div class="card border-0 shadow-sm text-center py-5">
        <div class="card-body">
            <i class="bi bi-file-earmark-bar-graph fs-1 text-muted d-block mb-2"></i>
            <h5 class="fw-bold text-dark">Silakan Pilih Kelas dan Bulan</h5>
            <p class="text-muted col-md-6 mx-auto mb-0">Pilih kelas dan bulan di atas untuk mengkalkulasi dan mencetak laporan absensi bulanan.</p>
        </div>
    </div>
@endif
@endsection

