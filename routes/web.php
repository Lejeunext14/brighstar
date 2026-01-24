<?php

use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\AdminReportsController;
use App\Http\Controllers\AdminLogsController;
use App\Http\Controllers\LessonProgressController;
use App\Http\Controllers\AdminParentChildController;
use App\Http\Controllers\ParentDashboardController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\TeacherDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/admin-login', function () {
    return view('pages::auth.admin-login');
})->name('admin.login');

Route::get('/teachers-login', function () {
    return view('pages::auth.teachers-login');
})->name('teachers.login');

Route::get('/parents-login', function () {
    return view('pages::auth.parents-login');
})->name('parents.login');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->middleware('admin.role')->name('admin.dashboard');

    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])->middleware('teacher.role')->name('teacher.dashboard');

    Route::get('/parent/dashboard', [ParentDashboardController::class, 'index'])->middleware('parent.role')->name('parent.dashboard');

    Route::get('/admin/users', [UserManagementController::class, 'index'])->middleware('admin.role')->name('users.index');
    Route::post('/admin/users', [UserManagementController::class, 'store'])->middleware('admin.role')->name('users.store');
    Route::get('/admin/users/{user}/edit', [UserManagementController::class, 'edit'])->middleware('admin.role')->name('users.edit');
    Route::put('/admin/users/{user}', [UserManagementController::class, 'update'])->middleware('admin.role')->name('users.update');
    Route::delete('/admin/users/{user}', [UserManagementController::class, 'destroy'])->middleware('admin.role')->name('users.destroy');

    // Admin Parent-Child Management Routes
    Route::get('/admin/parent-child', [AdminParentChildController::class, 'index'])->middleware('admin.role')->name('admin.parent-child.index');
    Route::post('/admin/link-child', [AdminParentChildController::class, 'linkChild'])->middleware('admin.role')->name('admin.link-child');
    Route::delete('/admin/unlink-child/{child}', [AdminParentChildController::class, 'unlinkChild'])->middleware('admin.role')->name('admin.unlink-child');

    // Admin Settings, Reports, and Logs Routes
    Route::get('/admin/settings', [AdminSettingsController::class, 'index'])->middleware('admin.role')->name('admin.settings');
    Route::get('/admin/reports', [AdminReportsController::class, 'index'])->middleware('admin.role')->name('admin.reports');
    Route::get('/admin/logs', [AdminLogsController::class, 'index'])->middleware('admin.role')->name('admin.logs');

    // Avatar Management Routes
    Route::get('/avatar/edit', [AvatarController::class, 'edit'])->name('avatar.edit');
    Route::post('/avatar/update', [AvatarController::class, 'update'])->name('avatar.update');
});

Route::get('dashboard', [StudentDashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/subject/{subject}/topics', function ($subject) {
        return view('subject.topics', ['subject' => $subject]);
    })->name('subject.topics');

    Route::post('/admin/reset-progress', function () {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return response()->json(['message' => 'Progress reset authorized'], 200);
        }
        return response()->json(['error' => 'Unauthorized'], 403);
    })->name('admin.reset-progress');

    Route::post('/lesson/mark-complete', [LessonProgressController::class, 'markComplete'])->name('lesson.mark-complete');
    Route::get('/lesson/progress', [LessonProgressController::class, 'getUserProgress'])->name('lesson.progress');
    Route::get('/lesson/daily-progress', [LessonProgressController::class, 'getDailyProgress'])->name('lesson.daily-progress');
    Route::post('/admin/reset-all-progress', [LessonProgressController::class, 'resetAllUserProgress'])->name('admin.reset-all-progress');

    Route::get('/subject/{subject}/games', function ($subject) {
        return view('subject.games', ['subject' => $subject]);
    })->name('subject.games');

    Route::get('/subject/{subject}/coloring', function ($subject) {
        return view('subject.coloring', ['subject' => $subject]);
    })->name('subject.coloring');

    Route::get('/lesson/{lesson}', function ($lesson) {
        // Define lesson sequence for unlocking
        $lessonSequence = [
            'pag-papakilala-sa-sarili',           // Lesson 1
            'bahagi-ng-katawan',                   // Lesson 2
            'mga-kulay',                           // Lesson 3
            'pag-papakilala-sa-ibat-ibang-uri-ng-tunog', // Lesson 4
            'mga-hugis',                           // Lesson 5
            'mga-kasapi-ng-aking-pamilya',        // Lesson 6
        ];

        $firstLesson = $lessonSequence[0];
        $lessonIndex = array_search($lesson, $lessonSequence);

        // First lesson is always unlocked for starting
        if ($lesson === $firstLesson) {
            return view('lessons.' . $lesson, ['lesson' => $lesson]);
        }

        // If lesson is not in sequence, deny access
        if ($lessonIndex === false) {
            return redirect()->back()->with('error', '🔒 This lesson is locked.');
        }

        // Get the previous lesson
        $previousLesson = $lessonSequence[$lessonIndex - 1];

        // Check if the previous lesson is completed
        $previousLessonProgress = \App\Models\LessonProgress::where('user_id', auth()->id())
            ->where('lesson_slug', $previousLesson)
            ->first();

        if (!$previousLessonProgress || !$previousLessonProgress->completed) {
            return redirect()->back()->with('error', '🔒 This lesson is locked. Complete the previous lesson first.');
        }

        return view('lessons.' . $lesson, ['lesson' => $lesson]);
    })->name('lesson.view');
});

require __DIR__.'/settings.php';
