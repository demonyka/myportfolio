<?php

use App\Http\Controllers\PostController;
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
           Route::get('/get/{section_id}', [PostController::class, 'getPost'])->name('api.user.post.get');
           Route::post('/new-post', [PostController::class, 'newPost'])->middleware('auth')->name('api.user.post.store');
            Route::post('/like/{post_id}', [PostController::class, 'like'])->middleware('auth')->name('api.user.post.like');
        });
        Route::post('/edit', [ProfileController::class, 'edit'])->middleware('auth')->name('api.user.edit.store');
        Route::post('/edit-section', [ProfileController::class, 'editSection'])->middleware('auth')->name('api.user.edit.section.store');

        Route::prefix('/email')->group(function() {
            Route::get('/confirm/{token}', [\App\Http\Controllers\EmailController::class, 'getConfirmation'])->name('api.user.email-confirmation.get');
            Route::post('/send-confirm/{email}', [\App\Http\Controllers\EmailController::class, 'sendConfirmation'])->name('api.user.email-confirmation.send');
        });
    });
});
