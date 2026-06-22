@extends('layouts.app')

@section('title', 'Kepala Sekolah Dashboard')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold m-0 text-dark">Dashboard Kepala Sekolah</h3>
        <span class="badge bg-indigo px-3 py-2 rounded-pill fs-7" style="background-color: var(--primary);"><i class="bi bi-calendar3 me-2"></i>Tahun Ajaran: Genap 2025/2026</span>
    </div>

    <!-- Quick Stats row -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 glass-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-box stat-icon-primary me-3">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Siswa Aktif</h6>
                        <h3 class="fw-bold m-0">{{ $totalStudents }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 glass-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-box stat-icon-secondary me-3">
                        <i class="bi bi-chat-heart-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Kasus Konseling</h6>
                        <h3 class="fw-bold m-0">{{ $totalCounselings }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 glass-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-box stat-icon-danger me-3">
                        <i class="bi bi-exclamation-octagon-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Siswa Melanggar</h6>
                        <h3 class="fw-bold m-0">{{ $totalViolations }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 glass-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-box stat-icon-success me-3">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Siswa Berprestasi</h6>
                        <h3 class="fw-bold m-0">{{ $totalAchievements }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts row -->
    <div class="row g-4 mb-4">
        <!-- Monthly comparison trend -->
        <div class="col-lg-8">
            <div class="card border-0 glass-card p-4">
                <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-graph-up-arrow me-2 text-primary"></i>Tren Pelanggaran & Konseling Bulanan {{ now()->year }}</h5>
                <div style="height: 300px; position: relative;">
                    <canvas id="monthlyCompareChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Category breakdown -->
        <div class="col-lg-4">
            <div class="card border-0 glass-card p-4">
                <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-pie-chart me-2 text-secondary"></i>Kategori Kasus Konseling</h5>
                <div style="height: 300px; position: relative; display: flex; align-items: center; justify-content: center;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Class Breakdown Row -->
    <div class="row g-4">
        <div class="col-lg-12">
            <div class="card border-0 glass-card p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="fw-bold m-0 text-dark"><i class="bi bi-bar-chart-steps me-2 text-danger"></i>Pelanggaran Berdasarkan Kelas</h5>
                    <a href="{{ route('reports.index') }}" class="btn btn-link text-decoration-none fw-semibold">Detail Laporan Lengkap <i class="bi bi-arrow-right"></i></a>
                </div>

                <div class="table-responsive">
                    <table class="table custom-table align-middle">
                        <thead>
                            <tr>
                                <th style="width: 60px;">No.</th>
                                <th>Tingkat</th>
                                <th>Nama Kelas</th>
                                <th class="text-center">Total Kasus Pelanggaran</th>
                                <th class="text-center">Tingkat Kasus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($violationByClass as $vc)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold">{{ $vc->level }}</td>
                                    <td>{{ $vc->class_name }}</td>
                                    <td class="text-center fw-bold">{{ $vc->total }}</td>
                                    <td class="text-center">
                                        @if($vc->total > 15)
                                            <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill"><i class="bi bi-exclamation-triangle me-1"></i> Tinggi</span>
                                        @elseif($vc->total > 5)
                                            <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill"><i class="bi bi-shield-alert me-1"></i> Sedang</span>
                                        @else
                                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill"><i class="bi bi-shield-check me-1"></i> Rendah</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada pelanggaran yang dicatat per kelas.</td>
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

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Monthly Compare Chart
        const compareCtx = document.getElementById('monthlyCompareChart').getContext('2d');
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        const violationData = @json($monthlyViolations);
        const counselingData = @json($monthlyCounselings);

        new Chart(compareCtx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Pelanggaran',
                        data: violationData,
                        backgroundColor: 'rgba(239, 68, 68, 0.75)',
                        borderColor: '#EF4444',
                        borderWidth: 1,
                        borderRadius: 6
                    },
                    {
                        label: 'Konseling',
                        data: counselingData,
                        backgroundColor: 'rgba(99, 102, 241, 0.75)',
                        borderColor: '#6366F1',
                        borderWidth: 1,
                        borderRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });

        // Category Chart
        const catCtx = document.getElementById('categoryChart').getContext('2d');
        const categories = @json($categoryCounts->pluck('category.name'));
        const categoryData = @json($categoryCounts->pluck('total'));
        const categoryColors = @json($categoryCounts->pluck('category.color'));

        new Chart(catCtx, {
            type: 'doughnut',
            data: {
                labels: categories,
                datasets: [{
                    data: categoryData,
                    backgroundColor: categoryColors.length ? categoryColors : ['#6366F1', '#8B5CF6', '#EC4899', '#F59E0B'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    });
</script>
@endsection
