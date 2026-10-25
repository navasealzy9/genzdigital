<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $resource->title }} - GenZ Digital Resource Reader</title>
    <link rel="icon" type="image/png" href="{{ asset('images/genz-logo.png') }}">

    <!-- Google Fonts: Google Sans & Khmer Sans (Kantumruy Pro, Noto Sans Khmer) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&family=Noto+Sans+Khmer:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/google-sans" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --app-font: 'Google Sans', 'Kantumruy Pro', 'Noto Sans Khmer', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            --gz-gradient: linear-gradient(135deg, #2563eb, #6366f1, #d946ef);
        }
        body {
            font-family: var(--app-font);
            background-color: #0b0f19;
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .reader-navbar {
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        .reader-viewport {
            max-width: 900px;
            margin: 2rem auto;
            background: #ffffff;
            color: #0f172a;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
            min-height: 980px;
            padding: 3.5rem;
            position: relative;
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

    <!-- Top Reader Navigation Bar -->
    <nav class="reader-navbar py-2.5 px-3 px-md-4">
        <div class="container-fluid d-flex flex-wrap justify-content-between align-items-center gap-2">
            <!-- Brand & File Info -->
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('campus.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3 py-1.5 fw-bold d-inline-flex align-items-center gap-1.5">
                    <i data-lucide="arrow-left" style="width: 15px; height: 15px;"></i>
                    <span class="d-none d-sm-inline">ត្រឡប់ទៅ Student Portal</span>
                </a>
                <div class="d-flex align-items-center gap-2 border-start border-secondary border-opacity-50 ps-3">
                    <img src="{{ asset('images/genz-logo.png') }}" alt="Logo" class="rounded-2" style="width: 28px; height: 28px; object-fit: contain;">
                    <div>
                        <h6 class="fw-bold mb-0 text-white fs-6 text-truncate" style="max-width: 320px;">{{ $resource->title }}</h6>
                        <small class="text-white-50" style="font-size: 11px;">{{ $resource->class_code ?: $resource->course }} • {{ $resource->file_name }}</small>
                    </div>
                </div>
            </div>

            <!-- Action Controls: Share Link & Download PDF -->
            <div class="d-flex align-items-center gap-2">
                <!-- Copy Link Share Button -->
                <button class="btn btn-outline-info rounded-pill px-3 py-1.5 fw-bold d-inline-flex align-items-center gap-1.5 shadow-sm" onclick="copyShareableLink()">
                    <i data-lucide="share-2" style="width: 15px; height: 15px;"></i>
                    <span>Copy Link Share (ចម្លង Link)</span>
                </button>

                <!-- Download PDF Button -->
                <a href="{{ route('campus.resource.download', $resource->id) }}" class="btn btn-primary rounded-pill px-3 py-1.5 fw-bold d-inline-flex align-items-center gap-1.5 shadow-sm">
                    <i data-lucide="download" style="width: 15px; height: 15px;"></i>
                    <span>Download PDF</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Reading Body Viewport -->
    <div class="container-fluid flex-grow-1 py-4">
        <!-- Floating Reading Toolbar -->
        <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
            <div class="bg-dark bg-opacity-75 p-2 px-3 rounded-pill border border-secondary border-opacity-25 d-flex align-items-center gap-3 shadow">
                <button class="btn btn-sm btn-outline-light rounded-circle p-1" onclick="prevPage()" title="Previous Page">
                    <i data-lucide="chevron-left" style="width: 16px; height: 16px;"></i>
                </button>
                <span class="small fw-bold text-white-50">
                    Page <span class="text-white" id="current-page-num">1</span> of 12
                </span>
                <button class="btn btn-sm btn-outline-light rounded-circle p-1" onclick="nextPage()" title="Next Page">
                    <i data-lucide="chevron-right" style="width: 16px; height: 16px;"></i>
                </button>
                <span class="text-secondary">|</span>
                <span class="badge bg-success-subtle text-success fw-bold">✓ Official Verified</span>
                <span class="badge bg-primary-subtle text-primary font-monospace">{{ $resource->file_size }}</span>
            </div>
        </div>

        <!-- Rendered Document Viewport -->
        <div class="reader-viewport">
            <!-- Header Section of Document -->
            <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ asset('images/genz-logo.png') }}" alt="Logo" style="width: 44px; height: 44px; object-fit: contain;">
                    <div>
                        <h4 class="fw-bolder mb-0 text-dark">GenZ Digital Campus OS</h4>
                        <small class="text-secondary text-uppercase fw-bold" style="font-size: 11px;">Academic Learning Resource & Lecture Material</small>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge bg-primary px-3 py-1.5 fs-7">{{ $resource->class_code ?: $resource->course }}</span>
                    <small class="text-secondary d-block mt-1">Uploaded by Faculty</small>
                </div>
            </div>

            <!-- Document Title -->
            <div class="mb-4">
                <span class="badge bg-secondary-subtle text-secondary mb-2">COURSE LECTURE NOTES & SYLLABUS</span>
                <h2 class="fw-bolder mb-2 text-dark">{{ $resource->title }}</h2>
                <div class="d-flex gap-3 text-secondary small">
                    <span><i data-lucide="file" class="d-inline-block me-1" style="width: 13px; height: 13px;"></i>{{ $resource->file_name }}</span>
                    <span>•</span>
                    <span><i data-lucide="hard-drive" class="d-inline-block me-1" style="width: 13px; height: 13px;"></i>{{ $resource->file_size }}</span>
                    <span>•</span>
                    <span><i data-lucide="eye" class="d-inline-block me-1" style="width: 13px; height: 13px;"></i>{{ $resource->download_count }} Reads</span>
                </div>
            </div>

            <!-- Document Content Preview -->
            <div class="py-3" style="line-height: 1.8; color: #334155;">
                <h5 class="fw-bold text-primary mb-3">1. Executive Overview & Learning Objectives</h5>
                <p>
                    Welcome to <strong>{{ $resource->title }}</strong>. This course document provides the full structural overview, lecture guidelines, laboratory practicals, and assessment criteria approved by the GenZ Digital Innovation Curriculum Board.
                </p>
                <div class="p-3.5 rounded-3 bg-light border-start border-4 border-primary my-4">
                    <h6 class="fw-bold mb-1">Key Competency Goals:</h6>
                    <ul class="mb-0 ps-3">
                        <li>Master modern design token architecture and atomic design patterns.</li>
                        <li>Implement responsive, accessible UI standards compliant with WCAG 2.2 Level AA.</li>
                        <li>Integrate component systems with production codebases seamlessly.</li>
                        <li>Collaborate using real-time version control and sprint review boards.</li>
                    </ul>
                </div>

                <h5 class="fw-bold text-primary mb-3">2. Course Syllabus & Project Milestones</h5>
                <p>
                    Students are expected to complete the assigned weekly sprints and submit laboratory exercises before the mid-term assessment. Full access to lecture recordings and supplementary assets is provided in the GenZ Student Portal.
                </p>
                <div class="table-responsive my-3">
                    <table class="table table-bordered table-sm small">
                        <thead class="table-light">
                            <tr>
                                <th>Week</th>
                                <th>Module Topic</th>
                                <th>Deliverable</th>
                                <th>Weight</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Week 1-4</td>
                                <td>Foundation & Token Architecture</td>
                                <td>Style Guide Prototype</td>
                                <td>20%</td>
                            </tr>
                            <tr>
                                <td>Week 5-8</td>
                                <td>Interactive Component Systems</td>
                                <td>Responsive UI Kit</td>
                                <td>30%</td>
                            </tr>
                            <tr>
                                <td>Week 9-12</td>
                                <td>Final QCM Assessment & Live Challenge</td>
                                <td>Capstone System Project</td>
                                <td>50%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-5 p-4 rounded-4 bg-light text-center border">
                    <i data-lucide="shield-check" class="text-success mb-2" style="width: 36px; height: 36px;"></i>
                    <h6 class="fw-bold mb-1">Official GenZ Digital Academic Resource</h6>
                    <small class="text-secondary d-block mb-3">This document is certified for enrolled students of Class {{ $resource->class_code ?: $resource->course }}.</small>
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold" onclick="copyShareableLink()">
                            <i data-lucide="share-2" style="width: 14px; height: 14px;" class="me-1"></i> Copy Link Share
                        </button>
                        <a href="{{ route('campus.resource.download', $resource->id) }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold">
                            <i data-lucide="download" style="width: 14px; height: 14px;" class="me-1"></i> Download File
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Copy Toast -->
    <div id="copyToast" class="copy-toast alert alert-success py-2.5 px-4 rounded-pill shadow-lg d-flex align-items-center gap-2 fw-bold">
        <i data-lucide="check-circle" style="width: 18px; height: 18px;" class="text-success"></i>
        <span>បានចម្លងតំណភ្ជាប់ចែករំលែកដោយជោគជ័យ! (Share Link Copied to Clipboard!)</span>
    </div>

    <script>
        lucide.createIcons();

        let currentPage = 1;
        const totalPages = 12;

        function nextPage() {
            if (currentPage < totalPages) {
                currentPage++;
                document.getElementById('current-page-num').textContent = currentPage;
            }
        }

        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                document.getElementById('current-page-num').textContent = currentPage;
            }
        }

        function copyShareableLink() {
            const url = window.location.href;
            if (navigator.clipboard) {
                navigator.clipboard.writeText(url).then(() => {
                    showCopyToast();
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
            showCopyToast();
        }

        function showCopyToast() {
            const toast = document.getElementById('copyToast');
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }
    </script>
</body>
</html>
