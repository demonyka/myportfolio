<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::prefix('/auth')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'view'])->name('auth.login.view');
        Route::post('/login', [LoginController::class, 'store'])->name('auth.login.store');

        Route::get('/register', [RegisterController::class, 'view'])->name('auth.register.view');
        Route::post('/register', [RegisterController::class, 'store'])->name('auth.register.store');
    });

    Route::middleware('auth')->group(function () {
        Route::any('/logout', [LoginController::class, 'destroy'])
            ->name('auth.logout');
    });
});

