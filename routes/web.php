<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthController;

// === МАРШРУТЫ ДЛЯ ГОСТЕЙ (только если НЕ авторизован) ===
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// === ЗАЩИЩЕННЫЕ МАРШРУТЫ (только для авторизованных) ===
Route::middleware('auth')->group(function () {
    // Твои существующие страницы
    Route::get('/', [EventController::class, 'index'])->name('home');
    Route::get('/calendar', [EventController::class, 'calendar'])->name('calendar');
    Route::resource('events', EventController::class)->except(['index']);
    
    // Профиль и выход
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});