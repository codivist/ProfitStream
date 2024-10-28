<?php

use App\Models\Post;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('users can view their own draft posts', function () {
    $post = Post::factory()->draft()->create([
        'user_id' => $this->user->id
    ]);

    $response = $this->actingAs($this->user)
        ->get(route('posts.show', $post));

    $response->assertOk();
});

test('users can see their posts list', function () {
    $posts = Post::factory(3)->create([
        'user_id' => $this->user->id
    ]);

    $response = $this->actingAs($this->user)
        ->get(route('posts.index'));

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('Posts/Index')
        ->has('posts', 3)
    );
});

test('users cannot view other users draft posts', function () {
    $otherUser = User::factory()->create();
    $post = Post::factory()->draft()->create([
        'user_id' => $otherUser->id
    ]);

    $response = $this->actingAs($this->user)
        ->get(route('posts.show', $post));

    $response->assertForbidden();
});
