<?php

declare(strict_types=1);

namespace App\Queries\Posts;

use Illuminate\Database\Eloquent\Builder;

final class SearchPostsByTagName
{
    public function handle(Builder $query, string $tagName): Builder
    {
        return $query->whereHas('tags', function (Builder $query) use ($tagName) {
            $query->where('name', $tagName);
        });
    }
}
