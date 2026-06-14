@extends('layouts.app')

@section('title', 'Kategori Pelanggaran')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold m-0 text-dark">Kategori Pelanggaran</h3>
        <a href="{{ route('violation-types.create') }}" class="btn btn-primary-custom"><i class="bi bi-plus-lg me-2"></i>Tambah Kategori</a>
    </div>

    <div class="card border-0 glass-card p-4">
        <div class="table-responsive">
            <table class="table custom-table align-middle">
                <thead>
                    <tr>
                        <th>Nama Pelanggaran</th>
                        <th>Kategori</th>
                        <th>Bobot Poin</th>
                        <th>Keterangan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($types as $type)
                        <tr>
                            <td class="fw-bold text-dark">{{ $type->name }}</td>
                            <td>
                                <span class="badge badge-custom badge-{{ $type->category }}">{{ $type->category }}</span>
                            </td>
                            <td class="fw-bold text-danger">{{ $type->points }} Poin</td>
                            <td>{{ $type->description ?? '-' }}</td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{ route('violation-types.edit', $type) }}" class="btn btn-light btn-sm text-warning"><i class="bi bi-pencil"></i> Edit</a>
                                    <form action="{{ route('violation-types.destroy', $type) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori pelanggaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light btn-sm text-danger"><i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada kategori pelanggaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $types->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
