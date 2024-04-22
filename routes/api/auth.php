<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::post('/register', RegistrationController::class)->name('register')->middleware(['allows:POST']);
Route::post('/login', LoginController::class)->name('login')->middleware(['allows:POST']);
Route::post('/logout', LogoutController::class)->name('logout')->middleware(['allows:POST', 'auth:sanctum']);
