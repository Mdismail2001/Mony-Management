<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

// Authentication
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('loginForm');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/create-user', [AuthController::class, 'createUserByAdmin'])->name('create-user');

// Invite registration (must be public)
Route::get('/invite/{token}', [MembersController::class, 'showInviteForm'])->name('invite.show');
Route::post('/invite/register', [MembersController::class, 'processInviteRegistration'])->name('invite.register');


/*
|--------------------------------------------------------------------------
| Protected Routes — Only for Logged-in Users
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'Dashboard'])->name('Dashboard');

    // Profile
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profileUpdate', [AuthController::class, 'profileUpdate'])->name('profileUpdate');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Communities
    |--------------------------------------------------------------------------
    */
    Route::get('/community-create', [CommunityController::class, 'createShowForm'])->name('community-create');
    Route::post('/community-store', [CommunityController::class, 'store'])->name('community-store');
    Route::get('/communities/{id}', [CommunityController::class, 'show'])->name('communities');
    Route::get('/community-edit/{id}', [CommunityController::class, 'editForm'])->name('community-edit');
    Route::post('/edit/{id}', [CommunityController::class, 'edit'])->name('edit');
    Route::get('/delete-community/{id}', [CommunityController::class, 'delete'])->name('delete-community');
    Route::get('/community-notice/{id}', [CommunityController::class, 'noticeForm'])->name('community-notice');
    Route::post('/notice-store/{id}',[CommunityController::class, 'noticeStore'])->name('notice-store');

    /*
    |--------------------------------------------------------------------------
    | Members
    |--------------------------------------------------------------------------
    */
    Route::get('/create-member/{id}', [MembersController::class, 'createMemberForm'])->name('create-member');
    Route::post('/store-member', [MembersController::class, 'storeMember'])->name('store-member');
    Route::get('/member-details/{id}', [MembersController::class, 'memberDetails'])->name('member-details');
    Route::get('/edit-member/{id}', [MembersController::class, 'editform'])->name('edit-member');
    Route::put('/update-member/{id}', [MembersController::class, 'updateMember'])->name('update-member');
    Route::get('/delete-member/{id}', [MembersController::class, 'deleteMember'])->name('delete-member');
    Route::get('/all-members', [MembersController::class, 'allMembers'])->name('all-members');

    /*
    |--------------------------------------------------------------------------
    | Transactions
    |--------------------------------------------------------------------------
    */
    Route::get('/transactions-Form', [TransactionController::class, 'showForm'])->name('transactions-form');
    Route::post('/store-transaction', [TransactionController::class, 'store'])->name('store-transaction');
    Route::get('/transaction-edit-form/{id}', [TransactionController::class, 'transactionEditForm'])->name('transaction-edit-form');
    Route::put('/transaction-update/{id}', [TransactionController::class, 'transactionUpdate'])->name('transaction-update');
    Route::get('/view-transaction/{id}', [TransactionController::class, 'view'])->name('view-transaction');
    Route::put('/status-update/{id}', [TransactionController::class, 'status'])->name('status-update');
    Route::get('/all-transactions', [TransactionController::class, 'allTransactions'])->name('all-transactions');
});
