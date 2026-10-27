<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Welcome to GenZ Digital - Campus OS</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=26.1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=26.1">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/genz-logo.png') }}?v=26.1">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/genz-logo.png') }}?v=26.1">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/genz-logo.png') }}?v=26.1">

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
        * {
            box-sizing: border-box;
        }
        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: var(--app-font);
            background-color: #ffffff;
            color: #0f172a;
            -webkit-font-smoothing: antialiased;
        }
        [data-bs-theme="dark"] html,
        [data-bs-theme="dark"] body {
            background-color: #0b0f19;
            color: #f1f5f9;
        }

        .login-viewport {
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.25rem;
        }

        .login-card {
            width: 100%;
            max-width: 480px;
            margin: 0 auto;
        }

        .brand-logo-box {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem auto;
            padding: 8px;
        }
        [data-bs-theme="dark"] .brand-logo-box {
            background: #1e293b;
            border-color: rgba(255, 255, 255, 0.1);
        }

        .brand-logo-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .login-title {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 0.35rem;
            color: #0f172a;
            line-height: 1.25;
            text-align: center;
        }
        [data-bs-theme="dark"] .login-title {
            color: #ffffff;
        }

        .title-genz {
            color: #2563eb;
        }
        .title-digital {
            color: #9333ea;
        }

        .login-subtitle {
            font-size: 0.95rem;
            color: #64748b;
            margin-bottom: 2rem;
            font-weight: 400;
            text-align: center;
        }
        [data-bs-theme="dark"] .login-subtitle {
            color: #94a3b8;
        }

        .field-label {
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            color: #475569;
            text-transform: uppercase;
            margin-bottom: 0.45rem;
            display: block;
        }
        [data-bs-theme="dark"] .field-label {
            color: #cbd5e1;
        }

        .field-sublabel {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
        }
        [data-bs-theme="dark"] .field-sublabel {
            color: #94a3b8;
        }

        .custom-input-group {
            position: relative;
            display: flex;
            align-items: center;
            background: #ffffff;
            border: 1.5px solid #cbd5e1;
            border-radius: 14px;
            transition: all 0.2s ease;
            margin-bottom: 1.4rem;
        }
        [data-bs-theme="dark"] .custom-input-group {
            background: #111827;
            border-color: #334155;
        }

        .custom-input-group:focus-within {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        .input-icon-left {
            display: flex;
            align-items: center;
            justify-content: center;
            padding-left: 1.15rem;
            padding-right: 0.75rem;
            color: #64748b;
            pointer-events: none;
        }

        .custom-input {
            width: 100%;
            height: 52px;
            border: none;
            outline: none;
            background: transparent;
            font-size: 1rem;
            font-weight: 500;
            color: #0f172a;
            padding: 0 1rem 0 0;
            font-family: inherit;
        }
        [data-bs-theme="dark"] .custom-input {
            color: #f1f5f9;
        }

        .custom-input::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        .toggle-password-btn {
            background: none;
            border: none;
            outline: none;
            padding: 0 1.15rem;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.15s ease;
        }
        .toggle-password-btn:hover {
            color: #0f172a;
        }
        [data-bs-theme="dark"] .toggle-password-btn:hover {
            color: #ffffff;
        }

        /* Toggle switch */
        .form-check-input {
            width: 2.75rem;
            height: 1.45rem;
            cursor: pointer;
            background-color: #cbd5e1;
            border-color: transparent;
        }
        .form-check-input:checked {
            background-color: #2563eb;
            border-color: #2563eb;
        }
        .form-check-label {
            font-size: 0.95rem;
            color: #64748b;
            cursor: pointer;
            user-select: none;
            padding-left: 0.4rem;
        }
        [data-bs-theme="dark"] .form-check-label {
            color: #cbd5e1;
        }

        .role-badge {
            background: #dbeafe;
            color: #2563eb;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 0.35rem 0.9rem;
            border-radius: 9999px;
            letter-spacing: 0.01em;
            display: inline-flex;
            align-items: center;
        }
        [data-bs-theme="dark"] .role-badge {
            background: rgba(37, 99, 235, 0.2);
            color: #60a5fa;
        }

        .btn-submit-login {
            width: 100%;
            height: 54px;
            border-radius: 14px;
            background: linear-gradient(135deg, #2563eb 0%, #4f46e5 50%, #7c3aed 100%);
            color: #ffffff;
            font-size: 1.05rem;
            font-weight: 700;
            border: none;
            outline: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.65rem;
            box-shadow: 0 10px 22px -4px rgba(79, 70, 229, 0.4);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
            margin-top: 1.6rem;
        }
        .btn-submit-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 28px -4px rgba(79, 70, 229, 0.5);
            color: #ffffff;
        }
        .btn-submit-login:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>

    <div class="login-viewport">
        <div class="login-card">
            
            <!-- Logo Box -->
            <div class="brand-logo-box">
                <img src="{{ asset('images/genz-logo.png') }}?v=26.1" alt="GenZ Digital Logo">
            </div>

            <!-- Title & Subtitle -->
            <h1 class="login-title">
                Welcome to <span class="title-genz">GenZ</span> <span class="title-digital">Digital</span>
            </h1>
            <p class="login-subtitle">
                Campus OS • សូមចូលគណនីរបស់អ្នក
            </p>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 small py-2 px-3 mb-3" role="alert">
                    <i data-lucide="check-circle" style="width: 15px; height: 15px; vertical-align: -2px;" class="me-1"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show rounded-3 small py-2 px-3 mb-3" role="alert">
                    <i data-lucide="alert-circle" style="width: 15px; height: 15px; vertical-align: -2px;" class="me-1"></i>
                    {{ $errors->first() }}
                    <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <!-- Username or Student ID -->
                <div>
                    <label class="field-label" for="input-login">STUDENT ID / USERNAME</label>
                    <div class="custom-input-group">
                        <span class="input-icon-left">
                            <i data-lucide="user-round" style="width: 18px; height: 18px;"></i>
                        </span>
                        <input type="text" name="login" id="input-login" class="custom-input" placeholder="Student ID or username" value="{{ old('login') }}" autocomplete="username" maxlength="100" required autofocus>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="field-label mb-0" for="input-password">PASSWORD</label>
                        <span class="field-sublabel">Your account password</span>
                    </div>
                    <div class="custom-input-group">
                        <span class="input-icon-left">
                            <i data-lucide="lock" style="width: 18px; height: 18px;"></i>
                        </span>
                        <input type="password" name="password" id="input-password" class="custom-input" placeholder="••••••••" autocomplete="current-password" required>
                        <button type="button" class="toggle-password-btn" onclick="toggleLoginPassword()" title="Show/Hide Password">
                            <i id="login-pass-icon" data-lucide="eye" style="width: 18px; height: 18px;"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Auto-Detect Role -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check form-switch mb-0 d-flex align-items-center">
                        <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" checked>
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <span class="role-badge">Auto-Detect Role</span>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit-login">
                    <i data-lucide="log-in" style="width: 20px; height: 20px;"></i>
                    <span>Sign In to Campus</span>
                </button>
                <p class="text-center text-secondary small mt-4 mb-0">New student? <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">Create an account</a></p>
            </form>

        </div>
    </div>

    <!-- Bootstrap 5 JS & Lucide -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();
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
    </script>
</body>
</html>
