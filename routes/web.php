<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\Front\HomeController::class, 'index'])->name('home');
Route::resource('posts', \App\Http\Controllers\Front\PostController::class)->names('posts');
Route::resource('categories', \App\Http\Controllers\Front\PostCategoryController::class)->names('categories');
Route::resource('tags', \App\Http\Controllers\Front\PostTagController::class)->names('tags');

// Email verification
Route::get('/email/verify', [\App\Http\Controllers\Front\EmailVerifyController::class, 'index'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [\App\Http\Controllers\Front\EmailVerifyController::class, 'store'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [\App\Http\Controllers\Front\EmailVerifyController::class, 'resendEmail'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::middleware('guest')->group(function () {
    Route::get('login', [\App\Http\Controllers\Front\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login_process', [\App\Http\Controllers\Front\AuthController::class, 'login'])->name('login_process');
    Route::get('register', [\App\Http\Controllers\Front\AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register_process', [\App\Http\Controllers\Front\AuthController::class, 'register'])->name('register_process');
});

Route::middleware('auth')->group(function () {
    Route::get('logout', [\App\Http\Controllers\Front\AuthController::class, 'logout'])->name('logout');
    Route::get('profile', [\App\Http\Controllers\Front\DashboardController::class, 'index'])->name('profile');
    Route::post('profile_process', [\App\Http\Controllers\Front\DashboardController::class, 'profile'])->name('profile_process');
});
