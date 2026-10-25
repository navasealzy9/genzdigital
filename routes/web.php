<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// Client Side (Student Portal)
Route::get('/', [CampusController::class, 'index'])->name('campus.index');
Route::post('/api/attendance/check-in', [CampusController::class, 'checkIn'])->name('campus.checkIn');
Route::post('/api/attendance/passcode', [CampusController::class, 'checkInWithPasscode'])->name('campus.passcode.checkIn');
Route::post('/profile/avatar', [CampusController::class, 'updateAvatar'])->name('profile.avatar.update');
Route::post('/api/cart/enroll', [CampusController::class, 'enrollCartCourse'])->name('campus.cart.enroll');
Route::post('/api/cart/drop', [CampusController::class, 'dropCartCourse'])->name('campus.cart.drop');
Route::post('/api/collaborations/{id}/join', [CampusController::class, 'joinCollaboration'])->name('campus.collab.join');
Route::post('/api/collaborations/{id}/answer', [CampusController::class, 'submitCollabAnswer'])->name('campus.collab.answer');
Route::post('/api/challenges/{id}/join', [CampusController::class, 'joinChallenge'])->name('campus.challenge.join');
Route::get('/api/challenges/{id}/leaderboard', [CampusController::class, 'getChallengeLeaderboard'])->name('campus.challenge.leaderboard');
Route::post('/api/challenges/{id}/submit', [CampusController::class, 'submitChallenge'])->name('campus.challenge.submit');
Route::get('/api/exams/{id}/questions', [CampusController::class, 'getExamQuestions'])->name('campus.exam.questions');
Route::post('/api/exams/{id}/submit', [CampusController::class, 'submitExam'])->name('campus.exam.submit');
Route::get('/resources/{id}/view', [CampusController::class, 'viewResource'])->name('campus.resource.view');
Route::get('/api/resources/{id}/download', [CampusController::class, 'downloadResource'])->name('campus.resource.download');
Route::get('/api/showscreen/live', [CampusController::class, 'getLiveShowScreen'])->name('campus.showscreen.live');
Route::get('/api/books/{id}/download', [CampusController::class, 'downloadBook'])->name('campus.book.download');
Route::get('/transcript/download', [CampusController::class, 'downloadTranscript'])->name('campus.transcript.download');
Route::post('/api/screenshare/request', [CampusController::class, 'requestScreenShare'])->name('campus.screen.request');

