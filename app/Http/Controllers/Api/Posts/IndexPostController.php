<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Posts;

use App\Http\Resources\Posts\PostResource;
use App\Http\Responses\CollectionResponse;
use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;

final readonly class IndexPostController
{
    /**
     * @param User $auth
     * */
    public function __construct(
        private readonly PostService $postService
    ) {
    }

    public function __invoke(Request $request): Responsable
    {
        $tagName = $request->query('tag');

        return new CollectionResponse(
            data: PostResource::collection(
                $this->postService->paginate($tagName)
            ),
        );
    }
}
