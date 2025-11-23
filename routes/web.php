<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\TransactionController;

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
Route::get('/Dashboard', [DashboardController::class, 'Dashboard'])->name('Dashboard');

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Other routes can be added here
// communities routes
// Route::get('/communities', [CommunityController::class, 'index'])->name('communities.index');
Route::get('/community-create', [CommunityController::class, 'createShowForm'])->name('community-create');
Route::post('/community-store', [CommunityController::class, 'store'])->name('community-store');
Route::get('/communities/{id}', [CommunityController::class, 'show'])->name('communities') ->middleware('auth');
Route::get('/community-edit/{id}', [CommunityController::class, 'editForm'])->name('community-edit');
Route::post('/edit/{id}', [CommunityController::class, 'edit'])->name('edit');
Route::get('delete-community/{id}', [CommunityController::class, 'delete'])->name('delete-community');
// members routes
Route::get('/create-member/{id}', [MembersController::class, 'createMemberForm'])->name('create-member');
Route::post('/store-member', [MembersController::class, 'storeMember'])->name('store-member');
Route::get('/member-details/{id}', [MembersController::class, 'memberDetails'])->name('member-details');
Route::get('/edit-member/{id}', [MembersController::class, 'editform'])->name('edit-member');
Route::put('/update-member/{id}', [MembersController::class, 'updateMember'])->name('update-member');
Route::get('/delete-member/{id}', [MembersController::class, 'deleteMember'])->name('delete-member');

// Invite routes
Route::get('/invite/{token}', [MembersController::class, 'showInviteForm'])->name('invite.show');
Route::post('/invite/register', [MembersController::class, 'processInviteRegistration'])->name('invite.register');

// transactions routes
Route::get('/transactionsForm', [TransactionController::class, 'showForm'])->name('transactions-form');
Route::post('/store-transaction', [TransactionController::class, 'store'])->name('store-transaction');