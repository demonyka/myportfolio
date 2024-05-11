<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\Misc\MiscController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Profile\ProfileEditController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'view'])->name('index.view');

Route::middleware('verified')->group(function () {
    Route::get('/id{id}', [ProfileController::class, 'view'])->name('profile.view.id');
    Route::get('/{username}', [ProfileController::class, 'view'])->name('profile.view.username');

    Route::middleware('auth')->group(function () {
        Route::prefix('/post')->group(function () {
            Route::post('/store', [PostController::class, 'store'])->name('post.store');
            Route::post('/like/{post_id}', [PostController::class, 'like'])->name('post.like');
            Route::delete('/delete/{post_id}', [PostController::class, 'delete'])->name('post.delete');
        });
        Route::prefix('/user')->group(function () {
            Route::post('/edit', [ProfileEditController::class, 'edit'])->name('user.edit');
        });
    });
});

Route::prefix('/misc')->group(function () {
    Route::get('/{page}', [MiscController::class, 'view'])->name('misc.view');
});

require __DIR__ . '/auth.php';
