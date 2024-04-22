<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Responses\Auth\TokenResponse;
use App\Services\AuthService;
use Illuminate\Contracts\Support\Responsable;
use JustSteveKing\Tools\Http\Enums\Status;

final readonly class RegistrationController
{
    public function __construct(
        private AuthService $service,
    ) {
    }

    /**
     * @param RegistrationRequest $request
     * @return Responsable
     * @throws Throwable
     */
    public function __invoke(RegisterRequest $request): Responsable
    {
        return new TokenResponse(
            data: $this->service->register(
                payload: $request->toDTO(),
                name: (string) $request->userAgent(),
            ),
            status: Status::CREATED,
        );
    }
}
