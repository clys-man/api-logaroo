<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:api'])->group(static function (): void {
    Route::prefix('auth')->as('auth:')->group(
        base_path('routes/api/auth.php'),
    );
});

Route::middleware(['auth:sanctum', 'throttle:api'])->group(static function (): void {
    Route::prefix('posts')->as('post:')->group(
        base_path('routes/api/posts.php'),
    );
});
