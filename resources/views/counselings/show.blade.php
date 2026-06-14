@extends('layouts.app')

@section('title', 'Detail Bimbingan')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="mb-4">
        <a href="{{ route('counselings.index') }}" class="btn btn-link text-decoration-none p-0"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Bimbingan</a>
        <h3 class="fw-bold mt-2 text-dark">Rincian Bimbingan Konseling</h3>
    </div>

    <div class="row g-4">
        <!-- Main details -->
        <div class="col-lg-7">
            <div class="card border-0 glass-card p-4 mb-4">
                <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-2">
                    <h5 class="fw-bold m-0 text-dark"><i class="bi bi-file-text text-primary me-2"></i>Rincian Sesi</h5>
                    @if($counseling->is_confidential)
                        <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill"><i class="bi bi-eye-slash-fill me-1"></i> Rahasia / Konfidensial</span>
                    @else
                        <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill"><i class="bi bi-eye-fill me-1"></i> Terbuka</span>
                    @endif
                </div>

                <!-- Problem section (respect confidentiality) -->
                <div class="mb-4">
                    <h6 class="fw-bold text-secondary">Aduan / Masalah Siswa:</h6>
                    @if($counseling->is_confidential && !auth()->user()->isGuruBK() && !auth()->user()->isAdmin())
                        <div class="alert alert-warning border-0 p-3" style="border-radius: 10px;">
                            <i class="bi bi-shield-lock-fill me-2 text-warning fs-5"></i>
                            Rincian keluhan/masalah ini dirahasiakan oleh Guru BK. Anda tidak memiliki izin untuk melihat detail kronologi.
                        </div>
                    @else
                        <div class="p-3 bg-light rounded-3 text-dark" style="white-space: pre-line; border-left: 4px solid var(--primary);">
                            {{ $counseling->problem }}
                        </div>
                    @endif
                </div>

                <!-- Solution Section -->
                <div class="mb-4">
                    <h6 class="fw-bold text-secondary">Solusi / Pembinaan:</h6>
                    <div class="p-3 bg-light rounded-3 text-dark" style="white-space: pre-line; border-left: 4px solid var(--success);">
                        {{ $counseling->solution ?? 'Belum ada catatan pembinaan.' }}
                    </div>
                </div>

                <!-- Follow up Section -->
                <div class="mb-3">
                    <h6 class="fw-bold text-secondary">Tindak Lanjut & Rencana:</h6>
                    <div class="p-3 bg-light rounded-3 text-dark" style="white-space: pre-line; border-left: 4px solid var(--warning);">
                        {{ $counseling->follow_up ?? 'Belum ada rencana tindak lanjut.' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Student & Session Meta details -->
        <div class="col-lg-5">
            <!-- Student profile summary card -->
            <div class="card border-0 glass-card p-4 mb-4">
                <h5 class="fw-bold mb-3 text-dark border-bottom pb-2"><i class="bi bi-person-video2 text-indigo me-2" style="color: var(--primary);"></i>Profil Siswa</h5>
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar-initials bg-secondary-subtle text-secondary me-3" style="width: 50px; height: 50px; font-size: 1.5rem;">
                        {{ substr($counseling->student->user->name, 0, 1) }}
                    </div>
                    <div>
                        <h6 class="fw-bold m-0 text-dark">{{ $counseling->student->user->name }}</h6>
                        <small class="text-muted">{{ $counseling->student->nis }} &bull; Kelas {{ $counseling->student->schoolClass->full_name }}</small>
                    </div>
                </div>
                <div class="d-grid">
                    <a href="{{ route('students.show', $counseling->student) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-search me-1"></i> Lihat Profil Lengkap Siswa</a>
                </div>
            </div>

            <!-- Session Metadata -->
            <div class="card border-0 glass-card p-4">
                <h5 class="fw-bold mb-3 text-dark border-bottom pb-2"><i class="bi bi-info-circle text-success me-2"></i>Informasi Sesi</h5>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="fw-semibold text-muted" style="width: 40%;">Konselor</td>
                        <td>: {{ $counseling->counselor->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold text-muted">Kategori Bimbingan</td>
                        <td>: <span class="badge bg-light text-dark border px-2 py-1"><i class="bi {{ $counseling->category->icon }}" style="color: {{ $counseling->category->color }};"></i> {{ $counseling->category->name }}</span></td>
                    </tr>
                    <tr>
                        <td class="fw-semibold text-muted">Tanggal Pertemuan</td>
                        <td>: {{ $counseling->date->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold text-muted">Status Sesi</td>
                        <td>: 
                            @if($counseling->status === 'pending')
                                <span class="badge bg-warning-subtle text-warning px-3 py-1 rounded-pill"><i class="bi bi-hourglass-split me-1"></i> Pending</span>
                            @elseif($counseling->status === 'ongoing')
                                <span class="badge bg-primary-subtle text-primary px-3 py-1 rounded-pill"><i class="bi bi-play me-1"></i> Ongoing</span>
                            @else
                                <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill"><i class="bi bi-check-circle me-1"></i> Completed</span>
                            @endif
                        </td>
                    </tr>
                </table>

                @if(auth()->user()->isGuruBK() || auth()->user()->isAdmin())
                    <div class="d-grid mt-4 gap-2">
                        <a href="{{ route('counselings.edit', $counseling) }}" class="btn btn-warning"><i class="bi bi-pencil me-1"></i> Edit / Tindak Lanjut</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
