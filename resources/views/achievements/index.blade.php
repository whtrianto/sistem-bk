@extends('layouts.app')

@section('title', 'Riwayat Prestasi')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold m-0 text-dark">Pencatatan Prestasi Siswa</h3>
        @if(auth()->user()->isGuruBK() || auth()->user()->isAdmin())
            <a href="{{ route('achievements.create') }}" class="btn btn-success"><i class="bi bi-plus-lg me-2"></i>Catat Prestasi</a>
        @endif
    </div>

    <!-- Search Card -->
    <div class="card border-0 glass-card p-4 mb-4">
        <form action="{{ route('achievements.index') }}" method="GET" class="row g-3">
            <div class="col-md-9">
                <label for="search" class="form-label fw-semibold text-secondary">Cari Nama Siswa</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0 bg-transparent text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" id="search" class="form-control border-start-0" placeholder="Ketik nama siswa..." value="{{ request('search') }}">
                </div>
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
                        <th>Prestasi</th>
                        <th>Kategori</th>
                        <th>Penambahan Poin</th>
                        <th>Dicatat Oleh</th>
                        @if(auth()->user()->isGuruBK() || auth()->user()->isAdmin())
                            <th class="text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($achievements as $ach)
                        <tr>
                            <td>{{ $achievements->firstItem() + $loop->index }}</td>
                            <td>{{ $ach->date->format('d/m/Y') }}</td>
                            <td class="fw-bold text-dark">{{ $ach->student->user->name }}</td>
                            <td>{{ $ach->student->schoolClass->full_name ?? '-' }}</td>
                            <td>{{ $ach->achievementType->name }}</td>
                            <td>
                                <span class="badge badge-custom badge-{{ $ach->achievementType->category }}">{{ str_replace('_', ' ', $ach->achievementType->category) }}</span>
                            </td>
                            <td class="text-success fw-bold">+{{ $ach->points_added }} Poin</td>
                            <td>{{ $ach->recorder->name }}</td>
                            @if(auth()->user()->isGuruBK() || auth()->user()->isAdmin())
                                <td class="text-center">
                                    <form action="{{ route('achievements.destroy', $ach) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan catatan prestasi ini? Poin siswa akan dikurangi kembali.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light btn-sm text-danger"><i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ (auth()->user()->isGuruBK() || auth()->user()->isAdmin()) ? 9 : 8 }}" class="text-center py-5 text-muted">Belum ada riwayat prestasi dicatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $achievements->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
