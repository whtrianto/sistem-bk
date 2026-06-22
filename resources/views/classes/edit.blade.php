@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="mb-4">
        <a href="{{ route('classes.index') }}" class="btn btn-link text-decoration-none p-0"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Kelas</a>
        <h3 class="fw-bold mt-2 text-dark">Edit Kelas: {{ $class->full_name }}</h3>
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
                <form action="{{ route('classes.update', $class) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="level" class="form-label fw-semibold">Tingkat Kelas <span class="text-danger">*</span></label>
                        <select name="level" id="level" class="form-select" required>
                            <option value="X" {{ old('level', $class->level) == 'X' ? 'selected' : '' }}>X (Sepuluh)</option>
                            <option value="XI" {{ old('level', $class->level) == 'XI' ? 'selected' : '' }}>XI (Sebelas)</option>
                            <option value="XII" {{ old('level', $class->level) == 'XII' ? 'selected' : '' }}>XII (Dua Belas)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Kelas <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $class->name) }}">
                    </div>

                    <div class="mb-3">
                        <label for="major" class="form-label fw-semibold">Kompetensi Keahlian (Jurusan) <span class="text-danger">*</span></label>
                        <input type="text" name="major" id="major" class="form-control" required value="{{ old('major', $class->major) }}">
                    </div>

                    <div class="mb-3">
                        <label for="academic_year_id" class="form-label fw-semibold">Tahun Ajaran <span class="text-danger">*</span></label>
                        <select name="academic_year_id" id="academic_year_id" class="form-select" required>
                            @foreach($academicYears as $ay)
                                <option value="{{ $ay->id }}" {{ old('academic_year_id', $class->academic_year_id) == $ay->id ? 'selected' : '' }}>
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
                                <option value="{{ $teacher->id }}" {{ old('wali_kelas_id', $class->wali_kelas_id) == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }} ({{ $teacher->role_label }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary-custom px-4"><i class="bi bi-save me-2"></i> Perbarui Kelas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
