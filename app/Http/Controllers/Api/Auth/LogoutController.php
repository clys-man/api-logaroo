<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Responses\MessageResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JustSteveKing\Tools\Http\Enums\Status;

final readonly class LogoutController
{
    public function __invoke(Request $request): Responsable
    {
        $request->user()->currentAccessToken()->delete();

        return new MessageResponse([], Status::NO_CONTENT);
    }
}
