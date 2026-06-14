@extends('layouts.app')

@section('title', 'Data Tahun Ajaran')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold m-0 text-dark">Tahun Ajaran</h3>
        <a href="{{ route('academic-years.create') }}" class="btn btn-primary-custom"><i class="bi bi-plus-lg me-2"></i>Tambah Tahun Ajaran</a>
    </div>

    <div class="card border-0 glass-card p-4">
        <div class="table-responsive">
            <table class="table custom-table align-middle">
                <thead>
                    <tr>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($years as $year)
                        <tr>
                            <td class="fw-bold text-dark fs-5">{{ $year->year }}</td>
                            <td class="text-capitalize">{{ $year->semester }}</td>
                            <td>
                                @if($year->is_active)
                                    <span class="badge bg-success px-3 py-2 rounded-pill"><i class="bi bi-check-circle me-1"></i> Aktif</span>
                                @else
                                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    @if(!$year->is_active)
                                        <form action="{{ route('academic-years.toggle-active', $year) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-light btn-sm text-success fw-semibold"><i class="bi bi-play-fill"></i> Aktifkan</button>
                                        </form>
                                    @endif
                                    <a href="{{ route('academic-years.edit', $year) }}" class="btn btn-light btn-sm text-warning"><i class="bi bi-pencil"></i> Edit</a>
                                    <form action="{{ route('academic-years.destroy', $year) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tahun ajaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light btn-sm text-danger"><i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">Belum ada data tahun ajaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $years->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
