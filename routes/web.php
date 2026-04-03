<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/employees', [EmployeeController::class, 'index']);

// CMS Routes
Route::resource('sections', SectionController::class);
Route::resource('menus', MenuController::class);
