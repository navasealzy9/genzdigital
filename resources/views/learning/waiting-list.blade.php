<section class="admin-panel">
    <div class="panel-heading"><div><h2>Waiting List <span class="count-label">{{ $waitingStudents->count() }}</span></h2><p>Accounts without a class. Enrolled students leave this list automatically.</p></div></div>
    @if($waitingStudents->isNotEmpty())
    <form method="post" action="{{ route('admin.waiting.enroll') }}" class="admin-form" id="waiting-enrollment">
        @csrf
        <div class="form-grid"><label class="field">ថ្នាក់ / Class
            <select name="course_id" required><option value="">Choose a class</option>@foreach($enrollmentCourses as $class)<option value="{{ $class->id }}" @selected(old('course_id') == $class->id)>{{ $class->title }} · {{ $class->code }} ({{ $class->status }})</option>@endforeach</select>
        </label></div>
        @if($enrollmentCourses->isEmpty())<p>Create a class before enrolling students.</p>@endif
        <div class="table-wrap"><table class="admin-table">
            <thead><tr><th><label><input type="checkbox" id="waiting-select-all"> Select all</label></th><th>Student</th><th>Username / Student ID</th><th>Status</th><th>Registered</th></tr></thead>
            <tbody>@foreach($waitingStudents as $student)<tr>
                <td><input type="checkbox" name="students[]" value="{{ $student->id }}" aria-label="Select {{ $student->name }}" @checked(in_array($student->id, old('students', [])))></td>
                <td>{{ $student->name }}</td><td>{{ $student->username }}<br><small>{{ $student->student_id }}</small></td><td>{{ $student->status }}</td><td>{{ $student->created_at?->format('d M Y H:i') }}</td>
            </tr>@endforeach</tbody>
        </table></div>
        <div class="form-actions"><span id="waiting-selected" aria-live="polite"></span><button id="waiting-submit" @disabled($enrollmentCourses->isEmpty())>Enroll selected students</button></div>
    </form>
    <script>
    (() => {
        const form = document.getElementById('waiting-enrollment');
        const all = document.getElementById('waiting-select-all');
        const boxes = [...form.querySelectorAll('input[name="students[]"]')];
        const update = () => {
            const count = boxes.filter(box => box.checked).length;
            all.checked = count === boxes.length;
            all.indeterminate = count > 0 && count < boxes.length;
            document.getElementById('waiting-selected').textContent = count + ' selected';
            document.getElementById('waiting-submit').disabled = !count || !form.elements.course_id.options[1];
        };
        all.addEventListener('change', () => { boxes.forEach(box => box.checked = all.checked); update(); });
        boxes.forEach(box => box.addEventListener('change', update));
        update();
    })();
    </script>
    @else<div class="admin-empty"><h3>No students waiting</h3><p>New student accounts appear here until they are enrolled in a class.</p></div>@endif
</section>
