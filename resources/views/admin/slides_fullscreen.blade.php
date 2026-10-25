<!DOCTYPE html>
<html lang="km" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Slide Presentation with Camera Gesture - GenZ Digital Campus OS</title>

    <!-- Google Fonts: Google Sans & Khmer Sans (Kantumruy Pro, Noto Sans Khmer) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&family=Noto+Sans+Khmer:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/google-sans" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --app-font: 'Google Sans', 'Kantumruy Pro', 'Noto Sans Khmer', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            font-family: var(--app-font);
            background: #020617;
            color: #f8fafc;
            min-height: 100vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .slide-header {
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 0.85rem 2rem;
        }

        .presentation-stage {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
        }

        .slide-screen {
            width: 100%;
            max-width: 1200px;
            min-height: 580px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border: 2px solid rgba(59, 130, 246, 0.3);
            border-radius: 32px;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.7);
            padding: 3.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .slide-screen::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4);
        }

        /* Camera PIP Box */
        .camera-pip {
            position: fixed;
            bottom: 5.5rem;
            right: 2rem;
            width: 260px;
            background: rgba(15, 23, 42, 0.95);
            border: 2px solid #3b82f6;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            z-index: 1050;
            transition: all 0.3s ease;
        }

        .camera-video {
            width: 100%;
            height: 180px;
            object-fit: cover;
            transform: scaleX(-1); /* mirror */
            background: #000;
        }

        .gesture-indicator-badge {
            position: absolute;
            top: 1.5rem;
            right: 2rem;
            background: rgba(16, 185, 129, 0.2);
            border: 2px solid #10b981;
            color: #34d399;
            padding: 0.6rem 1.4rem;
            border-radius: 9999px;
            font-weight: 800;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 0 25px rgba(16, 185, 129, 0.3);
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .gesture-indicator-badge.show {
            opacity: 1;
            transform: translateY(0);
        }

        .slide-footer {
            background: rgba(15, 23, 42, 0.9);
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding: 1rem 2rem;
        }
    </style>
</head>
<body>

    <!-- Slide Header -->
    <header class="slide-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-primary px-3 py-1.5 rounded-pill fw-bold">
                <i class="bi bi-camera-video me-1"></i> AI GESTURE TRACKER
            </span>
            <div>
                <h5 class="fw-bolder mb-0 text-white">{{ $teachingSlides ? $teachingSlides->title : 'Design Tokens & Component Hierarchy' }}</h5>
                <small class="text-white-50">{{ $teachingSlides ? $teachingSlides->course : 'DES302 • UI/UX Design Systems' }}</small>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Camera Toggle Button -->
            <button class="btn btn-outline-info btn-sm rounded-pill px-3 fw-bold d-flex align-items-center gap-1.5" id="btn-toggle-cam" onclick="toggleWebCam()">
                <i data-lucide="video" style="width: 16px; height: 16px;"></i>
                <span id="cam-status-text">Allow Camera / បើកកាមេរ៉ា Gesture</span>
            </button>

            <button class="btn btn-outline-light btn-sm rounded-pill px-3 fw-bold" onclick="toggleFullscreen()">
                <i data-lucide="maximize" style="width: 15px; height: 15px;" class="me-1"></i> Fullscreen
            </button>

            <a href="{{ route('admin.index', ['tab' => 'slides']) }}" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold">
                <i data-lucide="arrow-left" style="width: 15px; height: 15px;" class="me-1"></i> Exit
            </a>
        </div>
    </header>

    <!-- Presentation Stage -->
    <main class="presentation-stage">
        <!-- Floating Gesture Badge -->
        <div id="gesture-badge" class="gesture-indicator-badge">
            <span id="gesture-icon">✌️</span>
            <span id="gesture-text">Gesture Detected!</span>
        </div>

        <!-- Slide Content Screen -->
        <div class="slide-screen" id="slide-screen-container">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="badge bg-primary px-3 py-1.5 text-uppercase fw-bold" id="slide-category-badge">MODULE 01 • TOKENS</span>
                    <span class="badge bg-body-secondary text-secondary font-monospace" id="slide-counter-badge">SLIDE 1 OF 6</span>
                </div>

                <h1 class="display-5 fw-bolder text-white mb-3" id="slide-title">Design Tokens & Component Hierarchy</h1>
                <p class="lead text-light opacity-80 mb-4" id="slide-desc" style="max-width: 850px;">
                    How atomic design tokens (colors, sizing, typography, elevation) seamlessly synchronize between Figma and React/Vue/Blade frontend codebases.
                </p>

                <!-- Dynamic Slide Visual Elements -->
                <div id="slide-body-content" class="row g-3 my-3">
                    <div class="col-md-3">
                        <div class="p-4 rounded-4 text-center h-100" style="background: rgba(59, 130, 246, 0.12); border: 1px solid rgba(59, 130, 246, 0.3);">
                            <i data-lucide="palette" class="text-primary mb-2" style="width: 32px; height: 32px;"></i>
                            <h6 class="fw-bold text-white mb-1">1. Tokens</h6>
                            <small class="text-white-50">Base values: Color, font-size, spacing units</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-4 rounded-4 text-center h-100" style="background: rgba(139, 92, 246, 0.12); border: 1px solid rgba(139, 92, 246, 0.3);">
                            <i data-lucide="layers" class="text-info mb-2" style="width: 32px; height: 32px;"></i>
                            <h6 class="fw-bold text-white mb-1">2. Atoms</h6>
                            <small class="text-white-50">Buttons, inputs, icons, labels</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-4 rounded-4 text-center h-100" style="background: rgba(236, 72, 153, 0.12); border: 1px solid rgba(236, 72, 153, 0.3);">
                            <i data-lucide="box" class="text-warning mb-2" style="width: 32px; height: 32px;"></i>
                            <h6 class="fw-bold text-white mb-1">3. Molecules</h6>
                            <small class="text-white-50">Search bar, card headers, form fields</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-4 rounded-4 text-center h-100" style="background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.3);">
                            <i data-lucide="layout" class="text-success mb-2" style="width: 32px; height: 32px;"></i>
                            <h6 class="fw-bold text-white mb-1">4. Organisms</h6>
                            <small class="text-white-50">Full navigation bar, hero sections</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide Notes / Tips -->
            <div class="p-3 rounded-3 mt-4 d-flex justify-content-between align-items-center" style="background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.05);">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-warning text-dark fw-bold">PRO TIP</span>
                    <span class="small text-white-50" id="slide-notes">Always map tokens directly to CSS custom properties for instant dark mode switching.</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary-subtle text-primary fw-bold" style="font-size: 11px;">☝️ ម្រាម 1: ថយក្រោយ</span>
                    <span class="badge bg-info-subtle text-info fw-bold" style="font-size: 11px;">✌️ ម្រាម 2: ទៅមុខ</span>
                </div>
            </div>
        </div>
    </main>

    <!-- Picture-in-Picture WebCam for Hand Gesture Detection -->
    <div class="camera-pip" id="camera-box" style="display: none;">
        <div class="p-2 border-bottom d-flex justify-content-between align-items-center" style="background: rgba(0,0,0,0.4);">
            <div class="d-flex align-items-center gap-1.5">
                <span class="live-dot" style="width: 8px; height: 8px; background: #10b981; border-radius: 50%;"></span>
                <small class="fw-bold text-white" style="font-size: 11px;">AI Gesture Camera</small>
            </div>
            <button class="btn btn-sm text-white-50 p-0" onclick="toggleWebCam()">&times;</button>
        </div>
        <video id="webcam-feed" class="camera-video" autoplay playsinline muted></video>
        <canvas id="gesture-canvas" width="160" height="120" style="display: none;"></canvas>
        <div class="p-2 text-center" style="font-size: 10px; background: rgba(0,0,0,0.5);">
            <span class="text-info fw-bold" id="gesture-live-status">Tracking hands...</span>
        </div>
    </div>

    <!-- Presentation Controls Footer -->
    <footer class="slide-footer d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-body-secondary text-secondary" id="footer-slide-num">Slide 1 / 6</span>
            <small class="text-white-50">Press Keyboard Left / Right or show 1 / 2 fingers to Camera</small>
        </div>

        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-secondary rounded-pill px-4 fw-bold" onclick="changeSlide(-1)">
                <i data-lucide="arrow-left" class="me-1" style="width: 16px; height: 16px;"></i> ថយក្រោយ (Previous)
            </button>
            <button class="btn btn-primary rounded-pill px-4 fw-bold shadow" onclick="changeSlide(1)">
                ទៅមុខ (Next) <i data-lucide="arrow-right" class="ms-1" style="width: 16px; height: 16px;"></i>
            </button>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const slides = [
            {
                category: "MODULE 01 • TOKENS",
                title: "Design Tokens & Component Hierarchy",
                desc: "How atomic design tokens (colors, sizing, typography, elevation) seamlessly synchronize between Figma and React/Vue/Blade frontend codebases.",
                notes: "Always map tokens directly to CSS custom properties for instant dark mode switching.",
                cards: [
                    { icon: "palette", title: "1. Tokens", desc: "Base values: Color, font-size, spacing units", bg: "rgba(59, 130, 246, 0.12)", color: "text-primary" },
                    { icon: "layers", title: "2. Atoms", desc: "Buttons, inputs, icons, labels", bg: "rgba(139, 92, 246, 0.12)", color: "text-info" },
                    { icon: "box", title: "3. Molecules", desc: "Search bar, card headers, form fields", bg: "rgba(236, 72, 153, 0.12)", color: "text-warning" },
                    { icon: "layout", title: "4. Organisms", desc: "Full navigation bar, hero sections", bg: "rgba(16, 185, 129, 0.12)", color: "text-success" }
                ]
            },
            {
                category: "MODULE 02 • AUTO-LAYOUT",
                title: "Responsive Grids & Fluid Auto-Layout",
                desc: "Applying flexbox rules within Figma frames: Hug contents, Fill container, and Fixed dimensions for robust responsive interfaces.",
                notes: "Use 8pt grid unit for consistent spacing rhythm across mobile and desktop breakpoints.",
                cards: [
                    { icon: "columns", title: "12-Col Grid", desc: "Flexible desktop layouts with gutter margins", bg: "rgba(59, 130, 246, 0.12)", color: "text-primary" },
                    { icon: "maximize-2", title: "Fill Container", desc: "Allows cards to expand responsively", bg: "rgba(139, 92, 246, 0.12)", color: "text-info" },
                    { icon: "minimize-2", title: "Hug Contents", desc: "Adapts container tightly to nested text", bg: "rgba(236, 72, 153, 0.12)", color: "text-warning" },
                    { icon: "smartphone", title: "Mobile Stack", desc: "Auto wraps rows into single column", bg: "rgba(16, 185, 129, 0.12)", color: "text-success" }
                ]
            },
            {
                category: "MODULE 03 • MICRO-INTERACTIONS",
                title: "State Machines & Interactive Micro-Interactions",
                desc: "Creating physics-based spring animations for button clicks, dropdown expansions, and hover states that delight users without lag.",
                notes: "Keep durations between 150ms and 300ms. Slower animations feel sluggish to power users.",
                cards: [
                    { icon: "mouse-pointer", title: "Hover States", desc: "Subtle scale up (1.02) and elevation shadow", bg: "rgba(59, 130, 246, 0.12)", color: "text-primary" },
                    { icon: "toggle-right", title: "Active Toggle", desc: "Smooth color transition with spring physics", bg: "rgba(139, 92, 246, 0.12)", color: "text-info" },
                    { icon: "check-circle", title: "Feedback Ring", desc: "Visual pulse on action completion", bg: "rgba(236, 72, 153, 0.12)", color: "text-warning" },
                    { icon: "sparkles", title: "Haptics & SFX", desc: "Auditory cues for critical confirmations", bg: "rgba(16, 185, 129, 0.12)", color: "text-success" }
                ]
            },
            {
                category: "MODULE 04 • ACCESSIBILITY",
                title: "WCAG 2.2 Standards & Contrast Requirements",
                desc: "Ensuring digital products are inclusive for all users through 4.5:1 text contrast, accessible focus rings, and screen-reader semantics.",
                notes: "Never rely on color alone to communicate system state; always pair with icons or text.",
                cards: [
                    { icon: "eye", title: "Contrast Ratio", desc: "4.5:1 for normal text, 3.0:1 for large headers", bg: "rgba(59, 130, 246, 0.12)", color: "text-primary" },
                    { icon: "volume-2", title: "Aria Labels", desc: "Descriptive labels for icon-only action buttons", bg: "rgba(139, 92, 246, 0.12)", color: "text-info" },
                    { icon: "keyboard", title: "Focus Outline", desc: "Visible 2px outline for keyboard tab navigation", bg: "rgba(236, 72, 153, 0.12)", color: "text-warning" },
                    { icon: "shield-check", title: "Form Validation", desc: "Clear error messages linked to form inputs", bg: "rgba(16, 185, 129, 0.12)", color: "text-success" }
                ]
            },
            {
                category: "MODULE 05 • DESIGN HANDOFF",
                title: "Engineering Handoff & Variable Export",
                desc: "Exporting design tokens directly to JSON/CSS variables and configuring component properties for seamless frontend development.",
                notes: "Automate token synchronization with GitHub Actions so code stays in sync with Figma.",
                cards: [
                    { icon: "code", title: "Token JSON", desc: "W3C standard Design Tokens Community Group format", bg: "rgba(59, 130, 246, 0.12)", color: "text-primary" },
                    { icon: "git-branch", title: "Git Sync", desc: "Push tokens automatically via Webhooks", bg: "rgba(139, 92, 246, 0.12)", color: "text-info" },
                    { icon: "box", title: "Storybook", desc: "Live component playground for developers", bg: "rgba(236, 72, 153, 0.12)", color: "text-warning" },
                    { icon: "check-double", title: "Visual QA", desc: "Pixel comparison testing in CI/CD pipeline", bg: "rgba(16, 185, 129, 0.12)", color: "text-success" }
                ]
            },
            {
                category: "MODULE 06 • SUMMARY",
                title: "Key Takeaways & Production Checklist",
                desc: "Reviewing the complete end-to-end design system pipeline from token definition through prototype and engineering handoff.",
                notes: "Teams using design systems ship user interfaces 47% faster with fewer regression bugs.",
                cards: [
                    { icon: "check", title: "Consistent", desc: "Single source of truth for all brand colors", bg: "rgba(59, 130, 246, 0.12)", color: "text-primary" },
                    { icon: "zap", title: "Scalable", desc: "Theme variables support dark mode instantly", bg: "rgba(139, 92, 246, 0.12)", color: "text-info" },
                    { icon: "users", title: "Collaborative", desc: "Designers and engineers speak identical token names", bg: "rgba(236, 72, 153, 0.12)", color: "text-warning" },
                    { icon: "award", title: "Delightful", desc: "Smooth micro-interactions keep students engaged", bg: "rgba(16, 185, 129, 0.12)", color: "text-success" }
                ]
            }
        ];

        let currentSlideIdx = 0;

        function renderSlide(idx) {
            if (idx < 0) idx = 0;
            if (idx >= slides.length) idx = slides.length - 1;
            currentSlideIdx = idx;

            const s = slides[idx];
            document.getElementById('slide-category-badge').textContent = s.category;
            document.getElementById('slide-counter-badge').textContent = `SLIDE ${idx + 1} OF ${slides.length}`;
            document.getElementById('slide-title').textContent = s.title;
            document.getElementById('slide-desc').textContent = s.desc;
            document.getElementById('slide-notes').textContent = s.notes;
            document.getElementById('footer-slide-num').textContent = `Slide ${idx + 1} / ${slides.length}`;

            let cardsHtml = '';
            s.cards.forEach(c => {
                cardsHtml += `
                    <div class="col-md-3">
                        <div class="p-4 rounded-4 text-center h-100" style="background: ${c.bg}; border: 1px solid rgba(255, 255, 255, 0.08);">
                            <i data-lucide="${c.icon}" class="${c.color} mb-2" style="width: 32px; height: 32px;"></i>
                            <h6 class="fw-bold text-white mb-1">${c.title}</h6>
                            <small class="text-white-50">${c.desc}</small>
                        </div>
                    </div>
                `;
            });
            document.getElementById('slide-body-content').innerHTML = cardsHtml;
            if (window.lucide) window.lucide.createIcons();
        }

        function changeSlide(dir) {
            renderSlide(currentSlideIdx + dir);
        }

        // Keyboard Controls (Left Arrow = Prev, Right Arrow = Next)
        window.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight' || e.key === 'Space') {
                changeSlide(1);
            } else if (e.key === 'ArrowLeft') {
                changeSlide(-1);
            }
        });

        // =====================================================================
        // CAMERA GESTURE TRACKING (1 Finger = Prev, 2 Fingers = Next)
        // =====================================================================
        let isCamActive = false;
        let camStream = null;
        let gestureInterval = null;
        let lastGestureTime = 0;

        async function toggleWebCam() {
            const camBox = document.getElementById('camera-box');
            const video = document.getElementById('webcam-feed');
            const btnText = document.getElementById('cam-status-text');

            if (!isCamActive) {
                try {
                    camStream = await navigator.mediaDevices.getUserMedia({
                        video: { width: 320, height: 240, facingMode: 'user' }
                    });
                    video.srcObject = camStream;
                    camBox.style.display = 'block';
                    isCamActive = true;
                    btnText.textContent = 'Disable Camera Gesture / បិទកាមេរ៉ា';
                    document.getElementById('gesture-live-status').textContent = 'Tracking gestures (☝️ / ✌️)...';
                    startGestureAnalysis();
                } catch (err) {
                    alert('កាមេរ៉ាមិនអាចបើកបានទេ (Camera permission denied or camera not found): ' + err.message);
                }
            } else {
                if (camStream) {
                    camStream.getTracks().forEach(t => t.stop());
                }
                clearInterval(gestureInterval);
                camBox.style.display = 'none';
                isCamActive = false;
                btnText.textContent = 'Allow Camera / បើកកាមេរ៉ា Gesture';
            }
        }

        function showGestureBadge(icon, text) {
            const badge = document.getElementById('gesture-badge');
            document.getElementById('gesture-icon').textContent = icon;
            document.getElementById('gesture-text').textContent = text;
            badge.classList.add('show');
            setTimeout(() => {
                badge.classList.remove('show');
            }, 1800);
        }

        function triggerGesture(fingerCount) {
            const now = Date.now();
            if (now - lastGestureTime < 1600) return; // Debounce 1.6s
            lastGestureTime = now;

            if (fingerCount === 1) {
                // 1 finger up = Slide Previous (ថយក្រោយ)
                showGestureBadge('☝️', 'ម្រាមដៃ 1 ៖ ថយក្រោយ (Previous Slide)');
                changeSlide(-1);
            } else if (fingerCount === 2) {
                // 2 fingers up = Slide Next (ទៅមុខ)
                showGestureBadge('✌️', 'ម្រាមដៃ 2 ៖ ទៅមុខ (Next Slide)');
                changeSlide(1);
            }
        }

        function startGestureAnalysis() {
            const video = document.getElementById('webcam-feed');
            const canvas = document.getElementById('gesture-canvas');
            const ctx = canvas.getContext('2d');

            gestureInterval = setInterval(() => {
                if (!isCamActive || video.readyState !== 4) return;
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                const frame = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const data = frame.data;

                // Simple skin color & brightness thresholding to count hand silhouette peaks in upper half
                let columnHits = new Array(canvas.width).fill(0);
                for (let y = 10; y < canvas.height * 0.6; y++) {
                    for (let x = 10; x < canvas.width - 10; x++) {
                        const idx = (y * canvas.width + x) * 4;
                        const r = data[idx], g = data[idx + 1], b = data[idx + 2];
                        // Skin tone heuristic: r > 95, g > 40, b > 20, r > g, r - b > 15
                        if (r > 95 && g > 40 && b > 20 && r > g && (r - b) > 15) {
                            columnHits[x]++;
                        }
                    }
                }

                // Count peaks across horizontal columns
                let peaks = 0;
                let inPeak = false;
                for (let x = 15; x < canvas.width - 15; x++) {
                    if (columnHits[x] > 18) {
                        if (!inPeak) {
                            peaks++;
                            inPeak = true;
                        }
                    } else if (columnHits[x] < 8) {
                        inPeak = false;
                    }
                }

                if (peaks === 1) {
                    document.getElementById('gesture-live-status').textContent = '☝️ Detected 1 Finger (Previous)';
                    triggerGesture(1);
                } else if (peaks === 2) {
                    document.getElementById('gesture-live-status').textContent = '✌️ Detected 2 Fingers (Next)';
                    triggerGesture(2);
                } else {
                    document.getElementById('gesture-live-status').textContent = 'Ready for Gestures (☝️ Prev | ✌️ Next)';
                }
            }, 300);
        }

        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                if (document.exitFullscreen) document.exitFullscreen();
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            renderSlide(0);
        });
    </script>
</body>
</html>
