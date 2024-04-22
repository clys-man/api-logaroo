<?php

namespace App\Repositories\User;

use App\Http\Payloads\Auth\NewUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function all(): Collection;
    public function find(string $id): ?User;
    public function create(NewUser $payload): User;
    public function update(array $data, string $id): User;
    public function delete(string $id): bool;
}
