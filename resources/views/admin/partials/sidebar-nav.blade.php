@php($activeSection = request()->routeIs('admin.gen5.*') ? 'gen5' : (request()->routeIs('admin.courses.*') ? 'courses' : request('section', 'overview')))
<div class="d-flex flex-column gap-1">
    <div class="sidebar-section-title">CAMPUS MANAGEMENT</div>
    @foreach(['overview'=>['layout-dashboard','Dashboard'], 'courses'=>['graduation-cap','Class & Course Manage'], 'students'=>['users','Manage Users & Students'], 'create'=>['plus-circle','Create Course'], 'gen5'=>['gamepad-2','GEN5 · Team Battle']] as $key=>[$icon,$label])
    <a href="{{ $key === 'gen5' ? route('admin.gen5.index') : route('admin.index', ['section'=>$key]) }}" @class(['admin-nav-item d-flex align-items-center gap-2 text-decoration-none', 'active'=>$key === $activeSection]) @if($key === $activeSection) aria-current="page" @endif><i data-lucide="{{ $icon }}" style="width:18px;height:18px"></i><span>{{ $label }}</span>@if($key === 'gen5')<span class="badge rounded-pill bg-primary-subtle text-primary ms-auto">LIVE</span>@endif</a>
    @endforeach
    <div class="sidebar-section-title mt-3">LEARNING WORKFLOW</div>
    <p class="small text-secondary px-3" style="line-height:1.9">ជ្រើសរើសថ្នាក់ ដើម្បីគ្រប់គ្រងមេរៀន កិច្ចការ ការប្រឡង ការចុះឈ្មោះ និងរបាយការណ៍។</p>
</div>
