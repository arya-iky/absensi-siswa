@extends('layouts.app')

@section('title', 'Edit Data Siswa - Sistem Absensi Siswa')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}" class="text-decoration-none">Data Siswa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('siswa.show', $siswa->id) }}" class="text-decoration-none">{{ $siswa->nama }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>

        {{-- Card Form --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-warning text-dark p-2 rounded-3 d-inline-flex">
                        <i class="bi bi-pencil-square fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">Edit Data Siswa</h5>
                        <small class="text-muted">Perbarui data siswa: <strong>{{ $siswa->nama }}</strong> (NIS: {{ $siswa->nis }})</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        {{-- NIS --}}
                        <div class="col-md-6">
                            <label for="nis" class="form-label fw-semibold">
                                NIS (Nomor Induk Siswa) <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nis" id="nis" 
                                   class="form-control @error('nis') is-invalid @enderror" 
                                   value="{{ old('nis', $siswa->nis) }}" required>
                            @error('nis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nama Lengkap --}}
                        <div class="col-md-6">
                            <label for="nama" class="form-label fw-semibold">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama" id="nama" 
                                   class="form-control @error('nama') is-invalid @enderror" 
                                   value="{{ old('nama', $siswa->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold d-block">
                                Jenis Kelamin <span class="text-danger">*</span>
                            </label>
                            <div class="d-flex gap-4 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" 
                                           type="radio" name="jenis_kelamin" id="jk_l" value="Laki-laki" 
                                           {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'Laki-laki' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="jk_l">
                                        <i class="bi bi-gender-male text-primary me-1"></i> Laki-laki
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" 
                                           type="radio" name="jenis_kelamin" id="jk_p" value="Perempuan" 
                                           {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'Perempuan' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="jk_p">
                                        <i class="bi bi-gender-female text-danger me-1"></i> Perempuan
                                    </label>
                                </div>
                            </div>
                            @error('jenis_kelamin')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kelas --}}
                        <div class="col-md-6">
                            <label for="kelas" class="form-label fw-semibold">
                                Kelas <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="kelas" id="kelas" 
                                   class="form-control @error('kelas') is-invalid @enderror" 
                                   value="{{ old('kelas', $siswa->kelas) }}" required>
                            @error('kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jurusan --}}
                        <div class="col-md-6">
                            <label for="jurusan" class="form-label fw-semibold">Jurusan</label>
                            <input type="text" name="jurusan" id="jurusan" 
                                   class="form-control @error('jurusan') is-invalid @enderror" 
                                   value="{{ old('jurusan', $siswa->jurusan) }}">
                            @error('jurusan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- No. HP --}}
                        <div class="col-md-6">
                            <label for="no_hp" class="form-label fw-semibold">No. HP / WhatsApp Siswa/Wali</label>
                            <input type="text" name="no_hp" id="no_hp" 
                                   class="form-control @error('no_hp') is-invalid @enderror" 
                                   value="{{ old('no_hp', $siswa->no_hp) }}">
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="col-12">
                            <label for="alamat" class="form-label fw-semibold">Alamat Lengkap</label>
                            <textarea name="alamat" id="alamat" rows="3" 
                                      class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $siswa->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('siswa.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
