<?php

use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\LessonProgressController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/admin-login', function () {
    return view('pages::auth.admin-login');
})->name('admin.login');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('pages::admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::post('/admin/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::delete('/admin/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
});

Route::view('dashboard', 'dashboard')
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
    Route::post('/admin/reset-all-progress', [LessonProgressController::class, 'resetAllUserProgress'])->name('admin.reset-all-progress');

    Route::get('/subject/{subject}/games', function ($subject) {
        return view('subject.games', ['subject' => $subject]);
    })->name('subject.games');

    Route::get('/lesson/{lesson}', function ($lesson) {
        return view('lessons.' . $lesson, ['lesson' => $lesson]);
    })->name('lesson.view');
});

require __DIR__.'/settings.php';
