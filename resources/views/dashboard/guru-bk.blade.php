@extends('layouts.app')

@section('title', 'Guru BK Dashboard')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold m-0 text-dark">Dashboard Guru BK</h3>
        <span class="badge bg-indigo px-3 py-2 rounded-pill fs-7" style="background-color: var(--primary);"><i class="bi bi-calendar3 me-2"></i>Tahun Ajaran: Genap 2025/2026</span>
    </div>

    <!-- Quick Stats row -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 glass-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-box stat-icon-primary me-3">
                        <i class="bi bi-chat-heart-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Konseling</h6>
                        <h3 class="fw-bold m-0">{{ $totalCounselings }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 glass-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-box stat-icon-warning me-3">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Antrean Jadwal</h6>
                        <h3 class="fw-bold m-0">{{ $pendingSchedules }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 glass-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-box stat-icon-danger me-3">
                        <i class="bi bi-exclamation-octagon-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Pelanggaran Catat</h6>
                        <h3 class="fw-bold m-0">{{ $totalViolations }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="row g-4 mb-4">
        <!-- Today's Schedule -->
        <div class="col-lg-6">
            <div class="card border-0 glass-card p-4 h-100">
                <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-calendar-day me-2 text-indigo" style="color: var(--primary);"></i>Jadwal Konseling Hari Ini</h5>
                <div class="list-group list-group-flush">
                    @forelse($todaySchedules as $schedule)
                        <div class="list-group-item bg-transparent px-0 py-3 border-bottom d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="fw-bold m-0">{{ $schedule->student->user->name }} ({{ $schedule->student->schoolClass->full_name }})</h6>
                                <small class="text-muted"><i class="bi bi-clock me-1"></i> {{ $schedule->time_start }} - {{ $schedule->time_end }}</small>
                                <p class="m-0 text-secondary fs-7 mt-1">{{ $schedule->notes }}</p>
                            </div>
                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill"><i class="bi bi-check-circle me-1"></i> Disetujui</span>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-calendar-x fs-2 mb-2 d-block"></i>
                            Tidak ada jadwal konseling yang disetujui hari ini.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Violations -->
        <div class="col-lg-6">
            <div class="card border-0 glass-card p-4 h-100">
                <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-activity me-2 text-danger"></i>Pelanggaran Terbaru</h5>
                <div class="table-responsive">
                    <table class="table custom-table align-middle">
                        <thead>
                            <tr>
                                <th style="width: 60px;">No.</th>
                                <th>Siswa</th>
                                <th>Pelanggaran</th>
                                <th>Poin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentViolations as $violation)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="fw-bold d-block">{{ $violation->student->user->name }}</span>
                                        <small class="text-muted">{{ $violation->student->schoolClass->full_name }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-custom badge-{{ $violation->violationType->category }}">{{ $violation->violationType->name }}</span>
                                    </td>
                                    <td class="text-danger fw-bold">+{{ $violation->points_deducted }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Tidak ada pelanggaran tercatat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts row -->
    <div class="row g-4">
        <!-- Monthly counseling trend -->
        <div class="col-lg-8">
            <div class="card border-0 glass-card p-4">
                <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-graph-up me-2 text-primary"></i>Tren Kasus Konseling {{ now()->year }}</h5>
                <div style="height: 300px; position: relative;">
                    <canvas id="monthlyTrendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Category breakdown -->
        <div class="col-lg-4">
            <div class="card border-0 glass-card p-4">
                <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-pie-chart me-2 text-secondary"></i>Kategori Kasus</h5>
                <div style="height: 300px; position: relative; display: flex; align-items: center; justify-content: center;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Trend Chart
        const trendCtx = document.getElementById('monthlyTrendChart').getContext('2d');
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        
        // PHP variables mapped to monthly data
        const monthlyData = @json($monthlyCounselings);

        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Jumlah Sesi Konseling',
                    data: monthlyData,
                    borderColor: '#6366F1',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
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
