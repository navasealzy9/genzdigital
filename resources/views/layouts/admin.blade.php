<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.BASE_URL = "{{ url('/') }}";</script>

    <title>Admin Portal - GenZ Digital Campus OS</title>
    <link rel="icon" type="image/png" href="{{ asset('images/genz-logo.png') }}">

    <!-- Google Fonts: Google Sans & Khmer Sans (Kantumruy Pro, Noto Sans Khmer) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&family=Noto+Sans+Khmer:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/google-sans" rel="stylesheet">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Canvas Confetti for Game Random celebration -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>

    <style>
        :root {
            --app-font: 'Google Sans', 'Kantumruy Pro', 'Noto Sans Khmer', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            --sidebar-width: 270px;
        }

        body {
            font-family: var(--app-font);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background-color: #f8fafc;
            color: #0f172a;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        button, input, select, textarea, .form-control, .form-select, .btn, .badge, .dropdown-menu, .modal, .toast {
            font-family: var(--app-font);
        }

        .font-monospace, code, pre, kbd, samp {
            font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace !important;
        }

        [data-bs-theme="dark"] body {
            background-color: #0b0f19;
            color: #f8fafc;
        }

        /* Top Admin Navbar */
        .admin-navbar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        [data-bs-theme="dark"] .admin-navbar {
            background: rgba(15, 23, 42, 0.9);
            border-bottom: 1px solid rgba(30, 41, 59, 0.8);
        }

        /* Responsive Sidebar */
        .admin-sidebar {
            width: var(--sidebar-width);
            flex-shrink: 0;
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            min-height: calc(100vh - 65px);
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        [data-bs-theme="dark"] .admin-sidebar {
            background: #0f172a;
            border-right-color: #1e293b;
        }

        /* Status Indicator Live Pulse */
        .status-indicator-live {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #10b981;
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: livePulse 2s infinite;
        }
        @keyframes livePulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .admin-nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 0.9rem;
            border-radius: 12px;
            color: #64748b;
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
        }

        .admin-nav-item:hover {
            color: #2563eb;
            background: rgba(37, 99, 235, 0.08);
            transform: translateX(2px);
        }

        .admin-nav-item.active {
            color: #2563eb !important;
            background: rgba(37, 99, 235, 0.12) !important;
            font-weight: 700;
        }

        [data-bs-theme="dark"] .admin-nav-item {
            color: #94a3b8;
        }

        [data-bs-theme="dark"] .admin-nav-item:hover {
            color: #60a5fa;
            background: rgba(96, 165, 250, 0.1);
            transform: translateX(2px);
        }

        [data-bs-theme="dark"] .admin-nav-item.active {
            color: #60a5fa !important;
            background: rgba(96, 165, 250, 0.18) !important;
            font-weight: 700;
        }

        .sidebar-section-title {
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
            padding: 0.75rem 0.9rem 0.25rem;
        }

        /* Admin Content Cards */
        .admin-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.85);
            border-radius: 20px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.03), 0 1px 2px -1px rgba(0, 0, 0, 0.03);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .admin-card:hover {
            box-shadow: 0 8px 24px -4px rgba(15, 23, 42, 0.06), 0 4px 8px -4px rgba(15, 23, 42, 0.03);
        }

        [data-bs-theme="dark"] .admin-card {
            background: #0f172a;
            border-color: rgba(51, 65, 85, 0.7);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
        }

        [data-bs-theme="dark"] .admin-card:hover {
            box-shadow: 0 12px 30px -5px rgba(0, 0, 0, 0.5);
            border-color: rgba(99, 102, 241, 0.3);
        }

        /* Tables Refinement */
        .table > :not(caption) > * > * {
            padding: 0.85rem 1rem;
        }
        .table thead th {
            font-size: 0.74rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            border-bottom: 1px solid #e2e8f0;
        }
        [data-bs-theme="dark"] .table thead th {
            border-bottom-color: #334155;
            color: #94a3b8;
        }

        /* Custom Scrollbars */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.4);
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(100, 116, 139, 0.7);
        }

        /* Toast Alert */
        .admin-toast {
            position: fixed;
            top: 5rem;
            right: 1.5rem;
            z-index: 1090;
            background: #0f172a;
            color: #ffffff;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 0.75rem 1.4rem;
            border-radius: 9999px;
            box-shadow: 0 12px 28px -5px rgba(0, 0, 0, 0.35);
            display: flex;
            align-items: center;
            gap: 0.6rem;
            opacity: 0;
            transform: translateY(-20px);
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        [data-bs-theme="dark"] .admin-toast {
            background: #ffffff;
            color: #0f172a;
        }

        .admin-toast.show {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        /* Screen Broadcast Spotlight effect */
        .projector-frame {
            border: 3px solid #2563eb;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 40px -10px rgba(37, 99, 235, 0.3);
            background: #000000;
        }

        /* Slide Presenter */
        .slide-canvas {
            min-height: 380px;
            border-radius: 20px;
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2.5rem;
            text-align: center;
            position: relative;
        }

        /* Random Game Wheel / Student Card Animation */
        .student-picker-box {
            border: 2px dashed #3b82f6;
            border-radius: 24px;
            padding: 2rem;
            text-align: center;
            background: rgba(59, 130, 246, 0.05);
            transition: all 0.3s ease;
        }

        .student-picker-box.highlight {
            border-color: #10b981;
            background: rgba(16, 185, 129, 0.12);
            transform: scale(1.02);
        }
    </style>
</head>
<body>
    <!-- Top Admin Navbar -->
    <nav class="admin-navbar py-2 py-md-3">
        <div class="container-fluid px-3 px-md-4 d-flex justify-content-between align-items-center">
            <!-- Brand & Admin Indicator -->
            <div class="d-flex align-items-center gap-2 gap-md-3">
                <!-- Mobile Sidebar Toggle -->
                <button class="btn btn-sm d-md-none p-2 border" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebarOffcanvas">
                    <i data-lucide="menu" style="width: 20px; height: 20px;"></i>
                </button>

                <!-- GenZ Logo -->
                <a href="{{ route('admin.index') }}" class="d-flex align-items-center gap-2 text-decoration-none text-body">
                    <img src="{{ asset('images/genz-logo.png') }}" alt="GenZ Digital Logo" class="rounded-3 shadow-xs" style="width: 36px; height: 36px; object-fit: contain;">
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="fs-5 fw-bolder">GenZ Digital</span>
                            <span class="badge bg-danger text-uppercase fw-bold" style="font-size: 9px; letter-spacing: 0.08em;">Admin Console</span>
                        </div>
                        <small class="text-secondary d-none d-sm-block" style="font-size: 11px;">Campus Management & Live Classroom Hub</small>
                    </div>
                </a>
            </div>

            <!-- System Live Status Pill -->
            <div class="d-none d-lg-flex align-items-center gap-2 px-3 py-1 bg-body-tertiary border rounded-pill shadow-xs">
                <span class="status-indicator-live"></span>
                <span class="fw-bold" style="font-size: 11.5px;">Live Classroom OS</span>
                <span class="text-secondary opacity-50">•</span>
                <span class="text-secondary" style="font-size: 11px;">v26.0 Synced</span>
            </div>

            <!-- Right Controls: Switch to Student Portal, Theme Toggle, Admin User -->
            <div class="d-flex align-items-center gap-2">
                <!-- SWITCH TO CLIENT SIDE (STUDENT VIEW) -->
                <a href="{{ route('campus.index') }}" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1.5 rounded-pill px-3 py-1.5 fw-bold shadow-sm" title="View Client Side / Student Dashboard">
                    <i data-lucide="smartphone" style="width: 16px; height: 16px;"></i>
                    <span class="d-none d-sm-inline">Switch to Student View</span>
                </a>

                <!-- Dark Mode Toggle Button -->
                <button class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center p-2" id="admin-theme-toggle" title="Toggle Theme" style="width: 38px; height: 38px; background: rgba(148, 163, 184, 0.15);">
                    <i id="admin-theme-icon" data-lucide="moon" style="width: 18px; height: 18px;"></i>
                </button>

                <!-- Admin Profile Avatar & Logout -->
                <div class="d-flex align-items-center gap-2 ps-2 border-start">
                    @auth
                        <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 36px; height: 36px;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="d-none d-lg-block text-start lh-sm">
                            <span class="fw-bold fs-7 d-block">{{ Auth::user()->name }}</span>
                            <small class="badge bg-danger" style="font-size: 9px;">ADMINISTRATOR</small>
                        </div>
                        <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-danger rounded-circle p-1 d-flex align-items-center justify-content-center ms-1" title="Log Out" style="width: 32px; height: 32px;">
                            <i data-lucide="log-out" style="width: 14px; height: 14px;"></i>
                        </a>
                    @else
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px;">
                            AD
                        </div>
                        <div class="d-none d-lg-block text-start lh-sm">
                            <span class="fw-bold fs-7 d-block">Admin Instructor</span>
                            <small class="text-secondary" style="font-size: 10px;">Superuser</small>
                        </div>
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary rounded-pill px-2.5 py-1 fw-bold ms-1" style="font-size: 11px;">
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Global Floating Admin Toast -->
    <div id="admin-toast" class="admin-toast">
        <i data-lucide="check-circle" style="width: 18px; height: 18px; color: #10b981;"></i>
        <span id="admin-toast-message">Action completed successfully</span>
    </div>

    <!-- Main Container: Sidebar + Content -->
    <div class="d-flex">
        <!-- Desktop Sidebar (>= 768px) -->
        <aside class="admin-sidebar d-none d-md-block p-3">
            @include('admin.partials.sidebar-nav')
        </aside>

        <!-- Mobile Offcanvas Sidebar (< 768px) -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="adminSidebarOffcanvas">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title fw-bold fs-6">Campus Admin Modules</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body p-3">
                @include('admin.partials.sidebar-nav')
            </div>
        </div>

        <!-- Main Dynamic Content Area -->
        <main class="flex-grow-1 p-3 p-md-4" style="min-width: 0;">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 d-flex align-items-center gap-2" role="alert">
                    <i data-lucide="check-circle-2" style="width: 18px; height: 18px;"></i>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Bootstrap 5.3.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function renderIcons() {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        }
        document.addEventListener('DOMContentLoaded', renderIcons);

        // Dark Mode Toggle
        const htmlElement = document.documentElement;
        const themeBtn = document.getElementById('admin-theme-toggle');
        const themeIcon = document.getElementById('admin-theme-icon');

        function setAdminTheme(theme) {
            htmlElement.setAttribute('data-bs-theme', theme);
            localStorage.setItem('genz_theme', theme);
            if (theme === 'dark') {
                themeIcon.setAttribute('data-lucide', 'sun');
                themeBtn.classList.add('text-warning');
            } else {
                themeIcon.setAttribute('data-lucide', 'moon');
                themeBtn.classList.remove('text-warning');
            }
            renderIcons();
        }

        const savedTheme = localStorage.getItem('genz_theme') || 'light';
        setAdminTheme(savedTheme);

        themeBtn.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-bs-theme');
            setAdminTheme(currentTheme === 'dark' ? 'light' : 'dark');
        });

        // Admin Toast Helper
        let adminToastTimeout = null;
        function showAdminToast(msg) {
            const toastEl = document.getElementById('admin-toast');
            const msgEl = document.getElementById('admin-toast-message');
            if (!toastEl || !msgEl) return;
            msgEl.textContent = msg;
            toastEl.classList.add('show');
            if (adminToastTimeout) clearTimeout(adminToastTimeout);
            adminToastTimeout = setTimeout(() => {
                toastEl.classList.remove('show');
            }, 3000);
            renderIcons();
        }

        // Tab Switching for 13 Admin Modules
        function switchAdminTab(tabId) {
            document.querySelectorAll('.admin-tab-pane').forEach(p => p.classList.add('d-none'));
            const target = document.getElementById('admin-tab-' + tabId);
            if (target) {
                target.classList.remove('d-none');
            }

            document.querySelectorAll('.admin-nav-item').forEach(btn => {
                if (btn.getAttribute('data-admin-tab') === tabId) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            // Close mobile offcanvas if open
            const offcanvasEl = document.getElementById('adminSidebarOffcanvas');
            if (offcanvasEl) {
                const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
                if (offcanvas) offcanvas.hide();
            }

            window.scrollTo({ top: 0, behavior: 'smooth' });
            renderIcons();
        }

        // Open by URL query param ?tab=xxx if present
        const urlParams = new URLSearchParams(window.location.search);
        const queryTab = urlParams.get('tab');
        if (queryTab) {
            switchAdminTab(queryTab);
        }
    </script>

    @stack('scripts')
</body>
</html>
