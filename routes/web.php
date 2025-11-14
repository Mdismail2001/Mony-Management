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
// registration routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/create-user', [AuthController::class, 'createUserByAdmin'])->name('create-user');
// Dashboard routes
Route::get('/adminDashboard', [DashboardController::class, 'adminDash'])->name('adminDashboard');
Route::get('/userDashboard', [DashboardController::class, 'userDash'])->name('userDashboard');

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
