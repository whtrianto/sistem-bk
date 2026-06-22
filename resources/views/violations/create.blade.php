@extends('layouts.app')

@section('title', 'Catat Pelanggaran')

@section('content')
    <div class="container-fluid fade-in-section">
        <div class="mb-4">
            <a href="{{ route('violations.index') }}" class="btn btn-link text-decoration-none p-0"><i
                    class="bi bi-arrow-left"></i> Kembali ke Riwayat</a>
            <h3 class="fw-bold mt-2 text-dark">Catat Pelanggaran Baru</h3>
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
                    <form action="{{ route('violations.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="student_id" class="form-label fw-semibold">Pilih Siswa <span
                                    class="text-danger">*</span></label>
                            <select name="student_id" id="student_id" class="form-select" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->nis }} - {{ $student->user->name }}
                                        ({{ $student->schoolClass->full_name ?? 'Tanpa Kelas' }}) - [Poin:
                                        {{ $student->current_points }}]
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="violation_type_id" class="form-label fw-semibold">Jenis Pelanggaran <span
                                    class="text-danger">*</span></label>
                            <select name="violation_type_id" id="violation_type_id" class="form-select" required>
                                <option value="">-- Pilih Jenis Pelanggaran --</option>
                                @foreach($violationTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('violation_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }} - [{{ $type->category }} + {{ $type->points }} Point Pelanggaran]
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label fw-semibold">Tanggal Kejadian <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="date" id="date" class="form-control" required
                                value="{{ old('date', now()->format('Y-m-d')) }}">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Catatan Keterangan / Kronologi</label>
                            <textarea name="description" id="description" class="form-control" rows="3"
                                placeholder="Masukkan kronologi singkat kejadian...">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-3 form-check mt-3 bg-light p-3 rounded-3 border">
                            <input type="checkbox" name="send_wa" class="form-check-input ms-0 me-2" id="send_wa" value="1"
                                checked>
                            <label class="form-check-label fw-bold text-success" for="send_wa">
                                <i class="bi bi-whatsapp me-1"></i> Kirim Notifikasi WhatsApp Otomatis Ke Orang Tua / Wali
                            </label>
                            <div class="form-text text-muted ps-0 mt-1">Sistem akan otomatis mengirim detail pelanggaran
                                beserta sisa poin kredit siswa saat ini.</div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-danger px-4"><i
                                    class="bi bi-exclamation-triangle me-2"></i> Simpan & Kurangi Poin</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection