@extends('layouts.app')

@section('title', 'Data Guru')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold m-0 text-dark">Data Guru (BK & Wali Kelas)</h3>
        <a href="{{ route('teachers.create') }}" class="btn btn-primary-custom"><i class="bi bi-person-plus me-2"></i>Tambah Guru</a>
    </div>

    <!-- Search & Filter Card -->
    <div class="card border-0 glass-card p-4 mb-4">
        <form action="{{ route('teachers.index') }}" method="GET" class="row g-3">
            <div class="col-md-6">
                <label for="search" class="form-label fw-semibold text-secondary">Cari Guru (Nama / NIP / Email)</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0 bg-transparent text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" id="search" class="form-control border-start-0" placeholder="Ketik nama, NIP, atau email..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="col-md-3">
                <label for="role" class="form-label fw-semibold text-secondary">Peran</label>
                <select name="role" id="role" class="form-select">
                    <option value="">Semua Peran</option>
                    <option value="guru_bk" {{ request('role') == 'guru_bk' ? 'selected' : '' }}>Guru BK</option>
                    <option value="wali_kelas" {{ request('role') == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary-custom w-100 py-2"><i class="bi bi-funnel me-2"></i>Filter</button>
            </div>
        </form>
    </div>

    <div class="card border-0 glass-card p-4">
        <div class="table-responsive">
            <table class="table custom-table align-middle">
                <thead>
                    <tr>
                        <th style="width: 60px;">No.</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Peran</th>
                        <th>Spesialisasi / Keahlian</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $user)
                        <tr>
                            <td>{{ $teachers->firstItem() + $loop->index }}</td>
                            <td class="fw-semibold text-secondary">{{ $user->teacher->nip ?? '-' }}</td>
                            <td class="fw-bold text-dark">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $user->role == 'guru_bk' ? 'primary' : 'secondary' }} px-3 py-2 rounded-pill text-capitalize">
                                    {{ $user->role_label }}
                                </span>
                            </td>
                            <td>{{ $user->teacher->specialization ?? '-' }}</td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{ route('teachers.edit', $user) }}" class="btn btn-light btn-sm text-warning"><i class="bi bi-pencil"></i> Edit</a>
                                    <form action="{{ route('teachers.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data guru ini beserta akunnya?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light btn-sm text-danger"><i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">Data guru tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $teachers->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
