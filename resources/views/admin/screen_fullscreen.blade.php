<!DOCTYPE html>
<html lang="km" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Classroom Projector Spotlight - GenZ Digital Campus OS</title>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --app-font: 'Google Sans', 'Kantumruy Pro', 'Noto Sans Khmer', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            --spotlight-neon: #3b82f6;
            --spotlight-glow: rgba(59, 130, 246, 0.45);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: var(--app-font);
            background: radial-gradient(circle at 50% 25%, #0f172a 0%, #030712 100%);
            color: #f8fafc;
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Top Bar */
        .projector-header {
            background: rgba(15, 23, 42, 0.88);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 1rem 2rem;
            z-index: 10;
        }

        .live-dot {
            width: 12px;
            height: 12px;
            background-color: #ef4444;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 12px #ef4444;
            animation: pulseDot 1.5s infinite;
        }

        @keyframes pulseDot {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.25); opacity: 1; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }

        /* Spotlight Container & Grid */
        .spotlight-container-wrapper {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(1rem, 2.5vw, 2.5rem);
            min-height: calc(100vh - 160px);
        }

        .spotlight-grid {
            width: 100%;
            margin: 0 auto;
            display: grid;
            gap: clamp(1.5rem, 2.5vw, 3rem);
            align-items: stretch;
            justify-content: center;
        }

        .spotlight-grid.grid-1 {
            grid-template-columns: 1fr;
            max-width: 900px;
        }

        .spotlight-grid.grid-2 {
            grid-template-columns: repeat(2, 1fr);
            max-width: 1480px;
        }

        .spotlight-grid.grid-3,
        .spotlight-grid.grid-4 {
            grid-template-columns: repeat(2, 1fr);
            max-width: 1560px;
        }

        @media (max-width: 900px) {
            .spotlight-grid.grid-2,
            .spotlight-grid.grid-3,
            .spotlight-grid.grid-4 {
                grid-template-columns: 1fr;
            }
        }

        /* Hero Spotlight Card (Clean, Focused, Huge Avatar & Name) */
        .user-spotlight-hero {
            background: radial-gradient(circle at 50% 15%, rgba(59, 130, 246, 0.14) 0%, rgba(15, 23, 42, 0.85) 100%);
            border: 2px solid rgba(59, 130, 246, 0.38);
            border-radius: clamp(24px, 3vw, 38px);
            padding: clamp(2.2rem, 4vw, 4.5rem) clamp(1.5rem, 3vw, 3.5rem);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(18px);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.65), 0 0 45px rgba(59, 130, 246, 0.25);
            animation: fadeInHero 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .user-spotlight-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899);
        }

        .user-spotlight-hero:hover {
            transform: translateY(-4px);
            border-color: rgba(59, 130, 246, 0.7);
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.75), 0 0 55px rgba(59, 130, 246, 0.4);
        }

        @keyframes fadeInHero {
            from { opacity: 0; transform: scale(0.96) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        /* Avatar Large with Halo Glow */
        .spotlight-avatar-wrapper {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: clamp(1.25rem, 2vw, 2.25rem);
        }

        .spotlight-avatar-halo {
            position: absolute;
            inset: -16px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.55) 0%, rgba(139, 92, 246, 0.3) 50%, transparent 72%);
            filter: blur(18px);
            animation: pulseHalo 3.5s ease-in-out infinite alternate;
            z-index: 0;
            pointer-events: none;
        }

        @keyframes pulseHalo {
            0% { transform: scale(0.95); opacity: 0.55; }
            100% { transform: scale(1.1); opacity: 0.95; }
        }

        .spotlight-avatar-img {
            position: relative;
            z-index: 1;
            border-radius: 50%;
            border: 5px solid #3b82f6;
            box-shadow: 0 0 45px rgba(59, 130, 246, 0.55), 0 14px 32px rgba(0, 0, 0, 0.7);
            object-fit: cover;
            background-color: #1e293b;
            transition: transform 0.3s ease;
        }

        .grid-1 .spotlight-avatar-img {
            width: clamp(210px, 24vw, 320px);
            height: clamp(210px, 24vw, 320px);
            border-width: 6px;
        }

        .grid-2 .spotlight-avatar-img {
            width: clamp(165px, 17vw, 240px);
            height: clamp(165px, 17vw, 240px);
            border-width: 5px;
        }

        .grid-3 .spotlight-avatar-img,
        .grid-4 .spotlight-avatar-img {
            width: clamp(125px, 12vw, 175px);
            height: clamp(125px, 12vw, 175px);
            border-width: 4px;
        }

        /* Big Student Name */
        .spotlight-name-row {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: clamp(0.5rem, 1vw, 1rem);
            margin-bottom: clamp(0.75rem, 1.2vw, 1.4rem);
            flex-wrap: wrap;
        }

        .spotlight-student-name {
            margin: 0;
            color: #ffffff;
            font-weight: 800;
            letter-spacing: -0.02em;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.75);
            line-height: 1.2;
        }

        .grid-1 .spotlight-student-name {
            font-size: clamp(2.4rem, 4.4vw, 4.2rem);
        }

        .grid-2 .spotlight-student-name {
            font-size: clamp(2rem, 3.2vw, 3.2rem);
        }

        .grid-3 .spotlight-student-name,
        .grid-4 .spotlight-student-name {
            font-size: clamp(1.5rem, 2.2vw, 2.3rem);
        }

        /* Verified Icon */
        .verified-icon {
            display: inline-block;
            filter: drop-shadow(0 2px 8px rgba(24, 119, 242, 0.55));
        }

        .grid-1 .verified-icon {
            width: clamp(34px, 4vw, 48px);
            height: clamp(34px, 4vw, 48px);
        }

        .grid-2 .verified-icon {
            width: clamp(28px, 3vw, 38px);
            height: clamp(28px, 3vw, 38px);
        }

        .grid-3 .verified-icon,
        .grid-4 .verified-icon {
            width: clamp(22px, 2.2vw, 30px);
            height: clamp(22px, 2.2vw, 30px);
        }

        /* Clean Metadata Pill (Student ID & Major) */
        .spotlight-student-meta {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.85rem;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 9999px;
            padding: clamp(0.45rem, 0.8vw, 0.75rem) clamp(1.2rem, 1.8vw, 2.2rem);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
        }

        .grid-1 .spotlight-student-meta {
            font-size: clamp(1.1rem, 1.4vw, 1.4rem);
        }

        .grid-2 .spotlight-student-meta {
            font-size: clamp(0.95rem, 1.1vw, 1.2rem);
        }

        .grid-3 .spotlight-student-meta,
        .grid-4 .spotlight-student-meta {
            font-size: clamp(0.85rem, 0.95vw, 1.05rem);
        }

        .meta-item {
            color: #f1f5f9;
            font-weight: 600;
        }

        .meta-dot {
            color: rgba(255, 255, 255, 0.35);
        }

        /* Bottom Controls */
        .projector-footer {
            background: rgba(15, 23, 42, 0.92);
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding: 0.85rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
        }

        .page-badge {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 9999px;
            padding: 0.35rem 1rem;
            font-size: 0.85rem;
            font-weight: 700;
        }
    </style>
