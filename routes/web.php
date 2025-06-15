<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

Route::get('/', [Controllers\HomepageController::class, 'index'])->name('homepage');

Route::post('sendMail', [Controllers\EmailsController::class, 'sendMail'])->name('sendMail');

Route::get('login', [Controllers\AuthController::class, 'login'])->name('login');
Route::post('authenticate', [Controllers\AuthController::class, 'authenticate'])->name('authenticate');

Route::group(['middleware' => 'auth'], function () {
    Route::any('admin', [Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/log', [Controllers\AdminController::class, 'log'])->name('admin.log');
    Route::get('admin/log/clear', [Controllers\AdminController::class, 'logClear'])->name('admin.log.clear');
    Route::match(['get', 'post'], 'update-announcement', [Controllers\AdminController::class, 'announcement'])->name('set-announcement');

    Route::any('admin/customer/{action}/{id}', [Controllers\AdminController::class, 'customer'])->name('admin.customer');

    Route::post('save-methods', [Controllers\AdminController::class, 'saveMethods'])->name('save-methods');
});
