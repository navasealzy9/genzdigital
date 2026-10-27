@extends('learning.layout')
@section('body-class', 'admin-shell')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/learning-admin.css') }}?v={{ filemtime(public_path('css/learning-admin.css')) }}">
@endsection
@section('sidebar')
@include('learning.partials.admin-icons')
@php($activeSection = request()->routeIs('admin.gen5.*') ? 'gen5' : (request()->routeIs('admin.courses.*') ? 'courses' : request('section', 'overview')))
<aside class="admin-sidebar">
    <a class="brand" href="{{ route('admin.index') }}"><span class="brand-icon">G<span>z</span></span><span>GenZ Digital<small>LEARNING WORKSPACE</small></span></a>
    <div class="workspace-label"><span class="workspace-dot"></span>Admin workspace <span class="workspace-tag">ADMIN</span></div>
    <span class="sidebar-caption">គ្រប់គ្រងការសិក្សា</span>
    <nav class="sidebar-nav" aria-label="Administration">
        @foreach(['overview' => ['grid', 'ទិដ្ឋភាពទូទៅ', 'Overview'], 'courses' => ['book', 'វគ្គសិក្សា', 'Courses'], 'students' => ['users', 'សិស្ស', 'Students'], 'create' => ['plus', 'បង្កើតវគ្គថ្មី', 'Create course']] as $key => [$icon, $label, $english])
        <a href="{{ route('admin.index', ['section' => $key]) }}" @class(['sidebar-link', 'is-active' => $activeSection === $key]) @if($activeSection === $key) aria-current="page" @endif><svg class="admin-icon" aria-hidden="true"><use href="#icon-{{ $icon }}"/></svg><span>{{ $label }}<small>{{ $english }}</small></span>@if($activeSection === $key)<span class="active-dot"></span>@endif</a>
        @endforeach
        <a href="{{ route('admin.gen5.index') }}" @class(['sidebar-link', 'is-active' => $activeSection === 'gen5']) @if($activeSection === 'gen5') aria-current="page" @endif><svg class="admin-icon" aria-hidden="true"><use href="#icon-game"/></svg><span>GEN5<small>Team battle</small></span>@if($activeSection === 'gen5')<span class="active-dot"></span>@endif</a>
    </nav>
    <div class="sidebar-help"><span class="help-icon"><svg class="admin-icon" aria-hidden="true"><use href="#icon-spark"/></svg></span><strong>ការសិក្សាចាប់ផ្ដើមពីមេរៀន</strong><p>រៀបចំមេរៀន បន្ថែមកិច្ចការ ហើយ Publish វគ្គនៅពេលរួចរាល់។</p><a href="{{ route('admin.index', ['section' => 'create']) }}">បង្កើតវគ្គសិក្សា <span>→</span></a></div>
    <div class="sidebar-profile"><span class="avatar admin-avatar">{{ mb_substr(auth()->user()->name, 0, 1) }}</span><span><strong>{{ auth()->user()->name }}</strong><small>Administrator</small></span><form method="post" action="{{ route('logout') }}">@csrf<button class="logout-icon" aria-label="ចាកចេញ / Sign out" title="Sign out"><svg class="admin-icon" aria-hidden="true"><use href="#icon-logout"/></svg></button></form></div>
</aside>
@endsection
