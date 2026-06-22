@extends('layouts.app')

@section('title', 'Ranking Poin Kedisiplinan')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="mb-4">
        @if(auth()->user()->isSiswa() || auth()->user()->isKepsek())
            <a href="{{ route('dashboard') }}" class="btn btn-link text-decoration-none p-0"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>
        @else
            <a href="{{ route('points.index') }}" class="btn btn-link text-decoration-none p-0"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Poin</a>
        @endif
        <h3 class="fw-bold mt-2 text-dark">Ranking Kedisiplinan Siswa</h3>
        <p class="text-muted">Leaderboard top 50 siswa terdisiplin dengan poin pelanggaran terendah.</p>
    </div>

    <!-- Leaderboard Table -->
    <div class="card border-0 glass-card p-4">
        <div class="table-responsive">
            <table class="table custom-table align-middle">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">Peringkat</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Skor Poin</th>
                        <th>Medali</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $index => $student)
                        <tr class="{{ $index < 3 ? 'table-success-subtle' : '' }}">
                            <td class="text-center fw-bold fs-5 text-secondary">
                                #{{ $index + 1 }}
                            </td>
                            <td>{{ $student->nis }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $student->user->name }}</div>
                            </td>
                            <td>{{ $student->schoolClass->full_name ?? '-' }}</td>
                            <td class="fw-bold text-{{ $student->current_points <= 25 ? 'success' : ($student->current_points <= 50 ? 'warning' : 'danger') }} fs-5">{{ $student->current_points }}</td>
                            <td>
                                @if($index === 0)
                                    <span class="fs-4 text-warning" title="Juara 1 Paling Disiplin"><i class="bi bi-trophy-fill"></i></span>
                                @elseif($index === 1)
                                    <span class="fs-4 text-secondary" title="Juara 2 Paling Disiplin"><i class="bi bi-trophy-fill"></i></span>
                                @elseif($index === 2)
                                    <span class="fs-4 text-danger-emphasis" title="Juara 3 Paling Disiplin"><i class="bi bi-trophy-fill"></i></span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada data ranking.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
