@extends('layouts.app')

@section('title', 'Data Mata Pelajaran - Sistem Absensi Siswa')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6 mb-3 mb-md-0">
        <h3 class="fw-bold text-dark mb-1">Daftar Mata Pelajaran</h3>
        <p class="text-muted mb-0">Kelola mata pelajaran dan alokasi jam tatap muka.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="{{ route('mapel.create') }}" class="btn btn-primary shadow-sm px-3 py-2">
            <i class="bi bi-journal-plus me-1"></i> Tambah Mapel Baru
        </a>
    </div>
</div>

{{-- Filter & Pencarian --}}
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('mapel.index') }}" class="row g-2">
            <div class="col-md-9">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" 
                           placeholder="Cari kode atau nama mata pelajaran..." 
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary w-100">Cari</button>
                @if(request('search'))
                    <a href="{{ route('mapel.index') }}" class="btn btn-outline-secondary" title="Reset">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Tabel Data Mapel --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small text-uppercase">
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th>Kode Mapel</th>
                        <th>Nama Mata Pelajaran</th>
                        <th class="text-center">Jam Pelajaran</th>
                        <th class="text-center" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $index => $item)
                        <tr>
                            <td class="text-center text-muted fw-semibold">{{ $subjects->firstItem() + $index }}</td>
                            <td><span class="badge bg-light text-dark border font-monospace">{{ $item->kode_mapel }}</span></td>
                            <td class="fw-semibold text-dark">{{ $item->nama_mapel }}</td>
                            <td class="text-center">
                                <span class="badge bg-secondary-subtle text-secondary">{{ $item->jam_pelajaran }} JP</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('mapel.edit', $item->id) }}" class="btn btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" title="Hapus"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal" 
                                            data-id="{{ $item->id }}" 
                                            data-nama="{{ $item->nama_mapel }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-book fs-1 d-block mb-2 text-secondary"></i>
                                <p class="mb-2">Belum ada mata pelajaran yang terdaftar.</p>
                                <a href="{{ route('mapel.create') }}" class="btn btn-sm btn-primary">Tambah Mapel Baru</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($subjects->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $subjects->links('pagination::bootstrap-5') }}
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
                <p class="mb-1">Hapus mata pelajaran:</p>
                <h5 class="fw-bold text-dark" id="modalNamaMapel">-</h5>
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
            document.getElementById('modalNamaMapel').textContent = nama;
            document.getElementById('deleteForm').action = `{{ url('mapel') }}/${id}`;
        });
    }
</script>
@endpush

