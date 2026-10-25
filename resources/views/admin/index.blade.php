@extends('layouts.admin')

@section('content')

<!-- ====================================================================== -->
<!-- 0. DASHBOARD OVERVIEW                                                  -->
<!-- ====================================================================== -->
<div id="admin-tab-dashboard" class="admin-tab-pane">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4">
        <div>
            <h3 class="fw-bolder mb-0 tracking-tight">Campus Admin Hub</h3>
            <small class="text-secondary">Connected live with the GenZ Digital Student Portal (13 Modules Active)</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-success-subtle text-success py-2 px-3 rounded-pill fw-bold">
                <i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i> System Live & Synced
            </span>
            <a href="{{ route('campus.index') }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold">
                <i data-lucide="external-link" style="width: 14px; height: 14px;" class="me-1"></i> Preview Client Side
            </a>
        </div>
    </div>

    <!-- 4 Enterprise KPI Stat Cards -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3 mb-4">
        <div class="col">
            <div class="admin-card p-3 p-md-4 h-100 position-relative overflow-hidden cursor-pointer" onclick="switchAdminTab('users')">
                <div class="d-flex justify-content-between align-items-start mb-2.5">
                    <span class="text-secondary small fw-bold text-uppercase" style="letter-spacing: 0.05em; font-size: 11px;">Total Students</span>
                    <div class="p-2.5 rounded-3 bg-primary-subtle text-primary shadow-xs">
                        <i data-lucide="users" style="width: 20px; height: 20px;"></i>
                    </div>
                </div>
                <h2 class="fw-bolder mb-1.5 text-body tracking-tight">{{ $stats['total_students'] }}</h2>
                <div class="d-flex align-items-center gap-1.5">
                    <span class="badge bg-success-subtle text-success fw-bold rounded-pill" style="font-size: 10px;">
                        <i class="bi bi-arrow-up-right me-0.5"></i> {{ $stats['active_students'] }} Active
                    </span>
                    <small class="text-secondary" style="font-size: 11px;">Enrolled Students</small>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="admin-card p-3 p-md-4 h-100 position-relative overflow-hidden cursor-pointer" onclick="switchAdminTab('attendance')">
                <div class="d-flex justify-content-between align-items-start mb-2.5">
                    <span class="text-secondary small fw-bold text-uppercase" style="letter-spacing: 0.05em; font-size: 11px;">Today Attendance</span>
                    <div class="p-2.5 rounded-3 bg-success-subtle text-success shadow-xs">
                        <i data-lucide="check-circle-2" style="width: 20px; height: 20px;"></i>
                    </div>
                </div>
                <h2 class="fw-bolder mb-1.5 text-body tracking-tight">{{ $stats['overall_attendance'] }}</h2>
                <div class="d-flex align-items-center gap-1.5">
                    <span class="badge bg-success-subtle text-success fw-bold rounded-pill" style="font-size: 10px;">
                        <i class="bi bi-check2 me-0.5"></i> 2 Sessions Live
                    </span>
                    <small class="text-secondary" style="font-size: 11px;">Morning & Afternoon</small>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="admin-card p-3 p-md-4 h-100 position-relative overflow-hidden cursor-pointer" onclick="switchAdminTab('classes')">
                <div class="d-flex justify-content-between align-items-start mb-2.5">
                    <span class="text-secondary small fw-bold text-uppercase" style="letter-spacing: 0.05em; font-size: 11px;">Classes Active</span>
                    <div class="p-2.5 rounded-3 bg-info-subtle text-info shadow-xs">
                        <i data-lucide="book-open" style="width: 20px; height: 20px;"></i>
                    </div>
                </div>
                <h2 class="fw-bolder mb-1.5 text-body tracking-tight">{{ $stats['total_classes'] }}</h2>
                <div class="d-flex align-items-center gap-1.5">
                    <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill" style="font-size: 10px;">
                        {{ $stats['ongoing_classes'] }} Ongoing
                    </span>
                    <small class="text-secondary" style="font-size: 11px;">In Session Now</small>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="admin-card p-3 p-md-4 h-100 position-relative overflow-hidden cursor-pointer" onclick="switchAdminTab('challenges')">
                <div class="d-flex justify-content-between align-items-start mb-2.5">
                    <span class="text-secondary small fw-bold text-uppercase" style="letter-spacing: 0.05em; font-size: 11px;">Live Challenges</span>
                    <div class="p-2.5 rounded-3 bg-warning-subtle text-warning shadow-xs">
                        <i data-lucide="trophy" style="width: 20px; height: 20px;"></i>
                    </div>
                </div>
                <h2 class="fw-bolder mb-1.5 text-body tracking-tight">{{ $stats['active_challenges'] }}</h2>
                <div class="d-flex align-items-center gap-1.5">
                    <span class="badge bg-warning-subtle text-warning-emphasis fw-bold rounded-pill" style="font-size: 10px;">
                        +500 XP Rewards
                    </span>
                    <small class="text-secondary" style="font-size: 11px;">Campus Competition</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Launch Classroom Tools -->
    <div class="admin-card p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold mb-0 fs-6">Interactive Classroom Quick Launch</h5>
                <small class="text-secondary">Projectors, AI Camera Gesture Tracking, Real-Time Leaderboards & Roulette</small>
            </div>
            <span class="badge bg-body-secondary text-secondary rounded-pill fw-semibold px-2.5 py-1" style="font-size: 10px;">Live Tools</span>
        </div>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-3">
            <div class="col">
                <a href="{{ route('admin.screen.fullscreen') }}" target="_blank" class="admin-card p-3 rounded-3 text-start h-100 d-flex flex-column justify-content-between text-decoration-none">
                    <div class="p-2 rounded-3 bg-primary-subtle text-primary d-inline-block mb-3" style="width: fit-content;">
                        <i data-lucide="monitor" style="width: 22px; height: 22px;"></i>
                    </div>
                    <div>
                        <span class="fw-bold small d-block text-body mb-0.5">Show on Screen</span>
                        <small class="text-secondary" style="font-size: 11px;">4-User Rotation &rarr;</small>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="{{ route('admin.slides.fullscreen') }}" target="_blank" class="admin-card p-3 rounded-3 text-start h-100 d-flex flex-column justify-content-between text-decoration-none">
                    <div class="p-2 rounded-3 bg-info-subtle text-info d-inline-block mb-3" style="width: fit-content;">
                        <i data-lucide="presentation" style="width: 22px; height: 22px;"></i>
                    </div>
                    <div>
                        <span class="fw-bold small d-block text-body mb-0.5">Slide Teaching</span>
                        <small class="text-secondary" style="font-size: 11px;">AI Gesture (☝️ / ✌️) &rarr;</small>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="{{ route('admin.challenges.fullscreen') }}" target="_blank" class="admin-card p-3 rounded-3 text-start h-100 d-flex flex-column justify-content-between text-decoration-none">
                    <div class="p-2 rounded-3 bg-warning-subtle text-warning-emphasis d-inline-block mb-3" style="width: fit-content;">
                        <i data-lucide="trophy" style="width: 22px; height: 22px;"></i>
                    </div>
                    <div>
                        <span class="fw-bold small d-block text-body mb-0.5">Live Challenge</span>
                        <small class="text-secondary" style="font-size: 11px;">Fullscreen Leaderboard &rarr;</small>
                    </div>
                </a>
            </div>

            <div class="col">
                <button class="admin-card p-3 rounded-3 text-start h-100 d-flex flex-column justify-content-between w-100 border text-start" onclick="switchAdminTab('game')">
                    <div class="p-2 rounded-3 bg-success-subtle text-success d-inline-block mb-3" style="width: fit-content;">
                        <i data-lucide="dices" style="width: 22px; height: 22px;"></i>
                    </div>
                    <div>
                        <span class="fw-bold small d-block text-body mb-0.5">Game Random</span>
                        <small class="text-secondary" style="font-size: 11px;">Pick Random & Profile &rarr;</small>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ====================================================================== -->
