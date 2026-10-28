@extends('learning.layout')
@section('title', 'My learning')
@section('content')
@php
    $active = $courses->filter(fn($c) => isset($enrollments[$c->id]) && $enrollments[$c->id]->status === 'active');
    $user = auth()->user();
    $firstCourse = $active->first();
    $completedCourse = $active->first(fn($c) => $c->progress['eligible']);
    $courseLink = $firstCourse ? route('learning.course', $firstCourse->id) : '#courses';
@endphp
<section id="student-profile" class="campus-profile">
    <div class="campus-profile-identity"><div class="campus-profile-avatar">@if($user->avatar)<img src="{{ $user->avatar }}" alt="{{ $user->name }}" onerror="this.hidden=true">@endif<span>{{ mb_substr($user->name,0,1) }}</span></div><div><h1>{{ $user->name }}</h1><div class="campus-profile-id">ID · {{ $user->student_id ?: 'GZ-'.$user->id }} <span>● {{ $user->status }}</span></div><a href="#courses">មើលវគ្គសិក្សារបស់ខ្ញុំ →</a></div></div>
    <a class="button" href="{{ route('learning.profile.edit') }}">Edit profile</a>
    <div class="campus-profile-meta"><div><small>GENDER</small><strong>{{ $user->gender ?: 'Not set' }}</strong></div><div><small>MAJOR</small><strong>{{ $user->major ?: 'Not set' }}</strong></div></div>
</section>
<section id="learning-tools" class="campus-tools" aria-label="Learning tools">
    @foreach([
        ['school','Class','ថ្នាក់រៀន និងវគ្គសិក្សា','#courses',$active->count().' Classes','indigo'],
        ['folder-down','Lessons & Resources','មេរៀន និងឯកសារសិក្សា',$courseLink,$active->sum(fn($c) => $c->progress['completed_lessons']).' Completed','blue'],
        ['notebook-pen','Assignments','បញ្ជូនកិច្ចការ និងមើលមតិយោបល់',$firstCourse ? $courseLink.'#assignments' : '#courses','Learning','green'],
        ['file-text','Exam','ការប្រឡង និងលទ្ធផលរបស់ខ្ញុំ',$firstCourse ? $courseLink.'#quizzes' : '#courses','Quizzes','violet'],
        ['award','Certificate','វិញ្ញាបនបត្របញ្ចប់វគ្គ',$completedCourse ? route('learning.certificate',$completedCourse->id) : '#courses',$active->filter(fn($c) => $c->progress['eligible'])->count().' Earned','pink'],
        ['gamepad-2','GEN5','ប្រកួតសង់ទីក្រុងជាក្រុម',route('gen5.index'),'LIVE','teal'],
    ] as [$icon,$title,$description,$href,$count,$tone])
    <a class="tool-card campus-tool" href="{{ $href }}"><span class="campus-tool-count">{{ $count }}</span><span class="tool-icon-box campus-tool-icon {{ $tone }}"><i data-lucide="{{ $icon }}"></i></span><h2>{{ $title }}</h2><p>{{ $description }}</p><span class="campus-tool-arrow">→</span></a>
    @endforeach
</section>
<div class="campus-section-heading" id="courses"><div><h2>ថ្នាក់រៀនរបស់ខ្ញុំ / My courses</h2><p>រៀនតាមមេរៀន ធ្វើកិច្ចការ និងតាមដានវឌ្ឍនភាពពិតរបស់អ្នក។</p></div></div>
<div class="grid">@forelse($active as $course)
<article class="card"><div class="card-accent"></div><span class="code">{{ $course->code }}</span><h3>{{ $course->title }}</h3><p class="muted">{{ $course->instructor }}</p><progress class="progress" max="100" value="{{ $course->progress['percentage'] }}"></progress><p class="hint">{{ $course->progress['percentage'] }}% complete · {{ $course->progress['completed_lessons'] }}/{{ $course->progress['lessons'] }} lessons</p><div class="actions"><a class="button" href="{{ route('learning.course', $course->id) }}">បន្តរៀន / Continue</a></div></article>
@empty<div class="empty full">You have no published courses yet. Enroll below or contact your administrator.</div>@endforelse</div>
<h2 style="margin-top:36px">ស្វែងរកវគ្គសិក្សា / Course catalog</h2>
<div class="grid">@forelse($courses->reject(fn($c) => $active->contains('id', $c->id)) as $course)
<article class="card"><div class="card-accent"></div><span class="code">{{ $course->code }}</span><h3>{{ $course->title }}</h3><p class="muted">{{ \Illuminate\Support\Str::limit($course->description, 180) }}</p><p class="hint">Instructor · {{ $course->instructor }}</p><div class="actions">
@if(isset($enrollments[$course->id]))<span class="badge warn">Enrollment suspended · Contact admin</span>
@elseif($course->self_enrollment)<form method="post" action="{{ route('learning.enroll', $course->id) }}">@csrf<button>ចុះឈ្មោះរៀន / Enroll</button></form>
@else<span class="badge">Enrollment by administrator</span>@endif</div></article>
@empty<div class="empty full">No additional courses are available right now.</div>@endforelse</div>
@endsection
