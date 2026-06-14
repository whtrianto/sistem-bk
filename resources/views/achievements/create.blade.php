@extends('layouts.app')

@section('title', 'Catat Prestasi')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="mb-4">
        <a href="{{ route('achievements.index') }}" class="btn btn-link text-decoration-none p-0"><i class="bi bi-arrow-left"></i> Kembali ke Riwayat</a>
        <h3 class="fw-bold mt-2 text-dark">Catat Prestasi Baru</h3>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger border-0 mb-4" style="border-radius: 12px;">
            <ul class="m-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-6">
            <div class="card border-0 glass-card p-4">
                <form action="{{ route('achievements.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="student_id" class="form-label fw-semibold">Pilih Siswa <span class="text-danger">*</span></label>
                        <select name="student_id" id="student_id" class="form-select" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->nis }} - {{ $student->user->name }} ({{ $student->schoolClass->full_name ?? 'Tanpa Kelas' }}) - [Poin: {{ $student->current_points }}]
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="achievement_type_id" class="form-label fw-semibold">Jenis Prestasi <span class="text-danger">*</span></label>
                        <select name="achievement_type_id" id="achievement_type_id" class="form-select" required>
                            <option value="">-- Pilih Jenis Prestasi --</option>
                            @foreach($achievementTypes as $type)
                                <option value="{{ $type->id }}" {{ old('achievement_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }} - [{{ str_replace('_', ' ', $type->category) }} - Tambah {{ $type->points }} Poin]
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label fw-semibold">Tanggal Perolehan <span class="text-danger">*</span></label>
                        <input type="date" name="date" id="date" class="form-control" required value="{{ old('date', now()->format('Y-m-d')) }}">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Catatan Keterangan / Deskripsi</label>
                        <textarea name="description" id="description" class="form-control" rows="3" placeholder="Masukkan keterangan singkat prestasi... (misal: Juara 1 lomba FLS2N tingkat Provinsi)">{{ old('description') }}</textarea>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-success px-4"><i class="bi bi-save me-2"></i> Simpan & Tambah Poin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
