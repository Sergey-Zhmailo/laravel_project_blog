<?php

use App\Http\Controllers\Front\AuthController;
use App\Http\Controllers\Front\CommentController;
use App\Http\Controllers\Front\DashboardController;
use App\Http\Controllers\Front\EmailVerifyController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PostCategoryController;
use App\Http\Controllers\Front\PostController;
use App\Http\Controllers\Front\PostTagController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('post/{slug}', [HomeController::class, 'show'])->name('post');
Route::resource('posts', PostController::class)->names('posts');
Route::get('categories/{slug}', [PostCategoryController::class, 'show'])->name('categories');
Route::get('tags/{slug}', [PostTagController::class, 'show'])->name('tags');

// Email verification
Route::group([
    'prefix' => 'email',
    'middleware' => [
        'auth'
    ]
], function () {
    Route::get('/verify', [EmailVerifyController::class, 'index'])
        ->name('verification.notice');

    Route::get('/verify/{id}/{hash}', [EmailVerifyController::class, 'store'])
        ->middleware(['signed'])
        ->name('verification.verify');

    Route::post('/verification-notification', [EmailVerifyController::class, 'resendEmail'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login_process', [AuthController::class, 'login'])->name('login_process');
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register_process', [AuthController::class, 'register'])->name('register_process');
});

Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('profile', [DashboardController::class, 'index'])->name('profile');
    Route::post('profile_process', [DashboardController::class, 'profile'])->name('profile_process');
    Route::post('comment_process', [CommentController::class, 'comment_process'])->name('comment_process');
});
