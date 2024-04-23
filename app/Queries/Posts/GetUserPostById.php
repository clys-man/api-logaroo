<?php

declare(strict_types=1);

namespace App\Queries\Posts;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

final class GetUserPostById
{
    public function handle(User $user, string $postId): Builder
    {
        return $user->posts()->getQuery()->where('id', $postId);
    }
}
