<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Posts;

use App\Http\Responses\MessageResponse;
use App\Models\User;
use App\Queries\Posts\GetUserPostById;
use App\Services\PostService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use JustSteveKing\Tools\Http\Enums\Status;

final readonly class DeletePostController
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
     * @param string $id
     * @return Responsable
     * @throws Throwable
     */
    public function __invoke(string $id): Responsable
    {
        $post = (new GetUserPostById())
            ->handle(user: $this->auth, postId: $id)
            ->first();

        if ( ! $post) {
            throw new ModelNotFoundException(
                message: "No post found for [{$id}]",
                code: Status::NOT_FOUND->value,
            );
        }

        $post = $this->service->delete(
            post: $post,
            user: $this->auth
        );

        return new MessageResponse(
            data: [],
            status: Status::NO_CONTENT
        );
    }
}
