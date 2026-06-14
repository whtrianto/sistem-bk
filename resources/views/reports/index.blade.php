@extends('layouts.app')

@section('title', 'Laporan Bulanan')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold m-0 text-dark">Laporan & Statistik Sistem</h3>
        <form action="{{ route('reports.index') }}" method="GET" class="d-flex align-items-center gap-2">
            <select name="year" class="form-select w-auto" onchange="this.form.submit()">
                @for($y = now()->year - 2; $y <= now()->year + 2; $y++)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                @endfor
            </select>
        </form>
    </div>

    <!-- Quick Stats Cards Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 glass-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-box stat-icon-danger me-3">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Pelanggaran</h6>
                        <h3 class="fw-bold m-0">{{ $totalStats['violations'] }}</h3>
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
                        <h6 class="text-muted mb-1">Total Prestasi</h6>
                        <h3 class="fw-bold m-0">{{ $totalStats['achievements'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 glass-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-box stat-icon-primary me-3">
                        <i class="bi bi-chat-heart-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Sesi Konseling</h6>
                        <h3 class="fw-bold m-0">{{ $totalStats['counselings'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 glass-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-box stat-icon-secondary me-3">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Jumlah Siswa</h6>
                        <h3 class="fw-bold m-0">{{ $totalStats['students'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts row -->
    <div class="row g-4 mb-4">
        <!-- Monthly trends chart -->
        <div class="col-lg-8">
            <div class="card border-0 glass-card p-4">
                <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-graph-up me-2 text-primary"></i>Tren Bulanan Tahun {{ $year }}</h5>
                <div style="height: 320px; position: relative;">
                    <canvas id="monthlyTrendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Counseling category distribution doughnut -->
        <div class="col-lg-4">
            <div class="card border-0 glass-card p-4">
                <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-pie-chart-fill me-2 text-secondary"></i>Sebaran Kategori Konseling</h5>
                <div style="height: 320px; position: relative; display: flex; align-items: center; justify-content: center;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Analysis Row -->
    <div class="row g-4">
        <!-- Violations categories breakdown -->
        <div class="col-lg-6">
            <div class="card border-0 glass-card p-4 h-100">
                <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-bar-chart-fill me-2 text-danger"></i>Kategori Kasus Pelanggaran</h5>
                <div style="height: 250px; position: relative; display: flex; align-items: center; justify-content: center;">
                    <canvas id="violationCategoryChart"></canvas>
                </div>
            </div>
        </div>

        <!-- System summary notes -->
        <div class="col-lg-6">
            <div class="card border-0 glass-card p-4 h-100">
                <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-info-circle-fill text-indigo me-2" style="color: var(--primary);"></i>Ringkasan Keaktifan BK</h5>
                <p>Statistik di atas dihimpun secara real-time dari riwayat transaksi poin kredit kedisiplinan dan pencatatan bimbingan konseling di SMK.</p>
                <div class="p-3 bg-light rounded-4">
                    <h6 class="fw-bold text-secondary mb-2">Pedoman Tindak Lanjut:</h6>
                    <ul class="m-0 fs-7 text-secondary">
                        <li>Pastikan siswa dengan skor poin kritis (< 50) diberikan sesi konseling pribadi terarah.</li>
                        <li>Notifikasi pemanggilan orang tua dikirimkan otomatis melalui menu <strong>Surat Panggilan</strong>.</li>
                        <li>Siswa berprestasi dengan kenaikan poin kedisiplinan berhak diajukan dalam usulan beasiswa sekolah.</li>
                    </ul>
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
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        // Monthly trends chart (Line chart comparing Violations, Achievements, Counselings)
        const trendCtx = document.getElementById('monthlyTrendChart').getContext('2d');
        const vData = @json($monthlyViolations);
        const aData = @json($monthlyAchievements);
        const cData = @json($monthlyCounselings);

        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Pelanggaran',
                        data: vData,
                        borderColor: '#EF4444',
                        backgroundColor: 'transparent',
                        borderWidth: 3,
                        tension: 0.3
                    },
                    {
                        label: 'Prestasi',
                        data: aData,
                        borderColor: '#10B981',
                        backgroundColor: 'transparent',
                        borderWidth: 3,
                        tension: 0.3
                    },
                    {
                        label: 'Konseling',
                        data: cData,
                        borderColor: '#6366F1',
                        backgroundColor: 'transparent',
                        borderWidth: 3,
                        tension: 0.3
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

        // Counseling categories doughnut chart
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

        // Violation Category bar chart (Ringan, Sedang, Berat)
        const violCtx = document.getElementById('violationCategoryChart').getContext('2d');
        const violationCats = ['Ringan', 'Sedang', 'Berat'];
        const violationCatData = [
            {{ $violationByCategory['ringan'] ?? 0 }},
            {{ $violationByCategory['sedang'] ?? 0 }},
            {{ $violationByCategory['berat'] ?? 0 }}
        ];

        new Chart(violCtx, {
            type: 'bar',
            data: {
                labels: violationCats,
                datasets: [{
                    label: 'Kasus Pelanggaran',
                    data: violationCatData,
                    backgroundColor: ['rgba(245, 158, 11, 0.75)', 'rgba(139, 92, 246, 0.75)', 'rgba(239, 68, 68, 0.75)'],
                    borderColor: ['#F59E0B', '#8B5CF6', '#EF4444'],
                    borderWidth: 1,
                    borderRadius: 6
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
    });
</script>
@endsection
