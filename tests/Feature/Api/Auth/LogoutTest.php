<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

test('logout user', function () {
    Sanctum::actingAs(User::factory()->create());

    $response = $this->postJson('/api/auth/logout');

    $response->assertStatus(204);
});
