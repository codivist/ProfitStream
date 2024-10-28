<?php

use App\Models\Post;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->post = Post::factory()->create([
        'user_id' => $this->user->id
    ]);
});

test('users can edit their own posts', function () {
    $response = $this->actingAs($this->user)
        ->get(route('posts.edit', $this->post));

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('Posts/Edit')
        ->has('post')
        ->where('post.id', $this->post->id)
    );
});

test('users cannot edit posts they do not own', function () {
    $otherUser = User::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $otherUser->id
    ]);

    $response = $this->actingAs($this->user)
        ->get(route('posts.edit', $post));

    $response->assertForbidden();
});

test('users can update their own posts', function () {
    $updatedData = [
        'title' => 'Updated Title',
        'body' => 'Updated content',
        'is_published' => true,
    ];

    $response = $this->actingAs($this->user)
        ->put(route('posts.update', $this->post), $updatedData);

    $response->assertRedirect(route('posts.index'));
    $response->assertSessionHas('success', 'Post updated successfully');

    $this->assertDatabaseHas('posts', [
        'id' => $this->post->id,
        'title' => 'Updated Title',
        'body' => 'Updated content',
    ]);
});

test('users can change post status from published to draft', function () {
    $post = Post::factory()->published()->create([
        'user_id' => $this->user->id
    ]);

    $response = $this->actingAs($this->user)
        ->put(route('posts.update', $post), [
            'title' => $post->title,
            'body' => $post->body,
            'is_published' => false,
        ]);

    $post->refresh();
    expect($post)->toBeDraft();
});
