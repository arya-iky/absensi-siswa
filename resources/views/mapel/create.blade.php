@extends('layouts.app')

@section('title', 'Tambah Mata Pelajaran - Sistem Absensi Siswa')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ route('mapel.index') }}" class="text-decoration-none">Data Mapel</a></li>
                <li class="breadcrumb-item active">Tambah Mapel</li>
            </ol>
        </nav>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold mb-0 text-dark">Form Tambah Mata Pelajaran</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('mapel.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="kode_mapel" class="form-label fw-semibold">Kode Mapel <span class="text-danger">*</span></label>
                        <input type="text" name="kode_mapel" id="kode_mapel" 
                               class="form-control @error('kode_mapel') is-invalid @enderror" 
                               value="{{ old('kode_mapel') }}" 
                               placeholder="Contoh: MP-01, RPL-02" required>
                        @error('kode_mapel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_mapel" class="form-label fw-semibold">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                        <input type="text" name="nama_mapel" id="nama_mapel" 
                               class="form-control @error('nama_mapel') is-invalid @enderror" 
                               value="{{ old('nama_mapel') }}" 
                               placeholder="Contoh: Pemrograman Berorientasi Objek" required>
                        @error('nama_mapel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jam_pelajaran" class="form-label fw-semibold">Jumlah Jam Pelajaran (JP) <span class="text-danger">*</span></label>
                        <input type="number" name="jam_pelajaran" id="jam_pelajaran" 
                               class="form-control @error('jam_pelajaran') is-invalid @enderror" 
                               value="{{ old('jam_pelajaran', 2) }}" min="1" max="10" required>
                        @error('jam_pelajaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('mapel.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Mapel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

