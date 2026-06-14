@extends('layouts.app')

@section('title', 'Ajukan Konseling')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="mb-4">
        <a href="{{ route('schedules.index') }}" class="btn btn-link text-decoration-none p-0"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Jadwal</a>
        <h3 class="fw-bold mt-2 text-dark">Ajukan Bimbingan Konseling</h3>
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
                <form action="{{ route('schedules.store') }}" method="POST">
                    @csrf

                    @if(auth()->user()->isSiswa())
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Siswa Pemohon</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->name }} ({{ $student->nis }})" disabled>
                        </div>
                    @else
                        <div class="mb-3">
                            <label for="student_id" class="form-label fw-semibold">Pilih Siswa <span class="text-danger">*</span></label>
                            <select name="student_id" id="student_id" class="form-select" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($students as $stud)
                                    <option value="{{ $stud->id }}" {{ old('student_id') == $stud->id ? 'selected' : '' }}>
                                        {{ $stud->nis }} - {{ $stud->user->name }} ({{ $stud->schoolClass->full_name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="counselor_id" class="form-label fw-semibold">Pilih Guru BK (Konselor) <span class="text-danger">*</span></label>
                        <select name="counselor_id" id="counselor_id" class="form-select" required>
                            <option value="">-- Pilih Guru BK --</option>
                            @foreach($counselors as $counselor)
                                <option value="{{ $counselor->id }}" {{ old('counselor_id') == $counselor->id ? 'selected' : '' }}>
                                    {{ $counselor->name }} - [{{ $counselor->teacher->specialization ?? 'Bimbingan Konseling' }}]
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label fw-semibold">Tanggal Pertemuan <span class="text-danger">*</span></label>
                        <input type="date" name="date" id="date" class="form-control" required min="{{ now()->format('Y-m-d') }}" value="{{ old('date', now()->format('Y-m-d')) }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="time_start" class="form-label fw-semibold">Jam Mulai <span class="text-danger">*</span></label>
                            <input type="time" name="time_start" id="time_start" class="form-control" required value="{{ old('time_start') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="time_end" class="form-label fw-semibold">Jam Selesai <span class="text-danger">*</span></label>
                            <input type="time" name="time_end" id="time_end" class="form-control" required value="{{ old('time_end') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label fw-semibold">Alasan Konseling / Catatan Pengajuan</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Jelaskan secara singkat perihal keluhan atau alasan bimbingan..." required>{{ old('notes') }}</textarea>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary-custom px-4"><i class="bi bi-save me-2"></i> Ajukan Jadwal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
