@extends('layouts.app')

@section('title', 'Surat Panggilan Orang Tua')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold m-0 text-dark">Surat Panggilan Orang Tua</h3>
        <a href="{{ route('letters.create') }}" class="btn btn-primary-custom"><i class="bi bi-envelope-plus me-2"></i>Buat Surat Panggilan</a>
    </div>

    <!-- Data Table Card -->
    <div class="card border-0 glass-card p-4">
        <div class="table-responsive">
            <table class="table custom-table align-middle">
                <thead>
                    <tr>
                        <th style="width: 60px;">No.</th>
                        <th>No. Surat</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Alasan Panggilan</th>
                        <th>Tanggal Pertemuan</th>
                        <th>Pukul</th>
                        <th>Status Pengiriman</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($letters as $letter)
                        <tr>
                            <td>{{ $letters->firstItem() + $loop->index }}</td>
                            <td class="fw-semibold text-secondary">{{ $letter->letter_number }}</td>
                            <td class="fw-bold text-dark">{{ $letter->student->user->name }}</td>
                            <td>{{ $letter->student->schoolClass->full_name ?? '-' }}</td>
                            <td>{{ Str::limit($letter->reason, 40) }}</td>
                            <td>
                                <span class="fw-semibold text-secondary"><i class="bi bi-calendar3 me-1"></i> {{ $letter->meeting_date->format('d/m/Y') }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1"><i class="bi bi-clock me-1"></i> {{ $letter->meeting_time }} WIB</span>
                            </td>
                            <td>
                                @if($letter->status === 'generated')
                                    <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill"><i class="bi bi-file-earmark-text me-1"></i> Dibuat</span>
                                @elseif($letter->status === 'sent')
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill"><i class="bi bi-whatsapp me-1"></i> Terkirim (WA)</span>
                                @else
                                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill"><i class="bi bi-check2-all me-1"></i> Dikonfirmasi</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{ route('letters.pdf', $letter) }}" target="_blank" class="btn btn-outline-danger btn-sm"><i class="bi bi-file-pdf"></i> Cetak PDF</a>
                                    <form action="{{ route('letters.destroy', $letter) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus arsip surat panggilan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light btn-sm text-danger"><i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">Belum ada surat panggilan dibuat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $letters->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
