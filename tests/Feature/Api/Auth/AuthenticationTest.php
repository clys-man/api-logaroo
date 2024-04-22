<?php

use App\Models\User;

test('login with valid credentials', function () {
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

test('login with invalid credentials', function () {
    $response = $this->postJson('/api/auth/login', [
        'email' => 'invalid@example.com',
        'password' => 'invalidpassword',
    ]);

    $response->assertStatus(401);
});
