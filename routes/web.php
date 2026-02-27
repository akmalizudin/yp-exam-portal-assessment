<?php

use App\Http\Controllers\Lecturer\LecturerExamController;
use App\Http\Controllers\Lecturer\LecturerQuestionController;
use App\Http\Controllers\Lecturer\LecturerClassroomController;
use App\Http\Controllers\Lecturer\LecturerSubjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\ExamAttemptController;
use App\Http\Controllers\Student\StudentExamController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:student')->group(function () {
        // STUDENT-ROUTES
        Route::get('/student/exams', [StudentExamController::class, 'index'])->name('student.exams.index');
        Route::post('/student/exams/{exam}/start', [ExamAttemptController::class, 'start'])->name('student.exams.start');
        Route::get('/student/exams/{exam}', [StudentExamController::class, 'show'])->name('student.exams.show');
        Route::post('/student/exams/{exam}/submit', [StudentExamController::class, 'submit'])->name('student.exams.submit');
    });

    Route::middleware('role:lecturer')->group(function () {
        // LECTURER-ROUTES
        // EXAM-ROUTES
        Route::get('/lecturer/exams', [LecturerExamController::class, 'index'])->name('lecturer.exams.index');
        Route::get('/lecturer/exams/create', [LecturerExamController::class, 'create'])->name('lecturer.exams.create');
        Route::post('/lecturer/exams', [LecturerExamController::class, 'store'])->name('lecturer.exams.store');

        // QUESTION-ROUTES
        Route::get('/lecturer/exams/{exam}/questions', [LecturerQuestionController::class, 'index'])->name('lecturer.questions.index');
        Route::get('/lecturer/exams/{exam}/questions/create', [LecturerQuestionController::class, 'create'])->name('lecturer.questions.create');
        Route::post('/lecturer/exams/{exam}/questions', [LecturerQuestionController::class, 'store'])->name('lecturer.questions.store');

        Route::get('/lecturer/exams/{exam}/results', [LecturerExamController::class, 'results'])->name('lecturer.exams.results');
        Route::patch('/lecturer/exams/{exam}/toggle-publish', [LecturerExamController::class, 'togglePublish'])->name('lecturer.exams.toggle');
        Route::get('/lecturer/exams/{exam}/results/{attempt}', [LecturerExamController::class, 'showResult'])->name('lecturer.exams.results.show');

        // FOR EDIT AND DELETE QUESTIONS
        Route::get('/lecturer/questions/{question}/edit', [LecturerQuestionController::class, 'edit'])->name('lecturer.questions.edit');
        Route::patch('/lecturer/questions/{question}', [LecturerQuestionController::class, 'update'])->name('lecturer.questions.update');
        Route::delete('/lecturer/questions/{question}', [LecturerQuestionController::class, 'destroy'])->name('lecturer.questions.destroy');

        // CLASSROOM MANAGEMENT
        Route::get('/lecturer/classrooms', [LecturerClassroomController::class, 'index'])->name('lecturer.classrooms.index');
        Route::post('/lecturer/classrooms', [LecturerClassroomController::class, 'store'])->name('lecturer.classrooms.store');
        Route::get('/lecturer/classrooms/{classroom}/edit', [LecturerClassroomController::class, 'edit'])->name('lecturer.classrooms.edit');
        Route::patch('/lecturer/classrooms/{classroom}', [LecturerClassroomController::class, 'update'])->name('lecturer.classrooms.update');
        Route::delete('/lecturer/classrooms/{classroom}', [LecturerClassroomController::class, 'destroy'])->name('lecturer.classrooms.destroy');

        // SUBJECT MANAGEMENT
        Route::get('/lecturer/subjects', [LecturerSubjectController::class, 'index'])->name('lecturer.subjects.index');
        Route::post('/lecturer/subjects', [LecturerSubjectController::class, 'store'])->name('lecturer.subjects.store');
        Route::get('/lecturer/subjects/{subject}/edit', [LecturerSubjectController::class, 'edit'])->name('lecturer.subjects.edit');
        Route::patch('/lecturer/subjects/{subject}', [LecturerSubjectController::class, 'update'])->name('lecturer.subjects.update');
        Route::delete('/lecturer/subjects/{subject}', [LecturerSubjectController::class, 'destroy'])->name('lecturer.subjects.destroy');
    });

    // to test rbac, (if role = student, will get 403 when accessing /lecturer-only)
    Route::middleware('role:lecturer')->get('/lecturer-only', function () {
        return 'Hello Lecturer';
    });

    Route::middleware('role:student')->get('/student-only', function () {
        return 'Hello Student';
    });
});

require __DIR__ . '/auth.php';
