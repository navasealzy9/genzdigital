<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="utf-8">
    <title>Attendance Report - GenZ Digital Campus OS</title>
    <!-- Google Fonts: Google Sans & Khmer Sans (Kantumruy Pro, Noto Sans Khmer) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&family=Noto+Sans+Khmer:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/google-sans" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Google Sans', 'Kantumruy Pro', 'Noto Sans Khmer', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #ffffff;
            color: #0f172a;
            padding: 2.5rem;
        }

        .report-header {
            border-bottom: 2px solid #0f172a;
            padding-bottom: 1.5rem;
            margin-bottom: 2rem;
        }

        .badge-present {
            background-color: #dcfce7;
            color: #15803d;
            font-weight: 700;
            padding: 0.25rem 0.6rem;
            border-radius: 6px;
        }

        .badge-late {
            background-color: #fef9c3;
            color: #a16207;
            font-weight: 700;
            padding: 0.25rem 0.6rem;
            border-radius: 6px;
        }

        .badge-absent {
            background-color: #fee2e2;
            color: #b91c1c;
            font-weight: 700;
            padding: 0.25rem 0.6rem;
            border-radius: 6px;
        }

        @media print {
            body { padding: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <a href="{{ route('admin.index', ['tab' => 'attendance']) }}" class="btn btn-outline-secondary btn-sm">
            &larr; Back to Admin Portal
        </a>
        <div class="d-flex gap-2">
            <button class="btn btn-primary btn-sm fw-bold px-4" onclick="window.print()">
                <i class="bi bi-printer me-1"></i> Print / Save as PDF
            </button>
        </div>
    </div>

    <!-- Official Report Header -->
    <div class="report-header">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h3 class="fw-bolder mb-1">GENZ DIGITAL CAMPUS OS</h3>
                <h5 class="fw-bold text-secondary mb-0">OFFICIAL CLASSROOM ATTENDANCE ROSTER (របាយការណ៍វត្តមានសិស្ស)</h5>
            </div>
            <div class="text-end">
                <span class="badge bg-dark text-white px-3 py-2 fs-6">CLASS: {{ $classCode }}</span>
                <div class="small text-secondary mt-1">Date: {{ $date }}</div>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="row g-3 mb-4">
        <div class="col-3">
            <div class="p-3 border rounded-3 bg-light">
                <small class="text-secondary d-block fw-bold">TOTAL LOGS</small>
                <h4 class="fw-bold mb-0">{{ $attendances->count() }}</h4>
            </div>
        </div>
        <div class="col-3">
            <div class="p-3 border rounded-3 bg-light">
                <small class="text-success d-block fw-bold">PRESENT</small>
                <h4 class="fw-bold mb-0 text-success">{{ $attendances->where('status', 'Present')->count() }}</h4>
            </div>
        </div>
        <div class="col-3">
            <div class="p-3 border rounded-3 bg-light">
                <small class="text-warning d-block fw-bold">LATE</small>
                <h4 class="fw-bold mb-0 text-warning">{{ $attendances->where('status', 'Late')->count() }}</h4>
            </div>
        </div>
        <div class="col-3">
            <div class="p-3 border rounded-3 bg-light">
                <small class="text-danger d-block fw-bold">ABSENT</small>
                <h4 class="fw-bold mb-0 text-danger">{{ $attendances->where('status', 'Absent')->count() }}</h4>
            </div>
        </div>
    </div>

    <!-- Attendance Table -->
    <table class="table table-bordered align-middle mb-5">
        <thead class="table-light">
            <tr>
                <th style="width: 50px;">#</th>
                <th>Student Full Name (ឈ្មោះសិស្ស)</th>
                <th>Student ID</th>
                <th>Class / Course</th>
                <th>Check-in Time</th>
                <th>Status (ស្ថានភាព)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $idx => $att)
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td class="fw-bold">{{ $att->student_name }}</td>
                    <td><code>{{ $att->student_id }}</code></td>
                    <td>{{ $att->subject }} ({{ $att->code }})</td>
                    <td>{{ $att->check_in_time }}</td>
                    <td>
                        <span class="{{ $att->status === 'Present' ? 'badge-present' : ($att->status === 'Late' ? 'badge-late' : 'badge-absent') }}">
                            {{ $att->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-secondary">No attendance records found for this class.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Signature Section -->
    <div class="d-flex justify-content-between align-items-end pt-5 mt-5">
        <div class="text-center" style="width: 250px;">
            <div style="border-bottom: 1px solid #000; height: 60px;"></div>
            <small class="fw-bold d-block mt-2">Class Representative Signature</small>
        </div>
        <div class="text-center" style="width: 250px;">
            <div style="border-bottom: 1px solid #000; height: 60px;"></div>
            <small class="fw-bold d-block mt-2">Course Instructor / Professor</small>
        </div>
    </div>

</body>
</html>