</head>
<body>

    <!-- Projector Header -->
    <header class="projector-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <span class="live-dot"></span>
            <div>
                <h4 class="fw-bolder mb-0 tracking-tight text-white d-flex align-items-center gap-2">
                    <span>LIVE CLASSROOM SPOTLIGHT</span>
                    <span class="badge bg-primary px-3 py-1 rounded-pill" style="font-size: 11px;">4-USER MULTI-SCREEN</span>
                </h4>
                <small class="text-white-50">អេក្រង់ចាក់បញ្ចាំងសិស្សធំទូលាយ • Interactive Classroom Projector Hub</small>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <div id="cycle-countdown" class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill fw-bold">
                <i class="bi bi-clock me-1"></i> Rotating in: <span id="timer-sec">7</span>s
            </div>
            <button class="btn btn-outline-light btn-sm rounded-pill px-3 fw-bold" onclick="toggleFullscreen()">
                <i data-lucide="maximize" style="width: 15px; height: 15px;" class="me-1"></i> Toggle Fullscreen
            </button>
            <a href="{{ route('admin.index', ['tab' => 'screen']) }}" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold">
                <i data-lucide="arrow-left" style="width: 15px; height: 15px;" class="me-1"></i> Back to Admin
            </a>
        </div>
    </header>

    <!-- Main Spotlight Container -->
    <div class="spotlight-container-wrapper">
        <main class="spotlight-grid" id="spotlight-container">
            <!-- Rendered dynamically via JavaScript from /admin/screen/spotlights/data -->
        </main>
    </div>

    <!-- Projector Footer -->
    <footer class="projector-footer">
        <div class="d-flex align-items-center gap-2">
            <span class="page-badge" id="pagination-badge">Showing Users</span>
            <small class="text-white-50">បង្ហាញរូបថត និងឈ្មោះសិស្សធំទូលាយសម្រាប់អេក្រង់ Projector ឬ Fullscreen TV</small>
        </div>

        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="prevBatch()">
                <i data-lucide="chevron-left" style="width: 15px; height: 15px;"></i>
            </button>
            <button class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="nextBatch()">
                <i data-lucide="chevron-right" style="width: 15px; height: 15px;"></i>
            </button>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let allSpotlights = @json($spotlights);
        let currentIndex = 0;
        const BATCH_SIZE = 4;
        let countdownSec = 7;
        let countdownTimer = null;

        function renderBatch() {
            const container = document.getElementById('spotlight-container');
            const pageBadge = document.getElementById('pagination-badge');
            const countdownEl = document.getElementById('cycle-countdown');

            if (!allSpotlights || allSpotlights.length === 0) {
                container.className = 'spotlight-grid grid-1';
                container.innerHTML = `
                    <div class="user-spotlight-hero text-center py-5">
                        <div class="spotlight-avatar-wrapper mb-4">
                            <div class="spotlight-avatar-halo"></div>
                            <div class="d-flex align-items-center justify-content-center rounded-circle bg-dark border border-primary border-opacity-50" style="width: 140px; height: 140px; box-shadow: 0 0 35px rgba(59, 130, 246, 0.4);">
                                <i data-lucide="monitor" class="text-primary" style="width: 60px; height: 60px;"></i>
                            </div>
                        </div>
                        <h2 class="spotlight-student-name mb-2">មិនទាន់មានសិស្សនៅលើ Spotlight ទេ</h2>
                        <p class="text-white-50 fs-5 mb-0">សូមចុចប៊ូតុង "Spotlight" លើឈ្មោះសិស្សក្នុង Admin ដើម្បីបង្ហាញរូបភាព និងឈ្មោះនៅលើអេក្រង់នេះ</p>
                    </div>
                `;
                pageBadge.textContent = '0 Students Spotlighted';
                if (countdownEl) countdownEl.style.display = 'none';
                if (window.lucide) window.lucide.createIcons();
                return;
            }

            const total = allSpotlights.length;
            if (currentIndex >= total) {
                currentIndex = 0;
            }

            const currentBatch = allSpotlights.slice(currentIndex, currentIndex + BATCH_SIZE);
            const endIdx = Math.min(currentIndex + BATCH_SIZE, total);
            pageBadge.textContent = `Showing Users ${currentIndex + 1}-${endIdx} of ${total}`;

            // Hide countdown if only 1 batch
            if (countdownEl) {
                countdownEl.style.display = total > BATCH_SIZE ? 'inline-block' : 'none';
            }

            // Set grid class based on batch size (1, 2, 3, or 4)
            const count = Math.min(currentBatch.length, 4);
            container.className = `spotlight-grid grid-${count}`;

            const verifiedBadgeSvg = `
                <span class="d-inline-flex align-items-center justify-content-center flex-shrink-0 align-middle" title="Verified Student" style="vertical-align: middle;">
                    <svg viewBox="0 0 16 16" class="verified-icon" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#1877F2" stroke="#ffffff" stroke-width="0.75" stroke-linejoin="round" d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01z"/>
                        <path fill="#ffffff" d="M10.354 6.854a.5.5 0 0 0-.708-.708L7 8.793 5.354 7.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0z"/>
                    </svg>
                </span>
            `;

            let html = '';
            currentBatch.forEach((st) => {
                const avatarUrl = st.avatar || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=400';
                html += `
                    <div class="user-spotlight-hero">
                        <div class="spotlight-avatar-wrapper">
                            <div class="spotlight-avatar-halo"></div>
                            <img src="${avatarUrl}" alt="${st.student_name}" class="spotlight-avatar-img">
                        </div>

                        <div class="spotlight-name-row">
                            <h2 class="spotlight-student-name">${st.student_name}</h2>
                            ${verifiedBadgeSvg}
                        </div>

                        <div class="spotlight-student-meta">
                            <span class="meta-item font-monospace"><i class="bi bi-person-badge me-1.5 text-primary"></i>${st.student_id || 'GZ-STUDENT'}</span>
                            <span class="meta-dot">•</span>
                            <span class="meta-item"><i class="bi bi-mortarboard me-1.5 text-primary"></i>${st.major || 'GenZ Digital Campus'}</span>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
            if (window.lucide) window.lucide.createIcons();
        }

        function nextBatch() {
            if (!allSpotlights || allSpotlights.length <= BATCH_SIZE) return;
            currentIndex += BATCH_SIZE;
            if (currentIndex >= allSpotlights.length) {
                currentIndex = 0;
            }
            countdownSec = 7;
            renderBatch();
        }

        function prevBatch() {
            if (!allSpotlights || allSpotlights.length <= BATCH_SIZE) return;
            currentIndex -= BATCH_SIZE;
            if (currentIndex < 0) {
                currentIndex = Math.max(0, Math.floor((allSpotlights.length - 1) / BATCH_SIZE) * BATCH_SIZE);
            }
            countdownSec = 7;
            renderBatch();
        }

        // Auto Cycle Countdown every second
        setInterval(() => {
            const countdownEl = document.getElementById('cycle-countdown');
            if (allSpotlights && allSpotlights.length > BATCH_SIZE) {
                if (countdownEl) countdownEl.style.display = 'inline-block';
                countdownSec--;
                const timerSecEl = document.getElementById('timer-sec');
                if (timerSecEl) timerSecEl.textContent = countdownSec;
                if (countdownSec <= 0) {
                    nextBatch();
                }
            } else {
                if (countdownEl) countdownEl.style.display = 'none';
            }
        }, 1000);

        // Real-time polling /admin/screen/spotlights/data every 2.5s
        async function fetchSpotlights() {
            try {
                const res = await fetch('{{ route("admin.screen.spotlights.data") }}');
                const data = await res.json();
                if (data && data.users) {
                    const prevCount = allSpotlights ? allSpotlights.length : 0;
                    allSpotlights = data.users;
                    if (prevCount !== allSpotlights.length) {
                        renderBatch();
                    }
                }
            } catch (err) {
                console.error("Poll error:", err);
            }
        }
        setInterval(fetchSpotlights, 2500);

        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => {
                    console.log("Fullscreen request error:", err);
                });
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            renderBatch();
        });
    </script>
</body>
</html>