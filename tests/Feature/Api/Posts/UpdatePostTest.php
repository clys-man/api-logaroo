<?php

declare(strict_types=1);

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

it('updates an existing post', function (): void {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $post = Post::factory()->create(['user_id' => $user->id]);
    $tags = Tag::factory()->count(5)->create();
    $postData = [
        'title' => 'Updated Title',
        'content' => 'Updated content for the post.',
        'tags' => $tags->random(rand(1, 3))->pluck('name')->toArray(),
    ];

    $response = $this->putJson('/api/posts/' . $post->id, $postData);

    $response->assertStatus(200);
    $response->assertJsonStructure(['id', 'title', 'content', 'author']);

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => $postData['title'],
        'content' => $postData['content'],
    ]);

    $updatedPost = Post::find($post->id);
    foreach ($postData['tags'] as $tag) {
        $this->assertDatabaseHas('taggables', [
            'taggable_id' => $updatedPost->id,
            'taggable_type' => Post::class,
            'tag_id' => Tag::where('name', $tag)->first()->id,
        ]);
    }
});

it('returns error when trying to update non-existing post', function (): void {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $postId = 9999;
    $postData = [
        'title' => 'Updated Title',
        'content' => 'Updated content for the post.',
        'tags' => ['newtag1', 'newtag2'],
    ];

    $response = $this->putJson('/api/posts/' . $postId, $postData);

    $response->assertStatus(404);
});