<!-- 1. MANAGE USERS (សិស្សរង់ចាំការ Enroll ចូលថ្នាក់)                        -->
<!-- ====================================================================== -->
<div id="admin-tab-users" class="admin-tab-pane d-none">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
        <div>
            <h4 class="fw-bolder mb-0">Manage Users & Students (គ្រប់គ្រងសិស្សតាមថ្នាក់)</h4>
            <small class="text-secondary">សិស្សដែលទើប Register នឹងបង្ហាញនៅទីនេះ។ Admin អាចធីក Checkbox ដើម្បី Enroll ទៅកាន់ថ្នាក់។ នៅពេល Enroll រួច ឈ្មោះសិស្សនឹងលែងបង្ហាញនៅទីនេះទៀតហើយ (ផ្លាស់ទៅបង្ហាញក្នុង Class Manage)។</small>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <!-- Filter View: Pending Enrollment vs All Registered -->
            <div class="btn-group btn-group-sm p-1 bg-body-secondary rounded-pill" role="group">
                <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold" id="btn-tab-pending" onclick="toggleStudentListView('pending')">
                    <i data-lucide="clock" style="width: 13px; height: 13px;" class="me-1"></i>
                    <span>សិស្សរង់ចាំ Enroll ({{ $pendingStudents->count() }})</span>
                </button>
                <button type="button" class="btn btn-sm btn-light rounded-pill px-3 fw-bold text-secondary" id="btn-tab-all" onclick="toggleStudentListView('all')">
                    <i data-lucide="users" style="width: 13px; height: 13px;" class="me-1"></i>
                    <span>សិស្សទាំងអស់ ({{ $students->count() }})</span>
                </button>
            </div>

            <!-- Instant Search by Student Name or ID -->
            <div class="position-relative">
                <input type="text" id="student-search-input" class="form-control form-control-sm rounded-pill ps-4" style="min-width: 190px;" placeholder="ស្វែងរកសិស្ស (Search)..." onkeyup="searchStudents(this.value)">
                <i data-lucide="search" style="width: 13px; height: 13px; position: absolute; left: 10px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #94a3b8;"></i>
            </div>

            <!-- Filter Students by Class -->
            <div class="d-flex align-items-center gap-1">
                <label class="small text-secondary fw-bold text-nowrap"><i class="bi bi-funnel me-1"></i> ថ្នាក់:</label>
                <select id="user-class-filter" class="form-select form-select-sm" style="min-width: 170px;" onchange="filterUsersByClass(this.value)">
                    <option value="ALL">ថ្នាក់ទាំងអស់ (All Classes)</option>
                    @foreach($classes as $c)
                        <option value="{{ $c->code }}">{{ $c->title }} ({{ $c->code }})</option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-primary btn-sm rounded-pill px-3 fw-bold d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                <i data-lucide="user-plus" style="width: 16px; height: 16px;"></i>
                <span>Add Student</span>
            </button>
        </div>
    </div>

    <!-- Batch Enroll Action Toolbar (Checkbox Enroll Feature) -->
    <form action="{{ route('admin.students.batchAssignClass') }}" method="POST" id="batchEnrollForm">
        @csrf
        <div class="p-3 bg-light rounded-4 border mb-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 shadow-xs">
            <div class="d-flex align-items-center gap-2.5">
                <div class="form-check m-0 d-flex align-items-center gap-2">
                    <input class="form-check-input fs-5 m-0 cursor-pointer" type="checkbox" id="checkAllStudents" onchange="toggleSelectAllStudents(this)">
                    <label class="form-check-label fw-bold small cursor-pointer" for="checkAllStudents">
                        ធីកទាំងអស់ (Select All)
                    </label>
                </div>
                <span class="badge bg-primary px-3 py-1.5 rounded-pill fw-bold" id="selectedCountBadge">
                    បានធីក: <span id="selectedCountText">0</span> នាក់
                </span>
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                <label class="small fw-bold text-secondary text-nowrap"><i data-lucide="school" style="width: 14px; height: 14px;" class="me-1"></i>ជ្រើសរើសថ្នាក់ដែលត្រូវ Enroll:</label>
                <select name="class_id" class="form-select form-select-sm fw-bold shadow-xs" style="min-width: 220px;" required>
                    <option value="" disabled selected>-- ជ្រើសរើសថ្នាក់ (Select Class) --</option>
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}">{{ $c->title }} ({{ $c->code }})</option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3.5 py-1.5 fw-bold d-inline-flex align-items-center gap-1.5 shadow-xs" id="btnBatchEnroll" disabled>
                    <i data-lucide="user-check" style="width: 15px; height: 15px;"></i>
                    <span>Enroll សិស្សដែលបានធីក ទៅកាន់ថ្នាក់នេះ</span>
                </button>
            </div>
        </div>

        <div class="admin-card overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="students-table">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th style="width: 40px;" class="text-center">#</th>
                            <th>Student (សិស្ស)</th>
                            <th>Student ID</th>
                            <th>Major</th>
                            <th>Class Enrollment Status</th>
                            <th>Attendance</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-students-pending">
                        @forelse($pendingStudents as $st)
                            <tr class="student-row student-row-pending" data-classes="" data-name="{{ strtolower($st->name) }}" data-id="{{ strtolower($st->student_id) }}">
                                <td class="text-center">
                                    <input type="checkbox" name="student_ids[]" value="{{ $st->student_id }}" class="student-select-chk form-check-input cursor-pointer" onchange="updateSelectedCount()">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $st->avatar }}" alt="{{ $st->name }}" class="rounded-circle object-fit-cover shadow-sm" style="width: 38px; height: 38px;">
                                        <div>
                                            <span class="fw-bold d-block">{{ $st->name }}</span>
                                            <small class="text-secondary">{{ $st->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-body-secondary text-secondary fw-semibold font-monospace">{{ $st->student_id }}</span></td>
                                <td class="small">{{ $st->major }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-warning-subtle text-warning-emphasis fw-bold" style="font-size: 11px;">
                                            <i class="bi bi-clock me-1"></i> Pending Class (មិនទាន់មានថ្នាក់)
                                        </span>
                                        <button type="button" class="btn btn-sm btn-primary py-0.5 px-2 fw-bold" style="font-size: 11px;" onclick="openAssignModal('{{ $st->student_id }}', '{{ addslashes($st->name) }}')">
                                            + Enroll to Class
                                        </button>
                                    </div>
                                </td>
                                <td><span class="fw-bold text-primary">{{ $st->attendance_rate }}</span></td>
                                <td>
                                    <span class="badge {{ $st->status === 'Active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }} fw-bold">
                                        {{ $st->status }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex align-items-center gap-1">
                                        <button type="button" class="btn btn-sm btn-primary py-1 px-2.5 fw-bold d-inline-flex align-items-center gap-1" style="font-size: 11px;" onclick="spotlightStudentAJAX('{{ $st->student_id }}', '{{ addslashes($st->name) }}')" title="Show on Screen (បង្ហាញលើ Full Screen)">
                                            <i data-lucide="monitor" style="width: 13px; height: 13px;"></i>
                                            <span>Spotlight</span>
                                        </button>

                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('toggle-form-{{ $st->id }}').submit();" title="Toggle Status">
                                            <i data-lucide="refresh-cw" style="width: 14px; height: 14px;"></i>
                                        </button>

                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="if(confirm('Delete this student?')) document.getElementById('delete-form-{{ $st->id }}').submit();" title="Delete">
                                            <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-secondary">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center mb-2" style="width: 52px; height: 52px;">
                                            <i data-lucide="check-circle" style="width: 28px; height: 28px;"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1">គ្មានសិស្សរង់ចាំ Enroll ទេ!</h6>
                                        <p class="small text-secondary mb-0">សិស្សដែលបាន Register ទាំងអស់ត្រូវបាន Enroll ទៅកាន់ថ្នាក់រៀងៗខ្លួនរួចរាល់ហើយ។ អ្នកអាចមើលបញ្ជីឈ្មោះសិស្សតាមថ្នាក់នៅកន្លែង <strong>Class Manage</strong>។</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    <!-- All Registered Students List (Initially Hidden, Viewable via Toggle) -->
                    <tbody id="tbody-students-all" class="d-none">
                        @foreach($students as $st)
                            <tr class="student-row student-row-all" data-classes="{{ $st->enrolled_classes->pluck('course_code')->join(',') }}" data-name="{{ strtolower($st->name) }}" data-id="{{ strtolower($st->student_id) }}">
                                <td class="text-center">
                                    <input type="checkbox" name="student_ids[]" value="{{ $st->student_id }}" class="student-select-chk-all form-check-input cursor-pointer" onchange="updateSelectedCount()">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $st->avatar }}" alt="{{ $st->name }}" class="rounded-circle object-fit-cover shadow-sm" style="width: 38px; height: 38px;">
                                        <div>
                                            <span class="fw-bold d-block">{{ $st->name }}</span>
                                            <small class="text-secondary">{{ $st->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-body-secondary text-secondary fw-semibold font-monospace">{{ $st->student_id }}</span></td>
                                <td class="small">{{ $st->major }}</td>
                                <td>
                                    @if($st->is_enrolled)
                                        <div class="d-flex flex-wrap gap-1 align-items-center">
                                            @foreach($st->enrolled_classes as $enc)
                                                <span class="badge bg-success-subtle text-success fw-bold d-inline-flex align-items-center gap-1" style="font-size: 11px;">
                                                    <span>{{ $enc->course_code }}</span>
                                                    <button type="button" class="btn p-0 border-0 text-danger lh-1 ms-1 fw-bold" onclick="unassignStudentDirect('{{ $st->student_id }}', '{{ $enc->course_code }}')" title="Unenroll" style="font-size: 11px;">&times;</button>
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-warning-subtle text-warning-emphasis fw-bold" style="font-size: 10px;">
                                                <i class="bi bi-clock me-1"></i> Pending Class
                                            </span>
                                            <button type="button" class="btn btn-sm btn-primary py-0 px-2 fw-bold" style="font-size: 11px;" onclick="openAssignModal('{{ $st->student_id }}', '{{ addslashes($st->name) }}')">
                                                + Enroll to Class
                                            </button>
                                        </div>
                                    @endif
                                </td>
                                <td><span class="fw-bold text-primary">{{ $st->attendance_rate }}</span></td>
                                <td>
                                    <span class="badge {{ $st->status === 'Active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }} fw-bold">
                                        {{ $st->status }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex align-items-center gap-1">
                                        <button type="button" class="btn btn-sm btn-primary py-1 px-2.5 fw-bold d-inline-flex align-items-center gap-1" style="font-size: 11px;" onclick="spotlightStudentAJAX('{{ $st->student_id }}', '{{ addslashes($st->name) }}')" title="Show on Screen (បង្ហាញលើ Full Screen)">
                                            <i data-lucide="monitor" style="width: 13px; height: 13px;"></i>
                                            <span>Spotlight</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    <!-- Hidden standalone helper forms for toggle & delete -->
    @foreach($students as $st)
        <form id="toggle-form-{{ $st->id }}" action="{{ route('admin.students.toggle', $st->id) }}" method="POST" class="d-none">@csrf</form>
        <form id="delete-form-{{ $st->id }}" action="{{ route('admin.students.delete', $st->id) }}" method="POST" class="d-none">@csrf @method('DELETE')</form>
    @endforeach
</div>

<!-- ====================================================================== -->
<!-- 2. SHOW USER ON SCREEN (FULLSCREEN 4-USER ROTATION)                     -->
<!-- ====================================================================== -->
<div id="admin-tab-screen" class="admin-tab-pane d-none">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3">
        <div>
            <h4 class="fw-bolder mb-0">Show Users on Screen (Classroom Projector)</h4>
            <small class="text-secondary">ចុចលើសិស្សណាម្នាក់នឹងបង្ហាញលើ Full Screen (បង្ហាញម្តង 4 នាក់ ហើយលោតផ្លាស់ប្តូរ 4 នាក់ទៀតស្វ័យប្រវត្តិ)</small>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Dedicated Full Screen Projector Button -->
            <a href="{{ route('admin.screen.fullscreen') }}" target="_blank" class="btn btn-primary btn-sm rounded-pill px-4 py-2 fw-bold shadow d-flex align-items-center gap-1.5">
                <i data-lucide="maximize" style="width: 16px; height: 16px;"></i>
                <span>បើក Full Screen (4 Users Rotation)</span>
            </a>
        </div>
    </div>

    <!-- Active Spotlight Queue Status -->
    <div class="admin-card p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-success-subtle text-success fw-bold px-3 py-1.5 rounded-pill">
                    ● {{ $screenSpotlights->count() }} Students in Spotlight Queue
                </span>
                <small class="text-secondary">Full Screen displays 4 at a time with automatic 7-second rotation</small>
            </div>

            <form action="{{ route('admin.screen.spotlights.clear') }}" method="POST" onsubmit="return confirm('Clear all students from spotlight queue?')">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold">
                    <i data-lucide="trash-2" style="width: 14px; height: 14px;" class="me-1"></i> Clear Queue
                </button>
            </form>
        </div>

        <!-- 4-User Preview Grid -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
            @forelse($screenSpotlights->take(4) as $spot)
                <div class="col">
                    <div class="p-3 rounded-4 border bg-body-secondary h-100 position-relative">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <img src="{{ $spot->avatar }}" class="rounded-circle object-fit-cover shadow-sm" style="width: 44px; height: 44px;">
                            <div>
                                <span class="fw-bold d-block small">{{ $spot->student_name }}</span>
                                <small class="text-secondary font-monospace" style="font-size: 10px;">{{ $spot->student_id }}</small>
                            </div>
                        </div>
                        <span class="badge bg-primary-subtle text-primary fw-bold" style="font-size: 10px;">{{ $spot->preview_title }}</span>
                        <div class="mt-2 text-end">
                            <form action="{{ route('admin.screen.spotlights.remove') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="id" value="{{ $spot->id }}">
                                <button type="submit" class="btn btn-link text-danger p-0" style="font-size: 11px;">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4 text-secondary">
                    <i data-lucide="monitor" class="mb-2" style="width: 32px; height: 32px;"></i>
                    <p class="small mb-0">No students currently spotlighted. Click "Spotlight" on any student below to project!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Quick Click to Spotlight List -->
    <div class="admin-card p-4">
        <h6 class="fw-bold mb-3 fs-6">Click any student to add to Full Screen Spotlight:</h6>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-2">
            @foreach($students as $st)
                <div class="col">
                    <div class="p-2.5 rounded-3 border d-flex justify-content-between align-items-center hover-bg">
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ $st->avatar }}" class="rounded-circle object-fit-cover" style="width: 34px; height: 34px;">
                            <div>
                                <span class="fw-bold small d-block">{{ $st->name }}</span>
                                <small class="text-secondary" style="font-size: 10px;">{{ $st->student_id }} • {{ $st->major }}</small>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-outline-primary py-1 px-2.5 fw-bold" style="font-size: 11px;" onclick="spotlightStudentAJAX('{{ $st->student_id }}', '{{ addslashes($st->name) }}')">
                            + Spotlight
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- ====================================================================== -->
<!-- 3. REPORT (របាយការណ៍បង្រៀនសិស្សតាមថ្នាក់)                               -->
<!-- ====================================================================== -->
<div id="admin-tab-reports" class="admin-tab-pane d-none">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
        <div>
            <h4 class="fw-bolder mb-0">Teaching Reports & Analytics (របាយការណ៍បង្រៀនតាមថ្នាក់)</h4>
            <small class="text-secondary">របាយការណ៍នៃការបង្រៀនសិស្សតាមថ្នាក់នីមួយៗ ម៉ោងបង្រៀន វត្តមាន និងលទ្ធផលប្រឡង</small>
        </div>

        <div class="d-flex align-items-center gap-2">
            <select id="report-class-filter" class="form-select form-select-sm" style="min-width: 180px;" onchange="updateReportDisplay(this.value)">
                <option value="ALL">ថ្នាក់ទាំងអស់ (All Classes)</option>
                @foreach($classes as $c)
                    <option value="{{ $c->code }}">{{ $c->title }} ({{ $c->code }})</option>
                @endforeach
            </select>

            <a href="{{ route('admin.reports.export') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold d-flex align-items-center gap-1" id="btn-export-report">
                <i data-lucide="download" style="width: 15px; height: 15px;"></i>
                <span>Export CSV</span>
            </a>
        </div>
    </div>

    <!-- 4 Report Highlights -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3 mb-4">
        <div class="col">
            <div class="admin-card p-3">
                <small class="text-secondary fw-bold text-uppercase d-block mb-1">Teaching Sessions</small>
                <h3 class="fw-bold mb-0 text-primary" id="rep-sessions">36 Hours</h3>
                <small class="text-secondary" style="font-size: 11px;">12 Sessions Completed</small>
            </div>
        </div>
        <div class="col">
            <div class="admin-card p-3">
                <small class="text-secondary fw-bold text-uppercase d-block mb-1">Avg. Attendance Rate</small>
                <h3 class="fw-bold mb-0 text-success" id="rep-attendance">91.4%</h3>
                <small class="text-success" style="font-size: 11px;">+3.2% vs Last Month</small>
            </div>
        </div>
        <div class="col">
            <div class="admin-card p-3">
                <small class="text-secondary fw-bold text-uppercase d-block mb-1">Exam Average</small>
                <h3 class="fw-bold mb-0 text-info" id="rep-exam-avg">88.5%</h3>
                <small class="text-info" style="font-size: 11px;">Grade: B+ (Good)</small>
            </div>
        </div>
        <div class="col">
            <div class="admin-card p-3">
                <small class="text-secondary fw-bold text-uppercase d-block mb-1">Course Completion</small>
                <h3 class="fw-bold mb-0 text-warning-emphasis" id="rep-completion">94.8%</h3>
                <small class="text-secondary" style="font-size: 11px;">18 Students Active</small>
            </div>
        </div>
    </div>

    <!-- Course Comparison Cards -->
    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <div class="admin-card p-4">
                <h5 class="fw-bold fs-6 mb-3">Teaching Performance by Class</h5>
                <div class="d-flex flex-column gap-3">
                    @foreach($classes as $c)
                        <div class="p-3 rounded-3 border bg-body-tertiary">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div>
                                    <span class="fw-bold small d-block">{{ $c->title }} ({{ $c->code }})</span>
                                    <small class="text-secondary">Prof: {{ $c->prof }} • {{ $c->schedule_time }}</small>
                                </div>
                                <span class="badge bg-primary fw-bolder">92.4% Score</span>
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-primary" style="width: 92.4%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="admin-card p-4">
                <h5 class="fw-bold fs-6 mb-3">Teaching Analytics Summary</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="small text-secondary">Student Retention Rate</span>
                        <span class="fw-bold text-success">98.2%</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="small text-secondary">On-Time Class Check-ins</span>
                        <span class="fw-bold text-primary">89.6%</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="small text-secondary">QCM Auto-Grade Passing Rate</span>
                        <span class="fw-bold text-info">94.1%</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="small text-secondary">Learning Material Downloads</span>
                        <span class="fw-bold">{{ $stats['total_downloads'] }} files</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- ====================================================================== -->
<!-- 4. EXAM (QCM សំណួរ ពិន្ទុ និង Auto-Grade)                               -->
<!-- ====================================================================== -->
<div id="admin-tab-exams" class="admin-tab-pane d-none">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
        <div>
            <h4 class="fw-bolder mb-0">Exam Management & QCM Question Builder</h4>
            <small class="text-secondary">ប្រភេទប្រឡង (Lesson, Midterm, Final, Test, Dig4.0) ដាក់សំណួរ QCM និងកំណត់ពិន្ទុ Auto</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-primary btn-sm rounded-pill px-3 fw-bold d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#addExamModal">
                <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
                <span>Schedule New Exam</span>
            </button>
        </div>
    </div>

    <!-- Exam Cards with QCM Questions -->
    <div class="row row-cols-1 row-cols-lg-2 g-3 mb-4">
        @foreach($exams as $ex)
            <div class="col">
                <div class="admin-card p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-primary text-white fw-bold">{{ $ex->category ?: 'Midterm exam' }}</span>
                            <span class="badge bg-secondary-subtle text-secondary font-monospace">{{ $ex->course }}</span>
                        </div>
                        <h5 class="fw-bold mb-1">{{ $ex->title }}</h5>
                        <p class="text-secondary small mb-2">
                            <i class="bi bi-clock me-1"></i> {{ $ex->exam_date }} • Room: {{ $ex->room }}
                        </p>
                        <div class="d-flex gap-2 mb-3">
                            <span class="badge bg-info-subtle text-info fw-semibold">⏱️ {{ $ex->duration_minutes }} Mins</span>
                            <span class="badge bg-success-subtle text-success fw-semibold">🎯 {{ $ex->total_points }} Total Points</span>
                            <span class="badge bg-warning-subtle text-warning-emphasis fw-semibold">
                                📝 {{ $examQuestions->where('exam_id', $ex->id)->count() }} QCM Questions
                            </span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <button class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#qcmModal_{{ $ex->id }}">
                            <i data-lucide="list-plus" style="width: 14px; height: 14px;" class="me-1"></i> Manage QCM Questions
                        </button>
                        <form action="{{ route('admin.exams.delete', $ex->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this exam?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger rounded-circle p-1" title="Delete">
                                <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- ====================================================================== -->
<!-- 5. CHALLENGE (REAL-TIME FULLSCREEN LEADERBOARD)                        -->
<!-- ====================================================================== -->
<div id="admin-tab-challenges" class="admin-tab-pane d-none">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
        <div>
            <h4 class="fw-bolder mb-0">Campus Challenges & Live Competition</h4>
            <small class="text-secondary">បង្កើតកម្មវិធីប្រកួតប្រជែងជា Real-Time ដាក់សំណួរ កំណត់ពិន្ទុ និងបង្ហាញ Full Screen Leaderboard</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <!-- Dedicated Fullscreen Leaderboard Button -->
            <a href="{{ route('admin.challenges.fullscreen') }}" target="_blank" class="btn btn-warning text-dark btn-sm rounded-pill px-3 fw-bold shadow d-flex align-items-center gap-1">
                <i data-lucide="trophy" style="width: 16px; height: 16px;"></i>
                <span>បើក Full Screen Leaderboard</span>
            </a>
            <button class="btn btn-primary btn-sm rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#addChallengeModal">
                <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
                <span>Create Challenge</span>
            </button>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 g-3">
        @foreach($challenges as $ch)
            <div class="col">
                <div class="admin-card p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-warning text-dark fw-bold">{{ $ch->badge ?: 'HOT' }}</span>
                            <span class="badge {{ $ch->status === 'Active' ? 'bg-success-subtle text-success' : 'bg-secondary' }} fw-bold">{{ $ch->status }}</span>
                        </div>
                        <h5 class="fw-bold fs-6 mb-1">{{ $ch->title }}</h5>
                        <p class="text-secondary small mb-2">{{ $ch->description }}</p>
                        @if($ch->question_text)
                            <div class="p-2.5 rounded-3 bg-body-tertiary small mb-3">
                                <strong>សំណួរប្រកួត:</strong> {{ $ch->question_text }}
                            </div>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                        <span class="fw-bold text-warning-emphasis small">🏆 +{{ $ch->points }} PTS (⏱️ {{ $ch->duration_minutes }}m)</span>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('admin.challenges.fullscreen.id', $ch->id) }}" target="_blank" class="btn btn-sm btn-outline-warning text-dark fw-bold">
                                Live Screen
                            </a>
                            <form action="{{ route('admin.challenges.toggle', $ch->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-outline-secondary">Toggle</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- ====================================================================== -->
<!-- 6. CERTIFICATE (GENERATE AUTO ម្តងច្រើននាក់)                            -->
<!-- ====================================================================== -->
<div id="admin-tab-certificates" class="admin-tab-pane d-none">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
        <div>
            <h4 class="fw-bolder mb-0">Certificates & Credentials</h4>
            <small class="text-secondary">Generate Auto បានម្តងច្រើននាក់តាមថ្នាក់/ការប្រឡង ហើយសិស្សអាចចូលមើលក្នុង Account បានភ្លាមៗ</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1.5 fw-bold" style="font-size: 11px;">
                Showing latest {{ $certificates->count() }} of {{ $stats['issued_certificates'] }} credentials
            </span>
            <!-- Batch Auto Generate Button -->
            <button class="btn btn-primary btn-sm rounded-pill px-3 fw-bold d-flex align-items-center gap-1 shadow" data-bs-toggle="modal" data-bs-target="#batchCertModal">
                <i data-lucide="sparkles" style="width: 16px; height: 16px;"></i>
                <span>Generate Auto (ម្តងច្រើននាក់)</span>
            </button>
            <button class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#addCertModal">
                <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
                <span>Issue Single</span>
            </button>
        </div>
    </div>

    <div class="admin-card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small">
                    <tr>
                        <th>Certificate Title</th>
                        <th>Recipient Student</th>
                        <th>Issue Date</th>
                        <th>Credential ID</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($certificates as $cert)
                        <tr>
                            <td class="fw-bold">
                                <i data-lucide="award" class="text-warning me-1" style="width: 16px; height: 16px;"></i>
                                {{ $cert->title }}
                            </td>
                            <td>{{ $cert->recipient }}</td>
                            <td class="small">{{ $cert->issue_date }}</td>
                            <td><span class="badge bg-body-secondary text-secondary font-monospace">{{ $cert->credential_id }}</span></td>
                            <td><span class="badge bg-success-subtle text-success fw-bold">{{ $cert->status }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ====================================================================== -->
<!-- 7. SHOW SLIDE TEACHING (AI CAMERA GESTURE TRACKER)                     -->
<!-- ====================================================================== -->
<div id="admin-tab-slides" class="admin-tab-pane d-none">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
        <div>
            <h4 class="fw-bolder mb-0">Show Slide Teaching & Camera Gesture Control</h4>
            <small class="text-secondary">Upload PDF, PPT, Word • បើក Full Screen ប្រើកាមេរ៉ា Gesture (☝️ ម្រាម 1: ថយក្រោយ, ✌️ ម្រាម 2: ទៅមុខ)</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.slides.fullscreen') }}" target="_blank" class="btn btn-primary btn-sm rounded-pill px-4 py-2 fw-bold shadow d-flex align-items-center gap-1.5">
                <i data-lucide="presentation" style="width: 16px; height: 16px;"></i>
                <span>បើក Full Screen បង្រៀន (Camera Gesture)</span>
            </a>
        </div>
    </div>

    <!-- AI Gesture Instruction Card -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="admin-card p-3 p-md-4 border-primary border-opacity-50 h-100">
                <h6 class="fw-bold text-primary mb-2"><i class="bi bi-camera-video me-1"></i> Camera AI Gesture Commands:</h6>
                <div class="d-flex gap-3 mt-3">
                    <div class="p-3 rounded-4 bg-primary-subtle text-primary text-center flex-grow-1">
                        <div class="fs-1 mb-1">☝️</div>
                        <strong class="d-block">ម្រាមដៃ ១ (1 Finger)</strong>
                        <small>Slide ថយក្រោយ (Previous)</small>
                    </div>
                    <div class="p-3 rounded-4 bg-info-subtle text-info text-center flex-grow-1">
                        <div class="fs-1 mb-1">✌️</div>
                        <strong class="d-block">ម្រាមដៃ ២ (2 Fingers)</strong>
                        <small>Slide ទៅមុខ (Next)</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="admin-card p-3 p-md-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold mb-0"><i data-lucide="upload" style="width: 16px; height: 16px;" class="me-1"></i> Upload Slide Deck (PDF / PPT / Image)</h6>
                    @if($teachingSlides && $teachingSlides->file_path)
                        <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill" style="font-size: 10.5px;">
                            <i data-lucide="check-circle" style="width: 11px; height: 11px; vertical-align: -1px;"></i> Active File Ready
                        </span>
                    @endif
                </div>

                @if($teachingSlides && $teachingSlides->file_path)
                    <div class="p-2.5 rounded-3 bg-body-tertiary border mb-3 small d-flex justify-content-between align-items-center">
                        <div class="text-truncate me-2">
                            <span class="text-secondary d-block" style="font-size: 10px;">CURRENT PRESENTATION FILE:</span>
                            <strong class="text-truncate d-block">{{ $teachingSlides->title }} ({{ $teachingSlides->course }})</strong>
                            <small class="text-secondary font-monospace" style="font-size: 10px;">{{ basename($teachingSlides->file_path) }}</small>
                        </div>
                        <a href="{{ route('admin.slides.fullscreen') }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold flex-shrink-0" style="font-size: 11px;">
                            <i data-lucide="presentation" style="width: 13px; height: 13px;"></i> បើកស្លាយ
                        </a>
                    </div>
                @endif

                <form action="{{ route('admin.slides.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 11.5px;">Slide Deck Title</label>
                        <input type="text" name="title" class="form-control form-control-sm" required placeholder="Slide Deck Title (e.g. Digital AI Lecture)" value="{{ $teachingSlides ? $teachingSlides->title : '' }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 11.5px;">Course Code</label>
                        <input type="text" name="course" class="form-control form-control-sm" required placeholder="Course Code (e.g. DGT01)" value="{{ $teachingSlides ? $teachingSlides->course : '' }}">
                    </div>
                    <div class="mb-2.5">
                        <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 11.5px;">Choose Slide File (PDF recommended, or PPT / Image)</label>
                        <input type="file" name="slide_file" class="form-control form-control-sm" accept=".pdf,.ppt,.pptx,.doc,.docx,.png,.jpg,.jpeg,.webp">
                        <small class="text-secondary d-block mt-1" style="font-size: 10.5px;">💡 គន្លឹះ៖ ដើម្បីឱ្យការបញ្ជាស្លាយតាមម្រាមដៃ (AI Gesture) ដើររលូន និងច្បាស់បំផុត សូម Upload ជា File <strong>PDF</strong></small>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold d-flex align-items-center justify-content-center gap-1.5 py-2">
                        <i data-lucide="cloud-upload" style="width: 15px; height: 15px;"></i>
                        <span>Upload & Save Slide Deck</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ====================================================================== -->
<!-- 8. COLLABORATION (REAL-TIME GROUP QCM SPRINT)                          -->
<!-- ====================================================================== -->
<div id="admin-tab-collab" class="admin-tab-pane d-none">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
        <div>
            <h4 class="fw-bolder mb-0">Collaboration & Team Problem Solving (QCM)</h4>
            <small class="text-secondary">បង្កើតបន្ទប់សហការអោយសិស្ស Join ចូលធ្វើការជាមួយគ្នា Real-Time ដោះស្រាយលំហាត់ QCM</small>
        </div>
        <button class="btn btn-primary btn-sm rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#addCollabModal">
            <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
            <span>Create Team Project / QCM Sprint</span>
        </button>
    </div>

    <div class="row row-cols-1 row-cols-md-2 g-3">
        @foreach($collaborations as $cl)
            <div class="col">
                <div class="admin-card p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-primary-subtle text-primary fw-bold">{{ $cl->current_members }}/{{ $cl->max_members }} Members Joined</span>
                            <span class="badge bg-success-subtle text-success fw-bold">{{ $cl->status }}</span>
                        </div>
                        <h5 class="fw-bold fs-6 mb-1">{{ $cl->title }}</h5>
                        <p class="text-secondary small mb-2">{{ $cl->description }}</p>
                        <small class="text-primary fw-semibold d-block">Needed Role: <strong>{{ $cl->required_role }}</strong></small>
                    </div>
                    <div class="pt-3 border-top mt-3 d-flex justify-content-between align-items-center">
                        <small class="text-secondary">Real-Time Team Room Active</small>
                        <span class="badge bg-primary">Online</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- ====================================================================== -->
<!-- 9. GAME RANDOM (RANDOM ឈ្មោះសិស្សតាមថ្នាក់ & POPUP PROFILE)                 -->
<!-- ====================================================================== -->
<div id="admin-tab-game" class="admin-tab-pane d-none">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
        <div>
            <h4 class="fw-bolder mb-0">Game Random (Student Picker with Profile Popup)</h4>
            <small class="text-secondary">Random ឈ្មោះសិស្សតាមថ្នាក់នីមួយៗ ហើយនៅពេលចំឈ្មោះណានឹង Popup បង្ហាញ Profile សិស្សពេញលេញ</small>
        </div>

        <div class="d-flex align-items-center gap-2">
            <label class="small text-secondary fw-bold text-nowrap"><i class="bi bi-funnel me-1"></i> ជ្រើសរើសថ្នាក់:</label>
            <select id="game-class-filter" class="form-select form-select-sm" style="min-width: 180px;" onchange="filterGameStudents(this.value)">
                <option value="ALL">ថ្នាក់ទាំងអស់ (All Classes)</option>
                @foreach($classes as $c)
                    <option value="{{ $c->code }}">{{ $c->title }} ({{ $c->code }})</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <div class="admin-card p-4 text-center">
                <div class="student-picker-box mb-4" id="picker-box">
                    <img id="winner-avatar" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=250" class="rounded-circle object-fit-cover shadow-sm mb-3" style="width: 100px; height: 100px; border: 4px solid #3b82f6;">
                    <h3 class="fw-bold mb-1" id="winner-name">Ready to Roll?</h3>
                    <p class="text-secondary small mb-0" id="winner-info">Click the button below to randomly pick a student!</p>
                </div>

                <button class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow-lg" id="btn-spin" onclick="spinRandomStudentWithPopup()">
                    <i data-lucide="dices" class="me-2" style="width: 22px; height: 22px;"></i>
                    <span>🎲 Random ឈ្មោះសិស្ស (Spin & Popup Profile)</span>
                </button>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="admin-card p-4">
                <h6 class="fw-bold mb-3 fs-6">Eligible Students in Selected Class (<span id="eligible-count">{{ $students->count() }}</span>)</h6>
                <div class="d-flex flex-column gap-2" id="eligible-list" style="max-height: 380px; overflow-y: auto;">
                    @foreach($students as $st)
                        <div class="p-2.5 rounded-3 bg-body-secondary d-flex align-items-center gap-2">
                            <img src="{{ $st->avatar }}" class="rounded-circle object-fit-cover" style="width: 32px; height: 32px;">
                            <div class="flex-grow-1 min-w-0">
                                <span class="fw-bold small d-block text-truncate">{{ $st->name }}</span>
                                <small class="text-secondary" style="font-size: 10px;">{{ $st->student_id }} • {{ $st->major }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ====================================================================== -->
<!-- 10. ATTENDANCE (វត្តមានតាមថ្នាក់ & EXCEL, PDF, PRINT)                     -->
<!-- ====================================================================== -->
<div id="admin-tab-attendance" class="admin-tab-pane d-none">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
        <div>
            <h4 class="fw-bolder mb-0">Attendance Tracker (វត្តមានសិស្សតាមថ្នាក់)</h4>
            <small class="text-secondary">បង្ហាញវត្តមានសិស្សតាមថ្នាក់នីមួយៗជាតារាង (Export Excel, PDF, និង Print)</small>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <!-- Filter by Class -->
            <select id="attendance-class-filter" class="form-select form-select-sm" style="min-width: 170px;" onchange="filterAttendanceTable(this.value)">
                <option value="ALL">ថ្នាក់ទាំងអស់ (All Classes)</option>
                @foreach($classes as $c)
                    <option value="{{ $c->code }}">{{ $c->title }} ({{ $c->code }})</option>
                @endforeach
            </select>

            <!-- Filter by 2 Sessions per day -->
            <select id="attendance-session-filter" class="form-select form-select-sm" style="min-width: 155px;" onchange="filterAttendanceSession(this.value)">
                <option value="ALL">វេនទាំងអស់ (All Sessions)</option>
                <option value="Session 1">☀️ Session 1 (ព្រឹក)</option>
                <option value="Session 2">🌙 Session 2 (រសៀល)</option>
            </select>

            <!-- 3 Export Options: Excel, PDF, Print -->
            <a href="{{ route('admin.attendance.export', ['format' => 'excel']) }}" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold d-flex align-items-center gap-1" id="btn-export-excel">
                <i data-lucide="file-spreadsheet" style="width: 15px; height: 15px;"></i>
                <span>Export Excel</span>
            </a>

            <a href="{{ route('admin.attendance.export', ['format' => 'pdf']) }}" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold d-flex align-items-center gap-1" id="btn-export-pdf">
                <i data-lucide="file-text" style="width: 15px; height: 15px;"></i>
                <span>Export PDF</span>
            </a>

            <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-bold d-flex align-items-center gap-1" onclick="window.print()">
                <i data-lucide="printer" style="width: 15px; height: 15px;"></i>
                <span>Print</span>
            </button>
        </div>
    </div>

    <div class="admin-card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="attendance-roster-table">
                <thead class="table-light text-secondary small">
                    <tr>
                        <th>Student Name</th>
                        <th>Student ID</th>
                        <th>Subject & Class Code</th>
                        <th>Session (វេន)</th>
                        <th>Check-in Time</th>
                        <th>Status</th>
                        <th class="text-end">Quick Update</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $att)
                        <tr class="att-row" data-code="{{ $att->code }}" data-session="{{ $att->session_name ?? 'Session 1' }}">
                            <td class="fw-bold">{{ $att->student_name }}</td>
                            <td><span class="badge bg-body-secondary text-secondary font-monospace">{{ $att->student_id }}</span></td>
                            <td>{{ $att->subject }} <span class="badge bg-primary-subtle text-primary">{{ $att->code }}</span></td>
                            <td>
                                @if(str_contains($att->session_name ?? '', '2') || str_contains($att->session_name ?? '', 'Afternoon'))
                                    <span class="badge bg-warning-subtle text-warning-emphasis fw-bold" style="font-size: 11px;">
                                        🌙 {{ $att->session_name ?? 'Session 2 (រសៀល)' }}
                                    </span>
                                @else
                                    <span class="badge bg-info-subtle text-info-emphasis fw-bold" style="font-size: 11px;">
                                        ☀️ {{ $att->session_name ?? 'Session 1 (ព្រឹក)' }}
                                    </span>
                                @endif
                            </td>
                            <td class="small">{{ $att->check_in_time }}</td>
                            <td>
                                <span class="badge {{ $att->status === 'Present' ? 'bg-success' : ($att->status === 'Late' ? 'bg-warning text-dark' : 'bg-danger') }} fw-bold" id="att-badge-{{ $att->id }}">
                                    {{ $att->status }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-success" onclick="updateAttStatus({{ $att->id }}, 'Present')">Present</button>
                                    <button class="btn btn-outline-warning" onclick="updateAttStatus({{ $att->id }}, 'Late')">Late</button>
                                    <button class="btn btn-outline-danger" onclick="updateAttStatus({{ $att->id }}, 'Absent')">Absent</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ====================================================================== -->
<!-- 11. QR CODE & SHORT PASSCODE (ស្កេន QR ឬ វាយលេខកូដខ្លី)                  -->
<!-- ====================================================================== -->
<div id="admin-tab-qr" class="admin-tab-pane d-none">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
        <div>
            <h4 class="fw-bolder mb-0">QR Code & Short Passcode Manager</h4>
            <small class="text-secondary">QR Code តាមថ្នាក់ និងតាមថ្ងៃបង្រៀន (សិស្សអាច Scan QR ឬ វាយលេខកូដខ្លី ៤ ខ្ទង់)</small>
        </div>
        <button class="btn btn-primary btn-sm rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#addQrModal">
            <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
            <span>Generate New QR & Short Code</span>
        </button>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-3">
        @foreach($qrCodes as $qr)
            <div class="col">
                <div class="admin-card p-4 text-center h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-primary-subtle text-primary fw-bold">{{ $qr->class_code ?: $qr->type }}</span>
                            <span class="badge {{ str_contains($qr->session_name ?? '', '2') ? 'bg-warning-subtle text-warning-emphasis' : 'bg-info-subtle text-info-emphasis' }} fw-bold">
                                {{ $qr->session_name ?? 'Session 1 (ព្រឹក)' }}
                            </span>
                            <span class="badge bg-success-subtle text-success fw-bold">{{ $qr->status }}</span>
                        </div>
                        <h6 class="fw-bold fs-6 mb-2">{{ $qr->title }}</h6>
                        <small class="text-secondary d-block mb-3">Session Date: {{ $qr->session_date ?: date('Y-m-d') }}</small>

                        <!-- Simulated QR Code Graphic -->
                        <div class="bg-white p-3 rounded-4 shadow-sm border d-inline-block mb-3">
                            <svg width="110" height="110" viewBox="0 0 24 24" fill="none" stroke="#0f172a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
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

                        <!-- Short 4-Digit Passcode Prominent Box -->
                        <div class="p-2.5 rounded-3 bg-primary-subtle border border-primary border-opacity-25 mb-2">
                            <small class="text-primary fw-bold d-block" style="font-size: 11px;">លេខកូដខ្លី (SHORT PASSCODE)</small>
                            <span class="fs-4 fw-bolder font-monospace text-primary tracking-widest">{{ $qr->short_code ?: '8492' }}</span>
                        </div>
                        <small class="text-secondary font-monospace" style="font-size: 10px;">{{ $qr->code_value }}</small>
                    </div>

                    <button class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-bold mt-3" onclick="activateQrCodeAJAX({{ $qr->id }}, '{{ addslashes($qr->title) }}')">
                        <i data-lucide="cast" style="width: 14px; height: 14px;" class="me-1"></i> Project on Screen
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- ====================================================================== -->
<!-- 12. RESOURCE (UPLOAD មេរៀនជា PDF តាមថ្នាក់ & សិស្សអាច VIEW បាន)             -->
<!-- ====================================================================== -->
<div id="admin-tab-resources" class="admin-tab-pane d-none">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
        <div>
            <h4 class="fw-bolder mb-0">Learning Resources & PDF Upload</h4>
            <small class="text-secondary">Upload មេរៀនជា PDF តាមថ្នាក់នីមួយៗ ហើយសិស្សអាច View Online ផ្ទាល់បាន</small>
        </div>
        <button class="btn btn-primary btn-sm rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#addResourceModal">
            <i data-lucide="upload" style="width: 16px; height: 16px;"></i>
            <span>Upload PDF Lesson</span>
        </button>
    </div>

    <div class="admin-card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small">
                    <tr>
                        <th>Material Title</th>
                        <th>Class Code</th>
                        <th>File Name</th>
                        <th>Size</th>
                        <th>Downloads</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resources as $res)
                        <tr>
                            <td class="fw-bold">
                                <i data-lucide="file-text" class="text-danger me-1" style="width: 16px; height: 16px;"></i>
                                {{ $res->title }}
                            </td>
                            <td><span class="badge bg-primary-subtle text-primary">{{ $res->class_code ?: $res->course }}</span></td>
                            <td class="small font-monospace">{{ $res->file_name }}</td>
                            <td class="small">{{ $res->file_size }}</td>
                            <td><span class="badge bg-success-subtle text-success fw-bold">{{ $res->download_count }} views</span></td>
                            <td class="text-end">
                                <a href="{{ route('campus.resource.download', $res->id) }}" class="btn btn-sm btn-outline-primary" title="Download">
                                    <i data-lucide="download" style="width: 14px; height: 14px;"></i>
                                </a>
                                <form action="{{ route('admin.resources.delete', $res->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this resource?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ====================================================================== -->
<!-- 13. CLASS MANAGE (គ្រប់គ្រងថ្នាក់: បញ្ជីឈ្មោះ មុខវិជ្ជា ពិន្ទុ វត្តមាន)           -->
<!-- ====================================================================== -->
<div id="admin-tab-classes" class="admin-tab-pane d-none">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
        <div>
            <h4 class="fw-bolder mb-0">Class & Course Management (គ្រប់គ្រងថ្នាក់រៀន)</h4>
            <small class="text-secondary">បង្កើតថ្នាក់ គ្រប់គ្រងថ្នាក់ (នៅក្នុងថ្នាក់មាន: បញ្ជីឈ្មោះសិស្ស, មុខវិជ្ជា, ពិន្ទុ, វត្តមាន)</small>
        </div>
        <button class="btn btn-primary btn-sm rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#addClassModal">
            <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
            <span>Add New Class</span>
        </button>
    </div>

    <div class="admin-card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small">
                    <tr>
                        <th>Class Title</th>
                        <th>Code</th>
                        <th>Instructor</th>
                        <th>Room</th>
                        <th>Schedule</th>
                        <th>Enrolled (សិស្ស)</th>
                        <th>Status</th>
                        <th class="text-end">Detail (៤ មុខងារ)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classes as $cl)
                        <tr>
                            <td class="fw-bold">{{ $cl->title }}</td>
                            <td><span class="badge bg-primary text-white font-monospace">{{ $cl->code }}</span></td>
                            <td class="small">{{ $cl->prof }}</td>
                            <td class="small">{{ $cl->room }}</td>
                            <td class="small">{{ $cl->schedule_time }}</td>
                            <td>
                                <span class="badge bg-success-subtle text-success fw-bold px-2.5 py-1.5 cursor-pointer" onclick="openClassDetailsAJAX({{ $cl->id }})" title="មើលបញ្ជីឈ្មោះសិស្សក្នុងថ្នាក់នេះ">
                                    <i data-lucide="users" style="width: 13px; height: 13px;" class="me-1"></i>{{ $cl->enrolled_count ?? 0 }} នាក់
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $cl->status === 'Ongoing' ? 'bg-success-subtle text-success' : 'bg-primary-subtle text-primary' }} fw-bold">
                                    {{ $cl->status }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <!-- Interactive 4-Tab Detail Modal Button -->
                                    <button class="btn btn-sm btn-primary fw-bold px-2.5 py-1 d-inline-flex align-items-center gap-1" onclick="openClassDetailsAJAX({{ $cl->id }})">
                                        <i data-lucide="layers" style="width: 13px; height: 13px;"></i>
                                        <span>ព័ត៌មានថ្នាក់ (៤ Tabs)</span>
                                    </button>

                                    <form action="{{ route('admin.classes.toggle', $cl->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-secondary" title="Toggle Ongoing/Upcoming">
                                            <i data-lucide="refresh-cw" style="width: 14px; height: 14px;"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.classes.delete', $cl->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this class?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ====================================================================== -->
<!-- 14. DIGITAL LIBRARY (UPLOAD BOOKS)                                     -->
<!-- ====================================================================== -->
<div id="admin-tab-library" class="admin-tab-pane d-none">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
        <div>
            <h4 class="fw-bolder mb-0">Digital Library Management (គ្រប់គ្រងសៀវភៅឌីជីថល)</h4>
            <small class="text-secondary">Upload E-Books សម្រាប់សិស្សអានអនឡាញ & ទាញយក PDF • បង្ហាញក្នុង Client Library</small>
        </div>
        <button class="btn btn-primary btn-sm rounded-pill px-3 fw-bold shadow-xs" data-bs-toggle="modal" data-bs-target="#addBookModal">
            <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
            <span>Upload New E-Book</span>
        </button>
    </div>

    <div class="admin-card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small">
                    <tr>
                        <th class="ps-3">Book Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Pages</th>
                        <th>File Size</th>
                        <th>Total Reads</th>
                        <th class="text-end pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $bk)
                        <tr>
                            <td class="ps-3">
                                <span class="fw-bold d-block">{{ $bk->title }}</span>
                                <small class="text-secondary">{{ Str::limit($bk->description, 60) }}</small>
                            </td>
                            <td class="small">{{ $bk->author }}</td>
                            <td><span class="badge bg-primary-subtle text-primary font-monospace">{{ $bk->category }}</span></td>
                            <td class="small">{{ $bk->total_pages ?? 320 }} pages</td>
                            <td class="small">{{ $bk->file_size ?? '12 MB' }}</td>
                            <td><span class="badge bg-success-subtle text-success fw-bold">{{ $bk->reads_count }} reads</span></td>
                            <td class="text-end pe-3">
                                <form action="{{ route('admin.books.delete', $bk->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this book from library?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-2.5 py-1" title="Delete">
                                        <i data-lucide="trash-2" style="width: 13px; height: 13px;"></i>
                                        <span style="font-size: 11px;">Delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-secondary">
                                No books uploaded yet. Click "Upload New E-Book" to add.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ====================================================================== -->
<!-- 15. NEWS & ANNOUNCEMENTS (ADMIN POSTS)                                 -->
<!-- ====================================================================== -->
<div id="admin-tab-news" class="admin-tab-pane d-none">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
        <div>
            <h4 class="fw-bolder mb-0">Campus News & Announcements (ព័ត៌មាន & សេចក្តីជូនដំណឹង)</h4>
            <small class="text-secondary">ចុះផ្សាយព័ត៌មានសាលា សេចក្តីប្រកាសប្រឡង និងព្រឹត្តិការណ៍នានា • បង្ហាញក្នុង Client News</small>
        </div>
        <button class="btn btn-primary btn-sm rounded-pill px-3 fw-bold shadow-xs" data-bs-toggle="modal" data-bs-target="#addPostModal">
            <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
            <span>Create New Post</span>
        </button>
    </div>

    <div class="admin-card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small">
                    <tr>
                        <th class="ps-3">Post Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Pinned</th>
                        <th>Published Date</th>
                        <th class="text-end pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $pt)
                        <tr>
                            <td class="ps-3">
                                <span class="fw-bold d-block">{{ $pt->title }}</span>
                                <small class="text-secondary">{{ Str::limit($pt->content, 70) }}</small>
                            </td>
                            <td><span class="badge {{ $pt->category === 'ANNOUNCEMENT' ? 'bg-primary' : ($pt->category === 'EVENT' ? 'bg-info text-dark' : 'bg-success') }} fw-bold">{{ $pt->category }}</span></td>
                            <td class="small">{{ $pt->author }}</td>
                            <td>
                                @if($pt->is_pinned)
                                    <span class="badge bg-warning text-dark fw-bold"><i data-lucide="pin" style="width: 11px; height: 11px;" class="me-1"></i> Pinned</span>
                                @else
                                    <span class="text-secondary small">Normal</span>
                                @endif
                            </td>
                            <td class="small">{{ \Carbon\Carbon::parse($pt->created_at)->format('M d, Y') }}</td>
                            <td class="text-end pe-3">
                                <form action="{{ route('admin.posts.delete', $pt->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this post?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-2.5 py-1" title="Delete">
                                        <i data-lucide="trash-2" style="width: 13px; height: 13px;"></i>
                                        <span style="font-size: 11px;">Delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-secondary">
                                No news posts published yet. Click "Create New Post" to add.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ====================================================================== -->
<!-- ALL MODALS FOR 13 ADVANCED ADMIN MODULES                              -->
<!-- ====================================================================== -->

<!-- 1. Winner Student Profile Popup Modal (Feature 9) -->
<div class="modal fade" id="winnerProfileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 p-4 rounded-4 shadow-lg text-center" style="background: radial-gradient(circle at 50% 20%, #1e293b, #0f172a); color: #fff;">
            <div class="modal-header border-0 p-0 justify-content-end">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0 pt-2 pb-4">
                <span class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill mb-3 fs-7">
                    🎉 SELECTED LUCKY STUDENT (Game Random Winner)
                </span>

                <div class="position-relative d-inline-block mb-3">
                    <img id="modal-winner-avatar" src="" class="rounded-circle object-fit-cover shadow-lg" style="width: 110px; height: 110px; border: 4px solid #eab308;">
                </div>

                <h3 class="fw-bolder mb-1 text-white" id="modal-winner-name">Student Full Name</h3>
                <span class="badge bg-body-secondary text-secondary font-monospace fs-6 mb-3" id="modal-winner-id">GZ20260482</span>

                <div class="row g-2 text-start my-3">
                    <div class="col-6">
                        <div class="p-3 rounded-3 bg-white bg-opacity-10">
                            <small class="text-white-50 d-block" style="font-size: 11px;">Major</small>
                            <strong class="text-white small" id="modal-winner-major">Visual Comm</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded-3 bg-white bg-opacity-10">
                            <small class="text-white-50 d-block" style="font-size: 11px;">Attendance</small>
                            <strong class="text-success small" id="modal-winner-attendance">92.4%</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded-3 bg-white bg-opacity-10">
                            <small class="text-white-50 d-block" style="font-size: 11px;">Current GPA</small>
                            <strong class="text-warning small" id="modal-winner-gpa">3.88 / 4.00</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded-3 bg-white bg-opacity-10">
                            <small class="text-white-50 d-block" style="font-size: 11px;">Status</small>
                            <strong class="text-info small" id="modal-winner-status">Active Enrolled</strong>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-warning w-100 fw-bold py-2.5 rounded-pill shadow" id="modal-winner-spotlight-btn">
                    <i data-lucide="monitor" class="me-1" style="width: 16px; height: 16px;"></i>
                    Spotlight this Student onto Projector Screen
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 2. Interactive Class 4-Tab Detail Modal (Feature 13) -->
<div class="modal fade" id="classDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-3 p-md-4 rounded-4">
            <div class="modal-header border-0 pb-2">
                <div>
                    <h5 class="modal-title fw-bold fs-5" id="cd-title">Class Details</h5>
                    <small class="text-secondary" id="cd-subtitle">Course Overview • ៤ មុខងារក្នុងថ្នាក់</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Nav Tabs -->
            <ul class="nav nav-pills nav-fill bg-body-secondary p-1 rounded-3 mb-3" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active fw-bold small py-2" data-bs-toggle="pill" data-bs-target="#cd-tab-students">
                        1. បញ្ជីឈ្មោះសិស្ស (Students)
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold small py-2" data-bs-toggle="pill" data-bs-target="#cd-tab-subjects">
                        2. មុខវិជ្ជា (Subjects)
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold small py-2" data-bs-toggle="pill" data-bs-target="#cd-tab-scores">
                        3. ពិន្ទុ (Scores)
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold small py-2" data-bs-toggle="pill" data-bs-target="#cd-tab-attendance">
                        4. វត្តមាន (Attendance)
                    </button>
                </li>
            </ul>

            <!-- Tab Panes -->
            <div class="tab-content" id="cd-tabContent" style="min-height: 320px;">
                <!-- Tab 1: Students -->
                <div class="tab-pane fade show active" id="cd-tab-students">
                    <div id="cd-students-list" class="d-flex flex-column gap-2" style="max-height: 360px; overflow-y: auto;">
                        <!-- Filled by JS -->
                    </div>
                </div>

                <!-- Tab 2: Subjects -->
                <div class="tab-pane fade" id="cd-tab-subjects">
                    <div id="cd-subject-info">
                        <!-- Filled by JS -->
                    </div>
                </div>

                <!-- Tab 3: Scores -->
                <div class="tab-pane fade" id="cd-tab-scores">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light small">
                                <tr>
                                    <th>Student Name</th>
                                    <th>Student ID</th>
                                    <th>Exam / Quiz Score</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody id="cd-scores-list">
                                <!-- Filled by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab 4: Attendance -->
                <div class="tab-pane fade" id="cd-tab-attendance">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light small">
                                <tr>
                                    <th>Student</th>
                                    <th>Check-in Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="cd-attendance-list">
                                <!-- Filled by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. Batch Auto Generate Certificates Modal (Feature 6) -->
<div class="modal fade" id="batchCertModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-4 rounded-4">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold fs-6">Generate Auto Certificates (ម្តងច្រើននាក់)</h5>
                    <small class="text-secondary">បង្កើតវិញ្ញាបនបត្រស្វ័យប្រវត្តសម្រាប់សិស្សក្នុងថ្នាក់ ហើយសិស្សអាចមើលក្នុង Account ភ្លាមៗ</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.certificates.batch') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Certificate Title / Name</label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g. Certificate of Achievement in UI/UX Systems">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Certificate Category / Type (ប្រភេទវិញ្ញាបនបត្រ)</label>
                        <select name="cert_type" class="form-select" required>
                            <option value="Exam Certificate">Exam Certificate (វិញ្ញាបនបត្រប្រឡង)</option>
                            <option value="Challenge Award">Challenge Award (រង្វាន់ប្រកួតប្រជែង)</option>
                            <option value="Honor Roll">Honor Roll (តារាងកិត្តិយស)</option>
                            <option value="Dig4.0 Completion">Dig4.0 Completion (បញ្ចប់វគ្គបណ្តុះបណ្តាល)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Select Target Class (ថ្នាក់គោលដៅ)</label>
                        <select name="class_code" class="form-select" required>
                            <option value="ALL">សិស្សទាំងអស់ (All Active Students)</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->code }}">{{ $c->title }} ({{ $c->code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Issue Date</label>
                        <input type="text" name="issue_date" class="form-control" value="{{ date('F d, Y') }}" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2.5">
                        <i data-lucide="award" class="me-1" style="width: 16px; height: 16px;"></i>
                        Generate Certificates Now (Auto Batch)
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 4. Schedule Exam Modal with Category (Feature 4) -->
<div class="modal fade" id="addExamModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-4 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-6">Schedule Exam (ដាក់សំណួរប្រឡង)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.exams.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Exam Category (ប្រភេទប្រឡង)</label>
                        <select name="category" class="form-select" required>
                            <option value="Lesson Exam">Lesson Exam (ប្រឡងមេរៀន)</option>
                            <option value="Midterm exam">Midterm exam (ប្រឡងឆមាសទី១)</option>
                            <option value="Final exam">Final exam (ប្រឡងបញ្ចប់វគ្គ)</option>
                            <option value="Test exam">Test exam (ប្រឡងសាកល្បង)</option>
                            <option value="Dig4.0 exam">Dig4.0 exam (ប្រឡងបច្ចេកវិទ្យា 4.0)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Exam Title</label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g. UI/UX Design Systems">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Class / Course</label>
                        <select name="course" class="form-select" required>
                            @foreach($classes as $c)
                                <option value="{{ $c->code }}">{{ $c->title }} ({{ $c->code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Duration (Minutes)</label>
                            <input type="number" name="duration_minutes" class="form-control" value="45" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Total Points</label>
                            <input type="number" name="total_points" class="form-control" value="100" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Date & Time</label>
                        <input type="text" name="exam_date" class="form-control" required placeholder="e.g. Nov 15, 2026 • 09:00 AM">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Room</label>
                        <input type="text" name="room" class="form-control" required placeholder="e.g. Lab 402 • Media Wing">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Schedule Exam</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 5. QCM Questions Builder Modal for Each Exam (Feature 4) -->
@foreach($exams as $ex)
    <div class="modal fade" id="qcmModal_{{ $ex->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content p-3 p-md-4 rounded-4">
                <div class="modal-header border-0 pb-2">
                    <div>
                        <h5 class="modal-title fw-bold fs-6">សំណួរ QCM សម្រាប់: {{ $ex->title }} ({{ $ex->course }})</h5>
                        <small class="text-secondary">កំណត់ពិន្ទុតាមសំណួរនីមួយៗ នៅពេលសិស្សប្រឡងរួចនឹងគណនាពិន្ទុ Auto ភ្លាមៗ</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body py-3">
                    <!-- Existing Questions List -->
                    <h6 class="fw-bold mb-2">បញ្ជីសំណួរ QCM បច្ចុប្បន្ន:</h6>
                    <div class="d-flex flex-column gap-2 mb-4" style="max-height: 240px; overflow-y: auto;">
                        @forelse($examQuestions->where('exam_id', $ex->id) as $q)
                            <div class="p-3 rounded-3 border bg-body-tertiary d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="badge bg-primary fw-bold">+{{ $q->points }} PTS</span>
                                        <span class="fw-bold">{{ $q->question_text }}</span>
                                    </div>
                                    <div class="small text-secondary ps-2">
                                        <span class="{{ $q->correct_option === 'A' ? 'text-success fw-bold' : '' }}">A. {{ $q->option_a }}</span> • 
                                        <span class="{{ $q->correct_option === 'B' ? 'text-success fw-bold' : '' }}">B. {{ $q->option_b }}</span> • 
                                        <span class="{{ $q->correct_option === 'C' ? 'text-success fw-bold' : '' }}">C. {{ $q->option_c }}</span> • 
                                        <span class="{{ $q->correct_option === 'D' ? 'text-success fw-bold' : '' }}">D. {{ $q->option_d }}</span>
                                    </div>
                                </div>
                                <form action="{{ route('admin.exams.deleteQuestion', $q->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Delete Question">&times;</button>
                                </form>
                            </div>
                        @empty
                            <div class="p-3 text-center text-secondary border rounded-3">
                                មិនទាន់មានសំណួរនៅឡើយទេ។ សូមបន្ថែមសំណួរខាងក្រោម។
                            </div>
                        @endforelse
                    </div>

                    <!-- Add New Question Form -->
                    <div class="p-3 rounded-3 border bg-body-secondary">
                        <h6 class="fw-bold text-primary mb-3">+ បន្ថែមសំណួរ QCM ថ្មី:</h6>
                        <form action="{{ route('admin.exams.storeQuestion') }}" method="POST">
                            @csrf
                            <input type="hidden" name="exam_id" value="{{ $ex->id }}">
                            <div class="mb-2">
                                <label class="form-label small fw-bold">ខ្លឹមសារសំណួរ (Question Text)</label>
                                <input type="text" name="question_text" class="form-control form-control-sm" required placeholder="ឧទាហរណ៍: តើអ្វីជាអត្ថប្រយោជន៍ចម្បងនៃ Design Tokens?">
                            </div>
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <input type="text" name="option_a" class="form-control form-control-sm" required placeholder="ជម្រើស A">
                                </div>
                                <div class="col-6">
                                    <input type="text" name="option_b" class="form-control form-control-sm" required placeholder="ជម្រើស B">
                                </div>
                                <div class="col-6">
                                    <input type="text" name="option_c" class="form-control form-control-sm" required placeholder="ជម្រើស C">
                                </div>
                                <div class="col-6">
                                    <input type="text" name="option_d" class="form-control form-control-sm" required placeholder="ជម្រើស D">
                                </div>
                            </div>
                            <div class="row g-2 align-items-center">
                                <div class="col-6">
                                    <label class="form-label small fw-bold mb-0">ចម្លើយត្រឹមត្រូវ (Correct Option)</label>
                                    <select name="correct_option" class="form-select form-select-sm" required>
                                        <option value="A">ជម្រើស A (Option A)</option>
                                        <option value="B">ជម្រើស B (Option B)</option>
                                        <option value="C">ជម្រើស C (Option C)</option>
                                        <option value="D">ជម្រើស D (Option D)</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label class="form-label small fw-bold mb-0">ពិន្ទុ (Points)</label>
                                    <input type="number" name="points" class="form-control form-control-sm" value="25" required>
                                </div>
                                <div class="col-3 pt-3">
                                    <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">Save QCM</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- 6. Create Real-Time Challenge Modal (Feature 5) -->
<div class="modal fade" id="addChallengeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-4 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-6">បង្កើតកម្មវិធីប្រកួតប្រជែង (Real-Time Challenge)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.challenges.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Challenge Title</label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g. Design 3 Micro-interactions">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Question / Challenge Prompt</label>
                        <textarea name="question_text" class="form-control" rows="2" placeholder="សំណួរប្រកួតប្រជែង..."></textarea>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <input type="text" name="option_a" class="form-control form-control-sm" placeholder="ជម្រើស A">
                        </div>
                        <div class="col-6">
                            <input type="text" name="option_b" class="form-control form-control-sm" placeholder="ជម្រើស B">
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Points Reward</label>
                            <input type="number" name="points" class="form-control" value="500" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Duration (Minutes)</label>
                            <input type="number" name="duration_minutes" class="form-control" value="15" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Deadline / Round</label>
                        <input type="text" name="deadline" class="form-control" value="Live Now (15 mins)" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-warning text-dark w-100 fw-bold">Publish Live Challenge</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 7. Generate QR & Short Passcode Modal (Feature 11) -->
<div class="modal fade" id="addQrModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-4 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-6">Generate QR Code & លេខកូដខ្លីតាមថ្នាក់</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.qrCodes.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">QR Session Title</label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g. Lab 402 Morning Check-in">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Target Class (ថ្នាក់រៀន)</label>
                        <select name="class_code" class="form-select" required>
                            @foreach($classes as $c)
                                <option value="{{ $c->code }}">{{ $c->title }} ({{ $c->code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">វគ្គសិក្សា (Session - ក្នុង ១ ថ្ងៃមាន ២ Session)</label>
                        <select name="session_name" class="form-select fw-bold" required>
                            <option value="Session 1 (ព្រឹក)">🌅 Session 1 (ព្រឹក: 08:00 AM - 11:30 AM)</option>
                            <option value="Session 2 (រសៀល)">🌇 Session 2 (រសៀល: 01:00 PM - 05:00 PM)</option>
                        </select>
                        <small class="text-secondary" style="font-size: 11px;">សិស្សត្រូវស្កេនវត្តមានចំនួន ២ ដងក្នុង ១ ថ្ងៃ (Session 1 ព្រឹក និង Session 2 រសៀល)។</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Session Date (ថ្ងៃបង្រៀន)</label>
                        <input type="date" name="session_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Expiration</label>
                        <input type="text" name="expires_at" class="form-control" value="Today 11:59 PM" required>
                    </div>
                    <input type="hidden" name="type" value="Attendance">
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Generate QR & Short Code (Auto 4-Digit)</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 8. Upload Resource Modal (Feature 12) -->
<div class="modal fade" id="addResourceModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-4 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-6">Upload Lesson Material (PDF)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.resources.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Lesson Title</label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g. Lecture 05 - Design Systems">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Class / Course</label>
                        <select name="course" class="form-select" required>
                            @foreach($classes as $c)
                                <option value="{{ $c->code }}">{{ $c->title }} ({{ $c->code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">PDF File (សិស្សអាចមើល View Online បាន)</label>
                        <input type="file" name="pdf_file" class="form-control" accept=".pdf">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Upload PDF Resource</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 9. Assign Student to Class Modal -->
<div class="modal fade" id="assignClassModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-4 rounded-4">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold fs-6">Assign Student to Class</h5>
                    <small class="text-secondary">Enrolling will unlock student's full features on Client Side</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.students.assignClass') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <input type="hidden" name="student_id" id="assign-student-id">
                    <div class="p-2.5 rounded-3 bg-body-secondary mb-3">
                        <small class="text-secondary d-block" style="font-size: 11px;">Selected Student</small>
                        <h6 class="fw-bold mb-0 text-primary" id="assign-student-name">Student Name</h6>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Select Class to Assign</label>
                        <select name="class_id" class="form-select" required>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}">
                                    {{ $c->title }} ({{ $c->code }}) • {{ $c->prof }} [{{ $c->schedule_time }}]
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Enroll Student</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 10. Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-4 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-6">Add New Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.students.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Full Name</label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g. Liam Sokha">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Student ID</label>
                        <input type="text" name="student_id" class="form-control" required placeholder="e.g. GZ20260499">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" required placeholder="student@genzdigital.edu">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Major</label>
                        <input type="text" name="major" class="form-control" required placeholder="e.g. Visual Communication">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Assign to Class Immediately</label>
                        <select name="class_id" class="form-select">
                            <option value="">Do not assign yet (Pending Enrollment)</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}">{{ $c->title }} ({{ $c->code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Create Student</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 11. Add Class Modal -->
<div class="modal fade" id="addClassModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-4 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-6">Add New Academic Class</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.classes.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Class / Subject Title</label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g. 3D Generative AI Graphics">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Course Code</label>
                        <input type="text" name="code" class="form-control" required placeholder="e.g. ART401">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Room</label>
                        <input type="text" name="room" class="form-control" required placeholder="e.g. Lab 405 • AI Wing">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Instructor Name</label>
                        <input type="text" name="prof" class="form-control" required placeholder="e.g. Dr. Jennifer Wu">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Schedule Time</label>
                        <input type="text" name="schedule_time" class="form-control" required placeholder="e.g. 02:00 PM - 04:30 PM">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Create Class</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 12. Add Collab Modal -->
<div class="modal fade" id="addCollabModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-4 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-6">Create Team Collaboration & QCM Sprint</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.collaborations.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Project Title</label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g. AI Autonomous Drone Hackathon">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Class</label>
                        <select name="class_code" class="form-select">
                            @foreach($classes as $c)
                                <option value="{{ $c->code }}">{{ $c->title }} ({{ $c->code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">QCM Problem / Prompt</label>
                        <textarea name="exercise_prompt" class="form-control" rows="2" placeholder="លំហាត់ដោះស្រាយរួមគ្នា..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Required Role</label>
                        <input type="text" name="required_role" class="form-control" required placeholder="e.g. Computer Vision Engineer">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Max Members</label>
                        <input type="number" name="max_members" class="form-control" value="4" min="2" max="10" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Post Team Project</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 13. Single Issue Certificate Modal -->
<div class="modal fade" id="addCertModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-4 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-6">Issue Single Certificate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.certificates.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Certificate Title</label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g. UX Master Certificate">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Recipient Student</label>
                        <select name="recipient" class="form-select">
                            @foreach($students as $st)
                                <option value="{{ $st->name }}">{{ $st->name }} ({{ $st->student_id }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Issue Date</label>
                        <input type="text" name="issue_date" class="form-control" value="{{ date('F d, Y') }}" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Issue Certificate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 14. Upload Book Modal (Library Management) -->
<div class="modal fade" id="addBookModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-4 rounded-4 shadow-lg border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-6">Upload New E-Book to Library</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.books.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Book Title</label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g. Design Systems Handbook 2026">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Author(s)</label>
                        <input type="text" name="author" class="form-control" required placeholder="e.g. Dr. Alex Vance">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="UI/UX Design">UI/UX Design</option>
                                <option value="Computer Science">Computer Science</option>
                                <option value="Engineering">Engineering</option>
                                <option value="Business & Media">Business & Media</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Total Pages</label>
                            <input type="number" name="total_pages" class="form-control" value="280" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Description / Summary</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="សេចក្តីសង្ខេបសៀវភៅ..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2.5">Upload Book to Library</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 15. Create News Post Modal (Announcements Management) -->
<div class="modal fade" id="addPostModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 p-md-4 rounded-4 shadow-lg border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-6">Publish Campus News & Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.posts.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Post Title</label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g. សេចក្តីជូនដំណឹងស្តីពីការប្រឡងឆមាស">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="ANNOUNCEMENT">ANNOUNCEMENT</option>
                                <option value="EVENT">CAMPUS EVENT</option>
                                <option value="ACADEMIC">ACADEMIC NOTICE</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Author / Dept</label>
                            <input type="text" name="author" class="form-control" value="Academic Affairs Office" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Content</label>
                        <textarea name="content" class="form-control" rows="4" placeholder="ខ្លឹមសារនៃសេចក្តីជូនដំណឹង..." required></textarea>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="is_pinned" value="1" id="checkPinned">
                        <label class="form-check-label small fw-semibold" for="checkPinned">
                            📌 Pin this announcement at the top
                        </label>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2.5">Publish Announcement</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const allStudentsData = @json($students);

    // =========================================================================
    // 1. Manage Users: Filter by Class & Instant Search
    // =========================================================================
    function filterUsersByClass(selectedClass) {
        const isPendingView = !document.getElementById('tbody-students-pending').classList.contains('d-none');
        
        // If filtering by a specific class while on pending view, switch to all view
        if (selectedClass !== 'ALL' && isPendingView) {
            toggleStudentListView('all');
        }

        const rows = document.querySelectorAll('.student-row');
        rows.forEach(r => {
            const classes = r.getAttribute('data-classes') || '';
            if (selectedClass === 'ALL' || classes.includes(selectedClass)) {
                r.style.display = '';
            } else {
                r.style.display = 'none';
            }
        });
    }

    function searchStudents(query) {
        const q = (query || '').toLowerCase().trim();
        const activeTbody = document.getElementById('tbody-students-pending').classList.contains('d-none')
            ? document.getElementById('tbody-students-all')
            : document.getElementById('tbody-students-pending');

        const rows = activeTbody.querySelectorAll('.student-row');
        rows.forEach(r => {
            const name = (r.getAttribute('data-name') || '');
            const id = (r.getAttribute('data-id') || '');
            if (!q || name.includes(q) || id.includes(q)) {
                r.style.display = '';
            } else {
                r.style.display = 'none';
            }
        });
    }

    // =========================================================================
    // 2. Show on Screen: Click to Spotlight AJAX
    // =========================================================================
    function spotlightStudentAJAX(studentId, studentName) {
        fetch("{{ route('admin.screen.spotlights.add') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                student_id: studentId,
                preview_title: `Live Prototype Spotlight: ${studentName}`
            })
        })
        .then(res => res.json())
        .then(data => {
            showAdminToast(`សិស្ស ${studentName} ត្រូវបានដាក់បង្ហាញលើ Full Screen! (4-User Rotation)`);
        })
        .catch(err => {
            showAdminToast(`Added ${studentName} to screen!`);
        });
    }

    // =========================================================================
    // 3. Reports: Filter by Class
    // =========================================================================
    function updateReportDisplay(classCode) {
        const exportBtn = document.getElementById('btn-export-report');
        if (classCode === 'ALL') {
            exportBtn.href = "{{ route('admin.reports.export') }}";
            document.getElementById('rep-sessions').textContent = '36 Hours';
            document.getElementById('rep-attendance').textContent = '91.4%';
            document.getElementById('rep-exam-avg').textContent = '88.5%';
        } else {
            exportBtn.href = `{{ route('admin.reports.export') }}?class_code=${classCode}`;
            document.getElementById('rep-sessions').textContent = '14 Hours';
            document.getElementById('rep-attendance').textContent = '94.2%';
            document.getElementById('rep-exam-avg').textContent = '91.8%';
        }
        showAdminToast(`Report filtered for: ${classCode}`);
    }

    // =========================================================================
    // 9. Game Random: Filter & Roulette with Profile Popup Modal
    // =========================================================================
    let currentGameStudents = [...allStudentsData];

    function filterGameStudents(classCode) {
        if (classCode === 'ALL') {
            currentGameStudents = [...allStudentsData];
        } else {
            currentGameStudents = allStudentsData.filter(st => {
                if (!st.enrolled_classes) return false;
                return st.enrolled_classes.some(c => c.course_code === classCode);
            });
            if (currentGameStudents.length === 0) {
                currentGameStudents = [...allStudentsData];
            }
        }
        document.getElementById('eligible-count').textContent = currentGameStudents.length;

        // Render eligible list
        const listEl = document.getElementById('eligible-list');
        listEl.innerHTML = currentGameStudents.map(st => `
            <div class="p-2.5 rounded-3 bg-body-secondary d-flex align-items-center gap-2">
                <img src="${st.avatar}" class="rounded-circle object-fit-cover" style="width: 32px; height: 32px;">
                <div class="flex-grow-1 min-w-0">
                    <span class="fw-bold small d-block text-truncate">${st.name}</span>
                    <small class="text-secondary" style="font-size: 10px;">${st.student_id} • ${st.major}</small>
                </div>
            </div>
        `).join('');
    }

    function spinRandomStudentWithPopup() {
        if (!currentGameStudents || currentGameStudents.length === 0) return;

        const btn = document.getElementById('btn-spin');
        const box = document.getElementById('picker-box');
        const avatar = document.getElementById('winner-avatar');
        const name = document.getElementById('winner-name');
        const info = document.getElementById('winner-info');

        btn.disabled = true;
        box.classList.remove('highlight');

        let counter = 0;
        const totalSpins = 25;
        const interval = setInterval(() => {
            const randomIndex = Math.floor(Math.random() * currentGameStudents.length);
            const candidate = currentGameStudents[randomIndex];

            avatar.src = candidate.avatar;
            name.textContent = candidate.name;
            info.textContent = `Cycling through class... (${candidate.student_id})`;

            counter++;
            if (counter >= totalSpins) {
                clearInterval(interval);
                btn.disabled = false;
                box.classList.add('highlight');

                const winner = candidate;
                name.textContent = `🎉 ${winner.name} 🎉`;
                info.textContent = `Selected Student! • ${winner.student_id} (${winner.major})`;

                // Confetti Burst!
                if (window.confetti) {
                    window.confetti({ particleCount: 130, spread: 80, origin: { y: 0.6 } });
                }

                // Show Bootstrap Profile Popup Modal
                setTimeout(() => {
                    document.getElementById('modal-winner-avatar').src = winner.avatar;
                    document.getElementById('modal-winner-name').textContent = winner.name;
                    document.getElementById('modal-winner-id').textContent = winner.student_id;
                    document.getElementById('modal-winner-major').textContent = winner.major;
                    document.getElementById('modal-winner-attendance').textContent = winner.attendance_rate || '95%';
                    document.getElementById('modal-winner-status').textContent = winner.status || 'Active';
                    document.getElementById('modal-winner-gpa').textContent = '3.88 / 4.00';

                    document.getElementById('modal-winner-spotlight-btn').onclick = () => {
                        spotlightStudentAJAX(winner.student_id, winner.name);
                        bootstrap.Modal.getInstance(document.getElementById('winnerProfileModal')).hide();
                    };

                    const modal = new bootstrap.Modal(document.getElementById('winnerProfileModal'));
                    modal.show();
                }, 600);
            }
        }, 80);
    }

    // =========================================================================
    // 10. Attendance: Filter by Class & Update Export Links
    // =========================================================================
    function filterAttendanceTable(classCode) {
        const rows = document.querySelectorAll('.att-row');
        rows.forEach(r => {
            const code = r.getAttribute('data-code');
            if (classCode === 'ALL' || code === classCode) {
                r.style.display = '';
            } else {
                r.style.display = 'none';
            }
        });

        // Update Excel & PDF links
        const excelBtn = document.getElementById('btn-export-excel');
        const pdfBtn = document.getElementById('btn-export-pdf');
        if (classCode === 'ALL') {
            excelBtn.href = "{{ route('admin.attendance.export', ['format' => 'excel']) }}";
            pdfBtn.href = "{{ route('admin.attendance.export', ['format' => 'pdf']) }}";
        } else {
            excelBtn.href = `{{ route('admin.attendance.export') }}?format=excel&class_code=${classCode}`;
            pdfBtn.href = `{{ route('admin.attendance.export') }}?format=pdf&class_code=${classCode}`;
        }
    }

    function filterAttendanceSession(sessionName) {
        const rows = document.querySelectorAll('.att-row');
        rows.forEach(r => {
            const sess = r.getAttribute('data-session') || '';
            if (sessionName === 'ALL' || sess.includes(sessionName)) {
                r.style.display = '';
            } else {
                r.style.display = 'none';
            }
        });
    }

    function updateAttStatus(id, newStatus) {
        fetch(`${window.BASE_URL}/admin/attendance/${id}/status`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(res => res.json())
        .then(data => {
            const badge = document.getElementById(`att-badge-${id}`);
            if (badge) {
                badge.textContent = newStatus;
                badge.className = `badge ${newStatus === 'Present' ? 'bg-success' : (newStatus === 'Late' ? 'bg-warning text-dark' : 'bg-danger')} fw-bold`;
            }
            showAdminToast(`Attendance updated: ${newStatus}`);
        });
    }

    // =========================================================================
    // 11. Project QR Pass to Screen
    // =========================================================================
    function activateQrCodeAJAX(id, title) {
        fetch(`${window.BASE_URL}/admin/qr-codes/${id}/activate`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        })
        .then(res => res.json())
        .then(data => {
            showAdminToast(`QR Pass "${title}" projected live on classroom display!`);
        });
    }

    // =========================================================================
    // 13. Class Detail: 4-Tab Interactive Modal (AJAX)
    // =========================================================================
    async function openClassDetailsAJAX(classId) {
        try {
            const res = await fetch(`${window.BASE_URL}/admin/classes/${classId}/details`);
            const data = await res.json();

            document.getElementById('cd-title').textContent = `${data.class.title} (${data.class.code})`;
            document.getElementById('cd-subtitle').textContent = `Instructor: ${data.class.prof} • Room: ${data.class.room} • ${data.class.schedule_time}`;

            // Tab 1: Students
            const studentsContainer = document.getElementById('cd-students-list');
            if (data.students && data.students.length > 0) {
                studentsContainer.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center mb-2 px-1">
                        <span class="small fw-bold text-secondary"><i data-lucide="users" style="width: 13px; height: 13px;" class="me-1"></i>សិស្សដែលបាន Enroll (${data.students.length} នាក់)</span>
                        <span class="badge bg-success-subtle text-success fw-bold">Active Roster</span>
                    </div>
                ` + data.students.map(st => `
                    <div class="p-2.5 rounded-3 border bg-body-tertiary d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <img src="${st.avatar}" class="rounded-circle object-fit-cover shadow-xs" style="width: 38px; height: 38px;">
                            <div>
                                <strong class="small d-block">${st.name}</strong>
                                <small class="text-secondary">${st.student_id} • ${st.major}</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-success-subtle text-success fw-bold">Enrolled</span>
                            <button type="button" class="btn btn-sm btn-outline-danger py-0.5 px-2 fw-bold" onclick="unassignStudentDirect('${st.student_id}', '${data.class.code}')" style="font-size: 11px;" title="ដកសិស្សចេញពីថ្នាក់នេះ">
                                ដកចេញ
                            </button>
                        </div>
                    </div>
                `).join('');
            } else {
                studentsContainer.innerHTML = `
                    <div class="p-4 text-center text-secondary">
                        <i data-lucide="users" class="mb-2 opacity-50" style="width: 36px; height: 36px;"></i>
                        <p class="mb-1 fw-bold">មិនទាន់មានសិស្ស Enroll ចូលថ្នាក់នេះនៅឡើយទេ (No students enrolled yet)</p>
                        <small class="text-secondary">សូមទៅកាន់ផ្ទាំង <strong>Manage User</strong> រួចធីក Checkbox ដើម្បី Enroll សិស្សចូលថ្នាក់ ${data.class.title}។</small>
                    </div>
                `;
            }

            // Tab 2: Subject Outline
            const sub = data.subject;
            document.getElementById('cd-subject-info').innerHTML = `
                <div class="p-3 rounded-4 bg-body-tertiary mb-3">
                    <h6 class="fw-bold text-primary mb-2">${sub.title} • ${sub.code}</h6>
                    <p class="small text-secondary mb-2">Credits: ${sub.credits} Credits • Class Type: ${sub.type}</p>
                    <small class="fw-bold d-block mb-1">Course Units Syllabus:</small>
                    <ul class="small text-secondary mb-0 ps-3">
                        ${sub.syllabus.map(s => `<li>${s}</li>`).join('')}
                    </ul>
                </div>
            `;

            // Tab 3: Scores
            const scoresContainer = document.getElementById('cd-scores-list');
            if (data.scores && data.scores.length > 0) {
                scoresContainer.innerHTML = data.scores.map(sc => `
                    <tr>
                        <td class="fw-bold">${sc.student_name || sc.student_id}</td>
                        <td><code>${sc.student_id}</code></td>
                        <td><span class="badge bg-primary-subtle text-primary fw-bold">${sc.score} / 100</span></td>
                        <td><span class="badge bg-success-subtle text-success fw-bold">${sc.grade}</span></td>
                    </tr>
                `).join('');
            } else {
                scoresContainer.innerHTML = `<tr><td colspan="4" class="text-center py-3 text-secondary">No exam scores recorded yet.</td></tr>`;
            }

            // Tab 4: Attendance
            const attContainer = document.getElementById('cd-attendance-list');
            if (data.attendances && data.attendances.length > 0) {
                attContainer.innerHTML = data.attendances.map(at => `
                    <tr>
                        <td class="fw-bold">${at.student_name}</td>
                        <td class="small">${at.check_in_time}</td>
                        <td><span class="badge ${at.status === 'Present' ? 'bg-success' : 'bg-warning text-dark'} fw-bold">${at.status}</span></td>
                    </tr>
                `).join('');
            } else {
                attContainer.innerHTML = `<tr><td colspan="3" class="text-center py-3 text-secondary">No attendance logs for this class.</td></tr>`;
            }

            const modal = new bootstrap.Modal(document.getElementById('classDetailsModal'));
            modal.show();
            if (window.lucide) window.lucide.createIcons();
        } catch (err) {
            console.error("Error loading class details:", err);
            showAdminToast("Could not load class details.");
        }
    }

    // Modal Opener Helper
    function openAssignModal(studentId, studentName) {
        document.getElementById('assign-student-id').value = studentId;
        document.getElementById('assign-student-name').textContent = studentName + ' (' + studentId + ')';
        const modal = new bootstrap.Modal(document.getElementById('assignClassModal'));
        modal.show();
    }

    // Toggle View: Pending Enrollment vs All Students
    function toggleStudentListView(view) {
        const tbodyPending = document.getElementById('tbody-students-pending');
        const tbodyAll = document.getElementById('tbody-students-all');
        const btnPending = document.getElementById('btn-tab-pending');
        const btnAll = document.getElementById('btn-tab-all');

        if (view === 'pending') {
            tbodyPending.classList.remove('d-none');
            tbodyAll.classList.add('d-none');
            btnPending.className = 'btn btn-sm btn-primary rounded-pill px-3 fw-bold';
            btnAll.className = 'btn btn-sm btn-light rounded-pill px-3 fw-bold text-secondary';
        } else {
            tbodyPending.classList.add('d-none');
            tbodyAll.classList.remove('d-none');
            btnPending.className = 'btn btn-sm btn-light rounded-pill px-3 fw-bold text-secondary';
            btnAll.className = 'btn btn-sm btn-primary rounded-pill px-3 fw-bold';
        }
        updateSelectedCount();
    }

    // Checkbox Batch Enroll Helpers
    function toggleSelectAllStudents(master) {
        const activeTbody = document.getElementById('tbody-students-pending').classList.contains('d-none')
            ? document.getElementById('tbody-students-all')
            : document.getElementById('tbody-students-pending');

        activeTbody.querySelectorAll('input[type="checkbox"]').forEach(chk => {
            chk.checked = master.checked;
        });
        updateSelectedCount();
    }

    function updateSelectedCount() {
        const activeTbody = document.getElementById('tbody-students-pending').classList.contains('d-none')
            ? document.getElementById('tbody-students-all')
            : document.getElementById('tbody-students-pending');

        const checkedBoxes = activeTbody.querySelectorAll('input[type="checkbox"]:checked');
        const count = checkedBoxes.length;

        const countText = document.getElementById('selectedCountText');
        const btn = document.getElementById('btnBatchEnroll');
        if (countText) countText.textContent = count;
        if (btn) btn.disabled = count === 0;

        const master = document.getElementById('checkAllStudents');
        const allBoxes = activeTbody.querySelectorAll('input[type="checkbox"]');
        if (master && allBoxes.length > 0) {
            master.checked = count === allBoxes.length;
            master.indeterminate = count > 0 && count < allBoxes.length;
        }
    }

    // Direct Unenroll helper from Class Modal
    function unassignStudentDirect(studentId, courseCode) {
        if (!confirm(`តើអ្នកពិតជាចង់ដកសិស្ស ${studentId} ចេញពីថ្នាក់ ${courseCode} មែនទេ? (សិស្សនេះនឹងត្រឡប់ទៅ Students Manage វិញ)`)) return;

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.students.unassignClass") }}';

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        const stInput = document.createElement('input');
        stInput.type = 'hidden';
        stInput.name = 'student_id';
        stInput.value = studentId;
        form.appendChild(stInput);

        const codeInput = document.createElement('input');
        codeInput.type = 'hidden';
        codeInput.name = 'course_code';
        codeInput.value = courseCode;
        form.appendChild(codeInput);

        document.body.appendChild(form);
        form.submit();
    }
</script>
@endpush
