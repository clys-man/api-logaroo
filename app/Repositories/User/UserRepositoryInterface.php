<?php

namespace App\Repositories\User;

use App\Http\DTO\Auth\NewUserDTO;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function all(): Collection;
    public function find(string $id): ?User;
    public function create(NewUserDTO $payload): User;
    public function update(array $data, string $id): User;
    public function delete(string $id): bool;
}
