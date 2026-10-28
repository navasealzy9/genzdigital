<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Gen5Controller;
use App\Http\Controllers\LearningAdminController;
use App\Http\Controllers\LearningController;
use App\Http\Middleware\LearningAccess;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1')->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:6,1')->name('register.post');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::middleware(['auth', LearningAccess::class])->group(function () {
    Route::get('/', [LearningController::class, 'index'])->name('campus.index');
    Route::get('/lessons/{lesson}/material', [LearningController::class, 'material'])->name('learning.material');
    Route::get('/submissions/{submission}/attachment', [LearningController::class, 'attachment'])->name('learning.attachment');
    Route::get('/gen5/{match}/state', [Gen5Controller::class, 'state'])->whereNumber('match')->name('gen5.state');
});
Route::middleware(['auth', LearningAccess::class.':student'])->group(function () {
    Route::get('/profile', [\App\Http\Controllers\StudentProfileController::class, 'edit'])->name('learning.profile.edit');
    Route::put('/profile', [\App\Http\Controllers\StudentProfileController::class, 'update'])->name('learning.profile.update');
    Route::get('/gen5', [Gen5Controller::class, 'index'])->name('gen5.index');
    Route::get('/gen5/{match}', [Gen5Controller::class, 'show'])->whereNumber('match')->name('gen5.show');
    Route::post('/gen5/{match}/join', [Gen5Controller::class, 'join'])->middleware('throttle:20,1')->whereNumber('match')->name('gen5.join');
    Route::post('/gen5/{match}/action', [Gen5Controller::class, 'action'])->middleware('throttle:360,1')->whereNumber('match')->name('gen5.action');
    Route::get('/courses/{course}', [LearningController::class, 'show'])->name('learning.course');
    Route::post('/courses/{course}/enroll', [LearningController::class, 'enroll'])->name('learning.enroll');
    Route::get('/lessons/{lesson}', [LearningController::class, 'lesson'])->name('learning.lesson');
    Route::post('/lessons/{lesson}/complete', [LearningController::class, 'complete'])->name('learning.complete');
    Route::post('/assignments/{assignment}/submit', [LearningController::class, 'submitAssignment'])->name('learning.submit');
    Route::post('/quizzes/{quiz}/start', [LearningController::class, 'startQuiz'])->name('learning.start');
    Route::get('/attempts/{attempt}', [LearningController::class, 'attempt'])->name('learning.attempt');
    Route::post('/attempts/{attempt}/submit', [LearningController::class, 'submitQuiz'])->name('learning.finish');
    Route::put('/attempts/{attempt}/answers', [LearningController::class, 'saveAnswers'])->name('learning.answers');
    Route::get('/courses/{course}/certificate', [LearningController::class, 'certificate'])->name('learning.certificate');
});
Route::prefix('admin')->name('admin.')->middleware(['auth', LearningAccess::class.':admin'])->group(function () {
    Route::get('/gen5', [Gen5Controller::class, 'index'])->name('gen5.index');
    Route::post('/gen5', [Gen5Controller::class, 'store'])->name('gen5.store');
    Route::get('/gen5/{match}', [Gen5Controller::class, 'show'])->whereNumber('match')->name('gen5.show');
    Route::get('/gen5/{match}/screen', [Gen5Controller::class, 'show'])->whereNumber('match')->name('gen5.screen');
    Route::post('/gen5/{match}/control', [Gen5Controller::class, 'control'])->whereNumber('match')->name('gen5.control');
    Route::post('/gen5/{match}/generate-teams', [Gen5Controller::class, 'generate'])->whereNumber('match')->name('gen5.generate');
    Route::post('/gen5/{match}/players/{player}/team', [Gen5Controller::class, 'assign'])->whereNumber('match')->whereNumber('player')->name('gen5.assign');
    Route::get('/', [LearningAdminController::class, 'index'])->name('index');
    Route::post('/courses', [LearningAdminController::class, 'saveCourse'])->name('courses.store');
    Route::get('/courses/{course}', [LearningAdminController::class, 'show'])->name('courses.show');
    Route::put('/courses/{course}', [LearningAdminController::class, 'saveCourse'])->name('courses.update');
    Route::get('/courses/{course}/report', [LearningAdminController::class, 'export'])->name('courses.report');
    Route::post('/courses/{course}/lessons/{lesson?}', [LearningAdminController::class, 'saveLesson'])->name('lessons.save');
    Route::post('/courses/{course}/assignments/{assignment?}', [LearningAdminController::class, 'saveAssignment'])->name('assignments.save');
    Route::post('/courses/{course}/quizzes/{quiz?}', [LearningAdminController::class, 'saveQuiz'])->name('quizzes.save');
    Route::post('/courses/{course}/quizzes/{quiz}/questions', [LearningAdminController::class, 'addQuestion'])->name('questions.store');
    Route::delete('/courses/{course}/quizzes/{quiz}/questions/{question}', [LearningAdminController::class, 'deleteQuestion'])->name('questions.delete');
    Route::post('/courses/{course}/enrollments', [LearningAdminController::class, 'enroll'])->name('enrollments.save');
    Route::post('/submissions/{submission}/grade', [LearningAdminController::class, 'grade'])->name('submissions.grade');
    Route::post('/submissions/{submission}/reopen', [LearningAdminController::class, 'reopen'])->name('submissions.reopen');
    Route::post('/courses/{course}/quizzes/{quiz}/attempt-limit', [LearningAdminController::class, 'extendAttempts'])->name('quizzes.extend');
    Route::post('/waiting-list/enroll', [LearningAdminController::class, 'enrollWaiting'])->name('waiting.enroll');
    Route::post('/students', [LearningAdminController::class, 'saveStudent'])->name('students.store');
    Route::post('/students/{student}/status', [LearningAdminController::class, 'studentStatus'])->name('students.status');
});
