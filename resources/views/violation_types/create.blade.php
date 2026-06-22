@extends('layouts.app')

@section('title', 'Tambah Kategori Pelanggaran')

@section('content')
    <div class="container-fluid fade-in-section">
        <div class="mb-4">
            <a href="{{ route('violation-types.index') }}" class="btn btn-link text-decoration-none p-0"><i
                    class="bi bi-arrow-left"></i> Kembali ke Daftar Kategori</a>
            <h3 class="fw-bold mt-2 text-dark">Tambah Kategori Pelanggaran</h3>
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
                    <form action="{{ route('violation-types.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nama Pelanggaran <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Contoh: Terlambat, Merokok" required value="{{ old('name') }}">
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label fw-semibold">Tingkat Pelanggaran <span
                                    class="text-danger">*</span></label>
                            <select name="category" id="category" class="form-select" required>
                                <option value="">Pilih Tingkat</option>
                                <option value="ringan" {{ old('category') == 'ringan' ? 'selected' : '' }}>Ringan</option>
                                <option value="sedang" {{ old('category') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="berat" {{ old('category') == 'berat' ? 'selected' : '' }}>Berat</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="points" class="form-label fw-semibold">Bobot Poin Pelanggaran <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="points" id="points" class="form-control"
                                placeholder="Contoh: 5, 10, 25" required min="1" value="{{ old('points') }}">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Keterangan / Deskripsi
                                Pelanggaran</label>
                            <textarea name="description" id="description" class="form-control" rows="3"
                                placeholder="Masukkan detail penjelasan pelanggaran...">{{ old('description') }}</textarea>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary-custom px-4"><i class="bi bi-save me-2"></i> Simpan
                                Kategori</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection