<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem BK') -
        {{ \App\Models\SchoolSetting::getValue('school_name', 'SMK Negeri 1 Nusantara') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Custom & Compiled CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('styles')
</head>

<body>
    @auth
        <div class="app-wrapper">
            <!-- Sidebar -->
            <aside class="sidebar" id="sidebar">
                <div class="brand d-flex align-items-center">
                    @if($logo = \App\Models\SchoolSetting::getValue('school_logo'))
                        <img src="{{ asset($logo) }}" alt="Logo" class="me-2 rounded bg-white p-1" style="max-height: 40px; max-width: 40px; object-fit: contain;">
                    @else
                        <i class="bi bi-building-fill me-2 fs-4" style="color: #818CF8;"></i>
                    @endif
                    <span class="brand-title text-truncate" style="max-width: 160px; font-size: 1.05rem;" title="{{ \App\Models\SchoolSetting::getValue('school_name', 'SISTEM BK') }}">
                        {{ \App\Models\SchoolSetting::getValue('school_name', 'SISTEM BK') }}
                    </span>
                    <button class="btn btn-link text-white d-lg-none ms-auto" id="sidebar-close-btn">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <ul class="sidebar-nav">
                    <li class="nav-item {{ Route::is('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- ADMIN ONLY SECTION -->
                    @if(auth()->user()->isAdmin())
                        <li class="nav-header">Data Master</li>
                        <li class="nav-item {{ Route::is('admin.users.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.users.index') }}" class="nav-link">
                                <i class="bi bi-people"></i>
                                <span>Manajemen User</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('teachers.*') ? 'active' : '' }}">
                            <a href="{{ route('teachers.index') }}" class="nav-link">
                                <i class="bi bi-person-workspace"></i>
                                <span>Data Guru</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('students.*') ? 'active' : '' }}">
                            <a href="{{ route('students.index') }}" class="nav-link">
                                <i class="bi bi-mortarboard"></i>
                                <span>Data Siswa</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('classes.*') ? 'active' : '' }}">
                            <a href="{{ route('classes.index') }}" class="nav-link">
                                <i class="bi bi-building"></i>
                                <span>Data Kelas</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('academic-years.*') ? 'active' : '' }}">
                            <a href="{{ route('academic-years.index') }}" class="nav-link">
                                <i class="bi bi-calendar-event"></i>
                                <span>Tahun Ajaran</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('violation-types.*') ? 'active' : '' }}">
                            <a href="{{ route('violation-types.index') }}" class="nav-link">
                                <i class="bi bi-exclamation-triangle"></i>
                                <span>Kategori Pelanggaran</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('achievement-types.*') ? 'active' : '' }}">
                            <a href="{{ route('achievement-types.index') }}" class="nav-link">
                                <i class="bi bi-trophy"></i>
                                <span>Kategori Prestasi</span>
                            </a>
                        </li>

                        <li class="nav-header">Bimbingan & Poin</li>
                        <li class="nav-item {{ Route::is('counselings.*') ? 'active' : '' }}">
                            <a href="{{ route('counselings.index') }}" class="nav-link">
                                <i class="bi bi-chat-square-quote"></i>
                                <span>Catatan Konseling</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('schedules.*') ? 'active' : '' }}">
                            <a href="{{ route('schedules.index') }}" class="nav-link">
                                <i class="bi bi-calendar-check"></i>
                                <span>Jadwal Konseling</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('violations.*') ? 'active' : '' }}">
                            <a href="{{ route('violations.index') }}" class="nav-link">
                                <i class="bi bi-exclamation-octagon"></i>
                                <span>Catatan Pelanggaran</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('achievements.*') ? 'active' : '' }}">
                            <a href="{{ route('achievements.index') }}" class="nav-link">
                                <i class="bi bi-trophy"></i>
                                <span>Catatan Prestasi</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('points.*') ? 'active' : '' }}">
                            <a href="{{ route('points.index') }}" class="nav-link">
                                <i class="bi bi-star"></i>
                                <span>Poin Kredit</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('letters.*') ? 'active' : '' }}">
                            <a href="{{ route('letters.index') }}" class="nav-link">
                                <i class="bi bi-envelope-open"></i>
                                <span>Surat Panggilan</span>
                            </a>
                        </li>

                        <li class="nav-header">Pengaturan & Laporan</li>
                        <li class="nav-item {{ Route::is('reports.index') ? 'active' : '' }}">
                            <a href="{{ route('reports.index') }}" class="nav-link">
                                <i class="bi bi-graph-up-arrow"></i>
                                <span>Laporan Bulanan</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('admin.settings.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.settings.index') }}" class="nav-link">
                                <i class="bi bi-gear"></i>
                                <span>Pengaturan Sekolah</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('admin.settings.wa-logs') ? 'active' : '' }}">
                            <a href="{{ route('admin.settings.wa-logs') }}" class="nav-link">
                                <i class="bi bi-chat-left-text"></i>
                                <span>Log WhatsApp</span>
                            </a>
                        </li>
                    @endif

                    <!-- GURU BK SECTION -->
                    @if(auth()->user()->isGuruBK())
                        <li class="nav-header">Data Master</li>
                        <li class="nav-item {{ Route::is('students.*') ? 'active' : '' }}">
                            <a href="{{ route('students.index') }}" class="nav-link">
                                <i class="bi bi-mortarboard"></i>
                                <span>Data Siswa</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('classes.*') ? 'active' : '' }}">
                            <a href="{{ route('classes.index') }}" class="nav-link">
                                <i class="bi bi-building"></i>
                                <span>Data Kelas</span>
                            </a>
                        </li>

                        <li class="nav-header">Kasus & Konseling</li>
                        <li class="nav-item {{ Route::is('counselings.*') ? 'active' : '' }}">
                            <a href="{{ route('counselings.index') }}" class="nav-link">
                                <i class="bi bi-chat-square-quote"></i>
                                <span>Catatan Konseling</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('schedules.*') ? 'active' : '' }}">
                            <a href="{{ route('schedules.index') }}" class="nav-link">
                                <i class="bi bi-calendar-check"></i>
                                <span>Jadwal Konseling</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('violations.*') ? 'active' : '' }}">
                            <a href="{{ route('violations.index') }}" class="nav-link">
                                <i class="bi bi-exclamation-octagon"></i>
                                <span>Catatan Pelanggaran</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('achievements.*') ? 'active' : '' }}">
                            <a href="{{ route('achievements.index') }}" class="nav-link">
                                <i class="bi bi-trophy"></i>
                                <span>Catatan Prestasi</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('points.*') ? 'active' : '' }}">
                            <a href="{{ route('points.index') }}" class="nav-link">
                                <i class="bi bi-star"></i>
                                <span>Poin Kredit</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('letters.*') ? 'active' : '' }}">
                            <a href="{{ route('letters.index') }}" class="nav-link">
                                <i class="bi bi-envelope-open"></i>
                                <span>Surat Panggilan</span>
                            </a>
                        </li>

                        <li class="nav-header">Laporan</li>
                        <li class="nav-item {{ Route::is('reports.index') ? 'active' : '' }}">
                            <a href="{{ route('reports.index') }}" class="nav-link">
                                <i class="bi bi-graph-up-arrow"></i>
                                <span>Laporan Bulanan</span>
                            </a>
                        </li>
                    @endif

                    <!-- WALI KELAS SECTION -->
                    @if(auth()->user()->isWaliKelas())
                        <li class="nav-header">Kelas Saya</li>
                        <li class="nav-item {{ Route::is('counselings.*') ? 'active' : '' }}">
                            <a href="{{ route('counselings.index') }}" class="nav-link">
                                <i class="bi bi-chat-square-quote"></i>
                                <span>Catatan Konseling</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('violations.*') ? 'active' : '' }}">
                            <a href="{{ route('violations.index') }}" class="nav-link">
                                <i class="bi bi-exclamation-octagon"></i>
                                <span>Pelanggaran Siswa</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('achievements.*') ? 'active' : '' }}">
                            <a href="{{ route('achievements.index') }}" class="nav-link">
                                <i class="bi bi-trophy"></i>
                                <span>Prestasi Siswa</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('points.*') ? 'active' : '' }}">
                            <a href="{{ route('points.index') }}" class="nav-link">
                                <i class="bi bi-star"></i>
                                <span>Poin Kredit Siswa</span>
                            </a>
                        </li>
                    @endif

                    <!-- SISWA SECTION -->
                    @if(auth()->user()->isSiswa())
                        <li class="nav-header">Bimbingan</li>
                        <li class="nav-item {{ Route::is('schedules.*') ? 'active' : '' }}">
                            <a href="{{ route('schedules.index') }}" class="nav-link">
                                <i class="bi bi-calendar-plus"></i>
                                <span>Pengajuan Konseling</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('points.*') ? 'active' : '' }}">
                            <a href="{{ route('points.show', auth()->user()->student->id ?? 0) }}" class="nav-link">
                                <i class="bi bi-star-fill"></i>
                                <span>Riwayat Poin Saya</span>
                            </a>
                        </li>
                    @endif

                    <!-- KEPSEK SECTION -->
                    @if(auth()->user()->isKepsek())
                        <li class="nav-header">Pemantauan</li>
                        <li class="nav-item {{ Route::is('reports.index') ? 'active' : '' }}">
                            <a href="{{ route('reports.index') }}" class="nav-link">
                                <i class="bi bi-graph-up-arrow"></i>
                                <span>Laporan Sekolah</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('points.ranking') ? 'active' : '' }}">
                            <a href="{{ route('points.ranking') }}" class="nav-link">
                                <i class="bi bi-list-ol"></i>
                                <span>Ranking Poin</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </aside>

            <!-- Main Content Wrapper -->
            <div class="main-content">
                <!-- Topbar -->
                <header class="topbar">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-link text-dark d-lg-none me-3" id="sidebar-toggle-btn">
                            <i class="bi bi-list fs-3"></i>
                        </button>
                        <h5 class="m-0 fw-bold d-none d-sm-block text-secondary">
                            {{ \App\Models\SchoolSetting::getValue('school_name', 'SMK Negeri 1 Nusantara') }}
                        </h5>
                    </div>

                    <div class="dropdown">
                        <button class="user-profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <div class="avatar-initials me-2">{{ substr(auth()->user()->name, 0, 1) }}</div>
                            <div class="text-start d-none d-md-block">
                                <div class="fw-bold fs-7">{{ auth()->user()->name }}</div>
                                <small class="text-muted text-capitalize"
                                    style="font-size: 11px;">{{ auth()->user()->role_label }}</small>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </header>

                <!-- Main Page Content Body -->
                <main class="content-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show glass-card mb-4 border-0 border-start border-5 border-success text-success"
                            role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show glass-card mb-4 border-0 border-start border-5 border-danger text-danger"
                            role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    @else
        @yield('content')
    @endauth

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Sidebar Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('sidebar-toggle-btn');
            const closeBtn = document.getElementById('sidebar-close-btn');
            const sidebar = document.getElementById('sidebar');

            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function () {
                    sidebar.classList.add('show');
                });
            }

            if (closeBtn && sidebar) {
                closeBtn.addEventListener('click', function () {
                    sidebar.classList.remove('show');
                });
            }
        });
    </script>

    @yield('scripts')
</body>

</html>