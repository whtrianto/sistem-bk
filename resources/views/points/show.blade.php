@extends('layouts.app')

@section('title', 'Riwayat Poin: ' . $student->user->name)

@section('content')
<div class="container-fluid fade-in-section">
    <div class="mb-4">
        @if(auth()->user()->isSiswa())
            <a href="{{ route('dashboard') }}" class="btn btn-link text-decoration-none p-0"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>
        @else
            <a href="{{ route('points.index') }}" class="btn btn-link text-decoration-none p-0"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Poin</a>
        @endif
        <h3 class="fw-bold mt-2 text-dark">Riwayat Kredit Kedisiplinan</h3>
    </div>

    <div class="row g-4">
        <!-- Student Point Info Card -->
        <div class="col-lg-4">
            <div class="card border-0 glass-card p-4 text-center">
                <div class="avatar-initials bg-primary text-white mx-auto mb-3" style="width: 70px; height: 70px; font-size: 2rem;">
                    {{ substr($student->user->name, 0, 1) }}
                </div>
                <h4 class="fw-bold mb-1 text-dark">{{ $student->user->name }}</h4>
                <p class="text-muted mb-4">{{ $student->nis }} &bull; Kelas {{ $student->schoolClass->full_name }}</p>

                <div class="p-3 bg-light rounded-4 mb-4">
                    <h6 class="text-muted mb-2">Skor Kredit Saat Ini</h6>
                    <h1 class="fw-bold m-0 text-{{ $student->current_points >= 75 ? 'success' : ($student->current_points >= 50 ? 'warning' : 'danger') }}">
                        {{ $student->current_points }}
                    </h1>
                </div>

                @if(!auth()->user()->isSiswa())
                <div class="d-grid gap-2">
                    <a href="{{ route('students.show', $student) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-person me-1"></i> Rincian Profil Lengkap</a>
                </div>
                @endif
            </div>
        </div>

        <!-- Point History Timeline -->
        <div class="col-lg-8">
            <div class="card border-0 glass-card p-4">
                <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-clock-history text-indigo me-2" style="color: var(--primary);"></i>Linimasa Perubahan Poin</h5>
                
                <div class="timeline">
                    @forelse($histories as $log)
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
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-shield-check fs-2 mb-2 d-block text-success"></i>
                            Poin masih utuh 100%. Belum ada pencatatan pelanggaran atau prestasi untuk siswa ini.
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $histories->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
