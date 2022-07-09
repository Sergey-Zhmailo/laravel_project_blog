<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware('guest')->group(function () {
    Route::get('login', [\App\Http\Controllers\Front\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login_process', [\App\Http\Controllers\Front\AuthController::class, 'login'])->name('login_process');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\Front\DashboardController::class, 'index'])->name('dashboard');
});
