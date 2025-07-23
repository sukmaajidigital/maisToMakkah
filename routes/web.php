<?php

use Illuminate\Support\Facades\Route;

// Import semua controller yang akan kita gunakan
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NetworkMeController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\RankController as AdminRankController;
use App\Http\Controllers\Admin\ApprovalController as AdminApprovalController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\NetworkRegisterController;
use App\Http\Controllers\SettingUserController;

Route::get('/', function () {
    return redirect()->route('dashboard.index');
});
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.store');
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register/store', [AuthController::class, 'register'])->name('register.store');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.store');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

Route::middleware(['auth:web'])->group(function () {
    Route::get('/settings', [SettingUserController::class, 'index'])->name('settings.index');
    Route::put('/settings/update', [SettingUserController::class, 'update'])->name('settings.update');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::prefix('network/me')->group(function () {
        Route::get('/', [NetworkMeController::class, 'index'])->name('network.index');
    });

    Route::prefix('network')->group(function () {
        Route::get('/register', [NetworkRegisterController::class, 'index'])->name('network.register.index');
        Route::post('/register', [NetworkRegisterController::class, 'store'])->name('network.register.store');
        Route::get('/register/{user}/edit', [NetworkRegisterController::class, 'edit'])->name('network.register.edit');
        Route::put('/register/{user}', [NetworkRegisterController::class, 'update'])->name('network.register.update');
        Route::delete('/register/{user}', [NetworkRegisterController::class, 'destroy'])->name('network.register.destroy');
    });

    Route::prefix('bonus')->group(function () {
        Route::get('/riwayat', [BonusController::class, 'history'])->name('bonus.history');
        Route::get('/penarikan', [BonusController::class, 'withdraw'])->name('bonus.withdraw');
        Route::post('/penarikan/store', [BonusController::class, 'storeWithdrawal'])->name('bonus.withdraw.store');
    });

    Route::prefix('peringkat')->group(function () {
        Route::get('/kualifikasi', [RankController::class, 'qualification'])->name('rank.qualification');
        Route::post('/klaim-peringkat/store', [RankController::class, 'claimRank'])->name('rank.claim.store');
    });
});


Route::prefix('admin')->middleware(['is.admin'])->group(function () {

    Route::get('/', function () {
        return redirect()->route('admin.users.index');
    });

    // --- Manajemen Pengguna ---
    Route::prefix('users')->name('')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::get('create', [AdminUserController::class, 'create'])->name('admin.users.create');
        Route::post('store', [AdminUserController::class, 'store'])->name('admin.users.store');
        Route::get('edit/{user}', [AdminUserController::class, 'edit'])->name('admin.users.edit');
        Route::put('update/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::delete('destroy/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    });

    // --- Manajemen Peringkat ---
    Route::prefix('ranks')->group(function () {
        Route::get('/', [AdminRankController::class, 'index'])->name('admin.ranks.index');
        Route::get('create', [AdminRankController::class, 'create'])->name('admin.ranks.create');
        Route::post('store', [AdminRankController::class, 'store'])->name('admin.ranks.store');
        Route::get('edit/{rank}', [AdminRankController::class, 'edit'])->name('admin.ranks.edit');
        Route::put('update/{rank}', [AdminRankController::class, 'update'])->name('admin.ranks.update');
        Route::delete('destroy/{rank}', [AdminRankController::class, 'destroy'])->name('admin.ranks.destroy');
    });

    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('admin.product.index');
        Route::get('create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('store', [ProductController::class, 'store'])->name('admin.product.store');
        Route::get('edit/{rank}', [ProductController::class, 'edit'])->name('admin.product.edit');
        Route::put('update/{rank}', [ProductController::class, 'update'])->name('admin.product.update');
        Route::delete('destroy/{rank}', [ProductController::class, 'destroy'])->name('admin.product.destroy');
    });

    // --- Manajemen Persetujuan ---
    Route::prefix('approvals')->group(function () {
        // Halaman utama persetujuan (jika ada)
        Route::get('/', [AdminApprovalController::class, 'index'])->name('admin.approvals.index');

        // Persetujuan Penarikan Dana
        Route::get('/withdrawals', [AdminApprovalController::class, 'withdrawals'])->name('admin.approvals.withdrawals');
        Route::post('/withdrawals/{withdrawal}/approve', [AdminApprovalController::class, 'approveWithdrawal'])->name('admin.withdrawals.approve');
        Route::post('/withdrawals/{withdrawal}/reject', [AdminApprovalController::class, 'rejectWithdrawal'])->name('admin.approvals.withdrawals.reject');

        // Persetujuan Klaim Peringkat
        Route::get('/rank-claims', [AdminApprovalController::class, 'rankClaims'])->name('admin.approvals.ranks');
        Route::post('/rank-claims/{rankClaim}/approve', [AdminApprovalController::class, 'approveRankClaim'])->name('admin.approvals.ranks.approve');
        Route::post('/rank-claims/{rankClaim}/reject', [AdminApprovalController::class, 'rejectRankClaim'])->name('admin.approvals.ranks.reject');
    });
});
