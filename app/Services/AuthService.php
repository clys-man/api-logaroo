<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\DTO\Auth\NewUserDTO;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Contracts\Auth\Factory;
use Laravel\Sanctum\NewAccessToken;
use Throwable;

final readonly class AuthService
{
    /**
     * @param Factory $auth
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        private Factory $auth,
        private UserRepositoryInterface $userRepository,
    ) {
    }


    /**
     * @param string $id
     * @param string $name
     * @return NewAccessToken
     */
    public function createToken(string $userId, string $name): NewAccessToken
    {
        $user = $this->userRepository->find($userId);

        return $user->createToken(
            $name
        );
    }

    /**
     * @param NewUserDTO $payload
     * @return User
     * @throws Throwable
     */
    public function createUser(NewUserDTO $payload): User
    {
        return $this->userRepository->create(
            payload: $payload,
        );
    }

    /**
     * @param NewUserDTO $payload
     * @param string $name
     * @return NewAccessToken
     * @throws Throwable
     */
    public function register(NewUserDTO $payload, string $name): NewAccessToken
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
