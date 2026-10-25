<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - GenZ Digital Campus OS v26.0</title>
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
        body {
            font-family: var(--app-font);
            margin: 0;
            padding: 0;
            background: #ffffff;
            color: #0f172a;
            min-height: 100vh;
            min-height: 100dvh;
            overflow-x: hidden;
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
            flex: 1 1 48%;
            background: linear-gradient(145deg, #090d16 0%, #0f172a 45%, #1e1b4b 100%);
            position: relative;
            overflow: hidden;
            color: #ffffff;
            padding: 3.5rem 3.5rem;
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
            padding: 1.15rem 1.25rem;
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
            flex: 1 1 52%;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2.5rem 3rem;
            position: relative;
            overflow-y: auto;
        }
        [data-bs-theme="dark"] .auth-form-panel {
            background: #090d16;
        }

        .auth-form-container {
            width: 100%;
            max-width: 480px;
            margin: auto;
            padding: 1rem 0;
        }

        .gz-title-gradient {
            background: linear-gradient(135deg, #2563eb, #6366f1, #d946ef);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }

        /* Segmented Role Selector */
        .role-selector-pill {
            display: flex;
            background: #f1f5f9;
            border-radius: 14px;
            padding: 4px;
            gap: 4px;
            border: 1px solid #e2e8f0;
        }
        [data-bs-theme="dark"] .role-selector-pill {
            background: #101726;
            border-color: #1e293b;
        }
        .role-pill-btn {
            flex: 1;
            padding: 0.55rem 0.75rem;
            border-radius: 10px;
            border: none;
            background: transparent;
            font-size: 13px;
            font-weight: 700;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .role-pill-btn.active {
            background: #ffffff;
            color: #2563eb;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
        }
        [data-bs-theme="dark"] .role-pill-btn.active {
            background: #1e293b;
            color: #60a5fa;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        }

        .clean-field-group {
            margin-bottom: 1rem;
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
            height: 44px;
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
            font-size: 13.5px;
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
        }
        .btn-submit-campus:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 24px -5px rgba(37, 99, 235, 0.45);
            color: #ffffff;
        }
        .btn-submit-campus:active {
            transform: translateY(0);
        }

        /* Mobile Adjustments (< 992px) */
        @media (max-width: 991.98px) {
            .auth-showcase-panel {
                display: none;
            }
            .auth-form-panel {
                flex: 1 1 100%;
                padding: 2rem 1.25rem;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="auth-split-wrapper">

        <!-- 1. LEFT SHOWCASE PANEL (Desktop >= 992px) -->
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
            <div class="position-relative z-1 my-auto py-4" style="max-width: 520px;">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill mb-3" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15);">
                    <span class="badge rounded-circle p-1 bg-success"></span>
                    <span class="small fw-semibold text-white-50" style="font-size: 11.5px;">Student & Faculty Onboarding • 2026</span>
                </div>

                <h1 class="display-6 fw-bold text-white mb-2" style="letter-spacing: -0.02em; line-height: 1.25;">
                    Empowering the Next Generation of Thinkers & Builders.
                </h1>
                <p class="text-white-50 mb-4" style="font-size: 14.5px; line-height: 1.6;">
                    ចូលរួមជាមួយសហគមន៍ GenZ Digital Campus OS ដើម្បីទទួលបានសិទ្ធិចូលរៀន, វត្តមានឌីជីថល, បណ្ណាល័យសៀវភៅ, និងវិញ្ញាបនបត្រទទួលស្គាល់ជាផ្លូវការ។
                </p>

                <!-- 3 Highlights -->
                <div class="d-flex flex-column gap-2.5">
                    <div class="showcase-feature-card d-flex align-items-center gap-3">
                        <div class="feature-icon-badge" style="background: rgba(59, 130, 246, 0.2); color: #60a5fa;">
                            <i data-lucide="shield-check" style="width: 20px; height: 20px;"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white fs-6">Instant Student Passcode ID</div>
                            <div class="text-white-50 small" style="font-size: 12px;">Get unique student ID, QR scanner pass, and automated course enrollment.</div>
                        </div>
                    </div>

                    <div class="showcase-feature-card d-flex align-items-center gap-3">
                        <div class="feature-icon-badge" style="background: rgba(168, 85, 247, 0.2); color: #c084fc;">
                            <i data-lucide="sparkles" style="width: 20px; height: 20px;"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white fs-6">Interactive Learning Classroom</div>
                            <div class="text-white-50 small" style="font-size: 12px;">Engage with live QCM quizzes, challenge leaderboards, and peer collaboration.</div>
                        </div>
                    </div>

                    <div class="showcase-feature-card d-flex align-items-center gap-3">
                        <div class="feature-icon-badge" style="background: rgba(16, 185, 129, 0.2); color: #34d399;">
                            <i data-lucide="check-circle" style="width: 20px; height: 20px;"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white fs-6">Guaranteed Digital Credentials</div>
                            <div class="text-white-50 small" style="font-size: 12px;">Earn tamper-proof PDF graduation certificates recognized across campus.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Showcase Proof -->
            <div class="position-relative z-1 d-flex align-items-center justify-content-between pt-3 border-top border-white border-opacity-10">
                <span class="small text-white-50 fw-semibold" style="font-size: 12px;">Official GenZ Digital Academic Cloud</span>
                <div class="d-flex align-items-center gap-1.5 text-success small fw-semibold" style="font-size: 11.5px;">
                    <span class="badge rounded-circle p-1 bg-success"></span>
                    <span>Self-Service Enrollment Open</span>
                </div>
            </div>
        </div>

        <!-- 2. RIGHT FORM PANEL -->
        <div class="auth-form-panel">
            
            <!-- Top Controls Bar -->
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('campus.index') }}" class="d-inline-flex align-items-center gap-1 text-decoration-none text-secondary small fw-semibold" style="font-size: 12px;">
                    <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i>
                    <span>Campus Home</span>
                </a>

                <div class="d-flex align-items-center gap-2">
                    <!-- Light / Dark Theme Toggle -->
                    <button type="button" class="btn btn-sm rounded-circle p-1.5 border-0" id="theme-toggle-btn" title="Toggle Light/Dark Theme" style="background: rgba(148, 163, 184, 0.15); color: inherit;">
                        <i id="theme-icon" data-lucide="moon" style="width: 16px; height: 16px;"></i>
                    </button>
                    <!-- Sign In Link Pill -->
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold" style="font-size: 11.5px;">
                        Sign In
                    </a>
                </div>
            </div>

            <!-- Center Form Container -->
            <div class="auth-form-container">
                
                <!-- Brand Presence -->
                <div class="text-center mb-3">
                    <a href="{{ url('/') }}" class="d-inline-block mb-2 text-decoration-none">
                        <div class="showcase-brand-logo-box mx-auto" style="width: 50px; height: 50px; border: 1.5px solid rgba(226, 232, 240, 0.9);">
                            <img src="{{ asset('images/genz-logo.png') }}?v=26.1" alt="GenZ Digital Logo" class="showcase-brand-logo-img">
                        </div>
                    </a>
                    <h3 class="fw-bolder mb-1 text-body tracking-tight">
                        <span class="gz-title-gradient">Create Your Campus Account</span>
                    </h3>
                    <p class="text-secondary small mb-0" style="font-size: 13px;">
                        GenZ Digital Campus OS • ចុះឈ្មោះគណនីថ្មី
                    </p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 small py-2 px-3 mb-3" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Register Form -->
                <form action="{{ route('register.post') }}" method="POST">
                    @csrf

                    <!-- Segmented Role Selector -->
                    <div class="mb-3">
                        <label class="clean-field-label">SELECT ACCOUNT ROLE</label>
                        <div class="role-selector-pill">
                            <input type="radio" name="role" id="role-student" value="student" class="d-none" checked>
                            <input type="radio" name="role" id="role-admin" value="admin" class="d-none">
                            
                            <button type="button" class="role-pill-btn active" id="btn-role-student" onclick="setRole('student')">
                                <i data-lucide="graduation-cap" style="width: 15px; height: 15px;"></i>
                                <span>🎓 Student</span>
                            </button>
                            <button type="button" class="role-pill-btn" id="btn-role-admin" onclick="setRole('admin')">
                                <i data-lucide="shield" style="width: 15px; height: 15px;"></i>
                                <span>🛡️ Admin / Faculty</span>
                            </button>
                        </div>
                    </div>

                    <!-- Row 1: Full Name & Gender -->
                    <div class="row g-2">
                        <div class="col-12 col-sm-7">
                            <div class="clean-field-group">
                                <label class="clean-field-label" for="reg-name">FULL NAME</label>
                                <div class="clean-input-box">
                                    <span class="clean-input-icon">
                                        <i data-lucide="user" style="width: 15px; height: 15px;"></i>
                                    </span>
                                    <input type="text" name="name" id="reg-name" placeholder="e.g. Maya Chen" value="{{ old('name') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-5">
                            <div class="clean-field-group">
                                <label class="clean-field-label" for="reg-gender">GENDER</label>
                                <div class="clean-input-box">
                                    <span class="clean-input-icon">
                                        <i data-lucide="users" style="width: 15px; height: 15px;"></i>
                                    </span>
                                    <select name="gender" id="reg-gender">
                                        <option value="Female">Female</option>
                                        <option value="Male">Male</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Campus Email Address -->
                    <div class="clean-field-group">
                        <label class="clean-field-label" for="reg-email">CAMPUS EMAIL ADDRESS</label>
                        <div class="clean-input-box">
                            <span class="clean-input-icon">
                                <i data-lucide="mail" style="width: 15px; height: 15px;"></i>
                            </span>
                            <input type="email" name="email" id="reg-email" placeholder="student@genzdigital.edu" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <!-- Row 3: Student Specific Details (ID & Major) -->
                    <div id="student-extra-fields">
                        <div class="row g-2">
                            <div class="col-12 col-sm-6">
                                <div class="clean-field-group">
                                    <label class="clean-field-label" for="reg-student-id">STUDENT ID (OPTIONAL)</label>
                                    <div class="clean-input-box">
                                        <span class="clean-input-icon">
                                            <i data-lucide="credit-card" style="width: 15px; height: 15px;"></i>
                                        </span>
                                        <input type="text" name="student_id" id="reg-student-id" placeholder="Auto if blank" value="{{ old('student_id') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="clean-field-group">
                                    <label class="clean-field-label" for="reg-major">MAJOR / DEPARTMENT</label>
                                    <div class="clean-input-box">
                                        <span class="clean-input-icon">
                                            <i data-lucide="book" style="width: 15px; height: 15px;"></i>
                                        </span>
                                        <select name="major" id="reg-major">
                                            <option value="Visual Communication">Visual Communication</option>
                                            <option value="Software Engineering">Software Engineering</option>
                                            <option value="UI/UX Design Systems">UI/UX Design Systems</option>
                                            <option value="Data Science & AI">Data Science & AI</option>
                                            <option value="Interactive Media">Interactive Media</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 4: Password & Confirm Password -->
                    <div class="row g-2">
                        <div class="col-12 col-sm-6">
                            <div class="clean-field-group">
                                <label class="clean-field-label" for="reg-pass">PASSWORD</label>
                                <div class="clean-input-box">
                                    <span class="clean-input-icon">
                                        <i data-lucide="lock" style="width: 15px; height: 15px;"></i>
                                    </span>
                                    <input type="password" name="password" id="reg-pass" placeholder="Min. 6 chars" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="clean-field-group">
                                <label class="clean-field-label" for="reg-pass-confirm">CONFIRM PASSWORD</label>
                                <div class="clean-input-box">
                                    <span class="clean-input-icon">
                                        <i data-lucide="shield-check" style="width: 15px; height: 15px;"></i>
                                    </span>
                                    <input type="password" name="password_confirmation" id="reg-pass-confirm" placeholder="Repeat password" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-submit-campus mt-2 mb-3">
                        <i data-lucide="user-plus" style="width: 18px; height: 18px;"></i>
                        <span>Create Account & Get Started</span>
                    </button>
                </form>

                <!-- Footer Navigation -->
                <div class="text-center pt-2 border-top">
                    <p class="small text-secondary mb-1" style="font-size: 12.5px;">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="fw-bold text-decoration-none text-primary ms-1">
                            Sign in here
                        </a>
                    </p>
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

        function setRole(role) {
            const studentBtn = document.getElementById('btn-role-student');
            const adminBtn = document.getElementById('btn-role-admin');
            const studentRadio = document.getElementById('role-student');
            const adminRadio = document.getElementById('role-admin');
            const extraFields = document.getElementById('student-extra-fields');

            if (role === 'student') {
                studentBtn.classList.add('active');
                adminBtn.classList.remove('active');
                studentRadio.checked = true;
                adminRadio.checked = false;
                if (extraFields) extraFields.style.display = 'block';
            } else {
                adminBtn.classList.add('active');
                studentBtn.classList.remove('active');
                adminRadio.checked = true;
                studentRadio.checked = false;
                if (extraFields) extraFields.style.display = 'none';
            }
        }
    </script>
</body>
</html>
