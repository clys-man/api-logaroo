<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Posts;

use App\Http\Requests\Posts\StorePostRequest;
use App\Http\Resources\Posts\PostResource;
use App\Http\Responses\ModelResponse;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Support\Responsable;
use JustSteveKing\Tools\Http\Enums\Status;

final readonly class StorePostController
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

    public function __invoke(StorePostRequest $request): Responsable
    {
        $post = $this->service->create(
            newPostDTO: $request->toDTO(userId: $this->auth->id),
        );

        return new ModelResponse(
            data: new PostResource($post),
            status: Status::CREATED
        );
    }
}
