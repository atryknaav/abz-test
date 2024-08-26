<?php

use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\VerifyTokenMiddleware;
use Illuminate\Support\Facades\Route;


// Route::post('users', [UserController::class, 'store'])->name('users.store')->middleware(VerifyTokenMiddleware::class);
Route::get('/token', [TokenController::class, 'create'])->name('token.create');