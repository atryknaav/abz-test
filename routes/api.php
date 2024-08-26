<?php

use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('users', [UserController::class, 'store'])->name('users.store');
Route::get('/token', [TokenController::class, 'create'])->name('token.create');