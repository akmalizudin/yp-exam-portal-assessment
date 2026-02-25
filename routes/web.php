<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\ExamAttemptController;
use App\Http\Controllers\Student\StudentExamController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // get list of exams for student
    Route::get('/student/exams', [StudentExamController::class, 'index'])->name('student.exams.index');

    // student can start exam attempt
    Route::post('/student/exams/{exam}/start',[ExamAttemptController::class, 'start'])->name('student.exams.start');

    // to test rbac, (if role = student, will get 403 when accessing /lecturer-only)
    Route::middleware('role:lecturer')->get('/lecturer-only', function () {
        return 'Hello Lecturer';
    });

    Route::middleware('role:student')->get('/student-only', function () {
        return 'Hello Student';
    });
});

require __DIR__ . '/auth.php';
