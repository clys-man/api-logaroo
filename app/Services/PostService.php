<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\DTO\Posts\NewPostDTO;
use App\Models\Post;
use App\Models\User;
use App\Queries\Posts\SearchPostsByTagName;
use App\Repositories\Post\PostRepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

final readonly class PostService
{
    /**
     * @param  PostRepositoryInterface $repository
     */
    public function __construct(
        private readonly PostRepositoryInterface $repository,
    ) {
    }


    public function paginate(?string $tagName = null): Paginator
    {
        return $this->repository->paginate(
            callback: function (Builder $query) use ($tagName): void {
                if ($tagName) {
                    (new SearchPostsByTagName())->handle($query, $tagName);
                }
            }
        );
    }

    public function create(NewPostDTO $newPostDTO): Post
    {
        return $this->repository->create($newPostDTO);
    }

    public function update(Post $post, NewPostDTO $newPostDTO): Post
    {
        return $this->repository->update(post: $post, newPostDTO: $newPostDTO);
    }

    public function delete(Post $post, User $user): bool
    {
        if ($post->author->id !== $user->id) {
            return false;
        }

        return $this->repository->delete($post);
    }
}
