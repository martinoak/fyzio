<?php

use Illuminate\Support\Facades\Route;

Route::post('save-methods', [\App\Http\Controllers\AdminController::class, 'saveMethods']);

