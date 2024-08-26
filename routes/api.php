<?php

use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\VerifyTokenMiddleware;
use Illuminate\Support\Facades\Route;



Route::get('/token', [TokenController::class, 'create'])->name('token.create');