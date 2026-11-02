<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create New Password - GenZ Digital</title>
    <link rel="stylesheet" href="{{ asset('css/campus-learning.css') }}">
</head>
<body class="learning-workspace">
<main class="auth"><div class="panel">
    <img src="{{ asset('images/genz-logo.png') }}" alt="GenZ Digital" width="72" height="72">
    <h1>Create New Password</h1>
    <p>សូមកំណត់ពាក្យសម្ងាត់ថ្មី ដើម្បីបន្តប្រើប្រាស់គណនីរបស់អ្នក។</p>
    <p>{{ auth()->user()->username }}</p>
    @if($errors->any())<div role="alert">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
    <form method="post" action="{{ route('password.store') }}">
        @csrf
        <label class="field">ពាក្យសម្ងាត់ថ្មី / New password<input type="password" name="password" required minlength="8" maxlength="255" autocomplete="new-password" autofocus></label>
        <label class="field">បញ្ជាក់ពាក្យសម្ងាត់ / Confirm password<input type="password" name="password_confirmation" required minlength="8" maxlength="255" autocomplete="new-password"></label>
        <p>ប្រើយ៉ាងតិច 8 តួអក្សរ ហើយត្រូវខុសពីពាក្យសម្ងាត់បណ្តោះអាសន្ន។</p>
        <button type="submit">រក្សាទុក / Save Password</button>
    </form>
    <form method="post" action="{{ route('logout') }}">@csrf<button type="submit" class="subtle">ចាកចេញ / Sign out</button></form>
</div></main>
</body>
</html>
