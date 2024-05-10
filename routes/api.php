<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Profile\ProfileEditController;
use App\Http\Controllers\Profile\SectionController;
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
            Route::post('/new-post', [PostController::class, 'newPost'])->middleware('auth')->name('api.user.post.store');
            Route::post('/like/{post_id}', [PostController::class, 'like'])->middleware('auth')->name('api.user.post.like');
            Route::delete('/delete/{post_id}', [PostController::class, 'delete'])->middleware('auth')->name('api.user.post.delete');
        });
        Route::post('/edit', [ProfileEditController::class, 'store'])->middleware('auth')->name('api.user.edit.store');
        Route::get('/find', [ProfileController::class, 'find'])->name('api.user.find.get');
        Route::post('/edit-section', [SectionController::class, 'store'])->middleware('auth')->name('api.user.edit.section.store');

        Route::prefix('/email')->group(function() {
            Route::post('/send-confirm/{email}', [\App\Http\Controllers\EmailController::class, 'sendConfirmation'])->name('api.user.email-confirmation.send');
        });
    });
});
