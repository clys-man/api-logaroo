<?php

namespace App\Repositories\Post;

use App\Models\Post;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

interface PostRepositoryInterface
{
    public function all(?callable $callback = null): Collection;
    public function paginate(int $perPage = 20, ?callable $callback = null): Paginator;
    public function find(string $id): ?Post;
}
