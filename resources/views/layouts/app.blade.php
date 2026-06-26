<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Lab Tracker')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        .navbar-brand { font-weight: 700; letter-spacing: 0.5px; }
        .badge-role { font-size: 0.7rem; vertical-align: middle; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">🔬 Lab Tracker</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                @auth
                <div class="navbar-nav me-auto">
                    {{-- Menu Admin --}}
                    @if(auth()->user()->isAdmin())
                        <a class="nav-link {{ request()->routeIs('admin.alat.*') ? 'active' : '' }}"
                           href="{{ route('admin.alat.index') }}">
                            <i class="bi bi-tools"></i> Alat
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.peminjam.*') ? 'active' : '' }}"
                           href="{{ route('admin.peminjam.index') }}">
                            <i class="bi bi-people"></i> Peminjam
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}"
                           href="{{ route('admin.peminjaman.index') }}">
                            <i class="bi bi-clipboard-list"></i> Peminjaman
                        </a>
                    @endif

                    {{-- Menu User --}}
                    @if(auth()->user()->isUser())
                        <a class="nav-link {{ request()->routeIs('user.peminjaman.*') ? 'active' : '' }}"
                           href="{{ route('user.peminjaman.index') }}">
                            <i class="bi bi-clipboard-list"></i> Peminjaman Saya
                        </a>
                    @endif
                </div>

                {{-- Info user & logout --}}
                <div class="navbar-nav ms-auto align-items-center">
                    <span class="nav-link text-light">
                        <i class="bi bi-person-circle"></i>
                        {{ auth()->user()->name }}
                        <span class="badge {{ auth()->user()->isAdmin() ? 'bg-danger' : 'bg-primary' }} badge-role ms-1">
                            {{ strtoupper(auth()->user()->role) }}
                        </span>
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-outline-light ms-2">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container py-4">
        {{-- Alert sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Alert error --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>