<?php

use App\Models\Post;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('welcome page shows published posts', function () {
    $posts = Post::factory(3)->published()->create();

    $response = $this->get(route('welcome'));

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('Welcome')
        ->has('posts', 3)
        ->where('posts.0.is_published', true)
    );
});

test('welcome page does not show draft posts', function () {
    Post::factory(3)->published()->create();
    Post::factory(2)->draft()->create();

    $response = $this->get(route('welcome'));

    $response->assertInertia(fn (Assert $page) => $page
        ->component('Welcome')
        ->has('posts', 3)
    );
});

test('welcome page shows posts in descending order', function () {
    $oldPost = Post::factory()->published()->create([
        'created_at' => now()->subDays(2),
    ]);
    $newPost = Post::factory()->published()->create([
        'created_at' => now(),
    ]);

    $response = $this->get(route('welcome'));

    $response->assertInertia(fn (Assert $page) => $page
        ->component('Welcome')
        ->where('posts.0.id', $newPost->id)
        ->where('posts.1.id', $oldPost->id)
    );
});
