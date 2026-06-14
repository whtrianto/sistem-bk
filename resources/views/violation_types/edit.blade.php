@extends('layouts.app')

@section('title', 'Edit Kategori Pelanggaran')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="mb-4">
        <a href="{{ route('violation-types.index') }}" class="btn btn-link text-decoration-none p-0"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Kategori</a>
        <h3 class="fw-bold mt-2 text-dark">Edit Kategori Pelanggaran: {{ $violationType->name }}</h3>
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
                <form action="{{ route('violation-types.update', $violationType) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Pelanggaran <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $violationType->name) }}">
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label fw-semibold">Tingkat Pelanggaran <span class="text-danger">*</span></label>
                        <select name="category" id="category" class="form-select" required>
                            <option value="ringan" {{ old('category', $violationType->category) == 'ringan' ? 'selected' : '' }}>Ringan</option>
                            <option value="sedang" {{ old('category', $violationType->category) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="berat" {{ old('category', $violationType->category) == 'berat' ? 'selected' : '' }}>Berat</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="points" class="form-label fw-semibold">Bobot Poin Pengurangan <span class="text-danger">*</span></label>
                        <input type="number" name="points" id="points" class="form-control" required min="1" value="{{ old('points', $violationType->points) }}">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Keterangan / Deskripsi Pelanggaran</label>
                        <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $violationType->description) }}</textarea>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary-custom px-4"><i class="bi bi-save me-2"></i> Perbarui Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
