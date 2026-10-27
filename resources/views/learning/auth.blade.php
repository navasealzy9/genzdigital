@extends('learning.layout')
@section('title', $register ? 'Create account' : 'Sign in')
@section('content')
<div class="auth"><div class="panel">
    <span class="eyebrow">YOUR NEXT CHAPTER STARTS HERE</span>
    <h1>{{ $register ? 'បង្កើតគណនីសិស្ស' : 'សូមស្វាគមន៍មកវិញ' }}</h1>
    <p class="muted">{{ $register ? 'Create an account to discover courses and start learning.' : 'Sign in to continue your learning journey.' }}</p>
    <form method="post" action="{{ route($register ? 'register.post' : 'login.post') }}">@csrf
        @if($register)<label class="field">ឈ្មោះ / Full name<input name="name" value="{{ old('name') }}" required maxlength="191" autocomplete="name"></label>@endif
        <label class="field">អ៊ីមែល / Email<input name="email" type="email" value="{{ old('email') }}" required autocomplete="email" maxlength="191"></label>
        <label class="field">ពាក្យសម្ងាត់ / Password<input name="password" type="password" required {{ $register ? 'minlength=8' : '' }} autocomplete="{{ $register ? 'new-password' : 'current-password' }}"></label>
        @if($register)
        <label class="field">បញ្ជាក់ពាក្យសម្ងាត់ / Confirm password<input name="password_confirmation" type="password" required minlength="8" autocomplete="new-password"></label>
        <p class="hint">Use at least 8 characters. Public registration creates a student account.</p>
        @else<label class="field"><input type="checkbox" name="remember" value="1">Remember me</label>@endif
        <button style="width:100%">{{ $register ? 'ចុះឈ្មោះ / Create account' : 'ចូលគណនី / Sign in' }}</button>
    </form><hr class="divider">
    <p class="hint">{{ $register ? 'Already have an account?' : 'New to GenZ Digital?' }} <a href="{{ route($register ? 'login' : 'register') }}">{{ $register ? 'Sign in' : 'Create a student account' }}</a></p>
</div></div>
@endsection
