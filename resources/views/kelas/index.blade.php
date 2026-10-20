@extends('layouts.app')

@section('title', 'Data Kelas - Sistem Absensi Siswa')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6 mb-3 mb-md-0">
        <h3 class="fw-bold text-dark mb-1">Daftar Kelas</h3>
        <p class="text-muted mb-0">Kelola informasi ruang kelas dan penugasan wali kelas.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="{{ route('kelas.create') }}" class="btn btn-primary shadow-sm px-3 py-2">
            <i class="bi bi-plus-circle-fill me-1"></i> Tambah Kelas Baru
        </a>
    </div>
</div>

{{-- Filter & Pencarian --}}
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('kelas.index') }}" class="row g-2">
            <div class="col-md-9">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" 
                           placeholder="Cari nama kelas, jurusan, atau wali kelas..." 
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-filter me-1"></i> Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('kelas.index') }}" class="btn btn-outline-secondary" title="Reset">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Tabel Data Kelas --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small text-uppercase">
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th>Nama Kelas</th>
                        <th>Jurusan / Keahlian</th>
                        <th>Wali Kelas</th>
                        <th class="text-center" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $index => $item)
                        <tr>
                            <td class="text-center text-muted fw-semibold">
                                {{ $classes->firstItem() + $index }}
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-6">
                                    {{ $item->nama_kelas }}
                                </span>
                            </td>
                            <td class="fw-medium text-dark">
                                {{ $item->jurusan }}
                            </td>
                            <td class="text-muted">
                                <i class="bi bi-person-badge me-1"></i> {{ $item->wali_kelas ?? '-' }}
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('kelas.edit', $item->id) }}" class="btn btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" title="Hapus"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal" 
                                            data-id="{{ $item->id }}" 
                                            data-nama="{{ $item->nama_kelas }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-door-closed fs-1 d-block mb-2 text-secondary"></i>
                                <p class="mb-2">Belum ada data kelas yang terdaftar.</p>
                                <a href="{{ route('kelas.create') }}" class="btn btn-sm btn-primary">Tambah Kelas Baru</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($classes->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $classes->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

{{-- Modal Hapus --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i> Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <p class="mb-1">Hapus kelas:</p>
                <h5 class="fw-bold text-dark" id="modalNamaKelas">-</h5>
            </div>
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4">Hapus</button>
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
            document.getElementById('modalNamaKelas').textContent = nama;
            document.getElementById('deleteForm').action = `{{ url('kelas') }}/${id}`;
        });
    }
</script>
@endpush

