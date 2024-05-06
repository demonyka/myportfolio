<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OAuth\GithubAuthController;
use App\Http\Controllers\Auth\OAuth\GoogleAuthController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Route;

Route::prefix('/auth')->group(function () {
    Route::get('/email-confirm/{token}', [EmailController::class, 'getConfirmation'])->middleware('auth')->name('auth.email-confirmation.get');
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'view'])->name('auth.login.view');
        Route::post('/login', [LoginController::class, 'store'])->name('auth.login.store');

        Route::get('/register', [RegisterController::class, 'view'])->name('auth.register.view');
        Route::post('/register', [RegisterController::class, 'store'])->name('auth.register.store');

        Route::get('/forgot-password', [PasswordController::class, 'view'])->name('auth.forgot-password.view');
        Route::post('/forgot-password', [PasswordController::class, 'send'])->name('auth.forgot-password.send');
        Route::get('/forgot-password/{token}', [PasswordController::class, 'store'])->name('auth.forgot-password.store');

        Route::prefix('/github')->group(function () {
            Route::get('/redirect', [GithubAuthController::class, 'redirect'])->name('auth.github.redirect');
            Route::get('/callback', [GithubAuthController::class, 'callback'])->name('auth.github.callback');
        });
        Route::prefix('/google')->group(function () {
            Route::get('/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
            Route::get('/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
        });
    });

    Route::middleware('auth')->group(function () {
        Route::any('/logout', [LoginController::class, 'destroy'])
            ->name('auth.logout');
    });
});

