@extends('layouts.app')

@section('title', 'Edit Kelas - Sistem Absensi Siswa')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ route('kelas.index') }}" class="text-decoration-none">Data Kelas</a></li>
                <li class="breadcrumb-item active">Edit Kelas</li>
            </ol>
        </nav>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold mb-0 text-dark">Edit Kelas: {{ $kelas->nama_kelas }}</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama_kelas" class="form-label fw-semibold">Nama Kelas <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kelas" id="nama_kelas" 
                               class="form-control @error('nama_kelas') is-invalid @enderror" 
                               value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required>
                        @error('nama_kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jurusan" class="form-label fw-semibold">Program / Kompetensi Keahlian <span class="text-danger">*</span></label>
                        <input type="text" name="jurusan" id="jurusan" 
                               class="form-control @error('jurusan') is-invalid @enderror" 
                               value="{{ old('jurusan', $kelas->jurusan) }}" required>
                        @error('jurusan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="wali_kelas" class="form-label fw-semibold">Wali Kelas</label>
                        <input type="text" name="wali_kelas" id="wali_kelas" 
                               class="form-control @error('wali_kelas') is-invalid @enderror" 
                               value="{{ old('wali_kelas', $kelas->wali_kelas) }}">
                        @error('wali_kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('kelas.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

