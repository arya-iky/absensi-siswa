@extends('layouts.app')

@section('title', 'Data Siswa - Sistem Absensi Siswa')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6 mb-3 mb-md-0">
        <h3 class="fw-bold text-dark mb-1">Daftar Siswa</h3>
        <p class="text-muted mb-0">Kelola informasi data siswa sekolah untuk pencatatan absensi.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="{{ route('siswa.create') }}" class="btn btn-primary shadow-sm px-3 py-2">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah Siswa Baru
        </a>
    </div>
</div>

{{-- Card Filter & Pencarian --}}
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('siswa.index') }}" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" 
                           placeholder="Cari berdasarkan NIS, Nama, Kelas..." 
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-4">
                <select name="kelas" class="form-select">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($daftarKelas as $k)
                        <option value="{{ $k }}" {{ request('kelas') == $k ? 'selected' : '' }}>
                            Kelas {{ $k }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-filter me-1"></i> Filter
                </button>
                @if(request('search') || request('kelas'))
                    <a href="{{ route('siswa.index') }}" class="btn btn-outline-secondary" title="Reset Filter">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Tabel Data Siswa --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small text-uppercase">
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelamin</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>No. HP</th>
                        <th class="text-center" style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $index => $item)
                        <tr>
                            <td class="text-center text-muted fw-semibold">
                                {{ $students->firstItem() + $index }}
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border font-monospace">
                                    {{ $item->nis }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('siswa.show', $item->id) }}" class="fw-semibold text-decoration-none text-dark hover-primary">
                                    {{ $item->nama }}
                                </a>
                            </td>
                            <td>
                                @if($item->jenis_kelamin === 'Laki-laki')
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                        <i class="bi bi-gender-male me-1"></i>Laki-laki
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                        <i class="bi bi-gender-female me-1"></i>Perempuan
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $item->kelas }}</span>
                            </td>
                            <td class="text-muted">
                                {{ $item->jurusan ?? '-' }}
                            </td>
                            <td class="text-muted">
                                {{ $item->no_hp ?? '-' }}
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('siswa.show', $item->id) }}" class="btn btn-outline-info" title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('siswa.edit', $item->id) }}" class="btn btn-outline-warning" title="Edit Data">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" title="Hapus Data"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal" 
                                            data-id="{{ $item->id }}" 
                                            data-nama="{{ $item->nama }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                    <p class="mb-2 fw-medium">Belum ada data siswa ditemukan.</p>
                                    @if(request('search') || request('kelas'))
                                        <a href="{{ route('siswa.index') }}" class="btn btn-sm btn-outline-secondary">
                                            Reset Pencarian
                                        </a>
                                    @else
                                        <a href="{{ route('siswa.create') }}" class="btn btn-sm btn-primary">
                                            Tambah Siswa Pertama
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($students->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="small text-muted">
                    Menampilkan {{ $students->firstItem() ?? 0 }} sampai {{ $students->lastItem() ?? 0 }} dari {{ $students->total() }} data
                </div>
                <div>
                    {{ $students->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Modal Konfirmasi Hapus --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <i class="bi bi-trash3 text-danger fs-1 d-block mb-3"></i>
                <p class="mb-1">Apakah Anda yakin ingin menghapus siswa ini?</p>
                <h5 class="fw-bold text-dark" id="modalNamaSiswa">-</h5>
                <p class="small text-muted mb-0">Tindakan ini tidak dapat dibatalkan dan seluruh data absensi terkait akan ikut terhapus.</p>
            </div>
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="bi bi-trash-fill me-1"></i> Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');
            
            document.getElementById('modalNamaSiswa').textContent = nama;
            document.getElementById('deleteForm').action = `{{ url('siswa') }}/${id}`;
        });
    }
</script>
@endpush
