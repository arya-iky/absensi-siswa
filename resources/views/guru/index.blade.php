@extends('layouts.app')

@section('title', 'Data Guru - Sistem Absensi Siswa')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6 mb-3 mb-md-0">
        <h3 class="fw-bold text-dark mb-1">Daftar Guru Pengajar</h3>
        <p class="text-muted mb-0">Kelola data tenaga pendidik dan guru pengampu absensi.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="{{ route('guru.create') }}" class="btn btn-primary shadow-sm px-3 py-2">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah Guru Baru
        </a>
    </div>
</div>

{{-- Filter & Pencarian --}}
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('guru.index') }}" class="row g-2">
            <div class="col-md-9">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" 
                           placeholder="Cari NIP, nama guru, atau mata pelajaran..." 
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary w-100">Cari</button>
                @if(request('search'))
                    <a href="{{ route('guru.index') }}" class="btn btn-outline-secondary" title="Reset">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Tabel Data Guru --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small text-uppercase">
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th>NIP / NUPTK</th>
                        <th>Nama Lengkap</th>
                        <th>L/P</th>
                        <th>Mata Pelajaran</th>
                        <th>No. HP</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $index => $item)
                        <tr>
                            <td class="text-center text-muted fw-semibold">{{ $teachers->firstItem() + $index }}</td>
                            <td><span class="badge bg-light text-dark border font-monospace">{{ $item->nip }}</span></td>
                            <td class="fw-semibold text-dark">{{ $item->nama }}</td>
                            <td>
                                @if($item->jenis_kelamin === 'Laki-laki')
                                    <span class="badge bg-primary-subtle text-primary">L</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">P</span>
                                @endif
                            </td>
                            <td>{{ $item->mata_pelajaran ?? '-' }}</td>
                            <td>{{ $item->no_hp ?? '-' }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('guru.show', $item->id) }}" class="btn btn-outline-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('guru.edit', $item->id) }}" class="btn btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" title="Hapus"
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
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-person-x fs-1 d-block mb-2 text-secondary"></i>
                                <p class="mb-2">Belum ada data guru yang terdaftar.</p>
                                <a href="{{ route('guru.create') }}" class="btn btn-sm btn-primary">Tambah Guru Baru</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($teachers->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $teachers->links('pagination::bootstrap-5') }}
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
                <p class="mb-1">Hapus guru:</p>
                <h5 class="fw-bold text-dark" id="modalNamaGuru">-</h5>
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
            document.getElementById('modalNamaGuru').textContent = nama;
            document.getElementById('deleteForm').action = `{{ url('guru') }}/${id}`;
        });
    }
</script>
@endpush

