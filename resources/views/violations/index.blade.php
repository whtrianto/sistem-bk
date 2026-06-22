@extends('layouts.app')

@section('title', 'Riwayat Pelanggaran')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold m-0 text-dark">Pencatatan Pelanggaran Siswa</h3>
        @if(auth()->user()->isGuruBK() || auth()->user()->isAdmin())
            <a href="{{ route('violations.create') }}" class="btn btn-danger"><i class="bi bi-plus-lg me-2"></i>Catat Pelanggaran</a>
        @endif
    </div>

    <!-- Search & Filter Card -->
    <div class="card border-0 glass-card p-4 mb-4">
        <form action="{{ route('violations.index') }}" method="GET" class="row g-3">
            <div class="col-md-6">
                <label for="search" class="form-label fw-semibold text-secondary">Cari Nama Siswa</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0 bg-transparent text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" id="search" class="form-control border-start-0" placeholder="Ketik nama siswa..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="col-md-3">
                <label for="category" class="form-label fw-semibold text-secondary">Kategori</label>
                <select name="category" id="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    <option value="ringan" {{ request('category') == 'ringan' ? 'selected' : '' }}>Ringan</option>
                    <option value="sedang" {{ request('category') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="berat" {{ request('category') == 'berat' ? 'selected' : '' }}>Berat</option>
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary-custom w-100 py-2"><i class="bi bi-funnel me-2"></i>Filter</button>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="card border-0 glass-card p-4">
        <div class="table-responsive">
            <table class="table custom-table align-middle">
                <thead>
                    <tr>
                        <th style="width: 60px;">No.</th>
                        <th>Tanggal</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Jenis Pelanggaran</th>
                        <th>Kategori</th>
                        <th>Poin</th>
                        <th>Dicatat Oleh</th>
                        <th class="text-center" style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($violations as $violation)
                        <tr>
                            <td>{{ $violations->firstItem() + $loop->index }}</td>
                            <td>{{ $violation->date->format('d/m/Y') }}</td>
                            <td class="fw-bold text-dark">{{ $violation->student->user->name }}</td>
                            <td>{{ $violation->student->schoolClass->full_name ?? '-' }}</td>
                            <td>{{ $violation->violationType->name }}</td>
                            <td>
                                <span class="badge badge-custom badge-{{ $violation->violationType->category }}">{{ $violation->violationType->category }}</span>
                            </td>
                            <td class="text-danger fw-bold">+{{ $violation->points_deducted }} Poin</td>
                            <td>{{ $violation->recorder->name }}</td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <button type="button" class="btn btn-light btn-sm text-primary" data-bs-toggle="modal" data-bs-target="#detailModal-{{ $violation->id }}">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>
                                    @if(auth()->user()->isGuruBK() || auth()->user()->isAdmin())
                                        <form action="{{ route('violations.destroy', $violation) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pelanggaran ini? Poin siswa akan dikembalikan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm text-danger"><i class="bi bi-trash"></i> Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">Belum ada riwayat pelanggaran dicatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $violations->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Detail Modals -->
@foreach($violations as $violation)
    <div class="modal fade" id="detailModal-{{ $violation->id }}" tabindex="-1" aria-labelledby="detailModalLabel-{{ $violation->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content glass-card border-0 overflow-hidden shadow-lg" style="border-radius: 20px;">
                <!-- Header Banner -->
                <div class="modal-header border-0 p-4 text-white" style="background: linear-gradient(135deg, #EF4444 0%, #B91C1C 100%);">
                    <div class="d-flex align-items-center">
                        <div class="bg-white text-danger rounded-circle p-2 me-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 46px; height: 46px;">
                            <i class="bi bi-exclamation-octagon-fill fs-4"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold m-0" id="detailModalLabel-{{ $violation->id }}">Detail Pelanggaran</h5>
                            <small class="text-white-50">Sistem Kredit Kedisiplinan BK</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 text-start bg-light-subtle">
                    <!-- Student Info Card -->
                    <div class="card border-0 shadow-sm p-3 mb-4 rounded-4" style="background: rgba(255, 255, 255, 0.95); border: 1px solid rgba(0, 0, 0, 0.03) !important;">
                        <div class="d-flex align-items-center">
                            <div class="avatar-initials bg-danger-subtle text-danger fw-bold me-3 shadow-xs" style="width: 50px; height: 50px; font-size: 1.3rem; border: 2px solid rgba(239, 68, 68, 0.1);">
                                {{ substr($violation->student->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h6 class="fw-bold m-0 text-dark" style="font-size: 1.05rem;">{{ $violation->student->user->name }}</h6>
                                <p class="text-muted m-0 fs-7"><i class="bi bi-hash me-1"></i>{{ $violation->student->nis }} &bull; Kelas {{ $violation->student->schoolClass->full_name ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Details Box Info -->
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="p-3 rounded-4 border bg-white h-100 shadow-xs" style="border-color: rgba(0, 0, 0, 0.05) !important;">
                                <small class="text-muted d-block mb-1 fs-8 text-uppercase fw-bold" style="letter-spacing: 0.5px;">Kategori</small>
                                <span class="badge badge-custom badge-{{ $violation->violationType->category }} text-capitalize px-3 py-1 fs-7">
                                    {{ $violation->violationType->category }}
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-4 border bg-white h-100 shadow-xs" style="border-color: rgba(0, 0, 0, 0.05) !important;">
                                <small class="text-muted d-block mb-1 fs-8 text-uppercase fw-bold" style="letter-spacing: 0.5px;">Poin Pelanggaran</small>
                                <span class="text-danger fw-bold fs-5"><i class="bi bi-plus"></i>{{ $violation->points_deducted }} Poin</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-4 border bg-white h-100 shadow-xs" style="border-color: rgba(0, 0, 0, 0.05) !important;">
                                <small class="text-muted d-block mb-1 fs-8 text-uppercase fw-bold" style="letter-spacing: 0.5px;">Tanggal</small>
                                <span class="fw-semibold text-secondary fs-7">
                                    <i class="bi bi-calendar3 text-danger me-1"></i> {{ $violation->date->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-4 border bg-white h-100 shadow-xs" style="border-color: rgba(0, 0, 0, 0.05) !important;">
                                <small class="text-muted d-block mb-1 fs-8 text-uppercase fw-bold" style="letter-spacing: 0.5px;">Dicatat Oleh</small>
                                <span class="fw-semibold text-secondary fs-7 text-truncate d-block" title="{{ $violation->recorder->name }}">
                                    <i class="bi bi-person-check text-danger me-1"></i> {{ $violation->recorder->name }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Chronology -->
                    <div class="mb-2">
                        <h6 class="fw-bold text-secondary mb-2 fs-7 text-uppercase" style="letter-spacing: 0.5px;"><i class="bi bi-file-text-fill text-danger me-1"></i>Keterangan Kejadian</h6>
                        <div class="p-3 rounded-4 text-dark fs-7" style="white-space: pre-line; background: #FFF; border-left: 4px solid #EF4444; border-top: 1px solid rgba(0,0,0,0.02); border-right: 1px solid rgba(0,0,0,0.02); border-bottom: 1px solid rgba(0,0,0,0.02); box-shadow: inset 0 2px 4px rgba(0,0,0,0.01); min-height: 90px; line-height: 1.6;">
                            {{ $violation->description ?? 'Tidak ada catatan kronologi.' }}
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 p-3 bg-light" style="border-top: 1px solid rgba(0, 0, 0, 0.03);">
                    <button type="button" class="btn btn-light px-4 rounded-3 fw-bold border text-secondary shadow-xs" data-bs-dismiss="modal" style="font-size: 0.9rem; transition: var(--transition-smooth);">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection
