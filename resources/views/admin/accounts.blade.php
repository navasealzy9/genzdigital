@extends('learning.admin-layout')
@section('title', 'Account Manage')
@section('content')
<div class="admin-breadcrumb">Admin workspace <span>/</span> <strong>Account Manage</strong></div>
<div class="dashboard-heading">
    <div><span class="eyebrow">ACCOUNT MANAGEMENT</span><h1>Account Manage</h1><p>បង្កើតគណនីសិស្ស ឬគណនី Admin ថ្មី។</p></div>
    <a href="#new-account" class="button primary-action">+ បង្កើតគណនី / Create Account</a>
</div>
<section class="admin-panel" id="new-account">
    <div class="panel-heading"><div><h2>បង្កើតគណនីថ្មី / Create Account</h2><p>ជ្រើសរើសប្រភេទគណនី Student ឬ Admin។</p></div></div>
    <form class="admin-form" method="post" action="{{ route('admin.accounts.store') }}">
        @csrf
        <div class="form-grid">
            <label class="field">ប្រភេទគណនី / Account Type<select name="role" required><option value="student" @selected(old('role', 'student') === 'student')>សិស្ស / Student</option><option value="admin" @selected(old('role') === 'admin')>Admin / Administrator</option></select></label>
            <label class="field">ឈ្មោះ / Full Name<input name="name" required maxlength="191" value="{{ old('name') }}" autocomplete="name"></label>
            <label class="field">Username<input name="username" required minlength="3" maxlength="100" value="{{ old('username') }}" autocomplete="username" pattern="[A-Za-z0-9][A-Za-z0-9_.\-]{2,99}"></label>
            <label class="field">Student ID (optional)<input name="student_id" minlength="3" maxlength="100" value="{{ old('student_id') }}" placeholder="Auto-generated for students if blank"></label>
            <label class="field">ពាក្យសម្ងាត់ / Password<input type="password" name="password" required minlength="8" autocomplete="new-password"></label>
            <label class="field">បញ្ជាក់ពាក្យសម្ងាត់ / Confirm Password<input type="password" name="password_confirmation" required minlength="8" autocomplete="new-password"></label>
        </div>
        <div class="form-actions"><span>យ៉ាងតិច 8 តួអក្សរ។ គណនី Admin អាចចូលប្រើ Admin Console បាន។</span><button type="submit">បង្កើតគណនី / Create Account</button></div>
    </form>
</section>
<section class="admin-panel section">
    <div class="panel-heading"><div><h2>គណនីទាំងអស់ / Accounts <span class="count-label">{{ $accounts->total() }}</span></h2><p>Student & Administrator accounts</p></div><a class="button subtle" href="{{ route('admin.index', ['section' => 'students']) }}">Manage Students</a></div>
    <form class="admin-filters" method="get" action="{{ route('admin.accounts.index') }}">
        <label class="search-field"><span class="visually-hidden">Search accounts</span><input name="q" maxlength="100" value="{{ $search }}" placeholder="Name, username or Student ID..."></label>
        <label class="filter-select"><span class="visually-hidden">Account type</span><select name="role"><option value="">All account types</option><option value="student" @selected(request('role') === 'student')>Student</option><option value="admin" @selected(request('role') === 'admin')>Admin</option></select></label>
        <button type="submit">ស្វែងរក / Search</button>
        @if($search || request('role'))<a class="clear-filter" href="{{ route('admin.accounts.index') }}">Clear</a>@endif
    </form>
    <div class="table-wrap"><table class="admin-table"><thead><tr><th>ឈ្មោះ / Name</th><th>Username / Student ID</th><th>ប្រភេទ / Role</th><th>ស្ថានភាព / Status</th></tr></thead><tbody>
        @forelse($accounts as $account)
        <tr><td><div class="student-identity"><span class="avatar tone-{{ $loop->index % 4 }}">{{ mb_substr($account->name, 0, 1) }}</span><strong>{{ $account->name }}</strong></div></td><td>{{ $account->username }}<br><small>{{ $account->student_id ?: '—' }}</small></td><td><span class="status-pill {{ $account->role === 'admin' ? 'draft' : 'published' }}">{{ $account->role === 'admin' ? 'Administrator' : 'Student' }}</span></td><td><span class="status-pill {{ $account->status === 'Active' ? 'published' : 'archived' }}">{{ $account->status }}</span></td></tr>
        @empty<tr><td colspan="4"><div class="admin-empty"><h3>រកមិនឃើញគណនី / No accounts found</h3></div></td></tr>@endforelse
    </tbody></table></div>
    @include('learning.partials.admin-pagination', ['paginator' => $accounts, 'label' => 'Accounts'])
</section>
@endsection
