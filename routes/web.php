<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/employees', [EmployeeController::class, 'index']);

// CMS Routes
Route::resource('sections', SectionController::class);
Route::resource('menus', MenuController::class);

// Homework Management Routes
Route::resource('homeworks', HomeworkController::class);

// Student Routes
Route::get('/my-homeworks', [HomeworkController::class, 'studentIndex'])->name('homeworks.student.index');
Route::get('/my-homeworks/{homework}', [HomeworkController::class, 'studentShow'])->name('homeworks.student.show');

// Submission Routes
Route::post('/homeworks/{homework}/submit', [SubmissionController::class, 'store'])->name('submissions.store');
Route::get('/submissions/{submission}', [SubmissionController::class, 'show'])->name('submissions.show');
Route::put('/submissions/{submission}/grade', [SubmissionController::class, 'grade'])->name('submissions.grade');
Route::get('/submissions/{submission}/download', [SubmissionController::class, 'download'])->name('submissions.download');
