<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.BASE_URL = "{{ url('/') }}";</script>

    <title>GenZ Digital - Campus OS v26.0</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=26.1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=26.1">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/genz-logo.png') }}?v=26.1">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/genz-logo.png') }}?v=26.1">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/genz-logo.png') }}?v=26.1">

    <!-- Google Fonts: Google Sans & Khmer Sans (Kantumruy Pro, Noto Sans Khmer) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&family=Noto+Sans+Khmer:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/google-sans" rel="stylesheet">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Cropper.js CSS (For Avatar Upload & Crop) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">

    <style>
        :root {
            --app-font: 'Google Sans', 'Kantumruy Pro', 'Noto Sans Khmer', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            --gz-gradient: linear-gradient(135deg, #2563eb, #6366f1, #d946ef);
            --card-radius: 20px;
        }

        body {
            font-family: var(--app-font);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background-color: #f6f8fc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(147, 51, 234, 0.04) 0px, transparent 50%),
                radial-gradient(at 50% 100%, rgba(59, 130, 246, 0.03) 0px, transparent 50%);
            color: #0f172a;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        button, input, select, textarea, .form-control, .form-select, .btn, .badge, .dropdown-menu, .modal, .toast {
            font-family: var(--app-font);
        }

        .font-monospace, code, pre, kbd, samp {
            font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace !important;
        }

        [data-bs-theme="dark"] body {
            background-color: #090d16;
            background-image: 
                radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.12) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(147, 51, 234, 0.08) 0px, transparent 50%);
            color: #f8fafc;
        }

        /* Top Navigation Header (iOS 26 Frosted Glass) */
        .main-navbar {
            background: rgba(255, 255, 255, 0.78);
            backdrop-filter: blur(28px) saturate(190%);
            -webkit-backdrop-filter: blur(28px) saturate(190%);
            border-bottom: 1px solid rgba(226, 232, 240, 0.65);
            position: sticky;
            top: 0;
            z-index: 1030;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        [data-bs-theme="dark"] .main-navbar {
            background: rgba(11, 15, 25, 0.8);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .gz-title-gradient {
            background: linear-gradient(135deg, #2563eb, #6366f1, #d946ef);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 900;
        }

        [data-bs-theme="dark"] .gz-title-gradient {
            background: linear-gradient(135deg, #60a5fa, #c084fc, #f472b6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Desktop Nav Tabs (iOS Segmented Style) */
        .desktop-nav-link {
            border: none;
            background: transparent;
            padding: 0.45rem 0.95rem;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 0.85rem;
            color: #64748b;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .desktop-nav-link:hover {
            color: #2563eb;
            background: rgba(37, 99, 235, 0.08);
        }

        .desktop-nav-link.active {
            color: #1d4ed8 !important;
            background: #ffffff !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04);
        }

        [data-bs-theme="dark"] .desktop-nav-link {
            color: #94a3b8;
        }

        [data-bs-theme="dark"] .desktop-nav-link:hover {
            color: #60a5fa;
            background: rgba(96, 165, 250, 0.1);
        }

        [data-bs-theme="dark"] .desktop-nav-link.active {
            color: #60a5fa !important;
            background: rgba(255, 255, 255, 0.12) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.35);
        }

        /* Mobile Bottom Nav (iOS 26 Floating Frosted Dock < 768px) */
        .mobile-bottom-nav {
            position: fixed;
            bottom: 12px;
            left: 14px;
            right: 14px;
            max-width: 500px;
            margin: 0 auto;
            padding: 0.45rem 0.6rem;
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(28px) saturate(200%);
            -webkit-backdrop-filter: blur(28px) saturate(200%);
            border-radius: 28px;
            border: 1px solid rgba(255, 255, 255, 0.7);
            box-shadow: 0 16px 36px -8px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(0, 0, 0, 0.03);
            z-index: 1040;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        [data-bs-theme="dark"] .mobile-bottom-nav {
            background: rgba(15, 23, 42, 0.82);
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.6);
        }

        .mobile-tab-btn {
            background: transparent;
            border: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 0.68rem;
            font-weight: 700;
            padding: 0.35rem 0.65rem;
            border-radius: 18px;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        .mobile-tab-btn:active {
            transform: scale(0.92);
        }

        .mobile-tab-btn.active {
            color: #2563eb !important;
            background: rgba(37, 99, 235, 0.08);
        }

        [data-bs-theme="dark"] .mobile-tab-btn.active {
            color: #60a5fa !important;
            background: rgba(96, 165, 250, 0.12);
        }

        .mobile-tab-dot {
            width: 4px;
            height: 4px;
            background: currentColor;
            border-radius: 9999px;
            margin-top: 2px;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .mobile-tab-btn.active .mobile-tab-dot {
            opacity: 1;
        }

        /* iOS 26 Circular Frosted Glass Button */
        .btn-ios-circle {
            width: 38px;
            height: 38px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.72) !important;
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.8) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #0f172a;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            flex-shrink: 0;
        }

        .btn-ios-circle:hover {
            transform: translateY(-2px) scale(1.05);
            background: #ffffff !important;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
            color: #2563eb;
        }

        .btn-ios-circle:active {
            transform: scale(0.92);
        }

        [data-bs-theme="dark"] .btn-ios-circle {
            background: rgba(30, 41, 59, 0.7) !important;
            border-color: rgba(255, 255, 255, 0.12) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            color: #f8fafc;
        }

        [data-bs-theme="dark"] .btn-ios-circle:hover {
            background: rgba(51, 65, 85, 0.9) !important;
            color: #60a5fa;
        }

        /* Student Pass Gradient Card (iOS 26 Ultra-Clean Apple Card Style) */
        .student-pass-card {
            position: relative;
            overflow: hidden;
            border-radius: 26px;
            padding: 1.6rem;
            color: #ffffff;
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%);
            border: none !important;
            box-shadow: 0 20px 45px -12px rgba(37, 99, 235, 0.42);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
        }

        .student-pass-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 26px 55px -12px rgba(37, 99, 235, 0.55);
        }

        .student-pass-card:active {
            transform: scale(0.985);
        }

        .pass-glow-1 {
            position: absolute;
            right: -2rem;
            top: -2rem;
            width: 14rem;
            height: 14rem;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.14) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 9999px;
            pointer-events: none;
        }

        .student-pass-meta-box {
            background: transparent;
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
            border: none;
            border-radius: 0;
            padding: 0;
        }

        .student-pass-card .btn-link {
            color: #ffffff;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        .student-pass-card .btn-link:hover {
            color: #ffffff;
            opacity: 1 !important;
            transform: translateY(-1px);
        }

        /* Flippable 3D ID Card */
        .perspective-1000 {
            perspective: 1000px;
        }

        .flip-card {
            position: relative;
            width: 100%;
            height: 220px;
            cursor: pointer;
        }

        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            transform-style: preserve-3d;
        }

        .flip-card.flipped .flip-card-inner {
            transform: rotateY(180deg);
        }

        .flip-card-front, .flip-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 24px;
            padding: 1.5rem;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            box-shadow: 0 15px 35px -10px rgba(37, 99, 235, 0.35);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .flip-card-front {
            background: linear-gradient(135deg, #2563eb, #6366f1, #9333ea);
            color: #ffffff;
        }

        .flip-card-back {
            background: #1e293b;
            color: #ffffff;
            transform: rotateY(180deg);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        /* Modern Tool Card (iOS 26 Frosted Glass Widget) */
        .tool-card {
            background: rgba(255, 255, 255, 0.74);
            backdrop-filter: blur(24px) saturate(190%);
            -webkit-backdrop-filter: blur(24px) saturate(190%);
            border: 1px solid rgba(255, 255, 255, 0.85);
            border-radius: 24px;
            padding: 1.25rem;
            cursor: pointer;
            transition: all 0.28s cubic-bezier(0.16, 1, 0.3, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 0 0 1px rgba(255, 255, 255, 0.6) inset;
        }

        .tool-card:hover {
            border-color: rgba(147, 197, 253, 0.9);
            transform: translateY(-5px) scale(1.015);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 20px 38px -8px rgba(37, 99, 235, 0.14), 0 0 0 1px rgba(59, 130, 246, 0.18) inset;
        }

        .tool-card:active {
            transform: scale(0.965);
        }

        [data-bs-theme="dark"] .tool-card {
            background: rgba(22, 30, 48, 0.65);
            backdrop-filter: blur(24px) saturate(190%);
            -webkit-backdrop-filter: blur(24px) saturate(190%);
            border: 1px solid rgba(255, 255, 255, 0.09);
            box-shadow: 0 12px 30px -10px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.04) inset;
            color: #f8fafc;
        }

        [data-bs-theme="dark"] .tool-card:hover {
            background: rgba(30, 41, 59, 0.85);
            border-color: rgba(96, 165, 250, 0.45);
            box-shadow: 0 22px 42px -10px rgba(0, 0, 0, 0.7), 0 0 0 1px rgba(96, 165, 250, 0.25) inset;
        }

        .tool-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.25rem;
            box-shadow: 0 8px 18px -4px rgba(0, 0, 0, 0.2);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            flex-shrink: 0;
        }

        .tool-card:hover .tool-icon-box {
            transform: scale(1.08) rotate(-2deg);
        }

        /* Campus Hero Welcome Banner */
        .campus-hero-banner {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.08) 0%, rgba(99, 102, 241, 0.07) 50%, rgba(217, 70, 239, 0.05) 100%);
            border: 1px solid rgba(203, 213, 225, 0.7);
            border-radius: 26px;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        [data-bs-theme="dark"] .campus-hero-banner {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.85) 0%, rgba(49, 46, 129, 0.2) 60%, rgba(88, 28, 135, 0.15) 100%);
            border-color: rgba(51, 65, 85, 0.7);
        }

        /* Tool Category Filter Pills */
        .tool-filter-pill {
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #64748b;
            font-weight: 700;
            font-size: 0.8rem;
            padding: 0.42rem 0.95rem;
            border-radius: 9999px;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .tool-filter-pill:hover {
            color: #2563eb;
            border-color: #93c5fd;
            background: rgba(37, 99, 235, 0.05);
        }

        .tool-filter-pill.active {
            background: #2563eb !important;
            color: #ffffff !important;
            border-color: #2563eb !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        }

        [data-bs-theme="dark"] .tool-filter-pill {
            background: #1e293b;
            border-color: #334155;
            color: #94a3b8;
        }

        [data-bs-theme="dark"] .tool-filter-pill:hover {
            color: #60a5fa;
            border-color: #60a5fa;
        }

        [data-bs-theme="dark"] .tool-filter-pill.active {
            background: #3b82f6 !important;
            border-color: #3b82f6 !important;
            color: #ffffff !important;
        }

        /* Today's Schedule Card Item */
        .today-class-item {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 0.85rem 1rem;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .today-class-item:hover {
            transform: translateX(3px);
            border-color: #93c5fd;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        [data-bs-theme="dark"] .today-class-item {
            background: rgba(30, 41, 59, 0.65);
            border-color: #334155;
        }

        [data-bs-theme="dark"] .today-class-item:hover {
            background: #1e293b;
            border-color: #3b82f6;
        }

        /* Spotlight Feature Banner */
        .spotlight-card {
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .spotlight-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 26px -6px rgba(0, 0, 0, 0.08);
        }

        [data-bs-theme="dark"] .spotlight-card {
            background: #1e293b;
            border-color: #334155;
        }

        /* Day selector buttons */
        .day-btn {
            min-width: 65px;
            border: none;
            border-radius: 16px;
            padding: 0.6rem 0.85rem;
            text-align: center;
            background: #f1f5f9;
            color: #64748b;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .day-btn:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        .day-btn.active {
            background: #2563eb !important;
            color: #ffffff !important;
            box-shadow: 0 6px 15px -3px rgba(37, 99, 235, 0.4);
        }

        [data-bs-theme="dark"] .day-btn {
            background: #1e293b;
            color: #94a3b8;
        }

        [data-bs-theme="dark"] .day-btn:hover {
            background: #334155;
            color: #f8fafc;
        }

        /* Pulsing dot */
        .ping-dot {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #ef4444;
        }

        .ping-dot::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: #ef4444;
            animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
        }

        @keyframes ping {
            75%, 100% {
                transform: scale(2.4);
                opacity: 0;
            }
        }

        /* Global Toast */
        .app-toast {
            position: fixed;
            top: 5rem;
            right: 1.5rem;
            z-index: 1090;
            background: #0f172a;
            color: #ffffff;
            font-size: 0.82rem;
            font-weight: 600;
            padding: 0.75rem 1.4rem;
            border-radius: 9999px;
            box-shadow: 0 12px 28px -5px rgba(0, 0, 0, 0.35);
            display: flex;
            align-items: center;
            gap: 0.6rem;
            opacity: 0;
            transform: translateY(-20px);
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        [data-bs-theme="dark"] .app-toast {
            background: #ffffff;
            color: #0f172a;
        }

        .app-toast.show {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        /* Scanner Modal Laser Beam */
        .scan-frame {
            position: relative;
            width: 260px;
            height: 260px;
            border: 2px dashed rgba(59, 130, 246, 0.8);
            border-radius: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: rgba(37, 99, 235, 0.08);
        }

        .scan-beam {
            position: absolute;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, #38bdf8, transparent);
            box-shadow: 0 0 15px #38bdf8;
            animation: scanMove 2.2s ease-in-out infinite alternate;
        }

        @keyframes scanMove {
            0% { top: 10%; }
            100% { top: 90%; }
        }

        /* Bootstrap Modal Customization */
        .modal-content {
            border-radius: 24px;
            border: none;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        [data-bs-theme="dark"] .modal-content {
            background-color: #0f172a;
            color: #ffffff;
            border: 1px solid #1e293b;
        }

        /* Chat bubbles */
        .chat-bubble-me {
            background-color: #2563eb;
            color: #ffffff;
            border-radius: 18px 18px 4px 18px;
            padding: 0.65rem 1rem;
            font-size: 0.85rem;
            max-width: 75%;
        }

        .chat-bubble-them {
            background-color: #f1f5f9;
            color: #1e293b;
            border-radius: 18px 18px 18px 4px;
            padding: 0.65rem 1rem;
            font-size: 0.85rem;
            max-width: 75%;
        }

        [data-bs-theme="dark"] .chat-bubble-them {
            background-color: #1e293b;
            color: #f8fafc;
        }

        /* ================================================================= */
        /* RESPONSIVE OPTIMIZATIONS: DESKTOP, TABLET, MOBILE                 */
        /* ================================================================= */
        html, body {
            overflow-x: hidden;
            width: 100%;
            -webkit-overflow-scrolling: touch;
        }

        /* Responsive typography & layout scaling */
        @media (max-width: 575.98px) {
            /* Mobile View (< 576px) */
            h2, .fs-1 { font-size: 1.5rem !important; }
            h3, .fs-2 { font-size: 1.25rem !important; }
            h4, .fs-3 { font-size: 1.1rem !important; }
            h5, .fs-4 { font-size: 1rem !important; }
            .student-pass-card { padding: 1.15rem !important; border-radius: 20px !important; }
            .tool-card { padding: 0.95rem !important; border-radius: 16px !important; }
            .tool-icon-box { width: 40px !important; height: 40px !important; }
            .campus-hero-banner { padding: 1.5rem !important; border-radius: 20px !important; }
            .modal-dialog { margin: 0.75rem; }
        }

        @media (min-width: 576px) and (max-width: 991.98px) {
            /* Tablet View (576px - 991px) */
            .student-pass-card { padding: 1.35rem !important; }
            .tool-card { padding: 1.1rem !important; }
            .campus-hero-banner { padding: 2rem !important; }
        }

        @media (min-width: 992px) {
            /* Desktop View (>= 992px) */
            .container-xl { max-width: 1240px; }
            .tool-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 16px 30px -8px rgba(37, 99, 235, 0.12);
            }
            .student-pass-sticky {
                position: sticky;
                top: 85px;
                z-index: 10;
            }
        }

        /* Touch target size & accessible buttons */
        @media (max-width: 991.98px) {
            .btn, .tool-filter-pill, .day-btn {
                min-height: 38px;
            }
        }

        /* Padding adjustment for mobile bottom navigation */
        @media (max-width: 767.98px) {
            .app-main-content {
                padding-bottom: 6rem !important;
            }
            .app-toast {
                left: 50%;
                right: auto;
                transform: translateX(-50%) translateY(-20px);
            }
            .app-toast.show {
                transform: translateX(-50%) translateY(0);
            }
        }

        /* Table smooth scroll styling on mobile & tablet */
        .table-responsive {
            -webkit-overflow-scrolling: touch;
            border-radius: 14px;
        }
        .table-responsive::-webkit-scrollbar {
            height: 6px;
        }
        .table-responsive::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.35);
            border-radius: 4px;
        }

        /* ==========================================================================
           ULTRA CLEAN ENTERPRISE SPLIT AUTH EXPERIENCE
           ========================================================================== */
        .guest-app-wrapper {
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            flex-direction: column;
            background: #ffffff;
            position: relative;
            overflow-x: hidden;
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
        }

        [data-bs-theme="dark"] .guest-app-wrapper {
            background: #090d16;
        }

        .auth-split-wrapper {
            display: flex;
            min-height: 100vh;
            min-height: 100dvh;
            width: 100%;
        }

        /* ---------------- Left Showcase Panel (Desktop >= 992px) ---------------- */
        .auth-showcase-panel {
            flex: 1 1 50%;
            background: linear-gradient(145deg, #090d16 0%, #0f172a 45%, #1e1b4b 100%);
            position: relative;
            overflow: hidden;
            color: #ffffff;
            padding: 3.5rem 3.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .auth-showcase-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
            background-size: 24px 24px;
            pointer-events: none;
            opacity: 0.6;
        }
        .showcase-glow-orb-1 {
            position: absolute;
            width: 500px;
            height: 500px;
            top: -120px;
            left: -80px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.28) 0%, rgba(139, 92, 246, 0.12) 50%, transparent 70%);
            filter: blur(70px);
            pointer-events: none;
        }
        .showcase-glow-orb-2 {
            position: absolute;
            width: 440px;
            height: 440px;
            bottom: -60px;
            right: -60px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.25) 0%, rgba(6, 182, 212, 0.1) 60%, transparent 70%);
            filter: blur(65px);
            pointer-events: none;
        }

        .showcase-brand-logo-box {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.95);
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
        }
        .showcase-brand-logo-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .showcase-feature-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 16px;
            padding: 1.15rem 1.25rem;
            transition: all 0.25s ease;
        }
        .showcase-feature-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        .feature-icon-badge {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* ---------------- Right Form Panel ---------------- */
        .auth-form-panel {
            flex: 1 1 50%;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2.5rem 3rem;
            position: relative;
            overflow-y: auto;
        }
        [data-bs-theme="dark"] .auth-form-panel {
            background: #090d16;
        }

        .auth-form-container {
            width: 100%;
            max-width: 420px;
            margin: auto;
            padding: 1rem 0;
        }

        .clean-field-group {
            margin-bottom: 1.15rem;
        }
        .clean-field-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #475569;
            margin-bottom: 0.35rem;
            letter-spacing: 0.02em;
        }
        [data-bs-theme="dark"] .clean-field-label {
            color: #94a3b8;
        }

        .clean-input-box {
            display: flex;
            align-items: center;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 0 0.85rem;
            height: 46px;
            transition: all 0.2s ease;
        }
        [data-bs-theme="dark"] .clean-input-box {
            background: #101726;
            border-color: #1e293b;
        }
        .clean-input-box:focus-within {
            background: #ffffff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3.5px rgba(59, 130, 246, 0.12);
        }
        [data-bs-theme="dark"] .clean-input-box:focus-within {
            background: #131b2e;
            border-color: #60a5fa;
            box-shadow: 0 0 0 3.5px rgba(96, 165, 250, 0.16);
        }
        .clean-input-box input, .clean-input-box select {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
            font-size: 13.5px;
            color: inherit;
            padding-left: 0.5rem;
        }
        .clean-input-box input::placeholder {
            color: #94a3b8;
            font-size: 13px;
        }
        .clean-input-icon {
            color: #64748b;
            flex-shrink: 0;
            display: flex;
            align-items: center;
        }
        [data-bs-theme="dark"] .clean-input-icon {
            color: #94a3b8;
        }

        .btn-submit-campus {
            background: linear-gradient(135deg, #2563eb 0%, #4f46e5 50%, #7c3aed 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            height: 46px;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.35);
            transition: all 0.25s ease;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-submit-campus:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 24px -5px rgba(37, 99, 235, 0.45);
            color: #ffffff;
        }

        /* 1-Click Fast Demo Cards */
        .demo-chip-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.65rem 0.85rem;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            width: 100%;
        }
        .demo-chip-card:hover {
            background: #ffffff;
            border-color: #3b82f6;
            transform: translateY(-1.5px);
            box-shadow: 0 8px 16px -4px rgba(37, 99, 235, 0.12);
        }
        [data-bs-theme="dark"] .demo-chip-card {
            background: #101726;
            border-color: #1e293b;
        }
        [data-bs-theme="dark"] .demo-chip-card:hover {
            background: #162035;
            border-color: #60a5fa;
        }
        .demo-chip-avatar {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 12px;
            color: #ffffff;
            flex-shrink: 0;
        }

        /* ---------------- Tablet Responsive Adjustments (576px - 991.98px) ---------------- */
        .tablet-brand-banner {
            display: none;
        }
        @media (min-width: 576px) and (max-width: 991.98px) {
            .auth-showcase-panel {
                display: none;
            }
            .auth-form-panel {
                flex: 1 1 100%;
                padding: 2.5rem 2rem;
                justify-content: center;
                align-items: center;
            }
            .tablet-brand-banner {
                display: block;
                max-width: 480px;
                width: 100%;
                margin: 0 auto 1.5rem auto;
                background: linear-gradient(135deg, rgba(37, 99, 235, 0.08) 0%, rgba(79, 70, 229, 0.05) 100%);
                border: 1px solid rgba(37, 99, 235, 0.15);
                border-radius: 16px;
                padding: 1rem 1.25rem;
                text-align: center;
            }
            [data-bs-theme="dark"] .tablet-brand-banner {
                background: linear-gradient(135deg, rgba(37, 99, 235, 0.15) 0%, rgba(30, 41, 59, 0.5) 100%);
                border-color: rgba(96, 165, 250, 0.2);
            }
            .auth-form-container {
                max-width: 460px;
            }
        }

        /* ---------------- Mobile Responsive Adjustments (< 576px) ---------------- */
        @media (max-width: 575.98px) {
            .auth-showcase-panel {
                display: none;
            }
            .auth-form-panel {
                flex: 1 1 100%;
                padding: 1.5rem 1.15rem;
                padding-bottom: max(1.5rem, env(safe-area-inset-bottom));
                justify-content: space-between;
            }
            .auth-form-container {
                max-width: 100%;
                padding: 0.5rem 0;
            }
            /* Prevent iOS Safari input auto-zoom */
            .clean-input-box input, .clean-input-box select {
                font-size: 16px !important;
            }
            .clean-input-box {
                height: 48px;
            }
            .btn-submit-campus {
                height: 48px;
                font-size: 15px;
            }
            .demo-chip-card {
                padding: 0.6rem 0.65rem;
            }
        }

        /* Clean Brand Badge */
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

        /* Clean Form Inputs */
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

        .clean-input-group .form-control {
            border: none;
            background: transparent;
            font-size: 13.5px;
            box-shadow: none !important;
        }

        .clean-input-group .input-group-text {
            border: none;
            background: transparent;
        }

        /* Quick Demo Chips */
        .quick-chip {
            background: rgba(248, 250, 252, 0.9);
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            cursor: pointer;
            text-align: left;
        }

        .quick-chip:hover {
            transform: translateY(-1.5px);
            border-color: #3b82f6;
            background: rgba(59, 130, 246, 0.05);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
        }

        [data-bs-theme="dark"] .quick-chip {
            background: rgba(30, 41, 59, 0.5);
            border-color: #334155;
        }

        [data-bs-theme="dark"] .quick-chip:hover {
            background: rgba(30, 41, 59, 0.9);
            border-color: #60a5fa;
        }

        .quick-chip-avatar {
            width: 28px;
            height: 28px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
            flex-shrink: 0;
        }

        /* Splash Screen */
        .mobile-splash-screen {
            position: absolute;
            inset: 0;
            background: linear-gradient(150deg, #0b0f19 0%, #1e1b4b 55%, #020617 100%);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 1060;
            padding: 2rem;
            cursor: pointer;
            transition: opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1), transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mobile-splash-screen.splash-exit {
            opacity: 0;
            transform: scale(1.08);
            pointer-events: none;
        }

        .splash-logo-wrapper {
            position: relative;
            width: 115px;
            height: 115px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .splash-glow-ring {
            position: absolute;
            inset: -12px;
            border-radius: 36px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.7), rgba(217, 70, 239, 0.7));
            filter: blur(20px);
            animation: splashPulse 2.5s infinite ease-in-out;
        }

        @keyframes splashPulse {
            0%, 100% { transform: scale(0.92); opacity: 0.6; }
            50% { transform: scale(1.08); opacity: 0.95; }
        }

        .splash-app-logo {
            position: relative;
            width: 95px;
            height: 95px;
            border-radius: 26px;
            object-fit: contain;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            background: #ffffff;
            padding: 8px;
            z-index: 2;
            animation: logoFloat 3s infinite ease-in-out;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .splash-progress-track {
            width: 150px;
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            overflow: hidden;
            margin: 1.25rem auto 0;
        }

        .splash-progress-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #3b82f6, #a855f7, #ec4899);
            border-radius: 10px;
            animation: progressFill 1.8s cubic-bezier(0.65, 0, 0.35, 1) forwards;
        }

        @keyframes progressFill {
            0% { width: 0%; }
            40% { width: 50%; }
            80% { width: 85%; }
            100% { width: 100%; }
        }

        /* Login Screen Inside Mobile App */
        .mobile-login-screen {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 0.85rem 1.4rem 1.5rem;
            opacity: 0;
            transform: translateY(18px);
            transition: opacity 0.45s cubic-bezier(0.4, 0, 0.2, 1), transform 0.45s cubic-bezier(0.4, 0, 0.2, 1);
            -webkit-overflow-scrolling: touch;
        }

        .mobile-login-screen.login-active {
            opacity: 1;
            transform: translateY(0);
        }

        .mobile-login-screen::-webkit-scrollbar {
            width: 4px;
        }
        .mobile-login-screen::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.3);
            border-radius: 4px;
        }

        .mobile-brand-icon-box {
            width: 64px;
            height: 64px;
            border-radius: 20px;
            background: #ffffff;
            padding: 6px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        [data-bs-theme="dark"] .mobile-brand-icon-box {
            background: #1e293b;
            border-color: #334155;
        }

        .mobile-brand-icon {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 14px;
        }

        .mobile-icon-btn {
            background: rgba(148, 163, 184, 0.15);
            border: none;
            color: inherit;
        }
    </style>
</head>
<body>
    <!-- Top Responsive Header Navigation Bar (Visible only when logged in) -->
    @auth
    <nav class="main-navbar py-2 py-md-3">
        <div class="container-xl d-flex justify-content-between align-items-center">
            <!-- Brand Logo & Title -->
            <a href="{{ url('/') }}" class="d-flex align-items-center gap-2 gap-md-2.5 text-decoration-none text-body">
                <img src="{{ asset('images/genz-logo.png') }}" alt="GenZ Digital Logo" class="rounded-3 shadow-xs" style="width: 38px; height: 38px; object-fit: contain;">
                <div>
                    <div class="d-flex align-items-baseline lh-1">
                        <span class="gz-title-gradient fs-4 fw-bold">GenZ</span>
                        <span class="fs-4 fw-bolder ms-1">Digital</span>
                    </div>
                    <small class="text-secondary text-uppercase fw-bold" style="font-size: 9.5px; letter-spacing: 0.12em;">Campus OS v26.0</small>
                </div>
            </a>

            <!-- Desktop / Tablet Navigation Links (Hidden on small mobile) -->
            <div class="d-none d-md-flex align-items-center gap-1 p-1 rounded-3" style="background: rgba(148, 163, 184, 0.1);">
                <button class="desktop-nav-link active" data-tab="home" onclick="switchTab('home')">
                    <i data-lucide="home" style="width: 17px; height: 17px;"></i>
                    <span>Home</span>
                </button>
                <button class="desktop-nav-link" data-tab="schedule" onclick="switchTab('schedule')">
                    <i data-lucide="calendar" style="width: 17px; height: 17px;"></i>
                    <span>Schedule</span>
                </button>
                <button class="desktop-nav-link" data-tab="resource" onclick="switchTab('resource')">
                    <i data-lucide="folder-down" style="width: 17px; height: 17px;"></i>
                    <span>Resources</span>
                </button>
                <button class="desktop-nav-link position-relative" data-tab="inbox" onclick="switchTab('inbox')">
                    <i data-lucide="message-square" style="width: 17px; height: 17px;"></i>
                    <span>Inbox</span>
                    <span class="badge rounded-pill bg-danger ms-1" style="font-size: 9px; padding: 2px 6px;">3</span>
                </button>
                <button class="desktop-nav-link" data-tab="profile" onclick="switchTab('profile')">
                    <i data-lucide="user" style="width: 17px; height: 17px;"></i>
                    <span>Profile</span>
                </button>
            </div>

            <!-- Right Actions: Admin Switcher, Auth Buttons / Avatar, Theme Toggle, Notifications -->
            <div class="d-flex align-items-center gap-2">
                @if(Auth::user()->role === 'admin')
                    <!-- Direct Switch to Admin Portal -->
                    <a href="{{ route('admin.index') }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-1.5 rounded-pill px-2.5 px-md-3 py-1 fw-bold text-decoration-none shadow-sm" title="Go to Admin Management">
                        <i data-lucide="shield-check" style="width: 16px; height: 16px;"></i>
                        <span class="d-none d-sm-inline">Admin Portal</span>
                    </a>
                @endif

                <!-- Dark Mode Toggle Button -->
                <button class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center p-2" id="theme-toggle-btn" title="Toggle Theme" style="width: 38px; height: 38px; background: rgba(148, 163, 184, 0.15);">
                    <i id="theme-icon" data-lucide="moon" style="width: 18px; height: 18px;"></i>
                </button>

                <!-- Notifications Bell Button -->
                <button class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center p-2 position-relative" onclick="showToast('Notification center cleared')" style="width: 38px; height: 38px; background: rgba(148, 163, 184, 0.15);">
                    <i data-lucide="bell" style="width: 18px; height: 18px;"></i>
                    <span class="ping-dot"></span>
                </button>

                <!-- Authenticated User Profile & Logout Dropdown -->
                <div class="d-flex align-items-center gap-2 ms-2 ps-2 border-start">
                    <div class="cursor-pointer d-flex align-items-center gap-2" onclick="switchTab('profile')">
                        <img src="{{ Auth::user()->avatar ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=250' }}" alt="{{ Auth::user()->name }}" class="user-avatar-element rounded-circle object-fit-cover shadow-sm" style="width: 34px; height: 34px; border: 2px solid #2563eb;">
                        <div class="d-none d-lg-block text-start lh-sm">
                            <span class="fw-bold fs-7 d-inline-flex align-items-center gap-1">
                                <span>{{ Auth::user()->name }}</span>
                                @include('partials.verified-badge', ['size' => 13, 'border' => false])
                            </span>
                            <small class="badge {{ Auth::user()->role === 'admin' ? 'bg-danger' : 'bg-primary-subtle text-primary' }}" style="font-size: 9px;">
                                {{ strtoupper(Auth::user()->role) }}
                            </small>
                        </div>
                    </div>

                    <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-danger rounded-circle p-1 d-flex align-items-center justify-content-center" title="Log Out" style="width: 32px; height: 32px;">
                        <i data-lucide="log-out" style="width: 14px; height: 14px;"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    @endauth

    <!-- Global Floating Toast Notification -->
    <div id="app-toast" class="app-toast">
        <i data-lucide="sparkles" style="width: 16px; height: 16px; color: #fbbf24;"></i>
        <span id="toast-message">Notification message</span>
    </div>

    <!-- Main Responsive Body Content -->
    <main class="app-main-content @auth py-3 py-md-4 @else p-0 guest-app-wrapper @endauth">
        <div class="@auth container-xl @else w-100 p-0 @endauth">
            @yield('content')
        </div>
    </main>

    <!-- Mobile Bottom Navigation Bar (< 768px - Visible only when logged in) -->
    @auth
    <div class="mobile-bottom-nav d-md-none">
        <div class="d-flex justify-content-around align-items-center">
            <button class="mobile-tab-btn active" data-tab="home" onclick="switchTab('home')">
                <i data-lucide="home" style="width: 20px; height: 20px;"></i>
                <span>Home</span>
                <div class="mobile-tab-dot"></div>
            </button>

            <button class="mobile-tab-btn" data-tab="schedule" onclick="switchTab('schedule')">
                <i data-lucide="calendar" style="width: 20px; height: 20px;"></i>
                <span>Schedule</span>
                <div class="mobile-tab-dot"></div>
            </button>

            <button class="mobile-tab-btn" data-tab="resource" onclick="switchTab('resource')">
                <i data-lucide="folder-down" style="width: 20px; height: 20px;"></i>
                <span>Resources</span>
                <div class="mobile-tab-dot"></div>
            </button>

            <button class="mobile-tab-btn position-relative" data-tab="inbox" onclick="switchTab('inbox')">
                <i data-lucide="message-square" style="width: 20px; height: 20px;"></i>
                <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-danger" style="font-size: 8px; padding: 2px 4px; margin-top: -2px; margin-right: -4px;">
                    3
                </span>
                <span>Inbox</span>
                <div class="mobile-tab-dot"></div>
            </button>

            <button class="mobile-tab-btn" data-tab="profile" onclick="switchTab('profile')">
                <i data-lucide="user" style="width: 20px; height: 20px;"></i>
                <span>Profile</span>
                <div class="mobile-tab-dot"></div>
            </button>
        </div>
    </div>
    @endauth

    <!-- Bootstrap 5.3.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Cropper.js Bundle (For Avatar Upload & Crop) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

    <!-- HTML5 QR Code Scanner CDN -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <!-- Canvas Confetti CDN -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>

    <!-- Global App JavaScript -->
    <script>
        // Initialize Lucide Icons
        function renderIcons() {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        }
        document.addEventListener('DOMContentLoaded', renderIcons);

        // Theme Toggle (Light / Dark Mode) with localStorage persistence
        const htmlElement = document.documentElement;

        function setTheme(theme) {
            htmlElement.setAttribute('data-bs-theme', theme);
            localStorage.setItem('genz_theme', theme);
            const themeToggleBtn = document.getElementById('theme-toggle-btn');
            const themeIcon = document.getElementById('theme-icon');
            if (themeIcon) {
                if (theme === 'dark') {
                    themeIcon.setAttribute('data-lucide', 'sun');
                    if (themeToggleBtn) themeToggleBtn.classList.add('text-warning');
                } else {
                    themeIcon.setAttribute('data-lucide', 'moon');
                    if (themeToggleBtn) themeToggleBtn.classList.remove('text-warning');
                }
            }
            const mobileAppThemeIcon = document.getElementById('mobile-app-theme-icon');
            if (mobileAppThemeIcon) {
                mobileAppThemeIcon.setAttribute('data-lucide', theme === 'dark' ? 'sun' : 'moon');
            }
            renderIcons();
        }

        const savedTheme = localStorage.getItem('genz_theme') || 'light';
        setTheme(savedTheme);

        const themeToggleBtn = document.getElementById('theme-toggle-btn');
        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', () => {
                const currentTheme = htmlElement.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                setTheme(newTheme);
            });
        }

        function toggleAppTheme() {
            const currentTheme = htmlElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setTheme(newTheme);
        }

        // Mobile Status Bar Live Clock
        function updateMobileClock() {
            const clockEl = document.getElementById('mobile-clock');
            if (clockEl) {
                const now = new Date();
                let hours = now.getHours();
                let minutes = now.getMinutes();
                minutes = minutes < 10 ? '0' + minutes : minutes;
                clockEl.textContent = `${hours}:${minutes}`;
            }
        }
        setInterval(updateMobileClock, 1000);
        updateMobileClock();

        // Flash / Splash Screen Controller
        function skipSplash() {
            const splash = document.getElementById('app-splash-screen');
            const login = document.getElementById('app-login-screen');
            if (!splash || !login) return;
            splash.classList.add('splash-exit');
            login.classList.add('login-active');
            setTimeout(() => {
                splash.style.display = 'none';
            }, 550);
        }

        function replaySplash() {
            const splash = document.getElementById('app-splash-screen');
            const login = document.getElementById('app-login-screen');
            if (!splash || !login) return;
            splash.style.display = 'flex';
            splash.classList.remove('splash-exit');
            login.classList.remove('login-active');
            
            const progressFill = splash.querySelector('.splash-progress-fill');
            if (progressFill) {
                progressFill.style.animation = 'none';
                void progressFill.offsetWidth;
                progressFill.style.animation = 'progressFill 1.8s cubic-bezier(0.65, 0, 0.35, 1) forwards';
            }

            setTimeout(() => {
                skipSplash();
            }, 1850);
        }

        // Auto transition splash screen on initial page load
        document.addEventListener('DOMContentLoaded', () => {
            const splash = document.getElementById('app-splash-screen');
            if (splash) {
                setTimeout(() => {
                    skipSplash();
                }, 1850);
            }
        });

        // Mobile Login Helpers
        function togglePasswordVisibility() {
            const passInput = document.getElementById('guest-login-password');
            const passIcon = document.getElementById('pass-toggle-icon');
            if (!passInput || !passIcon) return;
            if (passInput.type === 'password') {
                passInput.type = 'text';
                passIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                passInput.type = 'password';
                passIcon.setAttribute('data-lucide', 'eye');
            }
            renderIcons();
        }

        function quickLogin(email, password) {
            const emailField = document.getElementById('guest-login-email');
            const passField = document.getElementById('guest-login-password');
            const form = document.getElementById('guest-login-form');
            if (emailField && passField && form) {
                emailField.value = email;
                passField.value = password;
                form.submit();
            }
        }

        // Tab & Page Switching (Synchronized with Desktop Header, Mobile Bottom Bar & URL Hash)
        function switchTab(tabId, pushHistory = true) {
            // Hide all sections, show target section
            document.querySelectorAll('.screen-section').forEach(sec => sec.classList.add('d-none'));
            const target = document.getElementById('screen-' + tabId);
            if (target) {
                target.classList.remove('d-none');
            } else {
                // Fallback to home if target not found
                const home = document.getElementById('screen-home');
                if (home) home.classList.remove('d-none');
                tabId = 'home';
            }

            // Sync Desktop Nav links
            document.querySelectorAll('.desktop-nav-link').forEach(btn => {
                if (btn.getAttribute('data-tab') === tabId) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            // Sync Mobile Nav links
            document.querySelectorAll('.mobile-tab-btn').forEach(btn => {
                if (btn.getAttribute('data-tab') === tabId) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            // Update URL hash without reload
            if (pushHistory && window.history && window.history.replaceState) {
                window.history.replaceState(null, '', '#' + tabId);
            }

            // Scroll to top of content smoothly
            window.scrollTo({ top: 0, behavior: 'smooth' });
            renderIcons();
        }

        // Support direct linking via hash e.g. /#classCart
        window.addEventListener('DOMContentLoaded', () => {
            const hash = window.location.hash.replace('#', '');
            if (hash && document.getElementById('screen-' + hash)) {
                switchTab(hash, false);
            }
        });

        window.addEventListener('hashchange', () => {
            const hash = window.location.hash.replace('#', '');
            if (hash && document.getElementById('screen-' + hash)) {
                switchTab(hash, false);
            }
        });

        // Global Toast Notification Helper
        let toastTimeout = null;
        function showToast(message) {
            const toastEl = document.getElementById('app-toast');
            const messageEl = document.getElementById('toast-message');
            if (!toastEl || !messageEl) return;

            messageEl.textContent = message;
            toastEl.classList.add('show');

            if (toastTimeout) clearTimeout(toastTimeout);
            toastTimeout = setTimeout(() => {
                toastEl.classList.remove('show');
            }, 3000);
            renderIcons();
        }

        // Helper to open Bootstrap Modals
        function openModal(modalId) {
            const modalEl = document.getElementById(modalId);
            if (modalEl) {
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
                renderIcons();
            }
        }
    </script>

    @stack('scripts')
</body>
</html>
