<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Posts\DeletePostController;
use App\Http\Controllers\Api\Posts\IndexPostController;
use App\Http\Controllers\Api\Posts\StorePostController;
use App\Http\Controllers\Api\Posts\UpdatePostController;
use Illuminate\Support\Facades\Route;

Route::get('/', IndexPostController::class)->name('index');
Route::post('/', StorePostController::class)->name('store');
Route::put('/{id}', UpdatePostController::class)->name('update');
Route::delete('/{id}', DeletePostController::class)->name('delete');
