<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Lab Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        :root {
            --lt-navy:   #0D1B2A;
            --lt-accent: #2563EB;
            --lt-bg:     #F7F8FC;
            --lt-border: #E2E8F0;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: var(--lt-bg);
        }

        /* ── LEFT PANEL ── */
        .auth-left {
            display: none;
            width: 42%;
            background: var(--lt-navy);
            position: relative;
            overflow: hidden;
            padding: 48px 40px;
            flex-direction: column;
            justify-content: space-between;
        }

        @media (min-width: 900px) { .auth-left { display: flex; } }

        .auth-left::before {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: rgba(37,99,235,.15);
            top: -100px; right: -100px;
        }

        .auth-left::after {
            content: '';
            position: absolute;
            width: 250px; height: 250px;
            border-radius: 50%;
            background: rgba(37,99,235,.1);
            bottom: 60px; left: -80px;
        }

        .auth-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            position: relative;
            z-index: 1;
        }

        .auth-brand-icon {
            width: 36px; height: 36px;
            background: var(--lt-accent);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
        }

        .auth-hero { position: relative; z-index: 1; }

        .auth-hero h2 {
            color: #fff;
            font-size: 1.7rem;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 12px;
        }

        .auth-hero p {
            color: rgba(255,255,255,.55);
            font-size: .9rem;
            line-height: 1.6;
        }

        .auth-features { position: relative; z-index: 1; }

        .auth-feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255,255,255,.7);
            font-size: .82rem;
            margin-bottom: 10px;
        }

        .auth-feature-item i {
            width: 24px; height: 24px;
            background: rgba(37,99,235,.25);
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            color: #60A5FA;
            font-size: .75rem;
            flex-shrink: 0;
        }

        /* ── RIGHT PANEL ── */
        .auth-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 20px;
        }

        .auth-box {
            width: 100%;
            max-width: 400px;
        }

        .auth-box-header { margin-bottom: 28px; }

        .auth-box-header .mobile-brand {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            color: var(--lt-navy);
            margin-bottom: 20px;
        }

        @media (min-width: 900px) { .auth-box-header .mobile-brand { display: none; } }

        .mobile-brand-icon {
            width: 30px; height: 30px;
            background: var(--lt-accent);
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: .85rem;
        }

        .auth-box-header h1 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--lt-navy);
            margin-bottom: 4px;
        }

        .auth-box-header p {
            color: #64748B;
            font-size: .875rem;
        }

        /* ── FORM ── */
        .form-group { margin-bottom: 16px; }

        .form-group label {
            display: block;
            font-size: .78rem;
            font-weight: 600;
            color: #475569;
            letter-spacing: .3px;
            margin-bottom: 6px;
        }

        .input-wrap { position: relative; }

        .input-wrap .input-icon {
            position: absolute;
            left: 11px; top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
            font-size: .9rem;
            pointer-events: none;
        }

        .input-wrap .form-control {
            padding-left: 34px;
            border: 1px solid var(--lt-border);
            border-radius: 8px;
            font-size: .875rem;
            height: 42px;
            transition: border-color .15s, box-shadow .15s;
            background: #fff;
        }

        .input-wrap .form-control:focus {
            border-color: var(--lt-accent);
            box-shadow: 0 0 0 3px rgba(37,99,235,.1);
            outline: none;
        }

        .input-wrap .form-control.is-invalid { border-color: #DC2626; }

        .error-msg {
            font-size: .75rem;
            color: #DC2626;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .alert-err {
            background: #FFF1F2;
            color: #B91C1C;
            border-left: 3px solid #DC2626;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: .83rem;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 20px;
            margin-top: -4px;
        }

        .remember-row label {
            font-size: .82rem;
            color: #64748B;
            cursor: pointer;
        }

        .btn-auth {
            width: 100%;
            background: var(--lt-accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            height: 42px;
            font-size: .875rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: background .15s, transform .1s;
            cursor: pointer;
        }

        .btn-auth:hover {
            background: #1D4ED8;
            transform: translateY(-1px);
        }

        .auth-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 20px 0;
            color: #CBD5E1;
            font-size: .8rem;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--lt-border);
        }

        .auth-footer {
            text-align: center;
            font-size: .83rem;
            color: #64748B;
        }

        .auth-footer a {
            color: var(--lt-accent);
            font-weight: 600;
            text-decoration: none;
        }

        .auth-footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    {{-- LEFT PANEL --}}
    <div class="auth-left">
        <div class="auth-brand">
            <div class="auth-brand-icon">
                <i class="bi bi-eyedropper text-white"></i>
            </div>
            Lab Tracker
        </div>

        <div class="auth-hero">
            <h2>Kelola peminjaman alat lab dengan mudah</h2>
            <p>Sistem pencatatan terintegrasi untuk administrator dan peminjam.</p>
        </div>

        <div class="auth-features">
            <div class="auth-feature-item">
                <i class="bi bi-tools"></i>
                <span>Manajemen inventaris alat laboratorium</span>
            </div>
            <div class="auth-feature-item">
                <i class="bi bi-people"></i>
                <span>Data peminjam terkelola dengan baik</span>
            </div>
            <div class="auth-feature-item">
                <i class="bi bi-clock-history"></i>
                <span>Riwayat & status peminjaman real-time</span>
            </div>
        </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="auth-right">
        <div class="auth-box">
            <div class="auth-box-header">
                <div class="mobile-brand">
                    <div class="mobile-brand-icon">
                        <i class="bi bi-eyedropper"></i>
                    </div>
                    Lab Tracker
                </div>
                <h1>Selamat datang kembali</h1>
                <p>Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            @if ($errors->any())
                <div class="alert-err">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Email</label>
                    <div class="input-wrap">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" name="email"
                               value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="nama@email.com"
                               autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrap">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" name="password"
                               class="form-control"
                               placeholder="Masukkan password">
                    </div>
                </div>

                <div class="remember-row">
                    <input type="checkbox" name="remember" id="remember"
                           class="form-check-input" style="margin:0">
                    <label for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn-auth">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk
                </button>
            </form>

            <div class="auth-divider">atau</div>

            <div class="auth-footer">
                Belum punya akun?
                <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>