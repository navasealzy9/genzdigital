@extends('learning.layout')
@section('title', 'My learning')
@section('content')
<div class="panel" style="display:flex;align-items:center;justify-content:space-between;gap:18px;flex-wrap:wrap;border-color:#c8d7f8;background:#edf3ff"><div><strong>GEN5 · ប្រកួតសង់ទីក្រុង</strong><p class="hint" style="margin:5px 0 0">ចូលក្រុម សង់អគារ និងឆ្លងព្រំដែនទៅប្រកួតជាមួយក្រុមម្ខាងទៀត។</p></div><a class="button" href="{{ route('gen5.index') }}">ចូល GEN5 →</a></div>
<div class="hero"><span class="eyebrow">LEARN AT YOUR OWN PACE</span><h1>បន្តការសិក្សារបស់អ្នក</h1><p>Explore your courses, study each lesson, practice with assignments, and check your understanding with quizzes.</p></div>
@php($active = $courses->filter(fn($c) => isset($enrollments[$c->id]) && $enrollments[$c->id]->status === 'active'))
<div class="stats"><div class="stat"><strong>{{ $active->count() }}</strong><span>វគ្គដែលកំពុងរៀន / Enrolled courses</span></div><div class="stat"><strong>{{ $active->filter(fn($c) => $c->progress['eligible'])->count() }}</strong><span>វគ្គបានបញ្ចប់ / Completed courses</span></div><div class="stat"><strong>{{ $active->sum(fn($c) => $c->progress['completed_lessons']) }}</strong><span>មេរៀនបានបញ្ចប់ / Lessons completed</span></div></div>
<h2>វគ្គសិក្សារបស់ខ្ញុំ / My courses</h2>
<div class="grid">@forelse($active as $course)
<article class="card"><div class="card-accent"></div><span class="code">{{ $course->code }}</span><h3>{{ $course->title }}</h3><p class="muted">{{ $course->instructor }}</p><progress class="progress" max="100" value="{{ $course->progress['percentage'] }}"></progress><p class="hint">{{ $course->progress['percentage'] }}% complete · {{ $course->progress['completed_lessons'] }}/{{ $course->progress['lessons'] }} lessons</p><div class="actions"><a class="button" href="{{ route('learning.course', $course->id) }}">បន្តរៀន / Continue</a></div></article>
@empty<div class="empty full">You have no published courses yet. Enroll below or contact your administrator.</div>@endforelse</div>
<h2 style="margin-top:36px">ស្វែងរកវគ្គសិក្សា / Course catalog</h2>
<div class="grid">@forelse($courses->reject(fn($c) => $active->contains('id', $c->id)) as $course)
<article class="card"><div class="card-accent"></div><span class="code">{{ $course->code }}</span><h3>{{ $course->title }}</h3><p class="muted">{{ \Illuminate\Support\Str::limit($course->description, 180) }}</p><p class="hint">Instructor · {{ $course->instructor }}</p><div class="actions">
@if(isset($enrollments[$course->id]))<span class="badge warn">Enrollment suspended · Contact admin</span>
@elseif($course->self_enrollment)<form method="post" action="{{ route('learning.enroll', $course->id) }}">@csrf<button>ចុះឈ្មោះរៀន / Enroll</button></form>
@else<span class="badge">Enrollment by administrator</span>@endif</div></article>
@empty<div class="empty full">No additional courses are available right now.</div>@endforelse</div>
@endsection
