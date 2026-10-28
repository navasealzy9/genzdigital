@extends('learning.layout')
@section('title', $course->title)
@section('content')
<a href="{{ route('campus.index') }}">← My learning</a>
<div class="hero" style="margin-top:18px"><span class="eyebrow">{{ $course->code }} · {{ $course->instructor }}</span><h1>{{ $course->title }}</h1><p>{{ $course->description }}</p></div>
<div class="split"><div>
<section class="panel"><h2>មេរៀន / Course curriculum</h2>
@forelse($lessons->groupBy('section') as $section => $items)<h3>{{ $section }}</h3>@foreach($items as $lesson)<div class="row"><div><span class="badge {{ in_array($lesson->id, $completed) ? 'good' : '' }}">{{ in_array($lesson->id, $completed) ? 'Completed' : 'Lesson '.$loop->iteration }}</span><p>{{ $lesson->title }}</p></div><a class="button subtle" href="{{ route('learning.lesson', $lesson->id) }}">{{ in_array($lesson->id, $completed) ? 'Review' : 'Study' }} →</a></div>@endforeach
@empty<p class="muted">Your instructor has not published any lessons yet.</p>@endforelse</section>
<h2 id="assignments">កិច្ចការផ្ទះ / Assignments</h2>
@forelse($assignments as $assignment)
@php($submission = $submissions[$assignment->id] ?? null)
@php($closed = $assignment->due_at && now()->gt(\Carbon\Carbon::parse($assignment->due_at)))
<section class="panel"><h3>{{ $assignment->title }}</h3><p class="hint">Due: {{ $assignment->due_at ?: 'No deadline' }} · Pass: {{ $assignment->pass_score }}/{{ $assignment->max_score }}</p><div class="prose">{{ $assignment->instructions }}</div>
@if($submission)<div class="answer"><span class="badge {{ $submission->graded_at ? 'good' : '' }}">{{ $submission->graded_at ? 'Graded' : 'Submitted · Awaiting review' }}</span><p class="hint">Submitted {{ $submission->submitted_at }}</p><div class="prose">{{ $submission->answer }}</div>
@if($submission->file_path)<a href="{{ route('learning.attachment', $submission->id) }}">{{ $submission->file_name }}</a>@endif
@if($submission->graded_at)<p class="grade">{{ $submission->score }} / {{ $assignment->max_score }}</p><p class="prose">{{ $submission->feedback }}</p><span class="badge {{ $submission->score >= $assignment->pass_score ? 'good' : 'warn' }}">{{ $submission->score >= $assignment->pass_score ? 'Passed' : 'Below passing score · Contact your instructor' }}</span>@endif</div>@endif
@if(!$closed && (!$submission || !$submission->graded_at))<form method="post" action="{{ route('learning.submit', $assignment->id) }}" enctype="multipart/form-data">@csrf<label class="field">Your answer<textarea name="answer" required maxlength="100000">{{ old('answer', $submission->answer ?? '') }}</textarea></label><label class="field">Attachment (optional, max 20 MB)<input type="file" name="attachment" accept=".pdf,.txt,.doc,.docx,.zip,.png,.jpg,.jpeg"></label><button>{{ $submission ? 'Update submission' : 'Submit assignment' }}</button></form>
@elseif($closed && !$submission)<p class="notice error">The submission deadline has passed.</p>@endif
</section>@empty<p class="empty">No published assignments.</p>@endforelse
<h2 id="quizzes">ការប្រឡង / Quizzes & exams</h2>
@forelse($quizzes as $quiz)<section class="panel"><h3>{{ $quiz->title }}</h3><p class="hint">{{ $quiz->duration_minutes }} minutes · Pass 50% · Maximum {{ $quiz->max_attempts }} attempts<br>Opens: {{ $quiz->opens_at ?: 'Anytime' }} · Closes: {{ $quiz->closes_at ?: 'No closing date' }}</p>
@php($history = $attempts[$quiz->id] ?? collect())
@foreach($history as $attempt)<div class="row"><span>Attempt {{ $history->count() - $loop->index }} · {{ $attempt->submitted_at ? $attempt->percentage.'%' : 'In progress' }} @if($attempt->submitted_at)<span class="badge {{ $attempt->passed ? 'good' : 'warn' }}">{{ $attempt->passed ? 'Passed' : 'Not passed' }}</span>@endif</span><a href="{{ route('learning.attempt', $attempt->id) }}">{{ $attempt->submitted_at ? 'Result' : 'Resume' }}</a></div>@endforeach
@if($history->whereNull('submitted_at')->isEmpty() && $history->count() < $quiz->max_attempts && (!$quiz->opens_at || now()->gte(\Carbon\Carbon::parse($quiz->opens_at))) && (!$quiz->closes_at || now()->lt(\Carbon\Carbon::parse($quiz->closes_at))))<form method="post" action="{{ route('learning.start', $quiz->id) }}" style="margin-top:16px">@csrf<button>Start timed attempt</button></form>@else<p class="hint">Resume your existing attempt, or check the schedule and attempt limit.</p>@endif
</section>@empty<p class="empty">No published quizzes.</p>@endforelse
</div><aside><div class="panel"><span class="eyebrow">YOUR PROGRESS</span><h1>{{ $progress['percentage'] }}%</h1><progress class="progress" max="100" value="{{ $progress['percentage'] }}"></progress><div class="row"><span>Lessons completed</span><strong>{{ $progress['completed_lessons'] }}/{{ $progress['lessons'] }}</strong></div><div class="row"><span>Assignments passed</span><strong>{{ $progress['passed_assignments'] }}/{{ $progress['assignments'] }}</strong></div><div class="row"><span>Quizzes passed</span><strong>{{ $progress['passed_quizzes'] }}/{{ $progress['quizzes'] }}</strong></div><p class="hint" style="margin-top:18px">Complete all published lessons and pass all assessments to earn your certificate.</p>@if($progress['eligible'])<a class="button" href="{{ route('learning.certificate', $course->id) }}">វិញ្ញាបនបត្រ / Certificate</a>@endif</div></aside></div>
@endsection
