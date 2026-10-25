<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - GenZ Digital Campus OS</title>
    <link rel="icon" type="image/png" href="{{ asset('images/genz-logo.png') }}?v=26.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/genz-logo.png') }}?v=26.0">
    <link rel="apple-touch-icon" href="{{ asset('images/genz-logo.png') }}?v=26.0">

    <!-- Google Fonts: Google Sans & Khmer Sans (Kantumruy Pro, Noto Sans Khmer) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&family=Noto+Sans+Khmer:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/google-sans" rel="stylesheet">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --app-font: 'Google Sans', 'Kantumruy Pro', 'Noto Sans Khmer', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        body {
            font-family: var(--app-font);
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            position: relative;
            overflow-x: hidden;
            padding: 1.5rem 1rem;
        }
        [data-bs-theme="dark"] body {
            background: #090d16;
        }

        .ambient-glow-orb-1 {
            position: absolute;
            width: 480px;
            height: 480px;
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(217, 70, 239, 0.08) 50%, transparent 70%);
            filter: blur(65px);
            pointer-events: none;
            z-index: 0;
        }

        .ambient-glow-orb-2 {
            position: absolute;
            width: 420px;
            height: 420px;
            bottom: -80px;
            right: 15%;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.14) 0%, transparent 70%);
            filter: blur(60px);
            pointer-events: none;
            z-index: 0;
        }

        [data-bs-theme="dark"] .ambient-glow-orb-1 {
            background: radial-gradient(circle, rgba(99, 102, 241, 0.22) 0%, rgba(217, 70, 239, 0.12) 50%, transparent 70%);
        }
        [data-bs-theme="dark"] .ambient-glow-orb-2 {
            background: radial-gradient(circle, rgba(37, 99, 235, 0.22) 0%, transparent 70%);
        }

        .auth-card {
            width: 100%;
            max-width: 440px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(226, 232, 240, 0.85);
            border-radius: 28px;
            box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.08), 0 0 1px 1px rgba(15, 23, 42, 0.03);
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
        }
        [data-bs-theme="dark"] .auth-card {
            background: rgba(15, 23, 42, 0.92);
            border-color: rgba(30, 41, 59, 0.9);
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.5);
        }
        .gz-title-gradient {
            background: linear-gradient(135deg, #2563eb, #6366f1, #d946ef);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 900;
        }

        .auth-brand-badge {
            width: 62px;
            height: 62px;
            border-radius: 20px;
            background: #ffffff;
            padding: 6px;
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 0 8px 20px -5px rgba(37, 99, 235, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.25s ease;
        }
        .auth-brand-badge:hover {
            transform: scale(1.04);
        }
        [data-bs-theme="dark"] .auth-brand-badge {
            background: #1e293b;
            border-color: #334155;
            box-shadow: 0 8px 20px -5px rgba(0, 0, 0, 0.4);
        }
        .auth-brand-logo {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 14px;
        }

        .clean-input-group {
            background: rgba(248, 250, 252, 0.8);
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            overflow: hidden;
        }
        [data-bs-theme="dark"] .clean-input-group {
            background: rgba(30, 41, 59, 0.5);
            border-color: #334155;
        }
        .clean-input-group:focus-within {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            background: #ffffff;
        }
        [data-bs-theme="dark"] .clean-input-group:focus-within {
            background: rgba(30, 41, 59, 0.9);
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.18);
        }
        .clean-input-group .form-control {
            border: none;
            background: transparent;
            font-size: 13.5px;
            box-shadow: none !important;
        }
        .clean-input-group .input-group-text {
            border: none;
            background: transparent;
        }

        .quick-chip {
            background: rgba(248, 250, 252, 0.9);
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            cursor: pointer;
            text-align: left;
        }
        .quick-chip:hover {
            transform: translateY(-1.5px);
            border-color: #3b82f6;
            background: rgba(59, 130, 246, 0.05);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
        }
        [data-bs-theme="dark"] .quick-chip {
            background: rgba(30, 41, 59, 0.5);
            border-color: #334155;
        }
        [data-bs-theme="dark"] .quick-chip:hover {
            background: rgba(30, 41, 59, 0.9);
            border-color: #60a5fa;
        }
        .quick-chip-avatar {
            width: 28px;
            height: 28px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
            flex-shrink: 0;
        }
    </style>
</head>
<body>
    <!-- Ambient Glowing Orbs -->
    <div class="ambient-glow-orb-1"></div>
    <div class="ambient-glow-orb-2"></div>

    <div class="auth-card p-4 p-md-4">
        <!-- Top Action Bar -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-1 fw-bold" style="font-size: 10px; letter-spacing: 0.05em;">
                CAMPUS OS v26.0
            </span>
            <div class="d-flex align-items-center gap-1.5">
                <button type="button" class="btn btn-sm rounded-circle p-1.5 border-0" id="theme-toggle-btn" title="Toggle Light/Dark Theme" style="background: rgba(148, 163, 184, 0.15); color: inherit;">
                    <i id="theme-icon" data-lucide="moon" style="width: 15px; height: 15px;"></i>
                </button>
            </div>
        </div>

        <!-- Logo & Brand Header -->
        <div class="text-center mb-3">
            <a href="{{ url('/') }}" class="auth-brand-badge mx-auto mb-2 text-decoration-none">
                <img src="{{ asset('images/genz-logo.png') }}" alt="GenZ Digital Logo" class="auth-brand-logo">
            </a>
            <h4 class="fw-bolder mb-1 text-body tracking-tight">
                Welcome to <span class="gz-title-gradient">GenZ Digital</span>
            </h4>
            <p class="text-secondary small mb-0" style="font-size: 12.5px;">
                Campus OS • សូមចូលគណនីរបស់អ្នក
            </p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 small py-2 px-3 mb-2.5" role="alert">
                <i data-lucide="check-circle" style="width: 14px; height: 14px; vertical-align: -2px;" class="me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-3 small py-2 px-3 mb-2.5" role="alert">
                <i data-lucide="alert-circle" style="width: 14px; height: 14px; vertical-align: -2px;" class="me-1"></i>
                {{ $errors->first() }}
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login.post') }}" method="POST" class="mb-2">
            @csrf
            
            <div class="mb-2.5">
                <label class="form-label small fw-bold text-secondary mb-1" style="font-size: 12px;">Campus Email</label>
                <div class="input-group clean-input-group">
                    <span class="input-group-text pe-1 text-secondary">
                        <i data-lucide="mail" style="width: 15px; height: 15px;"></i>
                    </span>
                    <input type="email" name="email" id="input-email" class="form-control py-2 ps-2" placeholder="user@genzdigital.edu" value="{{ old('email', 'maya.chen@genzdigital.edu') }}" required autofocus>
                </div>
            </div>

            <div class="mb-2.5">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label small fw-bold text-secondary mb-0" style="font-size: 12px;">Password</label>
                    <span class="text-secondary" style="font-size: 11px;">Default: password</span>
                </div>
                <div class="input-group clean-input-group">
                    <span class="input-group-text pe-1 text-secondary">
                        <i data-lucide="lock" style="width: 15px; height: 15px;"></i>
                    </span>
                    <input type="password" name="password" id="input-password" class="form-control py-2 ps-2" placeholder="••••••••" value="password" required>
                    <button type="button" class="input-group-text text-secondary" onclick="toggleLoginPassword()" title="Show/Hide Password">
                        <i id="login-pass-icon" data-lucide="eye" style="width: 15px; height: 15px;"></i>
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" checked>
                    <label class="form-check-label small text-secondary" for="rememberMe" style="font-size: 11.5px;">Remember me</label>
                </div>
                <span class="badge bg-primary-subtle text-primary fw-semibold" style="font-size: 9.5px;">Auto-Detect</span>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2.5 rounded-3 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 mb-2">
                <i data-lucide="log-in" style="width: 17px; height: 17px;"></i>
                <span>Sign In to Campus</span>
            </button>
        </form>

        <!-- Quick 1-Click Demo Accounts -->
        <div class="pt-2 mb-2.5">
            <div class="d-flex align-items-center gap-2 mb-2">
                <hr class="flex-grow-1 my-0 opacity-25">
                <span class="text-uppercase fw-bold text-secondary" style="font-size: 10px; letter-spacing: 0.08em;">
                    ⚡ 1-Click Fast Demo
                </span>
                <hr class="flex-grow-1 my-0 opacity-25">
            </div>
            <div class="row g-2">
                <div class="col-6">
                    <button type="button" class="btn btn-sm w-100 rounded-3 p-2 text-start d-flex align-items-center gap-2 quick-chip" onclick="fillCredentials('maya.chen@genzdigital.edu', 'password')">
                        <div class="quick-chip-avatar bg-primary text-white">M</div>
                        <div class="lh-sm text-truncate">
                            <span class="fw-bold d-block text-truncate text-body" style="font-size: 11.5px;">Maya Chen</span>
                            <small class="text-secondary" style="font-size: 10px;">Student</small>
                        </div>
                    </button>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-sm w-100 rounded-3 p-2 text-start d-flex align-items-center gap-2 quick-chip" onclick="fillCredentials('admin@genzdigital.edu', 'password')">
                        <div class="quick-chip-avatar bg-danger text-white">A</div>
                        <div class="lh-sm text-truncate">
                            <span class="fw-bold d-block text-truncate text-body" style="font-size: 11.5px;">Admin</span>
                            <small class="text-secondary" style="font-size: 10px;">Instructor</small>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Links to Register and Guest View -->
        <div class="text-center pt-2 border-top">
            <p class="small text-secondary mb-1.5" style="font-size: 12px;">
                Don't have an account? 
                <a href="{{ route('register') }}" class="fw-bold text-decoration-none text-primary ms-1">
                    Register New Account
                </a>
            </p>
            <a href="{{ route('campus.index') }}" class="small text-secondary text-decoration-none d-inline-flex align-items-center gap-1" style="font-size: 11.5px;">
                <i data-lucide="arrow-left" style="width: 12px; height: 12px;"></i>
                <span>Continue as Guest</span>
            </a>
        </div>
    </div>

    <!-- Bootstrap 5 JS & Lucide -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();

            // Sync theme with localStorage
            const savedTheme = localStorage.getItem('genz_theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        });

        function toggleLoginPassword() {
            const passInput = document.getElementById('input-password');
            const passIcon = document.getElementById('login-pass-icon');
            if (!passInput || !passIcon) return;
            if (passInput.type === 'password') {
                passInput.type = 'text';
                passIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                passInput.type = 'password';
                passIcon.setAttribute('data-lucide', 'eye');
            }
            if (window.lucide) window.lucide.createIcons();
        }

        function fillCredentials(email, password) {
            document.getElementById('input-email').value = email;
            document.getElementById('input-password').value = password;
            document.querySelector('form').submit();
        }
    </script>
</body>
</html>
