@extends('learning.layout')
@section('title', $lesson->title)
@section('content')
<a href="{{ route('learning.course', $course->id) }}">← {{ $course->title }}</a>
<div class="panel" style="margin-top:22px"><span class="eyebrow">{{ $lesson->section }}</span><h1>{{ $lesson->title }}</h1><div class="prose">{{ $lesson->content }}</div>
@if($lesson->video_url)<hr class="divider"><a class="button subtle" href="{{ $lesson->video_url }}" target="_blank" rel="noopener noreferrer">មើលវីដេអូ / Watch lesson video ↗</a>@endif
@if($lesson->file_path)<p style="margin-top:18px"><a href="{{ route('learning.material', $lesson->id) }}">ទាញយកឯកសារ / Download {{ $lesson->file_name }}</a></p>@endif
<hr class="divider">@if($complete)<span class="badge good">មេរៀននេះបានបញ្ចប់ / Completed</span>@else<form method="post" action="{{ route('learning.complete', $lesson->id) }}">@csrf<p class="hint">After studying the content and materials, mark this lesson complete.</p><button>បានរៀនរួច / Mark complete</button></form>@endif</div>
@endsection
