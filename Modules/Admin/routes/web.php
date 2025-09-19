<?php

use Modules\Admin\Http\Controllers\AdminAdminController;

Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::resource('admins', AdminAdminController::class)
    ->middlewareFor(['index, show'],'can:view admins section')
    ->middlewareFor(['create, store'],'can:make admins')
    ->middlewareFor(['edit, update'],'can:edit admins')
    ->middlewareFor(['destroy'],'can:delete admin');
});
