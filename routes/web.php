<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PlayController;
use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->middleware(\App\Http\Middleware\TrackVisit::class)->name('home');

// Новости (публичные)
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsController::class, 'show'])->whereNumber('id')->name('news.show');

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

// 🆕 Админка (доступ rank >= 4, см. EnsureStaff)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'staff'])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('home');

    // Новости: CRUD
    Route::get('/news', [App\Http\Controllers\Admin\AdminController::class, 'news'])->name('news.index');
    Route::get('/news/create', [App\Http\Controllers\Admin\AdminController::class, 'newsCreate'])->name('news.create');
    Route::post('/news', [App\Http\Controllers\Admin\AdminController::class, 'newsStore'])->name('news.store');
    Route::get('/news/{news}/edit', [App\Http\Controllers\Admin\AdminController::class, 'newsEdit'])->name('news.edit');
    Route::put('/news/{news}', [App\Http\Controllers\Admin\AdminController::class, 'newsUpdate'])->name('news.update');
    Route::delete('/news/{news}', [App\Http\Controllers\Admin\AdminController::class, 'newsDestroy'])->name('news.destroy');

    // Игроки
    Route::get('/users', [App\Http\Controllers\Admin\AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\AdminController::class, 'userEdit'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\AdminController::class, 'userUpdate'])->name('users.update');

    // Баны (пишем прямо в таблицу bans эмулятора)
    Route::post('/users/{user}/ban', [App\Http\Controllers\Admin\AdminController::class, 'banStore'])->name('ban.store');
    Route::delete('/ban/{ban}', [App\Http\Controllers\Admin\AdminController::class, 'banDestroy'])->name('ban.destroy');

    // Логи действий персонала
    Route::get('/logs', [App\Http\Controllers\Admin\AdminController::class, 'logs'])->name('logs');
});
