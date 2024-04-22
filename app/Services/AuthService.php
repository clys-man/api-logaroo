<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Payloads\Auth\NewUser;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Contracts\Auth\Factory;
use Laravel\Sanctum\NewAccessToken;
use Throwable;

final readonly class AuthService
{
    /**
     * @param Factory $auth
     * @param CreateNewUser $user
     * @param CreateTokenForUser $token
     */
    public function __construct(
        private Factory $auth,
        private UserRepositoryInterface $repository,
    ) {
    }


    /**
     * @param string $id
     * @param string $name
     * @return NewAccessToken
     */
    public function createToken(string $userId, string $name): NewAccessToken
    {

        $user = $this->repository->find($userId);

        return $user->createToken(
            $name
        );
    }

    /**
     * @param NewUser $payload
     * @return User
     * @throws Throwable
     */
    public function createUser(NewUser $payload): User
    {
        return $this->repository->create(
            payload: $payload,
        );
    }

    /**
     * @param NewUser $payload
     * @param string $name
     * @return NewAccessToken
     * @throws Throwable
     */
    public function register(NewUser $payload, string $name): NewAccessToken
    {
        $user = $this->createUser(
            payload: $payload,
        );

        $this->auth->guard()->loginUsingId(
            id: $user->id,
        );

        return $user->createToken(
            $name
        );
    }
}
