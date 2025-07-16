<?php

use Illuminate\Support\Facades\Route;

// Import semua controller yang akan kita gunakan
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\RankController as AdminRankController;
use App\Http\Controllers\Admin\ApprovalController as AdminApprovalController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AuthController;


Route::get('/', function () {

    return redirect()->route('dashboard.index');
});
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.store');
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register/store', [AuthController::class, 'register'])->name('register.store');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.store');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/jaringan-saya', [NetworkController::class, 'index'])->name('network.index');

    Route::prefix('bonus')->name('bonus.')->group(function () {
        Route::get('/riwayat', [BonusController::class, 'history'])->name('history');
        Route::get('/penarikan', [BonusController::class, 'withdraw'])->name('withdraw');
        Route::post('/penarikan/store', [BonusController::class, 'storeWithdrawal'])->name('withdraw.store');
    });

    Route::prefix('peringkat')->name('rank.')->group(function () {
        Route::get('/kualifikasi', [RankController::class, 'qualification'])->name('qualification');
        Route::post('/klaim-peringkat/store', [RankController::class, 'claimRank'])->name('claim.store');
    });
});


Route::prefix('admin')->name('admin.')->middleware(['is.admin'])->group(function () {

    Route::get('/', function () {
        return redirect()->route('admin.users.index');
    });

    // --- Manajemen Pengguna ---
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::get('create', [AdminUserController::class, 'create'])->name('create');
        Route::post('store', [AdminUserController::class, 'store'])->name('store');
        Route::get('show/{user}', [AdminUserController::class, 'show'])->name('show');
        Route::get('edit/{user}', [AdminUserController::class, 'edit'])->name('edit');
        Route::put('update/{user}', [AdminUserController::class, 'update'])->name('update');
        Route::delete('destroy/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
    });

    // --- Manajemen Peringkat ---
    Route::prefix('ranks')->name('ranks.')->group(function () {
        Route::get('/', [AdminRankController::class, 'index'])->name('index');
        Route::get('create', [AdminRankController::class, 'create'])->name('create');
        Route::post('store', [AdminRankController::class, 'store'])->name('store');
        Route::get('edit/{rank}', [AdminRankController::class, 'edit'])->name('edit');
        Route::put('update/{rank}', [AdminRankController::class, 'update'])->name('update');
        Route::delete('destroy/{rank}', [AdminRankController::class, 'destroy'])->name('destroy');
    });

    // --- Manajemen Persetujuan ---
    Route::prefix('approvals')->name('approvals.')->group(function () {
        // Halaman utama persetujuan (jika ada)
        Route::get('/', [AdminApprovalController::class, 'index'])->name('index');

        // Persetujuan Penarikan Dana
        Route::get('/withdrawals', [AdminApprovalController::class, 'withdrawals'])->name('withdrawals');
        Route::post('/withdrawals/{withdrawal}/approve', [AdminApprovalController::class, 'approveWithdrawal'])->name('withdrawals.approve');
        Route::post('/withdrawals/{withdrawal}/reject', [AdminApprovalController::class, 'rejectWithdrawal'])->name('withdrawals.reject');

        // Persetujuan Klaim Peringkat
        Route::get('/rank-claims', [AdminApprovalController::class, 'rankClaims'])->name('ranks');
        Route::post('/rank-claims/{rankClaim}/approve', [AdminApprovalController::class, 'approveRankClaim'])->name('ranks.approve');
        Route::post('/rank-claims/{rankClaim}/reject', [AdminApprovalController::class, 'rejectRankClaim'])->name('ranks.reject');
    });
});
