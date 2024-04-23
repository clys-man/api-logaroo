<?php

declare(strict_types=1);

namespace App\Http\DTO\Auth;

final readonly class NewUserDTO
{
    public function __construct(
        private string $name,
        private string $email,
        private string $password,
    ) {
    }

    /**
     * @param array{name:string,email:string,password:string} $data
     * @return NewUserDTO
     */
    public static function fromRequest(array $data): NewUserDTO
    {
        return new NewUserDTO(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
        );
    }

    /**
     * @return array{name:string,email:string,password:string} $data
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
