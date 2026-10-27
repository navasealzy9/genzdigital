@extends('learning.layout')
@section('title', $quiz->title)
@section('content')
<a href="{{ route('learning.course', $quiz->course_id) }}">← Back to course</a><h1>{{ $quiz->title }}</h1>
@if($attempt->submitted_at)<div class="panel"><span class="eyebrow">YOUR RESULT</span><h1>{{ $attempt->percentage }}%</h1><span class="badge {{ $attempt->passed ? 'good' : 'warn' }}">{{ $attempt->passed ? 'Passed' : 'Not passed' }}</span><p>{{ $attempt->earned_points }} / {{ $attempt->total_points }} points · Submitted {{ $attempt->submitted_at }}</p></div>
@else<div class="timer"><span>Time remaining</span><strong id="remaining" data-seconds="{{ max(0, now()->diffInSeconds(\Carbon\Carbon::parse($attempt->expires_at), false)) }}">Calculating…</strong></div><p class="hint" style="margin-top:16px">Answers save as you select them. At expiry, only saved answers count. Leaving this page does not pause the timer. <span id="save-status" role="status"></span></p>@endif
<form id="quiz-form" method="post" action="{{ route('learning.finish', $attempt->id) }}">@csrf
@foreach($questions as $question)<fieldset class="panel"><legend>Question {{ $loop->iteration }} · {{ $question['points'] }} points</legend><h3>{{ $question['prompt'] }}</h3>@foreach(json_decode($question['options'], true) as $key => $option)<label class="option"><input type="radio" name="answers[{{ $question['id'] }}]" value="{{ $key }}" @checked(($answers[$question['id']] ?? null) === $key) @disabled($attempt->submitted_at)><span><strong>{{ $key }}.</strong> {{ $option }}</span></label>@endforeach</fieldset>@endforeach
@unless($attempt->submitted_at)<button>Submit quiz for grading</button>@endunless</form>
@endsection
@push('scripts')
@unless($attempt->submitted_at)<script>
const display = document.getElementById('remaining');
const deadline = Date.now() + Number(display.dataset.seconds) * 1000;
const form = document.getElementById('quiz-form');
const saveStatus = document.getElementById('save-status');
let saveQueue = Promise.resolve();
form.addEventListener('change', () => {
    const answers = {};
    new FormData(form).forEach((value, key) => { const match = key.match(/^answers\[(\d+)\]$/); if (match) answers[match[1]] = value; });
    saveStatus.textContent = 'Saving…';
    saveQueue = saveQueue.then(async () => {
        try {
            const response = await fetch(@json(route('learning.answers', $attempt->id)), {method:'PUT', credentials:'same-origin', headers:{'Content-Type':'application/json', 'Accept':'application/json', 'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content}, body:JSON.stringify({answers})});
            saveStatus.textContent = response.ok ? 'Saved' : 'Could not save. Submit your quiz before time ends.';
        } catch { saveStatus.textContent = 'Connection lost. Submit your quiz before time ends.'; }
    });
});
let sent = false;
function tick() {
    const seconds = Math.max(0, Math.floor((deadline - Date.now()) / 1000));
    display.textContent = `${Math.floor(seconds / 60)}:${String(seconds % 60).padStart(2, '0')}`;
    if (seconds <= 0 && !sent) { sent = true; form.requestSubmit(); }
}
tick(); setInterval(tick, 500);
</script>@endunless
@endpush
