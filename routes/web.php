<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'view'])->name('index.view');


Route::middleware('verified')->group(function () {
    Route::middleware('auth')->group(function() {
        Route::prefix('/profile')->group(function () {
            Route::get('/', function () {
                return redirect()->route('profile.view.byId', ['id' => auth()->user()->id]);
            })->name('profile.view');

            Route::post('/edit', [ProfileController::class, 'edit'])->name('profile.edit.store');
        });

    });
    Route::get('/id{id}', [ProfileController::class, 'view'])->name('profile.view.byId');
    Route::get('/{username}', [ProfileController::class, 'view'])->name('profile.view.byUsername');
});

require __DIR__.'/auth.php';
