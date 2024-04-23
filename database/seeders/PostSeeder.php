<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

final class PostSeeder extends Seeder
{
    public function run(): void
    {
        Post::factory()->count(50)->create()->each(function ($post): void {
            $tags = Tag::inRandomOrder()->limit(rand(1, 3))->get();
            $post->tags()->attach($tags);
        });
    }
}
