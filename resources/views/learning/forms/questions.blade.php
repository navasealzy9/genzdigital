<div class="qcm-editor">
    <p class="hint">បញ្ចូលសំណួរ QCM ច្រើន រួចរក្សាទុកទាំងអស់ក្នុងពេលតែមួយ។ Maximum 100 questions.</p>
    <div class="qcm-rows"></div>
    <button type="button" class="button subtle qcm-add">+ Add question / បន្ថែមសំណួរ</button>
    <template>
        <fieldset class="answer qcm-row">
            <legend>QCM <span class="qcm-number"></span></legend>
            <label class="field">Question<textarea data-key="prompt" required maxlength="10000"></textarea></label>
            <div class="form-grid">
                @foreach(['A', 'B', 'C', 'D'] as $key)
                <label class="field">Option {{ $key }}<input data-key="options][{{ $key }}" required maxlength="2000"></label>
                @endforeach
                <label class="field">Correct answer<select data-key="correct_option">@foreach(['A', 'B', 'C', 'D'] as $key)<option>{{ $key }}</option>@endforeach</select></label>
                <label class="field">Points<input data-key="points" type="number" required min="1" max="1000" value="1"></label>
            </div>
            <button type="button" class="button danger qcm-remove">Remove question</button>
        </fieldset>
    </template>
</div>
<script>
(() => {
    const editor = document.currentScript.previousElementSibling;
    const rows = editor.querySelector('.qcm-rows');
    const add = editor.querySelector('.qcm-add');
    const renumber = () => {
        [...rows.children].forEach((row, index) => {
            row.querySelector('.qcm-number').textContent = index + 1;
            row.querySelectorAll('[data-key]').forEach(input => input.name = `questions[${index}][${input.dataset.key}]`);
        });
        add.disabled = rows.children.length >= 100;
    };
    add.addEventListener('click', () => {
        if (rows.children.length >= 100) return;
        const row = editor.querySelector('template').content.cloneNode(true);
        row.querySelector('.qcm-remove').addEventListener('click', event => { event.target.closest('.qcm-row').remove(); renumber(); });
        rows.append(row);
        renumber();
    });
})();
</script>
