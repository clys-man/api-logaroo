<?php

declare(strict_types=1);

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

it('deletes a post', function (): void {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $post = Post::factory()->create(['user_id' => $user->id]);

    $response = $this->deleteJson('/api/posts/' . $post->id);

    $response->assertStatus(204);
});

it('returns error when trying to delete non-existing post', function (): void {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $postId = '01hw46bd9aejxnkz9cwqy8skmt';

    $response = $this->deleteJson('/api/posts/' . $postId);

    $response->assertStatus(404);
});
