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
Route::get('categories/{slug}', [PostCategoryController::class, 'show'])->name('categories');
Route::get('tags/{slug}', [PostTagController::class, 'show'])->name('tags');
Route::get('search', [HomeController::class, 'search'])->name('search');
Route::post('search', [HomeController::class, 'search_process'])->name('search_process');

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

Route::middleware(['auth', 'is_banned'])->group(function () {
    // Admin
    Route::group([
        'prefix' => 'admin',
        'middleware' => 'is_admin',
        'as' => 'admin.'
    ], function () {
        Route::get('users', [App\Http\Controllers\Admin\DashboardController::class, 'users'])->name('users');
        Route::get('block_user/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'block_user'])->name('block_user');
        Route::get('unblock_user/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'unblock_user'])->name
        ('unblock_user');
    });

    // User
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('profile', [DashboardController::class, 'index'])->name('profile');
    Route::get('user_posts', [PostController::class, 'index'])->name('user_posts');
    Route::get('user_posts/trash', [PostController::class, 'trash'])->name('user_posts_trash');
    Route::resource('posts', PostController::class)->names('posts');
    Route::get('posts/force_delete/{id}', [PostController::class, 'force_delete'])->name('posts.force_delete');
    Route::get('posts/restore/{id}', [PostController::class, 'restore'])->name('posts.restore');
    Route::post('profile_process', [DashboardController::class, 'profile'])->name('profile_process');
    Route::post('comment_process', [CommentController::class, 'comment_process'])->name('comment_process');
});
