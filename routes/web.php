<?php

use App\Http\Controllers\ProfileController;
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

    // to test rbac, (if role = student, will get 403 when accessing /lecturer-only)
    Route::middleware('role:lecturer')->get('/lecturer-only', function () {
        return 'Hello Lecturer';
    });

    Route::middleware('role:student')->get('/student-only', function () {
        return 'Hello Student';
    });
});

require __DIR__ . '/auth.php';
