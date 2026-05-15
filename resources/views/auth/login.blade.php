<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Smart-Hub Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #0f172a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Animated background blobs */
        body::before {
            content: '';
            position: fixed; top: -200px; right: -200px;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(59,130,246,.25), transparent 70%);
            border-radius: 50%;
            animation: pulse 8s ease-in-out infinite;
        }
        body::after {
            content: '';
            position: fixed; bottom: -200px; left: -200px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(99,102,241,.2), transparent 70%);
            border-radius: 50%;
            animation: pulse 10s ease-in-out 2s infinite;
        }
        @keyframes pulse { 0%,100%{transform:scale(1);} 50%{transform:scale(1.1);} }

        .login-card {
            background: rgba(255,255,255,.04);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 20px;
            padding: 48px 40px;
            width: 100%; max-width: 420px;
            position: relative; z-index: 10;
        }

        .brand-icon {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 26px; color: white;
            margin: 0 auto 20px;
        }

        .login-title { color: #f1f5f9; font-size: 22px; font-weight: 700; text-align: center; }
        .login-sub   { color: #64748b; font-size: 13px; text-align: center; margin-bottom: 32px; }

        .form-label { color: #94a3b8; font-size: 12px; font-weight: 600; letter-spacing: .5px; text-transform: uppercase; margin-bottom: 6px; }

        .form-control {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 10px;
            color: #f1f5f9; font-size: 14px;
            padding: 12px 16px;
            transition: all .2s;
        }
        .form-control:focus {
            background: rgba(255,255,255,.08);
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,.2);
            color: #f1f5f9;
        }
        .form-control::placeholder { color: #475569; }

        .input-group-text {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.1);
            border-right: none;
            border-radius: 10px 0 0 10px;
            color: #64748b;
        }
        .input-group .form-control { border-left: none; border-radius: 0 10px 10px 0; }

        .btn-login {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            border: none; border-radius: 10px;
            color: white; font-size: 15px; font-weight: 600;
            padding: 13px; width: 100%;
            transition: all .3s;
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(59,130,246,.4); color: white; }
        .btn-login:active { transform: translateY(0); }

        .alert-danger {
            background: rgba(239,68,68,.12);
            border: 1px solid rgba(239,68,68,.2);
            border-radius: 10px; color: #fca5a5; font-size: 13px;
        }

        .demo-accounts { margin-top: 24px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,.06); }
        .demo-accounts p { color: #475569; font-size: 11px; text-align: center; margin-bottom: 10px; }
        .demo-badge {
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 8px; padding: 8px 12px;
            font-size: 11px; color: #64748b;
        }
        .demo-badge strong { color: #94a3b8; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="brand-icon"><i class="bi bi-grid-1x2-fill"></i></div>
        <h1 class="login-title">Selamat Datang</h1>
        <p class="login-sub">Masuk ke Smart-Hub Management System</p>

        @if($errors->any())
        <div class="alert alert-danger mb-3">
            <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control"
                        placeholder="email@smarthub.com" value="{{ old('email') }}" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control"
                        placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
            </button>
        </form>

        <div class="demo-accounts">
            <p>Akun Demo Tersedia</p>
            <div class="row g-2">
                <div class="col-6">
                    <div class="demo-badge">
                        <div><strong>Admin</strong></div>
                        <div>anza@test.com</div>
                        <div>admin123</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="demo-badge">
                        <div><strong>Member</strong></div>
                        <div>fiony@test.com</div>
                        <div>member123</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
