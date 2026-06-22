@extends('layouts.app')

@section('title', 'Tambah Kelas')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="mb-4">
        <a href="{{ route('classes.index') }}" class="btn btn-link text-decoration-none p-0"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Kelas</a>
        <h3 class="fw-bold mt-2 text-dark">Tambah Kelas Baru</h3>
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
                <form action="{{ route('classes.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="level" class="form-label fw-semibold">Tingkat Kelas <span class="text-danger">*</span></label>
                        <select name="level" id="level" class="form-select" required>
                            <option value="">Pilih Tingkat</option>
                            <option value="X" {{ old('level') == 'X' ? 'selected' : '' }}>X (Sepuluh)</option>
                            <option value="XI" {{ old('level') == 'XI' ? 'selected' : '' }}>XI (Sebelas)</option>
                            <option value="XII" {{ old('level') == 'XII' ? 'selected' : '' }}>XII (Dua Belas)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Kelas <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: RPL 1, TKJ 2" required value="{{ old('name') }}">
                    </div>

                    <div class="mb-3">
                        <label for="major" class="form-label fw-semibold">Kompetensi Keahlian (Jurusan) <span class="text-danger">*</span></label>
                        <input type="text" name="major" id="major" class="form-control" placeholder="Contoh: Rekayasa Perangkat Lunak" required value="{{ old('major') }}">
                    </div>

                    <div class="mb-3">
                        <label for="academic_year_id" class="form-label fw-semibold">Tahun Ajaran <span class="text-danger">*</span></label>
                        <select name="academic_year_id" id="academic_year_id" class="form-select" required>
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach($academicYears as $ay)
                                <option value="{{ $ay->id }}" {{ (old('academic_year_id') == $ay->id || $ay->is_active) ? 'selected' : '' }}>
                                    {{ $ay->year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="wali_kelas_id" class="form-label fw-semibold">Wali Kelas</label>
                        <select name="wali_kelas_id" id="wali_kelas_id" class="form-select">
                            <option value="">Pilih Wali Kelas (Opsional)</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('wali_kelas_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }} ({{ $teacher->role_label }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary-custom px-4"><i class="bi bi-save me-2"></i> Simpan Kelas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
