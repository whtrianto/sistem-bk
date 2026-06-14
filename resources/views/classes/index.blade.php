@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold m-0 text-dark">Data Kelas</h3>
        <a href="{{ route('classes.create') }}" class="btn btn-primary-custom"><i class="bi bi-plus-lg me-2"></i>Tambah Kelas</a>
    </div>

    <div class="card border-0 glass-card p-4">
        <div class="table-responsive">
            <table class="table custom-table align-middle">
                <thead>
                    <tr>
                        <th>Tingkat</th>
                        <th>Nama Kelas</th>
                        <th>Kompetensi Keahlian (Jurusan)</th>
                        <th>Tahun Ajaran</th>
                        <th>Wali Kelas</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $class)
                        <tr>
                            <td class="fw-bold fs-5 text-secondary">{{ $class->level }}</td>
                            <td class="fw-bold text-dark">{{ $class->name }}</td>
                            <td>{{ $class->major ?? '-' }}</td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1">{{ $class->academicYear->year }} ({{ $class->academicYear->semester }})</span>
                            </td>
                            <td>
                                @if($class->waliKelas)
                                    <div class="fw-semibold text-dark">{{ $class->waliKelas->name }}</div>
                                @else
                                    <span class="text-muted italic">Belum ditentukan</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{ route('classes.edit', $class) }}" class="btn btn-light btn-sm text-warning"><i class="bi bi-pencil"></i> Edit</a>
                                    <form action="{{ route('classes.destroy', $class) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light btn-sm text-danger"><i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada data kelas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $classes->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
