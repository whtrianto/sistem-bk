@extends('layouts.app')

@section('title', 'Jadwal Konseling')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold m-0 text-dark">Jadwal Konseling</h3>
        <a href="{{ route('schedules.create') }}" class="btn btn-primary-custom"><i class="bi bi-calendar-plus me-2"></i>Ajukan Sesi Konseling</a>
    </div>

    <!-- Data Table -->
    <div class="card border-0 glass-card p-4">
        <div class="table-responsive">
            <table class="table custom-table align-middle">
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Konselor (Guru BK)</th>
                        <th>Tanggal Kejadian</th>
                        <th>Jam Mulai - Selesai</th>
                        <th>Alasan / Catatan</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 220px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $sch)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ $sch->student->user->name }}</div>
                                <small class="text-muted">{{ $sch->student->nis }}</small>
                            </td>
                            <td>{{ $sch->student->schoolClass->full_name ?? '-' }}</td>
                            <td>{{ $sch->counselor->name }}</td>
                            <td>
                                <span class="fw-semibold text-secondary"><i class="bi bi-calendar3 me-1"></i> {{ $sch->date->format('d/m/Y') }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1"><i class="bi bi-clock me-1"></i> {{ $sch->time_start }} - {{ $sch->time_end }}</span>
                            </td>
                            <td>{{ Str::limit($sch->notes, 30) }}</td>
                            <td>
                                @if($sch->status === 'pending')
                                    <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill"><i class="bi bi-hourglass-split me-1"></i> Pending</span>
                                @elseif($sch->status === 'approved')
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill"><i class="bi bi-check-circle me-1"></i> Disetujui</span>
                                @elseif($sch->status === 'completed')
                                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill"><i class="bi bi-check-all me-1"></i> Selesai</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill" title="Alasan ditolak: {{ $sch->rejection_reason }}"><i class="bi bi-x-circle me-1"></i> Ditolak</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <!-- BK/Admin Approval Actions -->
                                    @if(auth()->user()->isGuruBK() || auth()->user()->isAdmin())
                                        @if($sch->status === 'pending')
                                            <form action="{{ route('schedules.approve', $sch) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check2"></i> Setujui</button>
                                            </form>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $sch->id }}"><i class="bi bi-x-lg"></i> Tolak</button>
                                            
                                            <!-- Rejection Modal -->
                                            <div class="modal fade text-start" id="rejectModal-{{ $sch->id }}" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content glass-card border-0">
                                                        <div class="modal-header border-bottom pb-2">
                                                            <h5 class="modal-title fw-bold" id="rejectModalLabel">Tolak Pengajuan Konseling</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('schedules.reject', $sch) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-body py-3">
                                                                <div class="mb-3">
                                                                    <label for="rejection_reason" class="form-label fw-semibold">Alasan Penolakan <span class="text-danger">*</span></label>
                                                                    <textarea name="rejection_reason" id="rejection_reason" class="form-control" rows="3" placeholder="Masukkan alasan penolakan..." required></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer border-0 pt-0">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-danger">Tolak Pengajuan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if($sch->status === 'approved')
                                            <form action="{{ route('schedules.complete', $sch) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2-all"></i> Selesai Sesi</button>
                                            </form>
                                        @endif
                                    @endif

                                    <!-- Delete / Cancel Action -->
                                    @if(auth()->user()->isSiswa() && $sch->status === 'pending')
                                        <form action="{{ route('schedules.destroy', $sch) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i> Batal</button>
                                        </form>
                                    @elseif(auth()->user()->isGuruBK() || auth()->user()->isAdmin())
                                        <form action="{{ route('schedules.destroy', $sch) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm text-danger"><i class="bi bi-trash"></i> Hapus</button>
                                        </form>
                                    @else
                                        <span class="text-muted fs-8">-</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">Belum ada pengajuan jadwal konseling.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $schedules->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
