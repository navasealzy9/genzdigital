<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\LearningProgress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LearningPlatformTest extends TestCase
{
    use RefreshDatabase;

    private function user(string $role = 'student'): User
    {
        return User::factory()->create(['role' => $role, 'status' => 'Active']);
    }

    private function course(array $overrides = []): int
    {
        return DB::table('learning_courses')->insertGetId($overrides + ['title' => 'Web foundations', 'code' => 'WEB'.uniqid(), 'description' => 'Learn the web', 'instructor' => 'Instructor', 'status' => 'published', 'self_enrollment' => true, 'created_at' => now(), 'updated_at' => now()]);
    }

    private function lesson(int $course, array $overrides = []): int
    {
        return DB::table('learning_lessons')->insertGetId($overrides + ['course_id' => $course, 'title' => 'HTML basics', 'section' => 'Introduction', 'content' => 'Build a semantic document.', 'published' => true, 'position' => 1, 'created_at' => now(), 'updated_at' => now()]);
    }

    private function enroll(User $user, int $course, string $status = 'active'): void
    {
        DB::table('learning_enrollments')->insert(['course_id' => $course, 'user_id' => $user->id, 'status' => $status, 'created_at' => now(), 'updated_at' => now()]);
    }

    private function quiz(int $course, array $overrides = []): array
    {
        $quiz = DB::table('learning_quizzes')->insertGetId($overrides + ['course_id' => $course, 'title' => 'HTML assessment', 'duration_minutes' => 10, 'pass_percentage' => 60, 'max_attempts' => 1, 'published' => true, 'created_at' => now(), 'updated_at' => now()]);
        $question = DB::table('learning_questions')->insertGetId(['quiz_id' => $quiz, 'prompt' => 'Choose semantic HTML', 'options' => json_encode(['A' => 'article', 'B' => 'div', 'C' => 'span', 'D' => 'b']), 'correct_option' => 'A', 'points' => 5, 'created_at' => now(), 'updated_at' => now()]);

        return [$quiz, $question];
    }

    public function test_guests_and_students_cannot_access_administration_or_old_unsafe_endpoints(): void
    {
        $this->get('/')->assertRedirect('/login');
        $this->get('/admin')->assertRedirect('/login');
        $this->postJson('/admin/courses', [])->assertUnauthorized();
        $this->actingAs($this->user())->get('/admin')->assertForbidden();
        $this->post('/admin/students', [])->assertForbidden();
        $this->post('/api/attendance/check-in', ['student_id' => 'someone-else'])->assertNotFound();
        $this->get('/logout')->assertStatus(405);
    }

    public function test_registration_is_student_only_and_passwords_are_hashed(): void
    {
        $this->get('/register')->assertOk();
        $this->post('/register', ['name' => 'Learner', 'username' => 'learner', 'password' => 'secure-password', 'password_confirmation' => 'secure-password', 'role' => 'admin'])->assertSessionHasErrors('role');
        $this->assertDatabaseMissing('users', ['username' => 'learner']);
        $this->post('/register', ['name' => 'Learner', 'username' => 'learner', 'password' => 'secure-password', 'password_confirmation' => 'secure-password'])->assertRedirect('/');
        $user = User::where('username', 'learner')->firstOrFail();
        $this->assertSame('student', $user->role);
        $this->assertTrue(password_verify('secure-password', $user->password));
        $this->get('/')->assertOk()->assertDontSee('3.88')->assertDontSee('Maya Chen');
    }

    public function test_login_and_existing_sessions_respect_inactive_accounts(): void
    {
        $user = $this->user();
        $user->update(['status' => 'Inactive']);
        $this->post('/login', ['login' => $user->username, 'password' => 'password'])->assertSessionHasErrors('login');
        $this->actingAs($user)->get('/')->assertForbidden();
    }

    public function test_admin_can_build_publish_and_render_a_course(): void
    {
        $admin = $this->user('admin');
        $this->actingAs($admin)->get('/admin')->assertOk();
        $data = ['title' => 'Khmer web course', 'code' => 'KH101', 'instructor' => 'Teacher', 'status' => 'draft'];
        $this->post('/admin/courses', $data)->assertRedirect();
        $course = DB::table('learning_courses')->where('code', 'KH101')->value('id');
        $this->put('/admin/courses/'.$course, array_replace($data, ['status' => 'published']))->assertStatus(422);
        $this->post('/admin/courses/'.$course.'/lessons', ['title' => 'First lesson', 'section' => 'Chapter 1', 'position' => 1, 'content' => 'Real lesson content', 'published' => 1])->assertRedirect();
        $this->put('/admin/courses/'.$course, array_replace($data, ['status' => 'published', 'self_enrollment' => 1]))->assertRedirect();
        $this->get('/admin/courses/'.$course)->assertOk()->assertSee('First lesson');
        $student = $this->user();
        $this->post('/admin/courses/'.$course.'/enrollments', ['user_id' => $student->id, 'status' => 'active'])->assertRedirect();
        $this->get('/admin/courses/'.$course.'/report')->assertOk()->assertDownload();
        $this->actingAs($student)->get('/courses/'.$course)->assertOk()->assertSee('First lesson');
    }

    public function test_enrollment_respects_visibility_admin_approval_and_suspension(): void
    {
        $student = $this->user();
        $course = $this->course();
        $lesson = $this->lesson($course);
        $draft = $this->course(['status' => 'draft']);
        $closed = $this->course(['self_enrollment' => false]);
        $this->actingAs($student)->get('/courses/'.$course)->assertForbidden();
        $this->get('/lessons/'.$lesson)->assertForbidden();
        $this->post('/courses/'.$draft.'/enroll')->assertNotFound();
        $this->post('/courses/'.$closed.'/enroll')->assertForbidden();
        $this->post('/courses/'.$course.'/enroll')->assertRedirect('/courses/'.$course);
        $this->post('/courses/'.$course.'/enroll')->assertRedirect();
        $this->assertDatabaseCount('learning_enrollments', 1);
        $this->assertDatabaseCount('learning_completions', 0);
        DB::table('learning_enrollments')->update(['status' => 'suspended']);
        $this->post('/courses/'.$course.'/enroll')->assertForbidden();
        $this->get('/lessons/'.$lesson)->assertForbidden();
    }

    public function test_lesson_completions_are_idempotent_and_student_specific(): void
    {
        $student = $this->user();
        $other = $this->user();
        $course = $this->course();
        $lesson = $this->lesson($course);
        $draft = $this->lesson($course, ['published' => false]);
        $this->enroll($student, $course);
        $this->enroll($other, $course);
        $this->actingAs($student)->get('/lessons/'.$lesson)->assertOk();
        $this->post('/lessons/'.$lesson.'/complete')->assertRedirect();
        $this->post('/lessons/'.$lesson.'/complete')->assertRedirect();
        $this->post('/lessons/'.$draft.'/complete')->assertNotFound();
        $this->assertDatabaseCount('learning_completions', 1);
        $this->assertSame(0, app(LearningProgress::class)->forStudent($course, $other->id)['percentage']);
    }

    public function test_assignments_require_enrollment_deadline_valid_grade_and_feedback(): void
    {
        $student = $this->user();
        $admin = $this->user('admin');
        $course = $this->course();
        $this->lesson($course);
        $assignment = DB::table('learning_assignments')->insertGetId(['course_id' => $course, 'title' => 'Practice', 'instructions' => 'Build a page', 'max_score' => 20, 'pass_score' => 10, 'due_at' => now()->addDay(), 'published' => true]);
        $this->actingAs($student)->post('/assignments/'.$assignment.'/submit', ['answer' => 'My answer'])->assertForbidden();
        $this->enroll($student, $course);
        $this->post('/assignments/'.$assignment.'/submit', ['answer' => 'My answer'])->assertRedirect();
        $submission = DB::table('learning_submissions')->first();
        $this->actingAs($admin)->post('/admin/submissions/'.$submission->id.'/grade', ['score' => 21, 'feedback' => 'Good'])->assertSessionHasErrors('score');
        $this->post('/admin/submissions/'.$submission->id.'/grade', ['score' => 18, 'feedback' => 'Well done'])->assertRedirect();
        $this->get('/admin/courses/'.$course)->assertOk()->assertSee('My answer');
        $this->actingAs($student)->get('/courses/'.$course)->assertOk()->assertSee('Well done');
        $this->post('/assignments/'.$assignment.'/submit', ['answer' => 'Changed'])->assertStatus(422);
        $this->actingAs($admin)->post('/admin/submissions/'.$submission->id.'/reopen', ['due_at' => now()->addDays(2)->format('Y-m-d H:i:s')])->assertRedirect();
        $this->actingAs($student)->post('/assignments/'.$assignment.'/submit', ['answer' => 'Revised work'])->assertRedirect();
        DB::table('learning_assignments')->where('id', $assignment)->update(['due_at' => now()->subMinute()]);
        $this->post('/assignments/'.$assignment.'/submit', ['answer' => 'Too late'])->assertStatus(422);
    }

    public function test_quiz_answers_are_private_scored_on_server_and_cannot_be_replayed(): void
    {
        $student = $this->user();
        $course = $this->course();
        $this->enroll($student, $course);
        [$quiz, $question] = $this->quiz($course);
        $this->actingAs($student)->post('/quizzes/'.$quiz.'/start')->assertRedirect();
        $attempt = DB::table('learning_attempts')->first();
        $this->get('/attempts/'.$attempt->id)->assertOk()->assertDontSee('correct_option');
        $this->post('/quizzes/'.$quiz.'/start')->assertRedirect('/attempts/'.$attempt->id);
        $this->assertDatabaseCount('learning_attempts', 1);
        $this->post('/attempts/'.$attempt->id.'/submit', ['answers' => [$question => 'A'], 'percentage' => 0])->assertRedirect();
        $this->assertDatabaseHas('learning_attempts', ['id' => $attempt->id, 'percentage' => 100, 'passed' => true]);
        $this->post('/attempts/'.$attempt->id.'/submit', ['answers' => [$question => 'B']])->assertRedirect();
        $this->assertDatabaseHas('learning_attempts', ['id' => $attempt->id, 'percentage' => 100]);
        $this->post('/quizzes/'.$quiz.'/start')->assertStatus(422);
        $this->actingAs($this->user())->get('/attempts/'.$attempt->id)->assertForbidden();
        $this->post('/attempts/'.$attempt->id.'/submit')->assertForbidden();
    }

    public function test_expired_quiz_grades_only_saved_answers_and_admin_can_allow_retake(): void
    {
        $student = $this->user();
        $course = $this->course();
        $this->enroll($student, $course);
        [$quiz, $question] = $this->quiz($course);
        $this->actingAs($student)->post('/quizzes/'.$quiz.'/start');
        $attempt = DB::table('learning_attempts')->first();
        $this->putJson('/attempts/'.$attempt->id.'/answers', ['answers' => [$question => 'B']])->assertOk();
        $this->travel(11)->minutes();
        $this->putJson('/attempts/'.$attempt->id.'/answers', ['answers' => [$question => 'A']])->assertStatus(409);
        $this->post('/attempts/'.$attempt->id.'/submit', ['answers' => [$question => 'A']])->assertRedirect();
        $this->assertDatabaseHas('learning_attempts', ['id' => $attempt->id, 'percentage' => 0, 'passed' => false]);
        $this->actingAs($this->user('admin'))->post('/admin/courses/'.$course.'/quizzes/'.$quiz.'/attempt-limit', ['max_attempts' => 2])->assertRedirect();
        $this->actingAs($student)->post('/quizzes/'.$quiz.'/start')->assertRedirect();
        $this->assertDatabaseCount('learning_attempts', 2);
    }

    public function test_expiry_command_preserves_correct_autosaved_answers(): void
    {
        $student = $this->user();
        $course = $this->course();
        $this->enroll($student, $course);
        [$quiz, $question] = $this->quiz($course);
        $this->actingAs($student)->post('/quizzes/'.$quiz.'/start');
        $attempt = DB::table('learning_attempts')->first();
        $this->putJson('/attempts/'.$attempt->id.'/answers', ['answers' => [$question => 'A']])->assertOk();
        $this->travel(11)->minutes();
        $this->artisan('learning:expire-attempts')->assertSuccessful();
        $this->assertDatabaseHas('learning_attempts', ['id' => $attempt->id, 'percentage' => 100, 'passed' => true]);
    }

    public function test_quiz_schedule_and_immutable_questions_are_enforced(): void
    {
        $student = $this->user();
        $admin = $this->user('admin');
        $course = $this->course();
        $this->enroll($student, $course);
        [$quiz] = $this->quiz($course, ['opens_at' => now()->addDay()]);
        $this->actingAs($student)->post('/quizzes/'.$quiz.'/start')->assertStatus(422);
        DB::table('learning_quizzes')->where('id', $quiz)->update(['opens_at' => now()->subDay(), 'closes_at' => now()->addDay()]);
        $this->post('/quizzes/'.$quiz.'/start')->assertRedirect();
        $this->actingAs($admin)->post('/admin/courses/'.$course.'/quizzes/'.$quiz.'/questions', ['prompt' => 'New question'])->assertStatus(422);
        $this->get('/admin/courses/'.$course)->assertOk()->assertSee('Assessment locked');
    }

    public function test_certificate_requires_all_real_learning_requirements(): void
    {
        $student = $this->user();
        $admin = $this->user('admin');
        $course = $this->course();
        $this->enroll($student, $course);
        $lesson = $this->lesson($course);
        [$quiz, $question] = $this->quiz($course);
        $assignment = DB::table('learning_assignments')->insertGetId(['course_id' => $course, 'title' => 'Project', 'instructions' => 'Submit a project', 'max_score' => 10, 'pass_score' => 5, 'published' => true]);
        $this->actingAs($student)->get('/courses/'.$course.'/certificate')->assertForbidden();
        $this->post('/lessons/'.$lesson.'/complete');
        $this->post('/assignments/'.$assignment.'/submit', ['answer' => 'Project']);
        $this->post('/quizzes/'.$quiz.'/start');
        $attempt = DB::table('learning_attempts')->first();
        $this->post('/attempts/'.$attempt->id.'/submit', ['answers' => [$question => 'A']]);
        $this->get('/courses/'.$course.'/certificate')->assertForbidden();
        $submission = DB::table('learning_submissions')->first();
        $this->actingAs($admin)->post('/admin/submissions/'.$submission->id.'/grade', ['score' => 8, 'feedback' => 'Passed']);
        $this->actingAs($student)->get('/courses/'.$course.'/certificate')->assertOk()->assertSee($student->name)->assertSee('Web foundations');
        $this->get('/courses/'.$course.'/certificate')->assertOk();
        $this->assertDatabaseCount('learning_certificates', 1);
        $this->assertSame(100, app(LearningProgress::class)->forStudent($course, $student->id)['percentage']);
    }

    public function test_private_materials_and_submission_attachments_require_permission(): void
    {
        Storage::fake('local');
        $admin = $this->user('admin');
        $student = $this->user();
        $course = $this->course();
        $this->actingAs($admin)->post('/admin/courses/'.$course.'/lessons', ['title' => 'Private material', 'section' => 'Intro', 'position' => 1, 'content' => 'Study this', 'published' => 1, 'material' => UploadedFile::fake()->create('notes.pdf', 10, 'application/pdf')])->assertRedirect();
        $lesson = DB::table('learning_lessons')->first();
        $this->actingAs($student)->get('/lessons/'.$lesson->id.'/material')->assertForbidden();
        $this->enroll($student, $course);
        $this->get('/lessons/'.$lesson->id.'/material')->assertOk()->assertDownload('notes.pdf');
        $assignment = DB::table('learning_assignments')->insertGetId(['course_id' => $course, 'title' => 'Project', 'instructions' => 'Submit', 'published' => true]);
        $this->post('/assignments/'.$assignment.'/submit', ['answer' => 'Attached', 'attachment' => UploadedFile::fake()->create('work.pdf', 10, 'application/pdf')])->assertRedirect();
        $submission = DB::table('learning_submissions')->first();
        $this->get('/submissions/'.$submission->id.'/attachment')->assertDownload('work.pdf');
        $this->actingAs($this->user())->get('/submissions/'.$submission->id.'/attachment')->assertForbidden();
        $this->actingAs($admin)->get('/submissions/'.$submission->id.'/attachment')->assertDownload('work.pdf');
    }

    public function test_admin_cannot_edit_content_under_a_different_course_id(): void
    {
        $a = $this->course();
        $b = $this->course();
        $lesson = $this->lesson($a);
        $this->actingAs($this->user('admin'))->post('/admin/courses/'.$b.'/lessons/'.$lesson, ['title' => 'Hijack'])->assertNotFound();
    }

    public function test_admin_can_author_questions_publish_quiz_and_create_assignments(): void
    {
        $course = $this->course();
        $this->actingAs($this->user('admin'));
        $quizData = ['title' => 'Final assessment', 'duration_minutes' => 20, 'pass_percentage' => 70, 'max_attempts' => 2, 'closes_at' => now()->addDays(2)->format('Y-m-d H:i:s')];
        $this->post('/admin/courses/'.$course.'/quizzes', $quizData)->assertRedirect();
        $quiz = DB::table('learning_quizzes')->first();
        $this->post('/admin/courses/'.$course.'/quizzes/'.$quiz->id, $quizData + ['published' => 1])->assertStatus(422);
        $questionData = ['prompt' => 'Which element is semantic?', 'options' => ['A' => 'article', 'B' => 'div', 'C' => 'span', 'D' => 'b'], 'correct_option' => 'A', 'points' => 5];
        $this->post('/admin/courses/'.$course.'/quizzes/'.$quiz->id.'/questions', $questionData)->assertRedirect();
        $this->post('/admin/courses/'.$course.'/quizzes/'.$quiz->id, $quizData + ['published' => 1])->assertRedirect();
        $this->assertDatabaseHas('learning_quizzes', ['id' => $quiz->id, 'published' => true]);
        $this->post('/admin/courses/'.$course.'/assignments', ['title' => 'Portfolio', 'instructions' => 'Build a portfolio', 'max_score' => 20, 'pass_score' => 10, 'published' => 1])->assertRedirect();
        $this->get('/admin/courses/'.$course)->assertOk()->assertSee('Which element is semantic?')->assertSee('Portfolio');
        $question = DB::table('learning_questions')->first();
        $this->delete('/admin/courses/'.$course.'/quizzes/'.$quiz->id.'/questions/'.$question->id)->assertRedirect();
        $this->assertDatabaseHas('learning_quizzes', ['id' => $quiz->id, 'published' => false]);
    }

    public function test_admin_created_students_can_sign_in_with_their_password(): void
    {
        $this->actingAs($this->user('admin'))->post('/admin/students', ['name' => 'New learner', 'username' => 'new.learner', 'password' => 'a-secure-password', 'password_confirmation' => 'a-secure-password'])->assertRedirect();
        $this->post('/logout')->assertRedirect('/login');
        $this->post('/login', ['login' => 'new.learner', 'password' => 'a-secure-password'])->assertRedirect('/');
        $this->get('/')->assertOk()->assertSee('New learner');
        $this->get('/admin')->assertForbidden();
    }

    public function test_admin_student_search_status_filter_and_pagination_keep_global_totals(): void
    {
        User::factory()->count(14)->create(['role' => 'student', 'status' => 'Active']);
        $target = User::factory()->create(['role' => 'student', 'name' => 'Unique learner', 'username' => 'unique.learner', 'email' => 'unique@example.test', 'status' => 'Inactive']);
        $this->actingAs($this->user('admin'));
        $this->get('/admin?section=students')->assertOk()
            ->assertViewHas('students', fn ($rows) => $rows->count() === 12 && $rows->total() === 15);
        $this->get('/admin?section=students&student_page=2')->assertOk()
            ->assertViewHas('students', fn ($rows) => $rows->count() === 3 && $rows->currentPage() === 2);
        $this->get('/admin?section=students&q=unique&account=Inactive')->assertOk()
            ->assertSee($target->username)->assertViewHas('studentCount', 15)
            ->assertViewHas('students', fn ($rows) => $rows->total() === 1);
        $this->get('/admin?section=students&q=unique&account=Active')->assertOk()
            ->assertViewHas('students', fn ($rows) => $rows->total() === 0);
    }

    public function test_admin_course_filters_and_separate_sections_render_correctly(): void
    {
        $this->course(['title' => 'Hidden draft', 'status' => 'draft']);
        $this->course(['title' => 'Public course', 'status' => 'published']);
        $this->actingAs($this->user('admin'));
        $this->get('/admin?section=courses&q=Hidden&status=draft')->assertOk()->assertSee('Hidden draft')->assertDontSee('Public course')
            ->assertViewHas('courses', fn ($rows) => $rows->total() === 1)
            ->assertViewHas('courseCounts', fn ($counts) => $counts->sum() === 2);
        $this->get('/admin?section=create')->assertOk()->assertSee('name="code"', false);
        $this->get('/admin')->assertOk()->assertDontSee('name="password_confirmation"', false);
    }
}
