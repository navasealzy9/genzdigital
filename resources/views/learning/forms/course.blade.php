<div class="form-grid">
<label class="field">Course title<input name="title" required maxlength="255" value="{{ old('title', $course->title ?? '') }}"></label>
<label class="field">Unique course code<input name="code" required maxlength="100" value="{{ old('code', $course->code ?? '') }}" placeholder="WEB101"></label>
<label class="field">Instructor name<input name="instructor" required maxlength="255" value="{{ old('instructor', $course->instructor ?? auth()->user()->name) }}"></label>
<label class="field">Status<select name="status">@foreach(($course ? ['draft', 'published', 'archived'] : ['draft']) as $status)<option value="{{ $status }}" @selected(old('status', $course->status ?? 'draft') === $status)>{{ ucfirst($status) }}</option>@endforeach</select></label>
<label class="field full">Description<textarea name="description" maxlength="20000">{{ old('description', $course->description ?? '') }}</textarea></label>
</div><label class="field"><input type="checkbox" name="self_enrollment" value="1" @checked(old('self_enrollment', $course->self_enrollment ?? false))>Allow students to enroll themselves</label><p class="hint">When self-enrollment is off, only an administrator can enroll students. Draft and archived courses are hidden from students.</p>
