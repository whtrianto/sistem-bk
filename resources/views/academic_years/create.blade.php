@extends('layouts.app')

@section('title', 'Tambah Tahun Ajaran')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="mb-4">
        <a href="{{ route('academic-years.index') }}" class="btn btn-link text-decoration-none p-0"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Tahun Ajaran</a>
        <h3 class="fw-bold mt-2 text-dark">Tambah Tahun Ajaran Baru</h3>
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
                <form action="{{ route('academic-years.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="year" class="form-label fw-semibold">Tahun Ajaran <span class="text-danger">*</span></label>
                        <input type="text" name="year" id="year" class="form-control" placeholder="Contoh: 2025/2026" required value="{{ old('year') }}">
                    </div>

                    <div class="mb-3">
                        <label for="semester" class="form-label fw-semibold">Semester <span class="text-danger">*</span></label>
                        <select name="semester" id="semester" class="form-select" required>
                            <option value="">Pilih Semester</option>
                            <option value="ganjil" {{ old('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="genap" {{ old('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                    </div>

                    <div class="mb-3 form-check mt-3">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1">
                        <label class="form-check-label fw-semibold text-secondary" for="is_active">Jadikan sebagai tahun ajaran aktif saat ini</label>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary-custom px-4"><i class="bi bi-save me-2"></i> Simpan Tahun Ajaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
