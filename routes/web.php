<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlayController;
use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Игра
Route::get('/play', [PlayController::class, 'index'])->name('play');
Route::get('/api/online', [PlayController::class, 'online']);

// Гость
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Авторизованные
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/me', [PlayerController::class, 'me'])->name('me');
});

// Публичные профили
Route::get('/player/{username}', [PlayerController::class, 'show'])->name('player.show');
Route::get('/players', [PlayerController::class, 'index'])->name('players.index');
