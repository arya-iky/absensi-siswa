@extends('layouts.app')

@section('title', 'Tambah Guru - Sistem Absensi Siswa')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ route('guru.index') }}" class="text-decoration-none">Data Guru</a></li>
                <li class="breadcrumb-item active">Tambah Guru</li>
            </ol>
        </nav>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold mb-0 text-dark">Form Tambah Guru Baru</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('guru.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nip" class="form-label fw-semibold">NIP / NUPTK <span class="text-danger">*</span></label>
                            <input type="text" name="nip" id="nip" 
                                   class="form-control @error('nip') is-invalid @enderror" 
                                   value="{{ old('nip') }}" 
                                   placeholder="Contoh: 198507202010011005" required>
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="nama" class="form-label fw-semibold">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="nama" 
                                   class="form-control @error('nama') is-invalid @enderror" 
                                   value="{{ old('nama') }}" 
                                   placeholder="Contoh: Budi Santoso, S.Kom., M.T." required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold d-block">Jenis Kelamin <span class="text-danger">*</span></label>
                            <div class="d-flex gap-4 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" 
                                           type="radio" name="jenis_kelamin" id="jk_l" value="Laki-laki" 
                                           {{ old('jenis_kelamin') === 'Laki-laki' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="jk_l">Laki-laki</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" 
                                           type="radio" name="jenis_kelamin" id="jk_p" value="Perempuan" 
                                           {{ old('jenis_kelamin') === 'Perempuan' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="jk_p">Perempuan</label>
                                </div>
                            </div>
                            @error('jenis_kelamin')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="mata_pelajaran" class="form-label fw-semibold">Mata Pelajaran yang Diampu</label>
                            <input type="text" name="mata_pelajaran" id="mata_pelajaran" 
                                   class="form-control @error('mata_pelajaran') is-invalid @enderror" 
                                   value="{{ old('mata_pelajaran') }}" 
                                   placeholder="Contoh: Pemrograman Web & Bergerak">
                            @error('mata_pelajaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="no_hp" class="form-label fw-semibold">No. HP / WhatsApp</label>
                            <input type="text" name="no_hp" id="no_hp" 
                                   class="form-control @error('no_hp') is-invalid @enderror" 
                                   value="{{ old('no_hp') }}" 
                                   placeholder="Contoh: 081234567890">
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="alamat" class="form-label fw-semibold">Alamat</label>
                            <textarea name="alamat" id="alamat" rows="3" 
                                      class="form-control @error('alamat') is-invalid @enderror" 
                                      placeholder="Alamat tempat tinggal...">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('guru.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Data Guru</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

