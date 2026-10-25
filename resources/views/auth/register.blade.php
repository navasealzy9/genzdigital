<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - GenZ Digital Campus OS</title>
    <link rel="icon" type="image/png" href="{{ asset('images/genz-logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/genz-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/genz-logo.png') }}">

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
            padding: 2rem 1rem;
        }
        [data-bs-theme="dark"] body {
            background: #090d16;
        }

        .ambient-glow-orb-1 {
            position: absolute;
            width: 500px;
            height: 500px;
            top: -120px;
            left: 50%;
            transform: translateX(-50%);
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(217, 70, 239, 0.08) 50%, transparent 70%);
            filter: blur(65px);
            pointer-events: none;
            z-index: 0;
        }

        .ambient-glow-orb-2 {
            position: absolute;
            width: 440px;
            height: 440px;
            bottom: -100px;
            right: 12%;
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
            max-width: 520px;
            background: rgba(255, 255, 255, 0.96);
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
        .clean-input-group .form-control, .clean-input-group .form-select {
            border: none;
            background: transparent;
            font-size: 13.5px;
            box-shadow: none !important;
        }
        .clean-input-group .input-group-text {
            border: none;
            background: transparent;
        }

        .role-option {
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            padding: 0.75rem 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
            background: rgba(248, 250, 252, 0.7);
        }
        .role-option.active {
            border-color: #2563eb;
            background: rgba(37, 99, 235, 0.08);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
        }
        [data-bs-theme="dark"] .role-option {
            border-color: #334155;
            background: rgba(30, 41, 59, 0.5);
        }
        [data-bs-theme="dark"] .role-option.active {
            border-color: #60a5fa;
            background: rgba(96, 165, 250, 0.15);
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

        <!-- Logo & Header -->
        <div class="text-center mb-3">
            <a href="{{ url('/') }}" class="auth-brand-badge mx-auto mb-2 text-decoration-none">
                <img src="{{ asset('images/genz-logo.png') }}" alt="GenZ Digital Logo" class="auth-brand-logo">
            </a>
            <h4 class="fw-bolder mb-1 text-body tracking-tight">
                <span class="gz-title-gradient">Create Your Campus Account</span>
            </h4>
            <p class="text-secondary small mb-0" style="font-size: 12.5px;">
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

        <form action="{{ route('register.post') }}" method="POST">
            @csrf

            <!-- Account Role Selection: Student vs Admin -->
            <label class="form-label small fw-bold text-secondary mb-1.5" style="font-size: 12px;">Select Account Role</label>
            <div class="row g-2 mb-3">
                <div class="col-6">
                    <div class="role-option active d-flex align-items-center gap-2" id="role-card-student" onclick="selectRole('student')">
                        <input class="form-check-input mt-0" type="radio" name="role" id="role-student" value="student" checked>
                        <label class="form-check-label small fw-bold cursor-pointer" for="role-student">
                            <span>🎓 Student</span>
                        </label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="role-option d-flex align-items-center gap-2" id="role-card-admin" onclick="selectRole('admin')">
                        <input class="form-check-input mt-0" type="radio" name="role" id="role-admin" value="admin">
                        <label class="form-check-label small fw-bold cursor-pointer" for="role-admin">
                            <span>🛡️ Admin / Faculty</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="row g-2 mb-2.5">
                <div class="col-12 col-sm-6">
                    <label class="form-label small fw-bold text-secondary mb-1" style="font-size: 12px;">Full Name</label>
                    <div class="input-group clean-input-group">
                        <span class="input-group-text pe-1 text-secondary">
                            <i data-lucide="user" style="width: 15px; height: 15px;"></i>
                        </span>
                        <input type="text" name="name" class="form-control py-2 ps-2" placeholder="e.g. Maya Chen" value="{{ old('name') }}" required>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <label class="form-label small fw-bold text-secondary mb-1" style="font-size: 12px;">Gender</label>
                    <div class="input-group clean-input-group">
                        <span class="input-group-text pe-1 text-secondary">
                            <i data-lucide="users" style="width: 15px; height: 15px;"></i>
                        </span>
                        <select name="gender" class="form-select py-2 ps-2">
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-2.5">
                <label class="form-label small fw-bold text-secondary mb-1" style="font-size: 12px;">Campus Email Address</label>
                <div class="input-group clean-input-group">
                    <span class="input-group-text pe-1 text-secondary">
                        <i data-lucide="mail" style="width: 15px; height: 15px;"></i>
                    </span>
                    <input type="email" name="email" class="form-control py-2 ps-2" placeholder="user@genzdigital.edu" value="{{ old('email') }}" required>
                </div>
            </div>

            <!-- Student specific fields (auto hidden if admin) -->
            <div id="student-specific-fields">
                <div class="row g-2 mb-2.5">
                    <div class="col-12 col-sm-6">
                        <label class="form-label small fw-bold text-secondary mb-1" style="font-size: 12px;">Student ID (Optional)</label>
                        <div class="input-group clean-input-group">
                            <span class="input-group-text pe-1 text-secondary">
                                <i data-lucide="credit-card" style="width: 15px; height: 15px;"></i>
                            </span>
                            <input type="text" name="student_id" class="form-control py-2 ps-2" placeholder="Auto-generated if empty" value="{{ old('student_id') }}">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label small fw-bold text-secondary mb-1" style="font-size: 12px;">Major / Department</label>
                        <div class="input-group clean-input-group">
                            <span class="input-group-text pe-1 text-secondary">
                                <i data-lucide="graduation-cap" style="width: 15px; height: 15px;"></i>
                            </span>
                            <select name="major" class="form-select py-2 ps-2">
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

            <div class="row g-2 mb-3">
                <div class="col-12 col-sm-6">
                    <label class="form-label small fw-bold text-secondary mb-1" style="font-size: 12px;">Password</label>
                    <div class="input-group clean-input-group">
                        <span class="input-group-text pe-1 text-secondary">
                            <i data-lucide="lock" style="width: 15px; height: 15px;"></i>
                        </span>
                        <input type="password" name="password" id="reg-pass" class="form-control py-2 ps-2" placeholder="Min. 6 chars" required>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <label class="form-label small fw-bold text-secondary mb-1" style="font-size: 12px;">Confirm Password</label>
                    <div class="input-group clean-input-group">
                        <span class="input-group-text pe-1 text-secondary">
                            <i data-lucide="shield-check" style="width: 15px; height: 15px;"></i>
                        </span>
                        <input type="password" name="password_confirmation" id="reg-pass-confirm" class="form-control py-2 ps-2" placeholder="Repeat password" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2.5 rounded-3 fw-bold mb-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                <i data-lucide="user-plus" style="width: 17px; height: 17px;"></i>
                <span>Create Account & Get Started</span>
            </button>
        </form>

        <div class="text-center pt-2 border-top">
            <p class="small text-secondary mb-1.5" style="font-size: 12.5px;">
                Already have an account? 
                <a href="{{ route('login') }}" class="fw-bold text-decoration-none text-primary ms-1">
                    Sign in here
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
            const savedTheme = localStorage.getItem('genz_theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        });

        function selectRole(role) {
            document.querySelectorAll('.role-option').forEach(el => el.classList.remove('active'));
            const studentFields = document.getElementById('student-specific-fields');
            if (role === 'student') {
                document.getElementById('role-student').checked = true;
                document.getElementById('role-card-student').classList.add('active');
                if (studentFields) studentFields.classList.remove('d-none');
            } else {
                document.getElementById('role-admin').checked = true;
                document.getElementById('role-card-admin').classList.add('active');
                if (studentFields) studentFields.classList.add('d-none');
            }
        }
    </script>
</body>
</html>
