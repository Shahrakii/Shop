<?php

use Illuminate\Support\Facades\Route;
use Modules\Permission\Http\Controllers\RolesController;

Route::middleware(['web', 'auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('roles', [RolesController::class, 'index'])
            ->name('roles.index')
            ->middleware('can:view roles section');

        Route::get('roles/create', [RolesController::class, 'create'])
            ->name('roles.create')
            ->middleware('can:make role');
        Route::post('roles', [RolesController::class, 'store'])
            ->name('roles.store')
            ->middleware('can:make role');

        Route::get('roles/{role}/edit', [RolesController::class, 'edit'])
            ->name('roles.edit')
            ->middleware('can:edit role');
        Route::patch('roles/{role}', [RolesController::class, 'update'])
            ->name('roles.update')
            ->middleware('can:edit role');

        Route::delete('roles/{role}', [RolesController::class, 'destroy'])
            ->name('roles.destroy')
            ->middleware('can:delete role');
    });
