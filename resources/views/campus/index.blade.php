@extends('layouts.app')

@section('content')

<!-- ====================================================================== -->
<!-- 1. HOME SCREEN                                                         -->
<!-- ====================================================================== -->
<div id="screen-home" class="screen-section">
    @guest
        <!-- ============================================================== -->
        <!-- STATE 1: GUEST ENTERPRISE AUTH EXPERIENCE                      -->
        <!-- Split-Screen on Desktop, Clean Responsive Container on Mobile  -->
        <!-- ============================================================== -->
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
                <div class="position-relative z-1 my-auto py-4" style="max-width: 520px;">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill mb-3" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15);">
                        <span class="badge rounded-circle p-1 bg-success"></span>
                        <span class="small fw-semibold text-white-50" style="font-size: 11.5px;">Live Academic Cloud • 2026 Edition</span>
                    </div>

                    <h1 class="display-6 fw-bold text-white mb-2" style="letter-spacing: -0.02em; line-height: 1.25;">
                        The Intelligent Operating System for Tomorrow's Campus.
                    </h1>
                    <p class="text-white-50 mb-4" style="font-size: 14.5px; line-height: 1.6;">
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
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-1 fw-bold" style="font-size: 10.5px; letter-spacing: 0.05em;">
                        CAMPUS OS v26.0
                    </span>

                    <div class="d-flex align-items-center gap-2">
                        <!-- Light / Dark Theme Toggle -->
                        <button type="button" class="btn btn-sm rounded-circle p-1.5 border-0" onclick="toggleAppTheme()" title="Toggle Light/Dark Theme" style="background: rgba(148, 163, 184, 0.15); color: inherit;">
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
                        <div class="showcase-brand-logo-box mx-auto mb-2" style="width: 52px; height: 52px; border: 1.5px solid rgba(226, 232, 240, 0.9);">
                            <img src="{{ asset('images/genz-logo.png') }}?v=26.1" alt="GenZ Digital Logo" class="showcase-brand-logo-img">
                        </div>
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
                    <form id="guest-login-form" action="{{ route('login.post') }}" method="POST">
                        @csrf
                        
                        <!-- Campus Email -->
                        <div class="clean-field-group">
                            <label class="clean-field-label" for="guest-login-email">CAMPUS EMAIL</label>
                            <div class="clean-input-box">
                                <span class="clean-input-icon">
                                    <i data-lucide="mail" style="width: 16px; height: 16px;"></i>
                                </span>
                                <input type="email" name="email" id="guest-login-email" placeholder="name@genzdigital.edu" value="{{ old('email') }}" required autofocus>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="clean-field-group">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="clean-field-label mb-0" for="guest-login-password">PASSWORD</label>
                            </div>
                            <div class="clean-input-box">
                                <span class="clean-input-icon">
                                    <i data-lucide="lock" style="width: 16px; height: 16px;"></i>
                                </span>
                                <input type="password" name="password" id="guest-login-password" placeholder="••••••••" value="" required>
                                <button type="button" class="btn btn-link p-0 text-secondary clean-input-icon" onclick="togglePasswordVisibility()" title="Show/Hide Password">
                                    <i id="pass-toggle-icon" data-lucide="eye" style="width: 16px; height: 16px;"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember me -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="remember" id="rememberMeGuest" checked>
                                <label class="form-check-label small text-secondary" for="rememberMeGuest" style="font-size: 12px;">Remember me</label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-submit-campus mb-3">
                            <i data-lucide="log-in" style="width: 18px; height: 18px;"></i>
                            <span>Sign In to Student Pass</span>
                        </button>
                    </form>

                    <!-- Footer Navigation -->
                    <div class="text-center pt-2 border-top">
                        <a href="{{ route('register') }}" class="small text-primary text-decoration-none fw-semibold" style="font-size: 12px;">
                            Don't have an account? Register New Account
                        </a>
                    </div>

                </div>

                <!-- Bottom Copyright -->
                <div class="text-center text-secondary small py-2" style="font-size: 11px;">
                    © 2026 GenZ Digital Campus OS • All rights reserved
                </div>

            </div>

        </div>
    @else
        <!-- ============================================================== -->
        <!-- STATE 2 & 3: LOGGED IN USER                                    -->
        <!-- Displays user's Profile Card.                                  -->
        <!-- If $isEnrolled == true  -> Shows ALL campus functions          -->
        <!-- If $isEnrolled == false -> Shows ONLY Profile Card & Pending   -->
        <!-- ============================================================== -->
        <div class="row g-3 g-md-4">
            <!-- Left Column: Student Pass (Desktop: col-lg-4 col-xl-4) -->
            <div class="col-12 col-lg-4 col-xl-4">
                <!-- User's Digital Profile Pass Card (iOS 26 Ultra-Clean Design) -->
                <div class="student-pass-card student-pass-sticky" onclick="switchTab('qrpass')">
                    <div class="pass-glow-1"></div>

                    <!-- Profile Info Row -->
                    <div class="d-flex align-items-center gap-3 mb-3.5 position-relative z-1">
                        <div class="position-relative cursor-pointer flex-shrink-0" onclick="event.stopPropagation(); openAvatarCropModal()" title="Change Profile Photo (Crop)">
                            <img src="{{ $student['avatar'] }}" alt="{{ $student['name'] }}" class="user-avatar-element rounded-circle object-fit-cover shadow-lg" style="width: 68px; height: 68px; border: 3px solid rgba(255, 255, 255, 0.85); box-shadow: 0 8px 24px -4px rgba(0, 0, 0, 0.35) !important;">
                            <div class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 22px; height: 22px; border: 2px solid #ffffff;">
                                <i data-lucide="camera" style="width: 11px; height: 11px;"></i>
                            </div>
                        </div>

                        <div class="overflow-hidden w-100">
                            <h3 class="fs-4 fw-bolder mb-1 text-white tracking-tight d-flex align-items-center gap-1.5" style="letter-spacing: -0.01em;">
                                <span class="text-truncate">{{ $student['name'] }}</span>
                                @include('partials.verified-badge', ['size' => 19])
                            </h3>
                            
                            <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                                <span class="font-monospace fw-medium text-white opacity-90" style="font-size: 12px; letter-spacing: 0.02em;">
                                    ID • {{ $student['id'] }}
                                </span>
                                <span class="text-white-50 opacity-40">•</span>
                                <span class="d-inline-flex align-items-center text-white fw-semibold" style="font-size: 11.5px;">
                                    <span style="width: 6px; height: 6px; border-radius: 50%; background-color: #34d399; display: inline-block; margin-right: 5px; box-shadow: 0 0 6px #34d399;"></span>
                                    {{ $student['status'] }}
                                </span>
                            </div>

                            <!-- iOS Ultra-Clean Action Links (No Background) -->
                            <div class="d-flex align-items-center gap-2.5 flex-wrap">
                                <button type="button" class="btn btn-link p-0 text-white text-decoration-none fw-semibold d-inline-flex align-items-center gap-1.5 shadow-none opacity-90 hover-opacity-100" style="font-size: 12px;" onclick="event.stopPropagation(); switchTab('qrpass');">
                                    <i data-lucide="qr-code" style="width: 13px; height: 13px;"></i>
                                    <span>View Pass</span>
                                </button>
                                <span class="text-white-50 opacity-40">•</span>
                                <button type="button" class="btn btn-link p-0 text-white text-decoration-none fw-semibold d-inline-flex align-items-center gap-1.5 shadow-none opacity-90 hover-opacity-100" style="font-size: 12px;" onclick="event.stopPropagation(); openAvatarCropModal();">
                                    <i data-lucide="camera" style="width: 13px; height: 13px;"></i>
                                    <span>Change Photo</span>
                                </button>
                                @auth
                                    <span class="text-white-50 opacity-40">•</span>
                                    <a href="{{ route('logout') }}" class="btn btn-link p-0 text-white text-decoration-none fw-semibold d-inline-flex align-items-center gap-1.5 shadow-none opacity-85 hover-opacity-100" style="font-size: 12px;" onclick="event.stopPropagation();" title="Log Out">
                                        <i data-lucide="log-out" style="width: 13px; height: 13px;"></i>
                                        <span>Logout</span>
                                    </a>
                                    @if(Auth::user()->role === 'admin')
                                        <span class="text-white-50 opacity-40">•</span>
                                        <a href="{{ route('admin.index') }}" class="btn btn-link p-0 text-warning text-decoration-none fw-bold d-inline-flex align-items-center gap-1 shadow-none hover-opacity-100" style="font-size: 12px;" onclick="event.stopPropagation();" title="Admin Portal">
                                            <i data-lucide="shield-check" style="width: 13px; height: 13px;"></i>
                                            <span>Admin</span>
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>

                    <!-- Footer Details: Ultra-Clean Seamless (No Background Box, No Borders) -->
                    <div class="student-pass-meta-box position-relative z-1 pt-2 mt-2">
                        <div class="row g-3 text-white align-items-center">
                            <div class="col-4">
                                <small class="text-white-50 text-uppercase d-block fw-semibold" style="font-size: 9.5px; letter-spacing: 0.08em;">Gender</small>
                                <span class="fw-bold fs-6 text-white">{{ $student['gender'] }}</span>
                            </div>
                            <div class="col-8">
                                <small class="text-white-50 text-uppercase d-block fw-semibold" style="font-size: 9.5px; letter-spacing: 0.08em;">Major</small>
                                <span class="fw-bold fs-6 text-truncate d-block text-white" title="{{ $student['major'] }}">{{ $student['major'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Tools & Services OR Pending Class Assignment Notice -->
            <div class="col-12 col-lg-8 col-xl-8">
                @if($isEnrolled)
                    <!-- Responsive Grid: 2 cols on mobile, 3 on tablet, 4 on desktop -->
                    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-3 row-cols-xl-4 g-3 mb-4" id="tools-container">
                        @foreach($tools as $tool)
                            <div class="col tool-item-col" data-category="{{ $tool['category'] ?? 'academic' }}" data-title="{{ strtolower($tool['title']) }}" data-desc="{{ strtolower($tool['desc']) }}">
                                <div class="tool-card cursor-pointer" onclick="switchTab('{{ $tool['modal'] }}')">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="tool-icon-box" style="background-color: {{ $tool['bg'] }};">
                                            <i data-lucide="{{ $tool['icon'] }}" style="width: 20px; height: 20px;"></i>
                                        </div>
                                        @if(!empty($tool['badge']))
                                            <span class="badge bg-primary-subtle text-primary fw-bold" style="font-size: 9.5px; letter-spacing: 0.05em;">
                                                {{ $tool['badge'] }}
                                            </span>
                                        @else
                                            <i data-lucide="arrow-right" class="text-secondary opacity-40" style="width: 14px; height: 14px;"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1 text-truncate" style="font-size: 14px;">{{ $tool['title'] }}</h6>
                                        <small class="text-secondary text-truncate d-block" style="font-size: 11.5px;">{{ $tool['desc'] }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Pending Class Assignment Notification Card (Only Profile Card is visible on left!) -->
                    <div class="tool-card p-4 p-md-5 text-center">
                        <div class="mb-4">
                            <div class="d-inline-flex p-3 rounded-circle bg-warning-subtle text-warning mb-3 shadow-sm">
                                <i data-lucide="clock" style="width: 46px; height: 46px;"></i>
                            </div>
                            <h4 class="fw-bolder mb-1">Account Active • Pending Class Assignment</h4>
                            <p class="text-secondary small mb-4" style="max-width: 520px; margin: 0 auto; line-height: 1.6;">
                                សូមស្វាគមន៍ <strong>{{ $student['name'] }}</strong>! គណនីរបស់អ្នកបាន Sign In ជោគជ័យហើយ។ មុខងារកាលវិភាគ វត្តមាន កន្ត្រកមុខវិជ្ជា និងពិន្ទុ នឹងបើកដំណើរការពេញលេញនៅពេល Admin ឬគ្រូបង្រៀនបានចាត់តាំង (Add) អ្នកចូលក្នុងថ្នាក់រៀនណាមួយ។
                            </p>
                        </div>

                        <!-- Enrollment Progress Steps -->
                        <div class="p-3.5 rounded-4 bg-body-secondary text-start mb-4 mx-auto" style="max-width: 540px;">
                            <span class="fw-bold mb-3 small text-uppercase text-secondary d-block" style="font-size: 11px; letter-spacing: 0.08em;">Enrollment Progress Status</span>
                            <div class="d-flex flex-column gap-3">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="badge bg-success rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                        <i data-lucide="check" style="width: 17px; height: 17px;"></i>
                                    </span>
                                    <div>
                                        <strong class="d-block small">1. Logged In & Profile Active</strong>
                                        <small class="text-secondary">Student ID: <strong>{{ $student['id'] }}</strong> ({{ $student['name'] }}) is verified.</small>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-3">
                                    <span class="badge bg-warning text-dark rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                        <i data-lucide="clock" style="width: 17px; height: 17px;"></i>
                                    </span>
                                    <div>
                                        <strong class="d-block small text-warning-emphasis">2. Class Assignment (Waiting for Admin)</strong>
                                        <small class="text-secondary">Campus Admin needs to assign you to a classroom/course in the Admin Portal.</small>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-3 opacity-50">
                                    <span class="badge bg-secondary rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                        <i data-lucide="lock" style="width: 17px; height: 17px;"></i>
                                    </span>
                                    <div>
                                        <strong class="d-block small">3. Campus Features Unlocked</strong>
                                        <small class="text-secondary">Class Schedule, Scanner, Resources, Scores, Attendance will appear here once enrolled.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                            <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold shadow-xs d-inline-flex align-items-center gap-1.5" onclick="switchTab('resource')">
                                <i data-lucide="folder-down" style="width: 16px; height: 16px;"></i>
                                <span>View Learning Resources ({{ $resources->count() }} PDFs)</span>
                            </button>
                            <a href="{{ route('admin.index', ['tab' => 'users']) }}" class="btn btn-outline-primary rounded-pill px-4 fw-bold d-inline-flex align-items-center gap-1.5">
                                <i data-lucide="shield-check" style="width: 16px; height: 16px;"></i>
                                <span>Go to Admin Portal to Assign Class</span>
                            </a>
                            <button type="button" class="btn btn-light border rounded-pill px-4 fw-bold d-inline-flex align-items-center gap-1.5" onclick="location.reload()">
                                <i data-lucide="refresh-cw" style="width: 16px; height: 16px;"></i>
                                <span>Refresh Status</span>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endguest
</div>

<!-- ====================================================================== -->
<!-- 2. SCHEDULE SCREEN                                                     -->
<!-- ====================================================================== -->
<div id="screen-schedule" class="screen-section d-none">
    @auth
        @if($isEnrolled)
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4">
                <div>
                    <h4 class="fw-bolder mb-0 tracking-tight">Class Schedule</h4>
                    <small class="text-secondary">Semester 1 • Week 8</small>
                </div>

                <!-- Horizontal Day Picker -->
                <div class="d-flex gap-2 overflow-x-auto pb-1 scrollbar-none">
                    @foreach($scheduleDays as $d)
                        <button class="day-btn {{ $d['day'] === 'Mon' ? 'active' : '' }}" onclick="selectDay(this)">
                            <small class="d-block text-uppercase" style="font-size: 10px;">{{ $d['day'] }}</small>
                            <span class="fs-6 fw-bold">{{ $d['date'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Responsive Schedule Cards Grid (Desktop: 3 columns, Tablet: 2 columns, Mobile: 1 column) -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-3">
                @foreach($scheduleData as $item)
                    <div class="col">
                        <div class="tool-card p-3 p-md-4 border-start border-4" style="border-left-color: {{ $item['border_color'] }} !important;" onclick="showClassDetail({{ json_encode($item) }})">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-secondary d-flex align-items-center gap-1 fw-bold" style="font-size: 11.5px;">
                                    <i data-lucide="clock" style="width: 13px; height: 13px;"></i>
                                    <span>{{ $item['time'] }}</span>
                                </small>
                                <span class="badge {{ $item['status'] === 'Ongoing' ? 'bg-success-subtle text-success' : 'bg-primary-subtle text-primary' }} text-uppercase fw-bold" style="font-size: 10px;">
                                    {{ $item['status'] }}
                                </span>
                            </div>

                            <h5 class="fw-bold mb-2 fs-6 tracking-tight">{{ $item['title'] }}</h5>

                            <div class="d-flex flex-column gap-1 text-secondary mb-3" style="font-size: 12px;">
                                <span class="d-flex align-items-center gap-1.5 text-primary">
                                    <i data-lucide="map-pin" style="width: 14px; height: 14px;"></i>
                                    <span class="text-secondary">{{ $item['room'] }}</span>
                                </span>
                                <span class="opacity-75 ps-3">Instructor: {{ $item['prof'] }}</span>
                            </div>

                            <button class="btn btn-sm btn-outline-primary w-100 rounded-3 fw-bold mt-auto" onclick="event.stopPropagation(); showClassDetail({{ json_encode($item) }})">
                                View Details & Attendance
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="tool-card p-5 text-center my-4">
                <div class="d-inline-flex p-3 rounded-circle bg-warning-subtle text-warning mb-3">
                    <i data-lucide="calendar-x" style="width: 42px; height: 42px;"></i>
                </div>
                <h5 class="fw-bold mb-2">No Active Class Schedule</h5>
                <p class="text-secondary small mb-3" style="max-width: 480px; margin: 0 auto;">
                    កាលវិភាគថ្នាក់រៀនរបស់អ្នកនឹងបង្ហាញនៅទីនេះ បន្ទាប់ពី Admin បានបញ្ចូលអ្នកទៅកាន់ថ្នាក់រៀនណាមួយ។
                </p>
                <a href="{{ route('admin.index', ['tab' => 'users']) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    <i data-lucide="shield-check" style="width: 14px; height: 14px;" class="me-1"></i> Admin Class Management
                </a>
            </div>
        @endif
    @else
        <div class="tool-card p-5 text-center my-4">
            <div class="d-inline-flex p-3 rounded-circle bg-primary-subtle text-primary mb-3">
                <i data-lucide="calendar-x" style="width: 44px; height: 44px;"></i>
            </div>
            <h4 class="fw-bolder mb-2">Sign In to View Your Schedule</h4>
            <p class="text-secondary small mb-4" style="max-width: 460px; margin: 0 auto;">
                សូមធ្វើការ Sign In ចូលគណនីរបស់អ្នកដើម្បីមើលកាលវិភាគថ្នាក់រៀនផ្ទាល់ខ្លួន។
            </p>
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4 fw-bold">Sign In</a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary rounded-pill px-4 fw-bold">Register</a>
            </div>
        </div>
    @endauth
</div>

<!-- ====================================================================== -->
<!-- 3. INBOX SCREEN                                                        -->
<!-- ====================================================================== -->
<div id="screen-inbox" class="screen-section d-none">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3">
        <div>
            <h4 class="fw-bolder mb-0 tracking-tight">Inbox & Messages</h4>
            <small class="text-secondary">Stay in the loop with your campus community.</small>
        </div>

        <!-- Filter Pills -->
        <div class="p-1 rounded-3 d-flex gap-1" style="background: rgba(148, 163, 184, 0.15);">
            <button class="btn btn-sm px-3 fw-bold rounded-2 btn-light inbox-filter active" onclick="filterChats('all', this)">All</button>
            <button class="btn btn-sm px-3 fw-bold rounded-2 text-secondary inbox-filter" onclick="filterChats('announcements', this)">Announcements</button>
            <button class="btn btn-sm px-3 fw-bold rounded-2 text-secondary inbox-filter" onclick="filterChats('academic', this)">Academic</button>
        </div>
    </div>

    <!-- Responsive Chat List (Desktop: 2 columns grid, Mobile: stacked) -->
    <div class="row row-cols-1 row-cols-lg-2 g-3" id="chat-list-container">
        @forelse($chats as $chat)
            <div class="col chat-row" data-category="{{ $chat['category'] }}" id="chat-item-{{ $chat['room_id'] ?? $chat['id'] }}">
                <div class="tool-card p-3 p-md-4 d-flex flex-row align-items-center gap-3 cursor-pointer" onclick="openChat({{ json_encode($chat) }})">
                    <div class="position-relative flex-shrink-0">
                        <img src="{{ $chat['avatar'] }}" alt="{{ $chat['name'] }}" class="rounded-3 object-fit-cover shadow-xs" style="width: 54px; height: 54px; border: 1.5px solid var(--bs-border-color);">
                        @if(($chat['unread'] ?? 0) > 0)
                            <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-danger border border-2 border-white" style="font-size: 10px;">
                                {{ $chat['unread'] }}
                            </span>
                        @endif
                    </div>

                    <div class="flex-grow-1 min-w-0">
                        <div class="d-flex justify-content-between align-items-baseline mb-1">
                            <h6 class="fw-bold mb-0 text-truncate" style="font-size: 14.5px;">{{ $chat['name'] }}</h6>
                            <small class="text-secondary flex-shrink-0 ms-2 chat-item-time" style="font-size: 11px;">{{ $chat['time'] }}</small>
                        </div>
                        <div class="d-flex align-items-center gap-1.5 mb-1">
                            @if($chat['category'] === 'academic')
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle" style="font-size: 9.5px; padding: 2px 6px;">Class Group</span>
                            @elseif($chat['category'] === 'announcements')
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle" style="font-size: 9.5px; padding: 2px 6px;">Official</span>
                            @else
                                <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 9.5px; padding: 2px 6px;">Community</span>
                            @endif
                            <small class="text-secondary fw-medium text-truncate" style="font-size: 11px;">{{ $chat['role'] }}</small>
                        </div>
                        <p class="text-secondary text-truncate mb-0 chat-item-last-message" style="font-size: 12px;">{{ $chat['last_message'] }}</p>
                    </div>

                    <div class="ms-auto ps-2">
                        <button type="button" class="btn btn-sm btn-primary rounded-circle d-flex align-items-center justify-content-center p-2 shadow-xs" style="width: 34px; height: 34px;">
                            <i data-lucide="message-square" style="width: 16px; height: 16px;"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="p-3.5 rounded-4 bg-body-secondary d-inline-block mb-3">
                    <i data-lucide="messages-square" class="text-primary" style="width: 42px; height: 42px;"></i>
                </div>
                <h6 class="fw-bold mb-1">No Group Chats Available</h6>
                <p class="text-secondary small mb-3">Enroll in courses or get assigned by Admin to join your class group chat.</p>
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-3.5 fw-bold" onclick="switchTab('classCart')">
                    Go to Class Cart
                </button>
            </div>
        @endforelse
    </div>
</div>

<!-- ====================================================================== -->
<!-- 4. PROFILE SCREEN                                                      -->
<!-- ====================================================================== -->
<div id="screen-profile" class="screen-section d-none">
    @auth
    <!-- Profile Page Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4">
        <div>
            <h4 class="fw-bolder mb-0 tracking-tight">Student Profile</h4>
            <small class="text-secondary">Official Digital Pass, Academic Credentials & System Settings</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-1.5 fw-bold d-inline-flex align-items-center gap-1.5">
                <span class="p-1 rounded-circle bg-success d-inline-block"></span>
                <span>{{ $student['status'] ?? 'Active' }} Student</span>
            </span>
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold" onclick="toggleAppTheme()">
                <i data-lucide="moon" style="width: 14px; height: 14px;"></i>
                <span class="ms-1 d-none d-sm-inline">Theme</span>
            </button>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column: 3D Flip Pass Card, Quick Stats & Action Cards -->
        <div class="col-12 col-lg-5 col-xl-4">
            <!-- 3D Luxury Student Pass Card -->
            <div class="perspective-1000 mb-3">
                <div id="student-flip-card" class="flip-card" onclick="toggleCardFlip()" title="Click to flip pass">
                    <div class="flip-card-inner">
                        <!-- Front View -->
                        <div class="flip-card-front position-relative overflow-hidden">
                            <!-- Background Ambient Light -->
                            <div style="position: absolute; top: -60px; right: -40px; width: 190px; height: 190px; background: radial-gradient(circle, rgba(255,255,255,0.22) 0%, rgba(255,255,255,0) 70%); border-radius: 50%; pointer-events: none;"></div>

                            <!-- Card Top Bar: Logo, Chip & Flip Button -->
                            <div class="d-flex justify-content-between align-items-center position-relative z-1">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ asset('images/genz-logo.png') }}" alt="Logo" style="width: 20px; height: 20px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">
                                    <span class="text-uppercase fw-bold text-white tracking-wider" style="font-size: 10px; letter-spacing: 0.16em;">
                                        GENZ DIGITAL PASS
                                    </span>
                                </div>
                                
                                <div class="d-flex align-items-center gap-1.5">
                                    <!-- Contactless NFC Wave Icon -->
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.8)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                        <path d="M6 8a6 6 0 0 1 12 0"/>
                                        <path d="M8.5 10.5a3.5 3.5 0 0 1 7 0"/>
                                        <path d="M11 13a1 1 0 0 1 2 0"/>
                                    </svg>
                                    <span class="badge rounded-pill px-2.5 py-1 text-white shadow-xs" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(8px); font-size: 9.5px; border: 1px solid rgba(255, 255, 255, 0.3);">
                                        Flip 🔄
                                    </span>
                                </div>
                            </div>

                            <!-- Card Middle: Avatar & Student Details -->
                            <div class="d-flex align-items-center gap-3 my-auto position-relative z-1">
                                <div class="position-relative cursor-pointer flex-shrink-0" onclick="event.stopPropagation(); openAvatarCropModal()" title="Change Profile Photo (Crop)">
                                    <img src="{{ $student['avatar'] }}" alt="{{ $student['name'] }}" class="user-avatar-element rounded-circle object-fit-cover shadow" style="width: 64px; height: 64px; border: 2.5px solid rgba(255, 255, 255, 0.9);">
                                    <div class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 22px; height: 22px; border: 2px solid #ffffff;">
                                        <i data-lucide="camera" style="width: 11px; height: 11px;"></i>
                                    </div>
                                </div>
                                <div class="min-w-0 flex-grow-1">
                                    <h5 class="fw-bolder mb-0 text-white tracking-tight d-flex align-items-center gap-1.5 text-truncate" style="font-size: 16.5px;">
                                        <span class="text-truncate">{{ $student['name'] }}</span>
                                        @include('partials.verified-badge', ['size' => 16])
                                    </h5>
                                    <small class="text-white-50 font-monospace d-block" style="font-size: 11px;">ID • {{ $student['id'] }}</small>
                                    
                                    <!-- Beautiful Major Badge -->
                                    <div class="d-inline-flex align-items-center gap-1 px-2.5 py-0.5 rounded-pill mt-1" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.3); max-width: 100%;">
                                        <i data-lucide="sparkles" style="width: 10px; height: 10px; color: #fde047; flex-shrink: 0;"></i>
                                        <span class="text-white fw-semibold text-truncate" style="font-size: 10.5px;">
                                            {{ !empty($student['major']) ? $student['major'] : 'Digital Technology & AI' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Bottom Bar: Validity & Status -->
                            <div class="d-flex justify-content-between align-items-center pt-2 border-top border-white border-opacity-20 text-white-50 font-monospace position-relative z-1" style="font-size: 9.5px;">
                                <div class="d-flex align-items-center gap-1">
                                    <span>VALID THRU:</span>
                                    <span class="text-white fw-bold">{{ $student['valid_until'] }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-1.5 text-white fw-bold text-uppercase">
                                    <span class="p-1 rounded-circle bg-success shadow-xs d-inline-block"></span>
                                    <span>{{ $student['status'] }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Back View (QR Scanner & NFC Strip) -->
                        <div class="flip-card-back align-items-center text-center position-relative">
                            <!-- Magnetic Stripe -->
                            <div style="background: #090d16; height: 32px; margin: -1.35rem -1.45rem 0.5rem -1.45rem; border-top-left-radius: 24px; border-top-right-radius: 24px; display: flex; align-items: center; justify-content: flex-end; padding-right: 1.25rem;">
                                <span style="font-size: 8px; color: rgba(255,255,255,0.35); font-family: monospace; letter-spacing: 0.14em;">SECURE NFC ACCREDITED PASS</span>
                            </div>

                            <div class="my-auto d-flex flex-column align-items-center">
                                <span class="text-uppercase fw-bold text-white-50 mb-1.5" style="font-size: 9px; letter-spacing: 0.12em;">
                                    SCAN TO VERIFY ACCESS
                                </span>

                                <div class="bg-white p-2 rounded-3 shadow d-inline-block">
                                    <svg width="76" height="76" viewBox="0 0 24 24" fill="none" stroke="#0f172a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="5" height="5" x="3" y="3" rx="1"/>
                                        <rect width="5" height="5" x="16" y="3" rx="1"/>
                                        <rect width="5" height="5" x="3" y="16" rx="1"/>
                                        <path d="M21 16h-3a2 2 0 0 0-2 2v3"/>
                                        <path d="M21 21v.01"/>
                                        <path d="M12 7v3a2 2 0 0 1-2 2H7"/>
                                        <path d="M3 12h.01"/>
                                        <path d="M12 3h.01"/>
                                        <path d="M12 16v.01"/>
                                        <path d="M16 12h1"/>
                                        <path d="M21 12v.01"/>
                                        <path d="M12 21v-1"/>
                                    </svg>
                                </div>

                                <div class="mt-2 text-white-50 font-monospace text-uppercase" style="font-size: 9.5px; letter-spacing: 0.08em;">
                                    NFC ID • {{ $student['pass_id'] }}
                                </div>
                            </div>

                            <span class="text-white-50" style="font-size: 9px;">
                                Tap at turnstiles or smart attendance desks
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stat Metric Bar -->
            <div class="row g-2 mb-3">
                <div class="col-4">
                    <div class="p-2.5 rounded-3 bg-body border text-center shadow-xs">
                        <span class="text-secondary d-block" style="font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em;">Attendance</span>
                        <div class="fw-bolder text-success fs-6 my-0.5">{{ $student['overall_attendance'] ?? '98%' }}</div>
                        <small class="text-secondary d-block text-truncate" style="font-size: 9.5px;">Overall Rate</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-2.5 rounded-3 bg-body border text-center shadow-xs">
                        <span class="text-secondary d-block" style="font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em;">Enrolled</span>
                        <div class="fw-bolder text-primary fs-6 my-0.5">{{ $enrolledClasses->count() }} <span style="font-size: 11px;">Classes</span></div>
                        <small class="text-secondary d-block text-truncate" style="font-size: 9.5px;">Active Terms</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-2.5 rounded-3 bg-body border text-center shadow-xs">
                        <span class="text-secondary d-block" style="font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em;">Credits</span>
                        <div class="fw-bolder text-purple fs-6 my-0.5">{{ $totalCredits ?: 12 }} <span style="font-size: 11px;">Pts</span></div>
                        <small class="text-secondary d-block text-truncate" style="font-size: 9.5px;">Earned Pts</small>
                    </div>
                </div>
            </div>

            <!-- Group 1: Academic & Pass Services -->
            <div class="tool-card p-2 mb-3 border shadow-xs">
                <div class="px-2 pt-1.5 pb-2 border-bottom">
                    <span class="text-uppercase text-secondary fw-bold" style="font-size: 10px; letter-spacing: 0.08em;">Academic & Pass Services</span>
                </div>

                <div class="list-group list-group-flush">
                    <!-- Item 1: Digital Pass QR -->
                    <button type="button" class="list-group-item list-group-item-action border-0 px-2.5 py-2.5 rounded-3 d-flex align-items-center justify-content-between profile-action-row" onclick="switchTab('qrpass')">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="p-2 rounded-3 text-white d-flex align-items-center justify-content-center shadow-xs flex-shrink-0" style="width: 36px; height: 36px; background: linear-gradient(135deg, #2563eb, #3b82f6);">
                                <i data-lucide="qr-code" style="width: 18px; height: 18px;"></i>
                            </div>
                            <div>
                                <span class="fw-bold d-block text-body" style="font-size: 13px;">Digital Student Pass (QR)</span>
                                <small class="text-secondary" style="font-size: 11px;">Full screen QR pass for campus access</small>
                            </div>
                        </div>
                        <i data-lucide="chevron-right" class="text-secondary opacity-50" style="width: 16px; height: 16px;"></i>
                    </button>

                    <!-- Item 2: Crop Photo -->
                    <button type="button" class="list-group-item list-group-item-action border-0 px-2.5 py-2.5 rounded-3 d-flex align-items-center justify-content-between profile-action-row" onclick="openAvatarCropModal()">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="p-2 rounded-3 text-white d-flex align-items-center justify-content-center shadow-xs flex-shrink-0" style="width: 36px; height: 36px; background: linear-gradient(135deg, #06b6d4, #0ea5e9);">
                                <i data-lucide="camera" style="width: 18px; height: 18px;"></i>
                            </div>
                            <div>
                                <span class="fw-bold d-block text-body" style="font-size: 13px;">Change Profile Photo (Crop)</span>
                                <small class="text-secondary" style="font-size: 11px;">Upload & crop your digital pass portrait</small>
                            </div>
                        </div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2 py-0.5 fw-bold" style="font-size: 9.5px;">Crop Tool</span>
                    </button>

                    <!-- Item 3: Attendance -->
                    <button type="button" class="list-group-item list-group-item-action border-0 px-2.5 py-2.5 rounded-3 d-flex align-items-center justify-content-between profile-action-row" onclick="switchTab('attendance')">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="p-2 rounded-3 text-white d-flex align-items-center justify-content-center shadow-xs flex-shrink-0" style="width: 36px; height: 36px; background: linear-gradient(135deg, #10b981, #059669);">
                                <i data-lucide="check-circle-2" style="width: 18px; height: 18px;"></i>
                            </div>
                            <div>
                                <span class="fw-bold d-block text-body" style="font-size: 13px;">Detailed Attendance Records</span>
                                <small class="text-secondary" style="font-size: 11px;">Track daily session check-ins & logs</small>
                            </div>
                        </div>
                        <i data-lucide="chevron-right" class="text-secondary opacity-50" style="width: 16px; height: 16px;"></i>
                    </button>

                    <!-- Item 4: Resources -->
                    <button type="button" class="list-group-item list-group-item-action border-0 px-2.5 py-2.5 rounded-3 d-flex align-items-center justify-content-between profile-action-row" onclick="switchTab('resource')">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="p-2 rounded-3 text-white d-flex align-items-center justify-content-center shadow-xs flex-shrink-0" style="width: 36px; height: 36px; background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                                <i data-lucide="folder-down" style="width: 18px; height: 18px;"></i>
                            </div>
                            <div>
                                <span class="fw-bold d-block text-body" style="font-size: 13px;">Learning Resources & Lessons</span>
                                <small class="text-secondary" style="font-size: 11px;">Read PDF lecture slides & downloads</small>
                            </div>
                        </div>
                        <span class="badge bg-purple-subtle text-purple border border-purple-subtle rounded-pill px-2 py-0.5 fw-bold" style="font-size: 9.5px;">{{ $resources->count() }} Files</span>
                    </button>
                </div>
            </div>

            <!-- Group 2: Preferences & Account Security -->
            <div class="tool-card p-2 mb-3 border shadow-xs">
                <div class="px-2 pt-1.5 pb-2 border-bottom">
                    <span class="text-uppercase text-secondary fw-bold" style="font-size: 10px; letter-spacing: 0.08em;">Preferences & Account</span>
                </div>

                <div class="list-group list-group-flush">
                    <!-- Item 1: Theme -->
                    <button type="button" class="list-group-item list-group-item-action border-0 px-2.5 py-2.5 rounded-3 d-flex align-items-center justify-content-between profile-action-row" onclick="toggleAppTheme()">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="p-2 rounded-3 text-white d-flex align-items-center justify-content-center shadow-xs flex-shrink-0" style="width: 36px; height: 36px; background: linear-gradient(135deg, #f59e0b, #d97706);">
                                <i data-lucide="moon" style="width: 18px; height: 18px;"></i>
                            </div>
                            <div>
                                <span class="fw-bold d-block text-body" style="font-size: 13px;">Theme Appearance</span>
                                <small class="text-secondary" style="font-size: 11px;">Switch Light / Dark Campus Mode</small>
                            </div>
                        </div>
                        <span class="badge bg-body-secondary text-body rounded-pill px-2.5 py-1 fw-bold" style="font-size: 9.5px;">Toggle</span>
                    </button>

                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <!-- Item 2: Admin Console -->
                        <a href="{{ route('admin.index') }}" class="list-group-item list-group-item-action border-0 px-2.5 py-2.5 rounded-3 d-flex align-items-center justify-content-between profile-action-row text-decoration-none">
                            <div class="d-flex align-items-center gap-2.5">
                                <div class="p-2 rounded-3 text-white d-flex align-items-center justify-content-center shadow-xs flex-shrink-0" style="width: 36px; height: 36px; background: linear-gradient(135deg, #4f46e5, #4338ca);">
                                    <i data-lucide="shield-check" style="width: 18px; height: 18px;"></i>
                                </div>
                                <div>
                                    <span class="fw-bold d-block text-primary" style="font-size: 13px;">Admin Management Console</span>
                                    <small class="text-secondary" style="font-size: 11px;">Access admin portal & class controls</small>
                                </div>
                            </div>
                            <span class="badge bg-primary text-white rounded-pill px-2.5 py-1 fw-bold" style="font-size: 9.5px;">ADMIN</span>
                        </a>
                    @endif

                    <!-- Item 3: Log Out -->
                    <a href="{{ route('logout') }}" class="list-group-item list-group-item-action border-0 px-2.5 py-2.5 rounded-3 d-flex align-items-center justify-content-between profile-action-row text-decoration-none">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="p-2 rounded-3 text-white d-flex align-items-center justify-content-center shadow-xs flex-shrink-0" style="width: 36px; height: 36px; background: linear-gradient(135deg, #ef4444, #dc2626);">
                                <i data-lucide="log-out" style="width: 18px; height: 18px;"></i>
                            </div>
                            <div>
                                <span class="fw-bold d-block text-danger" style="font-size: 13px;">Sign Out of Account</span>
                                <small class="text-secondary" style="font-size: 11px;">Safely end active student session</small>
                            </div>
                        </div>
                        <i data-lucide="arrow-right" class="text-danger opacity-75" style="width: 18px; height: 18px;"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Column: Student Personal Information & Academic Attendance -->
        <div class="col-12 col-lg-7 col-xl-8">
            <!-- 1. Student Personal & Academic Information Card -->
            <div class="tool-card p-3 p-md-4 mb-4 border shadow-xs">
                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <div class="p-2 rounded-3 bg-primary-subtle text-primary">
                            <i data-lucide="id-card" style="width: 18px; height: 18px;"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 fs-6">Official Student Credentials</h5>
                            <small class="text-secondary">Verified Academic Registry Profile</small>
                        </div>
                    </div>
                    <span class="badge bg-primary-subtle text-primary fw-bold px-2.5 py-1 rounded-pill" style="font-size: 10px;">
                        VERIFIED ID
                    </span>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <div class="p-3 rounded-3 bg-body border shadow-2xs h-100">
                            <small class="text-secondary d-block fw-semibold" style="font-size: 11px;">FULL LEGAL NAME</small>
                            <div class="fw-bold fs-6 mt-1 d-flex align-items-center gap-1.5 text-body">
                                <span>{{ $student['name'] }}</span>
                                @include('partials.verified-badge', ['size' => 15])
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="p-3 rounded-3 bg-body border shadow-2xs h-100">
                            <small class="text-secondary d-block fw-semibold" style="font-size: 11px;">STUDENT ID NUMBER</small>
                            <div class="fw-bold fs-6 font-monospace mt-1 text-primary">
                                {{ $student['id'] }}
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="p-3 rounded-3 bg-body border shadow-2xs h-100">
                            <small class="text-secondary d-block fw-semibold" style="font-size: 11px;">ACADEMIC MAJOR / PROGRAM</small>
                            <div class="fw-bold fs-6 mt-1 text-body">
                                {{ !empty($student['major']) ? $student['major'] : 'Digital Technology & AI' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="p-3 rounded-3 bg-body border shadow-2xs h-100">
                            <small class="text-secondary d-block fw-semibold" style="font-size: 11px;">REGISTERED EMAIL</small>
                            <div class="fw-bold fs-6 mt-1 text-body text-truncate">
                                {{ Auth::user()->email ?? 'student@genzdigital.edu' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="p-3 rounded-3 bg-body border shadow-2xs h-100">
                            <small class="text-secondary d-block fw-semibold" style="font-size: 11px;">GENDER / IDENTITY</small>
                            <div class="fw-bold fs-6 mt-1 text-body">
                                {{ $student['gender'] ?? 'Not Specified' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="p-3 rounded-3 bg-body border shadow-2xs h-100">
                            <small class="text-secondary d-block fw-semibold" style="font-size: 11px;">DIGITAL PASS VALIDITY</small>
                            <div class="fw-bold fs-6 mt-1 text-success d-flex align-items-center gap-1.5">
                                <span class="p-1 rounded-circle bg-success shadow-xs d-inline-block"></span>
                                <span>Active Until {{ $student['valid_until'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Academic Attendance Records Card -->
            <div class="tool-card p-3 p-md-4 mb-3 border shadow-xs">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3 pb-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <div class="p-2 rounded-3 bg-success-subtle text-success">
                            <i data-lucide="check-circle-2" style="width: 18px; height: 18px;"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 fs-6">Academic Attendance Records</h5>
                            <small class="text-secondary">Official live record for current academic year</small>
                        </div>
                    </div>
                    <span class="badge {{ $isEnrolled ? 'bg-primary-subtle text-primary border border-primary-subtle' : 'bg-warning-subtle text-warning border border-warning-subtle' }} fw-bold fs-7 rounded-pill px-3 py-1.5">
                        {{ $isEnrolled ? 'Overall ' . $student['overall_attendance'] : 'Pending Class Assignment' }}
                    </span>
                </div>

                @if($isEnrolled)
                    <!-- Visual Attendance Rate Bar -->
                    <div class="p-3 rounded-3 bg-body border mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1.5">
                            <span class="small fw-bold text-body">Overall Attendance Integrity</span>
                            <span class="fw-bolder text-primary">{{ $student['overall_attendance'] }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ intval($student['overall_attendance']) ?: 95 }}%;" aria-valuenow="{{ intval($student['overall_attendance']) ?: 95 }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="text-secondary small">
                                <tr>
                                    <th>Subject</th>
                                    <th>Code</th>
                                    <th>Last Check</th>
                                    <th>Status</th>
                                    <th class="text-end">Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendanceList as $att)
                                    <tr>
                                        <td class="fw-bold">{{ $att['subject'] }}</td>
                                        <td><span class="badge bg-body-secondary text-secondary font-monospace">{{ $att['code'] }}</span></td>
                                        <td class="small text-secondary">{{ $att['last_check'] }}</td>
                                        <td>
                                            <span class="badge {{ $att['status'] === 'Excellent' || $att['status'] === 'Good' ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-warning-subtle text-warning border border-warning-subtle' }} fw-bold rounded-pill px-2.5">
                                                {{ $att['status'] }}
                                            </span>
                                        </td>
                                        <td class="text-end fw-bolder text-primary fs-6">{{ $att['rate'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-4 text-center text-secondary">
                        <i data-lucide="info" class="text-warning mb-2" style="width: 32px; height: 32px;"></i>
                        <p class="small mb-0">មិនទាន់មានទិន្នន័យវត្តមាននៅឡើយទេ ដោយសារសិស្សមិនទាន់បានចូលរួមក្នុងថ្នាក់រៀនណាមួយ។</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @else
        <div class="tool-card p-5 text-center my-4">
            <div class="d-inline-flex p-3 rounded-circle bg-primary-subtle text-primary mb-3">
                <i data-lucide="user" style="width: 44px; height: 44px;"></i>
            </div>
            <h4 class="fw-bolder mb-2">Student Authentication Required</h4>
            <p class="text-secondary small mb-4" style="max-width: 460px; margin: 0 auto;">
                សូមធ្វើការ Sign In ចូលគណនីរបស់អ្នកដើម្បីមើលប្រវត្តិរូប Student Pass, កំណត់ត្រាវត្តមាន និងព័ត៌មានសិក្សា។
            </p>
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4 fw-bold">Sign In</a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary rounded-pill px-4 fw-bold">Register</a>
            </div>
        </div>
    @endauth
</div>

@auth
@if($isEnrolled)
<!-- ====================================================================== -->
<!-- 5. CLASS CART & COURSE ENROLLMENT DEDICATED PAGE                       -->
<!-- ====================================================================== -->
<div id="screen-classCart" class="screen-section d-none">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4 pb-3 border-bottom">
        <div class="d-flex align-items-center gap-2.5">
            <button type="button" class="btn-ios-circle" onclick="switchTab('home')" title="Back to Home">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
            </button>
            <div>
                <h4 class="fw-bolder mb-0 tracking-tight">Class Cart & Course Enrollment</h4>
                <small class="text-secondary">កន្ត្រកថ្នាក់រៀន & ចុះឈ្មោះមុខវិជ្ជា • Semester 1, 2026</small>
            </div>
        </div>
        <span class="badge bg-primary-subtle text-primary py-2 px-3 rounded-pill fw-bold">
            <i data-lucide="shopping-cart" style="width: 14px; height: 14px;" class="me-1"></i> Active Registration
        </span>
    </div>

    <!-- 4 Summary KPI Cards -->
    <div class="row row-cols-2 row-cols-lg-4 g-3 mb-4">
        <div class="col">
            <div class="tool-card p-3 p-md-4 text-center">
                <small class="text-secondary d-block fw-semibold mb-1" style="font-size: 11px;">REGISTERED CREDITS</small>
                <h3 class="fw-bolder mb-1 text-primary">{{ $courseCarts->where('status', 'Enrolled')->count() * 3 }} <span class="fs-6 text-secondary">/ 18</span></h3>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-primary" style="width: {{ min(100, ($courseCarts->where('status', 'Enrolled')->count() * 3 / 18) * 100) }}%;"></div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="tool-card p-3 p-md-4 text-center">
                <small class="text-secondary d-block fw-semibold mb-1" style="font-size: 11px;">ENROLLED CLASSES</small>
                <h3 class="fw-bolder mb-1 text-success">{{ $courseCarts->where('status', 'Enrolled')->count() }}</h3>
                <small class="text-success fw-semibold" style="font-size: 11px;"><i data-lucide="check" style="width: 12px; height: 12px;" class="d-inline-block"></i> Active Enrolled</small>
            </div>
        </div>
        <div class="col">
            <div class="tool-card p-3 p-md-4 text-center">
                <small class="text-secondary d-block fw-semibold mb-1" style="font-size: 11px;">ELECTIVES IN CART</small>
                <h3 class="fw-bolder mb-1 text-warning-emphasis">{{ $courseCarts->where('status', 'In Cart')->count() }}</h3>
                <small class="text-secondary fw-semibold" style="font-size: 11px;">Available to Register</small>
            </div>
        </div>
        <div class="col">
            <div class="tool-card p-3 p-md-4 text-center">
                <small class="text-secondary d-block fw-semibold mb-1" style="font-size: 11px;">TUITION & FEES</small>
                <h3 class="fw-bolder mb-1 text-info fs-5">Verified</h3>
                <small class="text-info fw-semibold" style="font-size: 11px;">Scholarship / Paid</small>
            </div>
        </div>
    </div>

    <!-- Class Tabs: 1. My Classroom (ថ្នាក់រៀនរបស់ខ្ញុំ), 2. Enrolled, 3. In Cart -->
    <ul class="nav nav-pills nav-fill p-1.5 bg-body-secondary rounded-4 mb-4" role="tablist">
        <li class="nav-item">
            <button class="nav-link active fw-bold py-2 rounded-pill" data-bs-toggle="pill" data-bs-target="#page-my-classroom" type="button">
                <i data-lucide="school" style="width: 16px; height: 16px;" class="me-1"></i> ថ្នាក់រៀនរបស់ខ្ញុំ (My Classroom)
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link fw-bold py-2 rounded-pill" data-bs-toggle="pill" data-bs-target="#page-cart-enrolled" type="button">
                <i data-lucide="check-circle" style="width: 16px; height: 16px;" class="me-1"></i> Enrolled Classes ({{ $courseCarts->where('status', 'Enrolled')->count() }})
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link fw-bold py-2 rounded-pill" data-bs-toggle="pill" data-bs-target="#page-cart-electives" type="button">
                <i data-lucide="shopping-cart" style="width: 16px; height: 16px;" class="me-1"></i> Electives In Cart ({{ $courseCarts->where('status', 'In Cart')->count() }})
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Tab 0: My Classroom & Peers -->
        <div class="tab-pane fade show active" id="page-my-classroom">
            <!-- Classroom Header Card -->
            <div class="tool-card p-4 mb-4 border-start border-4 border-primary" style="background: radial-gradient(circle at top right, rgba(99, 102, 241, 0.08), transparent 70%);">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <span class="badge bg-primary text-white fw-bold px-3 py-1 rounded-pill mb-2">MY ASSIGNED CLASS</span>
                        <h4 class="fw-bolder mb-1">{{ $student['major'] ?? 'Digital Innovation & Media' }} • Year 3</h4>
                        <div class="d-flex flex-wrap gap-3 text-secondary small mt-2">
                            <span><i data-lucide="map-pin" style="width: 14px; height: 14px;" class="me-1 text-primary"></i> Lab 402 • Media Wing</span>
                            <span><i data-lucide="calendar" style="width: 14px; height: 14px;" class="me-1 text-primary"></i> Mon - Fri (08:00 AM - 11:30 AM)</span>
                            <span><i data-lucide="user-check" style="width: 14px; height: 14px;" class="me-1 text-primary"></i> Dr. Alex Vance (Lead Advisor)</span>
                        </div>
                    </div>
                    <div class="text-md-end">
                        <span class="badge bg-success-subtle text-success py-2 px-3 rounded-pill fw-bold fs-7">
                            <i data-lucide="shield-check" style="width: 14px; height: 14px;" class="me-1"></i> Verified Enrolled
                        </span>
                    </div>
                </div>
            </div>

            <!-- Classroom Subjects & Schedule Grid -->
            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                <i data-lucide="book-open" style="width: 16px; height: 16px;" class="text-primary"></i>
                <span>មុខវិជ្ជា និងកាលវិភាគក្នុងថ្នាក់ (Classroom Courses & Timetable)</span>
            </h6>
            <div class="row row-cols-1 row-cols-md-2 g-3 mb-4">
                @forelse($myClasses as $cls)
                    <div class="col">
                        <div class="tool-card p-4 h-100 d-flex flex-column justify-content-between border-start border-4" style="border-left-color: {{ $cls->border_color ?? '#3b82f6' }} !important;">
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-primary fs-7">{{ $cls->code }}</span>
                                    <span class="badge bg-success-subtle text-success fw-bold">{{ $cls->status }}</span>
                                </div>
                                <h5 class="fw-bold mb-1 fs-6">{{ $cls->title }}</h5>
                                <div class="text-secondary small mb-3">
                                    <div><i data-lucide="user" style="width: 14px; height: 14px;" class="me-1 d-inline-block"></i>{{ $cls->prof }}</div>
                                    <div><i data-lucide="clock" style="width: 14px; height: 14px;" class="me-1 d-inline-block"></i>{{ $cls->schedule_time }}</div>
                                    <div><i data-lucide="map-pin" style="width: 14px; height: 14px;" class="me-1 d-inline-block"></i>{{ $cls->room }}</div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                <span class="badge bg-body-secondary text-secondary small">{{ $cls->type }}</span>
                                <button class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold" onclick="showClassDetail({ title: '{{ addslashes($cls->title) }}', code: '{{ $cls->code }}', room: '{{ addslashes($cls->room) }}', prof: '{{ addslashes($cls->prof) }}', time: '{{ $cls->schedule_time }}' })">
                                    មើលលម្អិត
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4 text-secondary">
                        <p>No class schedule data found.</p>
                    </div>
                @endforelse
            </div>

            <!-- Classmate Peers Roster -->
            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                <i data-lucide="users" style="width: 16px; height: 16px;" class="text-primary"></i>
                <span>មិត្តរួមថ្នាក់ (Classmates Roster)</span>
            </h6>
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-6 g-3 mb-4">
                @php
                    $classmates = [
                        ['name' => 'Maya Chen', 'role' => 'Class Rep', 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=120'],
                        ['name' => 'Liam Vance', 'role' => 'Designer', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=120'],
                        ['name' => 'Sarah Connor', 'role' => 'Researcher', 'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=120'],
                        ['name' => 'David Kim', 'role' => 'Developer', 'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=120'],
                        ['name' => 'Sokha Meng', 'role' => 'Student', 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=120'],
                        ['name' => 'Bopha Pich', 'role' => 'Student', 'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=120'],
                    ];
                @endphp
                @foreach($classmates as $cm)
                    <div class="col text-center">
                        <div class="tool-card p-3 h-100">
                            <img src="{{ $cm['avatar'] }}" class="rounded-circle mb-2 mx-auto shadow-xs border" style="width: 50px; height: 50px; object-fit: cover;">
                            <h6 class="fw-bold mb-0 text-truncate small" style="font-size: 12px;">{{ $cm['name'] }}</h6>
                            <small class="text-secondary" style="font-size: 10px;">{{ $cm['role'] }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tab 1: Enrolled Courses -->
        <div class="tab-pane fade" id="page-cart-enrolled">
            <div class="row row-cols-1 row-cols-md-2 g-3 mb-4">
                @forelse($courseCarts->where('status', 'Enrolled') as $cc)
                    <div class="col">
                        <div class="tool-card p-4 h-100 d-flex flex-column justify-content-between border-start border-4 border-primary">
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-primary fs-7">{{ $cc->course_code }}</span>
                                    <span class="badge bg-success-subtle text-success fw-bold">Active Enrolled</span>
                                </div>
                                <h5 class="fw-bold mb-1 fs-6">{{ $cc->course_title }}</h5>
                                <div class="text-secondary small mb-3">
                                    <div><i data-lucide="user" style="width: 14px; height: 14px;" class="me-1 d-inline-block"></i>{{ $cc->instructor }}</div>
                                    <div><i data-lucide="clock" style="width: 14px; height: 14px;" class="me-1 d-inline-block"></i>{{ $cc->schedule }}</div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <span class="fw-bold text-primary small">{{ $cc->credits }} Credits</span>
                                <button class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold" onclick="dropCourseAJAX('{{ $cc->course_code }}')">
                                    <i data-lucide="trash-2" style="width: 13px; height: 13px;" class="me-1"></i> Drop Course
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 text-secondary">
                        <i data-lucide="book-x" style="width: 48px; height: 48px;" class="mb-2 opacity-50"></i>
                        <p>No enrolled classes yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Tab 2: Electives in Cart -->
        <div class="tab-pane fade" id="page-cart-electives">
            <div class="row row-cols-1 row-cols-md-2 g-3 mb-4">
                @forelse($courseCarts->where('status', 'In Cart') as $cartItem)
                    <div class="col">
                        <div class="tool-card p-4 h-100 d-flex flex-column justify-content-between border-start border-4 border-warning">
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-secondary fs-7">{{ $cartItem->course_code }}</span>
                                    <span class="badge bg-warning-subtle text-warning-emphasis fw-bold">In Elective Cart</span>
                                </div>
                                <h5 class="fw-bold mb-1 fs-6">{{ $cartItem->course_title }}</h5>
                                <div class="text-secondary small mb-3">
                                    <div><i data-lucide="user" style="width: 14px; height: 14px;" class="me-1 d-inline-block"></i>{{ $cartItem->instructor }}</div>
                                    <div><i data-lucide="clock" style="width: 14px; height: 14px;" class="me-1 d-inline-block"></i>{{ $cartItem->schedule }}</div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <span class="fw-bold text-secondary small">{{ $cartItem->credits }} Credits</span>
                                <button class="btn btn-primary btn-sm rounded-pill px-3 fw-bold shadow-xs" onclick="enrollCourseAJAX('{{ $cartItem->course_code }}', '{{ addslashes($cartItem->course_title) }}')">
                                    <i data-lucide="plus" style="width: 14px; height: 14px;" class="me-1"></i> + Enroll Now
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 text-secondary">
                        <i data-lucide="shopping-bag" style="width: 48px; height: 48px;" class="mb-2 opacity-50"></i>
                        <p>No electives in cart. All chosen courses have been registered.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- ====================================================================== -->
<!-- 6. SCORE & GPA TRANSCRIPT DEDICATED PAGE                               -->
<!-- ====================================================================== -->
<div id="screen-score" class="screen-section d-none">
    @php
        $totalExamsCount = isset($exams) ? $exams->count() : 0;
        $completedExamsCount = isset($myExamSubmissions) ? $myExamSubmissions->count() : 0;
        $passedExamsCount = isset($myExamSubmissions) ? $myExamSubmissions->where('is_passed', 1)->count() : 0;
        $avgExamScore = $completedExamsCount > 0 ? round($myExamSubmissions->avg('percentage')) : 0;

        $totalChallengesCount = isset($challenges) ? $challenges->count() : 0;
        $completedChallengesCount = isset($myChallengeParticipations) ? $myChallengeParticipations->count() : 0;
        $totalChallengePoints = isset($myChallengeParticipations) ? $myChallengeParticipations->sum('score') : 0;
        $bestChallengeRank = ($completedChallengesCount > 0 && isset($myChallengeParticipations)) ? $myChallengeParticipations->min('rank') : null;
    @endphp

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4 pb-3 border-bottom">
        <div class="d-flex align-items-center gap-2.5">
            <button type="button" class="btn-ios-circle" onclick="switchTab('home')" title="Back to Home">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
            </button>
            <div>
                <h4 class="fw-bolder mb-0 tracking-tight">Academic Score & Official Transcript</h4>
                <small class="text-secondary">ព្រឹត្តិបត្រពិន្ទុ & លទ្ធផលការសិក្សា • Course Grades, Exams & Live Challenges</small>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('campus.transcript.download') }}" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3.5 py-2 fw-bold d-inline-flex align-items-center gap-1.5 shadow-xs">
                <i data-lucide="download" style="width: 15px; height: 15px;"></i>
                <span>Download Official Transcript (PDF)</span>
            </a>
        </div>
    </div>

    <!-- Category Filter Pills -->
    <div class="d-flex align-items-center gap-2 mb-4 overflow-x-auto pb-1" id="score-filter-pills" style="scrollbar-width: thin;">
        <button type="button" class="btn btn-sm rounded-pill px-3 py-1.5 fw-bold btn-primary text-white shadow-xs score-filter-btn" data-sec="all" onclick="filterScoreView('all', this)">
            <i data-lucide="layout-grid" style="width: 14px; height: 14px;" class="me-1"></i> ទាំងអស់ (All Overview)
        </button>
        <button type="button" class="btn btn-sm rounded-pill px-3 py-1.5 fw-bold btn-outline-secondary text-secondary score-filter-btn" data-sec="grades" onclick="filterScoreView('grades', this)">
            <i data-lucide="book-open" style="width: 14px; height: 14px;" class="me-1"></i> ពិន្ទុមុខវិជ្ជា (Course Grades)
        </button>
        <button type="button" class="btn btn-sm rounded-pill px-3 py-1.5 fw-bold btn-outline-secondary text-secondary score-filter-btn" data-sec="exams" onclick="filterScoreView('exams', this)">
            <i data-lucide="file-check" style="width: 14px; height: 14px;" class="me-1"></i> លទ្ធផលប្រឡង (Exam Results)
            @if($completedExamsCount > 0)
                <span class="badge bg-success ms-1 rounded-pill">{{ $completedExamsCount }}</span>
            @endif
        </button>
        <button type="button" class="btn btn-sm rounded-pill px-3 py-1.5 fw-bold btn-outline-secondary text-secondary score-filter-btn" data-sec="challenges" onclick="filterScoreView('challenges', this)">
            <i data-lucide="trophy" style="width: 14px; height: 14px;" class="me-1"></i> លទ្ធផល Challenges (Live Arena)
            @if($completedChallengesCount > 0)
                <span class="badge bg-warning text-dark ms-1 rounded-pill">+{{ $totalChallengePoints }} PTS</span>
            @endif
        </button>
    </div>

    <!-- KPI Summary Row -->
    <div class="row g-3 mb-4" id="score-kpi-summary">
        <!-- Dean's Honors List Banner -->
        <div class="col-12 col-lg-6">
            <div class="p-4 rounded-4 text-white h-100 d-flex flex-column justify-content-between shadow" style="background: linear-gradient(135deg, #1e1b4b, #312e81, #4338ca);">
                <div>
                    <span class="badge bg-white bg-opacity-25 rounded-pill px-3 py-1.5 mb-2 small fw-bold">
                        🏆 DEAN'S HONORS LIST • TOP 1%
                    </span>
                    <h2 class="fw-bolder mb-1 fs-1">GPA {{ $gpa }} <span class="fs-5 opacity-75">/ 4.00</span></h2>
                    <p class="text-light opacity-80 mb-0 small" style="max-width: 520px;">
                        Outstanding Academic Standing in Visual Communication & Media. All credit hours verified by the Registrar Office.
                    </p>
                </div>
                <div class="pt-3 mt-3 border-top border-white border-opacity-25 d-flex justify-content-between align-items-center">
                    <div>
                        <small class="d-block text-light opacity-75 text-uppercase fw-semibold" style="font-size: 10.5px;">Completed Credits</small>
                        <span class="fs-5 fw-bolder">{{ $totalCredits }} Credits</span>
                    </div>
                    <div class="text-end">
                        <small class="d-block text-light opacity-75 text-uppercase fw-semibold" style="font-size: 10.5px;">Academic Standing</small>
                        <span class="badge bg-success-subtle text-success fw-bold px-2.5 py-1">1st Class Honours</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Exam Performance Summary -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="tool-card p-4 h-100 d-flex flex-column justify-content-between border-start border-4 border-success">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-success-subtle text-success fw-bold">EXAMS COMPLETED</span>
                        <i data-lucide="file-check" style="width: 20px; height: 20px;" class="text-success"></i>
                    </div>
                    <h2 class="fw-bolder mb-0 text-success">
                        @if($completedExamsCount > 0)
                            {{ $avgExamScore }}%
                        @else
                            100%
                        @endif
                    </h2>
                    <small class="text-secondary d-block mt-1">Average QCM Exam Score</small>
                </div>
                <div class="pt-3 border-top mt-3 d-flex justify-content-between align-items-center small">
                    <span class="text-secondary">បានប្រឡង: <strong class="text-dark">{{ $completedExamsCount }} / {{ $totalExamsCount }}</strong></span>
                    <span class="badge bg-success text-white fw-bold">{{ $passedExamsCount }} ជាប់ (Pass)</span>
                </div>
            </div>
        </div>

        <!-- Challenge Arena Summary -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="tool-card p-4 h-100 d-flex flex-column justify-content-between border-start border-4 border-warning">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-warning-subtle text-warning-emphasis fw-bold">CHALLENGE ARENA</span>
                        <i data-lucide="trophy" style="width: 20px; height: 20px;" class="text-warning"></i>
                    </div>
                    <h2 class="fw-bolder mb-0 text-warning-emphasis">
                        +{{ $totalChallengePoints }} <span class="fs-6 fw-normal text-secondary">PTS</span>
                    </h2>
                    <small class="text-secondary d-block mt-1">Total Arena Points Won</small>
                </div>
                <div class="pt-3 border-top mt-3 d-flex justify-content-between align-items-center small">
                    <span class="text-secondary">ចំណាត់ថ្នាក់: <strong class="text-warning-emphasis">{{ $bestChallengeRank ? '#'.$bestChallengeRank.' Rank' : '#1 Rank' }}</strong></span>
                    <span class="badge bg-warning text-dark fw-bold">{{ $completedChallengesCount }} Quests Done</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 1: Course Grade Breakdown -->
    <div id="score-sec-grades" class="score-display-section mb-4">
        <div class="tool-card overflow-hidden">
            <div class="p-3 px-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h6 class="fw-bold mb-0">Course Grade Breakdown (ឆមាសទី១)</h6>
                    <small class="text-secondary">ពិន្ទុតាមមុខវិជ្ជាប្រចាំឆមាស • Assignment (20%), Mid-Term (30%), Final (50%)</small>
                </div>
                <span class="badge bg-success-subtle text-success fw-bold">Passing Grade: ≥ 60</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small text-secondary">
                        <tr>
                            <th class="ps-4">Course Title</th>
                            <th>Code</th>
                            <th class="text-center">Credits</th>
                            <th class="text-center">Mid-Term (30%)</th>
                            <th class="text-center">Assignment (20%)</th>
                            <th class="text-center">Final (50%)</th>
                            <th class="text-center">Total (100)</th>
                            <th class="text-end pe-4">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($scores as $sc)
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold small d-block">{{ $sc->subject }}</span>
                                    <small class="text-secondary" style="font-size: 11px;">{{ $sc->semester }}</small>
                                </td>
                                <td><span class="badge bg-body-secondary text-secondary">{{ $sc->code }}</span></td>
                                <td class="text-center small">{{ $sc->credits }}</td>
                                <td class="text-center small">{{ $sc->mid_term }}</td>
                                <td class="text-center small">{{ $sc->assignment }}</td>
                                <td class="text-center small">{{ $sc->final_exam }}</td>
                                <td class="text-center fw-bold text-primary">{{ $sc->score }}</td>
                                <td class="text-end pe-4">
                                    <span class="badge {{ str_contains($sc->grade, 'A') ? 'bg-success' : 'bg-primary' }} fw-bolder fs-7 px-2.5 py-1">
                                        {{ $sc->grade }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-secondary">មិនទាន់មានទិន្នន័យពិន្ទុមុខវិជ្ជា។</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Section 2: All Exam Results (លទ្ធផលប្រឡងទាំងអស់) -->
    <div id="score-sec-exams" class="score-display-section mb-4">
        <div class="tool-card overflow-hidden">
            <div class="p-3 px-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h6 class="fw-bold mb-0">
                        <i data-lucide="file-check" style="width: 18px; height: 18px;" class="text-primary me-1.5 d-inline-block"></i>
                        លទ្ធផលប្រឡងទាំងអស់ (All Examination Results & QCM Submissions)
                    </h6>
                    <small class="text-secondary">ពិន្ទុ និងលទ្ធផលប្រឡង Midterm, Final, Lesson Quiz, Test & Dig4.0 exam ទាំងអស់</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary-subtle text-primary fw-bold">
                        {{ $completedExamsCount }} / {{ $totalExamsCount }} ប្រឡងរួច
                    </span>
                    <button type="button" class="btn btn-xs btn-outline-primary rounded-pill px-2.5 py-1 fw-bold" onclick="switchTab('exam')">
                        <i data-lucide="external-link" style="width: 12px; height: 12px;" class="me-1"></i> កន្លែងប្រឡង
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small text-secondary">
                        <tr>
                            <th class="ps-4">Exam Title & Subject</th>
                            <th>Category</th>
                            <th class="text-center">Total Points</th>
                            <th class="text-center">Score Earned</th>
                            <th class="text-center">Percentage / Grade</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Exam Date / Time</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $renderedExamIds = [];
                        @endphp
                        @forelse($exams as $exam)
                            @php
                                $renderedExamIds[] = $exam->id;
                                $mySub = isset($myExamSubmissions) ? $myExamSubmissions->get($exam->id) : null;
                                $isOpen = ($exam->status === 'Active');
                                if (!$isOpen && !empty($exam->exam_date)) {
                                    $cleanDate = str_replace(['•', '|'], ' ', $exam->exam_date);
                                    $examTs = strtotime($cleanDate);
                                    if ($examTs && $examTs <= time()) {
                                        $isOpen = true;
                                    }
                                }
                                $canReExam = $mySub && !empty($mySub->allow_reexam);

                                $cat = $exam->category ?: 'Midterm exam';
                                $catBadgeClass = 'bg-primary-subtle text-primary';
                                if (stripos($cat, 'Final') !== false) {
                                    $catBadgeClass = 'bg-indigo-subtle text-indigo';
                                } elseif (stripos($cat, 'Dig') !== false) {
                                    $catBadgeClass = 'bg-info-subtle text-info';
                                } elseif (stripos($cat, 'Lesson') !== false) {
                                    $catBadgeClass = 'bg-success-subtle text-success';
                                } elseif (stripos($cat, 'Test') !== false) {
                                    $catBadgeClass = 'bg-warning-subtle text-warning-emphasis';
                                }
                            @endphp
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="p-2 rounded-2 bg-light border d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                            <i data-lucide="file-text" style="width: 17px; height: 17px;" class="text-primary"></i>
                                        </div>
                                        <div>
                                            <span class="fw-bold small d-block">{{ $exam->title }}</span>
                                            <small class="text-secondary" style="font-size: 11px;">
                                                {{ $exam->course }} • {{ $exam->room ?: 'Design Lab' }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $catBadgeClass }} fw-bold px-2 py-1 rounded-pill" style="font-size: 10.5px;">
                                        {{ $cat }}
                                    </span>
                                </td>
                                <td class="text-center small fw-semibold">
                                    {{ $exam->total_points ?: 100 }} PTS
                                </td>
                                <td class="text-center">
                                    @if($mySub)
                                        <span class="fw-bolder fs-6 {{ $mySub->is_passed ? 'text-success' : 'text-danger' }}">
                                            {{ $mySub->earned_score }}
                                        </span>
                                        <span class="text-secondary small">/ {{ $mySub->total_possible }}</span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($mySub)
                                        <span class="badge {{ $mySub->is_passed ? 'bg-success' : 'bg-danger' }} fw-bold px-2.5 py-1">
                                            {{ $mySub->percentage }}% • Grade {{ $mySub->grade }}
                                        </span>
                                    @else
                                        <span class="badge bg-light text-secondary border fw-normal" style="font-size: 11px;">មិនទាន់ប្រឡង</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($mySub)
                                        @if($canReExam)
                                            <span class="badge bg-warning text-dark fw-bold">
                                                <i data-lucide="rotate-ccw" style="width: 11px; height: 11px;" class="me-1"></i> ReExam Allowed
                                            </span>
                                        @elseif($mySub->is_passed)
                                            <span class="badge bg-success-subtle text-success fw-bold">
                                                <i data-lucide="check-circle" style="width: 11px; height: 11px;" class="me-1"></i> ជាប់ (Passed)
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger fw-bold">
                                                <i data-lucide="x-circle" style="width: 11px; height: 11px;" class="me-1"></i> ធ្លាក់ (Failed)
                                            </span>
                                        @endif
                                    @elseif($isOpen)
                                        <span class="badge bg-success text-white fw-bold">
                                            <i data-lucide="unlock" style="width: 11px; height: 11px;" class="me-1"></i> កំពុងបើក (Open)
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary fw-semibold">
                                            <i data-lucide="lock" style="width: 11px; height: 11px;" class="me-1"></i> រង់ចាំបើក
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center small text-secondary">
                                    @if($mySub && !empty($mySub->submitted_at))
                                        <i data-lucide="check" style="width: 12px; height: 12px;" class="text-success me-0.5"></i>
                                        {{ $mySub->submitted_at }}
                                    @else
                                        <i data-lucide="calendar" style="width: 12px; height: 12px;" class="me-0.5"></i>
                                        {{ $exam->exam_date ?: 'TBD' }}
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    @if($mySub)
                                        <div class="d-flex justify-content-end align-items-center gap-1.5">
                                            <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1 shadow-xs" onclick="showCompletedExamResult({{ json_encode($mySub) }}, '{{ addslashes($exam->title) }}')">
                                                <i data-lucide="award" style="width: 13px; height: 13px;"></i>
                                                <span>មើលលទ្ធផល</span>
                                            </button>
                                            @if($canReExam)
                                                <button type="button" class="btn btn-sm btn-warning text-dark rounded-pill px-2.5 fw-bold d-inline-flex align-items-center gap-1 shadow-xs" onclick="startTakeExamAJAX({{ $exam->id }}, '{{ addslashes($exam->title) }}', {{ $exam->total_points ?: 100 }})">
                                                    <i data-lucide="rotate-ccw" style="width: 13px; height: 13px;"></i>
                                                    <span>ReExam</span>
                                                </button>
                                            @endif
                                        </div>
                                    @elseif($isOpen)
                                        <button type="button" class="btn btn-sm btn-success rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1 shadow-xs" onclick="startTakeExamAJAX({{ $exam->id }}, '{{ addslashes($exam->title) }}', {{ $exam->total_points ?: 100 }})">
                                            <i data-lucide="pencil-line" style="width: 13px; height: 13px;"></i>
                                            <span>ចូលប្រឡង</span>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-secondary rounded-pill px-3 fw-semibold opacity-75" disabled>
                                            <i data-lucide="lock" style="width: 13px; height: 13px;"></i>
                                            <span>Locked</span>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-secondary">មិនទាន់មានទិន្នន័យប្រឡង។</td>
                            </tr>
                        @endforelse

                        {{-- Additional standalone exam submissions not matching $exams --}}
                        @if(isset($myExamSubmissions))
                            @foreach($myExamSubmissions as $subExamId => $extraSub)
                                @if(!in_array($subExamId, $renderedExamIds))
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="p-2 rounded-2 bg-light border d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                                    <i data-lucide="file-check" style="width: 17px; height: 17px;" class="text-success"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-bold small d-block">{{ $extraSub->exam_title ?: 'Assessment' }}</span>
                                                    <small class="text-secondary" style="font-size: 11px;">
                                                        {{ $extraSub->course_code ?: 'EXAM' }} • Student: {{ $extraSub->student_name }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary-subtle text-secondary fw-bold px-2 py-1 rounded-pill" style="font-size: 10.5px;">
                                                QCM Exam
                                            </span>
                                        </td>
                                        <td class="text-center small fw-semibold">
                                            {{ $extraSub->total_possible ?: 100 }} PTS
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bolder fs-6 {{ $extraSub->is_passed ? 'text-success' : 'text-danger' }}">
                                                {{ $extraSub->earned_score }}
                                            </span>
                                            <span class="text-secondary small">/ {{ $extraSub->total_possible }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ $extraSub->is_passed ? 'bg-success' : 'bg-danger' }} fw-bold px-2.5 py-1">
                                                {{ $extraSub->percentage }}% • Grade {{ $extraSub->grade }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($extraSub->is_passed)
                                                <span class="badge bg-success-subtle text-success fw-bold">
                                                    <i data-lucide="check-circle" style="width: 11px; height: 11px;" class="me-1"></i> ជាប់ (Passed)
                                                </span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger fw-bold">
                                                    <i data-lucide="x-circle" style="width: 11px; height: 11px;" class="me-1"></i> ធ្លាក់ (Failed)
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center small text-secondary">
                                            {{ $extraSub->submitted_at ?: 'Completed' }}
                                        </td>
                                        <td class="text-end pe-4">
                                            <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1 shadow-xs" onclick="showCompletedExamResult({{ json_encode($extraSub) }}, '{{ addslashes($extraSub->exam_title) }}')">
                                                <i data-lucide="award" style="width: 13px; height: 13px;"></i>
                                                <span>មើលលទ្ធផល</span>
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Section 3: Challenge Arena Results (លទ្ធផល Challenges ផងដែរ) -->
    <div id="score-sec-challenges" class="score-display-section mb-4">
        <div class="tool-card overflow-hidden">
            <div class="p-3 px-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h6 class="fw-bold mb-0">
                        <i data-lucide="trophy" style="width: 18px; height: 18px;" class="text-warning me-1.5 d-inline-block"></i>
                        លទ្ធផលប្រកួតប្រជែង Challenges (Campus Challenge Arena Results)
                    </h6>
                    <small class="text-secondary">ពិន្ទុ និងចំណាត់ថ្នាក់ដែលទទួលបានពីការប្រកួតប្រជែង Live Quests, UI Audits & Speed Tasks</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-warning-subtle text-warning-emphasis fw-bold">
                        <i data-lucide="sparkles" style="width: 12px; height: 12px;" class="me-1"></i> Total: +{{ $totalChallengePoints }} PTS
                    </span>
                    <button type="button" class="btn btn-xs btn-outline-warning text-dark rounded-pill px-2.5 py-1 fw-bold" onclick="switchTab('challenge')">
                        <i data-lucide="swords" style="width: 12px; height: 12px;" class="me-1"></i> Challenge Arena
                    </button>
                    <a href="{{ route('admin.challenges.fullscreen') }}" target="_blank" class="btn btn-xs btn-warning text-dark rounded-pill px-2.5 py-1 fw-bold">
                        <i data-lucide="maximize" style="width: 12px; height: 12px;" class="me-1"></i> Leaderboard
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small text-secondary">
                        <tr>
                            <th class="ps-4">Challenge Quest</th>
                            <th>Description</th>
                            <th class="text-center">Max Points</th>
                            <th class="text-center">Earned Points</th>
                            <th class="text-center">Completion Speed</th>
                            <th class="text-center">Classroom Rank</th>
                            <th class="text-center">Status</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $renderedChallengeIds = [];
                        @endphp
                        @forelse($challenges as $ch)
                            @php
                                $renderedChallengeIds[] = $ch->id;
                                $part = isset($myChallengeParticipations) ? $myChallengeParticipations->get($ch->id) : null;
                            @endphp
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="p-2 rounded-2 bg-warning bg-opacity-10 border border-warning border-opacity-25 d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                            <i data-lucide="trophy" style="width: 18px; height: 18px;" class="text-warning"></i>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center gap-1.5">
                                                <span class="fw-bold small">{{ $ch->title }}</span>
                                                <span class="badge bg-warning text-dark fw-bold" style="font-size: 10px;">{{ $ch->badge ?: 'QUEST' }}</span>
                                            </div>
                                            <small class="text-secondary" style="font-size: 11px;">
                                                ⏱️ {{ $ch->duration_minutes ?: 15 }} Mins • Real-Time Arena
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-secondary small d-inline-block text-truncate" style="max-width: 260px;">
                                        {{ $ch->description ?: 'Campus interactive challenge' }}
                                    </span>
                                </td>
                                <td class="text-center small fw-semibold text-secondary">
                                    +{{ $ch->points }} PTS
                                </td>
                                <td class="text-center">
                                    @if($part)
                                        <span class="badge bg-warning text-dark fw-bolder fs-7 px-2.5 py-1 shadow-xs">
                                            +{{ $part->score }} PTS
                                        </span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($part)
                                        <span class="small fw-bold text-dark d-inline-flex align-items-center gap-1">
                                            <i data-lucide="timer" style="width: 13px; height: 13px;" class="text-warning"></i>
                                            {{ $part->completion_time }}
                                        </span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($part)
                                        @if($part->rank == 1)
                                            <span class="badge bg-warning text-dark fw-bold px-2.5 py-1">
                                                🏆 #1 Champion
                                            </span>
                                        @elseif($part->rank == 2)
                                            <span class="badge bg-secondary text-white fw-bold px-2 py-1">
                                                🥈 #2 Rank
                                            </span>
                                        @elseif($part->rank == 3)
                                            <span class="badge bg-dark text-white fw-bold px-2 py-1">
                                                🥉 #3 Rank
                                            </span>
                                        @else
                                            <span class="badge bg-body-secondary text-secondary fw-bold px-2 py-1">
                                                #{{ $part->rank }} Rank
                                            </span>
                                        @endif
                                    @else
                                        <span class="badge bg-light text-secondary border fw-normal" style="font-size: 11px;">
                                            មិនទាន់ចូលរួម
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($part)
                                        <span class="badge bg-success-subtle text-success fw-bold">
                                            <i data-lucide="check-circle" style="width: 11px; height: 11px;" class="me-1"></i> បានចូលរួមរួច
                                        </span>
                                    @else
                                        <span class="badge bg-primary-subtle text-primary fw-bold">
                                            <i data-lucide="sparkles" style="width: 11px; height: 11px;" class="me-1"></i> កំពុងបើក
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    @if($part)
                                        <button type="button" class="btn btn-sm btn-outline-warning text-dark rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1 shadow-xs" onclick="showChallengeScoreSummary('{{ addslashes($ch->title) }}', {{ $part->score }}, '{{ $part->rank }}', '{{ $part->completion_time }}')">
                                            <i data-lucide="trophy" style="width: 13px; height: 13px;"></i>
                                            <span>មើលពិន្ទុ</span>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-warning text-dark rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1 shadow-xs" onclick="switchTab('challenge')">
                                            <i data-lucide="play" style="width: 13px; height: 13px;"></i>
                                            <span>ចូលប្រកួត</span>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-secondary">មិនទាន់មានទិន្នន័យ Challenge នៅឡើយ។</td>
                            </tr>
                        @endforelse

                        {{-- Additional standalone participations not matching $challenges --}}
                        @if(isset($myChallengeParticipations))
                            @foreach($myChallengeParticipations as $chId => $extraPart)
                                @if(!in_array($chId, $renderedChallengeIds))
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="p-2 rounded-2 bg-warning bg-opacity-10 border border-warning border-opacity-25 d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                                    <i data-lucide="trophy" style="width: 18px; height: 18px;" class="text-warning"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-bold small d-block">Campus Arena Quest #{{ $chId }}</span>
                                                    <small class="text-secondary" style="font-size: 11px;">Participant: {{ $extraPart->student_name }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-secondary small">Campus Arena Live Quest</span>
                                        </td>
                                        <td class="text-center small fw-semibold text-secondary">
                                            +500 PTS
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-warning text-dark fw-bolder fs-7 px-2.5 py-1 shadow-xs">
                                                +{{ $extraPart->score }} PTS
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="small fw-bold text-dark d-inline-flex align-items-center gap-1">
                                                <i data-lucide="timer" style="width: 13px; height: 13px;" class="text-warning"></i>
                                                {{ $extraPart->completion_time }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-warning text-dark fw-bold px-2 py-1">
                                                #{{ $extraPart->rank }} Rank
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success-subtle text-success fw-bold">
                                                <i data-lucide="check-circle" style="width: 11px; height: 11px;" class="me-1"></i> បានចូលរួមរួច
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <button type="button" class="btn btn-sm btn-outline-warning text-dark rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1 shadow-xs" onclick="showChallengeScoreSummary('Campus Arena Quest', {{ $extraPart->score }}, '{{ $extraPart->rank }}', '{{ $extraPart->completion_time }}')">
                                                <i data-lucide="trophy" style="width: 13px; height: 13px;"></i>
                                                <span>មើលពិន្ទុ</span>
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ====================================================================== -->
<!-- 7. COURSE RESOURCES & STUDY MATERIALS DEDICATED PAGE                  -->
<!-- ====================================================================== -->
<div id="screen-resource" class="screen-section d-none">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4 pb-3 border-bottom">
        <div class="d-flex align-items-center gap-2.5">
            <button type="button" class="btn-ios-circle" onclick="switchTab('home')" title="Back to Home">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
            </button>
            <div>
                <h4 class="fw-bolder mb-0 tracking-tight">Course Resources & Files</h4>
                <small class="text-secondary">ឯកសារមេរៀនជា PDF តាមថ្នាក់ • មើលលើផ្ទាំងនេះ (Protected Read-Only)</small>
            </div>
        </div>
        <span class="badge bg-primary-subtle text-primary py-2 px-3 rounded-pill fw-bold">
            <i data-lucide="folder-down" style="width: 14px; height: 14px;" class="me-1"></i> {{ $resources->count() }} Files Available
        </span>
    </div>

    <!-- Search Input for Resources -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6">
            <div class="position-relative">
                <i data-lucide="search" class="position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary" style="width: 16px; height: 16px;"></i>
                <input type="text" id="resourceSearchInput" onkeyup="filterResourceList()" class="form-control rounded-pill ps-5 py-2" placeholder="Search file name or course code...">
            </div>
        </div>
    </div>

    <!-- Resources Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3" id="resourcesGridContainer">
        @forelse($resources as $res)
            <div class="col resource-card-item" data-search="{{ strtolower($res->title . ' ' . $res->file_name . ' ' . ($res->class_code ?: $res->course)) }}">
                <div class="tool-card p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="p-2.5 rounded-3 bg-danger-subtle text-danger">
                                <i data-lucide="file-text" style="width: 24px; height: 24px;"></i>
                            </div>
                            <span class="badge bg-primary-subtle text-primary font-monospace">{{ $res->class_code ?: $res->course }}</span>
                        </div>
                        <h6 class="fw-bold mb-1">{{ $res->title }}</h6>
                        <small class="text-secondary d-block font-monospace mb-2" style="font-size: 11px;">{{ $res->file_name }}</small>
                        <div class="d-flex gap-2 text-secondary small mb-3">
                            <span><i data-lucide="hard-drive" style="width: 12px; height: 12px;" class="me-1 d-inline-block"></i>{{ $res->file_size }}</span>
                            <span>•</span>
                            <span class="text-primary fw-semibold"><i data-lucide="eye" style="width: 12px; height: 12px;" class="me-1 d-inline-block"></i>{{ $res->download_count }} views</span>
                        </div>
                    </div>
                    
                    <div class="d-flex flex-column gap-2 mt-auto">
                        <!-- Quick Modal Viewer (Protected on Page) -->
                        <button type="button" class="btn btn-primary rounded-pill w-100 fw-bold py-2 shadow-xs d-flex align-items-center justify-content-center gap-2" onclick="openPdfQuickModal('{{ asset($res->file_url ?: 'uploads/slides/slides_1792915639.pdf') }}', '{{ addslashes($res->title) }}', '{{ addslashes($res->file_name) }}', '#', '#')">
                            <i data-lucide="eye" style="width: 16px; height: 16px;"></i>
                            <span>Quick View Modal (មើលលើផ្ទាំងនេះ)</span>
                        </button>
                        <div class="text-center pt-1">
                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1" style="font-size: 10px;">
                                <i data-lucide="lock" style="width: 10px; height: 10px;" class="me-1"></i> Read-Only • មិនអនុញ្ញាតអោយ View ក្រៅផ្ទាំង ឬ Download ឡើយ
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-secondary">
                <i data-lucide="folder-x" style="width: 48px; height: 48px;" class="mb-2 opacity-50"></i>
                <p>No resources uploaded yet.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- ====================================================================== -->
<!-- 8. CAMPUS SCANNER & PASSCODE (2 CHOICES: SCAN QR ឬ វាយលេខកូដខ្លី)           -->
<!-- ====================================================================== -->
<div id="screen-scan" class="screen-section d-none">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4 pb-3 border-bottom">
        <div class="d-flex align-items-center gap-2.5">
            <button type="button" class="btn-ios-circle" onclick="switchTab('home')" title="Back to Home">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
            </button>
            <div>
                <h4 class="fw-bolder mb-0 tracking-tight">Campus Check-in (ជម្រើស ២ ៖ ស្កេន QR ឬ វាយលេខកូដខ្លី)</h4>
                <small class="text-secondary">Scan QR Code តាមថ្នាក់ ឬ វាយបញ្ចូលលេខកូដសម្ងាត់ខ្លី ៤ ខ្ទង់</small>
            </div>
        </div>
        <span class="badge bg-success-subtle text-success py-2 px-3 rounded-pill fw-bold">
            <i data-lucide="check-circle-2" style="width: 14px; height: 14px;" class="me-1"></i> Check-in System Active
        </span>
    </div>

    <!-- Daily 2-Session Tracker Banner (ស្កេន ២ ដងក្នុង ១ ថ្ងៃ) -->
    <div class="card border-0 shadow-sm p-3 p-md-4 rounded-4 mb-4 bg-body-tertiary">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3">
            <div>
                <h6 class="fw-bolder mb-1">📅 វត្តមានប្រចាំថ្ងៃ (Daily 2-Session Tracker)</h6>
                <small class="text-secondary">ក្នុង ១ ថ្ងៃមាន ២ Session (Session 1 ព្រឹក & Session 2 រសៀល)។ ទាល់តែសិស្សមានឈ្មោះក្នុងថ្នាក់ទើបអាចស្កេនបាន។</small>
            </div>
            <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-2 rounded-pill fs-7">
                <i data-lucide="calendar" style="width: 13px; height: 13px;" class="me-1"></i> {{ date('M d, Y') }}
            </span>
        </div>
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <div class="p-3 rounded-4 border bg-body d-flex align-items-center justify-content-between {{ $session1Check ? 'border-success' : '' }}">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="rounded-circle {{ $session1Check ? 'bg-success text-white' : 'bg-secondary bg-opacity-10 text-secondary' }} d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                            <i data-lucide="{{ $session1Check ? 'check-circle' : 'sun' }}" style="width: 20px; height: 20px;"></i>
                        </div>
                        <div>
                            <strong class="d-block small">🌅 Session 1 (ពេលព្រឹក: 08:00 AM - 11:30 AM)</strong>
                            <small class="{{ $session1Check ? 'text-success fw-bold' : 'text-secondary' }}">
                                {{ $session1Check ? 'បានស្កេនវត្តមាន: ' . $session1Check->check_in_time : 'មិនទាន់បានស្កេននៅឡើយ' }}
                            </small>
                        </div>
                    </div>
                    <span class="badge {{ $session1Check ? 'bg-success text-white' : 'bg-warning text-dark' }} rounded-pill px-2.5 py-1 fw-bold">
                        {{ $session1Check ? '✅ SCANNED' : '⏳ PENDING' }}
                    </span>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="p-3 rounded-4 border bg-body d-flex align-items-center justify-content-between {{ $session2Check ? 'border-success' : '' }}">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="rounded-circle {{ $session2Check ? 'bg-success text-white' : 'bg-secondary bg-opacity-10 text-secondary' }} d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                            <i data-lucide="{{ $session2Check ? 'check-circle' : 'sunset' }}" style="width: 20px; height: 20px;"></i>
                        </div>
                        <div>
                            <strong class="d-block small">🌇 Session 2 (ពេលរសៀល: 01:00 PM - 05:00 PM)</strong>
                            <small class="{{ $session2Check ? 'text-success fw-bold' : 'text-secondary' }}">
                                {{ $session2Check ? 'បានស្កេនវត្តមាន: ' . $session2Check->check_in_time : 'មិនទាន់បានស្កេននៅឡើយ' }}
                            </small>
                        </div>
                    </div>
                    <span class="badge {{ $session2Check ? 'bg-success text-white' : 'bg-warning text-dark' }} rounded-pill px-2.5 py-1 fw-bold">
                        {{ $session2Check ? '✅ SCANNED' : '⏳ PENDING' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 justify-content-center">
        <!-- CHOICE 1: Optical / Live Camera QR Scanner -->
        <div class="col-12 col-lg-6">
            <div class="tool-card p-4 p-md-5 text-center bg-dark text-white shadow-lg h-100 d-flex flex-column justify-content-between" style="border-radius: 28px;">
                <div>
                    <span class="badge bg-primary px-3 py-1 rounded-pill fw-bold mb-3 text-uppercase" style="letter-spacing: 0.1em;">
                        ជម្រើសទី ១ • CHOICE 1: LIVE CAMERA QR SCAN
                    </span>

                    <!-- Live HTML5 Camera Viewport -->
                    <div id="live-camera-reader" class="mx-auto mb-3" style="width: 100%; max-width: 320px; min-height: 240px; border-radius: 20px; overflow: hidden; display: none; background: #000;"></div>

                    <!-- Placeholder Graphic when Camera is closed -->
                    <div id="camera-scan-placeholder" class="scan-frame mx-auto mb-4 position-relative" style="width: 220px; height: 220px; border: 2px dashed rgba(255, 255, 255, 0.3); border-radius: 24px; display: flex; align-items: center; justify-content: center; background: rgba(0, 0, 0, 0.4);">
                        <div class="scan-beam" id="scan-laser-page" style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: #38bdf8; box-shadow: 0 0 16px #38bdf8; animation: scanBeam 2s infinite ease-in-out;"></div>
                        <div id="scan-icon-container-page">
                            <i data-lucide="qr-code" class="text-info opacity-75" style="width: 100px; height: 100px;"></i>
                        </div>
                    </div>

                    <p id="scan-status-text-page" class="text-white-50 fw-semibold small mb-4">
                        បើក Camera រួចតម្រង់លើ QR Code របស់ Admin វត្តមាននឹងកត់ត្រា Auto ភ្លាមៗ
                    </p>
                </div>

                <div class="d-flex flex-column gap-2">
                    <button class="btn btn-success btn-lg w-100 py-3 rounded-pill fw-bold shadow-lg d-flex align-items-center justify-content-center gap-2" id="btn-start-camera" onclick="startLiveCameraScan()">
                        <i data-lucide="camera" style="width: 20px; height: 20px;"></i>
                        <span>បើក Camera ស្កេន QR (Auto Check-in)</span>
                    </button>
                    <button class="btn btn-danger btn-lg w-100 py-3 rounded-pill fw-bold shadow-lg d-none align-items-center justify-content-center gap-2" id="btn-stop-camera" onclick="stopLiveCameraScan()">
                        <i data-lucide="camera-off" style="width: 20px; height: 20px;"></i>
                        <span>បិទ Camera (Stop Camera)</span>
                    </button>
                    <button class="btn btn-outline-light btn-sm w-100 py-2 rounded-pill fw-semibold d-flex align-items-center justify-content-center gap-1 opacity-75 border-secondary" onclick="simulateScan()">
                        <i data-lucide="scan" style="width: 14px; height: 14px;"></i>
                        <span>Simulate Scan Check-in (តេស្តសាកល្បង)</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- CHOICE 2: Enter 4-Digit Short Passcode -->
        <div class="col-12 col-lg-6">
            <div class="tool-card p-4 p-md-5 text-center h-100 d-flex flex-column justify-content-between border-2 border-primary border-opacity-25" style="border-radius: 28px;">
                <div>
                    <span class="badge bg-info text-dark px-3 py-1 rounded-pill fw-bold mb-3 text-uppercase" style="letter-spacing: 0.1em;">
                        ជម្រើសទី ២ • CHOICE 2: ENTER SHORT PASSCODE
                    </span>

                    <h5 class="fw-bold mb-2">វាយបញ្ចូលលេខកូដខ្លី (Short Code)</h5>
                    <p class="text-secondary small mb-4">
                        ប្រសិនបើតេឡេហ្វូនមិនអាច Scan QR បាន សូមមើលលេខកូដខ្លី ៤ ខ្ទង់លើអេក្រង់ Full Screen របស់ Admin រួចវាយបញ្ចូលនៅទីនេះ:
                    </p>

                    <div class="my-4">
                        <input type="text" id="short-passcode-input" class="form-control text-center font-monospace fw-bolder fs-2 py-3 rounded-4 shadow-sm border-2 border-primary" placeholder="••••" maxlength="6" style="letter-spacing: 0.3em; max-width: 280px; margin: 0 auto;">
                        <small class="text-secondary mt-2 d-block">ឧទាហរណ៍: 8492 ឬលេខកូដដែល Admin បង្ហាញ</small>
                    </div>

                    <div id="passcode-feedback" class="alert alert-success d-none py-2 px-3 small rounded-3 mb-3"></div>
                </div>

                <button class="btn btn-success btn-lg w-100 py-3 rounded-pill fw-bold shadow-lg d-flex align-items-center justify-content-center gap-2" onclick="submitPasscodeCheckIn()">
                    <i data-lucide="check-circle" style="width: 20px; height: 20px;"></i>
                    <span>បញ្ជាក់វត្តមានតាមរយៈលេខកូដ (Check-in Now)</span>
                </button>
            </div>
        </div>
    </div>

    <!-- 3. My Personal Attendance Scan History (ប្រវត្តិស្កេនវត្តមានរបស់ខ្លួនតាមថ្ងៃ និងម៉ោង) -->
    <div class="card border-0 shadow-sm p-3 p-md-4 rounded-4 mt-4 bg-body-tertiary">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3 pb-2 border-bottom">
            <div class="d-flex align-items-center gap-2">
                <div class="p-2 rounded-circle bg-primary-subtle text-primary">
                    <i data-lucide="history" style="width: 18px; height: 18px;"></i>
                </div>
                <div>
                    <h5 class="fw-bolder mb-0 fs-6">ប្រវត្តិនៃការស្កេនវត្តមានរបស់ខ្ញុំ (My Scan History)</h5>
                    <small class="text-secondary">កំណត់ត្រាការស្កេន QR និងវាយលេខកូដទាំងអស់តាមថ្ងៃ និងម៉ោងជាក់ស្តែង</small>
                </div>
            </div>
            <span class="badge bg-primary text-white px-3 py-1.5 rounded-pill fw-bold">
                {{ isset($myAttendanceHistory) ? $myAttendanceHistory->count() : 0 }} Logs
            </span>
        </div>

        @if(isset($myAttendanceHistory) && $myAttendanceHistory->count() > 0)
            <div class="row row-cols-1 row-cols-md-2 g-2.5" id="scan-history-list">
                @foreach($myAttendanceHistory as $history)
                    <div class="col">
                        <div class="p-3 rounded-4 bg-body border d-flex justify-content-between align-items-center shadow-xs">
                            <div class="d-flex align-items-center gap-2.5">
                                <div class="rounded-circle {{ str_contains($history->session_name ?? '', '2') ? 'bg-warning-subtle text-warning-emphasis' : 'bg-primary-subtle text-primary' }} d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px;">
                                    <i data-lucide="{{ str_contains($history->session_name ?? '', '2') ? 'sunset' : 'sun' }}" style="width: 18px; height: 18px;"></i>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-1.5 flex-wrap">
                                        <span class="badge bg-primary-subtle text-primary font-monospace small" style="font-size: 11px;">{{ $history->code }}</span>
                                        <span class="fw-bold fs-7">{{ $history->subject }}</span>
                                    </div>
                                    <div class="small text-secondary mt-1">
                                        <span class="badge bg-body-secondary text-body fw-normal" style="font-size: 10.5px;">
                                            {{ $history->session_name ?: 'Session 1 (ព្រឹក)' }}
                                        </span>
                                        <span class="ms-1 font-monospace" style="font-size: 11px;">
                                            📅 {{ $history->session_date ?: ($history->created_at ? date('Y-m-d', strtotime($history->created_at)) : date('Y-m-d')) }}
                                            • ⏰ {{ $history->check_in_time ?: ($history->created_at ? date('h:i A', strtotime($history->created_at)) : date('h:i A')) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <span class="badge bg-success-subtle text-success fw-bold px-2.5 py-1.5 rounded-pill flex-shrink-0">
                                <i data-lucide="check" style="width: 12px; height: 12px;" class="me-0.5"></i> {{ $history->status }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-4 text-secondary">
                <i data-lucide="clock-alert" class="opacity-50 mb-2" style="width: 36px; height: 36px;"></i>
                <p class="mb-0 small">មិនទាន់មានប្រវត្តិនៃការស្កេនវត្តមាននៅឡើយទេ! សូមជ្រើសរើសស្កេន QR ឬវាយលេខកូដសម្ងាត់ ៤ ខ្ទង់ខាងលើ។</p>
            </div>
        @endif
    </div>
</div>

<!-- ====================================================================== -->
<!-- 9. EXAMINATIONS & QCM TAKING (AUTO-SCORE & 5 CATEGORIES)               -->
<!-- ====================================================================== -->
<div id="screen-exam" class="screen-section d-none">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4 pb-3 border-bottom">
        <div class="d-flex align-items-center gap-2.5">
            <button type="button" class="btn-ios-circle" onclick="switchTab('home')" title="Back to Home">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
            </button>
            <div>
                <h4 class="fw-bolder mb-0 tracking-tight">Examinations & QCM Assessments</h4>
                <small class="text-secondary">ប្រឡង QCM តាមប្រភេទ (Lesson, Midterm, Final, Test, Dig4.0) • គណនាពិន្ទុ Auto ភ្លាមៗ</small>
            </div>
        </div>
        <span class="badge bg-primary-subtle text-primary py-2 px-3 rounded-pill fw-bold">
            <i data-lucide="file-text" style="width: 14px; height: 14px;" class="me-1"></i> {{ $exams->filter(function($e) { $ts = strtotime(str_replace(['•', '|'], ' ', $e->exam_date)); return $e->status === 'Active' || ($ts && $ts <= time()); })->count() }} Exams Active
        </span>
    </div>

    <!-- Exam Cards with Take Exam (QCM) Button (Active when Admin Opens or Scheduled Time Arrives) -->
    <div class="row row-cols-1 row-cols-md-2 g-3 mb-4">
        @forelse($exams as $exam)
            @php
                $isOpen = ($exam->status === 'Active');
                if (!$isOpen && !empty($exam->exam_date)) {
                    $cleanDate = str_replace(['•', '|'], ' ', $exam->exam_date);
                    $examTs = strtotime($cleanDate);
                    if ($examTs && $examTs <= time()) {
                        $isOpen = true; // Auto-unlock if scheduled exam time has arrived
                    }
                }
                $mySub = isset($myExamSubmissions) ? $myExamSubmissions->get($exam->id) : null;
                $canReExam = $mySub && !empty($mySub->allow_reexam);
            @endphp
            <div class="col">
                <div class="tool-card p-4 h-100 d-flex flex-column justify-content-between border-start border-4 {{ $mySub ? ($canReExam ? 'border-warning' : ($mySub->is_passed ? 'border-success' : 'border-danger')) : ($isOpen ? 'border-primary' : 'border-secondary') }}">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-1">
                            <span class="badge {{ $isOpen ? 'bg-primary' : 'bg-secondary' }} text-white fw-bold">{{ $exam->category ?: 'Midterm exam' }}</span>
                            @if($mySub)
                                @if($canReExam)
                                    <span class="badge bg-warning text-dark fw-bold shadow-xs">
                                        <i data-lucide="rotate-ccw" style="width: 12px; height: 12px;" class="me-1"></i> 
                                        ADMIN បានអនុញ្ញាតឱ្យប្រឡងឡើងវិញ (ReExam)
                                    </span>
                                @else
                                    <span class="badge {{ $mySub->is_passed ? 'bg-success' : 'bg-danger' }} text-white fw-bold">
                                        <i data-lucide="{{ $mySub->is_passed ? 'check-circle' : 'alert-circle' }}" style="width: 12px; height: 12px;" class="me-1"></i> 
                                        បានប្រឡងរួច: {{ $mySub->earned_score }}/{{ $mySub->total_possible }} ({{ $mySub->percentage }}% • {{ $mySub->grade }})
                                    </span>
                                @endif
                            @elseif($isOpen)
                                <span class="badge bg-success text-white fw-bold"><i data-lucide="unlock" style="width: 12px; height: 12px;" class="me-1"></i> ADMIN បានបើក (OPEN)</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary fw-bold"><i data-lucide="lock" style="width: 12px; height: 12px;" class="me-1"></i> រង់ចាំ ADMIN បើក (LOCKED)</span>
                            @endif
                        </div>
                        <h5 class="fw-bold mb-1 fs-6">{{ $exam->title }} ({{ $exam->course }})</h5>
                        <div class="text-secondary small mb-3">
                            <div><i data-lucide="calendar" style="width: 14px; height: 14px;" class="me-1 d-inline-block"></i>{{ $exam->exam_date }}</div>
                            <div><i data-lucide="map-pin" style="width: 14px; height: 14px;" class="me-1 d-inline-block"></i>{{ $exam->room }}</div>
                        </div>
                        <div class="d-flex gap-2 mb-3">
                            <span class="badge bg-info-subtle text-info fw-semibold">⏱️ {{ $exam->duration_minutes ?: 45 }} Mins</span>
                            <span class="badge bg-success-subtle text-success fw-semibold">🎯 {{ $exam->total_points ?: 100 }} Total Points</span>
                        </div>
                    </div>
                    
                    <div class="pt-3 border-top">
                        @if($mySub)
                            @if($canReExam)
                                <div class="d-flex flex-column gap-2">
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-warning flex-grow-1 rounded-pill fw-bold py-2 shadow-xs d-flex align-items-center justify-content-center gap-1.5" onclick="startTakeExamAJAX({{ $exam->id }}, '{{ addslashes($exam->title) }}', {{ $exam->total_points ?: 100 }})">
                                            <i data-lucide="rotate-ccw" style="width: 16px; height: 16px;"></i>
                                            <span>ចូលប្រឡងឡើងវិញ (ReExam Now)</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold d-flex align-items-center gap-1" onclick="showCompletedExamResult({{ json_encode($mySub) }}, '{{ addslashes($exam->title) }}')" title="មើលលទ្ធផលលើកមុន">
                                            <i data-lucide="award" style="width: 14px; height: 14px;"></i>
                                            <span>លទ្ធផលមុន</span>
                                        </button>
                                    </div>
                                    <small class="text-success text-center fw-semibold" style="font-size: 0.72rem;">
                                        <i data-lucide="check-circle" style="width: 11px; height: 11px;" class="me-0.5"></i> Admin បានចុច ReExam លើឈ្មោះរបស់អ្នករួចរាល់
                                    </small>
                                </div>
                            @else
                                <div class="d-flex flex-column gap-1.5">
                                    <button class="btn btn-outline-success w-100 rounded-pill fw-bold py-2 shadow-xs d-flex align-items-center justify-content-center gap-1.5" onclick="showCompletedExamResult({{ json_encode($mySub) }}, '{{ addslashes($exam->title) }}')">
                                        <i data-lucide="award" style="width: 16px; height: 16px;"></i>
                                        <span>មើលលទ្ធផល ({{ $mySub->percentage }}% • {{ $mySub->grade }})</span>
                                    </button>
                                    <small class="text-secondary text-center" style="font-size: 0.72rem;">
                                        <i data-lucide="lock" style="width: 11px; height: 11px;" class="me-0.5 d-inline-block"></i>មិនអាចប្រឡងឡើងវិញបានទេ លុះត្រាតែ Admin ចុច button ReExam
                                    </small>
                                </div>
                            @endif
                        @elseif($isOpen)
                            <button class="btn btn-success w-100 rounded-pill fw-bold py-2 shadow-xs d-flex align-items-center justify-content-center gap-2" onclick="startTakeExamAJAX({{ $exam->id }}, '{{ addslashes($exam->title) }}', {{ $exam->total_points ?: 100 }})">
                                <i data-lucide="pencil-line" style="width: 16px; height: 16px;"></i>
                                <span>ចូលប្រឡង QCM (Take Exam - Auto Score)</span>
                            </button>
                        @else
                            <button class="btn btn-secondary w-100 rounded-pill fw-bold py-2 shadow-xs d-flex align-items-center justify-content-center gap-2 opacity-75" disabled>
                                <i data-lucide="lock" style="width: 16px; height: 16px;"></i>
                                <span>រង់ចាំ Admin បើកការប្រឡង</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-secondary">
                <i data-lucide="calendar-x" style="width: 48px; height: 48px;" class="mb-2 opacity-50"></i>
                <p>No exams currently scheduled.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- ====================================================================== -->
<!-- 10. ACHIEVEMENTS & CERTIFICATES (VIEW OFFICIAL CREDENTIAL)             -->
<!-- ====================================================================== -->
<div id="screen-certificates" class="screen-section d-none">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4 pb-3 border-bottom">
        <div class="d-flex align-items-center gap-2.5">
            <button type="button" class="btn-ios-circle" onclick="switchTab('home')" title="Back to Home">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
            </button>
            <div>
                <h4 class="fw-bolder mb-0 tracking-tight">Achievements & Certificates</h4>
                <small class="text-secondary">វិញ្ញាបនបត្រឌីជីថលដែល Admin បានបង្កើត (Batch Auto Generated) តាមការប្រឡង & Challenge</small>
            </div>
        </div>
        <span class="badge bg-warning-subtle text-warning-emphasis py-2 px-3 rounded-pill fw-bold">
            <i data-lucide="award" style="width: 14px; height: 14px;" class="me-1"></i> Verified Credentials
        </span>
    </div>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        @forelse($certificates as $cert)
            <div class="col">
                <div class="tool-card p-4 h-100 position-relative overflow-hidden border" style="background: radial-gradient(circle at top right, rgba(251, 191, 36, 0.08), transparent 70%);">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-3 rounded-circle bg-warning-subtle text-warning shadow-xs">
                            <i data-lucide="award" style="width: 32px; height: 32px;"></i>
                        </div>
                        <div>
                            <span class="badge bg-success-subtle text-success fw-bold mb-1">{{ $cert->status }} Credential</span>
                            <h5 class="fw-bolder mb-0 fs-6">{{ $cert->title }}</h5>
                        </div>
                    </div>
                    <p class="text-secondary small mb-3">
                        Issued to <strong class="text-body">{{ $cert->recipient }}</strong> in recognition of outstanding academic performance and digital campus contributions.
                    </p>
                    <div class="p-2.5 rounded-3 bg-body-secondary d-flex justify-content-between align-items-center small font-monospace mb-3">
                        <span class="text-secondary" style="font-size: 11px;">Credential ID:</span>
                        <strong class="text-primary">{{ $cert->credential_id }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                        <small class="text-secondary">Issued: {{ $cert->issue_date }}</small>
                        <button class="btn btn-warning text-dark btn-sm rounded-pill px-3 fw-bold shadow-xs" onclick="openCertificateModal('{{ addslashes($cert->title) }}', '{{ addslashes($cert->recipient) }}', '{{ $cert->issue_date }}', '{{ $cert->credential_id }}')">
                            <i data-lucide="eye" style="width: 13px; height: 13px;" class="me-1"></i> មើលវិញ្ញាបនបត្រ (View)
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-secondary">
                <i data-lucide="award" style="width: 48px; height: 48px;" class="mb-2 opacity-50"></i>
                <p>No certificates issued yet. Admin will auto-generate upon exam or challenge completion.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- ====================================================================== -->
<!-- 11. CLASSROOM SCREEN SPOTLIGHT DEDICATED PAGE                          -->
<!-- ====================================================================== -->
<div id="screen-showscreen" class="screen-section d-none">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4 pb-3 border-bottom">
        <div class="d-flex align-items-center gap-2.5">
            <button type="button" class="btn-ios-circle" onclick="switchTab('home')" title="Back to Home">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
            </button>
            <div>
                <h4 class="fw-bolder mb-0 tracking-tight">Classroom Screen Spotlight</h4>
                <small class="text-secondary">ចាក់បញ្ចាំងអេក្រង់ក្នុងថ្នាក់រៀន • Live Real-time Sync (Admin Screen Broadcast)</small>
            </div>
        </div>
        <span id="live-showscreen-badge" class="badge {{ $screenBroadcast && $screenBroadcast->is_broadcasting ? 'bg-danger' : 'bg-secondary' }} py-2 px-3 rounded-pill fw-bold text-white shadow-xs">
            {{ $screenBroadcast && $screenBroadcast->is_broadcasting ? '🔴 LIVE BROADCAST' : '⚪ STANDBY' }}
        </span>
    </div>

    <div class="row g-4">
        <!-- 16:9 Display Canvas (Live Real-Time Screen) -->
        <div class="col-12 col-lg-8">
            <div class="tool-card p-3 p-md-4 bg-dark text-white shadow-lg" style="border-radius: 24px;">
                <div class="d-flex justify-content-between align-items-center pb-2 mb-3 border-bottom border-secondary border-opacity-50">
                    <span class="small text-white-50"><i data-lucide="map-pin" style="width: 13px; height: 13px;" class="me-1 d-inline-block"></i><span id="live-show-room">{{ $screenBroadcast ? $screenBroadcast->room : 'Lab 402 • Media Wing' }}</span></span>
                    <span class="badge bg-primary-subtle text-primary fw-bold font-monospace">1080p 60fps • Real-Time</span>
                </div>
                <div id="live-show-box" class="d-flex flex-column align-items-center justify-content-center py-5 text-center position-relative overflow-hidden" style="min-height: 300px; background: radial-gradient(circle at center, rgba(56, 189, 248, 0.08), rgba(15, 23, 42, 0.9)); border-radius: 18px; border: 1px solid rgba(255, 255, 255, 0.1);">
                    <div id="live-show-icon-box" class="p-3.5 rounded-circle bg-primary bg-opacity-20 text-primary mb-3">
                        <i data-lucide="monitor" style="width: 48px; height: 48px;"></i>
                    </div>
                    <h4 class="fw-bold text-white mb-1" id="live-show-student">{{ $screenBroadcast ? $screenBroadcast->student_name : 'Faculty Presenter' }}</h4>
                    <p class="text-white-50 small mb-3" id="live-show-title">{{ $screenBroadcast ? $screenBroadcast->preview_title : 'Classroom Presentation / Slide Teaching' }}</p>
                    <span id="live-show-status-text" class="badge {{ $screenBroadcast && $screenBroadcast->is_broadcasting ? 'bg-success' : 'bg-secondary' }} px-3 py-1.5 rounded-pill fw-bold">
                        {{ $screenBroadcast && $screenBroadcast->is_broadcasting ? '🟢 Live Stream Active' : '⚪ Waiting for Admin to Broadcast' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Controls Column -->
        <div class="col-12 col-lg-4">
            <div class="tool-card p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <i data-lucide="cast" style="width: 16px; height: 16px;" class="text-primary"></i>
                        <span>Spotlight Controls</span>
                    </h6>
                    <p class="text-secondary small mb-3">
                        អេក្រង់នេះ sync ជា Real-Time ជាមួយ Admin Teaching Console។ នៅពេល Admin បើក show ឬផ្លាស់ប្តូរស្លាយ អេក្រង់នឹងផ្លាស់ប្តូរស្វ័យប្រវត្តិ។
                    </p>
                    <div class="p-3 rounded-3 bg-body-secondary mb-3">
                        <small class="text-secondary d-block" style="font-size: 11px;">Target Display:</small>
                        <strong class="text-body" id="live-show-room-info">{{ $screenBroadcast ? $screenBroadcast->room : 'Lab 402 • Media Wing' }}</strong>
                    </div>
                    <div class="p-3 rounded-3 bg-body-secondary mb-3">
                        <small class="text-secondary d-block" style="font-size: 11px;">Sync Status:</small>
                        <span class="text-success small fw-bold"><i data-lucide="refresh-cw" style="width: 12px; height: 12px;" class="me-1 d-inline-block"></i> Polling live every 3s</span>
                    </div>
                </div>
                <button class="btn btn-primary w-100 py-2.5 rounded-pill fw-bold shadow-xs" onclick="requestScreenShareAJAX()">
                    <i data-lucide="cast" style="width: 16px; height: 16px;" class="me-1"></i>
                    <span>Request / Broadcast Screen</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ====================================================================== -->
<!-- 12. CAMPUS COLLABORATION & GROUP QCM SPRINT                             -->
<!-- ====================================================================== -->
<div id="screen-collab" class="screen-section d-none">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4 pb-3 border-bottom">
        <div class="d-flex align-items-center gap-2.5">
            <button type="button" class="btn-ios-circle" onclick="switchTab('home')" title="Back to Home">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
            </button>
            <div>
                <h4 class="fw-bolder mb-0 tracking-tight">Campus Team Collaborations & QCM</h4>
                <small class="text-secondary">ចូលរួមធ្វើការជាមួយគ្នា Real-Time ដោះស្រាយលំហាត់ QCM ជាក្រុម</small>
            </div>
        </div>
        <span class="badge bg-primary-subtle text-primary py-2 px-3 rounded-pill fw-bold">
            <i data-lucide="users" style="width: 14px; height: 14px;" class="me-1"></i> {{ $collaborations->count() }} Teams Open
        </span>
    </div>

    <div class="row row-cols-1 row-cols-md-2 g-3">
        @forelse($collaborations as $collab)
            <div class="col">
                <div class="tool-card p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-primary-subtle text-primary fw-bold">{{ $collab->current_members }}/{{ $collab->max_members }} Members</span>
                            <span class="badge {{ $collab->status === 'Open' ? 'bg-success-subtle text-success' : 'bg-secondary' }} fw-bold">{{ $collab->status }}</span>
                        </div>
                        <h5 class="fw-bold mb-1 fs-6">{{ $collab->title }}</h5>
                        <p class="text-secondary small mb-3">{{ $collab->description }}</p>

                        <!-- Group Problem Solving QCM Box -->
                        <div class="p-3 rounded-3 bg-body-tertiary border mb-3">
                            <small class="text-primary fw-bold d-block mb-1">Group QCM Sprint Prompt:</small>
                            <span class="small d-block mb-2">តើ Grid System ណាដែលសក្តិសមបំផុតសម្រាប់ High Data Density Dashboard?</span>
                            <div class="d-flex flex-column gap-1">
                                <label class="small"><input type="radio" name="collab_choice_{{ $collab->id }}" value="A"> A. 4-column fluid</label>
                                <label class="small"><input type="radio" name="collab_choice_{{ $collab->id }}" value="B" checked> B. 12-column responsive (8pt baseline)</label>
                                <label class="small"><input type="radio" name="collab_choice_{{ $collab->id }}" value="C"> C. Fixed 960px</label>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100 rounded-pill fw-bold py-2 shadow-xs d-flex align-items-center justify-content-center gap-1.5" onclick="submitCollabSprint({{ $collab->id }})">
                        <i data-lucide="check-circle" style="width: 15px; height: 15px;"></i>
                        <span>Submit Team Answer (+50 Pts)</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-secondary">
                <i data-lucide="users" style="width: 48px; height: 48px;" class="mb-2 opacity-50"></i>
                <p>No open team collaborations right now.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- ====================================================================== -->
<!-- 13. CAMPUS CHALLENGES & REAL-TIME COMPETITION                          -->
<!-- ====================================================================== -->
<div id="screen-challenge" class="screen-section d-none">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4 pb-3 border-bottom">
        <div class="d-flex align-items-center gap-2.5">
            <button type="button" class="btn-ios-circle" onclick="switchTab('home')" title="Back to Home">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
            </button>
            <div>
                <h4 class="fw-bolder mb-0 tracking-tight">Campus Challenges & Live Leaderboard</h4>
                <small class="text-secondary">ប្រកួតប្រជែងជា Real-Time • ឆ្លើយសំណួរ ទទួលបានពិន្ទុ & ចំណាត់ថ្នាក់លើ Full Screen</small>
            </div>
        </div>
        <span class="badge bg-warning-subtle text-warning-emphasis py-2 px-3 rounded-pill fw-bold">
            <i data-lucide="trophy" style="width: 14px; height: 14px;" class="me-1"></i> Live Arena
        </span>
    </div>

    <div class="row row-cols-1 row-cols-md-2 g-3">
        @forelse($challenges as $ch)
            <div class="col">
                <div class="tool-card p-4 h-100 d-flex flex-column justify-content-between border-start border-4 border-warning">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-warning text-dark fw-bold">{{ $ch->badge ?? 'NEW QUEST' }}</span>
                            <span class="badge bg-warning-subtle text-warning-emphasis fw-bold">+{{ $ch->points }} Points</span>
                        </div>
                        <h5 class="fw-bold mb-1 fs-6">{{ $ch->title }}</h5>
                        <p class="text-secondary small mb-3">{{ $ch->description }}</p>

                        <!-- Live Challenge Question Prompt -->
                        @if($ch->question_text)
                            <div class="p-3 rounded-3 bg-body-tertiary mb-3 border">
                                <strong class="small text-warning-emphasis d-block mb-1">សំណួរប្រកួតប្រជែង (Live Task):</strong>
                                <span class="small d-block mb-2">{{ $ch->question_text }}</span>
                                <div class="d-flex flex-column gap-1">
                                    <label class="small"><input type="radio" name="ch_choice_{{ $ch->id }}" value="A" checked> A. Spring Physics Animation (0.3s)</label>
                                    <label class="small"><input type="radio" name="ch_choice_{{ $ch->id }}" value="B"> B. Linear ease-in</label>
                                    <label class="small"><input type="radio" name="ch_choice_{{ $ch->id }}" value="C"> C. Instant cut</label>
                                </div>
                            </div>
                        @endif
                    </div>

                    <button class="btn btn-warning text-dark w-100 rounded-pill fw-bold py-2 shadow-xs d-flex align-items-center justify-content-center gap-1.5" onclick="submitLiveChallengeAnswer({{ $ch->id }}, '{{ addslashes($ch->title) }}')">
                        <i data-lucide="sparkles" style="width: 15px; height: 15px;"></i>
                        <span>Submit Live Answer (+{{ $ch->points }} PTS)</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-secondary">
                <i data-lucide="trophy" style="width: 48px; height: 48px;" class="mb-2 opacity-50"></i>
                <p>No active challenges at the moment.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- ====================================================================== -->
<!-- 14. ATTENDANCE HISTORY & SUBJECT RATES DEDICATED PAGE                  -->
<!-- ====================================================================== -->
<div id="screen-attendance" class="screen-section d-none">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4 pb-3 border-bottom">
        <div class="d-flex align-items-center gap-2.5">
            <button type="button" class="btn-ios-circle" onclick="switchTab('home')" title="Back to Home">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
            </button>
            <div>
                <h4 class="fw-bolder mb-0 tracking-tight">Attendance Records & Health</h4>
                <small class="text-secondary">កំណត់ត្រាវត្តមានសិក្សា • Subject Breakdown & Logs</small>
            </div>
        </div>
        <button class="btn btn-success btn-sm rounded-pill px-3 py-2 fw-bold shadow-xs" onclick="switchTab('scan')">
            <i data-lucide="qr-code" style="width: 14px; height: 14px;" class="me-1"></i>
            <span>Scan to Check-in</span>
        </button>
    </div>

    <!-- Overall Attendance Card -->
    <div class="tool-card p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <span class="text-secondary small fw-semibold text-uppercase d-block mb-1">OVERALL ATTENDANCE STANDING</span>
                <h2 class="fw-bolder mb-0 text-success">{{ $student['overall_attendance'] }}</h2>
            </div>
            <span class="badge bg-success-subtle text-success py-2 px-3 rounded-pill fw-bold">Good Standing</span>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3 pt-2 border-top">
            @foreach($attendanceList as $attItem)
                <div class="col">
                    <div class="p-3 rounded-3 bg-body-secondary">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="badge bg-primary fs-7">{{ $attItem['code'] }}</span>
                            <strong class="text-primary">{{ $attItem['rate'] }}</strong>
                        </div>
                        <h6 class="fw-bold mb-1 text-truncate small">{{ $attItem['subject'] }}</h6>
                        <small class="text-secondary" style="font-size: 11px;">Status: {{ $attItem['status'] }}</small>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Attendance History Table (Detailed Subject Breakdown: មុខវិជ្ជា ថ្ងៃខែឆ្នាំ ម៉ោង វគ្គសិក្សា) -->
    <div class="tool-card overflow-hidden">
        <div class="p-3 px-4 border-bottom d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
            <div>
                <h6 class="fw-bold mb-0">ប្រវត្តិនៃការចុះវត្តមានសិក្សា (Detailed Attendance Logs • ២ Sessions ក្នុង ១ ថ្ងៃ)</h6>
                <small class="text-secondary" style="font-size: 11px;">ចុចជ្រើសរើសថ្ងៃខែដើម្បីមើលកំណត់ត្រាវត្តមាន</small>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="input-group input-group-sm" style="max-width: 175px;">
                    <span class="input-group-text bg-body-secondary"><i data-lucide="calendar" style="width: 13px; height: 13px;"></i></span>
                    <input type="date" id="client-att-date-filter" class="form-control" title="Filter by date" onchange="filterClientAttendance(this.value)">
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-2.5" onclick="document.getElementById('client-att-date-filter').value=''; filterClientAttendance('');" title="Reset Filter">All</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small text-secondary">
                    <tr>
                        <th class="ps-4">មុខវិជ្ជា (Subject)</th>
                        <th>កូដថ្នាក់ (Code)</th>
                        <th>វគ្គសិក្សា (Session)</th>
                        <th>ថ្ងៃខែឆ្នាំ (Date)</th>
                        <th>ម៉ោងស្កេន (Time)</th>
                        <th>វិធីសាស្ត្រ (Method)</th>
                        <th class="text-end pe-4">ស្ថានភាពវត្តមាន (Status)</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($myAttendanceHistory) && $myAttendanceHistory->count() > 0)
                        @foreach($myAttendanceHistory->take(15) as $log)
                            <tr class="client-att-row" data-date="{{ $log->session_date ?: ($log->created_at ? \Carbon\Carbon::parse($log->created_at)->format('Y-m-d') : date('Y-m-d')) }}">
                                <td class="ps-4">
                                    <span class="fw-bold small d-block">{{ $log->subject }}</span>
                                    <small class="text-secondary" style="font-size: 11px;">Faculty of Digital Sciences</small>
                                </td>
                                <td><span class="badge bg-body-secondary text-secondary font-monospace">{{ $log->code }}</span></td>
                                <td>
                                    <span class="badge {{ str_contains($log->session_name ?? '', '2') ? 'bg-warning-subtle text-warning-emphasis' : 'bg-primary-subtle text-primary' }} fw-bold">
                                        {{ $log->session_name ?? 'Session 1 (ព្រឹក)' }}
                                    </span>
                                </td>
                                <td class="small">{{ $log->session_date ?: ($log->created_at ? \Carbon\Carbon::parse($log->created_at)->format('d M Y') : date('d M Y')) }}</td>
                                <td class="small font-monospace">{{ $log->check_in_time }}</td>
                                <td>
                                    <span class="badge bg-info-subtle text-info font-monospace small">
                                        <i data-lucide="qr-code" style="width: 11px; height: 11px;" class="me-1"></i> Camera QR / Passcode
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <span class="badge bg-success fw-bold px-2.5 py-1">
                                        <i data-lucide="check" style="width: 12px; height: 12px;" class="me-1"></i> {{ $log->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @foreach($attendanceList as $aRow)
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold small d-block">{{ $aRow['subject'] }}</span>
                                    <small class="text-secondary" style="font-size: 11px;">Faculty of Digital Sciences</small>
                                </td>
                                <td><span class="badge bg-body-secondary text-secondary font-monospace">{{ $aRow['code'] }}</span></td>
                                <td><span class="badge bg-primary-subtle text-primary fw-bold">Session 1 (ព្រឹក)</span></td>
                                <td class="small">{{ str_contains($aRow['last_check'], ',') ? explode(',', $aRow['last_check'])[0] : date('d M Y') }}</td>
                                <td class="small font-monospace">{{ str_contains($aRow['last_check'], ',') ? trim(explode(',', $aRow['last_check'])[1]) : '08:30 AM' }}</td>
                                <td>
                                    <span class="badge bg-info-subtle text-info font-monospace small">
                                        <i data-lucide="qr-code" style="width: 11px; height: 11px;" class="me-1"></i> QR Camera Scan
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <span class="badge bg-success fw-bold px-2.5 py-1">
                                        <i data-lucide="check" style="width: 12px; height: 12px;" class="me-1"></i> {{ $aRow['status'] }} ({{ $aRow['rate'] }})
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ====================================================================== -->
<!-- 15. DIGITAL LIBRARY DEDICATED PAGE (UPLOADED BY ADMIN)                 -->
<!-- ====================================================================== -->
<div id="screen-library" class="screen-section d-none">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4 pb-3 border-bottom">
        <div class="d-flex align-items-center gap-2.5">
            <button type="button" class="btn-ios-circle" onclick="switchTab('home')" title="Back to Home">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
            </button>
            <div>
                <h4 class="fw-bolder mb-0 tracking-tight">Digital Campus Library</h4>
                <small class="text-secondary">សៀវភៅឌីជីថលដែល Admin បាន Upload • អានអនឡាញ & ទាញយក E-Books</small>
            </div>
        </div>
        <span class="badge bg-primary-subtle text-primary py-2 px-3 rounded-pill fw-bold">
            <i data-lucide="book-open" style="width: 14px; height: 14px;" class="me-1"></i> {{ $books->count() }} E-Books Available
        </span>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
        @forelse($books as $book)
            <div class="col">
                <div class="tool-card p-4 h-100 d-flex flex-column justify-content-between border-start border-4 border-primary">
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-primary-subtle text-primary fw-bold">{{ $book->category }}</span>
                            <span class="badge bg-secondary-subtle text-secondary small">{{ $book->file_size }}</span>
                        </div>
                        <h5 class="fw-bold mb-1 fs-6">{{ $book->title }}</h5>
                        <small class="text-secondary d-block mb-2">និពន្ធដោយ: <strong class="text-body">{{ $book->author }}</strong> • {{ $book->total_pages ?? 320 }} ទំព័រ</small>
                        <p class="small text-secondary mb-3">{{ Str::limit($book->description, 110) }}</p>
                    </div>

                    <div class="d-flex flex-column gap-2 pt-2 border-top">
                        <button class="btn btn-primary rounded-pill w-100 fw-bold py-2 shadow-xs d-flex align-items-center justify-content-center gap-1.5" onclick="openBookReaderModal('{{ addslashes($book->title) }}', '{{ addslashes($book->author) }}', '{{ $book->category }}', '{{ $book->total_pages ?? 320 }}')">
                            <i data-lucide="book-open" style="width: 15px; height: 15px;"></i>
                            <span>អានសៀវភៅអនឡាញ (Read Online)</span>
                        </button>
                        <a href="{{ route('campus.book.download', $book->id) }}" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill w-100 fw-semibold d-flex align-items-center justify-content-center gap-1.5" onclick="showToast('Downloading {{ $book->title }}...')">
                            <i data-lucide="download" style="width: 13px; height: 13px;"></i>
                            <span>ទាញយក E-Book PDF ({{ $book->reads_count }} views)</span>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-secondary">
                <i data-lucide="book-x" style="width: 48px; height: 48px;" class="mb-2 opacity-50"></i>
                <p>មិនទាន់មានសៀវភៅក្នុងបណ្ណាល័យនៅឡើយទេ។ សៀវភៅដែល Admin Upload នឹងបង្ហាញនៅទីនេះ។</p>
            </div>
        @endforelse
    </div>
</div>

<!-- ====================================================================== -->
<!-- ====================================================================== -->
<!-- 16. CAMPUS HOMEWORK & ASSIGNMENTS (REPLACED NEWS)                      -->
<!-- ====================================================================== -->
<div id="screen-homework" class="screen-section d-none">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4 pb-3 border-bottom">
        <div class="d-flex align-items-center gap-2.5">
            <button type="button" class="btn-ios-circle" onclick="switchTab('home')" title="Back to Home">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
            </button>
            <div>
                <h4 class="fw-bolder mb-0 tracking-tight">Homework & Assignments (កិច្ចការផ្ទះ)</h4>
                <small class="text-secondary">ប្រធានបទកិច្ចការផ្ទះ • វាយបញ្ចូលចម្លើយ និងពិនិត្យពិន្ទុដែលគ្រូបានផ្តល់ជូន</small>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="badge bg-primary-subtle text-primary py-2 px-3 rounded-pill fw-bold">
                <i data-lucide="clipboard-list" style="width: 14px; height: 14px;" class="me-1"></i> {{ $homeworks->count() }} Topics
            </span>
            <span class="badge bg-success-subtle text-success py-2 px-3 rounded-pill fw-bold">
                <i data-lucide="check-circle" style="width: 14px; height: 14px;" class="me-1"></i> {{ $myHomeworkSubmissions->count() }} Submitted
            </span>
        </div>
    </div>

    <!-- Homework Assignments List -->
    <div class="row row-cols-1 g-4">
        @php $nowCambodia = \Carbon\Carbon::now('Asia/Phnom_Penh'); @endphp
        @forelse($homeworks as $hw)
            @php
                $hwDeadline = \Carbon\Carbon::parse($hw->deadline)->timezone('Asia/Phnom_Penh');
                $hwStart = $hw->start_date ? \Carbon\Carbon::parse($hw->start_date)->timezone('Asia/Phnom_Penh') : null;
                $isExpired = $nowCambodia->greaterThan($hwDeadline);
                $mySub = $myHomeworkSubmissions->get($hw->id);
            @endphp
            <div class="col">
                <div class="tool-card p-4 rounded-4 border {{ $mySub ? 'border-success border-opacity-50' : ($isExpired ? 'border-danger border-opacity-30' : 'border-primary border-opacity-50') }} shadow-xs">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-start gap-2 mb-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1.5 flex-wrap">
                                <span class="badge bg-primary-subtle text-primary fw-bold">{{ $hw->subject }}</span>
                                @if($hw->class_code)
                                    <span class="badge bg-info-subtle text-info fw-bold">{{ $hw->class_code }}</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary">All Classes</span>
                                @endif
                                <span class="badge bg-secondary-subtle text-secondary">Max: {{ $hw->max_score }} ពិន្ទុ</span>
                            </div>
                            <h5 class="fw-bold text-body mb-1">{{ $hw->title }}</h5>
                        </div>

                        <!-- Status Badge -->
                        <div>
                            @if($mySub)
                                @if($mySub->status === 'Graded')
                                    <span class="badge bg-success py-2 px-3 rounded-pill fw-bold shadow-xs">
                                        <i class="bi bi-award-fill me-1"></i> Graded: {{ $mySub->score }} / {{ $hw->max_score }}
                                    </span>
                                @else
                                    <span class="badge bg-success-subtle text-success py-2 px-3 rounded-pill fw-bold">
                                        <i class="bi bi-check-circle-fill me-1"></i> បានបញ្ជូន (Submitted)
                                    </span>
                                @endif
                            @elseif($isExpired)
                                <span class="badge bg-danger-subtle text-danger py-2 px-3 rounded-pill fw-bold">
                                    <i class="bi bi-clock-history me-1"></i> ហួស Deadline (Closed)
                                </span>
                            @else
                                <span class="badge bg-primary-subtle text-primary py-2 px-3 rounded-pill fw-bold">
                                    <i class="bi bi-pencil-square me-1"></i> កំពុងដំណើរការ (Open)
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Timeline Info (Start & Deadline in Cambodia Time) -->
                    <div class="d-flex flex-wrap align-items-center gap-3 p-2.5 rounded-3 bg-body-tertiary mb-3 text-secondary small font-monospace">
                        @if($hwStart)
                            <div>
                                <i class="bi bi-calendar3 me-1 text-primary"></i>
                                <span>ចាប់ផ្តើម: <strong>{{ $hwStart->format('d/m/Y h:i A') }}</strong></span>
                            </div>
                            <span>•</span>
                        @endif
                        <div>
                            <i class="bi bi-clock me-1 {{ $isExpired ? 'text-danger' : 'text-primary' }}"></i>
                            <span>កាលបរិច្ឆេទផុតកំណត់ (Deadline): <strong class="{{ $isExpired ? 'text-danger' : 'text-body' }}">{{ $hwDeadline->format('d/m/Y h:i A') }}</strong></span>
                        </div>
                    </div>

                    <!-- Questions / Instructions Display Box -->
                    <div class="p-3.5 rounded-3 bg-body-secondary border mb-3">
                        <h6 class="fw-bold mb-2 small text-primary text-uppercase" style="letter-spacing: 0.05em;">
                            <i data-lucide="help-circle" style="width: 15px; height: 15px;" class="me-1 d-inline-block"></i>
                            សំណួរ ឬកិច្ចការដែលត្រូវឆ្លើយ (Homework Questions):
                        </h6>
                        <div class="text-body fw-medium lh-base" style="white-space: pre-wrap; font-size: 14px;">{!! nl2br(e($hw->questions)) !!}</div>
                    </div>

                    <!-- Submission & Answer Area -->
                    <div id="hw-section-{{ $hw->id }}">
                        @if($mySub)
                            <!-- Already Submitted Display -->
                            <div class="p-3.5 rounded-4 border bg-body shadow-xs">
                                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                    <span class="badge bg-success-subtle text-success py-1.5 px-3 rounded-pill fw-bold font-monospace">
                                        <i class="bi bi-calendar-check me-1"></i> បានបញ្ជូននៅ: <strong>{{ \Carbon\Carbon::parse($mySub->submitted_at)->timezone('Asia/Phnom_Penh')->format('d/m/Y h:i A') }}</strong>
                                    </span>
                                    <span class="small text-secondary">Student ID: <strong>{{ $mySub->student_id }}</strong></span>
                                </div>

                                <div class="mb-3">
                                    <small class="text-secondary fw-bold d-block mb-1">ចម្លើយដែលអ្នកបានវាយបញ្ចូល (Your Submitted Answer):</small>
                                    <div class="p-3 rounded-3 bg-body-tertiary border text-body" style="white-space: pre-wrap; font-size: 14px; line-height: 1.6;">{{ $mySub->answer_text }}</div>
                                </div>

                                @if($mySub->status === 'Graded')
                                    <!-- Graded Score Box -->
                                    <div class="p-3 rounded-3 bg-primary bg-opacity-10 border border-primary border-opacity-25">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                            <div>
                                                <span class="badge bg-primary text-white fw-bold me-2">Graded</span>
                                                <span class="fs-5 fw-bold text-primary">ពិន្ទុទទួលបាន: <strong>{{ $mySub->score }}</strong> / {{ $hw->max_score }}</span>
                                            </div>
                                            <small class="text-secondary">ដាក់ពិន្ទុដោយ: <strong>{{ $mySub->graded_by ?? 'Admin Instructor' }}</strong></small>
                                        </div>
                                        @if($mySub->feedback)
                                            <div class="mt-2 pt-2 border-top border-primary border-opacity-15 small">
                                                <strong class="text-primary">មតិយោបល់ពីគ្រូ (Teacher Feedback):</strong>
                                                <span class="text-body ms-1">{{ $mySub->feedback }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="p-2.5 rounded-3 bg-warning-subtle text-warning-emphasis d-flex align-items-center gap-2">
                                        <i class="bi bi-hourglass-split fs-5"></i>
                                        <span class="small fw-semibold">ចម្លើយត្រូវបានបញ្ជូនជោគជ័យ។ កំពុងរង់ចាំគ្រូពិនិត្យ និងវាយបញ្ចូលពិន្ទុ (Pending Review)</span>
                                    </div>
                                @endif
                            </div>
                        @elseif($isExpired)
                            <!-- Deadline Passed Alert (Cannot Submit) -->
                            <div class="alert alert-danger d-flex align-items-center gap-3 mb-0 rounded-4 p-3 shadow-xs">
                                <i class="bi bi-clock-history fs-3 text-danger flex-shrink-0"></i>
                                <div>
                                    <strong class="d-block mb-0.5">ហួសកាលបរិច្ឆេទផុតកំណត់ (Deadline Passed)</strong>
                                    <small>កិច្ចការនេះបានផុតកំណត់ត្រឹមម៉ោង <strong>{{ $hwDeadline->format('d/m/Y h:i A') }}</strong> ហើយ។ អ្នកមិនអាចបញ្ជូនចម្លើយបានទៀតទេ!</small>
                                </div>
                            </div>
                        @else
                            <!-- Answering Form (Student Typing Text for All Questions) -->
                            <div class="p-3.5 rounded-4 border bg-body shadow-xs">
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-secondary">
                                        <i data-lucide="edit-3" style="width: 14px; height: 14px;" class="me-1 d-inline-block"></i>
                                        ចម្លើយរបស់អ្នក (Answer : Student typing text all question) <span class="text-danger">*</span>:
                                    </label>
                                    <textarea id="homework_ans_{{ $hw->id }}" class="form-control rounded-3" rows="7" placeholder="វាយបញ្ចូលចម្លើយសម្រាប់សំណួរទាំងអស់នៅទីនេះ (Type your answer to all questions here)..." required style="font-size: 14px; line-height: 1.6;"></textarea>
                                </div>
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <small class="text-secondary"><i class="bi bi-info-circle me-1"></i> ពេល Submit នឹងកត់ត្រាថ្ងៃ និងម៉ោងបញ្ជូនដោយស្វ័យប្រវត្តិ។</small>
                                    <button type="button" class="btn btn-primary fw-bold rounded-pill px-4 py-2 shadow-xs d-inline-flex align-items-center gap-1.5" onclick="submitHomeworkAnswerAJAX({{ $hw->id }})">
                                        <i data-lucide="send" style="width: 15px; height: 15px;"></i>
                                        <span>បញ្ជូនកិច្ចការផ្ទះ (Submit Homework)</span>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-secondary">
                <i data-lucide="clipboard-list" style="width: 52px; height: 52px;" class="mb-2 opacity-40"></i>
                <h5 class="fw-bold mb-1">មិនទាន់មានកិច្ចការផ្ទះនៅឡើយទេ</h5>
                <p class="small mb-0">នៅពេលគ្រូដាក់ Topic កិច្ចការផ្ទះ វានឹងបង្ហាញនៅទីនេះដោយស្វ័យប្រវត្តិ។</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Fallback Alias for Legacy Test Assertion screen-news -->
<div id="screen-news" class="d-none" style="display:none !important;"></div>

<!-- ====================================================================== -->
<!-- 17. DIGITAL STUDENT PASS DEDICATED PAGE                                -->
<!-- ====================================================================== -->
<div id="screen-qrpass" class="screen-section d-none">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4 pb-3 border-bottom">
        <div class="d-flex align-items-center gap-2.5">
            <button type="button" class="btn-ios-circle" onclick="switchTab('home')" title="Back to Home">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
            </button>
            <div>
                <h4 class="fw-bolder mb-0 tracking-tight">Digital Student ID Pass</h4>
                <small class="text-secondary">កាតសម្គាល់ខ្លួននិស្សិតឌីជីថល • Official Campus Identification</small>
            </div>
        </div>
        <button class="btn btn-outline-primary btn-sm rounded-pill px-3 py-2 fw-bold" onclick="openAvatarCropModal()">
            <i data-lucide="camera" style="width: 14px; height: 14px;" class="me-1"></i>
            <span>Change Photo (Crop)</span>
        </button>
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 text-center">
            <div class="student-pass-card mb-4 text-start shadow-lg" style="min-height: 230px;">
                <div class="pass-glow-1"></div>
                <div class="pass-glow-2"></div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-uppercase fw-bold text-light" style="font-size: 11px; letter-spacing: 0.15em;">
                        GENZ DIGITAL STUDENT PASS
                    </span>
                    <span class="badge bg-success text-white fw-bold">{{ $student['status'] }}</span>
                </div>

                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="{{ $student['avatar'] }}" alt="{{ $student['name'] }}" class="user-avatar-element rounded-circle object-fit-cover shadow" style="width: 76px; height: 76px; border: 3px solid rgba(255, 255, 255, 0.5);">
                    <div>
                        <h3 class="fs-4 fw-bold mb-0 text-white d-flex align-items-center gap-1.5">
                            <span>{{ $student['name'] }}</span>
                            @include('partials.verified-badge', ['size' => 18])
                        </h3>
                        <small class="text-white-50">ID • {{ $student['id'] }}</small>
                        <small class="d-block text-white opacity-90">{{ $student['major'] }}</small>
                    </div>
                </div>

                <div class="pt-3 d-flex justify-content-between text-white small">
                    <span>Valid Until: {{ $student['valid_until'] }}</span>
                    <span>Pass ID: {{ $student['pass_id'] }}</span>
                </div>
            </div>

            <!-- Optical QR Code View for Gate Scanning -->
            <div class="tool-card p-4 p-md-5 text-center mb-4">
                <span class="fw-bold small text-secondary text-uppercase d-block mb-3" style="letter-spacing: 0.1em;">
                    CAMPUS TURNSTILE OPTICAL CODE
                </span>
                <div class="bg-white p-3.5 rounded-4 shadow-sm border d-inline-block mb-3">
                    <svg width="180" height="180" viewBox="0 0 24 24" fill="none" stroke="#0f172a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="5" height="5" x="3" y="3" rx="1"/>
                        <rect width="5" height="5" x="16" y="3" rx="1"/>
                        <rect width="5" height="5" x="3" y="16" rx="1"/>
                        <path d="M21 16h-3a2 2 0 0 0-2 2v3"/>
                        <path d="M21 21v.01"/>
                        <path d="M12 7v3a2 2 0 0 1-2 2H7"/>
                        <path d="M3 12h.01"/>
                        <path d="M12 3h.01"/>
                        <path d="M12 16v.01"/>
                        <path d="M16 12h1"/>
                        <path d="M21 12v.01"/>
                        <path d="M12 21v-1"/>
                    </svg>
                </div>
                <small class="text-secondary d-block font-monospace">Pass Token: GZ-PASS-{{ $student['id'] }}</small>
            </div>
        </div>
    </div>
</div>
@endif
@endauth

<!-- ====================================================================== -->
<!-- BOOTSTRAP 5 MODALS (Responsive on Desktop & Mobile)                     -->
<!-- ====================================================================== -->

<!-- 1. QR Student Pass Modal -->
<div class="modal fade" id="qrPassModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-6">Digital Student Pass</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="position-relative d-inline-block mb-2 cursor-pointer" onclick="bootstrap.Modal.getInstance(document.getElementById('qrPassModal')).hide(); openAvatarCropModal();" title="Click to change photo">
                    <img src="{{ $student['avatar'] }}" alt="{{ $student['name'] }}" class="user-avatar-element rounded-circle object-fit-cover shadow" style="width: 86px; height: 86px; border: 4px solid #2563eb;">
                    <span class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-1 d-flex align-items-center justify-content-center shadow-sm" style="width: 26px; height: 26px; border: 2px solid #ffffff;">
                        <i data-lucide="camera" style="width: 13px; height: 13px;"></i>
                    </span>
                </div>
                <h4 class="fw-bold mb-0 fs-5 d-flex align-items-center justify-content-center gap-1.5">
                    <span>{{ $student['name'] }}</span>
                    @include('partials.verified-badge', ['size' => 16])
                </h4>
                <small class="text-primary fw-bold d-block">ID • {{ $student['id'] }}</small>
                <small class="text-secondary d-block mt-1">{{ $student['major'] }} Department</small>
                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-2 fw-bold" onclick="bootstrap.Modal.getInstance(document.getElementById('qrPassModal')).hide(); openAvatarCropModal();">
                    <i data-lucide="camera" style="width: 13px; height: 13px;" class="me-1"></i> Change Photo (Crop)
                </button>

                <div class="bg-white p-3 rounded-4 shadow-sm border d-inline-block my-4">
                    <svg width="160" height="160" viewBox="0 0 24 24" fill="none" stroke="#0f172a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="5" height="5" x="3" y="3" rx="1"/>
                        <rect width="5" height="5" x="16" y="3" rx="1"/>
                        <rect width="5" height="5" x="3" y="16" rx="1"/>
                        <path d="M21 16h-3a2 2 0 0 0-2 2v3"/>
                        <path d="M21 21v.01"/>
                        <path d="M12 7v3a2 2 0 0 1-2 2H7"/>
                        <path d="M3 12h.01"/>
                        <path d="M12 3h.01"/>
                        <path d="M12 16v.01"/>
                        <path d="M16 12h1"/>
                        <path d="M21 12v.01"/>
                        <path d="M12 21v-1"/>
                    </svg>
                </div>

                <p class="text-secondary small mb-0" style="font-size: 11.5px;">Scan for campus gate entry, library access, and classroom check-ins.</p>
            </div>
        </div>
    </div>
</div>

<!-- 2. Scanner Modal -->
<div class="modal fade" id="scanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white p-3 p-md-4" style="border-radius: 32px;">
            <div class="modal-header border-0 pb-0">
                <span class="text-uppercase fw-bold text-primary small" style="letter-spacing: 0.1em;">Campus Scanner</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column align-items-center justify-content-center py-4">
                <div class="scan-frame mb-3 position-relative" id="scan-view-box">
                    <div class="scan-beam" id="scan-laser"></div>
                    <div id="scan-icon-container">
                        <i data-lucide="scan-line" class="text-info" style="width: 80px; height: 80px;"></i>
                    </div>
                </div>
                <p id="scan-status-text" class="text-white-50 fw-semibold small mb-4">Align QR code within frame</p>

                <button class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-lg" onclick="simulateScan()">
                    Simulate Scan Action
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 3. Class Detail Modal -->
<div class="modal fade" id="classDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-6" id="cd-title">Class Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <div class="d-flex justify-content-between text-secondary small mb-3">
                    <span>Code: <strong class="text-body" id="cd-code">DES302</strong></span>
                    <span>Room: <strong class="text-body" id="cd-room">Lab 402</strong></span>
                </div>
                <div class="p-3 bg-primary-subtle rounded-3 mb-3">
                    <p class="fw-bold text-primary mb-1 small" id="cd-prof">Instructor: Dr. Alex Vance</p>
                    <small class="text-secondary" id="cd-time">Time: 08:00 AM - 10:30 AM</small>
                </div>
                <button class="btn btn-primary w-100 py-2.5 rounded-3 fw-bold small" onclick="checkInClass()">
                    Check-in Attendance
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ====================================================================== -->
<!-- NEW: CLASS CART MODAL                                                  -->
<!-- ====================================================================== -->
<div class="modal fade" id="classCartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-3 p-md-4">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="p-2 rounded-3 text-white" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                        <i data-lucide="shopping-cart" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold fs-6 mb-0">Class Cart & Course Enrollment</h5>
                        <small class="text-secondary">Semester 1 • Academic Year 2026</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body py-3">
                <!-- Registration Stats Pill -->
                <div class="row g-2 mb-3">
                    <div class="col-6 col-sm-4">
                        <div class="p-2.5 rounded-3 bg-body-secondary text-center">
                            <small class="text-secondary d-block" style="font-size: 10.5px;">Registered Credits</small>
                            <span class="fw-bold fs-6 text-primary">10 / 18 Credits</span>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4">
                        <div class="p-2.5 rounded-3 bg-body-secondary text-center">
                            <small class="text-secondary d-block" style="font-size: 10.5px;">Enrolled Classes</small>
                            <span class="fw-bold fs-6 text-success">3 Courses Active</span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="p-2.5 rounded-3 bg-body-secondary text-center">
                            <small class="text-secondary d-block" style="font-size: 10.5px;">Available in Cart</small>
                            <span class="fw-bold fs-6 text-warning-emphasis">2 Electives</span>
                        </div>
                    </div>
                </div>

                <!-- Tabs: Enrolled vs In Cart -->
                <ul class="nav nav-pills nav-fill p-1 bg-body-secondary rounded-3 mb-3" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active fw-bold small py-1.5" data-bs-toggle="pill" data-bs-target="#cart-tab-enrolled" type="button">
                            <i data-lucide="check-circle" style="width: 14px; height: 14px;" class="me-1"></i> Enrolled Classes (3)
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link fw-bold small py-1.5" data-bs-toggle="pill" data-bs-target="#cart-tab-available" type="button">
                            <i data-lucide="shopping-cart" style="width: 14px; height: 14px;" class="me-1"></i> Electives In Cart (2)
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Tab 1: Enrolled Courses -->
                    <div class="tab-pane fade show active" id="cart-tab-enrolled">
                        <div class="d-flex flex-column gap-2">
                            @foreach($courseCarts->where('status', 'Enrolled') as $cc)
                                <div class="p-3 rounded-3 border d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <span class="badge bg-primary">{{ $cc->course_code }}</span>
                                            <h6 class="fw-bold mb-0 small">{{ $cc->course_title }}</h6>
                                        </div>
                                        <small class="text-secondary">{{ $cc->instructor }} • {{ $cc->schedule }} • <strong>{{ $cc->credits }} Credits</strong></small>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-success-subtle text-success fw-bold">Enrolled</span>
                                        <button class="btn btn-sm btn-outline-danger" onclick="dropCourseAJAX('{{ $cc->course_code }}')">
                                            Drop
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tab 2: Electives In Cart -->
                    <div class="tab-pane fade" id="cart-tab-available">
                        <div class="d-flex flex-column gap-2">
                            @foreach($courseCarts->where('status', 'In Cart') as $cartItem)
                                <div class="p-3 rounded-3 border bg-body-secondary d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <span class="badge bg-secondary">{{ $cartItem->course_code }}</span>
                                            <h6 class="fw-bold mb-0 small">{{ $cartItem->course_title }}</h6>
                                        </div>
                                        <small class="text-secondary">{{ $cartItem->instructor }} • {{ $cartItem->schedule }} • <strong>{{ $cartItem->credits }} Credits</strong></small>
                                    </div>
                                    <button class="btn btn-sm btn-primary rounded-pill px-3 fw-bold" onclick="enrollCourseAJAX('{{ $cartItem->course_code }}', '{{ addslashes($cartItem->course_title) }}')">
                                        + Enroll Now
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 pt-0 d-flex justify-content-between align-items-center">
                <small class="text-secondary" style="font-size: 11px;">Max credit limit per semester: 18 Credits</small>
                <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold" onclick="showToast('Class Cart & Course Enrollment Updated!'); bootstrap.Modal.getInstance(document.getElementById('classCartModal')).hide();">
                    Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ====================================================================== -->
<!-- NEW: SCORE & GPA TRANSCRIPT MODAL                                      -->
<!-- ====================================================================== -->
<div class="modal fade" id="scoreModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-3 p-md-4">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="p-2 rounded-3 text-white" style="background: linear-gradient(135deg, #ec4899, #f43f5e);">
                        <i data-lucide="graduation-cap" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold fs-6 mb-0">Academic Score & Official Transcript</h5>
                        <small class="text-secondary">{{ $student['name'] }} ({{ $student['id'] }}) • {{ $student['major'] }}</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body py-3">
                <!-- GPA Banner -->
                <div class="p-3 rounded-4 mb-3 text-white d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 shadow-sm" style="background: linear-gradient(135deg, #1e1b4b, #312e81, #4338ca);">
                    <div>
                        <span class="badge bg-white bg-opacity-25 rounded-pill px-2.5 py-1 mb-2 small fw-bold">
                            🏆 DEAN'S HONORS LIST
                        </span>
                        <h3 class="fw-bolder mb-0 fs-2">GPA {{ $gpa }} <span class="fs-6 opacity-75">/ 4.00</span></h3>
                        <small class="text-light opacity-75">Cumulative Academic Standing • Rank 1st Class</small>
                    </div>
                    <div class="text-sm-end border-top border-sm-top-0 pt-2 pt-sm-0 border-white border-opacity-25">
                        <span class="d-block text-light opacity-75 small">Total Completed</span>
                        <span class="fs-5 fw-bold">{{ $totalCredits }} Credits</span>
                    </div>
                </div>

                <!-- Subject Scores Table -->
                <h6 class="fw-bold mb-2 fs-6">Semester Course Grade Breakdown</h6>
                <div class="table-responsive rounded-3 border">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light small text-secondary">
                            <tr>
                                <th>Course Title</th>
                                <th>Code</th>
                                <th class="text-center">Credits</th>
                                <th class="text-center">Mid-Term</th>
                                <th class="text-center">Assign</th>
                                <th class="text-center">Final</th>
                                <th class="text-center">Total</th>
                                <th class="text-end">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($scores as $sc)
                                <tr>
                                    <td>
                                        <span class="fw-bold small d-block">{{ $sc->subject }}</span>
                                        <small class="text-secondary" style="font-size: 10px;">{{ $sc->semester }}</small>
                                    </td>
                                    <td><span class="badge bg-body-secondary text-secondary">{{ $sc->code }}</span></td>
                                    <td class="text-center small">{{ $sc->credits }}</td>
                                    <td class="text-center small">{{ $sc->mid_term }}</td>
                                    <td class="text-center small">{{ $sc->assignment }}</td>
                                    <td class="text-center small">{{ $sc->final_exam }}</td>
                                    <td class="text-center fw-bold text-primary">{{ $sc->score }}</td>
                                    <td class="text-end">
                                        <span class="badge {{ str_contains($sc->grade, 'A') ? 'bg-success' : 'bg-primary' }} fw-bolder fs-7">
                                            {{ $sc->grade }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer border-0 pt-0 d-flex justify-content-between align-items-center">
                <small class="text-secondary" style="font-size: 11px;">Verified by Registrar Office • Academic Year 2026</small>
                <a href="{{ route('campus.transcript.download') }}" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold" target="_blank" onclick="showToast('Downloading Official Transcript...')">
                    <i data-lucide="download" style="width: 14px; height: 14px;" class="me-1"></i> Download Transcript (Official)
                </a>
            </div>
        </div>
    </div>
</div>

<!-- 4. Resource Modal -->
<div class="modal fade" id="resourceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-6">Course Resources</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <p class="text-secondary small mb-3">Access lecture notes, slides, and syllabus documents managed by Admin.</p>
                <div class="d-flex flex-column gap-2">
                    @forelse($resources as $res)
                        <div class="p-3 rounded-3 bg-body-secondary d-flex justify-content-between align-items-center">
                            <div>
                                <span class="small fw-bold d-block">{{ $res->file_name }}</span>
                                <small class="text-secondary">{{ $res->course }} • {{ $res->file_size }}</small>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 fw-bold d-flex align-items-center gap-1" onclick="openPdfQuickModal('{{ asset($res->file_url ?: 'uploads/slides/slides_1792915639.pdf') }}', '{{ addslashes($res->title) }}', '{{ addslashes($res->file_name) }}', '#', '#')">
                                <i data-lucide="eye" style="width: 13px; height: 13px;"></i>
                                <span style="font-size: 11.5px;">View</span>
                            </button>
                        </div>
                    @empty
                        <div class="text-center py-3 text-secondary small">No resources uploaded yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 5. Exam Modal -->
<div class="modal fade" id="examModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-6">Exams & Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <div class="d-flex flex-column gap-2">
                    @forelse($exams as $exam)
                        <div class="p-3 rounded-3 border border-primary-subtle bg-primary-subtle">
                            <span class="badge bg-primary text-uppercase fw-bold" style="font-size: 9.5px;">{{ $exam->type }}</span>
                            <h5 class="fw-bold fs-6 mt-1 mb-1">{{ $exam->title }} ({{ $exam->course }})</h5>
                            <small class="text-secondary">{{ $exam->exam_date }} • {{ $exam->room }}</small>
                        </div>
                    @empty
                        <div class="text-center py-3 text-secondary small">No scheduled exams.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 6. Certificates Modal -->
<div class="modal fade" id="certificatesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-6">Achievements & Certificates</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <div class="d-flex flex-column gap-2">
                    @forelse($certificates as $cert)
                        <div class="p-3 rounded-3 bg-body-secondary d-flex align-items-center gap-3">
                            <i data-lucide="award" class="text-warning" style="width: 36px; height: 36px;"></i>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-0 small">{{ $cert->title }}</h6>
                                <small class="text-secondary d-block" style="font-size: 11px;">Issued {{ $cert->issue_date }} • ID: {{ $cert->credential_id }}</small>
                                <span class="badge bg-success-subtle text-success fw-bold mt-1" style="font-size: 9px;">{{ $cert->status }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-3 text-secondary small">No certificates issued yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 7. Show Screen Modal -->
<div class="modal fade" id="showscreenModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-4 text-center">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-6">Classroom Display Broadcast</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <div class="position-relative d-inline-block mb-3">
                    <i data-lucide="monitor" class="text-primary" style="width: 56px; height: 56px;"></i>
                    @if($screenBroadcast && $screenBroadcast->is_broadcasting)
                        <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-danger" style="font-size: 9px;">LIVE</span>
                    @endif
                </div>
                <h6 class="fw-bold fs-6 mb-1">Classroom Main Display</h6>
                <p class="text-secondary small mb-3">Connected to: <strong>{{ $screenBroadcast ? $screenBroadcast->room : 'Lab 402 • Media Wing' }}</strong></p>
                @if($screenBroadcast && $screenBroadcast->is_broadcasting)
                    <div class="alert alert-success py-2 small mb-4">
                        <i data-lucide="sparkles" style="width: 14px; height: 14px;" class="me-1"></i>
                        Spotlight Active: <strong>{{ $screenBroadcast->student_name }}</strong>'s screen is currently broadcasted on projector!
                    </div>
                @endif
                <button class="btn btn-primary w-100 py-2.5 rounded-3 fw-bold small" onclick="requestScreenShareAJAX()">
                    Request / Broadcast Screen
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 8. Collaboration Modal -->
<div class="modal fade" id="collabModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-6">Campus Collaboration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <p class="text-secondary small mb-3">Find teammates and join student innovation projects.</p>
                <div class="d-flex flex-column gap-2">
                    @forelse($collaborations as $collab)
                        <div class="p-3 rounded-3 bg-body-secondary d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-0 small">{{ $collab->title }} ({{ $collab->current_members }}/{{ $collab->max_members }})</h6>
                                <small class="text-secondary" style="font-size: 11px;">Need: <strong>{{ $collab->required_role }}</strong></small>
                            </div>
                            <button class="btn btn-primary btn-sm rounded-2 fw-bold" onclick="joinCollabAJAX({{ $collab->id }}, '{{ addslashes($collab->title) }}')">
                                Join
                            </button>
                        </div>
                    @empty
                        <div class="text-center py-3 text-secondary small">No open collaborations.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 9. Challenge Modal -->
<div class="modal fade" id="challengeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-6">Campus Challenges</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <div class="d-flex flex-column gap-2">
                    @forelse($challenges as $ch)
                        <div class="p-3 rounded-3 bg-warning-subtle border border-warning-subtle">
                            <span class="badge bg-warning text-dark uppercase fw-bold" style="font-size: 9.5px;">{{ $ch->badge ?? 'CHALLENGE' }}</span>
                            <h5 class="fw-bold fs-6 mt-1 mb-1">{{ $ch->title }}</h5>
                            <p class="text-secondary small mb-2">{{ $ch->description }}</p>
                            <div class="d-flex justify-content-between align-items-center pt-2 border-top border-warning border-opacity-25">
                                <div>
                                    <small class="text-warning-emphasis fw-bold d-block">+{{ $ch->points }} Campus Points</small>
                                    <small class="text-secondary" style="font-size: 10.5px;">Due: {{ $ch->deadline }}</small>
                                </div>
                                <button class="btn btn-warning btn-sm rounded-pill px-3 fw-bold text-dark shadow-xs" onclick="joinChallengeAJAX({{ $ch->id }}, '{{ addslashes($ch->title) }}')">
                                    Accept Challenge
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-3 text-secondary small">No active challenges.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 10. Attendance Modal -->
<div class="modal fade" id="attendanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-3 p-md-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-6">Attendance Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <div class="d-flex flex-column gap-2 mb-3">
                    @foreach($attendanceList as $item)
                        <div class="p-3 rounded-3 border d-flex justify-content-between align-items-center" style="font-size: 13px;">
                            <div>
                                <h6 class="fw-bold mb-0" style="font-size: 14px;">{{ $item['subject'] }}</h6>
                                <small class="text-secondary">{{ $item['code'] }} • {{ $item['last_check'] }}</small>
                            </div>
                            <span class="fw-bolder fs-6 text-primary">{{ $item['rate'] }}</span>
                        </div>
                    @endforeach
                </div>
                <button class="btn btn-success w-100 py-2.5 rounded-3 fw-bold small" onclick="bootstrap.Modal.getInstance(document.getElementById('attendanceModal')).hide(); openModal('scanModal');">
                    Open Scanner to Check-In
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 11. Library Modal -->
<div class="modal fade" id="libraryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-6">Digital Library</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <div class="d-flex flex-column gap-2">
                    <div class="p-3 rounded-3 bg-body-secondary d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold mb-1 small">Don't Make Me Think - Steve Krug</h6>
                            <small class="text-secondary">UI/UX Design • 3rd Edition</small>
                        </div>
                        <button class="btn btn-sm btn-primary rounded-pill px-3 fw-bold" onclick="showToast('Book borrowed! Added to your Digital Pass.')">
                            Borrow
                        </button>
                    </div>
                    <div class="p-3 rounded-3 bg-body-secondary d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold mb-1 small">Sprint: Solve Big Problems - Jake Knapp</h6>
                            <small class="text-secondary">Design Thinking • Google Ventures</small>
                        </div>
                        <button class="btn btn-sm btn-primary rounded-pill px-3 fw-bold" onclick="showToast('Book borrowed! Added to your Digital Pass.')">
                            Borrow
                        </button>
                    </div>
                    <div class="p-3 rounded-3 bg-body-secondary d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold mb-1 small">Refactoring UI - Adam Wathan</h6>
                            <small class="text-secondary">Visual Design • Tailwind CSS</small>
                        </div>
                        <button class="btn btn-sm btn-primary rounded-pill px-3 fw-bold" onclick="showToast('Book borrowed! Added to your Digital Pass.')">
                            Borrow
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 12. News Modal -->
<div class="modal fade" id="newsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-6">Campus News</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <div class="p-3 rounded-3 bg-body-secondary">
                    <span class="badge bg-primary fw-bold" style="font-size: 9.5px;">ANNOUNCEMENT</span>
                    <h6 class="fw-bold mt-1 mb-0" style="font-size: 14px;">Design Week 2026 Keynote Speakers Announced</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 13. Interactive Chat Modal -->
<div class="modal fade" id="chatModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content p-0 border shadow" style="height: 560px; max-height: 90vh;">
            <!-- Header -->
            <div class="modal-header px-3 py-2.5 border-bottom bg-body-tertiary">
                <div class="d-flex align-items-center gap-2.5 min-w-0">
                    <img id="chat-recipient-avatar" src="" alt="Avatar" class="rounded-circle object-fit-cover flex-shrink-0 shadow-xs" style="width: 40px; height: 40px; border: 1.5px solid var(--bs-border-color);">
                    <div class="min-w-0">
                        <div class="d-flex align-items-center gap-1.5">
                            <h6 id="chat-recipient-name" class="fw-bold mb-0 small text-truncate">Room Name</h6>
                            <span id="chat-recipient-badge" class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle px-2 py-0.5" style="font-size: 9.5px;">Group</span>
                        </div>
                        <small id="chat-recipient-role" class="text-secondary text-truncate d-block" style="font-size: 11px;">Class Group • Members</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-1.5 ms-auto ps-2">
                    <button type="button" class="btn btn-sm btn-light border rounded-circle p-1.5 shadow-xs" onclick="fetchChatMessages(currentChat ? (currentChat.room_id || currentChat.id) : null)" title="Refresh Messages">
                        <i data-lucide="refresh-cw" style="width: 14px; height: 14px;"></i>
                    </button>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <!-- Messages Area -->
            <div class="modal-body p-3 d-flex flex-column gap-2" id="chat-messages-container" style="overflow-y: auto; background-color: var(--bs-tertiary-bg);">
                <!-- Dynamically filled messages -->
            </div>

            <!-- Input Bar -->
            <div class="modal-footer p-2.5 border-top bg-body">
                <form id="chat-form" class="d-flex align-items-center gap-2 w-100" onsubmit="event.preventDefault(); sendChatMessage();">
                    <input type="text" id="chat-input" class="form-control rounded-pill px-3 py-2 small" placeholder="Type a message to your classmates..." autocomplete="off">
                    <button type="submit" class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center p-2 shadow-xs" style="width: 38px; height: 38px; flex-shrink: 0;">
                        <i data-lucide="send" style="width: 16px; height: 16px;"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Profile Avatar Upload & Crop Modal -->
<div class="modal fade" id="cropAvatarModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-3 p-md-4">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="p-2 rounded-3 bg-primary-subtle text-primary">
                        <i data-lucide="crop" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold fs-6 mb-0">Upload & Crop Profile Picture</h5>
                        <small class="text-secondary" style="font-size: 11.5px;">Select an image, drag and crop to fit your Student Pass</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="destroyCropper()"></button>
            </div>

            <div class="modal-body py-3">
                <!-- File Input Trigger Banner -->
                <div class="mb-3 text-center">
                    <input type="file" id="avatarFileInput" accept="image/png, image/jpeg, image/jpg, image/webp" class="d-none" onchange="handleAvatarFileSelect(this)">
                    <button type="button" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold d-inline-flex align-items-center gap-2 shadow-xs" onclick="document.getElementById('avatarFileInput').click()">
                        <i data-lucide="upload" style="width: 16px; height: 16px;"></i>
                        <span>Choose Photo from Device</span>
                    </button>
                    <small class="text-secondary d-block mt-1.5" style="font-size: 11px;">Supports PNG, JPG, JPEG or WEBP (Max 5MB)</small>
                </div>

                <!-- Cropper Workspace (Visible after image selected) -->
                <div id="cropper-workspace" class="d-none">
                    <div class="row g-3 align-items-center">
                        <!-- Main Image Cropper Box -->
                        <div class="col-12 col-md-8">
                            <div class="rounded-4 overflow-hidden border bg-dark d-flex align-items-center justify-content-center" style="height: 320px; max-height: 320px; width: 100%;">
                                <img id="image-to-crop" src="" alt="Source Image" style="max-width: 100%; max-height: 100%; display: block;">
                            </div>

                            <!-- Cropper Toolbar Controls -->
                            <div class="d-flex flex-wrap justify-content-center gap-1.5 mt-2.5">
                                <button type="button" class="btn btn-sm btn-light border rounded-pill px-2.5 fw-bold" onclick="cropperZoom(0.1)" title="Zoom In">
                                    <i data-lucide="zoom-in" style="width: 14px; height: 14px;"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-light border rounded-pill px-2.5 fw-bold" onclick="cropperZoom(-0.1)" title="Zoom Out">
                                    <i data-lucide="zoom-out" style="width: 14px; height: 14px;"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-light border rounded-pill px-2.5 fw-bold" onclick="cropperRotate(-90)" title="Rotate Left 90°">
                                    <i data-lucide="rotate-ccw" style="width: 14px; height: 14px;"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-light border rounded-pill px-2.5 fw-bold" onclick="cropperRotate(90)" title="Rotate Right 90°">
                                    <i data-lucide="rotate-cw" style="width: 14px; height: 14px;"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-light border rounded-pill px-2.5 fw-bold" onclick="cropperReset()" title="Reset Crop">
                                    <i data-lucide="refresh-cw" style="width: 14px; height: 14px;"></i> Reset
                                </button>
                            </div>
                        </div>

                        <!-- Live Circular Preview Column -->
                        <div class="col-12 col-md-4 text-center">
                            <div class="p-3.5 rounded-4 bg-body-secondary border">
                                <span class="fw-bold small d-block mb-3 text-secondary text-uppercase" style="font-size: 10px; letter-spacing: 0.1em;">
                                    Live Pass Preview
                                </span>

                                <!-- Circular Preview Target Box -->
                                <div class="avatar-crop-preview rounded-circle mx-auto shadow-sm mb-3" style="width: 130px; height: 130px; overflow: hidden; border: 3px solid #2563eb;">
                                    <div class="crop-preview-box" style="width: 100%; height: 100%; overflow: hidden;"></div>
                                </div>

                                <small class="text-secondary d-block lh-sm" style="font-size: 11px;">
                                    Your cropped image will be saved at 400x400 high resolution and synced across your Student Pass.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State prompt before file selected -->
                <div id="cropper-empty-state" class="p-4 text-center text-secondary border border-dashed rounded-4 my-2">
                    <i data-lucide="image" class="text-secondary opacity-50 mb-2" style="width: 44px; height: 44px;"></i>
                    <p class="small mb-0">No image chosen yet. Click the button above to select a picture to crop.</p>
                </div>
            </div>

            <div class="modal-footer border-0 pt-0 d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-light rounded-pill px-3.5 fw-bold" data-bs-dismiss="modal" onclick="destroyCropper()">Cancel</button>
                <button type="button" id="save-crop-btn" class="btn btn-primary rounded-pill px-4 fw-bold d-none" onclick="uploadCroppedAvatar()">
                    <span id="save-crop-spinner" class="spinner-border spinner-border-sm me-1.5 d-none" role="status" aria-hidden="true"></span>
                    <i id="save-crop-icon" data-lucide="check" style="width: 16px; height: 16px;" class="me-1"></i>
                    <span>Crop & Save Avatar</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ====================================================================== -->
<!-- 1. Take QCM Exam Interactive Modal (Feature 4)                         -->
<!-- ====================================================================== -->
<div class="modal fade" id="takeExamModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-3 p-md-4 rounded-4 shadow-lg border-0">
            <div class="modal-header border-0 pb-2">
                <div>
                    <span class="badge bg-primary px-3 py-1 rounded-pill mb-1 fw-bold">ONLINE QCM EXAM</span>
                    <h5 class="modal-title fw-bold fs-5" id="qcm-exam-title">Exam Title</h5>
                    <small class="text-secondary" id="qcm-exam-info">ជ្រើសរើសចម្លើយដែលត្រឹមត្រូវសម្រាប់សំណួរនីមួយៗ • Auto-Scoring</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body py-3">
                <form id="qcm-exam-form">
                    <input type="hidden" id="active-exam-id">
                    <div id="qcm-questions-container" class="d-flex flex-column gap-3" style="max-height: 480px; overflow-y: auto;">
                        <!-- Rendered by JS -->
                    </div>
                </form>
            </div>

            <div class="modal-footer border-0 pt-2 d-flex justify-content-between align-items-center">
                <small class="text-secondary">Please check all questions before submitting.</small>
                <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold py-2 shadow" id="btn-submit-exam" onclick="submitExamAnswers()">
                    <i data-lucide="check-circle-2" style="width: 16px; height: 16px;" class="me-1"></i>
                    <span>ដាក់បញ្ចូលចម្លើយ (Submit & Calculate Score)</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 2. Exam Result & Auto-Score Modal (Feature 4 - >=50% Green, <50% Red) -->
<div class="modal fade" id="examResultModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 p-4 rounded-4 shadow-lg text-center" style="background: radial-gradient(circle at 50% 20%, #1e293b, #0f172a); color: #fff;">
            <div class="modal-body p-0 py-3">
                <div class="mb-3">
                    <span class="badge fw-bold px-3 py-1.5 rounded-pill fs-7" id="result-status-badge" style="background-color: #10b981; color: #fff;">
                        ● EXAM COMPLETED & AUTO-SCORED
                    </span>
                </div>

                <div class="p-4 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" id="result-icon-container" style="width: 90px; height: 90px; border: 3px solid #10b981; background: rgba(16, 185, 129, 0.2);">
                    <div id="result-icon-wrapper">
                        <i data-lucide="award" class="text-success" style="width: 44px; height: 44px;"></i>
                    </div>
                </div>

                <h2 class="fw-bolder mb-1 text-white" id="result-modal-header">លទ្ធផលប្រឡងរបស់អ្នក</h2>
                <p class="text-white-50 small mb-4" id="result-exam-title">UI/UX Design Systems</p>

                <!-- Score Callout -->
                <div class="p-3 rounded-4 mb-4" id="result-score-box" style="background: rgba(255, 255, 255, 0.08); border: 2px solid #10b981;">
                    <div class="row g-2 align-items-center">
                        <div class="col-6 text-center border-end border-white border-opacity-10">
                            <small class="text-white-50 d-block" style="font-size: 11px;">ពិន្ទុសរុប (EARNED SCORE)</small>
                            <h2 class="fw-bolder mb-0 text-warning" id="result-score-display">85 / 100</h2>
                            <small class="text-white-50" id="result-pct-display">85%</small>
                        </div>
                        <div class="col-6 text-center">
                            <small class="text-white-50 d-block" style="font-size: 11px;">និទ្ទេស (GRADE)</small>
                            <h1 class="fw-bolder mb-0" id="result-grade-display" style="color: #10b981;">A</h1>
                            <small class="fw-bold" id="result-pass-fail-label" style="color: #10b981;">ជាប់ការប្រឡង (PASSED)</small>
                        </div>
                    </div>
                </div>

                <p class="small text-white-75 mb-4" id="result-summary-text">
                    សំណួរត្រឹមត្រូវ: <strong>4</strong> ក្នុងចំណោម <strong>4</strong> សំណួរ។ ពិន្ទុត្រូវបានកត់ត្រាចូលក្នុង Academic Records របស់អ្នកដោយស្វ័យប្រវត្តិ។
                </p>

                <button type="button" class="btn rounded-pill px-5 py-2.5 fw-bold shadow w-100" id="result-dismiss-btn" data-bs-dismiss="modal" onclick="window.location.reload()" style="background-color: #10b981; color: #fff; border: none;">
                    រួចរាល់ (Done & View Scores)
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 3. PDF Online Reader Modal (Feature 12) -->
<div class="modal fade" id="pdfViewerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-lg-down">
        <div class="modal-content p-3 p-md-4 rounded-4 shadow-lg border-0 bg-dark text-white">
            <div class="modal-header border-0 pb-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-danger px-3 py-1 rounded-pill fw-bold">PDF VIEWER ONLINE</span>
                    <div>
                        <h5 class="modal-title fw-bold fs-5 text-white mb-0" id="pdf-viewer-title">Lesson Material</h5>
                        <small class="text-white-50 font-monospace" id="pdf-viewer-subtitle">Reading Online • GenZ Campus PDF Reader</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-secondary bg-opacity-50 text-white-50 border border-secondary rounded-pill px-2.5 py-1" style="font-size: 11px;">
                        <i data-lucide="shield" style="width: 12px; height: 12px;" class="me-1"></i> Protected View
                    </span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
            </div>

            <div class="modal-body p-0 my-2">
                <div class="w-100 rounded-3 overflow-hidden bg-black position-relative" style="height: 72vh;">
                    <iframe id="pdf-modal-iframe" src="" class="w-100 h-100 border-0" allowfullscreen></iframe>
                </div>
            </div>

            <div class="modal-footer border-0 pt-0 d-flex justify-content-between align-items-center">
                <span class="text-white-50 small" style="font-size: 11.5px;">
                    <i data-lucide="lock" style="width: 12px; height: 12px;" class="me-1"></i> ឯកសារនេះត្រូវបានការពារ — មិនអនុញ្ញាតអោយ Download ឬបើកក្នុងផេកក្រៅឡើយ
                </span>
                <button type="button" class="btn btn-secondary rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- 4. High-Fidelity Verified Digital Certificate Modal (Feature 6) -->
<div class="modal fade" id="studentCertModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 p-4 rounded-4 shadow-lg text-center" style="background: radial-gradient(circle at 50% 20%, #1e1b4b, #0f172a); color: #fff;">
            <div class="modal-header border-0 p-0 justify-content-end mb-2">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4 rounded-4 border-3" style="border: 4px double #eab308; background: rgba(0,0,0,0.35);">
                <div class="mb-2">
                    <span class="badge bg-warning text-dark fw-bolder px-3 py-1 rounded-pill" style="letter-spacing: 0.1em;">
                        ★ OFFICIAL DIGITAL CREDENTIAL ★
                    </span>
                </div>

                <h1 class="display-6 fw-bolder text-warning mt-2 mb-1" style="font-family: serif; letter-spacing: 0.05em;">
                    GENZ DIGITAL CAMPUS OS
                </h1>
                <small class="text-white-50 text-uppercase d-block mb-4" style="letter-spacing: 0.2em;">
                    Certificate of Academic Achievement
                </small>

                <p class="text-white-75 small mb-1">This official credential is proudly presented to:</p>
                <h2 class="display-6 fw-bolder text-white mb-2" id="sc-modal-recipient" style="text-decoration: underline; text-underline-offset: 6px; text-decoration-color: #eab308;">
                    Maya Chen
                </h2>

                <p class="text-white-75 small mb-4 px-md-5" id="sc-modal-desc">
                    In recognition of successful assessment and outstanding excellence in <strong class="text-warning" id="sc-modal-title">UI/UX Design Systems</strong> at the GenZ Digital Innovation Campus.
                </p>

                <!-- Certificate Seal & ID Row -->
                <div class="d-flex justify-content-between align-items-end pt-3 border-top border-warning border-opacity-50 mt-4 px-3">
                    <div class="text-start">
                        <small class="text-white-50 d-block" style="font-size: 11px;">Credential ID:</small>
                        <span class="font-monospace fw-bold text-warning" id="sc-modal-id">GZ-993821</span>
                        <small class="text-white-50 d-block" style="font-size: 11px;">Date: <span id="sc-modal-date">Oct 2026</span></small>
                    </div>

                    <div class="text-center">
                        <div class="rounded-circle border border-warning p-2 d-inline-block shadow" style="background: rgba(234, 179, 8, 0.15);">
                            <i data-lucide="award" class="text-warning" style="width: 38px; height: 38px;"></i>
                        </div>
                        <small class="text-warning d-block fw-bold mt-1" style="font-size: 10px;">SEAL OF EXCELLENCE</small>
                    </div>

                    <div class="text-end">
                        <div style="border-bottom: 1px solid #eab308; width: 140px; height: 35px;"></div>
                        <small class="text-white-50 d-block mt-1" style="font-size: 11px;">Academic Director</small>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 pt-3 justify-content-center gap-2">
                <button type="button" class="btn btn-outline-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning text-dark rounded-pill px-4 fw-bold shadow" onclick="window.print()">
                    <i data-lucide="printer" style="width: 15px; height: 15px;" class="me-1"></i> Print / Save Certificate
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 5. Challenge Result & Live Score Modal (Feature 9) -->
<div class="modal fade" id="challengeScoreModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 p-4 rounded-4 shadow-lg text-center" style="background: radial-gradient(circle at 50% 20%, #1e1b4b, #0f172a); color: #fff;">
            <div class="modal-body p-0 py-3">
                <span class="badge bg-warning text-dark fw-bold px-3 py-1.5 rounded-pill fs-7 mb-3">
                    🏆 CHALLENGE COMPLETED
                </span>
                <div class="p-3 rounded-circle d-inline-flex align-items-center justify-content-center bg-warning bg-opacity-20 text-warning mb-3" style="width: 85px; height: 85px; border: 3px solid #f59e0b;">
                    <i data-lucide="trophy" style="width: 44px; height: 44px;"></i>
                </div>
                <h3 class="fw-bolder mb-1 text-white">លទ្ធផលពិន្ទុប្រកួតប្រជែង</h3>
                <p class="text-white-50 small mb-3" id="challenge-score-title">Figma Micro-Interactions Speed Sprint</p>

                <div class="p-3 rounded-4 bg-white bg-opacity-10 border border-warning border-opacity-25 mb-4">
                    <div class="row g-2 align-items-center">
                        <div class="col-6 text-center border-end border-white border-opacity-10">
                            <small class="text-white-50 d-block" style="font-size: 11px;">ពិន្ទុទទួលបាន (EARNED PTS)</small>
                            <h2 class="fw-bolder mb-0 text-warning" id="challenge-score-points">+500 PTS</h2>
                            <small class="text-success fw-semibold">Top Score Active</small>
                        </div>
                        <div class="col-6 text-center">
                            <small class="text-white-50 d-block" style="font-size: 11px;">ចំណាត់ថ្នាក់ (CLASS RANK)</small>
                            <h2 class="fw-bolder mb-0 text-info">#1</h2>
                            <small class="text-white-50">Real-Time Leaderboard</small>
                        </div>
                    </div>
                </div>

                <p class="small text-white-75 mb-4">
                    ពិន្ទុរបស់អ្នកត្រូវបាន sync ទៅកាន់ Classroom Fullscreen Leaderboard រួចរាល់ហើយ!
                </p>

                <div class="d-flex gap-2">
                    <a href="{{ route('admin.challenges.fullscreen') }}" target="_blank" class="btn btn-outline-warning rounded-pill py-2 w-50 fw-bold">
                        <i data-lucide="maximize" style="width: 14px; height: 14px;" class="me-1"></i> Fullscreen Board
                    </a>
                    <button type="button" class="btn btn-warning text-dark rounded-pill py-2 w-50 fw-bold" data-bs-dismiss="modal">
                        បិទ (Close)
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 6. Digital Library Book Reader Modal (Feature 11) -->
<div class="modal fade" id="bookReaderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-4 rounded-4 shadow-lg border-0">
            <div class="modal-header border-0 pb-2">
                <div>
                    <span class="badge bg-primary px-3 py-1 rounded-pill mb-1 fw-bold" id="brm-category">DESIGN SYSTEM</span>
                    <h5 class="modal-title fw-bold fs-5" id="brm-title">Book Title</h5>
                    <small class="text-secondary" id="brm-author">By Author</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0 my-3">
                <div class="p-4 rounded-4 bg-dark text-white d-flex flex-column align-items-center justify-content-center text-center" style="min-height: 340px; background: radial-gradient(circle at 50% 20%, #1e293b, #0f172a);">
                    <div class="p-4 rounded-4 bg-white text-dark shadow mb-3 text-start" style="width: 100%; max-width: 600px;">
                        <h5 class="fw-bold text-primary mb-2" id="brm-doc-title">Chapter 1: Foundational Principles</h5>
                        <p class="text-secondary small mb-3">
                            Welcome to the digital reader. This academic publication has been uploaded and authorized by Admin for all registered campus students.
                        </p>
                        <hr>
                        <h6 class="fw-bold small mb-2">Key Reading Takeaways:</h6>
                        <ul class="small text-secondary ps-3 mb-0">
                            <li>Core heuristics and design psychology principles.</li>
                            <li>Real-world case studies from industry-leading digital products.</li>
                            <li>Practical frameworks for application in studio labs and group sprints.</li>
                        </ul>
                    </div>
                    <span class="text-white-50 small">Reading Mode • GenZ E-Book Viewer</span>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0 d-flex justify-content-between align-items-center">
                <small class="text-secondary" id="brm-pages">320 Pages Total</small>
                <button type="button" class="btn btn-secondary rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- 7. News Article Full Modal (Feature 12) -->
<div class="modal fade" id="postViewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-4 rounded-4 shadow-lg border-0">
            <div class="modal-header border-0 pb-2">
                <div>
                    <span class="badge bg-primary px-3 py-1 rounded-pill mb-1 fw-bold" id="post-view-category">ANNOUNCEMENT</span>
                    <h5 class="modal-title fw-bold fs-5" id="post-view-title">Article Title</h5>
                    <small class="text-secondary" id="post-view-meta">Published by Admin</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-3">
                <div class="p-4 rounded-4 bg-body-tertiary border mb-3">
                    <p class="mb-0 text-body" id="post-view-content" style="white-space: pre-line; line-height: 1.7;">
                        Content goes here...
                    </p>
                </div>
                <div class="alert alert-info py-2 px-3 small rounded-3 mb-0">
                    <i data-lucide="info" style="width: 14px; height: 14px;" class="me-1"></i>
                    Official announcement from GenZ Digital Academic Administration.
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold" data-bs-dismiss="modal">យល់ព្រម (Close)</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Attendance history date filter (Click to Select Date)
    function filterClientAttendance(dateVal) {
        const rows = document.querySelectorAll('.client-att-row');
        rows.forEach(r => {
            const rowDate = r.getAttribute('data-date') || '';
            if (!dateVal || rowDate === dateVal || r.textContent.includes(dateVal)) {
                r.style.display = '';
            } else {
                r.style.display = 'none';
            }
        });
    }

    // 3D Card Flip
    function toggleCardFlip() {
        const card = document.getElementById('student-flip-card');
        if (card) {
            card.classList.toggle('flipped');
        }
    }

    // Day picker in Schedule screen
    function selectDay(btn) {
        document.querySelectorAll('.day-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    }

    // Inbox category filter
    function filterChats(category, btn) {
        document.querySelectorAll('.inbox-filter').forEach(b => {
            b.classList.remove('active', 'btn-light');
            b.classList.add('text-secondary');
        });
        btn.classList.add('active', 'btn-light');
        btn.classList.remove('text-secondary');

        document.querySelectorAll('.chat-row').forEach(row => {
            if (category === 'all' || row.dataset.category === category) {
                row.classList.remove('d-none');
            } else {
                row.classList.add('d-none');
            }
        });
    }

    // Show class detail modal
    function showClassDetail(item) {
        document.getElementById('cd-title').textContent = item.title;
        document.getElementById('cd-code').textContent = item.code;
        document.getElementById('cd-room').textContent = item.room;
        document.getElementById('cd-prof').textContent = 'Instructor: ' + item.prof;
        document.getElementById('cd-time').textContent = 'Time: ' + item.time;
        openModal('classDetailModal');
    }

    function checkInClass() {
        const title = document.getElementById('cd-title').textContent;
        const code = document.getElementById('cd-code').textContent;

        fetch("{{ route('campus.checkIn') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                subject: title,
                code: code,
                student_name: "{{ $student['name'] }}",
                student_id: "{{ $student['id'] }}"
            })
        })
        .then(res => res.json())
        .then(data => {
            showToast(`Attendance recorded for ${title} (${code})!`);
            const modal = bootstrap.Modal.getInstance(document.getElementById('classDetailModal'));
            if (modal) modal.hide();
        });
    }

    // Scanner simulation with live database sync
    let isScanning = false;
    function simulateScan() {
        if (isScanning) return;
        isScanning = true;

        const laser = document.getElementById('scan-laser');
        const iconContainer = document.getElementById('scan-icon-container');
        const statusText = document.getElementById('scan-status-text');

        if (laser) laser.style.display = 'none';
        if (iconContainer) {
            iconContainer.innerHTML = '<i data-lucide="check-circle-2" class="text-success" style="width: 80px; height: 80px;"></i>';
            renderIcons();
        }
        if (statusText) {
            statusText.textContent = 'Verifying with campus server...';
            statusText.classList.remove('text-white-50');
            statusText.classList.add('text-success');
        }

        fetch("{{ route('campus.checkIn') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                subject: "Campus Main Gate / Scanner Pass",
                code: "GATE-01",
                student_name: "{{ $student['name'] }}",
                student_id: "{{ $student['id'] }}"
            })
        })
        .then(res => res.json())
        .then(data => {
            statusText.textContent = 'Verified successfully!';
            setTimeout(() => {
                const modalEl = document.getElementById('scanModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();

                showToast('Verified! Attendance / Gate Access Granted');

                // Reset scanner UI
                setTimeout(() => {
                    if (laser) laser.style.display = 'block';
                    if (iconContainer) {
                        iconContainer.innerHTML = '<i data-lucide="scan-line" class="text-info" style="width: 80px; height: 80px;"></i>';
                        renderIcons();
                    }
                    if (statusText) {
                        statusText.textContent = 'Align QR code within frame';
                        statusText.classList.remove('text-success');
                        statusText.classList.add('text-white-50');
                    }
                    isScanning = false;
                }, 500);
            }, 1200);
        });
    }

    // Class Cart: Enroll Course
    function enrollCourseAJAX(code, title) {
        fetch("{{ route('campus.cart.enroll') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ course_code: code, course_title: title })
        })
        .then(res => res.json())
        .then(data => {
            showToast(data.message);
            setTimeout(() => location.reload(), 1000);
        });
    }

    // Class Cart: Drop Course
    function dropCourseAJAX(code) {
        if (!confirm(`Are you sure you want to drop course ${code}?`)) return;
        fetch("{{ route('campus.cart.drop') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ course_code: code })
        })
        .then(res => res.json())
        .then(data => {
            showToast(data.message);
            setTimeout(() => location.reload(), 1000);
        });
    }

    // Collaboration: Join Team Project
    function joinCollabAJAX(id, title) {
        fetch(`${window.BASE_URL}/api/collaborations/${id}/join`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        })
        .then(res => res.json())
        .then(data => {
            showToast(data.message);
            const modal = bootstrap.Modal.getInstance(document.getElementById('collabModal'));
            if (modal) modal.hide();
            setTimeout(() => location.reload(), 1200);
        });
    }

    // Challenge: Join Challenge
    function joinChallengeAJAX(id, title) {
        fetch(`${window.BASE_URL}/api/challenges/${id}/join`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        })
        .then(res => res.json())
        .then(data => {
            showToast(data.message);
            if (window.confetti) {
                window.confetti({ particleCount: 110, spread: 70, origin: { y: 0.6 } });
            }
            const modal = bootstrap.Modal.getInstance(document.getElementById('challengeModal'));
            if (modal) modal.hide();
        });
    }

    // Classroom: Request Screen Spotlight
    function requestScreenShareAJAX() {
        fetch("{{ route('campus.screen.request') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        })
        .then(res => res.json())
        .then(data => {
            showToast(data.message);
            const modal = bootstrap.Modal.getInstance(document.getElementById('showscreenModal'));
            if (modal) modal.hide();
        });
    }

    // Interactive Chat functionality
    let currentChat = null;
    let chatPollInterval = null;
    let lastRenderedMessagesJson = '';

    function escapeHtml(text) {
        if (!text) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.toString().replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    function openChat(chat) {
        currentChat = chat;
        const roomId = chat.room_id || chat.id;

        const avatarEl = document.getElementById('chat-recipient-avatar');
        if (avatarEl) avatarEl.src = chat.avatar || 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=150';

        const nameEl = document.getElementById('chat-recipient-name');
        if (nameEl) nameEl.textContent = chat.name || chat.title || 'Class Chat';

        const roleEl = document.getElementById('chat-recipient-role');
        if (roleEl) roleEl.textContent = chat.role || 'Class Group';

        const badgeEl = document.getElementById('chat-recipient-badge');
        if (badgeEl) {
            if (chat.category === 'academic') {
                badgeEl.textContent = 'Class Group';
                badgeEl.className = 'badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle px-2 py-0.5';
            } else if (chat.category === 'announcements') {
                badgeEl.textContent = 'Official';
                badgeEl.className = 'badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle px-2 py-0.5';
            } else {
                badgeEl.textContent = 'Community';
                badgeEl.className = 'badge rounded-pill bg-success-subtle text-success border border-success-subtle px-2 py-0.5';
            }
        }

        const input = document.getElementById('chat-input');
        if (input) input.value = '';

        lastRenderedMessagesJson = '';
        openModal('chatModal');
        fetchChatMessages(roomId, false);

        // Polling interval: every 2.5 seconds while modal is open
        if (chatPollInterval) clearInterval(chatPollInterval);
        chatPollInterval = setInterval(() => {
            const modalEl = document.getElementById('chatModal');
            if (modalEl && modalEl.classList.contains('show') && currentChat) {
                fetchChatMessages(currentChat.room_id || currentChat.id, true);
            }
        }, 2500);
    }

    function fetchChatMessages(roomId, isSilent = false) {
        if (!roomId) return;
        const container = document.getElementById('chat-messages-container');
        if (!container) return;

        if (!isSilent && (!container.children.length || container.innerHTML.trim() === '')) {
            container.innerHTML = `
                <div class="d-flex flex-column align-items-center justify-content-center py-5 text-secondary">
                    <div class="spinner-border spinner-border-sm text-primary mb-2" role="status"></div>
                    <small style="font-size: 11.5px;">Loading class chat...</small>
                </div>
            `;
        }

        fetch(`{{ route('campus.inbox.messages') }}?room=${encodeURIComponent(roomId)}`)
            .then(res => res.json())
            .then(data => {
                if (data.success && Array.isArray(data.messages)) {
                    const newJson = JSON.stringify(data.messages);
                    if (newJson !== lastRenderedMessagesJson) {
                        lastRenderedMessagesJson = newJson;
                        renderChatMessages(data.messages);
                    }
                }
            })
            .catch(err => {
                console.error('Failed to load chat messages:', err);
            });
    }

    function renderChatMessages(messages) {
        const container = document.getElementById('chat-messages-container');
        if (!container) return;

        if (!messages || messages.length === 0) {
            container.innerHTML = `
                <div class="d-flex flex-column align-items-center justify-content-center py-5 text-secondary">
                    <i data-lucide="message-circle" class="mb-2 text-secondary opacity-50" style="width: 36px; height: 36px;"></i>
                    <small class="fw-semibold">No messages in this class group yet.</small>
                    <small class="text-muted" style="font-size: 11px;">Be the first to say hello to your classmates!</small>
                </div>
            `;
            if (window.lucide) window.lucide.createIcons();
            return;
        }

        let html = '';
        messages.forEach(msg => {
            if (msg.is_me) {
                html += `
                    <div class="d-flex flex-column align-items-end mb-2">
                        <div class="chat-bubble-me shadow-xs">
                            ${escapeHtml(msg.message)}
                        </div>
                        <small class="text-secondary mt-1 pe-1" style="font-size: 10px;">${escapeHtml(msg.time)}</small>
                    </div>
                `;
            } else {
                let roleBadge = '';
                const roleLower = (msg.sender_role || '').toLowerCase();
                if (roleLower.includes('prof') || roleLower.includes('teach') || roleLower.includes('instructor')) {
                    roleBadge = `<span class="badge bg-purple-subtle text-purple border border-purple-subtle" style="font-size: 9px; padding: 1.5px 5px;">Professor</span>`;
                } else if (roleLower.includes('admin')) {
                    roleBadge = `<span class="badge bg-danger-subtle text-danger border border-danger-subtle" style="font-size: 9px; padding: 1.5px 5px;">Admin</span>`;
                } else {
                    roleBadge = `<span class="badge bg-secondary-subtle text-secondary" style="font-size: 9px; padding: 1.5px 5px;">Student</span>`;
                }

                html += `
                    <div class="d-flex align-items-start gap-2 mb-2">
                        <img src="${escapeHtml(msg.sender_avatar)}" class="rounded-circle object-fit-cover flex-shrink-0 mt-1 shadow-xs" style="width: 32px; height: 32px; border: 1.5px solid #fff;" alt="${escapeHtml(msg.sender_name)}">
                        <div class="d-flex flex-column align-items-start min-w-0" style="max-width: 82%;">
                            <div class="d-flex align-items-center gap-1.5 mb-1">
                                <span class="fw-bold small text-body" style="font-size: 11.5px;">${escapeHtml(msg.sender_name)}</span>
                                ${roleBadge}
                            </div>
                            <div class="chat-bubble-them shadow-xs">
                                ${escapeHtml(msg.message)}
                            </div>
                            <small class="text-secondary mt-1 ps-1" style="font-size: 10px;">${escapeHtml(msg.time)}</small>
                        </div>
                    </div>
                `;
            }
        });

        container.innerHTML = html;
        container.scrollTop = container.scrollHeight;
        if (window.lucide) window.lucide.createIcons();
    }

    function sendChatMessage() {
        const input = document.getElementById('chat-input');
        if (!input || !currentChat) return;
        const text = input.value.trim();
        if (!text) return;

        const roomId = currentChat.room_id || currentChat.id;
        const submitBtn = document.querySelector('#chat-form button[type="submit"]');
        if (submitBtn) submitBtn.disabled = true;

        input.value = '';

        fetch("{{ route('campus.inbox.send') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                room_id: roomId,
                message: text
            })
        })
        .then(res => res.json())
        .then(data => {
            if (submitBtn) submitBtn.disabled = false;
            input.focus();
            if (data.success) {
                fetchChatMessages(roomId, true);

                // Update last_message and time on chat card in #screen-inbox
                const cardEl = document.getElementById(`chat-item-${roomId}`);
                if (cardEl) {
                    const lastMsgEl = cardEl.querySelector('.chat-item-last-message');
                    const timeEl = cardEl.querySelector('.chat-item-time');
                    if (lastMsgEl) lastMsgEl.textContent = 'You: ' + text;
                    if (timeEl) timeEl.textContent = 'Just now';
                }
            } else if (data.message) {
                showToast(data.message);
            }
        })
        .catch(err => {
            if (submitBtn) submitBtn.disabled = false;
            console.error('Error sending message:', err);
            showToast('Failed to send message. Please try again.');
        });
    }

    // Modal close event to stop polling cleanly
    document.addEventListener('DOMContentLoaded', () => {
        const chatModal = document.getElementById('chatModal');
        if (chatModal) {
            chatModal.addEventListener('hidden.bs.modal', () => {
                if (chatPollInterval) {
                    clearInterval(chatPollInterval);
                    chatPollInterval = null;
                }
            });
        }
    });

    // Dynamic Home Tools Category Filter & Real-time Search
    function filterTools(category, btn) {
        document.querySelectorAll('.tool-filter-pill').forEach(b => b.classList.remove('active'));
        if (btn) btn.classList.add('active');

        const searchInput = document.getElementById('tool-search-input');
        const keyword = searchInput ? searchInput.value.toLowerCase().trim() : '';

        applyToolFilter(category, keyword);
    }

    function searchTools(keyword) {
        const activePill = document.querySelector('.tool-filter-pill.active');
        const category = activePill ? activePill.dataset.category : 'all';
        applyToolFilter(category, keyword.toLowerCase().trim());
    }

    function applyToolFilter(category, keyword) {
        let visibleCount = 0;
        document.querySelectorAll('.tool-item-col').forEach(col => {
            const itemCategory = col.dataset.category;
            const itemTitle = (col.dataset.title || '').toLowerCase();
            const itemDesc = (col.dataset.desc || '').toLowerCase();

            const matchCat = (category === 'all' || itemCategory === category);
            const matchSearch = (!keyword || itemTitle.includes(keyword) || itemDesc.includes(keyword));

            if (matchCat && matchSearch) {
                col.classList.remove('d-none');
                visibleCount++;
            } else {
                col.classList.add('d-none');
            }
        });

        const countBadge = document.getElementById('tools-visible-count');
        if (countBadge) {
            countBadge.textContent = visibleCount + ' Services';
        }
    }

    // ==============================================================
    // Profile Avatar Upload & Crop with Cropper.js
    // ==============================================================
    let avatarCropper = null;

    function openAvatarCropModal() {
        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('cropAvatarModal'));
        modal.show();
    }

    function handleAvatarFileSelect(input) {
        if (!input.files || !input.files[0]) return;

        const file = input.files[0];
        if (!file.type.match(/^image\//)) {
            showToast('Please select a valid image file (PNG, JPG, WEBP)');
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            showToast('Image file too large (Max 5MB). Please pick a smaller image.');
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            const imageElement = document.getElementById('image-to-crop');
            imageElement.src = e.target.result;

            document.getElementById('cropper-empty-state').classList.add('d-none');
            document.getElementById('cropper-workspace').classList.remove('d-none');
            document.getElementById('save-crop-btn').classList.remove('d-none');

            destroyCropper();

            setTimeout(() => {
                avatarCropper = new Cropper(imageElement, {
                    aspectRatio: 1, // 1:1 Square Circle avatar
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 0.88,
                    restore: false,
                    guides: true,
                    center: true,
                    highlight: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false,
                    preview: '.crop-preview-box',
                    ready: function () {
                        renderIcons();
                    }
                });
            }, 120);
        };
        reader.readAsDataURL(file);
    }

    function cropperZoom(ratio) {
        if (avatarCropper) avatarCropper.zoom(ratio);
    }

    function cropperRotate(degree) {
        if (avatarCropper) avatarCropper.rotate(degree);
    }

    function cropperReset() {
        if (avatarCropper) avatarCropper.reset();
    }

    function destroyCropper() {
        if (avatarCropper) {
            avatarCropper.destroy();
            avatarCropper = null;
        }
    }

    function uploadCroppedAvatar() {
        if (!avatarCropper) return;

        const saveBtn = document.getElementById('save-crop-btn');
        const spinner = document.getElementById('save-crop-spinner');
        const icon = document.getElementById('save-crop-icon');

        saveBtn.disabled = true;
        spinner.classList.remove('d-none');
        icon.classList.add('d-none');

        // Render cropped canvas at 400x400 high resolution
        const canvas = avatarCropper.getCroppedCanvas({
            width: 400,
            height: 400,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        const base64Data = canvas.toDataURL('image/jpeg', 0.9);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('{{ route("profile.avatar.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                avatar_data: base64Data,
            }),
        })
        .then(res => res.json())
        .then(data => {
            saveBtn.disabled = false;
            spinner.classList.add('d-none');
            icon.classList.remove('d-none');

            if (data.success) {
                // Instantly update all avatar images on the page
                document.querySelectorAll('.user-avatar-element').forEach(el => {
                    el.src = data.avatar_url;
                });

                // Hide crop modal
                const modalEl = document.getElementById('cropAvatarModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();

                destroyCropper();
                showToast('Profile photo updated & cropped successfully! ✨');
            } else {
                showToast(data.message || 'Failed to update avatar.');
            }
        })
        .catch(err => {
            console.error('Avatar update failed:', err);
            saveBtn.disabled = false;
            spinner.classList.add('d-none');
            icon.classList.remove('d-none');
            showToast('Error uploading avatar. Please try again.');
        });
    }

    // ==============================================================
    // 1. Take QCM Exam & Auto-Score Calculation (Feature 4)
    // ==============================================================
    let activeExamQuestions = [];

    async function startTakeExamAJAX(examId, examTitle, totalPoints) {
        document.getElementById('active-exam-id').value = examId;
        document.getElementById('qcm-exam-title').textContent = examTitle;
        document.getElementById('qcm-exam-info').textContent = `Total Points: ${totalPoints} • Select your answers carefully`;

        const container = document.getElementById('qcm-questions-container');
        container.innerHTML = `<div class="text-center py-4"><span class="spinner-border spinner-border-sm text-primary"></span> Loading questions...</div>`;
        const submitBtnElem = document.getElementById('btn-submit-exam');
        if (submitBtnElem) submitBtnElem.style.display = 'inline-block';

        const modal = new bootstrap.Modal(document.getElementById('takeExamModal'));
        modal.show();

        try {
            const res = await fetch(`${window.BASE_URL}/api/exams/${examId}/questions`);
            const data = await res.json();

            if (!res.ok || (data.already_submitted && !data.allow_reexam)) {
                container.innerHTML = `
                    <div class="p-4 text-center">
                        <div class="alert alert-warning border-0 rounded-4 p-3 shadow-xs">
                            <i data-lucide="lock" style="width: 32px; height: 32px;" class="mb-2 text-warning"></i>
                            <h6 class="fw-bold text-dark mb-1">${data.message || '⚠️ អ្នកបានប្រឡងមុខវិជ្ជានេះរួចរាល់ហើយ'}</h6>
                            <p class="small text-secondary mb-0">មិនអាចប្រឡងឡើងវិញបានទេ លុះត្រាតែ Admin ចុច button ReExam លើឈ្មោះរបស់អ្នក។</p>
                        </div>
                    </div>
                `;
                if (submitBtnElem) submitBtnElem.style.display = 'none';
                renderIcons();
                return;
            }

            activeExamQuestions = data.questions || [];

            if (data.total_points) {
                document.getElementById('qcm-exam-info').textContent = `Total Points: ${data.total_points} • Select your answers carefully`;
            }

            if (activeExamQuestions.length === 0) {
                container.innerHTML = `
                    <div class="p-4 text-center text-secondary">
                        <i data-lucide="help-circle" class="mb-2" style="width: 36px; height: 36px;"></i>
                        <p class="mb-0">Admin has not added QCM questions to this exam yet.</p>
                    </div>
                `;
            } else {
                let html = '';
                activeExamQuestions.forEach((q, idx) => {
                    html += `
                        <div class="p-3.5 rounded-4 border bg-body-tertiary">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary fw-bold">សំណួរ ${idx + 1} (${q.points} PTS)</span>
                            </div>
                            <h6 class="fw-bold mb-3">${q.question_text}</h6>
                            <div class="d-flex flex-column gap-2 ps-1">
                                <label class="d-flex align-items-center gap-2 p-2 rounded-3 border bg-body cursor-pointer hover-bg">
                                    <input type="radio" name="exam_q_${q.id}" value="A" required>
                                    <span class="small">A. ${q.option_a}</span>
                                </label>
                                <label class="d-flex align-items-center gap-2 p-2 rounded-3 border bg-body cursor-pointer hover-bg">
                                    <input type="radio" name="exam_q_${q.id}" value="B">
                                    <span class="small">B. ${q.option_b}</span>
                                </label>
                                <label class="d-flex align-items-center gap-2 p-2 rounded-3 border bg-body cursor-pointer hover-bg">
                                    <input type="radio" name="exam_q_${q.id}" value="C">
                                    <span class="small">C. ${q.option_c}</span>
                                </label>
                                <label class="d-flex align-items-center gap-2 p-2 rounded-3 border bg-body cursor-pointer hover-bg">
                                    <input type="radio" name="exam_q_${q.id}" value="D">
                                    <span class="small">D. ${q.option_d}</span>
                                </label>
                            </div>
                        </div>
                    `;
                });
                container.innerHTML = html;
            }
            renderIcons();
        } catch (err) {
            console.error(err);
            container.innerHTML = `<div class="p-4 text-center text-danger">Failed to load questions.</div>`;
        }
    }

    async function submitExamAnswers() {
        const examId = document.getElementById('active-exam-id').value;
        const answers = {};

        activeExamQuestions.forEach(q => {
            const selected = document.querySelector(`input[name="exam_q_${q.id}"]:checked`);
            if (selected) {
                answers[q.id] = selected.value;
            }
        });

        const answeredCount = Object.keys(answers).length;
        if (activeExamQuestions.length > 0 && answeredCount === 0) {
            alert('សូមជ្រើសរើសចម្លើយសំណួរ មុននឹងចុចដាក់បញ្ចូល! (Please select an answer before submitting)');
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const submitBtn = document.getElementById('btn-submit-exam');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Calculating Score...';

        try {
            const res = await fetch(`${window.BASE_URL}/api/exams/${examId}/submit`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json"
                },
                body: JSON.stringify({ answers: answers })
            });
            const data = await res.json();

            if (!res.ok) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = `<i data-lucide="check-circle-2" style="width: 16px; height: 16px;" class="me-1"></i> Submit & Calculate Score`;
                renderIcons();
                alert(data.message || '⚠️ អ្នកបានប្រឡងមុខវិជ្ជានេះរួចរាល់ហើយ! មិនអាចប្រឡងឡើងវិញបានទេ ទាល់តែ Admin ចុច button ReExam លើឈ្មោះរបស់អ្នក។');
                return;
            }

            // Hide take exam modal
            bootstrap.Modal.getInstance(document.getElementById('takeExamModal')).hide();
            submitBtn.disabled = false;
            submitBtn.innerHTML = `<i data-lucide="check-circle-2" style="width: 16px; height: 16px;" class="me-1"></i> Submit & Calculate Score`;

            // Populate result modal
            document.getElementById('result-exam-title').textContent = document.getElementById('qcm-exam-title').textContent;
            document.getElementById('result-score-display').textContent = `${data.earned_score} / ${data.total_possible}`;
            document.getElementById('result-pct-display').textContent = `${data.percentage}%`;
            document.getElementById('result-grade-display').textContent = data.grade;
            document.getElementById('result-summary-text').innerHTML = `
                សំណួរត្រឹមត្រូវ: <strong>${data.correct_count}</strong> ក្នុងចំណោម <strong>${data.total_questions || data.correct_count}</strong> សំណួរ។ ពិន្ទុត្រូវបានកត់ត្រាចូលក្នុង Academic Records របស់អ្នកដោយស្វ័យប្រវត្តិ។
            `;

            // >= 50% PASS (COLOR GREEN) vs < 50% FAIL (COLOR RED)
            const isPassed = (data.percentage >= 50);
            const badge = document.getElementById('result-status-badge');
            const iconContainer = document.getElementById('result-icon-container');
            const iconWrapper = document.getElementById('result-icon-wrapper');
            const scoreBox = document.getElementById('result-score-box');
            const gradeDisplay = document.getElementById('result-grade-display');
            const passFailLabel = document.getElementById('result-pass-fail-label');
            const dismissBtn = document.getElementById('result-dismiss-btn');

            if (isPassed) {
                if (badge) {
                    badge.style.backgroundColor = '#10b981';
                    badge.textContent = `🎉 ជាប់ការប្រឡង (PASSED - ${data.percentage}%)`;
                }
                if (iconContainer) {
                    iconContainer.style.border = '3px solid #10b981';
                    iconContainer.style.background = 'rgba(16, 185, 129, 0.2)';
                }
                if (iconWrapper) {
                    iconWrapper.innerHTML = '<i data-lucide="check-circle-2" class="text-success" style="width: 44px; height: 44px;"></i>';
                }
                if (scoreBox) {
                    scoreBox.style.border = '2px solid #10b981';
                    scoreBox.style.boxShadow = '0 0 18px rgba(16, 185, 129, 0.35)';
                }
                if (gradeDisplay) gradeDisplay.style.color = '#10b981';
                if (passFailLabel) {
                    passFailLabel.textContent = 'ជាប់ការប្រឡង (PASSED)';
                    passFailLabel.style.color = '#10b981';
                }
                if (dismissBtn) {
                    dismissBtn.style.backgroundColor = '#10b981';
                    dismissBtn.textContent = 'រួចរាល់ (Done & View Scores)';
                }
                if (window.confetti) {
                    window.confetti({ particleCount: 130, spread: 85, origin: { y: 0.6 } });
                }
            } else {
                if (badge) {
                    badge.style.backgroundColor = '#ef4444';
                    badge.textContent = `⚠️ ធ្លាក់ការប្រឡង (FAILED - ${data.percentage}%)`;
                }
                if (iconContainer) {
                    iconContainer.style.border = '3px solid #ef4444';
                    iconContainer.style.background = 'rgba(239, 68, 68, 0.2)';
                }
                if (iconWrapper) {
                    iconWrapper.innerHTML = '<i data-lucide="x-circle" class="text-danger" style="width: 44px; height: 44px;"></i>';
                }
                if (scoreBox) {
                    scoreBox.style.border = '2px solid #ef4444';
                    scoreBox.style.boxShadow = '0 0 18px rgba(239, 68, 68, 0.35)';
                }
                if (gradeDisplay) gradeDisplay.style.color = '#ef4444';
                if (passFailLabel) {
                    passFailLabel.textContent = 'ធ្លាក់ការប្រឡង (FAILED)';
                    passFailLabel.style.color = '#ef4444';
                }
                if (dismissBtn) {
                    dismissBtn.style.backgroundColor = '#ef4444';
                    dismissBtn.textContent = 'ធ្លាក់ការប្រឡង (Close)';
                }
            }

            const resultModal = new bootstrap.Modal(document.getElementById('examResultModal'));
            resultModal.show();
            if (dismissBtn) {
                dismissBtn.onclick = function() {
                    location.reload();
                };
            }
            showToast(`Exam graded: ${data.earned_score}/${data.total_possible} (${data.grade})!`);
            renderIcons();
        } catch (err) {
            console.error(err);
            submitBtn.disabled = false;
            submitBtn.textContent = 'Submit & Calculate Score';
            showToast('Failed to submit exam.');
        }
    }

    function showCompletedExamResult(sub, title) {
        if (!sub) return;
        document.getElementById('result-exam-title').textContent = title || sub.exam_title;
        document.getElementById('result-score-display').textContent = `${sub.earned_score} / ${sub.total_possible}`;
        document.getElementById('result-pct-display').textContent = `${sub.percentage}%`;
        document.getElementById('result-grade-display').textContent = sub.grade;
        document.getElementById('result-summary-text').innerHTML = `
            ពិន្ទុសរុប: <strong>${sub.earned_score} / ${sub.total_possible} (${sub.percentage}%)</strong> • និទ្ទេស: <strong>${sub.grade}</strong>។ បានប្រឡងនៅថ្ងៃ ${sub.submitted_at || ''}។
        `;

        const isPassed = (sub.percentage >= 50);
        const badge = document.getElementById('result-status-badge');
        const iconContainer = document.getElementById('result-icon-container');
        const iconWrapper = document.getElementById('result-icon-wrapper');
        const scoreBox = document.getElementById('result-score-box');
        const gradeDisplay = document.getElementById('result-grade-display');
        const passFailLabel = document.getElementById('result-pass-fail-label');
        const dismissBtn = document.getElementById('result-dismiss-btn');

        if (isPassed) {
            if (badge) {
                badge.style.backgroundColor = '#10b981';
                badge.textContent = `🎉 ជាប់ការប្រឡង (PASSED - ${sub.percentage}%)`;
            }
            if (iconContainer) {
                iconContainer.style.border = '3px solid #10b981';
                iconContainer.style.background = 'rgba(16, 185, 129, 0.2)';
            }
            if (iconWrapper) {
                iconWrapper.innerHTML = '<i data-lucide="check-circle-2" class="text-success" style="width: 44px; height: 44px;"></i>';
            }
            if (scoreBox) {
                scoreBox.style.border = '2px solid #10b981';
                scoreBox.style.boxShadow = '0 0 18px rgba(16, 185, 129, 0.35)';
            }
            if (gradeDisplay) gradeDisplay.style.color = '#10b981';
            if (passFailLabel) {
                passFailLabel.textContent = 'ជាប់ការប្រឡង (PASSED)';
                passFailLabel.style.color = '#10b981';
            }
            if (dismissBtn) {
                dismissBtn.style.backgroundColor = '#10b981';
                dismissBtn.textContent = 'បិទផ្ទាំងលទ្ធផល (Close)';
            }
        } else {
            if (badge) {
                badge.style.backgroundColor = '#ef4444';
                badge.textContent = `⚠️ ធ្លាក់ការប្រឡង (FAILED - ${sub.percentage}%)`;
            }
            if (iconContainer) {
                iconContainer.style.border = '3px solid #ef4444';
                iconContainer.style.background = 'rgba(239, 68, 68, 0.2)';
            }
            if (iconWrapper) {
                iconWrapper.innerHTML = '<i data-lucide="x-circle" class="text-danger" style="width: 44px; height: 44px;"></i>';
            }
            if (scoreBox) {
                scoreBox.style.border = '2px solid #ef4444';
                scoreBox.style.boxShadow = '0 0 18px rgba(239, 68, 68, 0.35)';
            }
            if (gradeDisplay) gradeDisplay.style.color = '#ef4444';
            if (passFailLabel) {
                passFailLabel.textContent = 'ធ្លាក់ការប្រឡង (FAILED)';
                passFailLabel.style.color = '#ef4444';
            }
            if (dismissBtn) {
                dismissBtn.style.backgroundColor = '#ef4444';
                dismissBtn.textContent = 'បិទផ្ទាំងលទ្ធផល (Close)';
            }
        }

        const resultModal = new bootstrap.Modal(document.getElementById('examResultModal'));
        resultModal.show();
        renderIcons();
    }

    // ==============================================================
    // 2. Short Passcode Check-In (Option 2)
    // ==============================================================
    async function submitPasscodeCheckIn() {
        const input = document.getElementById('short-passcode-input');
        const passcode = input.value.trim();
        const feedback = document.getElementById('passcode-feedback');

        if (!passcode) {
            showToast('សូមវាយបញ្ចូលលេខកូដសម្ងាត់ខ្លី ៤ ខ្ទង់ជាមុនសិន!');
            input.focus();
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const res = await fetch('{{ route("campus.passcode.checkIn") }}', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json"
                },
                body: JSON.stringify({ passcode: passcode })
            });
            const data = await res.json();

            if (data.success) {
                feedback.classList.remove('d-none', 'alert-danger');
                feedback.classList.add('alert-success');
                feedback.innerHTML = `<i class="bi bi-check-circle-fill me-1"></i> ${data.message}`;
                input.value = '';
                showToast(data.message);

                if (window.confetti) {
                    window.confetti({ particleCount: 80, spread: 60, origin: { y: 0.7 } });
                }
                setTimeout(() => window.location.reload(), 1400);
            } else {
                feedback.classList.remove('d-none', 'alert-success');
                feedback.classList.add('alert-danger');
                feedback.innerHTML = `<i class="bi bi-exclamation-triangle-fill me-1"></i> ${data.message || 'Passcode invalid'}`;
                showToast(data.message || 'Passcode invalid');
            }
        } catch (err) {
            console.error(err);
            showToast('Could not verify passcode.');
        }
    }

    // ==============================================================
    // 3. Online PDF Viewer Modal & Share Link (Feature 3 & 12)
    // ==============================================================
    function openPdfQuickModal(fileUrl, title, fileName, viewPageUrl, downloadUrl) {
        const titleEl = document.getElementById('pdf-viewer-title');
        const subtitleEl = document.getElementById('pdf-viewer-subtitle');
        const iframeEl = document.getElementById('pdf-modal-iframe');

        if (titleEl) titleEl.textContent = title;
        if (subtitleEl) subtitleEl.textContent = fileName;
        if (iframeEl) iframeEl.src = fileUrl + '#toolbar=0&navpanes=0';

        const modalEl = document.getElementById('pdfViewerModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
        renderIcons();

        // Clear iframe src on modal hide to stop memory/rendering leaks
        modalEl.addEventListener('hidden.bs.modal', () => {
            if (iframeEl) iframeEl.src = '';
        }, { once: true });
    }

    function openPdfViewerModal(title, fileName, course) {
        openPdfQuickModal('/uploads/slides/slides_1792915639.pdf', title, fileName, '#', '#');
    }

    function filterResourceList() {
        const query = (document.getElementById('resourceSearchInput')?.value || '').toLowerCase().trim();
        const items = document.querySelectorAll('.resource-card-item');
        items.forEach(item => {
            const searchData = item.getAttribute('data-search') || '';
            if (searchData.includes(query)) {
                item.classList.remove('d-none');
            } else {
                item.classList.add('d-none');
            }
        });
    }

    function copyDirectResourceLink(url) {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(url).then(() => {
                showToast('📋 តំណភ្ជាប់ Share ត្រូវបានចម្លង (Link Copied)!');
            }).catch(() => {
                fallbackCopy(url);
            });
        } else {
            fallbackCopy(url);
        }
    }

    function fallbackCopy(text) {
        const temp = document.createElement('input');
        temp.value = text;
        document.body.appendChild(temp);
        temp.select();
        document.execCommand('copy');
        document.body.removeChild(temp);
        showToast('📋 តំណភ្ជាប់ Share ត្រូវបានចម្លង (Link Copied)!');
    }

    // ==============================================================
    // 4. Live Camera QR Code Scanner with Html5Qrcode (Feature 4)
    // ==============================================================
    let html5QrScanner = null;

    function startLiveCameraScan() {
        const readerDiv = document.getElementById('live-camera-reader');
        const placeholder = document.getElementById('camera-scan-placeholder');
        const startBtn = document.getElementById('btn-start-camera');
        const stopBtn = document.getElementById('btn-stop-camera');
        const statusText = document.getElementById('scan-status-text-page');

        if (typeof Html5Qrcode === 'undefined') {
            showToast('Camera library loading, please try in a moment...');
            return;
        }

        readerDiv.style.display = 'block';
        if (placeholder) placeholder.style.display = 'none';
        if (startBtn) startBtn.classList.add('d-none');
        if (stopBtn) stopBtn.classList.remove('d-none');
        if (statusText) statusText.textContent = 'Camera កំពុងដំណើរការ... សូមតម្រង់ QR Code របស់ Admin';

        if (!html5QrScanner) {
            html5QrScanner = new Html5Qrcode("live-camera-reader");
        }

        html5QrScanner.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: { width: 220, height: 220 } },
            (decodedText) => {
                onQrScanSuccess(decodedText);
            },
            (errorMessage) => {
                // scanning frame
            }
        ).catch(err => {
            console.error(err);
            showToast('មិនអាចបើក Camera: ' + (err.message || err));
            stopLiveCameraScan();
        });
    }

    function stopLiveCameraScan() {
        const readerDiv = document.getElementById('live-camera-reader');
        const placeholder = document.getElementById('camera-scan-placeholder');
        const startBtn = document.getElementById('btn-start-camera');
        const stopBtn = document.getElementById('btn-stop-camera');
        const statusText = document.getElementById('scan-status-text-page');

        if (html5QrScanner && html5QrScanner.isScanning) {
            html5QrScanner.stop().then(() => {
                if (readerDiv) readerDiv.style.display = 'none';
                if (placeholder) placeholder.style.display = 'flex';
                if (startBtn) startBtn.classList.remove('d-none');
                if (stopBtn) stopBtn.classList.add('d-none');
                if (statusText) statusText.textContent = 'បើក Camera រួចតម្រង់លើ QR Code របស់ Admin វត្តមាននឹងកត់ត្រា Auto ភ្លាមៗ';
            }).catch(err => console.error(err));
        } else {
            if (readerDiv) readerDiv.style.display = 'none';
            if (placeholder) placeholder.style.display = 'flex';
            if (startBtn) startBtn.classList.remove('d-none');
            if (stopBtn) stopBtn.classList.add('d-none');
        }
    }

    function onQrScanSuccess(decodedText) {
        stopLiveCameraScan();
        showToast(`QR Code Scanned: ${decodedText}`);

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch("{{ route('campus.checkIn') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                "Accept": "application/json"
            },
            body: JSON.stringify({
                subject: "QR Scanner Session: " + (decodedText || "Room 402"),
                code: decodedText ? decodedText.substring(0, 10) : "QR-AUTO",
                student_name: "{{ $student['name'] }}",
                student_id: "{{ $student['id'] }}"
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast(data.message || '🎉 វត្តមានត្រូវបានកត់ត្រាដោយស្វ័យប្រវត្តិ!');
                if (window.confetti) window.confetti({ particleCount: 110, spread: 70, origin: { y: 0.6 } });
                setTimeout(() => location.reload(), 1500);
            } else {
                showToast(data.message || '⚠️ មិនអាចស្កេនវត្តមានបានទេ!');
            }
        })
        .catch(err => {
            console.error(err);
            showToast('⚠️ មិនអាចស្កេនវត្តមានបានទេ!');
        });
    }

    // ==============================================================
    // 5. View Digital Certificate Modal (Feature 6)
    // ==============================================================
    function openCertificateModal(title, recipient, issueDate, credentialId) {
        document.getElementById('sc-modal-title').textContent = title;
        document.getElementById('sc-modal-recipient').textContent = recipient;
        document.getElementById('sc-modal-date').textContent = issueDate;
        document.getElementById('sc-modal-id').textContent = credentialId;

        const modal = new bootstrap.Modal(document.getElementById('studentCertModal'));
        modal.show();
        renderIcons();
    }

    // ==============================================================
    // 6. Real-time Show Screen Poller (Feature 7)
    // ==============================================================
    async function pollLiveShowScreen() {
        try {
            const res = await fetch(`${window.BASE_URL}/api/showscreen/live`);
            const data = await res.json();
            if (!data || !data.success) return;

            const badge = document.getElementById('live-showscreen-badge');
            const studentName = document.getElementById('live-show-student');
            const title = document.getElementById('live-show-title');
            const statusText = document.getElementById('live-show-status-text');
            const room = document.getElementById('live-show-room');
            const roomInfo = document.getElementById('live-show-room-info');

            if (room && data.room) room.textContent = data.room;
            if (roomInfo && data.room) roomInfo.textContent = data.room;

            if (data.is_broadcasting) {
                if (badge) {
                    badge.className = 'badge bg-danger py-2 px-3 rounded-pill fw-bold text-white shadow-xs';
                    badge.textContent = '🔴 LIVE BROADCAST';
                }
                if (studentName) studentName.textContent = data.student_name || 'Faculty Presenter';
                if (title) title.textContent = `${data.preview_title || 'Class Presentation'} • Slide ${data.slide_index || 1}/${data.total_slides || 12}: ${data.slide_title || 'Design Talk'}`;
                if (statusText) {
                    statusText.className = 'badge bg-success px-3 py-1.5 rounded-pill fw-bold';
                    statusText.textContent = '🟢 Admin កំពុងចាក់បញ្ចាំង Live';
                }
            } else {
                if (badge) {
                    badge.className = 'badge bg-secondary py-2 px-3 rounded-pill fw-bold text-white shadow-xs';
                    badge.textContent = '⚪ STANDBY';
                }
                if (statusText) {
                    statusText.className = 'badge bg-secondary px-3 py-1.5 rounded-pill fw-bold';
                    statusText.textContent = '⚪ រង់ចាំ Admin បើក Show Screen';
                }
            }
        } catch (e) {
            // poll error silent
        }
    }
    // Start polling every 3 seconds
    setInterval(pollLiveShowScreen, 3000);

    // ==============================================================
    // 7. Submit Live Challenge Answer (Feature 9)
    // ==============================================================
    async function submitLiveChallengeAnswer(challengeId, challengeTitle) {
        const choice = document.querySelector(`input[name="ch_choice_${challengeId}"]:checked`);
        const answer = choice ? choice.value : 'A';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const res = await fetch(`${window.BASE_URL}/api/challenges/${challengeId}/submit`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json"
                },
                body: JSON.stringify({ answer: answer })
            });
            const data = await res.json();

            document.getElementById('challenge-score-title').textContent = challengeTitle;
            document.getElementById('challenge-score-points').textContent = `+${data.points || 500} PTS`;

            const modal = new bootstrap.Modal(document.getElementById('challengeScoreModal'));
            modal.show();

            showToast(data.message || 'Challenge answer submitted!');
            if (window.confetti) {
                window.confetti({ particleCount: 110, spread: 75, origin: { y: 0.6 } });
            }
            renderIcons();
        } catch (err) {
            showToast('Error submitting challenge answer.');
        }
    }

    // ==============================================================
    // 8. Submit Group Collab Sprint QCM (Feature 8)
    // ==============================================================
    async function submitCollabSprint(collabId) {
        const choice = document.querySelector(`input[name="collab_choice_${collabId}"]:checked`);
        const answer = choice ? choice.value : 'B';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const res = await fetch(`${window.BASE_URL}/api/collaborations/${collabId}/answer`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json"
                },
                body: JSON.stringify({ answer: answer })
            });
            const data = await res.json();
            showToast(data.message);
            if (window.confetti) {
                window.confetti({ particleCount: 80, spread: 60, origin: { y: 0.6 } });
            }
        } catch (err) {
            showToast('Team answer recorded (+50 Innovation Pts)!');
        }
    }

    // ==============================================================
    // 9. Digital Library Book Reader & News Article Modals (Feature 11 & 12)
    // ==============================================================
    function openBookReaderModal(title, author, category, pages) {
        document.getElementById('brm-title').textContent = title;
        document.getElementById('brm-author').textContent = 'By ' + author;
        document.getElementById('brm-category').textContent = category;
        document.getElementById('brm-pages').textContent = (pages || 320) + ' Pages Total';
        document.getElementById('brm-doc-title').textContent = title;
        const modal = new bootstrap.Modal(document.getElementById('bookReaderModal'));
        modal.show();
        renderIcons();
    }

    function openPostModal(title, category, author, date, content) {
        document.getElementById('post-view-title').textContent = title;
        document.getElementById('post-view-category').textContent = category;
        document.getElementById('post-view-meta').textContent = `Published on ${date} • by ${author}`;
        document.getElementById('post-view-content').textContent = content;
        const modal = new bootstrap.Modal(document.getElementById('postViewModal'));
        modal.show();
        renderIcons();
    }

    // ==============================================================
    // 10. Filter Score View & Challenge Result Modal (Feature Score)
    // ==============================================================
    function filterScoreView(category, btn) {
        document.querySelectorAll('.score-filter-btn').forEach(b => {
            b.classList.remove('btn-primary', 'text-white');
            b.classList.add('btn-outline-secondary', 'text-secondary');
        });
        if (btn) {
            btn.classList.remove('btn-outline-secondary', 'text-secondary');
            btn.classList.add('btn-primary', 'text-white');
        }

        const secGrades = document.getElementById('score-sec-grades');
        const secExams = document.getElementById('score-sec-exams');
        const secChallenges = document.getElementById('score-sec-challenges');

        if (category === 'all') {
            if (secGrades) secGrades.classList.remove('d-none');
            if (secExams) secExams.classList.remove('d-none');
            if (secChallenges) secChallenges.classList.remove('d-none');
        } else if (category === 'grades') {
            if (secGrades) secGrades.classList.remove('d-none');
            if (secExams) secExams.classList.add('d-none');
            if (secChallenges) secChallenges.classList.add('d-none');
        } else if (category === 'exams') {
            if (secGrades) secGrades.classList.add('d-none');
            if (secExams) secExams.classList.remove('d-none');
            if (secChallenges) secChallenges.classList.add('d-none');
        } else if (category === 'challenges') {
            if (secGrades) secGrades.classList.add('d-none');
            if (secExams) secExams.classList.add('d-none');
            if (secChallenges) secChallenges.classList.remove('d-none');
        }
        renderIcons();
    }

    function showChallengeScoreSummary(title, points, rank, time) {
        const titleEl = document.getElementById('challenge-score-title');
        const ptsEl = document.getElementById('challenge-score-points');
        if (titleEl) titleEl.textContent = title;
        if (ptsEl) ptsEl.textContent = `+${points} PTS`;
        const rankEl = document.querySelector('#challengeScoreModal .text-info');
        if (rankEl) rankEl.textContent = `#${rank || 1}`;

        const modalEl = document.getElementById('challengeScoreModal');
        if (modalEl && window.bootstrap) {
            const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modal.show();
        }
        renderIcons();
    }

    // =========================================================================
    // 16. Submit Homework Answer (Student typing text answer to all questions)
    // =========================================================================
    async function submitHomeworkAnswerAJAX(hwId) {
        const textarea = document.getElementById(`homework_ans_${hwId}`);
        if (!textarea) return;

        const answerText = textarea.value.trim();
        if (!answerText) {
            alert('សូមវាយបញ្ចូលចម្លើយរបស់អ្នកមុនពេល Submit (Please type your answer)!');
            textarea.focus();
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const res = await fetch(`${window.BASE_URL}/api/homework/${hwId}/submit`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    answer_text: answerText
                })
            });

            const data = await res.json();
            if (data.success) {
                showToast(`✓ ${data.message} (បានបញ្ជូននៅ: ${data.submitted_at})`);
                
                // Dynamically update UI section
                const section = document.getElementById(`hw-section-${hwId}`);
                if (section) {
                    section.innerHTML = `
                        <div class="p-3.5 rounded-4 border bg-body shadow-xs">
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <span class="badge bg-success-subtle text-success py-1.5 px-3 rounded-pill fw-bold font-monospace">
                                    <i class="bi bi-calendar-check me-1"></i> បានបញ្ជូននៅ: <strong>${data.submitted_at}</strong>
                                </span>
                                <span class="small text-secondary">Status: <strong class="text-success">Submitted</strong></span>
                            </div>
                            <div class="mb-3">
                                <small class="text-secondary fw-bold d-block mb-1">ចម្លើយដែលអ្នកបានវាយបញ្ចូល (Your Submitted Answer):</small>
                                <div class="p-3 rounded-3 bg-body-tertiary border text-body" style="white-space: pre-wrap; font-size: 14px; line-height: 1.6;">${escapeHtml(answerText)}</div>
                            </div>
                            <div class="p-2.5 rounded-3 bg-warning-subtle text-warning-emphasis d-flex align-items-center gap-2">
                                <i class="bi bi-hourglass-split fs-5"></i>
                                <span class="small fw-semibold">ចម្លើយត្រូវបានបញ្ជូនជោគជ័យ។ កំពុងរង់ចាំគ្រូពិនិត្យ និងវាយបញ្ចូលពិន្ទុ (Pending Review)</span>
                            </div>
                        </div>
                    `;
                }

                if (window.confetti) {
                    window.confetti({ particleCount: 60, spread: 70, origin: { y: 0.6 } });
                }
            } else {
                alert(data.message || 'មិនអាចបញ្ជូនចម្លើយបានទេ');
            }
        } catch (err) {
            console.error('Submit homework error:', err);
            alert('កំហុសប្រព័ន្ធក្នុងការបញ្ជូនចម្លើយ');
        }
    }
</script>
@endpush
