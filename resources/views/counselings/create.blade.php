@extends('layouts.app')

@section('title', 'Catat Konseling')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="mb-4">
        <a href="{{ route('counselings.index') }}" class="btn btn-link text-decoration-none p-0"><i class="bi bi-arrow-left"></i> Kembali ke Daftar</a>
        <h3 class="fw-bold mt-2 text-dark">Catat Sesi Bimbingan Konseling</h3>
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

    <form action="{{ route('counselings.store') }}" method="POST" class="row g-4">
        @csrf
        <div class="col-lg-6">
            <div class="card border-0 glass-card p-4 h-100">
                <h5 class="fw-bold mb-4 text-dark border-bottom pb-2"><i class="bi bi-person-lines-fill text-primary me-2"></i>Informasi Konseling</h5>
                
                <div class="mb-3">
                    <label for="student_id" class="form-label fw-semibold">Pilih Siswa <span class="text-danger">*</span></label>
                    <select name="student_id" id="student_id" class="form-select" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->nis }} - {{ $student->user->name }} ({{ $student->schoolClass->full_name ?? 'Tanpa Kelas' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label fw-semibold">Kategori Kasus <span class="text-danger">*</span></label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label fw-semibold">Tanggal Bimbingan <span class="text-danger">*</span></label>
                    <input type="date" name="date" id="date" class="form-control" required value="{{ old('date', now()->format('Y-m-d')) }}">
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label fw-semibold">Status Awal Konseling</label>
                    <select name="status" id="status" class="form-select">
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending (Menunggu Sesi)</option>
                        <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Ongoing (Sedang Dibimbing)</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed (Selesai Pembinaan)</option>
                    </select>
                </div>

                <div class="mb-3 form-check mt-3 bg-light p-3 rounded border">
                    <input type="checkbox" name="is_confidential" class="form-check-input ms-0 me-2" id="is_confidential" value="1" checked>
                    <label class="form-check-label fw-semibold text-danger" for="is_confidential">
                        <i class="bi bi-eye-slash-fill me-1"></i> Rahasiakan Catatan Masalah
                    </label>
                    <div class="form-text text-muted ps-0 mt-1">Jika dicentang, hanya Guru BK yang dapat melihat detail rincian masalah siswa ini. Wali Kelas/Kepsek hanya melihat indikator status dan kategori kasus saja.</div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 glass-card p-4 h-100">
                <h5 class="fw-bold mb-4 text-dark border-bottom pb-2"><i class="bi bi-pencil-square text-success me-2"></i>Rincian Pembinaan</h5>
                
                <div class="mb-3">
                    <label for="problem" class="form-label fw-semibold">Rincian Masalah Siswa <span class="text-danger">*</span></label>
                    <textarea name="problem" id="problem" class="form-control" rows="4" placeholder="Jelaskan kendala, keluhan, atau masalah pelanggaran siswa..." required>{{ old('problem') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="solution" class="form-label fw-semibold">Solusi / Penanganan</label>
                    <textarea name="solution" id="solution" class="form-control" rows="3" placeholder="Masukkan solusi, nasehat, atau pembinaan yang disepakati...">{{ old('solution') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="follow_up" class="form-label fw-semibold">Rencana Tindak Lanjut</label>
                    <textarea name="follow_up" id="follow_up" class="form-control" rows="2" placeholder="Langkah pemantauan selanjutnya (misal: panggil ortu jika terulang)...">{{ old('follow_up') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary-custom px-5 py-2"><i class="bi bi-save me-2"></i> Simpan Catatan Bimbingan</button>
        </div>
    </form>
</div>
@endsection
