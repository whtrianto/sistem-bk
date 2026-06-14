@extends('layouts.app')

@section('title', 'Edit Kategori Prestasi')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="mb-4">
        <a href="{{ route('achievement-types.index') }}" class="btn btn-link text-decoration-none p-0"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Kategori</a>
        <h3 class="fw-bold mt-2 text-dark">Edit Kategori Prestasi: {{ $achievementType->name }}</h3>
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
                <form action="{{ route('achievement-types.update', $achievementType) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Prestasi <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $achievementType->name) }}">
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label fw-semibold">Tingkat Prestasi <span class="text-danger">*</span></label>
                        <select name="category" id="category" class="form-select" required>
                            <option value="akademik" {{ old('category', $achievementType->category) == 'akademik' ? 'selected' : '' }}>Akademik</option>
                            <option value="non_akademik" {{ old('category', $achievementType->category) == 'non_akademik' ? 'selected' : '' }}>Non Akademik</option>
                            <option value="karakter" {{ old('category', $achievementType->category) == 'karakter' ? 'selected' : '' }}>Karakter</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="points" class="form-label fw-semibold">Bobot Poin Penambahan <span class="text-danger">*</span></label>
                        <input type="number" name="points" id="points" class="form-control" required min="1" value="{{ old('points', $achievementType->points) }}">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Keterangan / Deskripsi Prestasi</label>
                        <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $achievementType->description) }}</textarea>
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
