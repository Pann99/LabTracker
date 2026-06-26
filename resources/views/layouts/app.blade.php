<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Lab Tracker')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        :root {
            --lt-bg:        #F7F8FC;
            --lt-surface:   #FFFFFF;
            --lt-navy:      #0D1B2A;
            --lt-navy-soft: #1A2E45;
            --lt-accent:    #2563EB;
            --lt-accent-lt: #EFF6FF;
            --lt-green:     #16A34A;
            --lt-amber:     #D97706;
            --lt-red:       #DC2626;
            --lt-muted:     #64748B;
            --lt-border:    #E2E8F0;
            --lt-radius:    10px;
            --lt-shadow:    0 1px 3px rgba(0,0,0,.08), 0 4px 16px rgba(0,0,0,.06);
        }

        * { box-sizing: border-box; }

        body {
            background: var(--lt-bg);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: #1E293B;
            min-height: 100vh;
        }

        /* ── NAVBAR ── */
        .lt-nav {
            background: var(--lt-navy);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0,0,0,.2);
        }

        .lt-nav .navbar-brand {
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: .3px;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 14px 0;
        }

        .lt-nav .navbar-brand .brand-icon {
            width: 32px;
            height: 32px;
            background: var(--lt-accent);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .95rem;
        }

        .lt-nav .nav-link {
            color: rgba(255,255,255,.65) !important;
            font-size: .875rem;
            font-weight: 500;
            padding: 18px 14px !important;
            border-bottom: 3px solid transparent;
            transition: color .15s, border-color .15s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .lt-nav .nav-link:hover,
        .lt-nav .nav-link.active {
            color: #fff !important;
            border-bottom-color: var(--lt-accent);
        }

        .lt-nav .nav-link.active { color: #fff !important; }

        .lt-user-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            color: rgba(255,255,255,.85);
            font-size: .8rem;
            padding: 6px 10px;
            background: rgba(255,255,255,.08);
            border-radius: 30px;
        }

        .lt-user-pill .role-badge {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .5px;
            padding: 2px 7px;
            border-radius: 20px;
        }

        .lt-nav .btn-logout {
            background: transparent;
            border: 1px solid rgba(255,255,255,.25);
            color: rgba(255,255,255,.8);
            font-size: .8rem;
            padding: 5px 12px;
            border-radius: 6px;
            transition: all .15s;
        }

        .lt-nav .btn-logout:hover {
            background: rgba(255,255,255,.1);
            color: #fff;
        }

        .navbar-toggler {
            border: 1px solid rgba(255,255,255,.25);
            padding: 4px 8px;
        }

        .navbar-toggler-icon {
            filter: invert(1);
            width: 18px;
            height: 18px;
        }

        /* ── PAGE WRAPPER ── */
        .lt-page {
            max-width: 1100px;
            margin: 0 auto;
            padding: 28px 16px 60px;
        }

        /* ── PAGE HEADER ── */
        .lt-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 24px;
        }

        .lt-header h1 {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--lt-navy);
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
        }

        .lt-header h1 .page-icon {
            width: 36px;
            height: 36px;
            background: var(--lt-accent-lt);
            color: var(--lt-accent);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        /* ── CARD ── */
        .lt-card {
            background: var(--lt-surface);
            border-radius: var(--lt-radius);
            box-shadow: var(--lt-shadow);
            border: 1px solid var(--lt-border);
        }

        .lt-card-body { padding: 20px 24px; }

        /* ── FILTER BAR ── */
        .lt-filter-bar {
            background: var(--lt-surface);
            border: 1px solid var(--lt-border);
            border-radius: var(--lt-radius);
            padding: 14px 20px;
            margin-bottom: 16px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }

        .lt-filter-bar .form-select,
        .lt-filter-bar .form-control {
            font-size: .85rem;
            border-color: var(--lt-border);
            border-radius: 6px;
            min-width: 140px;
            height: 36px;
            padding: 4px 10px;
        }

        /* ── TABLE ── */
        .lt-table-wrap {
            background: var(--lt-surface);
            border-radius: var(--lt-radius);
            box-shadow: var(--lt-shadow);
            border: 1px solid var(--lt-border);
            overflow: hidden;
        }

        .lt-table {
            margin: 0;
            font-size: .875rem;
            width: 100%;
        }

        .lt-table thead th {
            background: var(--lt-navy);
            color: rgba(255,255,255,.9);
            font-size: .75rem;
            font-weight: 600;
            letter-spacing: .5px;
            text-transform: uppercase;
            padding: 12px 16px;
            border: none;
            white-space: nowrap;
        }

        .lt-table thead th a {
            color: rgba(255,255,255,.9) !important;
            text-decoration: none;
        }

        .lt-table thead th a:hover { color: #fff !important; }

        .lt-table tbody td {
            padding: 12px 16px;
            border-color: var(--lt-border);
            vertical-align: middle;
            color: #334155;
        }

        .lt-table tbody tr:hover { background: #F8FAFF; }

        .lt-table .empty-row td {
            padding: 40px;
            text-align: center;
            color: var(--lt-muted);
            font-size: .875rem;
        }

        /* ── BADGES ── */
        .lt-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: .3px;
            padding: 3px 9px;
            border-radius: 20px;
        }

        .lt-badge-green  { background: #DCFCE7; color: #15803D; }
        .lt-badge-amber  { background: #FEF3C7; color: #B45309; }
        .lt-badge-red    { background: #FEE2E2; color: #B91C1C; }
        .lt-badge-blue   { background: #DBEAFE; color: #1D4ED8; }
        .lt-badge-gray   { background: #F1F5F9; color: #475569; }

        /* ── BUTTONS ── */
        .btn-lt-primary {
            background: var(--lt-accent);
            color: #fff;
            border: none;
            border-radius: 7px;
            font-size: .85rem;
            font-weight: 600;
            padding: 8px 16px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background .15s, transform .1s;
        }

        .btn-lt-primary:hover {
            background: #1D4ED8;
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-lt-ghost {
            background: transparent;
            color: var(--lt-muted);
            border: 1px solid var(--lt-border);
            border-radius: 7px;
            font-size: .8rem;
            padding: 5px 12px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all .15s;
        }

        .btn-lt-ghost:hover {
            background: var(--lt-bg);
            color: #334155;
            border-color: #CBD5E1;
        }

        .btn-lt-danger {
            background: transparent;
            color: var(--lt-red);
            border: 1px solid #FECACA;
            border-radius: 7px;
            font-size: .8rem;
            padding: 5px 12px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all .15s;
        }

        .btn-lt-danger:hover {
            background: #FEF2F2;
            border-color: var(--lt-red);
        }

        .btn-lt-success {
            background: var(--lt-green);
            color: #fff;
            border: none;
            border-radius: 7px;
            font-size: .8rem;
            padding: 5px 12px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: background .15s;
        }

        .btn-lt-success:hover { background: #15803D; color: #fff; }

        /* ── ACTION BUTTONS IN TABLE ── */
        .action-group { display: flex; gap: 6px; align-items: center; flex-wrap: wrap; }

        /* ── ALERTS ── */
        .lt-alert {
            border-radius: var(--lt-radius);
            padding: 12px 16px;
            font-size: .875rem;
            border: none;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 16px;
        }

        .lt-alert-success {
            background: #F0FDF4;
            color: #15803D;
            border-left: 3px solid var(--lt-green);
        }

        .lt-alert-danger {
            background: #FFF1F2;
            color: #B91C1C;
            border-left: 3px solid var(--lt-red);
        }

        .lt-alert-warning {
            background: #FFFBEB;
            color: #92400E;
            border-left: 3px solid var(--lt-amber);
        }

        .lt-alert-info {
            background: var(--lt-accent-lt);
            color: #1E40AF;
            border-left: 3px solid var(--lt-accent);
        }

        /* ── MODAL ── */
        .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,.15);
        }

        .modal-header {
            background: var(--lt-navy);
            color: #fff;
            border-radius: 12px 12px 0 0;
            padding: 16px 24px;
            border: none;
        }

        .modal-header .modal-title {
            font-size: .95rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modal-header .btn-close {
            filter: invert(1);
            opacity: .7;
        }

        .modal-header .btn-close:hover { opacity: 1; }

        .modal-body { padding: 24px; }
        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--lt-border);
            gap: 8px;
        }

        /* ── FORM CONTROLS IN MODAL ── */
        .lt-form-group { margin-bottom: 18px; }

        .lt-form-group label {
            font-size: .8rem;
            font-weight: 600;
            color: #475569;
            letter-spacing: .3px;
            margin-bottom: 6px;
            display: block;
        }

        .lt-form-group .form-control,
        .lt-form-group .form-select {
            border: 1px solid var(--lt-border);
            border-radius: 7px;
            font-size: .875rem;
            padding: 8px 12px;
            transition: border-color .15s, box-shadow .15s;
        }

        .lt-form-group .form-control:focus,
        .lt-form-group .form-select:focus {
            border-color: var(--lt-accent);
            box-shadow: 0 0 0 3px rgba(37,99,235,.1);
            outline: none;
        }

        .lt-form-group .invalid-feedback { font-size: .78rem; }

        /* ── PAGINATION ── */
        .pagination { margin-top: 16px; gap: 4px; }

        .page-link {
            border-radius: 6px !important;
            border: 1px solid var(--lt-border);
            color: var(--lt-accent);
            font-size: .8rem;
            padding: 6px 12px;
        }

        .page-item.active .page-link {
            background: var(--lt-accent);
            border-color: var(--lt-accent);
        }

        /* ── KODE CHIP ── */
        .kode-chip {
            font-family: monospace;
            font-size: .78rem;
            background: var(--lt-bg);
            border: 1px solid var(--lt-border);
            border-radius: 4px;
            padding: 2px 7px;
            color: #475569;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .lt-page { padding: 16px 12px 40px; }
            .lt-header h1 { font-size: 1.1rem; }
            .lt-table thead { display: none; }
            .lt-table tbody td {
                display: flex;
                padding: 8px 14px;
                border: none;
                font-size: .83rem;
            }
            .lt-table tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--lt-muted);
                min-width: 110px;
                font-size: .75rem;
            }
            .lt-table tbody tr {
                display: block;
                border: 1px solid var(--lt-border);
                border-radius: 8px;
                margin-bottom: 10px;
                background: var(--lt-surface);
                overflow: hidden;
            }
            .lt-table tbody tr:hover { background: var(--lt-surface); }
            .lt-table .empty-row { display: table-row !important; }
            .lt-table .empty-row td { display: table-cell !important; }
            .lt-table tbody td.action-cell {
                justify-content: flex-start;
                padding-top: 12px;
                padding-bottom: 12px;
                background: var(--lt-bg);
            }
            .lt-filter-bar { flex-direction: column; align-items: stretch; }
            .lt-filter-bar .form-select,
            .lt-filter-bar .form-control { min-width: unset; width: 100%; }
            .lt-nav .nav-link { padding: 12px 16px !important; border-bottom: none; border-left: 3px solid transparent; }
            .lt-nav .nav-link.active { border-left-color: var(--lt-accent); }
            .lt-user-pill { margin: 8px 16px 0; }
            .btn-logout-wrap { padding: 8px 16px 12px; }
        }

        @media (max-width: 480px) {
            .btn-lt-primary { font-size: .8rem; padding: 7px 13px; }
        }
    </style>
    @yield('styles')
</head>
<body>

    {{-- ── NAVBAR ── --}}
    <nav class="navbar navbar-expand-lg lt-nav">
        <div class="container-fluid px-3 px-md-4">
            <a class="navbar-brand" href="/">
                <span class="brand-icon"><i class="bi bi-eyedropper text-white"></i></span>
                Lab Tracker
            </a>

            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navMenu"
                    aria-controls="navMenu" aria-label="Toggle nav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                @auth
                <ul class="navbar-nav me-auto mb-0">
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.alat.*') ? 'active' : '' }}"
                               href="{{ route('admin.alat.index') }}">
                                <i class="bi bi-tools"></i> Alat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.peminjam.*') ? 'active' : '' }}"
                               href="{{ route('admin.peminjam.index') }}">
                                <i class="bi bi-people"></i> Peminjam
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}"
                               href="{{ route('admin.peminjaman.index') }}">
                                <i class="bi bi-clipboard-list"></i> Peminjaman
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->isUser())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.peminjaman.*') ? 'active' : '' }}"
                               href="{{ route('user.peminjaman.index') }}">
                                <i class="bi bi-clipboard-list"></i> Peminjaman Saya
                            </a>
                        </li>
                    @endif
                </ul>

                <div class="d-flex align-items-center gap-2 flex-wrap py-2 py-lg-0">
                    <span class="lt-user-pill">
                        <i class="bi bi-person-circle"></i>
                        <span>{{ auth()->user()->name }}</span>
                        <span class="role-badge {{ auth()->user()->isAdmin() ? 'bg-danger' : 'bg-primary' }}">
                            {{ strtoupper(auth()->user()->role) }}
                        </span>
                    </span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="bi bi-box-arrow-right"></i> Keluar
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ── PAGE CONTENT ── --}}
    <div class="lt-page">
        @if (session('success'))
            <div class="lt-alert lt-alert-success">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="lt-alert lt-alert-danger">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>