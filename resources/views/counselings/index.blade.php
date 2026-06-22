@extends('layouts.app')

@section('title', 'Sesi Konseling')

@section('content')
    <div class="container-fluid fade-in-section">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h3 class="fw-bold m-0 text-dark">Pencatatan Bimbingan Konseling (BK)</h3>
            @if(auth()->user()->isGuruBK() || auth()->user()->isAdmin())
                <a href="{{ route('counselings.create') }}" class="btn btn-success"><i class="bi bi-chat-dots me-2"></i>Catat
                    Konseling Baru</a>
            @endif
        </div>

        <!-- Search & Filter Card -->
        <div class="card border-0 glass-card p-4 mb-4">
            <form action="{{ route('counselings.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label fw-semibold text-secondary">Cari Siswa</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0 bg-transparent text-muted"><i
                                class="bi bi-search"></i></span>
                        <input type="text" name="search" id="search" class="form-control border-start-0"
                            placeholder="Ketik nama siswa..." value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="category_id" class="form-label fw-semibold text-secondary">Kategori</label>
                    <select name="category_id" id="category_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label fw-semibold text-secondary">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary-custom w-100 py-2"><i
                            class="bi bi-funnel me-2"></i>Filter</button>
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
                            <th>Kategori</th>
                            <th>Konselor (Guru BK)</th>
                            <th>Masalah</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($counselings as $counseling)
                            <tr>
                                <td>{{ $counselings->firstItem() + $loop->index }}</td>
                                <td>{{ $counseling->date->format('d/m/Y') }}</td>
                                <td class="fw-bold text-dark">{{ $counseling->student->user->name }}</td>
                                <td>{{ $counseling->student->schoolClass->full_name ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill"><i
                                            class="bi {{ $counseling->category->icon ?? 'bi-tag' }} me-1"
                                            style="color: {{ $counseling->category->color ?? '#6366F1' }};"></i>{{ $counseling->category->name }}</span>
                                </td>
                                <td>{{ $counseling->counselor->name }}</td>
                                <td>{{ Str::limit($counseling->problem, 40) }}</td>
                                <td>
                                    @if($counseling->status === 'pending')
                                        <span class="badge bg-warning-subtle text-warning px-2 py-1 rounded-pill"><i
                                                class="bi bi-hourglass-split me-1"></i> Pending</span>
                                    @elseif($counseling->status === 'ongoing')
                                        <span class="badge bg-primary-subtle text-primary px-2 py-1 rounded-pill"><i
                                                class="bi bi-play me-1"></i> Ongoing</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill"><i
                                                class="bi bi-check-circle me-1"></i> Selesai</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <a href="{{ route('counselings.show', $counseling) }}"
                                            class="btn btn-light btn-sm text-primary"><i class="bi bi-eye"></i> Detail</a>
                                        @if(auth()->user()->isGuruBK() || auth()->user()->isAdmin())
                                            <a href="{{ route('counselings.edit', $counseling) }}"
                                                class="btn btn-light btn-sm text-warning"><i class="bi bi-pencil"></i> Tindak
                                                Lanjut</a>
                                            <form action="{{ route('counselings.destroy', $counseling) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data konseling ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-light btn-sm text-danger"><i
                                                        class="bi bi-trash"></i> Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">Belum ada catatan konseling.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $counselings->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection