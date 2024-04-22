<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Queries\Posts\SearchPostByTagName;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

class PostRepository implements PostRepositoryInterface
{
    public function __construct(
        protected readonly Post $model,
    ) {
    }

    public function all(?callable $callback = null): collection
    {
        $query = $this->model->query();

        if ($callback) {
            $callback($query);
        }

        return $query->all();
    }

    public function paginate(int $perPage = 20, ?callable $callback = null): Paginator
    {
        $query = $this->model->query();

        if ($callback) {
            $callback($query);
        }

        return $query->paginate($perPage);
    }

    public function find(string $id): ?Post
    {
        return $this->model->query()->find($id);
    }
}
