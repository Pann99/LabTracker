<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — Lab Tracker</title>
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

        .auth-steps { position: relative; z-index: 1; }

        .auth-step {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 16px;
        }

        .step-num {
            width: 24px; height: 24px;
            background: rgba(37,99,235,.3);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #93C5FD;
            font-size: .7rem;
            font-weight: 700;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .step-text { color: rgba(255,255,255,.65); font-size: .82rem; line-height: 1.5; }
        .step-text strong { color: rgba(255,255,255,.9); display: block; margin-bottom: 2px; }

        /* RIGHT */
        .auth-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 20px;
            overflow-y: auto;
        }

        .auth-box { width: 100%; max-width: 420px; }

        .auth-box-header { margin-bottom: 24px; }

        .mobile-brand {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            color: var(--lt-navy);
            margin-bottom: 20px;
        }

        @media (min-width: 900px) { .mobile-brand { display: none; } }

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

        .auth-box-header p { color: #64748B; font-size: .875rem; }

        .notice-bar {
            background: #EFF6FF;
            border: 1px solid #BFDBFE;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: .8rem;
            color: #1E40AF;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .form-group { margin-bottom: 14px; }

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
            width: 100%;
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
            margin-top: 20px;
        }

        .btn-auth:hover {
            background: #1D4ED8;
            transform: translateY(-1px);
        }

        .form-row { display: flex; gap: 12px; }
        .form-row .form-group { flex: 1; }

        .auth-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 18px 0;
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
    <div class="auth-left">
        <div class="auth-brand">
            <div class="auth-brand-icon">
                <i class="bi bi-eyedropper text-white"></i>
            </div>
            Lab Tracker
        </div>

        <div class="auth-hero">
            <h2>Bergabung dan mulai meminjam alat lab</h2>
            <p>Daftarkan akun Anda. Data peminjam Anda akan dibuat otomatis.</p>
        </div>

        <div class="auth-steps">
            <div class="auth-step">
                <div class="step-num">1</div>
                <div class="step-text">
                    <strong>Isi formulir pendaftaran</strong>
                    Lengkapi nama, email, NIM/NIP, dan password
                </div>
            </div>
            <div class="auth-step">
                <div class="step-num">2</div>
                <div class="step-text">
                    <strong>Akun & data peminjam dibuat otomatis</strong>
                    Sistem langsung mendaftarkan data Anda
                </div>
            </div>
            <div class="auth-step">
                <div class="step-num">3</div>
                <div class="step-text">
                    <strong>Siap meminjam alat</strong>
                    Login dan ajukan peminjaman alat laboratorium
                </div>
            </div>
        </div>
    </div>

    <div class="auth-right">
        <div class="auth-box">
            <div class="auth-box-header">
                <div class="mobile-brand">
                    <div class="mobile-brand-icon">
                        <i class="bi bi-eyedropper"></i>
                    </div>
                    Lab Tracker
                </div>
                <h1>Buat akun baru</h1>
                <p>Isi data di bawah untuk mendaftar sebagai peminjam</p>
            </div>

            <div class="notice-bar">
                <i class="bi bi-info-circle-fill"></i>
                Akun baru akan otomatis terdaftar sebagai <strong>&nbsp;Peminjam</strong>
            </div>

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <div class="input-wrap">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" name="name"
                               value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Nama lengkap">
                    </div>
                    @error('name')
                        <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>NIM / NIP</label>
                    <div class="input-wrap">
                        <i class="bi bi-credit-card input-icon"></i>
                        <input type="text" name="nim_nip"
                               value="{{ old('nim_nip') }}"
                               class="form-control @error('nim_nip') is-invalid @enderror"
                               placeholder="Nomor induk mahasiswa/pegawai">
                    </div>
                    @error('nim_nip')
                        <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <div class="input-wrap">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" name="email"
                               value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="nama@email.com">
                    </div>
                    @error('email')
                        <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-wrap">
                            <i class="bi bi-lock input-icon"></i>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Min. 6 karakter">
                        </div>
                        @error('password')
                            <div class="error-msg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi</label>
                        <div class="input-wrap">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" name="password_confirmation"
                                   class="form-control"
                                   placeholder="Ulangi password">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-auth">
                    <i class="bi bi-person-plus"></i> Daftar Sekarang
                </button>
            </form>

            <div class="auth-divider">atau</div>

            <div class="auth-footer">
                Sudah punya akun?
                <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>