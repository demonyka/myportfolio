<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'view'])->name('index.view');


Route::middleware('verified')->group(function () {
    Route::get('/id{id}', [ProfileController::class, 'view'])->name('profile.view.byId');
    Route::get('/{username}', [ProfileController::class, 'view'])->name('profile.view.byUsername');
});

require __DIR__.'/auth.php';
