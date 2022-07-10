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
// Email verification
Route::get('/email/verify', function () {
    return view('front.auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware('guest')->group(function () {
    Route::get('login', [\App\Http\Controllers\Front\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login_process', [\App\Http\Controllers\Front\AuthController::class, 'login'])->name('login_process');
    Route::get('register', [\App\Http\Controllers\Front\AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register_process', [\App\Http\Controllers\Front\AuthController::class, 'register'])->name('register_process');
});

Route::middleware('auth')->group(function () {
    Route::get('logout', [\App\Http\Controllers\Front\AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard', [\App\Http\Controllers\Front\DashboardController::class, 'index'])->name('dashboard');
});
