@extends('layouts.app')

@section('title', 'Buat Surat Panggilan')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="mb-4">
        <a href="{{ route('letters.index') }}" class="btn btn-link text-decoration-none p-0"><i class="bi bi-arrow-left"></i> Kembali ke Arsip</a>
        <h3 class="fw-bold mt-2 text-dark">Buat Surat Panggilan Orang Tua</h3>
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
                <form action="{{ route('letters.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="student_id" class="form-label fw-semibold">Pilih Siswa Terkait <span class="text-danger">*</span></label>
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
                        <label for="reason" class="form-label fw-semibold">Alasan Pemanggilan <span class="text-danger">*</span></label>
                        <textarea name="reason" id="reason" class="form-control" rows="3" placeholder="Masukkan alasan pemanggilan (misal: Pelanggaran disiplin akumulasi poin kurang dari 50)..." required>{{ old('reason') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="meeting_date" class="form-label fw-semibold">Tanggal Pertemuan <span class="text-danger">*</span></label>
                            <input type="date" name="meeting_date" id="meeting_date" class="form-control" required min="{{ now()->format('Y-m-d') }}" value="{{ old('meeting_date') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="meeting_time" class="form-label fw-semibold">Pukul / Jam <span class="text-danger">*</span></label>
                            <input type="time" name="meeting_time" id="meeting_time" class="form-control" required value="{{ old('meeting_time') }}">
                        </div>
                    </div>

                    <div class="mb-3 form-check mt-3 bg-light p-3 rounded-3 border">
                        <input type="checkbox" name="send_wa" class="form-check-input ms-0 me-2" id="send_wa" value="1" checked>
                        <label class="form-check-label fw-bold text-success" for="send_wa">
                            <i class="bi bi-whatsapp me-1"></i> Kirim Surat Panggilan via WhatsApp Otomatis
                        </label>
                        <div class="form-text text-muted ps-0 mt-1">Sistem akan otomatis mengirimkan undangan digital ke nomor WhatsApp orang tua/wali siswa dengan tanggal dan pukul pertemuan di atas.</div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary-custom px-4"><i class="bi bi-file-earmark-pdf me-2"></i> Buat Surat & Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
