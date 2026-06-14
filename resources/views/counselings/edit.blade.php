@extends('layouts.app')

@section('title', 'Tindak Lanjut Konseling')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="mb-4">
        <a href="{{ route('counselings.show', $counseling) }}" class="btn btn-link text-decoration-none p-0"><i class="bi bi-arrow-left"></i> Kembali ke Rincian</a>
        <h3 class="fw-bold mt-2 text-dark">Tindak Lanjut & Pembinaan Siswa</h3>
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
        <!-- Counselor summary panel -->
        <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="card border-0 glass-card p-4">
                <h5 class="fw-bold mb-3 text-dark border-bottom pb-2">Informasi Sesi BK</h5>
                <table class="table table-sm table-borderless m-0">
                    <tr>
                        <td class="fw-semibold text-muted" style="width: 40%;">Siswa</td>
                        <td class="fw-bold">: {{ $counseling->student->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold text-muted">Kelas</td>
                        <td>: {{ $counseling->student->schoolClass->full_name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold text-muted">Kategori</td>
                        <td>: {{ $counseling->category->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold text-muted">Tanggal</td>
                        <td>: {{ $counseling->date->format('d/m/Y') }}</td>
                    </tr>
                </table>
                <div class="mt-4 p-3 bg-light rounded-3">
                    <h6 class="fw-bold text-secondary mb-2">Masalah Yang Diajukan:</h6>
                    <p class="m-0 text-dark fs-7" style="white-space: pre-line;">{{ $counseling->problem }}</p>
                </div>
            </div>
        </div>

        <!-- Form Panel -->
        <div class="col-lg-8">
            <div class="card border-0 glass-card p-4">
                <form action="{{ route('counselings.update', $counseling) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold">Status Bimbingan BK <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="pending" {{ old('status', $counseling->status) == 'pending' ? 'selected' : '' }}>Pending (Belum Berlangsung / Menunggu Tindakan)</option>
                            <option value="ongoing" {{ old('status', $counseling->status) == 'ongoing' ? 'selected' : '' }}>Ongoing (Sesi Pendampingan Sedang Berjalan)</option>
                            <option value="completed" {{ old('status', $counseling->status) == 'completed' ? 'selected' : '' }}>Completed (Selesai Pembinaan / Masalah Teratasi)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="solution" class="form-label fw-semibold">Solusi & Catatan Pembinaan</label>
                        <textarea name="solution" id="solution" class="form-control" rows="5" placeholder="Masukkan detail langkah nasehat, arahan, kesepakatan solusi dengan siswa...">{{ old('solution', $counseling->solution) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="follow_up" class="form-label fw-semibold">Rencana Tindak Lanjut</label>
                        <textarea name="follow_up" id="follow_up" class="form-control" rows="3" placeholder="Rencana pantau lanjutan, jadwal pertemuan selanjutnya, atau perjanjian khusus...">{{ old('follow_up', $counseling->follow_up) }}</textarea>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary-custom px-4"><i class="bi bi-save me-2"></i> Perbarui & Tindak Lanjut</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
