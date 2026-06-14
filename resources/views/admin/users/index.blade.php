@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold m-0 text-dark">Manajemen Pengguna</h3>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary-custom"><i class="bi bi-person-plus me-2"></i>Tambah Pengguna</a>
    </div>

    <!-- Search & Filter Card -->
    <div class="card border-0 glass-card p-4 mb-4">
        <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3">
            <div class="col-md-6">
                <label for="search" class="form-label fw-semibold text-secondary">Cari Pengguna</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0 bg-transparent text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" id="search" class="form-control border-start-0" placeholder="Ketik nama atau email..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="col-md-3">
                <label for="role" class="form-label fw-semibold text-secondary">Filter Role</label>
                <select name="role" id="role" class="form-select">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="guru_bk" {{ request('role') == 'guru_bk' ? 'selected' : '' }}>Guru BK</option>
                    <option value="wali_kelas" {{ request('role') == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                    <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="kepsek" {{ request('role') == 'kepsek' ? 'selected' : '' }}>Kepala Sekolah</option>
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary-custom w-100 py-2"><i class="bi bi-funnel me-2"></i>Filter</button>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="card border-0 glass-card p-4">
        <div class="table-responsive">
            <table class="table custom-table align-middle">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. WhatsApp</th>
                        <th>Peran (Role)</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 250px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-initials bg-light text-dark border me-3">{{ substr($user->name, 0, 1) }}</div>
                                    <span class="fw-bold text-dark">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td>
                                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill text-capitalize">{{ $user->role_label }}</span>
                            </td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill"><i class="bi bi-check2-circle me-1"></i> Aktif</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill"><i class="bi bi-x-circle me-1"></i> Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-light btn-sm text-{{ $user->is_active ? 'warning' : 'success' }} fw-semibold">
                                            @if($user->is_active)
                                                <i class="bi bi-person-x"></i> Nonaktifkan
                                            @else
                                                <i class="bi bi-person-check"></i> Aktifkan
                                            @endif
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-light btn-sm text-primary"><i class="bi bi-pencil"></i> Edit</a>
                                    
                                    @if(auth()->id() !== $user->id)
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun pengguna ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm text-danger"><i class="bi bi-trash"></i> Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Akun pengguna tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
