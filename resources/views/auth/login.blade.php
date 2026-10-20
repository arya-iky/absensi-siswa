<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Absensi Siswa</title>

    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .login-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 8px 10px -6px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 100%;
            max-width: 440px;
            background: #ffffff;
        }
        .login-header {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 2rem 2rem 1.5rem 2rem;
            text-align: center;
        }
        .brand-icon {
            width: 56px;
            height: 56px;
            background: #2563eb;
            color: #ffffff;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.3);
        }
        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: 1px solid #cbd5e1;
        }
        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }
        .btn-login {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-weight: 600;
            background-color: #2563eb;
            border-color: #2563eb;
        }
        .btn-login:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }
        .demo-badge-btn {
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .demo-badge-btn:hover {
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <div class="brand-icon">
            <i class="bi bi-calendar-check-fill"></i>
        </div>
        <h4 class="fw-bold text-dark mb-1">Sistem Absensi Siswa</h4>
        <p class="text-muted small mb-0">Project Uji Kompetensi Keahlian (UKK) Rekayasa Perangkat Lunak</p>
    </div>

    <div class="p-4">
        {{-- Flash Alert Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show small d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show small d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                <div class="fw-semibold mb-1"><i class="bi bi-x-circle me-1"></i> Gagal Masuk:</div>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Form Login --}}
        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold small text-secondary">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" id="email" 
                           class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}" 
                           placeholder="nama@sekolah.sch.id" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold small text-secondary">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" id="password" 
                           class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" 
                           placeholder="••••••••" required>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small text-muted" for="remember">Ingat Saya</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-login w-100 shadow-sm">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Sistem
            </button>
        </form>

        {{-- Panel Akun Demo Pengujian UKK --}}
        <div class="mt-4 pt-3 border-top">
            <div class="text-center text-muted small fw-semibold mb-2">
                <i class="bi bi-lightning-charge-fill text-warning me-1"></i> Akun Pengujian Penilaian UKK:
            </div>
            <div class="d-flex flex-column gap-2">
                <button type="button" class="btn btn-sm btn-outline-primary demo-badge-btn text-start d-flex justify-content-between align-items-center"
                        onclick="fillCredentials('admin@sekolah.sch.id', 'password')">
                    <span><i class="bi bi-shield-lock-fill me-1"></i> <strong>Admin:</strong> admin@sekolah.sch.id</span>
                    <span class="badge bg-primary">Klik Isi</span>
                </button>
                <button type="button" class="btn btn-sm btn-outline-success demo-badge-btn text-start d-flex justify-content-between align-items-center"
                        onclick="fillCredentials('guru@sekolah.sch.id', 'password')">
                    <span><i class="bi bi-person-workspace me-1"></i> <strong>Guru:</strong> guru@sekolah.sch.id</span>
                    <span class="badge bg-success">Klik Isi</span>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary demo-badge-btn text-start d-flex justify-content-between align-items-center"
                        onclick="fillCredentials('siswa@sekolah.sch.id', 'password')">
                    <span><i class="bi bi-mortarboard-fill me-1"></i> <strong>Siswa:</strong> siswa@sekolah.sch.id</span>
                    <span class="badge bg-secondary">Klik Isi</span>
                </button>
            </div>
            <div class="text-center mt-2">
                <small class="text-muted" style="font-size: 0.75rem;">Password default semua akun: <code>password</code></small>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function fillCredentials(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
    }
</script>
</body>
</html>

