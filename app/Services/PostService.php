<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\DTO\Posts\NewPostDTO;
use App\Models\Post;
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
            callback: function (Builder $query) use ($tagName) {
                if ($tagName) {
                    (new SearchPostsByTagName)->handle($query, $tagName);
                }
            }
        );
    }

    public function create(NewPostDTO $newPostDTO): Post
    {
        $post = $this->repository->create($newPostDTO);

        return $post;
    }
}
