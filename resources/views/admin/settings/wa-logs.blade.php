@extends('layouts.app')

@section('title', 'Log WhatsApp Gateway')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="mb-4">
        <h3 class="fw-bold text-dark">Log WhatsApp Gateway</h3>
        <p class="text-muted">Riwayat lengkap pesan yang dikirimkan sistem bimbingan konseling ke nomor tujuan.</p>
    </div>

    <!-- Data Table -->
    <div class="card border-0 glass-card p-4">
        <div class="table-responsive">
            <table class="table custom-table align-middle">
                <thead>
                    <tr>
                        <th>Waktu Kirim</th>
                        <th>Nomor Penerima</th>
                        <th>Kategori Pesan</th>
                        <th>Isi Pesan</th>
                        <th>Status</th>
                        <th>Respon API</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                            <td class="fw-semibold text-secondary">{{ $log->recipient_phone }}</td>
                            <td>
                                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill text-capitalize">
                                    {{ $log->type }}
                                </span>
                            </td>
                            <td>
                                <span title="{{ $log->message }}">{{ Str::limit($log->message, 45) }}</span>
                            </td>
                            <td>
                                @if($log->status === 'sent')
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill"><i class="bi bi-check-circle-fill me-1"></i> Berhasil</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill"><i class="bi bi-exclamation-triangle-fill me-1"></i> Gagal</span>
                                @endif
                            </td>
                            <td>
                                <code class="fs-8" title="{{ $log->response }}">{{ Str::limit($log->response, 30) }}</code>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada riwayat pengiriman pesan WhatsApp.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $logs->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
