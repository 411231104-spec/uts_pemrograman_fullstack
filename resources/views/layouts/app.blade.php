<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Smart-Hub') | Sistem Manajemen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #0f172a;
            --sidebar-accent: #1e293b;
            --sidebar-active: #3b82f6;
            --sidebar-text: #94a3b8;
            --sidebar-text-active: #f1f5f9;
            --topbar-height: 64px;
            --body-bg: #f1f5f9;
            --card-radius: 14px;
            --primary: #3b82f6;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #6366f1;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--body-bg);
            color: #1e293b;
            margin: 0;
        }

        /* ─── SIDEBAR ─── */
        .sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: transform .3s ease;
        }

        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid #1e293b;
        }

        .sidebar-brand .brand-logo {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: white;
            flex-shrink: 0;
        }

        .sidebar-brand .brand-text h6 {
            color: #f1f5f9; font-size: 15px; font-weight: 700; margin: 0;
        }
        .sidebar-brand .brand-text small {
            color: #64748b; font-size: 11px;
        }

        .sidebar-menu { flex: 1; padding: 16px 0; overflow-y: auto; }

        .menu-section-label {
            font-size: 10px; font-weight: 600; letter-spacing: 1.2px;
            color: #475569; text-transform: uppercase;
            padding: 8px 20px 4px;
        }

        .sidebar-link {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 20px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 14px; font-weight: 500;
            border-radius: 0;
            transition: all .2s;
            position: relative;
        }
        .sidebar-link:hover {
            background: #1e293b;
            color: var(--sidebar-text-active);
        }
        .sidebar-link.active {
            background: rgba(59,130,246,.12);
            color: #60a5fa;
        }
        .sidebar-link.active::before {
            content: '';
            position: absolute; left: 0; top: 0; bottom: 0;
            width: 3px;
            background: var(--sidebar-active);
            border-radius: 0 3px 3px 0;
        }
        .sidebar-link i { font-size: 17px; width: 20px; text-align: center; }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid #1e293b;
        }

        /* ─── TOPBAR ─── */
        .topbar {
            position: fixed;
            top: 0; left: var(--sidebar-width); right: 0;
            height: var(--topbar-height);
            background: white;
            border-bottom: 1px solid #e2e8f0;
            display: flex; align-items: center;
            padding: 0 28px;
            z-index: 900;
            gap: 16px;
        }

        .topbar-title { font-size: 16px; font-weight: 600; flex: 1; }

        .user-badge {
            display: flex; align-items: center; gap: 10px;
            padding: 6px 14px;
            background: var(--body-bg);
            border-radius: 50px;
            font-size: 13px; font-weight: 500;
        }
        .user-avatar {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 13px; font-weight: 600;
        }

        /* ─── MAIN CONTENT ─── */
        .main-content {
            margin-left: var(--sidebar-width);
            padding-top: calc(var(--topbar-height) + 28px);
            padding-bottom: 40px;
            padding-left: 28px;
            padding-right: 28px;
            min-height: 100vh;
        }

        /* ─── CARDS ─── */
        .card {
            border: none;
            border-radius: var(--card-radius);
            box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
        }
        .card-header {
            background: white;
            border-bottom: 1px solid #f1f5f9;
            border-radius: var(--card-radius) var(--card-radius) 0 0 !important;
            padding: 18px 24px;
            font-weight: 600; font-size: 15px;
        }
        .card-body { padding: 24px; }

        /* ─── STAT CARDS ─── */
        .stat-card {
            border-radius: var(--card-radius);
            padding: 24px;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .stat-card::after {
            content: '';
            position: absolute;
            right: -20px; top: -20px;
            width: 100px; height: 100px;
            border-radius: 50%;
            background: rgba(255,255,255,.1);
        }
        .stat-card .stat-icon {
            font-size: 28px; margin-bottom: 12px; display: block;
        }
        .stat-card .stat-value {
            font-size: 32px; font-weight: 700; line-height: 1;
        }
        .stat-card .stat-label {
            font-size: 13px; opacity: .85; margin-top: 4px;
        }
        .bg-primary-gradient { background: linear-gradient(135deg, #3b82f6, #6366f1); }
        .bg-success-gradient { background: linear-gradient(135deg, #10b981, #059669); }
        .bg-warning-gradient { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .bg-danger-gradient  { background: linear-gradient(135deg, #ef4444, #dc2626); }

        /* ─── TABLES ─── */
        .table { margin: 0; }
        .table thead th {
            background: #f8fafc;
            font-size: 11px; font-weight: 600;
            text-transform: uppercase; letter-spacing: .8px;
            color: #64748b; border-bottom: 1px solid #e2e8f0;
            padding: 12px 16px;
        }
        .table td {
            padding: 14px 16px;
            vertical-align: middle;
            font-size: 14px; color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }
        .table tbody tr:last-child td { border-bottom: none; }
        .table tbody tr:hover { background: #f8fafc; }

        /* ─── BADGES ─── */
        .badge { font-size: 11px; font-weight: 600; padding: 5px 10px; border-radius: 50px; }
        .badge-available  { background: #dcfce7; color: #15803d; }
        .badge-borrowed   { background: #fef3c7; color: #92400e; }
        .badge-maintenance{ background: #fee2e2; color: #991b1b; }
        .badge-pending    { background: #e0e7ff; color: #3730a3; }
        .badge-approved   { background: #dcfce7; color: #15803d; }
        .badge-returned   { background: #f1f5f9; color: #64748b; }
        .badge-rejected   { background: #fee2e2; color: #991b1b; }
        .badge-admin      { background: #fef3c7; color: #92400e; }
        .badge-member     { background: #e0e7ff; color: #3730a3; }

        /* ─── FORMS ─── */
        .form-label { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
        .form-control, .form-select {
            border: 1px solid #e2e8f0;
            border-radius: 8px; font-size: 14px;
            padding: 10px 14px;
            transition: all .2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59,130,246,.12);
        }

        /* ─── BUTTONS ─── */
        .btn { border-radius: 8px; font-size: 13px; font-weight: 600; padding: 9px 18px; }
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: #2563eb; border-color: #2563eb; }
        .btn-sm { padding: 5px 12px; font-size: 12px; border-radius: 6px; }
        .btn-icon { width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 7px; }

        /* ─── PAGE HEADER ─── */
        .page-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 24px;
        }
        .page-header h4 { font-size: 20px; font-weight: 700; margin: 0; }
        .page-header .breadcrumb { font-size: 12px; color: #94a3b8; margin: 0; }

        /* ─── ALERTS ─── */
        .alert { border-radius: 10px; border: none; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #15803d; }
        .alert-danger   { background: #fee2e2; color: #991b1b; }

        /* ─── EMPTY STATE ─── */
        .empty-state { text-align: center; padding: 48px 24px; color: #94a3b8; }
        .empty-state i { font-size: 48px; margin-bottom: 12px; display: block; }
        .empty-state p { font-size: 14px; margin: 0; }

        /* ─── SCROLLBAR ─── */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
    </style>
    @stack('styles')
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar">
    <div class="sidebar-brand d-flex align-items-center gap-3">
        <div class="brand-logo"><i class="bi bi-grid-1x2-fill"></i></div>
        <div class="brand-text">
            <h6>Smart-Hub</h6>
            <small>Management System</small>
        </div>
    </div>

    <nav class="sidebar-menu">
        <div class="menu-section-label">Utama</div>
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="menu-section-label mt-2">Manajemen</div>
        <a href="{{ route('equipments.index') }}" class="sidebar-link {{ request()->routeIs('equipments.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Peralatan
        </a>
        <a href="{{ route('bookings.index') }}" class="sidebar-link {{ request()->routeIs('bookings.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i> Peminjaman
        </a>

        @if(Auth::user()->isAdmin())
        <a href="{{ route('checkins.index') }}" class="sidebar-link {{ request()->routeIs('checkins.*') ? 'active' : '' }}">
            <i class="bi bi-check2-circle"></i> Check-in
        </a>
        @endif

        <div class="menu-section-label mt-2">Akun</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-link w-100 text-start border-0"
                style="background:none;cursor:pointer;">
                <i class="bi bi-box-arrow-left"></i> Keluar
            </button>
        </form>
    </nav>

    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2">
            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div>
                <div style="color:#f1f5f9;font-size:13px;font-weight:600;">{{ Auth::user()->name }}</div>
                <span class="badge badge-{{ Auth::user()->role }}">{{ ucfirst(Auth::user()->role) }}</span>
            </div>
        </div>
    </div>
</aside>

{{-- TOPBAR --}}
<header class="topbar">
    <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
    <div class="user-badge">
        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        <span>{{ Auth::user()->name }}</span>
    </div>
</header>

{{-- MAIN CONTENT --}}
<main class="main-content">
    @if(session('success'))
    <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger d-flex align-items-center gap-2 mb-4">
        <i class="bi bi-x-circle-fill"></i>
        {{ session('error') }}
    </div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
