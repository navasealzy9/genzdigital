<div class="d-flex flex-column gap-1">
    <button class="admin-nav-item active d-flex align-items-center justify-content-between" data-admin-tab="dashboard" onclick="switchAdminTab('dashboard')">
        <div class="d-flex align-items-center gap-2.5">
            <i data-lucide="layout-dashboard" style="width: 17px; height: 17px;"></i>
            <span>Dashboard Overview</span>
        </div>
        <span class="status-indicator-live" title="Live System"></span>
    </button>

    <div class="sidebar-section-title mt-2">1. Users & Classroom</div>
    <button class="admin-nav-item d-flex align-items-center justify-content-between" data-admin-tab="users" onclick="switchAdminTab('users')">
        <div class="d-flex align-items-center gap-2.5">
            <i data-lucide="users" style="width: 17px; height: 17px;"></i>
            <span>Manage User</span>
        </div>
        @if(isset($pendingStudents) && $pendingStudents->count() > 0)
            <span class="badge bg-warning text-dark rounded-pill" style="font-size: 10px;" title="{{ $pendingStudents->count() }} Pending Enrollment">
                {{ $pendingStudents->count() }}
            </span>
        @else
            <span class="badge bg-body-secondary text-secondary rounded-pill" style="font-size: 10px;">
                {{ isset($students) ? $students->count() : 0 }}
            </span>
        @endif
    </button>
    <button class="admin-nav-item d-flex align-items-center justify-content-between" data-admin-tab="screen" onclick="switchAdminTab('screen')">
        <div class="d-flex align-items-center gap-2.5">
            <i data-lucide="monitor" style="width: 17px; height: 17px;"></i>
            <span>Show User on Screen</span>
        </div>
        @if(isset($screenSpotlights) && $screenSpotlights->count() > 0)
            <span class="badge bg-primary text-white rounded-pill" style="font-size: 10px;">
                {{ $screenSpotlights->count() }}
            </span>
        @endif
    </button>
    <button class="admin-nav-item d-flex align-items-center gap-2.5" data-admin-tab="game" onclick="switchAdminTab('game')">
        <i data-lucide="dices" style="width: 17px; height: 17px;"></i>
        <span>Game Random</span>
    </button>

    <div class="sidebar-section-title mt-2">2. Academics & Performance</div>
    <button class="admin-nav-item d-flex align-items-center justify-content-between" data-admin-tab="classes" onclick="switchAdminTab('classes')">
        <div class="d-flex align-items-center gap-2.5">
            <i data-lucide="book-open" style="width: 17px; height: 17px;"></i>
            <span>Class Manage</span>
        </div>
        <span class="badge bg-body-secondary text-secondary rounded-pill" style="font-size: 10px;">
            {{ isset($classes) ? $classes->count() : 0 }}
        </span>
    </button>
    <button class="admin-nav-item d-flex align-items-center gap-2.5" data-admin-tab="attendance" onclick="switchAdminTab('attendance')">
        <i data-lucide="check-circle-2" style="width: 17px; height: 17px;"></i>
        <span>Attendance Tracker</span>
    </button>
    <button class="admin-nav-item d-flex align-items-center justify-content-between" data-admin-tab="exams" onclick="switchAdminTab('exams')">
        <div class="d-flex align-items-center gap-2.5">
            <i data-lucide="file-text" style="width: 17px; height: 17px;"></i>
            <span>Exam Management</span>
        </div>
        <span class="badge bg-body-secondary text-secondary rounded-pill" style="font-size: 10px;">
            {{ isset($exams) ? $exams->count() : 0 }}
        </span>
    </button>
    <button class="admin-nav-item d-flex align-items-center gap-2.5" data-admin-tab="reports" onclick="switchAdminTab('reports')">
        <i data-lucide="bar-chart-3" style="width: 17px; height: 17px;"></i>
        <span>Reports & Analytics</span>
    </button>

    <div class="sidebar-section-title mt-2">3. Teaching & Tools</div>
    <button class="admin-nav-item d-flex align-items-center gap-2.5" data-admin-tab="slides" onclick="switchAdminTab('slides')">
        <i data-lucide="presentation" style="width: 17px; height: 17px;"></i>
        <span>Show Slide Teaching</span>
    </button>
    <button class="admin-nav-item d-flex align-items-center gap-2.5" data-admin-tab="qr" onclick="switchAdminTab('qr')">
        <i data-lucide="qr-code" style="width: 17px; height: 17px;"></i>
        <span>QR Code Manage</span>
    </button>
    <button class="admin-nav-item d-flex align-items-center justify-content-between" data-admin-tab="resources" onclick="switchAdminTab('resources')">
        <div class="d-flex align-items-center gap-2.5">
            <i data-lucide="folder-down" style="width: 17px; height: 17px;"></i>
            <span>Learning Resources</span>
        </div>
        <span class="badge bg-body-secondary text-secondary rounded-pill" style="font-size: 10px;">
            {{ isset($resources) ? $resources->count() : 0 }}
        </span>
    </button>

    <div class="sidebar-section-title mt-2">4. Engagement & Awards</div>
    <button class="admin-nav-item d-flex align-items-center justify-content-between" data-admin-tab="challenges" onclick="switchAdminTab('challenges')">
        <div class="d-flex align-items-center gap-2.5">
            <i data-lucide="trophy" style="width: 17px; height: 17px;"></i>
            <span>Campus Challenges</span>
        </div>
        @if(isset($challenges) && $challenges->where('status', 'Active')->count() > 0)
            <span class="badge bg-warning text-dark rounded-pill" style="font-size: 10px;">
                {{ $challenges->where('status', 'Active')->count() }} Live
            </span>
        @endif
    </button>
    <button class="admin-nav-item d-flex align-items-center gap-2.5" data-admin-tab="certificates" onclick="switchAdminTab('certificates')">
        <i data-lucide="award" style="width: 17px; height: 17px;"></i>
        <span>Certificates</span>
    </button>
    <button class="admin-nav-item d-flex align-items-center gap-2.5" data-admin-tab="collab" onclick="switchAdminTab('collab')">
        <i data-lucide="user-plus" style="width: 17px; height: 17px;"></i>
        <span>Collaboration Teams</span>
    </button>

    <div class="sidebar-section-title mt-2">5. Library & News Media</div>
    <button class="admin-nav-item d-flex align-items-center justify-content-between" data-admin-tab="library" onclick="switchAdminTab('library')">
        <div class="d-flex align-items-center gap-2.5">
            <i data-lucide="book" style="width: 17px; height: 17px;"></i>
            <span>Digital Library (Books)</span>
        </div>
        <span class="badge bg-body-secondary text-secondary rounded-pill" style="font-size: 10px;">
            {{ isset($books) ? $books->count() : 0 }}
        </span>
    </button>
    <button class="admin-nav-item d-flex align-items-center justify-content-between" data-admin-tab="news" onclick="switchAdminTab('news')">
        <div class="d-flex align-items-center gap-2.5">
            <i data-lucide="newspaper" style="width: 17px; height: 17px;"></i>
            <span>Campus News & Posts</span>
        </div>
        <span class="badge bg-body-secondary text-secondary rounded-pill" style="font-size: 10px;">
            {{ isset($posts) ? $posts->count() : 0 }}
        </span>
    </button>
</div>
