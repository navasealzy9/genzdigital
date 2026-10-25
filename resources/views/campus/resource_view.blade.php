<!DOCTYPE html>
<html lang="km" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ $resource->title }} - GenZ Digital Resource Reader</title>
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

    <!-- PDF.js Engine -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    </script>

    <style>
        :root {
            --app-font: 'Google Sans', 'Kantumruy Pro', 'Noto Sans Khmer', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            font-family: var(--app-font);
            background-color: #020617;
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0;
        }

        .reader-navbar {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .reader-stage {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 1.5rem 1rem;
            background: radial-gradient(circle at top, rgba(30, 41, 59, 0.4) 0%, #020617 80%);
            min-height: calc(100vh - 75px);
        }

        .reader-canvas-wrapper {
            background: #0f172a;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6);
            padding: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 100%;
            overflow: auto;
            position: relative;
        }

        .reader-canvas {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            background: #ffffff;
            transition: transform 0.2s ease;
        }

        .copy-toast {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 9999;
        }

        .copy-toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }
    </style>
</head>
<body>

    <!-- Reader Navbar -->
    <header class="reader-navbar py-2.5 px-3 px-md-4">
        <div class="container-fluid d-flex flex-wrap justify-content-between align-items-center gap-2">
            <!-- Left Info -->
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('campus.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3 py-1.5 fw-bold d-inline-flex align-items-center gap-1.5">
                    <i data-lucide="arrow-left" style="width: 15px; height: 15px;"></i>
                    <span class="d-none d-sm-inline">Student Portal</span>
                </a>
                <div class="d-flex align-items-center gap-2 border-start border-secondary border-opacity-50 ps-3">
                    <img src="{{ asset('images/genz-logo.png') }}" alt="Logo" class="rounded-2" style="width: 28px; height: 28px; object-fit: contain;">
                    <div>
                        <h6 class="fw-bold mb-0 text-white fs-6 text-truncate" style="max-width: 280px;">{{ $resource->title }}</h6>
                        <small class="text-white-50" style="font-size: 11px;">
                            <span class="badge bg-primary px-1.5 py-0.5 rounded me-1">{{ $resource->class_code ?: $resource->course }}</span>
                            {{ $resource->file_name }} ({{ $resource->file_size }})
                        </small>
                    </div>
                </div>
            </div>

            <!-- Center Pagination & Zoom Controls -->
            <div class="d-flex align-items-center gap-2 bg-black bg-opacity-40 p-1.5 px-3 rounded-pill border border-white border-opacity-10 shadow-sm">
                <button type="button" class="btn btn-sm btn-outline-light rounded-circle p-1" onclick="changeReaderPage(-1)" title="Previous Page (ថយក្រោយ)">
                    <i data-lucide="chevron-left" style="width: 16px; height: 16px;"></i>
                </button>
                <span class="small font-monospace fw-bold text-white-50 px-2">
                    ទំព័រ <span class="text-white fw-bolder" id="reader-current-page">1</span> / <span id="reader-total-pages">1</span>
                </span>
                <button type="button" class="btn btn-sm btn-outline-light rounded-circle p-1" onclick="changeReaderPage(1)" title="Next Page (ទៅមុខ)">
                    <i data-lucide="chevron-right" style="width: 16px; height: 16px;"></i>
                </button>

                <span class="text-white-50">|</span>

                <!-- Zoom Controls -->
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-secondary btn-sm p-1 px-2" onclick="zoomReader(-0.15)" title="Zoom Out"><i data-lucide="zoom-out" style="width: 14px; height: 14px;"></i></button>
                    <button type="button" class="btn btn-outline-secondary btn-sm p-1 px-2" onclick="resetReaderZoom()" title="Reset Zoom"><i data-lucide="maximize-2" style="width: 14px; height: 14px;"></i></button>
                    <button type="button" class="btn btn-outline-secondary btn-sm p-1 px-2" onclick="zoomReader(0.15)" title="Zoom In"><i data-lucide="zoom-in" style="width: 14px; height: 14px;"></i></button>
                </div>
            </div>

            <!-- Right Actions -->
            <div class="d-flex align-items-center gap-2">
                <!-- Toggle Native / Iframe View -->
                <button type="button" class="btn btn-outline-light btn-sm rounded-pill px-3 py-1.5 fw-bold d-none d-md-inline-flex align-items-center gap-1.5" onclick="toggleReaderMode()">
                    <i data-lucide="layout" style="width: 14px; height: 14px;"></i>
                    <span id="btn-toggle-view-text">Native Iframe View</span>
                </button>

                <!-- Copy Share Link -->
                <button type="button" class="btn btn-outline-info btn-sm rounded-pill px-3 py-1.5 fw-bold d-inline-flex align-items-center gap-1.5" onclick="copyShareableLink()">
                    <i data-lucide="share-2" style="width: 14px; height: 14px;"></i>
                    <span class="d-none d-sm-inline">Copy Link Share</span>
                </button>

                <!-- Download Disabled / Protected -->
                <span class="badge bg-secondary bg-opacity-50 text-white-50 border border-secondary rounded-pill px-3 py-1.5 fw-bold d-inline-flex align-items-center gap-1.5">
                    <i data-lucide="lock" style="width: 13px; height: 13px;"></i>
                    <span>Download Disabled (Protected)</span>
                </span>
            </div>
        </div>
    </header>

    <!-- Reader Main Stage -->
    <main class="reader-stage">
        <!-- 1. PDF Canvas Viewport -->
        <div id="canvas-view-container" class="w-100 d-flex flex-column align-items-center">
            <div class="reader-canvas-wrapper" id="reader-canvas-viewport">
                <canvas id="pdf-reader-canvas" class="reader-canvas"></canvas>

                <!-- Loading Spinner Overlay -->
                <div id="reader-loading-spinner" class="position-absolute top-50 start-50 translate-middle text-center">
                    <div class="spinner-border text-primary mb-2" style="width: 2.5rem; height: 2.5rem;" role="status"></div>
                    <div class="fw-bold small text-white">កំពុងទាញយកមេរៀន PDF...</div>
                    <small class="text-white-50" style="font-size: 11px;">Rendering PDF Lesson pages via PDF.js</small>
                </div>
            </div>

            <!-- Bottom Floating Quick-Page Shortcuts -->
            <div class="d-flex align-items-center justify-content-between gap-3 mt-3 w-100" style="max-width: 850px;">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-3 py-1.5 fw-bold" onclick="changeReaderPage(-1)">
                    <i data-lucide="arrow-left" style="width: 14px; height: 14px;" class="me-1"></i> ទំព័រថយក្រោយ (Previous)
                </button>
                <div class="text-center small text-white-50">
                    ចុចប៊ូតុងសញ្ញាព្រួញលើ Keyboard <strong>←</strong> ឬ <strong>→</strong> ដើម្បីប្តូរទំព័រ
                </div>
                <button type="button" class="btn btn-primary rounded-pill px-3 py-1.5 fw-bold shadow" onclick="changeReaderPage(1)">
                    ទំព័របន្ទាប់ (Next) <i data-lucide="arrow-right" style="width: 14px; height: 14px;" class="ms-1"></i>
                </button>
            </div>
        </div>

        <!-- 2. Fallback / Native Iframe Viewport -->
        <div id="iframe-view-container" class="w-100 d-none" style="max-width: 1100px; height: calc(100vh - 120px);">
            <iframe id="reader-native-iframe" src="{{ asset($resource->file_url ?: 'uploads/slides/slides_1792915639.pdf') }}#toolbar=1" class="w-100 h-100 rounded-4 border border-secondary border-opacity-25" allowfullscreen></iframe>
        </div>
    </main>

    <!-- Copy Toast -->
    <div id="copyToast" class="copy-toast alert alert-success py-2 px-3 rounded-pill shadow-lg d-flex align-items-center gap-2 fw-bold text-white" style="background: rgba(16, 185, 129, 0.95); border: 1px solid #34d399;">
        <i data-lucide="check-circle" style="width: 16px; height: 16px;"></i>
        <span>បានចម្លង Link មេរៀននេះដោយជោគជ័យ! (Share link copied!)</span>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();
            loadResourcePdf();
        });

        const pdfFileUrl = "{{ asset($resource->file_url ?: 'uploads/slides/slides_1792915639.pdf') }}";
        let readerPdfDoc = null;
        let readerCurrentPage = 1;
        let readerTotalPages = 1;
        let readerPdfScale = 1.25;
        let isReaderRendering = false;
        let readerPendingPage = null;
        let readerRenderTask = null;
        let isIframeMode = false;

        async function loadResourcePdf() {
            try {
                const loadingTask = pdfjsLib.getDocument(pdfFileUrl);
                readerPdfDoc = await loadingTask.promise;
                readerTotalPages = readerPdfDoc.numPages;
                readerCurrentPage = 1;

                document.getElementById('reader-total-pages').textContent = readerTotalPages;
                const spinner = document.getElementById('reader-loading-spinner');
                if (spinner) spinner.style.display = 'none';

                renderReaderPage(1);
            } catch (err) {
                console.warn('PDF.js render failed, switching to native iframe viewer:', err);
                toggleReaderMode(true);
            }
        }

        async function renderReaderPage(num) {
            if (!readerPdfDoc) return;

            // Cleanly cancel active render task to avoid canvas collision
            if (readerRenderTask !== null) {
                try {
                    readerRenderTask.cancel();
                } catch (e) {}
                readerRenderTask = null;
            }

            isReaderRendering = true;

            try {
                const page = await readerPdfDoc.getPage(num);
                const canvas = document.getElementById('pdf-reader-canvas');
                if (!canvas) return;
                const ctx = canvas.getContext('2d');

                const viewportContainer = document.getElementById('reader-canvas-viewport');
                const containerH = (viewportContainer ? viewportContainer.clientHeight : 0) || 720;
                const containerW = (viewportContainer ? viewportContainer.clientWidth : 0) || 860;

                const unscaledViewport = page.getViewport({ scale: 1.0 });
                const scaleW = (containerW - 32) / unscaledViewport.width;
                const computedScale = (scaleW > 0.1 ? scaleW : 1.0) * readerPdfScale;

                const viewport = page.getViewport({ scale: computedScale });

                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };

                readerRenderTask = page.render(renderContext);
                await readerRenderTask.promise;
                readerRenderTask = null;
            } catch (err) {
                if (err && err.name !== 'RenderingCancelledException') {
                    console.error('Reader page error:', err);
                }
            } finally {
                isReaderRendering = false;
                if (readerPendingPage !== null) {
                    const next = readerPendingPage;
                    readerPendingPage = null;
                    renderReaderPage(next);
                }
            }

            document.getElementById('reader-current-page').textContent = num;
        }

        function queueRenderReaderPage(num) {
            if (isReaderRendering) {
                readerPendingPage = num;
                if (readerRenderTask !== null) {
                    try {
                        readerRenderTask.cancel();
                    } catch (e) {}
                }
            } else {
                renderReaderPage(num);
            }
        }

        function changeReaderPage(dir) {
            const next = readerCurrentPage + dir;
            if (next >= 1 && next <= readerTotalPages) {
                readerCurrentPage = next;
                queueRenderReaderPage(readerCurrentPage);
            }
        }

        function zoomReader(delta) {
            readerPdfScale = Math.max(0.6, Math.min(2.5, readerPdfScale + delta));
            if (readerPdfDoc) queueRenderReaderPage(readerCurrentPage);
        }

        function resetReaderZoom() {
            readerPdfScale = 1.25;
            if (readerPdfDoc) queueRenderReaderPage(readerCurrentPage);
        }

        function toggleReaderMode(forceIframe = null) {
            isIframeMode = forceIframe !== null ? forceIframe : !isIframeMode;
            const canvasContainer = document.getElementById('canvas-view-container');
            const iframeContainer = document.getElementById('iframe-view-container');
            const btnText = document.getElementById('btn-toggle-view-text');

            if (isIframeMode) {
                canvasContainer.classList.add('d-none');
                iframeContainer.classList.remove('d-none');
                btnText.textContent = 'PDF.js Canvas View';
            } else {
                iframeContainer.classList.add('d-none');
                canvasContainer.classList.remove('d-none');
                btnText.textContent = 'Native Iframe View';
                if (readerPdfDoc) queueRenderReaderPage(readerCurrentPage);
            }
        }

        // Keyboard navigation
        window.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight' || e.key === 'PageDown') {
                changeReaderPage(1);
            } else if (e.key === 'ArrowLeft' || e.key === 'PageUp') {
                changeReaderPage(-1);
            }
        });

        function copyShareableLink() {
            const url = window.location.href;
            if (navigator.clipboard) {
                navigator.clipboard.writeText(url).then(showCopyToast);
            } else {
                const temp = document.createElement('input');
                temp.value = url;
                document.body.appendChild(temp);
                temp.select();
                document.execCommand('copy');
                document.body.removeChild(temp);
                showCopyToast();
            }
        }

        function showCopyToast() {
            const toast = document.getElementById('copyToast');
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2500);
        }
    </script>
</body>
</html>
