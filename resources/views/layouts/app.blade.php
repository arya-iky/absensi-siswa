<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Absensi Siswa')</title>

    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS & Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #334155;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }
        .table > :not(caption) > * > * {
            padding: 0.9rem 1rem;
            vertical-align: middle;
        }
        .btn {
            border-radius: 8px;
            font-weight: 500;
        }
        .form-control, .form-select {
            border-radius: 8px;
            border-color: #cbd5e1;
            padding: 0.6rem 0.9rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }
        .badge {
            font-weight: 500;
            padding: 0.45em 0.75em;
            border-radius: 6px;
        }
        footer {
            margin-top: auto;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ auth()->check() ? route('dashboard') : route('login') }}">
                <i class="bi bi-calendar-check-fill fs-4"></i>
                <span>Absensi Siswa</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                @auth
                    <ul class="navbar-nav me-auto align-items-center gap-1">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold' : '' }}" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard
                            </a>
                        </li>
                        @if(auth()->user()->isAdmin() || auth()->user()->isGuru())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('absensi.index') ? 'active fw-bold' : '' }}" href="{{ route('absensi.index') }}">
                                    <i class="bi bi-check2-square me-1"></i> Input Absensi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('absensi.rekap') ? 'active fw-bold' : '' }}" href="{{ route('absensi.rekap') }}">
                                    <i class="bi bi-file-earmark-bar-graph-fill me-1"></i> Rekap Kehadiran
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->routeIs('siswa.*', 'kelas.*', 'guru.*', 'mapel.*') ? 'active fw-bold' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-folder2-open me-1"></i> Data Induk
                                </a>
                                <ul class="dropdown-menu shadow border-0">
                                    <li><a class="dropdown-item" href="{{ route('siswa.index') }}"><i class="bi bi-people-fill me-2 text-primary"></i> Data Siswa</a></li>
                                    <li><a class="dropdown-item" href="{{ route('kelas.index') }}"><i class="bi bi-door-open-fill me-2 text-success"></i> Data Kelas</a></li>
                                    <li><a class="dropdown-item" href="{{ route('guru.index') }}"><i class="bi bi-person-badge-fill me-2 text-warning"></i> Data Guru</a></li>
                                    <li><a class="dropdown-item" href="{{ route('mapel.index') }}"><i class="bi bi-book-half me-2 text-info"></i> Data Mapel</a></li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('absensi.riwayat') ? 'active fw-bold' : '' }}" href="{{ route('absensi.riwayat') }}">
                                    <i class="bi bi-calendar-check-fill me-1"></i> Riwayat Absensi Saya
                                </a>
                            </li>
                        @endif
                    </ul>

                    {{-- User Profile & Logout --}}
                    <ul class="navbar-nav ms-auto align-items-center gap-2">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="d-none d-md-block text-start">
                                    <div class="fw-semibold small leading-tight">{{ auth()->user()->name }}</div>
                                    <div>
                                        @if(auth()->user()->isAdmin())
                                            <span class="badge bg-warning text-dark" style="font-size: 0.65rem;">ADMIN</span>
                                        @elseif(auth()->user()->isGuru())
                                            <span class="badge bg-success" style="font-size: 0.65rem;">GURU</span>
                                        @else
                                            <span class="badge bg-light text-dark" style="font-size: 0.65rem;">SISWA</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                <li class="px-3 py-2 border-bottom">
                                    <div class="fw-bold small">{{ auth()->user()->name }}</div>
                                    <div class="text-muted small" style="font-size: 0.75rem;">{{ auth()->user()->email }}</div>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger py-2">
                                            <i class="bi bi-box-arrow-right me-2"></i> Keluar (Logout)
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @else
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a class="btn btn-light btn-sm px-3 fw-semibold text-primary" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                            </a>
                        </li>
                    </ul>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container py-4">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-top py-3 text-center text-muted small">
        <div class="container">
            &copy; {{ date('Y') }} Sistem Absensi Siswa. Dibuat dengan Laravel 13 & Bootstrap 5.
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
