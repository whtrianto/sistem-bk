@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold m-0 text-dark">Data Siswa</h3>
        <a href="{{ route('students.create') }}" class="btn btn-primary-custom"><i class="bi bi-person-plus me-2"></i>Tambah Siswa</a>
    </div>

    <!-- Search & Filter Card -->
    <div class="card border-0 glass-card p-4 mb-4">
        <form action="{{ route('students.index') }}" method="GET" class="row g-3">
            <div class="col-md-5">
                <label for="search" class="form-label fw-semibold text-secondary">Cari Nama / NIS</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0 bg-transparent text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" id="search" class="form-control border-start-0" placeholder="Ketik nama atau nomor induk..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="col-md-4">
                <label for="class_id" class="form-label fw-semibold text-secondary">Filter Kelas</label>
                <select name="class_id" id="class_id" class="form-select">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary-custom w-100 py-2"><i class="bi bi-funnel me-2"></i>Terapkan Filter</button>
            </div>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="card border-0 glass-card p-4">
        <div class="table-responsive">
            <table class="table custom-table align-middle">
                <thead>
                    <tr>
                        <th style="width: 60px;">No.</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Gender</th>
                        <th>Poin Kredit</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td>{{ $students->firstItem() + $loop->index }}</td>
                            <td class="fw-semibold text-secondary">{{ $student->nis }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $student->user->name }}</div>
                                <small class="text-muted">{{ $student->user->email }}</small>
                            </td>
                            <td>{{ $student->schoolClass->full_name ?? 'Tanpa Kelas' }}</td>
                            <td>{{ $student->gender_label }}</td>
                            <td>
                                <span class="badge bg-{{ $student->current_points >= 75 ? 'success' : ($student->current_points >= 50 ? 'warning' : 'danger') }} px-3 py-2 rounded-pill">
                                    {{ $student->current_points }} Poin
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{ route('students.show', $student) }}" class="btn btn-light btn-sm text-primary" title="Detail Siswa"><i class="bi bi-eye"></i> Detail</a>
                                    <a href="{{ route('students.edit', $student) }}" class="btn btn-light btn-sm text-warning" title="Edit Siswa"><i class="bi bi-pencil"></i> Edit</a>
                                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light btn-sm text-danger" title="Hapus Siswa"><i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">Data siswa tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $students->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
