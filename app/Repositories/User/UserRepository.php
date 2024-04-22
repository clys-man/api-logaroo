<?php

namespace App\Repositories\User;

use App\Http\Payloads\Auth\NewUser;
use App\Models\User;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        protected readonly User $model,
        protected readonly DatabaseManager $database
    ) {
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(string $id): ?User
    {
        return $this->model->query()->find($id);
    }

    public function create(NewUser $payload): User
    {
        return $this->model->query()->create($payload->toArray());
    }

    public function update(array $data, string $id): User
    {
        $user = $this->model->query()->findOrFail($id);
        $user->update($data);

        return $user;
    }

    public function delete(string $id): bool
    {
        return $this->model->query()->findOrFail($id)->delete();
    }
}
