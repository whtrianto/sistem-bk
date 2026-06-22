@extends('layouts.app')

@section('title', 'Siswa Dashboard')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold m-0 text-dark">Dashboard Siswa</h3>
        <span class="badge bg-indigo px-3 py-2 rounded-pill fs-7" style="background-color: var(--primary);"><i class="bi bi-calendar3 me-2"></i>Tahun Ajaran: Genap 2025/2026</span>
    </div>

    <!-- Quick Stats row -->
    <div class="row g-4 mb-4">
        <!-- My Points Card -->
        <div class="col-md-6">
            <div class="card border-0 glass-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-box me-3 bg-{{ $currentPoints <= 25 ? 'success' : ($currentPoints <= 50 ? 'warning' : 'danger') }}-subtle text-{{ $currentPoints <= 25 ? 'success' : ($currentPoints <= 50 ? 'warning' : 'danger') }}">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Poin Pelanggaran Saya</h6>
                        <h3 class="fw-bold m-0">{{ $currentPoints }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Violations Card -->
        <div class="col-md-6">
            <div class="card border-0 glass-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-box stat-icon-danger me-3">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Jumlah Pelanggaran</h6>
                        <h3 class="fw-bold m-0">{{ $totalViolations }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Upcoming approved counselings and booking actions -->
        <div class="col-lg-6">
            <div class="card border-0 glass-card p-4 mb-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="fw-bold m-0 text-dark"><i class="bi bi-calendar2-check-fill text-primary me-2"></i>Jadwal Konseling Terdekat</h5>
                    <a href="{{ route('schedules.create') }}" class="btn btn-primary-custom btn-sm"><i class="bi bi-plus-lg me-1"></i> Ajukan Konseling</a>
                </div>

                <div class="list-group list-group-flush">
                    @forelse($upcomingSchedules as $sch)
                        <div class="list-group-item bg-transparent px-0 py-3 border-bottom d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="fw-bold m-0">{{ $sch->counselor->name }}</h6>
                                <small class="text-muted"><i class="bi bi-calendar-event me-1"></i> {{ $sch->date->format('d/m/Y') }} | <i class="bi bi-clock me-1"></i> {{ $sch->time_start }} - {{ $sch->time_end }}</small>
                                <p class="m-0 text-secondary fs-7 mt-1">{{ $sch->notes }}</p>
                            </div>
                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill"><i class="bi bi-check-circle me-1"></i> Disetujui</span>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-calendar-x fs-3 mb-2 d-block"></i>
                            Tidak ada jadwal konseling terdekat.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- My Booked Schedules Status -->
            <div class="card border-0 glass-card p-4">
                <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-list-check text-secondary me-2"></i>Status Pengajuan Konseling</h5>
                <div class="table-responsive">
                    <table class="table custom-table align-middle">
                        <thead>
                            <tr>
                                <th style="width: 60px;">No.</th>
                                <th>Konselor</th>
                                <th>Tanggal & Waktu</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mySchedules as $sch)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sch->counselor->name }}</td>
                                    <td>
                                        <span class="d-block fw-semibold">{{ $sch->date->format('d/m/Y') }}</span>
                                        <small class="text-muted">{{ $sch->time_start }} - {{ $sch->time_end }}</small>
                                    </td>
                                    <td>
                                        @if($sch->status === 'pending')
                                            <span class="badge bg-warning-subtle text-warning px-2 py-1 rounded-pill"><i class="bi bi-hourglass-split me-1"></i> Pending</span>
                                        @elseif($sch->status === 'approved')
                                            <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill"><i class="bi bi-check-circle me-1"></i> Disetujui</span>
                                        @elseif($sch->status === 'completed')
                                            <span class="badge bg-primary-subtle text-primary px-2 py-1 rounded-pill"><i class="bi bi-check-all me-1"></i> Selesai</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger px-2 py-1 rounded-pill" title="{{ $sch->rejection_reason }}"><i class="bi bi-x-circle me-1"></i> Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">Belum ada pengajuan konseling.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Point History Timeline -->
        <div class="col-lg-6">
            <div class="card border-0 glass-card p-4 h-100">
                <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-clock-history text-danger me-2"></i>Riwayat Aktivitas Poin</h5>
                
                <div class="timeline">
                    @forelse($recentHistory as $log)
                        <div class="timeline-item">
                            <div class="timeline-marker deduction"></div>
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="fw-bold text-dark">{{ $log->description }}</span>
                                <span class="fw-bold text-danger">
                                    +{{ $log->points }} Poin
                                </span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <small class="text-muted"><i class="bi bi-calendar-event me-1"></i> {{ $log->date->format('d/m/Y') }}</small>
                                <small class="text-muted">Saldo akhir: <strong>{{ $log->balance_after }} Poin</strong></small>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-shield-check fs-2 mb-2 d-block text-success"></i>
                            Poin Anda masih utuh! Belum ada riwayat aktivitas poin.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
