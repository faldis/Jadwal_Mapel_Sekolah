<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Jadwal Sekolah') — Sistem Jadwal</title>
    <meta name="description" content="Sistem Manajemen Jadwal Pelajaran Sekolah">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* ======================================
           LIGHT CALM THEME — Soft Blue & White
           Optimized for readability (older users)
           ====================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: #f0f4f8;
            color: #1e293b;
            overflow-x: hidden;
            font-size: 16px;
            line-height: 1.6;
        }

        /* ===== LAYOUT ===== */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 280px;
            height: 100vh; /* Fixed height to allow inner scrolling */
            background: linear-gradient(180deg, #1e3a5f 0%, #1a3352 100%);
            padding: 0;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 50;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.08);
        }

        .sidebar-brand {
            padding: 28px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        .sidebar-brand h1 {
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.3px;
        }
        .sidebar-brand h1 i {
            color: #60a5fa;
            margin-right: 6px;
        }
        .sidebar-brand p {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.45);
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 20px 14px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            overflow-y: auto; /* Enable vertical scrolling */
            overflow-x: hidden;
        }
        
        /* Custom scrollbar for sidebar nav */
        .sidebar-nav::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }
        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .nav-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, 0.35);
            padding: 18px 16px 8px;
            font-weight: 600;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 13px 18px;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.25s ease;
            position: relative;
        }
        .nav-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
        }
        .nav-link.active {
            color: #fff;
            background: rgba(96, 165, 250, 0.25);
            border: 1px solid rgba(96, 165, 250, 0.35);
            font-weight: 600;
        }
        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 26px;
            background: #60a5fa;
            border-radius: 0 4px 4px 0;
        }
        .nav-link i {
            width: 22px;
            text-align: center;
            font-size: 1.05rem;
        }

        .sidebar-footer {
            padding: 16px 14px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.08);
        }
        .sidebar-user .avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            color: #fff;
        }
        .sidebar-user .user-info {
            flex: 1;
        }
        .sidebar-user .user-info .name {
            font-size: 0.9rem;
            font-weight: 600;
            color: #fff;
        }
        .sidebar-user .user-info .role {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.45);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 11px 16px;
            margin-top: 10px;
            border: none;
            border-radius: 10px;
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            cursor: pointer;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            transition: all 0.25s ease;
        }
        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.35);
            color: #fecaca;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 36px 40px;
            min-height: 100vh;
            min-width: 0; /* Required for nested overflow-x to work inside flex items */
            background: #f0f4f8;
        }

        .page-header {
            margin-bottom: 32px;
        }
        .page-header h2 {
            font-size: 2rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
        }
        .page-header p {
            font-size: 1rem;
            color: #64748b;
            margin-top: 6px;
        }

        /* ===== CARDS ===== */
        .glass-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 28px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 4px 12px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
        }
        .glass-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        }

        /* ===== STAT CARDS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }
        .stat-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
            cursor: default;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }
        .stat-icon.blue {
            background: #dbeafe;
            color: #2563eb;
        }
        .stat-icon.cyan {
            background: #cffafe;
            color: #0891b2;
        }
        .stat-icon.purple {
            background: #ede9fe;
            color: #7c3aed;
        }
        .stat-icon.amber {
            background: #fef3c7;
            color: #d97706;
        }
        .stat-icon.red {
            background: #fee2e2;
            color: #dc2626;
        }
        .stat-icon.green {
            background: #dcfce7;
            color: #16a34a;
        }
        .stat-info h3 {
            font-size: 2rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1;
        }
        .stat-info p {
            font-size: 0.9rem;
            color: #64748b;
            margin-top: 4px;
            font-weight: 500;
        }

        /* ===== TABLE ===== */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 12px;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        table thead th {
            background: #f1f5f9;
            color: #475569;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 14px 18px;
            text-align: left;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }
        table thead th:first-child {
            border-radius: 12px 0 0 0;
        }
        table thead th:last-child {
            border-radius: 0 12px 0 0;
        }
        table tbody td {
            padding: 16px 18px;
            font-size: 0.95rem;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        table tbody tr {
            transition: background 0.2s ease;
        }
        table tbody tr:hover {
            background: #f8fafc;
        }
        table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 22px;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.25s ease;
            border: none;
            text-decoration: none;
            white-space: nowrap;
        }
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.35);
        }
        .btn-sm {
            padding: 8px 16px;
            font-size: 0.85rem;
            border-radius: 8px;
        }
        .btn-warning {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        .btn-warning:hover {
            background: #fde68a;
        }
        .btn-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .btn-danger:hover {
            background: #fecaca;
        }
        .btn-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .btn-success:hover {
            background: #bbf7d0;
        }
        .btn-glass {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }
        .btn-glass:hover {
            background: #e2e8f0;
        }

        /* ===== FORMS ===== */
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            background: #fff;
            color: #1e293b;
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.25s ease;
            outline: none;
        }
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12);
        }
        .form-control::placeholder {
            color: #94a3b8;
        }
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 20px;
            padding-right: 40px;
        }
        select.form-control option {
            background: #fff;
            color: #1e293b;
        }

        /* ===== ALERTS ===== */
        .alert {
            padding: 16px 22px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 0.95rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.4s ease;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .alert-success {
            background: #dcfce7;
            border: 1px solid #86efac;
            color: #166534;
        }
        .alert-error {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: #991b1b;
        }
        .alert-warning {
            background: #fef3c7;
            border: 1px solid #fde68a;
            color: #92400e;
        }

        /* ===== MODAL ===== */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            z-index: 100;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.2s ease;
        }
        .modal-overlay.active {
            display: flex;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .modal-content {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 36px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            animation: scaleIn 0.3s ease;
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }
        .modal-header h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
        }
        .modal-close {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            color: #64748b;
            cursor: pointer;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .modal-close:hover {
            background: #fee2e2;
            border-color: #fca5a5;
            color: #dc2626;
        }
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 28px;
        }

        /* ===== BADGE ===== */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .badge-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .badge-warning {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* ===== FLEX/GRID HELPERS ===== */
        .flex { display: flex; }
        .flex-between { display: flex; justify-content: space-between; align-items: center; }
        .flex-center { display: flex; align-items: center; justify-content: center; }
        .gap-2 { gap: 8px; }
        .gap-3 { gap: 12px; }
        .gap-4 { gap: 16px; }
        .mt-4 { margin-top: 16px; }
        .mb-4 { margin-bottom: 16px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-muted { color: #94a3b8; }

        /* ===== MOBILE TOGGLE ===== */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 16px;
            left: 16px;
            z-index: 60;
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #fff;
            border: 1px solid #e2e8f0;
            color: #334155;
            font-size: 1.2rem;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 48px 24px;
        }
        .empty-state i {
            font-size: 3.5rem;
            color: #cbd5e1;
            margin-bottom: 16px;
        }
        .empty-state p {
            color: #64748b;
            font-size: 1rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
                padding: 20px 16px;
                padding-top: 72px;
            }
            .mobile-toggle {
                display: flex;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Mobile Toggle -->
    <button class="mobile-toggle" onclick="document.querySelector('.sidebar').classList.toggle('open')" id="mobile-toggle-btn">
        <i class="fas fa-bars"></i>
    </button>

    <div class="app-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <h1><i class="fas fa-calendar-alt"></i> Jadwal Sekolah</h1>
                <p>Management System</p>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-label">Menu Utama</div>
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" id="nav-dashboard">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>

                <div class="nav-label">Data Master</div>
                <a href="{{ route('guru.index') }}" class="nav-link {{ request()->routeIs('guru.*') ? 'active' : '' }}" id="nav-guru">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Data Guru</span>
                </a>
                <a href="{{ route('mapel.index') }}" class="nav-link {{ request()->routeIs('mapel.*') ? 'active' : '' }}" id="nav-mapel">
                    <i class="fas fa-book"></i>
                    <span>Mata Pelajaran</span>
                </a>
                <a href="{{ route('kelas.index') }}" class="nav-link {{ request()->routeIs('kelas.*') ? 'active' : '' }}" id="nav-kelas">
                    <i class="fas fa-school"></i>
                    <span>Data Kelas</span>
                </a>

                <div class="nav-label">Jadwal</div>
                <a href="{{ route('jadwal.index') }}" class="nav-link {{ request()->routeIs('jadwal.*') ? 'active' : '' }}" id="nav-jadwal">
                    <i class="fas fa-calendar-week"></i>
                    <span>Kelola Jadwal</span>
                </a>
                <a href="{{ route('export.index') }}" class="nav-link {{ request()->routeIs('export.*') ? 'active' : '' }}" id="nav-export">
                    <i class="fas fa-file-export"></i>
                    <span>Export / Cetak</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-user">
                    <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    <div class="user-info">
                        <div class="name">{{ Auth::user()->name }}</div>
                        <div class="role">Administrator</div>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn" id="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success" id="alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error" id="alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error" id="alert-validation">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        // Auto-dismiss alerts
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                alert.style.transition = 'all 0.3s ease';
                setTimeout(() => alert.remove(), 300);
            }, 5000);
        });

        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('mobile-toggle-btn');
            if (window.innerWidth <= 768 && sidebar.classList.contains('open')) {
                if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                    sidebar.classList.remove('open');
                }
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
