<?php

use App\Models\Post;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->post = Post::factory()->create([
        'user_id' => $this->user->id
    ]);
});

test('users can delete their own posts', function () {
    $response = $this->actingAs($this->user)
        ->delete(route('posts.destroy', $this->post));

    $response->assertRedirect(route('posts.index'));
    $response->assertSessionHas('success', 'Post deleted successfully');

    $this->assertSoftDeleted('posts', [
        'id' => $this->post->id
    ]);
});

test('users cannot delete posts they do not own', function () {
    $otherUser = User::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $otherUser->id
    ]);

    $response = $this->actingAs($this->user)
        ->delete(route('posts.destroy', $post));

    $response->assertForbidden();
    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'deleted_at' => null
    ]);
});

test('guests cannot delete posts', function () {
    $response = $this->delete(route('posts.destroy', $this->post));

    $response->assertRedirect(route('login'));
    $this->assertDatabaseHas('posts', [
        'id' => $this->post->id,
        'deleted_at' => null
    ]);
});
