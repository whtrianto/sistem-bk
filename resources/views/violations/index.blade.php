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
                        <th>Tanggal</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Jenis Pelanggaran</th>
                        <th>Kategori</th>
                        <th>Poin</th>
                        <th>Dicatat Oleh</th>
                        @if(auth()->user()->isGuruBK() || auth()->user()->isAdmin())
                            <th class="text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($violations as $violation)
                        <tr>
                            <td>{{ $violation->date->format('d/m/Y') }}</td>
                            <td class="fw-bold text-dark">{{ $violation->student->user->name }}</td>
                            <td>{{ $violation->student->schoolClass->full_name ?? '-' }}</td>
                            <td>{{ $violation->violationType->name }}</td>
                            <td>
                                <span class="badge badge-custom badge-{{ $violation->violationType->category }}">{{ $violation->violationType->category }}</span>
                            </td>
                            <td class="text-danger fw-bold">-{{ $violation->points_deducted }} Poin</td>
                            <td>{{ $violation->recorder->name }}</td>
                            @if(auth()->user()->isGuruBK() || auth()->user()->isAdmin())
                                <td class="text-center">
                                    <form action="{{ route('violations.destroy', $violation) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pelanggaran ini? Poin siswa akan dikembalikan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light btn-sm text-danger"><i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">Belum ada riwayat pelanggaran dicatat.</td>
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
@endsection
