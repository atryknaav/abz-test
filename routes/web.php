<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PositionController;
use App\Http\Middleware\VerifyTokenMiddleware;


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('guest')->group(function () {
    Route::post('users', [UserController::class, 'store'])->name('users.store')->middleware('token');
    Route::get('/', fn() => Inertia::render('Guest/Welcome'));
    Route::get('/dashboard', fn() => Inertia::render('Guest/Dashboard'))->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/positions', [PositionController::class, 'index'])->name('positions.index');
});

require __DIR__.'/auth.php';
require __DIR__.'/api.php';
