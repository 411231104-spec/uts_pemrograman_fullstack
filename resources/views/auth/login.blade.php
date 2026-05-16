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
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(99, 102, 241, 0.05) 0px, transparent 50%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 48px 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
        }

        .brand-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .brand-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
            margin: 0 auto 16px;
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        }

        .login-title {
            color: #0f172a;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .login-sub {
            color: #64748b;
            font-size: 14px;
        }

        .form-label {
            color: #475569;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control {
            background-color: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            color: #1e293b;
            font-size: 15px;
            padding: 12px 16px;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            background-color: #ffffff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .input-group-text {
            background-color: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: #64748b;
            padding-left: 16px;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 12px 12px 0;
        }

        .btn-login {
            background: #2563eb;
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            padding: 14px;
            width: 100%;
            margin-top: 10px;
            transition: all 0.2s ease;
        }

        .btn-login:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert-danger {
            background-color: #fef2f2;
            border: 1px solid #fee2e2;
            border-radius: 12px;
            color: #991b1b;
            font-size: 14px;
            padding: 12px 16px;
        }

        .demo-accounts {
            margin-top: 40px;
            padding-top: 24px;
            border-top: 1px solid #f1f5f9;
        }

        .demo-accounts p {
            color: #94a3b8;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 16px;
        }

        .demo-badge {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px;
            height: 100%;
            transition: all 0.2s ease;
        }

        .demo-badge:hover {
            border-color: #cbd5e1;
            background: #f1f5f9;
        }

        .demo-badge strong {
            color: #334155;
            font-size: 13px;
            display: block;
            margin-bottom: 4px;
        }

        .demo-badge span {
            color: #64748b;
            font-size: 12px;
            display: block;
            word-break: break-all;
        }

        .demo-badge .pass {
            color: #94a3b8;
            font-family: monospace;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="brand-section">
            <div class="brand-icon"><i class="bi bi-grid-1x2-fill"></i></div>
            <h1 class="login-title">Smart-Hub</h1>
            <p class="login-sub">Masuk ke Management System</p>
        </div>

        @if($errors->any())
        <div class="alert alert-danger mb-4">
            <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label class="form-label">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control"
                        placeholder="nama@test.com" value="{{ old('email') }}" required autofocus>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control"
                        placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="btn-login">
                Masuk Sekarang
            </button>
        </form>

        <div class="demo-accounts">
            <p>Akun Uji Coba</p>
            <div class="row g-3">
                <div class="col-6">
                    <div class="demo-badge">
                        <strong>Admin Access</strong>
                        <span>anza@test.com</span>
                        <div class="pass">admin123</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="demo-badge">
                        <strong>Member Access</strong>
                        <span>fiony@test.com</span>
                        <div class="pass">member123</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
