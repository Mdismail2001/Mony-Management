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

    Route::get('/adminDashboard', [DashboardController::class, 'adminDash'])->name('adminDashboard');

    Route::get('/userDashboard', [DashboardController::class, 'userDash'])->name('userDashboard');
