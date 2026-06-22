@extends('layouts.app')

@section('title', 'Poin Kredit Siswa')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold m-0 text-dark">Poin Kredit & Kedisiplinan</h3>
        <a href="{{ route('points.ranking') }}" class="btn btn-outline-primary"><i class="bi bi-list-ol me-2"></i>Lihat Ranking Poin</a>
    </div>

    <!-- Search & Filter Card -->
    <div class="card border-0 glass-card p-4 mb-4">
        <form action="{{ route('points.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label fw-semibold text-secondary">Cari Siswa</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0 bg-transparent text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" id="search" class="form-control border-start-0" placeholder="Ketik nama siswa..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="col-md-3">
                <label for="sort" class="form-label fw-semibold text-secondary">Urutkan</label>
                <select name="sort" id="sort" class="form-select">
                    <option value="current_points" {{ request('sort') == 'current_points' ? 'selected' : '' }}>Poin Kredit</option>
                    <option value="nis" {{ request('sort') == 'nis' ? 'selected' : '' }}>Nomor Induk Siswa (NIS)</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="order" class="form-label fw-semibold text-secondary">Arah Urutan</label>
                <select name="order" id="order" class="form-select">
                    <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Terkecil ke Terbesar</option>
                    <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Terbesar ke Terkecil</option>
                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary-custom w-100 py-2"><i class="bi bi-funnel me-2"></i>Urutkan</button>
            </div>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="card border-0 glass-card p-4">
        <div class="table-responsive">
            <table class="table custom-table align-middle">
                <thead>
                    <tr>
                        <th style="width: 60px;">No.</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Poin Awal</th>
                        <th>Poin Saat Ini</th>
                        <th>Status Kedisiplinan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td>{{ $students->firstItem() + $loop->index }}</td>
                            <td class="fw-semibold text-secondary">{{ $student->nis }}</td>
                            <td class="fw-bold text-dark">{{ $student->user->name }}</td>
                            <td>{{ $student->schoolClass->full_name ?? '-' }}</td>
                            <td>{{ $student->initial_points }}</td>
                            <td class="fw-bold text-{{ $student->current_points >= 75 ? 'success' : ($student->current_points >= 50 ? 'warning' : 'danger') }}">{{ $student->current_points }}</td>
                            <td>
                                @if($student->current_points >= 75)
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill"><i class="bi bi-shield-check me-1"></i> Sangat Baik</span>
                                @elseif($student->current_points >= 50)
                                    <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill"><i class="bi bi-shield-exclamation me-1"></i> Peringatan</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill"><i class="bi bi-shield-slash me-1"></i> Kritis</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('points.show', $student) }}" class="btn btn-light btn-sm text-primary"><i class="bi bi-clock-history"></i> Riwayat Poin</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">Data siswa tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $students->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
