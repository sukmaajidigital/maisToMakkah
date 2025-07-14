<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

Route::prefix('admin')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('create', [UserController::class, 'create'])->name('user.create');
    Route::post('store', [UserController::class, 'store'])->name('user.store');
    Route::get('edit/{ids}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('update/{ids}', [UserController::class, 'update'])->name('user.update');
    Route::delete('destroy/{ids}', [UserController::class, 'destroy'])->name('user.destroy');
});
