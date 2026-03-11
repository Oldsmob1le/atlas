<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\ProfileController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('home');
    Route::get('/calendar', [EventController::class, 'calendar'])->name('calendar');
    Route::resource('events', EventController::class)->except(['index']);

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/settings', [ProfileController::class, 'updateSettings'])->name('profile.settings.update');

    Route::post('/telegram/bind', [TelegramController::class, 'bindAccount'])->name('telegram.bind');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::post('/telegram/webhook', [TelegramController::class, 'webhook'])->name('telegram.webhook');