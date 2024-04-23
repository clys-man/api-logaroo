<?php

declare(strict_types=1);

use App\Models\User;

test('login with valid credentials', function (): void {
    $user = User::factory()->create([
        'password' => bcrypt('password123'),
    ]);

    $response = $this->postJson('/api/auth/login', [
        'email' => $user->email,
        'password' => 'password123',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure(['token']);
});

test('login with invalid credentials', function (): void {
    $response = $this->postJson('/api/auth/login', [
        'email' => 'invalid@example.com',
        'password' => 'invalidpassword',
    ]);

    $response->assertStatus(401);
});
