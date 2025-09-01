<?php

use Illuminate\Support\Facades\Route;

use Modules\Auth\Http\Controllers\Admin\AuthController;
use Modules\Auth\Http\Controllers\Admin\AdminController;

Route::prefix('admin')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.admin.login.submit');

    Route::middleware(['auth'])->group(function () {
        Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
    });
});
