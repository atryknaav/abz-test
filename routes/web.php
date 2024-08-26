<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PositionController;



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
