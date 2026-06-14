@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100" style="background: radial-gradient(circle at 50% 50%, #1e293b 0%, #0f172a 100%); position: relative; overflow: hidden;">
    <!-- Abstract Glowing Blobs in Background -->
    <div style="position: absolute; width: 300px; height: 300px; background: rgba(99, 102, 241, 0.15); filter: blur(100px); border-radius: 50%; top: 20%; left: 20%; z-index: 1;"></div>
    <div style="position: absolute; width: 250px; height: 250px; background: rgba(139, 92, 246, 0.12); filter: blur(80px); border-radius: 50%; bottom: 20%; right: 20%; z-index: 1;"></div>

    <div class="container" style="position: relative; z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card border-0 p-4 text-center" style="background: rgba(30, 41, 59, 0.75); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3), inset 0 0 0 1px rgba(255, 255, 255, 0.15); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-radius: 24px;">
                    <div class="card-body">
                        <!-- Brand Identity -->
                        <div class="mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px; background: rgba(99, 102, 241, 0.1); border: 1px solid rgba(99, 102, 241, 0.2); border-radius: 20px; overflow: hidden;">
                                @if($logo = \App\Models\SchoolSetting::getValue('school_logo'))
                                    <img src="{{ asset($logo) }}" alt="Logo Sekolah" style="width: 100%; height: 100%; object-fit: contain; padding: 5px; background: white;">
                                @else
                                    <i class="bi bi-shield-lock-fill fs-2" style="background: linear-gradient(135deg, #38BDF8, #818CF8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                                @endif
                            </div>
                            <h3 class="fw-bold m-0 text-white" style="letter-spacing: 0.5px; font-family: 'Outfit', sans-serif;">
                                {{ \App\Models\SchoolSetting::getValue('school_name', 'SMK BK Gateway') }}
                            </h3>
                            <small class="text-secondary" style="font-size: 13px;">Bimbingan Konseling & Poin Kedisiplinan</small>
                        </div>

                        <!-- Errors Box -->
                        @if ($errors->any())
                            <div class="alert alert-danger border-0 text-start py-2 px-3 mb-3" style="background: rgba(239, 68, 68, 0.15); color: #FCA5A5; border-radius: 12px; font-size: 13px;">
                                <ul class="m-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Form -->
                        <form action="{{ route('login') }}" method="POST" class="text-start">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label text-muted fw-semibold" style="font-size: 13px; letter-spacing: 0.5px;">ALAMAT EMAIL</label>
                                <div class="input-group">
                                    <span class="input-group-text border-0" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); border-right: none; color: #E2E8F0; border-radius: 12px 0 0 12px;"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" id="email" class="form-control border-0 text-white" placeholder="nama@sekolah.sch.id" required value="{{ old('email') }}" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); border-left: none; border-radius: 0 12px 12px 0; padding: 10px 14px; font-size: 14px;">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label text-muted fw-semibold" style="font-size: 13px; letter-spacing: 0.5px;">KATA SANDI</label>
                                <div class="input-group">
                                    <span class="input-group-text border-0" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); border-right: none; color: #E2E8F0; border-radius: 12px 0 0 12px;"><i class="bi bi-key"></i></span>
                                    <input type="password" name="password" id="password" class="form-control border-0 text-white" placeholder="Masukkan password" required style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); border-left: none; border-radius: 0 12px 12px 0; padding: 10px 14px; font-size: 14px;">
                                </div>
                            </div>

                            <div class="mb-4 d-flex align-items-center justify-content-between">
                                <div class="form-check m-0">
                                    <input type="checkbox" name="remember" class="form-check-input" id="remember" style="background-color: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.15);">
                                    <label class="form-check-label text-secondary fw-medium" for="remember" style="font-size: 13px; user-select: none;">Ingat Saya</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2.5 d-flex align-items-center justify-content-center gap-2" style="background: linear-gradient(135deg, #38BDF8, #6366F1); border: none; border-radius: 12px; font-size: 15px; box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3); transition: all 0.3s ease;">
                                Masuk Sistem <i class="bi bi-arrow-right-short fs-5"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.25) !important;
    }
    .form-control:focus {
        background: rgba(255, 255, 255, 0.06) !important;
        color: white !important;
        box-shadow: none !important;
        border-color: rgba(99, 102, 241, 0.5) !important;
    }
    .form-control:focus + .input-group-text, 
    .input-group:focus-within .input-group-text {
        border-color: rgba(99, 102, 241, 0.5) !important;
        color: #38BDF8 !important;
    }
    .btn-primary:hover {
        transform: translateY(-1.5px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.45);
        background: linear-gradient(135deg, #0EA5E9, #4F46E5);
    }
    .btn-primary:active {
        transform: translateY(0);
    }
    .form-check-input:checked {
        background-color: #38BDF8 !important;
        border-color: #38BDF8 !important;
    }
</style>
@endsection
