<?php

namespace App\Http\Resources\Posts;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->resource->title,
            'content' => $this->resource->content,
            'author' => $this->resource->author->name,
            'tags' => $this->resource->tags->pluck('name')->toArray()
        ];
    }
}
