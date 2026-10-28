@extends('learning.layout')
@section('title', 'Edit profile')
@section('content')
<section class="panel">
    <h1>Edit profile / កែប្រែព័ត៌មានផ្ទាល់ខ្លួន</h1>
    <p class="hint">Update your Student ID and personal information. Your username stays {{ $student->username }}.</p>
    @if($student->avatar)<img src="{{ $student->avatar }}" alt="Current profile photo" width="100" height="100" style="object-fit:cover;border-radius:50%">@endif
    <form method="post" action="{{ route('learning.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-grid">
            <label class="field">Student ID<input name="student_id" required minlength="3" maxlength="100" pattern="[A-Za-z0-9][A-Za-z0-9_.\-]{2,99}" value="{{ old('student_id', $student->student_id) }}">@error('student_id')<span role="alert">{{ $message }}</span>@enderror</label>
            <label class="field">Full name<input name="name" required maxlength="191" autocomplete="name" value="{{ old('name', $student->name) }}">@error('name')<span role="alert">{{ $message }}</span>@enderror</label>
            <label class="field">Gender<input name="gender" maxlength="50" value="{{ old('gender', $student->gender) }}">@error('gender')<span role="alert">{{ $message }}</span>@enderror</label>
            <label class="field">Major<input name="major" maxlength="191" value="{{ old('major', $student->major) }}">@error('major')<span role="alert">{{ $message }}</span>@enderror</label>
            <label class="field">Profile photo<input type="file" name="photo" accept="image/jpeg,image/png,image/webp"><small>JPG, PNG or WebP. Maximum 5 MB, 6000 × 6000 pixels.</small>@error('photo')<span role="alert">{{ $message }}</span>@enderror</label>
        </div>
        <div class="actions"><button>Save profile</button><a class="button subtle" href="{{ route('campus.index') }}">Back to dashboard</a></div>
    </form>
</section>
@endsection
