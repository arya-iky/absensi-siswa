@extends('layouts.app')

@section('title', 'Detail Guru - ' . $guru->nama)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ route('guru.index') }}" class="text-decoration-none">Data Guru</a></li>
                <li class="breadcrumb-item active">Detail Guru</li>
            </ol>
        </nav>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 pb-3 border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 60px; height: 60px; font-size: 1.5rem;">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1 text-dark">{{ $guru->nama }}</h4>
                            <div class="d-flex gap-2 align-items-center">
                                <span class="badge bg-light text-dark border font-monospace">NIP: {{ $guru->nip }}</span>
                                <span class="badge bg-info-subtle text-info">{{ $guru->mata_pelajaran ?? 'Guru' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('guru.edit', $guru->id) }}" class="btn btn-warning px-3">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </a>
                        <a href="{{ route('guru.index') }}" class="btn btn-outline-secondary px-3">Kembali</a>
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block mb-1">Jenis Kelamin</small>
                            <span class="fw-semibold text-dark">{{ $guru->jenis_kelamin }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block mb-1">No. HP / WhatsApp</small>
                            <span class="fw-semibold text-dark">{{ $guru->no_hp ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block mb-1">Alamat</small>
                            <span class="fw-semibold text-dark">{{ $guru->alamat ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

