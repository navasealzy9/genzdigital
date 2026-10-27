@extends('learning.layout')
@section('title', 'Certificate of completion')
@section('content')
<div class="actions no-print"><a href="{{ route('learning.course', $course->id) }}">← Back to course</a><button onclick="window.print()">Print / Save as PDF</button></div>
<article class="certificate"><span class="eyebrow">GENZ DIGITAL · E-LEARNING</span><h1>វិញ្ញាបនបត្របញ្ចប់វគ្គសិក្សា</h1><p>CERTIFICATE OF COMPLETION</p><hr class="divider"><p>This certifies that</p><h2>{{ auth()->user()->name }}</h2><p>has completed all published lessons and passed all required assessments in</p><h2>{{ $course->title }}</h2><p>{{ $course->code }} · Instructor: {{ $course->instructor }}</p><hr class="divider"><p>Issued {{ \Carbon\Carbon::parse($certificate->issued_at)->format('d F Y') }}</p><p class="credential">Credential ID: {{ $certificate->credential }}</p></article>
@endsection
