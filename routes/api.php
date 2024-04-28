<?php

use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/v1')->group(function () {
    Route::prefix('/user')->group(function() {
        Route::prefix('/post')->group(function() {
           Route::get('/get/{section_id}', [ProfileController::class, 'getPost'])->name('api.user.post.get');
           Route::post('/new-post', [ProfileController::class, 'newPost'])->middleware('auth')->name('api.user.post.store');
        });
        Route::post('/edit', [ProfileController::class, 'edit'])->middleware('auth')->name('api.user.edit.store');

        Route::prefix('/email')->group(function() {
            Route::get('/confirm/{token}', [\App\Http\Controllers\EmailController::class, 'getConfirmation'])->name('api.user.email-confirmation.get');
            Route::post('/send-confirm/{email}', [\App\Http\Controllers\EmailController::class, 'sendConfirmation'])->name('api.user.email-confirmation.send');
        });
    });
});
