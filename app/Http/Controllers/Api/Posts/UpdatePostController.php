<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Posts;

use App\Http\Requests\Posts\StorePostRequest;
use App\Http\Resources\Posts\PostResource;
use App\Http\Responses\ModelResponse;
use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use JustSteveKing\Tools\Http\Enums\Status;

final readonly class UpdatePostController
{
    /**
     * @param User $auth
     * @param PostService $service
     * */
    public function __construct(
        private readonly Authenticatable $auth,
        private readonly PostService $service
    ) {
    }

    /**
     * @param StorePostRequest $request
     * @param string $id
     * @return Responsable
     * @throws Throwable
     */
    public function __invoke(StorePostRequest $request, string $id): Responsable
    {
        if ( ! $post = Post::query()->where('id', $id)->first()) {
            throw new ModelNotFoundException(
                message: "No post found for [{$id}]",
                code: Status::NOT_FOUND->value,
            );
        }

        $post = $this->service->update(
            post: $post,
            newPostDTO: $request->toDTO(userId: $this->auth->id),
        );

        return new ModelResponse(
            data: new PostResource($post),
            status: Status::OK
        );
    }
}
