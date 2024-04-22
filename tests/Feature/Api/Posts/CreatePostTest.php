<?php

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

it('creates a new post', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $tags = Tag::factory()->count(5)->create();
    $postData = [
        'title' => 'Test Post',
        'content' => 'This is a test post content.',
        'tags' => $tags->random(rand(1, 3))->pluck('name')->toArray(),
    ];

    $response = $this->postJson('/api/posts', $postData);

    $response->assertStatus(201);
    $response->assertJsonStructure(['id', 'title', 'content', 'author']);

    $this->assertDatabaseHas('posts', [
        'title' => $postData['title'],
        'content' => $postData['content'],
        'user_id' => $user->id,
    ]);

    $post = Post::where('title', $postData['title'])->first();
    foreach ($postData['tags'] as $tag) {
        $this->assertDatabaseHas('taggables', [
            'taggable_id' => $post->id,
            'taggable_type' => Post::class,
            'tag_id' => Tag::where('name', $tag)->first()->id,
        ]);
    }
});

it('returns error when required fields are missing', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $postData = [];

    $response = $this->postJson('/api/posts', $postData);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['title', 'content', 'tags']);
});