// Admin Side (Campus Management Portal)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // 1. Manage User
    Route::post('/students', [AdminController::class, 'storeStudent'])->name('students.store');
    Route::post('/students/{id}/toggle', [AdminController::class, 'toggleStudentStatus'])->name('students.toggle');
    Route::delete('/students/{id}', [AdminController::class, 'deleteStudent'])->name('students.delete');
    Route::post('/students/assign-class', [AdminController::class, 'assignStudentToClass'])->name('students.assignClass');
    Route::post('/students/batch-assign-class', [AdminController::class, 'batchAssignStudentsToClass'])->name('students.batchAssignClass');
    Route::post('/students/unassign-class', [AdminController::class, 'unassignStudentFromClass'])->name('students.unassignClass');

    // 2. Show User on Screen & Fullscreen 4-User Rotation
    Route::post('/screen-broadcast', [AdminController::class, 'toggleScreenBroadcast'])->name('screenBroadcast');
    Route::get('/screen/fullscreen', [AdminController::class, 'screenFullscreen'])->name('screen.fullscreen');
    Route::get('/screen/spotlights/data', [AdminController::class, 'getSpotlightsData'])->name('screen.spotlights.data');
    Route::post('/screen/spotlights/add', [AdminController::class, 'addSpotlightUser'])->name('screen.spotlights.add');
    Route::post('/screen/spotlights/remove', [AdminController::class, 'removeSpotlightUser'])->name('screen.spotlights.remove');
    Route::post('/screen/spotlights/clear', [AdminController::class, 'clearSpotlights'])->name('screen.spotlights.clear');

    // 3. Report
    Route::get('/reports/export', [AdminController::class, 'exportReports'])->name('reports.export');

    // 4. Exam & QCM Management
    Route::post('/exams', [AdminController::class, 'storeExam'])->name('exams.store');
    Route::post('/exams/{id}/toggle', [AdminController::class, 'toggleExamStatus'])->name('exams.toggle');
    Route::delete('/exams/{id}', [AdminController::class, 'deleteExam'])->name('exams.delete');
    Route::post('/exams/qcm-question', [AdminController::class, 'storeExamQuestion'])->name('exams.storeQuestion');
    Route::delete('/exams/qcm-question/{id}', [AdminController::class, 'deleteExamQuestion'])->name('exams.deleteQuestion');
    Route::get('/exams/{id}/export-results', [AdminController::class, 'exportExamResults'])->name('exams.exportResults');
    Route::delete('/exams/submissions/{id}', [AdminController::class, 'deleteExamSubmission'])->name('exams.deleteSubmission');
    Route::post('/exams/submissions/{id}/re-exam', [AdminController::class, 'allowReExam'])->name('exams.allowReExam');

    // 5. Challenge & Fullscreen Leaderboard
    Route::post('/challenges', [AdminController::class, 'storeChallenge'])->name('challenges.store');
    Route::post('/challenges/{id}/toggle', [AdminController::class, 'toggleChallengeStatus'])->name('challenges.toggle');
    Route::get('/challenges/fullscreen', [AdminController::class, 'challengeFullscreen'])->name('challenges.fullscreen');
    Route::get('/challenges/{id}/fullscreen', [AdminController::class, 'challengeFullscreen'])->name('challenges.fullscreen.id');

    // 6. Certificate & Batch Generation
    Route::post('/certificates', [AdminController::class, 'storeCertificate'])->name('certificates.store');
    Route::post('/certificates/batch', [AdminController::class, 'batchGenerateCertificates'])->name('certificates.batch');

    // 7. Show Slide Teaching & Camera Gesture Fullscreen
    Route::post('/teaching-slide', [AdminController::class, 'updateSlide'])->name('teachingSlide.update');
    Route::get('/slides/fullscreen', [AdminController::class, 'slidesFullscreen'])->name('slides.fullscreen');
    Route::post('/slides/upload', [AdminController::class, 'uploadSlideFile'])->name('slides.upload');

    // 8. Collaboration
    Route::post('/collaborations', [AdminController::class, 'storeCollaboration'])->name('collaborations.store');

    // 10. Attendance
    Route::post('/attendance/{id}/status', [AdminController::class, 'updateAttendanceStatus'])->name('attendance.status');
    Route::get('/attendance/export', [AdminController::class, 'exportAttendance'])->name('attendance.export');

    // 11. QR Code Manage
    Route::post('/qr-codes', [AdminController::class, 'storeQrCode'])->name('qrCodes.store');
    Route::post('/qr-codes/{id}/activate', [AdminController::class, 'activateQrCode'])->name('qrCodes.activate');
    Route::post('/qr-codes/{id}/expire', [AdminController::class, 'updateQrExpiration'])->name('qrCodes.expire');
    Route::delete('/qr-codes/{id}', [AdminController::class, 'deleteQrCode'])->name('qrCodes.delete');

    // 12. Resource
    Route::post('/resources', [AdminController::class, 'storeResource'])->name('resources.store');
    Route::delete('/resources/{id}', [AdminController::class, 'deleteResource'])->name('resources.delete');

    // 13. Class Manage & 4-Tab Details
    Route::post('/classes', [AdminController::class, 'storeClass'])->name('classes.store');
    Route::post('/classes/{id}/toggle', [AdminController::class, 'toggleClassStatus'])->name('classes.toggle');
    Route::delete('/classes/{id}', [AdminController::class, 'deleteClass'])->name('classes.delete');
    Route::get('/classes/{id}/details', [AdminController::class, 'getClassDetails'])->name('classes.details');

    // 14. Library Books Management
    Route::post('/books', [AdminController::class, 'storeBook'])->name('books.store');
    Route::delete('/books/{id}', [AdminController::class, 'deleteBook'])->name('books.delete');

    // 15. News & Announcements Posts Management
    Route::post('/posts', [AdminController::class, 'storePost'])->name('posts.store');
    Route::delete('/posts/{id}', [AdminController::class, 'deletePost'])->name('posts.delete');
});
