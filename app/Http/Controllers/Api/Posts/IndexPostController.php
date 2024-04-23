<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Posts;

use App\Http\Resources\Posts\PostResource;
use App\Http\Responses\CollectionResponse;
use App\Services\PostService;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;

final readonly class IndexPostController
{
    /**
     * @param PostService $service
     * */
    public function __construct(
        private readonly PostService $service
    ) {
    }

    public function __invoke(Request $request): Responsable
    {
        $tagName = $request->query('tag');

        return new CollectionResponse(
            data: PostResource::collection(
                $this->service->paginate($tagName)
            ),
        );
    }
}
