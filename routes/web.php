<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\MembersController;

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

// Other routes can be added here
// communities routes
// Route::get('/communities', [CommunityController::class, 'index'])->name('communities.index');
Route::get('/community-create', [CommunityController::class, 'createShowForm'])->name('community-create');
Route::post('/community-store', [CommunityController::class, 'store'])->name('community-store');
Route::get('/communities/{id}', [CommunityController::class, 'show'])->name('communities');
Route::get('/create-member/{id}', [MembersController::class, 'createMemberForm'])->name('create-member');
Route::post('/store-member', [MembersController::class, 'storeMember'])->name('store-member');

// Invite routes
Route::get('/invite/{token}', [MembersController::class, 'showInviteForm'])->name('invite.show');
Route::post('/invite/register', [MembersController::class, 'processInviteRegistration'])->name('invite.register');