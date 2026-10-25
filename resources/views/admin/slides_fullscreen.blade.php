<!DOCTYPE html>
<html lang="km" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ $teachingSlides ? $teachingSlides->title : 'Slide Presentation' }} - AI Gesture Tracker</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=26.1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=26.1">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/genz-logo.png') }}?v=26.1">

    <!-- Google Fonts: Google Sans & Khmer Sans (Kantumruy Pro, Noto Sans Khmer) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&family=Noto+Sans+Khmer:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/google-sans" rel="stylesheet">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- PDF.js for rendering uploaded PDF presentations directly on Canvas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    </script>
    <!-- Google MediaPipe Hands AI for Browser Hand & Finger Tracking (100% Accurate) -->
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils/drawing_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js" crossorigin="anonymous"></script>

    <style>
        :root {
            --app-font: 'Google Sans', 'Kantumruy Pro', 'Noto Sans Khmer', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            font-family: var(--app-font);
            background: #020617;
            color: #f8fafc;
            min-height: 100vh;
            min-height: 100dvh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin: 0;
            padding: 0;
        }

        .slide-header {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 0.75rem 1.75rem;
            z-index: 100;
        }

        .presentation-stage {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.25rem 2rem;
            position: relative;
            overflow: hidden;
            background: radial-gradient(circle at center, rgba(30, 41, 59, 0.5) 0%, #020617 80%);
        }

        /* Slide Stage Container */
        .slide-stage-card {
            width: 100%;
            max-width: 1280px;
            height: calc(100vh - 150px);
            background: linear-gradient(145deg, #0f172a 0%, #1e293b 100%);
            border: 2px solid rgba(59, 130, 246, 0.3);
            border-radius: 28px;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.8), 0 0 1px 1px rgba(255, 255, 255, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            padding: 1.5rem 2rem;
            transition: all 0.3s ease;
        }

        .slide-stage-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4, #10b981);
        }

        /* PDF Viewer Styling */
        .pdf-viewer-viewport {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: auto;
            position: relative;
            width: 100%;
            height: 100%;
            padding: 0.5rem;
        }

        .pdf-render-canvas {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6);
            background: #ffffff;
            transition: transform 0.2s ease;
        }

        /* Floating Gesture Notification Badge */
        .gesture-indicator-badge {
            position: absolute;
            top: 2rem;
            left: 50%;
            transform: translateX(-50%) translateY(-20px);
            background: rgba(16, 185, 129, 0.25);
            border: 2px solid #10b981;
            backdrop-filter: blur(12px);
            color: #34d399;
            padding: 0.75rem 2rem;
            border-radius: 9999px;
            font-weight: 800;
            font-size: 1.15rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: 0 0 35px rgba(16, 185, 129, 0.45);
            opacity: 0;
            pointer-events: none;
            z-index: 1080;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .gesture-indicator-badge.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        /* Picture-in-Picture Camera Box */
        .camera-pip {
            position: fixed;
            bottom: 5.5rem;
            right: 2rem;
            width: 290px;
            background: rgba(15, 23, 42, 0.95);
            border: 2px solid #3b82f6;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.7);
            z-index: 1050;
            transition: all 0.3s ease;
        }

        .camera-video-wrapper {
            position: relative;
            width: 100%;
            height: 190px;
            background: #000;
            overflow: hidden;
        }

        .camera-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scaleX(-1); /* Mirror camera */
        }

        /* Detection Target Box Overlay */
        .camera-gesture-target {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 110px;
            height: 130px;
            border: 2px dashed #10b981;
            border-radius: 12px;
            background: rgba(16, 185, 129, 0.15);
            pointer-events: none;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            padding: 6px;
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.3);
            animation: targetPulse 2s infinite ease-in-out;
        }

        @keyframes targetPulse {
            0%, 100% { border-color: #10b981; opacity: 0.85; }
            50% { border-color: #34d399; opacity: 1; }
        }

        .target-box-label {
            font-size: 8.5px;
            font-weight: 800;
            color: #ffffff;
            background: rgba(0, 0, 0, 0.65);
            padding: 2px 6px;
            border-radius: 4px;
            text-align: center;
            line-height: 1.2;
        }

        .slide-footer {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(16px);
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding: 0.85rem 2rem;
            z-index: 100;
        }

        /* Floating On-Stage Navigation Arrows */
        .slide-nav-overlay-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(15, 23, 42, 0.82);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 60;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.5);
        }

        .slide-nav-overlay-btn:hover {
            background: #2563eb;
            border-color: #60a5fa;
            color: #ffffff;
            transform: translateY(-50%) scale(1.1);
        }

        .slide-nav-overlay-btn.prev {
            left: 14px;
        }

        .slide-nav-overlay-btn.next {
            right: 14px;
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
                <h5 class="fw-bolder mb-0 text-white" id="header-slide-title">
                    {{ $teachingSlides ? $teachingSlides->title : 'Digital AI Slide Presentation' }}
                </h5>
                <small class="text-white-50" id="header-slide-course">
                    {{ $teachingSlides ? $teachingSlides->course : 'Course Presentation' }}
                </small>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Camera Toggle Button -->
            <button class="btn btn-outline-info btn-sm rounded-pill px-3 fw-bold d-flex align-items-center gap-1.5" id="btn-toggle-cam" onclick="toggleWebCam()">
                <i data-lucide="video" style="width: 16px; height: 16px;"></i>
                <span id="cam-status-text">Allow Camera / បើកកាមេរ៉ា Gesture</span>
            </button>

            <!-- Zoom Controls (for PDF) -->
            <div class="btn-group btn-group-sm" id="pdf-zoom-controls" style="display: none;">
                <button class="btn btn-outline-secondary" onclick="zoomSlide(-0.15)" title="Zoom Out"><i data-lucide="zoom-out" style="width: 14px; height: 14px;"></i></button>
                <button class="btn btn-outline-secondary" onclick="resetZoom()" title="Reset Zoom"><i data-lucide="maximize-2" style="width: 14px; height: 14px;"></i></button>
                <button class="btn btn-outline-secondary" onclick="zoomSlide(0.15)" title="Zoom In"><i data-lucide="zoom-in" style="width: 14px; height: 14px;"></i></button>
            </div>

            <!-- Fullscreen -->
            <button class="btn btn-outline-light btn-sm rounded-pill px-3 fw-bold" onclick="toggleFullscreen()">
                <i data-lucide="maximize" style="width: 15px; height: 15px;" class="me-1"></i> Fullscreen
            </button>

            <!-- Exit -->
            <a href="{{ route('admin.index', ['tab' => 'slides']) }}" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold">
                <i data-lucide="arrow-left" style="width: 15px; height: 15px;" class="me-1"></i> Exit
            </a>
        </div>
    </header>

    <!-- Presentation Stage -->
    <main class="presentation-stage">
        <!-- Floating Gesture Notification Badge -->
        <div id="gesture-badge" class="gesture-indicator-badge">
            <span id="gesture-icon">✌️</span>
            <span id="gesture-text">Gesture Detected!</span>
        </div>

        <!-- Master Presentation Card Container -->
        <div class="slide-stage-card" id="slide-stage-container">
            
            <!-- Top Slide Metadata Row -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary px-3 py-1.5 text-uppercase fw-bold rounded-pill" id="slide-category-badge">
                        PRESENTATION SLIDE
                    </span>
                    <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill" id="slide-mode-badge" style="font-size: 11px;">
                        ● Uploaded Slide File Live
                    </span>
                </div>
                <span class="badge bg-body-secondary text-light font-monospace px-3 py-1.5 rounded-pill fs-7" id="slide-counter-badge">
                    SLIDE 1 OF 1
                </span>
            </div>

            <!-- 1. PDF Mode Viewport (Active when uploaded file is PDF) -->
            <div id="pdf-slide-viewport" class="pdf-viewer-viewport">
                <canvas id="pdf-slide-canvas" class="pdf-render-canvas"></canvas>
                <div id="pdf-loading-spinner" class="text-center py-5">
                    <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status"></div>
                    <h5 class="fw-bold text-white mb-1">កំពុងដំណើរការ Slide Presentation...</h5>
                    <small class="text-white-50">Loading high-definition presentation pages via PDF.js</small>
                </div>
            </div>

            <!-- 2. Office / PowerPoint Mode Viewport (Active when uploaded file is PPTX/PPT/DOCX) -->
            <div id="office-slide-viewport" class="pdf-viewer-viewport d-none p-0 w-100 h-100 position-relative">
                <iframe id="office-slide-iframe" class="w-100 h-100 border-0 rounded-4" allowfullscreen allow="autoplay"></iframe>
                <div id="office-loading-spinner" class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center bg-black bg-opacity-80 rounded-4" style="z-index: 10;">
                    <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status"></div>
                    <h5 class="fw-bold text-white mb-1">កំពុងដំណើរការ PowerPoint Presentation...</h5>
                    <small class="text-white-50">Rendering PowerPoint slides via Microsoft Office Online Engine</small>
                </div>
            </div>

            <!-- 3. Image Mode Viewport (Active when uploaded file is Image) -->
            <div id="image-slide-viewport" class="pdf-viewer-viewport d-none">
                <img id="image-slide-img" src="" alt="Slide Image" class="pdf-render-canvas" style="object-fit: contain;">
            </div>

            <!-- Floating On-Stage Navigation Arrows -->
            <button class="slide-nav-overlay-btn prev" onclick="changeSlide(-1)" title="ថយក្រោយ (Previous Slide)">
                <i data-lucide="chevron-left" style="width: 22px; height: 22px;"></i>
            </button>
            <button class="slide-nav-overlay-btn next" onclick="changeSlide(1)" title="ទៅមុខ (Next Slide)">
                <i data-lucide="chevron-right" style="width: 22px; height: 22px;"></i>
            </button>

            <!-- 3. Fallback / Interactive HTML Slide Viewport -->
            <div id="html-slide-viewport" class="d-none flex-grow-1 d-flex flex-column justify-content-between py-2">
                <div>
                    <h1 class="display-5 fw-bolder text-white mb-2" id="html-slide-title">Design Tokens & Component Hierarchy</h1>
                    <p class="lead text-light opacity-80 mb-3" id="html-slide-desc" style="max-width: 900px;">
                        How atomic design tokens (colors, sizing, typography, elevation) seamlessly synchronize between Figma and frontend codebases.
                    </p>

                    <!-- Dynamic HTML Slide Cards -->
                    <div id="html-slide-cards" class="row g-3 my-2"></div>
                </div>
            </div>

            <!-- Bottom Slide Note / Shortcut Bar -->
            <div class="p-2.5 rounded-3 mt-auto d-flex justify-content-between align-items-center bg-black bg-opacity-40 border border-white border-opacity-10">
                <div class="d-flex align-items-center gap-2 text-truncate me-2">
                    <span class="badge bg-warning text-dark fw-bold">AI GESTURE</span>
                    <span class="small text-white-50 text-truncate" id="slide-tip-text">
                        លើកម្រាមដៃ ១ (☝️) ដើម្បីថយក្រោយ • លើកម្រាមដៃ ២ (✌️) ដើម្បីទៅស្លាយបន្ទាប់
                    </span>
                </div>
                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                    <span class="badge bg-primary-subtle text-primary fw-bold" style="font-size: 11px;">☝️ ម្រាម 1: ថយក្រោយ</span>
                    <span class="badge bg-info-subtle text-info fw-bold" style="font-size: 11px;">✌️ ម្រាម 2: ទៅមុខ</span>
                </div>
            </div>

        </div>
    </main>

    <!-- Picture-in-Picture WebCam for Hand Gesture Detection -->
    <div class="camera-pip" id="camera-box" style="display: none;">
        <div class="p-2 border-bottom d-flex justify-content-between align-items-center" style="background: rgba(0,0,0,0.5);">
            <div class="d-flex align-items-center gap-1.5">
                <span style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; box-shadow: 0 0 8px #10b981;"></span>
                <small class="fw-bold text-white" style="font-size: 11px;">MediaPipe AI Hand Tracker</small>
            </div>
            <button class="btn btn-sm text-white-50 p-0" onclick="toggleWebCam()">&times;</button>
        </div>

        <div class="camera-video-wrapper position-relative">
            <video id="webcam-feed" class="camera-video" autoplay playsinline muted></video>
            <canvas id="gesture-canvas" width="320" height="240" class="position-absolute top-0 start-0 w-100 h-100" style="pointer-events: none; transform: scaleX(-1);"></canvas>

            <!-- AI Detection Status Badge -->
            <div class="position-absolute top-0 end-0 m-2">
                <span class="badge bg-secondary bg-opacity-75" style="font-size: 8.5px;" id="target-zone-status">READY</span>
            </div>
        </div>

        <div class="p-2 text-center" style="font-size: 11px; background: rgba(0,0,0,0.6);">
            <span class="text-info fw-bold" id="gesture-live-status">លើកម្រាមដៃ (☝️ ថយក្រោយ | ✌️ ទៅមុខ)</span>
        </div>
    </div>

    <!-- Presentation Controls Footer -->
    <footer class="slide-footer d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-body-secondary text-secondary" id="footer-slide-num">Slide 1 / 1</span>
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

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // File and Presentation State
        const rawFilePath = "{{ $teachingSlides && $teachingSlides->file_path ? asset($teachingSlides->file_path) : '' }}";
        const rawFileType = "{{ $teachingSlides ? $teachingSlides->file_type : 'demo' }}";

        let currentMode = 'pdf'; // 'pdf', 'image', or 'html'
        let currentSlideIdx = 1;
        let totalSlides = 1;
        let pdfDoc = null;
        let pdfScale = 1.35;
        let pdfRenderTask = null;
        let isPdfRendering = false;
        let pendingPageNum = null;

        // Fallback Demo HTML Slides Deck
        const demoHtmlSlides = [
            {
                category: "MODULE 01 • TOKENS",
                title: "Design Tokens & Component Hierarchy",
                desc: "How atomic design tokens (colors, sizing, typography, elevation) seamlessly synchronize between Figma and frontend codebases.",
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
                desc: "Applying flexbox rules within frames: Hug contents, Fill container, and Fixed dimensions for robust responsive interfaces.",
                notes: "Use 8pt grid unit for consistent spacing rhythm across mobile and desktop breakpoints.",
                cards: [
                    { icon: "columns", title: "12-Col Grid", desc: "Flexible desktop layouts with gutter margins", bg: "rgba(59, 130, 246, 0.12)", color: "text-primary" },
                    { icon: "maximize-2", title: "Fill Container", desc: "Allows cards to expand responsively", bg: "rgba(139, 92, 246, 0.12)", color: "text-info" },
                    { icon: "minimize-2", title: "Hug Contents", desc: "Adapts container tightly to nested text", bg: "rgba(236, 72, 153, 0.12)", color: "text-warning" },
                    { icon: "smartphone", title: "Mobile Stack", desc: "Auto wraps rows into single column", bg: "rgba(16, 185, 129, 0.12)", color: "text-success" }
                ]
            },
            {
                category: "MODULE 03 • AI INTEGRATION",
                title: "AI-Assisted Workflow & Automated Testing",
                desc: "Harnessing real-time computer vision, gesture tracking, and generative tooling to elevate modern classroom experiences.",
                notes: "Machine learning at the edge empowers hands-free interaction without physical clickers.",
                cards: [
                    { icon: "cpu", title: "Edge CV", desc: "Real-time webcam hand gesture recognition", bg: "rgba(59, 130, 246, 0.12)", color: "text-primary" },
                    { icon: "sparkles", title: "Auto Scoring", desc: "Instant evaluation of QCM quizzes and challenges", bg: "rgba(139, 92, 246, 0.12)", color: "text-info" },
                    { icon: "award", title: "Verified Badges", desc: "Cryptographic proof of lecture attendance", bg: "rgba(236, 72, 153, 0.12)", color: "text-warning" },
                    { icon: "zap", title: "Instant Sync", desc: "Zero-latency synchronization across students", bg: "rgba(16, 185, 129, 0.12)", color: "text-success" }
                ]
            }
        ];

        // Initialize presentation engine on load
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();

            const isPdf = rawFilePath && (rawFilePath.toLowerCase().endsWith('.pdf') || rawFileType === 'pdf');
            const isImage = rawFilePath && (rawFileType === 'image' || /\.(png|jpe?g|webp)$/i.test(rawFilePath));
            const isOffice = rawFilePath && (rawFileType === 'presentation' || rawFileType === 'word' || /\.(pptx?|ppsx?|docx?)$/i.test(rawFilePath));

            if (isPdf) {
                loadPdfPresentation(rawFilePath);
            } else if (isImage) {
                loadImagePresentation(rawFilePath);
            } else if (isOffice) {
                loadOfficePresentation(rawFilePath);
            } else {
                loadHtmlPresentation();
            }
        });

        // ---------------- 1. PDF Presentation Engine (PDF.js) ----------------
        async function loadPdfPresentation(url) {
            currentMode = 'pdf';
            document.getElementById('pdf-slide-viewport').classList.remove('d-none');
            document.getElementById('image-slide-viewport').classList.add('d-none');
            document.getElementById('html-slide-viewport').classList.add('d-none');
            document.getElementById('pdf-zoom-controls').style.display = 'inline-flex';
            document.getElementById('slide-mode-badge').textContent = '● PDF Presentation Live';

            try {
                const loadingTask = pdfjsLib.getDocument(url);
                pdfDoc = await loadingTask.promise;
                totalSlides = pdfDoc.numPages;
                currentSlideIdx = 1;

                document.getElementById('pdf-loading-spinner').style.display = 'none';
                renderPdfPage(1);
            } catch (err) {
                console.warn('PDF load error, falling back to HTML deck:', err);
                loadHtmlPresentation();
            }
        }

        async function renderPdfPage(num) {
            if (!pdfDoc) return;

            // 1. If another page is actively rendering on this canvas, cleanly cancel it first
            if (pdfRenderTask !== null) {
                try {
                    pdfRenderTask.cancel();
                } catch (e) {}
                pdfRenderTask = null;
            }

            isPdfRendering = true;

            try {
                const page = await pdfDoc.getPage(num);
                const canvas = document.getElementById('pdf-slide-canvas');
                if (!canvas) return;
                const ctx = canvas.getContext('2d');

                // Compute optimal viewport scale to fit stage height & width
                const container = document.getElementById('pdf-slide-viewport');
                const containerH = (container ? container.clientHeight : 0) || 550;
                const containerW = (container ? container.clientWidth : 0) || 960;

                const unscaledViewport = page.getViewport({ scale: 1.0 });
                const scaleH = (containerH - 24) / unscaledViewport.height;
                const scaleW = (containerW - 24) / unscaledViewport.width;
                const baseScale = Math.min(scaleH, scaleW);
                const fitScale = (baseScale > 0.05 ? baseScale : 1.0) * pdfScale;
                const viewport = page.getViewport({ scale: fitScale });

                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };

                pdfRenderTask = page.render(renderContext);
                await pdfRenderTask.promise;
                pdfRenderTask = null;
            } catch (err) {
                // RenderingCancelledException is normal when user quickly navigates slides
                if (err && err.name !== 'RenderingCancelledException') {
                    console.error('PDF render error:', err);
                }
            } finally {
                isPdfRendering = false;
                if (pendingPageNum !== null) {
                    const nextNum = pendingPageNum;
                    pendingPageNum = null;
                    renderPdfPage(nextNum);
                }
            }

            updateSlideIndicators(num, totalSlides);
        }

        function queueRenderPdfPage(num) {
            if (isPdfRendering) {
                pendingPageNum = num;
                if (pdfRenderTask !== null) {
                    try {
                        pdfRenderTask.cancel();
                    } catch (e) {}
                }
            } else {
                renderPdfPage(num);
            }
        }

        function zoomSlide(delta) {
            pdfScale = Math.max(0.6, Math.min(2.5, pdfScale + delta));
            if (pdfDoc) queueRenderPdfPage(currentSlideIdx);
        }

        function resetZoom() {
            pdfScale = 1.35;
            if (pdfDoc) queueRenderPdfPage(currentSlideIdx);
        }

        // ---------------- 2. Image Presentation Engine ----------------
        function loadImagePresentation(url) {
            currentMode = 'image';
            document.getElementById('pdf-slide-viewport').classList.add('d-none');
            document.getElementById('office-slide-viewport').classList.add('d-none');
            document.getElementById('html-slide-viewport').classList.add('d-none');
            document.getElementById('image-slide-viewport').classList.remove('d-none');
            document.getElementById('image-slide-img').src = url;
            totalSlides = 1;
            updateSlideIndicators(1, 1);
        }

        // ---------------- 3. Office / PowerPoint Presentation Engine ----------------
        function loadOfficePresentation(url) {
            currentMode = 'office';
            document.getElementById('pdf-slide-viewport').classList.add('d-none');
            document.getElementById('image-slide-viewport').classList.add('d-none');
            document.getElementById('html-slide-viewport').classList.add('d-none');
            document.getElementById('office-slide-viewport').classList.remove('d-none');
            document.getElementById('pdf-zoom-controls').style.display = 'none';

            const isWord = rawFileType === 'word' || /\.(docx?|doc)$/i.test(url);
            document.getElementById('slide-category-badge').textContent = isWord ? 'WORD DOCUMENT' : 'POWERPOINT PRESENTATION';
            document.getElementById('slide-mode-badge').textContent = isWord ? '● Word Document Live' : '● PowerPoint Live Presentation';

            totalSlides = {{ $teachingSlides && $teachingSlides->total_slides ? $teachingSlides->total_slides : 32 }};
            currentSlideIdx = 1;
            updateSlideIndicators(currentSlideIdx, totalSlides);

            // Construct Microsoft Office Online Embed Viewer URL
            let embedUrl = url;
            if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1' || window.location.hostname.endsWith('.test')) {
                try {
                    const parsed = new URL(url, window.location.origin);
                    embedUrl = 'https://genzdigital.goatplay.site' + parsed.pathname;
                } catch(e) {}
            }

            const iframe = document.getElementById('office-slide-iframe');
            const officeSpinner = document.getElementById('office-loading-spinner');
            iframe.src = 'https://view.officeapps.live.com/op/embed.aspx?src=' + encodeURIComponent(embedUrl);

            iframe.onload = () => {
                if (officeSpinner) officeSpinner.style.display = 'none';
            };

            setTimeout(() => {
                if (officeSpinner) officeSpinner.style.display = 'none';
            }, 3000);
        }

        // ---------------- 4. HTML Slide Deck Engine (Fallback) ----------------
        function loadHtmlPresentation() {
            currentMode = 'html';
            document.getElementById('pdf-slide-viewport').classList.add('d-none');
            document.getElementById('office-slide-viewport').classList.add('d-none');
            document.getElementById('image-slide-viewport').classList.add('d-none');
            document.getElementById('html-slide-viewport').classList.remove('d-none');
            totalSlides = demoHtmlSlides.length;
            currentSlideIdx = 1;
            renderHtmlSlide(0);
        }

        function renderHtmlSlide(idx) {
            const s = demoHtmlSlides[idx];
            document.getElementById('slide-category-badge').textContent = s.category;
            document.getElementById('html-slide-title').textContent = s.title;
            document.getElementById('html-slide-desc').textContent = s.desc;
            document.getElementById('slide-tip-text').textContent = s.notes;

            let cardsHtml = '';
            s.cards.forEach(c => {
                cardsHtml += `
                    <div class="col-md-3">
                        <div class="p-3.5 rounded-4 text-center h-100" style="background: ${c.bg}; border: 1px solid rgba(255, 255, 255, 0.08);">
                            <i data-lucide="${c.icon}" class="${c.color} mb-2" style="width: 28px; height: 28px;"></i>
                            <h6 class="fw-bold text-white mb-1">${c.title}</h6>
                            <small class="text-white-50">${c.desc}</small>
                        </div>
                    </div>
                `;
            });
            document.getElementById('html-slide-cards').innerHTML = cardsHtml;
            if (window.lucide) window.lucide.createIcons();

            updateSlideIndicators(idx + 1, totalSlides);
        }

        // ---------------- Universal Slide Navigation (Prev / Next) ----------------
        function changeSlide(dir) {
            if (currentMode === 'pdf') {
                if (!pdfDoc) return;
                const nextNum = currentSlideIdx + dir;
                if (nextNum >= 1 && nextNum <= totalSlides) {
                    currentSlideIdx = nextNum;
                    queueRenderPdfPage(currentSlideIdx);
                }
            } else if (currentMode === 'office') {
                const nextNum = currentSlideIdx + dir;
                if (nextNum >= 1 && nextNum <= totalSlides) {
                    currentSlideIdx = nextNum;
                    updateSlideIndicators(currentSlideIdx, totalSlides);
                }
                const iframe = document.getElementById('office-slide-iframe');
                if (iframe) {
                    try {
                        iframe.contentWindow.focus();
                        iframe.contentWindow.postMessage({ action: dir > 0 ? 'next' : 'prev', slide: currentSlideIdx }, '*');
                    } catch(e) {}
                }
            } else if (currentMode === 'html') {
                let nextIdx = (currentSlideIdx - 1) + dir;
                if (nextIdx < 0) nextIdx = 0;
                if (nextIdx >= demoHtmlSlides.length) nextIdx = demoHtmlSlides.length - 1;
                currentSlideIdx = nextIdx + 1;
                renderHtmlSlide(nextIdx);
            }
        }

        function updateSlideIndicators(current, total) {
            document.getElementById('slide-counter-badge').textContent = `SLIDE ${current} OF ${total}`;
            document.getElementById('footer-slide-num').textContent = `Slide ${current} / ${total}`;
        }

        // Keyboard Controls
        window.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight' || e.key === 'Space' || e.key === 'PageDown') {
                changeSlide(1);
            } else if (e.key === 'ArrowLeft' || e.key === 'PageUp') {
                changeSlide(-1);
            }
        });

        // =====================================================================
        // GOOGLE MEDIAPIPE HANDS AI GESTURE ENGINE
        // 100% ACCURATE 21-LANDMARK 3D SKELETON TRACKING (ZERO FACE INTERFERENCE!)
        // =====================================================================
        let isCamActive = false;
        let camStream = null;
        let mediaPipeHands = null;
        let animFrameId = null;
        let lastGestureTriggerTime = 0;
        let holdGestureType = null;
        let holdGestureFrames = 0;
        const REQUIRED_HOLD_FRAMES = 2; // Hold gesture steady for 2 consecutive frames
        const GESTURE_COOLDOWN_MS = 1300; // 1.3s cooldown between slide flips

        function initMediaPipe() {
            if (typeof Hands === 'undefined') {
                console.warn('MediaPipe Hands library not loaded yet.');
                return false;
            }

            try {
                mediaPipeHands = new Hands({
                    locateFile: (file) => `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${file}`
                });

                mediaPipeHands.setOptions({
                    maxNumHands: 1,
                    modelComplexity: 1,
                    minDetectionConfidence: 0.65,
                    minTrackingConfidence: 0.6
                });

                mediaPipeHands.onResults(onMediaPipeResults);
                return true;
            } catch (err) {
                console.error('MediaPipe initialization error:', err);
                return false;
            }
        }

        async function toggleWebCam() {
            const camBox = document.getElementById('camera-box');
            const video = document.getElementById('webcam-feed');
            const canvas = document.getElementById('gesture-canvas');
            const btnText = document.getElementById('cam-status-text');

            if (!isCamActive) {
                try {
                    camStream = await navigator.mediaDevices.getUserMedia({
                        video: { width: 320, height: 240, facingMode: 'user' }
                    });
                    video.srcObject = camStream;
                    await video.play();

                    canvas.width = 320;
                    canvas.height = 240;

                    camBox.style.display = 'block';
                    isCamActive = true;
                    btnText.textContent = 'Disable Camera / បិទកាមេរ៉ា Gesture';
                    document.getElementById('gesture-live-status').textContent = 'Loading MediaPipe AI Hand Tracker...';

                    if (!mediaPipeHands) {
                        initMediaPipe();
                    }

                    startMediaPipeLoop();
                } catch (err) {
                    alert('កាមេរ៉ាមិនអាចបើកបានទេ (Camera permission denied or camera not found): ' + err.message);
                }
            } else {
                if (camStream) {
                    camStream.getTracks().forEach(t => t.stop());
                }
                if (animFrameId) {
                    cancelAnimationFrame(animFrameId);
                }
                camBox.style.display = 'none';
                isCamActive = false;
                btnText.textContent = 'Allow Camera / បើកកាមេរ៉ា Gesture';
            }
        }

        function startMediaPipeLoop() {
            const video = document.getElementById('webcam-feed');

            async function processVideo() {
                if (!isCamActive) return;

                if (video.readyState >= 2 && mediaPipeHands) {
                    try {
                        await mediaPipeHands.send({ image: video });
                    } catch (e) {
                        // ignore dropped frame
                    }
                }
                animFrameId = requestAnimationFrame(processVideo);
            }
            processVideo();
        }

        function onMediaPipeResults(results) {
            if (!isCamActive) return;

            const canvas = document.getElementById('gesture-canvas');
            const ctx = canvas.getContext('2d');
            const targetStatus = document.getElementById('target-zone-status');
            const liveStatus = document.getElementById('gesture-live-status');

            ctx.clearRect(0, 0, canvas.width, canvas.height);

            if (results.multiHandLandmarks && results.multiHandLandmarks.length > 0) {
                const landmarks = results.multiHandLandmarks[0];

                // Draw AI Skeleton Hand connectors and landmarks
                if (typeof drawConnectors === 'function' && typeof HAND_CONNECTIONS !== 'undefined') {
                    drawConnectors(ctx, landmarks, HAND_CONNECTIONS, { color: '#00e5ff', lineWidth: 2.5 });
                }
                if (typeof drawLandmarks === 'function') {
                    drawLandmarks(ctx, landmarks, { color: '#10b981', lineWidth: 1, radius: 3 });
                }

                if (targetStatus) {
                    targetStatus.textContent = 'HAND DETECTED';
                    targetStatus.className = 'badge bg-success';
                }

                // Landmark positions: Wrist (0), Tip 8 (Index), Tip 12 (Middle), Tip 16 (Ring), Tip 20 (Pinky)
                const w = landmarks[0];
                const isExtended = (tip, pip) => {
                    const distTip = Math.hypot(landmarks[tip].x - w.x, landmarks[tip].y - w.y);
                    const distPip = Math.hypot(landmarks[pip].x - w.x, landmarks[pip].y - w.y);
                    return (landmarks[tip].y < landmarks[pip].y) || (distTip > distPip * 1.22);
                };

                const indexUp = isExtended(8, 6);
                const middleUp = isExtended(12, 10);
                const ringUp = isExtended(16, 14);
                const pinkyUp = isExtended(20, 18);

                let currentGesture = null;

                // ☝️ 1 Finger: Index is up, others are curled down
                if (indexUp && !middleUp && !ringUp && !pinkyUp) {
                    currentGesture = 1;
                    liveStatus.innerHTML = '<span class="text-warning fw-bold">☝️ ស្គាល់ម្រាមដៃ ១ (Previous Slide)</span>';
                }
                // ✌️ 2 Fingers: Index and Middle are up, others are curled down
                else if (indexUp && middleUp && !ringUp && !pinkyUp) {
                    currentGesture = 2;
                    liveStatus.innerHTML = '<span class="text-success fw-bold">✌️ ស្គាល់ម្រាមដៃ ២ (Next Slide)</span>';
                }
                // ✋ Open Palm: All fingers extended
                else if (indexUp && middleUp && ringUp && pinkyUp) {
                    liveStatus.innerHTML = '<span class="text-info fw-bold">✋ បាតដៃបើក (Standby)</span>';
                }
                // ✊ Fist: All fingers curled down
                else if (!indexUp && !middleUp && !ringUp && !pinkyUp) {
                    liveStatus.innerHTML = '<span class="text-white-50">✊ ក្តាប់ដៃ (Standby)</span>';
                }
                else {
                    liveStatus.innerHTML = '<span class="text-white-50">លើកម្រាមដៃ ១ (☝️) ឬ ២ (✌️)</span>';
                }

                // Debounce trigger
                const now = Date.now();
                if (currentGesture in {1: true, 2: true}) {
                    if (holdGestureType === currentGesture) {
                        holdGestureFrames++;
                        if (holdGestureFrames >= REQUIRED_HOLD_FRAMES && (now - lastGestureTriggerTime > GESTURE_COOLDOWN_MS)) {
                            triggerGestureAction(currentGesture);
                            lastGestureTriggerTime = now;
                            holdGestureFrames = 0;
                        }
                    } else {
                        holdGestureType = currentGesture;
                        holdGestureFrames = 1;
                    }
                } else {
                    holdGestureType = null;
                    holdGestureFrames = 0;
                }

            } else {
                if (targetStatus) {
                    targetStatus.textContent = 'NO HAND';
                    targetStatus.className = 'badge bg-secondary';
                }
                liveStatus.innerHTML = '<span class="text-white-50">សូមលើកដៃមុខកាមេរ៉ា (Show hand)</span>';
                holdGestureType = null;
                holdGestureFrames = 0;
            }
        }

        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                if (document.exitFullscreen) document.exitFullscreen();
            }
        }
    </script>
</body>
</html>
