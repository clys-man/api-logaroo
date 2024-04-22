<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Posts\IndexPostController;
use Illuminate\Support\Facades\Route;

Route::get('/', IndexPostController::class)->name('index');
