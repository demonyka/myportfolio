<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\Profile\ProfileController;
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
    Route::prefix('/user')->group(function () {
        Route::get('/find', [ProfileController::class, 'find'])->name('api.user.find');
        Route::prefix('/email')->group(function () {
            Route::post('/send-confirm/{email}', [EmailController::class, 'sendConfirmation'])->name('api.user.email-confirmation.send');
        });
    });
});
