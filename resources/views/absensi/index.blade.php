@extends('layouts.app')

@section('title', 'Input Absensi Harian - Sistem Absensi Siswa')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6 mb-3 mb-md-0">
        <h3 class="fw-bold text-dark mb-1">Checklist Absensi Harian</h3>
        <p class="text-muted mb-0">Catat kehadiran siswa secara cepat per kelas dengan status H / I / S / A.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="{{ route('absensi.rekap') }}" class="btn btn-outline-primary px-3 py-2 shadow-sm">
            <i class="bi bi-file-earmark-bar-graph me-1"></i> Rekapitulasi Bulanan
        </a>
    </div>
</div>

{{-- Filter Tanggal & Kelas --}}
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('absensi.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="tanggal" class="form-label fw-semibold small text-secondary">Tanggal Absensi</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-calendar3"></i></span>
                    <input type="date" name="tanggal" id="tanggal" class="form-control border-start-0 ps-0" 
                           value="{{ $selectedTanggal }}" required>
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
                    <i class="bi bi-search me-1"></i> Buka Absensi
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Tabel Checklist Kehadiran --}}
@if($selectedKelas)
    <form action="{{ route('absensi.store') }}" method="POST">
        @csrf
        <input type="hidden" name="tanggal" value="{{ $selectedTanggal }}">
        <input type="hidden" name="kelas" value="{{ $selectedKelas }}">

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">
                        Daftar Siswa Kelas {{ $selectedKelas }}
                    </h5>
                    <small class="text-muted">
                        Tanggal: <strong>{{ \Carbon\Carbon::parse($selectedTanggal)->translatedFormat('l, d F Y') }}</strong> (Total: {{ $students->count() }} Siswa)
                    </small>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <button type="button" class="btn btn-sm btn-outline-success" onclick="setAllStatus('Hadir')">
                        <i class="bi bi-check-all me-1"></i> Semua Hadir (H)
                    </button>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light small text-uppercase text-secondary">
                            <tr>
                                <th class="text-center" style="width: 50px;">No</th>
                                <th style="width: 120px;">NIS</th>
                                <th>Nama Lengkap</th>
                                <th style="width: 280px;" class="text-center">Status Kehadiran</th>
                                <th style="width: 250px;">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $index => $item)
                                @php
                                    $currentStatus = $attendancesMap[$item->id]['status'] ?? 'Hadir';
                                    $currentKet = $attendancesMap[$item->id]['keterangan'] ?? '';
                                @endphp
                                <tr>
                                    <td class="text-center text-muted fw-semibold">{{ $index + 1 }}</td>
                                    <td><span class="badge bg-light text-dark border font-monospace">{{ $item->nis }}</span></td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $item->nama }}</div>
                                        <small class="text-muted">{{ $item->jenis_kelamin }}</small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group w-100" role="group">
                                            {{-- Hadir --}}
                                            <input type="radio" class="btn-check status-radio status-hadir" 
                                                   name="attendances[{{ $item->id }}][status]" 
                                                   id="status_h_{{ $item->id }}" value="Hadir" 
                                                   {{ $currentStatus === 'Hadir' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-success btn-sm py-1" for="status_h_{{ $item->id }}" title="Hadir">
                                                <strong>H</strong>
                                            </label>

                                            {{-- Izin --}}
                                            <input type="radio" class="btn-check status-radio" 
                                                   name="attendances[{{ $item->id }}][status]" 
                                                   id="status_i_{{ $item->id }}" value="Izin" 
                                                   {{ $currentStatus === 'Izin' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-info btn-sm py-1" for="status_i_{{ $item->id }}" title="Izin">
                                                <strong>I</strong>
                                            </label>

                                            {{-- Sakit --}}
                                            <input type="radio" class="btn-check status-radio" 
                                                   name="attendances[{{ $item->id }}][status]" 
                                                   id="status_s_{{ $item->id }}" value="Sakit" 
                                                   {{ $currentStatus === 'Sakit' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning btn-sm py-1" for="status_s_{{ $item->id }}" title="Sakit">
                                                <strong>S</strong>
                                            </label>

                                            {{-- Alpa --}}
                                            <input type="radio" class="btn-check status-radio" 
                                                   name="attendances[{{ $item->id }}][status]" 
                                                   id="status_a_{{ $item->id }}" value="Alpa" 
                                                   {{ $currentStatus === 'Alpa' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger btn-sm py-1" for="status_a_{{ $item->id }}" title="Alpa">
                                                <strong>A</strong>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" name="attendances[{{ $item->id }}][keterangan]" 
                                               class="form-control form-control-sm" 
                                               value="{{ $currentKet }}" 
                                               placeholder="Catatan / surat (opsional)">
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-people fs-1 d-block mb-2 text-secondary"></i>
                                        Belum ada data siswa di kelas <strong>{{ $selectedKelas }}</strong>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($students->isNotEmpty())
                <div class="card-footer bg-white border-0 py-3 text-end">
                    <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm">
                        <i class="bi bi-save me-1"></i> Simpan Absensi Kelas {{ $selectedKelas }}
                    </button>
                </div>
            @endif
        </div>
    </form>
@else
    <div class="card border-0 shadow-sm text-center py-5">
        <div class="card-body">
            <div class="bg-primary-subtle text-primary rounded-circle d-inline-flex p-4 mb-3">
                <i class="bi bi-clipboard2-check fs-1"></i>
            </div>
            <h5 class="fw-bold text-dark">Silakan Pilih Kelas dan Tanggal</h5>
            <p class="text-muted col-md-6 mx-auto mb-0">
                Pilih kelas dan tanggal pada formulir filter di atas, kemudian klik <strong>Buka Absensi</strong> untuk mulai mencatat kehadiran siswa.
            </p>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
    function setAllStatus(status) {
        if (status === 'Hadir') {
            document.querySelectorAll('.status-hadir').forEach(function(radio) {
                radio.checked = true;
            });
        }
    }
</script>
@endpush

