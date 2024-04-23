<?php

namespace App\Repositories\Post;

use App\Http\DTO\Posts\NewPostDTO;
use App\Models\Post;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

interface PostRepositoryInterface
{
    public function all(?callable $callback = null): Collection;
    public function paginate(int $perPage = 20, ?callable $callback = null): Paginator;
    public function find(string $id): ?Post;
    public function create(NewPostDTO $newPostDTO): Post;
    public function update(Post $post, NewPostDTO $newPostDTO): Post;
    public function delete(Post $post): bool;
}
