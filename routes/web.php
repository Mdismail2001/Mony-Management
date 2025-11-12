<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('loginForm');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/create-user', [AuthController::class, 'createUserByAdmin'])->name('create-user');

// Admin routes
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/adminDashboard', [DashboardController::class, 'adminDash'])->name('adminDashboard');
});

// User routes
Route::prefix('user')->middleware(['auth', 'is_user'])->group(function () {
    Route::get('/userDashboard', [DashboardController::class, 'userDash'])->name('userDashboard');
});
