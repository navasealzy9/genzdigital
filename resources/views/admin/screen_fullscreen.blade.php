<!DOCTYPE html>
<html lang="km" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Classroom Projector Spotlight - GenZ Digital Campus OS</title>

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
            --spotlight-glow: rgba(59, 130, 246, 0.4);
        }

        body {
            font-family: var(--app-font);
            background: radial-gradient(circle at 50% 20%, #0f172a 0%, #020617 100%);
            color: #f8fafc;
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Top Bar */
        .projector-header {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 1rem 2rem;
        }

        /* 2x2 Grid Layout */
        .spotlight-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            padding: 1.5rem 2rem;
            flex-grow: 1;
        }

        @media (max-width: 768px) {
            .spotlight-grid {
                grid-template-columns: 1fr;
            }
        }

        .user-card {
            background: rgba(30, 41, 59, 0.6);
            border: 2px solid rgba(255, 255, 255, 0.08);
            border-radius: 28px;
            padding: 1.75rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(12px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            animation: fadeInCard 0.5s ease-out;
        }

        .user-card.active-spotlight {
            border-color: #3b82f6;
            box-shadow: 0 0 35px var(--spotlight-glow);
        }

        .user-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899);
        }

        .avatar-frame {
            position: relative;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid #3b82f6;
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
            overflow: hidden;
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
            50% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }

        @keyframes fadeInCard {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Sound Waves Indicator */
        .sound-wave {
            display: flex;
            align-items: center;
            gap: 3px;
            height: 18px;
        }

        .sound-bar {
            width: 3px;
            background: #10b981;
            border-radius: 3px;
            animation: soundAnim 1s ease-in-out infinite alternate;
        }

        .sound-bar:nth-child(1) { height: 6px; animation-delay: 0.1s; }
        .sound-bar:nth-child(2) { height: 16px; animation-delay: 0.3s; }
        .sound-bar:nth-child(3) { height: 10px; animation-delay: 0.2s; }
        .sound-bar:nth-child(4) { height: 18px; animation-delay: 0.4s; }
        .sound-bar:nth-child(5) { height: 8px; animation-delay: 0.15s; }

        @keyframes soundAnim {
            0% { transform: scaleY(0.4); }
            100% { transform: scaleY(1.3); }
        }

        /* Bottom Controls */
        .projector-footer {
            background: rgba(15, 23, 42, 0.9);
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding: 0.85rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-badge {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 9999px;
            padding: 0.35rem 1rem;
            font-size: 0.8rem;
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
                <small class="text-white-50">Auto-cycling 4 students at a time • Interactive Projector Hub</small>
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

    <!-- Main 4-User 2x2 Grid -->
    <main class="spotlight-grid" id="spotlight-container">
        <!-- Rendered dynamically via JavaScript from /admin/screen/spotlights/data -->
    </main>

    <!-- Projector Footer -->
    <footer class="projector-footer">
        <div class="d-flex align-items-center gap-2">
            <span class="page-badge" id="pagination-badge">Showing Users 1-4 of 4</span>
            <small class="text-white-50">When more students join or are clicked, system rotates 4 at a time automatically.</small>
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

            if (!allSpotlights || allSpotlights.length === 0) {
                container.innerHTML = `
                    <div class="col-12 text-center py-5" style="grid-column: 1 / -1;">
                        <i data-lucide="monitor" class="text-primary mb-3" style="width: 64px; height: 64px;"></i>
                        <h3 class="fw-bold">No Students Currently on Spotlight</h3>
                        <p class="text-white-50">Click any student in Admin "Manage Users" or "Show on Screen" to add them here.</p>
                    </div>
                `;
                pageBadge.textContent = '0 Students Spotlighted';
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

            let html = '';
            currentBatch.forEach((st, idx) => {
                html += `
                    <div class="user-card active-spotlight">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-frame">
                                    <img src="${st.avatar || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=250'}" alt="${st.student_name}" class="avatar-img">
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <h3 class="fw-bolder mb-0 text-white">${st.student_name}</h3>
                                        <span class="badge bg-primary-subtle text-primary fw-bold" style="font-size: 10px;">SLOT #${currentIndex + idx + 1}</span>
                                    </div>
                                    <span class="text-white-50 small font-monospace">${st.student_id}</span>
                                    <span class="badge bg-secondary-subtle text-secondary small ms-1">${st.major || 'Digital Media'}</span>
                                </div>
                            </div>

                            <div class="d-flex flex-column align-items-end gap-1">
                                <span class="badge bg-success-subtle text-success fw-bold px-2.5 py-1 rounded-pill d-flex align-items-center gap-1">
                                    <span class="live-dot" style="width: 8px; height: 8px;"></span> Live
                                </span>
                                <div class="sound-wave mt-1">
                                    <div class="sound-bar"></div>
                                    <div class="sound-bar"></div>
                                    <div class="sound-bar"></div>
                                    <div class="sound-bar"></div>
                                    <div class="sound-bar"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Prototype / Screen Showcase Preview -->
                        <div class="p-3 rounded-4 mb-3" style="background: rgba(0, 0, 0, 0.35); border: 1px solid rgba(255, 255, 255, 0.05);">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-primary fw-bold text-uppercase" style="font-size: 10px; letter-spacing: 0.08em;">Active Showcase Presentation</small>
                                <small class="text-white-50" style="font-size: 11px;"><i class="bi bi-geo-alt"></i> ${st.room || 'Lab 402 • Media Wing'}</small>
                            </div>
                            <h5 class="fw-bold text-white mb-2" style="font-size: 1.05rem;">${st.preview_title || 'UI/UX Interactive System Prototype'}</h5>
                            <div class="d-flex gap-2">
                                <span class="badge bg-white bg-opacity-10 text-white-50" style="font-size: 11px;">1080p 60fps Stream</span>
                                <span class="badge bg-white bg-opacity-10 text-white-50" style="font-size: 11px;">Audio Mic Connected</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-2 border-top border-white border-opacity-10">
                            <small class="text-white-50" style="font-size: 11px;">GenZ Digital Classroom OS • Projector Node #04</small>
                            <span class="badge bg-primary text-white fw-bold px-3 py-1 rounded-pill" style="font-size: 11px;">Verified Student</span>
                        </div>
                    </div>
                `;
            });

            // If fewer than 4 students in this batch and total < 4, fill empty slots with placeholder
            if (currentBatch.length < 4 && total < 4) {
                for (let i = currentBatch.length; i < 4; i++) {
                    html += `
                        <div class="user-card" style="opacity: 0.45; border-style: dashed;">
                            <div class="d-flex flex-column align-items-center justify-content-center text-center h-100 py-4">
                                <i data-lucide="user-plus" class="text-secondary mb-2" style="width: 36px; height: 36px;"></i>
                                <span class="fw-bold text-white-50">Empty Spotlight Slot #${i + 1}</span>
                                <small class="text-secondary">Click student on Admin Screen to project here</small>
                            </div>
                        </div>
                    `;
                }
            }

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
            if (allSpotlights && allSpotlights.length > BATCH_SIZE) {
                countdownSec--;
                document.getElementById('timer-sec').textContent = countdownSec;
                if (countdownSec <= 0) {
                    nextBatch();
                }
            } else {
                document.getElementById('cycle-countdown').style.display = 'none';
            }
        }, 1000);

        // Real-time polling /admin/screen/spotlights/data every 2.5s
        async function fetchSpotlights() {
            try {
                const res = await fetch('{{ route("admin.screen.spotlights.data") }}');
                const data = await res.json();
                if (data && data.users) {
                    const prevCount = allSpotlights.length;
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
                document.documentElement.requestFullscreen();
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
