<?php

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
        Route::prefix('/posts')->group(function() {
           Route::get('/get/{section_id}', [\App\Http\Controllers\Profile\SectionController::class, 'posts'])->name('api.user.posts.get');
        });
    });
});
