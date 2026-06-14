@extends('layouts.app')

@section('title', 'Detail Siswa: ' . $student->user->name)

@section('content')
<div class="container-fluid fade-in-section">
    <div class="mb-4">
        @if(auth()->user()->isAdmin() || auth()->user()->isGuruBK())
            <a href="{{ route('students.index') }}" class="btn btn-link text-decoration-none p-0"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Siswa</a>
        @else
            <a href="javascript:history.back()" class="btn btn-link text-decoration-none p-0"><i class="bi bi-arrow-left"></i> Kembali</a>
        @endif
    </div>

    <!-- Student Header Profile Card -->
    <div class="card border-0 glass-card p-4 mb-4">
        <div class="row align-items-center">
            <div class="col-md-auto text-center mb-3 mb-md-0">
                <div class="avatar-initials bg-primary text-white mx-auto" style="width: 80px; height: 80px; font-size: 2.2rem;">
                    {{ substr($student->user->name, 0, 1) }}
                </div>
            </div>
            <div class="col-md">
                <div class="d-flex flex-wrap align-items-center gap-3 justify-content-center justify-content-md-start">
                    <h3 class="fw-bold m-0 text-dark">{{ $student->user->name }}</h3>
                    <span class="badge bg-{{ $student->current_points >= 75 ? 'success' : ($student->current_points >= 50 ? 'warning' : 'danger') }} px-3 py-2 rounded-pill fs-7">
                        {{ $student->current_points }} Poin
                    </span>
                </div>
                <p class="text-muted text-center text-md-start m-0 mt-1">
                    {{ $student->nis }} &bull; Kelas {{ $student->schoolClass->full_name ?? 'Tanpa Kelas' }} &bull; {{ $student->gender_label }}
                </p>
                <p class="text-muted text-center text-md-start m-0">
                    <i class="bi bi-envelope me-1"></i> {{ $student->user->email }}
                </p>
            </div>
            @if(auth()->user()->isAdmin() || auth()->user()->isGuruBK())
                <div class="col-md-auto text-center text-md-end mt-3 mt-md-0">
                    <a href="{{ route('students.edit', $student) }}" class="btn btn-outline-warning"><i class="bi bi-pencil me-1"></i> Edit Profil</a>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Stats Cards Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 glass-card p-3 text-center">
                <h6 class="text-muted mb-1">Total Pelanggaran</h6>
                <h3 class="fw-bold m-0 text-danger">{{ $student->violations->count() }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 glass-card p-3 text-center">
                <h6 class="text-muted mb-1">Total Prestasi</h6>
                <h3 class="fw-bold m-0 text-success">{{ $student->achievements->count() }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 glass-card p-3 text-center">
                <h6 class="text-muted mb-1">Kasus Konseling</h6>
                <h3 class="fw-bold m-0 text-primary">{{ $student->counselings->count() }}</h3>
            </div>
        </div>
    </div>

    <!-- Tabbed Details -->
    <div class="card border-0 glass-card p-4">
        <!-- Tab Navigation -->
        <ul class="nav nav-pills mb-4" id="studentTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true"><i class="bi bi-person me-1"></i> Detail Profil</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="violations-tab" data-bs-toggle="tab" data-bs-target="#violations" type="button" role="tab" aria-controls="violations" aria-selected="false"><i class="bi bi-exclamation-octagon me-1"></i> Pelanggaran ({{ $student->violations->count() }})</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="achievements-tab" data-bs-toggle="tab" data-bs-target="#achievements" type="button" role="tab" aria-controls="achievements" aria-selected="false"><i class="bi bi-trophy me-1"></i> Prestasi ({{ $student->achievements->count() }})</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="counseling-tab" data-bs-toggle="tab" data-bs-target="#counseling" type="button" role="tab" aria-controls="counseling" aria-selected="false"><i class="bi bi-chat-heart me-1"></i> Konseling ({{ $student->counselings->count() }})</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="points-tab" data-bs-toggle="tab" data-bs-target="#points" type="button" role="tab" aria-controls="points" aria-selected="false"><i class="bi bi-clock-history me-1"></i> Riwayat Poin</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="studentTabsContent">
            <!-- Profile Tab -->
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Informasi Pribadi & Akademik</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-semibold text-muted" style="width: 35%;">NISN</td>
                                <td>: {{ $student->nisn ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">Tempat Lahir</td>
                                <td>: {{ $student->birth_place ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">Tanggal Lahir</td>
                                <td>: {{ $student->birth_date ? $student->birth_date->format('d/m/Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">Alamat</td>
                                <td>: {{ $student->address ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Informasi Orang Tua / Wali</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-semibold text-muted" style="width: 35%;">Nama Wali</td>
                                <td>: {{ $student->parent_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">No. WhatsApp</td>
                                <td>: {{ $student->parent_phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">Alamat Wali</td>
                                <td>: {{ $student->parent_address ?? $student->address ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Violations Tab -->
            <div class="tab-pane fade" id="violations" role="tabpanel" aria-labelledby="violations-tab">
                <div class="table-responsive">
                    <table class="table custom-table align-middle">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Pelanggaran</th>
                                <th>Kategori</th>
                                <th>Keterangan</th>
                                <th>Poin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($student->violations as $violation)
                                <tr>
                                    <td>{{ $violation->date->format('d/m/Y') }}</td>
                                    <td class="fw-bold">{{ $violation->violationType->name }}</td>
                                    <td>
                                        <span class="badge badge-custom badge-{{ $violation->violationType->category }}">{{ $violation->violationType->category }}</span>
                                    </td>
                                    <td>{{ $violation->description ?? '-' }}</td>
                                    <td class="text-danger fw-bold">-{{ $violation->points_deducted }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Tidak ada catatan pelanggaran untuk siswa ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Achievements Tab -->
            <div class="tab-pane fade" id="achievements" role="tabpanel" aria-labelledby="achievements-tab">
                <div class="table-responsive">
                    <table class="table custom-table align-middle">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Prestasi</th>
                                <th>Kategori</th>
                                <th>Keterangan</th>
                                <th>Poin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($student->achievements as $achievement)
                                <tr>
                                    <td>{{ $achievement->date->format('d/m/Y') }}</td>
                                    <td class="fw-bold">{{ $achievement->achievementType->name }}</td>
                                    <td>
                                        <span class="badge badge-custom badge-{{ $achievement->achievementType->category }}">{{ $achievement->achievementType->category }}</span>
                                    </td>
                                    <td>{{ $achievement->description ?? '-' }}</td>
                                    <td class="text-success fw-bold">+{{ $achievement->points_added }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Tidak ada catatan prestasi untuk siswa ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Counseling Tab -->
            <div class="tab-pane fade" id="counseling" role="tabpanel" aria-labelledby="counseling-tab">
                <div class="table-responsive">
                    <table class="table custom-table align-middle">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Konselor</th>
                                <th>Masalah</th>
                                <th>Solusi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($student->counselings as $counseling)
                                <tr>
                                    <td>{{ $counseling->date->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill"><i class="bi bi-tag-fill me-1" style="color: {{ $counseling->category->color }};"></i>{{ $counseling->category->name }}</span>
                                    </td>
                                    <td>{{ $counseling->counselor->name }}</td>
                                    <td>{{ Str::limit($counseling->problem, 40) }}</td>
                                    <td>{{ Str::limit($counseling->solution, 40) ?? '-' }}</td>
                                    <td>
                                        @if($counseling->status === 'pending')
                                            <span class="badge bg-warning-subtle text-warning px-2 py-1 rounded-pill">Pending</span>
                                        @elseif($counseling->status === 'ongoing')
                                            <span class="badge bg-primary-subtle text-primary px-2 py-1 rounded-pill">Ongoing</span>
                                        @else
                                            <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Tidak ada sesi konseling tercatat untuk siswa ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Point History Timeline Tab -->
            <div class="tab-pane fade" id="points" role="tabpanel" aria-labelledby="points-tab">
                <div class="timeline mt-3">
                    @forelse($student->pointHistories as $log)
                        <div class="timeline-item">
                            <div class="timeline-marker {{ $log->points < 0 ? 'deduction' : 'addition' }}"></div>
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="fw-bold text-dark">{{ $log->description }}</span>
                                <span class="fw-bold text-{{ $log->points < 0 ? 'danger' : 'success' }}">
                                    {{ $log->points < 0 ? '' : '+' }}{{ $log->points }} Poin
                                </span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <small class="text-muted"><i class="bi bi-calendar-event me-1"></i> {{ $log->date->format('d/m/Y') }}</small>
                                <small class="text-muted">Saldo akhir: <strong>{{ $log->balance_after }} Poin</strong></small>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">Tidak ada riwayat aktivitas poin.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
