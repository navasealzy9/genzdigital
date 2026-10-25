<!DOCTYPE html>
<html lang="km" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>window.BASE_URL = "{{ url('/') }}";</script>
    <title>Live Challenge Leaderboard - GenZ Digital Campus OS</title>

    <!-- Google Fonts: Google Sans & Khmer Sans (Kantumruy Pro, Noto Sans Khmer) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&family=Noto+Sans+Khmer:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/google-sans" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>

    <style>
        :root {
            --app-font: 'Google Sans', 'Kantumruy Pro', 'Noto Sans Khmer', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            --gold-glow: rgba(234, 179, 8, 0.4);
        }

        body {
            font-family: var(--app-font);
            background: radial-gradient(circle at 50% 10%, #1e1b4b 0%, #020617 100%);
            color: #f8fafc;
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .leaderboard-header {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 1.25rem 2.5rem;
        }

        /* Giant Timer */
        .timer-badge {
            background: rgba(239, 68, 68, 0.15);
            border: 2px solid #ef4444;
            color: #fca5a5;
            padding: 0.5rem 1.5rem;
            border-radius: 9999px;
            font-family: monospace;
            font-size: 1.5rem;
            font-weight: 900;
            letter-spacing: 0.05em;
            box-shadow: 0 0 25px rgba(239, 68, 68, 0.35);
        }

        /* Top 3 Podium */
        .podium-container {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            gap: 1.5rem;
            margin: 2rem 0;
            padding: 0 1rem;
        }

        .podium-card {
            background: rgba(30, 41, 59, 0.7);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 28px;
            padding: 1.75rem 1.25rem;
            text-align: center;
            width: 250px;
            backdrop-filter: blur(12px);
            position: relative;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            transition: all 0.3s ease;
        }

        .podium-card.rank-1 {
            border-color: #eab308;
            box-shadow: 0 0 40px var(--gold-glow);
            transform: translateY(-20px);
            background: linear-gradient(180deg, rgba(234, 179, 8, 0.15), rgba(30, 41, 59, 0.8));
        }

        .podium-card.rank-2 {
            border-color: #94a3b8;
            background: linear-gradient(180deg, rgba(148, 163, 184, 0.15), rgba(30, 41, 59, 0.8));
        }

        .podium-card.rank-3 {
            border-color: #d97706;
            background: linear-gradient(180deg, rgba(217, 119, 6, 0.15), rgba(30, 41, 59, 0.8));
        }

        .medal-badge {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .podium-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #eab308;
            margin-bottom: 0.75rem;
            box-shadow: 0 0 20px rgba(234, 179, 8, 0.4);
        }

        /* Leaderboard Table Card */
        .leaderboard-list-card {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
            max-width: 1000px;
            margin: 0 auto 2.5rem;
            width: 100%;
        }

        .rank-number {
            font-size: 1.25rem;
            font-weight: 900;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.08);
        }

        .rank-number.top-1 { background: #eab308; color: #000; }
        .rank-number.top-2 { background: #94a3b8; color: #000; }
        .rank-number.top-3 { background: #d97706; color: #fff; }
    </style>
</head>
<body>

    <!-- Leaderboard Header -->
    <header class="leaderboard-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold">
                <i data-lucide="trophy" style="width: 16px; height: 16px;" class="me-1"></i> REAL-TIME LEADERBOARD
            </span>
            <div>
                <h4 class="fw-bolder mb-0 text-white tracking-tight">{{ $challenge ? $challenge->title : 'Real-time UX Sprint Challenge' }}</h4>
                <small class="text-white-50">Points: <strong>+{{ $challenge ? $challenge->points : 500 }} PTS</strong> • Live Score Rankings</small>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <div class="timer-badge">
                <i class="bi bi-stopwatch me-1"></i> <span id="clock-display">14:59</span>
            </div>
            <button class="btn btn-outline-warning btn-sm rounded-pill px-3 fw-bold" onclick="confettiCelebration()">
                <i data-lucide="sparkles" style="width: 15px; height: 15px;" class="me-1"></i> Celebrate
            </button>
            <button class="btn btn-outline-light btn-sm rounded-pill px-3 fw-bold" onclick="toggleFullscreen()">
                <i data-lucide="maximize" style="width: 15px; height: 15px;" class="me-1"></i> Fullscreen
            </button>
            <a href="{{ route('admin.index', ['tab' => 'challenges']) }}" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold">
                <i data-lucide="arrow-left" style="width: 15px; height: 15px;" class="me-1"></i> Back
            </a>
        </div>
    </header>

    <!-- Main Live Leaderboard Content -->
    <main class="container-fluid px-3 px-md-5 my-4 flex-grow-1">

        <!-- Top 3 Podium -->
        <div class="podium-container" id="podium-section">
            <!-- Rendered dynamically -->
        </div>

        <!-- Full Ranked Participants Table -->
        <div class="leaderboard-list-card">
            <div class="p-3 border-bottom border-secondary border-opacity-25 d-flex justify-content-between align-items-center bg-black bg-opacity-25">
                <span class="fw-bold text-white fs-6">
                    <i data-lucide="bar-chart-2" style="width: 18px; height: 18px;" class="text-warning me-1"></i>
                    All Live Participants (<span id="participant-count">{{ $participants->count() }}</span>)
                </span>
                <span class="badge bg-success-subtle text-success fw-bold px-3 py-1 rounded-pill">
                    ● Real-time synced
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-white">
                    <thead class="table-dark text-secondary small">
                        <tr>
                            <th class="ps-4">Rank</th>
                            <th>Student</th>
                            <th>Student ID</th>
                            <th>Time</th>
                            <th class="text-end pe-4">Total Score</th>
                        </tr>
                    </thead>
                    <tbody id="leaderboard-rows">
                        <!-- Populated by JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="p-3 text-center text-white-50 border-top border-secondary border-opacity-25" style="background: rgba(15, 23, 42, 0.9);">
        <small>GenZ Digital Campus OS • Live Arena Projector Display • Highest Score Ranks #1</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const challengeId = {{ $challenge ? $challenge->id : 1 }};
        let participants = @json($participants);

        // Timer Countdown
        let remainingSeconds = {{ ($challenge && $challenge->duration_minutes ? $challenge->duration_minutes : 15) * 60 }};
        const clockEl = document.getElementById('clock-display');

        setInterval(() => {
            if (remainingSeconds > 0) {
                remainingSeconds--;
                const mins = String(Math.floor(remainingSeconds / 60)).padStart(2, '0');
                const secs = String(remainingSeconds % 60).padStart(2, '0');
                clockEl.textContent = `${mins}:${secs}`;
            } else {
                clockEl.textContent = '00:00 - TIME UP';
                clockEl.style.color = '#ef4444';
            }
        }, 1000);

        function renderLeaderboard() {
            const podiumEl = document.getElementById('podium-section');
            const rowsEl = document.getElementById('leaderboard-rows');
            const countEl = document.getElementById('participant-count');

            countEl.textContent = participants.length;

            // Sort participants by score DESC, then time ASC
            participants.sort((a, b) => b.score - a.score);

            // Render Podium (Top 3)
            let podiumHtml = '';
            if (participants.length >= 2) {
                // Rank 2 (Left)
                const p2 = participants[1];
                podiumHtml += `
                    <div class="podium-card rank-2">
                        <span class="medal-badge">🥈</span>
                        <img src="${p2.avatar || 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&q=80&w=250'}" class="podium-avatar" style="border-color: #94a3b8;">
                        <h5 class="fw-bolder text-white mb-0">${p2.student_name}</h5>
                        <small class="text-white-50">${p2.student_id}</small>
                        <div class="mt-2">
                            <span class="badge bg-secondary text-white fw-bold px-3 py-1.5 fs-6">${p2.score} PTS</span>
                        </div>
                        <small class="text-white-50 d-block mt-1 font-monospace">⏱️ ${p2.completion_time}</small>
                    </div>
                `;
            }

            if (participants.length >= 1) {
                // Rank 1 (Center, Elevated)
                const p1 = participants[0];
                podiumHtml += `
                    <div class="podium-card rank-1">
                        <span class="medal-badge">🥇</span>
                        <img src="${p1.avatar || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=250'}" class="podium-avatar">
                        <h4 class="fw-bolder text-warning mb-0">${p1.student_name}</h4>
                        <small class="text-white-50">${p1.student_id}</small>
                        <div class="mt-2">
                            <span class="badge bg-warning text-dark fw-bold px-3 py-1.5 fs-5 shadow">${p1.score} PTS</span>
                        </div>
                        <small class="text-warning fw-semibold d-block mt-1 font-monospace">⚡ FASTEST: ${p1.completion_time}</small>
                    </div>
                `;
            }

            if (participants.length >= 3) {
                // Rank 3 (Right)
                const p3 = participants[2];
                podiumHtml += `
                    <div class="podium-card rank-3">
                        <span class="medal-badge">🥉</span>
                        <img src="${p3.avatar || 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&q=80&w=250'}" class="podium-avatar" style="border-color: #d97706;">
                        <h5 class="fw-bolder text-white mb-0">${p3.student_name}</h5>
                        <small class="text-white-50">${p3.student_id}</small>
                        <div class="mt-2">
                            <span class="badge bg-danger-subtle text-danger fw-bold px-3 py-1.5 fs-6">${p3.score} PTS</span>
                        </div>
                        <small class="text-white-50 d-block mt-1 font-monospace">⏱️ ${p3.completion_time}</small>
                    </div>
                `;
            }

            podiumEl.innerHTML = podiumHtml;

            // Render Table Rows
            let rowsHtml = '';
            participants.forEach((p, idx) => {
                const rank = idx + 1;
                const topClass = rank === 1 ? 'top-1' : (rank === 2 ? 'top-2' : (rank === 3 ? 'top-3' : ''));
                rowsHtml += `
                    <tr>
                        <td class="ps-4">
                            <div class="rank-number ${topClass}">${rank}</div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="${p.avatar || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=250'}" class="rounded-circle object-fit-cover" style="width: 36px; height: 36px;">
                                <span class="fw-bold">${p.student_name}</span>
                            </div>
                        </td>
                        <td><span class="badge bg-body-secondary text-secondary font-monospace">${p.student_id}</span></td>
                        <td class="font-monospace text-white-50">${p.completion_time}</td>
                        <td class="text-end pe-4">
                            <span class="badge ${rank === 1 ? 'bg-warning text-dark' : 'bg-primary-subtle text-primary'} fw-bold px-3 py-1.5 fs-6">
                                ${p.score} PTS
                            </span>
                        </td>
                    </tr>
                `;
            });

            rowsEl.innerHTML = rowsHtml;
            if (window.lucide) window.lucide.createIcons();
        }

        // Real-Time Polling every 2.5s
        async function fetchLeaderboard() {
            try {
                const res = await fetch(`${window.BASE_URL}/api/challenges/${challengeId}/leaderboard`);
                const data = await res.json();
                if (data && data.participants) {
                    participants = data.participants;
                    renderLeaderboard();
                }
            } catch (err) {
                console.error("Leaderboard poll error:", err);
            }
        }
        setInterval(fetchLeaderboard, 2500);

        function confettiCelebration() {
            if (window.confetti) {
                window.confetti({ particleCount: 120, spread: 80, origin: { y: 0.6 } });
            }
        }

        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                if (document.exitFullscreen) document.exitFullscreen();
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            renderLeaderboard();
        });
    </script>
</body>
</html>
