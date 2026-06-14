@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold m-0 text-dark">Dashboard</h3>
        <span class="badge bg-primary px-3 py-2 rounded-pill fs-7"><i class="bi bi-calendar3 me-2"></i>Tahun Ajaran: Genap 2025/2026</span>
    </div>

    <!-- Quick Stats Row -->
    <div class="row g-4 mb-4">
        <!-- Users Card -->
        <div class="col-md-3">
            <div class="card border-0 glass-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-box stat-icon-primary me-3">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Pengguna</h6>
                        <h3 class="fw-bold m-0">{{ $totalUsers }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students Card -->
        <div class="col-md-3">
            <div class="card border-0 glass-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-box stat-icon-success me-3">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Siswa</h6>
                        <h3 class="fw-bold m-0">{{ $totalStudents }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teachers Card -->
        <div class="col-md-3">
            <div class="card border-0 glass-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-box stat-icon-warning me-3">
                        <i class="bi bi-person-workspace"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Guru</h6>
                        <h3 class="fw-bold m-0">{{ $totalTeachers }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Classes Card -->
        <div class="col-md-3">
            <div class="card border-0 glass-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-box stat-icon-secondary me-3">
                        <i class="bi bi-building-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Kelas</h6>
                        <h3 class="fw-bold m-0">{{ $totalClasses }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row g-4">
        <!-- Quick Links -->
        <div class="col-lg-4">
            <div class="card border-0 glass-card p-4 h-100">
                <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-lightning-fill text-warning me-2"></i>Aksi Cepat</h5>
                
                <div class="d-grid gap-3">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-outline-primary d-flex align-items-center justify-content-between p-3 rounded-4 border-2 transition-smooth">
                        <span class="fw-semibold"><i class="bi bi-person-plus me-2"></i>Tambah Pengguna</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="{{ route('students.create') }}" class="btn btn-outline-success d-flex align-items-center justify-content-between p-3 rounded-4 border-2 transition-smooth">
                        <span class="fw-semibold"><i class="bi bi-mortarboard me-2"></i>Tambah Siswa</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="{{ route('classes.create') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-between p-3 rounded-4 border-2 transition-smooth">
                        <span class="fw-semibold"><i class="bi bi-building me-2"></i>Tambah Kelas</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-dark d-flex align-items-center justify-content-between p-3 rounded-4 border-2 transition-smooth">
                        <span class="fw-semibold"><i class="bi bi-gear me-2"></i>Konfigurasi Sistem</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Users Table -->
        <div class="col-lg-8">
            <div class="card border-0 glass-card p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="fw-bold m-0 text-dark"><i class="bi bi-clock-history me-2 text-primary"></i>Pengguna Baru Ditambahkan</h5>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-link text-decoration-none fw-semibold">Semua User <i class="bi bi-arrow-right"></i></a>
                </div>

                <div class="table-responsive">
                    <table class="table custom-table align-middle">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentUsers as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-initials me-3 bg-secondary-subtle text-secondary">{{ substr($user->name, 0, 1) }}</div>
                                            <span class="fw-semibold">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark text-capitalize px-3 py-2 border rounded-pill">{{ $user->role_label }}</span>
                                    </td>
                                    <td>
                                        @if($user->is_active)
                                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill"><i class="bi bi-check2-circle me-1"></i> Aktif</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill"><i class="bi bi-x-circle me-1"></i> Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada data pengguna baru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
