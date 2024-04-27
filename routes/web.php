<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'view'])->name('index.view');


Route::middleware('verified')->group(function () {
    Route::middleware('auth')->group(function() {
        Route::prefix('/profile')->group(function () {
            Route::post('/edit', [ProfileController::class, 'edit'])->name('profile.edit.store');
            Route::post('/new-post', [ProfileController::class, 'newPost'])->name('profile.post.store');
        });

    });
    Route::get('/id{id}', [ProfileController::class, 'view'])->name('profile.view.id');
    Route::get('/{username}', [ProfileController::class, 'view'])->name('profile.view.username');
});

require __DIR__.'/auth.php';
