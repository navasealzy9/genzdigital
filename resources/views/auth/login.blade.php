<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Login - GenZ Digital Campus OS v26.0</title>
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
            --brand-primary: #2563eb;
            --brand-gradient: linear-gradient(135deg, #2563eb 0%, #4f46e5 50%, #7c3aed 100%);
        }
        * {
            box-sizing: border-box;
        }
        html, body {
            overflow-x: hidden;
            width: 100%;
            -webkit-overflow-scrolling: touch;
        }
        body {
            font-family: var(--app-font);
            margin: 0;
            padding: 0;
            background: #ffffff;
            color: #0f172a;
            min-height: 100vh;
            min-height: 100dvh;
        }
        [data-bs-theme="dark"] body {
            background: #090d16;
            color: #f1f5f9;
        }

        .auth-split-wrapper {
            display: flex;
            min-height: 100vh;
            min-height: 100dvh;
            width: 100%;
        }

        /* ---------------- Left Showcase Panel (Desktop >= 992px) ---------------- */
        .auth-showcase-panel {
            flex: 1 1 50%;
            background: linear-gradient(145deg, #090d16 0%, #0f172a 45%, #1e1b4b 100%);
            position: relative;
            overflow: hidden;
            color: #ffffff;
            padding: clamp(2rem, 4vh, 3.5rem) clamp(2rem, 3.5vw, 3.5rem);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .auth-showcase-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
            background-size: 24px 24px;
            pointer-events: none;
            opacity: 0.6;
        }
        .showcase-glow-orb-1 {
            position: absolute;
            width: 500px;
            height: 500px;
            top: -120px;
            left: -80px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.28) 0%, rgba(139, 92, 246, 0.12) 50%, transparent 70%);
            filter: blur(70px);
            pointer-events: none;
        }
        .showcase-glow-orb-2 {
            position: absolute;
            width: 440px;
            height: 440px;
            bottom: -60px;
            right: -60px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.25) 0%, rgba(6, 182, 212, 0.1) 60%, transparent 70%);
            filter: blur(65px);
            pointer-events: none;
        }

        .showcase-brand-logo-box {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.95);
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
        }
        .showcase-brand-logo-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .showcase-feature-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 16px;
            padding: 1.1rem 1.25rem;
            transition: all 0.25s ease;
        }
        .showcase-feature-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        .feature-icon-badge {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* ---------------- Right Form Panel ---------------- */
        .auth-form-panel {
            flex: 1 1 50%;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: clamp(1.5rem, 3.5vh, 2.75rem) clamp(1.25rem, 3.5vw, 3rem);
            position: relative;
            overflow-y: auto;
        }
        [data-bs-theme="dark"] .auth-form-panel {
            background: #090d16;
        }

        .auth-form-container {
            width: 100%;
            max-width: 420px;
            margin: auto;
            padding: 0.75rem 0;
        }

        .gz-title-gradient {
            background: linear-gradient(135deg, #2563eb, #6366f1, #d946ef);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }

        .clean-field-group {
            margin-bottom: 1.15rem;
        }
        .clean-field-label {
            display: block;
            font-size: 11.5px;
            font-weight: 700;
            color: #475569;
            margin-bottom: 0.35rem;
            letter-spacing: 0.02em;
        }
        [data-bs-theme="dark"] .clean-field-label {
            color: #94a3b8;
        }

        .clean-input-box {
            display: flex;
            align-items: center;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 0 0.85rem;
            height: 46px;
            transition: all 0.2s ease;
        }
        [data-bs-theme="dark"] .clean-input-box {
            background: #101726;
            border-color: #1e293b;
        }
        .clean-input-box:focus-within {
            background: #ffffff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3.5px rgba(59, 130, 246, 0.12);
        }
        [data-bs-theme="dark"] .clean-input-box:focus-within {
            background: #131b2e;
            border-color: #60a5fa;
            box-shadow: 0 0 0 3.5px rgba(96, 165, 250, 0.16);
        }
        .clean-input-box input, .clean-input-box select {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
            font-size: 14px;
            color: inherit;
            padding-left: 0.5rem;
        }
        .clean-input-box input::placeholder {
            color: #94a3b8;
            font-size: 13px;
        }
        .clean-input-icon {
            color: #64748b;
            flex-shrink: 0;
            display: flex;
            align-items: center;
        }
        [data-bs-theme="dark"] .clean-input-icon {
            color: #94a3b8;
        }

        .btn-submit-campus {
            background: var(--brand-gradient);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            height: 46px;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.35);
            transition: all 0.25s ease;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            touch-action: manipulation;
        }
        .btn-submit-campus:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 24px -5px rgba(37, 99, 235, 0.45);
            color: #ffffff;
        }
        .btn-submit-campus:active {
            transform: translateY(0);
        }

        /* 1-Click Fast Demo Cards */
        .demo-chip-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.65rem 0.85rem;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            width: 100%;
            touch-action: manipulation;
        }
        .demo-chip-card:hover {
            background: #ffffff;
            border-color: #3b82f6;
            transform: translateY(-1.5px);
            box-shadow: 0 8px 16px -4px rgba(37, 99, 235, 0.12);
        }
        [data-bs-theme="dark"] .demo-chip-card {
            background: #101726;
            border-color: #1e293b;
        }
        [data-bs-theme="dark"] .demo-chip-card:hover {
            background: #162035;
            border-color: #60a5fa;
        }
        .demo-chip-avatar {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 12px;
            color: #ffffff;
            flex-shrink: 0;
        }

        /* ---------------- Tablet Responsive Adjustments (576px - 991.98px) ---------------- */
        .tablet-brand-banner {
            display: none;
        }
        @media (min-width: 576px) and (max-width: 991.98px) {
            .auth-showcase-panel {
                display: none;
            }
            .auth-form-panel {
                flex: 1 1 100%;
                padding: 2.5rem 2rem;
                justify-content: center;
                align-items: center;
            }
            .tablet-brand-banner {
                display: block;
                max-width: 480px;
                width: 100%;
                margin: 0 auto 1.5rem auto;
                background: linear-gradient(135deg, rgba(37, 99, 235, 0.08) 0%, rgba(79, 70, 229, 0.05) 100%);
                border: 1px solid rgba(37, 99, 235, 0.15);
                border-radius: 16px;
                padding: 1rem 1.25rem;
                text-align: center;
            }
            [data-bs-theme="dark"] .tablet-brand-banner {
                background: linear-gradient(135deg, rgba(37, 99, 235, 0.15) 0%, rgba(30, 41, 59, 0.5) 100%);
                border-color: rgba(96, 165, 250, 0.2);
            }
            .auth-form-container {
                max-width: 460px;
            }
        }

        /* ---------------- Mobile Responsive Adjustments (< 576px) ---------------- */
        @media (max-width: 575.98px) {
            .auth-showcase-panel {
                display: none;
            }
            .auth-form-panel {
                flex: 1 1 100%;
                padding: 1.5rem 1.15rem;
                padding-bottom: max(1.5rem, env(safe-area-inset-bottom));
                justify-content: space-between;
            }
            .auth-form-container {
                max-width: 100%;
                padding: 0.5rem 0;
            }
            /* Prevent iOS Safari input auto-zoom */
            .clean-input-box input, .clean-input-box select {
                font-size: 16px !important;
            }
            .clean-input-box {
                height: 48px;
            }
            .btn-submit-campus {
                height: 48px;
                font-size: 15px;
            }
            .demo-chip-card {
                padding: 0.6rem 0.65rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-split-wrapper">

        <!-- 1. LEFT SHOWCASE PANEL (Visible on Desktop >= 992px) -->
        <div class="auth-showcase-panel">
            <div class="showcase-glow-orb-1"></div>
            <div class="showcase-glow-orb-2"></div>

            <!-- Top Brand Badge -->
            <div class="position-relative z-1 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="showcase-brand-logo-box">
                        <img src="{{ asset('images/genz-logo.png') }}?v=26.1" alt="GenZ Digital Logo" class="showcase-brand-logo-img">
                    </div>
                    <div>
                        <div class="fw-bold fs-5 text-white lh-1">GenZ Digital</div>
                        <small class="text-white-50" style="font-size: 11px;">Intelligent Campus OS</small>
                    </div>
                </div>
                <span class="badge bg-primary bg-opacity-25 text-info border border-info border-opacity-25 rounded-pill px-3 py-1.5 fw-bold" style="font-size: 11px; letter-spacing: 0.05em;">
                    Campus OS v26.0
                </span>
            </div>

            <!-- Center Showcase Hero -->
            <div class="position-relative z-1 my-auto py-3" style="max-width: 520px;">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill mb-3" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15);">
                    <span class="badge rounded-circle p-1 bg-success"></span>
                    <span class="small fw-semibold text-white-50" style="font-size: 11.5px;">Live Academic Cloud • 2026 Edition</span>
                </div>

                <h1 class="display-6 fw-bold text-white mb-2" style="letter-spacing: -0.02em; line-height: 1.25;">
                    The Intelligent Operating System for Tomorrow's Campus.
                </h1>
                <p class="text-white-50 mb-3.5" style="font-size: 14px; line-height: 1.6;">
                    វេទិកាគ្រប់គ្រងសាកលវិទ្យាល័យឌីជីថលឆ្លាតវៃ — វត្តមានតាម QR Passcode, ប្រឡង QCM ស្វ័យប្រវត្តិ, និងវិញ្ញាបនបត្រឌីជីថលភ្លាមៗ។
                </p>

                <!-- 3 Glassmorphic Feature Cards -->
                <div class="d-flex flex-column gap-2.5">
                    <div class="showcase-feature-card d-flex align-items-center gap-3">
                        <div class="feature-icon-badge" style="background: rgba(59, 130, 246, 0.2); color: #60a5fa;">
                            <i data-lucide="qr-code" style="width: 20px; height: 20px;"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white fs-6">Smart QR Attendance Pass</div>
                            <div class="text-white-50 small" style="font-size: 12px;">Dynamic passcodes & 2-session (ព្រឹក / រសៀល) tracking with GPS integrity.</div>
                        </div>
                    </div>

                    <div class="showcase-feature-card d-flex align-items-center gap-3">
                        <div class="feature-icon-badge" style="background: rgba(168, 85, 247, 0.2); color: #c084fc;">
                            <i data-lucide="book-open" style="width: 20px; height: 20px;"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white fs-6">Interactive Academic Classroom</div>
                            <div class="text-white-50 small" style="font-size: 12px;">Live presentation slides, instant QCM test auto-scoring, and digital library.</div>
                        </div>
                    </div>

                    <div class="showcase-feature-card d-flex align-items-center gap-3">
                        <div class="feature-icon-badge" style="background: rgba(245, 158, 11, 0.2); color: #fbbf24;">
                            <i data-lucide="award" style="width: 20px; height: 20px;"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white fs-6">Verifiable Digital Certificates</div>
                            <div class="text-white-50 small" style="font-size: 12px;">Automated batch credentials, gamified XP points, and real-time leaderboard.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Showcase Proof -->
            <div class="position-relative z-1 d-flex align-items-center justify-content-between pt-3 border-top border-white border-opacity-10">
                <div class="d-flex align-items-center gap-2">
                    <div class="d-flex">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=60" class="rounded-circle border border-dark" style="width: 26px; height: 26px; object-fit: cover;">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=60" class="rounded-circle border border-dark" style="width: 26px; height: 26px; object-fit: cover; margin-left: -8px;">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=60" class="rounded-circle border border-dark" style="width: 26px; height: 26px; object-fit: cover; margin-left: -8px;">
                    </div>
                    <span class="small text-white-50 fw-semibold" style="font-size: 12px;">500+ Active Students & Instructors</span>
                </div>
                <div class="d-flex align-items-center gap-1.5 text-success small fw-semibold" style="font-size: 11.5px;">
                    <span class="badge rounded-circle p-1 bg-success"></span>
                    <span>System 100% Operational</span>
                </div>
            </div>
        </div>

        <!-- 2. RIGHT FORM PANEL -->
        <div class="auth-form-panel">
            
            <!-- Top Controls Bar -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <a href="{{ route('campus.index') }}" class="d-inline-flex align-items-center gap-1 text-decoration-none text-secondary small fw-semibold" style="font-size: 12px;">
                    <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i>
                    <span>Campus Home</span>
                </a>

                <div class="d-flex align-items-center gap-2">
                    <!-- Light / Dark Theme Toggle -->
                    <button type="button" class="btn btn-sm rounded-circle p-1.5 border-0" id="theme-toggle-btn" title="Toggle Light/Dark Theme" style="background: rgba(148, 163, 184, 0.15); color: inherit;">
                        <i id="theme-icon" data-lucide="moon" style="width: 16px; height: 16px;"></i>
                    </button>
                    <!-- Register Link Pill -->
                    <a href="{{ route('register') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold" style="font-size: 11.5px;">
                        Register New Account
                    </a>
                </div>
            </div>

            <!-- Tablet Brand Banner (Visible only on 576px - 991px) -->
            <div class="tablet-brand-banner">
                <div class="d-flex align-items-center justify-content-center gap-2 mb-1.5">
                    <img src="{{ asset('images/genz-logo.png') }}?v=26.1" alt="GenZ Digital Logo" style="width: 28px; height: 28px; object-fit: contain;">
                    <span class="fw-bold fs-6">GenZ Digital Campus OS</span>
                    <span class="badge bg-primary-subtle text-primary rounded-pill" style="font-size: 10px;">v26.0</span>
                </div>
                <div class="d-flex justify-content-center gap-3 text-secondary" style="font-size: 11px;">
                    <span>⚡ QR Pass Attendance</span>
                    <span>•</span>
                    <span>📚 Classroom & Exams</span>
                    <span>•</span>
                    <span>🏆 Digital Certificates</span>
                </div>
            </div>

            <!-- Center Form Container -->
            <div class="auth-form-container">
                
                <!-- Brand Presence -->
                <div class="text-center mb-3 mb-md-4">
                    <a href="{{ url('/') }}" class="d-inline-block mb-2 text-decoration-none">
                        <div class="showcase-brand-logo-box mx-auto" style="width: 52px; height: 52px; border: 1.5px solid rgba(226, 232, 240, 0.9);">
                            <img src="{{ asset('images/genz-logo.png') }}?v=26.1" alt="GenZ Digital Logo" class="showcase-brand-logo-img">
                        </div>
                    </a>
                    <h3 class="fw-bolder mb-1 text-body tracking-tight fs-4 fs-md-3">
                        Welcome to <span class="gz-title-gradient">GenZ Digital</span>
                    </h3>
                    <p class="text-secondary small mb-0" style="font-size: 12.5px;">
                        Campus OS • សូមចូលគណនីរបស់អ្នក
                    </p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3 small py-2 px-3 mb-3" role="alert">
                        <i data-lucide="check-circle" style="width: 14px; height: 14px; vertical-align: -2px;" class="me-1"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 small py-2 px-3 mb-3" role="alert">
                        <i data-lucide="alert-circle" style="width: 14px; height: 14px; vertical-align: -2px;" class="me-1"></i>
                        {{ $errors->first() }}
                        <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    
                    <!-- Campus Email -->
                    <div class="clean-field-group">
                        <label class="clean-field-label" for="input-email">CAMPUS EMAIL</label>
                        <div class="clean-input-box">
                            <span class="clean-input-icon">
                                <i data-lucide="mail" style="width: 16px; height: 16px;"></i>
                            </span>
                            <input type="email" name="email" id="input-email" placeholder="user@genzdigital.edu" value="{{ old('email', 'maya.chen@genzdigital.edu') }}" required autofocus>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="clean-field-group">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="clean-field-label mb-0" for="input-password">PASSWORD</label>
                            <span class="text-secondary" style="font-size: 11px;">Default: password</span>
                        </div>
                        <div class="clean-input-box">
                            <span class="clean-input-icon">
                                <i data-lucide="lock" style="width: 16px; height: 16px;"></i>
                            </span>
                            <input type="password" name="password" id="input-password" placeholder="••••••••" value="password" required>
                            <button type="button" class="btn btn-link p-0 text-secondary clean-input-icon" onclick="toggleLoginPassword()" title="Show/Hide Password">
                                <i id="login-pass-icon" data-lucide="eye" style="width: 16px; height: 16px;"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember me & Status -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" checked>
                            <label class="form-check-label small text-secondary" for="rememberMe" style="font-size: 12px;">Remember me</label>
                        </div>
                        <span class="badge bg-primary-subtle text-primary fw-semibold" style="font-size: 10px;">Auto-Detect Role</span>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-submit-campus mb-3">
                        <i data-lucide="log-in" style="width: 18px; height: 18px;"></i>
                        <span>Sign In to Campus</span>
                    </button>
                </form>

                <!-- 1-Click Fast Demo Accounts -->
                <div class="mb-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <hr class="flex-grow-1 my-0 opacity-25">
                        <span class="text-uppercase fw-bold text-secondary" style="font-size: 10px; letter-spacing: 0.08em;">
                            ⚡ 1-Click Fast Demo
                        </span>
                        <hr class="flex-grow-1 my-0 opacity-25">
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="demo-chip-card" onclick="fillCredentials('maya.chen@genzdigital.edu', 'password')" title="Click to sign in as Student">
                                <div class="demo-chip-avatar bg-primary">M</div>
                                <div class="lh-sm text-truncate">
                                    <span class="fw-bold d-block text-truncate text-body" style="font-size: 11.5px;">Maya Chen</span>
                                    <small class="text-secondary" style="font-size: 10px;">Student Pass</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="demo-chip-card" onclick="fillCredentials('admin@genzdigital.edu', 'password')" title="Click to sign in as Admin">
                                <div class="demo-chip-avatar bg-danger">A</div>
                                <div class="lh-sm text-truncate">
                                    <span class="fw-bold d-block text-truncate text-body" style="font-size: 11.5px;">Faculty Lead</span>
                                    <small class="text-secondary" style="font-size: 10px;">Admin Portal</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Navigation -->
                <div class="text-center pt-2 border-top">
                    <div class="d-flex justify-content-center align-items-center gap-3">
                        <a href="{{ route('admin.index') }}" class="small text-secondary text-decoration-none" style="font-size: 11.5px;">
                            <i data-lucide="shield" style="width: 13px; height: 13px; vertical-align: -1.5px;"></i> Admin Portal
                        </a>
                        <span class="text-secondary opacity-25">•</span>
                        <a href="{{ route('register') }}" class="small text-primary text-decoration-none fw-semibold" style="font-size: 11.5px;">
                            Register New Account
                        </a>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright -->
            <div class="text-center text-secondary small py-2" style="font-size: 11px;">
                © 2026 GenZ Digital Campus OS • All rights reserved
            </div>

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
            updateThemeIcon(savedTheme);

            const themeBtn = document.getElementById('theme-toggle-btn');
            if (themeBtn) {
                themeBtn.addEventListener('click', () => {
                    const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
                    const nextTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    document.documentElement.setAttribute('data-bs-theme', nextTheme);
                    localStorage.setItem('genz_theme', nextTheme);
                    updateThemeIcon(nextTheme);
                });
            }
        });

        function updateThemeIcon(theme) {
            const icon = document.getElementById('theme-icon');
            if (!icon) return;
            icon.setAttribute('data-lucide', theme === 'dark' ? 'sun' : 'moon');
            if (window.lucide) window.lucide.createIcons();
        }

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
