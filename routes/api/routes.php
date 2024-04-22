<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:api'])->group(static function (): void {
    Route::prefix('auth')->as('auth:')->group(
        base_path('routes/api/auth.php'),
    );
});
