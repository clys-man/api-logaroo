
<?php

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('returns posts when user is authenticated', function (): void {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $tags = Tag::factory()->count(5)->create();
    $posts = Post::factory()->count(3)->create()->each(function ($post) use ($tags): void {
        $tags = $tags->random(rand(1, 3));
        $post->tags()->attach($tags);
    });

    $response = $this->getJson('/api/posts');

    $response->assertStatus(200);

    foreach ($posts as $post) {
        $response->assertJsonFragment([
            'title' => $post->title,
            'content' => $post->content,
            'author' => $post->author->name,
            'tags' => $post->tags->pluck('name')->toArray()
        ]);
    }
});

it('returns unauthorized when user is not authenticated', function (): void {
    $response = $this->getJson('/api/posts');

    $response->assertStatus(401);
});

it('returns posts when user filter by tag', function (): void {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $tags = Tag::factory()->count(5)->create();
    Post::factory()->count(3)->create()->each(function ($post) use ($tags): void {
        $tags = $tags->random(rand(1, 3));
        $post->tags()->attach($tags);
    });

    $response = $this->getJson('/api/posts?tag=' . $tags->first()->name);
    $postsWithTag = $tags->first()->posts;

    $response->assertStatus(200);

    foreach ($postsWithTag as $post) {
        $response->assertJsonFragment([
            'title' => $post->title,
            'content' => $post->content,
            'author' => $post->author->name,
            'tags' => $post->tags->pluck('name')->toArray()
        ]);
    }
});
