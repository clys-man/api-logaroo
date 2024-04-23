<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Responses\Auth\TokenResponse;
use App\Services\AuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Support\Responsable;

final readonly class LoginController
{
    public function __construct(
        private Factory $auth,
        private AuthService $service,
    ) {
    }

    /**
     * @param LoginRequest $request
     * @return Responsable
     * @throws AuthenticationException
     */
    public function __invoke(LoginRequest $request): Responsable
    {
        if ( ! $this->auth->guard()->attempt($request->only('email', 'password'))) {
            throw new AuthenticationException(
                message: 'Failed authentication, please check your credentials.',
            );
        }

        return new TokenResponse(
            data: $this->service->createToken(
                userId: (string) $this->auth->guard()->id(),
                name: (string) $request->userAgent(),
            ),
        );
    }
}
