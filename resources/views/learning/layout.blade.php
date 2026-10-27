<!doctype html>
<html lang="km">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Learning') · GenZ Digital</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/learning.css') }}">
</head>
<body>
<header class="topbar"><a class="brand" href="{{ route('campus.index') }}"><span class="brand-icon">G<span>z</span></span><span>GenZ Digital<small>E-LEARNING PLATFORM</small></span></a>
    <nav aria-label="Main navigation">
    @auth
        <a href="{{ route(auth()->user()->role === 'admin' ? 'admin.index' : 'campus.index') }}">{{ auth()->user()->role === 'admin' ? 'គ្រប់គ្រង / Admin' : 'ការសិក្សារបស់ខ្ញុំ / My learning' }}</a>
        <span class="user-name">{{ auth()->user()->name }}</span>
        <form method="post" action="{{ route('logout') }}">@csrf<button class="button subtle">ចាកចេញ</button></form>
    @else
        <a href="{{ route('login') }}">ចូលគណនី</a><a class="button" href="{{ route('register') }}">ចុះឈ្មោះ</a>
    @endauth
    </nav>
</header>
<main class="container">
    @if(session('success'))<div class="notice success" role="status">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="notice error" role="alert"><strong>Please check your information.</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    @yield('content')
</main>
<footer>GenZ Digital · រៀន អនុវត្ត និងអភិវឌ្ឍខ្លួន <span>Times shown in {{ config('app.timezone') }}</span></footer>
@stack('scripts')
</body></html>
