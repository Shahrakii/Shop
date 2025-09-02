<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Admin\AuthController;
use Modules\Auth\Http\Controllers\Admin\AdminController;

Route::prefix('admin')->group(function () {

    // Guest routes (only accessible if not logged in)
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('admin.login');
        Route::post('login', [AuthController::class, 'login'])->name('admin.login.submit');
    });

    // Logout route (must be POST)
    Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');

    // Protected routes (only accessible if logged in)
    Route::middleware('auth')->group(function () {
        Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    });
});
