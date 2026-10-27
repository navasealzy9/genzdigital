@extends('learning.layout')
@section('title', 'Request could not be completed')
@section('content')
<div class="auth panel"><span class="eyebrow">{{ $status }}</span><h1>{{ $heading }}</h1><p class="muted">{{ $message }}</p><div class="actions"><a class="button" href="{{ route('campus.index') }}">ទៅទំព័រដើម / Home</a><button class="button subtle" onclick="history.back()">ត្រឡប់ក្រោយ / Go back</button></div></div>
@endsection
