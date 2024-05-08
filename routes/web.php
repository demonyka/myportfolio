<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\Misc\MiscController;
use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'view'])->name('index.view');

Route::middleware('verified')->group(function () {
    Route::get('/id{id}', [ProfileController::class, 'view'])->name('profile.view.id');
    Route::get('/{username}', [ProfileController::class, 'view'])->name('profile.view.username');
});

Route::prefix('/misc')->group(function () {
   Route::get('/{page}', [MiscController::class, 'view'])->name('misc.view');
});

require __DIR__.'/auth.php';
