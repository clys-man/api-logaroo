<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Posts\IndexPostController;
use App\Http\Controllers\Api\Posts\StorePostController;
use Illuminate\Support\Facades\Route;

Route::get('/', IndexPostController::class)->name('index');
Route::post('/', StorePostController::class)->name('store')->middleware(['allows:POST']);
