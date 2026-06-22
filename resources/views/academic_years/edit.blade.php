@extends('layouts.app')

@section('title', 'Edit Tahun Ajaran')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="mb-4">
        <a href="{{ route('academic-years.index') }}" class="btn btn-link text-decoration-none p-0"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Tahun Ajaran</a>
        <h3 class="fw-bold mt-2 text-dark">Edit Tahun Ajaran: {{ $academicYear->year }}</h3>
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
                <form action="{{ route('academic-years.update', $academicYear) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="year" class="form-label fw-semibold">Tahun Ajaran <span class="text-danger">*</span></label>
                        <input type="text" name="year" id="year" class="form-control" required value="{{ old('year', $academicYear->year) }}">
                    </div>


                    <div class="mb-3 form-check mt-3">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ $academicYear->is_active ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold text-secondary" for="is_active">Tahun ajaran aktif saat ini</label>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary-custom px-4"><i class="bi bi-save me-2"></i> Perbarui Tahun Ajaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
