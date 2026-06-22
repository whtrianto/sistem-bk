@extends('layouts.app')

@section('title', 'Wali Kelas Dashboard')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold m-0 text-dark">Dashboard Wali Kelas</h3>
        <span class="badge bg-indigo px-3 py-2 rounded-pill fs-7" style="background-color: var(--primary);"><i class="bi bi-calendar3 me-2"></i>Tahun Ajaran: Genap 2025/2026</span>
    </div>

    <!-- Quick Stats row -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 glass-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-box stat-icon-primary me-3">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Siswa Kelas Saya</h6>
                        <h3 class="fw-bold m-0">{{ $totalStudents }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 glass-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-box stat-icon-danger me-3">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Pelanggaran</h6>
                        <h3 class="fw-bold m-0">{{ $totalViolations }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 glass-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-box stat-icon-warning me-3">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Rata-rata Poin</h6>
                        <h3 class="fw-bold m-0">{{ number_format($avgPoints, 1) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row g-4">
        <!-- Classes and Students list -->
        <div class="col-lg-7">
            <div class="card border-0 glass-card p-4 h-100">
                <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-building me-2 text-indigo" style="color: var(--primary);"></i>Daftar Kelas & Siswa</h5>
                
                @forelse($myClasses as $class)
                    <div class="mb-4">
                        <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">
                            Kelas {{ $class->full_name }} ({{ $class->major }})
                        </h6>
                        <div class="table-responsive">
                            <table class="table custom-table align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">No.</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Poin Saat Ini</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($class->students as $student)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $student->nis }}</td>
                                            <td>
                                                <a href="{{ route('points.show', $student->id) }}" class="text-decoration-none fw-semibold text-dark">
                                                    {{ $student->user->name }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $student->current_points <= 25 ? 'success' : ($student->current_points <= 50 ? 'warning' : 'danger') }} px-3 py-2 rounded-pill">
                                                    {{ $student->current_points }} Poin
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-3 text-muted">Belum ada siswa di kelas ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-building-x fs-2 mb-2 d-block"></i>
                        Anda belum ditugaskan sebagai wali kelas di kelas manapun.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Violations for Class Students -->
        <div class="col-lg-5">
            <div class="card border-0 glass-card p-4 h-100">
                <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-exclamation-octagon me-2 text-danger"></i>Pelanggaran Terbaru Siswa</h5>
                <div class="list-group list-group-flush">
                    @forelse($recentViolations as $violation)
                        <div class="list-group-item bg-transparent px-0 py-3 border-bottom">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="fw-bold text-dark">{{ $violation->student->user->name }}</span>
                                <span class="text-danger fw-bold">+{{ $violation->points_deducted }} Poin</span>
                            </div>
                            <span class="badge badge-custom badge-{{ $violation->violationType->category }} mb-2">{{ $violation->violationType->name }}</span>
                            <div class="d-flex align-items-center justify-content-between">
                                <small class="text-muted"><i class="bi bi-calendar-check me-1"></i> {{ $violation->date->format('d/m/Y') }}</small>
                                <small class="text-muted"><i class="bi bi-person me-1"></i> BK: {{ $violation->recorder->name }}</small>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-shield-check fs-2 mb-2 d-block text-success"></i>
                            Belum ada laporan pelanggaran untuk siswa Anda.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
